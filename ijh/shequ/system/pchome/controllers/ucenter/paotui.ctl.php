<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Paotui extends Ctl_Ucenter
{

    public function index($st,$page=1)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = 'paotui';
        if($st = (int)$st){
            if(in_array($st,array(0,1,2,3,4,5,6,7,8))){
                if($st == 1){ //待付款
                    $filter['pay_status'] = 0;
                    $filter['online_pay'] = 1;
                }elseif($st == 2){ //待接单
                    $filter['order_status'] = 0;
                    $filter['pay_status'] = 1;
                    $filter['online_pay'] = 1;
                    $filter['staff_id'] = "<>:0";
                }elseif($st == 3){
                    $filter['order_status'] = array(1,2);
                    $filter['pay_status'] = 1;
                    $filter['online_pay'] = 1;
                    $filter['staff_id'] = ">:0";
                }elseif($st == 4){
                    $filter['order_status'] = 3;
                }elseif($st == 5){
                    $filter['order_status'] = -1;
                    $filter['pay_time'] = 0;
                }elseif($st == 6){
                    $filter['order_status'] = 8;
                    $filter['comment_status'] = 0;
                }elseif($st == 7){
                    $filter['order_status'] = 8;
                    $filter['comment_status'] = 1;
                }elseif($st == 8){
                    $filter['order_status'] = -1;
                    $filter['pay_time'] = ">:0";
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
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/paotui/index',array($st,'{page}'),array('date'=>$date),'base'));
            $order_ids = $staff_ids = array();
            foreach($items as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($order_ids){
                $paotui_orders = K::M('paotui/order')->items_by_ids($order_ids);
                $types =  array();
                foreach($paotui_orders as $k=>$v){
                    $types[$v['type']] = $v['type'];
                }
                $cates = K::M('paotui/cate')->items(array('type'=>$types));
                foreach($paotui_orders as $k=>$v){
                    foreach($cates as $k1=>$v1){
                        if($v['type'] == $v1['type']){
                            $paotui_orders[$k]['icon'] = $v1['icon'];
                        }
                    }
                }
                
            }
            foreach($items as $k=>$v){
                foreach($paotui_orders as $k1=>$v1){
                    if($v['order_id'] == $v1['order_id']){
                      $items[$k]['order'] = $v1;
                    }
                }
            }
        }
        $this->pagedata['total_count'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'from'=>'paotui'));
        $this->pagedata['count_1'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'pay_status'=>0,'online_pay'=>1,'from'=>'paotui'));
        $this->pagedata['count_2'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0,'pay_status'=>1,'online_pay'=>1,'staff_id'=>'<>:0','from'=>'paotui'));
        $this->pagedata['count_3'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>array(1,2),'pay_status'=>1,'online_pay'=>1,'staff_id'=>'>:0','from'=>'paotui'));
        $this->pagedata['count_4'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>3,'from'=>'paotui'));
        $this->pagedata['count_5'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1,'pay_time'=>0,'from'=>'paotui'));
        $this->pagedata['count_6'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'comment_status'=>0,'from'=>'paotui'));
        $this->pagedata['count_7'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'comment_status'=>1,'from'=>'paotui'));
        $this->pagedata['count_8'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1,'pay_time'=>'>:0','from'=>'paotui'));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/paotui/index.html';
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
           $detail['order'] = K::M('paotui/order')->detail($order_id);
           $detail['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
           $this->pagedata['detail'] = $detail;
           $this->tmpl = 'pchome/ucenter/paotui/detail.html';
        }
        
    }

}
