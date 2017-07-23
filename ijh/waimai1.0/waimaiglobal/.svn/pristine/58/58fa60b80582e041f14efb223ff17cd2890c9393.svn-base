<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.ctl.php 9343 2015-03-24 07:07:00Z youyi $
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Index extends Ctl
{
    

    public function index()
    {
        $this->tmpl = 'admin:page/index.html';
        $this->output();
    }

    public function welcome()
    {

        $sysinfo = array(
            'version' => JH_VERSION . ' RELEASE '. JH_RELEASE .' [<a href="http://www.ijh.cc/" class="blue" target="_blank">查看最新版本</a>]',
            'server_domain' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
            'server_os' => PHP_OS,
            'web_server' => $_SERVER["SERVER_SOFTWARE"],
            'php_version' => PHP_VERSION,
            'mysql_version' => mysql_get_server_info(),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time') . '秒',
            'memory_limit' => ini_get('memory_limit'),
            'safe_mode' => (boolean) ini_get('safe_mode') ?  'YES' : 'NO',
            'zlib' => function_exists('gzclose') ?  'YES' : 'NO',
            'curl' => function_exists("curl_getinfo") ? 'YES' : 'NO',
            'timezone' => function_exists("date_default_timezone_get") ? date_default_timezone_get() : 'NO'
        );
        if(function_exists('gd_info')){
            $gd_info = @gd_info();
            $sysinfo['gd_version'] = $gd_info["GD Version"];
        }else{
            $sysinfo['gd_version'] = '<span class="red">NO</span>';
        }
        $this->pagedata['sysinfo'] = $sysinfo;
        $sdaytime = $this->system->sdaytime;
        $this->tmpl = 'admin:page/welcome.html';
    }

    public function login()
    {
		$access = $this->system->config->get('access');
        if($_POST['admin_name']){
            if(!$name = $this->GP('admin_name')){
                $this->msgbox->add('登录名不能为空',401);
            }else if(!$passwd = $this->GP('admin_pwd')){
                $this->msgbox->add('登录密码不能为空',402);
            }else{
                $verifycode_success = true;
                $access = $this->system->config->get('access');
                if($access['verifycode']['admin']){
                    if(!$code = $this->GP('verify_code')){
                         $verifycode_success = false;
                        $this->msgbox->add('验证码不能为空',403);
                    }else if(!K::M('magic/verify')->check($code)){
                        $verifycode_success = false;
                        $this->msgbox->add('验证码不正确',403);
                    }
                    if(!$verify_code = $this->GP('verify_code')){
                        $verifycode_success = false;
                        $this->msgbox->add('验证码不正确', 212);
                    }else if(!K::M('magic/verify')->check($verify_code)){
                        $verifycode_success = false;
                        $this->msgbox->add('验证码不正确', 212);
                    }
                }
                if($verifycode_success){
                    if($this->system->admin->login($name,$passwd)){
                        header("Location:?index.html");
                        exit();
                    }
                }
            }
            $this->msgbox->show("?index-login.html");
        }else{
            $this->pagedata['admin'] = $access['verifycode']['admin'];
            $this->tmpl = 'admin:page/login.html';
            $this->output();
        }
    }

    public function loginout()
    {
        $this->admin->loginout();
        $this->msgbox->add("帐户已经安全退出!!");
    }

    public function modifypasswd()
    {
        if($this->checksubmit()){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(empty($data['oldpasswd'])){
                $this->msgbox->add('旧密码不能为空', 212);
            }else if($data['newpasswd'] != $data['confirmpasswd']){
                $this->msgbox->add('两次密码不相同', 213);
            }else if($this->admin->modifypasswd($data['oldpasswd'], $data['newpasswd'])){
                $this->msgbox->add('修改密码成功,需重新登录');
            }
        }else{
            $this->tmpl = 'admin:admin/admin/modifypasswd.html';
        }
    }

    public function verify()
    {
        K::M('magic/verify')->output();
    }

    public function page($page)
    {
        $uri = $this->request['uri'];
        if(preg_match('/page-(\w+).html/i', $uri, $match)){
            $page = $match[1];
            $this->tmpl = "admin:page/{$page}.html";
        }
    }

    public function top()
    {
        $this->pagedata['top_menu'] = $this->admin->tree();
        $this->tmpl = 'admin:context/top.html'; 
    }

    public function ijh()
    {
        $cfg = $this->system->config->get('site_config');
        header("Content-type: image/png");
        echo base64_decode(K::M('secure/crypt')->hexstr($cfg['hash']));
        exit();
    }

    public function context($mid=null)
    {
        $menu_tree = $this->admin->tree();
        if(!$mid = intval($mid)){
            $tree = array_shift($menu_tree);
        }else{
            $tree = $menu_tree[$mid];
        }
        if(!defined('__DEV_MODEL')){
            unset($tree['menu'][7]);
        }    
        $this->pagedata['menu_tree'] = $tree['menu'];
        $this->tmpl = 'admin:context/menu.html';
    }
}