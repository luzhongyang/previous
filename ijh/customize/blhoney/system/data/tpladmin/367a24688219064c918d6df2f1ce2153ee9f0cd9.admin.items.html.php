<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:21:33
         compiled from "admin:shop/comment/items.html" */ ?>
<?php /*%%SmartyHeaderCode:165897947757b2b0ed713661-57809381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '367a24688219064c918d6df2f1ce2153ee9f0cd9' => 
    array (
      0 => 'admin:shop/comment/items.html',
      1 => 1470380626,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '165897947757b2b0ed713661-57809381',
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
    'member_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b0ed7f47b1_55307597',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b0ed7f47b1_55307597')) {function content_57b2b0ed7f47b1_55307597($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
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
			<td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/comment:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
        <tr><th class="w-100">ID</th>
        <th class="w-50">商家</th>
        <th class="w-50">用户</th>
        <th class="w-50">订单</th>
        <th class="w-50">评分</th>
        <th class="w-50">服务评分</th>
        <th class="w-50">口味评分</th>
        <th class="w-50">配送速度</th>
        <th>内容</th>
        <th>回复</th>
        <th class="w-100">评论时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
    <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['comment_id'];?>
" name="comment_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['comment_id'];?>
<label></td>
    <td><?php echo $_smarty_tpl->tpl_vars['shop_list']->value[$_smarty_tpl->tpl_vars['item']->value['shop_id']]['title'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['member_list']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
(<?php echo $_smarty_tpl->tpl_vars['member_list']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['mobile'];?>
)</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score_fuwu'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score_kouwei'];?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['pei_time_label'];?>
(<?php echo $_smarty_tpl->tpl_vars['item']->value['pei_time'];?>
)</td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</td>
    <td><?php if ('reply_time'){?><?php echo $_smarty_tpl->tpl_vars['item']->value['reply'];?>
<?php }else{ ?>未回复<?php }?></td>
    <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
    <td>
        <?php echo smarty_function_link(array('ctl'=>"shop/comment:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

        <?php if (empty($_smarty_tpl->tpl_vars['item']->value['reply'])){?><?php echo smarty_function_link(array('ctl'=>"shop/comment:reply",'args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id'],'title'=>"回复",'width'=>"mini:450",'load'=>"mini:回复评论",'class'=>"button"),$_smarty_tpl);?>
<?php }?>
        <?php echo smarty_function_link(array('ctl'=>"shop/comment:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
			<td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"shop/comment:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

<?php echo smarty_function_link(array('ctl'=>"shop/comment:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>
</td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>