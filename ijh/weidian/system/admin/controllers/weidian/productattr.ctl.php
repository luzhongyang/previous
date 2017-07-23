<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Pintuan_Productattr extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['attr_name']){$filter['attr_name'] = "LIKE:%".$SO['attr_name']."%";}
if($SO['attr_value']){$filter['attr_value'] = "LIKE:%".$SO['attr_value']."%";}
        }
        if($items = K::M('pintuan/productattr')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:pintuan/productattr/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:pintuan/productattr/so.html';
    }
    public function detail($pintuan_attr_id = null)
    {
        if(!$pintuan_attr_id = (int)$pintuan_attr_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('pintuan/productattr')->detail($pintuan_attr_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:pintuan/productattr/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($pintuan_attr_id = K::M('pintuan/productattr')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?pintuan/productattr-index.html');
            } 
        }else{
           $this->tmpl = 'admin:pintuan/productattr/create.html';
        }
    }
    public function edit($pintuan_attr_id=null)
    {
        if(!($pintuan_attr_id = (int)$pintuan_attr_id) && !($pintuan_attr_id = $this->GP('pintuan_attr_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('pintuan/productattr')->detail($pintuan_attr_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('pintuan/productattr')->update($pintuan_attr_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:pintuan/productattr/edit.html';
        }
    }
    public function doaudit($pintuan_attr_id=null)
    {
        if($pintuan_attr_id = (int)$pintuan_attr_id){
            if(K::M('pintuan/productattr')->batch($pintuan_attr_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('pintuan_attr_id')){
            if(K::M('pintuan/productattr')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($pintuan_attr_id=null)
    {
        if($pintuan_attr_id = (int)$pintuan_attr_id){
            if(!$detail = K::M('pintuan/productattr')->detail(pintuan_attr_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('pintuan/productattr')->delete($pintuan_attr_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('pintuan_attr_id')){
            if(K::M('pintuan/productattr')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}