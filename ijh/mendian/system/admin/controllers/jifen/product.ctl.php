<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Jifen_Product extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['product_id']){$filter['product_id'] = $SO['product_id'];}
if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
        }
        if($items = K::M('jifen/product')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:jifen/product/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:jifen/product/so.html';
    }
    public function detail($product_id = null)
    {
        if(!$product_id = (int)$product_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:jifen/product/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
                    if($_FILES['data']){
            foreach($_FILES['data'] as $k=>$v){
                foreach($v as $kk=>$vv){
                    $attachs[$kk][$k] = $vv;
                }
            }
            $upload = K::M('magic/upload');
            foreach($attachs as $k=>$attach){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = $upload->upload($attach, 'jifen')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

            if($product_id = K::M('jifen/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?jifen/product-index.html');
            } 
        }else{
           $this->tmpl = 'admin:jifen/product/create.html';
        }
    }
    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('jifen/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
                    if($_FILES['data']){
            foreach($_FILES['data'] as $k=>$v){
                foreach($v as $kk=>$vv){
                    $attachs[$kk][$k] = $vv;
                }
            }
            $upload = K::M('magic/upload');
            foreach($attachs as $k=>$attach){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = $upload->upload($attach, 'jifen')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

            if(K::M('jifen/product')->update($product_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:jifen/product/edit.html';
        }
    }
    public function doaudit($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(K::M('jifen/product')->batch($product_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('product_id')){
            if(K::M('jifen/product')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('jifen/product')->detail(product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('jifen/product')->delete($product_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('product_id')){
            if(K::M('jifen/product')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}