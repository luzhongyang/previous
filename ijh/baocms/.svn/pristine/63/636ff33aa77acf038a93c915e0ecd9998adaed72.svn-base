<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CommonAction extends Action {

    protected $uid = 0;
    protected $member = array();
    protected $_CONFIG = array();
    protected $seodatas = array();
    protected $shopcates = array();
    protected $citys = array();
    protected $areas = array();
    protected $bizs = array();
    protected $template_setting = array();
    protected $city_id = 0;
    protected $city = array();
    protected $_allow_fields = '';

    protected function _initialize() {
        define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
        
        
        $this->_CONFIG = D('Setting')->fetchAll();
        $this->citys = D('City')->fetchAll();
        $this->assign('citys', $this->citys);
        
       
        $this->city_id = cookie('city_id');
        if(empty($this->city_id)){
            import('ORG/Net/IpLocation');
            $IpLocation = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
            $result = $IpLocation->getlocation($_SERVER['REMOTE_ADDR']);
            foreach ($this->citys as $val) {
                if (strstr($result['country'], $val['name'])) {
                    $city = $val;
                    $this->city_id = $val['city_id'];
                    break;
                }
            }
            if(empty($city)){
                $this->city_id = $this->_CONFIG['site']['city_id'];
                $city = $this->citys[$this->_CONFIG['site']['city_id']];
            }  
        }  else{
            $city = $this->citys[$this->city_id];
        }
        $this->city = $city;
        
        $this->uid =  getUid();
        if (!empty($this->uid)) {
            $this->member = D('Users')->find($this->uid);
            if(empty($this->member)){//避免别的地方仅仅庞大了用户的COOKIE了而忽视数据库有木有用户了
                setUid(0);
                $this->uid = 0;
            }
        }

		$goods = cookie('goods');
		$cartnum = 0;
		foreach($goods as $k => $v){
			$cartnum+=$v;
		}
		$this->assign('cartnum', $cartnum);
        
         //这里主要处理推广链接入口！如果是用户推广进来的会增加到COOKIE
        $invite = (int) $this->_get('invite');
        if (!empty($invite)) { //这里改成了获得积分
            cookie('invite_id', $invite);
        }
        //全民推广员结束
        
        searchWordFrom(); //关键字已经员工推广判断

        //有很多地方需要用到所以这里调用了，因为这些都有缓存，不在设置为类的属性让子类继承了
        $this->shopcates = D('Shopcate')->fetchAll();
        $this->assign('shopcates', $this->shopcates);
        
        $this->Tuancates = D('Tuancate')->fetchAll();
        $this->assign('tuancates', $this->Tuancates);
        
        $this->areas = D('Area')->fetchAll();
        $areass = array();
        foreach($this->areas as $key=>$v){
            if($v['city_id'] == $this->city_id){
                $areass[$v['area_id']] = $this->areas[$key];
            }
        }
        $this->assign('areas', $areass);
        
        $this->bizs = D('Business')->fetchAll();
        $this->assign('bizs', $this->bizs);

        $limit_area = array();
        foreach($this->areas as $k=>$val){
            if($val['city_id'] == $this->city_id){
                $limit_area[$val['area_id']] = $val['area_id'];
            }
        }
        $this->assign('limit_area',$limit_area);
        $this->assign('ctl', strtolower(MODULE_NAME)); //主要方便调用
        $this->assign('act', ACTION_NAME);
        $this->assign('nowtime', NOW_TIME); // 主要标签短
        $current_url = strtolower(MODULE_NAME).'/'.ACTION_NAME;
        $this->assign('current_url',$current_url);
        $this->assign('func',D('Pcfunction')->where(array('is_show'=>1,'is_nav'=>1))->order('orderby ASC')->limit(9)->select());
        $this->assign('func2',D('Pcfunction')->where(array('is_show'=>1,'is_nav'=>0))->order('orderby ASC')->select());
        $this->assign('city_name', $city['name']); //您当前可能在的城市
        $this->assign('city_id', $this->city_id);
        $this->assign('city',$city);
		//$this->getelash($city['name']);
        //模版的选择
        $this->getTemplateTheme();
        $this->template_setting = D('Templatesetting')->detail($this->theme);
        
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('MEMBER', $this->member);
        $this->assign('today', TODAY); //兼容模版的其他写法
        $this->assign('now', NOW); //兼容模版的其他写法
        $city_ids = array('0',$this->city_id);
        $city_ids = join(',', $city_ids);
        $this->assign('city_ids',$city_ids);
    }
	// 这里处理文字翻译
	public function getelash($str)
	{
		include_once "Baocms/Lib/libs/English/english.php";
		$english = (array)new english();
		if($english["str_place"][$str]){
			return $english["str_place"][$str];
		}else{
			return $str;
		}
	}

    //购物车

    private function seo() {
        $seo = D('Seo')->fetchAll();
        $this->seodatas['sitename'] = $this->_CONFIG['site']['sitename'];
        $this->seodatas['tel'] = $this->_CONFIG['site']['tel'];
        $key = strtolower(MODULE_NAME . '_' . ACTION_NAME);
        if (isset($seo[$key])) {
            $this->assign('seo_title', $this->tmplToStr($seo[$key]['seo_title'], $this->seodatas));
            $this->assign('seo_keywords', $this->tmplToStr($seo[$key]['seo_keywords'], $this->seodatas));
            $this->assign('seo_description', $this->tmplToStr($seo[$key]['seo_desc'], $this->seodatas));
        } else {
            $this->assign('seo_title', $this->_CONFIG['site']['title']);
            $this->assign('seo_keywords', $this->_CONFIG['site']['keyword']);
            $this->assign('seo_description', $this->_CONFIG['site']['description']);
        }
    }

    private function tmplToStr($str, $datas) {
        return tmplToStr($str, $datas);
    }

    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        $this->seo();
        parent::display($this->parseTemplate($templateFile), $charset, $contentType, $content = '', $prefix = '');
    }

    private function parseTemplate($template = '') {

        $depr = C('TMPL_FILE_DEPR');
        $template = str_replace(':', $depr, $template);
        // 获取当前主题名称
        $theme = $this->getTemplateTheme();
        
        define('NOW_PATH',BASE_PATH.'/themes/'.$theme.'Pchome/');
       
        // 获取当前主题的模版路径
        define('THEME_PATH', BASE_PATH . '/themes/default/Pchome/');
        define('APP_TMPL_PATH', __ROOT__ . '/themes/default/Pchome/');
        // 分析模板文件规则
        if ('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
        } elseif (false === strpos($template, '/')) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower($template);
        }
        
        $file = NOW_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
        if(file_exists($file)) return $file;
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }

     private function getTemplateTheme() {
        define('THEME_NAME','default');

        if ($this->theme) { // 指定模板主题
            $theme = $this->theme;
        } else {
            /* 获取模板主题名称 */
            $default = D('Template')->getDefaultTheme();
            $themes = D('Template')->fetchAll();
         
           if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])) {
                    $theme = $_GET[$t];
                    cookie('think_template', $theme, 864000);
                } elseif(!empty($this->city['theme'])){
                    $theme = $this->city['theme'];
                }elseif (cookie('think_template')) {
                    $theme = cookie('think_template');
                } 
                if (!isset($themes[$theme])) {
                    $theme = $default;
                }
              
            }else{
                $theme = $default;
            }
        }
        return $theme ? $theme . '/' : '';
    }

    protected function baoMsg($message, $jumpUrl = '', $time = 3000,$callback = '',$parent=true) {
        $parents = $parent ? 'parent.':'';
        $str = '<script>';
        $str .=$parents.'bmsg("' . $message . '","' . $jumpUrl .'","'.$time. '","'.$callback.'");';
        $str.='</script>';
        exit($str);
    }
    
    protected function baoOpen($message, $close = true, $style) {
        $str = '<script>';
        $str .='parent.bopen("' . $message . '","' . $close .'","'.$style. '");';
        $str.='</script>';
        exit($str);
    }
    
    protected function baoSuccess($message, $jumpUrl = '', $time = 3000, $parent = true) {
        $this->baoMsg($message,$jumpUrl,$time,'',$parent);
    }

    protected function baoJump($jumpUrl) {
        $str = '<script>';
        $str .='parent.jumpUrl("' . $jumpUrl . '");';
        $str.='</script>';
        exit($str);
    }

    protected function baoErrorJump($message, $jumpUrl = '', $time = 3000) {
        $this->baoMsg($message,$jumpUrl,$time);
    }

    protected function baoError($message, $time = 3000, $yzm = false, $parent = true) {

        $parent = $parent ? 'parent.' : '';
        $str = '<script>';
        if ($yzm) {
            $str .= $parent . 'bmsg("' . $message . '","",' . $time . ',"yzmCode()");';
        } else {
            $str .= $parent . 'bmsg("' . $message . '","",' . $time . ');';
        }
        $str.='</script>';
        exit($str);
    }

    protected function baoLoginSuccess() { //异步登录
        $str = '<script>';
        $str .='parent.parent.LoginSuccess();';
        $str.='</script>';
        exit($str);
    }

    protected function ajaxLogin() {
        if ($mini = $this->_get('mini')) { //如果是迷你的弹出层操作就输出0即可
            die('0');
        }
        $str = '<script>';
        $str .='parent.ajaxLogin();';
        $str.='</script>';
        exit($str);
    }

    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
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

    protected function ipToArea($_ip) {
        return IpToArea($_ip);
    }
}
