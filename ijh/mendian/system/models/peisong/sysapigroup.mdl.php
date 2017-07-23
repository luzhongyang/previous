<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Peisong_Sysapigroup extends Mdl_Table
{

    protected $_table = 'peisong_sys_api_group';
    protected $_pk = 'group_id';
    protected $_cols = 'group_id,title,api_list,group_name,platform';
}
