<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Cate extends Ctl_Biz
{
    

    public function index($page=1)
    {
    	/*
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('product/cate')->items($filter, array('parent_id'=>'ASC','orderby'=>'ASC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        */
        $this->pagedata['tree'] = K::M('product/cate')->tree($this->shop_id);      
        //$this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/cate/index.html';
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
            if($cate_id = K::M('product/cate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?biz/cate-index.html');
            } 
        }else{
            $this->pagedata['cate_tree'] = K::M('product/cate')->tree($this->shop_id);      
            $this->tmpl = 'biz/cate/create.html';
        }
    }

    public function edit($cate_id=null)
    {
        if(!($cate_id = (int)$cate_id) && !($cate_id = $this->GP('cate_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('product/cate')->detail($cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
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

            if(K::M('product/cate')->update($cate_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
            $this->pagedata['cate_tree'] = K::M('product/cate')->tree($this->shop_id);      
        	$this->tmpl = 'biz/cate/edit.html';
        }
    }

    

    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('product/cate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('product/cate')->delete($cate_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    } 
    
    
}