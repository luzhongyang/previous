<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Cloud_Ucenter_Lottery extends Ctl_Cloud_Ucenter 
{

    public function index() 
    {
        $this->tmpl = 'cloud/ucenter/lottery/items.html';
    }


    public function loaddata($page=1){
        
        $filter = array('closed'=>0,'win_uid'=>$this->uid,'status'=>1);
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('cloud/attr')->items($filter,null, $page, $limit, $count)){
            $items = array();
        }
        $goods_ids = $uids = $attr_ids = array();
        foreach($items as $k=>$v){
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $attr_ids[$v['attr_id']] = $v['attr_id'];
        }
        if($goods_ids){
            $this->pagedata['goods'] = K::M('cloud/goods')->items_by_ids($goods_ids);
        }
        $buy_num_items = K::M('cloud/order')->member_num_count(array('uid'=>$this->uid,'order_status'=>1,'attr_id'=>$attr_ids));
        foreach($items as $k=>$v){
            foreach($buy_num_items as $k1=>$v1){
                if($v['attr_id'] == $v1['attr_id']){
                    $items[$k]['buy_num'] = $v1['buy_num'];
                }
            }
        }
        $count_num = K::M('cloud/attr')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['items'] = $items;
        $this->tmpl = 'cloud/ucenter/lottery/loaddata.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }


    
}
