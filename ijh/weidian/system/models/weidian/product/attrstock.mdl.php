<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Product_AttrStock extends Mdl_Table
{
    protected $_table = 'weidian_product_attr_stock';
    protected $_pk = 'attr_stock_id';
    protected $_cols = 'attr_stock_id,product_id,stock_name,price,wei_price,photo,stock,stock_sku,sales,stock_real_name';
}