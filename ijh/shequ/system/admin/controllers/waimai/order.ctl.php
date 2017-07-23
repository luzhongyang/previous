<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Waimai_Order extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
            if($SO['order_status']){$filter['order_status'] = $SO['order_status'];}
            if($SO['pay_status']){$filter['pay_status'] = $SO['pay_status'];}
            if($SO['online_pay']){$filter['online_pay'] = $SO['online_pay'];}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['from'] = "waimai";
        if($items = K::M('order/order')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $order_ids = $uids = $shop_ids = array();
        foreach ($items as $k=>$val){
            $order_ids[$val['order_id']] = $val['order_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $uids[$val['uid']] = $val['uid'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
        }
        $this->pagedata['orders'] = K::M('waimai/order')->items_by_ids($order_ids);
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['shops'] = K::M('waimai/waimai')->items_by_ids($shop_ids);
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $payments = K::M('payment/payment')->fetch_all();
        $pays = array();
        foreach($payments as $k=>$val){
            $pays[$val['payment']] = $val;
        }
        $this->pagedata['pays'] = $pays;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:waimai/order/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:waimai/order/so.html';
    }
    public function detail($order_id = null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            //print_r($detail);die;
            $detail['products'] = K::M('waimai/orderproduct')->items(array('order_id'=>$order_id));
            $detail['user'] = K::M('member/member')->detail($detail['uid']);
            $detail['shop'] = K::M('waimai/waimai')->detail($detail['shop_id']);
            $detail['logs'] = K::M('order/log')->items(array('order_id'=>$order_id),array('log_id'=>'asc'));
            $payments = K::M('payment/payment')->fetch_all();
            $pays = array();
            foreach($payments as $k=>$val){
                $pays[$val['payment']] = $val['title'];
            }
            $detail['payments'] = $pays;
            $detail['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
            $detail['types'] = K::M('order/log')->get_log_types();
            $payments = K::M('order/order')->get_payments();
            $order_from = array('weixin'=>'微信','ios'=>'苹果APP','android'=>'安卓APP','wap'=>'wap端','www'=>'网页端');
            $this->pagedata['froms'] = $order_from[$detail['order_from']];
            $this->pagedata['pay_method'] = $payments[$detail['pay_code']];
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:waimai/order/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($order_id = K::M('waimai/order')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?waimai/order-index.html');
            } 
        }else{
           $this->tmpl = 'admin:waimai/order/create.html';
        }
    }
    public function edit($order_id=null)
    {
        if(!($order_id = (int)$order_id) && !($order_id = $this->GP('order_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('waimai/order')->update($order_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:waimai/order/edit.html';
        }
    }
    public function doaudit($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(K::M('waimai/order')->batch($order_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('waimai/order')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$detail = K::M('waimai/order')->detail(order_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('waimai/order')->delete($order_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('waimai/order')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
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

    // 订单完成
    public function complete($order_id=null) 
    { 
        if($order_id = (int)$order_id){
            if(!$order_id) {
                $this->msgbox->add('订单号不存在',210);
            }else if(!$order = K::M('order/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['order_status'] !=3 && $order['order_status'] !=4){
                $this->msgbox->add('该订单不可完成',213);
            }else if($order['online_pay']==1 && $order['pay_status'] ==0){
                $this->msgbox->add('该订单不可完成',214);
            }else if($order['pei_type']!=0 && $order['staff_id'] ==0){
                $this->msgbox->add('该订单不可完成',215);
            }else if(K::M('order/order')->confirm($order_id,$order,'admin')){
                $this->msgbox->add('订单确认成功');
            }else{
                $this->msgbox->add('订单确认失败',216);
            } 
        }
    }
    public function paidan($page)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['pay_status'] = 1;
        $filter['from'] = 'waimai';
        $filter[':SQL'] = "(`order_status` IN(1,2,3,4) OR (`order_status`=0 AND `pei_type`=2))";
        $filter['staff_id'] = 0;    // 0等待配送员接单
        $filter['pei_type'] = array(1,2);
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }        
        $shop_ids = $order_ids =array();
        foreach($items as $k=>$val){
            $order_ids[$val['order_id']] = $val['order_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        if($waimai_order_list = K::M('waimai/order')->items_by_ids($order_ids)){
            foreach($waimai_order_list as $k=>$v){
                $items[$k] = array_merge($items[$k], $v);
            }
        }
        $this->pagedata['waimai_list'] = K::M('waimai/waimai')->items_by_ids($shop_ids); 
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:waimai/order/paidan.html';
    }
    public function dopaidan($order_id=null)
    {
        if(!($order_id=(int)$order_id) && !($order_id = (int)$this->GP('order_id'))){
            $this->msgbox->set_data('未指定要派单的单号',211);
        }else if(!$order = K::M('waimai/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['staff_id']>0){
            $this->msgbox->add('该订单已经有人配送了，您可以选取消再派单',212);
        }else if(!$order['pay_status']){
            $this->msgbox->add('未支付订单不可派单', 213);
        }else if(!in_array($order['pei_type'], array(1, 2))){
            $this->msgbox->add('该订单为商家自送，不可派单', 214);
        }else if(!in_array($order['order_status'], array(0,1,2,3,4))){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else if($order['order_status']==0 && (int)$order['pei_type']!==2){
            $this->msgbox->add('该订单状态不可派单', 215);
        }else if($data = $this->checksubmit('data')){
            if(!$staff = K::M('staff/staff')->detail((int)$data['staff_id'])){
                $this->msgbox->add('指派的配送员不存在', 216);
            }else if(K::M('order/order')->update($order_id, array('staff_id'=>$staff['staff_id'], 'order_status'=>2))){
                //记录订单日志
                K::M('order/log')->create(array('order_id'=>$order_id, 'from'=>'staff', 'log'=>'配送员('.$this->staff['name'].')准备为您配送', 'type'=>'2'));
                //增加订单统计
                K::M('staff/staff')->update_count($staff['staff_id'], 'orders', 1);
                //推送消息给配送员
                $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                $addr = $waimai['addr'].$waimai['house'];
                $title = sprintf("系统指派了[%s]外送订单(单号:%s)给您", $waimai['title'], $order_id);
                $content = sprintf("系统指派订单(单号：%s)(%s，%s)给您,取餐地址:[%s]%s", $order_id, $order['contact'], $order['mobile'], $waimai['title'], $addr);
                K::M('staff/staff')->send($staff['staff_id'], $title, $content, 'paidan', $order_id);
                $this->msgbox->add('指派配送员成功');
            }
        }else{
            $this->pagedata['order'] = $order;
            $this->tmpl = 'admin:waimai/order/dopaidan.html';
        }
    }
}