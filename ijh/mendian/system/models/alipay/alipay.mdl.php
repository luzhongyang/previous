<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Alipay_Alipay extends Mdl_Table
{   
  
    protected $_table = 'alipay';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,app_auth_token,app_refresh_token,auth_app_id,user_id,expires_in,re_expires_in,expire_time,status';
}