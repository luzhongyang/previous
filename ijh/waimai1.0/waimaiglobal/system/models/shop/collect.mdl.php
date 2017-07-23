<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Collect extends Mdl_Table
{   
  
    protected $_table = 'shop_collect';
    protected $_pk = 'shop_id,uid';
    protected $_cols = 'shop_id,uid,dateline';
    
    public function delete($where){
         $sql = "DELETE FROM ".$this->table($this->_table)." WHERE " . $where;
         $ret = $this->db->Execute($sql);  
         return $ret;
    }
    
}