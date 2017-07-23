<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_OrderProduct extends Mdl_Table
{
    protected $_table = 'weidian_order_product';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_name,product_price,product_number,amount,stock_name,stock_real_name';
}