<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Nav extends Ctl
{
    
    public function index($xiaoqu_id, $page=1)
    {

        if(!$xiaoqu_id = (int)$xiaoqu_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else{
            $filter = $pager = array('xiaoqu_id'=>$xiaoqu_id);
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            if($items = K::M('xiaoqu/nav')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/nav/items.html';
        }

    }





    public function create($xiaoqu_id=null)
    {
        
        if(!($xiaoqu_id = (int)$xiaoqu_id) && !($xiaoqu_id = (int)$this->GP('xiaoqu_id'))){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
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
                        if($a = $upload->upload($attach, 'xiaoqu')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if($nav_id = K::M('xiaoqu/nav')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?xiaoqu/nav-index-'.$xiaoqu_id.'.html');
            } 
        }else{
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/nav/create.html';
        }
    }

    public function edit($nav_id=null)
    {
        if(!($nav_id = (int)$nav_id) && !($nav_id = $this->GP('nav_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/nav')->detail($nav_id)){
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
                    if($a = $upload->upload($attach, 'xiaoqu')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

            if(K::M('xiaoqu/nav')->update($nav_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:xiaoqu/nav/edit.html';
        }
    }

    public function doaudit($nav_id=null)
    {
        if($nav_id = (int)$nav_id){
            if(K::M('xiaoqu/nav/nav')->batch($nav_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('nav_id')){
            if(K::M('xiaoqu/nav/nav')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($nav_id=null)
    {
        if($nav_id = (int)$nav_id){
            if(!$detail = K::M('xiaoqu/nav')->detail($nav_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/nav')->delete($nav_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('nav_id')){
            if(K::M('xiaoqu/nav/nav')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}