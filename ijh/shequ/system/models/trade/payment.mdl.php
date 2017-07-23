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
    public function order($code, $order, $from=false,$request)
    {
        $level = 0;
        if(!$oPayApi = $this->loadPayment($code,$request)){
            return false;
        }
        //$level 支付次数，
        if($order['pay_status']){
            K::$system->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }else if($order['order_status']==8){
            K::$system->msgbox->add(L('该订单已经完成'), 212);
            return false;
        }
        if(!$amount = K::M("{$order['from']}/order")->get_payment_amount($order['order_id'], $level)){
            return false;
        }

        if(!$log = K::M('payment/log')->log_by_order_id($order['order_id'], $level)){

            $log = array('uid'=>$order['uid'], 'from'=>'order', 'order_id'=>$order['order_id'], 'pay_level'=>$level, 'payment'=>$code, 'amount'=>$amount); //插入订单记录表

            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);

        }else if($log['payed'] == 1){
            K::$system->msgbox->add('该订单已经支付成功', 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $amount){
            $log['amount'] = $a['amount'] = $amount;
        }
        if($log['from'] != 'order'){
            $a['from'] = 'order';
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $log['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = $site['title'].'订单';
        $params['body'] = $order['addr'].'('.$order['contact'].','.$order['mobile'].')';
        $params['amount'] = $log['amount'];
        // $params['contact'] = $order['contact'];
        // $params['mobile'] = $order['mobile'];
        // $params['addr'] = $order['addr'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            //print_r($oPayApi->build_url($params));die;
            return $oPayApi->build_url($params);
        }
    }


    //收银扫码
    public function cashier($code, $order, $from=false)
    {
        $log_from = 'cashier';
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        //$level 支付次数，
        if($order['pay_status']){
            K::$system->msgbox->add(L('该订单已经支付成功'), 211);
            return false;
        }
        $level = 0;
        if(!$amount = K::M("cashier/order")->get_payment_amount($order['order_id'], $level)){
            return false;
        }

        if(!$log = K::M('payment/log')->log_by_order_id($order['order_id'], $level, $log_from)){
            $log = array('uid'=>$order['uid'], 'from'=>$log_from, 'order_id'=>$order['order_id'], 'pay_level'=>$level, 'payment'=>$code, 'amount'=>$amount); //插入订单记录表

            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);

        }else if($log['payed'] == 1){
            $this->msgbox->add('该订单已经支付成功', 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $amount){
            $log['amount'] = $a['amount'] = $amount;
        }
        if($log['from'] != $log_from){
            $a['from'] = $log_from;
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $log['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $params['title'] = $order['title'].'收银';
        $params['body'] = $order['body'];
        $params['amount'] = $log['amount'];
        $msg = '';
        if($from == 'saoma'){
            $params['auth_code'] = $order['auth_code'];
            $res = $oPayApi->codepay($params, $msg);
            $this->msgbox->add($msg, 300);
            return $res;
        }else{
            return $oPayApi->qrcodepay($params);
        }
    }

    public function payed_order($log, $trade)
    {
        if($log['order_id']){
            if(K::M('order/order')->set_payed($log, $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }
    public function money($uid, $code, $amount, $from=false)
    {
        if(!$uid = (int)$uid){
            return false;
        }else if(!$member = K::M('member/member')->detail($uid)){
            return false;
        }else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $log = array('uid'=>$uid,'amount'=>$amount,'payment'=>$code,'from'=>'money');
        if(!$log_id = K::M('payment/log')->create($log, true)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);
        $site = K::$system->config->get('site');
        $params = array();
        $params['title'] = $site['title'].'-充值余额';
        $params['body'] = '会员:'.$member['nickname'].'('.$uid.')';
        $params['amount'] = $amount;
        $params['trade_no'] = $log['trade_no'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else{
            //return $oPayApi->build_url($params);
            return array('url'=>$oPayApi->build_url($params),'trade_no'=>$log['trade_no']);
        }
    }

    public function payed_money($log, $trade)
    {
        $package = K::M('member/money')->package();
        if($smoney = $package[(int)$log['amount']]){
            $money = (float)$log['amount'] + (float)$smoney;
            $intro = "在线充值￥{$log['amount']},送￥{$smoney}";
        }else{
            $money = (float)$log['amount'];
            $intro = "在线充值￥{$log['amount']}";
        }
        return K::M('member/money')->update($log['uid'], $money, $intro);
    }

    public function coin($uid, $code, $amount, $from=false)
    { //夺宝币充值
        if(!$uid = (int)$uid){
            return false;
        }else if(!$member = K::M('member/member')->detail($uid)){
            return false;
        }else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        $log = array('uid'=>$uid,'amount'=>$amount,'payment'=>$code,'from'=>'coin');
        if(!$log_id = K::M('payment/log')->create($log, true)){
            return false;
        }
        $log = K::M('payment/log')->detail($log_id);
        $site = K::$system->config->get('site');
        $params = array();
        $params['title'] = $site['title'].'-充值夺宝币';
        $params['body'] = '会员:'.$member['nickname'].'('.$uid.')';
        $params['amount'] = $amount;
        $params['trade_no'] = $log['trade_no'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else{
            //return $oPayApi->build_url($params);
            return array('url'=>$oPayApi->build_url($params),'trade_no'=>$log['trade_no']);
        }
    }


    public function payed_coin($log, $trade)
    {
        $package = K::M('member/member')->getRecharge();
        if($smoney = $package[(int)$log['amount']]){
            $money = (int)$log['amount'] + (int)$smoney;
            $intro = "在线充值{$log['amount']}夺宝币,送{$smoney}夺宝币";
        }else{
            $money = (int)$log['amount'];
            $intro = "在线充值{$log['amount']}夺宝币";
        }
        return K::M('member/member')->update_coin($log['uid'], $money, $intro);
    }

    public function yzbill($code, $bill, $from=false)
    {
        if($bill['pay_status'] == 1){
            $this->msgbox->add('账单已经缴费成功', 211);
            return false;
        }else if(($amount = (float)$bill['total_price']) <= 0){
            K::M('system/logs')->log('mdl.trade.payment.yzbill', array($amount, $bill, $code, $from));
            $this->msgbox->add('账单无需缴费', 212);
            return false;
        }else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if(!$log = K::M('payment/log')->find(array('order_id'=>$bill['bill_id'], 'from'=>'yzbill'))){
            $log = array('uid'=>$bill['uid'], 'from'=>'yzbill', 'order_id'=>$bill['bill_id'],  'payment'=>$code, 'amount'=>$amount); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }else if($log['payed'] == 1){
            $this->msgbox->add('该订单已经支付成功', 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $amount){
            $log['amount'] = $a['amount'] = $amount;
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $log['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = $site['title'].'订单';
        $params['body'] = '物业帐单:'.$bill['bill_sn'];
        $params['amount'] = $log['amount'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            return $oPayApi->build_url($params);
        }
    }
    public function payed_yzbill($log, $trade)
    {
        
        if($log['order_id']){
            if(K::M('xiaoqu/bill')->set_payed($log, $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }

    //夺宝支付
    public function cloud($code, $order, $from=false)
    {
        if($order['order_status'] == 1){
            $this->msgbox->add('该订单已支付', 211);
            return false;
        }else if(0>=$amount = ($order['num'] - $order['use_coin'])){
            $this->msgbox->add('该订单不需要支付', 212);
            return false;
        }else if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if(!$log = K::M('payment/log')->find(array('order_id'=>$order['order_id'], 'from'=>'cloud'))){
            $log = array('uid'=>$order['uid'], 'from'=>'cloud', 'order_id'=>$order['order_id'],  'payment'=>$code, 'amount'=>$amount); //插入订单记录表
            if(!$log_id = K::M('payment/log')->create($log)){
                return false;
            }
            $log = K::M('payment/log')->detail($log_id);
        }else if($log['payed'] == 1){
            $this->msgbox->add('该订单已经支付成功', 211);
            return false;
        }
        $a = array();
        if($log['amount'] != $amount){
            $log['amount'] = $a['amount'] = $amount;
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            K::M('payment/log')->update($log['log_id'], $a,  true);
        }
        $params = array();
        $params['order_id'] = $log['order_id'];
        $params['trade_no'] = $log['trade_no'];
        $site = K::$system->config->get('site');
        $params['title'] = $site['title'].'订单';
        $params['body'] = '云购支付';
        $params['amount'] = $log['amount'];
        if($from == 'APP'){
            return $oPayApi->build_app($params);
        }else if($from){
            return $oPayApi->build_form($params);
        }else{
            return $oPayApi->build_url($params);
        }
    }
    public function payed_cloud($log, $trade)
    {
        if($log['order_id']){
            if(K::M('cloud/order')->set_payed($log, $trade)){
                if($log['uid']){
                    K::M('member/member')->update_total_money($log['uid'], $log['amount']);
                }
                return true;
            }
        }
        return false;
    }

    public function payed_cashier($log, $trade, $code = 'alipay')
    {
        if($log['order_id']){
            if(K::M('cashier/order')->set_payed($log, $trade, $code)){
                if($log['uid']){
                    K::M('shop/shop')->update_money($log['uid'], $log['amount'], '二维码收款'.$code);
                }
                return true;
            }
        }
        return false;
    }

    public function loadPayment($code,$request)
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
            if (defined('IN_WEIXIN') && $code == 'wxpay') {
                $file = __CFG::DIR."plugins/payments/{$code}/jsapi.php";
                include($file);
                $clsName = "Weixin_".ucfirst('jsapi');
            }else{
                include($file);
                $clsName = "Payment_".ucfirst($code);
            }
            $config = $payment['config'];
            $site = K::$system->config->get('site');
            
            
            if(__APP__ == 'pchome'){
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'pchome');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
            }else{
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null,'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null,'www');
            }
            $config['app_return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
            $config['app_notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
            $config['show_url'] = $site['siteurl'];
            $_PayApiObj[$code] = new $clsName($config);
        }
        return $_PayApiObj[$code];
    }
}