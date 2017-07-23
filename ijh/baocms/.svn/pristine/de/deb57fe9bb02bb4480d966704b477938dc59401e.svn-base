<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class weixin {

    public function init($payment) {
       // print_r($payment);die;
        define('WEIXIN_APPID', $payment['app_appid']);
        define('WEIXIN_MCHID', $payment['app_mchid']);
        define('WEIXIN_APPSECRET', $payment['app_appsecret']);
        define('WEIXIN_KEY',$payment['app_appkey']);
        //=======【证书路径设置】=====================================
        /**
         * TODO：设置商户证书路径
         * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，
         * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
         * @var path
         */
        define('WEIXIN_SSLCERT_PATH', '../cert/apiclient_cert.pem');
        define('WEIXIN_SSLKEY_PATH', '../cert/apiclient_key.pem');

        //=======【curl代理设置】===================================
        /**
         * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
         * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
         * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
         * @var unknown_type
         */
        define('WEIXIN_CURL_PROXY_HOST', "0.0.0.0"); //"10.152.18.220";
        define('WEIXIN_CURL_PROXY_PORT', 0); //8080;
        //=======【上报信息配置】===================================
        /**
         * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
         * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
         * 开启错误上报。
         * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
         * @var int
         */
        define('WEIXIN_REPORT_LEVENL', 1);

        require_once "weixin/WxPay.Api.php";
        
        require_once "weixin/WxPay.JsApiPay.php";
        
        require_once "weixin/WxPay.Config.php";
        
        require_once "weixin/WxPay.Data.php";
        
        require_once "weixin/WxPay.Notify.php";
        
    }

    public function getCode($logs, $payment) {
        
        $this->init($payment);
        $config = D('Payment')->select();
        $new_config = array();
        foreach($config as $k => $v){
            if($v['code'] == 'weixin'){
                $new_config = unserialize($v['setting']);
            }
        }
        $WxPayConfig = array('appid'=>$new_config['app_appid'], 'appsecret'=>$new_config['app_appsecret'], 'mch_id'=>$new_config['app_mchid'], 'key'=>$new_config['app_appkey']);
        WxPayConfig::$_CONFIG = $WxPayConfig;
     
        $inputObj = new WxPayUnifiedOrder();
//        $inputObj->SetAppid($WxPayConfig['appid']);
//        //$inputObj->GetAppid($WxPayConfig['appsecret']);
//        $inputObj->SetMch_id($WxPayConfig['mch_id']);
//        //$inputObj->SetMch_id($WxPayConfig['app_appkey']);
        $body = $logs['title'] ? $logs['title'] : '订单号:'.$logs['logs_id'];
        $inputObj->SetBody($body);
        $inputObj->SetOut_trade_no($logs['logs_id']);
        $inputObj->SetTotal_fee($logs['logs_amount']*100);

        if($logs['back_url']){
            $inputObj->SetNotify_url(__HOST__ . U( 'appv2/payment/respond', array('code' => 'wxpay','back_url'=>urlencode($logs['back_url']))));
        }else{
            $inputObj->SetNotify_url(__HOST__ . U( 'appv2/payment/respond', array('code' => 'wxpay')));
        }

        $inputObj->SetTrade_type("APP");
        $inputObj->SetProduct_id($logs['logs_id']);

        //if ($inputObj->GetTrade_type() == "APP") {
        if ($inputObj) {
            $ret = WxPayApi::unifiedOrder($inputObj);
            if($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS'){
                $data = array(
                    'appid'     => $ret['appid'],
                    'partnerid'    => $ret['mch_id'],
                    'noncestr' => $ret['nonce_str'],
                    'prepayid' => $ret['prepay_id'],
                    'package' => 'Sign=WXPay',
                    'timestamp' => time()
                );
                $data['sign'] = $this->create_sign($data);
                $data['wxpackage'] = $data['package'];
                $data['sign_string'] = $this->sign_string;
                $return = array(
                    'status'=>'success',
                    'data'=>$data
                );
                
                return $return;
            }
        }
        $log = array($inputObj, $ret, $data, $result, $new_config, $config, WxPayConfig::$_CONFIG, $WxPayConfig);

        $return = array(
            'status'=>'error',
            'data'=>$ret
        );

        return $return;
	}




    public function respond() {
        

        $xml = file_get_contents("php://input");
        if (empty($xml))
            return false;
        $xml = new SimpleXMLElement($xml);
        if (!$xml)
            return false;
        $data = array();
        foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
        }

        if (empty($data['return_code']) || $data['return_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['result_code']) || $data['result_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['out_trade_no'])){
            return false;
        }
        ksort($data);
        reset($data);
        $payment = D('Payment')->getPayment('weixin');
        /* 检查支付的金额是否相符 */
        if (!D('Payment')->checkMoney($data['out_trade_no'], $data['total_fee'])) {
            return false;
        }

        $sign = array();
        foreach ($data as $key => $val) {
            if ($key != 'sign') {
                $sign[] = $key . '=' . $val;
            }
        }
        $sign[] = 'key=' . $payment['appkey'];
        $signstr = strtoupper(md5(join('&', $sign)));
        if ($signstr != $data['sign']){
           
           
            return false;
        }    
        D('Payment')->logsPaid($data['out_trade_no']);

        return true;
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
        $sign_string = $sign_string . "&key=".WEIXIN_KEY;
        $this->sign_string = $sign_string;
        return strtoupper(md5($sign_string));
    }
}
