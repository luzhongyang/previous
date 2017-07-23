<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 16:51:17
         compiled from "admin:adv/adv/items.html" */ ?>
<?php /*%%SmartyHeaderCode:44973267757b5770526ae40-08288350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03ea18075a024b59ab8aa863a7344fd801346ecb' => 
    array (
      0 => 'admin:adv/adv/items.html',
      1 => 1470380618,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '44973267757b5770526ae40-08288350',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'theme_list' => 0,
    'from_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b5770532ffd3_02212403',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b5770532ffd3_02212403')) {function content_57b5770532ffd3_02212403($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right">
				<?php echo smarty_function_link(array('ctl'=>"adv/adv:so",'load'=>"mini:搜索广告位",'width'=>"mini:400",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;
				<?php echo smarty_function_link(array('ctl'=>"adv/adv:create",'load'=>"mini:添加广告位",'width'=>"mini:500",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>

			</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-100">ID</th><th>广告位</th><th>页面</th><th class="w-100">类型</th><th class="w-50">排序</th><th class="w-200">操作</th></tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
		<td class="left"><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['adv_id'];?>
" name="adv_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['adv_id'];?>
<label></td>
		<td class="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['theme_list']->value[$_smarty_tpl->tpl_vars['item']->value['theme_id']]['title'])===null||$tmp==='' ? '默认模板' : $tmp);?>
:<?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['page'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['from_list']->value[$_smarty_tpl->tpl_vars['item']->value['from']];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
		<td>
            <?php echo smarty_function_link(array('ctl'=>"adv/adv:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['adv_id'],'class'=>"button",'title'=>"数据"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"adv/adv:config",'args'=>$_smarty_tpl->tpl_vars['item']->value['adv_id'],'class'=>"button",'iframe'=>"mini:广告位模板",'width'=>"mini:600",'title'=>"模板"),$_smarty_tpl);?>

			<?php echo smarty_function_link(array('ctl'=>"adv/adv:code",'args'=>$_smarty_tpl->tpl_vars['item']->value['adv_id'],'class'=>"button",'load'=>"mini:调用代码",'width'=>"mini:550",'title'=>"代码"),$_smarty_tpl);?>

			<?php echo smarty_function_link(array('ctl'=>"adv/adv:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['adv_id'],'title'=>"修改",'load'=>"mini:修改广告位",'width'=>"mini:500",'class'=>"button"),$_smarty_tpl);?>

			<?php echo smarty_function_link(array('ctl'=>"adv/adv:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['adv_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

		</td>
	</tr>
    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
     <tr><td colspan="20"><p class="text-align">没有数据</p></td></tr>
    <?php } ?>
    </table>
	</form>
	<div class="page-bar">
		<table>
			<tr>
			<td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
			<td colspan="10" class="left">
                <?php echo smarty_function_link(array('ctl'=>"adv/adv:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

            </td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>