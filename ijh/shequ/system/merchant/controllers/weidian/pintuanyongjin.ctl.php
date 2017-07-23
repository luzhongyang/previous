<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Pintuanyongjin extends Ctl_Weidian
{

    public $status = 3;
    
    public function index($page)
    {
        $this->check_weidian();
        $filter = $pager = array();
        $filter = " a.shop_id = {$this->shop_id} && a.order_status = '8' && b.money_master_paid > 0";
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        $so = $this->GP('SO');
        if(isset($so)){
            $pager['SO'] = $this->GP('SO');
            if($SO['pintuan_group_id']){
                $filter['pintuan_group_id'] = $SO['pintuan_group_id'];
                $filter .= " && b.pintuan_group_id = {$SO['pintuan_group_id']}";
            }
            if($SO['master_id']){
                $filter['master_id'] = $SO['master_id'];
                $filter .= " && b.master_id = {$SO['master_id']}";
            }
            if($SO['order_id']){
                $filter['order_id'] = $SO['order_id'];
                $filter .= " && a.order_id = {$SO['order_id']}";
            }
        }

        $SO = $filter;

        $count = K::M('weidian/pintuan/order')->pintuan_order_count_biz($filter);

        if($items = K::M('weidian/pintuan/order')->pintuan_order_list_biz($filter, $page, $limit)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));

            $arr_product_id = array();
            $arr_master_id = array();
            foreach($items as $k => $v){
                $arr_product_id[] = $v['product_id'];
                $arr_master_id[] = $v['master_id'];
            }
            $arr_product_id = array_unique($arr_product_id);
            $arr_product_title = K::M('weidian/pintuan/product')->select(" product_id in (".implode(',',$arr_product_id).")");

            $arr_master_id = array_unique($arr_master_id);
            $arr_master_nickname = K::M('member/member')->select(" uid in (".implode(',',$arr_master_id).")");

            $view_params = K::M('weidian/pintuan/group')->view_params;

            foreach($items as $k => $v){
                $v['start_time'] = date('Y-m-d H:i', $v['start_time']);
                $v['end_time'] = date('Y-m-d H:i', $v['end_time']);
                $v['status_cn'] = $view_params['status']['select'][$v['status']];
                $v['pintuan_product_id_cn'] = $arr_product_title[$v['pintuan_product_id']]['title'];
                $v['master_id_cn'] = $arr_master_nickname[$v['master_id']]['nickname'];

                $items[$k] = $v;
            }

        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/yongjin/index.html';
    }


}
