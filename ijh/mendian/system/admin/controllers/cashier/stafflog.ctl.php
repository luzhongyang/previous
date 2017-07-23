<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Stafflog extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['staff_id']){$filter['staff_id'] = $SO['staff_id'];}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('cashier/staff/log')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/staff/log/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/staff/log/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($log_id = K::M('cashier/staff/log')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/stafflog-index.html');
            } 
        }else{
           $this->tmpl = 'admin:cashier/staff/log/create.html';
        }
    }
    public function edit($log_id=null)
    {
        if(!($log_id = (int)$log_id) && !($log_id = $this->GP('log_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/staff/log')->detail($log_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('cashier/staff/log')->update($log_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/staff/log/edit.html';
        }
    }


}