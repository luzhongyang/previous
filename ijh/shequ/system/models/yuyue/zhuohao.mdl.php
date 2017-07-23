<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Yuyue_Zhuohao extends Mdl_Table
{   
  
    protected $_table = 'yuyue_zhuohao';
    protected $_pk = 'zhuohao_id';
    protected $_cols = 'zhuohao_id,shop_id,cate_id,title,number';
}