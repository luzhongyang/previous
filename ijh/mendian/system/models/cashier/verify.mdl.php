<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Verify extends Mdl_Table
{   
  
    protected $_table = 'cashier_verify';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,id_name,id_number,id_photo1,id_photo2,id_photo3,mentou_photo,shop_photo1,shop_photo2,shop_photo3,verify,refuse,updatetime';
}