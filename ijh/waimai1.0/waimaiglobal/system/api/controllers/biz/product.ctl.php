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
    
    protected $_allow_fields = 'product_id,cate_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,orderby,dateline';

    public function items($params)
    {
        $limit = 20;
        $page = max((int)$params['page'], 1);
        if($items = K::M('product/product')->items(array('shop_id'=>$this->shop_id, 'closed'=>0), null, $page, $limit, $count)){
            $cate_ids = array();
            foreach($items as $k=>$v){
                $cate_ids[$v['cate_id']] = $v['cate_id'];
                $v = $this->filter_fields($this->_allow_fields, $v);
                $v['cate_name'] = '';
                $items[$k] = $v;
            }
            if($cate_list = K::M('product/cate')->items_by_ids($cate_ids)){
                foreach($items as $k=>$v){
                    $items[$k]['cate_name'] = $cate_list[$v['cate_id']]['title'];
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));        
    }

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'cate_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,orderby,dateline')){
            $this->msgbox->add(L('非法的数据提交'), 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }            
            if($product_id = K::M('product/product')->create($data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function update($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add(L('商品不存在'), 211);
        }else if(!$data = $this->check_fields($params, 'title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,orderby')){
            $this->msgbox->add(L('非法的数据提交'), 212);
        }else if(!$product = K::M('product/product')->detail($product_id)){
            $this->msgbox->add(L('商品不存在'), 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add(L('非法操作'), 214);
        }else{
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('product/product')->update($product_id, $data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function delete($params)
    {
        if(!$ids = K::M('verify/check')->ids($params['product_id'])){
            $this->msgbox->add(L('商品不存在'), 211);
        }else if(!$items = K::M('product/product')->items_by_ids($ids)){
            $this->msgbox->add(L('商品不存在'), 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['product_id']] = $v['product_id'];
                } 
            }
            if($del_ids){
                K::M('product/product')->delete($del_ids);
            }
            $this->msgbox->add('success');
        }        
    }

}