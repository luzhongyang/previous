<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_pintuanorder extends Ctl_Biz
{

    public $status = array(0);

    public function index($page)
    {

        $filter = $pager = array();
        $filter['a.shop_id'] = $this->shop_id;
        $filter['a.`from`'] = 'pintuan';



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
        //接收组团查询
        if(!$SO['group_id']){
         $filter['a.order_status'] = $this->status;
        }


        $count = K::M('pintuan/order')->pintuan_order_count($filter);
        if($items = K::M('pintuan/order')->pintuan_order_list($filter, $page, $limit)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }

        $view_params_order = K::M('order/order')->view_params;
        $this->pagedata['arr_status'] = $view_params_order['order_status']['select'];

        $this->pagedata['arr_status_key'] = $this->status;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/pintuan/order/index.html';
    }

    public function pei($page = 1)
    {
        $this->status = array(1);
        $this->index($page);
    }

    public function delivered($page = 1)
    {
        $this->status = array(3, 4);
        $this->index($page);
    }

    public function complete($page = 1)
    {
        $this->status = array(8);
        $this->index($page);
    }

    public function cancellist($page = 1)
    {
        $this->status = array(-1);
        $this->index($page);
    }

    /**
     * 组团成功, 商家接单发货
     */
    public function status_ok($group_id)
    {
        $return = array(
            'error'   => 1,
            'message' => '呵呵' . $group_id,
        );
        print_r(json_encode($return));
        exit;
    }

    /**
     * 组团成功,商家取消发货,执行此.
     */
    public function status_complete($group_id)
    {
        $return = array(
            'error'   => 0,
            'message' => '呵呵' . $group_id,
        );
        print_r(json_encode($return));
        exit;
    }

}
