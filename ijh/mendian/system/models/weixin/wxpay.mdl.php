<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weixin_Wxpay extends Mdl_Table
{   
  
    protected $_table = 'weixin_wxpay';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,mch_id,mch_key,total_amount,expire_time,status';
}