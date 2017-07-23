<?php /* Smarty version Smarty-3.1.8, created on 2016-08-19 09:39:46
         compiled from "admin:admin/role/index.html" */ ?>
<?php /*%%SmartyHeaderCode:129036449657b663629651f4-24525044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fce33043e18d0210b81210f2bafc9aac4d9c3e0' => 
    array (
      0 => 'admin:admin/role/index.html',
      1 => 1470380618,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '129036449657b663629651f4-24525044',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'role_list' => 0,
    'v' => 0,
    'ADMIN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b663629e0381_69071281',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b663629e0381_69071281')) {function content_57b663629e0381_69071281($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"admin/role:create",'class'=>"button"),$_smarty_tpl);?>
</td>
		<td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<input type="hidden" name="batch" value="orderby" />
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data list">
		<tr>
			<th class="w-100">ID</th>
			<th>管理员</th>
			<th class="w-100">类型</th>
			<th class="w-150">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['role_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<tr id="line-role-<?php echo $_smarty_tpl->tpl_vars['v']->value['role_id'];?>
">
		<td><label><?php echo $_smarty_tpl->tpl_vars['v']->value['role_id'];?>
</label></td>
		<td class="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['role_name'];?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['v']->value['role'];?>
</td>
		<td class="left">
			<?php if ($_smarty_tpl->tpl_vars['v']->value['role']=='system'&&$_smarty_tpl->tpl_vars['ADMIN']->value['role']!='system'){?>
			<label class="button disabled" title="管理" tips="您没有权限修改系统管理员角色" disabled="disabled">管理</label>
			<?php }else{ ?>
			<?php echo smarty_function_link(array('ctl'=>"admin/role:detail",'args'=>($_smarty_tpl->tpl_vars['v']->value['role_id']),'class'=>"button",'title'=>"管理"),$_smarty_tpl);?>

			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['v']->value['role']!='system'){?>
			<?php echo smarty_function_link(array('ctl'=>"admin/role:delete",'args'=>($_smarty_tpl->tpl_vars['v']->value['role_id']),'class'=>"button",'act'=>"mini:remove:line-role-".($_smarty_tpl->tpl_vars['v']->value['role_id']),'title'=>"删除"),$_smarty_tpl);?>

			<?php }else{ ?>
			<label class="button disabled" title="删除" tips="系统管理员角色不能删除" disabled="disabled">删除</label>
			<?php }?>
		</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>