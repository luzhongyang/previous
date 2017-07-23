<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Message extends Ctl_Card
{
    public function index()
    {
        $this->tmpl = 'shop/card/message/index.html';
    }
    
    public function loaditems($page=1)
    {
        $filter = array('shop_id'=>SHOP_ID);
        $shop = K::M('shop/shop')->detail(SHOP_ID);
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('message/message')->items($filter,array('msg_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        //print_r($items);die;
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->pagedata['shop'] = $shop;
        $this->tmpl = 'shop/card/message/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

}
