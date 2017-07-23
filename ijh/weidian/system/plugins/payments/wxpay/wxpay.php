<?php

require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Config.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Api.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Data.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Notify.php";

class Payment_Wxpay extends WxPayNotify {

    public function __construct($cfg)
	{
        $this->config = $cfg;		
        if(defined('IN_APP') && IN_APP){
			$this->setConfig('APP');
        }else{
			$this->setConfig('NATIVE');
        }
        //测试支付期间,始终不用app配置
        $this->_parameter = array();
        $this->_parameter['APPID'] = $cfg['appid'];
        $this->_parameter['APPSECRET'] = $cfg['appsecret'];
        $this->_parameter['MCHID'] = $cfg['mch_id'];
        $this->_parameter['KEY'] = $cfg['key'];
        require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.NativePay.php";
    }

	protected function setConfig($type='NATIVE')
	{
        if(strtoupper($type) == 'APP'){
			WxPayConfig::$APPID = $this->config['app_appid'];
			WxPayConfig::$MCHID = $this->config['app_mch_id'];
			WxPayConfig::$KEY = $this->config['app_key'];
			WxPayConfig::$APPSECRET = $this->config['app_appsecret'];
            $this->config['return_url'] = $this->config['app_return_url'];
            $this->config['notify_url'] = $this->config['app_notify_url'];
        }else{
			WxPayConfig::$APPID = $this->config['appid'];
			WxPayConfig::$MCHID = $this->config['mch_id'];
			WxPayConfig::$KEY = $this->config['key'];
			WxPayConfig::$APPSECRET = $this->config['appsecret'];
            $this->config['return_url'] = $this->config['return_url'];
            $this->config['notify_url'] = $this->config['notify_url'];
        }		
	}

    //付款码付款
    public function codepay($input, &$msg='SUCCESS')
    {
		$this->setConfig('NATIVE');
        require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.MicroPay.php";
        if(empty($input['auth_code'])){
            return false;
        }
        try{
            $inputObj = new WxPayMicroPay();
            $inputObj->SetAuth_code($input['auth_code']);
            $inputObj->SetBody($input['title']);
            $inputObj->SetTotal_fee($input['amount'] * 100);
            $inputObj->SetOut_trade_no($input['trade_no']);
            if(!empty($input['device_info'])){
                $inputObj->SetDevice_info($input['device_info']);
            }

            $microPay = new MicroPay();
            if($result = $microPay->pay($inputObj)){
                $trade = array('code'=>'wxpay', 'trade_no'=>$input['trade_no'], 'amount'=>$input['amount']);
                $trade['pay_trade_no'] = $result['transaction_id'];
                $trade['trade_status'] = $result['result_code'];
                $trade['pay_info'] = $result;

                return $trade;
            }
            return false;
        }catch(Exception $e){
            $msg = $e->getMessage();
            K::M('system/logs')->log('codepay.wxpay', array($msg,$input));
            return false;
        }
    }

    public function qrcodepay($input)
    {
		$this->setConfig('NATIVE');
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($input['title']);
        $inputObj->SetOut_trade_no($input['trade_no']);
        $inputObj->SetTotal_fee($input['amount'] * 100);
        $inputObj->SetNotify_url($this->config['notify_url']);
        $inputObj->SetTrade_type("NATIVE");
        $inputObj->SetProduct_id($input['trade_no']);
        if ($inputObj->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($inputObj);
            if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                return array('code'=>'wxpay', 'trade_no'=>$input['trade_no'], 'qrcode'=>$result["code_url"], 'amount'=>$input['amount'],'prepay_id'=>$result['prepay_id']);
            }
        }
        K::M('system/logs')->log('payment-wxpay-qrcodepay.error', array($input, $result));
        return false;  
    }

    public function Queryorder($transaction_id)
	{
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return true;
        }
        return false;
    }

    public function build_app($input)
    {
        $this->SetConfig('APP');
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($input['title']);
        $inputObj->SetOut_trade_no($input['trade_no']);
        $inputObj->SetTotal_fee($input['amount'] * 100);
        $inputObj->SetNotify_url($this->config['notify_url']);
        $inputObj->SetTrade_type("APP");
        $inputObj->SetProduct_id($input['trade_no']);
        if ($inputObj->GetTrade_type() == "APP") {
            $ret = WxPayApi::unifiedOrder($inputObj);
            if($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS'){
                $timestamp = __TIME;
                $data = array(
                    'appid'     => $ret['appid'],
                    'partnerid' => $ret['mch_id'],
                    'noncestr' => $ret['nonce_str'],
                    'prepayid' => $ret['prepay_id'],
                    'package' => 'Sign=WXPay',
                    'timestamp' => "$timestamp"
                );
                $data['sign'] = $this->create_sign($data);
                $data['wxpackage'] = $data['package'];
                $data['sign_string'] = $this->sign_string;
                return $data;
            }
        }
        K::M('system/logs')->log('payment-wxpay-build-app.error', array($input, $ret));
        return false;
    }

    public function build_url($input)
	{
		$this-->SetConfig('NATIVE');
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($input['title']);
        $inputObj->SetOut_trade_no($input['trade_no']);
        $inputObj->SetTotal_fee($input['amount'] * 100);
        $inputObj->SetNotify_url($this->config['notify_url']);
        $inputObj->SetTrade_type("NATIVE");
        $inputObj->SetProduct_id($input['trade_no']);
        if ($inputObj->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($inputObj);
            if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                return array('trade_no'=>$input['trade_no'], 'qrcode'=>$result["code_url"], 'amount'=>$input['amount'],'prepay_id'=>$result['prepay_id']);
            }
            K::M('system/logs')->log('payment-wxpay-uniniedOrder.error', array($input, $result));
        }
        return false;
    }

    public function NotifyProcess($trade, &$msg)
	{

        $success = false;
        $this->_logs('notify:' . json_encode($trade));
        if (!array_key_exists("transaction_id", $trade)) {
            $msg = "输入参数不正确";
        } else if (!$this->Queryorder($trade["transaction_id"])) {//查询订单，判断订单真实性
            $msg = "订单查询失败";
        } else if ($trade['return_code'] == 'SUCCESS' && $trade['result_code'] == 'SUCCESS') {
            $amount = $trade['total_fee'] / 100;
            $trade = array('code'=>'wxpay','trade_no' => $trade['out_trade_no'], 'pay_trade_no' => $trade['transaction_id'], 'trade_status' => $trade['return_code'], 'amount' => $amount, 'trade_type' => $trade['trade_type']);
            if (!$log = K::M('payment/log')->log_by_no($trade['trade_no'])) {
                $msg = '支付的订单不存在';
            } else if ($trade['amount'] != $log['amount']) {
                $msg = '支付金额非法';
            } else if (K::M('payment/log')->set_payed($trade['trade_no'])) {
                if ($log['from'] == 'order') { //订单支付
                    if (K::M('trade/payment')->payed_order($log, $trade)) {
                        $success = true;
                    }
                } else if ($log['from'] == 'paotui') { //跑腿订单
                    if (K::M('trade/payment')->payed_paotui($log, $trade)) {
                        $success = true;
                    }
                } else if ($log['from'] == 'money') { //余额充值
                    if (K::M('trade/payment')->payed_money($log, $trade)) {
                        $success = true;
                    }
                } else if($log['from'] == 'cashier'){
                    if(K::M('trade/payment')->payed_cashier($log, $trade, 'wxpay')){
                        $success = true;
                    }
                }
            }
        }
        return $success;
    }

    public function notify_verify()
    {
        $handle = $this->Handle(true);
    }

    public function notify_success()
    {
        if ($success) {
            echo "success";
            exit;
        } else {
            echo "fail";
            exit;
        }
    }

    private function params_to_url($params)
    {
        $buff = "";
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    private function create_sign($params)
    {
        ksort($params);
        $sign_string = $this->params_to_url($params);
        $sign_string = $sign_string . "&key=".WxPayConfig::$KEY;
        $this->sign_string = $sign_string;
        return strtoupper(md5($sign_string));
    }

    protected function _logs($log)
    {
        $key = 'payment-wxpay-' . date('Ymd');
        K::M('system/logs')->log($key, $log);
    }

}
