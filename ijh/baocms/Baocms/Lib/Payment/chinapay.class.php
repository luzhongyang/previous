<?php

require_once 'chinapaysdk/acp_service.php';

class chinapay
{

//    private $pay_url = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
    private $pay_url = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';

    //gov 环境
    // 前台请求地址
//    const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
//    // 前台通知地址 (商户自行配置通知地址)
//    const SDK_FRONT_NOTIFY_URL = 'http://localhost:8085/upacp_demo_b2c/demo/api_01_gateway/FrontReceive.php';
//    // 后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)
//    const SDK_BACK_NOTIFY_URL = 'http://222.222.222.222/upacp_demo_b2c/demo/api_01_gateway/BackReceive.php';
//    //单笔查询请求地址
//    const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';

    //test 环境
    // 前台请求地址
//    private $SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
    private $SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';

    // 前台通知地址 (商户自行配置通知地址)
    private  $SDK_FRONT_NOTIFY_URL = 'http://www.baocms.cn/upacp_demo_b2c/demo/api_01_gateway/FrontReceive.php';
    // 后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)
    private $SDK_BACK_NOTIFY_URL = 'http://www.baocms.cn/upacp_demo_b2c/demo/api_01_gateway/BackReceive.php';
    //单笔查询请求地址
    //private $SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';

    /**
     * 生成支付代码
     * @param   array $logs 订单信息
     * @param   array $payment 支付方式信息
     */

    function getCode($logs, $payment)
    {

        $sendMap['MerId'] = $payment['chinapay_account']; //商户ID
        $sendMap['MerOrderNo'] = pad($logs['logs_id'], 'l', 16, 0);//订单ID 要补齐到16位
        $sendMap['OrderAmt'] = (int)($logs['logs_amount'] * 100);//订单金额
        $sendMap['TranDate'] = date('Ymd', NOW_TIME); //交易日期
        $sendMap['TranTime'] = date('His', NOW_TIME); //交易时间
        $sendMap['TranType'] = '0001';

        $sendMap['BusiType'] = '0001'; //固定值 业务类型
        $sendMap['Version'] = '20140728';//支付接口版本号
        $sendMap['CurryNo'] = 'CNY';//支付币种
        $sendMap['AccessType'] = '0';
        $sendMap['AcqCode'] = '000000000000014';
        $sendMap['MerPageUrl'] = __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay', 'respond' => 1)); // 前台通知地址
        $sendMap['MerBgUrl'] = __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay'));//后台通知地址

        $sendMap['MerResv'] = 'baocms';//私有域

        //新版银联参数
        $sendMap = array(

            //以下信息非特殊情况不需要改动
            'version' => '5.0.0',                 //版本号
            'encoding' => 'utf-8',                  //编码方式
            'txnType' => '01',                      //交易类型
            'txnSubType' => '01',                  //交易子类
            'bizType' => '000201',                  //业务类型
//            'frontUrl' => $this->SDK_FRONT_NOTIFY_URL,  //前台通知地址  更新成本地测试,  __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay', 'respond' => 1));
//            'backUrl' => $this->SDK_BACK_NOTIFY_URL,      //后台通知地址  __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay'));
            'frontUrl' => __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay', 'respond' => 1)) ,  //前台通知地址  更新成本地测试,  __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay', 'respond' => 1));
            'backUrl' => __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay')) ,      //后台通知地址  __HOST__ . U('pchome/payment/respond', array('code' => 'chinapay'));
            'signMethod' => '01',                  //签名方法
            'channelType' => '08',                  //渠道类型，07-PC，08-手机
            'accessType' => '0',                  //接入类型
            'currencyCode' => '156',              //交易币种，境内商户固定156

            //TODO 以下信息需要填写
            'merId' => $_POST["merId"],        //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'merId' => 777290058140825,//test

            'orderId' => pad($logs['logs_id'], 'l', 16, 0),    //商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => date("YmdHis"),    //订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' =>  (int)($logs['logs_amount'] * 100),    //交易金额，单位分，此处默认取demo演示页面传递的参数
// 		'reqReserved' =>'透传信息',        //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

            //TODO 其他特殊用法请查看 special_use_purchase.php
        );

//        $file = "/data/htdocs/www_baocms_cn/public_html/Baocms/Lib/Payment/chinapaysdk/certs/acp_test_enc.cer";
//        $is_have = file_exists($file);
//        var_dump($is_have);
//        $file = "/data/htdocs/www_baocms_cn/public_html/Baocms/Lib/Payment/chinapaysdk/certs/acp_test_sign.pfx";
//        $is_have = file_exists($file);
//        var_dump($is_have);

        AcpService::sign ( $sendMap );

        //var_dump($sendMap);
        $html = '<form name="payment" action="' . $this->SDK_FRONT_TRANS_URL . '" method="POST">';
        
        foreach ($sendMap as $k => $v) {
            $html .= "
            <input type='hidden' name = '" . $k . "' value ='" . $v . "'/>";
        }
    
        $html .= '<input type="submit" class="payment" value="立刻支付"/></form>';    
        return $html;
    }

    /**
     * 响应操作
     */
    function respond()
    {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $data) {
                $_GET[$key] = $data;
            }
        }

        if (isset ( $_POST ['signature'] )) {


            $validate_status = AcpService::validate ( $_POST ) ? 'success' : 'failure';


            $orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
            $respCode = $_POST ['respCode']; //判断respCode=00或A6即可认为交易成功

            if('success' == $validate_status){
                $payment = D('Payment')->getPayment($_GET['code']);
                $logs_id = $_POST['orderId'];
                D('Payment')->logsPaid($logs_id);
                return true;
            }

        }


        return false;
    }

}
