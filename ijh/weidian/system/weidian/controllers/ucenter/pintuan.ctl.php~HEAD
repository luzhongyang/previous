<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Pintuan extends Ctl_Ucenter
{

    /**
     * 我的团迹
     */
    public function index($status = null)
    {
        $overdue = K::M('weidian/pintuan/group')->group_auto_check(); //检测自动过期
        if($status){
            $this->pagedata['status'] = $status;
            switch ($status) {
                case 1:
                    $status_name = "组团中";
                    break;
                case 2:
                    $status_name = "已成团";
                    break;
                case 3:
                    $status_name = "组团失败";
                    break;
            }
        }
        else{
            $status = 0;
            $status_name = "全部";
        }
        $this->pagedata['status'] = $status;
        $this->pagedata['status_name'] = $status_name;
        $this->tmpl = 'weidian/ucenter/pintuan/index.html';
    }

    public function loaditems($page = 1)
    {
        $filter = array('uid' => $this->uid);
        $page = max((int) $page, 1);
        $limit = 10;
        $orderby = array('order_id'=>'desc');
 
        if(!$items = K::M('weidian/pintuan/order')->items($filter, $orderby, $page, $limit, $count)){
            $items = array();
        }
        else{
            $group_ids = $product_ids = $order_ids =  array();
            foreach($items as $k => $v){
                $order_ids[$v['order_id']] = $v['order_id'];
                $group_ids[$v['group_id']] = $v['group_id'];
            }
            $orders = K::M('order/order')->items_by_ids($order_ids);
            $groups_filter = array('group_id' => $group_ids);
            if($status = (int) $this->GP('status')){
                $groups_filter['status'] = $status - 1;
            }
            $groups = K::M('weidian/pintuan/group')->items($groups_filter, null);
            foreach($items as $k => $v){
                $items[$k]['order'] = $orders[$v['order_id']];
                if(!$groups[$v['group_id']]){
                    unset($items[$k]);
                }
            }

            if($items){
                foreach($groups as $k => $v){
                    $product_ids[$v['product_id']] = $v['product_id'];
                }
                $glevel = K::M('weidian/pintuan/grouplevel')->items(array('group_id' => $group_ids));
                foreach($glevel as $k => $v){
                    $groups[$v['group_id']]['level'][] = $v;
                }
                $products = K::M('weidian/product')->items_by_ids($product_ids);
                foreach($groups as $k => $v){
                    $groups[$k]['product'] = $products[$v['product_id']];
                }
                foreach($items as $k => $v){
                    $items[$k]['group'] = $groups[$v['group_id']];
                }
                foreach($items as $k => $v){
                    $now = time() - 5;
                    if(1 == $v['order']['pay_status'] && 1 == $v['is_money_pre'] && $v['product_number']*$v['product_price'] > $v['money_paid']){
                        if(1 == $v['group']['status'] || 3 == $v['group']['status']){
                            //已付款,待付尾款,分阶梯团二种状态,
                            if(1 == $v['group']['tuan_type']){
                                //阶梯团                            //时间+86400,可以付款
                                if($now > $v['group']['end_time']){
                                    $items[$k]['weikuan'] = 1;
                                }
                            }
                            else{
                                $items[$k]['weikuan'] = 1;
                            }
                        }
                    }
                }
            }
        }
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0;
        }
        else{
            $loadst = 1;
        }

        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['items'] = $items;
        $this->tmpl = 'weidian/ucenter/pintuan/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }

}
