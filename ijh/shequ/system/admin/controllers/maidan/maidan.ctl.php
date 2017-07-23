<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Maidan_Maidan extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
        }
        if($items = K::M('maidan/maidan')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $shop_ids = array();
        foreach($items as $k=>$val){
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:maidan/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:maidan/so.html';
    }
    public function shop($shop_id=null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定隶属商家', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id, true)){
            $this->msgbox->add('指定的商家不存在或删除', 212);
        }else{
            $filter = array('shop_id'=>$shop_id);
            if($items = K::M('maidan/maidan')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'admin:maidan/shop.html';
        } 
    }
    
    public function create($shop_id=null) 
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
             $this->msgbox->add('未指定隶属商家', 211);
        }else{
            if($data = $this->checksubmit('data')){
                $data['shop_id'] = $shop_id;
                if($maidan_id = K::M('maidan/maidan')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward',$this->mklink('maidan/maidan:shop',array($shop_id)));
                } 
            }else{
               $this->pagedata['shop_id'] = $shop_id;
               $this->tmpl = 'admin:maidan/create.html';
            }
        }
    }
    public function edit($maidan_id=null)
    {
        if(!($maidan_id = (int)$maidan_id) && !($maidan_id = $this->GP('maidan_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('maidan/maidan')->detail($maidan_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('maidan/maidan')->update($maidan_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:maidan/edit.html';
        }
    }
   
    public function delete($maidan_id=null)
    {
        if($maidan_id = (int)$maidan_id){
            if(!$detail = K::M('maidan/maidan')->detail($maidan_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('maidan/maidan')->delete($maidan_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('maidan_id')){
            if(K::M('maidan/maidan')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}