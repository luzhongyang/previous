<?php
    error_reporting(E_ALL ^ E_NOTICE);
    //修改下面代码来联接数据库
    $server_name = "127.0.0.1";
    $server_usr = "root";
    $server_pwd = "123456";
    $server_db = "ahhb";
    $link = mysql_connect($server_name, $server_usr, $server_pwd) or die("不能连接数据库!");
    mysql_select_db($server_db,$link); 
    mysql_query("set names utf8");
?>