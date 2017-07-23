<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Tuan_Ticket extends Mdl_Table
{
    protected $_table = 'tuan_ticket';
    protected $_pk = 'ticket_id';
    protected $_cols = 'ticket_id,uid,shop_id,tuan_id,order_id,number,count,ltime,use_time,status,dateline,type';
    protected $_tuan = array();

    /***
     * 生成消费券
     * @param array $data 券信息
     * @param int   $ticket_merge 是否多券合一
     */
    /*public function create($data, $ticket_merge=null)
    {
        $data['number'] = $this->create_number();
        $num = $data['count'];
        for ($i = 1; $i <= $num; $i++) {
            $data['uid'] = $data['uid'];
            $data['shop_id'] = $data['shop_id'];
            $data['tuan_id'] = $data['tuan_id'];
            $data['order_id'] = $data['order_id'];
            $data['number'] = $data['number'];
            $data['count'] = 1;
            $data['ltime'] = $data['ltime'];
            $data['use_time'] = $data['use_time'];
            $data['status'] = $data['status'];
            $data['dateline'] = $data['dateline'];
            $data['type'] = $data['type'];
        }
        foreach ($datas as $key => $v) {
            $ticket_id = $this->db->insert($this->_table, $v, true);
        }
        return $ticket_id;
    }*/
    public function create_number()
    {
        do{
            $no = date('Ymd',__TIME).rand(100000000, 999999999);
            $number = $this->db->GetOne("SELECT number FROM ".$this->table($this->_table)." WHERE number='{$no}'");
        } while ($number);
        return $no;
    }
    public function create_ticket($order_id=null)
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = K::M('tuan/order')->detail($order_id))){
            return false;
        }else if($order['order_status'] == 5 ) {
            $data['uid'] = $order['uid'];
            $data['shop_id'] = $order['shop_id'];
            $data['tuan_id'] = $order['tuan_id'];
            $data['order_id'] = $order['order_id'];
            $data['number'] = $this->create_number();
            $data['count'] = $order['tuan_number'];
            $data['ltime'] = $order['ltime'];
            $data['use_time'] = $order['use_time'];
            $data['status'] = 0;
            $data['dateline'] = __TIME;
            $data['type'] = $order['type'];
            return $this->db->insert($this->_table, $data, true);
        }
    }
    public function detail_by_number($number)
    {
        if(!preg_match('/^(\d+)$/i', $number)){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE number='".$number."'";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);

        }
        return $row;
    }
}