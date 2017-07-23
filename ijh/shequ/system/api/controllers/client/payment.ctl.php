<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Payment extends Ctl
{
    /* 订单支付
     * @param order_id
     * @param code,支付方式[money|alipay|wxpay]
     * @param hongbao_id
     */
    public function order($params)
    {
        $this->check_login();
        if(!($order_id = (int)$order_id) && !($order_id = (int)$params['order_id'])){
            $this->msgbox->add('参数传递错误', 211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('订单非法', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已取消不可支付', 214);
        }else if($order['pay_status'] == 1){
            $this->msgbox->add('该订单已经支付', 216);
        }else if($order['amount'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }else if(!$code = $params['code']){
            $this->msgbox->add('未选定支付方式', 221);
        }else { 
            if(($code == 'money') && ($this->MEMBER['money'] < $amount)){
                $this->msgbox->add('余额不足，请更换支付方式', 221);
            }else if(!$data = K::M('trade/payment')->order($code, $order, 'APP')){
                $this->msgbox->add('创建支付请求失败', 223);
            }else{
                $this->msgbox->set_data('data', $data);
                $this->msgbox->add('success');
            }
        }
    }

    /* 余额充值
     * @param $code,支付方式
     * @param $amount,金额
     */
    public function money($params)
    {
        $this->check_login();
        if(!$code = $params['code']){
            $this->msgbox->add('未选定支付方式', 211);
        }else if(!$amount = $params['amount']){
            $this->msgbox->add('未选择充值金额', 212);
        }else if($amount<=0){
            $this->msgbox->add('充值金额不正确', 213);
        }else if($data = K::M('trade/payment')->money($this->uid, $code, $amount, 'APP')){
            //$data['noncestr'] = strtolower($data['noncestr']);
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add('创建支付请求失败', 214);
        }
    }
    
    public function coin($params)
    { //夺宝币充值
        $this->check_login();
        $code = $params['code'];
        $amount = $params['amount'];
        if(!$code){
            $this->msgbox->add('没有选择支付方式', 212);
        }else if(empty($amount)){
            $this->msgbox->add('充值金额不合法', 211);
        }else if($data = K::M('trade/payment')->coin($this->uid, $code, $amount,'APP')){
            $this->msgbox->set_data('data', $data);
            $this->msgbox->add('success');
        }else{
            $this->msgbox->add('创建支付请求失败', 214);
        }
    }
    

    //业主账单
    public function yzbill($params)
    {
        $this->check_login();
        if(!$bill_id = (int)$params['order_id']){
            $this->msgbox->add('参数传递错误', 211);
        }else if(!$bill = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('账单不存在', 212);
        }else if($bill['uid'] != $this->uid){
            $this->msgbox->add('非法的数据操作', 213);
        }else if($bill['pay_status'] == 1){
            $this->msgbox->add('账单已经支付成功', 216);
        }else if($bill['total_price'] <= 0){
            $this->msgbox->add('账单无需需要支付', 217);
        }else if(!$code = $params['code']){
            $this->msgbox->add('未选定支付方式', 221);
        }else { 
            if(($code == 'money') && ($this->MEMBER['money'] < $bill['total_price'])){
                $this->msgbox->add('余额不足，请更换支付方式', 221);
            }else if(!$data = K::M('trade/payment')->yzbill($code, $bill, 'APP')){
                $this->msgbox->add('创建支付请求失败', 223);
            }else{
                $this->msgbox->set_data('data', $data);
                $this->msgbox->add('success');
            }
        }
    }

    
    public function cloud($params)
    {
        $order_id = (int)$params['order_id'];
        $code = $params['code'];
        if(!$order_id){
            $this->msgbox->add('该订单不存在', 210);
        }
        else if(empty($code)){
            $this->msgbox->add('该订单不存在', 211);
        }
        else if(!$order = K::M('cloud/order')->detail($order_id)){
            $this->msgbox->add('该订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法的数据操作', 213);
        }
        else if($order['order_status'] == 1){
            $this->msgbox->add('订单已经支付成功', 216);
        }
        else if($order['num'] - $order['use_coin'] <= 0){
            $this->msgbox->add('该订单不需要支付', 217);
        }
        else{
            if($code == 'money'&&$this->MEMBER['money'] < ($order['num']-$order['use_coin'])){//使用余额支付
                 $this->msgbox->add('余额不足，请更换支付方式', 221);
            }else if(!$data = K::M('trade/payment')->cloud($code, $order, 'APP')){
                $this->msgbox->add('创建支付请求失败', 223);
            }else{
                $this->msgbox->set_data('data', $data);
                $this->msgbox->add('success');
            }
        }
    }
    
    
    
    
    public function payment_return($params)
    {
        $this->check_login();
        if(!$code && !($code = $params['code'])){
            $this->msgbox->add('未指定支付方式', 211);
        }else if(!$return_data =$params['return_data']){
            $this->msgbox->add('支付返回参数不正确', 212);
        }else if($obj = K::M('trade/payment')->loadPayment($code)){
            $_GET = array_merge($_GET, json_decode($return_data, true));
            if($trade = $obj->return_verify()){
                if(!$log = K::M('payment/log')->log_by_no($trade['trade_no'])){
                    $this->msgbox->add('支付的订单不存在', 211);
                }else if(K::M('payment/log')->set_payed($trade['trade_no'])){
                    if($log['from'] == 'order'){ //订单支付
                        K::M('trade/payment')->payed_order($log, $trade);
                        $this->pagedata['order'] = K::M('trade/order')->detail_by_no($trade['trade_no']);
                        $this->msgbox->add('success');//订单支付成功
                        $forward = $this->mklink('mobile/order:detail', array($trade['trade_no']));
                    }else if($log['from'] == 'money'){ //余额充值
                        K::M('trade/payment')->payed_money($log, $trade);
                        $this->msgbox->add('success');//充值余额成功
                    }else if($log['from'] == 'yzbill'){
                        K::M('trade/payment')->payed_yzbill($log, $trade);
                        $this->msgbox->add('success');//账单支付成功
                    }else if($log['from'] == 'coin'){ //夺宝币充值
                        K::M('trade/payment')->payed_coin($log, $trade);
                        $this->msgbox->add('success');//夺宝币充值成功
                    }
                }else{
                    if($log['from'] == 'order'){
                        $this->msgbox->add('该订单已经支付过了', 213);
                    }else if($log['from'] == 'money'){
                        $this->msgbox->add('已经充值成功，请不要重复提交', 214);
                    }else if($log['from'] == 'yzbill'){
                        $this->msgbox->add('账单已经支付过了', 215);
                    }
                }
            }else{
                $this->msgbox->add('支付验证签名失败', 215);
            }
        }
    }

    public function package($params)
    {
        $data = array();
        if($package = K::M('member/money')->package()){
            foreach($package as $k=>$v){
                $data[] = array('chong'=>$k, 'song'=>$v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>$data));
    }
    
    
    public function package2($params)
    {
        $data = array();
        if($package = K::M('member/member')->getRecharge()){
            foreach($package as $k=>$v){
                $data[] = array('chong'=>$k, 'song'=>$v);
            }
        }
        $this->msgbox->set_data('data', array('items'=>$data));
    }

    /**
     * 余额支付确认
     * trade_no 支付订单号
     * hongbao_id,红包ID
     * passwd 支付密码同用户登录密码
     */
    public function paymoney($params)
    {
        $this->check_login();
        $passwd = $params['passwd'];
        if(!$trade_no = $params['trade_no']){
            $this->msgbox->add('要支付单号错误', 211);
        }else if(md5($passwd) != $this->MEMBER['passwd']){
            $this->msgbox->add('支付密码不正确', 212);
        }else if(!$log = K::M('payment/log')->log_by_no($trade_no)){
            $this->msgbox->add('支付流水不存在', 213);
        }else if($log['payed']){
            $this->msgbox->add('该订单号已经支付', 217);
        }else{
            if($log['from'] == 'order'){
                if(!$order = K::M('order/order')->detail($log['order_id'])){
                    $this->msgbox->add('订单不存在或已删除', 214)->response();
                }else if($this->uid != $order['uid']){
                    $this->msgbox->add('非法的数据操作', 215)->response();
                }else if($order['order_status'] < 0){
                    $this->msgbox->add('订单已经取消,不可支付', 216)->response();
                }else if($order['pay_status']){
                    $this->msgbox->add('该订单已经支付', 217)->response();
                }else if($order['order_status']==8){
                    $this->msgbox->add('该订单已经完成', 218)->response();
                }
            }else if($log['from'] == 'yzbill'){
                if(!$bill = K::M('xiaoqu/bill')->detail($log['order_id'])){
                    $this->msgbox->add('账单不存在或已删除', 214)->response();
                }else if($bill['pay_status'] ==1){
                    $this->msgbox->add('账单已经付款成功', 215)->response();
                }
            }else if($log['from'] == 'cloud'){
               if(!$order = K::M('cloud/order')->detail($log['order_id'])){
                    $this->msgbox->add('订单不存在或已删除', 214)->response();
                }else if($order['order_status'] ==1){
                    $this->msgbox->add('订单已经付款成功', 215)->response();
                }
            }else if(!in_array($log['from'], array('coin'))){
                $this->msgbox->add('不支持的交易类型', 215)->response();
            }
            if($this->MEMBER['money'] < $log['amount']){// 可以等于，不能小于 edit by zhuhongwei 2016-11-29 14:17:07
                $this->msgbox->add('余额不足，请更换支付方式', 219)->response();
            }else if($log['from'] == 'coin'){
                if(K::M('trade/payment')->payed_coin($log, $trade)){
                    $this->msgbox->add('success');
                }                
            }else{
                $trade = array('trade_no'=>$trade_no, 'pay_trade_no'=>$trade_no, 'order_id'=>$log['order_id'], 'amount'=>$log['amount'], 'code'=>'money');
                if(K::M('member/member')->update_money($this->uid, -$log['amount'], '余额支付订单(ID:'.$order['order_id'].')')){
                    $this->MEMBER['money'] = $this->MEMBER['money'] - $log['amount'];
                    if(K::M('payment/log')->set_payed($trade_no)){
                        if('order' == $log['from']){
                            K::M('trade/payment')->payed_order($log, $trade);
                            $this->msgbox->set_data('data',$trade);                        
                        }else if('yzbill' == $log['from']){
                            K::M('trade/payment')->payed_yzbill($log, $trade);
                            $this->msgbox->set_data('data',$trade);                          
                        }else if($log['from'] == 'coin'){ //夺宝币充值
                            K::M('system/logs')->log('client.payment.coin.log', $log);
                            K::M('trade/payment')->payed_coin($log, $trade);
                            $this->msgbox->add('success');//夺宝币充值成功
                        }else if('cloud' == $log['from']){
                            K::M('trade/payment')->payed_cloud($log, $trade);
                            $this->msgbox->set_data('data',$trade);                          
                        }
                    }else{
                        $this->msgbox->add('订单支付失败', 218);
                    }
                }
            }
        }
    }
}

