<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 00:22:38
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/account/forgot.html" */ ?>
<?php /*%%SmartyHeaderCode:163588831457b48f4edea889-27573223%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '845109a3c6ad1d509ed8320dedbad11ee23be365' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/account/forgot.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163588831457b48f4edea889-27573223',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'VER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b48f4ee306d6_57019819',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b48f4ee306d6_57019819')) {function content_57b48f4ee306d6_57019819($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>忘记密码</title>
<link type="text/css" rel="stylesheet" href="css/style.css">
    <script type="text/javascript"  src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/kt.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/jBox/jBox.min.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/layer/layer.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.msgbox.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <link type="text/css" rel="stylesheet" href="/themes/default/biz/static/css/login.css">
</head>
<body>
    <div class="login_cont">
        <div class="login">
        <h2>忘记密码</h2>
        <form id="form_post"  method="post">
            <input type="text" name="data[mobile]" id="mobile" class="text" placeholder="请输入手机号">
        <div class="yanzheng">
            <input type="text" name="data[code]" class="text short lt" placeholder="请输入验证码">
            <a class="hqyzm" href="javascript:void(0);" login="sendsms">获取验证码</a>
            <div class="cl"></div>
        </div>
        <input type="password" name="data[new_passwd]" class="text" placeholder="请输入新密码">
        <input type="password" name="data[new_passwd2]" class="text" placeholder="请再次输入新密码">
        <input type="button" class="btn" id="btn_mobile" value="修改密码">
                </form>
                <div class="bottom_link">
                <a href="<?php echo smarty_function_link(array('ctl'=>'biz/account:login'),$_smarty_tpl);?>
">已有账号？立即登录</a>
                </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var minute = 60;
            var mobile_timeout;
            var mobile_count = minute;
            var mobile_lock = 0;
            BtnCount = function () {
                if (mobile_count == 0) {
                    $(".hqyzm").addClass("on");
                    $('.hqyzm').removeAttr("disabled");
                    $('.hqyzm').text("重新获取");
                    mobile_lock = 0;
                    clearTimeout(mobile_timeout);
                    $('.hqyzm').removeClass("on");
                } else {
                    mobile_count--;
                    $('.hqyzm').text(+mobile_count.toString() + "秒...");
                    mobile_timeout = setTimeout(BtnCount, 1000);
                }
            };
            $("[login]").click(function () {
                if (mobile_lock == 0) {
                    var mobile = $('#mobile').val();
                    var link = "<?php echo smarty_function_link(array('ctl'=>'passport/sendsms'),$_smarty_tpl);?>
";
                    $.post(link, {mobile: mobile}, function (ret) {
                        if (ret.error == 0) {
                            BtnCount();
                            mobile_lock = 1;
                            $(".hqyzm").addClass("on");
                            $('.hqyzm').attr("disabled", "disabled");
                        } else {
                            layer.msg(ret.message);
                            mobile_lock = 0;
                        }
                    }, 'json');
                    mobile_count = minute;
                }
            });
            $('#btn_mobile').click(function () {
                var link = "<?php echo smarty_function_link(array('ctl'=>'biz/account:forgot'),$_smarty_tpl);?>
";
                $.post(link,$("#form_post").serialize(), function (ret) {
                    if (ret.error == 0) {
                        layer.msg(ret.message);
                        setTimeout(function () {
                            window.location.href="<?php echo smarty_function_link(array('ctl'=>'biz/account:login'),$_smarty_tpl);?>
";
                        }, 1000)
                        BtnCount();
                    } else {
                        layer.msg(ret.message);
                    }
                }, 'json');
            })
        })

    </script>    
</body>
</html>
<?php }} ?>