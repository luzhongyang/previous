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

    public function items()
    {
        $page = max((int) $this->GP('page'), 1);
        $filter = array();
        $limit = 10;
        $filter['uid'] = $this->uid;
        $collect_list = K::M('shop/collect')->items($filter, null, $page, $limit, $count);
        $shop_ids = array();
        foreach ($collect_list as $k => $val) {
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
        $lat = addslashes($_COOKIE['lat']);
        $lng = addslashes($_COOKIE['lng']);
        foreach ($shop_list as $k => $val) {
            if ($lat && $lng) {
                if ($val['lat'] != '' && $val['lng'] != '') {
                    $shop_list[$k]['d'] = K::M('helper/round')->getdistance($val['lng'], $val['lat'], $lng, $lat);  //距离
                }
            }
            $shop_list[$k]['url'] = $this->mklink('shop/detail', array($val['shop_id']));
            $shop_list[$k]['score'] = round($val['score'] / 5, 2) * 100;

        }
        foreach($shop_list as $k=>$val){
            $items[] = $val;
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items' => $items));

    }

}
