<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Verify extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['id_name']){
                $filter['id_name'] = $SO['id_name'];
            }
            if($SO['id_number']){
                $filter['id_number'] = $SO['id_number'];
            }
            
        }
        if($items = K::M('cashier/verify')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/verify/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/verify/so.html';
    }
    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('cashier/verify')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cashier/verify/detail.html';
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
                    if($a = $upload->upload($attach, 'cashier')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

            if($shop_id = K::M('cashier/verify')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/verify-index.html');
            } 
        }else{
           $this->tmpl = 'admin:cashier/verify/create.html';
        }
    }
    public function edit($shop_id=null)
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/verify')->detail($shop_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }if($detail['verify'] == 1){
            $this->msgbox->add('店铺已经通过认证,无需重复提交', 211);
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
                        if($a = $upload->upload($attach, 'cashier')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(!$data['updatetime']){
                $data['updatetime'] = time();
            }
            if(K::M('cashier/verify')->update($shop_id, $data)){
                if($data['verify'] == 1){
                    K::M('cashier/cashier')->update($shop_id,array('verify_name'=>1));
                }else if($data['verify'] == 2) {
                    K::M('cashier/cashier')->update($shop_id,array('verify_name'=>2));
                }
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/verify/edit.html';
        }
    }

    public function delete($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(!$detail = K::M('cashier/verify')->detail(shop_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/verify')->delete($shop_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('cashier/verify')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}