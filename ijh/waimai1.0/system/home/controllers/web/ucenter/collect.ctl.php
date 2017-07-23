<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Collect extends Ctl_Web_Ucenter {


    public function index($page=1)
    {
        $page = max((int)$page, 1);
        $filter = array();
        $limit = 10;
        $filter['uid'] = $this->uid;
        if($items = K::M('shop/collect')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $shop_ids = array();
        foreach ($items as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
        $lat = addslashes($this->system->cookie->get('lat'));
        $lng = addslashes($this->system->cookie->get('lng'));
        foreach ($shop_list as $k => $val) {
            if ($lat && $lng) {
                if ($val['lat'] != '' && $val['lng'] != '') {
                    $shop_list[$k]['d'] = K::M('helper/round')->getdistance($val['lng'], $val['lat'], $lng, $lat);  //距离
                }
            }
        }
        foreach($items as $k=>$val){
            foreach($shop_list as $kk=>$v){
                if($val['shop_id'] == $v['shop_id']){
                    $items[$k] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'web/ucenter/collect/items.html';
    }
    
    

}
