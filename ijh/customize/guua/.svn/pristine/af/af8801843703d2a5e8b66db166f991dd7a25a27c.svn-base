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

    public function index($page=1)
    {
       $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = 0;
        $filter[':SQL'] = '(`online_pay`=0 OR (`online_pay`=1 AND `pay_status`=1))';
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        
        $order_ids = array();
        foreach($items as $k=>$val){
            $items[$k]['js_price'] = $val['money'] + $val['amount'];
            $order_ids[$val['order_id']] = $val['order_id'];
            // 管理员取消超时未付款的订单
            if(__TIME - $val['dateline'] > 1800) {
                K::M('order/order')->cancel($val['order_id'], null, 'admin');
            }
        }
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
    
    
    public function pei($page=1)
    {
       $filter = $pager =  array();
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
    
    public function cancel($order_id=null){
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L(L('非法操作')),212);
            }else if($order['order_status'] !=0&&$order['order_status']!=1){
                $this->msgbox->add(L('该订单不可取消'),213);
            }else if(K::M('order/order')->cancel($order_id,$order,'shop')){
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),215);
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
                $this->msgbox->add(L('SUCCESS'));
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
    
    public function cancellist($page=1) 
    {
    	$filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = -1;
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
    

    public function delivered($page=1) 
    {
    	$filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['order_status'] = array(3,4);
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
            $order = $this->filter_fields('order_id,order_status,pay_status,product_price,amount,pei_time,note,contact,mobile,order_youhui,first_youhui,hongbao,comment_status',$order);
        	if($order_product = K::M('order/product')->items(array('order_id'=>$order['order_id']))) {
        		foreach($order_product as $k=>$v) {
        			$goods[] = $this->filter_fields('product_name,product_number',$v);
        		}
                
        	}
            if($order['comment_status'] == 1) {
                $comment = K::M('shop/comment')->find(array('order_id'=>$order_id));
            }
        }
        $this->pagedata['order'] = $order;
        $this->pagedata['goods'] = $order_product;
        $this->pagedata['comment'] = $comment;
    	$this->tmpl = 'biz/order/detail.html';
    }
    
    

    // 接单
    public function accept($order_id=null,$pei_type=nul) {
        if($order_id = (int)$order_id){
            $pei_type = (int)$pei_type;
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L(L('非法操作')),212);
            }else if($order['order_status'] !=0){
                $this->msgbox->add(L('该订单不可接单'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add(L('该订单未支付'),214);
            }else if(K::M('order/order')->update($order_id,array('order_status'=>1,'pei_type'=>$pei_type))){
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=> L('商家已接单'),'dateline'=>__TIME,'type'=>3));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --商家已接单
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>L('商家已接单'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('商家已接单')), 'remark' =>sprintf(L('您的订单于 %s 已接单'), date('Y-m-d H:i:s',__TIME)));
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add(L('SUCCESS'));
                $this->msgbox->set_data("is_one",1);
            }else{
                $this->msgbox->add(L('FAIL'),215);
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
                    K::M('order/order')->update($val,array('order_status'=>1,'pei_type'=>$pei_type));
                    K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=>L('商家已接单'),'dateline'=>__TIME,'type'=>3));
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
                        $a = array('title'=>L('商家已接单'), 'items' => array('OrderSn' => $val, 'OrderStatus' => L('商家已接单')), 'remark' =>sprintf(L('您的订单于 %s 已接单'), date('Y-m-d H:i:s',__TIME)));
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add(L('SUCCESS'));
            }
            
        }    
    }

    // 配送
    public function peisong($order_id=null) {
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=1){
                $this->msgbox->add(L('该订单不可配送'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add(L('该订单不可配送'),214);
            }/*else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add('第三方配送必须配送员接单',215);
            }*/else if($order['staff_id']>0){
                K::M('order/order')->update($order_id,array('order_status'=>3));
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>L('开始配送'),'dateline'=>__TIME,'type'=>4));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息
                if ($wx_openid) {
                    //获取模版消息配置 --开始配送
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>L('开始配送'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('开始配送')), 'remark' =>sprintf(L('您的订单于 %s 开始配送'), date('Y-m-d H:i:s',__TIME)));
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add(L('SUCCESS'));
            }else if(!$order['staff_id']){
                K::M('order/order')->update($order_id,array('order_status'=>3,'pei_type'=>0));
                K::M('order/log')->create(array('order_id'=>$order_id,'from'=>'shop','log'=>L('开始配送'),'dateline'=>__TIME,'type'=>4));
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --开始配送
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>L('开始配送'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('开始配送')), 'remark' =>sprintf(L('您的订单于 %s 开始配送'), date('Y-m-d H:i:s',__TIME)));
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),216);
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
                     K::M('order/log')->create(array('order_id'=>$val,'from'=>'shop','log'=>L('开始配送'),'dateline'=>__TIME,'type'=>4));
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
                        $a = array('title'=>L('开始配送'), 'items' => array('OrderSn' => $val, 'OrderStatus' => L('开始配送')), 'remark' =>sprintf(L('您的订单于 %s 开始配送'), date('Y-m-d H:i:s',__TIME)));
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add(L('SUCCESS'));
            }
        }
    }
    
    
    public function finish($order_id=null) { //订单完成
        $inviteCfg = $this->system->config->get('invite');
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add(L('订单不存在'),210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add(L('订单不存在'),211);
            }else if($order['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'),212);
            }else if($order['order_status'] !=3&&$order['order_status'] !=4){
                $this->msgbox->add(L('该订单不可完成'),213);
            }else if($order['online_pay']==1&&$order['pay_status'] ==0){
                $this->msgbox->add(L('该订单不可完成'),214);
            }else if($order['pei_type']!=0&&$order['staff_id'] ==0){
                $this->msgbox->add(L('该订单不可完成'),215);
            }else if(K::M('order/order')->confirm($order_id,$order,'shop',$inviteCfg['invite_order_money'])) {
                if($myuser = K::M('member/member')->detail($order['uid'])) {
                    $wx_openid = $myuser['wx_openid'];
                }
                //更新微信模版消息 
                if ($wx_openid) {
                    //获取模版消息配置 --订单已完成
                    $wx_config = $this->system->config->get('wx_config');
                    $config = $this->system->config->get('site');
                    $a = array('title'=>L('订单已完成'), 'items' => array('OrderSn' => $order_id, 'OrderStatus' => L('订单已完成')), 'remark' => sprintf(L('您的订单于 %s 已完成'), date('Y-m-d H:i:s',__TIME)));
                    $url = K::M('helper/link')->mklink('order:detail', array('args'=>$order_id), array(), 'www');
                    K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                }
                $this->msgbox->add(L('SUCCESS'));
            }else{
                $this->msgbox->add(L('FAIL'),216);
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
                        $a = array('title'=>L('订单已完成'), 'items' => array('OrderSn' => $val, 'OrderStatus' => L('订单已完成')), 'remark' => sprintf(L('您的订单于 %s 已完成'), date('Y-m-d H:i:s',__TIME)));
                        $url = K::M('helper/link')->mklink('order:detail', array('args'=>$val), array(), 'www');
                        K::M('weixin/wechat')->wechat_client($config)->sendTempMsg($wx_openid, $wx_config['order_id'], $url, $a);    
                    }
                }
                $this->msgbox->add(L('SUCCESS'));
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
            $this->msgbox->add(L('SUCCESS'));
        }
    }
}
