<?php

/** 获取运行系统 */
function get_run_os() {
    $str = php_uname();
    $arr = explode(' ', $str);
    return $arr[0];
}

/** 获取运行服务器 */
function get_run_server()
{
    $arr = explode(' ', $_SERVER['SERVER_SOFTWARE']);
    return $arr[0];
}

/** 获取PHP版本 */
function get_php_version()
{
    return PHP_VERSION;
}

/** 获取附件上传大小 */
function get_upload_max_size()
{
    return get_cfg_var('upload_max_filesize');
}

