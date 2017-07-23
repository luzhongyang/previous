<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_Product_AttrValue extends Mdl_Table
{
    protected $_table = 'weidian_product_attr_value';
    protected $_pk = 'attr_value_id';
    protected $_cols = 'attr_value_id,attr_group_id,title,orderby';
}