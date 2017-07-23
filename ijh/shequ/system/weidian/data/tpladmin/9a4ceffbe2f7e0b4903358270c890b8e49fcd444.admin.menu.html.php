<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:15:57
         compiled from "admin:context/menu.html" */ ?>
<?php /*%%SmartyHeaderCode:75355833e29d4b3272-53778895%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a4ceffbe2f7e0b4903358270c890b8e49fcd444' => 
    array (
      0 => 'admin:context/menu.html',
      1 => 1475911366,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '75355833e29d4b3272-53778895',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'menu_tree' => 0,
    'menu' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e29d50b799_64185873',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e29d50b799_64185873')) {function content_5833e29d50b799_64185873($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<link rel="stylesheet" href="style/menu.css" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/jquery.min.js"></script>
<title>管理菜单</title>
</head>
<body style="background:#F5F9FA;overflow-x:hidden;">
    <ul class="page-menu">        
	<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
	<li class="menu close" rel="menu_tree"><strong title="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</strong></span>
	   <ul class="menu-item">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
			<li title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
"><a href="?<?php echo $_smarty_tpl->tpl_vars['v']->value['ctl'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['act'];?>
.html" target="admin_main" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
			<?php } ?>
		</ul>
	</li>
	<?php } ?>
	</ul>
<div style="clear:both;"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("li[rel='menu_tree']>strong").click(function(){
		//$("li[rel='menu_tree']").not($(this).parent()).removeClass('open').addClass('close').children('ul').hide();
		if($(this).parent().hasClass('open')){
			$(this).parent().removeClass('open').addClass('close').children('ul').hide();
		}else{
			$(this).parent().removeClass('close').addClass('open').children('ul').show();
		}
	});//.last().click();
	$(".menu-item>li a").click(function(){
		$(".menu-item>li").not($(this).parent("li")).removeClass('active');
		$(this).parent("li").addClass("active");
	});
});
</script>
</body>
</html>
<?php }} ?>