<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Sysapilog extends Mdl_Table
{   
  
    protected $_table = 'peisong_sys_api_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,shop_id,platform,api_id,api_url,request_head,request_body,api_status,log_ip,dateline';
}