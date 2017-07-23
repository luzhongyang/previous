<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Waimai_Productcollect extends Mdl_Table
{ 
	protected $_table = 'waimai_product_collect';
    protected $_pk = 'product_id';
    protected $_cols = 'product_id,uid,dateline';

    public function del($uid, $product_id)
    {
        if(!($uid = (int)$uid) || !($product_id = (int)$product_id)){
            return false;
        }
        $sql = "DELETE FROM ". $this->db->table($this->_table) . " WHERE uid = $uid" . " AND product_id = $product_id";
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}