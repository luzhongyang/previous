<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:33:14
         compiled from "admin:product/cate/items.html" */ ?>
<?php /*%%SmartyHeaderCode:103412898857b2897a0dd3d8-29073384%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c97e1366a1eaaa0a7324f0e0b2a296ef8dbc0fc' => 
    array (
      0 => 'admin:product/cate/items.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '103412898857b2897a0dd3d8-29073384',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'shop_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2897a1699b3_95443648',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2897a1699b3_95443648')) {function content_57b2897a1699b3_95443648($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data"> 
    <form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-100">分类ID</th>
        <th class="w-50">商家</th>
        <th>标题</th>
        <th class="w-50">排序</th>
        <th class="w-100">创建时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
" name="cate_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
<label></td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['shop_list']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
        <td>
            <?php echo smarty_function_link(array('ctl'=>"product/cate:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['cate_id'],'title'=>"修改",'load'=>"mini:修改分类",'width'=>"mini:400",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"product/cate:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['cate_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

        </td>
    </tr>
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
                    <?php echo smarty_function_link(array('ctl'=>"product/cate:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                    <?php echo smarty_function_link(array('ctl'=>"product/cate:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>

                </td>
                <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
            </tr>
        </table>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>