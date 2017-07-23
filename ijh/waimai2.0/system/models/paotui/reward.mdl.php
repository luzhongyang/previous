<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Paotui_Reward extends Mdl_Table
{   
  
    protected $_table = 'paotui_order_reward';
    protected $_pk = 'id';
    protected $_cols = 'id,order_id,order_status,type,amount,dateline';
    protected $_pre_cache_key = 'paotui_reward';
    protected $_orderby = array('id'=>'DESC');

    public function create($data, $checked=false)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }
 
}