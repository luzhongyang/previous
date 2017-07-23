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
   	    $filter['pay_status'] = 1;
   	    $filter['comment_status'] = 0;
   	    if($nums = K::M('order/order')->count($filter)) {
            $this->pagedata['comments'] = $nums;
   	    }
        
        $hongbao = K::M('hongbao/hongbao')->count(array('uid'=>$this->uid,'order_id'=>0,'ltime'=>'>:'.time()));
        $this->pagedata['hb_count'] = $hongbao;
        
		$this->tmpl = 'ucenter/index.html';  
   }
}