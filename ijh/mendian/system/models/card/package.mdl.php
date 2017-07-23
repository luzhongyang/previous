<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Package extends Mdl_Table
{   
  
    protected $_table = 'card_package';
    protected $_pk = 'package_id';
    protected $_cols = 'package_id,shop_id,money,give,jifen';
}