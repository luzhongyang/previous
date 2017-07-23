<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Member_Invite extends Mdl_Table
{   
  
    protected $_table = 'member_invite';
    protected $_pk = 'invite_uid';
    protected $_cols = 'invite_uid,uid,mobile,money,dateline';
    public function invite_count($uid)
    {
        if(!$uid = (int)$uid){
            return false;
        }
        $sql = "SELECT uid, COUNT(1) as invite_count, SUM(`money`) as invite_money FROM ".$this->table($this->_table)." WHERE uid='$uid'";
        return $this->db->GetRow($sql);
    }
    public function send_invite_money($invite_uid, $money)
    {
        if(!$invite_uid = (int)$invite_uid){
            return false;
        }else if(!$invite = $this->detail($invite_uid)){
            return false;
        }else if($this->update($invite_uid, array('money'=>$money), true)){
            K::M('member/money')->update($invite['uid'], $money, '邀请用户(UID:'.$invite_uid.')');
            return true;
        }
        return false;
    }
}