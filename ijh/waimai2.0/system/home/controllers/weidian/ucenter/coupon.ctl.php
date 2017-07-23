<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Ucenter_Coupon extends Ctl_Weidian
{
    // 用户的店铺优惠券列表
	public function index()
	{
		$filter = $pager = array();
		$shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        //查找用户已经领取的列表
        $use_filter = array();
        $use_filter['uid'] = $this->uid;
        $use_filter['use_time'] = 0;
        $use_filter['order_id'] = 0;
        $use_filter['status'] = 0;
        $use_filter['ltime'] = '>:' . __TIME;
        $use_filter['shop_id'] = $shop_id;
        if($shop_id > 0){
            $use_filter['shop_id'] = $shop_id;
            $shop = K::M('shop/shop')->detail($shop_id);
        }
        $user_coupon = K::M('member/coupon')->items($use_filter);
        $arr_user_coupon = array();
        foreach($user_coupon as $k => $v){
            $arr_user_coupon[] = $v['coupon_id'];
            $shop_coupon = K::M('shop/coupon')->detail($v['coupon_id']);
            if($v['order_id']>0 && $v['status']==1 && $v['use_time']>0) {
            	$user_coupon[$k]['status_label'] = '已使用';
            	$user_coupon[$k]['money_class'] = 'huise';
            	$user_coupon[$k]['label_class'] = 'graybg';
            	$user_coupon[$k]['title_class'] = 'color-gray';
            	$user_coupon[$k]['useful_class'] = 'graybg';
            }else if($v['order_id']==0 && $v['status']==0 && $v['use_time']==0 &&$v['ltime']<__TIME) {
            	// $user_coupon[$k]['status_label'] = '已过期';
            	// $user_coupon[$k]['money_class'] = 'huise';
            	// $user_coupon[$k]['label_class'] = 'graybg';
            	// $user_coupon[$k]['title_class'] = 'color-gray';
            	// $user_coupon[$k]['useful_class'] = 'graybg';
            }else if($v['order_id']==0 && $v['status']==0 && $v['use_time']==0 &&$v['ltime']>__TIME){
            	$user_coupon[$k]['status_label'] = '已领取';
            	$user_coupon[$k]['money_class'] = '';
            	$user_coupon[$k]['label_class'] = 'chengbg';
            	$user_coupon[$k]['title_class'] = '';
            	$user_coupon[$k]['useful_class'] = 'chengbg';
            }
            $user_coupon[$k]['shop_name'] = $shop['title'];
            $user_coupon[$k]['stime'] = $shop_coupon['stime'];
        }
        $this->pagedata['arr_user_coupon'] = $arr_user_coupon;
        $this->pagedata['items'] = $user_coupon;

		$this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/coupon/mycoupon.html';     
	}

    // 商家优惠券列表
    public function items()
    {
        $shop_id = $_SESSION['WEIDIAN_SHOP_ID'];
        $filter['shop_id'] = (int)$shop_id;
        $filter['ltime'] = ">:" . __TIME;
        $filter['sku'] = ">:0";
        $filter['closed'] = 0;
        $shop = K::M('shop/shop')->detail($shop_id);
        if($items = K::M('shop/coupon')->items($filter)) {
            foreach($items as $k=>$v) {
                $items[$k]['has_got'] = K::M('member/coupon')->count(array('coupon_id'=>$v['coupon_id'],'uid'=>$this->uid,'shop_id'=>$shop_id));
                $items[$k]['shop_name'] = $shop['title'];
            }
            $this->pagedata['items'] = $items;
        }

        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/coupon/shopcoupon.html';     
    }

    // 领取优惠券
    public function getcoupon()
    {
        $this->check_login();
        $shop_id = $_SESSION['WEIDIAN_SHOP_ID'];
        if(!$shop_id = (int) $shop_id){
            $this->msgbox->add('商家不存在', 201);
        }else if(!$coupon_id = (int) $this->GP('coupon_id')){
            $this->msgbox->add('优惠券不存在', 202);
        }else if(!$coupon = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add('优惠券不存在', 203);
        }else if($coupon['ltime'] < __TIME){
            $this->msgbox->add('优惠券已过期', 204);
        }else if($coupon['shop_id'] != $shop_id){
            $this->msgbox->add('非法操作', 205);
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

    // 外卖提交订单选择优惠券
    public function choosecoupon($shop_id=null, $amount=null)
    {
        $filter = $pager = array();
        $filter = array(
            'shop_id' =>$shop_id,
            'uid' => $this->uid,
            'use_time' => 0,
            'order_id' => 0,
            'status' => 0,
            'ltime' => '>:' . __TIME,
            ':SQL' => 'order_amount<=' . $amount,
        );
        if($items = K::M('member/coupon')->items($filter, array('dateline' => 'desc'))){

            foreach($items as $k => $v){
                $shop_coupon = K::M('shop/coupon')->detail($v['coupon_id']);
                $items[$k]['stime'] = date('Y-m-d', $shop_coupon['stime']);
                $items[$k]['ltime'] = date('Y-m-d', $v['ltime']);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/coupon/choosecoupon.html';     
    }
}
