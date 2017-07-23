<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Tongji extends Ctl
{

    public function money($params)
    {
        $this->check_login();
        $sday = date('Ymd', __TIME);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('staff_id'=>$this->staff_id, 'money'=>'>:0' ,'day'=>$lday.'~'.$sday);
        $today_money = $week_money = $month_money = $total_money = 0;
        $items = array();
        for($i = 0; $i < 30; $i ++ ){
            $day = date('Ymd', __TIME - (30-$i)*86400);
            $date = date('Y-m-d', __TIME - (30-$i)*86400);
            $items[$day] = array('day'=>$day, 'date'=>$date, 'money'=>0);
        }
        if($count_list = K::M('staff/log')->count_by_day($filter,1,31)){
            foreach($count_list as $k=>$v){
                if($sday == $v['day']){
                    $today_money += $v['day_money'];
                }else{
                    if($week_day <= $v['day']){
                        $week_money += $v['day_money'];
                    }
                    $month_money += $v['day_money'];
                    $items[$k]['money'] = $v['day_money'];
                }
            }
            foreach($items as $k=>$v) {
                if(!$v['day'] && !$v['date']) {
                    unset($items[$k]);
                }
            }
        }
        $a = K::M('staff/log')->total_by_staff(array('staff_id'=>$this->staff_id, 'money'=>'>:0'));
        $total_money = (int)$a['total_money'];
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_money'=>$total_money, 'today_money'=>$today_money, 'week_money'=>$week_money,'month_money'=>$month_money));
    }

    public function order($params)
    {
        $this->check_login();
        $sday = date('Ymd', __TIME - 86400);
        $lday = date('Ymd', __TIME - 31*86400);
        $week_day = date('Ymd', __TIME - 8 * 86400);
        $filter = array('staff_id'=>$this->staff_id, 'order_status'=>8, 'day'=>$lday.'~'.$sday);
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
        $total_count = K::M('order/order')->count(array('staff_id'=>$this->staff_id,'order_status'=>8));
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$total_count,'today_count'=>$today_count, 'week_count'=>$week_count,'month_count'=>$month_count));
    }

    public function source($params)
    {
        $this->check_login();
        $filter['staff_id'] = $this->staff_id;
        $count = array('android_count'=>0, 'ios_count'=>0, 'weixin_count'=>0, 'wap_count'=>0);
        if($items = K::M('order/order')->orderfrom($filter)){
            foreach($items as $v){
                $count[$v['order_from'].'_count'] = $v['nums'];
            }
        }
        $this->msgbox->set_data('data', $count);
    }
}
