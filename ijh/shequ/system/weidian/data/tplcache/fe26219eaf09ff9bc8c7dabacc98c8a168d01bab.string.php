<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:32:45
         compiled from "fe26219eaf09ff9bc8c7dabacc98c8a168d01bab" */ ?>
<?php /*%%SmartyHeaderCode:205335833ae4d169345-33006941%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe26219eaf09ff9bc8c7dabacc98c8a168d01bab' => 
    array (
      0 => 'fe26219eaf09ff9bc8c7dabacc98c8a168d01bab',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '205335833ae4d169345-33006941',
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
  'unifunc' => 'content_5833ae4d1802d3_62372992',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ae4d1802d3_62372992')) {function content_5833ae4d1802d3_62372992($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['a_attr'];?>
><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" text="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" <?php echo $_smarty_tpl->tpl_vars['item']->value['item_attr'];?>
 width="50" height="50"><p><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</p></a></li>
<?php } ?><?php }} ?>