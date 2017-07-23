<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Log_Tixian extends Mdl_Table
{   
  
    protected $_table = 'staff_tixian';
    protected $_pk = 'tixian_id';
    protected $_cols = 'tixian_id,staff_id,money,intro,status,reason,updatetime,clientip,dateline';
}