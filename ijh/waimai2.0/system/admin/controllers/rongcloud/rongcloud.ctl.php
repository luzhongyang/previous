<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Rongcloud_Rongcloud extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['uuid']){$filter['uuid'] = "LIKE:%".$SO['uuid']."%";}
if($SO['token']){$filter['token'] = "LIKE:%".$SO['token']."%";}
        }
        if($items = K::M('rongcloud/rongcloud')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:rongcloud/rongcloud/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:rongcloud/rongcloud/so.html';
    }



    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($uuid = K::M('rongcloud/rongcloud')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?rongcloud/rongcloud-index.html');
            } 
        }else{
           $this->tmpl = 'admin:rongcloud/rongcloud/create.html';
        }
    }

    public function edit($uuid=null)
    {
        if(!($uuid = (int)$uuid) && !($uuid = $this->GP('uuid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('rongcloud/rongcloud')->detail($uuid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('rongcloud/rongcloud')->update($uuid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:rongcloud/rongcloud/edit.html';
        }
    }





}