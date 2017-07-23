<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:45
         compiled from "admin:config/wx_config.html" */ ?>
<?php /*%%SmartyHeaderCode:157321997357b2a631761623-33051327%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee0e1ff44f5a79a34d9886b82ce5a7e3f6326a5e' => 
    array (
      0 => 'admin:config/wx_config.html',
      1 => 1470380608,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '157321997357b2a631761623-33051327',
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
  'unifunc' => 'content_57b2a6317a3e83_80238256',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a6317a3e83_80238256')) {function content_57b2a6317a3e83_80238256($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data"><form action="?system/config-wx_config.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="wx_config" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
<tr><th>订单状态通知：</th>
    <td>
    <ul class="group-list">
        <li style="width:200px;">模板库编号：
            <input type="text" name="config[order_number]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['order_number'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100" readonly="true" />
        </li>
        <li style="width:400px;">模板ID号：
            <input type="text" name="config[order_id]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['order_id'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/>
        </li>
        <div class="clear-both"></div>
    </ul>
    </td>
</tr>

<tr><th>资金变动通知：</th>
    <td>
    <ul class="group-list">
        <li style="width:200px;">模板库编号：
            <input type="text" name="config[money_number]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['money_number'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100" readonly="true" />
        </li>
        <li style="width:400px;">模板ID号：
            <input type="text" name="config[money_id]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['money_id'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/>
        </li>
        <div class="clear-both"></div>
    </ul>
    </td>
</tr>


<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>