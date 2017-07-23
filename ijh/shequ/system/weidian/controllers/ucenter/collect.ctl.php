<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Collect extends Ctl_Ucenter
{

    /**
     * 微店用户中心我的收藏
     */
    public function index()
    {
        $this->tmpl = 'weidian/ucenter/collect/index.html';
    }

    public function loaditems($page=1)
    {
        $filter = array('uid'=>$this->uid);
        $filter['shop_id'] = $this->shop_id;
        $page = max((int)$page, 1);
        $limit = 10;
        if(!$items = K::M('weidian/collect')->items($filter,array('collect_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }else{
            $product_ids = array();
            foreach($items as $k => $v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            $products = K::M('weidian/product')->items_by_ids($product_ids);
            foreach($items as $k => $v){
                $items[$k]['product'] = $products[$v['product_id']];
            }
        }
        $count_num = K::M('weidian/collect')->count($filter);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'weidian/ucenter/collect/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

}
