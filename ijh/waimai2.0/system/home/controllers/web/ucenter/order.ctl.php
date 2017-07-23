<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Order extends Ctl_Web_Ucenter {


    public function index($page=1)
    {
        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $pager['count'] = $count = 0;
        
        $filter = array('uid'=>$this->uid);
        $new_3month = __TIME - 86400*90;
        $filter['dateline'] = ">=:".$new_3month;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $order_ids = $shop_ids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($shop_ids){
                $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($order_ids){
                $products = K::M('order/product')->items(array('order_id'=>$order_ids)); 
            }
            $td = (float)date("m.d", __TIME);
            $now_date = date("Y-m-d",__TIME);
            $ytd = (float)date("m.d",  strtotime($now_date)-86399);
            foreach($items as $k=>$val){
                foreach($products as $kk=>$v){
                    if($v['order_id'] == $val['order_id']){
                        $items[$k]['product'][] = $v;
                    }
                }
                if((float)date("m.d", $val['dateline']) == $td){
                    $items[$k]['time_str'] = "今天";
                }elseif((float)date("m.d", $val['dateline']) == $ytd){
                    $items[$k]['time_str'] = "昨天";
                }
                if($val['online_pay'] ==1){
                    if($val['order_status'] ==0&&$val['pay_status'] == 0){
                        if(__TIME - $val['dateline'] <= 1800){
                            $items[$k]['last_second'] = 1800-(__TIME - $val['dateline']);
                        }
                    }
                }
                
            }
        }
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'web/ucenter/order/items.html';
    }
    
    

    
    public function detail($order_id){
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法的订单操作'),213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['products'] = K::M('order/product')->items(array('order_id'=>$order_id));
            $this->pagedata['logs'] = K::M('order/log')->items(array('order_id'=>$order_id),array('log_id'=>'desc'));
            $this->pagedata['last_log'] = K::M('order/log')->find(array('order_id'=>$order_id),array('log_id'=>'desc'));
            $this->tmpl = 'web/ucenter/order/detail.html';
        }
    }
    
    
    public function complaint($order_id){
        if(!$order_id = (int)$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),212);
        }elseif($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法的订单操作'),214);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'web/ucenter/order/complaint.html';
        }
    }
   

    public function set_complaint($order_id){
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),222);
        }else if($order['order_status'] < 1){
            $this->msgbox->add(L('该订单暂时不可投诉'),212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
        }else if(!$title = $this->GP('title')){
            $this->msgbox->add(L('请选择投诉类型'),214);
        }else if(!$content = $this->GP('content')){
            $this->msgbox->add(L('请填写投诉内容'),215);
        }else if($check = K::M('order/complaint')->find(array('uid'=>$this->uid,'order_id'=>$order_id))){
            $this->msgbox->add(L('该订单已经投诉过了'),216);
        }else{
            
            $data = array(
                'order_id'=>$order_id,
                'uid'=>$this->uid,
                'shop_id'=>$order['shop_id'],
                'staff_id'=>$order['staff_id'],
                'title'=>$title,
                'content'=>$content
            );
            $data2 = array(
                'shop_id'=>$order['shop_id'],
                'title'=>$title,
                'content'=>$content,
                'is_read'=>0,
                'type'=>3,
                'order_id'=>$order_id
            );
            if(!$add = K::M('order/complaint')->create($data)){
                $this->msgbox->add(L('投诉失败'),217);
            }else{
                K::M('shop/msg')->create($data2);
                if($staff = $order['staff_id']) {
                    $data3 = array(
                        'staff_id'  => $staff,
                        'title'     => sprintf(L('用户(%s)投诉了订单(ID:%s)'), $order['contact'], $order['order_id']),
                        'content'   => $content,
                        'is_read'   => 0,
                        );
                    K::M('staff/msg')->create($data3);
                }
                $this->msgbox->add(L('投诉成功'));
            }
        }
    }
    
    
    public function comment($order_id)
    {
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add(L('订单不存在'),211);
            $this->msgbox->response();
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add(L('订单不存在'),221);
            $this->msgbox->response();
        }else if($order['order_status'] != 8){
            $this->msgbox->add(L('订单不可评价'),212);
            $this->msgbox->response();
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),213);
            $this->msgbox->response();
        }else if($order['comment_status'] != 0){
            $this->msgbox->add(L('订单已经评价过了'),214);
            $this->msgbox->response();
        }else{
            $shop = K::M('shop/shop')->detail($order['shop_id']);
        }
        if($res = K::M('shop/collect')->find(array('uid'=>$this->uid,'shop_id'=>$order['shop_id']))){
            $shop['collect'] = 1;
        }else{
            $shop['collect'] = 0;
        }
        
        $peitime = K::M('shop/comment')->peitime();
        $jifen = K::M('system/config')->get('jifen');
        $this->pagedata['products'] = K::M('order/product')->items(array('order_id'=>$order_id));
        $this->pagedata['peitime'] = $peitime;
        $this->pagedata['jifen'] = intval($order['amount']*$jifen['jifen_ratio']);
        $this->pagedata['shop'] = $shop;
        $this->pagedata['order'] = $order;
        $this->tmpl = 'web/ucenter/order/comment.html';  
    }

    
    public function comment_handle()
    {
        if($this->checksubmit()){
            $data = array('post'=>$this->GP('data'), 'file'=>$_FILES);
            $datas = $data['post'];
            $datas['uid'] = $this->uid;

            if(!$this->uid){
                $this->msgbox->add(L('NOLOGIN'),101);
            }else if(!$datas['score_fuwu'] || $datas['score_fuwu'] < 1 || $datas['score_fuwu'] > 5){
                $this->msgbox->add(L('请给服务态度打分'),211);
            }else if(!$datas['pei_time']){
                $this->msgbox->add(L('请选择配送速度'),212);
            }else if(!$datas['score_kouwei'] || $datas['score_kouwei'] < 1 || $datas['score_kouwei'] > 5){
                $this->msgbox->add(L('请给菜品口味打分'),213);
            }else if(!$datas['score'] || $datas['score'] < 1 || $datas['score'] > 5){
                $this->msgbox->add(L('请给综合评分打分'),214);
            }else if(!$datas['content']){
                $this->msgbox->add(L('请填写评价内容'),215);
            }else if(!$datas['order_id']){
                $this->msgbox->add(L('订单不存在'),216);
            }else if(!$order = K::M('order/order')->detail($datas['order_id'])){
                $this->msgbox->add(L('订单不存在'),217);
            }else{
                    $datas['shop_id'] = $order['shop_id'];
                    if($data['file']){
                        $datas['have_photo'] = 1;
                    }
                    if($create = K::M('shop/comment')->create($datas)){
                        if($data['file']){
                            //插入评价
                            foreach($data['file'] as $k => $v){
                                if($a = K::M('magic/upload')->upload($v,'photo')){
                                    $photo_data = array(
                                        'comment_id' => $create,
                                        'photo' => $a['photo']
                                    );
                                    $create_photo = K::M('shop/photo') -> create($photo_data);
                                }
                            }
                        }
                        $shop = K::M('shop/shop') -> detail($order['shop_id']);
                        
                        $pei_time = intval(($datas['pei_time'] + $shop['pei_time']*$shop['comments'])/($shop['comments']+1));
                        
                        if($datas['score']>3){
                            $update_data = array('comments'=>'`comments`+1','praise_num'=>'`praise_num`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_time);
                        }else{
                           $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_time);
                        }
                        K::M('shop/shop')->update($order['shop_id'],$update_data,true);
                        K::M('order/order')->update($datas['order_id'],array('comment_status'=>1));
                        $jifen = $this->system->config->get('jifen');
                        $jifen_total = (int)(($order['product_price'] + $order['package_price'])*$jifen['jifen_ratio']);
                        K::M('member/member')->update_jifen($this->uid,$jifen_total, sprintf(L('订单%s评价完成，获得积分'), $data['order_id']));
                        K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>L('订单已评价'),'content'=>sprintf(L('用户(%s)已评价订单(ID:%s)'), $order['contact'], $order['order_id']),'is_read'=>0,'type'=>2,'order_id'=>$order['order_id']));
                        $this->msgbox->add(L('评论成功'));
                    }else{
                        $this->msgbox->add(L('评论失败'),217);
                    }  
            }
            
        }
        
    }
    
    
    // 申请退单
    public function cancel($order_id) 
    {
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add(L('订单已经取消，无需重复取消'),214);
        }else if($order['order_status'] != 0){
             $this->msgbox->add(L('当前订单是不可取消的状态'),215);
        }else{
            if(K::M('order/order')->cancel($order_id, $order, 'member')) {
                $data = array(
                    'shop_id'=>$order['shop_id'],
                    'title'=>L('订单已取消'),
                    'content'=>sprintf(L('用户(%s)已取消订单(ID:%s)'), $order['contact'], $order_id),
                    'is_read'=>0,
                    'type'=>1,
                    'order_id'=>$order_id
                    );
                K::M('shop/msg')->create($data);
                $this->msgbox->add(L('操作成功'));
            }else {
                $this->msgbox->add(L('订单取消失败'),216);
            }
        }
    } 
    
    
    // 确认送达
    public function complete() 
    {
        $inviteCfg = $this->system->config->get('invite');
        $order_id = $this->GP('order_id');
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else if($order['order_status']==8){
            $this->msgbox->add(L('订单已经确认,无需重复确认'),214);
        }else if(!in_array($order['order_status'], array(1,3,4))){
            $this->msgbox->add(L('商家还未配送完成不可确认'),215);
        }else if(K::M('order/order')->confirm($order_id, null, 'member')){
            $this->msgbox->add(L('恭喜操作成功')); 
        }else {
            $this->msgbox->add(L('操作失败'),222);
        }
    }

    
    
    // 再来一份
    public function onemore()
    {
        $ele = array();
        $order_id = $this->GP('order_id');
        if(!$order_id) {
            $this->msgbox->add(L('订单不存在'),211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add(L('订单不存在'),212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),213);
        }else {
            if($order_product = K::M('order/product')->items(array('order_id'=>$order_id))) {
                $ele = array();
                foreach($order_product as $k => $v){
                    $product = K::M('product/product')->find(array('product_id'=>$v['product_id']));
                    $order_product[$k]['cate_id'] = $product['cate_id'];
                    $product['num'] = $v['product_number'];
                    $product['price'] = $v['product_price'];
//                    if($product['sale_type']== 1){
//                        $product['sku'] = $product['sale_sku'] - $product['sale_count'];
//                        if($product['sku'] == 0) {
//                            unset($product['product_id']);
//                        }
//                    }else {
//                        $product['sku'] = 999;
//                    }
                    $product['sku'] = $product['stock'];
                    unset($product['photo'],$product['sales'],$product['shop_id'],$product['sale_sku'],$product['sale_type'],$product['sale_count']);
                    unset($product['intro'],$product['orderby'],$product['closed'],$product['clientip'],$product['dateline']);
                    $ele[$v['product_id']] = $product;
                }
                $cart = (array) json_decode($_COOKIE['ele']);
                foreach ($cart as $kk => $vv) {
                    foreach ($vv as $key => $v) {
                        $v = (array) $v;
                        $carts[$kk][$key] = $v;
                        if ($v['num'] == 0) {
                            unset($carts[$kk][$key]);
                        }
                    }
                }  
                $cart[$order['shop_id']] = $ele;
                setcookie("ele",json_encode($cart),time()+86400*30,'/');
            }
        }
    }  
    
}
