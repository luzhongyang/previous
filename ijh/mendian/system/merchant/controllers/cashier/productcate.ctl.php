<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('cashier');
class Ctl_Cashier_Productcate extends Ctl_Cashier
{

    public function index($page=1)
    {
        $filter = $pager =  array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        if ($items = K::M('cashier/product/cate')->items($filter, array('cate_id'=>"DESC"), $page, $limit, $count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count,$limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:cashier/productcate/index.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
            $data['shop_id'] = $this->shop_id;
            $data['dateline'] = __TIME;
            if($cate_id = K::M('cashier/product/cate')->create($data)){
                $this->msgbox->add(L('添加内容成功'));
                $this->msgbox->set_data('forward', $this->mklink('merchant/cashier/productcate:index'));
            } 
            
        }else{
            $this->tmpl = 'merchant:cashier/productcate/create.html';
        }
    }

    public function edit($cate_id=null)
    {
        if(!($cate_id = (int)$cate_id) && !($cate_id = $this->GP('cate_id'))){
            $this->msgbox->add(L('未指定要修改的内容ID'), 211);
        }else if(!$detail = K::M('cashier/product/cate')->detail($cate_id)){
            $this->msgbox->add(L('您要修改的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'.$detail['shop_id']), 213);
        }else if($data = $this->checksubmit('data')){
            if(K::M('cashier/product/cate')->update($cate_id, $data)){
                $this->msgbox->add(L('修改内容成功'));
            }  
        }else{     
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:cashier/productcate/edit.html';
        }
    }

    

    public function delete($cate_id=null)
    {
        if($cate_id = (int)$cate_id){
            if(!$detail = K::M('cashier/product/cate')->detail($cate_id)){
                $this->msgbox->add(L('你要删除的内容不存在或已经删除'), 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }else{
                if(K::M('cashier/product/cate')->delete($cate_id)){
                    $this->msgbox->add(L('删除内容成功'));
                }
            }
        }else{
            $this->msgbox->add(L('未指定要删除的内容ID'), 401);
        }
    } 

}
