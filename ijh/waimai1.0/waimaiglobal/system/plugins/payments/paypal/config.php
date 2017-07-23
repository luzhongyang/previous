<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: config.php 9343 2015-03-24 07:07:00Z youyi $
 */
return array(
	'code'=>'paypal',
	'name'=>'贝宝支付',
	'content'=>'PayPal（www.paypal.com） 是在线付款解决方案的全球领导者，在全世界有超过七千一百六十万个帐户用户。PayPal 可在 56 个市场以 7 种货币（加元、欧元、英镑、美元、日元、澳元、港元）使用。<a href="https://www.paypal.com/c2/" target="_blank" style="color:red; font-weight:bold;">立即在线申请</a>',
	'website'   => 'http://www.paypal.com',
	'version'   => '1.0',
	'currency'  => '人民币',
	'config'    => array(
        'paypal_currency'  => array(
            'text'      => '支付货币',
            'desc'  => '支付货币',
            'type'      => 'select',
            'items'     => array(
                'USD'   => '美元',
				'EUR'   => '欧元',
                'HKD'   => '港元',
				'JPY'   => '日元',
				'GBP'   => '英镑',
				'AUD'   => '澳元',
                'CAD'   => '加元',
            ),
        ),	
        'paypal_account'   => array(
            'text'  => '商户帐号',
            'desc'  => '商户帐号',
            'type'  => 'text',
        ),

    ),
);