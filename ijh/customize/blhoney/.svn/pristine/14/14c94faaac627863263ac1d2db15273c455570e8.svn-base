<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Order extends Ctl
{
	public function items()
    {
        $this->check_login();
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        if($order_list = K::M('order/order')->items($filter,array('order_id'=>'desc'),1,1000,$count)) {
            $shop_ids = array();
            foreach($order_list as $k=>$val){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            if($shop_list = K::M('shop/shop')->items_by_ids($shop_ids)){
                foreach($shop_list as $k=>$v){
                    $v = $this->filter_fields('shop_id,title,phone,logo',$v);
                    $shop_list[$k] = $v;
                }
            }
            $items = array();
            foreach($order_list as $k=>$val){            
                $items[$k] = $this->filter_fields('order_id,product_number,amount,order_status,pay_status,comment_status,ordered_time', $val);
                if($shop_list[$val['shop_id']]){
                    $items[$k]['shop'] = $shop_list[$val['shop_id']];
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->tmpl = 'ucenter/order/items.html';  
    }

    //订单详情-待支付
	public function detail1()
    {
        $this->tmpl = 'ucenter/order/detail1.html';  
    }

    //订单详情-已支付
	public function detail2()
    {
        $this->tmpl = 'ucenter/order/detail2.html';  
    }

    //订单详情-待评价
	public function detail3()
    {
        $this->tmpl = 'ucenter/order/detail3.html';  
    }

    //订单详情-已评价
	public function detail4()
    {
        $this->tmpl = 'ucenter/order/detail4.html';  
    }

}