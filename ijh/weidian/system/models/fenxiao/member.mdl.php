<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Fenxiao_Member extends Mdl_Table
{

    protected $_table = 'fenxiao_member';
    protected $_pk = 'id';
    protected $_cols = 'id,sid,invite1,invite2,invite3';
    
     public function items_by_shop($filter, $orderby, $page=1, $limit=10, &$count=0)
    {
        
        $where = '1';
        $ext_sql = '';
        if(is_array($filter)){
            if(isset($filter['fenxiao'])){
                $where = $this->where($filter['fenxiao'], 'ext.');
                $ext_sql = " LEFT JOIN ".$this->table($this->_table)." ext ON f.`sid`=ext.`sid` ";
            }
        }
        //print_r($where);die;
        $where = $where ." AND ". K::M('fenxiao/fenxiao')->where($filter, 'f.');
        $orderby = $this->order($orderby);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT COUNT(*) FROM ".$this->table('fenxiao') . " f " . $ext_sql . " WHERE $where";
        if($count = $this->db->GetOne($sql)){
            $sql = "SELECT f.*,ext.sid,ext.invite1,ext.invite2,ext.invite3 FROM ". $this->table('fenxiao')." f $ext_sql WHERE $where $orderby $limit";
            if($rs = $this->db->Execute($sql)){
                while($row = $rs->fetch()){
                    $row = $this->_format_row($row);
                    if($row[$this->_pk]){
                        $items[$row[$this->_pk]] = $row;
                    }else{
                        $items[] = $row;
                    }
                }
            }
        }
        return $items;
    }
    
}
