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
    // 优惠券列表
    public function index($page = 1)
    {
        $filter = $pager = array();
        $filter = array(
            'uid' => $this->uid,
            'use_time' => 0,
            'order_id' => 0,
            'status' => 0,
            'ltime' => '>:' . __TIME
        );
        if($items = K::M('member/coupon')->items($filter, array('dateline' => 'desc'))){
            foreach($items as $k => $v){
                if($v['order_id']) {
                    unset($items[$k]);
                }
                $items[$k]['dateline'] = date('Y-m-d', $v['dateline']);
                $coupon_ids[$v['coupon_id']] = $v['coupon_id'];
            }
        }
        $this->pagedata['items'] = $items;
        $coupons = K::M('shop/coupon')->items_by_ids($coupon_ids);
        foreach($coupons as $k => $v){
            $coupons[$k]['stimef'] = date('Y-m-d', $v['stime']);
            $coupons[$k]['ltimef'] = date('Y-m-d', $v['ltime']);
            $coupons[$k]['coupon_amount'] = round($v['coupon_amount']);
            $coupons[$k]['order_amount'] = round($v['order_amount']);
            $shop_ids[$k] = $v['shop_id'];
        }
        $shops = K::M('shop/shop')->items_by_ids($shop_ids);
        foreach($shop_ids as $k => $v){
            $coupons[$k]['logo'] = $shops[$v]['logo'];
            $coupons[$k]['shop_name'] = $shops[$v]['title'];
        }
        $this->pagedata['coupons'] = $coupons;
        $this->tmpl = 'ucenter/coupon/index.html';
    }


    //外卖下单时选择优惠券
    public function lists($shop_id = null, $money = null)
    {
        $filter = $pager = array();
        $filter = array(
            'uid' => $this->uid,
            'use_time' => 0,
            'order_id' => 0,
            'status' => 0,
            'ltime' => '>:' . __TIME,
            'order_amount'=>'<=:' . $money
        );
        if($items = K::M('member/coupon')->items($filter, array('dateline' => 'desc'))){
            foreach($items as $k => $v){
                $coupon = K::M('shop/coupon')->detail($v['coupon_id']);
                if($coupon['shop_id'] <> $shop_id || $coupon['ltime'] < time() || round($v['coupon_amount']) > $money){
                    unset($items[$k]);
                }else{
                    $items[$k]['dateline'] = date('Y-m-d', $v['dateline']);
                    $coupon_ids[$v['coupon_id']] = $v['coupon_id'];
                }
            }
        }
        $this->pagedata['items'] = $items;
        $coupons = K::M('shop/coupon')->items_by_ids($coupon_ids);
        foreach($coupons as $k => $v){
            $coupons[$k]['stimef'] = date('Y-m-d', $v['stime']);
            $coupons[$k]['ltimef'] = date('Y-m-d', $v['ltime']);
            $coupons[$k]['coupon_amount'] = round($v['coupon_amount']);
            $coupons[$k]['order_amount'] = round($v['order_amount']);
            $shop_ids[$k] = $v['shop_id'];
        }
        $shops = K::M('shop/shop')->items_by_ids($shop_ids);
        foreach($shop_ids as $k => $v){
            $coupons[$k]['logo'] = $shops[$v]['logo'];
            $coupons[$k]['shop_name'] = $shops[$v]['title'];
        }
        $this->pagedata['coupons'] = $coupons;
        if($shop_id > 0){
            $this->pagedata['shop_id'] = $shop_id;
        }
        $this->tmpl = 'ucenter/coupon/lists.html';
    }

    public function receive($shop_id = null)
    {

        $filter = $pager = array();
        if($shop_id > 0){
            $filter['shop_id'] = $shop_id;
        }
        if($money = $this->GP('money')){
            $filter['order_amount'] = '<=:' . $money;
        }
        $filter['sku'] = '>:0';
        $filter['ltime'] = '>:' . time();
        if($items = K::M('shop/coupon')->items($filter, array('coupon_amount' => 'desc'), null, null, $count)){
            foreach($items as $k => $v){
                $items[$k]['coupon_amount'] = round($v['coupon_amount']);
                $items[$k]['order_amount'] = round($v['order_amount']);
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
        $this->tmpl = 'ucenter/coupon/receive.html';
    }

}
