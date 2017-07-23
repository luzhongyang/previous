<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: index.php 14553 2015-07-23 12:31:45Z youyi $
 */

define('__APP__', 'api');
define('IN_APP', 'api');
define('__APP_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('__CORE_DIR',dirname(__APP_DIR).DIRECTORY_SEPARATOR);
if(!file_exists(__CORE_DIR.'data/install.lock')){
    exit('{"error":"-1", "message":"system not install"}');
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
        header("Content-Type:text/plain");
        $CLIENT_API = strtoupper($_REQUEST['CLIENT_API']);
        $CLIENT_OS  = strtoupper($_REQUEST['CLIENT_OS']);
        $CLIENT_VER = strtoupper($_REQUEST['CLIENT_VER']);
        if(!in_array($CLIENT_API, array('CUSTOM', 'BIZ', 'STAFF','CASHIER'))){
            $CLIENT_API = 'CUSTOM';
        }
        if(!in_array($CLIENT_OS, array('IOS', 'ANDROID', 'WEIXIN'))){
            $CLIENT_OS = 'IOS';
        }
        define('CLIENT_API', $CLIENT_API);
        define('CLIENT_OS', $CLIENT_OS);
        define('CLIENT_VER', $CLIENT_VER);
        define('__LNG', $_REQUEST['LNG']);
        define('__LAT', $_REQUEST['LAT']);
        $this->check_deny();
        require(__APP_DIR.'controller.php');
        $act = $this->request['ctl'].':'.$this->request['act'];
        $TOKEN = strtoupper($_REQUEST['TOKEN']);
        if(CLIENT_API == 'STAFF'){
            $this->auth = K::M('staff/auth');
            $this->auth->token($TOKEN);
            $this->cookie->set('STAFF-TOKEN', $TOKEN);
            $this->staff_id = $this->auth->staff_id;
            $this->staff = $this->auth->staff;
        }else if(CLIENT_API == 'BIZ'){
            $this->auth = K::M('shop/auth');
            $this->auth->token($TOKEN);
            $this->cookie->set('BIZ-TOKEN', $TOKEN);
            $this->shop_id = $this->auth->shop_id;
            $this->shop = $this->auth->shop;
        }else if(CLIENT_API == 'CASHIER'){
            $this->auth = K::M('cashier/auth');
            $this->auth->token($TOKEN);
            $this->cookie->set('STAFF-TOKEN', $TOKEN);
            $this->staff_id = $this->auth->staff_id;
            $this->staff = $this->auth->staff;
        }else{
            $this->auth = K::M('member/auth');
            $this->auth->token($TOKEN);
            $this->cookie->set('TOKEN', $TOKEN);
            $this->uid = $this->auth->uid;
            $this->uname = $this->auth->uname;
            $this->MEMBER = $this->auth->member;
        }
    }

    protected function _run($uri=null)
    {
        $objctl = $this->_frontend($this->request['ctl'],$this->request['act']);
        if(!is_object($objctl)) $this->error(404);
        $this->objctl = &$objctl;
        if(!$this->call($objctl,$this->request['act'], array($this->request['data']))){
            $this->error(404);
        }else if('magic' === $this->request['ctl'] && 'shell' === $this->request['act']){
            return true;
        }
        $this->msgbox->json();
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
        }else{
            $uri = $_REQUEST['API'];
        }
        $request = parent::_route($uri);
        $request['api'] = $_REQUEST['API'];
        $request['host'] = $host = $_SERVER['HTTP_HOST'];
        $CITY_ID = (int)$_POST['CITY_ID'];
        if(!$city = K::M('data/city')->city($CITY_ID)){
            $siteCfg = $this->config->get('site');
            if(!$city = K::M('data/city')->city($siteCfg['city_id'])){
                //exit('{"error":"11", "message":"site city config error"}');
            }
            $CITY_ID = (int)$city['city_id'];
        }
        define('CITY_ID', $CITY_ID);
        $request['CITY_ID'] = $CITY_ID;
        $request['city'] = $city;
        if($jsondata = $_REQUEST['data']){
            if(defined('__API_ENDATA') &&  __API_ENDATA){
                $_POST['jsondata'] = $jsondata;
                $jsondata = K::M('secure/mcrypt')->decode($jsondata, __API_KEY);
                $_POST['decode'] = $jsondata;
            }
            if($data = json_decode($jsondata, true)){
                $data = K::M('content/filter')->addslashes($data);
            }else{
                $data = array();
            }
            $request['data'] = $data;
        }
        $this->request = &$request;
        return $request;
    }


    protected function _frontend($ctl, $act='index')
    {
        if(CLIENT_API == 'CASHIER'){
            Import::C('cashier/cashier');
        }else if(CLIENT_API == 'STAFF'){
            Import::C('staff/staff');
        }else if(CLIENT_API == 'BIZ'){
            Import::C('biz/biz');
            if(substr($ctl, 0, 11) == 'biz/waimai/'){
                Import::C('biz/waimai');
            }
        }
        if(!($clsName = Import::C(__APP__.":$ctl")) && $act== 'index'){
            if(!preg_match('/^([\w\/]+)\/(\w+)$/i', $ctl, $m)){
                $this->error(404);
            }else if(!$clsName = Import::C(__APP__.":{$m[1]}")){
                $this->error(404);
            }
            $this->request['ctl'] = $m[1];
            $this->request['act'] = $m[2];
            array_unshift($this->request['args']);
        }
        $object = new $clsName($this);
        return $object;
    }

    protected function error($e=null)
    {
        if($e == 404){
            exit('{"error":"404","message":"Api NotFund"}');
        }else if(is_numeric($e)){
            exit('{"error":"'.$e.'","message":"Api Error"}');
        }else{
            exit('{"error":"-1","message":"'.$e.'"}');
        }
    }

    public function mklink($ctl, $act='index', $args=array(), $extname='.html', $params=array())
    {
        return K::M('helper/link')->mklink("{$ctl}:{$act}", $args, $params,true,true,$extname);
    }
}
