<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: config.php 10736 2015-06-10 12:39:11Z maoge $
 */

if(!defined('__DEBUG')){
    define('__DEBUG', true);
}
define('__TIME',    time());
define('__CHARSET', 'UTF-8');
define('__CFG_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('__IMG_DIR', dirname(__CFG_DIR).DIRECTORY_SEPARATOR.'attachs'.DIRECTORY_SEPARATOR);
define('__TPL_DIR', dirname(__CFG_DIR).DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR);
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
define('__DEV_MODEL', true);
ini_set("display_errors", __DEBUG);
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING);
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=UTF-8");
class __CFG
{
    CONST DEBUG     = __DEBUG;
    CONST CHARSET   = __CHARSET;
    CONST DIR       = __CORE_DIR;
    CONST GPC       = MAGIC_QUOTES_GPC;
    CONST TIME      = __TIME;
    CONST TMPL_DIR  = __TPL_DIR;

    CONST RES_URL = '/static';

    CONST MYSQL = 'mysql://jh_o2o:uWF5rRVm2McNLWaA@192.168.1.10:3406/jh_waimai/jh_/UTF8';

    CONST SECRET_KEY = 'f6075a5e1ab5a3da64b42771759672f2';
    CONST Authorize = '2ef6089722ad45ed4e1be4c04ff54060';

    //Cookie
    CONST C_PREFIX  = 'KT-';
    CONST C_PATH    = '/';
    CONST C_DOMAIN  = 'waimaiglobal.jhcms.cn';
    CONST C_EXPIRE  = 2592000;
    CONST C_SECURE  = false; //https
    CONST C_HTTPONLY= true;  //httponly

    //session
    CONST S_TYPE    = 'database';
    CONST S_STAGE   = '';
    CONST S_NAME    = 'KTSSID';
    CONST S_EXPIRE  = 3600;

    //cache
    CONST CACHE_TYPE = 'file'; 
    CONST CACHE_FILE_SIZE = '32M'; //开辟缓存文件大小
    //googlemap
    CONST GMAP_SERVER_KEY = 'AIzaSyDQdgITkrUZgtz_cA7A6lxPOGDaSdd6w0o';
    CONST GMAP_CLIENT_KEY = 'AIzaSyDpffjC9Wbc5sT8B2KBg6bx1382rjo7QbY';

}