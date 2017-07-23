<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Order extends Ctl_Ucenter {


    public function index($type,$page) 
    {
        $filter = array();
        $filter['uid'] = $this->uid;
        if($type == 1){
            $filter['order_status'] = array(0,1,3,4,5);
        }else if($type == 2){
            $filter['order_status'] = array(-1,-2,8);
        }
        $orders   = K::M('order/order')->items($filter,array('order_id'=>'desc'));
     
        $this->pagedata['orders'] = $orders;
        $this->tmpl = 'ucenter/order/items.html';
    }

    // 订单统一支付支付
    public function payment($order_id=null)
    {
        $this->check_login();
        if($order_id = (int)$order_id) {
            if($order = K::M('order/order')->detail($order_id)) {
                if(empty($order['order_status'])) {
                    if(defined('IN_WEIXIN')){
                        $this->pagedata['weixin'] = 1;
                    }
                    if($order['from'] == 'mall') {
                        $order['child']  = K::M('mall/order')->items(array('order_id'=>$order_id));
                        $order['link'] = $this->mklink('mall/order:detail', array($order_id));
                    }
                    if($order['from'] == 'waimai') {
                        $order['link'] = $this->mklink('waimai/order:detail', array($order_id));
                    }
                    if($order['from'] == 'paotui') {
                        $order['link'] = $this->mklink('paotui:order_detail', array($order_id));
                    }
                    $leftover_seconds = 1800 - ( __TIME - $order['dateline']);
                    if($order['from'] == 'pintuan') {
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
                        $order['link'] = $this->mklink('pintuan/tuan_detail', array($arr_p_order['pintuan_group_id']));
                    }
                    if($leftover_seconds <= 0) {
                        $this->pagedata['leftover_seconds'] = 0;
                    }else {
                        $this->pagedata['leftover_seconds'] = $leftover_seconds;
                    }
                    //检测支付方式是否开启
                    $payment_stripe = K::M('payment/payment')->payment('stripe');
                    $payment_wxpay = K::M('payment/payment')->payment('wxpay');
                    $payment_alipay = K::M('payment/payment')->payment('alipay');
                    $status = array(
                        'stripe' => $payment_stripe['status'],
                        'wxpay' => $payment_wxpay['status'],
                        'alipay' => $payment_alipay['status'],
                    );
                    $this->pagedata['status'] = $status;
                    $this->pagedata['order'] = $order;
                    $this->tmpl = 'ucenter/order/payment.html';
                }
            }
        }
    }
    
    public function detail($order_id=null){
        $this->check_login();
        if(!$order_id = (int)$order_id){
            $this->msgbox->add(L('订单号错误'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else{
            if($order['from'] == 'waimai'){
                header('Location:'.$this->mklink('waimai/order/detail',array($order_id)));
            }elseif($order['from'] == 'paotui'){
                header('Location:'.$this->mklink('paotui/order_detail',array($order_id)));
            }elseif($order['from'] == 'mall'){
                header('Location:'.$this->mklink('mall/order/detail',array($order_id)));
            }elseif($order['from'] == 'pintuan'){
                header('Location:'.$this->mklink('pintuan/tuan_order_detail',array($order_id)));
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
    
}
