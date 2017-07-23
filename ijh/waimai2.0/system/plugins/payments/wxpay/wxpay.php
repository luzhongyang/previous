<?php
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Notify.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Api.php";
require_once __CFG::DIR . "plugins/payments/wxpay/lib/WxPay.Config.php";

class Payment_Wxpay extends WxPayNotify {

    public function __construct($cfg) {
        $this->config = $cfg;		
        if(defined('IN_APP') && IN_APP){
            WxPayConfig::$_CONFIG = array('appid'=>$this->config['app_appid'], 'appsecret'=>$this->config['app_appsecret'], 'mch_id'=>$this->config['app_mch_id'], 'key'=>$this->config['app_key']);            
        }else{
            WxPayConfig::$_CONFIG = array('appid'=>$cfg['appid'], 'appsecret'=>$cfg['appsecret'], 'mch_id'=>$cfg['mch_id'], 'key'=>$cfg['key']);
        }
        $this->_parameter = array();
        $this->_parameter['APPID'] = $cfg['appid'];
        $this->_parameter['APPSECRET'] = $cfg['appsecret'];
        $this->_parameter['MCHID'] = $cfg['mch_id'];
        $this->_parameter['KEY'] = $cfg['key'];
        require_once __CFG::DIR . "plugins/payments/wxpay/WxPay.NativePay.php";
    }

    public function Queryorder($transaction_id) {
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
        WxPayConfig::$_CONFIG = array('appid'=>$this->config['app_appid'], 'appsecret'=>$this->config['app_appsecret'], 'mch_id'=>$this->config['app_mch_id'], 'key'=>$this->config['app_key']);
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($input['title']);
        $inputObj->SetOut_trade_no($input['trade_no']);
        $inputObj->SetTotal_fee($input['amount'] * 100);
        $inputObj->SetNotify_url($this->config['notify_url']);
        $inputObj->SetTrade_type("APP");
        $inputObj->SetProduct_id($input['trade_no']);
        if ($inputObj->GetTrade_type() == "APP") {
            $ret = WxPayApi::unifiedOrder($inputObj);
            K::M('system/logs')->log('payment.wxpay.build.app', array($ret, $inputObj));
            if($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS'){
                $data = array(
                    'appid'     => $ret['appid'],
                    'partnerid'    => $ret['mch_id'],
                    'noncestr' => $ret['nonce_str'],
                    'prepayid' => $ret['prepay_id'],
                    'package' => 'Sign=WXPay',
                    'timestamp' => __TIME
                );
                $data['sign'] = $this->create_sign($data);
                $data['wxpackage'] = $data['package'];
                $data['sign_string'] = $this->sign_string;
                return $data;
            }
        }
        K::$system->msgbox->add($ret['return_msg'], '-301');
        K::M('system/logs')->log('payment.wxpay.build.app', array($ret, $inputObj,$this->config));
        return false;
    }

    public function build_url($input) {
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($input['title']);
        $inputObj->SetOut_trade_no($input['trade_no']);
        $inputObj->SetTotal_fee($input['amount'] * 100);
        $inputObj->SetNotify_url($this->config['notify_url']);
        $inputObj->SetTrade_type("NATIVE");
        $inputObj->SetProduct_id($input['trade_no']);
        if ($inputObj->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($inputObj);
            return $result["code_url"];
        }
        return false;
    }

    public function NotifyProcess($trade, &$msg) {

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
        $WxPayConfig = new WxPayConfig();
        //签名步骤一：按字典序排序参数
        ksort($params);
        $string = $this->params_to_url($params);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$WxPayConfig->KEY;
        $this->sign_string = $string;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    protected function _logs($log)
    {
        $key = 'payment-wxpay-' . date('Ymd');
        K::M('system/logs')->log($key, $log);
    }

}
