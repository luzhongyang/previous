<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Nav extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_nav';
    protected $_pk = 'nav_id';
    protected $_cols = 'nav_id,title,photo,type,link,app_link,pid';
}