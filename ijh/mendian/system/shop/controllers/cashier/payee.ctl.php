<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

Import::C('cashier/cashier');
class Ctl_Cashier_Payee extends Ctl_Cashier
{

    public function index()
    {
        $this->tmpl = 'shop/cashier/payee/index.html';
    }

    public function alipay()
    {
        if(!$payee_alipay = K::M('alipay/alipay')->detail($this->shop_id)){
            $redirect_uri = $this->mklink('alipay/api:authcode', array(), array('shop_id'=>$this->shop_id), 'www');
            $this->pagedata['alipay_auth_code_uri'] = K::M('alipay/service')->getAuthCodeUri($redirect_uri);
            $this->pagedata['alipay_auth_sign_uri'] = K::M('alipay/service')->getAuthSignUri();
            $this->tmpl = 'shop/cashier/payee/openalipay.html';
        }else{
            $this->pagedata['payee_alipay'] = $payee_alipay;
            $this->tmpl = 'shop/cashier/payee/alipay.html';
        }
    }

    public function wxpay()
    {
        if(!$payee_wxpay = K::M('weixin/wxpay')->detail($this->shop_id)){
            $this->tmpl = 'shop/cashier/payee/openwxpay.html';
        }else{
            $this->pagedata['payee_wxpay'] = $payee_wxpay;
            $this->tmpl = 'shop/cashier/payee/wxpay.html';
        }
    }

}