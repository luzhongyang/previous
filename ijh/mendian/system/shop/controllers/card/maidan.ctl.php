<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Maidan extends Ctl_Card
{

    public function index()
    {

        $this->pagedata['shop'] = K::M('shop/shop')->detail(SHOP_ID);
        $this->pagedata['url'] = $this->request['url'];
        if($this->card['grade_id']){
            $this->pagedata['grade'] = K::M('card/grade')->detail($this->card['grade_id']);
        }
        $this->tmpl = 'shop/card/maidan/index.html';
    }

    public function create()
    {
        if(($total_price = (float)$this->GP('total_price')) <= 0){
            $this->msgbox->add('付款金额不正确', 211);
        }else{
            $order_amount = $total_price;
            $order_youhui = $order_money = 0;
            if($grade = K::M('card/grade')->detail($this->card['grade_id'])){
                if($grade['shop_id'] == SHOP_ID){
                    if($grade['discount'] > 0 && $grade['discount'] < 10){
                        if(($order_amount = bcmul($total_price, bcdiv($grade['discount'], 10, 2), 2)) > 0){
                            $order_youhui = bcsub($total_price, $order_amount, 2);
                        }else{
                            $order_amount = $total_price;
                        }
                    }
                }
            }
            //使用会员卡余额
           if(!$code = $this->GP('code')){
               $this->msgbox->add('支付方式错误',223);
           } else if($code == 'money'){
               if(bccomp($this->card['money'], $order_amount, 2) >= 0){
                   $order_money = $order_amount;
                   $order_amount = 0;
               }else{
                   $this->msgbox->add(' 会员卡余额不足', 224)->response();
               }
           }
            $intro = $this->GP('intro');
            $order_data = array(
                    'shop_id'       => SHOP_ID,
                    'uid'           => $this->uid, 
                    'from'          => 'card',
                    'total_price'   => $total_price, 
                    'order_youhui'  => $order_youhui, 
                    'money'         => $order_money, 
                    'amount'        => $order_amount,
                    'pay_code'      => $code, 
                    'order_status'  => 0, 
                    'online_pay'    => 1, 
                    'pay_status'    => 0,
                    'wx_openid'     => $this->wx_openid,
                    'intro'          => $intro
                );
            if($order_id = K::M('order/order')->create($order_data)){
                $a = array('order_id'=>$order_id, 'card_id'=>$this->card['card_id'], 'type'=>'maidan','product_number'=>1, 'product_price'=>$total_price);
                K::M('cashier/order')->create($a);
                $b = array('order_id'=>$order_id, 'card_id'=>$this->card['card_id'], 'type'=>'maidan');
                K::M('card/order')->create($b);
                $product_title = sprintf('会员卡(%s)买单￥%s', $this->card['number'], $total_price);
                $product = array('order_id'=>$order_id, 'product_title'=>$product_title,'product_price'=>$total_price, 'product_number'=>1, 'amount'=>$total_price);
                K::M('cashier/order/product')->create($product);
                if(bccomp($order_money, 0, 2) > 0){
                    K::M('card/card')->update_money($this->card['card_id'], -$order_money, '会员卡余额支付订单('.$order_id.')', $order_id);
                    if(bccomp($order_amount, 0, 2) == 0){
                        $order = K::M('card/order')->detail($order_id);
                        if($trade = K::M('trade/payment')->order('money', $order)){
                            if(K::M('payment/log')->set_payed($trade['trade_no'], $trade['trade_no'])){
                                $log = K::M('payment/log')->log_by_no($trade['trade_no']);
                                K::M('order/order')->set_payed($log, $trade);
                            }
                        }
                    }
                }
                if(IN_WEIXIN){
                    $payment = 'wxjspay';
                } else {
                    $payment = 'alipay';
                }
                $rebackurl = $this->mklink('card/order/success',array('order_id'=>$order_id),null,$this->shop['url'],true);
                $paylink = $this->mklink("trade/payment:$payment",array('order_id'=>$order_id),array('rebackurl'=>$rebackurl),'www',true);
                $this->msgbox->set_data('data', array('order_id'=>$order_id, 'amount'=>$order_amount, 'code'=>$code,'payurl'=>$paylink,'rebackurl'=>$rebackurl));
            }
        }
    }
   
    


    
}
