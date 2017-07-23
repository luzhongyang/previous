<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Ditui_Member extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['ditui_id']){$filter['ditui_id'] = $SO['ditui_id'];}
        }
        if($items = K::M('ditui/member')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/member/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:ditui/member/so.html';
    }
    public function detail($mid = null)
    {
        if(!$mid = (int)$mid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/member')->detail($mid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/member/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($mid = K::M('ditui/member')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?ditui/member-index.html');
            } 
        }else{
           $this->tmpl = 'admin:ditui/member/create.html';
        }
    }
    public function edit($mid=null)
    {
        if(!($mid = (int)$mid) && !($mid = $this->GP('mid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/member')->detail($mid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('ditui/member')->update($mid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/member/edit.html';
        }
    }
    public function doaudit($mid=null)
    {
        if($mid = (int)$mid){
            if(K::M('ditui/member')->batch($mid, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('mid')){
            if(K::M('ditui/member')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($mid=null)
    {
        if($mid = (int)$mid){
            if(!$detail = K::M('ditui/member')->detail($mid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/member')->delete($mid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('mid')){
            if(K::M('ditui/member')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}