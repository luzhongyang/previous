<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Tuan_Order extends Ctl_Biz
{
    
    public function index($page=1)
    {
        $this->check_tuan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,order_status_label,dateline,clientip',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
        //$photos = K::M('order/photo')->items(array('order_id'=>$order_ids), array('photo_id'=>'desc'));
        
        $tuans = K::M('tuan/order')->items(array('order_id'=>$order_ids), array('tuan_id'=>'desc'));
        foreach($items as $k=>$val){
            foreach($tuans as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['tuan_id'] = $v['tuan_id'];
                    $items[$k]['tuan'] = $v;
                }
            }
        }
        $tuan_ids = array();
        foreach($tuans as $k=>$val){
            $tuan_ids[$val['tuan_id']] = $val['tuan_id'];
        }
        
        $this->pagedata['tuans'] = K::M('tuan/tuan')->items_by_ids($tuan_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/tuan/order/index.html';
    }

    public function ticket() 
    {
        $this->check_tuan();
        if($this->checksubmit()) {
            $data = $this->checksubmit('code');
            foreach($data as $k=>$v) {
                $rlt = K::M('tuan/ticket')->find(array('number'=>$v));
                if($rlt['shop_id'] == $this->shop_id && $rlt['status'] == 0 && $rlt['ltime'] > __TIME) {
                    if($order = K::M('tuan/order')->detail($rlt['order_id'])){
                        if($order['order_status']  > 0 && $order['order_status'] < 8){
                            echo '<script>parent.used(' . $k . ',"√验证成功",1);</script>';
                        }else{
                            echo '<script>parent.used(' . $k . ',"×该团购券无效",3);</script>';
                        }
                    }else{
                        echo '<script>parent.used(' . $k . ',"×该团购券无效",3);</script>';
                    }
                }else {
                    echo '<script>parent.used(' . $k . ',"×该团购券无效",3);</script>';
                }
            } 
        }else{
            $this->tmpl = 'biz/tuan/order/ticket.html';
        }
    }

    public function dialog($number)
    {
        if(!$ticket = K::M('tuan/ticket')->find(array('number'=>$number))) {
            $this->msgbox->add('密码不正确',211);
        }else if($ticket['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作',212);
        }else if(isset($ticket['use_time']) && $ticket['status']==1) {
            $this->msgbox->add('该券已被核销',213);
        }else if($ticket['status'] == -1) {
            $this->msgbox->add('该券已退款',214);
        }else if($ticket['ltime'] < __TIME) {
            $this->msgbox->add('该券已过期',215);
        }else {
            $this->pagedata['shop'] = $this->shop;
            $this->pagedata['tuan'] = K::M('tuan/tuan')->detail($ticket['tuan_id']);
            $this->pagedata['detail'] = $ticket;
            $this->tmpl = 'biz/tuan/order/dialog.html';
        }
    }
    
    /*public function used() 
    {
        $this->check_tuan();
        if($this->checksubmit()) {
            $data = $this->checksubmit('code');
            foreach($data as $k=>$v) {
                $rlt = K::M('tuan/ticket')->find(array('number'=>$v));
                if($rlt['shop_id'] == $this->shop_id && $rlt['status'] == 0 && $rlt['ltime'] > __TIME) {
                    $datas = array(
                        'number'   => $rlt['number'],
                        'count'    => $rlt['count'],
                        'dateline' => $rlt['dateline'],
                        'tuan_id'  => $rlt['tuan_id'],
                        'order_id' => $rlt['order_id'],
                        'uid'      => $rlt['uid'],
                        'shop_id'  => $this->shop_id,
                        'ltime'    => $rlt['ltime'],
                        'use_time' => __TIME,
                        'status'   => 1,
                        );
                    if(K::M('tuan/ticket')->update($rlt['ticket_id'], $datas)) {
                        K::M('tuan/order')->update($rlt['order_id'],array('use_time'=>__TIME));
                        //更新订单主订单表订单状态
                        K::M('order/order')->update($rlt['order_id'], array('order_status'=>8));
                        echo '<script>parent.used(' . $k . ',"√验证成功",1);</script>';
                    }
                }else {
                    echo '<script>parent.used(' . $k . ',"×该团购券无效",3);</script>';
                }
            } 
       }
    }*/
    
    public function used()
    {
        if(!$ticket_id = (int)$this->GP('ticket_id')) {
            $this->msgbox->add('该券不存在',210);
        }else if(!$this->GP('number')) {
            $this->msgbox->add('密码不正确',211);
        }else if(!$ticket = K::M('tuan/ticket')->detail($ticket_id)) {
            $this->msgbox->add('该券不存在',212);
        }else if($ticket['number'] != $this->GP('number')) {
            $this->msgbox->add('非法操作',213);
        }else if($ticket['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作',214);
        }else if(isset($ticket['use_time']) && $ticket['status']==1) {
            $this->msgbox->add('该券已被核销',215);
        }else if($ticket['ltime'] < __TIME) {
            $this->msgbox->add('该券已过期',216);
        }else if(!$order = K::M('tuan/order')->detail($ticket['order_id'])){
            $this->msgbox->add('无效的订单',216);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消',216);
        }else if($order['order_status']  == 8){
            $this->msgbox->add('订单已完成',216);
        }else if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')) {
            if(K::M('tuan/ticket')->update($ticket_id, array('status'=>1,'use_time'=>__TIME))) {
                $this->msgbox->add('核销成功');
            }else {
                $this->msgbox->add('核销失败',220);
            }
        }
    }
    
    public function detail($order_id)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('tuan/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else{
            $logs = K::M('order/log')->items(array('order_id'=>$order_id));
            $this->pagedata['detail'] = $order;
            $this->pagedata['log_list'] = $logs;
            $this->tmpl = 'biz/tuan/order/detail.html';
        }
    }
    
}