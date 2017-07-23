<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Shop_Tixian extends Mdl_Table
{   
  
    protected $_table = 'shop_tixian';
    protected $_pk = 'tixian_id';
    protected $_cols = 'tixian_id,shop_id,money,intro,account_info,status,reason,updatetime,clientip,dateline,end_money';
    protected $_orderby = array('tixian_id'=>'DESC');
}