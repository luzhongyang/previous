<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Staff extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['title']){
                $filter['name'] = "LIKE:%".$SO['title']."%";
            }
            if($SO['mobile']){
                $filter['mobile'] = $SO['mobile'];
            }
            if($SO['staff_id']){
                unset($filter['mobile']);
                unset($filter['name']);
                $filter['staff_id'] = $SO['staff_id'];
            }
        }
        if($items = K::M('cashier/staff')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        foreach ($items as $k => $v) {
            $shop_ids[$v['shop_id']] = $v['shop_id'];
        }
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/staff/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/staff/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){            
            if($staff_id = K::M('cashier/staff')->create($data)){

                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/staff-index.html');
            }
        }else{
            /*$this->pagedata['shops'] = K::M('shop/shop')->items(array('closed'=>0,'audit'=>1));*/
            $this->pagedata['shops'] = K::M('shop/shop')->items(array('closed'=>0));
            $this->tmpl = 'admin:cashier/staff/create.html';
        }
    }
    public function edit($staff_id=null)
    {
        if(!($staff_id = (int)$staff_id) && !($staff_id = $this->GP('staff_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('cashier/staff')->update($staff_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/staff/edit.html';
        }
    }
    public function doaudit($staff_id=null)
    {
        if($staff_id = (int)$staff_id){
            if(K::M('cashier/staff')->batch($staff_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('staff_id')){
            if(K::M('cashier/staff')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($staff_id=null)
    {
        if($staff_id = (int)$staff_id){
            if(!$detail = K::M('cashier/staff')->detail($staff_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/staff')->delete($staff_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('staff_id')){
            if(K::M('cashier/staff')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}