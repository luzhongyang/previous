<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Pintuan_GroupLevel extends Mdl_Table
{
    protected $_table = 'weidian_pintuan_group_level';
    protected $_pk = 'level_id';
    protected $_cols = 'level_id,group_id,product_id,level,user_num,price';
}