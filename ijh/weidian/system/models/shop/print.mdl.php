<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Shop_Print extends Mdl_Table
{
	protected $_table = 'shop_print';
    protected $_pk = 'plat_id';
    protected $_cols = 'shop_id,plat_id,title,partner,apikey,machine_code,mkey,num,status,dateline';
    protected $_orderby = array('plat_id'=>'DESC');
    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            return $id;
        } 
    }
    public function set_status($shop_id, $plat_id, $status)
    {
        if(!($shop_id = (int)$shop_id) || !($plat_id = (int)$plat_id)){
            return false;
        }
        if(!$status) {
            $this->db->update($this->_table, array('status'=>0), "shop_id={$shop_id} AND plat_id={$plat_id}");
        }else {
            $this->db->update($this->_table, array('status'=>0), "shop_id={$shop_id}");
            $this->db->update($this->_table, array('status'=>1), "shop_id={$shop_id} AND plat_id={$plat_id}");
        }
        
        return true;
    }
}