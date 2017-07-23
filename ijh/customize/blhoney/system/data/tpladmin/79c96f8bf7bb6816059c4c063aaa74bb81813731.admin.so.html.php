<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 18:29:56
         compiled from "admin:shop/shop/so.html" */ ?>
<?php /*%%SmartyHeaderCode:117167627157b2eb24840699-45822610%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79c96f8bf7bb6816059c4c063aaa74bb81813731' => 
    array (
      0 => 'admin:shop/shop/so.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '117167627157b2eb24840699-45822610',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2eb24892d88_03002071',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2eb24892d88_03002071')) {function content_57b2eb24892d88_03002071($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_widget')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.widget.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/shop:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
<?php if ($_smarty_tpl->tpl_vars['pager']->value['target']=='dialog'){?>
<form action="?shop/shop-dialog.html&MINI=LoadIframe" id="SO-form" method="post">
<input type="hidden" name="multi" value="<?php echo $_smarty_tpl->tpl_vars['pager']->value['multi'];?>
" />
<?php }else{ ?>
<form action="?shop/shop-index.html" id="SO-form" method="post">
<?php }?>
<table width="100%" border="0" cellspacing="0" class="table-data form">
    <tr>
        <th>城市ID：</th>
        <td>
            <select name="SO[city_id]" class="w-100">
                <option value="">不限</option>
                <?php echo smarty_function_widget(array('id'=>"data/city",'type'=>"option"),$_smarty_tpl);?>

            </select>
        </td>
    </tr>
    <tr><th>分类ID：</th><td><select name="SO[cate_id]" class="w-100"><option value="">不限</option><?php echo smarty_function_widget(array('id'=>"shop/cate",'type'=>"option"),$_smarty_tpl);?>
</select></td></tr>
    <tr><th>手机号：</th><td><input type="text" name="SO[mobile]" value="" class="input w-200"/>手机号，登录用</td></tr>
    <tr><th>商家名称：</th><td><input type="text" name="SO[title]" value="" class="input w-200"/></td></tr>
    <tr><th>地址：</th><td><input type="text" name="SO[addr]" value="" class="input w-200"/></td></tr>
    <tr><th>创建时间：</th><td><input type="text" name="SO[dateline][0]" value="" class="input w-100" date="dateline" readonly/>~<input type="text" name="SO[dateline][1]" value="" class="input w-100" date="dateline" readonly/></td></tr>    <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="搜 索" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>