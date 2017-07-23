<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Order_alipay extends Mdl_Table
{
    protected $_table = 'cashier_order_alipay';
    protected $_pk = 'detail_id';
    protected $_cols = 'detail_id,po_id,code,msg,buyer_logon_id,buyer_pay_amount,buyer_user_id,fund_bill_list,gmt_payment,invoice_amount,open_id,out_trade_no,point_amount,receipt_amount,total_amount,trade_no,is_pay,is_back,back_time,back_info,dateline';
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
