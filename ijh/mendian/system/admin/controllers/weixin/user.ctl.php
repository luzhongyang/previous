<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weixin_User extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        
        if($items = K::M('weixin/user')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weixin/user/items.html';
    }

    public function detail($wx_uid = null)
    {
        if(!$wx_uid = (int)$wx_uid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('weixin/user')->detail($wx_uid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weixin/user/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($wx_uid = K::M('weixin/user')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?weixin/user-index.html');
            } 
        }else{
           $this->tmpl = 'admin:weixin/user/create.html';
        }
    }
    public function edit($wx_uid=null)
    {
        if(!($wx_uid = (int)$wx_uid) && !($wx_uid = $this->GP('wx_uid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/user')->detail($wx_uid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('weixin/user')->update($wx_uid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:weixin/user/edit.html';
        }
    }

    public function delete($wx_uid=null)
    {
        if($wx_uid = (int)$wx_uid){
            if(!$detail = K::M('weixin/user')->detail(wx_uid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('weixin/user')->delete($wx_uid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('wx_uid')){
            if(K::M('weixin/user')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}