<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 16:36:56
         compiled from "admin:shop/youhui/create.html" */ ?>
<?php /*%%SmartyHeaderCode:208158354957b2d0a8c28b99-02244976%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd448128d0230ca10f23ce639cf0d0abbe05b9da' => 
    array (
      0 => 'admin:shop/youhui/create.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '208158354957b2d0a8c28b99-02244976',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'shop_id' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2d0a8c74cc0_26476572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2d0a8c74cc0_26476572')) {function content_57b2d0a8c74cc0_26476572($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/youhui:index",'arg0'=>$_smarty_tpl->tpl_vars['shop_id']->value,'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data"><form action="?shop/youhui-create.html" mini-form="youhui-form" method="post" >
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <input type="hidden" name="shop_id" value="<?php echo $_smarty_tpl->tpl_vars['shop_id']->value;?>
" />
            <tr><th><span class="red">*</span>满多少：</th><td><input type="text" name="data[order_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['order_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">订单最小金额</span></td></tr>
            <tr><th><span class="red">*</span>减多少：</th><td><input type="text" name="data[youhui_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['youhui_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">优惠金额</span></td></tr>
            <tr><th><span class="red">*</span>排序：</th><td><input type="text" name="data[orderby]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['orderby'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100"/><span class="tip-comment">排序</span></td></tr>
            <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
        </table>
    </form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>