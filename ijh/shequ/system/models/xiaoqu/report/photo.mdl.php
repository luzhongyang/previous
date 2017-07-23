<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Report_Photo extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_report_photo';
    protected $_pk = 'photo_id';
    protected $_cols = 'photo_id,report_id,photo,dateline';
}