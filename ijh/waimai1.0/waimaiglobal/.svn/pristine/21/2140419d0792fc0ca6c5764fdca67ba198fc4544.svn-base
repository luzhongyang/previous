<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Shop_Verify extends Mdl_Table
{   
  
    protected $_table = 'shop_verify';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,id_name,id_number,id_photo,shop_photo,verify_dianzhu,yz_number,yz_photo,verify_yyzz,cy_number,cy_photo,verify_cy,refuse,verify,verify_time,updatetime';

    public function create($data, $checked=false)
    {
        $data['updatetime'] = $data['updatetime'] ? $data['updatetime'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }
        return $id;
    }
}