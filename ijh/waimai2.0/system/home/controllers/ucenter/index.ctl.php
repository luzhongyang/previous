<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Index extends Ctl_Ucenter
{
   public function index()
   {    
   	    //待评价订单
   	    $filter = array();
   	    $filter['uid'] = $this->uid;
   	    $filter['order_status'] = 8;
   	    $filter['from'] = 'waimai';
   	    $filter['comment_status'] = 0;
        $filter['closed'] = 0;
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
            'ltime'=>'>:' . __TIME
            );
        $coupon_count = K::M('member/coupon')->count($c_filter);
        $this->pagedata['coupon_count'] = $coupon_count;
        
		$this->tmpl = 'ucenter/index.html';  
   }
}