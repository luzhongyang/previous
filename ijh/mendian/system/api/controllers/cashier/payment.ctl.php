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

class Ctl_Cashier_Payment extends Ctl_Cashier 
{
    
    
    public function order($params)
    {
        if(!($order_id = (int)$params['order_id'])){
            $this->msgbox->add('参数传递错误', 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('订单非法', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 214);
        }else if($order['pay_status'] == 1){
            $this->msgbox->add('该订单已经支付', 216);
        }else if($order['amount'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }else if(!$code = $params['code']){
            $this->msgbox->add('未选定支付方式', 221);
        }else if(!$data = K::M('trade/payment')->order($code, $order, 'APP')){
            $this->msgbox->add('创建支付请求失败', 223);
        }else{
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }
    }

    public function codepay($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数传递错误', 211);
        }else if(!in_array($params['code'], array('wxpay', 'alipay'))){
            $this->msgbox->add('支付方式错误', 212);
        }else if(!$auth_code = $params['auth_code']){
            $this->msgbox->add('支付码错误', 212);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成不可支付', 214);
        }else if($order['pay_status']){
            $this->msgbox->add('订单已经支付成功', 215);
        }else if($trade = K::M('trade/payment')->codepay($params['code'], $auth_code, $order, $msg)){
            $log = K::M('payment/log')->log_by_no($trade['trade_no']);
            if(K::M('order/order')->set_payed($log, $trade)){
                $this->msgbox->set_data('data', array('trade_detail'=>$trade));
            }else{
                $this->msgbox->add('支付失败');
            }
        }else{
            $this->msgbox->add($msg, 216);
        }
    }

    public function qrcodepay($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数传递错误', 211);
        }else if(!in_array($params['code'], array('wxpay', 'alipay'))){
            $this->msgbox->add('支付方式错误', 212);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成不可支付', 214);
        }else if($order['pay_status']){
            $this->msgbox->add('订单已经支付成功', 215);
        }else if($trade = K::M('trade/payment')->qrcodepay($params['code'], $order)){
            $this->msgbox->set_data('data', array('trade_detail'=>$trade));
        }else{
            $this->msgbox->add('创建支付二维码失败', 216);
        }
    }

    public function cashpay($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('无效的订单号', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('无效的订单号', 212);
        }else if($order['order_status'] < 0 || $order['order_status'] == 8){
            $this->msgbox->add('订单状态不可支付', 213);
        }else if($order['pay_status']){
            $this->msgbox->add('订单已经支付过了', 214);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 215);
        }else if(($shishou_amount = (float)$params['shishou_amount']) < $order['amount']){
            $this->msgbox->add('实收金额不能小于订单金额', 215);
        }else if($trade = K::M('trade/payment')->cashpay($order)){
            $log = K::M('payment/log')->log_by_no($trade['trade_no']);
            if(K::M('cashier/order')->set_payed($log, $trade)){
                $zhaoling_amount = $shishou_amount - $order['amount'];
                if($zhaoling_amount || $shishou_amount){
                    K::M('cashier/order')->update($order_id, array('shishou_amount'=>$shishou_amount, 'zhaoling_amount'=>$zhaoling_amount));
                }
                $this->msgbox->set_data('data', array('trade_detail'=>$trade));
            }
        }
    }
}