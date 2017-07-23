<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
class Ctl_Trade_Payment extends Ctl
{

    public function maidan()
    {


        if ($amount = $this->checksubmit('amount')) {
            if (($amount = (float)$amount) <= 0) {
                $this->msgbox->add('订单金额不正确', 211);
            } else {
                $order_data = array('shop_id' => SHOP_ID, 'amount' => $amount, 'total_price' => $amount, 'from' => 'cashier', 'online_pay' => 1);
                if (defined("IN_WEIXIN")) {
                    $order_data['pay_code'] = 'wxpay';
                    $order_data['wx_openid'] = $this->wx_openid;
                } else {
                    $order_data['pay_code'] = 'alipay';
                }
                if ($order_id = K::M('order/order')->create($order_data)) {
                    $cashier_data = array('order_id' => $order_id, 'type' => 'maidan', 'product_number' => 1, 'product_price' => $amount);
                    K::M('cashier/order')->create($cashier_data);
                    $product_data = array('order_id' => $order_id, 'product_title' => '台卡买单', 'product_price' => $amount, 'amount' => $amount,'product_number'=>1);
                    K::M('cashier/order/product')->create($product_data);
                   $arr = $this->request;
                   $rebackurl =$arr['url'].'/trade/payment/success-'.$order_id.".html";
                    if($order_data['pay_code'] == 'wxpay'){
                       $link= $this->mklink('trade/payment:wxjspay', array($order_id),array('rebackurl'=>$rebackurl),'www',true);
                    } elseif($order_data['pay_code'] == 'alipay'){
                        $link= $this->mklink('trade/payment:order', array('alipay',$order_id),array('rebackurl'=>$rebackurl),'www');
                    }
                    $this->msgbox->set_data('data',array('url'=>$link));
                   

                }
            }

        } else {
           $this->pagedata['url'] = $this->request['url'];
            $this->pagedata['shopinfo'] = $this->shop;
            $this->tmpl = 'shop/trade/maidan.html';
        }
    }

    public function success($order_id){
        if(!$order_id){
            $this->msgbox->add('订单不存在',212);
        }elseif(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',213);
        }else if($order['pay_status']!=1) {
            $this->msgbox->add('订单支付失败',214);
        } else {
            $order['day'] = date('Y-m-d',strtotime($order['day']));
            $this->pagedata['order']=$order;
            $this->tmpl='shop/trade/success.html';
        }
        $this->msgbox->set_data('forward',$this->mklink('trade/payment:maidan',null,null,$this->request['url']));

    }
}






