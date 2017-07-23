<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Money extends Ctl_Card
{ 

    public function index()
    {
        $this->pagedata['money_pack'] = $this->shop['package_data'];
        $this->tmpl = 'shop/card/money/index.html';
    }

    public function chongzhi()
    {
        if(($money = (float)$this->GP('money')) <= 0){
            $this->msgbox->add('充值金额不正确', 211);
        }else if(!$code = $this->GP('code')){
            $this->msgbox->add('支付方式不正确', 212);
        }else if(!($card_id = (int)$this->card['card_id'])){
            $this->msgbox->add('未指定要充值的会员卡', 213);
        }else{
            $card = $this->card;
            $order_data = array('shop_id'=>SHOP_ID, 'uid'=>$card['uid'], 'amount'=>$money, 'from'=>'card', 'total_price'=>$money, 'online_pay'=>1);
            $order_data['wx_openid'] = $this->wx_openid;
            if($order_id = K::M('order/order')->create($order_data)){
                $a = array('order_id'=>$order_id, 'card_id'=>$card['card_id'], 'type'=>'chongzhi','product_number'=>1, 'product_price'=>$money);
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
                K::M('cashier/order')->create($a);
                $b = array('order_id'=>$order_id, 'card_id'=>$card_id, 'chongzhi_money'=>$money);
                K::M('card/order')->create($b);
                $product_title = sprintf('会员卡(%s)充值￥%s', $card['number'], $money);
                $product = array('order_id'=>$order_id,'product_id'=>0, 'product_title'=>$product_title,'product_price'=>$money, 'product_number'=>1, 'amount'=>$money);
                K::M('cashier/order/product')->create($product);
                $pay_order = array('order_id'=>$order_id, 'title'=>$product_title, 'wx_openid'=>$this->wx_openid, 'amount'=>$money);
                $this->msgbox->set_data('data', $pay_order);
            }
        }
    }
    
    
    public function recharge(){
        
        $this->tmpl = 'shop/card/money/recharge.html';
    }

    public function loaditems($page=1)
    {
        $filter = array('card_id'=>$this->card['card_id'],'type'=>'chongzhi');
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cashier/order')->items($filter,array('order_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        $order_ids = array();
        foreach($items as $k=>$v){
            $order_ids[$v['order_id']] = $v['order_id'];
        }
       
        if($order_ids){
            $filter['pay_status'] = 1;
            $filter['order_id'] = $order_ids;
            $order = K::M('order/order')->items($filter,null,$page,$limit,$count1);
        }
        $order_products = K::M('cashier/order/product')->items(array('order_id'=>$order_ids));

        foreach( $order as $k=>$v){
            foreach($order_products as $k1=>$v1){
                if($v['order_id'] == $v1['order_id']){
                    $order[$k]['title'] = $v1['product_title'];

                }
            }
        }
        

    
        //$this->pagedata['order_products'] = $order_products;
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['order'] =  $order;
        $this->tmpl = 'shop/card/money/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    
    public function xiaofei(){//消费记录
        
        $this->tmpl = 'shop/card/money/xiaofei.html';
    }

    public function loaddata($page=1)
    {
        $filter = array('card_id'=>$this->card['card_id'],'type'=>'chongzhi');
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cashier/order')->items($filter,array('order_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        $order_ids = array();
        foreach($items as $k=>$v){
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        if($order_ids){
            $this->pagedata['orders'] = K::M('order/order')->items_by_ids($order_ids);
        }
        $order_products = K::M('cashier/order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$v){
            foreach($order_products as $k1=>$v1){
                if($v['order_id'] == $v1['order_id']){
                    $items[$k]['title'] = $v1['product_title'];
                }
            }
        }
        
        $this->pagedata['order_products'] = $order_products;
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        //print_r($items);die;
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/money/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    
}
