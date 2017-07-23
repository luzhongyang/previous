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

    public function order($code, $order, $from = false)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        //判断订单来源类型,拼团
        $is_write_log = 0;
        if('pintuan' == $order['from'] || 'weidian_pintuan' == $order['from'] ){
            $arr_p_order = K::M('pintuan/order')->find(array('order_id' => $order['order_id']));
            if(1 == $arr_p_order['is_money_pre']){
                if(0 == $arr_p_order['money_paid']){
                    //1.预付款
                    $order['amount'] = $arr_p_order['money_need_pay'];
                    $is_write_log = 1;
                }
                elseif($arr_p_order['money_need_pay'] == $arr_p_order['money_paid']){
                    //2.付尾款
                    $order['amount'] = abs($order['amount'] - $arr_p_order['money_paid']);
                    $is_write_log = 1;
                }
            }
           
        }

        if((!$log = K::M('payment/log')->log_by_order_id($order['order_id'])) || 1 == $is_write_log){
            
            $log = array('uid' => $order['uid'], 'from' => $order['from'], 'order_id' => $order['order_id'], 'trade_no' => $order['order_id'], 'payment' => $code, 'amount' => $order['amount']); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }
        if($log['payed'] == 1){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }

        $a = array();
        if($log['amount'] != $order['amount']){
            $a['amount'] = $order['amount'];
        }

        if($log['from'] != 'order'){
            $a['from'] = 'order';
        }

        if($log['payment'] != $code){
            $a['payment'] = $code;
        }

        if($a){
            K::M('payment/log')->update($log['log_id'], $a, true);
        }

        $params = array();
        $params['order_id'] = $order['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $order['addr'] . '(' . $order['contact'] . ',' . $order['mobile'] . ')';
        $params['amount'] = $order['amount'];
        $params['contact'] = $order['contact'];
        $params['mobile'] = $order['mobile'];
        $params['addr'] = $order['addr'];
        $params['code'] = $code;

        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }
        else if($from){
            return $oPayApi->build_form($params);
        }
        else{
            return $oPayApi->build_url($params);
        }
    }

    public function paotui($code, $paotui, $from = false, $level = null)
    {
        if($paotui['pay_status']){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }
        else if($paotui['order_status'] == 8){
            $this->msgbox->add(L('该订单已经完成'), 212);
            return false;
        }
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if(!$log = K::M('payment/log')->log_by_order_id($paotui['order_id'])){
            $log = array('uid' => $paotui['uid'], 'from' => 'paotui', 'order_id' => $paotui['order_id'], 'trade_no' => $paotui['order_id'], 'payment' => $code, 'amount' => $paotui['amount']); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }
        if($log['payed']){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $paotui['amount']){
            $a['amount'] = $paotui['amount'];
        }
        if($log['from'] != 'paotui'){
            $a['from'] = 'paotui';
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a, true);
        }
        $params = array();
        $params['order_id'] = $paotui['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $paotui['addr'] . '(' . $paotui['contact'] . ',' . $paotui['mobile'] . ')';
        $params['amount'] = $paotui['amount'];
        $params['contact'] = $paotui['contact'];
        $params['mobile'] = $paotui['mobile'];
        $params['addr'] = $paotui['addr'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }
        else if($from){
            return $oPayApi->build_form($params);
        }
        else{
            return $oPayApi->build_url($params);
        }
    }

    public function payed_order($log, $trade)
    {
        if($log['order_id']){
            if(K::M('order/order')->set_payed($log['order_id'], $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }

    public function reward($code, $order, $amount, $from = false)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $log = array('uid' => $order['uid'], 'from' => 'reward', 'order_id' => $order['order_id'], 'trade_no' => $order['order_id'], 'payment' => $code, 'amount' => $amount); //插入订单记录表
        if(!$log_id = K::M('payment/log')->create($log)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);

        $params = array();
        $params['order_id'] = $order['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $order['addr'] . '(' . $order['contact'] . ',' . $order['mobile'] . ')';
        $params['amount'] = $amount;
        $params['contact'] = $order['contact'];
        $params['mobile'] = $order['mobile'];
        $params['addr'] = $order['addr'];
        $params['code'] = $code;
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }
        else if($from){
            return $oPayApi->build_form($params);
        }
        else{
            return $oPayApi->build_url($params);
        }
    }

    public function payed_reward($log, $trade)
    {
        if($log['order_id']){
            if(K::M('order/order')->set_reward_payed($log, $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }

    // 在线充值
    public function money($uid, $code, $amount, $from = false)
    {
        if(!$uid = (int) $uid){
            return false;
        }
        else if(!$member = K::M('member/member')->detail($uid)){
            return false;
        }
        else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $log = array('uid' => $uid, 'amount' => $amount, 'payment' => $code, 'from' => 'money');
        if(!$log_id = K::M('payment/log')->create($log, true)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);
        $site = K::$system->config->get('site');
        $params = array();
        $params['title'] = sprintf(L('%s-充值余额'), $site['title']);
        $params['body'] = sprintf(L('会员:%s(%s)'), $member['nickname'], $uid);
        $params['amount'] = $amount;
        $params['trade_no'] = $log['trade_no'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }
        else{
            //return $oPayApi->build_url($params);
            return array('url' => $oPayApi->build_url($params), 'trade_no' => $log['trade_no']);
        }
    }

    public function payed_money($log, $trade)
    {
        $package = K::M('member/money')->package();
        $amount = $trade['amount'] ? $trade['amount'] : $log['amount'];
        $kk = (int) ($amount * 100);
        foreach($package as $k => $v){
            if($kk == $k * 100){
                $smoney = $v;
                break;
            }
        }
        if($smoney){
            $money = (float) $amount + (float) $smoney;
            $intro = sprintf(L('在线充值￥%s,送￥%s'), $amount, $smoney);
        }
        else{
            $money = (float) $amount;
            $intro = sprintf(L('在线充值￥%s'), $amount);
        }
        return K::M('member/money')->update($log['uid'], $money, $intro);
    }

    public function loadPayment($code)
    {
        static $_PayApiObj = array();
        if(!is_object($_PayApiObj[$code])){
            $file = __CFG::DIR . "plugins/payments/{$code}/{$code}.php";
            if(!file_exists($file)){
                $this->msgbox->add(L('您选择的支付接口不存在'), 311);
                return false;
            }
            else if(!$payment = K::M('payment/payment')->payment($code)){
                $this->msgbox->add(L('您选择的支付接口不存在'), 312);
                return false;
            }
            else if(empty($payment['status'])){
                $this->msgbox->add(L('您选择的支付接口不可用'), 313);
                return false;
            }
            if(defined('IN_WEIXIN') && $code == 'wxpay'){
                $file = __CFG::DIR . "plugins/payments/{$code}/jsapi.php";
                include($file);
                $clsName = "Weixin_" . ucfirst('jsapi');
            }
            else{
                include($file);
                $clsName = "Payment_" . ucfirst($code);
            }
            $config = $payment['config'];
            $site = K::$system->config->get('site');
            if(/* $code == 'wxpay' && */defined('IN_APP')){
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
            }
            else{
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
            }
            $config['show_url'] = $site['siteurl'];
            $_PayApiObj[$code] = new $clsName($config);
        }
        return $_PayApiObj[$code];
    }

    public function mall($code, $order, $from = false)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if(!$log = K::M('payment/log')->log_by_order_id($order['order_id'])){
            $log = array('uid' => $order['uid'], 'from' => 'mall', 'order_id' => $order['order_id'], 'trade_no' => $order['order_id'], 'payment' => $code, 'amount' => $order['amount']); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }
        if($log['payed'] == 1){
            $this->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }

        $a = array();
        if($log['amount'] != $order['amount']){
            $a['amount'] = $order['amount'];
        }

        if($log['from'] != 'order'){
            $a['from'] = 'order';
        }

        if($log['payment'] != $code){
            $a['payment'] = $code;
        }

        if($a){
            K::M('payment/log')->update($log['log_id'], $a, true);
        }

        $params = array();
        $params['order_id'] = $order['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = sprintf(L('%s订单'), $site['title']);
        $params['body'] = $order['addr'] . '(' . $order['contact'] . ',' . $order['mobile'] . ')';
        $params['amount'] = $order['amount'];
        $params['contact'] = $order['contact'];
        $params['mobile'] = $order['mobile'];
        $params['addr'] = $order['addr'];

        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }
        else if($from){
            return $oPayApi->build_form($params);
        }
        else{
            return $oPayApi->build_url($params);
        }
    }

}
