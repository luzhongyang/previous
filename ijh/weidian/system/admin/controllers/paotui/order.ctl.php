<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Paotui_Order extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
        }
        $filter['from'] = 'paotui';
        $filter['closed'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $staff_ids = $uids = $order_ids = array();
        foreach($items as $k=>$val){
            $staff_ids[$val['staff_id']] = $val['staff_id'];
            $order_ids[$val['order_id']] = $val['order_id'];
            $uids[$val['uid']] = $val['uid'];
        }
        $orders = K::M('paotui/order')->items_by_ids($order_ids);
        $cates = K::M('paotui/cate')->items();
        foreach($orders as $k=>$val){
            foreach($cates as $kk=>$v){
                if($val['type'] == $v['type']){
                    $orders[$k]['cate'] = $v; 
                }
            }
        }
        //print_r($orders);die;
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->pagedata['orders'] = $orders;
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids); 
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:paotui/order/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:paotui/order/so.html';
    }
    public function detail($order_id = null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
            $detail['user'] = K::M('member/member')->detail($detail['uid']);
            $detail['type'] = K::M('paotui/cate')->find(array('type'=>$detail['type']));
            $detail['photos'] = K::M('order/photo')->items(array('order_id'=>$order_id));
            $payments = K::M('payment/payment')->fetch_all();
            $pays = array();
            foreach($payments as $k=>$val){
                $pays[$val['payment']] = $val['title'];
            }
            $detail['payments'] = $pays;
            $this->pagedata['detail'] = $detail;
            $payments = K::M('order/order')->get_payments();
            $order_from = array('weixin'=>'微信','ios'=>'苹果APP','android'=>'安卓APP','wap'=>'wap端','www'=>'网页端');
            $this->pagedata['froms'] = $order_from[$detail['order_from']];
            $this->pagedata['pay_method'] = $payments[$detail['pay_code']];
            $this->tmpl = 'admin:paotui/order/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($order_id = K::M('paotui/order')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?paotui/order-index.html');
            } 
        }else{
           $this->tmpl = 'admin:paotui/order/create.html';
        }
    }
    public function edit($order_id=null)
    {
        if(!($order_id = (int)$order_id) && !($order_id = $this->GP('order_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('paotui/order')->update($order_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:paotui/order/edit.html';
        }
    }
    public function doaudit($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(K::M('paotui/order')->batch($order_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('paotui/order')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$detail = K::M('paotui/order')->detail(order_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('paotui/order')->delete($order_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('paotui/order')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

    public function paidan($page)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['pay_status'] = 1;
        $filter['from'] = 'paotui';
        $filter['order_status'] = array(0, 1, 2);
        $filter['staff_id'] = 0;    // 0等待配送员接单
        if($items = K::M('order/order')->items($filter, array('order_id'=>'DESC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }        
        $shop_ids = $order_ids =array();
        foreach($items as $k=>$val){
            $order_ids[$val['order_id']] = $val['order_id'];
        }
        if($paotui_order_list = K::M('paotui/order')->items_by_ids($order_ids)){
            foreach($paotui_order_list as $k=>$v){
                $items[$k] = array_merge($items[$k], $v);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:paotui/order/paidan.html';
    }
    public function dopaidan($order_id=null)
    {
        if(!($order_id=(int)$order_id) && !($order_id = (int)$this->GP('order_id'))){
            $this->msgbox->set_data('未指定要派单的单号',211);
        }else if(!$order = K::M('paotui/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['staff_id']>0){
            $this->msgbox->add('该订单已经有人接单了，您可以选取消再派单',212);
        }else if(!$order['pay_status']){
            $this->msgbox->add('未支付订单不可派单', 213);
        }else if($order['from'] != 'paotui'){
            $this->msgbox->add('订单类型不正确', 214);
        }else if(!in_array($order['order_status'], array(0,1,2))){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else if($data = $this->checksubmit('data')){
            if(!$staff = K::M('staff/staff')->detail((int)$data['staff_id'])){
                $this->msgbox->add('指派的配送员不存在', 216);
            }else if(K::M('order/order')->update($order_id, array('staff_id'=>$staff['staff_id'], 'order_status'=>1))){
                //记录订单日志
                K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'staff', 'log'=>'配送员('.$this->staff['name'].')准备为您配送', 'type'=>'2'));
                //增加订单统计
                K::M('staff/staff')->update_count($staff['staff_id'], 'orders', 1);
                //发送通知
                $title = "系统指派了跑腿订单(单号:%s)给您";
                $content = sprintf("系统指派订单(单号：%s)(%s，%s)给您,地址:%s", $order_id, $order['contact'], $order['mobile']);
                K::M('staff/staff')->send($staff['staff_id'], $title, $content, 'paidan', $order_id);
                $this->msgbox->add('指派配送员成功');
            }
        }else{
            $this->pagedata['order'] = $order;
            $this->tmpl = 'admin:paotui/order/dopaidan.html';
        }
    }
}