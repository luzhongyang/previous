<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Wuye_Tixian extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_wuye_tixian';
    protected $_pk = 'tixian_id';
    protected $_cols = 'tixian_id,wuye_id,money,intro,account_info,status,reason,updatetime,clientip,dateline,end_money';
    public function total_wait_money($wuye_id)
    {
    	if(!$staff_id = (int)$staff_id){
    		return false;
    	}
    	return $this->db->GetOne("SELECT SUM(`money`) FROM ".$this->table($this->_table)." WHERE `wuye_id`='{$wuye_id}' AND `status`=0");
    }
}