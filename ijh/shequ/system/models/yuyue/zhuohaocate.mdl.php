<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Yuyue_Zhuohaocate extends Mdl_Table
{   
  
    protected $_table = 'yuyue_zhuohao_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,shop_id,title,orderby';
}