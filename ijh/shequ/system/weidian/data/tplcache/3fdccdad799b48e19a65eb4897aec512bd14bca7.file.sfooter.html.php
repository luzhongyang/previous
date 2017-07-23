<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:32:45
         compiled from "D:\phpStudy\WWW\shequ\themes\default\block\sfooter.html" */ ?>
<?php /*%%SmartyHeaderCode:233655833ae4d263ef8-38756423%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fdccdad799b48e19a65eb4897aec512bd14bca7' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\block\\sfooter.html',
      1 => 1475911379,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '233655833ae4d263ef8-38756423',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ae4d27dfa5_74990519',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ae4d27dfa5_74990519')) {function content_5833ae4d27dfa5_74990519($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><footer id="block_footer">
    <style type="text/css">
        div.list{width:20%;}
    </style>
    <div class="list" id="l1">
	<a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
">
        <i class="ico_1"></i>
        <p>首页</p>
	</a>
    </div>
    <div class="list" id="l2">
        <a href="<?php echo smarty_function_link(array('ctl'=>'shop'),$_smarty_tpl);?>
">
        <i class="ico_2"></i>
        <p>商家</p>
	</a>
    </div>
    <div class="list" id="l5">
       <a href="<?php echo smarty_function_link(array('ctl'=>'xiaoqu'),$_smarty_tpl);?>
">
        <i class="ico_5"></i>
        <p>小区</p>
        </a>
    </div>
    <div class="list" id="l3">
       <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/order'),$_smarty_tpl);?>
">
        <i class="ico_3"></i>
        <p>订单</p>
        </a>
    </div>
    <div class="list" id="l4">
       <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter'),$_smarty_tpl);?>
">
        <i class="ico_4"></i>
        <p>我的</p>
        </a>
    </div>
</footer><?php }} ?>