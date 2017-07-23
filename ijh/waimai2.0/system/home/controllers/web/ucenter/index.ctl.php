<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Index extends Ctl_Web 
{

    public function index($type,$page) 
    {
        $this->check_login();
        //时间段
        $h = date("H", __TIME);
        if($h<11&&$h>=6){
            $str ="早上";
        }elseif($h>=11&&$h<14){
            $str ="中午";
        }elseif($h>=14&&$h<19){
            $str ="下午";
        }else{
            $str ="晚上";
        }
        $this->pagedata['time_str'] = $str;
        //红包
        $hongbao_map = array('uid'=>$this->uid,'order_id'=>0);
        $hongbao_map['stime'] = "<=:".__TIME;
        $hongbao_map['ltime'] = ">=:".__TIME;
        $hongbao_num = K::M('hongbao/hongbao')->count($hongbao_map);
        //print_r($hongbao_num);die;
        $this->pagedata['hongbao_num'] = $hongbao_num;
        //订单
        $orders = K::M('order/order')->items(array('uid'=>$this->uid),array('order_id'=>'desc'),null,3);
        $order_ids = $shop_ids = array();
        foreach($orders as $k=>$v){
            $shop_ids[$v['shop_id']] = $v['shop_id'];
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        if($shop_ids){
            $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        }
        if($order_ids){
            $products = K::M('order/product')->items(array('order_id'=>$order_ids)); 
        }
        foreach($orders as $k=>$val){
            foreach($products as $kk=>$v){
                if($v['order_id'] == $val['order_id']){
                    $orders[$k]['product'][] = $v;
                }
            }
        }
        $this->pagedata['orders'] = $orders;
        //print_r($orders);die;
        $this->tmpl = 'web/ucenter/index.html';
    }


}
