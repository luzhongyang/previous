<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Card_Setting extends Mdl_Table
{   
  
    protected $_table = 'card_setting';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,explain,birthday,member,jifen';

    
}