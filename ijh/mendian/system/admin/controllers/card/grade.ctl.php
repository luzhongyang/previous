<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Card_Grade extends Ctl
{
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['grade_id']){$filter['grade_id'] = $SO['grade_id'];}
            if($SO['shop_id']){
                $filter['shop_id'] = $SO['shop_id'];
            }
        }
        if($items = K::M('card/grade')->items($filter, array('grade_id'=>'desc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        foreach ($items as $k => $v) {
            $shop_ids[$v['shop_id']] = $v['shop_id'];
        }
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:card/grade/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:card/grade/so.html';
    }
    public function detail($grade_id = null)
    {
        if(!$grade_id = (int)$grade_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('card/grade')->detail($grade_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:card/grade/detail.html';
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
            if($grade_id = K::M('card/grade')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?card/grade-index.html');
            } 
        }else{
           $this->tmpl = 'admin:card/grade/create.html';
        }
    }
    public function edit($grade_id=null)
    {
        if(!($grade_id = (int)$grade_id) && !($grade_id = $this->GP('grade_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('card/grade')->detail($grade_id)){
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
            if(K::M('card/grade')->update($grade_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:card/grade/edit.html';
        }
    }

    public function delete($grade_id=null)
    {
        if($grade_id = (int)$grade_id){
            if(!$detail = K::M('card/grade')->detail(grade_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('card/grade')->delete($grade_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('grade_id')){
            if(K::M('card/grade')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}