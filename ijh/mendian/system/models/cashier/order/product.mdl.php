<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Order_Product extends Mdl_Table
{   
  
    protected $_table = 'cashier_order_product';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_title,product_price,product_number,amount';
}