<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*收银首页控制器*/

class Ctl_Cashier_Order extends Ctl_Cashier_Cashier 
{
    
    public function items($page=1)
    {
    	
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter['from'] = 'waimai';
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        $filter['pei_type'] = array(0,1,3); //0:商家送,1:三方送,2:三方代
        $filter['closed'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
    	$this->tmpl = 'biz/cashier/order/items.html';
    }

    
}