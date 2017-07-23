<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Order extends Ctl_Ucenter {


    public function index($type,$page) 
    {
        $this->check_login();
        $filter = array();
        $filter['uid'] = $this->uid;
        if($type == 1){
            $filter['order_status'] = array(0,1,3,4,5);
        }else if($type == 2){
            $filter['order_status'] = array(-1,-2,8);
        }
        $orders   = K::M('order/order')->items($filter,array('order_id'=>'desc'));
     
        $this->pagedata['orders'] = $orders;
        $this->tmpl = 'ucenter/order/items.html';
    }


}
