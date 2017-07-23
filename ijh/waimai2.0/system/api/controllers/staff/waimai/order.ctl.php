<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Waimai_Order extends Ctl_Staff
{

    protected $_all_fields = 'order_id,shop_id,staff_id,uid,from,order_status,online_pay,pay_status,trade_no,total_price,hongbao_id,hongbao,order_youhui,first_youhui,money,amount,o_lng,o_lat,contact,mobile,addr,house,lng,lat,day,intro,order_from,dateline,cui_time,comment_status,jd_time,pay_code,pay_time,pei_type,pei_amount,pei_time,o_addr,o_house,paotui_amount,jiesuan_price,danbao_amount,order_status_label,order_status_warning,shop_name';



    /**
     * 订单详情
     * @param $order_id     int
     */
    public function detail($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] > 0 && $order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else{
            $order = $this->filter_fields($this->_all_fields, $order);
            if($order['pei_time']){
                $order['pei_time_label'] = '预计'.date('H:i',$order['pei_time']).'送达';
            }else{
                $order['pei_time_label'] = '尽快送达';
            }
            $order['products'] = $order['photos'] = $order['logs'] = array();
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array('shop_id'=>0, 'title'=>'', 'phone'=>'', 'logo'=>'default/waimai_shop.png', 'addr'=>'');
            }else{
                $shop = $this->filter_fields('shop_id,title,phone,logo,addr,lng,lat',$shop);
                $order['shop'] = $shop;
            }
            if($product_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id), null, 1, $limit,$count)){
                foreach($product_list as $k=>$v) {
                    if($v['spec_id']) {
                        $spec_ids[$v['spec_id']] = $v['spec_id'];
                    }
                }
                $spec_items = K::M('waimai/productspec')->items_by_ids($spec_ids);
                foreach($product_list as $k=>$v) {
                    $product_list[$k]['spec_name'] = '';
                    if($v['spec_id']) {
                        $product_list[$k]['spec_name'] = $spec_items[$v['spec_id']]['spec_name'];
                    }
                }
                
                $order['products'] = array_values($product_list);
            }
            if($logs = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'DESC'))){
                $order['logs'] = array_values($logs);
            }
            //comment_id,order_id,staff_id,uid,score,content,reply,reply_ip,reply_time,clientip,dateline
            $comment_info = array('comment_id'=>0,'order_id'=>0,'staff_id','uid'=>0,'score'=>0,'content'=>'','reply'=>'','reply_time'=>0,'dateline'=>0);
            $comment_info['photos'] = array();
            $comment_info['member_face'] = 'default/face.png';
            $comment_info['member_name'] = '';
            if($comment = K::M('staff/comment')->find(array('order_id'=>$order_id))){
                $comment_info = $this->filter_fields('comment_id,order_id,staff_id,uid,score,content,reply,reply_time,dateline', $comment);
                if($photos = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    foreach($photos as $v){
                        $comment_info['photos'][] = $v['photo'];
                    }
                }
                if($member = K::M('member/member')->member($order['uid'])){
                    $comment_info['member_face'] = $member['face'];
                    $comment_info['member_name'] = $member['nickname'];
                }                
            }
            $order['comment_info'] = $comment_info;
            $juliobj = K::M('helper/round');
            $order['juli_quancheng'] = $juliobj->getdistance($this->staff['lng'], $this->staff['lat'], $order['lng'], $order['lat']);
            $order['juli_qidian'] = $juliobj->getdistance($this->staff['lng'], $this->staff['lat'], $order['o_lng'], $order['o_lat']);
            $order['juli_zhongdian'] = $juliobj->juli($this->staff['lng'], $this->staff['lat'], $order['lng'], $order['lat']);
            if($order['juli_zhongdian'] >= 1000) {
                $order['juli_zhongdian'] = round(intval($order['juli_zhongdian']/1000).'.'.($order['juli_zhongdian']%1000), 2).'km';
            }else {
                $order['juli_zhongdian'] = round($order['juli_zhongdian'], 2).'m';
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('SUCCESS');
        }
    }

    //抢单
    public function qiang($params)
    {
        $verify = K::M('staff/verify')->detail($this->staff_id);
        $is_verify = isset($verify['verify'])?$verify['verify']:0;
        
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if($is_verify != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if(empty($order['online_pay'])){
            $this->msgbox->add(L('货到付款订单不可配送'),212);
        }else if(empty($order['pay_status'])){
            $this->msgbox->add(L('订单未支付不可抢单'),213);
        //货到付款可以接单 开始
//        }else if(  !( 0==$order['online_pay'] &&  0==$order['pay_status']) || 0==$order['pay_status']  ){
//            $this->msgbox->add(L('订单未支付不可抢单'),212);
//        //货到付款可以接单 结束
        }else if($order['pei_type'] == 2 && !empty($order['order_status'])){
            $this->msgbox->add(L('该订单不可抢单'),213);
        }else if($order['pei_type'] != 1 && in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add(L('该订单不可抢单'),213);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add(L('订单已经被抢走'),214);
        }else if($this->staff['audit'] != 1){
            $this->msgbox->add('您还没有通过审核不能接单', 216);
        }else if(K::M('order/order')->update($order_id, array('staff_id'=>$this->staff_id, 'order_status'=>2))){
            //增加订单统计
            K::M('staff/staff')->update_count($this->staff_id, 'orders', 1);
            //记录订单日志
            $log = array('order_id'=>$order_id,'from'=>'staff','log'=>sprintf(L('骑手(%s)准备为您配送'), $this->staff['name']),'type'=>3);
            K::M('order/log')->create($log);
            //通知会员
            K::M('order/order')->send_member("骑手已接单", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }


    /**
     * 取消接单
     * @param $order_id
     */
    public function cancel($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$reason=$params['reason']){
            $this->msgbox->add('未指定取消原因',212);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else if(!in_array($order['order_status'], array(1,2,3,4))){
            $this->msgbox->add('订单状态不可取消', 214);
        }else{
            //修改订单状态为配货完成待接单状态
            $a = array('order_status'=>2, 'lasttime'=>__TIME, 'staff_id'=>0);
            if($order['pei_type'] == 2){
                $a['order_status'] = 0;
            }
            if(K::M('order/order')->update($order_id, $a)){
                // $log = array('order_id'=>$order_id,'from'=>'staff','log'=>'骑手取消原因：'.$reason,'dateline'=>__TIME,'type'=>$a['order_status']);
                // K::M('order/log')->create($log);
                $log_items1 = K::M('order/log')->items(array('order_id'=>$order_id,'from'=>'staff','type'=>array(2,3,4)));
                foreach($log_items1 as $k=>$v) {
                    K::M('order/log')->delete($v['log_id'],true);
                }
                $log_items2 = K::M('order/log')->items(array('order_id'=>$order_id,'from'=>'shop','type'=>4));
                foreach($log_items2 as $k=>$v) {
                    K::M('order/log')->delete($v['log_id'],true);
                }
                //通知会员
                K::M('order/order')->send_member("骑手取消订单", $log['log'], $order);
                $this->msgbox->add('SUCCESS');
            }
        }
    }


    //订单开始配送
    public function pei($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',212);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单',213);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add(L('该订单不可配送'),213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'lasttime'=>__TIME))){
            //记录订单日志
            $log = array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('骑手(%s)开始为您配送'), $this->staff['name']), 'type'=>'4');
            K::M('order/log')->create($log);
            //通知会员
            K::M('order/order')->send_member("开始配送", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    //订单送达
    public function delivered($params)
    {
        $this->finshed($params);
    }
    public function finshed($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',212);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单',213);
        }else if(!in_array($order['order_status'], array(2,3))){
            $this->msgbox->add('订单状态不可设置送达', 213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'lasttime'=>__TIME))){
            //记录订单日志
            $log = array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('骑手(%s)已经为您送达'), $this->staff['name']), 'type'=>'4');
            K::M('order/log')->create($log);
            //通知会员
            K::M('order/order')->send_member("订单配送完成", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
            $this->msgbox->add('SUCCESS');
        }
    }

}