<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:33:08
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/help/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:91496657257b2a5943a5086-19119359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c35c98f0a1f9ff7508c59658105978960f3663d6' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/help/detail.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '91496657257b2a5943a5086-19119359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a5943e99e4_37184438',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a5943e99e4_37184438')) {function content_57b2a5943e99e4_37184438($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'help/index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title" style="overflow;hidden;">
        <?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>

    </div>
</header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
<section class="page_center_box">
    <div class="message_list_details"><?php echo nl2br($_smarty_tpl->tpl_vars['detail']->value['content']);?>
</div>
</section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<script>
    $(document).ready(function(){
    
        $('#l5').addClass('on');
     
    });
</script>
</body>
</html>
<?php }} ?>