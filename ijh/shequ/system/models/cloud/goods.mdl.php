<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Goods extends Mdl_Table
{   
  
    protected $_table = 'cloud_goods';
    protected $_pk = 'goods_id';
    protected $_cols = 'goods_id,cate_id,title,photo,intro,details,orderby,closed,clientip,dateline';   
    
   
}