<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_index extends Ctl
{
    
    // 管理中心
    public function index()
    {
        // 待接订单数
        $filter = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        $filter['from'] = 'waimai'; 
        $filter['pei_type'] = array(0,1,3); //0:商家送,1:三方送,2:三方代
        $filter['closed'] = 0;
        if($wait_accept = K::M('order/order')->count($filter)) {
            $this->pagedata['wait_accept'] = $wait_accept;
        }else{
            $this->pagedata['wait_accept'] = 0;
        }
        // 待配送订单数
        $filter_peisong = array();
        $filter_peisong['shop_id'] = $this->shop_id;
        $filter_peisong['order_status'] = array(1, 2);
        $filter_peisong['from'] = 'waimai';
        $filter_peisong['staff_id'] = 0;
        $filter_peisong['closed'] = 0;
        $filter_peisong[':SQL'] =  "pei_type != 3";
        if($wait_peisong = K::M('order/order')->count($filter_peisong)) {
            $this->pagedata['wait_peisong'] = $wait_peisong;
        }else{
            $this->pagedata['wait_peisong'] = 0;
        }
        //正在配送订单数
        if($is_peiing = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>2))) {
            $this->pagedata['is_peiing'] = $is_peiing;
        }else{
            $this->pagedata['is_peiing'] = 0;
        }

        //已完成数
        $filter_orderall = array();
        $filter_orderall['shop_id'] = $this->shop_id;
        $filter_orderall['order_status'] = array(4,5,6,7,8);
        $filter_orderall['from'] = 'waimai';
        $filter_orderall['closed'] = 0;
        if($orderall = count(K::M('order/order')->select($filter_orderall))) {
            $this->pagedata['orderall'] = $orderall;
        }else{
            $this->pagedata['orderall'] = 0;
        }
        // 今日已完成订单数
        $today = date('Ymd', __TIME);
        $filter_orderall['day'] = $today;
        $todayorder = K::M('order/order')->select($filter_orderall);
        if($today_order = count($todayorder)) {
            $this->pagedata['today_order'] = $today_order;
        }else{
            $this->pagedata['today_order'] = 0;
        }
        //今日完成总金额
        $todaymoney = 0;
        foreach ($today_order as $k => $v) {
            $todaymoney += $v['total_price'];
        }
        $this->pagedata['todaymoney'] = $todaymoney;
        //收到点评数
        $shopcomment = count(K::M('shop/comment')->select(array('shop_id'=>$this->shop_id)));
        if($shopcomment){
            $this->pagedata['shopcomtnum'] = $today_order;
        }else{
            $this->pagedata['shopcomtnum'] = 0;
        }
        //我的粉丝  
        $fans = K::M('member/collect')->count(array('can_id'=>$this->shop_id,'status'=>1));
        if($fans){
            $this->pagedata['fans'] = $fans;
        }else{
            $this->pagedata['fans'] = 0;
        }
        //已取消数
        $cansle = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>-1,'closed'=>0));
        if($cansle){
            $this->pagedata['cansle'] = $cansle;
        }else{
            $this->pagedata['cansle'] = 0;
        }
        //自提订单
        $ziti = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'pay_type'=>3,'closed'=>0));
        if($ziti){
            $this->pagedata['ziti'] = $ziti;
        }else{
            $this->pagedata['ziti'] = 0;
        }
        //总完成订单数
        if($all_order = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>8,'closed'=>0))) {
            $this->pagedata['all_order'] = $all_order;
        }else{
            $this->pagedata['all_order'] = 0;
        }
     //   echo '<pre>';print_r($this->system->db->SQLLOG());die;

        //未回复的店铺评论
        $filter = array();
        $filter['reply_time'] = 0;
        $filter['shop_id'] = $this->shop_id;
        if($unshopcom = K::M('shop/comment')->items($filter, array('comment_id'=>"DESC"), 1, 5, $count)){
            $pager['diancount'] = $count;
        }
        $uids = array();
        foreach($unshopcom as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['dianusers'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['unshopcom'] = $unshopcom;
        //未回复的外送评论
        $filter = array();
        $filter['closed'] = 0;
        $filter['reply_time'] = 0;
        $filter['shop_id'] = $this->shop_id;
        if($unwaicom = K::M('waimai/comment')->items($filter, null, 1, 5, $count)){
            $pager['unwaicomc'] = $count;
        }
        $uids = array();
        foreach($unwaicom as $k=>$val){
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['waiusers'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['unwaicom'] = $unwaicom;
        // 收入统计和订单统计
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter2 = array('shop_id'=>$this->shop_id, 'order_status'=>8, 'day'=>$lday.'~'.$sday);
        $filter2[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        $items = $items2 = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'count'=>0, 'money'=>0, 'day_order'=>0);
            $items2[$day] = array('date'=>$date,'day_order'=>0);
        }
        
        if($count_list = K::M('order/order')->count_by_day($filter2, 1, 31)){
            foreach($count_list as $k=>$v){
                $dmoney = $v['day_money'] + $v['day_amount'] + $v['day_hongbao'];
                $items[$k]['money'] = $dmoney;
                $items2[$k]['day_order'] = $v['day_order']; 
            }
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
                $items2[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $month_data = $items;
            $week_data = array_slice($items,-7);
            $month_order = $items2;
            $week_order = array_slice($items2,-7);   
        }
        $this->pagedata['week_in'] = $week_data;
        $this->pagedata['month_in'] = $month_data;
        $this->pagedata['month_order'] = $month_order;
        $this->pagedata['week_order'] = $week_order;  
        $this->pagedata['today'] = $today;
        $this->tmpl = 'merchant:index.html';
    }
}
