<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Order extends Ctl
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
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['from'] = "tuan";
        if($items = K::M('order/order')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $order_ids = $shop_ids = $uids = array();
        foreach($items as $k=>$val){
            $order_ids[$val['order_id']] = $val['order_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['tickets'] = K::M('tuan/ticket')->items(array('order_id'=>$order_ids));
        $this->pagedata['orders'] = K::M('tuan/order')->items_by_ids($order_ids);
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:tuan/order/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:tuan/order/so.html';
    }
    public function detail($order_id = null)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('tuan/order')->detail($order_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['tuan'] = K::m('tuan/tuan')->detail($detail['tuan_id']);
            $detail['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $detail['user'] = K::M('member/member')->detail($detail['user_id']);
            $detail['tickets'] = K::M('tuan/ticket')->items(array('order_id'=>$order_id));
            $this->pagedata['detail'] = $detail;
            $this->pagedata['froms'] = array('weixin'=>'微信','ios'=>'苹果APP','android'=>'安卓APP','wap'=>'wap端','www'=>'网页端');
            $payments = K::M('order/order')->get_payments();
            $order_from = array('weixin'=>'微信','ios'=>'苹果APP','android'=>'安卓APP','wap'=>'wap端','www'=>'网页端');
            $this->pagedata['froms'] = $order_from[$detail['order_from']];
            $this->pagedata['pay_method'] = $payments[$detail['pay_code']];
            $this->tmpl = 'admin:tuan/order/detail.html';
        }
    }
    public function recovery($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$detail = K::M('order/order')->find(array('order_id'=>$order_id))){
                $this->msgbox->add('你要恢复的内容不存在', 211);
            }else{
                if(K::M('order/order')->batch($order_id, array('closed'=>0))){
                    $this->msgbox->add('恢复内容成功');
                }
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('order/order')->batch($ids, array('closed'=>0))){
                $this->msgbox->add('批量恢复内容成功');
            }
        }else{
            $this->msgbox->add('未指定要恢复的内容ID', 401);
        }
    }
    
    public function delete($order_id=null)
    {
        if($order_id = (int)$order_id){
            if(!$detail = K::M('order/order')->detail($order_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('order/order')->batch($order_id, array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('order_id')){
            if(K::M('order/order')->batch($ids, array('closed'=>1))){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}