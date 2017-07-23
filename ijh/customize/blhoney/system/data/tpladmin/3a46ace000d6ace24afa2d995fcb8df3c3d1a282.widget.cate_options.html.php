<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:31:56
         compiled from "widget:shop/cate_options.html" */ ?>
<?php /*%%SmartyHeaderCode:21732335657b2892cf10d64-05287954%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a46ace000d6ace24afa2d995fcb8df3c3d1a282' => 
    array (
      0 => 'widget:shop/cate_options.html',
      1 => 1470380618,
      2 => 'widget',
    ),
  ),
  'nocache_hash' => '21732335657b2892cf10d64-05287954',
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
  'unifunc' => 'content_57b2892d011322_41289796',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2892d011322_41289796')) {function content_57b2892d011322_41289796($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"<?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['value'])&&in_array($_smarty_tpl->tpl_vars['v']->value['cat_id'],$_smarty_tpl->tpl_vars['data']->value['value']))||$_smarty_tpl->tpl_vars['v']->value['cate_id']==$_smarty_tpl->tpl_vars['data']->value['value']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
<option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
"<?php if ((is_array($_smarty_tpl->tpl_vars['data']->value['value'])&&in_array($_smarty_tpl->tpl_vars['vv']->value['cat_id'],$_smarty_tpl->tpl_vars['data']->value['value']))||$_smarty_tpl->tpl_vars['vv']->value['cate_id']==$_smarty_tpl->tpl_vars['data']->value['value']){?>selected="selected"<?php }?>>&nbsp;&nbsp;├─<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
<?php } ?>
<?php } ?><?php }} ?>