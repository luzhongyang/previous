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
        $this->msgbox->template("weidian/page/notice.html");
        $this->InitializeApp();
        if (defined('IN_WEIXIN') && IN_WEIXIN) {
            if ($this->wx_openid = $this->token_openid()) {
                // if ($m = K::M('member/weixin')->detail_by_openid($this->wx_openid)) {
                //     if ($uid = (int) $m['uid']) {     //如果数据库中存在该微信id则直接登录
                //         K::M('member/auth')->manager($uid);
                //     }
                // }
            }
        }
    }

    //初始化当前应用程序控制器
    protected function InitializeApp()
    {
        if(!preg_match('/^wd(\d+)/i', $this->request['host'], $m)){
            $this->error(404);
        }else if(!$weidian = K::M('weidian/weidian')->detail($m[1])){
            $this->error(404);
        }else if( 0 == $weidian['audit']){

            $this->msgbox->add('您还没有开通微店功能', 211);
            $this->msgbox->response();
        }
        else{

            define('WD_SID', $m[1]);
            define('WEIDIAN_SHOP_ID', $m[1]);
            $this->shop_id = WEIDIAN_SHOP_ID;

				
			//查询商家信息
            $total = array();
            $week_time = __TIME-86400*7;
            $total['product'] = K::M('weidian/product')->count(array('shop_id'=>$this->shop_id,'closed'=>0,'is_onsale'=>1));
            $total['new_product'] = K::M('weidian/product')->count(array('shop_id'=>$this->shop_id,'closed'=>0,'is_onsale'=>1,'dateline'=>'>:'.$week_time));
            $total['sale'] = K::M('weidian/product')->total_sale($this->shop_id);
            $this->pagedata['total'] = $total;

            $this->weidian = $this->shop = $weidian;
        }
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
        $this->pagedata['weidian'] = $this->weidian;
        $this->pagedata['pager']['url'] = $site['url'];
        $this->pagedata['pager']['res'] = __CFG::RES_URL;
        $this->pagedata['pager']['theme'] = $site['siteurl'].'/themes';
        $this->pagedata['nowtime'] = $this->pagedata['pager']['dateline'] = __TIME;
        $this->pagedata['VER'] = JH_RELEASE;
        $this->pagedata['site'] = $site;
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

    public function getcart($shop_id,$stock_names)
    { //微店购物车
        $shop_id = (int) $shop_id;
        $cart = (array) json_decode(str_replace('\\\"', '\"', $_COOKIE['KT-WeiCart']), true);
        $carts = array();
        foreach ($cart as $kk => $vv) {
            $vv = explode(",", $vv);
            foreach ($vv as $key => $v) {
                $v = explode(":", $v);
                $s = explode("-", $v[0]);
                if(!$stock_names||in_array($v[0], $stock_names)){
                    if ($v[1] != 0) {
                        $carts[$kk][$v[0]] = array('num'=>$v[1],'product_id'=>$s[0],'stock_name'=>$s[1]);
                    }
                }
            }
        }
        //print_r($carts);die;
        $product_ids = $nums = $stock_names = array();
        $this_carts = $carts[$shop_id];
        foreach ($this_carts as $k => $val) {
            $product_ids[$val['product_id']] = $val['product_id'];
            $stock_names[] = $val['stock_name'];
        }
        $products = K::M('weidian/product')->items_by_ids($product_ids);
        $product_stocks = K::M('weidian/product/attrstock')->items(array('stock_name'=>$stock_names));
        foreach($this_carts as $k => $v){
            $this_carts[$k]['title'] = $products[$v['product_id']]['title'];
            $this_carts[$k]['ship_fee'] = $products[$v['product_id']]['ship_fee'];
            $this_carts[$k]['photo'] = $products[$v['product_id']]['photo'];
            if($v['stock_name'] == 0){ //没有属性的商品
                $this_carts[$k]['price'] =  $products[$v['product_id']]['wei_price'];
                $this_carts[$k]['stock'] = $products[$v['product_id']]['stock'];
                $this_carts[$k]['sales'] = $products[$v['product_id']]['sales'];
            }else{
                foreach($product_stocks as $k1=>$v1){
                    if($v['stock_name'] == $v1['stock_name']){
                        $this_carts[$k]['price'] =  $v1['wei_price'];
                        $this_carts[$k]['stock'] = $v1['stock'];
                        $this_carts[$k]['sales'] = $v1['sales'];
                        $this_carts[$k]['stock_real_name'] = $v1['stock_real_name'];
                    }
                }
            }
        }
        foreach($this_carts as $k=>$v){
            $this_carts[$k]['total_price'] = round($v['num'] * $v['price'],2);
        }
        return $this_carts;
    }

    public function check_login()
    {
        if(!$this->uid){
            if($this->request['XREQ'] || $this->request['MINI']){
                $this->msgbox->add('很抱歉，你还没有登录不能访问', 101);
            }else{

                $session =K::M('system/session')->start();
                $session->set('login_url',$_SERVER['HTTP_REFERER']);

//                $forward = $session->get('login_url');
//                echo $forward;die;

                $this->tmpl = 'weidian/passport/login.html';
            }
            $this->msgbox->response();
            exit();
        }
        return true;
    }

    protected function set_resource_view(&$output)
    {
        $theme = $this->default_theme();
        $output->setTemplateDir(__CFG::TMPL_DIR.$theme['theme']);
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
        $this->tmpl = "weidian/page/404.html";
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
        static $wx_openid = null;
        if ($wx_openid === null) {
            if ($code = $this->GP('WXCODE')) {
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                if($wx_unionid = $ret['unionid']){
                    if($member = K::M('member/member')->member($wx_unionid, 'wx_unionid')){
                        $this->auth->manager($m['uid']);
                    }
                    $this->cookie->set('wx_unionid', $wx_unionid);
                    $this->cookie->set('wx_openid', $ret['openid']);
                }else if ($wx_openid = $ret['openid']) {
                    if($member = K::M('member/member')->member($wx_openid, 'wx_openid')){
                        $this->auth->manager($m['uid']);
                    }
                    $this->cookie->set('wx_openid', $wx_openid);
                } else {
                    $this->msgbox->add('获取授权失败1！');
                    $this->msgbox->set_data('forward', $this->mklink('index'));
                }
            }else if ($wx_openid = $this->GP('WXOPENID')) {
                if($pos = strpos($wx_openid, '?')){
                    $wx_openid = substr($wx_openid, 0, $pos);
                }
                //$client = $this->wechat_client();
                if($member = K::M('member/member')->member($wx_openid, 'wx_openid')){
                    $this->auth->manager($member['uid']);
                }
                $this->cookie->set('wx_openid', $wx_openid);
            } else { //获取cookie的openid
                if (!$wx_openid = $this->cookie->get('wx_openid')) {
                    //$client = $this->wechat_client(); //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $authurl = 'http://fz.jhcms.cn/weixin/token/index.html?reback_url=' . urlencode($url);
                    header('Location:' . $authurl);
                    exit();
                }
            }
            if (!defined('WX_OPENID')) {
                define('WX_OPENID', $wx_openid);
            }
            if (!defined('WX_OPENID')) {
                define('WX_UNIONID', $wx_unionid);
            }
        }
        if (empty($wx_openid)) {
            $this->msgbox->add('获取授权失败！');
            $this->msgbox->set_data('forward', $this->mklink('index'));
        }
        return $wx_openid;
    }

    protected function access_openid($force = false)
    {
        static $wx_openid = null;
        if ($force || $wx_openid === null) {
            if ($code = $this->GP('code') && $code != 'wxpay') {
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                if($wx_unionid = $ret['unionid']){
                    if($member = K::M('member/member')->member($wx_unionid, 'wx_unionid')){
                        $this->auth->manager($m['uid']);
                    }
                    $this->cookie->set('wx_unionid', $wx_unionid);
                    $this->cookie->set('wx_openid', $wx_openid);
                }else if ($wx_openid = $ret['openid']) {
                    if($member = K::M('member/member')->member($wx_openid, 'wx_openid')){
                        $this->auth->manager($m['uid']);
                    }
                    $this->cookie->set('wx_openid', $wx_openid);
                } else {
                    $this->msgbox->add('获取授权失败1！');
                    $this->msgbox->set_data('forward', $this->mklink('index'));
                }
            } else {
                //获取cookie的openid
                if (!$wx_openid = $this->cookie->get('wx_openid')) {
                    $client = $this->wechat_client(); //$client
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $url = $this->mklink(null, $this->request['args'], null, 'www');
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:' . $authurl);
                    exit();
                }
            }
            if (!defined('WX_OPENID')) {
                define('WX_OPENID', $wx_openid);
            }
        }
        if (empty($wx_openid)) {
            $this->msgbox->add('获取授权失败！');
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
