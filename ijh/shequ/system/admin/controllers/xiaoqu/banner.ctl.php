<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Banner extends Ctl
{
    
    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        
        if($items = K::M('xiaoqu/banner')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/banner/items.html';
    }

    public function xiaoqu($xiaoqu_id, $page=1)
    {
        if(!$xiaoqu_id = (int)$xiaoqu_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else{
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            $filter['xiaoqu_id'] = $xiaoqu_id;
            if($items = K::M('xiaoqu/banner')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/banner/items.html';
        }
    }

    public function detail($banner_id = null)
    {
        if(!$banner_id = (int)$banner_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:xiaoqu/banner/detail.html';
        }
    }

    public function create($xiaoqu_id=null)
    {
        if(!($xiaoqu_id = (int)$xiaoqu_id) && !($xiaoqu_id = (int)$this->GP('xiaoqu_id'))){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['xiaoqu_id'] = $xiaoqu_id;
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
            if($banner_id = K::M('xiaoqu/banner')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/banner-xiaoqu-'.$xiaoqu_id.'.html');
            } 
        }else{
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/banner/create.html';
        }
    }

    public function edit($banner_id=null)
    {
        if(!($banner_id = (int)$banner_id) && !($banner_id = $this->GP('banner_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
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
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(K::M('xiaoqu/banner')->update($banner_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            $this->tmpl = 'admin:xiaoqu/banner/edit.html';
        }
    }

    public function delete($banner_id=null)
    {
        if($banner_id = (int)$banner_id){
            if(!$detail = K::M('xiaoqu/banner')->detail($banner_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/banner')->delete($banner_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('banner_id')){
            if(K::M('xiaoqu/banner')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}