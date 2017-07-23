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
    protected $_cols = 'cate_id,shop_id,title,icon,orderby,dateline';
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
}