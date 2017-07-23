<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Logs extends Ctl_Cloud_Ucenter 
{

    public function index($type) 
    {
       $this->pagedata['type'] = $type;
        $this->tmpl = 'cloud/ucenter/logs/items.html';
    }
    
    public function loaditems($page=1){
        $filter = array('uid'=>$this->uid,'order_status'=>1);
        $page = max((int)$page, 1);
        $limit = 20;
        if(!$items = K::M('cloud/order')->items($filter,array('dateline'=>'desc'), $page, $limit, $count)){
            $items = array();
        }
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/logs/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
        public function loaddata($page=1){
        $filter = array('uid'=>$this->uid,'type'=>'coin');
        $page = max((int)$page, 1);
        $limit = 20;
        if(!$items = K::M('member/log')->items($filter,array('log_id'=>'desc'), $page, $limit, $count)){
            $items = array();
        }
        $count_num = K::M('member/log')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/logs/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
}
