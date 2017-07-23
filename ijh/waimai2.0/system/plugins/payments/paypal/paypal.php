<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: alipay.php 5379 2014-05-30 10:17:21Z youyi $
 */

class Payment_Paypal 
{

    //支付网关地址
    //live
    private $gateway = 'https://www.paypal.com/cgi-bin/webscr';
    //sandbox
    //private $gateway = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    private $cacert_url = '';


    //支付接口标识
    private $code      = 'paypal';

    //支付接口配置信息
    private $config = array();
    //订单信息
    private $order = array();
    //发送至支付宝的参数
    private $_parameter = array();   
    
    public function __construct($cfg)
    {
        $this->config = $cfg;
        $this->_parameter = array();
        $this->_parameter['paypal_account'] = $cfg['paypal_account'];
        $this->_parameter['paypal_currency'] = $cfg['paypal_currency'];
        $this->_parameter['return_url'] = $cfg['return_url'];
        $this->_parameter['notify_url'] = $cfg['notify_url'];
        $this->_parameter['show_url'] = $cfg['show_url'];
    }

    public function build_app($params)
    {
        $html = $this->build_form($params);
        return array('html'=>$html);
    }

    public function build_url($params)
    {
        return $this->build_form($params);
    }

    public function build_form($params)
    {      
        $parameter = $this->build_parameter($params);
        $html = '<form id="paypalsubmit" name="paypalsubmit" action="'.$this->gateway.'" method="post">';
        while (list ($key, $val) = each ($parameter)) {
            $html.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
        $html .= "<input type='submit' value='Paypal支付'></form>";        
        $html .= "<script>document.forms['paypalsubmit'].submit();</script>";
        return $html;
    }

    public function return_verify()
    {
        if(!$trade_no = $_GET['trade_no']){
            return false;
        }
        $url = K::M('helper/link')->mklink('trade/payment:redirect', array($trade_no, 'app'), null, 'www');        
        header("Location:".$url);
        exit;
        //return true;
    }


    public function notify_verify()
    {
        if(empty($_POST)) {//判断POST来的数组是否为空
                return false;
        }else if(!$notify = $_POST){
            return false;
        }
        //写日志记录
        $log = "notify_url_log:".$this->_build_query($notify, false, false);
        $this->_logs($log);
        if($notify['receiver_email'] != $this->_parameter['paypal_account']){
            return false;
        }else if ($notify['payment_status'] != 'Completed' && $notify['payment_status'] != 'Pending') {
            return false;
        }else if ($this->_parameter['paypal_currency'] != $notify['mc_currency']) {
            return false;
        }else if($this->notify_validate($notify)){
            return array('code'=>'paypal','trade_no'=>$notify['invoice'], 'pay_trade_no'=>$notify['txn_id'], 'trade_status'=>$notify['trade_status'], 'amount'=>$notify['amount'],'payer_email' => $notify['payer_email']);
        }
        return false;

    }

    public function notify_success($success=true)
    {
        if($success){
            echo "success";exit;
        }else{
            echo "fail";exit;
        }
    }

  
    public function notify_validate($params)
    {
        $req = 'cmd=_notify-validate';
        foreach ($params as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        // post back to PayPal system to validate
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) ."\r\n\r\n";
        $fp = stream_socket_client("tcp://www.paypal.com:80", $errno, $errstr, 15);
        //$fp = stream_socket_client("tcp://www.sandbox.paypal.com:80", $errno, $errstr, 5);
        if ($fp) {
            fputs($fp, $header . $req);
            while (!feof($fp)) {
                $res = fgets($fp, 1024);
                if (strcmp($res, 'VERIFIED') == 0) {
                    fclose($fp);
                    return true;
                } elseif (strcmp($res, 'INVALID') == 0) {
                    fclose($fp);
                    return false;
                }
            }
        }else{
            fclose($fp);
            return false;
        }        
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $params 请求前的参数数组
     * @return 要请求的参数数组
     */
    public function build_parameter($params)
    {
        if(defined('IN_APP')){
            $return_url = K::M('helper/link')->mklink('trade/payment:return', array('paypal', 'app'), array('trade_no'=>$params['trade_no']), 'www');
        }else{
            $return_url= K::M('helper/link')->mklink('trade/payment:return', array('paypal'), array('trade_no'=>$params['trade_no']), 'www');
        }
        $parameter = array(
            'cmd'           => '_xclick',           
            'invoice'           => $params['trade_no'],
            'amount'            => $params['amount'],
            'no_shipping'       => '1',
            'rm'                => '2',
            'charset'           => 'utf-8',
            'item_name'         => $params['title'],
            'no_note'           => $params['body'],
            'business'      => $this->_parameter['paypal_account'],
            'currency_code'     => $this->_parameter['paypal_currency'],
            //'return'            => $this->_parameter['return_url'],
            'return'            => $return_url,
            'notify_url'        => $this->_parameter['notify_url'],
            //'cancel_return'     => $this->_parameter['return_url'],
            'cancel_return'     => $return_url,
        );
        return $parameter;
    }


    protected function _build_query($params, $urlencode=true, $quotation=false)
    {
        $query_string = "";
        while (list ($key, $val) = each ($params)) {
            if($quotation){
                $val = '"'.$val.'"';
            }
            if($urlencode){
                $query_string .= $key."=".urlencode($val)."&";
            }else{
                $query_string .= $key."=".$val."&";  
            }
        }
        $query_string = substr($query_string, 0, count($query_string)-2);
        if(get_magic_quotes_gpc()){$query_string = stripslashes($query_string);}
        return $query_string;
    }


    protected function _logs($log)
    {
        $key = 'payment-paypal-'.date('Ymd');
        K::M('system/logs')->log($key, $log);
    }
}