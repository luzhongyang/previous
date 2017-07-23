<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:35:56
         compiled from "admin:order/complaint/items.html" */ ?>
<?php /*%%SmartyHeaderCode:181246959957b510fc701f19-24711916%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc782ddfc729031e930cf4cc33b6e9a664cdd872' => 
    array (
      0 => 'admin:order/complaint/items.html',
      1 => 1470380624,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '181246959957b510fc701f19-24711916',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'users' => 0,
    'shops' => 0,
    'staffs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b510fc7c2ce8_25617081',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b510fc7c2ce8_25617081')) {function content_57b510fc7c2ce8_25617081($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_modifier_iplocal')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.iplocal.php';
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
    <tr><th class="w-50">投诉编号</th>
        <th class="w-50">订单ID</th>
        <th class="w-50">用户</th>
        <th class="w-50">商家</th>
        <th class="w-50">配送员</th>
        <th>类型</th>
        <th>投诉</th>
        <th>回复</th>
        <th class="w-100">创建时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
    <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['complaint_id'];?>
" name="complaint_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['complaint_id'];?>
<label></td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['shops']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
</td>
    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['staff_id']>0){?><?php echo $_smarty_tpl->tpl_vars['staffs']->value[$_smarty_tpl->tpl_vars['item']->value['staff_id']]['name'];?>
(ID:<?php echo $_smarty_tpl->tpl_vars['item']->value['staff_id'];?>
)<?php }else{ ?>无<?php }?></td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</td>
    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['reply_time']>0){?><?php echo $_smarty_tpl->tpl_vars['item']->value['reply'];?>
<br />By:<?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['reply_time']);?>
<?php }else{ ?>---<?php }?></td>
    <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
    <td>
        <?php echo smarty_function_link(array('ctl'=>"order/complaint:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['complaint_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

        <?php if (empty($_smarty_tpl->tpl_vars['item']->value['reply'])){?><?php echo smarty_function_link(array('ctl'=>"order/complaint:reply",'arg0'=>$_smarty_tpl->tpl_vars['item']->value['complaint_id'],'title'=>"回复",'width'=>"mini:450",'load'=>"mini:回复投诉",'class'=>"button"),$_smarty_tpl);?>
<?php }?>
        <?php echo smarty_function_link(array('ctl'=>"order/complaint:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['complaint_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>
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
            <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"order/complaint:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
        </tr>
    </table>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>