<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Order extends Ctl_Ucenter
{

    public function index()
    {
        if($st = (int)$this->GP('st')){
            $this->pagedata['st'] = $st;
        }
        switch ($st) {
            case 1:
                $status_name = "待付款";
                break;
            case 2:
                $status_name = "待发货";
                break;
            case 3:
                $status_name = "待收货";
                break;
            case 4:
                $status_name = "待评价";
                break;
            default:
                $status_name = "全部";
                break;
        }
        $this->pagedata['status_name'] = $status_name;
        $this->tmpl = 'fenxiao/ucenter/order/index.html';
    }

    
    public function loaditems($page=1)
    {
        $filter = array('uid'=>$this->uid);
        $filter['weidian']['type'] = "fenxiao";
        $filter['weidian']['sid'] = FX_SID;
        $page = max((int)$page, 1);
        $limit = 10;
        if($st = (int)$this->GP('st')){
            switch($st){
                case 1:
                $filter['order_status'] = 0;
                $filter['pay_status'] = 0;
                break;
                case 2:
                $filter['order_status'] = 1;
                    break;
                case 3:
                $filter['order_status'] = 3;
                    break;
                case 4:
                $filter['order_status'] = 8;
                $filter['comment_status'] = 0;  
                break;
                case 5:
                $filter['order_status'] = -1;
                    break;
            }
        }
        if(!$items = K::M('weidian/order')->items_by_status($filter,array('order_id'=>'desc'),$page, $limit, $count)){
            $items = array();
        }
        $order_ids = array();
        foreach($items as $k=>$v){
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        $order_products = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
        $product_ids = array();
        foreach($items as $k=>$v){
            foreach($order_products as $k1=>$v1){
                if($v['order_id'] == $v1['order_id']){
                    $product_ids[$v1['product_id']] = $v1['product_id'];
                    $items[$k]['products'][] = $v1;
                }
            }
        }
        if($product_ids){
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
        }
        $count_num = count($items);
        if($count_num <= $limit){
            $loadst = 0; 
        }else{
            $loadst = 1; 
        }
        $this->msgbox->set_data('loadst', $loadst);
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'fenxiao/ucenter/order/loaditems.html';
        $html = $this->output(true);
        $this->msgbox->set_data('html', $html);
        $this->msgbox->json();
    }
    
    public function detail($order_id){
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }elseif(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('订单不合法!',213);
        }else{
            $orderproducts = K::M('weidian/orderproduct')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($orderproducts as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            $log = K::M('payment/log')->find(array('order_id'=>$order_id));
            $this->pagedata['log'] = $log;
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
            $this->pagedata['orderproducts'] = $orderproducts;
            $this->pagedata['order'] = $order;
            $this->pagedata['shop'] = K::M('fenxiao/fenxiao')->detail(FX_SID);
            $this->tmpl = 'fenxiao/ucenter/order/detail.html';
        }
    }

    public function cancel($order_id){ //订单取消
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }elseif(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('订单不合法!',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消',214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态',215);
        }else{
            if(K::M('weidian/order')->cancel($order_id,$order,'member')){
                $this->msgbox->add('订单取消成功!');
            }else{
                $this->msgbox->add('订单取消失败!',214);
            }
        }
    }

    public function complete($order_id){ //订单完成
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }elseif(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('订单不合法!',213);
        }else if($order['order_status'] != 3&&$order['order_status'] != 4){
            $this->msgbox->add('当前订单是不可完成的状态',215);
        }else{
            if(K::M('weidian/order')->complete($order_id,$order)){
                $this->msgbox->add('操作成功!');
            }else{
                $this->msgbox->add('操作失败!',214);
            }
        }
    }
    
    public function confirm($order_id){ //确认收货
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }elseif(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }elseif($order['uid'] != $this->uid){
            $this->msgbox->add('订单不合法!',213);
        }else if($order['order_status'] != 3){
            $this->msgbox->add('当前订单是不可收货的状态',215);
        }else{
            if(K::M('order/order')->update($order_id,array('order_status'=>4),true)){
                $this->msgbox->add('确认收货成功!');
            }else{
                $this->msgbox->add('确认收货失败!',214);
            }
        }
    }

    // 提醒发货
    public function remind()
    {
        if(!$order_id = (int)$this->GP('order_id')){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('weidian/order')->detail($order_id)) {
            $this->msgbox->add("订单不存在",212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] !=1){
            $this->msgbox->add('当前不能提醒发货',216);
        }else {
            if(K::M('order/order')->update($order_id, array('cui_time'=>__TIME))) {
                $data = array(
                    'shop_id'=>$order['shop_id'],
                    'title'=>'用户已提醒发货',
                    'content'=>'用户('.$order['contact'].')正在提醒订单(ID:'.$order_id.')发货',
                    'is_read'=>0,
                    'type'=>1,
                    'order_id'=>$order_id
                );
                K::M('shop/msg')->create($data);
                $this->msgbox->add('提醒发货成功');
            }else {
                $this->msgbox->add('提醒发货失败',214);
            }
        }

    }
    
    
     /*评价*/
    public function comment($order_id){
        if(!$order_id){
            $this->msgbox->add('订单不存在!',211);
        }else if(!$order = K::M('weidian/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',213);
        }else if($order['comment_status'] == 1){
            $this->msgbox->add('该订单已评价!',214);
        }else{
            $orderproducts = K::M('weidian/orderproduct')->items(array('order_id'=>$order_id));
            $product_ids = array();
            foreach($orderproducts as $k=>$v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            $this->pagedata['products'] = K::M('weidian/product')->items_by_ids($product_ids);
            $this->pagedata['orderproducts'] = $orderproducts;
            $this->pagedata['order'] = $order;
            $this->tmpl = 'fenxiao/ucenter/order/comment.html';
        }
    }
    
    public function comment_handle() 
    {
        if($this->checksubmit()){
            $datas = $this->GP('data');
            $file = $_FILES;
            $datas['uid'] = $this->uid;
            if(!$this->uid){
                $this->msgbox->add('您还没有登录!',101);
            }else if(!$datas['order_id']){
                $this->msgbox->add('错误的订单!',216);
            }else if(!$order = K::M('weidian/order')->detail($datas['order_id'])){
                $this->msgbox->add('错误的订单!',216);
            }else if($order['comment_status'] == 1){
                $this->msgbox->add('你已经评价过了!',216);
            }else if($order['from'] == 'weidian' &&(!$datas['packing_score'] || $datas['packing_score'] < 1 || $datas['packing_score'] > 5)){
                $this->msgbox->add('请正确选择包装评分!',211);
            }else if($order['from'] == 'weidian' &&(!$datas['quality_score'] || $datas['quality_score'] < 1 || $datas['quality_score'] > 5)){
                $this->msgbox->add('请正确选择质量评分!',211);
            }else if($order['from'] == 'weidian' &&(!$datas['fuwu_score'] || $datas['fuwu_score'] < 1 || $datas['fuwu_score'] > 5)){
                $this->msgbox->add('请正确选择物流服务评分!',211);
            }else if(!$datas['content']){
                $this->msgbox->add('没有填写评价内容!',215);
            }else{

                $datas['shop_id'] = $order['shop_id'];
                if($data['file']){
                    $datas['have_photo'] = 1;
                }
                $datas['score'] = round(($datas['packing_score']+$datas['quality_score']+$datas['fuwu_score'])/3,1);
                $datas['clientip'] = __IP;
                $datas['dateline'] = __TIME;
                if($create = K::M('weidian/comment')->create($datas)){
                    if($file){
                        //插入评价
                        foreach($file as $k => $v){
                            if($a = K::M('magic/upload')->upload($v,'photo')){
                                $photo_data = array(
                                    'comment_id' => $create,
                                    'photo' => $a['photo']
                                );
                                $create_photo = K::M('weidian/commentphoto') -> create($photo_data);
                            }
                        }
                    }
                    $shop = K::M('shop/shop') -> detail($order['shop_id']);
                    
                    K::M('shop/shop')->update($order['shop_id'], array('comments'=>$shop['comments']+1));
                    K::M('order/order')->update($datas['order_id'],array('comment_status'=>1));
                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int)($order['amount']*$jifen['jifen_ratio']);
                    if($jifen_total>=1){
                        K::M('member/member')->update_jifen($this->uid,$jifen_total,'订单'.$data['order_id'].'评价完成，获得积分');
                    }
                    K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>'订单已评价','content'=>'用户('.$order['contact'].')已评价订单(ID:'.$order['order_id'].')','is_read'=>0,'type'=>2,'order_id'=>$order['order_id']));
                    $this->msgbox->add('评价成功!');
                    $this->msgbox->set_data("forward", $this->mklink('ucenter/order/index',null,null,'base'));
                }else{
                    $this->msgbox->add('评价失败!',217);
                }
            }

        }

    }

    /*通用订单支付页面*/
    public function pay($order_id)
    {
        K::M('system/session')->start();
        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('订单不存在!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($order['pay_status']){
               $this->msgbox->add('该订单已支付!',213);
               if($order['from'] == 'weidian'){
                    if($detail = K::M('weidian/order')->detail($order_id)){
                        if($detail['type'] == 'default'){
                            $this->msgbox->set_data("forward", $this->mklink('weidian/product'));
                        }else{
                            $this->msgbox->set_data("forward", $this->mklink('weidian/ucenter/pintuan'));
                        }
                    }
                }
        }else{
            if($order['from'] == 'weidian'){
                $worder = K::M('weidian/order')->detail($order['order_id']);
                if($worder['type'] == 'pintuan'){
                    
                    $arr_p_order = K::M('weidian/pintuan/order')->find(array('order_id' => $order_id));
     
                        if(1 == $arr_p_order['is_money_pre']){
                            if(0 == $arr_p_order['money_paid']){
                                //1.预付款
                                $order['amount'] = $arr_p_order['money_need_pay'];
                            } 
                            else if($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                                //2.付尾款
                                $order['is_weikuan'] = 1;//拼图付尾款标记
                                $order['amount'] = abs($arr_p_order['product_price']*$arr_p_order['product_number'] - $arr_p_order['money_paid']);
                            }
                            else{
                                //3.付尾款 多次付款兼容
                                $order['is_weikuan'] = 1;//拼图付尾款标记
                                $order['amount'] = abs($arr_p_order['product_price']*$arr_p_order['product_number'] - $arr_p_order['money_paid']);
                            }
                        }
                        $arr_group = K::M('weidian/pintuan/group')->find(array('group_id' => $arr_p_order['group_id']));
                        $leftover_seconds = $arr_group['end_time'] - __TIME;
                        $order['link'] = $this->mklink('pintuan/tuan_detail', array($arr_p_order['group_id']));

                    $this->pagedata['pintuan'] = 1;
                    $this->pagedata['group_id'] = $arr_p_order['group_id'];

                }
            }
            if(defined('IN_WEIXIN')){
                $this->pagedata['weixin'] = 1;
            }
            $this->pagedata['order'] = $order;
            $payment_amount = $youhui_amount = $total_price = 0;
            $payment_amount = K::M("{$order['from']}/order")->get_payment_amount($order_id, $payment_level);
            $total_price = $payment_amount;
            if($payment_level){
                if($order['total_price'] > $payment_amount){
                    $total_price = $order['total_price'];
                    $youhui_amount = $total_price - $payment_amount;
                }
            }
            if($youhui_amount&&$payment_level==1){
                $str = "已支付";
            }else{
                $str = "优惠";
            }
            $pager = array('payment_amount'=>$payment_amount, 'youhui_amount'=>$youhui_amount, 'total_price'=>$total_price, 'payment_level'=>$payment_level,'payment_str'=>$str);
            $this->pagedata['pager'] = $pager;

            $this->pagedata['order'] = $order;
            $this->tmpl = 'fenxiao/ucenter/order/pay.html';
        }
    }
    
}