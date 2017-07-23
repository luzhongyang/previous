<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Order_Order extends Ctl_Biz
{

    public function items($params)
    {
        $filter = array();
        $orderby = array('order_id'=>'DESC');
        $day = (int)$params['day'];
        $today = strtotime(date('Y-m-d'));
        if($day == 1){
            $filter['dateline'] = '>:'.$today;
        }else if($day == 2){
            $filter['dateline'] = '<=:'.$today;
        }
        if(in_array($params['status'], array(1, 2, 3))){
            switch ($params['status']) {
                case 1 : //待接单的
                    $filter['order_status'] = 0;
                    $filter['pei_type'] = array(0, 1, 3);
                    $filter[':OR'] = array('pay_status'=>1, 'online_pay'=>0);
                    $orderby = array('order_id'=>'ASC');
                    break;
                case 2 : //进行中的
                    $filter['pei_type'] = array(0,1,3);
                    $filter['order_status'] = array(1,2,3,4);
                    //$filter['staff_id'] = 0;
                    break;
                case 3 : //已完成的
                    $filter['pei_type'] = array(0,1,3);
                    $filter['order_status'] = array(5,6,7,8);
                    //$filter['order_status'] = array(4,5,6,7,8);                    
                    break;
            }
        }
        $filter['closed'] = 0;
        $filter['from'] = 'waimai';
        $filter['shop_id'] = $this->shop_id;        
        $page = max((int)$params['page'], 1);
        $limit = 10;
         $items = array();
        if($order_list = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $staff_ids = $order_ids = $staff_list = $uids = array();
            foreach($order_list as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['staff_id']){
                    $staff_ids[$v['staff_id']] = $v['staff_id'];
                }
                if($v['pei_time'] == 0) {
                    $v['pei_time_label'] = L('尽快送达');
                }else{
                    $v['pei_time_label'] = date("H:i", $v['pei_time']);
                }
                $v['comment_info'] = array('comment_id'=>0,'shop_id'=>0,'uid'=>0,'order_id'=>0,'content'=>'','reply'=>'','reply_time'=>0,'dateline'=>0);
                // 管理员取消超时未付款的订单
                if(__TIME - $v['dateline'] > 1800 && $v['pay_status'] == 0) {
                    if(K::M('order/order')->cancel($v['order_id'], null, 'system')){
                        $v['status'] = -1;
                    }
                }
                $order_list[$k] = $v;
            }
            $member_list = K::M('member/member')->items_by_ids($uids);
            $waimai_order_list = K::M('waimai/order')->items_by_ids($order_ids);   
            if($staff_ids){
                $staff_list = K::M('staff/staff')->items_by_ids($staff_ids);
            }
            $cui_count_list = K::M('order/cuilog')->count_by_order(array('order_id'=>$order_ids));
            $order_ids = array();
            foreach ($waimai_order_list as $k=>$v) {
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['staff_id']){
                    $v['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', $staff_list[$v['staff_id']]);
                }else{
                    $v['staff'] = array('staff_id'=>'0','name'=>'','mobile'=>'','lng'=>'', 'lat'=>'');
                }
                if(!$order['spend_status']){
                    $order['spend_number'] = '';
                }
                $v['products'] = array();
                $items[$k] = array_merge($order_list[$v['order_id']], $v);
                $items[$k]['shop_title'] = $items[$k]['waimai_title'] = $this->shop['title'];
                if($waimai = K::M('waimai/waimai')->detail($this->shop_id)){
                    $items[$k]['waimai_title'] = $waimai['title'];
                }                
                $items[$k]['cui_count'] = (int)$cui_count_list[$v['order_id']]['cui_count'];
                $items[$k]['juli'] = K::M('helper/round')->getdistance($v['lng'], $v['lat'], $this->shop['lng'], $this->shop['lat']);
            }
            if($product_list = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids), null, 1, 500)){
                foreach($product_list as $k=>$v){
                    $items[$v['order_id']]['products'][] = $v;
                }
            }
            if($comment_list = K::M('waimai/comment')->items(array('order_id'=>$order_ids), null, 1, 10)){
                foreach($comment_list as $k=>$v){
                    $items[$v['order_id']]['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,content,reply,reply_time,dateline', $v);
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
    }

    public function detail($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            if($order['staff_id'] && ($staff = K::M('staff/staff')->detail($order['staff_id']))){
                $order['staff'] = $this->filter_fields('staff_id,name,mobile,lng,lat', $staff);
            }else{
                $order['staff'] = array('staff_id'=>'0', 'name'=>'', 'mobile'=>'', 'lng'=>'', 'lat'=>'');
            }
            if($member = K::M('member/member')->detail($order['uid'])){
                $order['member'] = array('uid'=>$member['uid'], 'nickname'=>$member['nickname'], 'face'=>$member['face']);
            }else{
                $order['member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
            }

            if(!$logs = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'ASC'))){
                $logs = array();
            }
            $order['logs'] = array_values($logs);
            if(!$products = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id))){
                $products = array();
            }
            $order['products'] = array_values($products);
            if($complaint = K::M('order/complaint')->find(array('uid'=>$this->uid, 'order_id'=>$order_id))){
               $order['complaint'] = 1; 
            }else{
               $order['complaint'] = 0; 
            }
            if(!$order['spend_status']){
                $order['spend_number'] = '';
            }
            if($order['pei_time'] == 0) {
                $order['pei_time_label'] = L('尽快送达');
            }else{
                $order['pei_time_label'] = date("H:i", $order['pei_time']);
            }
            $order['shop_title'] = $order['waimai_title'] = $this->shop['title'];
            if($waimai = K::M('waimai/waimai')->detail($this->shop_id)){
                $order['waimai_title'] = $waimai['title'];
            }  
            if($reply = K::M('waimai/comment')->find(array('order_id'=>$order['order_id']))) {
                $order['comment_info'] = $this->filter_fields('comment_id,shop_id,uid,order_id,score,score_fuwu,score_kouwei,pei_time,content,have_photo,reply,reply_ip,reply_time,dateline,mobile,face,photo', $reply);
                $reply['pei_time_label'] = $reply['pei_time'].'分钟送达';
                $reply['have_photo'] = 0;
                $reply['photo_list'] = array();
                if($photo_list = K::M('waimai/commentphoto')->items(array('comment_id'=>$reply['comment_id']), null, 1, 5)) {                    
                    foreach($photo_list as $k=>$v){
                        $reply['have_photo'] = 1;
                        $reply['photo_list'][] = $v['photo'];
                    }
                }
                $reply['member'] = $order['member'];
                // if($order['pei_time'] == 0) {
                //     $reply['pei_time_label'] = date("H:i", $order['dateline']+$reply['pei_time']*60);
                // }else{
                //     $reply['pei_time_label'] = date("H:i", $order['pei_time']+$reply['pei_time']*60);
                // }
                $order['comment_info'] = $reply;
            }else{
                $order['comment_info'] = array('comment_id'=>0, 'member'=>$order['member']);
            }
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('success');
        }        
    }
    
    //商户端用于更新订单列表中的订单状态刷新
    public function mdetail($params)
    {
        $limit = 100;
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            // $order = $this->filter_fields('order_id,dateline,online_pay,contact,mobile,addr,intro,pei_time,cui_time,comment_info,staff,order_status_label,order_status_warning,pei_type,is_daofu,order_status,house',$order);
            $order['cui_count'] = K::M('order/cuilog')->count(array('order_id'=>$order['order_id']));
            $order['juli'] = K::M('helper/round')->getdistance($order['lng'], $order['lat'], $this->shop['lng'], $this->shop['lat']);
            $order['comment_info'] = K::M('shop/comment')->items(array('order_id'=>$order['order_id']), null, 1, $limit);
            $order['staff'] = K::M('staff/staff')->detail($order['staff_id']);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',$order);
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
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($this->shop['verify_name'] != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可接单'), 214);
        }else if($order['online_pay'] && !$order['pay_status']){
            $this->msgbox->add(L('订单未支付不可接单'), 215);
        }else if((int)$order['order_status'] !== 0){
            $this->msgbox->add(L('订单状态不可接单'), 216);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>1,'lasttime'=>time()))){
            //自动打印订单判断 todo...

            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','status'=>1);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('商家已经接单', sprintf("您在[%s]下的订单(%s)，商家已接单", $this->shop['title'], $order_id), $order);
            $this->msgbox->add('success');
        }
    }

    public function setpei($params)
    {

        $pei_type = $params['pei_type'] ? 1 : 0;
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在或已被删除',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add('非法操作',212);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('已有骑手接单不可操作',212);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(K::M('order/order')->update($order_id, array('pei_type'=>$pei_type, 'lasttime'=>__TIME))){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
            $this->msgbox->add('SUCCESS');
        } 
    }

    //抢单
    public function qiang($params)   //分配给配送员的订单，抢单接口
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在或已被删除'), 212);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($this->shop['verify_name'] != 1){
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
            $log = array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('订单由商家自己配送'), 'type'=>3);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            $title = $content = sprintf("您在[%s]下的订单(%s)，由商家自己配送", $this->shop['title'], $order_id);
            K::M('order/order')->send_member($title, $content, $order);            
            $orderdetail = K::M('order/order')->detail($order_id);
            $this->msgbox->set_data('data', array('order'=>$orderdetail));
            $this->msgbox->add('success');
        }
    }
    
    //自己送的时候用来操作配送状态的
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
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('商家已经开始配送'), 'type'=>4));
            $title = $content = sprintf("您在[%s]下的订单(%s)，商家已经开始配送", $this->shop['title'], $order_id);
            K::M('order/order')->send_member($title, $content, $order);
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
        }else if($order['from'] != 'waimai'){
            $this->msgbox->add(L('非法操作'), 214);
        }else if($order['pei_type'] == 2){
            $this->msgbox->add(L('代购订单不可取消'), 215);
        }else if($order['order_status'] != 0 ){
            $this->msgbox->add(L('订单状态不可取消'), 216);
        }else if(K::M('order/order')->cancel($order_id, $order, 'shop')){
            $this->msgbox->add('success');
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
        }else if($order['order_status'] > 3){
            $this->msgbox->add(L('订单已完成'), 214);
        }else if((int)$order['order_status'] < 3 ){
            $this->msgbox->add(L('订单状态不可设置为已送达'), 215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'lasttime'=>__TIME))){
            //订单日志 v-1取消，0其他，1下单，2支付，3接单，4配送，5送达，6确认完成
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'shop', 'log'=>L('订单已送达'), 'type'=>5));
            $title = $content = sprintf("您在[%s]下的订单(%s)，商家已送达", $this->shop['title'], $order_id);
            K::M('order/order')->send_member($title, $content, $order);
            $this->msgbox->add('success');
        }
    }

    public function batch($params)
    {

    }

    //订单提醒
    public function tixing($params)
    {
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
    
    //回复催单
    public function cui_reply($params)
    {
        if(!$order_id = $params['order_id']){
            $this->msgbox->add(L('错误的订单!'), 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('错误的订单!'), 212);
        }else if(!$cui = K::M('order/cuilog')->find(array('order'=>$order_id),array('log_id'=>'desc'))){
            $this->msgbox->add(L('没有催单记录!'), 213);
        }else if(!($reply = $params['reply']) && !($reply = $params['replay'])){
            $this->msgbox->add(L('没有回复内容!'), 214);
        }else{
            if(K::M('order/cuilog')->update($reply['log_id'],array('reply'=>$reply,'reply_time'=>time()))){
                $title = sprintf("商户[%s]回复了您的催单(单号:%s)", $this->shop['title'], $order_id);
                $content = sprintf("商户[%s]回复了您的催单(单号:%s)，回复[{$reply}]", $this->shop['title'], $order_id, $reply);
                K::M('order/order')->send_member($title, $content, $order, 'reply');
                $this->msgbox->add('success');  
            }
        }
    }

}
