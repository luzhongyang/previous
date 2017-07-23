<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Ding extends Ctl_Ucenter
{

    /**
     * 用户中心地址
     */
    public function index($st,$page=1)
    {
        //print_r(date('Y-m-d H:i:s',strtotime("-1 month",  strtotime(date('Y-m-d',__TIME)))));die;
        
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        if($st = (int)$st){
            if(in_array($st,array(0,1,2,3))){
                if($st == 1){
                    $filter['order_status'] = 0;
                }elseif($st == 2){
                    $filter['order_status'] = 1;
                }elseif($st == 3){
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
        
        if (!$items = K::M('yuyue/dingzuo')->items($filter, array('dingzuo_id'=>'desc'), $page, $limit, $count)) {
            $items= array();
        }else{
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/ding/index',array($st,'{page}'),array('date'=>$date),'base'));
            $shop_ids = $zhuohao_ids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                if($v['zhuohao_id']){
                    $zhuohao_ids[$v['zhuohao_id']] = $v['zhuohao_id'];
                }
            }
            if($shop_ids){
                $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($zhuohao_ids){
                $this->pagedata['zhuo_lists'] = K::M('yuyue/zhuohao')->items_by_ids($zhuohao_ids);
            }
        }
        $this->pagedata['total_count'] = K::M('yuyue/dingzuo')->count(array('uid'=>$this->uid,'closed'=>0));
        $this->pagedata['count_1'] = K::M('yuyue/dingzuo')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0));
        $this->pagedata['count_2'] = K::M('yuyue/dingzuo')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>1));
        $this->pagedata['count_3'] = K::M('yuyue/dingzuo')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->pagedata['reason_list'] = K::M('yuyue/dingzuo')->cancel_reason_list();
        $this->tmpl = 'pchome/ucenter/ding/index.html';
    }
    

    public function detail($dingzuo_id){
        $dingzuo_id = (int)$dingzuo_id;
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 211);
        }else{
            if($detail['shop_id'] && ($row = K::M('shop/shop')->detail($detail['shop_id']))){
                $detail['shop'] = array('shop_id'=>$row['shop_id'], 'title'=>$row['title'], 'addr'=>$row['addr'].$row['house'], 'lat'=>$row['lat'], 'lng'=>$row['lng'],'phone'=>$row['phone'],'mobile'=>$row['mobile'],'logo'=>$row['logo']);
            }else{
                $v['shop_detail'] = array('shop_id'=>0, 'title'=>'--', 'addr'=>'', 'lat'=>'0', 'lng'=>'0', 'phone'=>'');
            }
            if($detail['zhuohao_id'] && ($row = K::M('yuyue/zhuohao')->detail($detail['zhuohao_id']))){
                $detail['zhuohao_detail'] = array('zhuohao_id'=>$row['zhuohao_id'], 'title'=>$row['title']);
            }else{
                $detail['zhuohao_detail'] = array('zhuohao_id'=>0, 'title'=>'--');
            }
            if($detail['order_status'] == 0) {
                $detail['order_status_label'] = '等待商户确认';
            }else if($detail['order_status'] == 1) {
                $detail['order_status_label'] = '预约成功';
            }else if($detail['order_status'] == -1) {
                $detail['order_status_label'] = '已取消';
            }
            $detail['cancel_reason_list'] = K::M('yuyue/dingzuo')->cancel_reason_list();
            $this->pagedata['order'] = $detail;
            $this->tmpl = 'pchome/ucenter/ding/detail.html';
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
