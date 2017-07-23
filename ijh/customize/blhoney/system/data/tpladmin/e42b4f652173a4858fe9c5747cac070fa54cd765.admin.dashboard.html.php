<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:36:03
         compiled from "admin:order/order/dashboard.html" */ ?>
<?php /*%%SmartyHeaderCode:16827790357b51103da94a9-52763140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e42b4f652173a4858fe9c5747cac070fa54cd765' => 
    array (
      0 => 'admin:order/order/dashboard.html',
      1 => 1470380624,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '16827790357b51103da94a9-52763140',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'money' => 0,
    'order' => 0,
    'new_order' => 0,
    'new_mem' => 0,
    'new_shop' => 0,
    'shop_txs' => 0,
    'staff_txs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b51103df8805_40667003',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b51103df8805_40667003')) {function content_57b51103df8805_40667003($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<style type="text/css">
.no_link {
    background: #2B5CB0;
}
.has_link {
    background: #65AD03;
}
.admin_info {
    color: white;
    float: left;
    font-size: 18px;
    font-weight: bold;
    height: 50px;
    margin-left:20px;
    margin-right: 20px;
    margin-top: 60px;
    text-align: center;
    width: 205px;
    vertical-align: middle;
    padding: 35px 0;
}
</style>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
         <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="admin_info no_link"><p>&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['money']->value)===null||$tmp==='' ? '0' : $tmp);?>
.00<br>今日营业额</p></div>
<div class="admin_info no_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['order']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>今日订单数</p></div>
<a href="?order/order-neworder.html"><div class="admin_info has_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['new_order']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>今日新订单</p></div></a>
<div class="admin_info no_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['new_mem']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>今日新会员</p></div>
<a href="?order/order-newshop.html"><div class="admin_info has_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['new_shop']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>今日新商户</p></div></a>
<a href="?order/order-shoptx.html"><div class="admin_info has_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['shop_txs']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>商户提现</p></div></a>
<a href="?order/order-stafftx.html"><div class="admin_info has_link"><p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['staff_txs']->value)===null||$tmp==='' ? '0' : $tmp);?>
<br>配送员提现</p></div></a>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>