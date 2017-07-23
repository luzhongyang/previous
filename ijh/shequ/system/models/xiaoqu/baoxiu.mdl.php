<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Baoxiu extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_baoxiu';
    protected $_pk = 'baoxiu_id';
    protected $_cols = 'baoxiu_id,uid,xiaoqu_id,yezhu_id,contact,mobile,yuyue_time,content,reply,reply_time,tx_time,status,closed,clientip,dateline';
}