<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Product extends Ctl_Biz
{
   
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('waimai/product')->items($filter, array('orderby'=>'asc'), $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('waimai/productcate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'biz/product/index.html';
    }

    public function so()
    {
        $this->tmpl = 'admin:product/product/so.html';
    }

    public function detail($product_id = null)
    {
        if(!$product_id = (int)$product_id){
            $this->msgbox->add(L('未指定要查看内容的ID'), 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add(L('您要查看的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cates'] = K::M('waimai/productcate')->items(array('shop_id'=>$detail['shop_id']));
            $this->tmpl = 'biz/product/detail.html';
        }
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
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            $data['sales'] = 0;//默认销量0
            if($product_id = K::M('waimai/product')->create($data)){
                $this->msgbox->add(L('操作成功'));
                $this->msgbox->set_data('forward',  $this->mklink('biz/product:index'));

            } 
        }else{
            $this->pagedata['tree'] = K::M('waimai/productcate')->tree($this->shop_id); 
            $this->pagedata['shop_id'] = $this->shop_id;  
            $this->tmpl = 'biz/product/create.html';
        }
    }

    public function edit($product_id=null)
    {
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add(L('未指定要修改的内容ID'), 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add(L('您要修改的内容不存在或已经删除'), 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 213);
        }else if($data = $this->checksubmit('data')){
            if(isset($data['sales'] )){
                unset($data['sales'] ); //默认不允许调整销量
            }
            if($_FILES['data']){
            foreach($_FILES['data'] as $k=>$v){
                foreach($v as $kk=>$vv){
                    $attachs[$kk][$k] = $vv;
                }
            }
            $upload = K::M('magic/upload');
            foreach($attachs as $k=>$attach){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = $upload->upload($attach, 'product')){
                        $data[$k] = $a['photo'];
                    }
                }
            }
        }
        $data['price'] = abs($data['price']);
            if(K::M('waimai/product')->update($product_id, $data)){
                $this->msgbox->add(L('操作成功'));
            }  
        }else{
            $cate = K::M('waimai/productcate')->detail($detail['cate_id']);
            if($cate['parent_id'] == 0) {
                $cate_list = K::M('waimai/productcate')->items(array('parent_id'=>0,'shop_id'=>$detail['shop_id']));
            }else {
                $cate_list = K::M('waimai/productcate')->items(array('parent_id'=>'>:0','shop_id'=>$detail['shop_id']));
            }
            $this->pagedata['cate_list'] = $cate_list;
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/product/edit.html';
        }
    }

    public function delete($product_id=null)
    {
        if($product_id = (int)$product_id){
            if(!$detail = K::M('waimai/product')->detail($product_id)){
                $this->msgbox->add(L('你要删除的内容不存在或已经删除'), 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }else{
                if(K::M('waimai/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add(L('操作成功'));
                }
            }
        }else{
            $this->msgbox->add(L('未指定要删除的内容ID'), 401);
        }
    }  
    
    public function setspec($product_id)
    {
        $product_id = (int)$product_id;
        if(!$pro = K::M('waimai/product')->detail($product_id)) {
            $this->msgbox->add('商品不存在',210);
        }else if($pro['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作', 213);
        }else {
            if($data = $this->checksubmit()) {
                if(!$data = $this->check_fields($data, 'spec_name,price,package_price,sale_sku,spec_photo')){
                    $this->msgbox->add('非法的数据提交', 211);
                }else{
                    if($data1 = $this->checksubmit('data1')) {
                        if($spec_list = K::M('waimai/productspec')->items(array('product_id'=>$product_id))){
                            foreach($data1 as $k=>$v){
                                if($sp = $spec_list[$k]){
                                    $a = array();
                                    if($v['spec_name']!=$sp['spec_name']){
                                        $a['spec_name'] = $v['spec_name'];
                                    } 
                                    if($v['price']!=$sp['price']){
                                        $a['price'] = $v['price'];
                                    }
                                    if($v['package_price']!=$sp['package_price']){
                                        $a['package_price'] = $v['package_price'];
                                    }
                                    if($v['sale_sku']!=$sp['sale_sku']){
                                        $a['sale_sku'] = $v['sale_sku'];
                                    }
                                    if($v['spec_photo']!=$sp['spec_photo']){
                                        $a['spec_photo'] = $v['spec_photo'];
                                    }
                                    if($a){
                                        K::M('waimai/productspec')->update($k, $a);
                                    }   
                                }
                            }
                        }
                    }
                    if($data2 = $this->checksubmit('data2')) {
                        foreach($data2 as $k=>$v){
                            $v['product_id'] = $product_id;
                            K::M('waimai/productspec')->create($v);
                        } 
                        K::M('waimai/product')->update($product_id, array('is_spec'=>1));
                    }
                    $this->msgbox->add('规格设置成功'); 
                }
            }else {
                $filter = array('product_id'=>$product_id);
                if($items = K::M('waimai/productspec')->items($filter, null, $page, $limit, $count)){
                    $pager['count'] = $count;
                    $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($product_id, '{page}')));
                    $this->pagedata['items'] = $items;
                    K::M('waimai/product')->update($product_id,array('is_spec'=>1));
                }else {
                    K::M('waimai/product')->update($product_id,array('is_spec'=>0));
                }
                $this->pagedata['pager'] = $pager;
                $this->pagedata['product_id'] = $product_id;
                $this->tmpl = 'biz/product/specs.html';
            } 
        }
    }

    public function spec_del($spec_id, $product_id)
    {
        if($spec_id = (int)$spec_id){
            if(!$detail = K::M('waimai/productspec')->detail($spec_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['product_id'] != $product_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/productspec')->delete($spec_id)){
                    if(!$res = K::M('waimai/productspec')->find(array('product_id'=>$product_id))){
                        K::M('waimai/product')->update($product_id, array('is_spec'=>0));
                    }
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}