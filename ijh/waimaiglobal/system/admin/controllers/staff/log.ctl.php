<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Staff_Log extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['log_id']){$filter['log_id'] = $SO['log_id'];}
            if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
            if($SO['intro']){$filter['intro'] = "LIKE:%".$SO['intro']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('staff/log')->items($filter, null, $page, $limit, $count)){
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
        $this->tmpl = 'admin:staff/log/items.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:staff/log/so.html';
    }

    public function detail($log_id = null)
    {
        if(!$log_id = (int)$log_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('staff/log')->detail($log_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:staff/log/detail.html';
        }
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){            
            if($log_id = K::M('staff/log')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?staff/log-index.html');
            } 
        }else{
           $this->tmpl = 'admin:staff/log/create.html';
        }
    }

}