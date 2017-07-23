<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Mall extends Ctl
{

    // 积分商城商品分类列表
    public function cate()
    {
        $items = array();
        if($cate_list = K::M('mall/cate')->fetch_all()) {
            $index = 0;
            foreach($cate_list as $v){
                if(empty($v['parent_id'])){                    
                    if(++$index > 7 ){
                        break;
                    }
                    $items[] = $v;
                }
            }
        }
        $items[] = array('cate_id'=>0,'title'=>'更多','icon'=>'default/mall_cate_more.png','orderby'=>'9999');
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    // 积分商城商品列表
    public function product($params)
    {
        $filter = $items = array();
        $filter['closed'] = 0;
        if($cate_id = (int)$params['cate_id']){
            if($cate_ids = K::M('mall/cate')->children_ids($params['cate_id'])){
                $filter['cate_id'] = explode(',', $cate_ids);
            }else{
                $filter['cate_id'] = $cate_id;
            }            
        }        
        $page = max((int)$params['page'], 1);
        if($items = K::M('mall/product')->items($filter, null, $page, 10)){
            foreach($items as $k=>$v){
                $items[$k] = $this->filter_fields('product_id,cate_id,title,photo,jifen,price,freight,views,sales,sku', $v);
            }
        }else{
            $items = array();
        }
        $this->msgbox->set_data('data',array('items'=>array_values($items)));        
        $this->msgbox->add('success');
    }


    public function detail($params)
    {
        if(!$product_id = (int)$params['product_id']){
            $this->msgbox->add('商品不存在',211);
        }else if(!$detail = K::M('mall/product')->detail($product_id)){
            $this->msgbox->add('商品不存在',212);
        }else{
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('detail'=>$detail));
        }
    }
    
    

}
