<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:32:45
         compiled from "46120844737b9c39bb1497d8a6bc86e9680f8817" */ ?>
<?php /*%%SmartyHeaderCode:126555833ae4d0fd144-95348264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46120844737b9c39bb1497d8a6bc86e9680f8817' => 
    array (
      0 => '46120844737b9c39bb1497d8a6bc86e9680f8817',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '126555833ae4d0fd144-95348264',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'pager' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ae4d10ef23_51259018',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ae4d10ef23_51259018')) {function content_5833ae4d10ef23_51259018($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" width="100%" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" text="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['item_attr'];?>
 /></li>
<?php } ?><?php }} ?>