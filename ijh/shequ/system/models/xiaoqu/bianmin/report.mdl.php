<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Bianmin_Report extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_bianmin_report';
    protected $_pk = 'report_id';
    protected $_cols = 'report_id,bianmin_id,uid,yezhu_id,title,content,clientip,dateline';
}