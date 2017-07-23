<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Sysaccount extends Mdl_Table
{   
  
    protected $_table = 'peisong_sys_account';
    protected $_pk = 'account_id';
    protected $_cols = 'account_id,shop_id,platform,user_name,password,login_header,request_header,login_type,login_info,login_return,login_main_params,login_time,bak1,bak2,bak3,dateline';
}