`<?php

require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Config.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Api.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Data.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Notify.php";

class Payment_Wxpay extends WxPayNotify
{

    protected $notify_url = '';
    protected $return_url = '';
    protected $config = array();
    public function __construct($cfg)
	{
        $this->config = $cfg;		
        if(defined('IN_APP') && IN_APP){
			$this->setConfig('APP');
        }else{
			$this->setConfig('NATIVE');
        }
        // WxPayConfig::$SSLKEY_PATH = $this->config['sslkey_path'];
        // WxPayConfig::$SSLCERT_PATH = $this->config['sslcert_path'];

        //测试支付期间,始终不用app配置
        $this->_parameter = array();
        $this->_parameter['APPID'] = $cfg['appid'];
        $this->_parameter['APPSECRET'] = $cfg['appsecret'];
        $this->_parameter['MCHID'] = $cfg['mch_id'];
        $this->_parameter['KEY'] = $cfg['key'];
    }

	protected function setConfig($type='NATIVE')
	{
        $cert_path = dirname(dirname(__CORE_DIR)).'/cert/';
        if(strtoupper($type) == 'APP'){
			WxPayConfig::$APPID = $this->config['app_appid'];
			WxPayConfig::$MCHID = $this->config['app_mch_id'];
			WxPayConfig::$KEY = $this->config['app_key'];
			WxPayConfig::$APPSECRET = $this->config['app_appsecret'];
            $this->notify_url = $this->config['app_notify_url'];
            $this->return_url = $this->config['app_return_url'];
            WxPayConfig::$SSLCERT_PATH = $cert_path.'jhapp_cert.pem';
            WxPayConfig::$SSLKEY_PATH = $cert_path.'jhapp_key.pem';
        }else{
			WxPayConfig::$APPID = $this->config['appid'];
			WxPayConfig::$MCHID = $this->config['mch_id'];
			WxPayConfig::$KEY = $this->config['key'];
			WxPayConfig::$APPSECRET = $this->config['appsecret'];
            $this->notify_url = $this->config['notify_url'];
            $this->return_url = $this->config['return_url'];
            WxPayConfig::$SSLCERT_PATH = $cert_path.'jhmp_cert.pem';
            WxPayConfig::$SSLKEY_PATH = $cert_path.'jhmp_key.pem';
        }		
	}

    //付款码付款
    public function codepay($input, &$msg='SUCCESS')
    {
		$this->setConfig('NATIVE');
        require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.MicroPay.php";
        if(!preg_match("/^1[0-5]\d{16}$/i", $input['auth_code'])){
            $msg = '付款码错误';
            return false;
        }
        try{
            if($input['mch_id'] && $input['mch_key']){
                WxPayConfig::$MCHID = $input['mch_id'];
                WxPayConfig::$KEY = $input['mch_key'];
            }
            $inputObj = new WxPayMicroPay();
            $inputObj->SetAuth_code($input['auth_code']);
            $inputObj->SetBody($input['title']);
            $inputObj->SetTotal_fee($input['amount'] * 100);
            $inputObj->SetOut_trade_no($input['trade_no']);
            if(!empty($input['device_info'])){
                $inputObj->SetDevice_info($input['device_info']);
            }
            $microPay = new MicroPay();
            $result = $microPay->pay($inputObj);
            if($result['return_code'] == 'SUCCESS'){
                if($result['result_code'] == 'SUCCESS'){
                    $trade = array(
                            'code'          => 'wxpay', 
                            'trade_no'      => $input['trade_no'], 
                            'trade_type'    => $input['trade_type'],
                            'trade_status'  => $input['result_code'],
                            'amount'        => $input['amount'],
                            'transaction_id'=> $input['transaction_id'],
                        );
                    return $trade;
                }else{
                    $msg = $result['err_code_des'].'['.$result['err_code'].']';
                }
            }else{
                $msg = $result['return_msg'];
            }
        }catch(Exception $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }

    public function qrcodepay($input, &$msg='SUCCESS')
    {
        try{
            require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.NativePay.php";
            $this->setConfig('NATIVE');
            if($input['mch_id'] && $input['mch_key']){
                WxPayConfig::$MCHID = $input['mch_id'];
                WxPayConfig::$KEY = $input['mch_key'];
            }
            $inputObj = new WxPayUnifiedOrder();
            $inputObj->SetBody($input['title']);
            $inputObj->SetOut_trade_no($input['trade_no']);
            $inputObj->SetTotal_fee($input['amount'] * 100);
            $inputObj->SetNotify_url($this->notify_url);
            $inputObj->SetTrade_type("NATIVE");
            $inputObj->SetProduct_id($input['trade_no']);
            if ($inputObj->GetTrade_type() == "NATIVE") {
                $result = WxPayApi::unifiedOrder($inputObj);
                if($result['return_code'] == 'SUCCESS'){
                    if($result['result_code'] == 'SUCCESS'){
                        $trade = array(
                                'code'      => 'wxpay', 
                                'trade_no'  => $input['trade_no'], 
                                'qrcode'    => $result["code_url"], 
                                'amount'    => $input['amount'],
                                'prepay_id' => $result['prepay_id']
                            );
                        return $trade;
                    }else{
                        $msg = $result['err_code_des'].'['.$result['err_code'].']';
                    }
                }else{
                    $msg = $result['return_msg'];
                }
            }            
        }catch(Execption $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }

    public function Queryorder($transaction_id, &$msg='SUCCESS')
	{
        try{
            $input = new WxPayOrderQuery();
            $input->SetTransaction_id($transaction_id);
            $result = WxPayApi::orderQuery($input);
            if($result['return_code'] == 'SUCCESS'){
                if($result['result_code'] == 'SUCCESS'){
                    $trade = array(
                        'code'          => 'wxpay',
                        'trade_no'      => $result['out_trade_no'],
                        'trade_type'    => $result['trade_type'],
                        'trade_state'   => $result['trade_state'],
                        'is_subscribe'  => $result['is_subscribe'],
                        'pay_trade_no'  => $result['transaction_id'],
                        'total_fee'     => (int)($result['total_fee'] * 100)
                    );
                    return $trade;
                }else{
                    $msg = $result['err_code_des'].'['.$result['err_code'].']';
                }
            }else{
                $msg = $result['return_msg'];
            }
        }catch(Execption $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }

    public function build_app($input, &$msg='SUCCESS')
    {
        try{
            $this->SetConfig('APP');
            if($input['mch_id'] && $input['mch_key']){
                WxPayConfig::$MCHID = $input['mch_id'];
                WxPayConfig::$KEY = $input['mch_key'];
            }
            $inputObj = new WxPayUnifiedOrder();
            $inputObj->SetBody($input['title']);
            $inputObj->SetOut_trade_no($input['trade_no']);
            $inputObj->SetTotal_fee($input['amount'] * 100);
            $inputObj->SetNotify_url($this->notify_url);
            $inputObj->SetTrade_type("APP");
            $inputObj->SetProduct_id($input['trade_no']);
            if ($inputObj->GetTrade_type() == "APP") {
                $result = WxPayApi::unifiedOrder($inputObj);
                if($result['return_code'] == 'SUCCESS'){
                    if($result['result_code'] == 'SUCCESS'){
                        $timestamp = __TIME;
                        $data = array(
                            'appid'     => $result['appid'],
                            'partnerid' => $result['mch_id'],
                            'noncestr'  => $result['nonce_str'],
                            'prepayid'  => $result['prepay_id'],
                            'package'   => 'Sign=WXPay',
                            'timestamp' => "$timestamp"
                        );
                        $data['sign'] = $this->create_sign($data);
                        $data['wxpackage'] = $data['package'];
                        //$data['sign_string'] = $this->sign_string;
                        return $data;                    
                    }else{
                        $msg = $result['err_code_des'].'['.$result['err_code'].']';
                    }
                }else{
                    $msg = $result['return_msg'];
                }
            }
        }catch(Execption $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }

    public function build_url($input, &$msg='SUCCESS')
	{
        try {
            require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.NativePay.php";
            $this->setConfig('NATIVE');
            if($input['mch_id'] && $input['mch_key']){
                WxPayConfig::$MCHID = $input['mch_id'];
                WxPayConfig::$KEY = $input['mch_key'];
            }
            $inputObj = new WxPayUnifiedOrder();
            $inputObj->SetBody($input['title']);
            $inputObj->SetOut_trade_no($input['trade_no']);
            $inputObj->SetTotal_fee($input['amount'] * 100);
            $inputObj->SetNotify_url($this->notify_url);
            $inputObj->SetTrade_type("NATIVE");
            $inputObj->SetProduct_id($input['trade_no']);
            if ($inputObj->GetTrade_type() == "NATIVE") {
                $result = WxPayApi::unifiedOrder($inputObj);
                if($result['return_code'] == 'SUCCESS'){
                    if($result['result_code'] == 'SUCCESS'){
                        $trade = array(
                                'code'      => 'wxpay',
                                'trade_no'  => $input['trade_no'],
                                'trade_type'=> $result['trade_type'],
                                'qrcode'    => $result["code_url"], 
                                'amount'    => $input['amount'],
                                'prepay_id' => $result['prepay_id']
                            );
                        return $trade;
                    }else{
                        $msg = $result['err_code_des'].'['.$result['err_code'].']';
                    }
                }else{
                    $msg = $result['return_msg'];
                }
            }
        } catch (Exception $e) {
            $msgt = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }

    public function JsApiPay($input, &$msg='SUCCESS')
    {
        require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.JsApiPay.php";
        try{
            $this->setConfig('NATIVE');
            if($input['mch_id'] && $input['mch_key']){
                WxPayConfig::$MCHID = $input['mch_id'];
                WxPayConfig::$KEY = $input['mch_key'];
            }
            $tools = new JsApiPay();
            $inputObj = new WxPayUnifiedOrder();
            $inputObj->SetBody($input['title']);
            $inputObj->SetOut_trade_no($input['trade_no']);
            $inputObj->SetTotal_fee($input['amount']*100);
            $inputObj->SetNotify_url($this->config['notify_url']);
            $inputObj->SetTrade_type("JSAPI");
            //$inputObj->SetProduct_id($input['trade_no']);
            $inputObj->SetTime_start(date("YmdHis"));
            $inputObj->SetTime_expire(date("YmdHis", time() + 600));
            $inputObj->SetOpenid($input['wx_openid']);
            if($order = WxPayApi::unifiedOrder($inputObj)){
                //$editAddress = $tools->GetEditAddressParameters(); //获取共享收货地址js函数参数
                if($jsApiParameters = $tools->GetJsApiParameters($order)){
                    $trade = array('code'=>'wxpay','trade_no'=>$input['trade_no'], 'wx_openid'=>$input['wx_openid'], 'amount'=>$input['amount'], 'jsApiParameters'=>$jsApiParameters);
                    return $trade;
                }
            }
        }catch(Exception $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $order, $jsApiParameters));
        return false;
    }

    public function refund($input, &$msg='SUCCESS')
    {
        try{
            if($input['trade_type'] == 'APP'){ //如果是APP付款的刚从APP商户MCHID退款
                $this->setConfig('APP');
            }else{
                $this->setConfig('NATIVE');
            }
//            //商户自主账户收款不允许退款
//            if($input['mch_id'] && $input['mch_key']){
//                WxPayConfig::$MCHID = $input['mch_id'];
//                WxPayConfig::$KEY = $input['mch_key'];
//            }
            $inputObj = new WxPayRefund();
            if($trade_no = $input['trade_no']){
                $inputObj->SetOut_trade_no($trade_no);
            }else if($transaction_id = $input['pay_trade_no']){
                $inputObj->SetTransaction_id($transaction_id);
            }else{
                throw new WxPayException("退款申请接口中，out_trade_no、transaction_id至少填一个！");
            }
            if(!$out_refund_no = $input['refund_no']){
                $out_refund_no = WxPayConfig::$MCHID.date('YmdHis');
            }
            $inputObj->SetOut_refund_no($out_refund_no);
            $inputObj->SetTotal_fee((int)($input['total_amount'] * 100));
            $inputObj->SetRefund_fee((int)($input['refund_amount'] * 100));
            $inputObj->SetOp_user_id(WxPayConfig::$MCHID);
            $result = WxPayApi::refund($inputObj);
            if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                $trade = array(
                    'code'          => 'wxpay',
                    'trade_no'      => $result['out_trade_no'], 
                    'pay_trade_no'  => $result['transaction_id'],
                    'refund_amount' => $result['refund_fee'] /100,
                    'refund_no'     => $result['out_refund_no'],
                    'pay_refund_no' => $result['refund_id']
                );
                return $trade;
            }
        }catch(Execption $e){
            $msg = $e->getMessage();
        }
        $this->_errlogs(array($input, $result));
        return false;
    }    

    public function NotifyProcess($trade, &$msg='SUCCESS')
	{

        $success = false;
        $this->_logs('notify:' . json_encode($trade));
        if (!array_key_exists("transaction_id", $trade)) {
            $msg = "输入参数不正确";
        }else if (($trade['return_code'] != 'SUCCESS') || ($trade['result_code'] != 'SUCCESS')){
            $msg = $trade['return_msg'];
        }else if (!$log = K::M('payment/log')->log_by_no($trade['trade_no'])) {
            $msg = '支付的订单不存在';
        } else if ($trade['amount'] != $log['amount']) {
            $msg = '支付金额非法';
        }else{
            if($log['payee']){
                WxPayConfig::$MCHID = $log['payee_info']['mch_id'];
                WxPayConfig::$KEY = $log['payee_info']['mch_key'];
            }
            if (!$this->Queryorder($trade["transaction_id"])) {//查询订单，判断订单真实性
                $msg = "订单查询失败";
            } else {
                $amount = $trade['total_fee'] / 100;
                $trade = array('code'=>'wxpay','trade_no' => $trade['out_trade_no'], 'pay_trade_no' => $trade['transaction_id'], 'trade_status' => $trade['return_code'], 'amount' => $amount, 'trade_type' => $trade['trade_type']);
                if (!$log = K::M('payment/log')->log_by_no($trade['trade_no'])) {
                    $msg = '支付的订单不存在';
                } else if ($trade['amount'] != $log['amount']) {
                    $msg = '支付金额非法';
                } else if (K::M('payment/log')->set_payed($trade['trade_no'])) {
                    if (K::M('trade/payment')->payed_order($log, $trade)) {
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

    public function notify_success($success)
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

    protected function _errlogs($log)
    {
        $key = 'payment-wxpay-error-' . date('Ymd');
        K::M('system/logs')->log($key, $log);
    }

    protected function _logs($log)
    {
        $key = 'payment-wxpay-' . date('Ymd');
        K::M('system/logs')->log($key, $log);
    }

}
