<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Card extends Ctl_Cashier
{

    public function items($params)
    {
        $items = array();
        $filter = array('shop_id'=>$this->shop_id,'closed'=>0);
        if(!empty($params['kw'])){
            $kw = $params['kw'];
            if(is_numeric($kw)){
                $filter[':OR'] = array('mobile'=>'LIKE:'.$kw.'%', 'number'=>'LIKE:'.$kw.'%');
            }else{
                $filter['name'] = 'LIKE:%'.$kw.'%';
            }
        }
        if($month = (int)$params['month']){// 月份
            $filter['M'] = $month;
        }
        if($grade_id = (int)$params['grade_id']){// 会员等级
            $filter['grade_id'] = $grade_id;
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('card/card')->items($filter, null, $page, $limit, $count)){
            $grade_list = K::M('card/grade')->items_by_shop_id($this->shop_id);
            foreach($items as $k=>$v){
                if($grade = $grade_list[$v['grade_id']]){
                    $v['grade_detail'] = $grade;
                }else{
                    $v['grade_detail'] = array('grade_id'=>0, 'title'=>'','need_money'=>'','discount'=>10,'icon'=>'default/card/VIP-v1.png');
                }
                $items[$k] = $v;
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    //uid,card
    public function detail($params)
    {
        if($card_id = (int)$params['card_id']){
            $card = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'card_id'=>$card_id));
        }else if($uid = (int)$params['uid']){
            $card = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'uid'=>$uid));
        }else if($mobile = K::M('verify/check')->mobile($params['mobile'])){
            $card = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'mobile'=>$mobile));
        }else if($number = $params['number']){
            $card = K::M('card/card')->find(array('shop_id'=>$this->shop_id, 'number'=>$number));
        }
        if(empty($card)){
            $this->msgbox->add('会员卡不存在', 211);
        }else{
            $grade_list = K::M('card/grade')->items_by_shop_id($this->shop_id);
            if(!$grade = $grade_list[$card['grade_id']]){
                $grade = array('grade_id'=>0, 'shop_id'=>$this->shop_id, 'title'=>'默认', 'need_jifen'=>0, 'discount'=>100, 'icon'=>'default/card/VIP-v1.png', 'orderby'=>50);
            }
            $card['grade_detail'] = $grade;
            $card['jifen_log'] = $card['money_log'] = $card['order_log'] = $card['chongzhi_log'] = array();
            if($logs = K::M('card/log')->items(array('card_id'=>$card_id, 'type'=>'jifen'), array('log_id'=>'DESC'), 1, 10)){
                $card['jifen_log'] = array_values($logs);
            }
            if($logs = K::M('card/log')->items(array('card_id'=>$card_id, 'type'=>'money'), array('log_id'=>'DESC'), 1, 10)){
                $card['money_log'] = array_values($logs);
            }
            if($logs = K::M('card/log')->items(array('card_id'=>$card_id, 'type'=>'chongzhi'), array('log_id'=>'DESC'), 1, 10)){
                $card['chongzhi_log'] = array_values($logs);
            }
            if($logs = K::M('card/log')->items(array('card_id'=>$card_id, 'type'=>'order'), array('log_id'=>'DESC'), 1, 10)){
                $card['order_log'] = array_values($logs);
            }
            $this->msgbox->set_data('data', array('card_detail'=>$card));
        }
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'name,mobile,grade_id,number,Y,M,D')){
            $this->msgbox->add('请求参数错误', 211);
        }else if(!$grade_id = (int)$data['grade_id']){
            $this->msgbox->add('会员卡类型未设置', 212);
        }else if(!$grade = K::M('card/grade')->detail($grade_id)){
            $this->msgbox->add('会员卡类型未设置', 213);
        }else if($grade['shop_id'] != $this->shop_id){
            $this->msgbox->add('会员卡类型未设置', 214);
        }else{
            $data['shop_id'] = $this->shop_id;
            $data['staff_id'] = $this->staff_id;
            if($card_id = K::M('card/card')->create($data)){
                $this->msgbox->set_data('data', array('card_id'=>$card_id));
            }
        }

    }

    public function edit($params)
    {
        if(!$card_id = (int)$params['card_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员卡不存在', 212);
        }else if($card['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法的数据操作', 213);
        }else if(!$data = $this->check_fields($params, 'name,mobile,grade_id,number,Y,M,D')){
            $this->msgbox->add('非法的数据操作', 213);
        }else{
            if($this->staff['is_owner']){
                if(($grade_id = (int)$params['grade_id']) && ($grade = K::M('card/grade')->detail($grade_id))){
                    if($grade['shop_id'] == $this->shop_id){
                        $data['grade_id'] = $grade_id;
                    }
                }
            }
            if(K::M('card/card')->update($card_id, $data)){
                $this->msgbox->set_data('data', array('card_id'=>$card_id));
            }
        }
    }

    public function log($params)
    {
        if(!$card_id = (int)$params['card_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员卡不存在或已经删除', 212);
        }else if($card['shop_id'] != $this->shop_id){
            $this->msgbox->add('会员卡不存在或已经删除',213);
        }else{
            $page = max((int)$params['page'], 1);
            $limit = 10;
            $type = in_array($params['type'], array('money', 'chongzhi', 'jifen','order')) ? $params['type'] : 'money';
            $filter = array('type'=>$type, 'card_id'=>$card['card_id']);
            if(!$items = K::M('card/log')->items($filter, null, $page, $limit, $count)){
                $items = array();
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }


    public function package($params)
    {
        $this->msgbox->set_data('data', array('package_data'=>array_values($this->shop['package_data'])));
    }

    public function chongzhi($params)
    {
        if(($money = (float)$params['money']) <= 0){
            $this->msgbox->add('充值金额不正确', 211);
        }else if(!$card_id = (int)$params['card_id']){
            $this->msgbox->add('未指定要充值的会员卡', 212);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员卡不存在', 212);
        }else{
            $order_data = array('shop_id'=>$this->shop_id, 'staff_id'=>$this->staff_id, 'uid'=>$card['uid'], 'from'=>'card', 'amount'=>$money, 'total_price'=>$money);
            if($order_id = K::M('order/order')->create($order_data)){
                //同一订单在card_order,cashier_order订单表中都有记录，方便业务处理
                $card_order = array('order_id'=>$order_id, 'card_id'=>$card['card_id'], 'chongzhi_money'=>$money);
                $give_money = $give_jifen = 0;
                if($this->shop['package_data']){
                    $_total_price = (int)$money;
                    foreach($this->shop['package_data'] as $v){
                        if((int)$v['money'] == $_total_price){
                            $give_money = $v['give'];
                            $give_jifen = $v['jifen'];
                            break;
                        }
                    }
                }
                $card_order['give_money'] = $give_money;
                $card_order['give_jifen'] = $give_jifen;
                K::M('card/order')->create($card_order);
                $cashier_order = array('order_id'=>$order_id, 'card_id'=>$card['card_id'], 'type'=>'chongzhi','product_number'=>1, 'product_price'=>$money);
                K::M('cashier/order')->create($cashier_order); //向收银表插入记录
                $product_title = sprintf('会员卡(%s)充值￥%s', $card['number'], $money);
                $product = array('order_id'=>$order_id,'product_id'=>0, 'product_title'=>$product_title,'product_price'=>$money, 'product_number'=>1, 'amount'=>$money);
                K::M('cashier/order/product')->create($product);
                $this->msgbox->set_data('order', array('order_id'=>$order_id));
            }
        }
    }

    //充值LOG
    public function czlog($params)
    {
        $filter = array('type'=>'chongzhi');
        if($this->staff['is_owner']){
            $filter['shop_id'] = $this->shop_id;
        }else{
            $filter['staff_id'] = $this->staff_id;
        }
        if(in_array($params['code'], array('cash','wxpay','alipay'))){
            $filter['pay_code'] = $params['code'];
        }else if(in_array($params['type'], array('cash','wxpay','alipay'))){ //兼容旧参数
            $filter['pay_code'] = $params['type'];
        }
        if($oid = (int)$params['order_id']){
            $filter['order_id'] = "LIKE:%{$oid}%";
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('cashier/log')->items($filter, null, $page, $limit, $count)){
            $order_ids = $staff_ids = array();
            foreach($items as $k=>$v){
                if($order_id = $v['order_id']){
                    $order_ids[$order_id] = $order_id;
                }
                if($staff_id = $v['staff_id']){
                    $staff_ids[$staff_id] = $staff_id;
                }
                $v['card_detail'] = array('card_id'=>0, 'name'=>'', 'mobile'=>'', 'number'=>'');
                $v['staff_detail'] = array('staff_id'=>0, 'name'=>'', 'mobile'=>'');
                $items[$k] = $v;
            }
            if($order_list = K::M('card/order')->items_by_ids($order_ids)){
                $card_ids = array();
                foreach($order_list as $v){
                    if($card_id = $v['card_id']){
                        $card_ids[$card_id] = $card_id;
                    }
                }
                if($card_list = K::M('card/card')->items_by_ids($card_ids)){
                    $card_order_list = array();
                    foreach($card_list as $v){
                        $card_order_list[$v['order_id']] = $v;
                    }
                    $staff_list = K::M('cashier/staff')->items_by_ids($staff_ids);
                    foreach($items as $k=>$v){
                        if($card = $card_order_list[$v['card_id']]){
                            $v['card_detail'] = array('card_id'=>$card['card_id'], 'name'=>$card['name'], 'mobile'=>$card['mobile']);
                        }
                        if($staff = $staff_list[$v['staff_id']]){
                            $v['staff_detail'] = array('staff_id'=>$staff['staff_id'], 'name'=>$staff['name'], 'mobile'=>$staff['name']);
                        }
                        $items[$k] = $v;
                    }
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'totao_count'=>$count));
    }
}
