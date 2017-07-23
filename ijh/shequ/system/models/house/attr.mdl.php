<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_House_Attr extends Mdl_Table
{
    protected $_table = 'house_attr';
    protected $_pk = 'staff_id,cate_id';
    protected $_cols = 'staff_id,cate_id';
    /**
     * 批量插入数据
     * $data,array
     */
    public function insertAll($data,$staff_id)
    {
        $sql = "DELETE FROM ".$this->table($this->_table)." WHERE `staff_id`={$staff_id}";
        $this->db->Execute($sql);
        $string = '';
        foreach($data as $value){
           $string .=  "(".$value['staff_id'] .','. $value['cate_id'] .",'". $value['cate_title']."'),";
        }
        $string = rtrim($string, ',');
        $sql = "REPLACE INTO ".$this->table($this->_table)." VALUES {$string}";
        return $this->db->Execute($sql);
    }
    protected function _format_row($row)
    {
        static $cate_list = null;
        if($cate_list === null){
            $cate_list = K::M('house/cate')->fetch_all();
        }
        if($cate = $cate_list[$row['cate_id']]){
            $row['cate_title'] = $cate['title'];
        }
        return $row;
    }
}
