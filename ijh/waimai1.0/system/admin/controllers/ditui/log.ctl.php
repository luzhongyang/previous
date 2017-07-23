<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_Log extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['log_id']){$filter['log_id'] = $SO['log_id'];}
            if($SO['ditui_id']){$filter['ditui_id'] = $SO['ditui_id'];}
        }
        if($items = K::M('ditui/log')->items($filter, null, $page, $limit, $count)){
            $ditui_ids = array();
            foreach($items as $k=>$v){
                $ditui_ids[$v['ditui_id']] = $v['ditui_id'];
            }
            $this->pagedata['ditui_list'] = K::M('ditui/ditui')->items_by_ids($ditui_ids);
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/log/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:ditui/log/so.html';
    }

    public function detail($log_id = null)
    {
        if(!$log_id = (int)$log_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/log')->detail($log_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/log/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($log_id = K::M('ditui/log')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?ditui/log-index.html');
            } 
        }else{
           $this->tmpl = 'admin:ditui/log/create.html';
        }
    }

    public function edit($log_id=null)
    {
        if(!($log_id = (int)$log_id) && !($log_id = $this->GP('log_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/log')->detail($log_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('ditui/log')->update($log_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/log/edit.html';
        }
    }

    public function doaudit($log_id=null)
    {
        if($log_id = (int)$log_id){
            if(K::M('ditui/log')->batch($log_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('log_id')){
            if(K::M('ditui/log')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($log_id=null)
    {
        if($log_id = (int)$log_id){
            if(!$detail = K::M('ditui/log')->detail($log_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/log')->delete($log_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('log_id')){
            if(K::M('ditui/log')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}