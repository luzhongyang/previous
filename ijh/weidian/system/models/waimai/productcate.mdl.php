<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_ProductCate extends Mdl_Table
{
    protected $_table = 'waimai_product_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,shop_id,title,icon,orderby,type,spec,dateline';
    protected $_pre_cache_key = 'waimai_product-cate-list';
    protected $_orderby = array('parent_id'=>'ASC', 'orderby'=>'ASC');
    public function create($data, $checked=false)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($cate_id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }        
        return $cate_id;        
    }
    public function options($shop_id)
    {
        $options = array();
        if($shop_id = (int)$shop_id){
            if($items = $this->items(array('shop_id'=>$shop_id))){
                foreach($items as $k=>$v){
                    $options[$k] = $v['title'];
                }
            }
        }
        return $options;
    }
    public function children_ids($cate_id, $glue=',')
    {
        if(!$cate_id = (int)$cate_id){
            return false;
        }
        $cate_ids = array($cate_id=>$cate_id);
        if($items = $this->items(array('parent_id'=>$cate_id))){
            foreach((array)$items as $k=>$v){
                if(in_array($v['parent_id'], $cate_ids)){
                    $cate_ids[$v['cate_id']] = $v['cate_id'];
                }
            }
        }
        return implode($glue, $cate_ids);
    }
    public function tree($shop_id)
    {
        $tree = array();
        if($items = $this->items(array('shop_id'=>$shop_id), null, 1, 500)){
            foreach($items as $k=>$v){
                if(!$v['parent_id']){
                    $v['children'] = $v['childrens'] = array();
                    //$v['children'] = $v['childrens'];
                    $tree[$k] = $v;
                }
            }
            foreach($items as $k=>$v){
                if($tree[$v['parent_id']]){
                    $tree[$v['parent_id']]['childrens'][$k] = $v;
                }
            }
        }
        return $tree;
    }
}
