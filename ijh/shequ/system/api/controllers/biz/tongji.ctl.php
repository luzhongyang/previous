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

    public function money($params)
    {
        $this->check_login();
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('shop_id'=>$this->shop_id, 'order_status'=>8, 'day'=>$lday.'~'.$sday);
        $filter[':SQL'] = "pei_type!=2";//排除代购订单(代购订单，全部结算给配送员，属于线下营业款，线下数据不统计)  add by zhuhongwei 2016-11-28 20:08:52
        $today_money = $week_money = $month_money = $total_money = 0;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('day'=>$day, 'date'=>$date, 'count'=>0, 'money'=>0);
        }
        if($count_list = K::M('order/order')->count_by_day($filter, 1, 31)){
            foreach($count_list as $k=>$v){
                $dmoney = $v['day_money'] + $v['day_amount'] + $v['day_hongbao'] - $v['day_pei_money'];
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
        }
        foreach($items as $k=>$v) {
            if(!$v['day'] && !$v['date']) {
                unset($items[$k]);
            }
        }
        $total_money = $this->shop['total_money'];
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_money'=>$total_money, 'today_money'=>$today_money, 'week_money'=>$week_money,'month_money'=>$month_money));
    }

    public function order($params)
    {
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('shop_id'=>$this->shop_id, 'order_status'=>'>:0','day'=>$lday.'~'.$sday);
        $today_count = $week_count = $month_count = $total_count = 0;
        $total_count = $this->staff['orders'];
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('day'=>$day, 'date'=>$date, 'count'=>0);
        }

        if($count_list = K::M('order/order')->count_by_day($filter, 1, 31)){
            foreach($count_list as $k=>$v){
                if($sday == $v['day']){
                    $today_count += $v['day_order'];
                }else{
                    if($week_day <= $v['day']){
                        $week_count += $v['day_order'];
                    }
                    $month_count += $v['day_order'];
                    $items[$k]['count'] = $v['day_order'];
                }
            }
        }
        foreach($items as $k=>$v) {
            if(!$v['day'] && !$v['date']) {
                unset($items[$k]);
            }
        }
        $total_count = K::M('order/order')->count(array('shop_id'=>$this->shop_id,'order_status'=>'>:0'));
        if(CLIENT_OS == "ANDROID"){
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$total_count, 'today_count'=>$today_count, 'week_counts'=>$week_count,'month_counts'=>$month_count));
        }else{
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$total_count, 'today_count'=>$today_count, 'week_count'=>$week_count,'month_count'=>$month_count));
        }
    }

    public function source($params)
    {
        $today = date('Ymd', __TIME);
        $tweek = date('Ymd', __TIME - 8 * 86400);
        $tmonth = date('Ymd', __TIME - 31*86400); 
        $filter = array();
        $filter['order_status'] = '>:0';
        $filter['shop_id'] = $this->shop_id;
        
        $filter['day'] = $tmonth."~".$today;
        $count_month = array('android_count'=>0, 'ios_count'=>0, 'weixin_count'=>0, 'wap_count'=>0);
        if($month = K::M('order/order')->orderfrom($filter)) {  
            foreach($month as $v){
                $count_month[$v['order_from'].'_count'] = $v['nums'];
            }
        }

        $filter['day'] = $tweek."~".$today;
        $count_week = array('android_count'=>0, 'ios_count'=>0, 'weixin_count'=>0, 'wap_count'=>0);
        if($week = K::M('order/order')->orderfrom($filter)){
            foreach($week as $v){
                $count_week[$v['order_from'].'_count'] = $v['nums'];
            }
        }
        $this->msgbox->set_data('data', array('month_count'=>$count_month, 'week_count'=>$count_week));
    }
    
    public function sales($params){

        $week = __TIME - 8 * 86400;
        $month = __TIME - 30*86400;
        $week_items = K::M('order/order')->ordersale($this->shop_id,$week);
        $month_items = K::M('order/order')->ordersale($this->shop_id,$month);

        $this->msgbox->set_data('data', array('month_items'=>array_values($month_items),'week_items'=>array_values($week_items)));
        
    }

}


