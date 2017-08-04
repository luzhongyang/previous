<?php
header("Content-type:text/html;charset=utf-8");
session_start();
//使用一个会话变量检查登录状态
if (isset($_SESSION['username'])) {

    $_SESSION = array();
    session_destroy();
}
header("Location:login.php"); //你想登出后用户返回的页面
exit;
?>