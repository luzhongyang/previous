<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:49:56
         compiled from "admin:shop/verify/items.html" */ ?>
<?php /*%%SmartyHeaderCode:204421219457b28d643db8c2-57033577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2cf3ead9154286b2bb8458bbba1dd04cb00d79a5' => 
    array (
      0 => 'admin:shop/verify/items.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '204421219457b28d643db8c2-57033577',
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
  'unifunc' => 'content_57b28d644b2ae1_50633649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28d644b2ae1_50633649')) {function content_57b28d644b2ae1_50633649($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/verify:so",'load'=>"mini:搜索内容",'width'=>"mini:400",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-100">商家</th>
        <th>店主姓名</th>
        <th>店主身份证号</th>
        <th class="w-50">店主认证</th>
        <th>营业执照号</th>
        <th class="w-50">营业执照认证</th>
        <th>餐饮执照号</th>
        <th class="w-50">餐饮认证</th>
        <th class="w-100">申请时间</th>
        <th class="w-50">状态</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td>
            <label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
" name="shop_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['shop_list']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
(<?php echo $_smarty_tpl->tpl_vars['shop_list']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
)<label>
        </td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['id_name'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['id_number'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['verify_dianzhu']==1){?>
            <b class="green">通过</b>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['verify_dianzhu']==2){?>
            <b class="red">拒绝</b>
            <?php }else{ ?>
            <b class="blue">待审</b>
            <?php }?>
        </td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['yz_number'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['verify_yyzz']==1){?>
            <b class="green">通过</b>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['verify_yyzz']==2){?>
            <b class="red">拒绝</b>
            <?php }else{ ?>
            <b class="blue">待审</b>
            <?php }?>
        </td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['cy_number'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['verify_cy']==1){?>
            <b class="green">通过</b>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['verify_cy']==2){?>
            <b class="red">拒绝</b>
            <?php }else{ ?>
            <b class="blue">待审</b>
            <?php }?>
        </td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['updatetime']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['updatetime']);?>
<?php }else{ ?>--<?php }?></td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['verify']==1){?>
            <b class="green">通过</b>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['verify']==2){?>
            <b class="red">拒绝</b>
            <?php }else{ ?>
            <b class="blue">待审</b>
            <?php }?>
        </td>        
        <td>
            <?php echo smarty_function_link(array('ctl'=>"shop/verify:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

            
            <?php echo smarty_function_link(array('ctl'=>"shop/verify:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
                <?php echo smarty_function_link(array('ctl'=>"shop/verify:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"shop/verify:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>

            </td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>