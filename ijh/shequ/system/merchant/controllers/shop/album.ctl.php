<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Shop_Album extends Ctl
{
    public function index($page)
    {
        $filter = $pager = $orderby = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 20;
        $filter['shop_id'] = $this->shop_id;
        $filter['cate_id'] = array(1,2);
        $orderby = array('photo_id'=>'desc');
        if($items = K::M('shop/albumphoto')->items($filter,$orderby,$page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }      
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/album/index.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'type,photo')) {
                $this->msgbox->add('非法的数据提交',214);
            }else {
                if(!$data['type']) {
                    $this->msgbox->add('请选择相册类型',211);
                }else if(!$data['photo']) {
                    $this->msgbox->add('请上传图片',212);
                }else {
                    $data['shop_id'] = $this->shop_id;
                    $data['dateline'] = __TIME;
                    if($product_id = K::M('shop/albumphoto')->create($data)){
                        $this->msgbox->add('添加内容成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/album:index'));
                    } 
                }
            }
        }else{
           $this->pagedata['shop_id'] = $this->shop_id;  
           $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
           $this->tmpl = 'merchant:shop/album/create.html';
        }   
    }

    public function edit($photo_id=null)
    {
        if(!$photo_id = (int)$photo_id){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('shop/albumphoto')->detail($photo_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'type,photo')) {
                $this->msgbox->add('非法的数据提交',214);
            }else {
                if(!$data['type']) {
                    $this->msgbox->add('请选择相册类型',211);
                }else if(!$data['photo']) {
                    $this->msgbox->add('请上传图片',212);
                }else {
                   if(K::M('shop/albumphoto')->update($photo_id, $data)){
                        $this->msgbox->add('修改内容成功');
                    }  
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:shop/album/edit.html';
        }
    }

    public function delete($photo_id=null)
    {
        if($photo_id = (int)$photo_id){
            if(!$detail = K::M('shop/albumphoto')->detail($photo_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('shop/albumphoto')->delete($photo_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}  