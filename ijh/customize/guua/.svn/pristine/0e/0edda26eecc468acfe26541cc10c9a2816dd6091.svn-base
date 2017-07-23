<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Adv extends Ctl
{

    // 首页轮播
    public function index($params)
    {
        if($adv = K::M('adv/item')->items(array('adv_id'=>1,'audit'=>1,'closed'=>0),array('item_id'=>'asc'), $page,$limit,$count)) {
        	foreach($adv as $k=>$v) {
	        	$advs[] = $this->filter_fields('adv_id,title,link,thumb', $v);
	        }
        }else {
        	$advs= array();
        }
        
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($advs)));
    }
   
    // 商城轮播
    public function mall($params)
    {
        if($adv = K::M('adv/item')->items(array('adv_id'=>2,'audit'=>1,'closed'=>0),array('item_id'=>'asc'), $page,$limit,$count)) {
        	foreach($adv as $k=>$v) {
	        	$advs[] = $this->filter_fields('adv_id,title,link,thumb', $v);
	        }
        }else {
        	$advs= array();
        }
        
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($advs)));
    }
}
