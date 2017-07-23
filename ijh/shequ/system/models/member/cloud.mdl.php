<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
class Mdl_Member_Cloud extends Mdl_Table {
    protected $_table = 'member_cloud';
    protected $_pk = 'uid';
    protected $_cols = 'uid,mobile,nickname,face';
    
    public function selectUids($need_nums){//
        $count = $this->count();
        $number = max(($count-$need_nums),1);
        $rand = rand(1, $number);
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE `uid`>".$rand." ORDER BY RAND() LIMIT ".$need_nums;
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['uid']] = $row['uid'];
            }
        }
        return $items;
    }
    
    protected function _format_row($row)
    {
        if(!$row['face']){
            $row['face'] = 'default/member_face.png';
        }
        if(!$row['nickname']) {
            $row['nickname'] = '匿名';
        }
        $row['pid'] = sprintf("M%05d", $row['uid']);
        return $row;
    }
}
