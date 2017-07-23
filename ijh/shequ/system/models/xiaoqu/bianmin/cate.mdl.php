<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Bianmin_Cate extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_bianmin_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,title';
    protected $_pre_cache_key = 'xiaoqu-bianmin-cate-list';
}