<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 20:20:00
         compiled from "admin:member/member/money.html" */ ?>
<?php /*%%SmartyHeaderCode:202494580057b304f085ea01-56648569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51f5a474c6b7ffa36d30ced1500fa41ec2bdc8b0' => 
    array (
      0 => 'admin:member/member/money.html',
      1 => 1470380623,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '202494580057b304f085ea01-56648569',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b304f089fc04_25639457',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b304f089fc04_25639457')) {function content_57b304f089fc04_25639457($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"member/member:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <form action="?member/member-money.html" mini-form="money-form" method="post">
        <input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['uid'];?>
" />
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <tr>
                <th>用户：</th>
                <td><?php echo $_smarty_tpl->tpl_vars['detail']->value['nickname'];?>
</td>
            </tr>
            <tr>
                <th>余额：</th>
                <td><b class="red"><?php echo $_smarty_tpl->tpl_vars['detail']->value['money'];?>
</b></td>
            </tr>
            <tr>
                <th>数目：</th>
                <td><input type="text" name="data[money]" value="" class="input w-100"/>&nbsp;<b class="red"> 输入负值表示减少金币</b></td>
            </tr>
            <tr>
                <th>备注：</th>
                <td><textarea name="data[intro]" class="textarea" style="width:300px;height:80px;"></textarea></td>
            </tr>
            <tr>
                <th class="clear-th-bottom"></th>
                <td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="充值余额" /></td>
            </tr>
        </table>
    </form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>