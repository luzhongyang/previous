<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:42
         compiled from "admin:config/app_download.html" */ ?>
<?php /*%%SmartyHeaderCode:4292767657b2a62e6c9481-45507260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42678baac80eee3b5deadd8ac82d5b4da9c22a70' => 
    array (
      0 => 'admin:config/app_download.html',
      1 => 1470380607,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '4292767657b2a62e6c9481-45507260',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a62e720670_79839644',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a62e720670_79839644')) {function content_57b2a62e720670_79839644($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"></td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data"><form action="?system/config-app_download.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="app_download" />
<table width="100%" border="0" cellspacing="0" class="table-data form"><tr><th>客户端版本：</th><td><input type="text" name="config[waimai_version]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['waimai_version'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
<tr><th>客户端下载地址：</th><td><input type="text" name="config[waimai_download]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['waimai_download'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/><span class="tip-comment">客户端下载地址 http:// 开头</span></td></tr>
<tr><th>客户端版本更新说明：</th><td><textarea name="config[waimai_intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['waimai_intro'];?>
</textarea><br /></td></tr>
<tr><th>商户端版本：</th><td><input type="text" name="config[biz_version]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['biz_version'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
<tr><th>商户端下载地址：</th><td><input type="text" name="config[biz_download]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['biz_download'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/><span class="tip-comment">商户端下载地址 http:// 开头</span></td></tr>
<tr><th>商户端版本更新说明：</th><td><textarea name="config[biz_intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['biz_intro'];?>
</textarea><br /></td></tr>
<tr><th>配送端版本：</th><td><input type="text" name="config[staff_version]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['staff_version'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
<tr><th>配送端下载地址：</th><td><input type="text" name="config[staff_download]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['staff_download'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/><span class="tip-comment">配送端下载地址 http:// 开头</span></td></tr>
<tr><th>配送端版本更新说明：</th><td><textarea name="config[staff_intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['staff_intro'];?>
</textarea><br /></td></tr>
    <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>