<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:46:14
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/order/dialog.html" */ ?>
<?php /*%%SmartyHeaderCode:202676087957b28c862fe6d8-09888114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5429ade1521194861aa2c3efd8e8517382bafeea' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/order/dialog.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '202676087957b28c862fe6d8-09888114',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28c8632a3b9_40860578',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28c8632a3b9_40860578')) {function content_57b28c8632a3b9_40860578($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><div class="ucenter_c" style="width: 400px; height: 200px; min-height:0px;">
    <form action="<?php echo smarty_function_link(array('ctl'=>'biz/order/setspend'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <td style="text-align:center;">您可以使用输入密码方式来进行核销：</td>
            </tr>
            <tr>
                <td style="text-align:center;">
                    <input type="hidden" class="input w-150" name="data[order_id]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['order_id'];?>
" />
                    <input type="text" class="input w-150" name="data[spend_number]" value="" />
                </td>
            </tr>
            <tr>
                <td style="text-align:center;"><input type="submit" value="确认消费" class="btn btn-success" style="padding:5px 45px 5px 45px;"/></td>
            </tr>
        </table>
    </form>
</div>
<?php }} ?>