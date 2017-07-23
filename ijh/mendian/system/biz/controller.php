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
        $this->msgbox->template('biz/page/notice.html');
        $this->InitializeApp();
      
        
       

    }



    //初始化当前应用程序控制器
    protected function InitializeApp()
    {
        $this->ctlmaps  = include(dirname(__FILE__) . '/controllers/ctlmaps.php');
        $ctlmap = $this->_check_priv();
        $this->request['ctlmap'] = $ctlmap;
        $this->pagedata['ctlgroup'] = $this->ctlgroup;
        $this->pagedata['menu_list'] = $this->ctlmaps[$this->ctlgroup];
      

    }

    



    protected function _check_priv()
    {
        $ctlmap  = array();
        $request = $this->request;

        foreach($this->ctlmaps as $group=>$menu){

            foreach($menu as $k=>$v){
                foreach ($v['items'] as $kk=>$vv) {

                    if($vv['ctl'] == $request['ctl'].':'.$request['act']){
                        $this->ctlgroup = $group;
                        $this->ctlmenu = $menu;
                        $ctlmap = $vv;
                    }
                }
            }
        }
        
        if($ctlmap){
            return $ctlmap;
        }elseif($this->request['XREQ'] || $this->request['MINI'] ){
            $this->msgbox->add('很抱歉，您没有权限访问', 201);
        }else{
            $this->tmpl = 'biz/page/nopriv.html';
        }
        $this->msgbox->response();
        exit();
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
        $this->pagedata['shop'] = $this->shop;
        $this->pagedata['city_id'] = $this->system->cookie->get('UxCityId');
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

    public function getcart($shop_id)
    {
        $shop_id = (int) $shop_id;
        $cart = (array) json_decode(str_replace('\\\"', '\"', $_COOKIE['ele']), true);
        $carts = array();
        foreach ($cart as $kk => $vv) {
            foreach ($vv as $key => $v) {
                $v = (array) $v;
                $carts[$kk][$key] = $v;
                if ($v['num'] == 0) {
                    unset($carts[$kk][$key]);
                }
            }
        }
        $product_ids = $nums = array();
        foreach ($carts[$shop_id] as $k => $val) {
            $product_ids[$val['product_id']] = $val['product_id'];
            $nums[$val['product_id']] = $val['num'];
        }
        $products = K::M('product/product')->items_by_ids($product_ids);
        foreach ($products as $k => $val) {
            $products[$k]['cart_num'] = $nums[$val['product_id']];
            $products[$k]['total_price'] = $nums[$val['product_id']] * $val['price'];
        }
        return $products;
    }


    public function check_login()
    {
        if(!$this->shop){
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

    protected function wechat_client()
    {
        static $client = null;
        if ($client === null) {
            $client = K::M('weixin/wechat')->wechat_client();
        }
        return $client;
    }
    
}
