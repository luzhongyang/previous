<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Product extends Ctl_Biz
{
   
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('product/product')->items($filter, array('orderby'=>'asc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('product/cate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/product/index.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:product/product/so.html';
    }

    public function detail($product_id = null)
    {
        if(!$product_id = (int)$product_id){
            $this->msgbox->add(L('未指定要查看内容的ID'), 211);
        }else if(!$detail = K::M('product/product')->detail($product_id)){
            $this->msgbox->add(L('您要查看的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cates'] = K::M('product/cate')->items(array('shop_id'=>$detail['shop_id']));
            $this->tmpl = 'biz/product/detail.html';
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
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            if($product_id = K::M('product/product')->create($data)){
                $this->msgbox->add(L('SUCCESS'));
                $this->msgbox->set_data('forward',  $this->mklink('biz/product:index'));

            } 
        }else{
            $this->pagedata['tree'] = K::M('product/cate')->tree($this->shop_id); 
            $this->pagedata['shop_id'] = $this->shop_id;  
            $this->tmpl = 'biz/product/create.html';
        }
    }

    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add(L('未指定要修改的内容ID'), 211);
        }else if(!$detail = K::M('product/product')->detail($product_id)){
            $this->msgbox->add(L('您要修改的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
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
                    if($a = $upload->upload($attach, 'product')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }
        $data['price'] = abs($data['price']);
            if(K::M('product/product')->update($product_id, $data)){
                $this->msgbox->add(L('SUCCESS'));
            }  
        }else{
            $this->pagedata['tree'] = K::M('product/cate')->tree($this->shop_id); 
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/product/edit.html';
        }
    }

    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('product/product')->detail($product_id)){
                $this->msgbox->add(L('你要删除的内容不存在或已经删除'), 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }else{
                if(K::M('product/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add(L('SUCCESS'));
                }
            }
        }else{
            $this->msgbox->add(L('未指定要删除的内容ID'), 401);
        }
    }  
    
    
}