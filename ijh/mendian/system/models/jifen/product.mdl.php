<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Jifen_Product extends Mdl_Table
{   
  
    protected $_table = 'jifen_product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,shop_id,title,photo,jifen,stock,sales,orderby,dateline';
}