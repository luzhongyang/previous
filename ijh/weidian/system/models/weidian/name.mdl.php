<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Name extends Mdl_Table
{
    protected $_table = 'weidian_name';
    protected $_pk = 'key';
    protected $_cols = 'key,shop_id,title';
}