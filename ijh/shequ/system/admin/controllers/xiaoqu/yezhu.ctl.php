<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Xiaoqu_Yezhu extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['xiaoqu_id']){$filter['xiaoqu_id'] = $SO['xiaoqu_id'];}
            if($SO['uid']){$filter['uid'] = $SO['uid'];}
            if($SO['contact']){$filter['contact'] = "LIKE:%".$SO['contact']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
        }
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/yezhu')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $xiaoqu_ids = $uids = array();
            foreach($items as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
            }
            $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
            $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:xiaoqu/yezhu/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:xiaoqu/yezhu/so.html';
    }

    public function xiaoqu($xiaoqu_id, $page=1)
    {
        if(!$xiaoqu_id = (int)$xiaoqu_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else{
            $filter = $pager = array();
            $pager['page'] = max(intval($page), 1);
            $pager['limit'] = $limit = 50;
            $filter['xiaoqu_id'] = $xiaoqu_id;
            if($items = K::M('xiaoqu/baoxiu')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
                $xiaoqu_ids = $uids = array();
                foreach($items as $k=>$v){
                    $uids[$v['uid']] = $v['uid'];
                    $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                }
                $this->pagedata['xiaoqu_list'] = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids);
                $this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/yezhu/items.html';            
        }
    }


    public function detail($yezhu_id = null)
    {
        if(!$yezhu_id = (int)$yezhu_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
            $this->tmpl = 'admin:xiaoqu/yezhu/detail.html';
        }
    }

    public function create($xiaoqu_id=null)
    {
        if(!($xiaoqu_id = (int)$xiaoqu_id) && !($xiaoqu_id = (int)$this->GP('xiaoqu_id'))){
            $this->msgbox->add('参数错误', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            $data['xiaoqu_id'] = $xiaoqu_id;
            if($yezhu_id = K::M('xiaoqu/yezhu')->create($data)){
                $this->msgbox->add('添加业主成功');
                $this->msgbox->set_data('forward', '?xiaoqu/yezhu-index.html');
            } 
        }else{
            $this->pagedata['xiaoqu'] = $xiaoqu;
            $this->tmpl = 'admin:xiaoqu/yezhu/create.html';
        }
    }

    public function edit($yezhu_id=null)
    {
        if(!($yezhu_id = (int)$yezhu_id) && !($yezhu_id = $this->GP('yezhu_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('xiaoqu/yezhu')->update($yezhu_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
            $this->pagedata['xiaoqu'] = K::M('xiaoqu/xiaoqu')->detail($detail['xiaoqu_id']);
        	$this->tmpl = 'admin:xiaoqu/yezhu/edit.html';
        }
    }

    public function doaudit($yezhu_id=null)
    {
        if($yezhu_id = (int)$yezhu_id){
            if(K::M('xiaoqu/yezhu')->batch($yezhu_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('yezhu_id')){
            if(K::M('xiaoqu/yezhu')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }

    public function delete($yezhu_id=null)
    {
        if($yezhu_id = (int)$yezhu_id){
            if(!$detail = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('xiaoqu/yezhu')->delete($yezhu_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('yezhu_id')){
            if(K::M('xiaoqu/yezhu')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

}