<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: cate.ctl.php 2034 2013-12-07 03:08:33Z $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Article_Cate extends Ctl
{
   
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($items = K::M('article/cate')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));;
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['tree'] = K::M('article/cate')->tree();
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:article/cate/items.html';
    }
    public function create($parent_id=null)
    {
        if($this->checksubmit('data')){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 201);
            }else if($cate_id = K::M('article/cate')->create($data)){
                $this->msgbox->add('添加分类成功');
                $this->msgbox->set_data('forward', '?article/cate-index.html');
            }
        }else{
            $pager['parent_id'] = intval($parent_id);
            $this->pagedata['pager'] = $pager;
            $this->pagedata['tree'] = K::M('article/cate')->tree();
            $this->tmpl = 'admin:article/cate/create.html';
        }
    }
    public function edit($cate_id=null)
    {
        if(!($cate_id = (int)$cate_id) && !($cate_id = (int)$this->GP('cate_id'))){
            $this->msgbox->add('未指要修改ID', 211);
        }else if(!$cate = K::M('article/cate')->detail($cate_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($this->checksubmit('data')){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 201);
            }else if(K::M('article/cate')->update($cate_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
        	$this->pagedata['cate'] = $cate;
            $this->pagedata['cate_list'] = K::M('article/cate')->fetch_all();
        	$this->tmpl = 'admin:article/cate/edit.html';
        }
    }
    public function update()
    {
        if($orders = $this->GP('orderby')){
            $obj = K::M('article/cate');
            foreach($orders as $k=>$v){
                $obj->update($k, array('orderby'=>$v));
            }
            $this->msgbox->add('更新数据成功');
        }
    }
    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(K::M('article/cate')->delete($cate_id)){
                $this->msgbox->add('删除成功');
            }
        }else if($pks = $this->GP('$cate_id')){
            if(K::M('article/cate')->delete($pks)){
                $this->msgbox->add('批量删除成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }        
    }
}