<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weidian_ProductAttr extends Mdl_Table
{
    protected $_table = 'weidian_product_attr';
    protected $_pk = 'attr_id';
    protected $_cols = 'attr_id,product_id,attr_name,attr_value,dateline';
}