<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cloud_Photo extends Mdl_Table
{   
  
    protected $_table = 'cloud_goods_photo';
    protected $_pk = 'photo_id';
    protected $_cols = 'photo_id,goods_id,photo';
    
    public function delete_by_goods_id($goods_id)
    {
        if(!$goods_id = (int)$goods_id){
            return false;
        }
        $sql = "DELETE FROM ".$this->table($this->_table)." WHERE goods_id=$goods_id";
        return $this->db->Execute($sql);
    }

}