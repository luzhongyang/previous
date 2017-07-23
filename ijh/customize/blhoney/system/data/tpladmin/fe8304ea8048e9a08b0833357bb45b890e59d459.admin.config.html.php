<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 19:44:22
         compiled from "admin:payment/config.html" */ ?>
<?php /*%%SmartyHeaderCode:14400493157b2fc96139bd6-79047218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe8304ea8048e9a08b0833357bb45b890e59d459' => 
    array (
      0 => 'admin:payment/config.html',
      1 => 1470380609,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '14400493157b2fc96139bd6-79047218',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'payment_config' => 0,
    'config' => 0,
    'key' => 0,
    'k' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2fc9622a343_62628386',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2fc9622a343_62628386')) {function content_57b2fc9622a343_62628386($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_html_options')) include '/data/htdocs/blhoney_com/public_html/system/libs/smarty/plugins/function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"payment/payment:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
<form action="?payment/payment-config.html" mini-form="payment-form" method="post" ENCTYPE="multipart/form-data">
<table width="100%" border="0" cellspacing="0" class="table-data form">
<input type="hidden" name="payment_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['payment_id'];?>
"/>
<tr><th>接口介绍：</th><td><div style="padding:10px;"><?php echo $_smarty_tpl->tpl_vars['payment_config']->value['content'];?>
</div></td></tr>
<tr><th>支付接口：</th>
    <td>
        <input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['payment_config']->value['name'] : $tmp);?>
" class="input w-300"/>
    </td>
</tr>
<tr><th>接口标识：</th><td><b class="blue"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['payment'])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['payment_config']->value['code'] : $tmp);?>
</b></td></tr>
<tr><th>接口Logo：</th><td><input type="text" name="data[logo]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['logo']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
"<?php }?> class="input w-300" />&nbsp;&nbsp;&nbsp;<input type="file" name="payment_logo" class="input w-100" /></td></tr>

<?php  $_smarty_tpl->tpl_vars['config'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['config']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['payment_config']->value['config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['config']->key => $_smarty_tpl->tpl_vars['config']->value){
$_smarty_tpl->tpl_vars['config']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['config']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['config']->value['type']=='password'){?>
<tr><th><?php echo $_smarty_tpl->tpl_vars['config']->value['text'];?>
：</th>
    <td><input type="password" name="data[config][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['config'][$_smarty_tpl->tpl_vars['key']->value];?>
" class="input w-300"/><span class="tip-comment"><?php echo $_smarty_tpl->tpl_vars['config']->value['desc'];?>
</span></td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['config']->value['type']=='select'){?>
<tr><th><?php echo $_smarty_tpl->tpl_vars['config']->value['text'];?>
：</th>
    <td>
        <select name="data[config][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" class="select w-200"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['config']->value['items'],'selected'=>$_smarty_tpl->tpl_vars['detail']->value['config'][$_smarty_tpl->tpl_vars['key']->value]),$_smarty_tpl);?>
</select>
        <span class="tip-comment"><?php echo $_smarty_tpl->tpl_vars['config']->value['desc'];?>
</span>
    </td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['config']->value['type']=='radio'){?>
<tr><th><?php echo $_smarty_tpl->tpl_vars['config']->value['text'];?>
：</th>
    <td>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['config']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
        <label><input type="radio" name="data[config][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['config'][$_smarty_tpl->tpl_vars['key']->value]==$_smarty_tpl->tpl_vars['k']->value){?>checked<?php }?>/><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</label>
        <?php } ?>
        <span class="tip-comment"><?php echo $_smarty_tpl->tpl_vars['config']->value['desc'];?>
</span>
    </td>
</tr>
<?php }elseif($_smarty_tpl->tpl_vars['config']->value['type']=='text'){?>
<tr><th><?php echo $_smarty_tpl->tpl_vars['config']->value['text'];?>
：</th>
    <td><input type="text" name="data[config][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['config'][$_smarty_tpl->tpl_vars['key']->value];?>
" class="input w-300"/><span class="tip-comment"><?php echo $_smarty_tpl->tpl_vars['config']->value['desc'];?>
</span></td>
</tr>
<?php }?>
<?php } ?>
<tr>
	<th>状态：</th>
	<td>
		<label><input type="radio" name="data[status]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['status']){?>checked="checked"<?php }?> value="1"/>开启</label>&nbsp;&nbsp;
		<label><input type="radio" name="data[status]" <?php if (isset($_smarty_tpl->tpl_vars['detail']->value['status'])&&empty($_smarty_tpl->tpl_vars['detail']->value['status'])){?>checked="checked"<?php }?> value="0"/>关闭</label>
	</td>
</tr>
    <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>