<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: controller.php 9343 2015-03-24 07:07:00Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl extends Factory
{

    protected $_allow_fields = '';

    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->cookie = $system->cookie;
        $this->system->config->get('mobile');
        $this->system->objctl = &$this;
        $this->msgbox->template("shop/card/page/notice.html");
        $this->InitializeApp();
 
    }


    //初始化当前应用程序控制器
    protected function InitializeApp()
    {
        if(!preg_match("/shop(\d+)/i", $this->request['host'], $m)){
            $this->error(404);
        }
        define('SHOP_ID', $m[1]); //店铺ID常量
        if(!$shop = K::M('shop/shop')->detail(SHOP_ID)){
            $this->error(404);
        }
        $this->shop = $shop;
        $this->shop_id = SHOP_ID;
		if(defined('IN_WEIXIN')){
			if($this->wx_openid = $this->get_wx_openid()){
				if(defined('WX_UNIONID')){
					$wxuser = K::M('weixin/user')->detail_by_unionid(WX_UNIONID);
				}else if(defined('WX_OPENID')){
					$wxuser = K::M('weixin/user')->detail_by_openid(WX_OPENID);
				}
				if(empty($wxuser)){
					$wxuser = $this->init_wxuser_by_openid($this->wx_openid);
				}
			   $this->wxuserinfo = $wxuser;
			}
		}
    }

    protected function _init_pagedata()
    {
        if(defined('IN_WEIXIN')){
            $CONFIG = $this->system->config->load(array('site', 'wechat'));
        }
        else{
            $CONFIG = $this->system->config->load(array('site'));
        }
        $site = $CONFIG['site'];
        parent::_init_pagedata();
        $theme = $this->default_theme();
        $this->pagedata['MEMBER'] = $this->MEMBER;
        $this->pagedata['CARD'] = $this->card;
        $this->pagedata['SHOP_ID'] = SHOP_ID;
        $this->pagedata['shop'] = $this->shop;
        $this->pagedata['wxuserinfo'] = $this->wxuserinfo;
        $this->pagedata['city_id'] = $this->system->cookie->get('UxCityId');
        $this->pagedata['pager']['url'] = $site['url'];
        $this->pagedata['pager']['res'] = __CFG::RES_URL;
        $this->pagedata['pager']['theme'] = $site['siteurl'] . '/themes';
        $this->pagedata['nowtime'] = $this->pagedata['pager']['dateline'] = __TIME;
        $this->pagedata['VER'] = JH_RELEASE;
        $this->pagedata['site'] = $site;
        $output = K::M('system/frontend');
        $output->setCompileDir(__CFG::DIR . 'data/tplcache');
        if(defined('IN_WEIXIN')){
            $wxcfg = $this->system->config->get('wechat');
            Import::L('weixin/jssdk.php');
            $wxjssdk = new WeixinJSSDK($wxcfg['appid'], $wxcfg['appsecret']);
            $this->pagedata['wxjs_config'] = $wxjssdk->getSignPackage();
        }
    }

    public function check_login()
    {
        if(!$this->uid){
            $this->msgbox->add('很抱歉，你还没有登录不能访问', 101)->response();
        }
        return true;
    }

    //数组键值过滤。通常用户过滤不允许前台修改的表字段
    public function check_fields($data, $fields = null)
    {
        if($fields === null){
            $fields = $this->_allow_fields;
        }
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array) $data as $k => $v){
            if(!in_array($k, $fields)){
                unset($data[$k]);
            }
        }
        return $data;
    }

    protected function filter_fields($fields, $row)
    {
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array) $row as $k => $v){
            if(!in_array($k, $fields)){
                unset($row[$k]);
            }
        }
        return $row;
    }

    

    protected function set_resource_view(&$output)
    {
        $theme = $this->default_theme();
        $output->setTemplateDir(__CFG::TMPL_DIR . $theme['theme']);
        $output->registerFilter('pre', array($this, 'smarty_pre_filter'));
        $output->registerFilter('post', array($this, 'smarty_post_filter'));
        $output->default_template_handler_func = array($this, 'theme_default_handler');
    }

    public function smarty_pre_filter($source, $smarty)
    {
        //$s = array('/(<\{(KT|AD|calldata)[^\}]*\}>)/', '/(<\{\/(KT|AD|calldata)\}>)/');
        //$r = array('\1<{literal}>', '<{/literal}>\1');
        $s = array(
            '/(<\{KT[^\}]*\}>)/', '/(<\{\/KT\}>)/',
            '/(<\{AD[^\}]*\}>)/', '/(<\{\/AD\}>)/',
            '/(<\{calldata[^\}]*\}>)/', '/(<\{\/calldata\}>)/'
        );
        $r = array('\1<{literal}>', '<{/literal}>\1', '\1<{literal}>', '<{/literal}>\1', '\1<{literal}>', '<{/literal}>\1');
        return preg_replace($s, $r, $source);
    }

    public function smarty_post_filter($source, $smarty)
    {
        if($file_dependency = $smarty->properties['file_dependency']){
            list($hash, $info) = each($file_dependency);
            $tmpl = $smarty->template_resource;
            if($info[2] == 'file'){
                $theme = substr($info[0], strlen(__CFG::TMPL_DIR), -strlen($tmpl));
                $theme = str_replace('\\', '/', $theme);
                $theme = str_replace('/', '', $theme);
                $site = $this->system->config->get('site');
                $theme_url = trim($site['url'], '/') . '/themes/' . $theme;
                return preg_replace('/%THEME%/', $theme_url, $source);
            }
        }
        return $source;
    }

    public function theme_default_handler($type, $name, &$content, &$modified, Smarty $smarty)
    {
        if($type == 'file'){
            $file = __CFG::TMPL_DIR . 'default' . DIRECTORY_SEPARATOR . $name;
            return $file;
        }
        return false;
    }

    public function error($error)
    {
        if(is_numeric($error)){
            $this->system->response_code($error);
        }
        $this->tmpl = "shop/card/page/{$error}.html";
        $this->output();
    }

    public function shutdown()
    {
        //system logs
    }

    protected function default_theme()
    {
        static $theme = null;
        if($theme === null){
            if(empty($theme)){
                $theme = K::M('system/theme')->default_theme();
            }
        }
        return $theme;
    }


    //微信登录开始
    protected function get_wx_openid()
    {
        static $wx_openid = null;
        static $wx_unionid = null;
        if($wx_openid === null){
            if($code = $this->GP('WXCODE')){
                $client = $this->wechat_client();
                if($ret = $client->getAccessTokenByCode($code)){
                    $wx_unionid = $ret['unionid'];
                    $wx_openid = $ret['openid'];  
                }
            }else if($wx_openid = $this->GP('WXOPENID')){
                if($pos = strpos($wx_openid, '?')){
                    $wx_openid = substr($wx_openid, 0, $pos);
                }
                $this->cookie->set('wx_openid', $wx_openid);
            }else{ //获取cookie的openid
                if(!$wx_openid = $this->cookie->get('wx_openid')){
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $authurl = 'http://fz.jhcms.cn/weixin/token/index.html?reback_url=' . urlencode($url);
                    header('Location:' . $authurl);
                    exit();
                }
                $wx_unionid = $this->cookie->get('wx_unionid');
            }
        }
        if(!defined('WX_OPENID')){
            define('WX_OPENID', $wx_openid);
        }
        if(!defined('WX_UNIONID') && $wx_unionid){
            define('WX_UNIONID', $wx_unionid);
        }
        if(empty($wx_openid)){
            $this->msgbox->add('获取授权失败！');
            $this->msgbox->set_data('forward', $this->mklink('index'));
        }

        return $wx_openid;
    }


    protected function access_openid($force = false)
    {
        static $wx_openid = null;
        static $wx_unionid = null;
        if($force || $wx_openid === null){
            if($code = $this->GP('code') && $code != 'wxpay'){
                $client = $this->wechat_client();
                if($ret = $client->getAccessTokenByCode($code)){
                    $wx_unionid = $ret['unionid'];
                    $wx_openid = $ret['openid'];  
                }
            }else{
                //获取cookie的openid
                if(!$wx_openid = $this->cookie->get('wx_openid')){
                    $client = $this->wechat_client(); //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $url = $this->mklink(null, $this->request['args'], null, 'www');
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:' . $authurl);
                    exit();
                }
            }
        }

        if(!defined('WX_OPENID')){
            define('WX_OPENID', $wx_openid);
        }
        if(!defined('WX_UNIONID') && $wx_unionid){
            define('WX_UNIONID', $wx_unionid);
        }
        if(empty($wx_openid)){
            $this->msgbox->add('获取授权失败！');
            $this->msgbox->set_data('forward', $this->mklink('index'));
        }
        return $wx_openid;
    }

    protected function wechat_client()
    {
        static $client = null;
        if($client === null){
            $client = K::M('weixin/wechat')->admin_wechat_client();
        }
        return $client;
    }

    protected function init_wxuser_by_openid($wx_openid)
    {

        if($client = $this->wechat_client()){
            if($wxinfo = $client->getUserInfoById($wx_openid)){
                if($wx_unionid = $wxinfo['unionid']){
                    $wxuser = K::M('weixin/user')->detail_by_unionid($wx_unionid);
                }else if($wx_openid = $ret['openid']){
                    $wxuser = K::M('weixin/user')->detail_by_openid($wx_openid);
                }
                if(empty($wxuser)){
                    $data = array('wx_openid'=>$wxinfo['openid'], 'nickname'=>$wxinfo['nickname'], 'face'=>$wxinfo['headimgurl']);
                    $data['unionid'] = $wxinfo['unionid'] ? $wxinfo['unionid'] : '';
                    if($wxuid = K::M('weixin/user')->create($data, true)){
                        $wxuser = K::M('weixin/user')->detail($wxuid);
                    }
                }
                return $wxuser;
            }
        }
        return false;
    }

    //微信登录
    protected function init_account_by_wx_openid($wx_openid)
    {
        if($client = $this->wechat_client()){
            if($wxinfo = $client->getUserInfoById($wx_openid)){
                $data = array('wx_openid'=>$wx_openid, 'nickname'=>$wxinfo['nickname']);
                $data['wx_unionid'] = defined('WX_UNIONID') ? WX_UNIONID : '';
                $data['passwd'] = md5(uniqid());
                if($uid = K::M('member/member')->create($data, true)){
                    if($face = file_get_contents($wxinfo['headimgurl'])){
                        K::M('member/face')->update_face($uid, '', $face);
                    }
                    return $this->auth->manager($uid);
                }
            }
        }
        return false;
    }

}
