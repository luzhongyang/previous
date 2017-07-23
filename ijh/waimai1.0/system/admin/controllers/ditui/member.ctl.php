<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ditui_Member extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
            if($SO['ditui_id']){$filter['ditui_id'] = $SO['ditui_id'];}
        }
        if($items = K::M('ditui/member')->items($filter, null, $page, $limit, $count)){
            $ditui_ids = $uids = array();
            foreach($items as $k=>$v){
                $ditui_ids[$v['ditui_id']] = $v['ditui_id'];
                $uids[$v['uid']] = $v['uid'];
            }
            $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            $this->pagedata['ditui_list'] = K::M('ditui/ditui')->items_by_ids($ditui_ids);
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:ditui/member/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:ditui/member/so.html';
    }

    public function detail($mid = null)
    {
        if(!$mid = (int)$mid){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('ditui/member')->detail($mid)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:ditui/member/detail.html';
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
            if($items = K::M('ditui/member')->items($filter, null, $page, $limit, $count)){
                $uids = array();
                foreach($items as $k=>$v){
                    $uids[$v['uid']] = $v['uid'];
                }
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            }
            $this->pagedata['ditui'] = $ditui;
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'admin:ditui/member/ditui.html';            
        }
    }

    public function edit($mid=null)
    {
        if(!($mid = (int)$mid) && !($mid = $this->GP('mid'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('ditui/member')->detail($mid)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('ditui/member')->update($mid, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:ditui/member/edit.html';
        }
    }


    public function delete($mid=null)
    {
        if($mid = (int)$mid){
            if(!$detail = K::M('ditui/member')->detail($mid)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('ditui/member')->delete($mid)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('mid')){
            if(K::M('ditui/member')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}