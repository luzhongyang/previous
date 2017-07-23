<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Sysapi extends Mdl_Table
{   
  
    protected $_table = 'peisong_sys_api';
    protected $_pk = 'api_id';
    protected $_cols = 'api_id,platform,title,url,url_type,url_param,content';
}