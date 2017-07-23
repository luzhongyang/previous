<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_order extends Ctl
{

    public function index($page=1)
    {
        $this->waimai();
    }

    
    public function porder($order_id){
       $order_id = (int)$order_id;
        if(!$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else{
           $order['products'] = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id'])); 
           $order['js_price'] = $order['amount'] + $order['money'];
           $this->pagedata['detail'] = $order; 
           $this->pagedata['payments'] = K::M('order/order')->get_payments();
           $this->tmpl = 'merchant:order/waimai/porder.html';
        }
    }
    
    
    public function pei($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 1;
        $filter['from'] = 'waimai';
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
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }   
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }        
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        
        $this->tmpl = 'merchant:order/waimai/pei.html';
    }
    
    public function cancel($order_id=null){
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=0&&$order['order_status']!=1){
                $this->msgbox->add('该订单不可取消',213);
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
                }else if($order['order_status'] !=0&&$order['order_status']!=1){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     K::M('order/order')->cancel($val,null,'shop');
                }
                $this->msgbox->add('批量取消成功');
            }
        }
    }

    
    public function complete($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 8;
        $filter['from'] = 'waimai';
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
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }  
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:order/waimai/complete.html';
    }
    
    public function cancellist($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = -1;
        $filter['from'] = 'waimai';
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
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }  
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:order/waimai/cancellist.html';
    }
    

    public function delivered($page=1) 
    {
    	$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(3,4);
        $filter['from'] = 'waimai';
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
        $order_product = K::M('waimai/orderproduct')->items(array('order_id'=>$order_ids));
        $freight = K::M('waimai/order')->items(array('order_id'=>$order_ids));
        foreach($items as $k=>$val){
            foreach ($order_product as $kk=>$v){
                if($val['order_id'] == $v['order_id']){
                    foreach($freight as $k2=>$v2) {
                        if($v['order_id'] == $v2['order_id']) {
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }
                    
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }        
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->tmpl = 'merchant:order/waimai/delivered.html';
    }
    
    public function tongji($page=1) 
    {
    	$this->tmpl = 'merchant:order/tongji.html';
    }

  
    // 接单
    public function accept($order_id=null,$pei_type=nul) {
        if($order_id = (int)$order_id){
            $pei_type = (int)$pei_type;
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
            }else if(K::M('order/order')->update($order_id, array('order_status'=>1))){
                K::M('waimai/order')->update($order_id, array('pei_type'=>$pei_type));
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>'商家已接单','status'=>3));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --商家已接单
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>'商家已接单！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '商家已接单'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 已接单');
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add('接单成功');
                $this->msgbox->set_data("is_one",1);
            }else{
                $this->msgbox->add('接单失败',215);
            }
        }else if($ids = $this->GP('order_id')){
            $pei_type = (int)$this->GP('pei_type');
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=0){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                    K::M('order/order')->update($val,array('order_status'=>1));
                    K::M('waimai/order')->update($order_id, array('pei_type'=>$pei_type));
                    K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=>'商家已接单','status'=>3));
                    if($order_detail = K::M('order/order')->detail($val)) {
                        if($myuser = K::M('member/member')->detail($order_detail['uid'])) {
                            $wx_openid = $myuser['wx_openid'];
                        }
                    }
                    //更新微信模版消息 
                    if ($wx_openid) {
                        //获取模版消息配置 --商家已接单
                        $wx_config = $this->system->config->get('wx_config');
                        $config = $this->system->config->get('site');
                        $a = array('title'=>'商家已接单！', 'items' => array('OrderSn' => $val, 'OrderStatus' => '商家已接单'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 已接单');
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add('批量接单成功');
            }   
        }    
    }

    // 配送
    public function peisong($order_id=null) {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=1){
                $this->msgbox->add('该订单不可配送',213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单不可配送',214);
            }/*else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add('第三方配送必须配送员接单',215);
            }*/else if($order['staff_id']>0){
                K::M('order/order')->update($order_id,array('order_status'=>3));
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>'开始配送','status'=>4));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息
                if ($wx_openid) {
                    //获取模版消息配置 --开始配送
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>'开始配送！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '开始配送'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 开始配送');
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add('订单配送开始');
                $this->msgbox->set_data('forward', '?biz/order/waimai-delivered.html');
            }else if(!$order['staff_id']){
                K::M('waimai/order')->update($order_id,array('pei_type'=>0));
                K::M('order/order')->update($order_id,array('order_status'=>3));
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>'开始配送','status'=>4));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --开始配送
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>'开始配送！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '开始配送'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 开始配送');
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add('订单配送开始');
                $this->msgbox->set_data('forward', '?biz/order/waimai-delivered.html');
            }else{
                $this->msgbox->add('开始配送失败',216);
            } 
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=1){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                     if(!$val['staff_id']){
                         K::M('order/order')->update($val,array('order_status'=>3,'pei_type'=>0));
                     }else{
                         K::M('order/order')->update($val,array('order_status'=>3));
                     }
                     K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=>'开始配送','dateline'=>__TIME,'type'=>4));
                    if($order_detail = K::M('order/order')->detail($val)) {
                        if($myuser = K::M('member/member')->detail($order_detail['uid'])) {
                            $wx_openid = $myuser['wx_openid'];
                        }
                    }
                    //更新微信模版消息 
                    if ($wx_openid) {
                        //获取模版消息配置 --开始配送
                        $wx_config = $this->system->config->get('wx_config');
                        $config = $this->system->config->get('site');
                        $a = array('title'=>'开始配送！', 'items' => array('OrderSn' => $val, 'OrderStatus' => '开始配送'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 开始配送');
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add('批量配送成功');
            }
        }
    }
    
    
    public function finish($order_id=null) { //订单完成
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',212);
            }else if($order['order_status'] !=3&&$order['order_status'] !=4){
                $this->msgbox->add('该订单不可完成',213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add('该订单不可完成',214);
            }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add('该订单不可完成',215);
            }else if(K::M('order/order')->confirm($order_id,$order,'shop')){
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --订单已完成
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>'订单已完成！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '订单已完成'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 已完成');
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add('订单确认成功');
            }else{
                $this->msgbox->add('订单确认失败',216);
            } 
        }else if($ids = $this->GP('order_id')){
            foreach($ids as $k=>$val){
                if(!$val) {
                    unset($ids[$k]);
                }else if(!$order = K::M('order/order')->detail($val)) {
                    unset($ids[$k]);
                }else if($order['shop_id'] != $this->shop_id){
                    unset($ids[$k]);
                }else if($order['order_status'] !=3&&$order['order_status'] !=4){
                    unset($ids[$k]);
                }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                    unset($ids[$k]);
                }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                    unset($ids[$k]);
                }
            }
            if($ids){
                foreach($ids as $k=>$val){
                    K::M('order/order')->confirm($val,null,'shop');
                    if($order_detail = K::M('order/order')->detail($val)) {
                        if($myuser = K::M('member/member')->detail($order_detail['uid'])) {
                            $wx_openid = $myuser['wx_openid'];
                        }
                    }
                    //更新微信模版消息 
                    if ($wx_openid) {
                        //获取模版消息配置 --订单已完成
                        $wx_config = $this->system->config->get('wx_config');
                        $config = $this->system->config->get('site');
                        $a = array('title'=>'订单已完成！', 'items' => array('OrderSn' => $val, 'OrderStatus' => '订单已完成'), 'remark' =>'您的订单于 '.date('Y-m-d H:i:s',__TIME).' 已完成');
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add('批量确认成功');
            }
        }
    }

    // 外卖订单
    public function waimai()
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter['from'] = 'waimai';
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
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
                            $order_product[$kk]['freight'] = $v2['freight'];   
                        }
                    }   
                }
            }
            foreach ($order_product as $kk2=>$vv2){
                $items[$k]['products'][] = $vv2;
            }        
        }
        
        $this->pagedata['payments'] = K::M('waimai/order')->get_payments();
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:order/waimai/index.html';
    }

    // 团购订单
    public function tuan()
    {
        $this->t_index();
    }
    public function t_index($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('tuan/tuan')->items($filter, array('tuan_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->tmpl = 'merchant:order/tuan/index.html';
    }
    public function t_history()
    {
        $this->tmpl = 'merchant:order/tuan/history.html';
    }
    public function t_manager($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'tuan';

        $order_items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, 50, $count);
        foreach($order_items as $k => $v) {
            $order_items[$k] = $this->filter_fields('order_id,order_status,dateline,clientip',$v);
            $orderids[] = $v['order_id'];
        }

        $order_photos = K::M('order/photo')->items(array('order_id'=>$orderids), array('photo_id'=>'desc'), $page, 50, $count);
 
        if($tuan_order_items = K::M('tuan/order')->items(array('order_id'=>$orderids), array('tuan_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }

        foreach($tuan_order_items as $k1 => $v1) {
            foreach($order_items as $k2 => $v2) {
                if($v1['order_id'] == $v2['order_id']) {
                    $tuan_order_items[$k1]['order_status'] = $v2['order_status'];
                    $tuan_order_items[$k1]['dateline'] = $v2['dateline'];
                    $tuan_order_items[$k1]['clientip'] = $v2['clientip'];
                }
            }
            foreach($order_photos as $k3 => $v3) {
                if($v1['order_id'] == $v3['order_id']) {
                    $tuan_order_items[$k1]['photo'] = $v3['photo'];
                }
            }
        }
        
        $this->pagedata['items'] = $tuan_order_items;
        $this->tmpl = 'merchant:order/tuan/manager.html';
    }
    public function t_quan()
    {
        $this->tmpl = 'merchant:order/tuan/quan.html';
    }

    public function t_confirm() 
    {
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
    }

    public function maidan($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['from'] = 'maidan';

        $order_items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, 50, $count);
        foreach($order_items as $k => $v) {
            $order_items[$k] = $this->filter_fields('order_id,total_price,pay_status,dateline',$v);
            $orderids[] = $v['order_id'];
        }
        
        $order_photos = K::M('order/photo')->items(array('order_id'=>$orderids), array('photo_id'=>'desc'), $page, 50, $count);
        if($maidan_order_items = K::M('maidan/order')->items(array('order_id'=>$orderids), array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }

        foreach($maidan_order_items as $k1 => $v1) {
            foreach($order_items as $k2 => $v2) {
                if($v1['order_id'] == $v2['order_id']) {
                    $maidan_order_items[$k1]['total_price'] = $v2['total_price'];
                    $maidan_order_items[$k1]['pay_status'] = $v2['pay_status'];
                    $maidan_order_items[$k1]['dateline'] = $v2['dateline'];
                }
            }
            foreach($order_photos as $k3 => $v3) {
                if($v1['order_id'] == $v3['order_id']) {
                    $maidan_order_items[$k1]['photo'] = $v3['photo'];
                }
            }
        }

        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $maidan_order_items;
        $this->tmpl = 'merchant:order/maidan/index.html';
    }

    // 查看订单消息详情
    public function detailorder($order_id) 
    {
        if($order_id != (int)$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('非法的订单',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else {
            $order = $this->filter_fields('order_id,from,order_status,pay_status,total_price,,contact,mobile,dateline,order_status_label',$order);
        }
        $this->pagedata['order'] = $order;
        $this->tmpl = 'merchant:order/detailorder.html';
    }

    // 查看评价消息详情
    public function detailcomment($order_id) 
    {
        
        if($order_id != (int)$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('该订单不存在',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else {
            $order = $this->filter_fields('order_id,from,order_status,pay_status,total_price,,contact,mobile,dateline,order_status_label',$order);
            $comment = K::M('shop/comment')->find(array('order_id'=>$order_id));
            if($comment){
                $comment['photos'] = K::M('shop/commentphoto')->items(array('comment_id'=>$comment['comment_id']));
            }
            $order['comment'] = $comment;

            $this->pagedata['order'] = $order;
            
            $this->tmpl = 'merchant:order/detailcomment.html';
        }
        
    }

    // 查看投诉消息详情
    public function detailcomplain($order_id) 
    {
        if($order_id != (int)$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('非法的订单',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else {
            $order = $this->filter_fields('order_id,from,order_status,pay_status,total_price,,contact,mobile,dateline,order_status_label',$order);
        }
        $this->pagedata['order'] = $order;
        
        $this->tmpl = 'merchant:order/detailcomplain.html';
    }

    // 查看系统消息详情
    public function detailsystem($order_id) 
    {
        if($order_id != (int)$order_id) {
            $this->msgbox->add('订单号不存在',210);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('非法的订单',211);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',212);
        }else {
            $order = $this->filter_fields('order_id,from,order_status,pay_status,total_price,,contact,mobile,dateline,order_status_label',$order);
        }
        $this->pagedata['order'] = $order;
        
        $this->tmpl = 'merchant:order/detailsystem.html';
    }

}
