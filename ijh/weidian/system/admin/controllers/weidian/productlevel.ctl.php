<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Pintuan_Productlevel extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['pintuan_level_id']){$filter['pintuan_level_id'] = $SO['pintuan_level_id'];}
if($SO['pintuan_product_id']){$filter['pintuan_product_id'] = $SO['pintuan_product_id'];}
        }
        if($items = K::M('pintuan/productlevel')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:pintuan/product_level/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:pintuan/product_level/so.html';
    }
    public function detail($pintuan_level_id = null)
    {
        if(!$pintuan_level_id = (int)$pintuan_level_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('pintuan/productlevel')->detail($pintuan_level_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:pintuan/product_level/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($pintuan_level_id = K::M('pintuan/productlevel')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?pintuan/productlevel-index.html');
            } 
        }else{
           $this->tmpl = 'admin:pintuan/product_level/create.html';
        }
    }
    public function edit($pintuan_level_id=null)
    {
        if(!($pintuan_level_id = (int)$pintuan_level_id) && !($pintuan_level_id = $this->GP('pintuan_level_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('pintuan/productlevel')->detail($pintuan_level_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('pintuan/productlevel')->update($pintuan_level_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:pintuan/product_level/edit.html';
        }
    }
    public function doaudit($pintuan_level_id=null)
    {
        if($pintuan_level_id = (int)$pintuan_level_id){
            if(K::M('pintuan/productlevel')->batch($pintuan_level_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('pintuan_level_id')){
            if(K::M('pintuan/productlevel')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($pintuan_level_id=null)
    {
        if($pintuan_level_id = (int)$pintuan_level_id){
            if(!$detail = K::M('pintuan/productlevel')->detail(pintuan_level_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('pintuan/productlevel')->delete($pintuan_level_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('pintuan_level_id')){
            if(K::M('pintuan/productlevel')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}