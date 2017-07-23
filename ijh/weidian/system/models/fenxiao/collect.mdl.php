<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Fenxiao_Collect extends Mdl_Table
{
    protected $_table = 'fenxiao_collect';
    protected $_pk = 'collect_id';
    protected $_cols = 'collect_id,shop_id,product_id,uid,dateline';
}