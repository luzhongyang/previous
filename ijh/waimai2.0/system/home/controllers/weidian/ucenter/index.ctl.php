<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weidian_Ucenter_Index extends Ctl_Weidian
{

   public function index()
   {    
        $shop_id = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        if(!$shop = K::M('shop/shop')->detail($shop_id)) {
            $this->msgbox->add('商家不存在',210);
        }else if($shop['audit']!=1 || $shop['closed']!=0) {
            $this->msgbox->add('商家不存在或已被删除',211);
        }else if($shop['weidian'] != 1) {
            $this->msgbox->add('该商家暂未开通微店功能',212);
        }else {

       	    //待评价订单
       	    $filter = array();
       	    $filter['uid'] = $this->uid;
       	    $filter['order_status'] = 8;
       	    $filter['from'] = 'waimai';
       	    $filter['pay_status'] = 1;
       	    $filter['comment_status'] = 0;
       	    if($nums = K::M('order/order')->count($filter)) {
                $this->pagedata['comments'] = $nums;
       	    }
            
            $hongbao = K::M('hongbao/hongbao')->count(array('uid'=>$this->uid,'order_id'=>0,'ltime'=>'>:'.time()));
            $this->pagedata['hb_count'] = $hongbao;
            
            if($msg = K::M('member/message')->count(array('uid'=>$this->uid,'is_read'=>0))) {
               $this->pagedata['msg'] = $msg;
            }
            
            $c_filter = array(
                'uid'=>$this->uid,
                'use_time'=>0,
                'order_id'=>0,
                'status'=>0,
                'ltime'=>'>:' . __TIME,
                'shop_id'=>$shop_id,
                );
            $coupon_count = K::M('member/coupon')->count($c_filter);
            $this->pagedata['shop'] = $shop;
            $this->pagedata['coupon_count'] = $coupon_count;
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/index.html';
        }
    }
}