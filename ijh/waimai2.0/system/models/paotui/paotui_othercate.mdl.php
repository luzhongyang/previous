<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Paotui_Paotui_othercate extends Mdl_Table
{   
  
    protected $_table = 'paotui_othercate';
    protected $_pk = 'cate_id';
    protected $_cols = 'cate_id,title,price,type';
    protected $_pre_cache_key = 'paotui_othercate';
    protected $_orderby = array('cate_id'=>'ASC');

    public function create($data, $checked=false)
    {
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }
 
}