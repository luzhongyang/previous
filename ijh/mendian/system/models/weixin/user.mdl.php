<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Weixin_User extends Mdl_Table
{   
  
    protected $_table = 'weixin_user';
    protected $_pk = 'wx_uid';
    protected $_cols = 'wx_uid,shop_id,wx_openid,unionid,nickname,face,dateline';

    public function detail_by_openid($openid)
    {
    	$sql = "SELECT * FROM ".$this->table($this->_table)." WHERE " . self::field('wx_openid', $openid);
    	if($row = $this->db->GetRow($sql)){
    		$row = $this->_format_row($row);
    	}
    	return $row;
    }

    public function detail_by_unionid($unionid)
    {
    	$sql = "SELECT * FROM ".$this->table($this->_table)." WHERE " . self::field('unionid', $unionid);
    	if($row = $this->db->GetRow($sql)){
    		$row = $this->_format_row($row);
    	}
    	return $row;
    }
}