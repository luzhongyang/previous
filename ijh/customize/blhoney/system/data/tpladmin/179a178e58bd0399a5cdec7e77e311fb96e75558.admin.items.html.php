<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:22:47
         compiled from "admin:mall/product/items.html" */ ?>
<?php /*%%SmartyHeaderCode:79347009757b2b1375fb705-35464896%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '179a178e58bd0399a5cdec7e77e311fb96e75558' => 
    array (
      0 => 'admin:mall/product/items.html',
      1 => 1470380622,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '79347009757b2b1375fb705-35464896',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'cates' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b1376c7f24_52224517',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b1376c7f24_52224517')) {function content_57b2b1376c7f24_52224517($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_modifier_iplocal')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.iplocal.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"mall/product:create",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"mall/product:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
<form id="items-form">
<table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-100">商品ID</th>
        <th>分类</th>
        <th>名称</th>
        <th>图片</th>
        <th class="w-50">花费积分</th>
        <th class="w-50">浏览次数</th>
        <th class="w-50">库存</th>
        <th class="w-50">销量</th>
        <th class="w-50">排序</th>
        <th class="w-100">添加时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <?php if ($_smarty_tpl->tpl_vars['item']->value['closed']==0){?>
    <tr>
        <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
" name="product_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
<label></td>
        <td><?php echo $_smarty_tpl->tpl_vars['cates']->value[$_smarty_tpl->tpl_vars['item']->value['cate_id']];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
        <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['photo'];?>
" class="wh-50" /></td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['jifen'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['views'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sku'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sales'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
        <td>
            <?php echo smarty_function_link(array('ctl'=>"mall/product:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['product_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"mall/product:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['product_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"mall/product:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['product_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

        </td>
    </tr>
    <?php }?>
    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
    <tr><td colspan="20"><p class="text-align tip-notice">没有数据</p></td></tr>
    <?php } ?>
</table>
</form>
<div class="page-bar">
<table>
    <tr>
        <td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
        <td colspan="10" class="left">
            <?php echo smarty_function_link(array('ctl'=>"mall/product:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"mall/product:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>

        </td>
        <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
    </tr>
</table>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>