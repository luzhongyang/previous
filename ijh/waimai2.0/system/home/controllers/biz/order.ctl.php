<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_order extends Ctl_Biz
{
    // 待接单订单列表
    public function index($page=1)
    {
       $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter['from'] = array('waimai', 'weidian_waimai');
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            if(__TIME - $val['dateline'] > 1800 && $val['order_status']==0 && $val['pay_status']==0 && $val['online_pay']==1) {
                K::M('order/order')->cancel($val['order_id'], $val, 'admin','订单超过30分钟未付款自动取消');
            }
            if(__TIME - $val['dateline'] > 3600 && $val['order_status']==0 && $val['pay_status']==1) {
                K::M('order/order')->cancel($val['order_id'], $val, 'admin','订单逾期1小时内无人接单自动取消');
            }
        }
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            $order_ids[] = $val['order_id'];
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $waimai_order = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $this->pagedata['waimai_order'] = $waimai_order;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['payments'] = K::M('order/order')->get_payments();
        $this->tmpl = 'biz/order/index.html';
    }

    public function porder($order_id){
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),211);
        }else{
           $order['products'] = K::M('order/product')->items(array('order_id'=>$order['order_id'])); 
           $order['js_price'] = $order['amount'] + $order['money'];
           $this->pagedata['detail'] = $order; 
           $this->pagedata['payments'] = K::M('order/order')->get_payments();
           $this->tmpl = 'biz/order/porder.html';
        }
    }
    
    public function check_print()
    {
        //判断打印机
        if(!$printer = K::M('shop/print')->find(array('shop_id'=>$this->shop_id,'status'=>1))) {
            $this->msgbox->add('打印机未添加或未启用',210);
        }else {
            $this->msgbox->add('success');
        }
    }

    public function yun_print()
    {
        K::M('order/order')->yunprint($this->GP('order_id'), $this->GP('nums'));
    }
    
    // 待配送订单列表
    public function pei($page=1)
    {
        $filter = $pager =  array();
        $filter['from'] = array('waimai', 'weidian_waimai');
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 1;
        //$filter[':SQL'] = '(`pei_type`=0 OR (`pei_type`=1 AND `staff_id`>0))';
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $waimai_order = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $this->pagedata['waimai_order'] = $waimai_order;
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->tmpl = 'biz/order/pei.html';
    }
    
    // 已完成订单列表
    public function complete($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(4,5,6,7,8);
        $filter['from'] = array('waimai', 'weidian_waimai');
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $waimai_order = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $this->pagedata['waimai_order'] = $waimai_order;
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'biz/order/complete.html';
    }
    
    // 已取消订单列表
    public function cancellist($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = -1;
        $filter['from'] = array('waimai', 'weidian_waimai');
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $waimai_order = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $this->pagedata['waimai_order'] = $waimai_order;
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'biz/order/cancellist.html';
    }
    
    // 配送中订单列表
    public function delivered($page=1) 
    {
    	$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 3;
        $filter['from'] = array('waimai', 'weidian_waimai');
        $orderby = array('order_id'=>'desc');
        if($items = K::M('order/order')->items($filter, $orderby , $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $order_ids = $staff_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $waimai_order = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        $this->pagedata['waimai_order'] = $waimai_order;
        $order_product = K::M('order/product')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    $items[$k]['products'][] = $v;
                }
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['status'] = K::M('order/order')->get_order_status();
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'biz/order/delivered.html';
    }
    
    public function tongji($page=1) 
    {
    	$this->tmpl = 'biz/order/tongji.html';
    }

    public function detail($order_id) 
    {
    	if($order_id != (int)$order_id) {
        	$this->msgbox->add(L('订单不存在'),210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
        	$this->msgbox->add(L('订单不存在'),211);
        }else if($order['shop_id'] != $this->shop_id){
        	$this->msgbox->add(L(L('非法操作')),212);
        }else {
            $order = $this->filter_fields('order_id,order_status,pay_status,total_price,amount,pei_time,intro,contact,mobile,order_youhui,first_youhui,hongbao,comment_status,dateline',$order);
        	if($order_product = K::M('order/product')->items(array('order_id'=>$order['order_id']))) {
        		foreach($order_product as $k=>$v) {
        			$goods[] = $this->filter_fields('product_name,product_number',$v);
        		}
                
        	}
            if($order['comment_status'] == 1) {
                $comment = K::M('shop/comment')->find(array('order_id'=>$order_id));
            }
            if($complaint = K::M('order/complaint')->find(array('shop_id'=>$order['shop_id'],'order_id'=>$order_id,'uid'=>$order['uid']))) {
                $this->pagedata['complaint'] = $complaint;
            }
            $this->pagedata['order'] = $order;
            $this->pagedata['goods'] = $order_product;
            $this->pagedata['comment'] = $comment;
            $this->tmpl = 'biz/order/detail.html';
        }  
    }
    
    // 接单
    public function accept($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=0){
                $this->msgbox->add('该订单不可接单',213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单未支付',214);
            }else if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                //自动打印订单判断 todo...
                $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','type'=>3);
                K::M('order/log')->create($log);
                //通知用户,APP推送 weixin模板消息
                K::M('order/order')->send_member('商家已经接单', sprintf("订单(%s)商家已经接单", $order_id), $order,'jiedan');
                $this->msgbox->add('接单成功');
            }else{
                $this->msgbox->add('接单失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && $order['pei_type'] != 2){
                            if($order['online_pay']==1 && $order['pay_status'] ==0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>1,'jd_time'=>__TIME, 'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','type'=>3);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('商家已经接单', sprintf("订单(%s)商家已经接单", $order_id), $order,'jiedan');
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量接单'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }  
        }    
    }

    // 取消订单
    public function cancel($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
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
                }else if(!$order = K::M('order/order')->detail($val)) {
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

    // 设置订单为骑手配送
    public function setpei($order_id, $type)
    {
        $pei_type = $type ? 1 : 0;
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['from'], array('waimai','weidian_waimai'))){
            $this->msgbox->add('非法操作',212);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('已有骑手接单不可操作',212);
        }else if(!in_array($order['pei_type'], array(0, 1, 4))){
            $this->msgbox->add('该订单不可配送',214);
        }else if(!in_array($order['order_status'], array(1, 2, 4))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(K::M('order/order')->update($order_id, array('pei_type'=>$pei_type, 'lasttime'=>__TIME))){
            $this->msgbox->add('修改配送方式成功');
        }      
    }

    // 开始配送
    public function peisong($order_id=null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['order_status'], array(1, 2))){
            $this->msgbox->add('该订单不可配送',213);
        }else if(!in_array($order['pei_type'], array(0, 1, 4))){
            $this->msgbox->add('该订单不可配送',214);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('该订单已由骑手配送',215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0, 'lasttime'=>__TIME))){
            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'开始由商家配送','type'=>4);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('订单开始配送', sprintf('订单(%s)商家已经开始配送', $order_id), $order);
            $this->msgbox->add('订单由商家开始配送');
            $this->msgbox->set_data('forward', '?biz/waimai/order/waimai-delivered.html');
        }else if($ids = $this->GP('order_id')){ //批量配送
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && in_array($order['pei_type'], array(0, 1))){
                            if($order['staff_id'] == 0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>3, 'pei_type'=>0,'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'开始由商家配送','type'=>4);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('订单开始配送', sprintf('订单(%s)商家已经开始配送', $order_id), $order);
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);                
                $this->msgbox->set_data('forward', '?biz/order/delivered.html');
                $this->msgbox->add('批量配送订单'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }             
        }
    }
    
    // 订单配送完成
    public function finish($order_id=null)
    { 
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['from'], array('waimai','weidian_waimai','pintuan','weidian_pintuan'))){
            $this->msgbox->add('非法操作',212);
        }else if(!in_array($order['order_status'], array(1, 2, 3))){            
            $this->msgbox->add('该订单不可配送',213);
        }else if(!in_array($order['pei_type'], array(0, 1))){
            $this->msgbox->add('该订单不可配送',214);
        }else if($order['staff_id'] > 0){
            $this->msgbox->add('该订单已由骑手配送',215);
        }else if(K::M('order/order')->update($order_id, array('order_status'=>4, 'pei_type'=>0, 'lasttime'=>__TIME))){
            $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家确认送达','type'=>5);
            K::M('order/log')->create($log);
            //通知用户,APP推送 weixin模板消息
            K::M('order/order')->send_member('订单已确认送达', sprintf('订单(%s)商家确认送达', $order_id), $order);
            $this->msgbox->add('订单已配送');
        }else if($ids = $this->GP('order_id')){ //批量配送
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['shop_id'] == $this->shop_id && empty($order['order_status']) && in_array($order['pei_type'], array(0, 1))){
                            if($order['staff_id'] == 0){
                                if(K::M('order/order')->update($order_id, array('order_status'=>4, 'pei_type'=>0,'lasttime'=>__TIME))){
                                    //自动打印订单判断 todo...
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'订单由商家配送达','type'=>5);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('订单已送达', sprintf('订单(%s)商家已经送达', $order_id), $order);
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);                
                $this->msgbox->add('批量配送订单完成'.$success_count.'个');
            }else{
                $this->msgbox->add('未选有效订单');
            }             
        }
    }

    // 自提订单
    public function ziti($page)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(1,8);
        $filter['from'] = array('waimai', 'weidian_waimai');
        $filter['closed'] = 0;
        $filter['pei_type'] = 3;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }        
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $items[$k]['spend_number'] = $v2['spend_number'];  
                            $items[$k]['spend_status'] = $v2['spend_status'];
                            $order_product[$kk]['freight'] = $v2['freight']; 
                        }
                    }   
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }        
        }
        $this->pagedata['payments'] = K::M('order/order')->get_payments();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/order/ziti.html';
    }

    // 自提订单核销弹框
    public function dialog($order_id)
    {
        if($order_id = (int)$order_id) {
            if($detail = K::M('order/order')->detail($order_id)) {
                $this->pagedata['detail'] = $detail;
            }
        }
        $this->tmpl = 'biz/order/dialog.html';   
    }

    // 自提订单核销
    public function setspend()
    {
        if($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'order_id,spend_number')){
                $this->msgbox->add('非法的数据提交', 211);
            }if($data['order_id'] != (int)$data['order_id']){
                $this->msgbox->add('订单不存在', 212);
            }else if(!$order = K::M('order/order')->detail($data['order_id'])) {
                $this->msgbox->add('订单不存在', 213);
            }else if(!$waimai_order = K::M('waimai/order')->detail($order['order_id'])) {
                $this->msgbox->add('订单不存在', 213);
            }else if($order['closed'] != 0) {
                $this->msgbox->add('订单不存在或已被删除',214);
            }else if($order['shop_id'] != $this->shop_id) {
                $this->msgbox->add('非法操作',215);
            }else if(!$data['spend_number']) {
                $this->msgbox->add('请输入核销密码',216);
            }else if(!($order['order_status']==1 && $order['pay_status']==1)) {
                $this->msgbox->add('订单状态不可核销',217);
            }else if($waimai_order['spend_status'] == 1 && $order['order_status'] == 8) {
                $this->msgbox->add('订单已核销，请勿重复操作',218);
            }else if($waimai_order['spend_number'] != $data['spend_number']) {
                $this->msgbox->add('核销密码不正确',219);
            }else {
                if(K::M('order/order')->confirm($order['order_id'], $order, 'shop')){
                    $this->msgbox->add('订单核销成功');
                }
            }
        }
    }
    
    public function reply()
    {
        if(!$order_id = (int)$this->GP('order_id')){
            $this->msgbox->add(L('订单不存在'), 211);
        }if(!$comment = K::M('shop/comment')->find(array('order_id'=>$order_id))){
            $this->msgbox->add(L('回复的评论不存在'), 212);
        }else if($comment['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($comment['reply_time']){
            $this->msgbox->add(L('您已经回复过了'), 214);
        }else if(!$reply = $this->GP('reply')) {
            $this->msgbox->add(L('评论内容不能为空'), 215);
        }else if(K::M('shop/comment')->update($comment['comment_id'], array('reply'=>$reply, 'reply_time'=>__TIME, 'reply_ip'=>__IP))){
            K::M('order/order')->update($order_id,array('comment_status'=>1));
            $this->msgbox->add(L('操作成功'));
        }
    }
}
