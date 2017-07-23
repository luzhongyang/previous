<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Product_Cate extends Mdl_Table
{   
  
    protected $_table = 'product_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,shop_id,title,icon,orderby,dateline';
    protected $_orderby = array('shop_id'=>'ASC', 'parent_id'=>'ASC', 'orderby'=>'ASC');

    public function options($shop_id)
    {
        $options = array();
        if($shop_id = (int)$shop_id){
            if($items = $this->items(array('shop_id'=>$shop_id), array('parent_id'=>'ASC', 'orderby'=>'ASC'))){
                foreach($items as $k=>$v){
                    $options[$k] = $v['title'];
                }
            }
        }
        return $options;
    }

    public function children_ids($parent_id)
    {
        $ids = array();
        if($parent_id = (int)$parent_id){
            if($items = K::M('product/cate')->items(array('parent_id'=>$parent_id), null, 1, 100)){
                foreach($items as $k=>$v){
                    $ids[$v['cate_id']] = $v['cate_id'];
                }
            }
        }
        return $ids;
    }

    public function tree($shop_id)
    {
        $tree = array();
        if($shop_id = (int)$shop_id){
            if($items = $this->items(array('shop_id'=>$shop_id), array('parent_id'=>'ASC', 'orderby'=>'ASC'), 1, 500)){
                foreach($items as $k=>$v){
                    if(empty($v['parent_id'])){
                        $tree[$k] = $v;
                    }else{
                        $tree[$v['parent_id']]['childrens'][] = $v;
                    }
                }
            }
        }
        return $tree;
    }
}