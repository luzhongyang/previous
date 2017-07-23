<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Youhui extends Ctl
{
    
    public function index($shop_id=null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定隶属商家', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id, true)){
            $this->msgbox->add('指定的商家不存在或删除', 212);
        }else{
            $filter = array('shop_id'=>$shop_id);
            if($items = K::M('shop/youhui')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['shop'] = $shop;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'admin:shop/youhui/items.html';
        }
    }





    public function create($shop_id=null)
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
             $this->msgbox->add('未指定隶属商家', 211);
        }else{
            if($data = $this->checksubmit('data')){
                 $data['shop_id'] = $shop_id;
                if($youhui_id = K::M('shop/youhui')->create($data)){
                    K::M('shop/shop')->change_youhui($shop_id);
                    $this->msgbox->add('添加内容成功');
                   $this->msgbox->set_data('forward',  $this->mklink('shop/youhui:index',array($shop_id)));
                } 
            }else{
               $this->pagedata['shop_id'] = $shop_id;
               $this->tmpl = 'admin:shop/youhui/create.html';
            }
        }
    }

    public function edit($youhui_id=null)
    {
        if(!($youhui_id = (int)$youhui_id) && !($youhui_id = $this->GP('youhui_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('shop/youhui')->detail($youhui_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('shop/youhui')->update($youhui_id, $data)){
                K::M('shop/shop')->change_youhui($detail['shop_id']);
                $this->msgbox->add('修改内容成功');
            }  
        }else{
                $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:shop/youhui/edit.html';
        }
    }



    public function delete($youhui_id=null)
    {
        if($youhui_id = (int)$youhui_id){
            if(!$detail = K::M('shop/youhui')->detail($youhui_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('shop/youhui')->delete($youhui_id)){
                    K::M('shop/shop')->change_youhui($detail['shop_id']);
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('youhui_id')){
            foreach($ids as $id){
                $detail = K::M('shop/youhui')->detail($id);
            }
            if(K::M('shop/youhui')->delete($ids)){
                K::M('shop/shop')->change_youhui($detail['shop_id']);
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}