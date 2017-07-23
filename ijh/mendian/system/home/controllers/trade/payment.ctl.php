<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
class Ctl_Trade_Payment extends Ctl
{

    public function __construct(&$system)
    {
        parent::__construct($system);
        $uri = $this->request['uri'];
        if(preg_match('/(return|notify)-(\w+)(-(app))?/i', $uri, $match)){
            $system->request['act'] = $match[1] . '_verify';
            $system->request['args'] = array($match[2], $match[4]);
        }
    }

    public function return_verify($code, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        if($obj = K::M('trade/payment')->loadPayment($code)){
            if($trade = $obj->return_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add('支付的订单不存在', 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    K::M('trade/payment')->payed_order($log, $trade);
                }else{
                    $this->msgbox->add('该订单已经支付过了', 213);
                }
            }else{
                $this->msgbox->add('支付验证签名失败', 215);
            }
            if(!$rebackurl = $this->GP('rebackurl')){
                $rebackurl = $this->cookie->get('pay_rebackurl');
            }
            if(empty($rebackurl)){
                $rebackurl = K::M('helper/link')->mklink('trade/payment:success', array($order_id), array(), 'www');
            }
            if(defined('IN_WEIXIN') && $code == 'alipay'){
                $this->msgbox->set_js('window.top.location.href="' . $rebackurl . '";');
            }else{
                header("Location:{$rebackurl}");
                exit;
            }
        }
    }

    public function notify_verify($code, $from = null)
    {
        if($from && strtolower($from) == 'app' && !defined('IN_APP')){
            define('IN_APP', 'api');
        }
        $success = false;
        if($obj = K::M('trade/payment')->loadPayment($code)){
            if($trade = $obj->notify_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add('支付的订单不存在', 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if(K::M('trade/payment')->payed_order($log, $trade)){
                        $success = true;
                    }
                }
            }
            $obj->notify_success($success);
        }
    }

    public function order($code, $order_id)
    {
        $this->cookie->delete('pay_rebackurl');
        if(!$rebackurl = $this->GP('rebackurl')){
            $rebackurl = K::M('helper/link')->mklink('trade/payment:success', array($order_id), array(), 'www');
        }
        $this->cookie->set('pay_rebackurl', $rebackurl);
        if(!$order_id = (int)$order_id){
            $this->error(404);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 214);
        }else if($order['pay_status'] == 1){
            $this->msgbox->add('该订单已经支付', 216);
        }else if($order['amount'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成无需支付', 218);
        }else if(empty($order['online_pay'])){
            $this->msgbox->add('订单无需在线支付', 219);
        }else if($trade = K::M('trade/payment')->order($code, $order)){
            if($code == 'money'){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add('获取支付流水失败', 223);
                }else if($log['payed']){
                    $this->msgbox->add('单号已经支付过了', 224);
                }else if(!$member = K::M('member/member')->detail($order['uid'])){
                    $this->msgbox->add('该订单不支持余额支付', 221);
                }else if(($amount = (float)$trade['amount']) <=0 ){
                    $this->msgbox->add('支付金额不合法', 222);
                }else if($amount != $log['amount']){
                    $this->msgbox->add('支付金额不合法', 222);
                }else if($member['money'] < $trade['amount']){
                    $this->msgbox->add('账户余额不足！', 223);
                }else if(K::M('member/member')->update_money($this->uid, -$amount, '支付订单(ID:' . $order_id . ')')){
                    if(K::M('payment/log')->set_payed($trade['trade_no'])){
                        if($res = K::M('trade/payment')->payed_order($log, $trade)){
                            if($order['wx_openid']){
                                $wx_config = $this->system->config->get('wx_config');
                                $config = $this->system->config->get('site');
                                $a = array('title' => '恭喜您！订单支付成功！！', 'items' => array('OrderSn' => $order_id, 'OrderStatus' => '订单支付成功'), 'remark' => '您的订单于 ' . date('Y-m-d H:i:s', __TIME) . ' 支付成功');
                                K::M('weixin/wechat')->admin_wechat_client()->sendTempMsg($order['wx_openid'], $wx_config['order_id'], $rebackurl, $a);
                            }
                        }
                    }
                }
                if($rebackurl = $this->GP('rebackurl')){
                    header("Location:{$rebackurl}");
                }else{
                    $this->redirect($trade['trade_no']);
                }
            }else{
                $url = is_array($trade) ? $trade['payurl'] : $trade;
                if(!defined('IN_WEIXIN') && ($code == 'wxpay')){
                    $qrurl = $this->mklink('trade/payment:wxqrcode', array(), array('codeurl' => $url, 'amount' => $order['amount'], 'order_id' => $order['order_id']));
                    header("Location:{$qrurl}");
                }else if(defined('IN_WEIXIN') && ($code == 'alipay')){
                    $this->pagedata['payurl'] = $url;
                    $this->tmpl = 'trade/payment/wxalipay.html';
                }else{
                    header("Location:{$url}");
                }
            }
        }else{
            $this->msgbox->add('请求支付失败', 231);
        }
        $this->msgbox->set_data('forward', $rebackurl);
    }

    public function wxqrcode()
    {
        if(!$codeurl = $this->GP('codeurl')){
            exit('params error');
        }
        if(!$amount = $this->GP('amount')){
            exit('params error');
        }
        if(!$order_id = $this->GP('order_id')){
            exit('params error');
        }
        $amount = sprintf("%.2f", $amount);
        $this->pagedata['codeurl'] = $codeurl;
        $this->pagedata['amount'] = $amount;
        $this->pagedata['order_id'] = $order_id;
        $this->tmpl = 'home/trade/payment/wxqrcode.html';
    }

    public function wxjspay($order_id)
    {
        if(!$order_id = (int)$order_id){
            $this->error(404);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在或已经删除', 211);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 214);
        }else if($order['pay_status'] == 1){
            $this->msgbox->add('该订单已经支付', 216);
        }else if($order['amount'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成无需支付', 218);
        }else if(empty($order['online_pay'])){
            $this->msgbox->add('订单无需在线支付', 219);
        }else{
            $order['wx_openid'] = $this->get_wx_openid();
            if(!$trade = K::M('trade/payment')->order('wxpay', $order, 'JSAPI')){
                $this->msgbox->add('创建支付请求失败', 223);
            }else{
                if($rebackurl = $this->GP('rebackurl')){
                    $this->pagedata['rebackurl'] = $rebackurl;
                }
                $this->pagedata['jsApiParameters'] = $trade['jsApiParameters'];
                $this->pagedata['trade'] = $trade;
                $this->pagedata['order'] = $order;
                $this->tmpl = 'home/trade/payment/wxjspay.html';
            }
        }
    }

    protected function gorebackurl($status='SUCCESS', $rebackurl=null)
    {
        if(empty($rebackurl) && ($rebackurl = $this->cookie->get('pay_rebackurl'))){
            
        }
    }

    public function success($order_id)
    {
        $this->tmpl = 'home/trade/payment/success.html';
    }

    public function redirect($trade_no)
    {
        $url = K::M('helper/link')->mklink('ucenter/money:index', null, null, 'base');
        if($log = K::M('payment/log')->log_by_no($trade_no)){
            if($log['from'] == 'order'){
                $url = K::M('helper/link')->mklink('ucenter/order:detail', array($log['order_id']), array(), 'base');
            }
        }
        header("Location:{$url}");
        exit;
    }

}
