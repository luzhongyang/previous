<?php

// 支付接口请求回调

namespace Api\Controller;
use Think\Controller;

class PaymentController extends Controller {

    /**
     * 支付宝接口事务处理
     * @return [type] [description]
     */
    public function alipay_affair($verify_result=array(),$alipay_config=array())
    {
        //所有参与金币变动的数据表都要使用innerDB引擎以支持事务回滚

        //启动事务
        $mod = D('Common/Paymentlog');
        $mod->startTrans();
        $flag = false;
        if($log = $mod->log_by_no($verify_result['out_trade_no'])) {
            //判断该笔订单是否在商户网站中已经做过处理
            if($log['payed'] === 0) {
                //请务必判断请求时的total_amount、seller_id与通知时获取的total_amount、seller_id为一致的
                if($log['amount'] == (float)$verify_result['total_amount'] && $alipay_config['seller_id'] == $verify_result['seller_id']) {
                    //  平台费率扣除
                    $rate_percent = round((int)C('rate')/100, 2);
                    if($rate_percent < 1 && $rate_percent > 0) {
                        $log['amount'] = $log['amount'] * (1-$rate_percent);
                    }
                    //  更新支付日志支付状态、订单状态
                    if($mod->set_payed($verify_result['out_trade_no'], $verify_result['trade_no']) {
                        if($log['type'] == 'money') {
                            if(D('Common/Payment')->payed_coin($log)) {
                                $flag = true;
                            }
                        }else if(in_array($log['type'], D('Common/Order')->getType())) {
                            if(D('Common/Payment')->payed_order($log)) {
                                $flag = true;
                            }
                        }
                    }
                }
            }
            if($flag == false){
                //回滚事务
                $mod->rollback();
            }else{
                //提交事务
                $mod->commit();
            }
        }
    }

    /**
     * 支付宝服务器异步通知
     */
    public function alipay_notify_url()
    {
        //  异步通知使用POST方式获取，异步通知验证没有时间限制,计算得出通知验证结果,该方式的作用主要防止订单丢失，即页面跳转同步通知没有处理订单更新，它则去处理；
        $payment = D('Payment')->payment('alipay');
        $alipay_config = unserialize($payment['config']);
        $alipayNotify = new \Vendor\Alipay\AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        $success = false;
        if($verify_result) {
            $out_trade_no = $verify_result['out_trade_no']; //商户订单号
            $trade_no = $verify_result['trade_no'];         //支付宝交易号
            $trade_status = $verify_result['trade_status']; //交易状态
            if($trade_status == 'TRADE_FINISHED') {
                //交易状态TRADE_FINISHED的通知触发条件是商户签约的产品不支持退款功能的前提下，买家付款成功；或者，商户签约的产品支持退款功能的前提下，交易已经成功并且已经超过可退款期限
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount、seller_id与通知时获取的total_amount、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知


                $this->alipay_affair($verify_result,$alipay_config);

                //调试用，写文本函数记录程序运行情况是否正常
                log_result("alipay_notify_url->success:trade_no->".$trade_no);
            }else if ($trade_status == 'TRADE_SUCCESS') {
                //状态TRADE_SUCCESS的通知触发条件是商户签约的产品支持退款功能的前提下，买家付款成功；
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount、seller_id与通知时获取的total_amount、seller_id为一致的
                //如果有做过处理，不执行商户的业务程序

                $this->alipay_affair($verify_result);

                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
                log_result("alipay_notify_url->success:trade_no->".$trade_no);
            }
            echo "success";     //当商户收到服务器异步通知并打印出success时，服务器异步通知参数notify_id才会失效。也就是说在支付宝发送同一条异步通知时（包含商户并未成功打印出success导致支付宝重发数次通知），服务器异步通知参数notify_id是不变的。
        }else {
            echo "fail";
            log_result("alipay_notify_url->fail");
        }

    }


    /**
     *  支付宝页面跳转同步通知页面
     */
    public function alipay_return_url()
    {
        //  同步返回使用GET方式获取，同步返回验证有1分钟超时,计算得出通知验证结果
        $payment = D('Payment')->payment('alipay');
        $alipay_config = unserialize($payment['config']);
        $alipayNotify = new \Vendor\Alipay\AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {
            $out_trade_no = $verify_result['out_trade_no']; //商户订单号
            $trade_no = $verify_result['trade_no'];         //支付宝交易号
            $trade_status = $verify_result['trade_status']; //交易状态
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->alipay_affair($verify_result,$alipay_config);
            }else {
                echo "trade_status=".$trade_status;
            }
            echo "验证成功<br />";
        }else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "验证失败";
        }
    }

    public function wxpay_notify_url()
    {

    }

    public function wxpay_return_url()
    {

    }

    public function moneypay_affair()
    {

    }

    // 余额支付异步通知
    public function moneypay_notifi_url()
    {

    }

    //  余额支付同步通知
    public function moneypay_return_url()
    {

    }

}