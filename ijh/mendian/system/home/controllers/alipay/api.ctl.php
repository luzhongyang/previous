<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Alipay_Api extends Ctl
{
    public function index()
    {

    }

    public function authcode()
    {
        if(!$app_id = $this->GP('app_id')){
            $this->msgbox->add('应用APPID出错', 211);
        }elseif(!$app_auth_code = $this->GP('app_auth_code')){
            $this->msgbox->add('获取授权出错', 212);
        }else{
            Import::L('alipay/AopSdk.php');
            $alipay_config = $this->system->config->get('alipay');
            $AopClient = new AopClient();
            $AopClient->appId = $alipay_config['app_id'];
            $AopClient->rsaPrivateKey = $alipay_config['app_rsa_private_key'];
            $AopClient->alipayrsaPublicKey = $alipay_config['alipay_rsa_public_key'];
            $request = new AlipayOpenAuthTokenAppRequest();
            $request->setBizContent('{"grant_type":"authorization_code","code":"'.$app_auth_code.'"}');
            if($ret = $AopClient->execute($request)){
                if($ret->alipay_open_auth_token_app_response->code == '10000'){
                    $jsondata = $ret->alipay_open_auth_token_app_response;
                    if($shop_id = $this->GP('shop_id')){
                        $auth_data = array(
                            'shop_id'           => $shop_id,
                            'app_auth_token'    => $jsondata->app_auth_token,
                            'auth_app_id'       => $jsondata->auth_app_id,
                            'app_refresh_token' => $jsondata->app_refresh_token,
                            'user_id'           => $jsondata->user_id,
                            'expires_in'        => __TIME + $jsondata->expires_in,
                            're_expires_in'     => __TIME + $jsondata->re_expires_in
                        );
                        K::M('alipay/alipay')->create($auth_data);
                    }
                    $this->tmpl = 'home/alipay/authsuccess.html';
                }else{
                    $this->msgbox->add('获取授权出错', 214);
                }
            }else{
                $this->msgbox->add('获取授权出错', 215);
            }
        }
    }
}