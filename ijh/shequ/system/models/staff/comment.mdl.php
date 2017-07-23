<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Staff_Comment extends Mdl_Table
{   
  
    protected $_table = 'staff_comment';
    protected $_pk = 'comment_id';
    protected $_cols = 'comment_id,order_id,staff_id,uid,score,content,reply,reply_ip,reply_time,clientip,dateline';
    
    public function create($data)
    {   
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        if($id = $this->db->insert($this->_table, $data, true)){
            $this->flush();
        }        
        return $id;
    }
    /**
     * 获取评论一条记录
     * @param $staff_id
     * @param $order_id
     */
    public function order_staff($staff_id, $order_id)
    {
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE `staff_id`={$staff_id} AND `order_id`={$order_id}";
        return $this->db->GetRow($sql);
    }
    public function items_by_order_ids($ids)
    {
        if(is_array($ids)){
            $ids = implode(',', $ids);
        }       
        if(!K::M('verify/check')->ids($ids)){
            return false;
        }
        $where = "order_id IN ($ids)";
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE $where";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['order_id']] = $this->_format_row($row);
            }
        }
        return $items;
    }
    public function detail_by_order_id($order_id)
    {
        if(!$order_id = (int)$order_id){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE `order_id`={$order_id}";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }
    public function staff_score($staff_id)
    {
        if($staff_id = (int)$staff_id) {
            $sql = "SELECT count(1) as total_count,SUM(`score`) as total_score FROM {$this->table($this->_table)} WHERE `staff_id`={$staff_id}";
            if ($row = $this->db->GetRow($sql)) {
                $rlt = round($row['total_score']/$row['total_count'],2);
            }
            return $rlt;
        }
    }
}