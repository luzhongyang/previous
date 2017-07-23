<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Verify extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
            if($SO['id_name']){$filter['id_name'] = "LIKE:%".$SO['id_name']."%";}
            if($SO['id_number']){$filter['id_number'] = "LIKE:%".$SO['id_number']."%";}
        }
        if($items = K::M('staff/verify')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
            $staff_ids = array();
            foreach($items as $v){
                $staff_ids[$v['staff_id']] = $v['staff_id'];
            }
            if($staff_ids){
                $this->pagedata['staff_list'] = K::M('staff/staff')->items_by_ids($staff_ids);
            }
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:staff/verify/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/verify/so.html';
    }

    public function detail($staff_id)
    {
        if(!$staff_id = (int)$staff_id){
            $this->msgbox->add('未指ID', 212);
        }else if(!$detail = K::M('staff/verify')->detail($staff_id)){
            $this->msgbox->add('认证请求不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['staff'] = K::M('staff/staff')->detail($staff_id);
            $this->tmpl = 'admin:staff/verify/detail.html';
        }
    }


    public function refuse($staff_id=null)
    {
        if(!($staff_id = (int)$staff_id) && !($staff_id = $this->GP('staff_id'))){
            $this->msgbox->add('未指定要操作的认证ID', 211);
        }else if(!$detail = K::M('staff/verify')->detail($staff_id)){
            $this->msgbox->add('要操作的认证不存在或已经删除', 212);
        }else if($refuse_content = $this->checksubmit('refuse_content')){
            if(K::M('staff/verify')->update($staff_id, array('refuse'=>$refuse_content, 'verify'=>2))){
                K::M('staff/staff')->update($staff_id, array('verify_name'=>2));
                $this->msgbox->add('操作成功');
            } 
        }else{
            $this->pagedata['detail'] = $detail;
        	$this->pagedata['staff'] = K::M('staff/staff')->detail($staff_id);
        	$this->tmpl = 'admin:staff/verify/refuse.html';
        }
    }

    public function doaudit($staff_id=null)
    {
        if($staff_id = (int)$staff_id){
            if(K::M('staff/verify')->update($staff_id, array('verify'=>1, 'verify_time'=>__TIME))){
                K::M('staff/staff')->update($staff_id, array('verify_name'=>1));
                $this->msgbox->add('审核认证成功');
            }
        }else if($ids = $this->GP('staff_id')){
            if(K::M('staff/verify')->update($ids, array('verify'=>1, 'verify_time'=>__TIME))){
                K::M('staff/staff')->update($ids, array('verify_name'=>1));
                $this->msgbox->add('批量审核认证成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的认证', 401);
        }
    }


}