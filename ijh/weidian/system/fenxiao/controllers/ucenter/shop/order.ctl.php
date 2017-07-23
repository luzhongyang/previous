<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Order extends Ctl_Ucenter_Shop
{

    /**
     * 我的推广订单
     */
    public function index(){
        //$this->pagedata['']
        if($st = (int)$this->GP('st')){
            $this->pagedata['st'] = $st;
        }
        $this->tmpl = 'fenxiao/ucenter/shop/order/index.html';
        
    }
    
    public function loaditems($page=1)
    {
        $filter = array();
        $filter['weidian'][':OR'] = array('invite1'=>$this->uid,'invite2'=>$this->uid,'invite3'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        //$filter['weidian']['sid'] = FX_SID;
        $page = max((int)$page, 1);
        $limit = 10;
        if($st = (int)$this->GP('st')){
            switch($st){
                case 3:
                $filter['order_status'] = -1;
                break;
                case 2:
                $filter['order_status'] = 8;
                break;
                case 1:
                $filter['order_status'] = array(0,1,2,3,4); 
                break;
            }
        }
        if(!$items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        //print_r($this->system->db->SQLLOG());die;
        $order_ids = $sids = array();
        foreach($items as $k=>$v){
            if($v['invite1'] == $this->uid){
                $items[$k]['profit'] = $v['amount_1'];
                $items[$k]['level'] = 0;
            }elseif($v['invite2'] == $this->uid){
                $items[$k]['profit'] = $v['amount_2'];
                $items[$k]['level'] = 1;
            }elseif($v['invite3'] == $this->uid){
                $items[$k]['profit'] = $v['amount_3'];
                $items[$k]['level'] = 2;
            }
            $sids[$v['sid']] = $v['sid']; 
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $this->pagedata['fenxiao_shops'] = K::M('fenxiao/fenxiao')->items_by_ids($sids);
        $order_products = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
        $product_ids =  array();
        foreach($items as $k=>$v){
            foreach($order_products as $k1=>$v1){
                if($v['order_id'] == $v1['order_id']){
                    $product_ids[$v1['product_id']] = $v1['product_id'];
                    $items[$k]['products'][] = $v1;
                }
            }
        }
        if($product_ids){
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
        }
        //print_r($items);die;
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'fenxiao/ucenter/shop/order/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

    public function detail($order_id){
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }elseif(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }elseif($order['invite1'] != $this->uid &&$order['invite2'] != $this->uid&&$order['invite3'] != $this->uid){
            $this->msgbox->add('订单不合法!',213);
        }else{
            if($order['invite1'] == $this->uid){
                $order['profit'] = $order['amount_1'];
            }elseif($order['invite2'] == $this->uid){
                $order['profit'] = $order['amount_2'];
            }elseif($order['invite3'] == $this->uid){
                $order['profit'] = $order['amount_3'];
            }
            $orderproducts = K::M('weidian/orderproduct')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($orderproducts as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            $log = K::M('payment/log')->find(array('order_id'=>$order_id));
            $this->pagedata['log'] = $log;
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
            $this->pagedata['orderproducts'] = $orderproducts;
            $this->pagedata['order'] = $order;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
            $this->tmpl = 'fenxiao/ucenter/shop/order/detail.html';
        }
    }
    

}


