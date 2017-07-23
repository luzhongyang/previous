<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:15:55
         compiled from "admin:context/top.html" */ ?>
<?php /*%%SmartyHeaderCode:205045833e29b011056-77245592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae54faf572d1fdcaa7d14add06050e3c970561b7' => 
    array (
      0 => 'admin:context/top.html',
      1 => 1475911366,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '205045833e29b011056-77245592',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'top_menu' => 0,
    'v' => 0,
    'ADMIN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e29b0733d4_13860545',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e29b0733d4_13860545')) {function content_5833e29b0733d4_13860545($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<title>江湖婚庆门户系统管理中心</title>
<meta name="Description" content="" />
<link rel="stylesheet" rev="stylesheet" href="style/top.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/kt.j.js"></script>
</head>
<body>
<!-- nav op -->
<div id="top-nav">
    <div class="nav_top">
        <div class="logo"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/logo.png" alt="" /></div>
		<div class="menu">
			<ul id="menu_list">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['top_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<li><a href="?index-context-<?php echo $_smarty_tpl->tpl_vars['v']->value['mod_id'];?>
.html" target="admin_left"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
 </a></li>
			<?php } ?>
			</ul>
		</div>
        <div class="info">
			 欢迎您：<strong class="red"><?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['admin_name'];?>
！</strong>
			 <a href="?index-modifypasswd.html" target="admin_main">修改密码</a>
			 <span class="green"><a href="?index-loginout.html" target="_top">注销</a></span><br />
			<a href="../index.php" target="_blank">网站首页</a>
			<a href="?index-welcome.html" target="admin_main">后台首页</a>
			<a href="?tools/cache-clean.html" target="admin_main">更新缓存</a>
			<a href="http://www.ijh.cc/jiajuhelp.html" target="_blank">帮助手册</a>
		</div>
		<div style="clear:both;"></div>
    </div>
	<div class="bottom-line"></div>
</div>
<!-- nav ed -->
<script type="text/javascript">
(function($){
	$("#menu_list li").on("click", function(){
		$("#menu_list li").removeClass('on');
		$(this).addClass("on");
	});
})(window.jQuery);
</script>
</body>
</html>
<?php }} ?>