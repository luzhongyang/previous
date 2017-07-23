<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:34:55
         compiled from "admin:order/order/items.html" */ ?>
<?php /*%%SmartyHeaderCode:62071680957b289df7d8286-70486180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd484163ab87fa5b361419be3b7b15cbeb7cfe280' => 
    array (
      0 => 'admin:order/order/items.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '62071680957b289df7d8286-70486180',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'shops' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b289df8d0da6_98428806',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b289df8d0da6_98428806')) {function content_57b289df8d0da6_98428806($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right">
                
                <?php echo smarty_function_link(array('ctl'=>"order/order:export",'load'=>"mini:导出订单",'width'=>"mini:400",'class'=>"button",'title'=>"导出"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"order/order:so",'load'=>"mini:搜索内容",'width'=>"mini:400",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>

            </td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
    <th class="w-50">订单ID</th>
    <th class="w-100">商家</th>
    <th class="w-200">订单总价</th>
    <th class="w-100">结算价格</th>
    <th class="w-100">实际支付</th>
    <!--<th class="w-50">结算金额</th>-->
    <th class="w-50">状态</th>
    <th class="w-50">支付</th>
    <th>配送地址</th> 
<!--    
    <th>订单优惠</th>
    <th class="w-50">首单优惠</th>
    <th class="w-50">红包金额</th>
-->
    <th class="w-150">下单时间</th>
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
        <td><?php echo $_smarty_tpl->tpl_vars['shops']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
</td>
        <td>
            <b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['product_price']+$_smarty_tpl->tpl_vars['item']->value['package_price']+$_smarty_tpl->tpl_vars['item']->value['freight'];?>
</b>
            (<?php if ($_smarty_tpl->tpl_vars['item']->value['package_price']){?>打包费:￥<?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['item']->value['freight']){?>，配送费:￥<?php echo $_smarty_tpl->tpl_vars['item']->value['freight'];?>
<?php }?>)
        </td>
        <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['amount']+$_smarty_tpl->tpl_vars['item']->value['money']+$_smarty_tpl->tpl_vars['item']->value['hongbao'];?>
</b></td>
        <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['amount']+$_smarty_tpl->tpl_vars['item']->value['money'];?>
</b> <?php if ($_smarty_tpl->tpl_vars['item']->value['money']>0){?>(余额:￥<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
)<?php }?></td>
        <td><b class="blue"><?php echo $_smarty_tpl->tpl_vars['item']->value['order_status_label'];?>
</b></td>
        <td><?php if (!$_smarty_tpl->tpl_vars['item']->value['online_pay']){?>货到付款<?php }elseif($_smarty_tpl->tpl_vars['item']->value['pay_status']==1){?><b class="green">已支付</b><?php }else{ ?><b class="red">未支付</b><?php }?></td>
        <!--
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['order_youyi'])===null||$tmp==='' ? "0.00" : $tmp);?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['first_youhui'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao'];?>
</td>
        -->
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['house'];?>
(<?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>
,<?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
)</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
        <td>
            <?php echo smarty_function_link(array('ctl'=>"order/order:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"order/order:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['order_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
                <?php echo smarty_function_link(array('ctl'=>"order/order:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"order/order:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>
</td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>