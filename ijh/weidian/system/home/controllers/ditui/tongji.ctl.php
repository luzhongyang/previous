<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Tongji extends Ctl_Ditui
{
    public $day_date = NULL;    
    public $week_monday = NULL;
    public $month_firstday = NULL;

    public function __construct(&$system) {
        parent::__construct($system);
        $this->day_date = date('Y-m-d', __TIME);
        $this->month_firstday = date('Y-m-d', __TIME - 31*86400);
        $this->week_monday= date('Y-m-d', __TIME - 8 * 86400);
    }

    // 用户渠道推广收入
    public function mincome()
    {   
        $sday = __TIME;
        $lday = __TIME - 31*86400;
        $filter = $month = array();
        $filter['ditui_id'] = $this->ditui_id;
        $filter['dateline'] = $lday.'~'.$sday;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Y-m-d', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'money'=>0);
        }
       
        if($month = K::M('ditui/member')->ditui_income($filter,1,31)) {
            foreach($month as $k=>$v) {
                if($this->day_date == $k) {$today_coins = $v['money']; }          
                if($this->week_monday <= $k) {$seven_coins +=  $v['money']; }     
                if($this->month_firstday <= $k) {$month_coins += $v['money']; }   
                $items[$k]['money'] = $v['money'];
            }
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $this->pagedata['month_data'] = $items;
            $this->pagedata['today_income'] = $today_coins;
            $this->pagedata['week_income'] = $seven_coins;
            $this->pagedata['month_income'] = $month_coins;
        }

        // 累计总收入
        if($all_money = K::M('ditui/member')->count_income(array('ditui_id'=>$this->ditui_id))) {
            $this->pagedata['all_money'] = $all_money;
        }
        $this->tmpl = 'ditui/tongji/mincome.html';
    }

    // 商户渠道推广收入
    public function sincome()
    {
        $sday = __TIME;
        $lday = __TIME - 31*86400;
        $filter = $month = array();
        $filter['ditui_id'] = $this->ditui_id;
        $filter['dateline'] = $lday.'~'.$sday;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Y-m-d', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'money'=>0);
        }
        if($month = K::M('ditui/shop')->ditui_income($filter,1,31)) {
            foreach($month as $k=>$v) {
                if($this->day_date == $k) {$today_coins = $v['money']; }         
                if($this->week_monday <= $k) {$seven_coins +=  $v['money']; }     
                if($this->month_firstday <= $k) {$month_coins += $v['money']; }   
                $items[$k]['money'] = $v['money'];
            }
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $this->pagedata['month_data'] = $items;
            $this->pagedata['today_income'] = $today_coins;
            $this->pagedata['week_income'] = $seven_coins;
            $this->pagedata['month_income'] = $month_coins;
        }

        // 累计总收入
        if($all_money = K::M('ditui/member')->count_income(array('ditui_id'=>$this->ditui_id))) {
            $this->pagedata['all_money'] = $all_money;
        }
        $this->tmpl = 'ditui/tongji/sincome.html';
    }

    public function member()
    {
        $sday = __TIME;
        $lday = __TIME - 31*86400;
        $filter = $month = $week = array();
        $filter['ditui_id'] = $this->ditui_id;
        $filter['dateline'] = $lday.'~'.$sday;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Y-m-d', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'uids'=>0);
        }
        if($month = K::M('ditui/member')->ditui_member($filter,1,31)) {  
            foreach($month as $k=>$v) {
                if($this->day_date == $k) {$today_uids = $v['uids']; }
                if($this->week_monday <= $k) {$seven_uids +=  $v['uids']; }
                if($this->month_firstday <= $k) {$month_uids += $v['uids']; }
                $items[$k]['uids'] = $v['uids'];
            }  
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $month_data = $items;
            $week_data = array_slice($items,-7); 
        }

        if($all_uids = K::M('ditui/member')->count($this->ditui_id)) {
            $this->pagedata['all_uids'] = $all_uids;
        }
  
        $this->pagedata['today_uids'] = $today_uids;
        $this->pagedata['seven_uids'] = $seven_uids;
        $this->pagedata['month_uids'] = $month_uids;
        $this->pagedata['month_data'] = $month_data;
        $this->pagedata['week_data'] = $week_data;
        $this->tmpl = 'ditui/tongji/member.html';
    }
 
    public function shop() 
    {   
        $sday = __TIME;
        $lday = __TIME - 31*86400;
        $filter = $month = $week = array();
        $filter['ditui_id'] = $this->ditui_id;
        $filter['dateline'] = $lday.'~'.$sday;
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Y-m-d', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('date'=>$date, 'shopids'=>0);
        }
        if($month = K::M('ditui/shop')->ditui_shop($filter,1,31)) {  
            foreach($month as $k=>$v) {
                if($this->day_date == $v['date']) {$today_shops = $v['shopids']; }
                if($this->week_monday <= $v['date']) {$seven_shops +=  $v['shopids']; }
                if($this->month_firstday <= $v['date']) {$month_shops += $v['shopids']; }
                $items[$k]['shopids'] = $v['shopids'];
            }  
            foreach($items as $k=>$v) {
                $items[$k]['date'] = "'".substr($v['date'],5,6)."'";
            }
            $month_data = $items;
            $week_data = array_slice($items,-7);   

        }
        if($all_shops = K::M('ditui/shop')->count($this->ditui_id)) {
            $this->pagedata['all_shops'] = $all_shops;
        }
        $this->pagedata['today_shops'] = $today_shops;
        $this->pagedata['seven_shops'] = $seven_shops;
        $this->pagedata['month_shops'] = $month_shops;
        $this->pagedata['month_data'] = $month_data;
        $this->pagedata['week_data'] = $week_data;
        $this->tmpl = 'ditui/tongji/shop.html';
    }

    // 根据当前时间戳获取本周第一天的日期
    public function this_monday($timestamp=0,$is_return_timestamp=true){  
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
        return date('Y-m-d', $cache[$id]);
    }

    // 获取最近7天日期
    public function near_seven()
    {
        for($i=7; $i>0; $i--) {
            $dates[$i] = date('Y-m-d', strtotime("-".$i. " days"));
        }
        return array_values($dates);
    }

    // 获取近一个月日期
    public function near_month()
    {
        for($i=31; $i>0; $i--) {
            $dates[$i] = date('Y-m-d', strtotime("-".$i. " days"));
        }
        return array_values($dates);
    }
}