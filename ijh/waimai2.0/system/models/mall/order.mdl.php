<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Mall_Order extends Mdl_Table
{   
  
    protected $_table = 'mall_order';
    protected $_pk = 'pid';
    protected $_cols = 'pid,order_id,product_id,product_name,product_jifen,product_number,product_price,post_id,post_name';
    protected $_orderby = array('order_id'=>'DESC');

    public function create($data, $checked=false)
    {
        // if(!$checked && !$data = $this->_check_schema($data)){
        //     return false;
        // }
        return $this->db->insert($this->_table, $data);
    }
}
