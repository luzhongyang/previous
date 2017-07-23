<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:20:51
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/block/sfooter.html" */ ?>
<?php /*%%SmartyHeaderCode:116822426757b2869368f446-69988463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fed59186ed944b100879dbbb9b66779fd346792e' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/block/sfooter.html',
      1 => 1470380629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '116822426757b2869368f446-69988463',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2869369c745_93712542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2869369c745_93712542')) {function content_57b2869369c745_93712542($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><footer>
    <style type="text/css">
        div.list{width:25%;}
    </style>
    <div class="list on" id="l1">
	<a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
">
        <i class="ico_1"></i>
        <p>首页</p>
	</a>
    </div>
    <div class="list" id="l2">
        <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/order:items'),$_smarty_tpl);?>
">
        <i class="ico_2"></i>
        <p>订单</p>
	</a>
    </div>
    <div class="list" id="l4">
       <a href="<?php echo smarty_function_link(array('ctl'=>'mall'),$_smarty_tpl);?>
">
        <i class="ico_3"><span class="tag"><img src="/themes/default/static/images/footerTag.png" /></span></i>
        <p>商城</p>
        </a>
    </div>
    <div class="list" id="l5">
       <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter'),$_smarty_tpl);?>
">
        <i class="ico_4"></i>
        <p>我的</p>
        </a>
    </div>
</footer>
<?php }} ?>