<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Order_Complaint extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        
        if($items = K::M('order/complaint')->items($filter, array('complaint_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $shop_ids = $staff_ids = $uids = array();
        foreach($items as $k=>$val){
            $shop_ids[$val['shop_id']] = $val['shop_id'];
            $staff_ids[$val['staff_id']] = $val['staff_id'];
            $uids[$val['uid']] = $val['uid'];
        }
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['staffs'] = K::M('staff/staff')->items_by_ids($staff_ids);
        $this->pagedata['users'] = K::M('member/member')->items_by_ids($uids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:order/complaint/items.html';
    }



    public function detail($complaint_id = null)
    {
        if(!$complaint_id = (int)$complaint_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('order/complaint')->detail($complaint_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['order'] = K::M('order/order')->detail($detail['order_id']);
            $this->pagedata['member'] = K::M('member/member')->detail($detail['uid']);
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->pagedata['staff'] = K::M('staff/staff')->detail($detail['staff_id']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:order/complaint/detail.html';
        }
    }


    public function reply($complaint_id=null)
    {
        if(!($complaint_id = (int)$complaint_id) && !($complaint_id = (int)$this->GP('complaint_id'))){
            $this->msgbox->add('未指定投诉的ID', 211);
        }else if(!$detail = K::M('order/complaint')->detail($complaint_id)){
            $this->msgbox->add('投诉不存在或已经删除', 212);
        }else if(!empty($detail['reply'])){
            $this->msgbox->add('该投诉已回复过了', 213);
        }else if($reply = $this->checksubmit('reply')){
            if(K::M('order/complaint')->update($complaint_id, array('reply'=>$reply, 'reply_time'=>__TIME))){
                $this->msgbox->add('回复投诉成功');
            }else{
                $this->msgbox->add('回复投诉失败',214);
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:order/complaint/reply.html';
        }
    }  



    public function delete($complaint_id=null)
    {
        if($complaint_id = (int)$complaint_id){
            if(!$detail = K::M('order/complaint')->detail($complaint_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('order/complaint')->delete($complaint_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('complaint_id')){
            if(K::M('order/complaint')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}