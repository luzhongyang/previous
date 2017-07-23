<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Fenxiao extends Ctl
{

    public $status = array(0);
    
    /**
     * 分销店铺列表
     */
    public function index(){
        
        $filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 20;
        if($items = K::M('fenxiao/fenxiao')->items($filter, null, $page, $limit, $count)){
            $shop_ids = $uids = array();
            foreach($items as $k => $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $shops = K::M('shop/shop')->items_by_ids($shop_ids);
            $members = K::M('member/member')->items_by_ids($uids);
            foreach($items as $k => $v){
                $items[$k]['shop'] = $shops[$v['shop_id']];
                $items[$k]['member'] = $members[$v['uid']];
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weidian/fenxiao/index.html';
        
    }

    public function order($page)
    {   
        $filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 20;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
        }
        $filter['type'] = 'fenxiao';
        if($items = K::M('weidian/order')->items($filter, null, $page, $limit, $count)){
            $order_ids = array();
            foreach($items as $k => $v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            $orders = K::M('order/order')->items_by_ids($order_ids);
            $order_products = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
            
            $porders = K::M('weidian/pintuan/order')->items_by_ids($order_ids);
            
            foreach($items as $k => $v){
                foreach($order_products as $k1=>$v1){
                    if($v['order_id'] == $v1['order_id']){
                        $items[$k]['products'][] = $v1;
                    }
                }
                $items[$k]['order'] = $orders[$v['order_id']];
            }
            foreach($porders as $k => $v){
                $items[$k]['porder'] = $porders[$v['order_id']];
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weidian/fenxiao/order.html';
       
    }


    public function so()
    {
        $this->tmpl = 'admin:weidian/fenxiao/so.html';
    }

    public function set_status($sid,$status){
        if(!$sid = (int)$sid){
            $this->msgbox->add('没有指定店铺!', 211);
        }else if(!in_array($status, array(1,2))){
            $this->msgbox->add('状态错误!', 212);
        }else if(!$fenxiao = K::M('fenxiao/fenxiao')->detail($sid)){
            $this->msgbox->add('店铺不存在!', 213);
        }else{
            if(K::M('fenxiao/fenxiao')->update($sid, array('status'=>$status))){
                $this->msgbox->add('设置成功!');
            }else{
                $this->msgbox->add('设置失败!',300);
            }
            
        }
    }
    
    
    public function detail($sid = null)
    {
        if(!$sid = (int)$sid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('fenxiao/fenxiao')->detail($sid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            if($detail['p_sid']){
                $detail['parent'] = K::M('fenxiao/fenxiao')->detail($detail['p_sid']);
            }
            $detail['member'] = K::M('member/member')->detail($detail['uid']);
            $detail['account'] = K::M('fenxiao/account')->find(array('uid'=>$detail['uid']));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weidian/fenxiao/detail.html';
        }
    }

    
}
