<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Ucenter_Collect extends Ctl_Ucenter
{

    public function index($page=1)
    {
        $this->tmpl = 'ucenter/collect/index.html';
    }

    public function items($type=null)
    {
        $this->check_login();
        $page = max((int) $this->GP('page'), 1);
        $filter = array();
        $limit = 10;
        $filter['uid'] = $this->uid;
        $collect_list = K::M('shop/collect')->items($filter, null, $page, $limit, $count);
        $shop_ids = array();
        foreach ($collect_list as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }

        $lng = $this->GP('lng');
        $lat = $this->GP('lat');
        if(!$lng || !$lat){
            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
        }
        $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
        foreach ($shop_list as $k => $val) {
            $val['juli_sort'] = K::M('helper/round')->getdistances($val['lng'], $val['lat'], $lng, $lat);  //距离m
            if($val['juli_sort'] >= 1000) {
                $val['juli'] = round(intval($val['juli_sort']/1000).'.'.($val['juli_sort']%1000), 2).'km';
            }else {
                $val['juli'] = round($val['juli_sort'], 2).'m';
            }
            $val['avg_score'] = ($val['score_kouwei'] + $val['score_fuwu'])/2;
            $val['star'] = (round($val['avg_score'] / $val['comments'], 2) >= 5 ? 5 : round($val['avg_score'] / $val['comments'], 2));
            if ($lat && $lng) {
                if ($val['lat'] != '' && $val['lng'] != '') {
                    $shop_list[$k]['d'] = K::M('helper/round')->getdistance($val['lng'], $val['lat'], $lng, $lat);  //距离
                }
            }
            $shop_list[$k]['url'] = $this->mklink('shop/detail', array($val['shop_id']));
            $shop_list[$k] = $val;

        }
        $this->pagedata['items'] = $shop_list;
        $this->tmpl = 'ucenter/collect/items.html';
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

        $this->pagedata['pintuan_list'] = $pintuan_list;
        $this->tmpl = 'ucenter/collect/pintuan.html';
    }

}
