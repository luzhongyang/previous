<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Report extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_report';
    protected $_pk = 'report_id';
    protected $_cols = 'report_id,xiaoqu_id,uid,yezhu_id,contact,mobile,content,reply,reply_time,tx_time,status,closed,clientip,dateline';
    protected $_orderby = array('report_id'=>'DESC');
}