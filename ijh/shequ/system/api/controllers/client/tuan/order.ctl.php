<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 * check view code by shzhrui
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Tuan_Order extends Ctl
{

    public function create($params)
    {
        $this->check_login();
        if(!$tuan_id = $params['tuan_id']) {
            $this->msgbox->add('商品不能为空',224);
        }else if(!$tuan_detail = K::M('tuan/tuan')->detail($tuan_id)) {
            $this->msgbox->add('商品不存在',225);
        // }else if(empty($tuan_detail['audit'])){
        //     $this->msgbox->add('商品审核中不可下单',226);
        }else if(!$shop_detail = K::M('shop/shop')->detail($tuan_detail['shop_id'])){
            $this->msgbox->add('商家不存在或已经删除',222);
        }else if(empty($shop_detail['audit'])){
            $this->msgbox->add('商家审核中不可下单',223);
        }else if(!$number = (int)$params['nums']) {
            $this->msgbox->add('商品数量不正确',227);
        }else if($tuan_detail['max_buy'] < $number){
            $this->msgbox->add('不能超过最大购买数',230);
        }else if($tuan_detail['min_buy'] > $number){
            $this->msgbox->add('不能低于最小购买数',231);
        }else if($tuan_detail['stock_type'] ==1 && ($tuan_detail['stock_num']< $number)){
            $this->msgbox->add('商品库存不足',229);
        }else if((__TIME < $tuan_detail['stime']) || (__TIME > $tuan_detail['ltime'])) {
            $this->msgbox->add('当前不在团购有效期时间内', 230);
        }else {
            $amount = $tuan_detail['price'] * $number;           
            $data = array(
                'city_id'            => $shop_detail['city_id'],
                'shop_id'            => $shop_detail['shop_id'],
                'staff_id'           => 0,
                'uid'                => $this->uid,
                'from'               => 'tuan',
                'total_price'        => $amount,
                'amount'             => $amount,
                'mobile'             => $this->MEMBER['mobile'],
                'contact'            => $this->MEMBER['nickname'],
                $data['order_from']  => strtolower(CLIENT_OS)
            );
            if($order_id = K::M('order/order')->create($data)){
                $data_tuan = array(
                    'order_id'          => $order_id,
                    'tuan_id'           => $tuan_id,
                    'tuan_title'        => $tuan_detail['title'],
                    'tuan_price'        => $tuan_detail['price'],
                    'tuan_photo'        => $tuan_detail['photo'],
                    'tuan_number'       => $number,
                    'ltime'             => $tuan_detail['ltime'],
                    'type'              => $tuan_detail['type'],
                );
                //创建订单团购扩展表
                K::M('tuan/order')->create($data_tuan);
                //更新销量
                K::M('tuan/tuan')->update_count($tuan_id, 'sales', $number);
                if($tuan_detail['stock_type'] ==1){  //启用库存机制时 更新已购数
                    K::M('tuan/tuan')->update_count($tuan_id,'sale_count', $number);
                    K::M('tuan/tuan')->update_count($tuan_id,'stock_num', -$number);
                }
                // 写入订单日志
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'member','log'=>'订单提交成功','status'=>1));
                // 给商户发送订单消息
                //K::M('shop/msg')->create(array('shop_id'=>$shop_id,'title'=>'订单已提交','content'=>'订单已提交','is_read'=>0,'type'=>1,'order_id'=>$order_id));
                // 更新用户订单量
                K::M('member/member')->update_count($this->uid, 'orders', 1);
                $this->msgbox->set_data('data', array('order_id' => $order_id));
            } else {
                $this->msgbox->add('创建订单失败', 411);
            }
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数错误',211);
        }else if(!$order = K::M('tuan/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消',214);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成不可取消',215);
        }else if(!$order['pay_status']){
            $this->msgbox->add('订单未支付无需退款',215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'member')){
            $this->msgbox->add('success');
        }       
    }
}
