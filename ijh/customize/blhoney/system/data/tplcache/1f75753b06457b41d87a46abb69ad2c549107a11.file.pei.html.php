<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:40
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pei.html" */ ?>
<?php /*%%SmartyHeaderCode:156685941857b2af14157b16-51433183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f75753b06457b41d87a46abb69ad2c549107a11' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pei.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156685941857b2af14157b16-51433183',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af141ba645_25557613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af141ba645_25557613')) {function content_57b2af141ba645_25557613($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
">基本资料</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
">安全设置</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
">更换手机</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
">提现帐号</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:pei'),$_smarty_tpl);?>
" class="on">配送设置</a>
	<div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
<form action="<?php echo smarty_function_link(array('ctl'=>'biz/shop:pei'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
<table cellspacing="0" cellpadding="0" class="form">
    <tr>
        <th>起步金额：</th>
        <td><input type="text" name="data[min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['min_amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td>
    </tr>
    <!--<tr>
        <th>配送费：</th>
        <td><input type="text" name="data[freight]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['freight'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td>
    </tr>
    <tr>
        <th>配送距离：</th>
        <td>
            <input type="text" name="data[pei_distance]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['pei_distance'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/>
            <span class="comment-tip">单位千米</span>
        </td>
    </tr>
    <tr>
        <th>配送方式：</th>
        <td>
        <select name="data[pei_type]" id="pei_type_select" class="select select_td input w-200">
            <option value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==0){?>selected<?php }?> >自己送</option>
            <option value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==1){?>selected<?php }?> >第三方配送</option>
            <option value="2" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==2){?>selected<?php }?> >第三方代购及配送</option>
        </select>
        </td>
    </tr>    
    <tr>
        <th>配送结算价：</th>
        <td>
            <input type="text" name="data[pei_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['pei_amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/>
            <span class="comment-tip">由第三方配送时支付给配送员的费用</span>
        </td>
    </tr>-->
    <tr><th></th><td><input type="submit" value="保存数据" class="btn btn-primary" /></td></tr>
</table>
</form>
</div>
<script type="text/javascript">
(function(K, $){
$("#pei_type_select").chanage(function(){
    //$(this).val()
})
})(window.KT, window.jQuery);
</script>  
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>