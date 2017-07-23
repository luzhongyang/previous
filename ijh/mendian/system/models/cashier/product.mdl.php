<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Product extends Mdl_Table
{   
  
    protected $_table = 'cashier_product';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,cate_id,shop_id,title,price,photo,code,stock,sales,orderby,dateline,closed';

    protected  function _format_row($row)
    {
        if(empty($row['photo'])){
            $row['photo'] = 'default/cashier_product.png';
        }
        return $row;
    }
}