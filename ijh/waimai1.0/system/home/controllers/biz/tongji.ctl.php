<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tongji extends Ctl_Biz
{ 
    public $day_date = NULL;
    public $week_monday = NULL;
    public $month_firstday = NULL;

    public function __construct(&$system) {
        parent::__construct($system);
        $this->day_date =  date('Ymd'); //今日日期
        $this->week_monday = $this->this_monday(time()); // 当周周一日期
        $this->month_firstday = date('Ym01', strtotime($this->day_date)); // 当月第一天日期
    }
    
    public function index()
    {
        $this->tmpl = 'biz/tongji/index.html';
    }

    /*收入统计*/
    public function income()
    {
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('shop_id'=>$this->shop_id, 'order_status'=>8, 'day'=>$lday.'~'.$sday);
        $today_money = $week_money = $month_money = $total_money = 0;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('day'=>$day, 'date'=>$date, 'count'=>0, 'money'=>0);
        }
        if($count_list = K::M('order/order')->count_by_day($filter, 1, 31)){
            foreach($count_list as $k=>$v){
                $dmoney = $v['day_money'] + $v['day_amount'] + $v['day_hongbao'];
                if($sday == $v['day']){
                    $today_money = $dmoney;
                }else{
                    if($week_day <= $v['day']){
                        $week_money += $dmoney;
                    }
                    $month_money += $dmoney;
                    $items[$k]['money'] = $dmoney;
                }    
            }
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $month_data = $items;
            $week_data = array_slice($items,-7);
        }
        $total_money = $this->shop['total_money'];
        $this->pagedata['today_coins'] = $today_money;
        $this->pagedata['seven_coins'] = $week_money;
        $this->pagedata['month_coins'] = $month_money;
        $this->pagedata['all_coins'] = $total_money;
        $this->pagedata['month_data'] = $month_data;
        $this->pagedata['week_data'] = $week_data;
        $this->tmpl = 'biz/tongji/income.html';
    }

    /*订单统计*/
    public function order()
    {
        $items = $filter = array();
        $today_orders = $seven_orders = $month_orders = '';
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('shop_id'=>$this->shop_id, 'order_status'=>'>:0', 'day'=>$lday.'~'.$sday);

        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'day_order'=>0);
        }

        if($month = K::M('order/order')->count_by_day($filter, 1, 31)) {
            
            // 近一月订单曲线
            foreach($month as $k=>$v) {  
                if($this->day_date == $k) {$today_orders = $v['day_order']; }          //今日订单量
                if($this->week_monday <= $k) {$seven_orders +=  $v['day_order']; }     //本周订单量
                if($this->month_firstday <= $k) {$month_orders += $v['day_order']; }   //本月订单量
                $items[$k]['day_order'] = $v['day_order']; 
            }   

            foreach($items as $kk=>$vv) {
                $items[$kk]['date'] = "'".substr($vv['date'],5,6)."'";
            }

            $month_data = $items;
            $week_data = array_slice($items,-7); 
        }
        //累计总订单量
        $filter2['shop_id'] = $this->shop_id;
        $filter2['order_status'] = '>:0';

        if($all = K::M('order/order')->count($filter2)) {
            $all_orders= $all; 
        }
        $this->pagedata['today_orders'] = $today_orders;
        $this->pagedata['seven_orders'] = $seven_orders;
        $this->pagedata['month_orders'] = $month_orders;
        $this->pagedata['all_orders'] = $all_orders;
        $this->pagedata['month_data'] = $month_data;
        $this->pagedata['week_data'] = $week_data;
        $this->tmpl = 'biz/tongji/order.html';    
    }
    
    /*来源统计*/
    public function orderfrom()
    {
        $tmonth = date('Ymd', strtotime('-31 days'));
        $tweek = date('Ymd', strtotime('-7 days'));
        $today = date('Ymd', __TIME);
        $filter = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = '>:0';

        // 近一月来源占比  
        $filter['day'] = $tmonth."~".$today;
        if($month = K::M('order/order')->orderfrom($filter)) {  
            $this->pagedata['month_data'] = $month;
        }
        // 近一周来源占比
        $filter['day'] = $tweek."~".$today;
        if($week = K::M('order/order')->orderfrom($filter)) {
            $this->pagedata['week_data'] = $week;
        }
        $this->tmpl = 'biz/tongji/orderfrom.html';  
    }

    /*销量统计*/
    public function product()
    {    
        
        $tmonth = __TIME - 31*86400;
        $tweek = __TIME - 7*86400;
        $today = __TIME;
        // 近一月商品销量
        
        $between = "BETWEEN {$tmonth} AND {$today}";
        if($month = K::M('product/product')->count_sales($this->shop_id, $between)) {
            $this->pagedata['month_data'] = $month;
        }
        // 近一周商品销量
        $between = "BETWEEN {$tweek} AND {$today}";
        if($week = K::M('product/product')->count_sales($this->shop_id, $between)) {
            $this->pagedata['week_data'] = $week;
        }
        $this->tmpl = 'biz/tongji/product.html';  
    }
 
    // 根据当前时间戳获取本周第一天的日期
    function this_monday($timestamp=0,$is_return_timestamp=true){  
        static $cache ;  
        $id = $timestamp.$is_return_timestamp;  
        if(!isset($cache[$id])){  
            if(!$timestamp) $timestamp = time();  
            $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));  
            if($is_return_timestamp){  
                $cache[$id] = strtotime($monday_date);  
            }else{  
                $cache[$id] = $monday_date;  
            }  
        }  
        return date('Ymd', $cache[$id]);
    }   
}

