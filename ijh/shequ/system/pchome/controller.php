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
    protected $city_id = '';

    public function __construct(&$system)
    {
        parent::__construct($system);
        $this->cookie = $system->cookie;
        $this->system->config->get('mobile');
        $this->system->objctl = &$this;
        //$this->msgbox->template("weidian/page/notice.html");
        $this->msgbox->template("pchome/page/notice.html");
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
        $city_id = $this->system->cookie->get('city_id');
        if(!$city_id){
            //如果没有CITY_ID的COOKIE，根据IP自动获取城市代码如下：
            $data = K::M('net/http')->callapi('tools/ip/geo',array('ip'=>__IP));
            $city_code = $data['citycode'];
            //通过区号得到城市记录
            if($city = K::M('data/city')->find(array('city_code'=>$city_code))){
                $this->city_id = $city['city_id'];
                $this->city = $city;
            }
        }else{
            $this->city_id = $city_id;
            $this->city = K::M('data/city')->detail($this->city_id);
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
        $this->MEMBER['message'] = K::M('member/message')->count(array('is_read'=>0,'uid'=>$this->uid));
        if($this->uid){
            $this->pagedata['MEMBER'] = $this->MEMBER;
        }
       
        //当前city
        $this->pagedata['city'] = $this->city;
        
        //顶部热门商家
        $this->pagedata['hot_shop'] = K::M('shop/shop')->items(array('closed'=>0,'audit'=>1),array('score'=>'asc'),1,5);
        
        //获取积分商城购物车总数
        if($mallcart = unserialize($this->cookie->get('mallcart'))) {
            foreach($mallcart as $k=>$v){
                $ids[$k] =$k; 
                $total['count'] += $v;
            }
        }
        $this->pagedata['top_mall_count']= $total;
        //获取结束
        
        //商户分类
        $this->pagedata['cates'] = K::M('shop/cate')->tree();
        $this->pagedata['cates_list'] = K::M('shop/cate')->fetch_all();
        //end
        $this->pagedata['peitime'] = K::M('shop/comment')->peitime(); //
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

    

    public function check_login()
    {
        if(!$this->uid){
            if($this->request['XREQ'] || $this->request['MINI']){
                $this->msgbox->add('很抱歉，你还没有登录不能访问', 101);
            }else{
                $session =K::M('system/session')->start();
                $session->set('login_url',$_SERVER['HTTP_REFERER']);
                $this->tmpl = 'pchome/passport/login.html';
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

}
