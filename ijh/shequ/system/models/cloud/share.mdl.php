<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Share extends Mdl_Table
{   
  
    protected $_table = 'cloud_share';
    protected $_pk = 'share_id';
    protected $_cols = 'share_id,goods_id,attr_id,uid,content,clientip,dateline';
    
}