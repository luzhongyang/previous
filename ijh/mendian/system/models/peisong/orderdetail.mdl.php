<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Orderdetail extends Mdl_Table
{   
  
    protected $_table = 'peisong_order_detail';
    protected $_pk = 'pf_order_detail_id';
    protected $_cols = 'pf_order_detail_id,pf_product_id,product_name,price,quantity,discount,total';
}