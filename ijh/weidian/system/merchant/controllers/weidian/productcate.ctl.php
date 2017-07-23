<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Productcate extends Ctl_Weidian
{

    public function index($page)
    {
        $this->check_weidian();
        $tree = K::M('weidian/productcate')->tree($this->shop_id);
        $this->pagedata['tree'] = $tree;  
        $this->tmpl = 'merchant:weidian/productcate/index.html';
    }

    public function example()
    {
        $this->check_weidian();
        $this->tmpl = 'merchant:weidian/productcate/example.html';
    }
    
    public function create()
    {
        $this->check_weidian();
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
            if($cate_id = K::M('weidian/productcate')->create($data)){
                $this->msgbox->add(L('添加内容成功'));
                $this->msgbox->set_data('forward', '?weidian/productcate-index.html');
            } 
        }else{
            $this->pagedata['cate_tree'] = K::M('weidian/productcate')->tree($this->shop_id);
            $this->tmpl = 'merchant:weidian/productcate/create.html';
        }
    }

    public function edit($cate_id=null)
    {
        $this->check_weidian();
        if(!($cate_id = (int)$cate_id) && !($cate_id = $this->GP('cate_id'))){
            $this->msgbox->add(L('未指定要修改的内容ID'), 211);
        }else if(!$detail = K::M('weidian/productcate')->detail($cate_id)){
            $this->msgbox->add(L('您要修改的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'.$detail['shop_id']), 213);
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
            if(K::M('weidian/productcate')->update($cate_id, $data)){
                $this->msgbox->add(L('修改内容成功'));
                $this->msgbox->set_data('forward', '?weidian/productcate-index.html');
            }  
        }else{
            $cate = K::M('weidian/productcate')->detail($cate_id);
            $cate_list = K::M('weidian/productcate')->items(array('parent_id'=>0,'shop_id'=>$cate['shop_id']));
            
            //查找是否有子分类
            $is_have_sub = K::M('weidian/productcate')->find(array('parent_id' => $detail['cate_id']));
            //是否允许编辑上级分类
            $is_edit_parent = 0;
            if(!is_array($is_have_sub)){
                $is_edit_parent = 1;
            }
            
            $this->pagedata['is_edit_parent'] = $is_edit_parent;  
            $this->pagedata['cate_list'] = $cate_list;  
            $this->pagedata['curr_cate'] = $cate;       
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:weidian/productcate/edit.html';
        }
    }

    

    public function delete($cate_id=null)
    {
        $this->check_weidian();
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('weidian/productcate')->detail($cate_id)){
                $this->msgbox->add(L('你要删除的内容不存在或已经删除'), 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }else if(K::M('weidian/productcate')->count(array('parent_id'=>$cate_id))){
                $this->msgbox->add(L('该分类下有子分类不能删除'), 214);
            }else if(K::M('weidian/product')->items(array('cate_id'=>$cate_id, 'closed'=>0))){
                $this->msgbox->add(L('该分类下有商品不能删除'), 215);
            }else{
                if(K::M('weidian/productcate')->delete($cate_id)){
                    $this->msgbox->add(L('删除内容成功'));
                }
            }
        }else{
            $this->msgbox->add(L('未指定要删除的内容ID'), 401);
        }
    } 

}
