<?php

if (ini_get('magic_quotes_gpc')) {

    function stripslashesRecursive(array $array) {
        foreach ($array as $k => $v) {
            if (is_string($v)) {
                $array[$k] = stripslashes($v);
            } else if (is_array($v)) {
                $array[$k] = stripslashesRecursive($v);
            }
        }
        return $array;
    }

    $_GET = stripslashesRecursive($_GET);
    $_POST = stripslashesRecursive($_POST);
}

define('ROOT', '../');
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai'); //默认时区
error_reporting(0); //报告所有错误，0为忽略所有错误
ini_set('display_errors', '0'); //开启错误提示
define('NOW_TIME', $_SERVER['REQUEST_TIME']);
define('TODAY', date('Y-m-d', NOW_TIME));
if (file_exists(ROOT . 'attachs/upgrade65.lock')) {
    header('Location: ../index.php');
    die;
}

switch ($_GET['action']) {

    case 2:
        $is_through = true;
        //运行环境
        $sys = php_uname('s');
        $web_server = function_exists('apache_get_version') ? apache_get_version() : "";

        $PHP_GD = '';
        if (extension_loaded('gd')) {
            if (function_exists('imagepng'))
                $PHP_GD .= 'png';
            if (function_exists('imagejpeg'))
                $PHP_GD .= ' jpg';
            if (function_exists('imagegif'))
                $PHP_GD .= ' gif';
        }
        $CURL = '';
        if (function_exists('curl_init')) {
            $CURL = 1;
        }
        //目录权限
        $test_dir = array(
            ROOT . 'Baocms/Conf/',
        );

        $tmp_test_dir = array();
        foreach ($test_dir as $k => $v) {
            $is_write = 0;
            if (is_dir($v)) {
                $hd = fopen($v . 'helloword.txt', 'w+');
                if ($hd) {
                    $is_write = 1;
                    fclose($hd);
                    unlink($v . 'helloword.txt');
                } else {
                    $is_through = false;
                }
            } else {
                $is_through = false;
            }
            $tmp_test_dir[$v] = $is_write;
        }

        //文件权限
        $test_file = array(
            ROOT . 'upgrade/data/v65.sql',
        );

        $tmp_test_file = array();
        foreach ($test_file as $k => $v) {
            $is_write = 1;
            $a = fopen($v, 'r+');
            if ($a === false) {
                $is_write = 0;
                $is_through = false;
            } else {
                fclose($a);
            }
            $tmp_test_file[$v] = $is_write;
        }

        $result = array_merge($tmp_test_file, $tmp_test_dir);

        require './template/action2.html';
        break;
    case 3:
        require './template/action3.html';
        break;
    case 4:
        $_POST['dbhost'] = isset($_POST['dbhost']) ? trim($_POST['dbhost']) : '';
        $_POST['dbport'] = isset($_POST['dbport']) ? trim($_POST['dbport']) : '';
        $_POST['dbuser'] = isset($_POST['dbuser']) ? trim($_POST['dbuser']) : '';
        $_POST['dbpw'] = isset($_POST['dbpw']) ? trim($_POST['dbpw']) : '';
        $_POST['dbname'] = isset($_POST['dbname']) ? trim($_POST['dbname']) : '';
        $_POST['pre'] = isset($_POST['pre']) ? trim($_POST['pre']) : '';
        $_POST['manager'] = isset($_POST['manager']) ? trim($_POST['manager']) : '';
        $_POST['manager_pwd'] = isset($_POST['manager_pwd']) ? trim($_POST['manager_pwd']) : '';
        $_POST['manager_mobile'] = isset($_POST['manager_mobile']) ? trim($_POST['manager_mobile']) : '';
        $_POST['v'] = isset($_POST['v']) ? trim($_POST['v']) : '';

        if (strlen($_POST['dbhost']) == 0)
            errorAlert('请填写 数据库服务器地址');
        if (strlen($_POST['dbuser']) == 0)
            errorAlert('请填写 数据库服务器用户名');
        if (strlen($_POST['dbpw']) == 0)
            errorAlert('请填写 数据库服务器密码');
        if (strlen($_POST['dbname']) == 0)
            errorAlert('请填写 数据库名');

        if ($_POST['pre'] !== '') {
            if (!preg_match('~^[A-Za-z][A-Za-z]*[a-z0-9_]*$~', $_POST['pre'])) {
                errorAlert('数据库表前缀 必须以字母开头，只允许字母、数字、下划线');
            }
        }


    
        if (!mysql_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpw']))
            errorAlert('服务器用户名 或 服务器密码 不正确');

    
        
        mysql_select_db($_POST['dbname']);
     

        mysql_query("set names utf8");
        $_auth = md5(uniqid());


        //修改配置
        $str = <<<Eof
<?php
    return  array(
    'DB_TYPE'   =>  'mysql',
    'DB_HOST'   =>  '{$_POST['dbhost']}',
    'DB_NAME'   =>  '{$_POST['dbname']}',
    'DB_USER'   =>  '{$_POST['dbuser']}',
    'DB_PWD'    =>  '{$_POST['dbpw']}',
    'DB_PORT'   =>   {$_POST['dbport']} ,
    'DB_CHARSET'=>  'utf8',
    'DB_PREFIX' =>  '{$_POST['pre']}',
    'AUTH_KEY'  =>  '{$_auth}', //这个KEY只是保证部分表单在没有SESSION 的情况下判断用户本人操作的作用
    'BAO_KEY'   => '{$_POST['bao_key']}',
);
Eof;
        file_put_contents(ROOT . 'Baocms/Conf/db.php', $str);
        $init_database = file_get_contents(ROOT . 'upgrade/data/v65.sql');

        //替换表前缀
        if ($_POST['pre'] != 'bao_') {
            $structure = str_replace('`bao_', '`' . $_POST['pre'], $structure);
            $init_database = str_replace('`bao_', '`' . $_POST['pre'], $init_database);
        }
        $init_database = preg_replace('/\/\*.*?\*\//i', '',$init_database);
        $init_database = str_replace("\r", "\n", $init_database);
        $init_database = preg_replace("/\n+/i", "\n", $init_database);


        //初始化数据
        $init_database = explode(";\n", $init_database);
        $errsql = array();
        foreach ($init_database as $k => $v) {
            $v = trim($v);
            if (empty($v))
                continue;
            mysql_query($v);
            if(mysql_errno() !== 0){
                $errsql[] = $v.'['.mysql_error().']';
            }
        }

        file_put_contents(ROOT . 'attachs/upgrade65.lock', 1);
        if($errsql){
            file_put_contents('./upgrade.err.php', '<?php exit();>'.var_export($errsql, true));
            errorAlert("升级过程有错误，请查看错误日志文件");
        }else{
            yesAlert('升级成功', 'index.php?action=5');
        }
        break;

    case 5:
        require './template/action5.html';
        break;

    default:
        require './template/index.html';
        break;
}

function yesAlert($msg, $URL) {
    echo '<script>';
    echo 'parent.alert("' . $msg . '");';
    echo 'parent.location.href="' . $URL . '"';
    echo '</script>';
    die;
}

function errorAlert($msg) {
    echo '<script>';
    echo 'parent.alert("' . $msg . '");';
    echo '</script>';
    die;
}
