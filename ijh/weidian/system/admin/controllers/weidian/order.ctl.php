<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weidian_Order extends Ctl
{
    public $status = array(0);
    public function product($type,$page)
    {   
        $filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 20;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
        }
        if($type == 1){
            $filter['type'] = "pintuan";
        }else{
            $filter['type'] = 'default';
        }
        if($items = K::M('weidian/order')->items($filter, null, $page, $limit, $count)){
            $order_ids = array();
            foreach($items as $k => $v){
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            $orders = K::M('order/order')->items_by_ids($order_ids);
            $order_products = K::M('weidian/orderproduct')->items(array('order_id'=>$order_ids));
            
            $porders = K::M('weidian/pintuan/order')->items_by_ids($order_ids);
            
            foreach($items as $k => $v){
                foreach($order_products as $k1=>$v1){
                    if($v['order_id'] == $v1['order_id']){
                        $items[$k]['products'][] = $v1;
                    }
                }
                $items[$k]['order'] = $orders[$v['order_id']];
            }
            foreach($porders as $k => $v){
                $items[$k]['porder'] = $porders[$v['order_id']];
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        //print_r($items);die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['type'] = $type;
        if($type == 1){
            $this->tmpl = 'admin:weidian/order/pintuan_items.html';
        }else{
            $this->tmpl = 'admin:weidian/order/items.html';
        }
    }
    
    public function pintuan(){
        $this->product(1);
    }
    public function so()
    {
        $this->tmpl = 'admin:weidian/order/so.html';
    }
    
    public function delete($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$detail = K::M('weidian/order')->detail(order_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('weidian/order')->delete($order_id)){
                    K::M('order/order')->update($order_id,array('closed'=>1));
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('weidian/order')->delete($ids)){
                K::M('order/order')->update($order_id,array('closed'=>1));
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
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['order_status'] ==-1 && $order['order_status']==8){
                $this->msgbox->add('该订单不可取消',213);
            }else if(K::M('weidian/order')->cancel($order_id,$order,'admin')){
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
            }else if(!$order = K::M('weidian/order')->detail($order_id)) {
                $this->msgbox->add('该订单不存在',211);
            }else if($order['order_status'] !=3 && $order['order_status'] !=4){
                $this->msgbox->add('该订单不可完成',213);
            }else if($order['online_pay']==1 && $order['pay_status'] ==0){
                $this->msgbox->add('该订单不可完成',214);
            }else if(K::M('order/order')->confirm($order_id,$order,'admin')){
                $this->msgbox->add('订单确认成功');
            }else{
                $this->msgbox->add('订单确认失败',216);
            } 
        }
    }

    
}
