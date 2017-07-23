<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 16:36:52
         compiled from "admin:shop/youhui/items.html" */ ?>
<?php /*%%SmartyHeaderCode:66704030057b2d0a48f1239-72628632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3b8bd580882643798af901f2445c8717cddc4cb' => 
    array (
      0 => 'admin:shop/youhui/items.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '66704030057b2d0a48f1239-72628632',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'shop' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2d0a4976dd0_81575307',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2d0a4976dd0_81575307')) {function content_57b2d0a4976dd0_81575307($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
&nbsp;&nbsp;(商铺:<b class="red"><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
</b>)</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/youhui:create",'arg0'=>$_smarty_tpl->tpl_vars['shop']->value['shop_id'],'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr><th class="w-100">ID</th>
                <th class="w-50">满多少</th>
                <th class="w-50">减多少</th>
                <th class="w-50">使用了次数</th>
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
                <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_id'];?>
" name="youhui_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_id'];?>
<label></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_amount'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_amount'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['use_count'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
                            <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
                            <td><?php echo smarty_function_link(array('ctl'=>"shop/youhui:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['youhui_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>
<?php echo smarty_function_link(array('ctl'=>"shop/youhui:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['youhui_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>
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
                                        <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"shop/youhui:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>
</td>
                                        <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>