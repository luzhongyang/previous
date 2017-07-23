<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 11:52:00
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/money/index.html" */ ?>
<?php /*%%SmartyHeaderCode:133157502757b3df60a55423-48264719%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '577b09b12e30653bac93410bc46274e295d7139e' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/money/index.html',
      1 => 1470380643,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133157502757b3df60a55423-48264719',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MEMBER' => 0,
    'items' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b3df60ab2f71_04931572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b3df60ab2f71_04931572')) {function content_57b3df60ab2f71_04931572($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable('我的余额', null, 0);?>
<!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter:index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
    	我的余额
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
	<div class="mineFigure">
    	<div class="mineFigure_state mb10">
        	<div class="fl">
            	<p class="black9">当前余额</p>
                <p class="black9"><big class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['money'];?>
</big> 元</p>
            </div>
            <div class="fr">
            	<a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/money:recharge'),$_smarty_tpl);?>
" class="btn">充值</a>
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="mineFigure_list_box">
        <h3 class="black9">最近30天余额明细</h3>
            <ul>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <li class="mineFigure_list">
                    <div class="fl">
                    	<p><?php echo $_smarty_tpl->tpl_vars['v']->value['intro'];?>
</p>
                        <p class="black9"><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['v']->value['dateline'],'Y-m-d H:i');?>
</p>
                    </div>
                    <div class="fr <?php if ($_smarty_tpl->tpl_vars['v']->value['number']>0){?> fontcl1<?php }else{ ?>pointcl1<?php }?>"><?php echo $_smarty_tpl->tpl_vars['v']->value['number'];?>
</div>
                </li>
            <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
            <div class="youhui_no">
                <div class="iconBg"><i class="ico1"></i> </div>
                <h2>无余额明细</h2>
            </div>
            <?php } ?>
                
            </ul>
        </div>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(document).ready(function() {
    
});
</script>
</body>
</html>
<?php }} ?>