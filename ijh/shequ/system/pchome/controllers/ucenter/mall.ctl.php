<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Mall extends Ctl_Ucenter
{

    public function index($st,$page=1)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = "mall";
        if($st = (int)$st){
            if(in_array($st,array(0,1,2,3,4))){
                if($st == 1){
                    $filter['order_status'] = 0;
                    $filter['pay_status'] = 0;
                }elseif($st == 2){
                    $filter['order_status'] = 0;
                    $filter['pay_status'] = 1;
                }elseif($st == 3){
                    $filter['order_status'] = -1;
                }elseif($st == 4){
                    $filter['order_status'] = 8;
                }
            }
        }
        $this->pagedata['st'] = $st;
        $today = date('Y-m-d',__TIME);
        if($date = (int)$this->GP('date')){
            if(in_array($date,array(0,1,2,3,4))){
                if($date == 1){
                    $stime = strtotime($today) - 7*86400; 
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 2){
                    $stime = strtotime("-1 month",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 3){
                    $stime = strtotime("-3 month",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 4){
                    $stime = strtotime("-1 year",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }
            }
        }
        $this->pagedata['date'] = $date;
        if (!$items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)) {
            $items= array();
        }else{
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/mall/index',array($st,'{page}'),array('date'=>$date),'base'));
            $order_ids = array();
            foreach($items as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($order_ids){
                $this->pagedata['orders'] = K::M('mall/order')->items_by_ids($order_ids);
            }
            $order_products = K::M('mall/order/product')->items(array('order_id'=>$order_ids));
            $product_ids = array();
            foreach($order_products as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            if($product_ids){
                $products = K::M('mall/product')->items_by_ids($product_ids);
            }
            foreach($order_products as $k=>$v){
                foreach($products as $k1=>$v1){
                    if($v['product_id'] == $v1['product_id']){
                        $order_products[$k]['product'] = $v1;
                    }
                }
            }
            foreach($items as $k=>$v){
                foreach($order_products as $k1=>$v1){
                    if($v['order_id'] == $v1['order_id']){
                        $items[$k]['order_products'][] = $v1;
                    }
                }
            }
            //$this->pagedata['order_products'] = $order_products;
        }
        //print_r($items);die;
        $this->pagedata['total_count'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'from'=>'mall'));
        $this->pagedata['count_1'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0,'pay_status'=>0,'from'=>'mall'));
        $this->pagedata['count_2'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0,'pay_status'=>1,'from'=>'mall'));
        $this->pagedata['count_3'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1,'from'=>'mall'));
        $this->pagedata['count_4'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'from'=>'mall'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/mall/index.html';
    }
    

    public function detail($order_id){
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('该订单不存在', 211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['mall_order'] = K::M('mall/order')->detail($order_id);
            $order_products = K::M('mall/order/product')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($order_products as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            if($product_ids){
                $this->pagedata['products'] = K::M('mall/product')->items_by_ids($product_ids); 
            }
            $this->pagedata['order_products'] = $order_products;
            $this->tmpl = 'pchome/ucenter/mall/detail.html';
        }
        
    }

}
