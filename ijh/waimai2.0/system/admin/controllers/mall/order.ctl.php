<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Mall_Order extends Ctl {

    public function index($page = 1) {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if ($SO = $this->GP('SO')) {
            $pager['SO'] = $SO;
            if ($SO['order_id']) {
                $filter['order_id'] = $SO['order_id'];
            }
            if ($SO['uid']) {
                $filter['uid'] = $SO['uid'];
            }
            if ($SO['product_name']) {
                $filter['product_name'] = "LIKE:%" . $SO['product_name'] . "%";
            }
            if ($SO['product_jifen']) {
                $filter['product_jifen'] = $SO['product_jifen'];
            }
            if ($SO['contact']) {
                $filter['contact'] = "LIKE:%" . $SO['contact'] . "%";
            }
            if ($SO['mobile'] && is_array($SO['mobile'])) {
                $filter['mobile'] = $SO['mobile'];
            } else if (K::M("verify/check")->ids($SO['mobile'])) {
                $filter['mobile'] = "IN:" . $SO['mobile'];
            }
            if ($SO['addr']) {
                $filter['addr'] = "LIKE:%" . $SO['addr'] . "%";
            }
            if (is_array($SO['dateline'])) {
                if ($SO['dateline'][0] && $SO['dateline'][1]) {
                    $a = strtotime($SO['dateline'][0]);
                    $b = strtotime($SO['dateline'][1]) + 86400;
                    $filter['dateline'] = $a . "~" . $b;
                }
            }
        }

        $uids = $orderids = array();
        if($orders = K::M('order/order')->items(array('from'=>'mall','closed'=>0,'pay_status'=>1))) {
            foreach($orders as $k=>$v) {
                $orderids[$v['order_id']] = $v['order_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $filter['order_id'] = $orderids;
            if ($items = K::M('mall/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)) {
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            }
            if(!empty($uids)){
                $this->pagedata['members'] = K::M('member/member')->items_by_ids($uids);
            }   
        }
        
        $this->pagedata['orders'] = $orders;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:mall/order/items.html';
    }

    public function so() {
        $this->tmpl = 'admin:mall/order/so.html';
    }

    public function detail($order_id = null) {
        if (!$order_id = (int) $order_id) {
            $this->msgbox->add('未指定要查看内容的ID', 211);
        } else if (!$detail = K::M('mall/order')->find(array('order_id'=>$order_id))) {
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        } else {
            $p_name = '';
            $products = K::M('mall/order')->items(array('order_id'=>$order_id));
            if($products) {
                $this->pagedata['items'] = $products;
            }
            $order = K::M('order/order')->detail($order_id);
            $member = K::M('member/member')->detail($order['uid']);
            $this->pagedata['logs']= K::M('order/log')->items(array('order_id'=>$order_id),array('log_id'=>'asc'));
            $this->pagedata['types'] = K::M('order/log')->get_log_types();
            $this->pagedata['order'] = $order;
            $this->pagedata['member'] = $member;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['p_name'] = $p_name;
            $this->tmpl = 'admin:mall/order/detail.html';
        }
    }

    public function create() {
        if ($data = $this->checksubmit('data')) {

            if ($order_id = K::M('mall/order')->create($data)) {
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?mall/order-index.html');
            }
        } else {
            $this->tmpl = 'admin:mall/order/create.html';
        }
    }

    public function edit($order_id = null) {
        if (!($order_id = (int) $order_id) && !($order_id = $this->GP('order_id'))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        } else if (!$detail = K::M('mall/order')->detail($order_id)) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        } else if ($data = $this->checksubmit('data')) {

            if (K::M('mall/order')->update($order_id, $data)) {
                $this->msgbox->add('修改内容成功');
            }
        } else {
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:mall/order/edit.html';
        }
    }


    public function delete($order_id = null) {
        if ($order_id = (int) $order_id) {
            if (!$detail = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            } else {
                if($order['order_status'] == 0) {
                    $this->msgbox->add('订单未发货不可删除',212)->response();
                }else if($order['order_status'] == 3) {
                    $this->msgbox->add('订单已发货不可删除',213)->response();
                }else if(in_array($order['order_status'], array(-1,8))) {
                    if (K::M('order/order')->delete($order_id)) {
                        $this->msgbox->add('删除订单成功');
                    }
                }else {
                    $this->msgbox->add('订单不可删除',214)->response();
                }
            }
        } else if ($ids = $this->GP('order_id')) {
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if($order['order_status'] == 0) {
                            $this->msgbox->add('订单未发货不可删除',212)->response();
                        }else if($order['order_status'] == 3) {
                            $this->msgbox->add('订单已发货不可删除',213)->response();
                        }else if(in_array($order['order_status'], array(-1,8))) {
                            if (K::M('order/order')->delete($order_id)) {
                                $this->msgbox->add('删除订单成功');
                                $success_count ++;
                            }
                        }else {
                            $this->msgbox->add('订单不可删除',214)->response();
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量删除订单'.$success_count.'个');
            }else{
                $this->msgbox->add('未指定要删除的订单');
            }  
        } else {
            $this->msgbox->add('未指定要删除的订单', 401);
        }
    }
    
    // 商城订单发货
    public function deliver($order_id = null) {
        if ($order_id = (int) $order_id) {
            if (!$detail = K::M('mall/order')->find(array('order_id'=>$order_id))) {
                $this->msgbox->add('等待发货的订单不存在', 211);
            } else {
                $order = K::M('order/order')->detail($order_id);
                if($order['order_status'] == -1) {
                    $this->msgbox->add('该订单已取消',212)->response();
                }else if($order['order_status'] == 8){
                    $this->msgbox->add('该订单已完成',213)->response();
                }else if($order['order_status'] == 3){
                    $this->msgbox->add('该订单已发货',214)->response();
                }else if($order['order_status'] == 0){
                    if (K::M('order/order')->update($order_id, array('order_status'=>3,'lasttime'=>__TIME))) {
                        $this->msgbox->add('发货成功');
                    }
                }
            }
        } else if ($ids = $this->GP('order_id')) {
            $success_count = 0;
            if($ids = K::M('verify/check')->ids($ids)){
                if($items = K::M('order/order')->items_by_ids($ids)){
                    $order_list = array();
                    foreach($items as $order_id=>$order){
                        if(empty($order['order_status'])){
                            if($order['pay_status']==1){
                                if(K::M('order/order')->update($order_id, array('order_status'=>3,'lasttime'=>__TIME))){
                                    $log = array('order_id'=>$order_id,'from'=>'shop','log'=>'平台已发货','type'=>4);
                                    K::M('order/log')->create($log);
                                    //通知用户,APP推送 weixin模板消息
                                    K::M('order/order')->send_member('平台已发货', sprintf("订单(%s)平台已发货", $order_id), $order,'deliver');
                                    $success_count ++;
                                }
                            }
                        }
                    }
                }
            }
            if($success_count){
                $this->msgbox->set_data('count', $success_count);
                $this->msgbox->add('批量发货'.$success_count.'个');
            }else{
                $this->msgbox->add('未指定要发货的订单');
            }  
        } else {
            $this->msgbox->add('未指定要发货的订单', 401);
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
            }else if($order['order_status'] ==-1 && $order['order_status']==8){
                $this->msgbox->add('该订单不可取消',213);
            }else if(K::M('order/order')->cancel($order_id,$order,'admin')){
                $this->msgbox->add('取消订单成功');
            }else{
                $this->msgbox->add('取消订单失败',215);
            }
        }
    } 

    //填写物流信息页面
    public function info($order_id=null)
    {
        if (!($order_id = (int) $order_id) && !($order_id = $this->GP('order_id'))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        } else if (!$detail = K::M('mall/order')->find(array('order_id'=>$order_id))) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 213);
        }else {
            if($mall_order = K::M('mall/order')->find(array('order_id'=>$order_id))) {
                $this->pagedata['order'] = $order;
                $this->pagedata['post_id'] = $mall_order['post_id'];
                $this->pagedata['post_name'] = $mall_order['post_name'];
            }
            $this->tmpl = 'admin:mall/order/info.html';
        }
    }
    
    //提交物流信息
    public function sub_info($order_id=null)
    {

        if (!($order_id = (int) $order_id) && !($order_id = $this->GP('order_id'))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        } else if (!$detail = K::M('mall/order')->find(array('order_id'=>$order_id))) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        } else if (!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 213);
        }else if ($data = $this->checksubmit('data')) {
            $items = K::M('mall/order')->items(array('order_id'=>$order_id));
            foreach ($items as $key => $value) {
                $pids[] = $value['pid'];
            }
            if (K::M('mall/order')->update($pids, $data)) {
                $this->msgbox->add('修改内容成功');
            }
        }
    }
}
