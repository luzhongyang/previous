<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Waimai_Waimai extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
            if($SO = $this->GP('SO')){
                $pager['SO'] = $SO;
                if($SO['title']){
                    $filter['title'] = "LIKE:%".$SO['title']."%";
                }
                if($SO['yy_status']){
                    $filter['yy_status'] = $SO['yy_status'];
                }
                if($SO['audit']){
                    $filter['audit'] = $SO['audit'];
                }
        }
        if($items = K::M('waimai/waimai')->items($filter, array('shop_id'=>'desc'), $page, $limit, $count)){
            $shop_ids = array();
            foreach($items as $k =>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
            }
            if($shop_ids){
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:waimai/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:waimai/so.html';
    }
    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:waimai/detail.html';
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
                        if($a = $upload->upload($attach, 'shop')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if($shop_id = K::M('waimai/waimai')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?waimai/waimai-index.html');
            } 
        }else{
            $this->pagedata['citys'] = K::M('data/city')->items();
            $this->pagedata['areas'] = K::M('data/area')->items(array('city_id'=>$detail['city_id']));
            $this->pagedata['busis'] = K::M('data/business')->items(array('area_id'=>$detail['area_id']));
           $this->tmpl = 'admin:waimai/create.html';
        }
    }
    public function edit($shop_id=null)
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if(K::M('waimai/waimai')->update($shop_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:waimai/edit.html';
        }
    }
    public function audit($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(K::M('waimai/waimai')->batch($shop_id, array('audit'=>1))){
                K::M('shop/shop')->batch($shop_id, array('have_waimai'=>1));
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('waimai/waimai')->batch($ids, array('audit'=>1))){
                K::M('shop/shop')->batch($ids, array('have_waimai'=>1));
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(!$detail = K::M('waimai/waimai')->detail($shop_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('waimai/waimai')->delete($shop_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('waimai/waimai')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}