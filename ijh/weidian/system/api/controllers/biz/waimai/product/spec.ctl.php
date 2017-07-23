<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Product_Spec extends Ctl_Biz
{

    public function items($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('没有商品ID', 211);
        }else if(!$product = K::M('waimai/product')->detail($product_id)){
             $this->msgbox->add('商品不存在或已经删除', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('越权操作', 214);
        }else{
            $filter = $pager =  array();
            $pager['page'] = $params['page'] = max((int)$page, 1);
            $pager['limit'] = $limit = 20;
            $filter['product_id'] = $product_id;
            $filter['shop_id'] = $this->shop_id;
            if(!$items = K::M('waimai/productspec')->items($filter, array('spec_id'=>'desc'), $page, $limit, $count)){
                $items = array();
            }
            $this->msgbox->set_data('data',array('items'=>array_values($items),'product_name'=>$product['title']));
            $this->msgbox->add('success'); 
        }
 
    }
    
    public function create($params){
        
        if(!$data = $this->check_fields($params, 'product_id,price,spec_name,spec_photo,sale_sku')){
            $this->msgbox->add('非法的数据提交', 211);
        }else if(!$product_id = (int)$data['product_id']){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$product = K::M('waimai/product')->detail($product_id)){
             $this->msgbox->add('商品不存在或已经删除', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('越权操作', 214);
        }else{
            if($attach = $_FILES['spec_photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['spec_photo'] = $a['photo'];
                    }
                }
            }            
            if($spec_id = K::M('waimai/productspec')->create($data)){
                K::M('waimai/product')->update_spec($product_id);
                $this->msgbox->set_data('data', array('spec_id'=>$spec_id));
            }
        }
        
    }
        
    public function update($params)
    {
        if(!$spec_id = (int)$params['spec_id']){
            $this->msgbox->add('规格商品不存在', 211);
        }else if(!$data = $this->check_fields($params, 'spec_id,price,spec_name,spec_photo,sale_sku')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$spec = K::M('waimai/productspec')->detail($spec_id)){
            $this->msgbox->add('商品规格不存在', 213);
        }else if(!$product = K::M('waimai/product')->detail($spec['product_id'])){
             $this->msgbox->add('商品不存在或已经删除', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('越权操作', 214);
        }else{
            if($attach = $_FILES['spec_photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['spec_photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('waimai/productspec')->update($spec_id, $data)){
                K::M('waimai/product')->update_spec($product['product_id']);
                $this->msgbox->set_data('data', array('spec_id'=>$spec_id));
            }
        }
    }
    
    
    public function delete($params)
    {
        if(!$spec_id = $params['spec_id']){
            $this->msgbox->add('错误的规格ID', 212);
        }else if(!$spec = K::M('waimai/productspec')->detail($spec_id)){
            $this->msgbox->add('规格不存在', 213);
        }else if(!$product = K::M('waimai/product')->detail($spec['product_id'])){
             $this->msgbox->add('商品不存在或已经删除', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('越权操作', 214);
        }else if($del = K::M('waimai/productspec')->delete($spec_id)){
            K::M('waimai/product')->update_spec($product['product_id']);
        }
    }

}