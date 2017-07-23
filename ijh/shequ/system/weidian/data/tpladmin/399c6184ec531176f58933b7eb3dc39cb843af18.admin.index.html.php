<?php /* Smarty version Smarty-3.1.8, created on 2016-12-06 11:21:02
         compiled from "admin:module/menu/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1485458462e9e0c4d15-99965020%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '399c6184ec531176f58933b7eb3dc39cb843af18' => 
    array (
      0 => 'admin:module/menu/index.html',
      1 => 1475911366,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '1485458462e9e0c4d15-99965020',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'tree' => 0,
    'v' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58462e9e4014b9_94345767',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58462e9e4014b9_94345767')) {function content_58462e9e4014b9_94345767($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th>导航菜单管理</th>
        <td align="right">&nbsp;<?php echo smarty_function_link(array('ctl'=>"module/menu:create",'class'=>"button",'priv'=>"hide",'load'=>"mini:添加导航菜单",'width'=>"mini:400"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<form action="?module/menu-update.html" mini-form="menu-order" method="post"/>
	<input type="hidden" name="batch" value="orderby" />
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data list">
		<tr>
			<th style="width:50px;padding-left:5px;text-align:left;">ID</th>
			<th>标题</th>
			<th class="w-150">排序</th>
			<th class="w-200">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
		<tr id="mod-<?php echo $_smarty_tpl->tpl_vars['v']->value['mod_id'];?>
">
			<td><?php echo $_smarty_tpl->tpl_vars['v']->value['mod_id'];?>
</td>
			<td style="text-align:left;">&nbsp;&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</strong></td>
			<td class="left">&nbsp;<input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['v']->value['mod_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['orderby'];?>
" class="input w-50" /></td>
			<td>
				<?php echo smarty_function_link(array('ctl'=>"module/menu:create",'args'=>($_smarty_tpl->tpl_vars['v']->value['mod_id']),'load'=>"mini:添加子菜单",'width'=>"mini:400",'title'=>"添加菜单",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"module/menu:edit",'args'=>($_smarty_tpl->tpl_vars['v']->value['mod_id']),'load'=>"mini:编辑导航菜单",'width'=>"mini:400",'title'=>"编辑",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"module/menu:remove",'args'=>($_smarty_tpl->tpl_vars['v']->value['mod_id']),'act'=>"mini:remove:mod-".($_smarty_tpl->tpl_vars['v']->value['mod_id']),'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

			</td>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
		<tr id="mod-<?php echo $_smarty_tpl->tpl_vars['vv']->value['mod_id'];?>
">
			<td><?php echo $_smarty_tpl->tpl_vars['vv']->value['mod_id'];?>
</td>
			<td style="text-align:left;">&nbsp;&nbsp;|----<strong><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</strong></td>
			<td class="left">&nbsp;&nbsp;|----<input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['vv']->value['mod_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['orderby'];?>
" class="input w-50" /></td>
			<td>
				<?php echo smarty_function_link(array('ctl'=>"module/ctl:detail",'args'=>($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'width'=>"mini:700",'load'=>"mini:管理控制模块",'title'=>"控制模块"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"module/menu:edit",'args'=>($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'load'=>"mini:编辑导航菜单",'width'=>"mini:400",'title'=>"编辑"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"module/menu:remove",'args'=>($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'act'=>"mini:remove:mod-".($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'title'=>"删除"),$_smarty_tpl);?>

		</tr>
		<?php } ?>
		<?php } ?>
		<tr>
			<td colspan="3" class="clear-td-border right"></td>
			<td class="clear-td-border"></td>
		</tr>
	</table>
	<div class="page-bar">
		<table>
			<tr>
			<td class="w-100"></td>
			<td colspan="10" class="left"></td>
			<td class="w-200"><input type="submit" class="bt-big" value="更 新 排 序" /></td>
			</tr>
		</table>
	</div>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>