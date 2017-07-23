<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Order extends Ctl_Weidian
{

    public function index($page=1,$fenxiao)
    {
        $this->check_weidian();
         $this->weidian($page,$fenxiao);
    }
    
    // 微店订单
    public function weidian($page,$fenxiao)
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        $filter['from'] = 'weidian';
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
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
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}'), $attr));
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        if($keyword){
            $this->tmpl = 'merchant:weidian/order/so.html';
        }else{
            $this->tmpl = 'merchant:weidian/order/index.html';
        }
        
    }

    public function porder($order_id)
    {
        $this->check_weidian();
       $order_id = (int)$order_id;
        if(!$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else{
           $order['products'] = K::M('weidian/orderproduct')->items(array('order_id'=>$order['order_id'])); 
           $order['js_price'] = $order['amount'] + $order['money'];
           $this->pagedata['detail'] = $order; 
           $this->pagedata['payments'] = K::M('order/order')->get_payments();
           $this->tmpl = 'merchant:weidian/order/porder.html';
        }
    }

    public function check_print()
    {
        $this->check_weidian();
        //判断打印机
        if(!$printer = K::M('shop/print')->find(array('shop_id'=>$this->shop_id,'status'=>1))) {
            $this->msgbox->add('打印机未添加或未启用',210);
        }else {
            $this->msgbox->add('success');
        }
    }

    public function yun_print()
    {
        $this->check_weidian();
        K::M('order/order')->yunprint($this->GP('order_id'), $this->GP('nums'));
    }
    
    //待发货
    public function fahuo($page=1,$fenxiao)
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 1;
        $filter['pei_type'] = "<>:2";
        $filter['from'] = 'weidian';
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('cui_time'=>'desc','order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/fahuo.html';
    }
    
    
    public function shouhuo($page=1,$fenxiao)
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 3;
        $filter['from'] = 'weidian';
        $filter['pei_type'] = "<>:2";
        $filter['pay_status'] = 1;
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/shouhuo.html';
    }
    
    public function cancel($order_id=null)
    {
        $this->check_weidian();
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if(K::M('order/order')->cancel($order_id,$order,'shop')){
                $this->msgbox->add('取消订单成功');
            }else{
                $this->msgbox->add('取消订单失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('weidian/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }/*else if($order['order_status'] !=0&&$order['order_status']!=1){
                    unset($ids[$k]);
                }*/
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->cancel($val,null,'shop');
                }
                $this->msgbox->add('批量取消成功');
            }
        }
    }

    
    public function complete($page=1,$fenxiao,$day=null) 
    {
        $this->check_weidian();
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 8;
        $filter['pei_type'] = "<>:2";
        $filter['from'] = 'weidian';
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/complete.html';
    }
    
    public function cancellist($page=1,$fenxiao) 
    {
        $this->check_weidian();
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = -1;
        $filter['from'] = 'weidian';
        $filter['pei_type'] = "<>:2";
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/cancellist.html';
    }
    

    public function confirm($page=1,$fenxiao)
    {
        $this->check_weidian();
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 4;
        $filter['from'] = 'weidian';
        $filter['pay_status'] = 1;
        $filter['pei_type'] = "<>:2";
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/confirm.html';
    }


    // 确认订单
    public function accept($order_id=null)
    {
        $this->check_weidian();
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=0){
                $this->msgbox->add('该订单不可确认',213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单未支付',214);
            }else if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                //自动打印订单判断 todo...
                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已确认订单','status'=>1);
                K::M('order/log')->create($log);
                //通知用户,APP推送 weixin模板消息
                K::M('order/order')->send_member('商家已经确认订单', sprintf("订单(%s)商家已经确认订单", $order_id), $order);
                $this->msgbox->add('订单确认成功');
                $this->msgbox->set_data("is_one",1);
            }else{
                $this->msgbox->add('确认订单失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && $order['pay_status'] == 1){
                            if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                                //自动打印订单判断 todo...
                                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已确认订单','status'=>1);
                                K::M('order/log')->create($log);
                                //通知用户,APP推送 weixin模板消息
                                K::M('order/order')->send_member('商家已经确认订单', sprintf("订单(%s)商家已经确认订单", $order_id), $order);
                                $success_count ++;
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量确认订单'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }  
        }    
    }
    
    // 发货操作
    public function sendgoods($order_id=null)
    {
        $this->check_weidian();
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=1){
                $this->msgbox->add('该订单不可发货',213);
            }else if(K::M('order/order')->update($order_id, array('order_status'=>3))){
                //自动打印订单判断 todo...
                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已发货','status'=>3);
                K::M('order/log')->create($log);
                //通知用户,APP推送 weixin模板消息
                K::M('order/order')->send_member('商家已经发货', sprintf("订单(%s)商家已经发货", $order_id), $order);
                $this->msgbox->add('发货成功');
                $this->msgbox->set_data("is_one",1);
            }else{
                $this->msgbox->add('发货失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && $order['order_status'] == 1){
                            if(K::M('order/order')->update($order_id, array('order_status'=>3))){
                                //自动打印订单判断 todo...
                                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已经发货','status'=>1);
                                K::M('order/log')->create($log);
                                //通知用户,APP推送 weixin模板消息
                                K::M('order/order')->send_member('商家已经发货', sprintf("订单(%s)商家已经发货", $order_id), $order);
                                $success_count ++;
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量发货'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }  
        }    
    }
    
    
    
    // 确认送达操作
    public function service($order_id=null)
    {
        $this->check_weidian();
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=3){
                $this->msgbox->add('该订单不可确认送达',213);
            }else if(K::M('order/order')->update($order_id, array('order_status'=>4))){
                //自动打印订单判断 todo...
                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已确认送达','status'=>3);
                K::M('order/log')->create($log);
                //通知用户,APP推送 weixin模板消息
                K::M('order/order')->send_member('商家已确认送达', sprintf("订单(%s)商家已确认送达", $order_id), $order);
                $this->msgbox->add('确认送达成功');
                $this->msgbox->set_data("is_one",1);
            }else{
                $this->msgbox->add('确认送达失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && $order['order_status'] == 3){
                            if(K::M('order/order')->update($order_id, array('order_status'=>4))){
                                //自动打印订单判断 todo...
                                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已确认送达','status'=>1);
                                K::M('order/log')->create($log);
                                //通知用户,APP推送 weixin模板消息
                                K::M('order/order')->send_member('商家已确认送达', sprintf("订单(%s)商家已确认送达", $order_id), $order);
                                $success_count ++;
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量确认送达'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }  
        }    
    }

    public function setpei($order_id, $type=0)
    {
        $this->check_weidian();
        $pei_type = $type ? 1 : 0;
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if($order['from'] != 'weidian'){
            $this->msgbox->add('非法操作',212);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('已有骑手接单不可操作',212);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(K::M('order/order')->update($order_id, array('pei_type'=>$pei_type, 'lasttime'=>__TIME))){
            $this->msgbox->add('修改配送方式成功');
        }      
    }

    
    
    //订单配送完成
    public function finish($order_id=null)
    { 
        $this->check_weidian();
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if($order['from'] != 'weidian'){
            $this->msgbox->add('非法操作',212);
        }else if($order['order_status'] != 4 &&$order['order_status'] != 3){            
            $this->msgbox->add('该订单不可完成',213);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>8, 'lasttime'=>__TIME))){
            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家确认完成','status'=>3);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('订单已确认完成', sprintf('订单(%s)商家已确认完成', $order_id), $order);
            $this->msgbox->add('订单已确认完成');
        }else if($ids = $this->GP('order_id')){ //批量配送
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && in_array($order['order_status'], array(3, 4))){
                            if(K::M('order/order')->update($order_id, array('order_status'=>8,'lasttime'=>__TIME))){
                                //自动打印订单判断 todo...
                                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家确认完成','status'=>3);
                                K::M('order/log')->create($log);
                                //通知用户,APP推送 weixin模板消息
                                K::M('order/order')->send_member('订单已确认完成', sprintf('订单(%s)商家已确认完成', $order_id), $order);
                                $success_count ++;
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);                
                $this->msgbox->add('批量确认完成'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }             
        }
    }

    // 自提订单
    public function ziti($page,$fenxiao)
    {
        $this->check_weidian();
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'weidian';
        $filter['pei_type'] = 2;
        $filter['pay_status'] = 1;
        $filter['weidian']['type'] = 'default';
        if($fenxiao == 'fenxiao'){
            $filter['weidian']['type'] = 'fenxiao';
        }
        $filter['closed'] = 0;
        if($items = K::M('weidian/order')->items_by_status($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
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
        $this->pagedata['fenxiao'] = $fenxiao;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/order/ziti.html';
    }

    // 自提订单核销弹框
    public function dialog($order_id)
    {
        $this->check_weidian();
        if($order_id = (int)$order_id) {
            if($detail = K::M('weidian/order')->detail($order_id)) {
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'merchant:weidian/order/dialog.html';   
    }

    // 自提订单核销
    public function setspend()
    {
        $this->check_weidian();
        if($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'order_id,spend_number')){
                $this->msgbox->add('非法的数据提交', 211);
            }if($data['order_id'] != (int)$data['order_id']){
                $this->msgbox->add('订单不存在', 212);
            }else if(!$order = K::M('order/order')->detail($data['order_id'])) {
                $this->msgbox->add('订单不存在', 213);
            }else if(!$weidian_order = K::M('weidian/order')->detail($order['order_id'])) {
                $this->msgbox->add('订单不存在', 213);
            }else if($order['closed'] != 0) {
                $this->msgbox->add('订单不存在或已被删除',214);
            }else if($order['shop_id'] != $this->shop_id) {
                $this->msgbox->add('非法操作',215);
            }else if(!($order['order_status']==1 && $order['pay_status']==1)) {
                $this->msgbox->add('订单状态不可核销',216);
            }else if($weidian_order['spend_status'] == 1 && $order['order_status'] == 8) {
                $this->msgbox->add('订单已核销，请勿重复操作',217);
            }else if($weidian_order['spend_number'] != $data['spend_number']) {
                $this->msgbox->add('核销密码不正确',218);
            }else {  
                if(K::M('order/order')->update($order['order_id'], array('order_status'=>8))) {
                    K::M('weidian/order')->update($order['order_id'], array('spend_status'=>1));
                    $this->msgbox->add('核销成功');
                }
            }
        }
    }

    public function detail($order_id)
    {
        $this->check_weidian();
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('weidian/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else{
            if($staff_id = (int)$order['staff_id']){
                $this->pagedata['staff'] = K::M('staff/staff')->detail($staff_id);
            }
            $this->pagedata['product_list'] = K::M('weidian/orderproduct')->items(array('order_id'=>$order_id));
            $this->pagedata['log_list'] = K::M('order/log')->items(array('order_id'=>$order_id));
            $this->pagedata['member'] = K::M('member/member')->detail($order['uid']);            
            $this->pagedata['detail'] = $order;
            $this->tmpl = 'merchant:weidian/order/detail.html';
        }
    }

}
