<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Product_Spec extends Mdl_Table
{   
  
    protected $_table = 'product_spec';
    protected $_pk = 'spec_id';
    protected $_cols = 'spec_id,product_id,price,spec_name,spec_photo,sale_sku,sale_count';


}