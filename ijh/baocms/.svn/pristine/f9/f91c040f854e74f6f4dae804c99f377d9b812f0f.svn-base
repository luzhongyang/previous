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
        define('WEIXIN_APPID', $payment['appid']);
        define('WEIXIN_MCHID', $payment['mchid']);
        define('WEIXIN_APPSECRET', $payment['appsecret']);
        define('WEIXIN_KEY',$payment['appkey']);
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
        
        //require_once "weixin/WxPay.Notify.php";
        
    }

    public function getCode($logs, $payment) {
        if(!is_weixin()){
            //不在微信中打开直接使用NATIVE,扫码支付
            return $this->build_qrcode($logs, $payment);
        }
        $this->init($payment);
        //①、获取用户openid
        $tools = new JsApiPay();
       
        $openId = $tools->GetOpenid();

       //echo $openId;die;
        $input = new WxPayUnifiedOrder();
        $input->SetBody($logs['subject']);
        $input->SetAttach($logs['subject']);
        $input->SetOut_trade_no($logs['logs_id']);
        $logs['logs_amount'] = $logs['logs_amount'] *100;
        $input->SetTotal_fee("{$logs['logs_amount']}");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($logs['subject']);
        if($logs['back_url']){
            $input->SetNotify_url(__HOST__ . U( 'mobile/payment/respond', array('code' => 'weixin','back_url'=>urlencode($logs['back_url']))));
        }else{
            $input->SetNotify_url(__HOST__ . U( 'mobile/payment/respond', array('code' => 'weixin')));
        }
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        //var_dump($order);die;
        //   echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';

        $jsApiParameters = $tools->GetJsApiParameters($order);
        $str = '<script>function jsApiCall()
    {
        WeixinJSBridge.invoke(
            \'getBrandWCPayRequest\',
            '.$jsApiParameters.',
            function(res){
                            if(res.err_msg ==\'get_brand_wcpay_request:ok\'){ 
                                location.href="'.U('mobile/payment/yes',array('log_id'=>$logs['logs_id'])).'";
                            }
            }
        );
    }

    function callpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener(\'WeixinJSBridgeReady\', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent(\'WeixinJSBridgeReady\', jsApiCall); 
                document.attachEvent(\'onWeixinJSBridgeReady\', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }</script>
        
<button   class="payment" type="button" onclick="callpay()" >立即支付</button>


        ';
        
        baolog('wxpay.mobile.getcode', array($str, $logs, $payment));
        return $str;
    }


    public function build_qrcode($logs, $payment)
    {
        $this->init($payment);
        $inputObj = new WxPayUnifiedOrder();
        $inputObj->SetBody($logs['subject']);
        $inputObj->SetAttach($logs['subject']);
        $inputObj->SetOut_trade_no($logs['logs_id']);
        $inputObj->SetTotal_fee($logs['logs_amount'] *100);
        $inputObj->SetProduct_id($logs['logs_id']);
        if($logs['back_url']){
            $inputObj->SetNotify_url(__HOST__ . U( 'mobile/payment/respond', array('code' => 'weixin','back_url'=>urlencode($logs['back_url']))));
        }else{
            $inputObj->SetNotify_url(__HOST__ . U( 'mobile/payment/respond', array('code' => 'weixin')));
        }
        $inputObj->SetTrade_type("NATIVE");
        $inputObj->SetOut_trade_no($logs['logs_id']);
        if ($inputObj->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($inputObj);
            if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
                return array('trade_no'=>$logs['trade_no'], 'qrcode'=>$result["code_url"], 'amount'=>$log['logs_amount'],'prepay_id'=>$result['prepay_id']);
            }
            baolog('payment-wxpay-uniniedOrder.error', array($logs, $inputObj, $result, $payment));
        }
        return false;
    }


    public function respond()
    {
        $xmlstr = file_get_contents("php://input");
        baolog('payment.weixin.mobile.respond'.date('Ymd'), array($xmlstr));
        if (empty($xmlstr)){
            return false;
        }elseif (!$xml = new SimpleXMLElement($xmlstr)){
            return false;
        }
        $data = array();
        foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
        }
        if (empty($data['return_code']) || $data['return_code'] != 'SUCCESS') {
            return false;
        }elseif (empty($data['result_code']) || $data['result_code'] != 'SUCCESS') {
            return false;
        }elseif (empty($data['out_trade_no'])){
            return false;
        }elseif (!D('Payment')->checkMoney($data['out_trade_no'], $data['total_fee'])) {
            /* 检查支付的金额是否相符 */
            return false;
        }
        $payment = D('Payment')->getPayment('weixin');
        $this->init($payment);
        $mysign = $this->create_sign($data);
        baolog('payment.weixin.mobile.respond'.date('Ymd'), array("mysign={$mysign}&sign={$data['sign']}", $this->sign_string, $xmlstr));
        if ($mysign != $data['sign']){
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
