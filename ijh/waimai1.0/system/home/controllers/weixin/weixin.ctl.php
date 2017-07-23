<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixin extends Ctl
{


    protected function wechat_client()
    {
        if(!$client = K::M('weixin/wechat')->admin_wechat_client()){
            exit('公众号未授权');
        }
        return $client;
    }

    protected function weixin_jssdk()
    {
        static $jssdk = null;
        if($jssdk === null){
            Import::L('weixin/jssdk.php');
            $jssdk = new WeixinJSSDK($this->request['weixin']['appid'], $this->request['weixin']['secret']);
        }
        return $jssdk;
    }

    protected function access_openid($force = false)
    {
        static $openid = null;
        if($force || $openid === null){
            if($code = $this->GP('code')){
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                //var_dump($ret); echo __FILE__.'+++++'.__LINE__;exit;
                $openid = $ret['openid'];
                if($unionid = $ret['unionid']){                    
                    $this->cookie->set('wx_unionid', $ret['unionid']);
                    $m = K::M('member/weixin')->detail_by_unionid($unionid);
                }else if($openid){
                    $m = K::M('member/weixin')->detail_by_openid($openid);
                }else{
                    exit('获取授权失败1');
                }
                if($m['uid']){
                    K::M('member/auth')->manager($m['uid']);
                }else if($wx_info = $client->getUserInfoById($ret['openid'])){
                    if($m = K::M('member/weixin')->create_account($wx_info)){
                        K::M('member/auth')->manager($m['uid']);
                    }
                }
                $this->cookie->set('wx_openid', $openid);
            }else{
                if(!$openid = $this->cookie->get('wx_openid')){
                    //var_dump($openid);die;
                    $client = $this->wechat_client();
                    $url = $this->request['url'].'/'.$this->request['uri'];
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    //var_dump($authurl);die;
                    header('Location:'.$authurl);
                    exit();
                }
                $unionid = $this->cookie->get('unionid');
            }
            if(!defined('WX_OPENID')){
                define('WX_OPENID', $openid);
            }
            if(!defined('WX_OPENID')){
                define('WX_UNIONID', $unionid);
            }            
        }
        if(empty($openid)){
            exit('获取授权失败');
        }
        return $openid;
    }


    protected function access_openid2($force = false)
    {
        static $openid = null;
        if($force || $openid === null){
            if($code = $this->GP('code')){
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                $openid = $ret['openid'];
                $this->cookie->set('wx_openid', $openid);
                if($reback_url = $this->GP('reback_url')){
                    if(strpos($reback_url, '?') === false){
                        $reback_url .= '?openid='.$openid;
                    }else{
                        $reback_url .= '&openid='.$openid;
                    }
                    header('Location:'.$reback_url);
                    exit();
                }
            }else{
                if(!$openid = $this->cookie->get('wx_openid')){
                    $client = $this->wechat_client();
                    $site = $this->system->config->get('site');
                    $url .= 'reback_url='.urldecode('http://'.$site['domain'].'/'.$this->request['uri']);
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:'.$authurl);
                    exit();
                }
            }
        }
        if(empty($openid)){
            exit('获取授权失败');
        }
        return $openid;
    }

    protected function check_zxpm()
    {
        $openid = $this->access_openid();
        $this->zxpm = K::M('company/zxpm')->detail_by_openid($openid);
        return $this->zxpm;
    }

    protected function check_member()
    {
        $openid = $this->access_openid();
        if($member = K::M('member/weixin')->detail_by_openid($openid)){
            $this->MEMBER = $member;
        }
        return $member;
    }

    protected function _init_pagedata()
    {
        parent::_init_pagedata();
        $this->pagedata['weixinJS'] = $this->weixin_jssdk()->getSignPackage();
    }
}