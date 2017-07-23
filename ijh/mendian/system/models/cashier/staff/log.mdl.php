<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Staff_Log extends Mdl_Table
{   
  
    protected $_table = 'cashier_staff_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,shop_id,staff_id,day_orders,day_cash,day_money,day_alipay,day_wxpay,day_refund,day_refund_count,day_refund_cash,day_refund_money,day_refund_money,day_refund_wxpay,day_refund_alipay,day,dateline';
    protected $_orderby = array('log_id'=>'DESC');
}