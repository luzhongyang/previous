<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Quan extends Ctl_Biz
{
 
    public function get($params)
    {
       if(!$params['code']){
           $this->msgbox->add(L('参数错误'), 213);
       }else{
           $number = $params['code'];
           $first_code = substr($number, 0, 1);
           if($first_code == '2'){
                if(!$ticket = K::M('tuan/ticket')->find(array('number'=>$number))){
                    $this->msgbox->add('无效的团购券',212);
                }else if($ticket['shop_id'] != $this->shop_id){
                    $this->msgbox->add(L('无效的团购券'), 212);
                }else if($ticket['ltime'] < __TIME){ //过期
                    $this->msgbox->add('团购券已过期',213);
                }else if($ticket['status'] < 0){
                    $this->msgbox->add('团购券已退款',214);
                }else if($ticket['status'] > 0){
                    $this->msgbox->add('团购券已使用',215);
                }else if(!$order = K::M('tuan/order')->detail($ticket['order_id'])){
                    $this->msgbox->add('订单不存在或已删除',214);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add('订单已取消', 217);
                }else{
                    if(CLIENT_OS == 'ANDROID'){
                        $this->msgbox->set_data('data',array('tuan_order'=>$order,'tuan'=>$ticket)); 
                    }else{
                        $this->msgbox->set_data('data',array('result'=>$order, 'tuan_order'=>$order,'tuan'=>$ticket));
                    }
                    
                }
           }else if($first_code == '1'){
                if(!$order = K::M('waimai/order')->detail_by_number($number)){
                    $this->msgbox->add(L('无效的自提码'), 218);
                }else if($order['shop_id'] != $this->shop_id){
                     $this->msgbox->add(L('无效的自提码'), 219);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add(L('订单已取消'), 220);
                }else if($order['spend_status']){
                    $this->msgbox->add(L('自提码已使用'), 221);
                }else{
                    $order = $this->filter_fields('order_id,hongbao_id,first_youhui,order_youhui,contact,mobile,intro,total_price,hongbao,amount,spend_number,spend_status,dateline', $order);
                    $product_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id']));
                    $data= array('product_list'=>array_values($product_list), 'waimai'=>array('order'=>$order, 'spend_number'=>$order['spend_number'], 'order_id'=>$order['order_id']));
                    if(CLIENT_OS == 'ANDROID'){
                    $this->msgbox->set_data('data', $data);
                    }else{
                        $data['result'] = $data['product_list'];
                        $this->msgbox->set_data('data', $data);
                    }
                }
            }else{
                $this->msgbox->add('无效的券',212);
            }
        }
    }

    public  function set($params)
    {
        if(!$params['code']){
           $this->msgbox->add('参数错误', 213);
        }else{
           $number = $params['code'];
           $first_code = substr($number, 0, 1);
           if($first_code == '2'){
                if(!$ticket = K::M('tuan/ticket')->detail_by_number($number)){
                    $this->msgbox->add('无效的团购券',212);
                }else if($ticket['shop_id'] != $this->shop_id){
                     $this->msgbox->add(L('无效的团购券'), 212);
                }else if($ticket['ltime'] < __TIME){ //过期
                    $this->msgbox->add('团购券已过期',213);
                }else if($ticket['status'] < 0){
                    $this->msgbox->add('团购券已退款',214);
                }else if($ticket['status'] > 0){
                    $this->msgbox->add('团购券已使用',215);
                }else if(!$order = K::M('tuan/order')->detail($ticket['order_id'])){
                    $this->msgbox->add('订单不存在或已删除', 216);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add('订单已取消', 217);
                }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                    if(K::M('tuan/ticket')->update($ticket['ticket_id'], array('use_time'=>__TIME, 'status'=>1))){
                        $title = sprintf("您的券已经被商家核销", $order['title'], $order['order_id']);
                        $content = sprintf("您购买[%s]的券(%s)已被商家核销", $order['title'], $order['order_id'], $ticket['number']);
                        K::M('member/member')->send($order['uid'], $title, $content,  'order', $order['order_id']);                        
                        $this->msgbox->add(L('核销券成功'));
                    }else{
                         $this->msgbox->add(L('核销券失败'), 216);
                    }
                }else{
                    $this->msgbox->add(L('核销券失败'), 217);
                }
           }else if($first_code == '1'){
                if(!$order = K::M('waimai/order')->detail_by_number($number)){
                    $this->msgbox->add(L('无效的自提码'), 218);
                }else if($order['shop_id'] != $this->shop_id){
                     $this->msgbox->add(L('无效的自提码'), 219);
                }else if($order['order_status'] < 0){
                    $this->msgbox->add(L('订单已取消'), 220);
                }else if($order['spend_status']){
                    $this->msgbox->add(L('自提码已使用'), 221);
                }else if($order['order_status'] == 8){
                    $this->msgbox->add(L('自提码已使用'), 221);
                }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                    if(K::M('waimai/order')->update($order['order_id'], array('spend_status'=>1))){
                        $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                        $title = sprintf("您在[%s]的自体订单完成", $waimai['title'], $order['order_id']);
                        $content = sprintf("您在[%s]的订单(单号：%s)自提码(%s)已使用", $waimai['title'], $order['order_id'], $order['spend_number']);
                        K::M('member/member')->send($order['uid'], $title, $content,  'order', $order['order_id']);
                        $this->msgbox->add(L('核销码成功'));
                    }else{
                       $this->msgbox->add(L('核销码失败'), 222); 
                    }

                }else{
                    K::M('system/logs')->log('biz.quan.set', array($this->system->db->SQLLOG(), $order));
                    $this->msgbox->add(L('核销码失败'), 223);
                }
            }else{
                $this->msgbox->add('无效的券',212);
            }
       }
    }


}