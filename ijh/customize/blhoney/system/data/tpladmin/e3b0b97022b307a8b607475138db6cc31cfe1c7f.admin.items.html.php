<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 19:44:20
         compiled from "admin:payment/items.html" */ ?>
<?php /*%%SmartyHeaderCode:106718329657b2fc94021460-29739890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3b0b97022b307a8b607475138db6cc31cfe1c7f' => 
    array (
      0 => 'admin:payment/items.html',
      1 => 1470380609,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '106718329657b2fc94021460-29739890',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2fc940b4f49_11778183',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2fc940b4f49_11778183')) {function content_57b2fc940b4f49_11778183($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right"><?php echo smarty_function_link(array('ctl'=>"payment/payment:install",'load'=>"mini:安装新支付接口",'width'=>"mini:500",'class'=>"button",'title'=>"安装新支付接口"),$_smarty_tpl);?>
</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-50">ID</th><th class="w-100">logo</th><th class="w-100">接口标识</th><th>接口标题</th><th class="w-50">接口状态</th><th class="w-150">操作</th></tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
    	<td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['payment_id'];?>
" name="payment_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['payment_id'];?>
<label></td>
		<td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['logo'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['logo'];?>
" class="w-100 h-50" /></td>
		<td><b class="blue"><?php echo $_smarty_tpl->tpl_vars['item']->value['payment'];?>
</b></td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
		<td><?php if ($_smarty_tpl->tpl_vars['item']->value['status']){?><b class="blue">开启</b><?php }else{ ?>关闭<?php }?></td>
		<td>
			<?php echo smarty_function_link(array('ctl'=>"payment/payment:config",'args'=>$_smarty_tpl->tpl_vars['item']->value['payment_id'],'title'=>"配置",'class'=>"button"),$_smarty_tpl);?>

			<?php echo smarty_function_link(array('ctl'=>"payment/payment:uninstall",'args'=>$_smarty_tpl->tpl_vars['item']->value['payment_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"卸载",'class'=>"button"),$_smarty_tpl);?>

		</td>
	</tr>
    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
     <tr><td colspan="20"><p class="text-align tip-notice">没有数据</p></td></tr>
    <?php } ?>
    </table>
	</form>
	<div class="page-bar">
		<table>
			<tr>
			<td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
			<td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"payment/payment:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>
</td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>