<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Tieba_Photo extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_tieba_photo';
    protected $_pk = 'photo_id';
    protected $_cols = 'photo_id,tieba_id,photo,dateline';
}