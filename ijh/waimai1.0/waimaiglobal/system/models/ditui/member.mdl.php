<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Ditui_Member extends Mdl_Table
{   
  
    protected $_table = 'ditui_member';
    protected $_pk = 'mid';
    protected $_cols = 'mid,ditui_id,uid,signup_amount,first_amount,first_order_id,first_order_amount,first_order_time,clientip,dateline';

    public function create($data, $checked=false)
    {
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __CFG::TIME;
        return $this->db->insert($this->_table, $data, true);
    }

    // 近一月推荐用户曲线
    public function ditui_member($filter=null, $page=1,$limit=31) 
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT FROM_UNIXTIME(dateline,'%Y-%m-%d') as date,COUNT(uid) as uids FROM {$this->table($this->_table)} WHERE {$where} GROUP BY date ORDER BY date DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['date']] = $row;
            }
        }
        return $items;
    }

    // 近一月地推用户成功下单数
    public function first_amount($filter=null, $page=1,$limit=31) 
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT FROM_UNIXTIME(dateline,'%Y-%m-%d') as date, COUNT(1) as first FROM {$this->table($this->_table)} WHERE {$where} AND first_amount>0 GROUP BY date ORDER BY date DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[] = $row;
            }
        }
        return $items;
    }
 
    // 近一月推用户收入曲线
    public function ditui_income($filter=null, $page=1,$limit=31)
    {
        $where = $this->where($filter);
        $limit = $this->limit($page, $limit);
        $sql = "SELECT FROM_UNIXTIME(dateline,'%Y-%m-%d') as date,SUM(`signup_amount`+`first_amount`) as money FROM {$this->table($this->_table)} WHERE {$where} GROUP BY date ORDER BY date DESC $limit";
        $items = array();
        if($rs = $this->db->Execute($sql)){
            while($row = $rs->fetch()){
                $items[$row['date']] = $row;
            }
        }
        return $items;
    }

    public function count_income($filter)
    {
        $where = $this->where($filter);
        $sql = "SELECT SUM(`signup_amount`+`first_amount`) as money FROM {$this->table($this->_table)} WHERE {$where}";
        if($row = $this->db->GetRow($sql)) {
            return $row['money'];
        }
    }
}