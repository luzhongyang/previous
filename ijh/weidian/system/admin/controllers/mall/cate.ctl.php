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
        $this->pagedata['items'] = K::M('mall/cate')->tree();
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:mall/cate/items.html';
    }

    public function create($parent_id=0)
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
                K::M('mall/cate')->flush();
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?mall/cate-index.html');
            }
        }else{
            $this->pagedata['parent_id'] = $parent_id;
            $this->pagedata['cate_list'] = K::M('mall/cate')->fetch_all();
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
                K::M('mall/cate')->flush();
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
            $this->pagedata['cate_list'] = K::M('mall/cate')->fetch_all();
        	$this->tmpl = 'admin:mall/cate/edit.html';
        }
    }

    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('mall/cate')->detail($cate_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if(K::M('mall/cate')->count(array('parent_id'=>$cate_id))){
                $this->msgbox->add('有子分类不能直接删除', 211);
            }else{
                if(K::M('mall/cate')->delete($cate_id)){
                    $this->msgbox->add('删除内容成功');
                    K::M('mall/cate')->flush();
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}