<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:23:24
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/account/signup.html" */ ?>
<?php /*%%SmartyHeaderCode:186452288157b2a34cba54b3-13887447%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '879c6de086f1a87d35671f33d163ae71915c1420' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/account/signup.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186452288157b2a34cba54b3-13887447',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'VER' => 0,
    'citys' => 0,
    'val' => 0,
    'cates' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a34cc0ea65_13255553',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a34cc0ea65_13255553')) {function content_57b2a34cc0ea65_13255553($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
<title>商户管理中心登录</title>
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
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>
	<div class="login_cont register_cont">
		<div class="login register">
			<h2>申请入驻</h2>
			<form action="<?php echo smarty_function_link(array('ctl'=>'biz/account:signup'),$_smarty_tpl);?>
" mini-form="biz" method="post">
                            <input type="text" class="text" name="data[mobile]" id="mobile" placeholder="联系电话">
                            <div class="yanzheng">
                            <input type="text" class="text short lt" name="data[code]" placeholder="验证码">
                            <a class="hqyzm" href="javascript:void(0);" login="sendsms">获取验证码</a>
                            <input type="text" class="text" name="data[passwd]" placeholder="登录密码">
                            <div class="cl"></div>
                            </div>
                            <input type="text" class="text" name="data[title]" placeholder="店铺名称">
                            <input type="text" class="text" name="data[phone]" placeholder="服务电话">
                            <select class="text"  name="data[city_id]">
                                    <option>请选择城市</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['citys']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['city_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['city_name'];?>
</option>
                                    <?php } ?>
                            </select>
                            <select class="text"  name="data[cate_id]">
                                    <option>请选择店铺类型</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['cate_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
                                    <?php } ?>
                            </select>
                            <input type="text" class="text" name="data[addr]" placeholder="店铺地址">
                            <textarea  name="data[info]" placeholder="店铺简介" class="text"></textarea>
                            <input type="submit" class="btn" value="立即申请">
			</form>
			<div class="bottom_link">
                            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/account/login'),$_smarty_tpl);?>
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
            var link = "<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
";
            $.post(link,$("#form_post").serialize(), function (ret) {
                if (ret.error == 0) {
                    layer.msg(ret.message);
                    setTimeout(function () {
                        window.location.reload(true);
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