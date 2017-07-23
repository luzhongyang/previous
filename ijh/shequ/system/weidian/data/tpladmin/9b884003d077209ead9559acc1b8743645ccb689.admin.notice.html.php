<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:16:25
         compiled from "admin:page/notice.html" */ ?>
<?php /*%%SmartyHeaderCode:42275833e2b9013856-44810976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b884003d077209ead9559acc1b8743645ccb689' => 
    array (
      0 => 'admin:page/notice.html',
      1 => 1475911366,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '42275833e2b9013856-44810976',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e2b9078497_73531982',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e2b9078497_73531982')) {function content_5833e2b9078497_73531982($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-clew">
	<table width="709" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="3" valign="top" style="padding-top:30px;text-align:center;" class="clew-img w-100">
				<?php if ($_smarty_tpl->tpl_vars['pager']->value['error']&&$_smarty_tpl->tpl_vars['pager']->value['error']!=200){?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/clew-error.gif" alt="" />
				<?php }else{ ?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/clew-success.gif" alt="" />
				<?php }?>
			</td>
			<td class="b"><p class="s-15"></p><p style="color:#FF3300;"><?php echo $_smarty_tpl->tpl_vars['pager']->value['message'];?>
</p><span><?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
秒之后页面自动跳转</span></td>
		</tr>
		<tr><td colspan="2"><a href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
" class="red">如没有跳转,点击这里立即跳转</a></td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>            
</div>
<script type="text/javascript">setTimeout(function(){window.location.href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
";},<?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
*1000);</script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>