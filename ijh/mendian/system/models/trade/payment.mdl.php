<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: payment.mdl.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Trade_Payment extends Model
{


    public function order($code, $order, $from=false)
    {
        
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }else if(!$log = $this->get_payment_log($code, $order, $level)){
            return false;
        }        
        $params = $this->get_payment_params($log, $order);
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from == 'JSAPI'){
            $params['wx_openid'] = $order['wx_openid'];
            return $oPayApi->JsApiPay($params, $msg);
        }else if($from == 'qrcode'){
            return $oPayApi->qrcode($params);
        }else if($from == 'codepay'){ //扫码支付
            $params['auth_code'] = $order['auth_code'];
            return $oPayApi->codepay($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            return $oPayApi->build_url($params);
        }
    }

    public function codepay($code, $auth_code, $order, &$msg='')
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }else if(empty($auth_code)){
            return false;
        }else if(!$log = $this->get_payment_log($code, $order, $level)){
            return false;
        }
        $params = $this->get_payment_params($log, $order);
        $params['auth_code'] = $auth_code;
        if($trade  =$oPayApi->codepay($params, $msg)){
            $trade['order_id'] = $order['order_id'];
            K::M('payment/log')->set_payed($log['trade_no'], $trade['pay_trade_no']);
        }
        return $trade;
    }

    public function qrcodepay($code, $order)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }else if(!$log = $this->get_payment_log($code, $order, $level)){
            return false;
        }
        $params = $this->get_payment_params($log, $order);
        K::M('system/logs')->log('mdl.trade.payment.qrcodepay', array($log, $order, $params));
        return $trade  =$oPayApi->qrcodepay($params);
    }

    public function cashpay($order)
    {
        if(!$log = $this->get_payment_log('cash', $order, $level)){
            return false;
        }else if(K::M('payment/log')->set_payed($log['trade_no'], $log['trade_no'])){
            return array('code'=>'cash', 'order_id'=>$order['order_id'], 'trade_no'=>$log['trade_no'], 'amount'=>$log['amount']);
        }
        return false;
    }

    public function payed_order($log, $trade)
    {
        if($log['order_id']){
            if(K::M('order/order')->set_payed($log, $trade)){
                return true;
            }
        }
        return false;
    }

    public function refund($code, $order)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $refund_amount = (float)$order['refund_amount'];
        $log_data = array('uid'=>$order['uid'], 'order_id'=>$order['order_id'], 'pay_level'=>$level, 'payment'=>$code, 'amount'=>$refund_amount); 
        //插入订单记录表
        $log_data['type'] = 'refund';
        if(!$log_id = K::M('payment/log')->create($log_data)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);
        $params = array('refund_amount'=>$refund_amount, 'refund_reason'=>$order['refund_reason'], 'order_id'=>$order['order_id']);
        $params['trade_no'] = $order['trade_no'];
        $params['total_amount'] = $order['amount'];
        $params['refund_no'] = $log['trade_no'];
        if($trade = $oPayApi->refund($params, $msg)){
            //$trade['refund_amount'] = $refund_amount;
            if(!K::M('payment/log')->set_payed($log['trade_no'], $trade['pay_trade_no'])){
                return false;
            }
        }
        return $trade;
    }
    
    public function loadPayment($code)
    {
        static $_PayApiObj = array();
        if(!is_object($_PayApiObj[$code])){
            $file = __CFG::DIR."plugins/payments/{$code}/{$code}.php";
            if(!file_exists($file)){
                $this->msgbox->add('您选择的支付接口不存在', 311);
                return false;
            }else if(!$payment = K::M('payment/payment')->payment($code)){
                $this->msgbox->add('您选择的支付接口不存在', 312);
                return false;
            }else if(empty($payment['status'])){
                $this->msgbox->add('您选择的支付接口不可用', 313);
                return false;
            }
            // if (defined('IN_WEIXIN') && $code == 'wxpay') {
            //     $file = __CFG::DIR."plugins/payments/{$code}/jsapi.php";
            //     include($file);
            //     $clsName = "Weixin_".ucfirst('jsapi');
            // }else{
            //     include($file);
            //     $clsName = "Payment_".ucfirst($code);
            // }
            include($file);
            $clsName = "Payment_".ucfirst($code);
            $config = $payment['config'];
            $site = K::$system->config->get('site');
            $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'www');
            $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
            $config['app_return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
            $config['app_notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
            $config['show_url'] = $site['siteurl'];
            $_PayApiObj[$code] = new $clsName($config);
        }
        return $_PayApiObj[$code];
    }

    protected function get_payment_log($code, $order, &$level=0)
    {
        $amount = $order['amount'];
        if(!$log = K::M('payment/log')->log_by_order_id($order['order_id'], $level)){
            $log = array('uid'=>$order['uid'],'shop_id'=>$order['shop_id'], 'order_id'=>$order['order_id'], 'pay_level'=>$level, 'payment'=>$code, 'amount'=>$amount);
            //插入订单记录表
            $log['from'] = $order['from'] ? $order['from'] : 'order';
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);            
        }else if($log['payed']){
            K::$system->msgbox->add('该订单已经支付成功', 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $order['amount']){
            $log['amount'] = $a['amount'] = $amount;
        }
        if($order['from'] && $log['from'] != $order['from']){
            $a['from'] = $order['from'];
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        $a['payee'] = 0;
        $a['payee_info'] = array();
        if($shop_id = (int)$order['shop_id']){
            if($code == 'alipay'){
                if($payee_alipay = K::M('alipay/alipay')->detail($shop_id)){
                    if($payee_alipay['expire_time'] > __TIME){
                        $a['payee'] = 1;
                        $log['payee_info'] = $a['payee_info'] = array('app_auth_token'=>$payee_alipay['app_auth_token']);
                    }
                }
            }else if($code == 'wxpay'){
                if($payee_wxpay = K::M('weixin/wxpay')->detail($shop_id)){
                    if($payee_wxpay['expire_time'] > __TIME){
                        $log['payee'] = $a['payee'] = 1;
                        $log['payee_info'] = $a['payee_info'] = array('mch_id'=>$payee_wxpay['mch_id'], 'mch_key'=>$payee_wxpay['mch_key']);
                    }
                }
            }
        }
        if($a){
            $log = array_merge($log, $a);
            $a['payee_info'] = json_encode($a['payee_info']);
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        return $log;
    }

    protected function get_payment_params($log, $order)
    {
        $params = array();
        $params['order_id'] = $log['order_id'];
        $params['trade_no'] = $log['trade_no'];
        if($order['title']){
            $params['title'] = $order['title'];
            $params['body'] = $order['body'] ? $order['body'] : $order['title'].'('.$params['trade_no'].')';  
        }else if($shop = K::M('shop/shop')->detail($order['shop_id'])){
            $params['title'] = $shop['title'].'订单';
            $params['body'] = $shop['title'].'订单('.$params['trade_no'].')';
        }else{
            $site = K::$system->config->get('site');
            $params['title'] = $site['title'].'订单';
            $params['body'] = $site['title'].'订单('.$params['trade_no'].')';  
        }
        $params['amount'] = $log['amount'];
        $params['payee'] = $log['payee'];
        $params = array_merge($params, (array)$log['payee_info']);
        return $params;
    }

}
