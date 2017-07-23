<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Mall extends Ctl
{

    // 积分商城商品分类列表
    public function cate()
    {
        if(!$items = K::M('mall/cate')->fetch_all()) {
            $items = array();
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    // 积分商城商品列表
    public function product($params)
    {
        $filter = $items = array();
        if($cate_id = (int)$params['cate_id']){
            $filter['cate_id'] = $cate_id;
        }
        $filter['closed'] = 0;        
        $page = max((int)$params['page'], 1);
        if($items = K::M('mall/product')->items($filter, null, $page, 10)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('product_id,cate_id,title,photo,jifen,views,sales,sku,info', $v);
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));        
        $this->msgbox->add('success');
    }


    public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add(L('商品不存在'),211);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add(L('商品不存在'),212);
        }else{
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }
    
    

}
