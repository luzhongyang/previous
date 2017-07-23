<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Mall extends Ctl_Ucenter
{
    //积分商城订单列表
	public function orderitems()
    {
        $this->tmpl = 'ucenter/mall/orderitems.html';  
    }

    public function loaditems() {
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $page = max((int)$this->GP('page'), 1);
        if($items = K::M('mall/order')->items($filter, array('order_id'=>'DESC'), $page, 10, $count)) {
            foreach($items as $k=>$v) {
                $order_ids[] = $v['order_id'];              
                $items[$k] = $this->filter_fields('order_id,order_status,pay_status,pay_code,contact,mobile,addr,product_price,dateline',$v);
                if(isset($v['pay_code']) && $v['pay_status']==1) {
                    $payments = K::M('mall/order')->get_payments();
                    $items[$k]['pay_method'] = $payments[$v['pay_code']];
                }else {
                    $items[$k]['pay_method'] = '未支付';
                }
                $items[$k]['products'] = array();
                $items[$k]['dateline'] = date('Y-m-d H:i:s', $v['dateline']);
            }
            if($order_products = K::M('mall/orderproduct')->items(array('order_id'=>$order_ids))) {
                foreach($order_products as $k=>$v) {
                    $product_ids[] = $v['product_id'];
                }
            }
            $products = K::M('mall/product')->items(array('product_id'=>$products_ids));
            foreach($items as $k=>$v) {
                foreach($order_products as $k2=>$v2) {
                    $v2['photo'] = $products[$v2['product_id']]['photo'];
                    if($v['order_id'] == $v2['order_id']) {
                        $items[$k]['products'][] = $this->filter_fields('product_name,product_price,product_jifen,product_number,photo',$v2);
                    }
                }
            }
        }else {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    // 查看订单详情
    public function detail($order_id=null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在',211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作',213);
        }else{
            $order = $this->filter_fields('order_id,uid,product_jifen,product_number,product_price,order_status,contact,mobile,addr,clientip,dateline,closed,pay_code,pay_status,pay_time,pay_ip,lasttime',$order);
            if(isset($order['pay_code']) && $order['pay_status']==1) {
                $payments = K::M('mall/order')->get_payments();
                $order['pay_method'] = $payments[$order['pay_code']];
            }else {
                $order['pay_method'] = '未支付';
            }

            if($product_list = K::M('mall/orderproduct')->items(array('order_id'=>$order_id))){
                foreach($product_list as $k=>$v) {
                    $proids[] = $v['product_id'];
                    $product_list[$k] = $this->filter_fields('pid,product_id,product_name,product_price,product_jifen,product_number',$v);
                }
                if($mall_product = K::M('mall/product')->items(array('product_id'=>$proids))) {
                    foreach($mall_product as $k=>$v) {
                        foreach($product_list as $key=>$val) {
                            if($v['product_id'] == $val['product_id'] ) {
                                $product_list[$key]['photo'] = $v['photo'];
                            }
                        }
                    }
                }
            }

            $order['products'] = array_values($product_list);
            $this->pagedata['order'] = $order;
            $this->tmpl = 'ucenter/mall/detail.html';
        }
    }

    // 确认收货
    public function receive($order_id=null)
    {
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add('订单不存在',210);
        }else if(!$order = K::M('mall/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在',210);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作',213);
        }else if($order['order_status'] != 5 && $order['pay_status'] != 1) {
            $this->msgbox->add('订单是不可确认收货的状态',211);
        }else {
            if(K::M('mall/order')->update($order['order_id'], array('order_status'=>8,'lasttime'=>__TIME))) {
                $this->msgbox->add('确认成功');
            }
        }
    }

    // 删除订单
    public function delete($order_id=null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('不存在的订单',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作',213);
        }else if(in_array($order['order_status'],array(-1,8))) {
            if(K::M('mall/order')->delete($order_id)) {
                if($order['order_status'] != -1) {
                    K::M('mall/order')->update($order_id, array('lasttime'=>__TIME));
                    $mall_order_product_items = K::M('mall/orderproduct')->items(array('order_id'=>$order_id));
                    foreach ($mall_order_product_items as $k => $v) {
                        K::M('mall/product')->update_count($v['product_id'], 'sales', -$v['product_number']);
                        K::M('mall/product')->update_count($v['product_id'], 'sku', +$v['product_number']);
                    }
                }
                $this->msgbox->add('删除成功');
                $this->msgbox->set_data('data','delete');
            }
        }else{
            $this->msgbox->add('订单为不可删除状态',214);
        }
    }

    // 取消订单
    public function chargeback($order_id=null) 
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在',211);
        }else if(!$order = K::M('mall/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消',214);
        }else if($order['order_status']==0 && $order['pay_status']==0){
            if(K::M('mall/order')->cancel($order_id, $order, 'member')) {
                $this->msgbox->add('取消成功');
            }  
        }else{
            $this->msgbox->add('当前订单是不可取消的状态',215);  
        }
    }
}