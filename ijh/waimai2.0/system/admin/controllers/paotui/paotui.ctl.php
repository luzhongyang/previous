<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Paotui_Paotui extends Ctl
{

    public function index($page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['addr']){
                $filter['addr'] = "LIKE:%" . $SO['addr'] . "%";
            }
            if($SO['house']){
                $filter['house'] = "LIKE:%" . $SO['house'] . "%";
            }
            if($SO['o_addr']){
                $filter['o_addr'] = "LIKE:%" . $SO['o_addr'] . "%";
            }
            if($SO['o_house']){
                $filter['o_house'] = "LIKE:%" . $SO['o_house'] . "%";
            }
            if($SO['staff_id']){
                $filter['staff_id'] = $SO['staff_id'];
            }
            if($SO['order_status']){
                $filter['order_status'] = $SO['order_status'];
            }
            if($SO['pay_status']){
                $filter['pay_status'] = $SO['pay_status'];
            }
            if(is_array($SO['dateline'])){
                if($SO['dateline'][0] && $SO['dateline'][1]){
                    $a = strtotime($SO['dateline'][0]);
                    $b = strtotime($SO['dateline'][1]) + 86400;
                    $filter['dateline'] = $a . "~" . $b;
                }
            }
        }
        $filter['from'] = 'paotui';
        if($items = K::M('order/order')->items($filter, array('order_id' => 'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            foreach($items as $k => $v){
                $uids[$v['uid']] = $v['uid'];
                $paotui_ids[$v['order_id']] = $v['order_id'];
                if($v['staff_id']){
                    $staff_ids[$v['staff_id']] = $v['staff_id'];
                }
            }
            if($staffs = K::M('staff/staff')->items_by_ids($staff_ids)){
                foreach($items as $k => $v){
                    if($v['staff_id']){
                        $items[$k]['staff'] = $staffs[$v['staff_id']];
                    }
                }
            }
            if($paotuis = K::M('paotui/order')->items_by_ids($paotui_ids)){
                foreach($items as $k => $v){
                    $items[$k]['paotui'] = $paotuis[$v['order_id']];
                }
            }
            if($member = K::M('member/member')->items_by_ids($uids)){
                $mems = $member;
            }
            
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['mems'] = $mems;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:paotui/paotui/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:paotui/paotui/so.html';
    }

    public function detail($paotui_id = null)
    {
        if(!$paotui_id = (int) $paotui_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }
        else if(!$detail = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }
        else{
            $detail['user'] = K::M('member/member')->detail($detail['uid']);
            $detail['logs'] = K::M('paotui/log')->items(array('paotui_id' => $detail['paotui_id']), array('log_id' => 'desc'));


            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:paotui/paotui/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){

            if($paotui_id = K::M('paotui/paotui')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?paotui/paotui-index.html');
            }
        }
        else{
            $this->tmpl = 'admin:paotui/paotui/create.html';
        }
    }

    public function edit($paotui_id = null)
    {
        if(!($paotui_id = (int) $paotui_id) && !($paotui_id = $this->GP('paotui_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('paotui/paotui')->detail($paotui_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($data = $this->checksubmit('data')){

            if(K::M('paotui/paotui')->update($paotui_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:paotui/paotui/edit.html';
        }
    }

    public function doaudit($paotui_id = null)
    {
        if($paotui_id = (int) $paotui_id){
            if(K::M('paotui/paotui')->batch($paotui_id, array('audit' => 1))){
                $this->msgbox->add('审核内容成功');
            }
        }
        else if($ids = $this->GP('paotui_id')){
            if(K::M('paotui/paotui')->batch($ids, array('audit' => 1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($paotui_id = null)
    {
        if($paotui_id = (int) $paotui_id){
            if(!$detail = K::M('paotui/paotui')->detail(paotui_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('paotui/paotui')->delete($paotui_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('paotui_id')){
            if(K::M('paotui/paotui')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

    // 导出跑腿订单列表到excel
    public function expert()
    {
        
    }

    // 管理员取消订单
    public function cancel($order_id)
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

    public function paidan($page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['pay_status'] = 1;
        $filter['staff_id'] = 0;
        $filter['order_status'] = array(0, 1, 2);
        if($items = K::M('paotui/order')->items($filter, array('paotui_id' => 'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:paotui/paotui/paidan.html';
    }

    public function dopaidan($order_id = null)
    {
        if(!($order_id = (int) $order_id) && !($order_id = (int) $this->GP('order_id'))){
            $this->msgbox->set_data('未指定要派单的单号', 211);
        }
        else if(!$paotui = K::M('paotui/paotui')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }
        else if($paotui['staff_id'] > 0){
            $this->msgbox->add('该订单已经有人配送了，您可以选取消再派单', 212);
        }
        else if(!$paotui['pay_status']){
            $this->msgbox->add('未支付订单不可派单', 213);
        }
        else if(!in_array($paotui['order_status'], array(0, 1, 2, 3))){
            $this->msgbox->add('该订单状态不可派单', 215);
        }
        else if($data = $this->checksubmit('data')){
            if(!$staff = K::M('staff/staff')->detail((int) $data['staff_id'])){
                $this->msgbox->add('指派的配送员不存在', 216);
            }
            else if(K::M('order/order')->update($order_id, array('staff_id' => $staff['staff_id'], 'order_status' => 2))){
                //记录订单日志
                K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'staff', 'log' => '配送员(' . $this->staff['name'] . ')准备为您配送', 'type' => '2'));
                //增加订单统计
                K::M('staff/staff')->update_count($staff['staff_id'], 'orders', 1);
                $this->msgbox->add('指派配送员成功');
            }
        }
        else{
            $this->pagedata['paotui'] = $paotui;
            $this->tmpl = 'admin:paotui/paotui/dopaidan.html';
        }
    }

    public function paotui_cart()
    {
        if($_POST){
            if($cart = $_POST[cart]){
                $carts = K::M('paotui/paotui_othercate')->items();
                foreach($carts as $k => $v){
                    K::M('paotui/paotui_othercate')->delete($k);
                }
                foreach($cart as $k => $v){
                    if($v['k']){
                        $data['title'] = $v['k'];
                        $data['type'] = $v['t'];
                        $data['price'] = $v['v'];
                        K::M('paotui/paotui_othercate')->create($data);
                    }
                }
            }
        }
    }

}
