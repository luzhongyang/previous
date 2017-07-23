<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:44
         compiled from "admin:config/jifen.html" */ ?>
<?php /*%%SmartyHeaderCode:182745123657b2a6306a2440-65629580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7a144fc6328f549099472fd444a873fda91b482' => 
    array (
      0 => 'admin:config/jifen.html',
      1 => 1470380607,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '182745123657b2a6306a2440-65629580',
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
  'unifunc' => 'content_57b2a6306d65c6_87692714',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a6306d65c6_87692714')) {function content_57b2a6306d65c6_87692714($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data"><form action="?system/config-jifen.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="jifen" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
    <tr><th>1元奖积分数：</th><td><input type="text" name="config[jifen_ratio]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['jifen_ratio'])===null||$tmp==='' ? '1' : $tmp);?>
" class="input w-100"/><span class="tip-comment">用户下单后评价根据订单金额获取积分（1代表1元奖1积分）</span></td></tr>
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>