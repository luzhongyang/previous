<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 15:16:36
         compiled from "admin:product/product/so.html" */ ?>
<?php /*%%SmartyHeaderCode:128776360357b803d4902bf0-38860154%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '155e91d61e16b8065d206099f0dffe33f70f2de1' => 
    array (
      0 => 'admin:product/product/so.html',
      1 => 1470380626,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '128776360357b803d4902bf0-38860154',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b803d49488d3_75539541',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b803d49488d3_75539541')) {function content_57b803d49488d3_75539541($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"product/product:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data"><form action="?product/product-index.html" id="SO-form" method="post">
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <tr>
                <th><span class="red">*</span>选择商户：</th>
                <td>
                    <input type="hidden" name="SO[shop_id]" value="" id="select_shop_shop_id_id" />
                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
" id="select_shop_shop_id_title" class="input w-200" readonly/>
                    <?php echo smarty_function_link(array('ctl'=>"shop/shop:dialog",'select'=>"mini:#select_shop_shop_id_id,#select_shop_shop_id_title/N/选择商户",'title'=>"选择商户",'class'=>"button"),$_smarty_tpl);?>

                </td>
            </tr>
            <tr><th>标题：</th><td><input type="text" name="SO[title]" value="" class="input w-300"/>标题</td></tr>    <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="搜 索" /></td></tr>
        </table>
    </form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>