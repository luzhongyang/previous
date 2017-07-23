<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Member_Coupon extends Ctl
{

    public function index($params)
    {
        $this->items($params);
    }

    public function items($params)
    { //status 0:全部，1:可用,2:不可用;
        $this->check_login();
        $filter = array();
        if(!$params['status']){
            $params['status'] = 0;
        }
        if(in_array($params['status'], array(0,1,2))){
            // if($params['status'] == 1){ //未使用
            //     $filter['order_id'] = 0;
            //     $filter['ltime'] = '>=:'.time();
            // }else if($params['status'] == 2){ //已使用或过期
            //      $filter[':OR'] = array('order_id'=>'>:0','ltime'=>'<:'.time());
            // }
            $filter['order_id'] = 0;
            $filter['use_time'] = 0;
            $filter['status'] = 0;
            $filter['ltime'] = '>=:' . __TIME;

        }
        
        if($params['price']){
            $filter['order_amount'] = '<=:'.$params['price'];
        }
        
        if($params['shop_id']){
            $filter['shop_id'] = (int)$params['shop_id'];
        }
        $count = K::M('member/coupon')->count($filter);
        $filter['uid'] = $this->uid;
        $page = max((int)$params['page'], 1);
        if($items = K::M('member/coupon')->items($filter, null, $page, 20,$count)){
            $ids = array();
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('cid,coupon_id,uid,use_time,order_id,status,dateline,ltime,order_amount,coupon_amount,shop_id',$v);
                $ids[$v['shop_id']] = $v['shop_id'];
            }
            $shops = K::M('shop/shop')->items_by_ids($ids);
            foreach($items as $kk => $vv){
                $items[$kk]['title'] = $shops[$vv['shop_id']]['title'];
                $items[$kk]['logo'] = $shops[$vv['shop_id']]['logo'];
            }
        }else{
            $items = array();
        }
        K::M('system/logs')->log('coupon',$this->system->db->SQLLOG());
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items),'total_count'=>$count));
    }

    
    public function get($params){ //领取优惠券
        $this->check_login();
        if(!$coupon_id = $params['coupon_id']){
            $this->msgbox->add(L('错误的优惠券！'),213);
        }else if(!$coupon = K::M('shop/coupon')->detail($coupon_id)){
            $this->msgbox->add(L('错误的优惠券！'),214);
        }else if($coupon['sku'] == 0){
            $this->msgbox->add(L('该优惠券被领光了！'),215);
        }else if($coupon['ltime'] <= time()){
            $this->msgbox->add(L('优惠券已过期！无法领取！'),216);
        }else if($my_coupon = K::M('member/coupon')->find(array('coupon_id'=>$coupon['coupon_id'],'uid'=>$this->uid))){
            $this->msgbox->add(L('您已经领取过该优惠券了！'),217);
        }else{
            $data['coupon_id'] = $coupon['coupon_id'];
            $data['uid'] = $this->uid;
            $data['use_time'] = 0;
            $data['order_id'] = 0;
            $data['status'] = 0;
            $data['order_amount'] = $coupon['order_amount'];
            $data['coupon_amount'] = $coupon['coupon_amount'];
            $data['ltime'] = $coupon['ltime'];
            $data['shop_id'] = $coupon['shop_id'];
            if($cid = K::M('member/coupon')->create($data)){
                K::M('shop/coupon')->update_count($coupon['coupon_id'], 'sku', -1);
                K::M('shop/coupon')->update_count($coupon['coupon_id'], 'picked', 1);
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('cid'=>$cid));
            }else{
                $this->msgbox->add('领取失败',300);
            }
        }
    }


}
