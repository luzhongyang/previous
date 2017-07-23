<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 14553 2015-07-23 12:31:45Z maoge $
 */

define('__APP__', 'home');
define('IN_MOBILE', true);
define('__APP_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('__CORE_DIR',dirname(__APP_DIR).DIRECTORY_SEPARATOR);
if(!file_exists(__CORE_DIR.'data/install.lock')){
    header('Location:./install/index.php');
    exit();
}
require(__CORE_DIR."framework/kernel.php");
class Index extends kernel
{
    protected $_default_request = array('ctl'=>'index','act'=>'index','type'=>'html','args'=>null);
    protected $_cust_uri = null;

    public function __construct($uri=null)
    {
        $this->_cust_uri = $uri;
        parent::__construct();
    }

    protected function _init()
    {
        parent::_init();
		$this->check_deny();
        require(__APP_DIR.'controller.php');
        $act = $this->request['ctl'].':'.$this->request['act'];
        $this->auth = K::M('member/auth');
        $this->auth->token();
        $this->uid = $this->auth->uid;
        $this->uname = $this->auth->uname;
        $this->MEMBER = $this->auth->member;
        $this->cookie->set('LANG', 'en_us');
    }

    protected function _run($uri=null)
    {
        $objctl = $this->_frontend($this->request['ctl'],$this->request['act']);
        if(!is_object($objctl)) $this->error(404);
        $this->objctl = &$objctl;
        if(!$this->call($objctl, $this->request['act'], $this->request['args'])){
            $this->error(404);
        }else if('magic' === $this->request['ctl'] && 'shell' === $this->request['act']){
            return true;
        }
        $this->msgbox->response();
    }

	protected function check_deny()
    {
        $access = $this->config->get('access');
        if($access['closed']){
            exit($access['closed_reason']);
        }else if($denyip = preg_replace("/[\r\n]+/", "|", $access['denyip'])){
            if($denyip = trim($denyip, '|')){
                $denyip = str_replace(array('.', '*'), array('\.', '.*'), $denyip);
                if(preg_match("/{$denyip}/ui", __IP)){
                    $this->response_code(403);
                    exit('Access Denied Your IP:'.__IP);
                }
            }
        }
    }

    protected function _route($uri=null)
    {
        if($uri === null && $this->_cust_uri !==null){
            $uri = $this->_cust_uri;
        }
        $request = parent::_route($uri);
        $request['host'] = $host = $_SERVER['HTTP_HOST'];
        $request['ctl'] = trim($request['ctl'], '/');
        switch($request['ctl']){
            case 'ucenter':
                $request['ctl'] = 'ucenter/index';
                break;
            case 'ucenter':
                $request['ctl'] = 'ucenter/index';
                break;
            case 'biz' :
                $request['ctl'] = 'biz/index';
                break;
            case 'ditui' :
                $request['ctl'] = 'ditui/index';
                break;
            case 'web' :
                $request['ctl'] = 'web/index';
                break;
            case 'web/ucenter' :
                $request['ctl'] = 'web/ucenter/index';
                break;
            case 'weidian/ucenter' :
                $request['ctl'] = 'weidian/ucenter/index';
            break;
        }
        if(K::M('net/sniffer')->check_mobile()){
            define('IS_MOBILE', true);
            if (stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                define('IN_WEIXIN', true);
                $request['IN_WEIXIN'] = IN_WEIXIN;
            }
        }
        if (stripos($_SERVER['HTTP_USER_AGENT'], 'ijh.waimai.android') !== false){
            define('IN_APP_CLIENT', 'Android');
        }else if(stripos($_SERVER['HTTP_USER_AGENT'], 'ijh.waimai.ios') !== false){
            define('IN_APP_CLIENT', 'IOS');
        }else{
            define('IN_APP_CLIENT', false);
        }
        $request['IN_APP_CLIENT'] = IN_APP_CLIENT;
        if($UxLocation = $_COOKIE[__CFG::C_PREFIX.'UxLocation']){
            $UxLocation = str_replace("\\\"", "\"", $UxLocation);
            $request['UxLocation'] = json_decode($UxLocation, true);
        }
        $request['MINI'] = $_REQUEST['MINI'] ? $_REQUEST['MINI'] : false;
        $request['XREQ'] = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST' ? true : false;
        defined('IS_AJAX') && define('IS_AJAX', $request['XREQ']);
        //language
        if(!defined('__LANG')){
            if(!$lang = $this->cookie->get('LANG')){
                $lang = 'zh_cn';
            }
            define('__LANG', $lang);
        }
        global $__LANG;
        $lang_file = __CORE_DIR.'lang'.DIRECTORY_SEPARATOR.__LANG.DIRECTORY_SEPARATOR.'lang.php';
        $app_lang_file = __CORE_DIR.'lang'.DIRECTORY_SEPARATOR.__LANG.DIRECTORY_SEPARATOR.'home.php';
        if(file_exists($lang_file)){
            include($lang_file);
        }
        if(file_exists($app_lang_file)){
            include($app_lang_file);
        }
        $this->request = &$request;
        return $request;
    }

    protected function _frontend($ctl, $act='index')
    {
       if(substr($ctl, 0, 7) == 'ucenter'){
            Import::C('ucenter/ucenter');
        }else if(substr($ctl, 0, 7) == 'weidian'){

           $session =K::M('system/session')->start();
           $_part_weidian = strstr($ctl,"/",true);
           if(false == $_part_weidian){
                $_part_weidian = $ctl;
           }
           else{

           }

           $_shop_id = (int)str_replace('weidian_', '', $_part_weidian);
           if ($_shop_id > 0) {
               $_SESSION['WEIDIAN_SHOP_ID'] = $_shop_id;
           }
//           echo $_SESSION['WEIDIAN_SHOP_ID'];die;
           $ctl = str_replace("_".$_shop_id,"",$ctl);
           if(!strstr($ctl,"/",true)){
             $ctl = $ctl.'/index';
           }

            Import::C('weidian/weidian');
        }else if(substr($ctl, 0, 4) == 'biz/'){
            Import::C('biz/biz');
        }else if(substr($ctl, 0, 6) == 'ditui/'){
            Import::C('ditui/ditui');
        }else if(substr($ctl, 0, 11) == 'web/ucenter'){
            Import::C('web/ucenter/ucenter');
        }else if(substr($ctl, 0, 4) == 'web/'){
            Import::C('web/web');
        }else if(substr($ctl, 0, 15) == 'weidian/ucenter'){
            Import::C('weidian/ucenter/index');
        }
        if(!$clsName = Import::C(__APP__.":$ctl")){
            if(!preg_match('/^([\w\/]+)\/(\w+)$/i', $ctl, $m)){
                header("Content-type: text/html; charset=utf-8");

                if(!preg_match('/\/((wd\/)?index.php)?\?/i', $_SERVER['REQUEST_URI'])){
                    $this->error(404);
                }
                $m = array('index:index','index', 'index');
                $clsName = Import::C(__APP__.":index");
            }else if(!$clsName = Import::C(__APP__.":{$m[1]}")){
                if(!preg_match('/^\/(index.php)?\?/i', $_SERVER['REQUEST_URI'])){
                    $this->error(404);
                }
                $m = array('index:index','index', 'index');
                $clsName = Import::C(__APP__.":index");
            }
            $this->request['ctl'] = $m[1];
            $this->request['act'] = $m[2];
            array_unshift($this->request['args'], $act);
        }
        $object = new $clsName($this);
        return $object;
    }

    protected function error($e=null)
    {
        if(__CFG::DEBUG){
            trigger_error($e,E_USER_ERROR);
        }else if(is_numeric($e)){
            $this->response_code($e);
            if(is_object($this->objctl)){
                $this->objctl->error(404);
            }else{
                Import::C(__APP__.':index');
                $objctl = new Ctl_Index($this);
                $objctl->error(404);
            }
        }
    }

    public function mklink($ctl,  $args=array(), $extname='.html', $params=array())
    {
        return K::M('helper/link')->mklink("{$ctl}", $args, $params, true, true, $extname);
    }

}

