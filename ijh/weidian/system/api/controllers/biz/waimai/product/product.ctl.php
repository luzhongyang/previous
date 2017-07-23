<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Biz_Waimai_Product_Product extends Ctl_Biz
{
    
    protected $_allow_fields = 'product_id,cate_id,title,photo,price,package_price,sales,sale_type,sale_sku,sale_count,intro,orderby,is_onsale,dateline';

    public function items($params)
    {
        $limit = 20;
        $page = max((int)$params['page'], 1);
        $filter = $orderby = array();
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $count = K::M('waimai/product')->count($filter);
        
        if($cate_id = (int)$params['cate_id']){
            $filter['cate_id'] = $cate_id;
        }
        $status = (int)$params['status'];
        if($status == 1){
            $filter['is_onsale'] = 1;
        }else{
            $filter['is_onsale'] = 0;
        }
        
        if($count%$limit > 0){
            $total_page = intval($count/$limit) + 1;
        }else{
            $total_page = intval($count/$limit);
        }
        
        if(isset($params['sales']) && $params['sales'] == 0){
            $orderby['sales'] = 'DESC';
            $orderby['product_id'] = 'desc';
        }elseif($params['sales'] == 1){
            $orderby['sales'] = 'ASC';
            $orderby['product_id'] = 'desc';
        }else{
            unset($orderby['sales']);
        }

        if($items = K::M('waimai/product')->items($filter, $orderby, $page, $limit, $count)){
            $cate_ids = array();
            foreach($items as $k=>$v){
                $cate_ids[$v['cate_id']] = $v['cate_id'];
                $v = $this->filter_fields($this->_allow_fields, $v);
                $v['cate_name'] = '';
                $items[$k] = $v;
            }
            if($cate_list = K::M('waimai/productcate')->items_by_ids($cate_ids)){
                foreach($items as $k=>$v){
                    $items[$k]['cate_name'] = $cate_list[$v['cate_id']]['title'];
                }
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count,'total_page'=>$total_page));        
    }
    
    
    public function batch_status($params)
    {
        if(!$params['ids']){
            $this->msgbox->add('没有选择删除的内容',211);
        }else{
            if(!in_array($params['status'],array(0,1))){
                $params['status'] = 1;
            }
            $ids = explode(',',$params['ids']);
            $count = 0;
            foreach($ids as $k => $v){
                if(K::M('waimai/product')->update($v,array('is_onsale'=>$params['status']))){
                    $count = $count + 1;
                }
            }
            $this->msgbox->add('成功设置了'.$count.'条');
        }
    }
    

    public function create($params)
    {
        if(!$data = $this->check_fields($params, 'cate_id,title,photo,price,package_price,sale_type,sale_sku,intro,orderby,is_onsale')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if($product_id = K::M('waimai/product')->create($data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function update($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('商品不存在', 211);
        }else if(!$data = $this->check_fields($params, 'title,photo,cate_id,price,package_price,sales,sale_type,sale_sku,intro,orderby,is_onsale')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(!$product = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('商品不存在', 213);
        }else if($product['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 214);
        }else{
            if($attach = $_FILES['photo']){
                if($attach['error'] == UPLOAD_ERR_OK){
                    if($a = K::M('magic/upload')->upload($attach, 'product')){
                        $data['photo'] = $a['photo'];
                    }
                }
            }
            if(K::M('waimai/product')->update($product_id, $data)){
                $this->msgbox->set_data('data', array('product_id'=>$product_id));
            }
        }
    }

    public function delete($params)
    {

        if(!$ids = K::M('verify/check')->ids($params['product_id'])){
            $this->msgbox->add('商品不存在', 211);
        }else if(!$items = K::M('waimai/product')->items_by_ids($ids)){
            $this->msgbox->add('商品不存在', 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['product_id']] = $v['product_id'];
                } 
            }
            if($del_ids){
                K::M('waimai/product')->delete($del_ids);
            }
            $this->msgbox->add('success');
        }        
    }

}