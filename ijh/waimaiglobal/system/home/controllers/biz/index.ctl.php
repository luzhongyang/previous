<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_index extends Ctl_Biz
{
    
    // 管理中心
    public function index()
    {
        // 待接订单数
        $filter = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';

    	if($wait_accept = K::M('order/order')->count($filter)) {
    		$this->pagedata['wait_accept'] = $wait_accept;
    	}
        // 待配送订单数
    	if($wait_peisong = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>1))) {
    		$this->pagedata['wait_peisong'] = $wait_peisong;
    	}
        // 今日已完成订单数
        $day = date('Ymd', __TIME);
    	if($today_order = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>8,'day'=>$day))) {
    		$this->pagedata['today_order'] = $today_order;
    	}
        //总完成订单数
    	if($all_order = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>8))) {
            $this->pagedata['all_order'] = $all_order;
        }
        
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
        $this->tmpl = 'biz/index.html';
    }
}
