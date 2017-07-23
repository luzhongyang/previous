<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:35:20
         compiled from "admin:product/cate/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:158911237557b289f8155a91-61891660%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '51bbf240eb953d3eb1df847f4e1c6358cc6ab83d' => 
    array (
      0 => 'admin:product/cate/edit.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '158911237557b289f8155a91-61891660',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b289f819e688_08340037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b289f819e688_08340037')) {function content_57b289f819e688_08340037($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"product/cate:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <form action="?product/cate-edit.html" mini-form="cate-form" method="post" ENCTYPE="multipart/form-data">
    <table width="100%" border="0" cellspacing="0" class="table-data form">
        <input type="hidden" name="cate_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['cate_id'];?>
"/>
        <tr>
            <th>商户：</th>
            <td><b><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
</b></td>
        </tr>
        <tr><th><span class="red">*</span>标题：</th><td><input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td></tr>
        <tr><th>排序：</th><td><input type="text" name="data[orderby]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['orderby'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100"/></td></tr>
        <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
    </table>
    </form>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>