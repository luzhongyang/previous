<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Ticket extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['ticket_id']){$filter['ticket_id'] = $SO['ticket_id'];}
if($SO['uid']){$filter['uid'] = $SO['uid'];}
if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['tuan_id']){$filter['tuan_id'] = $SO['tuan_id'];}
if($SO['order_id']){$filter['order_id'] = $SO['order_id'];}
if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
if(is_array($SO['use_time'])){if($SO['use_time'][0] && $SO['use_time'][1]){$a = strtotime($SO['use_time'][0]); $b = strtotime($SO['use_time'][1])+86400;$filter['use_time'] = $a."~".$b;}}
if($SO['status']){$filter['status'] = $SO['status'];}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('tuan/ticket')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:tuan/ticket/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:tuan/ticket/so.html';
    }
    public function detail($ticket_id = null)
    {
        if(!$ticket_id = (int)$ticket_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('tuan/ticket')->detail($ticket_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:tuan/ticket/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            $data['number'] = K::M('tuan/ticket')->create_number();// 团购券密码不能自定义
            if($ticket_id = K::M('tuan/ticket')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?tuan/ticket-index.html');
            } 
        }else{
           $this->tmpl = 'admin:tuan/ticket/create.html';
        }
    }
    public function edit($ticket_id=null)
    {
        if(!($ticket_id = (int)$ticket_id) && !($ticket_id = $this->GP('ticket_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('tuan/ticket')->detail($ticket_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('tuan/ticket')->update($ticket_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:tuan/ticket/edit.html';
        }
    }
    public function doaudit($ticket_id=null)
    {
        if($ticket_id = (int)$ticket_id){
            if(K::M('tuan/ticket')->batch($ticket_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('ticket_id')){
            if(K::M('tuan/ticket')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($ticket_id=null)
    {
        if($ticket_id = (int)$ticket_id){
            if(!$detail = K::M('tuan/ticket')->detail(ticket_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('tuan/ticket')->delete($ticket_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('ticket_id')){
            if(K::M('tuan/ticket')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}