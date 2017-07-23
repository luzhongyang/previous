<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:47
         compiled from "admin:config/site.html" */ ?>
<?php /*%%SmartyHeaderCode:151259709757b2a63364e9c6-00257472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22d132dc777e16776f7209e3d5968f752c39508a' => 
    array (
      0 => 'admin:config/site.html',
      1 => 1470380608,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '151259709757b2a63364e9c6-00257472',
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
  'unifunc' => 'content_57b2a6336f72a7_24141010',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a6336f72a7_24141010')) {function content_57b2a6336f72a7_24141010($_smarty_tpl) {?><?php if (!is_callable('smarty_function_widget')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.widget.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data">
<form action="?system/config-site.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="site" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
<tr><th class="w-100">网站名称：</th><td><input type="text" name="config[title]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['title'];?>
" class="input w-300"/></td></tr>
<tr><th class="w-100">网站网址：</th><td><input type="text" name="config[siteurl]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['siteurl'];?>
" class="input w-300"/></td></tr>
<tr><th class="w-100">网站密钥：</th><td><input type="text" name="config[secret]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['secret'];?>
" class="input w-300"/></td></tr>
<tr><th class="w-100">联系邮箱：</th><td><input type="text" name="config[mail]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['mail'];?>
" class="input w-300"/></td></tr>
<tr><th class="w-100">客服QQ：</th><td><input type="text" name="config[kfqq]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['kfqq'];?>
" class="input w-300"/><span class="tip-comment">多个QQ用","分隔</span></td></tr>
<tr><th class="w-100">联系电话：</th><td><input type="text" name="config[phone]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['phone'];?>
" class="input w-300"/></td></tr>
<tr><th>网站LOGO：</th>
    <td>
        <input type="hidden" name="config[logo]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['logo'];?>
" />
        <input type="file" name="config[logo]" class="input w-300" style="vertical-align:middle;display:inline;"/>
        <?php if ($_smarty_tpl->tpl_vars['config']->value['logo']){?><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['logo'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['logo'];?>
" class="wh-30" style="vertical-align:middle;display:inline;"/><?php }?>
    </td>
</tr>
<tr><th>微信二维码：</th>
    <td>
        <input type="hidden" name="config[weixinqr]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['weixinqr'];?>
" />
        <input type="file" name="config[weixinqr]" class="input w-300" style="vertical-align:middle;display:inline;"/>
        <?php if ($_smarty_tpl->tpl_vars['config']->value['weixinqr']){?><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['weixinqr'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['weixinqr'];?>
" class="wh-30" style="vertical-align:middle;display:inline;"/><?php }?>
    </td>
</tr>
<tr><th class="w-100">开启订单审核：</th>
	<td>
		<label><input type="radio" name="config[is_status]" <?php if ($_smarty_tpl->tpl_vars['config']->value['is_status']){?>checked="checked"<?php }?> value="1"/>开启</label>&nbsp;&nbsp;
		<label><input type="radio" name="config[is_status]" <?php if (empty($_smarty_tpl->tpl_vars['config']->value['is_status'])){?>checked="checked"<?php }?> value="0"/>关闭</label>
		<span class="tip-comment">建议给客户测试订单时再关闭。</span>
	</td>
</tr>
<tr><th class="w-100">默认城市：</th><td><select name="config[city_id]" class="w-100"><?php echo smarty_function_widget(array('id'=>"data/city",'value'=>$_smarty_tpl->tpl_vars['config']->value['city_id']),$_smarty_tpl);?>
</select></td></tr>
<tr>
	<th>开启多城市：</th>
	<td>
		<label><input type="radio" name="config[multi_city]" <?php if ($_smarty_tpl->tpl_vars['config']->value['multi_city']){?>checked="checked"<?php }?> value="1"/>开启</label>&nbsp;&nbsp;
		<label><input type="radio" name="config[multi_city]" <?php if (isset($_smarty_tpl->tpl_vars['config']->value['multi_city'])&&empty($_smarty_tpl->tpl_vars['config']->value['multi_city'])){?>checked="checked"<?php }?> value="0"/>关闭</label>
	</td>
</tr>
<tr><th class="w-100">根域名：</th>
    <td>
        <input type="text" name="config[domain]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['domain'];?>
" class="input w-300"/>
        <span class="tip-comment">开启多城市或设置频道域名，必须设置此项否则网站无法打开</span>
    </td>
</tr>

<tr>
	<th>开启伪静态：</th><td>
		<label><input type="radio" name="config[rewrite]" <?php if ($_smarty_tpl->tpl_vars['config']->value['rewrite']){?>checked="checked"<?php }?> value="1"/>开启</label>&nbsp;&nbsp;
		<label><input type="radio" name="config[rewrite]" <?php if (empty($_smarty_tpl->tpl_vars['config']->value['rewrite'])){?>checked="checked"<?php }?> value="0"/>关闭</label>
	</td>
</tr>
<tr><th>网站简介：</th><td><textarea name="config[intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['intro'];?>
</textarea><br /></td></tr>
<tr><th>统计代码：</th><td><textarea name="config[tongji]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['tongji'];?>
</textarea><br /></td></tr>
<tr><th class="w-100">备案信息：</th><td><input type="text" name="config[icp]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['icp'];?>
" class="input w-300"/></td></tr>
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>