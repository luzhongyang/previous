<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: config.php 9343 2015-03-24 07:07:00Z youyi $
 */
return array(
	'code'=>'paypal',
	'name'=>'贝宝支付',
	'content'=>'Stripe支付方式使用。<a href="https://www.stripe.com/" target="_blank" style="color:red; font-weight:bold;">立即在线申请</a>。沙盒测试账号：4242424242424242，billcode:12345',
	'website'   => 'http://www.paypal.com',
	'version'   => '1.0',
	'currency'  => '人民币',
	'config'    => array(
        'stripe_currency'  => array(
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

				'env_set'  => array(
						'text'      => '支付环境设置',
						'desc'  => '正式环境, 沙盒环境选择',
						'type'      => 'radio',
						'items'     => array(
								'0'   => '沙盒环境',
								'1'   => '正式环境',
						),
				),


        'live_sk'   => array(
            'text'  => 'Live Secret Key',
            'desc'  => '正式环境私钥',
            'type'  => 'text',
        ),
				'live_pk'   => array(
            'text'  => 'Live Publishable Key',
            'desc'  => '正式环境公钥',
            'type'  => 'text',
        ),
				'test_sk'   => array(
            'text'  => 'Test Secret Key',
            'desc'  => '测试环境私钥',
            'type'  => 'text',
        ),
				'test_pk'   => array(
            'text'  => 'Test Publishable Key',
            'desc'  => '测试环境公钥',
            'type'  => 'text',
        ),

    ),
);
