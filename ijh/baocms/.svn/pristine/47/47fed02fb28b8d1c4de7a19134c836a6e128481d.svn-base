<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class HotelorderModel extends CommonModel{
    protected $pk   = 'order_id';
    protected $tableName =  'hotel_order';
    
    public function cancel($order_id){
        if(!$order_id = (int)$order_id){
            return false;
        }elseif(!$detail = $this->find($order_id)){
            return false;
        }else{
            if($detail['online_pay'] == 1&&$detail['order_status'] == 1){
                $detail['is_fan'] = 1;
            }
            $room = D('Hotelroom')->find($detail['room_id']);
            if(!$room['is_cancel']){
                return false;
            }
            if(false !== $this->save(array('order_id'=>$order_id,'order_status'=>-1))){
                if($detail['is_fan'] == 1){
                    D('Users')->addMoney($detail['user_id'],(int)$detail['amount']*100,'酒店订单取消,ID:'.$order_id.'，返还余额');
                }
                D('Hotelroom')->updateCount($detail['room_id'],'sku',$detail['num']);
                return true;
            }else{
                return false;
            }
            
        }  
    }
     
    public function plqx($hotel_id){
        if($hotel_id = (int)$hotel_id){
            $ntime = date('Y-m-d',NOW_TIME);
            $map['stime'] = array('LT',$ntime);
            $map['hotel_id'] = $hotel_id;
            $order = $this->where($map)->select();
            foreach ($order as $k=>$val){
                $this->cancel($val['order_id']);
            }
            return true;
        }else{
            return false;
        }
    }
    
    public function complete($order_id){
        if(!$order_id = (int)$order_id){
            return false;
        }elseif(!$detail = $this->find($order_id)){
            return false;
        }else{
            $shop = D('Shop')->find($detail['shop_id']);
            if($detail['online_pay'] == 1&&$detail['order_status'] == 1){
                $detail['is_fan'] = 1;
            }
            $room = D('Hotelroom')->find($detail['room_id']);
            if(!$room['is_cancel']){
                return false;
            }
            if(false !== $this->save(array('order_id'=>$order_id,'order_status'=>2))){
                if($detail['is_fan'] == 1){
                    D('Users')->addMoney($shop['user_id'], $detail['jiesuan_amount']*100, '酒店订单完成,ID:'.$order_id.'，结算金额');
                }
                return true;
            }else{
                return false;
            }
            
        }  
    }
    
}