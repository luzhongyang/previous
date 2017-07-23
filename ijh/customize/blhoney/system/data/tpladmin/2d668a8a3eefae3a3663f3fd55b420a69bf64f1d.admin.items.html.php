<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:05:29
         compiled from "admin:article/cate/items.html" */ ?>
<?php /*%%SmartyHeaderCode:62248457657b2bb39a3b8f7-33531637%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d668a8a3eefae3a3663f3fd55b420a69bf64f1d' => 
    array (
      0 => 'admin:article/cate/items.html',
      1 => 1470380619,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '62248457657b2bb39a3b8f7-33531637',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'tree' => 0,
    'v' => 0,
    'vv' => 0,
    'vvv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2bb39b70156_40655631',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2bb39b70156_40655631')) {function content_57b2bb39b70156_40655631($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right">
				<?php echo smarty_function_link(array('ctl'=>"article/cate:create",'class'=>"button",'load'=>"mini:添加分类",'width'=>"mini:520",'title'=>"添加分类"),$_smarty_tpl);?>
</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data table">
		<tr>
			<th class="w-100">ID</th>
			<th>分类名称</th>
			<th class="w-100">排序</th>
			<th class="w-150">是否隐藏</th>
			<th class="w-200">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
		<tr id="cat-<?php echo $_smarty_tpl->tpl_vars['v']->value['cat_id'];?>
">
			<td class="left"><label><input type="checkbox" value="cat_id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cat_id'];?>
" CK="PRI"><?php echo $_smarty_tpl->tpl_vars['v']->value['cat_id'];?>
</label></td>
			<td class="left"><strong><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</strong></td>
			<td class="left"><input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['v']->value['cat_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['orderby'];?>
" class="input w-50" /></td>
			<td><?php if ($_smarty_tpl->tpl_vars['v']->value['hidden']){?><span class="red">隐藏</span><?php }else{ ?>显示<?php }?></td>
			<td>
				<?php echo smarty_function_link(array('ctl'=>"article/cate:create",'args'=>($_smarty_tpl->tpl_vars['v']->value['cat_id']),'load'=>"mini:添加子分类",'width'=>"mini:520",'title'=>"添加子分类",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"article/cate:edit",'args'=>($_smarty_tpl->tpl_vars['v']->value['cat_id']),'load'=>"mini:编辑分类",'width'=>"mini:520",'title'=>"编辑分类",'class'=>"button"),$_smarty_tpl);?>

				<?php if ($_smarty_tpl->tpl_vars['v']->value['from']=='article'||$_smarty_tpl->tpl_vars['v']->value['cat_id']>50){?>
				<?php echo smarty_function_link(array('ctl'=>"article/cate:delete",'args'=>($_smarty_tpl->tpl_vars['v']->value['cat_id']),'act'=>"mini:remove:cat-".($_smarty_tpl->tpl_vars['v']->value['cat_id']),'title'=>"删除分类",'class'=>"button"),$_smarty_tpl);?>

				<?php }else{ ?>
				<label title="删除分类" class="button disabled" tips="系统分类不能删除" disabled="disabled">删除分类</label>
				<?php }?>
			</td>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
		<tr id="cat-<?php echo $_smarty_tpl->tpl_vars['vv']->value['cat_id'];?>
">
			<td class="left"><label><input type="checkbox" value="cat_id[]" value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cat_id'];?>
" CK="PRI"><?php echo $_smarty_tpl->tpl_vars['vv']->value['cat_id'];?>
</label></td>
			<td style="text-align:left;padding-left:30px;">&nbsp;&nbsp;|---<strong><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</strong></td>
			<td class="left">&nbsp;&nbsp;|---<input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['vv']->value['cat_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['orderby'];?>
" class="input w-50" /></td>
			<td><?php if ($_smarty_tpl->tpl_vars['vv']->value['hidden']){?><span class="red">隐藏</span><?php }else{ ?>显示<?php }?></td>
			<td>
				<?php echo smarty_function_link(array('ctl'=>"article/cate:create",'args'=>($_smarty_tpl->tpl_vars['vv']->value['cat_id']),'load'=>"mini:添加子分类",'width'=>"mini:520",'title'=>"添加子分类",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"article/cate:edit",'args'=>($_smarty_tpl->tpl_vars['vv']->value['cat_id']),'load'=>"mini:编辑分类",'width'=>"mini:520",'title'=>"编辑分类",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"article/cate:delete",'args'=>($_smarty_tpl->tpl_vars['vv']->value['cat_id']),'act'=>"mini:remove:cat-".($_smarty_tpl->tpl_vars['vv']->value['cat_id']),'title'=>"删除分类",'class'=>"button"),$_smarty_tpl);?>

			</td>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['vvv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vvv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vv']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vvv']->key => $_smarty_tpl->tpl_vars['vvv']->value){
$_smarty_tpl->tpl_vars['vvv']->_loop = true;
?>
		<tr id="cat-<?php echo $_smarty_tpl->tpl_vars['vvv']->value['cat_id'];?>
">
			<td class="left"><label><input type="checkbox" value="cat_id[]" value="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['cat_id'];?>
" CK="PRI"><?php echo $_smarty_tpl->tpl_vars['vvv']->value['cat_id'];?>
</label></td>
			<td style="text-align:left;padding-left:60px;">&nbsp;&nbsp;|---<strong><?php echo $_smarty_tpl->tpl_vars['vvv']->value['title'];?>
</strong></td>
			<td class="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---<input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['vvv']->value['cat_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['orderby'];?>
" class="input w-50" /></td>
			<td><?php if ($_smarty_tpl->tpl_vars['vvv']->value['hidden']){?><span class="red">隐藏</span><?php }else{ ?>显示<?php }?></td>
			<td>
				<label title="添加子分类" class="button disabled" tips="该分类不能添加子分类" disabled="disabled">添加子分类</label>
				<?php echo smarty_function_link(array('ctl'=>"article/cate:edit",'args'=>($_smarty_tpl->tpl_vars['vvv']->value['cat_id']),'load'=>"mini:编辑分类",'width'=>"mini:520",'title'=>"编辑分类",'class'=>"button"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"article/cate:delete",'args'=>($_smarty_tpl->tpl_vars['vvv']->value['cat_id']),'act'=>"mini:remove:cat-".($_smarty_tpl->tpl_vars['vvv']->value['cat_id']),'title'=>"删除分类",'class'=>"button"),$_smarty_tpl);?>

		</tr>
		<?php } ?>
		<?php } ?>
		<?php } ?>
	</table>
    </table>
	</form>
	<div class="page-bar">
		<table>
			<tr>
			<td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
			<td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"article/cate:delete",'type'=>"button",'submit'=>"mini:#items-form",'title'=>"删除分类"),$_smarty_tpl);?>
</td>
			<td class="w-200"><?php echo smarty_function_link(array('ctl'=>"article/cate:update",'type'=>"button",'submit'=>"mini:#items-form",'title'=>"更新数据"),$_smarty_tpl);?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>