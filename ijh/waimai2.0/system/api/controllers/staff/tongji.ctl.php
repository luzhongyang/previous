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
    /** 
     * 订单统计
     * @param $this->staff_id
     */
    public function order($params)
    {
        $this->check_login();
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',200);
        }else{
            $today_orders = $week_orders = $month_orders = $total_orders = 0;
            //总订单量
            $total_orders = K::M('order/order')->count(array('staff_id'=>$this->staff_id));
            //昨天时间戳
            $yesterday   = strtotime('-1day 11:59:59');
            //最近30天第一天
            $month_start = strtotime('-30day 00:00:00'); 
            //最近7天第一天
            $week_start = strtotime('-7day 00:00:00'); 
            //最近30天订单条件
            $filter = array(
                'staff_id'=>$this->staff_id, 
                'jd_time'=>'<=:'.$yesterday, 
                'jd_time'=>'>=:'.$month_start,
                'order_status' => 8//已经完成状态
            );
            //最近30天订单量
            $month_orders  = K::M('order/order')->count($filter);
            $month_data    = K::M('order/order')->items($filter);
            //输出数据
            $month         = array();
            //生成最近30天时间轴
            for($i=30;$i>=1;$i--){
                $month[date('Y-m-d', strtotime("-{$i}day"))] = 0;
            } 
            //生成30天数据
            foreach($month as $key=>$value){
                foreach($month_data as $k=>$v){
                    $timeline = date('Y-m-d', $v['jd_time']);
                    if($timeline == $key){
                        $month[$key]+=1;
                    }
                }
            }
            //最近7天订单条件
            $filter = array(
                'staff_id'=>$this->staff_id, 
                'jd_time'=>'<=:'.$yesterday, 
                'jd_time'=>'>=:'.$week_start,
                'order_status' => 8//已经完成状态
            );
            //最近7天订单量
            $week_orders  = K::M('order/order')->count($filter);
            $week_data    = K::M('order/order')->items($filter);
            //输出数据
            $week         = array();
            //生成最近7天时间轴
            for($i=7;$i>=1;$i--){
                $week[date('Y-m-d', strtotime("-{$i}day"))] = 0;
            } 
            //生成7天数据
            foreach($week as $key=>$value){
                foreach($week_data as $k=>$v){
                    $timeline = date('Y-m-d', $v['jd_time']);
                    if($timeline == $key){
                        $week[$key]+=1;
                    }
                }
            }
            //本日订单量
            $today_start = strtotime(date("Ymd"));
            $today_end   = strtotime(date("Ymd")." 23:59:59");
            $filter = array(
                'staff_id' => $this->staff_id, 
                'jd_time'=>">=:".$today_start, 
                'jd_time'=>'<=:'.$today_end
            );
            $today_orders  = K::M('order/order')->count($filter);

            $month_data = array();
            foreach($month as $key=>$v){
                $month_data['key'][] = $key;
                $month_data['value'][] = $v;
            }
            $week_data = array();
            foreach($week as $key=>$v){
                $week_data['key'][] = $key;
                $week_data['value'][] = $v;
            }

            $this->msgbox->set_data('data', array(
                'total_orders'=>$total_orders,
                'month_orders'=>$month_orders,
                'week_orders'=>$week_orders,
                'today_orders'=>$today_orders,
                'month_arr'=>$month_data,
                'week_arr'=>$week_data,
//                'sql'=>$this->system->db->SQLLOG()
            ));
        }
    }
    /**
     * 收入统计
     * @param $this->staff_id
     */
    public function amount($params)
    {
        $this->check_login();
        if(!$this->staff_id){
            $this->msgbox->add('参数不正确',200);
        }else{
            $total_save = $month_save = $week_save = $today_save = 0;
            //总共收入
            $filter = array('staff_id' => $this->staff_id);
            $total = K::M('staff/log')->items($filter);
            foreach($total as $item){
                if($item['money']>0){
                    $total_save += $item['money'];
                }
            }
            //昨天时间戳
            $yesterday   = strtotime('-1day 11:59:59');
            //最近30天第一天
            $month_start = strtotime('-30day 00:00:00'); 
            //最近7天第一天
            $week_start = strtotime('-7day 00:00:00'); 
            //最近30天订单条件
            $filter = array(
                'staff_id'=>$this->staff_id, 
                'dateline'=>'<=:'.$yesterday, 
                'dateline'=>'>=:'.$month_start,
            );
            //最近30天订单量
            $month_data    = K::M('staff/log')->items($filter);
            foreach($month_data as $item){
                if($item['money']>0){
                    $month_save += $item['money'];
                }
            }
            //输出数据
            $month         = array();
            //生成最近30天时间轴
            for($i=30;$i>=1;$i--){
                $month[date('Y-m-d', strtotime("-{$i}day"))] = 0;
            } 
            //生成30天数据
            foreach($month as $key=>$value){
                foreach($month_data as $k=>$v){
                    $timeline = date('Y-m-d', $v['dateline']);
                    if($timeline == $key){
                        $month[$key]+=$v['money'];
                    }
                }
            }
            //最近7天订单条件
            $filter = array(
                'staff_id'=>$this->staff_id, 
                'dateline'=>'<=:'.$yesterday, 
                'dateline'=>'>=:'.$week_start,
            );
            //最近7天订单量
            $week_data    = K::M('staff/log')->items($filter);
            foreach($week_data as $item){
                if($item['money']>0){
                    $week_save += $item['money'];
                }
            }
            //输出数据
            $week         = array();
            //生成最近7天时间轴
            for($i=7;$i>=1;$i--){
                $week[date('Y-m-d', strtotime("-{$i}day"))] = 0;
            } 
            //生成7天数据
            foreach($week as $key=>$value){
                foreach($week_data as $k=>$v){
                    $timeline = date('Y-m-d', $v['dateline']);
                    if($timeline == $key){
                        $week[$key]+=$v['money'];
                    }
                }
            }
            //本日订单量
            //今日收入
            $today_start = strtotime(date("Ymd"));
            $today_end   = strtotime(date("Ymd")." 23:59:59");
            $filter = array('staff_id' => $this->staff_id, 'dateline'=>">=:".$today_start, 'dateline'=>'<=:'.$today_end);
            $today  = K::M('staff/log')->items($filter);
            foreach($today as $item){
                if($item['money']>0){
                    $today_save += $item['money'];
                }
            }
            $month_data = array();
            foreach($month as $key=>$v){
                $month_data['key'][] = $key;
                $month_data['value'][] = $v;
            }
            $week_data = array();
            foreach($week as $key=>$v){
                $week_data['key'][] = $key;
                $week_data['value'][] = $v;
            }

            $this->msgbox->set_data('data', array(
                'total_save'=>$total_save,
                'month_save'=>$month_save,
                'week_save'=>$week_save,
                'today_save'=>$today_save,
                'month_detail'=>$month_data,
                'week_detail'=>$week_data
            ));
        }
    }
}