<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Shop extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            
        }
        if($items = K::M('ditui/shop')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/shop/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:ditui/shop/so.html';
    }
    public function detail($sid = null)
    {
        if(!$sid = (int)$sid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/shop')->detail($sid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/shop/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($sid = K::M('ditui/shop')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?ditui/shop-index.html');
            } 
        }else{
           $this->tmpl = 'admin:ditui/shop/create.html';
        }
    }
    public function edit($sid=null)
    {
        if(!($sid = (int)$sid) && !($sid = $this->GP('sid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/shop')->detail($sid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('ditui/shop')->update($sid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/shop/edit.html';
        }
    }
    public function doaudit($sid=null)
    {
        if($sid = (int)$sid){
            if(K::M('ditui/shop')->batch($sid, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('sid')){
            if(K::M('ditui/shop')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($sid=null)
    {
        if($sid = (int)$sid){
            if(!$detail = K::M('ditui/shop')->detail($sid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/shop')->delete($sid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('sid')){
            if(K::M('ditui/shop')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}