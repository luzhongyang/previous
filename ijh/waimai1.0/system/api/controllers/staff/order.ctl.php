<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Order extends Ctl
{

    protected $_allow_fields = 'order_id,city_id,shop_id,uid,product_price,comment_status,product_number,freight,money,amount,order_youhui,first_youhui,hongbao,hongbao_id,contact,mobile,addr,house,lat,lng,note,order_status,order_status_label,online_pay,pay_status,pay_code,pay_time,pei_amount,pei_time,staff_id,pei_type,dateline,lasttime';

    //订单列表
    public function index($params)
    {
        $this->check_login();
        $filter = array();
        $orderby = array('order_id'=>'DESC');
        if(!($lat = $params['lat']) || !($lng = $params['lng'])){
            $lat = $this->staff['lat'];
            $lng = $this->staff['lng'];
        }
        //0:全部, 1:待接单, 2:进行中的, 3:已完成的
        if(in_array($params['status'], array(0,1,2,3))){
            switch ($params['status']){
                case 3: //已完成
                    $filter['order_status'] = array(4,5,6,7,8); // 4配送完成 8订单完成
                    $filter['staff_id'] = $this->staff_id;
                    break;
                case 2: //待处理
                    $filter['order_status'] = array(1,2,3); // 1商家已接单 2已配货
                    $filter['staff_id'] = $this->staff_id;
                    $orderby = array('order_id'=>'ASC');
                    break;
                case 1: //待接单                    
                    if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
                        //使用此函数计算得到结果后，带入sql查询。
                        $squares = K::M('helper/round')->returnSquarePoint($lng, $lat, 5); //5KM以内的新订单
                        $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
                        $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
                    }                
                    $filter['pay_status'] = 1;
                    $filter[':SQL'] = "(`order_status` IN(1,2,3) OR (`order_status`=0 AND `pei_type`=2))";
                    $filter['staff_id'] = 0;    // 0等待配送员接单
                    $filter['pei_type'] = array(1,2);
                    $orderby = array('order_id'=>'ASC');
                    break;
                default : 
                    $filter['staff_id'] = $this->staff_id;
            }
        }else{
            $filter['staff_id'] = $this->staff_id;
        }
        $filter['closed'] = 0;
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if($order_list = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $shop_ids = array();
            foreach($order_list as $k=>$val){
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
            foreach($shop_list as $k=>$val){
                $shop_list[$k] = $this->filter_fields('shop_id,title,phone,logo,addr,lng,lat',$val);
            }
            $items = array();
            foreach($order_list as $k=>$val){
                $items[$k] = $this->filter_fields($this->_allow_fields, $val);
                if($shop_list[$val['shop_id']]){
                    $items[$k]['shop'] = $shop_list[$val['shop_id']];
                }else{
                    $items[$k]['shop'] = array();
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    //订单详情
    public function detail($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['order_status'] < 1 && $order['pei_type'] != 2){
            $this->msgbox->add(L('订单不存在'),213);
        }else if($order['staff_id'] && $order['staff_id'] != $this->staff_id){
            $this->msgbox->add(L('非法操作'),214);
        }else{
            $order_data = $this->filter_fields($this->_allow_fields, $order);
            if(!$shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = array();
            }else{
                $shop = $this->filter_fields('shop_id,title,phone,logo,addr,lng,lat',$shop);
                $order['shop'] = $shop;
            }
            if(!$logs = K::M('order/log')->items(array('order_id'=>$order_id),array('log_id'=>'asc'))){
                $logs = array();
            }
            if(!$product_list = K::M('order/product')->items(array('order_id'=>$order_id))){
                $product_list = array();
            }
            $order['products'] = array_values($product_list);
            $order['logs'] = array_values($logs);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('order'=>$order));
        }
    }

    //抢单
    public function qiang($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($this->staff['verify_name'] != 1){
            $this->msgbox->add(L('您还没有认证通过或被拒绝，不可以接单'),212);
        }else if(empty($order['online_pay'])){
            $this->msgbox->add(L('货到付款订单不可配送'),212);
        }else if(empty($order['pay_status'])){
            $this->msgbox->add(L('订单未支付不可抢单'),213);
        }else if((empty($order['order_status']) && $order['pei_type']!=2) || (in_array($order['pei_type'], array(0,1)) && (int)$order['order_status'] !== 1)){
            $this->msgbox->add(L('该订单不可抢单'),213);
        }else if($order['staff_id']){
            $this->msgbox->add(L('订单已经被抢走'),214);
        }else if(K::M('order/order')->update($order_id, array('staff_id'=>$this->staff_id, 'order_status'=>2))){
            //记录订单日志
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('配送员(%s)准备为您配送'), $this->staff['name']), 'type'=>'2'));
            //增加订单统计
            K::M('staff/staff')->update_count($this->staff_id, 'orders', 1);
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    //订单开始配送
    public function pei($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add(L('该订单不可配送'),213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'lasttime'=>__TIME))){
            //记录订单日志
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('配送员(%s)开始为您配送'), $this->staff['name']), 'type'=>'4'));
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    //订单送达
    public function delivered($params)
    {
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['staff_id'] != $this->staff_id){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!in_array($order['order_status'], array(2,3))){
            $this->msgbox->add(L('该订单不可配送'),213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'lasttime'=>__TIME))){
            //记录订单日志
            K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'staff', 'log'=>sprintf(L('配送员(%s)已经为您送达'), $this->staff['name']), 'type'=>'5'));
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }

    //订单提醒
    public function tixing($params)
    {
        $this->check_login();
        if(!$dateline = (int)$params['dateline']){
            //如果没有传时间戳设置为15分钟前
            $dateline = __TIME - 900;
        }
        // staff_id 0等待配送员接单
        $filter = array('staff_id'=>0, 'closed'=>0, 'pay_status'=>1, 'pei_type'=>array(1,2),'lasttime'=>">:".$dateline);
        $filter[':SQL'] = "(`order_status` IN(1,2,3) OR (`order_status` IN(0,1,2,3) AND `pei_type`=2))";
        //使用此函数计算得到结果后，带入sql查询。
        if(!defined('__DEV_MODEL') || !constant('__DEV_MODEL')){ //开发环境忽略坐标
            $squares = K::M('helper/round')->returnSquarePoint($this->staff['lng'], $this->staff['lat'],5); //5KM以内的新订单
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
        }

        if(!$new_order = (int)K::M('order/order')->count($filter)){
            //如果没有外卖新单，再查询跑腿新单
            $filter = array('staff_id'=>0, 'order_status'=>0, 'pay_status'=>1, 'pay_time'=>'>:'.$dateline);
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            $new_order = (int)K::M('paotui/paotui')->count($filter);
        }
    
        $cui_order = (int)K::M('order/order')->count(array('staff_id'=>$this->staff_id, 'cui_time'=>">:".$dateline, 'order_status'=>array(2,3)));
        
        $this->msgbox->set_data('data', array('new_order'=>$new_order, 'cui_order'=>$cui_order, 'dateline'=>__TIME,'latlng'=>$this->staff['lat'].','.$this->staff['lng'].','.$this->staff['staff_id']));
        K::M('system/logs')->log('try',$this->system->db->SQLLOG());
        
    }

}
