<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 00:22:51
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/page/404.html" */ ?>
<?php /*%%SmartyHeaderCode:54288411557b48f5b6240a8-01300155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73c6a56acc15e8f72126d36514f70f63c1dd8152' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/page/404.html',
      1 => 1470380631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54288411557b48f5b6240a8-01300155',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msgnum' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b48f5b654165_52698902',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b48f5b654165_52698902')) {function content_57b48f5b654165_52698902($_smarty_tpl) {?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
        <header>
            <i class="left">
                <a class="bell_prompt" href="javascript:void(0);"><?php if ($_smarty_tpl->tpl_vars['msgnum']->value>0){?><span class="num"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</span><?php }?></a>
            </i>
            <div class="title"> 404 页面不存在</div>
            <i class="right"></i>
        </header>
        <div class="error_box">
            <div style="text-align:center;"><img src="/themes/default/static/images/none_networkService@2x.png" style="margin:0px auto;" /></div>
        </div>
    </body>
</html>






<?php }} ?>