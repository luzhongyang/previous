<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: log.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Tuisong_Tuisong extends Mdl_Table
{
    protected $_table = 'tuisong';
    protected $_pk    = 'uid';
    protected $_cols  = 'uid,register_id,tags,dateline';
    public function tuisong_by_uids($uids)
    {
        $sql = "SELECT * FROM " . $this->table($this->_table) . " WHERE `uid` IN ($uids)";
        $rs = $this->db->Execute($sql);
        $items = array();
        while($row = $rs->fetch()){
            $items[] = $row;
        }
        return $items;
    }
}
