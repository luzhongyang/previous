<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Pic extends Mdl_Table
{   
  
    protected $_table = 'shop_pic';
    protected $_pk = 'pic_id';
    protected $_cols = 'pic_id,shop_id,photo,dateline';
    
    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        if($pic_id = $this->db->insert($this->_table, $data, true)){
            return $pic_id;
        } 
    }
}