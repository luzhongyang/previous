<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Order extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array();
        $orderby = array('order_id'=>'DESC');    
        if(in_array($params['status'], array(1, 2, 3))){
            switch ($params['status']) {
                case 1 : //待接单的
                    $filter['order_status'] = 0;
                    $filter['pei_type'] = array(0, 1);
                    $filter[':OR'] = array('pay_status'=>1, 'online_pay'=>0);
                    $orderby = array('order_id'=>'ASC');
                    break;
                case 2 : //进行中的
                    $filter['pei_type'] = array(0, 1);
                    $filter['order_status'] = array(1, 2, 3);
                    //$filter['staff_id'] = 0;
                    break;
                case 3 : //已完成的
                    $filter['pei_type'] = array(0, 1);
                    $filter['order_status'] = array(4,5,6,7,8);
                    //$filter['order_status'] = array(4,5,6,7,8);                    
                    break;
            }
        }
        $filter['closed'] = 0;
        $filter['shop_id'] = $this->shop_id;        
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($items = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $staff_ids = $order_ids = $staff_list = array();
            foreach($items as $k=>$v){
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['staff_id']){
                    $staff_ids[$v['staff_id']] = $v['staff_id'];
                }
                if($v['pei_time'] == 0) {
                    $items[$k]['pei_time'] = L('尽快送达');
                }
                $items[$k]['comment_info'] = array('comment_id'=>0,'shop_id'=>0,'uid'=>0,'order_id'=>0,'content'=>'','reply'=>'','reply_time'=>0,'dateline'=>0);
                // 管理员取消超时未付款的订单
                if(__TIME - $v['dateline'] > 1800) {
                    K::M('order/order')->cancel($v['order_id'], null, 'admin');
                }
            }
            if($order_ids){
                if($comment_list = K::M('shop/comment')->items(array('order_id'=>$order_ids), null, 1, $limit)){
                    foreach($comment_list as $k=>$v){
                        $items[$v['order_id']]['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,content,reply,reply_time,dateline', $v);
                    }
                }
            }
            if($staff_ids){
                $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);
            }
            foreach ($items as $k=>$v) {
                if($v['staff_id']){
                    $v['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', $staff_list[$v['staff_id']]);
                }else{
                    $v['staff'] = array('staff_id'=>'0','name'=>'','mobile'=>'','lng'=>'', 'lat'=>'');
                }
                $items[$k] = $v;
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            if($order['pei_type']>0 && $order['staff_id']){
                $staff = K::M('staff/staff')->detail($order['staff_id']);
                $order['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', (array)$staff);
            }else{
                $order['staff'] = array('staff_id'=>'0','name'=>'','mobile'=>'','lng'=>'', 'lat'=>'');
            }
            if(!$logs = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'ASC'))){
                $logs = array();
            }
            $order['logs'] = array_values($logs);
            if(!$products = K::M('order/product')->items(array('order_id'=>$order_id))){
                $products = array();
            }
            $order['products'] = array_values($products);
            if($complaint = K::M('order/complaint')->find(array('uid'=>$this->uid, 'order_id'=>$order_id))){
               $order['complaint'] = 1; 
            }else{
               $order['complaint'] = 0; 
            }   
            if($reply = K::M('shop/comment')->detail_by_order($order['order_id'])) {
                $order['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo', $reply);
                $reply['have_photo'] = 0;
                $reply['photo_list'] = array();
                if($photo_list = K::M('shop/photo')->items(array('comment_id'=>$reply['comment_id']), null, 1, 5)) {                    
                    foreach($photo_list as $k=>$v){
                        $reply['have_photo'] = 1;
                        $reply['photo_list'][] = $v['photo'];
                    }
                }
                $order['comment_info'] = $reply;
            }else{
                $order['comment_info'] = array('comment_id'=>0);
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('success');
        }        
    }

    public function jiedan($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($this->biz['verify_name'] != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可接单'), 214);
        }else if($order['online_pay'] && !$order['pay_status']){
            $this->msgbox->add(L('订单未支付不可接单'), 215);
        }else if((int)$order['order_status'] !== 0){
            $this->msgbox->add(L('订单状态不可接单'), 216);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>1,'lasttime'=>time()))){
            //订单日志
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('商家已接单'), 'type'=>'3'));
            $this->msgbox->add('success');
        }
    }

    //抢单
    public function qiang($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($this->biz['verify_name'] != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可抢送'), 214);
        }else if($order['staff_id']>0){
            $this->msgbox->add(L('配送员已经接单不可抢送'), 215);
        }else if($order['online_pay'] && !$order['pay_status']){
            $this->msgbox->add(L('订单未支付不可抢送'), 216);
        }else if(!in_array($order['order_status'], array(0, 1, 2))){
            $this->msgbox->add(L('订单状态不可抢送'), 217);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0))){
            //订单日志
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('商家自己开始配送'), 'type'=>3));
            $this->msgbox->add('success');
            $orderdetail = K::M('order/order')->detail($order_id);
            $this->msgbox->set_data('data', array('order'=>$orderdetail));
        }
    }

    public function cancel($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可取消'), 214);
        }else if($order['order_status'] != 0 ){
            $this->msgbox->add(L('订单状态不可取消'), 215);
        }else if(K::M('order/order')->cancel($order_id, $order, 'shop')){
            $this->msgbox->add('success');
        }
    }

    public function pei($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可抢送'), 214);
        }else if($order['staff_id']>0){
            $this->msgbox->add(L('配送员已经接单不可操作'), 214);
        }else if(!in_array($order['order_status'], array(1,2))){
            $this->msgbox->add(L('订单状态不可发货'), 215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0, 'lasttime'=>__TIME))){
            //订单日志 v-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('商家开始配送'), 'type'=>4));
            $this->msgbox->add('success');
            $orderdetail = K::M('order/order')->detail($order_id);
            $this->msgbox->set_data('data', array('order'=>$orderdetail));
        }
    }

    public function delivered($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($order['staff_id']>0){
            $this->msgbox->add(L('订单由配送员配送不可操作'), 214);
        }else if((int)$order['order_status'] !== 3 ){
            $this->msgbox->add(L('订单状态不可设置为已送达'), 215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'lasttime'=>__TIME))){
            //订单日志 v-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('订单已送达'), 'type'=>5));
            $this->msgbox->add('success');
        }
    }

    public function batch($params)
    {

    }

    //订单提醒
    public function tixing($params)
    {
        $this->check_login();
        if(!$dateline = (int)$params['dateline']){
            //如果没有传时间戳设置为15分钟前
            $dateline = __TIME - 900;
        }
        //$lasttime = K::M('order/order')->get_last_dateline();
        $filter = array('shop_id'=>$this->shop_id,'order_status'=>0,'lasttime'=>">:".$dateline);
        $filter[':OR'] =  array('pay_status'=>1, 'online_pay'=>0);
        $filter['pei_type'] = array(0, 1);
        $filter['closed'] = 0;
        $new_order = (int)K::M('order/order')->count($filter);
        $cui_order = (int)K::M('order/order')->count(array('shop_id'=>$this->shop_id, 'pei_type'=>array(0,1), 'cui_time'=>">:".$dateline, 'order_status'=>array(1,2,3,4),'closed'=>0));
   
        $new_msg = (int)K::M('shop/msg')->items(array('shop_id'=>$this->shop_id, 'dateline'=>">:".$dateline, 'is_read'=>0));
        
        $this->msgbox->set_data('data', array('new_order'=>$new_order, 'cui_order'=>$cui_order, 'new_msg'=>$new_msg, 'dateline'=>__TIME));
        $this->msgbox->add('success');
    }    

}
