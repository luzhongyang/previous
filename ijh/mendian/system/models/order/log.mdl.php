<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Order_Log extends Mdl_Table
{
    protected $_table = 'order_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,order_id,status,log,from,dateline';
}
