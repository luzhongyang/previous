<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:09:53
         compiled from "widget:shop/cate_options.html" */ ?>
<?php /*%%SmartyHeaderCode:12491584520d1c33372-42933110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a46ace000d6ace24afa2d995fcb8df3c3d1a282' => 
    array (
      0 => 'widget:shop/cate_options.html',
      1 => 1475911377,
      2 => 'widget',
    ),
  ),
  'nocache_hash' => '12491584520d1c33372-42933110',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'v' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520d1c70aa3_35895849',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520d1c70aa3_35895849')) {function content_584520d1c70aa3_35895849($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<?php if (!$_smarty_tpl->tpl_vars['v']->value['children']){?><option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"<?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['value'])&&in_array($_smarty_tpl->tpl_vars['v']->value['cat_id'],$_smarty_tpl->tpl_vars['data']->value['value']))||$_smarty_tpl->tpl_vars['v']->value['cate_id']==$_smarty_tpl->tpl_vars['data']->value['value']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option><?php }?>
<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
<option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
"<?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['value'])&&in_array($_smarty_tpl->tpl_vars['vv']->value['cat_id'],$_smarty_tpl->tpl_vars['data']->value['value']))||$_smarty_tpl->tpl_vars['vv']->value['cate_id']==$_smarty_tpl->tpl_vars['data']->value['value']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
&nbsp;&nbsp;-><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
<?php } ?>
<?php } ?><?php }} ?>