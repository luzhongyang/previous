<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Coupon extends Ctl_Ucenter
{

    /**
     * 微店用户中心我的优惠券
     */
    public function index()
    {   
        $coupon_num = $this->GP('coupon_num');
        if($coupon_num){
            $this->pagedata['shop_id'] = $this->shop_id;
        }
        $this->pagedata['coupon_num'] = $coupon_num;
        $this->tmpl = 'weidian/ucenter/coupon/index.html';
    }
    
    /*单个商户优惠券列表--用户可领取*/
    public function shop_coupon($shop_id = null){
        $filter = $pager = array();
//        if($shop_id > 0){
//            $filter['shop_id'] = $shop_id;
//        }
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($money = $this->GP('money')){
            $filter['order_amount'] = '<=:' . $money;
        }

        $filter['sku'] = '>:0';
        $filter['ltime'] = '>:' . time();
        if($items = K::M('shop/coupon')->items($filter, array('coupon_amount' => 'desc'), null, null, $count)){
            foreach($items as $k => $v){
                $items[$k]['coupon_amount'] = $v['coupon_amount'];
                $items[$k]['order_amount'] = $v['order_amount'];
                $items[$k]['stime'] = date('Y-m-d', $v['stime']);
                $items[$k]['ltime'] = date('Y-m-d', $v['ltime']);
                $shop_ids[$k] = $v['shop_id'];
            }
            $shops = K::M('shop/shop')->items_by_ids($shop_ids);
            foreach($shop_ids as $k => $v){
                $items[$k]['logo'] = $shops[$v]['logo'];
                $items[$k]['shop_id'] = $shops[$v]['shop_id'];
                $items[$k]['shop_name'] = $shops[$v]['title'];
            }
        }

        //查找用户已经领取的列表
        $use_filter = array();
        $use_filter['uid'] = $this->uid;
        if($shop_id > 0){
            $use_filter['shop_id'] = $shop_id;
        }
        $user_coupon = K::M('member/coupon')->select($use_filter);
        $arr_user_coupon = array();
        foreach($user_coupon as $k => $v){
            $arr_user_coupon[] = $v['coupon_id'];
        }

        $this->pagedata['arr_user_coupon'] = $arr_user_coupon;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'weidian/ucenter/coupon/shop_coupon.html';
    }

    public function loaditems($page=1)
    {
        $filter = array('uid'=>$this->uid,'shop_id'=>$this->shop_id,'status'=>0,'ltime'=>'>:'.time());
        if($coupon_num = $this->GP('coupon_num')){
            $filter['order_amount'] = '<=:'.$coupon_num;
        }
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('member/coupon')->items($filter,array('cid'=>'desc'),$page, $limit, $count)){
            $items = array();
        }else{
            $shop_ids = array();
            foreach($items as $k => $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
            }
            if($shops = K::M('shop/shop')->items_by_ids($shop_ids)){
                foreach($items as $k => $v){
                    if($shops[$v['shop_id']]){
                        $items[$k]['shop'] = $shops[$v['shop_id']];
                    }else{
                        $items[$k]['shop'] = array();
                    }
                }
            }
        }
        $count_num = K::M('member/coupon')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'weidian/ucenter/coupon/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    //领取优惠券
    public function get_coupon(){
        
        $this->check_login();
        if(!$coupon_id = (int)$this->GP('coupon_id')){
            $this->msgbox->add('优惠券不存在!',211);
        }else if(!$coupon = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add('优惠券不存在!',212);
        }else if($coupon['sku'] < 1){
            $this->msgbox->add('优惠券领光了!',213);
        }else if($coupon['ltime'] < __TIME){
            $this->msgbox->add('优惠券已过期!',214);
        }else if(K::M('member/coupon')->find(array('coupon_id' => $coupon_id, 'uid' => $this->uid))){
            $this->msgbox->add('您已经领取过了', 206);
        }else{
            $data['coupon_id'] = $coupon_id;
            $data['uid'] = $this->uid;
            $data['use_time'] = 0;
            $data['order_id'] = 0;
            $data['status'] = 0;
            $data['order_amount'] = $coupon['order_amount'];
            $data['coupon_amount'] = $coupon['coupon_amount'];
            $data['ltime'] = $coupon['ltime'];
            $data['shop_id'] = $coupon['shop_id'];
            if(K::M('member/coupon')->create($data)){
                K::M('shop/coupon')->update_count($coupon_id, 'sku', -1);
                K::M('shop/coupon')->update_count($coupon_id, 'picked', 1);
                $this->msgbox->add('成功领取' . $coupon['coupon_amount'] . '元优惠券一张');
            }
        }
        
    }

}
