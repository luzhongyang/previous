<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Alipay_Alipay extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        
        if($items = K::M('alipay/alipay')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:alipay/alipay/items.html';
    }

    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('alipay/alipay')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:alipay/alipay/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($shop_id = K::M('alipay/alipay')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?alipay/alipay-index.html');
            } 
        }else{
           $this->tmpl = 'admin:alipay/alipay/create.html';
        }
    }


    public function delete($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(!$detail = K::M('alipay/alipay')->detail(shop_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('alipay/alipay')->delete($shop_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('alipay/alipay')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}