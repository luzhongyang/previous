<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Sharephoto extends Mdl_Table
{   
  
    protected $_table = 'cloud_share_photo';
    protected $_pk = 'photo_id';
    protected $_cols = 'photo_id,share_id,photo';
    
}