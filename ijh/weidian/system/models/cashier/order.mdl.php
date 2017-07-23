<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Cashier_Order extends Mdl_Table
{
    protected $_table = 'cashier_order';
    protected $_pk = 'po_id';
    protected $_cols = 'po_id,shop_id,trade_no,order_type,wx_url,ali_url,amount,pay_status,pay_desc,pay_shop,clientip,dateline';
    public function create($data, $checked = false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        $data['clientip'] = $data['clientip'] ? $data['clientip'] : __IP;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data, true);
    }
    public function set_payed($log, $trade, $code = 'alipay')
    {
        if('alipay' == $code){
            $code_num = 2;
        }
        else{
            $code_num = 1;
        }
        $order_id = $log['order_id'];
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($result = $this->db->update($this->_table, array('pay_status' => 1, 'order_type'=> $code_num,'trade_no'=>$log['trade_no']), "po_id='{$order_id}'", true)){
            //order_type 需区分微信和支付宝
            if('alipay' == $code){
                $pay_name = '支付宝客户扫码';
                $res = $log;
                $res['pay_info']['po_id'] = $log['order_id'];
                $res['attach'] = json_encode($res['attach']);
                $res['is_pay'] = 1;
                $a = array('payed'=>1,'pay_trade_no'=>$res['pay_trade_no']);
                if($a){
                    K::M('payment/log')->update($log['log_id'], $a, true);
                }
                K::M('cashier/order_alipay')->create($res['pay_info']);//记录支付信息
            }
            else{
                $pay_name = '微信客户扫码';
                $res = $log;
                $res['pay_info']['po_id'] = $log['order_id'];
                $res['attach'] = json_encode($res['attach']);
                $res['is_pay'] = 1;
                $a = array('payed'=>1,'pay_trade_no'=>$res['pay_trade_no']);
                if($a){
                    K::M('payment/log')->update($log['log_id'], $a, true);
                }
                K::M('cashier/order_wxpay')->create($res['pay_info']);//记录支付信息
            }
            $title = sprintf($pay_name."支付成功通知(单号：%s)", $order_id);
            $content = sprintf($pay_name."支付成功(单号：%s)，买单金额￥%s，支付方式", $order_id,  $order['amount']);
            //优惠后支付￥%s
            K::M('shop/shop')->send($order['shop_id'], $title, $content, 'qrcodepay', $order_id, 'newMsg.mp3', $order['amount'], $pay_name);//qrcodepay 扫码支付
        }
        return $res;
    }
    public function printf_info($data)
    {
        foreach($data as $key => $value){
            echo "<font color='#00ff55;'>$key</font> : $value <br/>";
        }
    }

    public function get_payment_amount($order_id, &$level=0)
    {
        if(!$order = $this->detail($order_id)){
            return false;
        }else if($order['pay_status']){
            return false;
        }else{
            $level = 0;
            $amount = $order['amount'];
        }
        return $amount;
    }

}
