<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

// 包含外卖订单和拼团订单

class Ctl_Weidian_Ucenter_Order extends Ctl_Weidian
{

    /* ---------------------------------外卖订单功能开始---------------------------------------- */

    // 外卖订单列表
    public function waimai_order_items()
    {
        $this->pagedata['shop'] = K::M('shop/shop')->detail((int)$_SESSION['WEIDIAN_SHOP_ID']);
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/ucenter/order/waimai/items.html';
    }

    // ajax获取外卖订单列表
    public function ajax_waimai_order_items()
    {
        $status_label = '';
        $allow_filelds = 'order_id,order_status,pay_status,online_pay,comment_status,amount,dateline,format_dateline,pei_type,status_label,shop_id';
        $page = max((int) $this->GP('page'), 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = 'weidian_waimai';
        $orderby['order_id'] = 'desc';
        if($page <= 100 && $items = K::M('order/order')->items($filter,$orderby,1,5000,$count)) {
            foreach ($items as $k => $v) {
                $ids[$v['order_id']] = $v['order_id'];
                $v['format_dateline'] = date('Y/m/d H:i',$v['dateline']);

                // 订单超时自动取消
                if(__TIME - $v['dateline'] > 1800 && $v['order_status'] == 0 && $v['pay_status'] == 0 && $v['online_pay'] == 1){
                    K::M('order/order')->cancel($v['order_id'], $v, 'admin', '订单超过30分钟未付款自动取消');
                }
                if(__TIME - $v['dateline'] > 3600 && $v['order_status'] == 0 && $v['pay_status'] == 1){
                    K::M('order/order')->cancel($v['order_id'], $v, 'admin', '订单逾期1小时内无人接单自动取消');
                }

                // 订单状态
                if($v['pei_type'] == 3) {
                    if ($v['order_status']==0 && $v['pay_status']==0 && $v['online_pay']==1) {
                        $v['status_label'] = '等待支付';
                    }else if ($v['order_status']==0 && $v['pay_status']==0 && $v['online_pay']==0) {
                        $v['status_label'] = '等待商家接单';
                    }else if ($v['order_status']==0 && $v['pay_status']==1 && $v['online_pay']==1) {
                        $v['status_label'] = '等待商家接单';
                    }else if ($v['order_status']==1) {
                        $v['status_label'] = '商家已接单';
                    }else if ($v['order_status']==8 && $v['comment_status']==0) {
                        $v['status_label'] = '订单待评价';
                    }else if ($v['order_status']==8 && $v['comment_status']==1) {
                        $v['status_label'] = '订单已完成';
                    }else if ($v['order_status']==-1) {
                        $v['status_label'] = '订单已取消';
                    }                   
                }else {
                    if ($v['order_status']==0 && $v['pay_status']==0 && $v['online_pay']==1) {
                        $v['status_label'] = '等待支付';
                    }else if ($v['order_status']==0 && $v['pay_status']==0 && $v['online_pay']==0) {
                        $v['status_label'] = '等待商家接单';
                    }else if ($v['order_status']==0 && $v['pay_status']==1 && $v['online_pay']==1) {
                        $v['status_label'] = '等待商家接单';
                    }else if ($v['order_status']==1 && $v['staff_id']==0) {
                        $v['status_label'] = '商家已接单';
                    }else if (in_array($v['order_status'],array(1,2)) && $v['pei_type']==0) {
                        $v['status_label'] = '商家正在配货';
                    }else if (in_array($v['order_status'],array(1,2)) && $v['staff_id']>0 && in_array($v['pei_type'],array(1,2))) {
                        $v['status_label'] = '骑手正在取餐';
                    }else if ($v['order_status']==3 && $v['staff_id']>0 && in_array($v['pei_type'],array(1,2))) {
                        $v['status_label'] = '骑手正在送餐';
                    }else if ($v['order_status']==3 && $v['pei_type']==0) {
                        $v['status_label'] = '商家正在送餐';
                    }else if ($v['order_status']==-1) {
                        $v['status_label'] = '订单已取消';
                    }else if ($v['order_status']==4) {
                        $v['status_label'] = '订单已完成';
                    }else if ($v['order_status']==8 && $v['comment_status']==0) {
                        $v['status_label'] = '订单待评价';
                    }else if ($v['order_status']==8 && $v['comment_status']==1) {
                        $v['status_label'] = '订单已完成';
                    }
                }

                $items[$k] = $this->filter_fields($allow_filelds,$v);
            }   
            foreach ($ids as $k => $v) {
                $standard[$v] = K::M('waimai/orderproduct')->get_standard($v);
            }
            foreach ($standard as $k => $v) {
                $pro = K::M('waimai/product')->detail($v['product_id']);
                $standard[$k]['photo'] = $pro['photo'];
                $standard[$k]['title'] = $pro['title']; 
                $items[$k]['pro_info'] = $standard[$k];
            }
            $items = array_slice($items, ($page - 1) * 10, 10, true);
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',array('items'=>array_values($items)));
    }

    // 外卖订单详情页
    public function waimai_order_detail($order_id)
    {
        // 订单超过半小时未支付自动取消
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 210)->response();
        }
        else{
            if($order['from'] == 'weidian_waimai' && $order['uid'] == $this->uid){
                if(__TIME - $order['dateline'] > 1800 && $order['order_status'] == 0 && $order['online_pay'] == 1 && $order['pay_status'] == 0){
                    K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单超过30分钟未付款自动取消');
                }
                if(__TIME - $order['dateline'] > 3600 && $order['order_status'] == 0 && $order['pay_status'] == 1){
                    K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单逾期1小时内无人接单自动取消');
                }
            }
            if(!$waimai_order = K::M('waimai/order')->detail($order_id)){
                $this->msgbox->add('订单扩展信息不存在', 205);
            }
            else if(!$waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
                $this->msgbox->add('订单商品信息不存在', 206);
            }
            else{
                $total_package_price = 0;
                $order['format_dateline'] = K::M('helper/format')->time($order['dateline']);
                $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
                $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
                $order['waimai_order'] = $waimai_order;
                $order['waimai_order_product'] = $waimai_order_product;
                foreach($waimai_order_product as $k => $v){
                    $specids[] = $v['spec_id'];
                    $productids[] = $v['product_id'];
                    $total_package_price += $v['package_price'] * $v['product_number'];
                }
                $order['qrcode'] = $this->mklink('qrcode?data=' . $waimai_order['spend_number']);
                $order['qrcode'] = substr($order['qrcode'], 0, strlen($order['qrcode']) - 1);
                $order['products'] = K::M('waimai/product')->items_by_ids($productids);
                $order['specs'] = K::M('waimai/productspec')->items_by_ids($specids);
                $order['source_reason'] = $order['reason'];
                $reason = K::M('order/order')->get_reason();
                $order['reason'] = $reason['waimai'];
                $order['total_package_price'] = $total_package_price;
                if($log_list = K::M('order/log')->items(array('order_id' => $order_id, 'type' => $log_type), array('log_id' => 'desc'))){
                    $order['logs'] = array_values($log_list);
                }
                $this->pagedata['order'] = $order;
                $this->pagedata['theme_style'] = $this->default_weidian_theme();
                $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/ucenter/order/waimai/detail.html';
            }
        }
    }

    // 外卖订单状态页面
    public function waimai_order_status($order_id)
    {
        // 订单超过半小时未支付自动取消
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 210)->response();
        }else {
        	if($order['from'] == 'weidian_waimai' && $order['uid'] == $this->uid) {
        		if(__TIME - $order['dateline'] > 1800 && $order['order_status'] == 0 && $order['online_pay'] == 1 && $order['pay_status'] == 0){
	                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单超过30分钟未付款自动取消');
	            }
	            if(__TIME - $order['dateline'] > 3600 && $order['order_status'] == 0 && $order['pay_status'] == 1){
	                K::M('order/order')->cancel($order['order_id'], $order, 'admin', '订单逾期1小时内无人接单自动取消');
	            }
	            $order = K::M('order/order')->detail($order_id);
        	} 
        	if(!$waimai_order = K::M('waimai/order')->detail($order_id)){
	            $this->msgbox->add('订单扩展信息不存在', 205);
	        }else if(!$waimai_order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
	            $this->msgbox->add('订单商品信息不存在', 206);
	        }else{
	        	$order['format_dateline'] = K::M('helper/format')->time($order['dateline']);
	            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
	            $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
	            $order['waimai_order'] = $waimai_order;
	            $order['waimai_order_product'] = $waimai_order_product;
	            foreach($waimai_order_product as $k => $v){
	                $specids[] = $v['spec_id'];
	            }
	            $order['qrcode'] = $this->mklink('qrcode?data=' . $waimai_order['spend_number']);
	            $order['qrcode'] = substr($order['qrcode'], 0, strlen($order['qrcode']) - 1);
	            $order['specs'] = K::M('waimai/productspec')->items_by_ids($specids);
	            $order['source_reason'] = $order['reason'];
	            $reason = K::M('order/order')->get_reason();
	            $order['reason'] = $reason['waimai'];
                if($order['pei_type'] != 3){
                    // 配送订单
                    if($order['order_status'] == 0){
                        if(($order['online_pay'] == 1 && $order['pay_status'] == 0) || ($order['online_pay'] == 0)){
                            $log_type = 1;
                        }else if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2);
                        }
                    }else if($order['order_status'] == 1 || (in_array($order['order_status'], array(1, 2)) && $order['staff_id'] > 0)){
                        if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2, 3);
                        }else if($order['online_pay'] == 0){
                            $log_type = array(1, 3);
                        }
                    }else if($order['order_status'] == 3){
                        if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2, 3, 4);
                        }else if($order['online_pay'] == 0){
                            $log_type = array(1, 3, 4);
                        }
                    }else if(in_array($order['order_status'], array(4, 8))){
                        if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2, 3, 5);
                        }else if($order['online_pay'] == 0){
                            $log_type = array(1, 3, 5);
                        }
                    }else if($order['order_status'] == -1){
                        $log_type = array(1, -1);
                    }
                }else{
                    // 自提订单
                    if($order['order_status'] == 0){
                        if(($order['online_pay'] == 1 && $order['pay_status'] == 0) || ($order['online_pay'] == 0)){
                            $log_type = 1;
                        }else if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2);
                        }
                    }else if($order['order_status'] == 1){
                        if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2, 3);
                        }else if($order['online_pay'] == 0){
                            $log_type = array(1, 3);
                        }
                    }else if($order['order_status'] == 8 && $waimai_order['spend_status'] == 1){
                        if($order['online_pay'] == 1 && $order['pay_status'] == 1){
                            $log_type = array(1, 2, 3, 6);
                        }else if($order['online_pay'] == 0){
                            $log_type = array(1, 3, 6);
                        }
                    }else if($order['order_status'] == -1){
                        $log_type = array(1, -1);
                    }
                    $order['qrcode'] = $this->mklink('qrcode?data=' . $waimai_order['spend_number']);
                    $order['qrcode'] = substr($order['qrcode'], 0, strlen($order['qrcode']) - 1);
                }

                $order['log_type'] = $log_type;
	            if($log_list = K::M('order/log')->items(array('order_id' => $order_id, 'type' => $log_type), array('log_id' => 'desc'))){
	                $order['logs'] = array_values($log_list);
	            }
                //echo '<pre>';print_r($order['logs']);die;
	            $this->pagedata['order'] = $order;
                
	        	$this->pagedata['theme_style'] = $this->default_weidian_theme();
				$this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/order/waimai/status.html';
	        }
        }
    }

    // 外卖订单支付页面
    public function payment($order_id)
    {
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 210);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){

            $this->msgbox->add('非法操作', 211);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 212);
        }
        else if($order['pay_status'] == 1){
            $this->msgbox->add('订单已经支付过了', 213);
        }
        else if(!empty($order['order_status'])){
            $this->msgbox->add('订单状态不正确', 214);
        }
        else{
            if(defined('IN_WEIXIN')){
                $this->pagedata['weixin'] = 1;
            }
            $leftover_seconds = 1800 - ( __TIME - $order['dateline']);
            if($leftover_seconds <= 0){
                $this->pagedata['leftover_seconds'] = 0;
            }
            else{
                $this->pagedata['leftover_seconds'] = $leftover_seconds;
            }
            $order['link'] = $this->mklink('weidian_'.$order['shop_id'].'/ucenter/order:waimai_order_detail', array($order['order_id']));
            if($order['from'] == 'pintuan' || $order['from'] == 'weidian_pintuan') {
                $arr_p_order = K::M('pintuan/order')->find(array('order_id' => $order_id));
                if(1 == $arr_p_order['is_money_pre']){
                    if(0 == $arr_p_order['money_paid']){
                        //1.预付款
                        $order['amount'] = $arr_p_order['money_need_pay'];
                    }
                    elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                        //2.付尾款
                        $order['is_weikuan'] = 1;//拼图付尾款标记
                        $order['amount'] = abs($order['amount'] - $arr_p_order['money_paid']);
                    }
                    else{
                        //3.付尾款 多次付款兼容
                        $order['is_weikuan'] = 1;//拼图付尾款标记
                        $order['amount'] = abs($order['amount'] - $arr_p_order['money_paid']);
                    }

                }

                $arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $arr_p_order['pintuan_group_id']));

                $leftover_seconds = $arr_group['end_time'] - __TIME;
                $order['link'] = $this->mklink('weidian_'.$order['shop_id'].'/pintuan/tuan_detail', array($arr_p_order['pintuan_group_id']));
            }
            $this->pagedata['order'] = $order;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/ucenter/order/waimai/payment.html';
        }

        
    }

    // 外卖订单取消
    public function waimai_order_cancel()
    {
        $reason = $this->GP('reason');
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 213);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消', 214);
        }
        else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态', 215);
        }
        else if(K::M('order/order')->cancel($order_id, $order, 'member', $reason)){
            $this->msgbox->add('订单取消成功');
        }
        else{
            $this->msgbox->add('订单取消失败', 216);
        }
    }

    // 外卖再来一单
    public function waimai_order_onemore()
    {
        $cart = array();
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 213);
        }
        else{
            if($order_product = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
                foreach($order_product as $key => $val){
                    $pk = $val['product_id'] . '-' . $val['spec_id'];
                    $product_ids[$val['product_id']] = $val['product_id'];
                    $spec_ids[$val['spec_id']] = $val['spec_id'];
                    $product_numbers[$pk] = $val['product_number'];
                    $cart_product_list[$pk] = array('product_id' => $val['product_id'], 'number' => $val['product_number'], 'spec_id' => $val['spec_id']);
                }
                $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($cart_product_list as $pk => $v){
                    if(!$p = $product_list[$v['product_id']]){
                        
                    }
                    else if($p['is_spec']){
                        // 带规格
                        $sp = $spec_lists[$v['spec_id']];
                        $order_product_list[$pk] = array(
                            'product_id'     => $v['product_id'],
                            'title'          => $p['title'],
                            'spec_name'      => $sp['spec_name'],
                            'price'          => $sp['price'],
                            'package'        => $p['package_price'],
                            'sale_type'      => $p['sale_type'],
                            'sale_sku'       => $sp['stock'],
                            'product_number' => $product_numbers[$pk]
                        );
                    }
                    else{
                        // 不带规格
                        $order_product_list[$pk] = array(
                            'product_id'     => $v['product_id'],
                            'title'          => $p['title'],
                            'spec_name'      => '',
                            'price'          => $p['price'],
                            'package'        => $p['package_price'],
                            'sale_type'      => $p['sale_type'],
                            'sale_sku'       => $p['stock'],
                            'product_number' => $product_numbers[$pk]
                        );
                    }
                }
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('shop_id', $order['shop_id']);
            $this->msgbox->set_data('product_list', $order_product_list);
        }
    }

    // 外卖订单催单
    public function waimai_order_cuidan()
    {
        $order_id = $this->GP('order_id');
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 213);
        }
        else if((__TIME - $order['jd_time']) < 1800){
            $this->msgbox->add('请在30分钟后催单', 216);
        }
        else if((__TIME - $order['cui_time']) < 600){
            $this->msgbox->add('已经催过，请稍后再试', 217);
        }
        else if(K::M('order/order')->update($order_id, array('cui_time' => __TIME))){
            $cuilog['uid'] = $order['uid'];
            $cuilog['shop_id'] = $order['shop_id'];
            $cuilog['staff_id'] = $order['staff_id'];
            $cuilog['order_id'] = $order['order_id'];
            if($log_id = K::M('order/cuilog')->find($cuilog)){
                K::M('order/cuilog')->update($log_id, array('cui_time' => __TIME));
            }
            else{
                $cuilog['cui_time'] = __TIME;
                K::M('order/cuilog')->create($cuilog);
            }
            $this->msgbox->add('催单成功,请耐心等待');
        }
        else{
            $this->msgbox->add('催单失败', 214);
        }
    }

    // 外卖订单用户确认送达
    public function waimai_order_arrived()
    {
        $order_id = (int) $this->GP('order_id');
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 213);
        }
        else if($order['order_status'] == 8){
            $this->msgbox->add('确认送达成功', 214); //订单已经确认,无需重复确认. 更改友好提示
        }
        else if(!in_array($order['order_status'], array(1, 3, 4))){
            $this->msgbox->add('商家还未配送完成不可确认', 215);
        }
        else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->add('确认送达成功');
        }
        else{
            $this->msgbox->add('确认送达失败', 222);
        }
    }

    // 外卖订单评价页面
    public function waimai_order_comment($order_id = null)
    {
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 202);
        }
        else if(!in_array($order['order_status'], array(4, 8))){
            $this->msgbox->add('订单不可评价', 203);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 204);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 204);
        }
        else if($order['comment_status'] != 0){
            $this->msgbox->add('订单已经评价过了', 205);
        }
        else{
            $comment['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $comment['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $comment['timestr'] = K::M('shop/comment')->peitime();
            $jifen = K::M('system/config')->get('jifen');
            $comment['jifen'] = intval($order['amount'] * $jifen['jifen_ratio']);
            $comment['order'] = $order;
            $this->pagedata['comment'] = $comment;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/ucenter/order/waimai/comment.html';
        }
    }

    // 外卖订单评价提交
    public function waimai_order_subcomment()
    {
        if(isset($_POST)){
            $data['staff_score'] = $_POST['score_staff'];
            $data['staff_content'] = $_POST['staff_content'];
            $data['score_fuwu'] = $_POST['score_fuwu'];
            $data['score_kouwei'] = $_POST['score_kouwei'];
            $data['shop_content'] = $_POST['shop_content'];
            $data['pei_time'] = $_POST['pei_time'];
            $data['order_id'] = $_POST['order_id'];
            // 判断订单状态

            if(!$order = K::M('order/order')->detail($data['order_id'])){
                $this->msgbox->add('订单不存在', 210)->response();
            }
            else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
                $this->msgbox->add('非法操作', 211)->response();
            }
            else if($order['uid'] != $this->uid){
                $this->msgbox->add('非法操作', 212)->response();
            }
            else if(!in_array($order['order_status'], array(4, 8))){
                $this->msgbox->add('订单状态不可评价', 213)->response();
            }
            else if($order['comment_status'] != 0){
                $this->msgbox->add('订单已经评价过了', 214)->response();
            }
            else{
                // 判断配送类型
                if($order['pei_type'] == 3){
                    // 自提订单 无配送时间
                    if(!$data['score_fuwu']){
                        $this->msgbox->add('请给服务打分', 215)->response();
                    }
                    else if(!$data['score_kouwei']){
                        $this->msgbox->add('请给商品打分', 216)->response();
                    }
                }
                else if(in_array($order['pei_type'], array(0, 1, 2))){
                    // 配送订单
                    if($order['staff_id'] == 0 && $order['pei_type'] == 0){  // 商家配送
                        if(!$data['pei_time']){
                            $this->msgbox->add('请选择送达时间', 220)->response();
                        }
                        else if(!$data['score_fuwu']){
                            $this->msgbox->add('请给服务打分', 221)->response();
                        }
                        else if(!$data['score_kouwei']){
                            $this->msgbox->add('请给商品打分', 223)->response();
                        }
                    }
                    else{
                        if(!$data['staff_score'] && $order['staff_id'] > 0){   //配送员配送
                            $this->msgbox->add('请为配送打分', 218)->response();
                        }
                        else if(!$data['pei_time']){
                            $this->msgbox->add('请选择送达时间', 220)->response();
                        }
                        else if(!$data['score_fuwu']){
                            $this->msgbox->add('请给服务打分', 221)->response();
                        }
                        else if(!$data['score_kouwei']){
                            $this->msgbox->add('请给商品打分', 223)->response();
                        }
                    }
                }
                $data_staff = $data_shop = array();
                $order_id = $data['order_id'];
                $data_staff['staff_id'] = $order['staff_id'];
                $data_staff['uid'] = $data_shop['uid'] = $this->uid;
                $data_staff['order_id'] = $data_shop['order_id'] = $order_id;
                $data_staff['content'] = $data['staff_content'];
                $data_staff['score'] = $data['staff_score'];
                $data_staff['mark'] = $data['staff_mark'] = '';
                $data_shop['shop_id'] = $order['shop_id'];
                $data_shop['score_fuwu'] = $data['score_fuwu'];
                $data_shop['score_kouwei'] = $data['score_kouwei'];
                $data_shop['pei_time'] = $data['pei_time'];
                $data_shop['content'] = $data['shop_content'];
                $data_shop['mark'] = $data['mark'];
                $comment_id1 = K::M('shop/comment')->create($data_shop);
                $comment_id2 = K::M('staff/comment')->create($data_staff);
                if($comment_id1 && $comment_id2){
                    if($_FILES['data']){
                        foreach($_FILES['data'] as $k => $v){
                            foreach($v as $kk => $vv){
                                $attachs[$kk][$k] = $vv;
                            }
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k => $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'comment')){
                                K::M('shop/photo')->create(array('comment_id' => $comment_id1, 'photo' => $a['photo']));
                            }
                        }
                    }
                    // 更新商家订单量、订单状态、用户获得积分
                    $shop = K::M('shop/shop')->detail($order['shop_id']);
                    $is_up_succ = K::M('order/order')->update($order_id, array('order_status' => 8, 'comment_status' => 1));


                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int) ($order['amount'] * $jifen['jifen_ratio']);
                    K::M('member/member')->update_jifen($this->uid, $jifen_total, '订单' . $order_id . '评价完成，获得积分');
                    K::M('shop/msg')->create(array('shop_id' => $order['shop_id'], 'title' => '订单已评价', 'content' => '用户(' . $order['contact'] . ')已评价订单(ID:' . $order_id . ')', 'is_read' => 0, 'type' => 2, 'order_id' => $order_id));

                    // 计算商家平均等待时间
                    $order_items = K::M('shop/comment')->items(array('shop_id' => $order['shop_id']), array(), 0, 9999999, $count);
                    foreach($order_items as $key => $val){
                        $pei_times += $val['pei_time'];
                    }
                    $pei_times = intval($pei_times / $count);
                    if($data_shop['score_fuwu'] > 3 && $data_shop['score_kouwei'] > 3){
                        $update_data = array('comments' => '`comments`+1', 'praise_num' => '`praise_num`+1', 'score_fuwu' => '`score_fuwu`+' . $data_shop['score_fuwu'], 'score_kouwei' => '`score_kouwei`+' . $data_shop['score_kouwei'], 'pei_time' => $pei_times);
                    }
                    else{
                        $update_data = array('comments' => '`comments`+1', 'score_fuwu' => '`score_fuwu`+' . $data_shop['score_fuwu'], 'score_kouwei' => '`score_kouwei`+' . $data_shop['score_kouwei'], 'pei_time' => $pei_times);
                    }
                    if($order['from'] == 'waimai'){
                        K::M('shop/shop')->update($order['shop_id'], $update_data, true);
                    }
                    $this->msgbox->add('评价成功');
                    $this->msgbox->set_data('forward', $this->mklink('waimai/order:detail', array($order_id)));
                }
                else{
                    $this->msgbox->add('评价失败');
                    $this->msgbox->set_data('forward', $this->mklink('waimai/order:comment', array($order_id)));
                }
            }
        }
    }

    // 外卖订单查看评价
    public function waimai_order_lookcomment($order_id = null)
    {
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 201);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }else if($order['from'] != 'weidian_waimai'){
            $this->msgbox->add('非法操作', 203);
        }else if($order['comment_status'] != 1){
            $this->msgbox->add('订单还未评价', 204);
        }
        else{
            if($shop_comment = K::M('shop/comment')->find(array('shop_id' => $order['shop_id'], 'uid' => $this->uid, 'order_id' => $order['order_id']))){
                $pei_time = $shop_comment['pei_time'];
                if($pei_time < 60){
                    $song_time = $pei_time . '分钟';
                }
                else if($pei_time == 60){
                    $song_time = '1小时';
                }
                else if($pei_time > 60 && $pei_time < 120){
                    $song_time = $pei_time . '分钟';
                }
                else if($pei_time == 120){
                    $song_time = '2小时';
                }
                else if($pei_time > 120 && $pei_time < 180){
                    $song_time = $pei_time . '分钟';
                }
                else if($pei_time == 180){
                    $song_time = '3小时';
                }
                else{
                    $song_time = '3小时以上';
                }
                $shop_comment['song_time'] = $song_time;
                $shop_comment['marklist'] = explode(',', $shop_comment['mark']);
                $shop_comment['photos'] = K::M('shop/photo')->items(array('comment_id' => $shop_comment['comment_id'], 'order_id' => $order['order_id']));
                $this->pagedata['shop_comment'] = $shop_comment;
            }
            if($staff_comment = K::M('staff/comment')->find(array('staff_id' => $order['staff_id'], 'uid' => $this->uid, 'order_id' => $order['order_id']))){
                $staff_comment['marklist'] = explode(',', $staff_comment['mark']);
                $this->pagedata['staff_comment'] = $staff_comment;
            }

            $this->pagedata['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $this->pagedata['order'] = $order;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/order/waimai/lookcomment.html';
        }   

    }

    // 外卖订单投诉页面
    public function waimai_order_complaint($order_id = null)
    {
        $order_id = (int) $order_id;
        if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 201);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }
        else if(!in_array($order['from'], array('weidian_waimai', 'weidian_pintuan'))){
            $this->msgbox->add('非法操作', 202);
        }
        else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂不可投诉', 203);
        }
        else if(K::M('order/complaint')->find(array('order_id' => $order_id, 'uid' => $this->uid))){
            $this->msgbox->add('该订单已经投诉过了', 204);
        }
        else{
            $remarks = K::M('order/order')->get_complaint();
            $order['remarks'] = $remarks['shop'];
            $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
            $this->pagedata['order'] = $order;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/ucenter/order/waimai/complaint.html';
        }
    }

    // 外卖订单投诉提交
    public function waimai_order_subcomplaint()
    {
        if(!$data['order_id'] = $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 201);
        }
        else if(!$order = K::M('order/order')->detail($data['order_id'])){
            $this->msgbox->add('订单不存在', 201);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 202);
        }
        else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂不可投诉', 203);
        }
        else if(!$data['content'] = $this->GP('content')){
            $this->msgbox->add('请输入反馈', 205);
        }
        else if(K::M('order/complaint')->find(array('order_id' => $data['order_id'], 'uid' => $this->uid))){
            $this->msgbox->add('该订单已经投诉过了', 206);
        }
        else{
            $data['uid'] = $this->uid;
            $data['shop_id'] = $order['shop_id'];
            $data['staff_id'] = $order['staff_id'];
            $m = K::M('member/member')->detail($order['uid']);
            if(K::M('order/complaint')->create($data)){
                $msg['shop_id'] = $order['shop_id'];
                $msg['title'] = '用户(' . $m['nickname'] . ')投诉了订单(ID:' . $order['order_id'] . ')';
                $msg['content'] = $data['content'];
                $msg['is_read'] = 0;
                $msg['type'] = 3;
                $msg['order_id'] = $order['order_id'];
                K::M('shop/msg')->create($msg);
                $this->msgbox->add('投诉成功');
            }
            else{
                $this->msgbox->add('投诉失败', 207);
            }
        }
    }


    // 外卖订单实时获取骑手地理位置
    public function waimai_order_staffpos()
    {
        $staff_id = (int) $this->GP('staff_id');
        $staff = K::M('staff/staff')->detail($staff_id);
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('lng' => $staff['lng'], 'lat' => $staff['lat']));
    }
    /*---------------------------------外卖订单功能结束----------------------------------------*/


    /* ---------------------------------外卖订单功能结束---------------------------------------- */

    // 拼团订单列表,原来的tuan_my动作
    public function pintuan_order_items()
    {

    }

}
