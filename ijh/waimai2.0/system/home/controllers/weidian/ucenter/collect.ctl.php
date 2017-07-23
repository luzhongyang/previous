<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
class Ctl_Weidian_Ucenter_Collect extends Ctl_Weidian
{

    public function index()
    {
        $this->waimai_items();
    }

    public function waimai_items()
    {
        $items = K::M('waimai/productcollect')->items(array('uid'=>$this->uid));
        $pro_ids = array();
        foreach ($items as $k => $v) {
            $pro_ids[$v['product_id']] = $v['product_id'];
        }
        $pro_items = K::M('waimai/product')->items_by_ids($pro_ids);
        $this->pagedata['items'] = $pro_items;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/collect/waimai.html';     
    }
    
    public function pin_items()
    {
        $page = max((int) $this->GP('page'), 1);
        $filter = array('uid'=>$this->uid);
        $collect_list = K::M('pintuan/collect')->items($filter, null, $page, null, $count);
        $product_ids = array();
        foreach ($collect_list as $k => $val) {
            $product_ids[$val['pintuan_product_id']] = $val['pintuan_product_id'];
        }
        $pintuan_list = K::M('pintuan/product')->items_by_ids($product_ids);
        foreach($pintuan_list as $k=>$v){
            $pintuan_list[$k]['rate'] = round($v['tuan_price']/$v['price'],2)*10;
            $cate = K::M('pintuan/productcate')->detail($v['cate_id']);
            $pintuan_list[$k]['cate'] = $cate['title'];
        }
        $this->pagedata['items'] = $pintuan_list;
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/collect/pintuan.html';     
    }

}
