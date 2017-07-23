<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Pintuan_Order extends Ctl
{

    public $status = array(0);

    public function index($page)
    {

        $filter = $pager = array();
        $filter['a.`from`'] = 'pintuan';

        $filter['a.order_status'] = array(-1, 0, 1, 2, 3, 4, 5, 6, 7, 8);


        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){
                $filter['a.order_id'] = $SO['order_id'];
            }
            if($SO['shop_id']){
                $filter['a.shop_id'] = $SO['shop_id'];
            }
            if($SO['mobile']){
                $filter['a.mobile'] = $SO['mobile'];
            }
        }


        $orderby = array('a.order_id' => 'desc'); //固定在 pintuan_order_list 内,无需传递

        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['pintuan_product_id']){
                $filter['pintuan_product_id'] = $SO['pintuan_product_id'];
            }
            if($SO['group_id']){
                $filter['pintuan_group_id'] = $SO['group_id'];
            }

            if($SO['tuan_limit']){
                $filter['tuan_limit'] = $SO['tuan_limit'];
            }
        }



        $count = K::M('pintuan/order')->pintuan_order_count($filter);
        if($items = K::M('pintuan/order')->pintuan_order_list($filter, $page, $limit)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $arr_shop_id = array();
            foreach($items as $k => $v){
                $arr_shop_id[] = $v['shop_id'];
            }
            $arr_shop_id = array_unique($arr_shop_id);
            $arr_shop_name = K::M('shop/shop')->select(" shop_id in (" . implode(',', $arr_shop_id) . ")");

            foreach($items as $k => $v){
                $v['shop_name'] = $arr_shop_name[$v['shop_id']]['title'];
                $items[$k] = $v;
            }
        }



        $view_params_order = K::M('order/order')->view_params;
        $this->pagedata['arr_status'] = $view_params_order['order_status']['select'];

        $this->pagedata['arr_status_key'] = $this->status;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:pintuan/order/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:pintuan/order/so.html';
    }

    public function detail($order_id=null)
    {
        if (!$order_id = (int)$order_id) {
            $this->msgbox->add('未指定要查看内容的ID', 211);
        } else if (!$detail = K::M('pintuan/order')->detail($order_id)) {
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        } else {
            $detail['staff'] = K::M('staff/staff')->detail($detail['order_items']['staff_id']);
            $detail['status'] = K::M('order/order')->get_order_status();
            $detail['logs'] = K::M('order/log')->items(array('order_id' => $order_id), array('log_id' => 'asc'));
            $detail['types'] = K::M('order/log')->get_log_types();
            $this->pagedata['detail'] = $detail;
            $this->pagedata['froms'] = array('weixin' => '微信', 'ios' => '苹果APP', 'android' => '安卓APP', 'wap' => 'wap端', 'www' => '网页端');
            $this->tmpl = 'admin:pintuan/order/detail.html';
        }
    }

}
