<?php
header("Content-type:text/html;charset=utf-8");
@session_start();
//使用一个会话变量检查登录状态
if (!isset($_SESSION['username'])) {
    echo "<script language=JavaScript>{window.alert('你没有超级管理权限');window.location.href='login.php';}</script>";
    exit;
}
?>