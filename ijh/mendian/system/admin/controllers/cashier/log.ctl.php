<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Log extends Ctl
{
    
    public function index($page=1,$shop_id)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
        $shop_id = intval($shop_id);
        if($shop_id){
            $filter['shop_id'] = $shop_id;
        }
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['log_id']){$filter['log_id'] = $SO['log_id'];}
if($SO['shop_id']){$filter['shop_id'] = "LIKE:%".$SO['shop_id']."%";}
if($SO['staff_id']){$filter['staff_id'] = "LIKE:%".$SO['staff_id']."%";}
if($SO['order_id']){$filter['order_id'] = "LIKE:%".$SO['order_id']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('cashier/log')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        foreach ($items as $k => $v) {
            $shop_ids[$v['shop_id']] = $v['shop_id'];
            $staff_ids[$v['staff_id']] = $v['staff_id'];
        }
        $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
        $this->pagedata['staffs'] = K::M('cashier/staff')->items_by_ids($staff_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/log/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/log/so.html';
    }
    public function detail($log_id = null)
    {
        if(!$log_id = (int)$log_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('cashier/log')->detail($log_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $detail['staff'] = K::M('cashier/staff')->detail($detail['staff_id']);
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cashier/log/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($log_id = K::M('cashier/log')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/log-index.html');
            } 
        }else{
           $this->tmpl = 'admin:cashier/log/create.html';
        }
    }



}