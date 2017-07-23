<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cloud_Brand extends Ctl
{
    
    public function index($cate_id=null,$page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($cate_id = (int)$cate_id){
            $filter['cate_id'] = $cate_id;
        }else{
            unset($filter['cate_id']);
        }
        if($items = K::M('cloud/brand')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(array($cate_id), array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cate_id'] = $cate_id;
        $this->tmpl = 'admin:cloud/brand/items.html';
    }
    public function create($cate_id=null)
    {
        $cate_id = (int)$cate_id;
        if($data = $this->checksubmit('data')){
            $data['cate_id'] = $cate_id;
            if($brand_id = K::M('cloud/brand')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',$this->mklink('cloud/brand:index',array($cate_id)));
            } 
        }else{
           $this->pagedata['detail'] = K::M('cloud/cate')->detail($cate_id);
           $this->tmpl = 'admin:cloud/brand/create.html';
        }
    }
    
    public function edit($brand_id=null)
    {
        if(!($brand_id = (int)$brand_id) && !($brand_id = $this->GP('brand_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cloud/brand')->detail($brand_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('cloud/brand')->update($brand_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $detail['cates'] = K::M('cloud/cate')->detail($detail['cate_id']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cloud/brand/edit.html';
        }
    }

    public function delete($brand_id=null)
    {
        if($brand_id = (int)$brand_id){
            if(!$detail = K::M('cloud/brand')->detail($brand_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cloud/brand')->delete($brand_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('brand_id')){
            if(K::M('cloud/brand')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}