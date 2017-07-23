<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 16:25:47
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/account.html" */ ?>
<?php /*%%SmartyHeaderCode:177473098157b41f8ba994c1-91820214%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c73a13678e8801cd8fa2abc6351d7aa71b044da5' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/account.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '177473098157b41f8ba994c1-91820214',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bank_list' => 0,
    'v' => 0,
    'account_info' => 0,
    'pager' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b41f8bb00234_65238295',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b41f8bb00234_65238295')) {function content_57b41f8bb00234_65238295($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
">基本资料</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
">安全设置</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
">更换手机</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
" class="on">提现帐号</a>
	<div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
<form action="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
<table cellspacing="0" cellpadding="0" class="form">
    <tr><th>开户行：</th><td>
        <select name="data[account_type]" class="select select_td input w-200">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bank_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['account_info']->value['account_type']==$_smarty_tpl->tpl_vars['v']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
            <?php } ?>
        </select>
        </td>
    </tr>
    <tr><th>开户人：</th><td><input type="text" name="data[account_name]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['account_info']->value['account_name'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
    <tr><th>帐号：</th><td><input type="text" name="data[account_number]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['account_info']->value['account_number'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
    <tr><th></th><td><input type="submit" value="保存数据" class="btn btn-primary" /></td></tr>
</table>
</form>
</div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
(function(K, $){
var editor = KindEditor.create('textarea[kindeditor]',{uploadJson : '<?php echo smarty_function_link(array('ctl'=>"biz/upload:editor",'http'=>"base"),$_smarty_tpl);?>
', extraFileUploadParams:{OTOKEN:"<?php echo $_smarty_tpl->tpl_vars['OTOKEN']->value;?>
"}});
})(window.KT, window.jQuery);
</script>  
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>