<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 20:53:22
         compiled from "admin:mall/order/items.html" */ ?>
<?php /*%%SmartyHeaderCode:2864797457b30cc2d2e412-83653257%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c41c036d9991e81b871c1c284a174f19440c6287' => 
    array (
      0 => 'admin:mall/order/items.html',
      1 => 1471248452,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '2864797457b30cc2d2e412-83653257',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'members' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b30cc2e54a40_32111813',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b30cc2e54a40_32111813')) {function content_57b30cc2e54a40_32111813($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><!--<?php echo smarty_function_link(array('ctl'=>"mall/order:create",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
-->
                <?php echo smarty_function_link(array('ctl'=>"mall/order:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
        <table width="100%" border="0" cellspacing="0" class="table-data table">
         <tr><th class="w-100">订单ID</th>
        <th class="w-50">用户ID</th>
        <th class="w-50">支付积分</th>
        <th class="w-50">支付金额</th>
        <th>收货人</th>
        <th>手机号</th>
        <th>收货地址</th>
        <th>收货IP</th>
        <th>订单状态</th>
        <th class="w-100">购买时间</th>
        <th class="w-150">操作</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
        <tr>
            <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
" name="order_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
<label></td>
        <td><?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
(UID:<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
)</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['product_jifen'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['product_price'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['addr'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
</td>
        <td> 
            <?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==5){?>
            <span class="green" style="font-weight: bold;">已发货</span>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==0){?>
            <span class="red" style="font-weight: bold;">未发货</span>
            <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==8){?>
            <span class="blue" style="font-weight: bold;">已完成</span>
            <?php }?>
        </td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
        <td>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

        <?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==0){?>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:deliver",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'act'=>"mini:发货",'confirm'=>"mini:确定要发货吗？",'title'=>"发货",'class'=>"button"),$_smarty_tpl);?>

        <?php }else{ ?>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:finish",'title'=>"已发",'class'=>"button"),$_smarty_tpl);?>

        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==0){?>
        <?php echo smarty_function_link(array('title'=>"运单",'class'=>"button"),$_smarty_tpl);?>

        <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==5){?>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:post_edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'title'=>"运单",'class'=>"button"),$_smarty_tpl);?>

        <?php }else{ ?>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:post_edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'title'=>"运单",'class'=>"button"),$_smarty_tpl);?>

        <?php }?>
        <?php echo smarty_function_link(array('ctl'=>"mall/order:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>
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
            <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"mall/order:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"mall/order:deliver",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量发货吗?",'priv'=>"hide",'value'=>"批量发货"),$_smarty_tpl);?>
</td>
            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
        </tr>
    </table>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>