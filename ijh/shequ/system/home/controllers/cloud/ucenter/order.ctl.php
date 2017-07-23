<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Order extends Ctl_Cloud_Ucenter {


    public function index()
    {
        $this->tmpl = 'cloud/ucenter/order/items.html';
    }
    
    
    public function loaditems($page=1){
        $status = (int)$this->GP('status');
        $filter['order_status'] = ">:-1";
        if($status == 2){
            $filter['order_status'] = 0;
            $filter['attr']['status'] = 0;
        }else{
            $filter['attr']['status'] = $status;
        }
        $filter['attr']['closed'] = 0;
        $filter['uid'] = $this->uid;
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cloud/order')->items_by_status($filter,array('dateline'=>'desc'), $page, $limit, $count)){
            $items = array();
        }
        $goods_ids = $attr_ids = $uids = array();
        foreach($items as $k=>$v){
            $items[$k]['cancel_url'] = $this->mklink('cloud/order:cancel',array($v['order_id']));
            $items[$k]['back_url'] = $this->mklink('cloud/ucenter/order');
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $attr_ids[$v['attr_id']] = $v['attr_id'];
            $uids[$v['win_uid']] = $v['win_uid'];
        }
        if($goods_ids){
            $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_ids);
        }
        if($attr_ids){
            $this->pagedata['attrs'] = K::M('cloud/attr')->items_by_ids($attr_ids);
        }
        if($uids){
            $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        }
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        //print_r($items);die;
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/order/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    

    
    public function detail($order_id){   
        if(!$order_id = (int)$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$detail = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法的订单操作'),213);
        }else{
            $goods = K::M('cloud/goods')->detail($detail['goods_id']);
            $goods['attr'] = K::M('cloud/attr')->detail($detail['attr_id']);            
            $this->pagedata['goods'] = $goods;
            $this->pagedata['detail'] = $detail;
            if($detail['order_status'] == 1){
                $this->pagedata['number_list'] = K::M('cloud/number')->items(array('order_id'=>$order_id), null, 1, 10000);
            }
            $this->tmpl = 'cloud/ucenter/order/detail.html';
        }
    }
    
    public function loaddata($page=1){
        
        $filter = array('closed'=>0);
        if(!$order_id = $this->GP('order_id')){
         $this->msgbox->add('该订单不存在',211)->response();
       }elseif(!$order = K::M('cloud/order')->detail($order_id)){
           $this->msgbox->add('该订单不存在',212)->response();
       }elseif($order['order_status'] != 1){
           $this->msgbox->add('该订单未支付',213)->response();
       }elseif($order['uid'] != $this->uid){
           $this->msgbox->add('非法操作订单',214)->response();
       }else{
           $filter['attr_id'] = $order['attr_id'];
           $filter['uid'] = $this->uid;
           $filter['order_id'] = $order_id;
       }
        $page = max((int)$page, 1);
        $limit = 80;
        if(!$items = K::M('cloud/number')->items($filter,null, $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('cloud/number')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/order/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    
    public function cancel($order_id){
        if(!$order_id = (int) $order_id){
            $this->msgbox->add('云购订单不存在',211);
        }elseif(!$order = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add('云购订单不存在',212);
        }elseif($order['order_status'] != 0){
            $this->msgbox->add('该订单已经取消',213);
        }else{
            if(K::M('cloud/order')->cancel($order_id)){
                $this->msgbox->add('订单取消成功');
            }else{
                $this->msgbox->add('订单取消失败',215);
            }
        }
    }
    
    
}
