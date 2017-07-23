<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Mall_Order extends Ctl
{

    public function index($page = 1)
    {
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
        $filter['from'] = 'mall';
        $filter['closed'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $uids = $order_ids = array();
            foreach($items as $k=>$val){
                $order_ids[$val['order_id']] = $val['order_id'];
                $uids[$val['uid']] = $val['uid'];
            }
            if($mall_order_list = K::M('mall/order')->items_by_ids($order_ids)){
                foreach($mall_order_list as $k=>$v){
                    $items[$k] = array_merge($items[$k], $v);
                }
            }
            $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            $this->pagedata['items'] = $items;
        }
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:mall/order/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:mall/order/so.html';
    }

    public function detail($order_id = null)
    {
        if (!$order_id = (int) $order_id) {
            $this->msgbox->add('未指定要查看内容的ID', 211);
        } else if (!$detail = K::M('mall/order')->detail($order_id)) {
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        } else {
            $this->pagedata['detail'] = $detail;
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['product_list'] = K::M('mall/order/product')->items(array('order_id'=>$order_id), null, 1, 100);
            $this->tmpl = 'admin:mall/order/detail.html';
        }
    }
    
    public function fahuo($order_id = null){
        if ($order_id = (int) $order_id) {
            if (!$detail = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            } else if($detail['order_status'] != 0 && $detail['pay_status'] != 1){
                $this->msgbox->add('该订单不可发货', 211);
            }else {
                if (K::M('order/order')->update($order_id,array('order_status'=>3))) {
                    $this->msgbox->add('发货成功');
                }
            }
        }
    }

    public function create()
    {
        if ($data = $this->checksubmit('data')) {

            if ($order_id = K::M('mall/order')->create($data)) {
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?mall/order-index.html');
            }
        } else {
            $this->tmpl = 'admin:mall/order/create.html';
        }
    }

    public function edit($order_id = null)
    {
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

    public function delete($order_id = null)
    {
        if ($order_id = (int) $order_id) {
            if (!$detail = K::M('mall/order')->detail($order_id)) {
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            } else {
                if (K::M('mall/order')->delete($order_id)) {
                    $this->msgbox->add('删除内容成功');
                }
            }
        } else if ($ids = $this->GP('order_id')) {
            if (K::M('mall/order')->delete($ids)) {
                $this->msgbox->add('批量删除内容成功');
            }
        } else {
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

    public function delivery($order_id = null)
    {
        if (!$order_id = (int) $order_id) {
            $this->msgbox->add('未指定要发货的订单', 401);
        }else if (!$order = K::M('mall/order')->detail($order_id)) {
            $this->msgbox->add('等待发货的订单不存在', 211);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不能发货', 212);
        }else if(empty($order['pay_status'])){
            $this->msgbox->add('订单未支付不能发货', 213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已完成无需发货', 214);
        }else if(!in_array($order['order_status'], array(0, 1, 2))){
            $this->msgbox->add('订单状态不可发货', 214);
        }else if (K::M('order/order')->update($order_id, array('order_status' => 3))) {
            K::M('member/member')->send($order['uid'], '您的商城订单已经发货', "您的商城订单(".$order_id.")已经开始发货");
            $this->msgbox->add('订单发货成功');
        }
    }

    public function cancel($order_id = null)
    {
        if (!$order_id = (int) $order_id) {
            $this->msgbox->add('未指定要取消的订单', 401);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['order_status'] < 0) {
            $this->msgbox->add('订单已经取消过了', 212);
        }else if(K::M('order/order')->cancel($order_id, $order, 'admin')){
            K::M('member/member')->send($order['uid'], '您的订单被管理员取消', "您的商城订单(".$order_id.")被管理员取消");
            
            //返回积分
            $mall_orders = k::M('mall/order')->items(array('order_id' => $order_id));
            foreach($mall_orders as $k => $v){
                $jifen += $v['product_jifen'] * $v['product_number'];
            }
            K::M('member/member')->update_jifen($order['order_id'], $jifen, '商城订单(ID:' . $order['order_id'] . ')取消返还积分', 'member');
            
        }
    }
}