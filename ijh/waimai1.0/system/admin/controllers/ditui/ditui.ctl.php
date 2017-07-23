<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_Ditui extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['mobile']){$filter['mobile'] = $SO['mobile'];}
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
        }
        if($items = K::M('ditui/ditui')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/ditui/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:ditui/ditui/so.html';
    }

    public function detail($ditui_id = null)
    {
        if(!$ditui_id = (int)$ditui_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/ditui')->detail($ditui_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/ditui/detail.html';
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
                        if($a = $upload->upload($attach, 'ditui')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if($ditui_id = K::M('ditui/ditui')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?ditui/ditui-index.html');
            } 
        }else{
           $this->tmpl = 'admin:ditui/ditui/create.html';
        }
    }

    public function edit($ditui_id=null)
    {
        if(!($ditui_id = (int)$ditui_id) && !($ditui_id = $this->GP('ditui_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/ditui')->detail($ditui_id)){
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
                        if($a = $upload->upload($attach, 'ditui')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(K::M('ditui/ditui')->update($ditui_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/ditui/edit.html';
        }
    }

    public function doaudit($ditui_id=null)
    {
        if($ditui_id = (int)$ditui_id){
            if(K::M('ditui/ditui')->batch($ditui_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('ditui_id')){
            if(K::M('ditui/ditui')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($ditui_id=null)
    {
        if($ditui_id = (int)$ditui_id){
            if(!$detail = K::M('ditui/ditui')->detail($ditui_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/ditui')->delete($ditui_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('ditui_id')){
            if(K::M('ditui/ditui')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  


    public function manager($ditui_id)
    {
        K::M('ditui/auth')->manager($ditui_id);
        header("Location:".'../ditui/index.php');
    }
}