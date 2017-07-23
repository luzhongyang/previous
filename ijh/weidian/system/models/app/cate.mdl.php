<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author @shzhrui<Anhuike@gmail.com>
 * $Id: cate.mdl.php 2108 2013-12-11 11:21:31Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_App_Cate extends Mdl_Table
{   
  
    protected $_table = 'app_cate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,cate_name,cate_photo,cate_type,cate_link,rule_id';
    protected $_orderby = array('cate_id'=>'DESC');
}