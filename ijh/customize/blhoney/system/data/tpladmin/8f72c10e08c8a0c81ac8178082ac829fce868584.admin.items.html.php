<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:21:34
         compiled from "admin:shop/log/items.html" */ ?>
<?php /*%%SmartyHeaderCode:179282918157b2b0ee51d401-82098630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f72c10e08c8a0c81ac8178082ac829fce868584' => 
    array (
      0 => 'admin:shop/log/items.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '179282918157b2b0ee51d401-82098630',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'shop_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b0ee5abf49_37929820',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b0ee5abf49_37929820')) {function content_57b2b0ee5abf49_37929820($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_modifier_iplocal')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.iplocal.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right"></td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	<form id="items-form">
<table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-100">日志ID</th>
        <th class="w-50">商家</th>
        <th class="w-50">金额</th>
        <th>描述</th>
        <th class="w-100">管理员</th>
        <th class="w-150">创建时间</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
    <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['log_id'];?>
" name="log_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['log_id'];?>
<label></td>
    <td><?php echo $_smarty_tpl->tpl_vars['shop_list']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
(ID:<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
)</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['intro'];?>
</td>
    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['admin'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
    <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
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
			<td colspan="10" class="left"></td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>