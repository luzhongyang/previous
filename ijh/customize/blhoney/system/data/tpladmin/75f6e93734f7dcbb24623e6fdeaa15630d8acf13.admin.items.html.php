<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:10:26
         compiled from "admin:shop/shop/items.html" */ ?>
<?php /*%%SmartyHeaderCode:93206213457b284220a38b0-72672018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75f6e93734f7dcbb24623e6fdeaa15630d8acf13' => 
    array (
      0 => 'admin:shop/shop/items.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '93206213457b284220a38b0-72672018',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28422192036_87161862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28422192036_87161862')) {function content_57b28422192036_87161862($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
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
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/shop:create",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"shop/shop:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-100">商家ID</th>
        <th>商家名称</th>
        <th>手机号</th>
        <th class="w-100">总营收</th>       
        <th class="w-100">余额</th>
        <th class="w-100">订单数</th>       
        <th class="w-50">在线支付</th>
        <th class="w-50">审核</th>        
        <th class="w-150">创建时间</th>
        <th class="w-200">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
" name="shop_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
<label></td>        
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['title'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
        <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['total_money'];?>
</b></td>
        <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</b></td>
        <td><b class="blue"><?php echo $_smarty_tpl->tpl_vars['item']->value['orders'];?>
</b></td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['online_pay']==1){?><b class="green">支持</b><?php }else{ ?><b class="red">不支持</b><?php }?></td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['audit']==1){?><b class="green">正常</b><?php }else{ ?><b class="red">待审</b><?php }?></td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['audit']==0){?>
            
            <?php }?>
            <?php echo smarty_function_link(array('ctl'=>"shop/shop:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"shop/shop:manage",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'class'=>"button",'target'=>"_blank",'title'=>"管理"),$_smarty_tpl);?>
            
            <?php echo smarty_function_link(array('ctl'=>"product/product:shop",'arg0'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'title'=>"商品",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"shop/youhui:index",'arg0'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'title'=>"优惠",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"shop/shop:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"shop/shop:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['shop_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
                <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"shop/shop:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                    <?php echo smarty_function_link(array('ctl'=>"shop/shop:audit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>
</td>
                <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
            </tr>
        </table>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>