<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier/coupon_Coupon extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
                if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['coupon_id']){$filter['coupon_id'] = $SO['coupon_id'];}
if($SO['shop_id']){$filter['shop_id'] = $SO['shop_id'];}
if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        if($items = K::M('cashier/coupon/coupon')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/coupon/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/coupon/so.html';
    }
    public function detail($coupon_id = null)
    {
        if(!$coupon_id = (int)$coupon_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('cashier/coupon/coupon')->detail($coupon_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cashier/coupon/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($coupon_id = K::M('cashier/coupon/coupon')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/coupon/coupon-index.html');
            } 
        }else{
           $this->tmpl = 'admin:cashier/coupon/create.html';
        }
    }
    public function edit($coupon_id=null)
    {
        if(!($coupon_id = (int)$coupon_id) && !($coupon_id = $this->GP('coupon_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/coupon/coupon')->detail($coupon_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('cashier/coupon/coupon')->update($coupon_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/coupon/edit.html';
        }
    }

    public function delete($coupon_id=null)
    {
        if($coupon_id = (int)$coupon_id){
            if(!$detail = K::M('cashier/coupon/coupon')->detail(coupon_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/coupon/coupon')->delete($coupon_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('coupon_id')){
            if(K::M('cashier/coupon/coupon')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}