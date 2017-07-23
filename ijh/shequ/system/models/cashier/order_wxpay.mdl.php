<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Order_wxpay extends Mdl_Table
{
    protected $_table = 'cashier_order_wxpay';
    protected $_pk = 'detail_id';
    protected $_cols = 'detail_id,po_id,appid,attach,bank_type,cash_fee,fee_type,is_subscribe,mch_id,nonce_str,openid,out_trade_no,result_code,return_code,return_msg,sign,time_end,total_fee,trade_state,trade_type,transaction_id,is_pay,is_back,back_time,back_info,dateline';
    public function create($data, $checked = false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data, true);
    }
}
