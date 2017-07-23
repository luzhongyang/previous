<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: log.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Payment_Log extends Mdl_Table
{   
  
    protected $_table = 'payment_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,uid,from,payment,trade_no,order_id,amount,payed,payedip,payedtime,pay_trade_no,extra_pay,clientip,dateline';
    protected $_orderby = array('log_id'=>'DESC');

    
    public function create($data, $checked=false)
    {
        /*if(!$checked && !$data = $this->_check($data)){
            return false;
        }*/
		$data['trade_no'] = $this->create_trade_no();
        $data['dateline'] = __CFG::TIME;
        $data['clientip'] = __IP;
        return $this->db->insert($this->_table, $data, true);
    }

    public function update($pk, $data, $checked=false)
    {
        unset($data['trade_no']);
        if(!$checked && !$data = $this->_check($data,  $pk)){
            return false;
        }
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }

    public function update_trade_no($log_id, $trade_no)
    {
        $log_id = (int)$log_id;
        $trade_no = (int)$trade_no;
        return $this->db->update($this->_table, array('trade_no'=>$trade_no), "log_id='$log_id'"); 
    }

    public function create_trade_no()
    {
        $i = rand(0, 9999);
        do {
            if (9999 == $i) {
                $i = 0;
            } 
            ++$i;
            $no = date("ymd") . str_pad($i, 4, "0", STR_PAD_LEFT);
            $order_no = $this->db->GetRow("SELECT trade_no FROM ".$this->table($this->_table)." WHERE trade_no='{$no}'");
        } while ($order_no);
        return $no;
    }


    public function log_by_no($no) 
    {
        if(!is_numeric($no)){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE trade_no=$no";
        return $this->db->GetRow($sql);
    }

    public function log_by_order_id($order_id, $level)
    {
        if(!is_numeric($order_id)){
            return false;
        }
        $level = (int)$level;
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE order_id=$order_id AND pay_level=$level AND `from`='order'";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }

    public function log_by_paotui_id($order_id, $level)
    {
        if(!is_numeric($order_id)){
            return false;
        }
        $level = (int)$level;
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE order_id=$order_id AND pay_level=$level AND `from`='paotui'";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }

    public function set_payed($no, $pay_trade_no='', $extra='')
    {
        if(!is_numeric($no)){
            return false;
        }
        if($res = $this->db->update($this->_table, array('payed'=>1), "trade_no='{$no}'", true)){
            $a = array('pay_trade_no'=>$pay_trade_no, 'payedip'=>__IP, 'payedtime'=>__CFG::TIME);
            $a['extra_pay'] = $extra;
            $this->db->update($this->_table, $a, "trade_no='{$no}'");
        }
        return $res;
    }

    protected function _check($data, $log_id=null)
    {
        unset($data['log_id'], $data['dateline'], $data['clientip']);
        if(isset($data['payment']) || empty($log_id)){
            if(empty($data['payment'])){
                $this->msgbox->add(L('支付接口不能为空'), 452);
                return false;
            }
        }
        if(isset($data['from']) || empty($log_id)){
            if(empty($data['from'])){
                $this->msgbox->add(L('支付来源不能为空'), 453);
                return false;
            }
        }
        if(isset($data['amount']) || empty($log_id)){
            $data['amount'] = floatval($data['amount']);
            if($data['amount'] <= 0){
                $this->msgbox->add(L('支付金额不正确'), 454);
                return false;
            }
        }
        if(isset($data['uid'])){
            $data['uid'] = (int)$data['uid'];
        }      
        return parent::_check($data, $log_id);
    } 
}