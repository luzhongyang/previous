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
        $this->msgbox->template("page/notice.html");
        if (defined('IN_WEIXIN') && IN_WEIXIN) {
            if ($this->wx_openid = $this->token_openid()) {
                /*if ($m = K::M('member/weixin')->detail_by_openid($this->wx_openid)) {
                    if ($uid = (int) $m['uid']) {     //如果数据库中存在该微信id则直接登录
                        K::M('member/auth')->manager($uid);
                    }
                }*/
            }
        }
    }
    
    //初始化当前应用程序控制器
    protected function InitializeApp()
    {

    }

    protected function _init_pagedata()
    {
        if(defined('IN_WEIXIN')){
            $CONFIG = $this->system->config->load(array('site', 'wechat'));
        }else{
            $CONFIG = $this->system->config->load(array('site'));
        }
        $site = $CONFIG['site'];
        parent::_init_pagedata();
        $theme = $this->default_theme();
        $this->pagedata['MEMBER'] = $this->MEMBER;
        $this->pagedata['pager']['url'] = $site['url'];
        $this->pagedata['pager']['res'] = __CFG::RES_URL;
        $this->pagedata['pager']['theme'] = $site['siteurl'].'/themes';
        $this->pagedata['nowtime'] = $this->pagedata['pager']['dateline'] = __TIME;
        $this->pagedata['VER'] = JH_RELEASE;
        $output = K::M('system/frontend');
        $output->setCompileDir(__CFG::DIR.'data/tplcache');
        if(defined('IN_WEIXIN')){
            $wxcfg = $this->system->config->get('wechat');
            Import::L('weixin/jssdk.php');
            $wxjssdk = new WeixinJSSDK($wxcfg['appid'], $wxcfg['appsecret']);
            $this->pagedata['wxjs_config'] = $wxjssdk->getSignPackage();
        }
    }

    //数组键值过滤。通常用户过滤不允许前台修改的表字段
    public function check_fields($data, $fields=null)
    {
        if($fields === null){
            $fields = $this->_allow_fields;
        }
        if(!is_array($fields)){
            $fields = explode(',', $fields);
        }
        foreach((array)$data as $k=>$v){
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
        foreach((array)$row as $k=>$v){
            if(!in_array($k, $fields)){
                unset($row[$k]);
            }
        }
        return $row;
    }

    public function getcart($shop_id)
    {        
        $shop_id = (int) $shop_id;
        $cart = (array) json_decode(str_replace("\\\"", "\"", urldecode($this->system->cookie->get('beauty'))), true);
        $cart = $cart[$shop_id]['undefined'];

        $carts = array();
        foreach ($cart as $kk => $vv) {
            if($kk == 'num') {
                unset($cart[$kk]);
            }
            $vv['num'] = 1;
            foreach ($vv as $key => $v) {
                $carts[$kk][$key] = $v;
            }
        }
        $product_ids = $nums = array();
        foreach ($carts as $k => $val) {
            $product_ids[] = $val['product_id'];
            $nums[$val['product_id']] = $val['num'];
        }
        if($products = K::M('product/product')->items(array('product_id'=>$product_ids))) {
            foreach($carts as $k1=>$v1) {
                foreach($products as $k=>$val) {
                    if($v1['product_id'] == $val['product_id']) {
                        $products[$k]['title'] = $v1['title'];
                    }
                    $products[$k]['cart_num'] = $nums[$val['product_id']];
                    $products[$k]['total_price'] = $nums[$val['product_id']] * $val['price'];
                }
            }
        }
        return $products;
    }

    public function check_login()
    {
        if(!$this->uid){
            if($this->request['XREQ'] || $this->request['MINI']){
                $this->msgbox->add('很抱歉，你还没有登录不能访问', 101);
            }else{
                $this->tmpl = 'passport/login.html';
            }
            $this->msgbox->response();
            exit();
        }
        return true;
    }

    protected function set_resource_view(&$output)
    {
        $theme = $this->default_theme();
        global $__LANG;
        if(file_exists(__CORE_DIR.'lang/'.__LANG.'/themes/default.php')){
            include(__CORE_DIR.'lang/'.__LANG.'/themes/default.php');
        }
        if(file_exists(__CORE_DIR.'lang/'.__LANG.'/themes/'.$theme['theme'].'.php')){
            include(__CORE_DIR.'lang/'.__LANG.'/themes/'.$theme['theme'].'.php');
        }        
        $output->setTemplateDir(__CFG::TMPL_DIR.$theme['theme']);
        $output->registerFilter('pre', array($this, 'smarty_pre_filter'));
        $output->registerFilter('post', array($this, 'smarty_post_filter'));
        $output->default_template_handler_func = array($this, 'theme_default_handler');
    }

    public function smarty_pre_filter($source, $smarty)
    {
        //$s = array('/(<\{(KT|AD|calldata|L)[^\}]*\}>)/', '/(<\{\/(KT|AD|calldata|L)\}>)/');
        //$r = array('\1<{literal}>', '<{/literal}>\1');
        $s = array(
                '/(<\{KT[^\}]*\}>)/', '/(<\{\/KT\}>)/',
                '/(<\{AD[^\}]*\}>)/', '/(<\{\/AD\}>)/',
                '/(<\{calldata[^\}]*\}>)/', '/(<\{\/calldata\}>)/'
                );
        $r = array('\1<{literal}>', '<{/literal}>\1','\1<{literal}>', '<{/literal}>\1','\1<{literal}>', '<{/literal}>\1');
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
                $theme_url = trim($site['url'], '/').'/themes/'.$theme;
                return preg_replace('/%THEME%/', $theme_url, $source);
            }
        }
        return $source;
    }

    public function theme_default_handler($type, $name, &$content, &$modified, Smarty $smarty)
    {
        if($type == 'file'){
            $file = __CFG::TMPL_DIR.'default'.DIRECTORY_SEPARATOR.$name;
            return $file;
        }
        return false;
    }

    public function error($error)
    {
        if(is_numeric($error)){
            $this->system->response_code($error);
        }
        $this->tmpl = "page/{$error}.html";
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
    protected function token_openid()
    {
        return $this->access_openid();
        static $openid = null;
        if ($openid === null) {
            if ($code = $this->GP('WXCODE')) {               
				$client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                if($wxid = $ret['unionid']){
                    $wxtype = 'wx_unionid';
                    $wx_unionid = $wxid;
                    if (!defined('WX_UNIONID')) {
                        define('WX_UNIONID', $wx_unionid);
                    }               
                    $wx_openid = $ret['openid'];
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }
                    $this->cookie->set('wx_unionid', $wx_unionid);
                    $this->cookie->set('wx_openid', $wx_openid);
                }else if($wxid = $ret['openid']){
                    $wxtype = 'wx_openid';
                    $wx_openid = $wxid;
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }
                    $this->cookie->set('wx_openid', $wx_openid);
                }else{
                    $this->msgbox->add('获取授权失败');
                    $this->msgbox->set_data('forward', $this->mklink('index'));
                    $this->msgbox->response();
                }
                if($member = K::M('member/member')->member($wxid, $wxtype)){
                    $this->auth->manager($member['uid']);
                }
            } else { //获取cookie的openid
                if (!$wx_openid = $this->cookie->get('wx_openid')) {
                    $client = $this->wechat_client(); //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $authurl = 'http://fz.jhcms.cn/weixin/token/code.html?reback_url=' . urlencode($url);
                    header('Location:' . $authurl);
                    exit();
                }else{
                    if($wx_unionid = $this->cookie->get('wx_unionid')){
                        if (!defined('WX_UNIONID')) {
                            define('WX_UNIONID', $wx_unionid);
                        }
                    }
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }                   
                }
            }
            if (!defined('WX_OPENID')) {
                define('WX_OPENID', $openid);
            }
            if (!defined('WX_UNIONID')) {
                define('WX_UNIONID', $unionid);
            }
        }
        if (empty($wx_openid)) {
            $this->msgbox->add('获取授权失败', 105);
            $this->msgbox->set_data('forward', $this->mklink('index'));
        }
        return $wx_openid;
    }



    //微信登录开始
    protected function access_openid($force = false)
    {
        static $openid = null;
        if ($force || $openid === null) {
            // 充值时GET['code']不等于array('wxpay', 'alipay')
            if (($code = $this->GP('code')) && !in_array($code, array('wxpay', 'alipay'))) {
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                echo $code;print_r($ret);die;
                if($wxid = $ret['unionid']){
                    $wxtype = 'wx_unionid';
                    $wx_unionid = $wxid;
                    if (!defined('WX_UNIONID')) {
                        define('WX_UNIONID', $wx_unionid);
                    }               
                    $wx_openid = $ret['openid'];
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }
                    $this->cookie->set('wx_unionid', $wx_unionid);
                    $this->cookie->set('wx_openid', $wx_openid);
                }else if($wxid = $ret['openid']){
                    $wxtype = 'wx_openid';
                    $wx_openid = $wxid;
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }
                    $this->cookie->set('wx_openid', $wx_openid);
                }else{
                    echo __LINE__;exit;
                    $this->msgbox->add('获取授权失败', 105);
                    $this->msgbox->set_data('forward', $this->mklink('index'));
                    $this->msgbox->response();
                }
                if($member = K::M('member/member')->member($wxid, $wxtype)){
                    $this->auth->manager($member['uid']);
                }
            } else { //获取cookie的openid
                /*if (!$wxid = $this->cookie->get('wx_openid')) {
                    $client = $this->wechat_client();                    //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:' . $authurl);
                    exit();
                }*/
                if (!$wx_openid = $this->cookie->get('wx_openid')) {
                    $client = $this->wechat_client(); //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $url = $this->mklink(null, $this->request['args'], null, 'www');
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:' . $authurl);
                    exit();
                }else{
                    if($wx_unionid = $this->cookie->get('wx_unionid')){
                        if (!defined('WX_UNIONID')) {
                            define('WX_UNIONID', $wx_unionid);
                        }
                    }
                    if (!defined('WX_OPENID')) {
                        define('WX_OPENID', $wx_openid);
                    }                   
                }
            }
        }
        if (empty($wx_openid)) {
            $this->msgbox->add('获取授权失败', 105);
            $this->msgbox->set_data('forward', $this->mklink('index'));
        }
        return $wx_openid;
    }
  

  
    protected function wechat_client()
    {
        static $client = null;
        if ($client === null) {
            $client = K::M('weixin/wechat')->wechat_client();
        }
        return $client;
    }

}
