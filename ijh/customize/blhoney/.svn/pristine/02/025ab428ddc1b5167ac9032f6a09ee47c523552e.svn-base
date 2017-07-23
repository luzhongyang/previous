<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Mall_Cate extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
        $pager['SO'] = $SO;
        if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
        if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
        if($SO['orderby']){$filter['orderby'] = $SO['orderby'];}
        }
        if($items = K::M('mall/cate')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:mall/cate/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:mall/cate/so.html';
    }

    public function detail($cate_id = null)
    {
        if(!$cate_id = (int)$cate_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('mall/cate')->detail($cate_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:mall/cate/detail.html';
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
                        if($a = $upload->upload($attach, 'mall')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if($cate_id = K::M('mall/cate')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?mall/cate-index.html');
            } 
        }else{
           $this->tmpl = 'admin:mall/cate/create.html';
        }
    }

    public function edit($cate_id=null)
    {
        if(!($cate_id = (int)$cate_id) && !($cate_id = $this->GP('cate_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('mall/cate')->detail($cate_id)){
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
                    if($a = $upload->upload($attach, 'mall')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

        if(K::M('mall/cate')->update($cate_id, $data)){
            $this->msgbox->add('修改内容成功');
        }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:mall/cate/edit.html';
        }
    }

    public function doaudit($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(K::M('mall/cate')->batch($cate_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('cate_id')){
            if(K::M('mall/cate')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('mall/cate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('mall/cate')->delete($cate_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('cate_id')){
            if(K::M('mall/cate')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}