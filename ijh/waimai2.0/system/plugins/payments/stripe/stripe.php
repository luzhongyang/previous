<?php
require_once __CFG::DIR . "plugins/payments/stripe/init.php";

class Payment_Stripe {

    public function __construct($cfg) {
        $this->config = $cfg;
        // print_r($cfg);die;

        $this->_parameter = array();
        if(1 == $cfg['env_set']){
          //gov mode
          $this->_parameter['sk'] = $cfg['live_sk'];
          $this->_parameter['pk'] = $cfg['live_pk'];
        }
        else {
          //test mode
          $this->_parameter['sk'] = $cfg['test_sk'];
          $this->_parameter['pk'] = $cfg['test_pk'];
        }
    }


    public function Queryorder($transaction_id) {
      // $transaction_id = 'ch_198p20L0GMAB00HJw2xPVjwc';
      \Stripe\Stripe::setApiKey($this->_parameter['sk']);
      try {
          $order = \Stripe\Charge::retrieve($transaction_id);
          //history pay  id   ch_198p20L0GMAB00HJw2xPVjwc
          // ch_1993NWL0GMAB00HJgAsv6bcT  eur 6.66
      } catch(\Stripe\Error\Card $e) {
          $msg =  $e->getMessage();
          return false;
          // return $msg;
          // print_r($msg);
          // echo '<pre><hr />';
          // print_r($e);
      }
      return $order;

    }

    public function build_app($input)
    {
        $data = array();
        $data['payurl'] = K::M('helper/link')->mklink('trade/payment:order', array('stripe', $input['order_id']), null, null, 'www');
        return $data;
    }

    public function return_verify(){
        //stripe 回调支付
        $order_id = (int)$_GET['order_id'];
        $amount = (int)$_GET['amount'] * 100;
        $currency = $_GET['currency'];

        $token = $_POST['stripeToken'];
        $token_mail = $_POST['stripeEmail'];
        $token_type = $_POST['stripeTokenType'];


        if($order_id>0 && $amount>0 && strlen($currency)> 0){
            //search_order
            $arr_order = K::M('payment/log')->find(array('order_id'=>$order_id));
            $trade_no = $arr_order['trade_no'];
            if(1 == $arr_order['payed']){
                return false;
            }


            \Stripe\Stripe::setApiKey($this->_parameter['sk']);

            try {
                $pay_order = \Stripe\Charge::create(array(
                    "amount" => $amount, // Amount in cents
                    "currency" => $currency,
                    "source" => $token,
                    "description" => $order_id
                ));
                K::M('system/logs')->log('stripe_pay_log_success', 'sub_token:'.$_POST.',return_info:'.$pay_order.'---');

                $trade = array();



                $trade = array('code'=>'alipay',
                  'trade_no'=>$trade_no,
                  'pay_trade_no'=>$pay_order['id'],
                  'trade_status'=>$_GET['trade_status'],
                  'amount'=>$notify['total_fee'],
                );
                //其他信息不记录了, 可以单独加表存储..
                return $trade;

            } catch(\Stripe\Error\Card $e) {
                $msg =  $e->getMessage();
                K::M('system/logs')->log('stripe_pay_log_false', 'getMessage:'.$msg.',detail:'.$e.'---');
                return false;
            }

        }
        else {
          K::M('system/logs')->log('stripe_pay_log', '订单号/金额/货币传递不正确,order_id:'.$order_id.',amount:'.$amount.',currency:'.$currency.'---');
          return false;
        }


    }

    public function build_url($input) {

      return $input;
      // $url = "amount={$input['amount']}&order_id={$input['order_id']}";
      // return $url;
    }

    public function load_web_pay_button($input,$payment_stripe){
        $input['amount'] = $input['amount'] * 100;
        return $html = '
        <form action="/trade/payment/return_verify-stripe.html?order_id='.$input['order_id'].'&amount='.$input['amount'].'&currency='.$payment_stripe['config']['stripe_currency'].'" method="POST">
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="'.$this->_parameter['pk'].'"
                data-amount="'.$input['amount'].'"
                data-name="HUNGRYPANDA LTD"
                data-description="'.$input['order_id'].'"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-zip-code="true"
                data-currency="'.$payment_stripe['config']['stripe_currency'].'">
            </script>
        </form>
        ';
    }


    protected function _logs($log)
    {
        $key = 'payment-stripe-' . date('Ymd');
        K::M('system/logs')->log($key, $log);
    }

}
