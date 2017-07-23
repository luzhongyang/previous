<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_Shop extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
            if($SO['ditui_id']){$filter['ditui_id'] = $SO['ditui_id'];}
        }
        if($items = K::M('ditui/shop')->items($filter, null, $page, $limit, $count)){
            $ditui_ids = $shop_ids = array();
            foreach($items as $k=>$v){
                $ditui_ids[$v['ditui_id']] = $v['ditui_id'];
                $shop_ids[$v['shop_id']] = $v['shop_id'];
            }
            $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            $this->pagedata['ditui_list'] = K::M('ditui/ditui')->items_by_ids($ditui_ids);

        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/shop/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:ditui/shop/so.html';
    }

    public function detail($sid = null)
    {
        if(!$sid = (int)$sid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/shop')->detail($sid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/shop/detail.html';
        }
    }

    public function ditui($ditui_id, $page=1)
    {
        if(!$ditui_id = (int)$ditui_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$ditui = K::M('ditui/ditui')->detail($ditui_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 211);
        }else{
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            $filter = array('ditui_id'=>$ditui_id);
            if($SO = $this->GP('SO')){
                if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1]);$filter['dateline'] = $a."~".$b;}}
                $pager['SO'] = $SO;
            }
            if($items = K::M('ditui/shop')->items($filter, null, $page, $limit, $count)){
                $shop_ids = array();
                foreach($items as $k=>$v){
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                }
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            }
            $this->pagedata['ditui'] = $ditui;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'admin:ditui/shop/ditui.html';            
        }
    }

    public function edit($sid=null)
    {
        if(!($sid = (int)$sid) && !($sid = $this->GP('sid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/shop')->detail($sid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('ditui/shop')->update($sid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/shop/edit.html';
        }
    }


    public function delete($sid=null)
    {
        if($sid = (int)$sid){
            if(!$detail = K::M('ditui/shop')->detail($sid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/shop')->delete($sid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('sid')){
            if(K::M('ditui/shop')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}