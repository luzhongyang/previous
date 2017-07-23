<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Tuan extends Ctl_Ucenter
{
    public function index($st,$page=1)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = "tuan";
        if($st = (int)$st){
            if(in_array($st,array(0,1,2,3,4,5))){
                if($st == 1){
                   $filter['order_status'] = 0;
                    $filter['pay_status'] = 0;
                }elseif($st == 2){
                    $filter['order_status'] = 5;
                }elseif($st == 3){
                    $filter['order_status'] = 8;
                    $filter['comment_status'] = 0;
                }elseif($st == 4){
                    $filter['order_status'] = 8;
                }elseif($st == 5){
                    $filter['order_status'] = -1;
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
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/tuan/index',array($st,'{page}'),array('date'=>$date),'base'));
            $shop_ids = $order_ids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($shop_ids){
                $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($order_ids){
                $this->pagedata['tuan_orders'] = K::M('tuan/order')->items_by_ids($order_ids);
            }
        }
        $this->pagedata['total_count'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'from'=>"tuan"));
        $this->pagedata['count_1'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0,'from'=>"tuan",'pay_status'=>0));
        $this->pagedata['count_2'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>5,'from'=>"tuan"));
        $this->pagedata['count_3'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'comment_status'=>0,'from'=>"tuan"));
        $this->pagedata['count_4'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'from'=>"tuan"));
        $this->pagedata['count_5'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1,'from'=>"tuan"));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/tuan/index.html';
    }
    

    public function detail($order_id)
    {
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('该订单不存在', 211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('该订单不存在或已经删除', 211);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 211);
        }else{
            $this->pagedata['tuan_order'] = K::M('tuan/order')->detail($order_id);
            $this->pagedata['quan'] = K::M('tuan/ticket')->find(array('order_id'=>$order_id));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'pchome/ucenter/tuan/detail.html';
        }
        
    }

    
    public function cancel()
    {
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        $reason = $this->GP('reason');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限查下该订单', 213);
        }else if($detail['order_status'] != 0){
            $this->msgbox->add('订单状态不可取消', 214);
        }else if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('order_status'=>-1, 'reason'=>$reason,'lasttime'=>__TIME))){
            $this->msgbox->add('取消成功');
            $this->msgbox->set_data('data', array('dingzuo_id'=>$dingzuo_id));
        }
    }

    public function delete()
    {
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 213);
        }else if(K::M('yuyue/dingzuo')->delete($dingzuo_id)){
            K::M('yuyue/dingzuo')->update($dingzuo_id,array('lasttime'=>__TIME));
            $this->msgbox->add('删除成功');
        }
    }
    
    
    // 催单
    public function cuidan($dingzuo_id)
    {
        if(!$dingzuo_id = (int)$this->GP('dingzuo_id')){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$dingzuo = K::M('yuyue/dingzuo')->detail($dingzuo_id)) {
            $this->msgbox->add("订单不存在",212);
        }else if($dingzuo['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if((__TIME - $dingzuo['jd_time']) < 1800){
            $this->msgbox->add('请在30分钟后催单',214);
        }else if((__TIME - $dingzuo['cui_time']) < 900){
            $this->msgbox->add('请在15分钟之后催单',215);
        }else {
            if(K::M('yuyue/dingzuo')->update($dingzuo_id, array('cui_time'=>__TIME))) {
                $dingzuo['order_id'] = $dingzuo['dingzuo_id'];
                K::M('order/order')->send_shop('用户正在催单', sprintf("用户(%s)正在催促订座订单(%s)", $dingzuo['contact'] ,$dingzuo_id), $dingzuo);
                $this->msgbox->add('催单成功');
            }else {
                $this->msgbox->add('催单失败',216);
            }
        }
    }
    
}
