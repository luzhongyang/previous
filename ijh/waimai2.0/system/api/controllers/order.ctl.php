<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Order extends Ctl
{

    public function index($params)
    {
        $this->items($params);
    }

    public function items($params)
    {

        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        if(in_array($params['status'], array(0, 1, 2))){
            switch($params['status']){
                case 2:
                    $filter['order_status'] = array(-1, 5, 6, 7, 8);
                    if(in_array($params['comment_status'], array(0, 1))){
                        $filter['comment_status'] = $params['comment_status'];
                        if($filter['comment_status'] == 0 && !$params['from']){
                            $filter['order_status'] = 8;
                        }
                    }
                    break;
                case 1:
                    $filter['order_status'] = array(0, 1, 2, 3, 4, 5);
                    break;
            }
        }
        if(in_array($params['pay_status'], array(0, 1))){
            $filter['pay_status'] = $params['pay_status'];
        }

        if(in_array($params['from'], array('waimai', 'paotui', 'mall', 'pintuan'))){
            $filter['from'] = $params['from'];
        }
        else{
            $filter['from'] = array('waimai', 'paotui');
        }


        $page = max((int) $params['page'], 1);
        $limit = 10;

        if($order_list = K::M('order/order')->items($filter, array('order_id' => 'DESC'), $page, $limit, $count)){
            
            $shop_ids = $staff_ids = $order_ids = array();
            foreach($order_list as $k => $val){
                $order_list[$k]['order_youhuis'] = $val['order_youhui'];
                unset($order_list[$k]['order_youhui']);
                $staff_ids[$val['staff_id']] = $val['staff_id'];
                $shop_ids[$val['shop_id']] = $val['shop_id'];
                $order_ids[$val['order_id']] = $val['order_id'];
                if($val['from'] == 'waimai'){
                    $order_list[$k]['products'] = array();

                    /* if($this->uid){
                      if($collects = K::M('shop/collect')->items(array('uid'=>$this->uid,'shop_id'=>$shop_ids))){
                      foreach($collects as $k=>$v){
                      $shop_list[$v['shop_id']]['collect'] = 1;
                      }
                      }
                      } */
                }
                else if($val['from'] == 'paotui'){
                    if($val['comment_status'] > 0){
                        $order_list[$k]['comment'] = K::M('staff/comment')->find(array('order_id' => $val['order_id']));
                        if($commentphoto = K::M('staff/commentphoto')->items(array('comment_id' => $order_list[$k]['comment']['comment_id']))){
                            $order_list[$k]['commentphoto'] = array_values($commentphoto);
                        }
                        else{
                            $order_list[$k]['commentphoto'] = array();
                        }
                    }
                    else{
                        $order_list[$k]['comment'] = array('comment_id' => 0);
                        $order_list[$k]['commentphoto'] = array();
                    }
                    if($reward = K::M('paotui/reward')->find(array('order_id' => $val['order_id'], 'order_status' => 8, 'type' => 1))){
                        $order_list[$k]['reward_status'] = 1;
                    }
                    else{
                        $order_list[$k]['reward_status'] = 0;
                    }
                }
            }

            $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);

            $waimai_order = K::M('waimai/order')->items_by_ids($order_ids);
            foreach($waimai_order as $k => $v){
                $order_list[$v['order_id']]['detail'] = $v;
            }

            if($shop_list = K::M('shop/shop')->items_by_ids($shop_ids)){
                $shop_ids = array();
                foreach($shop_list as $k => $v){
                    $v = $this->filter_fields('shop_id,title,phone,mobile,logo,lat,lng,lngcomments,yy_stime,yy_ltime,praise_num,score_fuwu,score_kouwei,info', $v);
                    $v['collect'] = 0;
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                    $shop_list[$k] = $v;
                }
            }
            if($this->uid){
                if($collects = K::M('shop/collect')->items(array('uid' => $this->uid, 'shop_id' => $shop_ids))){
                    foreach($collects as $k => $v){
                        $shop_list[$v['shop_id']]['collect'] = 1;
                    }
                }
            }

            $product_list = K::M('waimai/orderproduct')->items(array('order_id' => $order_ids));
            foreach($product_list as $k => $v){  //写入订单产品列表
                $order_list[$v['order_id']]['products'][] = $v;
            }

            $jifen = K::M('system/config')->get('jifen');

            foreach($order_list as $k => $v){
                
                if($staff_list[$v['staff_id']]){
                    $order_list[$k]['staff'] = $staff_list[$v['staff_id']];
                    unset($order_list[$k]['staff']['passwd']);
                }
                else{
                    $order_list[$k]['staff'] = array('staff_id'=>0);
                }

                $order_list[$k]['jifen'] = (int) $jifen['jifen_ratio'];
                if($shop_list[$v['shop_id']]){
                    $order_list[$k]['shop'] = $shop_list[$v['shop_id']];
                }
                else{
                    $order_list[$k]['shop'] = array('shop_id' => '0', 'shop_title' => '', 'photo' => '', 'logo' => 'default/shop_logo.png');
                }
            }

            $paotui_order = K::M('paotui/order')->items_by_ids($order_ids);
            foreach($paotui_order as $pk => $pv){
                $pv['type'] = trim($pv['type']);
                if(empty($pv['type']) || strlen($pv['type'])<2){
                    $pv['type'] = 'buy';
                }
                $order_list[$pk]['type'] = $pv['type'];
                $order_list[$pk]['o_addr'] = $pv['o_addr'];
                $order_list[$pk]['o_house'] = $pv['o_house'];
                $order_list[$pk]['o_contact'] = $pv['o_contact'];
                $order_list[$pk]['o_mobile'] = $pv['o_mobile'];
                $order_list[$pk]['o_lat'] = $pv['o_lat'];
                $order_list[$pk]['o_lng'] = $pv['o_lng'];
                $order_list[$pk]['paotui_amount'] = $pv['paotui_amount'];
                $order_list[$pk]['reward_amount'] = $pv['reward_amount'];
            }
        }
        else{
            $order_list = array();
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => array_values($order_list), 'page' => $page));
    }

    /* 外卖创建订单
     * pei_time,配送时间
     * shop_id,商铺ID
     * products,
     * addr_id
     */

    public function create($params)
    {
        $this->check_login();

        // 验证并拆分用户要求送达时间
        $pei_time = $pei_time_start = $pei_time_last = 0;
        if($opei_time = $params['pei_time']){
            $pei_time = explode('-', $params['pei_time']);
            $pei_time_start = $pei_time[0];
            $pei_time_last = $pei_time[1];
            $pei_time = strtotime(date('Y-m-d') . ' ' . $pei_time_start);
        }
        else{
            $pei_time = __TIME + 1800;
        }
        // 订单备注
        if(!$shop_id = (int) $params['shop_id']){
            $this->msgbox->add('商家不能为空', 221);
        }
        else if(!$shop_detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 222);
        }
        else if($shop_detail['audit'] != 1 || $shop_detail['closed'] != 0){
            $this->msgbox->add('商家不存在或已删除', 223);
        }
        else{
            $cur_time = (float) date("H.i", __TIME);
            $yy_stime = (float) str_replace(':', '.', $shop_detail['yy_stime']);
            $yy_ltime = (float) str_replace(':', '.', $shop_detail['yy_ltime']);
            $pei_stime = (float) str_replace(':', '.', $opei_time);

            if(empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                $this->msgbox->add('商家已经打烊不可下单', 224);
            }
            else if($opei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                $this->msgbox->add('配送时间不在商家营业范围', 225);
            }
            else if(!$products = $params['products']){
                $this->msgbox->add('您还没有订餐呢', 226);
            }
            else if($params['pei_type'] == 3 && !$shop_detail['is_ziti']){
                $this->msgbox->add('该商户不支持自提', 227);
            }
            else if($params['online_pay'] == 1 && $shop_detail['online_pay'] != 1){
                $this->msgbox->add('该商户不支持在线支付', 228);
            }
            else if($params['online_pay'] == 0 && (!in_array($shop_detail['online_pay'], array(0, 2)) || !$shop_detail['is_daofu'])) {
                $this->msgbox->add('该商户不支持货到付款', 229);
            }
            else if($params['pei_type'] != 3 && !($addr_id = (int) $params['addr_id'])){
                $this->msgbox->add('请选择地址', 230);
            }
            else if($params['pei_type'] != 3 && !($addr_detail = K::M('member/addr')->detail($addr_id))){
                $this->msgbox->add('地址不存在', 231);
            }
            else if($params['pei_type'] != 3 && K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat']) > ($shop_detail['pei_distance'] * 1000)){
                $this->msgbox->add('超出配送范围', 232);
            }
            else{

                $data_order = $data_waimai = array();
                // 验证订单商品信息
                //1:2:1,2:2
                //商品ID:规格ID:数量
                $products = explode(',', $products);
                foreach($products as $key => $pro){
                    $products[$key] = explode(':', $pro);
                }
                $product_ids = $spec_ids = $product_numbers = $product_specids = $order_product_list = array();
                foreach($products as $key => $value){
                    $len = count($value);
                    if($len > 2){
                        $pk = $value[0] . '-' . $value[1];
                        $product_ids[$value[0]] = $value[0];
                        $spec_ids[$value[1]] = $value[1];
                        $product_numbers[$pk] = $value[2];
                        $cart_product_list[$pk] = array('product_id' => $value[0], 'number' => $value[2], 'spec_id' => $value[1]);
                    }
                    else{
                        $pk = $value[0];
                        $product_ids[$value[0]] = $value[0];
                        $product_numbers[$pk] = $value[1];
                        $cart_product_list[$pk] = array('product_id' => $value[0], 'number' => $value[2], 'spec_id' => $value[1]);
                    }
                }
                // foreach ($products as $key => $val) {
                //
                //     if(preg_match('/^(\d+):(\d+):(\d+)$/', $val, $local)){
                //         $pk = $local[1].'-'.$local[3];
                //         $product_ids[$local[1]] = $local[1];
                //         $spec_ids[$local[3]] = $local[3];
                //         $product_numbers[$pk] = $local[2];
                //         $cart_product_list[$pk] = array('product_id'=>$local[1], 'number'=>$local[2], 'spec_id'=>$local[3]);
                //     }
                // }
                $product_price = $package_price = $product_number = $hongbao_amount = $coupon_amount = $first_youhui = $youhui_amount = $pei_amount = $money = $amount = 0;
                $product_list = K::M('waimai/product')->items_by_ids($product_ids);
                $spec_lists = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($cart_product_list as $pk => $v){
                    if(!$p = $product_list[$v['product_id']]){
                        //购物车的商品实际不存在
                    }if($p['shop_id'] != $shop_detail['shop_id']){
                        $this->msgbox->add('商品不是同一家商家的', 230)->response();
                    }
                    else if($p['is_spec']){
                        $sp = $spec_lists[$v['spec_id']];
                        if(!$v['spec_id'] && $sp){
                            //商品未选规格sku
                            $this->msgbox->add('商品未选规格', 231)->response();
                        }
                        else if($sp['product_id'] != $v['product_id']){
                            //选择规格与商品ID关联不符
                            $this->msgbox->add('选择规格与商品ID关联不符', 232)->response();
                        }
                        else if( $sp['sale_sku'] < $product_numbers[$pk] ){
                            $this->msgbox->add('商品库存不足', 233)->response();
                        }
                        else{
                            $_pamount = ($sp['price'] + $p['package_price']) * $product_numbers[$pk];
                            $order_product_list[$pk] = array(
                                'product_id'     => $v['product_id'],
                                'spec_id'        => $v['spec_id'],
                                'sale_type'      => $p['sale_type'],
                                'product_number' => $product_numbers[$pk],
                                'product_name'   => $p['title'],
                                'product_price'  => $sp['price'],
                                'package_price'  => $p['package_price'],
                                'amount'         => $_pamount
                            );
                            $product_number += $product_numbers[$pk];
                            $product_price +=$sp['price'] * $product_numbers[$pk];
                            $package_price +=$p['package_price'] * $product_numbers[$pk];
                        }
                    }
                    else{
                        if( $p['stock'] < $product_numbers[$pk] ){
                            $this->msgbox->add('商品库存不足', 211)->response();
                        }
                        else{
                            $_pamount = ($p['price'] + $p['package_price']) * $product_numbers[$pk];
                            $order_product_list[$pk] = array(
                                'product_id'     => $v['product_id'],
                                'spec_id'        => 0,
                                'sale_type'      => $p['sale_type'],
                                'product_number' => $product_numbers[$pk],
                                'product_name'   => $p['title'],
                                'product_price'  => $p['price'],
                                'package_price'  => $p['package_price'],
                                'amount'         => $_pamount
                            );
                            $product_number += $product_numbers[$pk];
                            $product_price +=$p['price'] * $product_numbers[$pk];
                            $package_price +=$p['package_price'] * $product_numbers[$pk];
                        }
                    }
                }
                if($product_price < $shop_detail['min_amount']){
                    $this->msgbox->add('没有达到配送要求', 212)->response();
                }
                if(isset($params['ziti_time'])){
                    $ziti_time = strtotime($params['ziti_time']);
                }else{
                    $ziti_time = 0;
                }
                $data_order = array(
                    'city_id'        => $shop_detail['city_id'],
                    'shop_id'        => $shop_id,
                    'staff_id'       => 0,
                    'uid'            => $this->uid,
                    'from'           => 'waimai',
                    'order_status'   => 0,
                    'product_number' => $product_number,
                    'product_price'  => $product_price,
                    'package_price'  => $package_price,
                    'o_lat'          => $shop_detail['lat'],
                    'o_lng'          => $shop_detail['lng'],
                    'intro'          => $params['intro'],
                    'pay_status'     => 0,
                    'pei_time'       => $pei_time,
                    'order_from'     => strtolower(CLIENT_OS),
                    'ziti_time'      => $ziti_time,
                );
                if($params['pei_type'] == 3){
                    $data_order['amount'] = $product_price + $package_price;
                    $data_order['freight'] = 0;
                    $data_order['contact'] = $this->MEMBER['nickname'];
                    $data_order['mobile'] = $this->MEMBER['mobile'];
                    $data_order['addr'] = $shop_detail['addr'];
                    $data_order['lng'] = $shop_detail['lng'];
                    $data_order['lat'] = $shop_detail['lat'];
                    $data_order['pei_type'] = 3;
                    $data_order['pei_amount'] = 0;
                    $data_order['total_price'] = $product_price + $package_price;
                }
                else{
                    $juli = K::M('helper/round')->getdistances($shop_detail['lng'], $shop_detail['lat'], $addr_detail['lng'], $addr_detail['lat']);
                    $juli = ceil($juli / 10);
                    $juli = $juli/100;//新距离计算方式wu.
                    $_freight = array();
                    $_max_freight = array('fkm' => 0, 'fm' => 0);
                    foreach($shop_detail['freight_stage'] as $k => $v){
                        if($juli <= $v['fkm']){
                            if($_freight && $_freight['fkm'] > $v['fkm']){
                                $_freight = $v;
                            }
                            else if(empty($_freight)){
                                $_freight = $v;
                            }
                        }
                        if($v['fkm'] > $_max_freight['fkm']){
                            $_max_freight = $v;
                        }
                    }
                    $freight = $_freight['fkm'] ? $_freight['fm'] : $_max_freight['fm'];
                    $p_amount = $_freight['fkm'] ? $_freight['sm'] : $_max_freight['sm'];

                    $data_order['amount'] = $product_price + $package_price + $freight;
                    $data_order['contact'] = $addr_detail['contact'];
                    $data_order['mobile'] = $addr_detail['mobile'];
                    $data_order['addr'] = $addr_detail['addr'];
                    $data_order['house'] = $addr_detail['house'];
                    $data_order['lng'] = $addr_detail['lng'];
                    $data_order['lat'] = $addr_detail['lat'];
                    if($shop_detail['pei_type'] == 4) {
                        $data_order['pei_type'] = 0;
                    }else { 
                        $data_order['pei_type'] = $shop_detail['pei_type'];
                    }

                    $data_order['pei_amount'] = $p_amount;
                    $data_order['total_price'] = $product_price + $package_price + $freight;
                }
                if($params['online_pay'] == 1){
                    // 在线支付享受的优惠顺序 首单优惠 > 满减优惠 > 店铺优惠券 > 红包优惠
                    $data_order['online_pay'] = 1;

                    // 首单优惠
                    $member_orders = K::M('order/order')->count(array('order_status'=>'>:'.-1,'uid'=>$this->uid));
                    if($shop_detail['first_amount'] && !$this->MEMBER['orders'] && !$member_orders){
                        $data_order['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                    }else {
                        $data_order['first_youhui'] = $first_youhui = 0;
                    }

                    // 满减优惠
                    if($youhui_detail = K::M('shop/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                        $data_order['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                    }

                    
                    // 店铺优惠券优惠
                    if($cid = (int) $params['cid']){
                        if(!$coupon_detail = K::M('member/coupon')->detail($cid)){
                            $this->msgbox->add('优惠券不存在', 206)->response();
                        }
                        else if($coupon_detail['shop_id'] != $shop_detail['shop_id']){
                            $this->msgbox->add('优惠券错误', 207)->response();
                        }
                        else if($coupon_detail['uid'] != $this->uid){
                            $this->msgbox->add('非法操作', 207)->response();
                        }
                        else if($coupon_detail['use_time'] > 0){
                            $this->msgbox->add('该优惠券已使用', 208)->response();
                        }
                        else if($coupon_detail['ltime'] < time()){
                            $this->msgbox->add('该优惠券已过期', 209)->response();
                        }
                        else if($coupon_detail['order_amount'] > ($product_price - $first_youhui - $youhui_amount)){
                            $this->msgbox->add('该优惠券不能使用', 210)->response();
                        }
                        else{
                            $data_order['coupon_id'] = $coupon_detail['coupon_id'];
                            $data_order['coupon'] = $coupon_amount = $coupon_detail['coupon_amount'];
                        }
                    }

                    // 红包优惠
                    if($hongbao_id = (int) $params['hongbao_id']){
                        if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                            $this->msgbox->add('红包不存在', 203)->response();
                        }
                        else if($hongbao_detail['uid'] != $this->uid){
                            $this->msgbox->add('红包信息不正确', 204)->response();
                        }
                        else if($hongbao_detail['order_id']){
                            $this->msgbox->add('该红包已经使用', 205)->response();
                        }
                        else if($hongbao_detail['ltime'] < __TIME){
                            $this->msgbox->add('红包已过期不能使用', 244)->response();
                        }
                        else if($hongbao_detail['min_amount'] > ($product_price - $first_youhui - $youhui_amount - $coupon_amount)){
                            $this->msgbox->add('该红包不能使用', 205)->response();
                        }
                        else{
                            $data_order['hongbao_id'] = $hongbao_id;
                            $data_order['hongbao'] = $hongbao_amount = $hongbao_detail['amount'];
                        }
                    }
                    $total_youhui_amount = $youhui_amount + $coupon_amount + $first_youhui + $hongbao_amount;
                    if($product_price > $total_youhui_amount) {
                        $data_order['amount'] = $amount = $product_price + $package_price + $freight - $youhui_amount - $coupon_amount - $first_youhui - $hongbao_amount;
                    }else {
                        $data_order['amount'] = $amount = $package_price + $freight;
                    }   
                }
                else{
                    // 货到付款方式支付
                    $data_order['online_pay'] = 0;
                    if( 2 == $data_order['pei_type'] || 1 == $data_order['pei_type']){
                        $data_order['pei_type'] = 0;
                    }
                }

                if($data_order['amount'] == 0){
                    $data_order['pay_status'] = 1;
                }

                $data_order['wx_openid'] = $this->MEMBER['wx_openid'];
                // 创建主订单记录
                if($order_id = K::M('order/order')->create($data_order)){
                    $data_waimai = array(
                        'order_id'       => $order_id,
                        'product_number' => $product_number,
                        'product_price'  => $product_price,
                        'package_price'  => $package_price,
                        'freight'        => $freight,
                    );
                    // 创建附属表订单记录
                    $waimai_order_id = K::M('waimai/order')->create($data_waimai);
                    $order = K::M('order/order')->detail($order_id);
                    if($order['online_pay'] == 0 && $order['pei_type'] == 3){
                        //如果是自提单且选择了到付，直接生成消费码
                        K::M('waimai/order')->create_number($order_id);
                    }
                    else if($order['online_pay'] == 1 && $order['pay_status'] == 0 && $order['pei_type'] == 3){
                        //如果自提单选择了在线支付且未支付，支付成功之后生成消费码
                        K::M('waimai/order')->update($order_id, array('spend_number' => 0, 'spend_status' => 0));
                    }
                    //写入waimai_order_product表
                    foreach($order_product_list as $k => $val){
                        $val['order_id'] = $order_id;
                        K::M('waimai/orderproduct')->create($val);
                    }
                    if($youhui_detail){
                        K::M('shop/youhui')->update_count($youhui_detail['youhui_id'], 'use_count', 1);
                    }
                    if($hongbao_detail){
                        K::M('hongbao/hongbao')->update($hongbao_id, array('order_id' => $order_id, 'used_time' => __TIME, 'used_ip' => __IP));
                    }
                    if($coupon_detail){
                        K::M('member/coupon')->update($coupon_detail['cid'], array('order_id'=>$order_id,'use_time'=>__TIME,'used_ip'=>__IP,'status'=>1));
                    }
                    // 写入订单日志
                    K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));

                    // 如果是货到付款订单则直接推送消息给商户，在线支付则在支付成功之后推送给商户
                    if($order['online_pay']==0) {
                        $title = sprintf("您有新的外卖订单(单号：%s)", $order_id);
                        $content = sprintf("您有新的外卖订单(单号：%s)，客户%s(电话：%s)配送地址:%s", $order_id, $order['contact'], $order['mobile'], $addr);
                        K::M('shop/shop')->send($order['shop_id'], $title, $content, 'newOrder', $order_id);
                    }
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id'=>$order['order_id'],'amount'=>$order['amount'],'dateline'=>time(),'pay_status'=>$order['pay_status']));
                }
                else{
                    if($money){ //下单失败退回余额
                        K::M('member/member')->update_money($this->uid, $money, '订单创建失败退回余额');
                    }
                    $this->msgbox->add('创建订单失败', 411);
                }
            }
        }
    }

    public function preinfo($params)
    {
        $this->check_login();
        if(!$shop_id = (int) $params['shop_id']){
            $this->msgbox->add('商家不存在', 211);
        }
        else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在或已被删除', 212);
        }
        else if(empty($shop['audit'])){
            $this->msgbox->add('商户审核中不可下单', 212);
        }
        else{
            
            if($addr_id = (int) $params['addr_id']){
                if($addr = K::M('member/addr')->detail($addr_id)){
                    if($addr['uid'] != $this->uid){
                        $addr = array();
                    }
                    else{
                        $addr['juli'] = K::M('helper/round')->getdistances($shop['lng'], $shop['lat'], $addr['lng'], $addr['lat']);
                    }
                }
            }

            if(empty($addr)){
                if($addr_list = K::M('member/addr')->items(array('uid' => $this->uid), null, 1, 10)){
                    $pei_distance = $shop['pei_distance'] ? $shop['pei_distance'] : 5;
                    $_a = array();
                    foreach($addr_list as $k => $v){
                        $v['juli'] = K::M('helper/round')->getdistances($shop['lng'], $shop['lat'], $v['lng'], $v['lat']);
                        if($v['juli'] <= $pei_distance * 1000){
                            if(empty($addr) || ($addr['juli'] > $v['juli'])){
                                $addr = $v;
                                $addr_id = $v['addr_id'];
                            }
                        }
                        $addr_list[$k] = $v;
                    }
                }
            }



            
            if($addr){
                //计算出对应的配送费
//                $juli = ceil($addr['juli'] / 1000);
                $juli = ceil($addr['juli'] / 10);
                $juli = $juli/100;//新距离计算方式wu.
                $_freight = array();
                $_max_freight = array('fkm' => 0, 'fm' => 0);
                foreach($shop['freight_stage'] as $k => $v){
                    if($juli <= $v['fkm']){
                        if($_freight && $_freight['fkm'] > $v['fkm']){
                            $_freight = $v;
                        }
                        else if(empty($_freight)){
                            $_freight = $v;
                        }
                    }
                    if($v['fkm'] > $_max_freight['fkm']){
                        $_max_freight = $v;
                    }
                }
                $freight_stage = $_freight['fkm'] ? $_freight['fm'] : $_max_freight['fm'];
                //计算出对应的配送费结束
            }
            else{
                $addr = array('addr_id' => 0, 'uid' => '', 'contact' => '', 'mobile' => '', 'addr' => '', 'house' => '', 'is_default' => '0', 'lat' => '0', 'lng' => '');
                $freight_stage = 0;
            }

            if(empty($addr)){
                $addr = array('addr_id' => 0, 'uid' => '', 'contact' => '', 'mobile' => '', 'addr' => '', 'house' => '', 'is_default' => '0', 'lat' => '0', 'lng' => '');
            }

            $addr = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng,juli', $addr);

            // 在线支付享受的优惠顺序 首单优惠 > 满减优惠 > 店铺优惠券 > 红包优惠
            
            // 首单优惠
            $member_orders = K::M('order/order')->count(array('order_status'=>'>:'.-1,'uid'=>$this->uid));
            if($shop['first_amount'] && !$this->MEMBER['orders'] && !$member_orders){
                if($params['amount'] >= $shop['first_amount']) {
                    $first_youhui = $shop['first_amount']; //如果订单金额小于首单优惠则首单优惠等于订单金额
                }else {
                    $first_youhui = $params['amount']; // 不是第一单不享受首单优惠
                }
            }

            // 满减优惠
            if($youhui_detail = K::M('shop/youhui')->order_youhui($shop['shop_id'], $params['amount']-$first_youhui)){
                $data['youhui'] = $youhui_detail['youhui_amount'];
            }

            // 店铺优惠券
            $second_youhui = $params['amount'] - $first_youhui - $data['youhui'];

            $cid = 0;
            if(isset($params['cid'])){
                $cid = (int)$params['cid'];
            }
            if($cid>0) {

                if(!$coupon_detail = K::M('member/coupon')->detail($cid)){
                    $this->msgbox->add('优惠券不存在', 206)->response();
                }
                else if($coupon_detail['shop_id'] != $shop['shop_id']){
                    $this->msgbox->add('优惠券错误', 207)->response();
                }
                else if($coupon_detail['uid'] != $this->uid){
                    $this->msgbox->add('非法操作', 207)->response();
                }
                else if($coupon_detail['use_time'] > 0){
                    $this->msgbox->add('该优惠券已使用', 208)->response();
                }
                else if($coupon_detail['ltime'] < time()){
                    $this->msgbox->add('该优惠券已过期', 209)->response();
                }
                else if($coupon_detail['order_amount'] > $second_youhui){
                    $this->msgbox->add('该优惠券不满足使用条件', 210)->response();
                }
                else{
                    $coupon = $coupon_detail;
                    $my_c_filter = array(
                        'shop_id'=>$shop['shop_id'],
                        'status'=>0,
                        'uid'=>$this->uid,
                        'use_time'=>0,
                        'order_amount'=>'<=:' . $second_youhui,
                        'ltime'=>'>=:' . __TIME
                        );
                    $coupon_count = K::M('member/coupon')->count($my_c_filter);
                }
            }else {
                if(!$coupon = K::M('member/coupon')->items(array('shop_id' => $shop['shop_id'], 'status' => 0,'uid'=>$this->uid, 'use_time' => 0, 'order_amount' => '<=:' . $second_youhui, 'ltime' => '>=:' . __TIME), array('coupon_amount' => 'desc'))){
                    $coupon = array('cid' => 0, 'coupon_id' => '', 'uid' => '', 'use_time' => '', 'order_id' => '', 'status' => '', 'dateline' => '', 'ltime' => '', 'order_amount' => '', 'coupon_amount' => '', 'shop_id' => '');
                    $coupon_count = 0;
                    $cid = 0;
                }
                else{
                    $coupon = array_values($coupon);
                    $coupon_count = count($coupon);
                    $cid = $coupon[0]['cid'];
                    $coupon = $coupon[0];
                }
            }

            // 红包优惠
            $hongbao_id = $hongbao_count = 0;

            $hongbao = array('hongbao_id' => 0, 'title' => '', 'min_amount' => '', 'amount' => '', 'type' => '', 'uid' => '0', 'stime' => '0', 'ltime' => '', 'order_id' => '0', 'used_time' => '0', 'dateline' => '');
            $third_youhui = $params['amount'] - $first_youhui  - $data['youhui'] - $coupon['coupon_amount'];
            if($amount = (float) $third_youhui){
                $filter = array('uid' => $this->uid, 'min_amount' => '<=:' . $amount, 'ltime' => '>=:' . __TIME, 'order_id' => 0);
                if($hb_list = K::M('hongbao/hongbao')->items($filter, array('amount' => 'DESC'), 1, 1, $count)){
                    $hongbao = array_shift($hb_list);
                    $hongbao_id = $hongbao['hongbao_id'];
                    $hongbao_count = $count;
                }
                else{
                    $hongbao = array('hongbao_id' => 0, 'title' => '', 'min_amount' => '', 'amount' => '', 'type' => '', 'uid' => '0', 'stime' => '0', 'ltime' => '', 'order_id' => '0', 'used_time' => '0', 'dateline' => '');
                }
            }

            $data = array('hongbao_id' => $hongbao_id, 'hongbao_count' => $hongbao_count, 'hongbao' => $hongbao, 'addr_id' => $addr_id, 'address' => $addr, 'freight' => $shop['freight'], 'first_amount' => $first_youhui, 'youhui' => $data['youhui'], 'coupon' => $coupon, 'coupon_count' => $coupon_count, 'cid' => $cid);

            $data['freight_stage'] = $freight_stage;
            $shop = array(
                'yy_stime'     => $shop['yy_stime'],
                'yy_ltime'     => $shop['yy_ltime'],
                'yy_status'    => $shop['yy_status'],
                'addr'         => $shop['addr'],
                'house'        => $shop['house'],
                'lat'          => $shop['lat'],
                'lng'          => $shop['lng'],
                'pei_distance' => $shop['pei_distance'],
                'titleString'  => $shop['title'],
                'is_ziti'      => $shop['is_ziti'],
                'online_pay'   => $shop['online_pay'],
                'is_daofu'      =>$shop['is_daofu'],
                'pei_type'     => $shop['pei_type'],
            );
            $data['shopinfo'] = $shop;
            $this->msgbox->set_data('data', $data);
        }
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else{
            $waimai_order = K::M('waimai/order')->detail($order['order_id']);
            $order['detail']['order_id'] = $waimai_order['order_id'];
            $order['detail']['product_number'] = $waimai_order['product_number'];
            $order['detail']['product_price'] = $waimai_order['product_price'];
            $order['detail']['package_price'] = $waimai_order['package_price'];
            $order['detail']['freight'] = $waimai_order['freight'];
            $order['detail']['spend_number'] = $waimai_order['spend_number'];
            $order['detail']['spend_status'] = $waimai_order['spend_status'];
            $order['order_youhuis'] = $order['order_youhui'];

            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array(
                    'shop_id' => '0',
                    'logo'    => 'default/shop_logo.png',
                );
            }
            else{
                $shop = $this->filter_fields('shop_id,title,phone,mobile,logo,lat,lng,lngcomments,yy_stime,yy_ltime,praise_num,score_fuwu,score_kouwei,info', $shop);
                $order['shop'] = $shop;
            }
            if(!$staff = K::M('staff/staff')->detail($order['staff_id'])){
                $order['staff'] = array('staff_id' => 0, 'name' => '', 'mobile' => '', 'lat' => '', 'lng' => '', 'face' => '');
            }
            else{
                $staff = $this->filter_fields('staff_id,name,mobile,lng,lat,face', $staff);
                $order['staff'] = $staff;
            }
            if(!$log_list = K::M('order/log')->items(array('order_id' => $order_id), array('log_id' => 'DESC'))){
                $log_list = array();
            }
            if(!$product_list = K::M('waimai/orderproduct')->items(array('order_id' => $order_id))){
                $product_list = array();
            }
            else{
                $spec_ids = array();
                foreach($product_list as $k => $v){
                    if($v['spec_id']){
                        $spec_ids[$v['spec_id']] = $v['spec_id'];
                    }
                }
                $specs = K::M('waimai/productspec')->items_by_ids($spec_ids);

                foreach($product_list as $k => $v){
                    if($v['spec_id']){
                        $product_list[$k]['spec'] = $specs[$v['spec_id']];
                    }
                    else{
                        $product_list[$k]['spec'] = array('spec_id' => 0);
                    }
                }
            }
            if($complaint = K::M('order/complaint')->find(array('uid' => $this->uid, 'order_id' => $order_id))){
                $order['complaint'] = 1;
            }
            else{
                $order['complaint'] = 0;
            }
            $logs = array();
            foreach($log_list as $k => $val){
                $logs[$val['type']] = $val;
            }

            if($order['order_status'] >= 1){
                $order['receive_time'] = $logs[3]['dateline'];
            }
            if($order['order_status'] >= 3){
                $order['pks_time'] = $logs[4]['dateline'];
            }
            if($order['order_status'] >= 4){
                $order['pwc_time'] = $logs[5]['dateline'];
            }
            if($order['order_status'] >= 8){
                $order['wc_time'] = $logs[6]['dateline'];
                $order['pwc_from'] = $logs[6]['from'];
            }
            if($order['order_status'] == -1){
                if($logs[3]){
                    $order['receive_time'] = $logs[3]['dateline'];
                }
                if($logs[4]){
                    $order['pks_time'] = $logs[4]['dateline'];
                }
                if($logs[5]){
                    $order['pwc_time'] = $logs[5]['dateline'];
                }
                $order['pcancel_time'] = $logs[-1]['dateline'];
                $order['pcancel_from'] = $logs[-1]['from'];
            }
            $order['order_status_tips'] = '';
            if($order['pay_status'] == 0){
                if($order['order_status'] == 0 || $order['order_status'] == 1){
                    $order['order_status_tips'] = L('订单逾期未支付半小时自动取消');
                }
                else if($order['order_status'] == -1){
                    $order['order_status_tips'] = L('订单已取消');
                }
            }
            else if($order['pay_status'] == 1){
                if($order['order_status'] == 0){
                    $order['order_status_tips'] = L('等待商家接单');
                }
                else if($order['order_status'] == 1 || $order['order_status'] == 3){
                    $order['order_status_tips'] = L('预计送达：尽快送达');
                }
                else if($order['order_status'] == 4 || $order['order_status'] == 8){
                    $order['order_status_tips'] = L('订单超过3小时自动完成');
                }
                else if($order['order_status'] == -1){
                    $order['order_status_tips'] = L('订单逾期未支付半小时自动取消');
                }
            }
            //订单进度
            $jindu = array('xiadan' => array(), 'zhifu' => array());

            $order['products'] = array_values($product_list);
            $order['logs'] = array_values($log_list);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('order' => $order));
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'), 214);
        }
        else if($order['order_status'] != 0){
            $this->msgbox->add(L('当前订单是不可取消的状态'), 215);
        }
        else if(K::M('order/order')->cancel($order_id, $order, 'member', $params['reason'])){
            $this->msgbox->add('success');
        }
        else{
            $this->msgbox->add(L('取消订单失败'), 216);
        }
    }

    public function delete($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] >= 0 && $order['order_status'] < 8){
            $this->msgbox->add(L('订单为不可删除状态'), 214);
        }
        else if(K::M('order/order')->delete($order_id)){
            $this->msgbox->add('success');
        }
        else{
            $this->msgbox->add(L('删除订单失败'), 216);
        }
    }

    //用户申请退单，需要商家/管理员同意后才能取消订单
    public function tuidan($params)
    {
        
    }

    public function cuidan($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] == 8){
            $this->msgbox->add(L('订单已完成可催单'), 214);
        }
        else if(!in_array($order['order_status'], array(1, 2, 3, 4))){
            $this->msgbox->add(L('未接单不可催单'), 214);
        }
        else if($order['cui_time'] > (__TIME - 900)){
            $this->msgbox->add(L('您已经催单了,请再耐心等等'), 214);
        }
        else if(K::M('order/order')->update($order_id, array('cui_time' => __TIME), true)){
            if($order['pei_type'] < 2 && $order['shop_id']){
                $a = array(
                    'shop_id'  => $order['shop_id'],
                    'type'     => 1,
                    'order_id' => $order_id,
                    'title'    => L('催单消息'),
                    'content'  => sprintf(L('用户于%s催单了(单号：%s，手机号：%s)'), date("Y-m-d H:i", __TIME), $order_id, $order['mobile'])
                );
                K::M('shop/msg')->create($a);
            }
            if($order['staff_id']){
                $a = array(
                    'staff_id' => $order['staff_id'],
                    'title'    => L('催单消息'),
                    'content'  => sprintf(L('用户于%s催单了(单号：%s，手机号：%s)'), date("Y-m-d H:i", __TIME), $order_id, $order['mobile'])
                );
                K::M('staff/msg')->create($a);
            }
            $this->msgbox->add('success');
        }
    }

    public function confirm($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if($order['order_status'] == 8){
            $this->msgbox->add('确认送达成功', 214);//订单已经确认,无需重复确认. 更改友好提示
        }
        else if(!in_array($order['order_status'], array(3, 4))){
            $this->msgbox->add(L('商家还未配送完成不可确认'), 215);
        }
        else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }
        else{
            $this->msgbox->add(L('订单确认完成失败'), 216);
        }
    }

    // 订单投诉
    public function complaint($params)
    {
        $this->check_login();
        if(!$order_id = (int) $params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }
        else if(!$order_detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'), 212);
        }
        else if($order_detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 213);
        }
        else if(!$title = $params['title']){
            $this->msgbox->add(L('投诉类型不能为空'), 214);
        }
        else if(!$content = $params['content']){
            $this->msgbox->add(L('投诉内容不能为空'), 214);
        }
        else{
            $data = array(
                'order_id' => $order_detail['order_id'],
                'uid'      => $this->uid,
                'shop_id'  => $order_detail['shop_id'],
                'staff_id' => $order_detail['staff_id'],
                'title'    => $title,
                'content'  => $content
            );
            if($complaint_id = K::M('order/complaint')->create($data)){
                $data2 = array(
                    'shop_id'  => $order_detail['shop_id'],
                    'title'    => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order_detail['contact'], $order_detail['order_id']),
                    'content'  => $content,
                    'is_read'  => 0,
                    'type'     => 3,
                    'order_id' => $order_detail['order_id'],
                );
                K::M('shop/msg')->create($data2);
                if($staff = $order_detail['staff_id']){
                    $data3 = array(
                        'staff_id' => $staff,
                        'title'    => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order_detail['contact'], $order_detail['order_id']),
                        'content'  => $content,
                        'is_read'  => 0,
                    );
                    K::M('staff/msg')->create($data3);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('complaint_id' => $complaint_id));
            }
        }
    }

}
