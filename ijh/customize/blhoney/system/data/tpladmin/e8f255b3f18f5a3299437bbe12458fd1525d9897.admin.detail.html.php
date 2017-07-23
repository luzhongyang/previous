<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 16:51:21
         compiled from "admin:adv/adv/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:12421153857b5770906df65-20281803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8f255b3f18f5a3299437bbe12458fd1525d9897' => 
    array (
      0 => 'admin:adv/adv/detail.html',
      1 => 1470380618,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '12421153857b5770906df65-20281803',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b5770915cdd5_48645059',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b5770915cdd5_48645059')) {function content_57b5770915cdd5_48645059($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
  &gt; <?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
[<span class="red"><?php echo $_smarty_tpl->tpl_vars['detail']->value['from_title'];?>
</span>]</th>
        <td align="right">
			<?php echo smarty_function_link(array('ctl'=>"adv/item:create",'class'=>"button",'args'=>($_smarty_tpl->tpl_vars['detail']->value['adv_id']),'title'=>"添加广告"),$_smarty_tpl);?>

			<?php echo smarty_function_link(array('ctl'=>"adv/adv:index",'class'=>"button",'title'=>"返回广告位管理"),$_smarty_tpl);?>

		</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<form method="post" id="adv-detail">
	<input type="hidden" name="adv_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['adv_id'];?>
" />
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data list">
		<tr>
			<th class="w-100">编号</th>
			<?php if ($_smarty_tpl->tpl_vars['detail']->value['from']=='photo'||$_smarty_tpl->tpl_vars['detail']->value['from']=='product'){?><th class="w-30">预览</th><?php }?>
			<th>标题</th><th class="w-100">城市</th><th class="w-100">目标</th><th class="w-100">排序</th>
			<th class="w-100">点击</th><th class="w-100">状态</th><th class="w-150">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
		<tr id="item-<?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
">
			<td class="left"><label><input type="checkbox" name="item_id[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
" CK="itemId"/><?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
</label></td>
			<?php if ($_smarty_tpl->tpl_vars['detail']->value['from']=='photo'||$_smarty_tpl->tpl_vars['detail']->value['from']=='product'){?>
			<td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['thumb'];?>
" class="wh-30"/></td>
			<?php }?>
			<td class="text-left">&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['city_name'];?>
</td>
			<td><?php if ($_smarty_tpl->tpl_vars['item']->value['target']=='_blank'){?>新窗口<?php }elseif($_smarty_tpl->tpl_vars['item']->value['target']=='_parent'){?>父窗口<?php }elseif($_smarty_tpl->tpl_vars['item']->value['target']=='_top'){?>Top窗口<?php }else{ ?>本窗口<?php }?></td>
			<td><input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['item']->value['item_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
" class="input w-50"/></td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['clicks'];?>
</td></td><td><?php if ($_smarty_tpl->tpl_vars['item']->value['audit']){?><b class="blue">上架</b><?php }else{ ?><b class="red">下架</b><?php }?></td>
			<td class="left">
				<?php echo smarty_function_link(array('ctl'=>"adv/item:edit",'args'=>($_smarty_tpl->tpl_vars['item']->value['item_id']),'class'=>"button",'title'=>"编辑"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"adv/item:delete",'args'=>($_smarty_tpl->tpl_vars['item']->value['item_id']),'act'=>"mini:remove:item-".($_smarty_tpl->tpl_vars['item']->value['itemId']),'class'=>"button",'title'=>"删除"),$_smarty_tpl);?>

			</td>
		</tr> 
		<?php } ?>
		<tr>
	</table>
	<div class="page-bar">
		 <table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="w-100 left"><label><input type="checkbox" CKA="itemId"/>&nbsp;&nbsp;全选</label></td>
				<td class="left">
					<?php echo smarty_function_link(array('ctl'=>"adv/item:delete",'type'=>"button",'submit'=>"mini:#adv-detail",'confirm'=>"mini:确定要删除选中的广告吗?",'class'=>"bt-big"),$_smarty_tpl);?>

					<?php echo smarty_function_link(array('ctl'=>"adv/item:doaudit",'type'=>"button",'submit'=>"mini:#adv-detail",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量上架"),$_smarty_tpl);?>

					<?php echo smarty_function_link(array('ctl'=>"adv/item:update",'type'=>"button",'submit'=>"mini:#adv-detail",'class'=>"bt-big"),$_smarty_tpl);?>

				</td>
				<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
			</tr>
		</table>
	</div>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>