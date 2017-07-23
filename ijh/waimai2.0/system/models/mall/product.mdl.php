<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Mall_Product extends Mdl_Table
{   
  
    protected $_table = 'mall_product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,cate_id,title,photo,jifen,price,info,views,sales,sku,orderby,closed,clientip,dateline,freight';
}