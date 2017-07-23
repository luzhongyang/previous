<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Alipay_Service
{
    static protected $_client_list = null;
    static protected $_alipay_config = array();
    public function __construct()
    {
        self::$_alipay_config = K::M('system/config')->get('alipay');
    }

    public function client($shop_id)
    {
        if(!$client = self::$_client_list[$shop_id]){

        }
    }

    public function getAuthCodeUri($redirect_uri)
    {
        $appid = self::$_alipay_config['app_id'];
        $url = 'http://openauth.alipay.com/oauth2/appToAppAuth.htm?app_id=%s&redirect_uri=%s';
        $uri = sprintf($url, $appid, $redirect_uri);
		return urlencode($uri);
    }

    public function getAuthSignUri()
    {
        return 'https://b.alipay.com/settling/index.htm?appId='.self::$_alipay_config['app_id'];
    }

    public function getAuthTokenByCode($code)
    {
        $AopClient = $this->AopClient();
        $request = new AlipayOpenAuthTokenAppRequest();
        $request->setBizContent('{"grant_type":"authorization_code","code":"'.$code.'"}');
        if($ret = $AopClient->execute($request)){
            if($ret->alipay_open_auth_token_app_response->code == '10000'){
                return $ret->alipay_open_auth_token_app_response;
            }
        }
        return false;
    }

    public function refreshAuthToken($refresh_token)
    {

    }

    //alipay.open.auth.token.app.query
    public function queryAuthToken($token)
    {

    }

    public function AopClient()
    {
        static $AopClient = null;
        if($AopClient === null){
            Import::L('alipay/AopSdk.php');
            $alipay_config = $this->system->config->get('alipay');
            $AopClient = new AopClient();
            $AopClient->appId = $alipay_config['app_id'];
            $AopClient->rsaPrivateKey = $alipay_config['app_rsa_private_key'];
            $AopClient->alipayrsaPublicKey = $alipay_config['alipay_rsa_public_key'];
        }
        return $AopClient;
    }
}