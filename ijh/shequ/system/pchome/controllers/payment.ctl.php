<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Payment extends Ctl
{
    
    /*微信支付定时请求支付状态接口*/
    public function get_order_status(){
        if(!$trade_no = (int)$this->GP('trade_no')){
            $this->msgbox->add('订单错误',211);
        }else if(!$order = K::M('payment/log')->find(array('trade_no'=>$trade_no),array('log_id'=>'desc'))){
            $this->msgbox->add('订单错误',212);
        }else if($order['payed'] == 1){
            $this->msgbox->add('已支付');
        }else{
            $this->msgbox->add('未支付',213);
        }
    }
    
    
    /*通用订单支付页面*/
    public function pay($order_id)
    {
        K::M('system/session')->start();
        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('订单不存在!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($order['pay_status']){
               $this->msgbox->add('该订单已支付!',213);
               if($order['from'] == 'weidian'){
                    if($detail = K::M('weidian/order')->detail($order_id)){
                        if($detail['type'] == 'default'){
                            $this->msgbox->set_data("forward", $this->mklink('weidian/product'));
                        }else{
                            $this->msgbox->set_data("forward", $this->mklink('weidian/ucenter/pintuan'));
                        }
                    }
                }
        }else{
            if($order['from'] == 'weidian'){
                $worder = K::M('weidian/order')->detail($order['order_id']);
                if($worder['type'] == 'pintuan'){
                    
                    $arr_p_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id));
     
                        if(1 == $arr_p_order['is_money_pre']){
                            if(0 == $arr_p_order['money_paid']){
                                //1.预付款
                                $order['amount'] = $arr_p_order['money_need_pay'];
                            } 
                            else if($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                                //2.付尾款
                                $order['is_weikuan'] = 1;//拼图付尾款标记
                                $order['amount'] = abs($arr_p_order['product_price']*$arr_p_order['product_number'] - $arr_p_order['money_paid']);
                            }
                            else{
                                //3.付尾款 多次付款兼容
                                $order['is_weikuan'] = 1;//拼图付尾款标记
                                $order['amount'] = abs($arr_p_order['product_price']*$arr_p_order['product_number'] - $arr_p_order['money_paid']);
                            }
                        }
                        $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $arr_p_order['group_id']));
                        $leftover_seconds = $arr_group['end_time'] - __TIME;
                        $order['link'] = $this->mklink('pintuan/tuan_detail', array($arr_p_order['group_id']));

                    $this->pagedata['pintuan'] = 1;
                    $this->pagedata['group_id'] = $arr_p_order['group_id'];

                }
            }
            if(defined('IN_WEIXIN')){
                $this->pagedata['weixin'] = 1;
            }
            $this->pagedata['order'] = $order;
            $payment_amount = $youhui_amount = $total_price = 0;
            $payment_amount = K::M("{$order['from']}/order")->get_payment_amount($order_id, $payment_level);
            $total_price = $payment_amount;
            if($payment_level){
                if($order['total_price'] > $payment_amount){
                    $total_price = $order['total_price'];
                    $youhui_amount = $total_price - $payment_amount;
                }
            }
            if($youhui_amount&&$payment_level==1){
                $str = "已支付";
            }else{
                $str = "优惠";
            }
            $pager = array('payment_amount'=>$payment_amount, 'youhui_amount'=>$youhui_amount, 'total_price'=>$total_price, 'payment_level'=>$payment_level,'payment_str'=>$str);
            $this->pagedata['pager'] = $pager;
            //print_r($order);die;
            $this->pagedata['order'] = $order;
            $this->tmpl = 'pchome/payment/pay.html';
        }
    }
    
    
}