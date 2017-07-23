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
    protected $citys = array();
    protected $areas = array();
    protected $bizs = array();
    protected $city_id = 0;
    protected $city = array();
    protected $mobile_title = '';
    protected $_allow_fields = '';
      //private  function logs($log){
      // echo $log;die;
       // $fp = fopen(BASE_PATH.'/Baocms/Lib/Action/Mobile/logs.php', 'a+');
       // fwrite($fp,$log.";\n");
       // fclose($fp);
    // }
    protected function _initialize() {
//$this->logs(var_export($_COOKIE,true));        
//file_put_contents('./bbb.txt', $_SERVER['HTTP_USER_AGENT']);
      //  echo $_SERVER['HTTP_USER_AGENT'];
        //echo is_app();die;
        define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
        define('IN_MOBILE', true);
        $is_app = (boolean)is_app();
        define('IS_APP', $is_app);
        if (!IS_APP) {
            $is_weixin = (boolean)is_weixin();
        } else {
           // echo $_SERVER['HTTP_USER_AGENT'];die;
            $is_android =  is_android();
            define('IS_ANDROID', $is_android);
            $is_weixin = false;
            $this->assign('is_android',$is_android);
        }
        define('IS_WEIXIN', $is_weixin);
        $this->_CONFIG = D('Setting')->fetchAll();
        $this->citys = D('City')->fetchAll();
        $this->assign('citys', $this->citys);
        $this->city_id = cookie('city_id');
        if (empty($this->city_id)) {
            import('ORG/Net/IpLocation');
            $IpLocation = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
             $ip = get_client_ip();
             $result = $IpLocation->getlocation($ip);
            //$result = $IpLocation->getlocation($_SERVER['REMOTE_ADDR']);
            foreach ($this->citys as $val) {
                if (strstr($result['country'], $val['name'])) {
                    $city = $val;
                    $this->city_id = $val['city_id'];
                    break;
                }
            }
            if (empty($city)) {
                $this->city_id = $this->_CONFIG['site']['city_id'];
                $city = $this->citys[$this->_CONFIG['site']['city_id']];
            }
        } else {
            $city = $this->citys[$this->city_id];
        }
        $this->city = $city;

        searchWordFrom();
        $this->uid = getUid();
        if (!empty($this->uid)) {
            $this->member = D('Users')->find($this->uid);
        } else {
            $access = cookie('weixin_access');
            if (IS_WEIXIN && strtolower(MODULE_NAME) != 'passport' && empty($access) && !empty($this->_CONFIG['site']['weixin'])) {// 新增了后台开关
                header("Location:" . U('passport/wxlogin'));
                die;
            }
        }
        //这里主要处理推广链接入口！如果是用户推广进来的会增加到COOKIE
        $invite = (int) $this->_get('invite');
        if (!empty($invite)) { //这里改成了获得积分
            cookie('invite_id', $invite);
        }
        //全民推广员结束
        $this->assign('CONFIG', $this->_CONFIG);
        $this->assign('MEMBER', $this->member);
        $this->assign('shopcates', D('Shopcate')->fetchAll());
        $this->assign('tuancates', D('Tuancate')->fetchAll());
        $this->assign('goodscates', D('Goodscate')->fetchAll());
        $this->areas = D('Area')->fetchAll();
        $areass = array();
        foreach ($this->areas as $key => $v) {
            if ($v['city_id'] == $this->city_id) {
                $areass[$v['area_id']] = $this->areas[$key];
            }
        }

	
        $this->assign('areas', $areass);
        $this->bizs = D('Business')->fetchAll();
        $this->assign('bizs', $this->bizs);
        $this->assign('today', TODAY); //兼容模版的其他写法
        $this->assign('now', NOW); 
        $this->assign('nowtime', NOW_TIME);
        $this->assign('ctl', strtolower(MODULE_NAME)); //主要方便调用
        $this->assign('act', ACTION_NAME);
        $this->assign('is_weixin', IS_WEIXIN);
        $this->assign('is_app',IS_APP);
        $this->assign('city_name', $city['name']); //您当前可能在的城市
        $this->assign('city_id', $this->city_id);
        $this->assign('city', $city);
        $city_ids = array('0', $this->city_id);
        $city_ids = join(',', $city_ids);
        $this->assign('city_ids', $city_ids);
        $this->msg();
    }

    protected function check_mobile() {//检测用户是否绑定手机
        $u = D('Users');
        $m = $u->where('user_id =' . $this->uid)->getField('mobile');

        if ($m == null || !isMobile($m)) {
            $mobile_open = 0;
        } else {
            $mobile_open = 1;
        }
        $this->assign('mobile_open', $mobile_open); //0为未绑定
    }

    protected function mobile() {   //绑定手机
        if ($this->isPost()) {
            $mobile = $this->_post('mobile');
            $yzm = $this->_post('yzm');
            if (empty($mobile) || empty($yzm))
                $this->ajaxReturn(array('status' => 'error', 'msg' => '请填写正确的手机及手机收到的验证码！'));
            $s_mobile = session('mobile');
            $s_code = session('code');
            if ($mobile != $s_mobile)
                $this->ajaxReturn(array('status' => 'error', 'msg' => '手机号码和收取验证码的手机号不一致！'));
            if ($yzm != $s_code)
                $this->ajaxReturn(array('status' => 'error', 'msg' => '验证码不正确！'));
            $data = array(
                'user_id' => $this->uid,
                'mobile' => $mobile
            );
            if (D('Users')->save($data)) {
                D('Users')->integral($this->uid, 'mobile');
                D('Users')->prestige($this->uid, 'mobile');
                $this->ajaxReturn(array('status' => 'success', 'msg' => '恭喜您通过手机认证！'));
            }
            $this->ajaxReturn(array('status' => 'error', 'msg' => '更新失败！'));
        } else {

            $this->display();
        }
    }

    protected function mobile2() {   //绑定手机
        if ($this->isPost()) {
            $mobile = $this->_post('mobile');
            $yzm = $this->_post('yzm');
            if (empty($mobile) || empty($yzm))
                $this->ajaxReturn(array('status' => 'error', 'msg' => '请填写正确的手机及手机收到的验证码！'));
            $s_mobile = session('mobile');
            $s_code = session('code');
            if ($mobile != $s_mobile)
                $this->ajaxReturn(array('status' => 'error', 'msg' => '手机号码和收取验证码的手机号不一致！'));
            if ($yzm != $s_code)
                $this->ajaxReturn(array('status' => 'error', 'msg' => '验证码不正确！'));
            $data = array(
                'user_id' => $this->uid,
                'mobile' => $mobile
            );
            if (D('Users')->save($data)) {
                $this->ajaxReturn(array('status' => 'success', 'msg' => '恭喜您成功更换绑定手机号！'));
            }
            $this->ajaxReturn(array('status' => 'error', 'msg' => '更新失败！'));
        }
    }

    protected function sendsms() {
        if (!$mobile = $this->_post('mobile')) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '请输入正确的手机号码！'));
        }
        if (!isMobile($mobile)) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '请输入正确的手机号码！'));
        }
        if ($user = D('Users')->where(array('mobile' => $mobile))->find()) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '手机号码已经存在！'));
        }
        session('mobile', $mobile);
        $randstring = session('code');
        if (empty($randstring)) {
            $randstring = rand_string(6, 1);
            session('code', $randstring);
        }
        D('Sms')->sendSms('sms_code', $mobile, array('code' => $randstring));
        $this->ajaxReturn(array('status' => 'success', 'msg' => '短信发送成功，请留意收到的手机短信！', 'code' => session('code')));
    }

    protected function msg() {
        return false; //现在没有了 所以节约一下性能
        $msgs = D('Msg')->where(array('user_id' => array('IN', array(0, $this->uid))))->limit(0, 20)->select();
        $this->assign('msgs', $msgs);
        $msg_ids = array();
        foreach ($msgs as $val) {
            $msg_ids[] = $val['msg_id'];
        }
        if (!empty($this->uid)) {
            $reads = D('Msgread')->where(array('user_id' => $this->uid, 'msg_id' => array('IN', $msg_ids)))->select();
            $messagenum = count($msgs) - count($reads);
            $messagenum = $messagenum > 9 ? 9 : $messagenum;
            $readids = array();
            foreach ($reads as $val) {
                $readids[$val['msg_id']] = $val['msg_id'];
            }
            $this->assign('readids', $readids);
            $this->assign('messagenum', $messagenum);
        } else {
            $this->assign('messagenum', 0);
        }
    }

    private function seo() {
       
        $this->assign('mobile_title', $this->mobile_title);
        $this->assign('mobile_description', $this->_CONFIG['site']['description']);
    }

    private function tmplToStr($str, $datas) {
        preg_match_all('/{(.*?)}/', $str, $arr);
        foreach ($arr[1] as $k => $val) {
            $v = isset($datas[$val]) ? $datas[$val] : '';
            $str = str_replace($arr[0][$k], $v, $str);
        }
        return $str;
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
        define('NOW_PATH', BASE_PATH . '/themes/' . $theme . 'Mobile/');
        // 获取当前主题的模版路径
        define('THEME_PATH', BASE_PATH . '/themes/default/Mobile/');
        define('APP_TMPL_PATH', __ROOT__ . '/themes/default/Mobile/');

        // 分析模板文件规则
        if ('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = strtolower(MODULE_NAME) . $depr . strtolower(ACTION_NAME);
        } elseif (false === strpos($template, '/')) {
            $template = strtolower(MODULE_NAME) . $depr . strtolower($template);
        }
        $file = NOW_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
        if (file_exists($file))
            return $file;
        return THEME_PATH . $template . C('TMPL_TEMPLATE_SUFFIX');
    }

    private function getTemplateTheme() {
        define('THEME_NAME', 'default');

        if ($this->theme) { // 指定模板主题
            $theme = $this->theme;
        } else {
            /* 获取模板主题名称 */
            $default = D('Template')->getDefaultTheme();
            $themes = D('Template')->fetchAll();
            if (C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
                $t = C('VAR_TEMPLATE');
                if (isset($_GET[$t])) {
                    $theme = $_GET[$t];
                    cookie('think_template', $theme, 864000);
                } elseif (!empty($this->city['theme'])) {
                    $theme = $this->city['theme'];
                } elseif (cookie('think_template')) {
                    $theme = cookie('think_template');
                }
                if (!isset($themes[$theme])) {
                    $theme = $default;
                }
            } else {
                $theme = $default;
            }
        }
        return $theme ? $theme . '/' : '';
    }

    protected function baoSuccess($message, $jumpUrl = '', $jumpUrl2 = '', $time = 3000) {
        $str = '<script>';
        if(IS_APP){
            if($jumpUrl2){
                $str .='parent.success("' . $message . '",' . $time . ',\'getNewWebView("'.$jumpUrl .'","'. $jumpUrl2 . '")\');';
            }else{
                $str .='parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
            }
        }else{
            $str .='parent.success("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        }
        $str.='</script>';
        exit($str);
    }

    protected function baoMsg($message, $jumpUrl = '', $time = 3000) {
        $str = '<script>';
        $str .='parent.bmsg("' . $message . '","' . $jumpUrl . '","' . $time . '");';
        $str.='</script>';
        exit($str);
    }

    protected function baoErrorJump($message, $jumpUrl = '', $time = 3000) {
        $str = '<script>';
        $str .='parent.error("' . $message . '",' . $time . ',\'jumpUrl("' . $jumpUrl . '")\');';
        $str.='</script>';
        exit($str);
    }

    protected function baoError($message, $time = 3000, $yzm = false) {
        $str = '<script>';
        if ($yzm) {
            $str .='parent.error("' . $message . '",' . $time . ',"yzmCode()");';
        } else {
            $str .='parent.error("' . $message . '",' . $time . ');';
        }
        $str.='</script>';
        exit($str);
    }

    protected function baoAlert($message, $url = '') {
        $str = '<script>';
        $str.='parent.alert("' . $message . '");';
        if (!empty($url)) {
            $str.='parent.location.href="' . $url . '";';
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
