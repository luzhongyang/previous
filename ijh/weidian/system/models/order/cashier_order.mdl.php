<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Cashier_order extends Mdl_Table
{   
  
    protected $_table = 'cashier_order';
    protected $_pk = 'po_id';
    protected $_cols = 'po_id,shop_id,order_type,url,amount,pay_status,pay_desc,pay_shop,clientip,dateline';
}