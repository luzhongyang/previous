<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Order extends Ctl
{
    
    public function index($page=1)
    {
        $this->check_tuan();
        $filter = $pager = $attr =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        if($keyword = $this->GP('keyword')){
            $keyword = htmlspecialchars($keyword);
            if(K::M('verify/check')->mobile($keyword)){
                $filter['mobile'] =$keyword;
            }else{
                $filter[':OR'] = array( 'addr'=>"LIKE:%".$keyword."%", 'contact'=>"LIKE:%".$keyword."%");
                if(is_numeric($keyword)){
                    $filter[':OR']['mobile'] = "LIKE:%".$keyword."%";
                    $filter[':OR']['order_id'] = "LIKE:%".$keyword."%";
                }
            }
            $attr = array('keyword'=>$keyword);
            $pager['keyword'] = $keyword;
        }
        
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/tuan/order/index', array('{page}'), $attr));
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
        $this->tmpl = 'merchant:tuan/order/index.html';
    }
    public function waitpay($page=1)
    {
        $this->check_tuan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        $filter['pay_status'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,order_status_label,dateline,clientip',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
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
        $this->tmpl = 'merchant:tuan/order/waitpay_list.html';
    }

    public function cancellist($page=1)
    {
        $this->check_tuan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        $filter['order_status'] = -1;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,order_status_label,dateline,clientip',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
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
        $this->tmpl = 'merchant:tuan/order/cancel_list.html';
    }

    public function todaycomplete($page=1)
    {
        $this->check_tuan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        $filter['order_status'] = 8;
        $filter['day'] = date('Ymd',__TIME);
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,order_status_label,dateline,clientip',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
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
        $this->tmpl = 'merchant:tuan/order/todaycomplete_list.html';
    }

    public function allcomplete($page=1)
    {
        $this->check_tuan();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';
        $filter['order_status'] = 8;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = array();
        foreach($items as $k => $v) {
            $items[$k] = $this->filter_fields('order_id,amount,order_status,order_status_label,dateline,clientip',$v);
            $order_ids[$v['order_id']] = $v['order_id'];
        }
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
        $this->tmpl = 'merchant:tuan/order/allcomplete_list.html';
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
            $this->tmpl = 'merchant:tuan/order/ticket.html';
        }
    }


    // ajax 验证密码
    public function check($number)
    {
        if(!$ticket = K::M('tuan/ticket')->find(array('number'=>$this->GP('number')))) {
            $this->msgbox->add('密码不正确',211);
        }else if($ticket['number'] != $this->GP('number')) {
            $this->msgbox->add('非法操作',213);
        }else if($ticket['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作',214);
        }else if(isset($ticket['use_time']) && $ticket['status']==1) {
            $this->msgbox->add('该券已被核销',215);
        }else if($ticket['ltime'] < __TIME) {
            $this->msgbox->add('该券已过期',216);
        }else if(!$order = K::M('tuan/order')->detail($ticket['order_id'])){
            $this->msgbox->add('无效的订单',217);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消',218);
        }else if($order['order_status']  == 8){
            $this->msgbox->add('订单已完成',219);
        }else {
            $ticket['order'] = $order;
            $ticket['youxiao_time'] = date('Y-m-d H:i',$ticket['ltime']);
            $this->msgbox->add('success');
            $this->msgbox->set_data('data',array('ticket'=>$ticket));
        }
    }
    
    // ajax 核销密码
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
            $this->tmpl = 'merchant:tuan/order/detail.html';
        }
    }
    
}