<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 9343 2015-03-24 07:07:00Z youyi $
 */
define('__APP__', 'merchant');
define('__APP_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('__CORE_DIR', dirname(__APP_DIR) . DIRECTORY_SEPARATOR);
define('IN_MOBILE', true);
define('IN_MERCHANT', true);

if (!file_exists(__CORE_DIR . 'data/install.lock')) {
    header('Location:../install/index.php');
    exit();
}
require(__CORE_DIR . "framework/kernel.php");

class Index extends kernel
{
    protected $_default_request = array('ctl' => 'index', 'act' => 'index', 'type' => 'html', 'args' => null);

    public function __construct($uri = null)
    {
        $this->_cust_uri = $uri;
        parent::__construct();
    }

    protected function _init()
    {
        $guest_allow = array('index:login', 'index:verify', 'index:loginout');
        if ($OATOKEN = trim($_POST['OATOKEN'])) {
            if ($a = $this->load_model('secure/crypt')->hexarr($OATOKEN)) {
                if ($a['ATOKEN'] && $a['AGENT']) {
                    $_SERVER['HTTP_USER_AGENT'] = $a['AGENT'];
                    $_COOKIE[__CFG::C_PREFIX . 'ATOKEN'] = $a['ATOKEN'];
                }
            }
        }
        define('CITY_ID', $this->admin->admin['city_id']);
        parent::_init();
        require(__APP_DIR . 'controller.php');
        $act = $this->request['ctl'] . ':' . $this->request['act'];

    }

    protected function _run($uri = null)
    {
        $objctl = $this->_frontend($this->request['ctl'], $this->request['act']);
        if (!is_object($objctl)) $this->error(404);
//{{{演示帐号开始 
        $guest_allow = array('index:login', 'index:verify', 'index:loginout');
        $act = $this->request['ctl'] . ':' . $this->request['act'];
        if (!in_array($act, $guest_allow)) {
            $admin_name = strtolower($this->admin->admin['admin_name']);
            if (strstr($admin_name, 'demo')) {
                $_FILES = array();
                if (in_array(strtolower($this->request['act']), array('delete', 'doaudit', 'batch')) || (strtoupper($_SERVER['REQUEST_METHOD']) === 'POST')) {
                    $this->msgbox->add('演示帐号不能提交数据', 211);
                    $this->msgbox->response();
                } else if ($admin_name != 'demo' . date("Ymd")) {
                    $this->msgbox->add('演示帐号已经过期,联系客服重新获取', 212);
                    $this->msgbox->response();
                }
            }
        }
//演示帐号结束}}}}        
        if ($objctl->__call) {
            array_unshift($this->request['args'], $this->request['act']);
            $this->request['act'] = $objctl->__call;
        }
        if (!$this->call($objctl, $this->request['act'], $this->request['args'])) {
            trigger_error("not find {$this->request[ctl]}:{$this->request[act]}");
            $this->error(404);
        }
        $this->msgbox->response();
    }

    protected function _route($uri = null)
    {
        if ($uri === null && $this->_cust_uri !== null) {
            $uri = $this->_cust_uri;
        }
        $request = parent::_route($uri);

        $request['host'] = $host = $_SERVER['HTTP_HOST'];
        $request['ctl'] = trim($request['ctl'], '/');
        switch ($request['ctl']) {

            case 'merchant' :
                $request['ctl'] = 'merchant/index';
                break;

            case 'cloud/ucenter' :
                $request['ctl'] = 'cloud/ucenter/index';
                break;
        }
        if (K::M('net/sniffer')->check_mobile()) {
            define('IS_MOBILE', true);
            if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                define('IN_WEIXIN', true);
                $request['IN_WEIXIN'] = IN_WEIXIN;
            }
        }

        if ($UxLocation = $_COOKIE[__CFG::C_PREFIX . 'UxLocation']) {
            $UxLocation = str_replace('\\\"', '\"', $UxLocation);
            $request['UxLocation'] = json_decode($UxLocation, true);
        }
        $request['MINI'] = $_REQUEST['MINI'] ? $_REQUEST['MINI'] : false;
        $request['XREQ'] = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST' ? true : false;
        defined('IS_AJAX') && define('IS_AJAX', $request['XREQ']);
        $this->request = &$request;
        return $request;
    }

    protected function _frontend($ctl, $act = 'index')
    {
        if (substr($ctl, 0, 9) == 'merchant/') {
            Import::C('merchant');
        }

        if (!$clsName = Import::C(__APP__ . ":$ctl")) {
            if (!preg_match('/^([\w\/]+)\/(\w+)$/i', $ctl, $m)) {
                if (!preg_match('/^\/(index.php)?\?/i', $_SERVER['REQUEST_URI'])) {
                    $this->error(404);
                }
                $m = array('index:index', 'index', 'index');
                $clsName = Import::C(__APP__ . ":index");
            } else if (!$clsName = Import::C(__APP__ . ":{$m[1]}")) {
                if (!preg_match('/^\/(index.php)?\?/i', $_SERVER['REQUEST_URI'])) {
                    $this->error(404);
                }
                $m = array('index:index', 'index', 'index');
                $clsName = Import::C(__APP__ . ":index");
            }
            $this->request['ctl'] = $m[1];
            $this->request['act'] = $m[2];
            array_unshift($this->request['args'], $act);
        }
        $object = new $clsName($this);
        return $object;
    }

    public function mklink($ctl, $act = 'index', $args = array(), $extends = '.html', $gets = array())
    {
        if ($args && is_array($args)) {
            $args = '-' . implode('-', $args);
        } else {
            $args = '';
        }
        return __APP_URL . "/?{$ctl}-{$act}{$args}{$extends}";
    }
}

new Index();