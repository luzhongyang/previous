<?php /* Smarty version Smarty-3.1.8, created on 2016-08-19 09:39:47
         compiled from "admin:admin/admin/index.html" */ ?>
<?php /*%%SmartyHeaderCode:126630850057b66363822be9-36871426%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3608a60e18792a1167035678cbf8747b81e21424' => 
    array (
      0 => 'admin:admin/admin/index.html',
      1 => 1470380618,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '126630850057b66363822be9-36871426',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'v' => 0,
    'role_list' => 0,
    'ADMIN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b663638e2133_29956742',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b663638e2133_29956742')) {function content_57b663638e2133_29956742($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"admin/admin:create",'width'=>"mini:400",'load'=>"mini:创建管理员",'class'=>"button"),$_smarty_tpl);?>
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
			<th class="w-100">ID</th>
			<th>用户名</th>
			<th class="w-150">角色名</th>
			<th class="w-100">类型</th>
			<th class="w-100">状态</th>
			<th class="w-150">最后登录IP</th>
			<th class="w-150">最后登录时间</th>
			<th class="w-150">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<tr id="line-admin-<?php echo $_smarty_tpl->tpl_vars['v']->value['admin_id'];?>
">
			<td><label><?php echo $_smarty_tpl->tpl_vars['v']->value['admin_id'];?>
</label></td>
			<td class="left"><?php echo $_smarty_tpl->tpl_vars['v']->value['admin_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['role_list']->value[$_smarty_tpl->tpl_vars['v']->value['role_id']]['role_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['role_list']->value[$_smarty_tpl->tpl_vars['v']->value['role_id']]['role'];?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['v']->value['closed']==3){?>已删除<?php }elseif($_smarty_tpl->tpl_vars['v']->value['closed']){?>禁用<?php }else{ ?>正常<?php }?></td>		
			<td><?php echo $_smarty_tpl->tpl_vars['v']->value['last_ip'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['v']->value['format_last_login'];?>
</td>
			<td class="left">
				<?php if ($_smarty_tpl->tpl_vars['role_list']->value[$_smarty_tpl->tpl_vars['v']->value['role_id']]['role']=='system'&&$_smarty_tpl->tpl_vars['ADMIN']->value['role']!='system'){?>
				<label class="button disabled" title="编辑" tips="您没有权限编辑系统管理员" disabled="disabled">编辑</label>
				<?php }else{ ?>
				<?php echo smarty_function_link(array('ctl'=>"admin/admin:edit",'args'=>($_smarty_tpl->tpl_vars['v']->value['admin_id']),'width'=>"mini:400",'load'=>"mini:编辑管理员",'class'=>"button",'title'=>"编辑"),$_smarty_tpl);?>

				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['v']->value['admin_id']==$_smarty_tpl->tpl_vars['ADMIN']->value['admin_id']){?>
				<label class="button disabled" title="删除" tips="不能删除当前登录帐号" disabled="disabled">删除</label>
				<?php }elseif($_smarty_tpl->tpl_vars['ADMIN']->value['role']=='editor'){?>
				<label class="button disabled" title="删除" tips="您没有权限删除管理员" disabled="disabled">删除</label>
				<?php }elseif($_smarty_tpl->tpl_vars['role_list']->value[$_smarty_tpl->tpl_vars['v']->value['role_id']]['role']=='system'&&$_smarty_tpl->tpl_vars['ADMIN']->value['role']!='system'){?>
				<label class="button disabled" title="删除" tips="您没有权限删除系统管理员" disabled="disabled">删除</label>
				<?php }else{ ?>
				<?php echo smarty_function_link(array('ctl'=>"admin/admin:delete",'args'=>($_smarty_tpl->tpl_vars['v']->value['admin_id']),'class'=>"button",'act'=>"mini:remove:line-role-".($_smarty_tpl->tpl_vars['v']->value['role_id']),'title'=>"删除"),$_smarty_tpl);?>
			
				<?php }?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div class="page-bar">
		<table>
			<tr>
				<td></td>			
				<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
			</tr>
		</table>
	</div>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>