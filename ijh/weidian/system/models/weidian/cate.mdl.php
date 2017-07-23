<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Cate extends Mdl_Table
{   
  
    protected $_table = 'weidian_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,parent_id,title,icon,photo,orderby';
}