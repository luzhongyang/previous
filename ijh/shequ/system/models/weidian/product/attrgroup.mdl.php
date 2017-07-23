<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Product_AttrGroup extends Mdl_Table
{
    protected $_table = 'weidian_product_attr_group';
    protected $_pk = 'attr_group_id';
    protected $_cols = 'attr_group_id,product_id,title,orderby';
}