<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Order extends Ctl_Card
{ 
    public function index(){//消费记录
        
        $this->tmpl = 'shop/card/order/index.html';
    }

    public function loaddata($page=1)
    {
        $filter = array('card_id'=>$this->card['card_id'],'type'=>'order');
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('card/log')->items($filter,array('order_id'=>'desc'), $page, $limit, $count)){
            $items = array();
        }
        $count_num = $count;
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'shop/card/order/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    public function detail($order_id,$from=0){
        //print_r($this->uid);die;
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在', 211);
        }elseif(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }elseif($order['type'] == "chongzhi"){
            $this->msgbox->add('订单类型不正确', 213);
        }elseif(!$_order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 214);
        }elseif($_order['uid'] != $this->uid){
            $this->msgbox->add('非法的订单操作', 215);
        }else{
            //$_order = K::M('order/order')->detail($order_id);
            $order_product = K::M('cashier/order/product')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($order_product as $k=>$v){
                $product_ids[$v['prodcut_id']] = $v['product_id'];
            }
            if($product_ids){
                $this->pagedata['products'] = K::M('cashier/product')->items_by_ids($product_ids);
            }
            if($order['staff_id']){
                $this->pagedata['staff'] = K::M('cashier/staff')->detail($order['staff_id']);
            }
            $this->pagedata['order_product'] = $order_product;
            $this->pagedata['_order'] = $_order;
            $this->pagedata['is_from_success'] = $from;
            $this->pagedata['order'] = $order;
            $this->tmpl = 'shop/card/order/detail.html';
          
        }
        $this->msgbox->set_data('forward',$this->mklink('/card/order/index',$this->request['url']));
    }
    
    public function refund($order_id){
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在', 211);
        }elseif(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }elseif($order['type'] == "chongzhi"){
            $this->msgbox->add('订单类型不正确', 213);
        }elseif(!$_order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 214);
        }elseif($_order['uid'] != $this->uid){
            $this->msgbox->add('非法的订单操作', 215);
        }else if(!$order['refund_id']){
            $this->msgbox->add('改订单未退款', 220);

        }
        else{
            //$_order = K::M('order/order')->detail($order_id);
            $order_product = K::M('cashier/order/product')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($order_product as $k=>$v){
                $product_ids[$v['prodcut_id']] = $v['product_id'];
            }
            if($product_ids){
                $this->pagedata['products'] = K::M('cashier/product')->items_by_ids($product_ids);
            }
            if($order['staff_id']){
                $this->pagedata['staff'] = K::M('cashier/staff')->detail($order['staff_id']);
            }
            $this->pagedata['order_product'] = $order_product;
            $this->pagedata['_order'] = $_order;
            $this->pagedata['order'] = $order;
            $this->pagedata['back_code']= K::M('cashier/log')->detail($order['refund_id']);
            $this->tmpl = 'shop/card/order/refund.html';
        }
        $this->msgbox->set_data('forward',$this->mklink('/card/order/index',$this->request['url']));
    }
    
    

    public function success($order_id){
        if(!$order_id){
            $this->msgbox->add('订单不存在！',216);
        } else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在！',217);
        } else if($order['pay_status']!=1 ){
            $this->msgbox->add('订单支付失败',218);
        }else if(!$cashier = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单不存在！',219);
        } else if($cashier['refund_id']) {
            $link = $this->mklink('card/order/refund',array($order_id),array(),$this->shop['url'],true);
            header("Location:$link");
            exit;

        } else  {
           $order['total_price'] = (float)$order['money']+(float)$order['amount'];
            $this->pagedata['order'] = $order;
            $this->tmpl = 'shop/card/order/success.html';

        }
        $this->msgbox->set_data('forward', $this->mklink('card/maidan:index', null, null, $this->shop['url']));
        
    }



    
}
