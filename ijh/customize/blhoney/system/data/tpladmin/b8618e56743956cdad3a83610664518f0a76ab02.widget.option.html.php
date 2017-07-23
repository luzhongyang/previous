<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:31:56
         compiled from "widget:default/option.html" */ ?>
<?php /*%%SmartyHeaderCode:162483429157b2892cefe635-66284184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8618e56743956cdad3a83610664518f0a76ab02' => 
    array (
      0 => 'widget:default/option.html',
      1 => 1470380617,
      2 => 'widget',
    ),
  ),
  'nocache_hash' => '162483429157b2892cefe635-66284184',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2892cf0a713_89844768',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2892cf0a713_89844768')) {function content_57b2892cf0a713_89844768($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/data/htdocs/blhoney_com/public_html/system/libs/smarty/plugins/function.html_options.php';
?><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['data']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['data']->value['value'],'value'=>$_smarty_tpl->tpl_vars['detail']->value['value']),$_smarty_tpl);?>
<?php }} ?>