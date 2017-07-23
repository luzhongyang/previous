<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Order_Order extends Mdl_Table
{   
  
    protected $_table = 'order';
    protected $_pk = 'order_id';
    protected $_cols = 'order_id,city_id,shop_id,staff_id,uid,from,payee,order_status,online_pay,pay_status,trade_no,total_price,order_youhui,money,amount,wx_openid,day,intro,order_from,pay_code,pay_time,closed,lasttime,clientip,dateline';
    protected $_orderby = array('order_id' => 'DESC');
    
    public function set_payed($log, $trade=array())
    {        
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else{
            return K::M("{$order['from']}/order")->set_payed($log, $trade);
        }
        return false;
    }

    //确认订单 ，结算订单
    public function confirm($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else{
            return K::M("{$order['from']}/order")->confirm($order_id, $order, $from);
        }
    }
    
    /**
     * @function  取消/退单 退回余额+在线支付金额到余额，退回红包
     * @params  $order_id
     * @params  $order
     * @params  $from  string  由哪个角色取消的[member, staff, shop, admin]
     */
    public function cancel($order_id=null, $order=null, $from='member')
    {
        $order_id = (int)$order_id;
        if(!$order && !($order = $this->detail($order_id))){
            return false;
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消过，不能再取消', 449);
            return false;
        }else if(in_array($order['order_status'], array(0, 1, 2, 3, 4, 5))){ ////-1:已取消，0：未处理，1：已接单，2：已配货，3：配送开始，4：配送完成，8：订单完成
            //todo
            return K::M("{$order['from']}/order")->cancel($order_id, $order, $from);
        }
        return false;
    }
    
    
    public function order_format_row($row)
    {
        return $this->_format_row($row);
    }

    protected function _format_row($row)
    {
        if($row['from'] == 'cashier'){
            if($row['order_status'] == -1){
                $label = '已取消';
            }else if(empty($row['pay_status'])){
                $label = '挂单中';
            }else if($row['order_status'] == 8){
                $label = '已完成';
            }else{
                $label = '已完成';
            }    
        }
        switch ($row['from']){
            case 'cashier':
                $from_name = '收银';
                break;
            case 'waimai';
                $from_name = '外卖';
                break;
            case 'weidian';
                $from_name = '微店';
                break;
            case 'fenxiao';
                $from_name = '分销';
                break;
            default:
                $from_name = '其它';
        }

        if($row['pay_code']){
            switch ($row['pay_code']){
                case 'wxpay':
                    $type='微信';
                    break;
                case "alipay":
                    $type='支付宝';
                    break;
                case 'money':
                    $type='余额';
                    break;
                case  'cash':
                    $type= '现金';
                    break;
                default:
                    $type = '其他';


            }
        }
        $row['from_name'] = $from_name;
        $row['order_status_label'] = $label;
        $row['order_pay_type'] = $type;

        return $row;
    }

    protected function _check($row, $order_id=null)
    {
        if(empty($order_id) && empty($row['day'])){
            $row['day'] = date('Ymd', __TIME);
        }
        return parent::_check($row, $order_id);
    }
   
    
}