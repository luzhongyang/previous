<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Paotui_Order extends Ctl_Staff
{

    protected $_all_fields = 'order_id,shop_id,staff_id,uid,from,order_status,online_pay,pay_status,trade_no,total_price,hongbao_id,hongbao,order_youhui,first_youhui,money,amount,o_lng,o_lat,contact,mobile,addr,house,lng,lat,day,intro,order_from,dateline,cui_time,comment_status,jd_time,pay_code,pay_time,pei_type,pei_amount,pei_time,o_addr,o_house,o_contact,o_mobile,o_time,time,paotui_amount,jiesuan_amount,danbao_amount,order_status_label,order_status_warning,shop_name,type';
    /**
     * 跑腿外卖订单列表
     * @access public 
     * @param $status,[1:待接单,2:待处理,3:已完成]
     * @param $page
     */
    public function index($params)
    {
        $items = $orderby = $orderby = array();
        $filter = $wait_filter = array('closed'=>0);
        $wait_filter['order_status'] = array(1,2,3);
        $wait_filter['staff_id'] = $this->staff_id;
        $lng = $this->staff['lng'];
		$lat = $this->staff['lat'];
        //0:全部, 1:待接单, 2:进行中的, 3:已完成的
        if(in_array($params['status'], array(0,1,2,3))){
            switch ($params['status']){
                case 3: //已完成
                    $filter['order_status'] = array(4,5,6,7,8); // 4配送完成 8订单完成
                    $filter['staff_id'] = $this->staff_id;
					$order['lasttime'] = 'DESC';
                    break;
                case 2: //待处理
                    $filter = $wait_filter;
                    $orderby = array('lasttime'=>'ASC');
                    break;
                case 1: //待接单                    
                    if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
                        //使用此函数计算得到结果后，带入sql查询。
                        $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 5); //5KM以内的新订单
                        $filter['o_lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                        $filter['o_lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
                    }
                    $filter[':SQL'] = "((`from`='waimai' AND ((`pei_type`=1 AND `order_status` IN(1,2)) OR (`order_status`=0 AND `pei_type`=2))) OR (`from`='paotui' AND `order_status`=0))";
                    $filter['pay_status'] = 1;
                    $filter['staff_id'] = 0;    // 0等待接单
                    $orderby = array('lasttime'=>'ASC');
                    break;
                default : 
                    $filter['staff_id'] = $this->staff_id;
            }
        }else{
            $filter['staff_id'] = $this->staff_id;
        }
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($orders = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $order_ids = $uids = $shop_ids = array();
            $juliobj = K::M('helper/round');
            foreach($orders as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['from'] == 'waimai'){
                    $waimai_oids[$v['order_id']] = $v['order_id'];
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                }else{
                    $paotui_oids[$v['order_id']] = $v['order_id'];
                }
                $v = $this->filter_fields($this->_all_fields, $v);
                //order_id,type,o_addr,o_house,o_contact,o_mobile,o_time,time,paotui_amount,danbao_amount,jiesuan_amount
                if($v['pei_time']){
                    $v['pei_time_label'] = '预计'.date('H:i',$v['pei_time']).'送达';
                }else{
                    $v['pei_time_label'] = '尽快送达';
                }
                
                $v['o_addr'] = '';
                $v['o_house'] = '';
                $v['shop_name'] = '';
                $v['type'] = $v['from'];
                $v['type_name'] = '';
                $v['paotui_amount'] = $v['pei_amount']; //默认设置跑腿费用为外卖的三方配送费用
                $v['jiesuan_price'] = 0;
                $v['danbao_amount'] = 0;
                $v['juli_quancheng'] = $juliobj->juli_label($this->staff['lng'], $this->staff['lat'], $v['lng'], $v['lat']);
                if($v['o_lat'] && $v['o_lng']){
                    $v['juli_qidian'] = $juliobj->juli_label($this->staff['lng'], $this->staff['lat'], $v['o_lng'], $v['o_lat']);
                    $v['juli_zhongdian'] = $juliobj->juli_label($v['o_lng'], $v['o_lat'], $v['lng'], $v['lat']);
                }else{
                    $v['juli_qidian'] = '0m';
                    $v['juli_zhongdian'] = $v['juli_quancheng'];
                }                
                $orders[$k] = $v;
            }
            if($order_ids){
                $comment_list = K::M('staff/comment')->items_by_order_ids($order_ids);
                $comment_info = array('comment_id'=>0,'order_id'=>0,'staff_id','uid'=>0,'score'=>0,'content'=>'','reply'=>'','reply_time'=>0,'dateline'=>0);
                if($shop_ids){
                    if($shop_list = K::M('shop/shop')->items_by_ids($shop_ids)){
                        foreach($orders as $k=>$v){
                            if($shop = $shop_list[$v['shop_id']]){
                                $v['shop_name'] = $shop['title'];
								$v['o_addr'] = $shop['addr'];
                                $orders[$k] = $v;
                            }
                        }
                    }
                }
                if($extorders = K::M('paotui/order')->items_by_ids($order_ids)){
                    foreach($orders as $k=>$v){
                        if($o = $extorders[$k]){
                            $v['type'] = $o['type'];
                            $v['o_addr'] = $o['o_addr'];
                            $v['o_house'] = $o['o_house'];
                            $v['paotui_amount'] = $o['paotui_amount'];
                            $v['jiesuan_price'] = $o['jiesuan_price'];
                            $v['danbao_amount'] = $o['danbao_amount'];
                        }
                        if($comment = $comment_list[$k]){
                            $v['comment_info'] = $this->filter_fields('comment_id,order_id,staff_id,uid,score,content,reply,reply_time,dateline', $comment);
                        }else{
                            $v['comment_info'] = $comment_info;
                        }
                        $orders[$k] = $v;
                    }
                }
            }
        }
        if($status != 2){
            $wait_count = K::M('order/order')->count($wait_filter);
        }else{
            $wait_count = $count;
        }
        $this->msgbox->set_data('data', array('items'=>array_values($orders), 'total_count'=>$count, 'wait_count'=>$wait_count));
        $this->msgbox->add('SUCCESS');
    }

    /**
     * 订单详情
     * @param $order_id     int
     */
    public function detail($params)
    {

        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] > 0 && $order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else{
            $order = $this->filter_fields($this->_all_fields, $order);
            $order['photos'] = $order['logs'] = array();
            if($photos = K::M('order/photo')->items(array('order_id'=>$order_id), null, 1, 5)){
                foreach($photos as $v){
                    $order['photos'][] = $v['photo'];
                }
            }
            if($logs = K::M('order/log')->items(array('order_id'=>$order_id), array('log_id'=>'DESC'))){
                $order['logs'] = array_values($logs);
            }
            $voice_info = array('voice_id'=>0, 'order_id'=>0, 'voice'=>'', 'voice_time'=>0, 'dateline'=>0);
            if($voice = K::M('order/voice')->detail_by_order_id($order_id)){
                $voice_info = $voice;
            }
            $order['voice_info'] = $voice_info;              
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
            $order['juli_quancheng'] = $juliobj->juli_label($this->staff['lng'], $this->staff['lat'], $order['lng'], $order['lat']);
            $order['juli_qidian'] = $juliobj->juli_label($this->staff['lng'], $this->staff['lat'], $order['o_lng'], $order['o_lat']);
            $order['juli_zhongdian'] = $juliobj->juli_label($order['o_lng'], $order['o_lat'], $order['lng'], $order['lat']);
            $this->msgbox->set_data('data', $order);
            $this->msgbox->add('SUCCESS');
        }
    }


    /**
     * 接单|开始服务
     * @param $order_id
     */
    public function qiang($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if($this->staff['verify_name'] != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if(empty($order['pay_status'])){
            $this->msgbox->add('订单未支付不可抢单',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('该订单已经取消不可枪单', 213);
        }else if(!in_array($order['order_status'], array(0, 1, 2))){
            $this->msgbox->add('该订单不可抢单',213);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('该订单已被抢走', 215);
        }else if(empty($this->staff['audit'])){
            $this->msgbox->add('您还没有通过审核不能接单', 216);
        }else if(empty($this->staff['verify_name'])){
            $this->msgbox->add('需要认证后才能正常接单', 217);
        }else if(K::M('order/order')->update($order_id, array('staff_id'=>$this->staff_id, 'order_status'=>2,'jd_time'=>__TIME))){
            //记录订单日志
            $log = array('order_id'=>$order_id, 'from'=>'staff','log'=>sprintf('订单由骑手(%s)提供服务', $this->staff['name']), 'type'=>'2');
            K::M('order/log')->create($log);
            //增加订单统计
            K::M('staff/staff')->update_count($this->staff_id, 'orders', 1);
            //通知用户
            K::M('order/order')->send_member("骑手已接单", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }else{
            $this->msgbox->add('FAIl', 221);
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
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else if(!in_array($order['order_status'], array(0,1,2,3))){
            $this->msgbox->add('订单状态不可取消', 214);
        }else{
            $a = array('order_status'=>0, 'lasttime'=>__TIME, 'staff_id'=>0);
            if(K::M('order/order')->update($order_id, $a)){
                $log = array('order_id'=>$order_id, 'status'=>$a['order_status'], 'log'=>'骑手取消原因：'.$reason, 'from'=>'staff', 'dateline'=>__TIME);
                K::M('order/log')->create($log);
                //通知用户
                K::M('order/order')->send_member("骑手取消接单", $log['log'], $order);
                $this->msgbox->add('SUCCESS');
            }
        }
    }

    /**
     * 设置帮我买商品小票金额
     * @param $order_id         int
     * @param $jiesuan_price    float
     */
    public function setprice($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(($jiesuan_price = (float)$params['jiesuan_price'])<=0){
            $this->msgbox->add('未指定结算价格',212);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else if(!in_array($order['order_status'], array(4, 5))){
            $this->msgbox->add('订单状态不可设置价格', 215);
        }else if($jiesuan_price < $order['danbao_amount']){
            $this->msgbox->add('结算价格不能少于担保金额', 216);
        }else if(!K::M('paotui/order')->set_price($order_id, $jiesuan_price, 'staff')){
            $this->msgbox->add('设置结算价格失败', 216);
        }else{
            $log = array('order_id'=>$order_id, 'status'=>5, 'log'=>sprintf('骑手设置了结算价格：￥%s', $jiesuan_price), 'from'=>'staff');
            K::M('order/log')->create($log);            
            //通知会员
            K::M('order/order')->send_member("骑手设置了结算价格", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }


    /**
     * 开始工作
     * @param $order_id     int
     */
    public function startwork($params)
    {
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 213);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单', 214);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单状态已经取消不可操作', 214);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单状态已经完成不可操作', 214);
        }else{
            K::M('order/order')->update($order_id, array('order_status'=>3));
            $log = array('order_id'=>$order_id, 'status'=>3, 'log'=>'骑手已经开始服务', 'from'=>'staff');
            K::M('order/log')->create($log);
            //通知会员
            K::M('order/order')->send_member("骑手开始服务", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    //订单送达
    public function finshed($params)
    {

        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('参数不正确',211);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在',212);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add('您没有权限操作该订单',213);
        }else if(!in_array($order['order_status'], array(2,3))){
            $this->msgbox->add(L('该订单不可配送'), 213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'lasttime'=>__TIME))){
            //记录订单日志
            $log = array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('骑手(%s)已经为您送达'), $this->staff['name']), 'type'=>'4');
            K::M('order/log')->create($log);
            //通知用户
            K::M('order/order')->send_member("订单已送达", $log['log'], $order);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
            $this->msgbox->add('SUCCESS');
        }
    }

}