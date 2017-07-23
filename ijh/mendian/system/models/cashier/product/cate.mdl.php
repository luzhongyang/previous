<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Product_Cate extends Mdl_Table
{   
  
    protected $_table = 'cashier_product_cate';
    protected $_pk = 'cate_id';
    protected $_pre_cache_key = 'cashier-product-cate-list';
    protected $_cols = 'cate_id,shop_id,title,orderby,dateline';
}