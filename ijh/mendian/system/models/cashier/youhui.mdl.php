<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Youhui extends Mdl_Table
{   
  
    protected $_table = 'cashier_youhui';
    protected $_pk = 'youhui_id';
    protected $_cols = 'youhui_id,shop_id,type,youhui,discount';
}