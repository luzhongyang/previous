<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Tuan_Tuan extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
            if($SO['type']){$filter['type'] = $SO['type'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['stime'])){if($SO['stime'][0] && $SO['stime'][1]){$a = strtotime($SO['stime'][0]); $b = strtotime($SO['stime'][1])+86400;$filter['stime'] = $a."~".$b;}}
            if(is_array($SO['ltime'])){if($SO['ltime'][0] && $SO['ltime'][1]){$a = strtotime($SO['ltime'][0]); $b = strtotime($SO['ltime'][1])+86400;$filter['ltime'] = $a."~".$b;}}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('tuan/tuan')->items($filter, null, $page, $limit, $count)){
            foreach($items as $k => $v){
                if($shop = K::M('shop/shop')->detail($v['shop_id'])){
                    $items[$k]['shop'] = $shop;
                }
            }
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:tuan/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:tuan/so.html';
    }
    public function detail($tuan_id = null)
    {
        if(!$tuan_id = (int)$tuan_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:tuan/detail.html';
        }
    }
    public function create($shop_id=null)
    { 
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定隶属商家', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商户不存在或已经删除', 211);
        }else{
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
                $data['shop_id'] = $shop_id;
                if($tuan_id = K::M('tuan/tuan')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('tuan/tuan:shop',array($shop_id)));
                   
                } 
            }else{
				$this->pagedata['city_id'] = $shop['city_id'];
                $this->pagedata['shop_id'] = $shop_id;
                $this->tmpl = 'admin:tuan/create.html';
            }
        }
    }
    
    
    public function edit($tuan_id=null)
    {
        if(!($tuan_id = (int)$tuan_id) && !($tuan_id = $this->GP('tuan_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
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
            if(K::M('tuan/tuan')->update($tuan_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
                $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
                $this->pagedata['detail'] = $detail;
                $this->tmpl = 'admin:tuan/edit.html';
        }
    }
    
    public function shop($shop_id=null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定隶属商家', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id, true)){
            $this->msgbox->add('指定的商家不存在或删除', 212);
        }else{
            $filter = array('shop_id'=>$shop_id, 'closed'=>0);
            if($items = K::M('tuan/tuan')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['shop'] = $shop;
            //$cates = K::M('tuan/cate')->items(array('shop_id'=>$shop_id));
            //$this->pagedata['cates'] = $cates;
            $this->tmpl = 'admin:tuan/shop.html';
        } 
    }
    
    
    
    public function delete($tuan_id=null)
    {
        if($tuan_id = (int)$tuan_id){
            if(!$detail = K::M('tuan/tuan')->detail($tuan_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('tuan/tuan')->delete($tuan_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('tuan_id')){
            if(K::M('tuan/tuan')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
    
    public function audit($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if($shop = K::M('shop/shop')->detail($shop_id)) {
                if($shop['audit'] == 1) {
                    if(K::M('shop/shop')->batch($shop_id, array('have_tuan'=>1))) {
                        $this->msgbox->add('审核内容成功');
                    }
                }
            }
        }else if($ids = $this->GP('shop_id')){
            if($items = k::M('shop/shop')->items(array('shop_id'=>$ids))) {
                K::M('shop/shop')->batch($ids, array('have_tuan'=>1));
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
}