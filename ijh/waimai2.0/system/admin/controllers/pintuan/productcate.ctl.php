<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Pintuan_Productcate extends Ctl
{

    public function index($page = 1)
    {
        $filter = $pager = array();
        $filter['closed'] = 0;
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['pintuan_cate_id']){
                $filter['pintuan_cate_id'] = $SO['pintuan_cate_id'];
            }
            if($SO['parent_id']){
                $filter['parent_id'] = $SO['parent_id'];
            }
            if($SO['shop_id']){
                $filter['shop_id'] = $SO['shop_id'];
            }
            if($SO['title']){
                $filter['title'] = "LIKE:%" . $SO['title'] . "%";
            }
        }
        if($items = K::M('pintuan/productcate')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            //获取上级分类
            $all_cate = K::M('pintuan/productcate')->options(1);
            foreach($items as $k => $v){
                $items[$k]['parent_id'] = $all_cate[$v['parent_id']] ? $all_cate[$v['parent_id']] : '一级分类';
            }
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:pintuan/productcate/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:pintuan/productcate/so.html';
    }

    public function detail($pintuan_cate_id = null)
    {
        if(!$pintuan_cate_id = (int) $pintuan_cate_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('pintuan/productcate')->detail($pintuan_cate_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $all_cate = K::M('pintuan/productcate')->options(1, $detail['pintuan_cate_id']);
            $detail['parent_id'] = $all_cate[$detail['parent_id']];
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:pintuan/productcate/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pintuan')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if($pintuan_cate_id = K::M('pintuan/productcate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?pintuan/productcate-index.html');
            }
        }else{
            //获取一级分类,select值
            $all_cate = K::M('pintuan/productcate')->options(1);
            $this->pagedata['cates'] = $all_cate;
            $this->tmpl = 'admin:pintuan/productcate/create.html';
        }
    }

    public function edit($pintuan_cate_id = null)
    {
        if(!($pintuan_cate_id = (int) $pintuan_cate_id) && !($pintuan_cate_id = $this->GP('pintuan_cate_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('pintuan/productcate')->detail($pintuan_cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pintuan')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if(K::M('pintuan/productcate')->update($pintuan_cate_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
            //获取一级分类,select值
            $all_cate = K::M('pintuan/productcate')->options(1, $detail['pintuan_cate_id']);
            $this->pagedata['cates'] = $all_cate;
            $this->pagedata['detail'] = $detail;            
            $this->tmpl = 'admin:pintuan/productcate/edit.html';
        }
    }

    public function doaudit($pintuan_cate_id = null)
    {
        if($pintuan_cate_id = (int) $pintuan_cate_id){
            if(K::M('pintuan/productcate')->batch($pintuan_cate_id, array('audit' => 1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('pintuan_cate_id')){
            if(K::M('pintuan/productcate')->batch($ids, array('audit' => 1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($pintuan_cate_id = null)
    {
        if($pintuan_cate_id = (int) $pintuan_cate_id){
            if(!$detail = K::M('pintuan/productcate')->detail($pintuan_cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('pintuan/productcate')->update($pintuan_cate_id, array('closed' => 1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('pintuan_cate_id')){
            if(K::M('pintuan/productcate')->update($ids, array('closed' => 1))){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

}
