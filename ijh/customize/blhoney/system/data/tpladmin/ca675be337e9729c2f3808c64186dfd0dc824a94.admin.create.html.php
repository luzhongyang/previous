<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:05:32
         compiled from "admin:article/cate/create.html" */ ?>
<?php /*%%SmartyHeaderCode:148157584357b2bb3cce9b74-35031931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca675be337e9729c2f3808c64186dfd0dc824a94' => 
    array (
      0 => 'admin:article/cate/create.html',
      1 => 1470380619,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '148157584357b2bb3cce9b74-35031931',
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
    'class' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2bb3cd4c670_51559616',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2bb3cd4c670_51559616')) {function content_57b2bb3cd4c670_51559616($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td style="width:30px;" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th align="left"><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<form action="?article/cate-create.html" mini-form="article-form" method="post">
	<table width="100%" border="0" cellspacing="0" class="table-data form">
		<tr>
			<th width="150">上级菜单:</th>
			<td>
				<select name="data[parent_id]">
				<option value="0">顶级菜单</option>
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cat_id'];?>
"<?php if ($_smarty_tpl->tpl_vars['v']->value['cat_id']==$_smarty_tpl->tpl_vars['pager']->value['parent_id']){?>selected="selected"<?php }?>>|--<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
				<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cat_id'];?>
"<?php if ($_smarty_tpl->tpl_vars['vv']->value['cat_id']==$_smarty_tpl->tpl_vars['pager']->value['parent_id']){?>selected="selected"<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;|--<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
				<?php } ?>
				<?php } ?>
				</select>
			</td>
		</tr>		
		<tr><th>分类标题：</th><td><input type="text" name="data[title]" value="" class="input w-300"/></td></tr>
		<tr><th>SEO标题：</th><td><input type="text" name="data[seo_title]" value="" class="input w-300"/></td></tr>
		<tr><th>SEO关键字：</th><td><input type="text" name="data[seo_keywords]" value="" class="input w-300"/></td></tr>
		<tr><th>SEO描述：</th><td><textarea name="data[seo_description]" style="width:300px;height:80px;"></textarea>
		<tr>
			<th width="150">隐藏：</th>
			<td>
				<label><input type="radio" name="data[hidden]" value="1" />是</label>
				<label><input type="radio" name="data[hidden]" value="0" checked="checked" />否</label>
			</td>
		</tr>
		<tr>
			<th width="150">排序：</th>
			<td><input type="text" name="data[orderby]" class="input w-50" value="<?php if ($_smarty_tpl->tpl_vars['class']->value['orderby']){?><?php echo $_smarty_tpl->tpl_vars['class']->value['orderby'];?>
<?php }else{ ?>50<?php }?>"></td>
		</tr>
		<tr>
			<th class="form-button-th"></th>
			<td class="form-button-td"><input type="submit" class="bt-big"  value="提  交  数  据" /></td>
		</tr>
	</table>
	</form>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>