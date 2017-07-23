<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Product extends Ctl
{
    
    public function index($page=1,$shop_id)
    {
        $filter_shop=$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $shop_id = intval($shop_id);
        if($shop_id){
            $filter['shop_id'] = $shop_id;
        }
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;


                if($SO['shop_title']){

                    $filter_shop['title'] = 'LIKE:%'.$SO['shop_title'].'%';

                    $shop = K::M('shop/shop')->items($filter_shop);
                    foreach ($shop as $v){
                        $filter['shop_id'][] = $v['shop_id'];
                    }
                }
                if($SO['title']){
                    $filter['title'] = "LIKE:%".$SO['title']."%";
                }
            if($SO['product_id']){
                $filter=array();
                $filter['product_id'] = $SO['product_id'];
            }
           
        }
        if($items = K::M('cashier/product')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        foreach($items as $k=>$v) {
            $cateids[] = $v['cate_id'];
        }
        if($cateids) {
            if($p_cate_items = K::M('cashier/product/cate')->items_by_ids($cateids)) {
                $this->pagedata['p_cate_items'] = $p_cate_items;
            }
        }
        $this->pagedata['shop'] = K::M('shop/shop')->detail($shop_id);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/product/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/product/so.html';
    }

    public function create()
    {
        if($data = $this->checksubmit('data')){
                    if($_FILES['data']){
            foreach($_FILES['data'] as $k=>$v){
                foreach($v as $kk=>$vv){
                    $attachs[$kk][$k] = $vv;
                }
            }
            $upload = K::M('magic/upload');
            foreach($attachs as $k=>$attach){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = $upload->upload($attach, 'cashier')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }

            if($product_id = K::M('cashier/product')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/product-index.html');
            } 
        }else{
            $this->pagedata['shops'] = K::M('shop/shop')->items(array('closed'=>0));
            $this->pagedata['cates'] = K::M('cashier/product/cate')->items();
            $this->tmpl = 'admin:cashier/product/create.html';
        }
    }
    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'cashier')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            if(K::M('cashier/product')->update($product_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
            $shop = K::M('shop/shop')->detail($detail['shop_id']);
            $cate_items = K::M('cashier/product/cate')->items(array('shop_id'=>$detail['shop_id']));
            $this->pagedata['cate_items'] = $cate_items;
            $this->pagedata['shop_title'] = $shop['title'];
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:cashier/product/edit.html';
        }
    }

    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('cashier/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/product')->delete($product_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('product_id')){
            if(K::M('cashier/product')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  
}