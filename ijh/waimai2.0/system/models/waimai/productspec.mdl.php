<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Waimai_Productspec extends Mdl_Table
{   
  
    protected $_table = 'waimai_product_spec';
    protected $_pk = 'spec_id';
    protected $_cols = 'spec_id,product_id,price,spec_name,spec_photo,package_price,sale_sku,sale_count';
    protected $_orderby = array('sale_count'=>'ASC','spec_id'=>'DESC');
    protected $_pre_cache_key = 'spec_id';

}