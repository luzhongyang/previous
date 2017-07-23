<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:20:51
         compiled from "d95cdda6059cd104289474a441bebec8f8f91f0c" */ ?>
<?php /*%%SmartyHeaderCode:58875477857b2869366ca94-25609685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd95cdda6059cd104289474a441bebec8f8f91f0c' => 
    array (
      0 => 'd95cdda6059cd104289474a441bebec8f8f91f0c',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '58875477857b2869366ca94-25609685',
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
  'unifunc' => 'content_57b2869368a601_17582609',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2869368a601_17582609')) {function content_57b2869368a601_17582609($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['clickurl'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['a_attr'];?>
><img style="width:100%;height:117px;" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" width="640" height="198" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" text="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['item_attr'];?>
 /></a></li>
<?php } ?><?php }} ?>