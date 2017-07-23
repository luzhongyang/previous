<?php /* Smarty version Smarty-3.1.8, created on 2016-11-23 11:04:24
         compiled from "merchant:account/login.html" */ ?>
<?php /*%%SmartyHeaderCode:24863583505d12fa8e1-63133839%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ae86cb1bb5d15a1895eab633a642b8826398e9f' => 
    array (
      0 => 'merchant:account/login.html',
      1 => 1479870235,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '24863583505d12fa8e1-63133839',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_583505d1339fb9_34158532',
  'variables' => 
  array (
    'pager' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_583505d1339fb9_34158532')) {function content_583505d1339fb9_34158532($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>登录</title>
<link href="/merchant/style/css/bootstrap.min.css" rel="stylesheet">
<link href="/merchant/style/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/merchant/style/css/animate.css" rel="stylesheet">
<link href="/merchant/style/css/style.css" rel="stylesheet">
<link href="/merchant/style/css/mine.css" rel="stylesheet">
<link href="/merchant/style/css/layer.css" rel="stylesheet">
<script src="/merchant/script/js/jquery-2.1.1.js"></script>
<script src="/merchant/script/js/bootstrap.min.js"></script>
<script src="/merchant/script/js/layer.js"></script>
<script type="text/javascript" src="/static/script/kt.js"></script>
<script type="text/javascript" src="/static/script/jBox/jBox.min.js"></script>
<script type="text/javascript" src="/static/script/layer/layer.js"></script>
<!--<script type="text/javascript" src="/static/script/kt.j.js"></script>-->
<script type="text/javascript" src="/static/script/widget.msgbox.js"></script>
<script type="text/javascript" src="/static/script/My97DatePicker/WdatePicker.js"></script>

<script src="/themes/default/biz/static/script/printArea.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
</head>
<style type="text/css" media="screen">
.login_form .form-group .ico1 {
    display: block;
    width: 24px;
    height: 24px;
    background: url(/merchant/static/images/login/loginIco1.png) no-repeat center;
    background-size: 100%;
    position: absolute;
    left: 15px;
    top: 50%;
    margin-top: -12px;
}
.login_form .form-group .ico2 {
    display: block;
    width: 24px;
    height: 24px;
    background: url(/merchant/static/images/login/loginIco2.png) no-repeat center;
    background-size: 100%;
    position: absolute;
    left: 15px;
    top: 50%;
    margin-top: -12px;
}
</style>
<body class="gray-bg">
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>

<div class="login_box" style="background: url(/merchant/images/bgBig.png) no-repeat center top;">
    <div class="login_box_wd animated fadeInDown">
        <div class="login_tit">
            <h1>商户管理中心</h1>
            <small>Business Management System</small>
            <h2><span>登录</span></h2>
        </div>
        <div class="login_form">
            <div class="login_form_wd">
                <form  role="form" action="<?php echo smarty_function_link(array('ctl'=>'merchant/account:login'),$_smarty_tpl);?>
" mini-form="merchant" method="post">
                    <div class="form-group">
                        <div class="pull-left ico ico1"></div>
                        <div class="int_box"><input type="text" name="data[mobile]" class="form-control" placeholder="请输入手机号" ></div>
                    </div>
                    <div class="form-group">
                        <div class="pull-left ico ico2"></div>
                        <div class="int_box"><input type="password" name="data[passwd]" class="form-control" placeholder="请输入新密码"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
                    <div class="bottom_link clearfix">
                        <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/account:signup'),$_smarty_tpl);?>
" class="pull-left">申请入驻</a>
                        <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/account:forgot'),$_smarty_tpl);?>
" class="pull-right">忘记密码?</a>
                    </div>
                </form>
            </div>
            
        </div>
        <p class="copyt">Copyright © 2013-2016 江湖科技出品, All rights reserved. ICP备案：皖ICP备13010842号</p>
    </div>
</div>
<!-- Mainly scripts --> 

</body>
</html>
<?php }} ?>