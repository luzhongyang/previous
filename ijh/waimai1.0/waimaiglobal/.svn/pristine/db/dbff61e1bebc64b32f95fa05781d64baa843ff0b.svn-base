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
        if(in_array($params['status'], array(0,1,2))){
            switch ($params['status']){
            case 2:
                $filter['order_status'] = array(-1,5,6,7,8);
                if(in_array($params['comment_status'], array(0,1))){
                   $filter['comment_status'] = $params['comment_status'];
                }
              break;
            case 1:
                $filter['order_status'] = array(0,1,2,3,4);
                break;
            }
        }
        if(in_array($params['pay_status'], array(0,1))){
            $filter['pay_status'] = $params['pay_status'];
        }
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($order_list = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $shop_ids = $staff_ids = array();
            foreach($order_list as $k=>$val){
                $staff_ids[$val['staff_id']] = $val['staff_id'];
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
          
            if($shop_list = K::M('shop/shop')->items_by_ids($shop_ids)){
                $shop_ids = array();
                foreach($shop_list as $k=>$v){
                    $v = $this->filter_fields('shop_id,title,phone,logo',$v);
                    $v['collect'] = 0;
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                    $shop_list[$k] = $v;
                }
            }
            $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);
            if($this->uid){
                if($collects = K::M('shop/collect')->items(array('uid'=>$this->uid,'shop_id'=>$shop_ids))){
                    foreach($collects as $k=>$v){
                        $shop_list[$v['shop_id']]['collect'] = 1;
                    }
                }
            }
            
            foreach($staff_list as $k=>$val){
                $staff_list[$k] = $this->filter_fields('staff_id,name,mobile,lng,lat',$val);
            }
            $items = array();
            $jifen = K::M('system/config')->get('jifen');

            foreach($order_list as $k=>$val){            
                $items[$k] = $this->filter_fields('order_id,city_id,shop_id,uid,product_price,package_price,comment_status,product_number,freight,money,amount,order_youhui,first_youhui,hongbao,hongbao_id,contact,mobile,addr,house,lat,lng,note,order_status,pay_status,pay_code,pay_time,staff_id,pei_type,dateline,order_status_label,total_order_price', $val);
                $items[$k]['jifen'] = (int)(($val['product_price'] + $val['package_price'])*$jifen['jifen_ratio']);
                if($shop_list[$val['shop_id']]){
                    $items[$k]['shop'] = array($shop_list[$val['shop_id']]);
                }else{
                    $items[$k]['shop'] = array();
                }
                if($staff_list[$val['staff_id']]){
                    $items[$k]['staff'] = $staff_list[$val['staff_id']];
                }else{
                    $items[$k]['staff'] = array('staff_id'=>0);
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'page'=>$page));
    }

    public function preinfo($params)
    {
        $this->check_login();
        if(!$shop_id = (int)$params['shop_id']){
            $this->msgbox->add(L('商家不存在'), 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'), 212);
        }else if(empty($shop['audit'])){
            $this->msgbox->add(L('商户审核中不可下单'),212);
        }else{
            $hongbao_id = $addr_id = $hongbao_count = 0;
            $hongbao = $addr = array();
            if($amount = (float)$params['amount']){
                $filter = array('uid'=>$this->uid,'min_amount'=>'<=:'.$amount,'ltime'=>'>=:'.__TIME,'order_id'=>0);
                if($hb_list = K::M('hongbao/hongbao')->items($filter, array('amount'=>'DESC'), 1, 1, $count)){
                    $hongbao = array_shift($hb_list);
                    $hongbao_id = $hongbao['hongbao_id'];
                    $hongbao_count = $count;
                }else{
                    $hongbao = array('hongbao_id'=>0, 'title'=>'', 'min_amount'=>'', 'amount'=>'','type'=>'', 'uid'=>'0', 'stime'=>'0', 'ltime'=>'','order_id'=>'0','used_time'=>'0','dateline'=>'');
                }
            }
            if($addr_id = (int)$params['addr_id']){
                if($addr = K::M('member/addr')->detail($addr_id)){
                    if($addr['uid'] != $this->uid){
                        $addr = array();
                    }
                }
            }
            if(!$addr){
                if($addr_list = K::M('member/addr')->items(array('uid'=>$this->uid), null, 1, 10)){
                    $pei_distance = $shop['pei_distance'] ? $shop['pei_distance'] : 5;
                    $point = K::M('helper/round')->returnSquarePoint($shop['lng']/1000000, $shop['lat']/1000000, $pei_distance);
                    foreach($addr_list as $v){
                        if(($v['lng']>$point['left-bottom']['lng']) && ($v['lng'] < $point['right-top']['lng'])){
                            if(($v['lat']>$point['left-bottom']['lat']) && ($v['lat']<$point['right-top']['lat'])){
                                $addr = $v;
                                $addr_id = $v['addr_id'];
                                break;
                            }
                        }
                    }
                }
            }else{
                $addr = array('addr_id'=>0, 'uid'=>'', 'contact'=>'', 'mobile'=>'', 'addr'=>'','house'=>'', 'is_default'=>'0', 'lat'=>'0', 'lng'=>'');
            }
            $addr = $this->filter_fields('addr_id,uid,contact,mobile,addr,house,is_default,lat,lng', $addr);
            $data = array('hongbao_id'=>$hongbao_id, 'hongbao_count'=>$hongbao_count, 'hongbao'=>$hongbao, 'addr_id'=>$addr_id, 'addr'=>$addr);
            $this->msgbox->set_data('data', $data);
        }
    }

    public function create($params)
    {
        $this->check_login();
        $pei_time = $pei_time_start = $pei_time_last = 0;
        if($params['pei_time']){
            if(preg_match('/^(\d{2}\:\d{2})(\-(\d{2}\:\d{2}))?$/i', $params['pei_time'], $m)){
                $pei_time_start = $m[1];
                $pei_time_last = $m[2];
                //$pei_time = $pei_time_start;
                $pei_time = $params['pei_time'];
            }
        }else{
            $pei_time = 0;
        }
        $note = $params['note'];
        $cur_time = (float)date("H.i", __TIME);
        if(!$shop_id = (int) $params['shop_id']){
            $this->msgbox->add(L('商家不存在'),221);
        }else if(!$shop_detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add(L('商家不存在或已被删除'),222);
        }else if($shop_detail['audit']!=1||$shop_detail['closed']!=0){
            $this->msgbox->add(L('商家不存在或已被删除'),223);
        }else{          
            $yy_stime = (float)str_replace(':', '.', $shop_detail['yy_stime']);
            $yy_ltime = (float)str_replace(':', '.', $shop_detail['yy_ltime']);
            $pei_stime = (float)str_replace(':', '.', $pei_time_start);
            if(empty($shop_detail['yy_status']) || ($cur_time < $yy_stime || $cur_time > $yy_ltime)){
                $this->msgbox->add(L('商家已经打烊不可下单'),223);
            }else if($pei_time && ($pei_stime < $yy_stime || $pei_stime > $yy_ltime)){
                $this->msgbox->add(L('配送时间不在商家营业范围'),223);
            }else if(!$products = $params['products']){
                $this->msgbox->add(L('您还没有订餐呢'),201);
            }else if(!$addr_id = (int)$params['addr_id']){
                $this->msgbox->add(L('请选择地址'),206);
            }else if(!$addr_detail = K::M('member/addr')->detail($addr_id)){
                $this->msgbox->add(L('地址不存在'),207);
            }else if(K::M('helper/round')->getdistances($addr_detail['lng'], $addr_detail['lat'], $shop_detail['lng'], $shop_detail['lat'])>$shop_detail['pei_distance']*1000){
                $this->msgbox->add(L('超出配送范围'),208);
            }else{
                $products = explode(',',$products);
                $product_ids = $product_numbers = $order_product_list = array();
                foreach ($products as $key => $val) {
                    $local = explode(':',$val);
                    $local[0] = (int) $local[0];
                    $local[1] = (int) $local[1];
                    if (!empty($local[0]) && !empty($local[1]) && $local[1] > 0) {
                        $product_ids[$local[0]] = $local[0];
                        $product_numbers[$local[0]] = $local[1];
                    }
                }
                $product_price = $package_price = $product_number = $hongbao_amount = $first_youhui = $youhui_amount = $pei_amount =  $money = $amount = 0;
                $freight = $shop_detail['freight'];
                $product_list = K::M('product/product')->items_by_ids($product_ids);
                foreach($product_list as $k=>$v){
                    if($v['shop_id'] != $shop_detail['shop_id']){
                        $this->msgbox->add(L('商品不是同一家商家的'),202)->response();
                    }else if($v['sale_type'] == 1 && (($v['sale_sku']-$v['sale_count']) < $product_numbers[$k])){
                        $this->msgbox->add(L('商品库存不足'),211)->response();
                    }else{
                        $_pamount = ($v['price'] + $v['package_price']) * $product_numbers[$k];
                        $order_product_list[$k] = array(
                            'product_id'=>$k,
                            'product_number'=>$product_numbers[$k],
                            'product_name'=>$v['title'],
                            'product_price'=>$v['price'],
                            'package_price'=>$v['package_price'],
                            'sale_type' => $v['sale_type'],
                            'amount'=> $_pamount
                        );
                        $product_number += $product_numbers[$k];
                        $product_price +=$v['price'] * $product_numbers[$k];
                        $package_price +=$v['package_price'] * $product_numbers[$k];
                    }
                }
                if($product_price < $shop_detail['min_amount']){
                    $this->msgbox->add(L('没有达到配送要求'),212)->json();
                }
                $data = array(
                    'shop_id' => $shop_id,
                    'city_id' => $shop_detail['city_id'],
                    'uid' => $this->uid,
                    'product_number' => $product_number,
                    'product_price' => $product_price,
                    'package_price' => $package_price,
                    'freight'=>$freight,
                    'amount' => $product_price+$package_price+$freight,
                    'contact' => $addr_detail['contact'],
                    'mobile' => $addr_detail['mobile'],
                    'addr' => $addr_detail['addr'],
                    'house' => $addr_detail['house'],
                    'lng' => $addr_detail['lng'],
                    'lat' => $addr_detail['lat'],
                    'online_pay' => 0,
                    'pei_time' => $pei_time,
                    'note' => $note,
                    'order_from'=>strtolower(CLIENT_OS)
                );

                $data['pei_type'] = $shop_detail['pei_type'];
                $data['pei_amount'] = $shop_detail['pei_amount'];
                if($params['online_pay']){
                    $data['online_pay'] = 1;
                    if($shop_detail['first_youhui'] && !$this->MEMBER['orders']){
                        $data['first_youhui'] = $first_youhui = $shop_detail['first_amount'];
                    }
                    if($youhui_detail = K::M('shop/youhui')->order_youhui($shop_id, $product_price-$first_youhui)){
                        $data['order_youhui'] = $youhui_amount = $youhui_detail['youhui_amount'];
                    }
                    if($hongbao_id = (int)$params['hongbao_id']){
                        if(!$hongbao_detail = K::M('hongbao/hongbao')->detail($hongbao_id)){
                            $this->msgbox->add(L('红包不存在'),203)->response();
                        }else if($hongbao_detail['uid'] != $this->uid){
                            $this->msgbox->add(L('红包信息不正确'),204)->response();
                        }else if($hongbao_detail['order_id']){
                            $this->msgbox->add(L('该红包已经使用'),205)->response();
                        }else if($hongbao_detail['ltime'] < __TIME){
                            $this->msgbox->add(L('红包已过期不能使用'),244)->response();
                        }else if($hongbao_detail['min_amount'] > ($product_price-$first_youhui-$youhui_amount)){
                            $this->msgbox->add(L('该红包不能使用'),205)->response();
                        }else{
                            $data['hongbao_id'] = $hongbao_id;
                            $data['hongbao_amount'] = $hongbao_amount = $hongbao_detail['amount'];
                        }
                    }
                    //if($shop_detail['pei_type']){
                        
                    //}
                    $data['amount'] = $amount = $product_price + $package_price + $freight - $youhui_amount - $first_youhui - $hongbao_amount;
                    if($this->MEMBER['money']>0 && ($passwd = $params['passwd'])){
                        if(md5($passwd) == $this->MEMBER['passwd']){
                            if($this->MEMBER['money'] >= $amount){
                                if(K::M('member/member')->update_money($this->uid, -$amount, L('订单抵扣金额'))){
                                    $data['money'] = $money = $amount;
                                    $data['amount'] = $amount = 0;
                                    $data['pay_status'] = 1;
                                    $data['pay_code'] = 'money';
                                    $data['pay_time'] = __TIME;
                                    $data['pay_ip'] = __IP;                                
                                }
                            }else if(K::M('member/member')->update_money($this->uid, -$money, L('订单抵扣金额'))){
                                $data['money'] = $money = $this->MEMBER['money'];
                                $data['amount'] = $amount = $amount - $money;
                            }
                        }else{
                            $this->msgbox->add(L('密码不正确'),255)->response();
                        }
                    }
                }else{
                    $data['pei_type'] = 0;
                    $data['pei_amount'] = 0;
                }

                if($data['amount'] == 0) {
                    $data['pay_status'] = 1;
                }

                if($order_id = K::M('order/order')->create($data)){
                    foreach ($order_product_list as $k=>$val){
                        $val['order_id'] = $order_id;
                        K::M('order/product')->create($val);
                        K::M('product/product')->update_count($val['product_id'], 'sales', $val['product_number']);
                        if($val['sale_type'] ==1){
                            K::M('product/product')->update_count($val['product_id'],'sale_count', $val['product_number']);
                        }
                    }
                    if($youhui_detail){
                        K::M('shop/youhui')->update_count($youhui_detail['youhui_id'],'use_count',1);
                    }
                    if($hongbao_detail){
                        K::M('hongbao/hongbao')->update($hongbao_id, array('order_id'=>$order_id,'used_time'=>__TIME,'used_ip'=>__IP));
                    }
                    K::M('shop/shop')->update_count($shop_id, 'orders', 1);
                    K::M('member/member')->update_count($this->uid, 'orders', 1);
                    K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>L('订单已提交成功'),'type'=>1));
                    if($data['pay_status']){
                        K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'payment','log'=>L('订单余额支付成功'),'type'=>2));
                    }
                    $this->msgbox->add('success');
                    $this->msgbox->set_data('data', array('order_id'=>$order_id, 'amount'=>$data['amount']));
                }else{
                    if($money){ //下单失败退回余额
                        K::M('member/member')->update_money($this->uid, $money, L('订单创建失败退回余额'));
                    }
                    $this->msgbox->add(L('创建订单失败'), 411);
                }
            }
        }
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else{
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array();
            }else{
                $shop = $this->filter_fields('shop_id,title,phone,logo,comments,yy_stime,yy_ltime,praise_num,score_fuwu,score_kouwei,info',$shop);
                $order['shop'] = $shop;
            }
            if(!$staff = K::M('staff/staff')->detail($order['staff_id'])){
               $order['staff'] = array('staff_id'=>0);               
            }else{
                $staff = $this->filter_fields('staff_id,name,mobile,lng,lat',$staff);
                $order['staff'] = $staff;
            }
            if(!$log_list = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'DESC'))){
                $log_list = array();
            }
            if(!$product_list = K::M('order/product')->items(array('order_id'=>$order_id))){
                $product_list = array();
            }
            if($complaint = K::M('order/complaint')->find(array('uid'=>$this->uid,'order_id'=>$order_id))){
               $order['complaint'] = 1; 
            }else{
               $order['complaint'] = 0; 
            }
            $logs = array();
            foreach($log_list as $k=>$val){
                $logs[$val['type']] = $val;
            }
            
            if($order['order_status'] >=1){
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
                }else if($order['order_status'] == -1){
                    $order['order_status_tips'] = L('订单已取消');
                }
            }else if($order['pay_status'] == 1){
                if($order['order_status'] == 0){
                    $order['order_status_tips'] = L('等待商家接单');
                }else if($order['order_status'] == 1 || $order['order_status'] == 3){
                    $order['order_status_tips'] = L('预计送达：尽快送达');
                }else if($order['order_status'] == 4 || $order['order_status'] == 8){
                    $order['order_status_tips'] = L('订单超过3小时自动完成');
                }else if($order['order_status'] == -1){
                    $order['order_status_tips'] = L('订单逾期未支付半小时自动取消');
                }
            }
            //订单进度 jindu
            $jindu = array('xiadan'=>array(), 'zhifu'=>array());

            $order['products'] = array_values($product_list);
            $order['logs'] = array_values($log_list);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('order'=>$order));
        }
    }


    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'),214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add(L('当前订单是不可取消的状态'),215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add(L('取消订单失败'), 216);            
        }
    }


    public function delete($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] != (-1) || $order['order_status'] != 8){
            $this->msgbox->add(L('订单为不可删除状态'),214);
        }else if(K::M('order/order')->delete($order_id)){
            $this->msgbox->add('success');
        }else{
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
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add(L('订单已完成可催单'),214);
        }else if(!in_array($order['order_status'], array(1, 2, 3, 4))){
            $this->msgbox->add(L('未接单不可催单'),214);
        }else if($order['cui_time']>(__TIME-900)){
            $this->msgbox->add(L('您已经催单了,请再耐心等等'),214);
        }else if(K::M('order/order')->update($order_id, array('cui_time'=>__TIME), true)){
            if($order['pei_type'] < 2 && $order['shop_id']){
                $a = array(
                    'shop_id'=>$order['shop_id'], 
                    'type'=>1, 
                    'order_id'=>$order_id,
                    'title'=>L('催单消息'), 
                    'content'=>sprintf(L('用户于%s催单了(单号：%s，手机号：%s)'), date("Y-m-d H:i", __TIME), $order_id, $order['mobile'])
                );
                K::M('shop/msg')->create($a);
            }
            if($order['staff_id']){
                $a = array(
                    'staff_id'=>$order['staff_id'], 
                    'title'=>L('催单消息'), 
                    'content'=>sprintf(L('用户于%s催单了(单号：%s，手机号：%s)'), date("Y-m-d H:i", __TIME), $order_id, $order['mobile'])
                );
                K::M('staff/msg')->create($a);
            }
            $this->msgbox->add('success');
        }     
    }

    public function confirm($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add(L('订单已经确认,无需重复确认'),214);
        }else if(!in_array($order['order_status'], array(3, 4))){
            $this->msgbox->add(L('商家还未配送完成不可确认'),215);
        }else if(K::M('order/order')->confirm($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add(L('订单确认完成失败'),216);
        }
    }

    // 订单投诉
    public function complaint($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order_detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order_detail['uid'] !=$this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!$title = $params['title']){
            $this->msgbox->add(L('投诉类型不能为空'),214);
        }else if(!$content = $params['content']){
            $this->msgbox->add(L('投诉内容不能为空'),214);
        }else{
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
                    'shop_id' => $order_detail['shop_id'],
                    'title'   => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order_detail['contact'], $order_detail['order_id']),
                    'content' => $content,
                    'is_read' => 0,
                    'type'    => 3,
                    'order_id'=> $order_detail['order_id'],
                    );
                K::M('shop/msg')->create($data2);
                if($staff = $order_detail['staff_id']) {
                    $data3 = array(
                        'staff_id'  => $staff,
                        'title'     => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order_detail['contact'], $order_detail['order_id']),
                        'content'   => $content,
                        'is_read'   => 0,
                        );
                    K::M('staff/msg')->create($data3);
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('complaint_id'=>$complaint_id));
            }
        }
    }
    
}
