<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Value extends Mdl_Table
{
    protected $_table = 'weidian_value';
    protected $_pk = 'key';
    protected $_cols = 'key,shop_id,title';
}