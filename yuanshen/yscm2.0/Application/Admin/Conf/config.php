<?php
$ini = require('./Data/Conf/config.ini.php');
$config = array(
        'URL_MODEL'  =>  2,      //URL访问模式
        'VIEW_PATH'     => './Theme/Admin/', //定义模板目录
        //'DEFAULT_THEME'			=> 'Admin', //主题风格
        'ADMIN_AUTH_KEY'        => 'admin', //无需认证的超级管理员
        'AUTH_CONFIG' => array(
        'AUTH_ON'           => true, //认证开关
        'AUTH_TYPE'         => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP'        => 'ys_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'ys_auth_group_access', //用户组明细表
        'AUTH_RULE'         => 'ys_auth_rule', //权限规则表
        'AUTH_USER'         => 'ys_admin'//用户信息表
    )
);

return array_merge($ini,$config);