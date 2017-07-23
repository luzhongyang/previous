<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:32:45
         compiled from "2825d0f305b36962f85f6c090ef12859053613e9" */ ?>
<?php /*%%SmartyHeaderCode:209005833ae4d1f0950-87043398%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2825d0f305b36962f85f6c090ef12859053613e9' => 
    array (
      0 => '2825d0f305b36962f85f6c090ef12859053613e9',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '209005833ae4d1f0950-87043398',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ae4d205278_56705805',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ae4d205278_56705805')) {function content_5833ae4d205278_56705805($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li class="sy_extend_list"><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['clickurl'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['a_attr'];?>
><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" style="max-height:70px;" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" text="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['item_attr'];?>
/></a></li>
<?php } ?><?php }} ?>