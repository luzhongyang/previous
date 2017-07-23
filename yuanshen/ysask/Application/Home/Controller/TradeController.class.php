<?php

/**
 * 前台交易
 */
namespace Home\Controller;
use Common\Controller\BaseController;

class TradeController extends BaseController{
	/**
	 * [验证支付接口]
	 * @param  [type] $code    [支付方式]
	 * @return [type]          [description]
	 */
	public function loadPayment($code)
    {
        static $_PayApiObj = array();
        if(!is_object($_PayApiObj)){
            $file = SITE_PATH . 'Include/' ."ThinkPHP/Library/Vendor/".ucfirst($code)."/{$code}.php";
            if(!file_exists($file)){
                $this->error('您选择的支付接口不存在');
            }else if(!$payment = D('Payment')->payment($code)){
                $this->error('您选择的支付接口不存在');
            }else if(empty($payment['status'])){
                $this->error('您选择的支付接口不可用');
            }

            if($code = 'alipay') {
            	if($payment['config']) {
        			$alipay_config = unserialize($payment['config']);
        			$alipay_config['return_url'] = U('Api/Payment/alipay_return_url');
                	$alipay_config['notify_url'] = U('Api/Payment/alipay_notify_url');
            	}
            	$_PayApiObj = new \Vendor\Alipay\AlipaySubmit($alipay_config);
            }else if($code = 'wxpay') {

            }
        }
        return $_PayApiObj;
    }

	/**
	 * [金币充值执行]
	 * @param  [type]  $uid    [用户user_id]
	 * @param  [type]  $code   [支付方式]
	 * @param  [type]  $amount [充值金额]
	 * @param  boolean $from   [description]
	 * @return [type]          [description]
	 */
	public function money_pay($uid, $code, $amount)
    {
        if(!$member = D('User')->find($uid)) {
            $this->error('用户信息不存在');
        }else if(!$oPayApi = $this->loadPayment($code)) {
        	$this->error('支付接口对象不存在');
        }
        $log = array(
            'user_id'   => $uid,
            'money'      => $amount,
            'payment'   => $code,
            'type'      => 'money',
            'trade_no'  => D('Paymentlog')->create_trade_no()
        );
        if(!$log_obj = D('Paymentlog')->create($log)) {
        	return false;
        }else if(!$log_id = D('Paymentlog')->add($log_obj)) {
        	return false;
        }

        $log = D('Paymentlog')->find($log_id);
        //$site = get_cfg('site','site_title');
        $site['site'] = '源神CMS';
        $site['site_title'] = '源神CMS系统';
        $data = array();
        $out_trade_no = $log['trade_no'];
        $subject = $site['site_title'].'-充值金币';
        $body = '用户:'.$member['username'].'('.$uid.')';
		$data = array(
			'partner'			=> $oPayApi->alipay_config['partner'],
			'seller_id'			=> $oPayApi->alipay_config['seller_id'],
			'key'				=> $oPayApi->alipay_config['key'],
			'notify_url' 		=> $oPayApi->alipay_config['notify_url'],
			'return_url' 		=> $oPayApi->alipay_config['return_url'],
			'sign_type'     	=> $oPayApi->alipay_config['sign_type'],
			'input_charset'		=> $oPayApi->alipay_config['input_charset'],
			'cacert'    		=> $oPayApi->alipay_config['cacert'],
			'transport'     	=> $oPayApi->alipay_config['transport'],
			'payment_type'  	=> $oPayApi->alipay_config['payment_type'],
			'service' 			=> $oPayApi->alipay_config['service'], //接口名称
			'anti_phishing_key' => $oPayApi->alipay_config['anti_phishing_key'],
			'exter_invoke_ip' 	=> $oPayApi->alipay_config['exter_invoke_ip'],
			"out_trade_no"		=> $out_trade_no,
			"subject"			=> 'recharge',
			"total_fee"			=> $amount,
			"body"				=> 'member',
		);
		$param = $data;
        $rlt = $oPayApi->buildRequestForm($param,"get", "确认");
        echo '<pre>';print_r($rlt);die;
        //return array('url'=>$oPayApi->buildRequestForm($param,"get", "确认"),'trade_no'=>$log['trade_no']);
    }

	/**
	 * [金币充值请求]
	 * @param  [type] $code   [支付方式:支付宝]
	 * @param  [type] $amount [充值金额]
	 * @return [type]         [description]
	 */
	public function money()
    {
        $code = I('request.code');
        $amount = I('request.amount');
        if (!$code) {
            $this->error('没有选择支付方式', 212);
        } else if (empty($amount)) {
            $this->error('付款金额不合法', 211);
        } else if (check_login()) {
            if ($ret = $this->money_pay($this->uid, $code, $amount)) {
                $url = $ret['url'];
                $trade_no = $ret['trade_no'];
                //  成功页面跳转处理
            }
        }
    }

    //  订单支付执行
    public function order_pay($code, $order, $type)
    {
        if(!$oPayApi = $this->loadPayment($code)){
            return false;
        }
        if($order['pay_status'] == 1){
            $this->error('该订单已经支付成功');
            return false;
        }else if($order['order_status'] == 2){
            $this->error('该订单已经完成');
            return false;
        }
        if(!$total_amount = $order['money']){
            $this->error('订单金额非法');
            return false;
        }
        //  校验支付日志
        $mod = D('Common/Paymentlog');

        if(!$log = $mod->log_by_order_id($order['id'], 'order')){
            $log = array('user_id'=>$order['user_id'], 'type'=>$type['logtype'], 'order_id'=>$order['id'], 'payment'=>$code, 'money'=>$total_amount); //插入订单记录表
            $log['trade_no'] = $mod->create_trade_no();
            if(!$log_id = $mod->add($log)){
                $this->error('创建支付日志失败');
                return false;
            }
            $log = $mod->find($log_id);
        }else if($log['payed'] == 1){
            $this->error('该订单已经支付成功', 211);
            return false;
        }
        //  校验支付日志字段
        $a = array();
        if($log['money'] != $order['money']){
            $log['money'] = $a['money'] = $order['money'];
        }
        if($log['type'] != 'order'){
            $a['type'] = 'order';
        }
        if($log['payment'] != $code){
            $a['payment'] = $code;
        }
        if($a){
            $mod->where(array('id'=>$log['id']))->save($a);
        }

        $data = array();
        $out_trade_no = $log['trade_no'];
        $subject = $site['site_title'].'-'.$type['ordertype'];
        $body = $order['address'].'('.$order['contact'].','.$order['phone'].')';
        $data = array(
            'partner'           => $oPayApi->alipay_config['partner'],
            'seller_id'         => $oPayApi->alipay_config['seller_id'],
            'key'               => $oPayApi->alipay_config['key'],
            'notify_url'        => $oPayApi->alipay_config['notify_url'],
            'return_url'        => $oPayApi->alipay_config['return_url'],
            'sign_type'         => $oPayApi->alipay_config['sign_type'],
            'input_charset'     => $oPayApi->alipay_config['input_charset'],
            'cacert'            => $oPayApi->alipay_config['cacert'],
            'transport'         => $oPayApi->alipay_config['transport'],
            'payment_type'      => $oPayApi->alipay_config['payment_type'],
            'service'           => $oPayApi->alipay_config['service'], //接口名称
            'anti_phishing_key' => $oPayApi->alipay_config['anti_phishing_key'],
            'exter_invoke_ip'   => $oPayApi->alipay_config['exter_invoke_ip'],
            "out_trade_no"      => $out_trade_no,
            "subject"           => 'shoporder',
            "total_fee"         => $order['money'],
            "body"              => 'addressnamephone',
        );
        if($from == 'APP'){
            return $oPayApi->build_app($data);
        }else{
            return $oPayApi->buildRequestForm($data,"get", "确认");
        }
    }

    /**
     * [订单支付请求]
     * @param  $code    支付方式
     * @param  $order_id  订单id
     * @param  $order_type  订单类型
     * @return [type]           [description]
     */
    public function order($code, $order_id)
    {
        check_login();;
        if (!($order_id = (int)I('request.order_id'))) {
            $this->error(404);
        }else if (!($code = I('request.code'))) {
            $this->error(404);
        }else if (!($order_type = I('request.order_type'))) {
            $this->error(404);
        }else {
            $order = D('Common/order')->find($order_id);

            if ($order['order_status'] < 0) {
                $this->error('订单已经取消不可支付');
            }else if ($order['order_status'] == 8) {
                $this->error('订单已经完成不可支付');
            }else if ($order['pay_status'] == 1) {
                $this->error('该订单已经支付过了,不需要重复支付');
            }else if ((float)$order['money'] == 0) {
                $this->error('订单无需在线支付');
            }else {
                //使用金币支付
                $type = D("Common/order")->getType($order['type']);
                if ($ret = $this->order_pay($code, $order, $type)) {
                    // 成功页面跳转处理
                }
            }
        }
    }

}