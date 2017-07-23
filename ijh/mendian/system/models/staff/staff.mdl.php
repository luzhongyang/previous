<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 9:41
 */
class Mdl_Staff_Staff extends Mdl_Table {
    protected $_table = 'cashier_staff_log';
    protected $_pk = 'staff_id';
    protected $_cols = 'staff_id,shop_id,is_owner,name,mobile,passwd,day_orders,day_cash,day_money,day_alipay,
    day_wxpay,day_chongzhi,day_refund_count,day_refund,day_refund_cash,day_refund_money,day_refund_wxpay,day_refund_alipay,
    audit,loginip,lastlogin,closed,dateline,';
    protected $_orderby = array('staff_id'=>'DESC');



}