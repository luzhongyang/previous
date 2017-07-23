<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Paotui_Cate extends Mdl_Table
{   
  
    protected $_table = 'paotui_cate';
    protected $_pk = 'type';
    protected $_cols = 'type,title,info,config';
    protected $_pre_cache_key = 'paotui-cate-list';
    public function savecfg($type, $data)
    {
    	if($data){
    		$info = $data['info'];
    		unset($data['info'], $data['type']);
    		$config = serialize($data);
    		$sql = "UPDATE {$this->table($this->_table)} SET `info`='{$info}',`config`='{$config}' WHERE type='{$type}'";
	    	if($this->db->Execute($sql)){
	            return true;
	        }
    	}
    }
}