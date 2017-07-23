<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:44
         compiled from "admin:config/invite.html" */ ?>
<?php /*%%SmartyHeaderCode:73089154957b2a630e7d8c2-54109377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '78874e55ba349bcb10c3d819ba46177f1b6f8c77' => 
    array (
      0 => 'admin:config/invite.html',
      1 => 1470380607,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '73089154957b2a630e7d8c2-54109377',
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
  'unifunc' => 'content_57b2a630edf077_59293420',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a630edf077_59293420')) {function content_57b2a630edf077_59293420($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data"><form action="?system/config-invite.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="invite" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
    <tr><th>注册奖励：</th><td><input type="text" name="config[invite_reg_money]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['invite_reg_money'])===null||$tmp==='' ? '10' : $tmp);?>
" class="input w-100"/><span class="tip-comment">用户注册后奖励</span></td></tr>
<tr><th>首单奖励：</th><td><input type="text" name="config[invite_order_money]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['invite_order_money'])===null||$tmp==='' ? '10' : $tmp);?>
" class="input w-100"/><span class="tip-comment">用户首单后奖励</span></td></tr>
<tr><th>红包金额：</th><td><input type="text" name="config[hongbao_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['hongbao_amount'])===null||$tmp==='' ? '10' : $tmp);?>
" class="input w-100"/><span class="tip-comment">奖励被邀请的好友的红包</span></td></tr>
<tr><th>最低消费：</th><td><input type="text" name="config[hongbao_min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['hongbao_min_amount'])===null||$tmp==='' ? '20' : $tmp);?>
" class="input w-100"/></td></tr>
<tr><th>分享图片：</th>
    <td>
        <input type="hidden" name="config[share_photo]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['share_photo'];?>
" />
        <input type="file" name="config[share_photo]" class="input w-300" style="vertical-align:middle;display:inline;"/>
        <?php if ($_smarty_tpl->tpl_vars['config']->value['share_photo']){?><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['share_photo'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['config']->value['share_photo'];?>
" class="wh-30" style="vertical-align:middle;display:inline;"/><?php }?>
    </td>
</tr>
<tr><th>分享说明：</th><td><input type="text" name="config[share_title]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['share_title'];?>
" class="input w-500"/></td></tr>
<tr><th>活动说明：</th><td><textarea name="config[intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['config']->value['intro'];?>
</textarea><br /></td></tr>
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>