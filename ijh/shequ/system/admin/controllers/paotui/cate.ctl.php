<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Paotui_Cate extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            
        }
        if($items = K::M('paotui/cate')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:paotui/cate/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:paotui/cate/so.html';
    }
    public function detail($ID = null)
    {
        if(!$ID = (int)$ID){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('paotui/cate')->detail($ID)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:paotui/cate/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($ID = K::M('paotui/cate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?paotui/cate-index.html');
            } 
        }else{
           $this->tmpl = 'admin:paotui/cate/create.html';
        }
    }
    public function edit($ID=null)
    {
        if(!($ID = (int)$ID) && !($ID = $this->GP('ID'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('paotui/cate')->detail($ID)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('paotui/cate')->update($ID, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:paotui/cate/edit.html';
        }
    }
    public function doaudit($ID=null)
    {
        if($ID = (int)$ID){
            if(K::M('paotui/cate')->batch($ID, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('ID')){
            if(K::M('paotui/cate')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($ID=null)
    {
        if($ID = (int)$ID){
            if(!$detail = K::M('paotui/cate')->detail(ID)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('paotui/cate')->delete($ID)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('ID')){
            if(K::M('paotui/cate')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
    public function config($type)
    {
        $detail = K::M('paotui/cate')->find(array('type'=>$type));
        $detail['config'] = unserialize($detail['config']);
        $this->pagedata['type'] = $type;
        $this->pagedata['detail'] = $detail;
        if($type == 'buy') {
            $this->tmpl = 'admin:paotui/cate/config/buy.html';
        }else if($type == 'song') {
            $this->tmpl = 'admin:paotui/cate/config/song.html';
        }else if($type == 'paidui') {
            $this->tmpl = 'admin:paotui/cate/config/paidui.html';
        }else if($type == 'chongwu') {
            $this->tmpl = 'admin:paotui/cate/config/chongwu.html';
        }else if($type == 'seat'){
            $this->tmpl = 'admin:paotui/cate/config/seat.html';
        }else if($type == 'other'){
            $this->tmpl = 'admin:paotui/cate/config/other.html';
        }
    }
    public function savecfg() 
    {
        if($data = $this->checksubmit('config')) {
            if(K::M('paotui/cate')->savecfg($data['type'], $data)){
                $this->msgbox->add('修改内容成功');
            } 
        }
    }
}