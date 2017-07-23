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
    
    public function del($uid, $shop_id)
    {
        if(!($uid = (int)$uid) || !($shop_id = (int)$shop_id)){
            return false;
        }
        $sql = "DELETE FROM ". $this->db->table($this->_table) . " WHERE uid = $uid" . " AND shop_id = $shop_id";
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        }
        
    }
}