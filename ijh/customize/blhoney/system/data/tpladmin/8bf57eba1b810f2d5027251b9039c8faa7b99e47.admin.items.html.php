<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:48:51
         compiled from "admin:article/article/items.html" */ ?>
<?php /*%%SmartyHeaderCode:213027909457b2b75380deb7-27425427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8bf57eba1b810f2d5027251b9039c8faa7b99e47' => 
    array (
      0 => 'admin:article/article/items.html',
      1 => 1470380619,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '213027909457b2b75380deb7-27425427',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'city_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b7539c2da2_39643006',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b7539c2da2_39643006')) {function content_57b2b7539c2da2_39643006($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
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
				<?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='about'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/about:so",'class'=>"button",'load'=>"mini:搜索文章",'width'=>"mini:400",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;
				<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='help'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/help:so",'class'=>"button",'load'=>"mini:搜索文章",'width'=>"mini:400",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;
				<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='page'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/page:so",'class'=>"button",'load'=>"mini:搜索文章",'width'=>"mini:400",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;
				<?php }else{ ?>
				<?php echo smarty_function_link(array('ctl'=>"article/article:so",'class'=>"button",'load'=>"mini:搜索文章",'width'=>"mini:400",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;
				<?php }?>	
				<?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='about'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/about:create",'priv'=>"hidden",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
</td>
				<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='help'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/help:create",'priv'=>"hidden",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
</td>
				<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='page'){?>
				<?php echo smarty_function_link(array('ctl'=>"article/page:create",'priv'=>"hidden",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
</td>
				<?php }else{ ?>
				<?php echo smarty_function_link(array('ctl'=>"article/article:create",'priv'=>"hidden",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
</td>
				<?php }?>
				</td>
			</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
		<th class="w-100">ID</th><th>标题</th><?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='about'||$_smarty_tpl->tpl_vars['pager']->value['from']=='article'){?><th class="w-50">城市</th><?php }?>
		<th class="w-200">分类</th><?php if ($_smarty_tpl->tpl_vars['pager']->value['from']!='article'){?><th class="w-100">页面名称</th><?php }?>
		<th class="w-50">是否轮播</th><th class="w-50">隐藏</th><th class="w-50">状态</th><th class="w-50">排序</th>
		<th class="w-50">起步价</th><th class="w-100">添加时间</th><th class="w-150">操作</th>
	</tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
		<td class="left"><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['article_id'];?>
" name="article_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['article_id'];?>
<label></td>
		<td class="left"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td><?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='about'){?><td><?php echo $_smarty_tpl->tpl_vars['city_list']->value[$_smarty_tpl->tpl_vars['item']->value['city_id']]['city_name'];?>
</td><?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='article'){?><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['city_list']->value[$_smarty_tpl->tpl_vars['item']->value['city_id']]['city_name'])===null||$tmp==='' ? '总站' : $tmp);?>
</td><?php }?>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['cat_title'];?>
</td><?php if ($_smarty_tpl->tpl_vars['pager']->value['from']!='article'){?><td><?php echo $_smarty_tpl->tpl_vars['item']->value['page'];?>
</td><?php }?>
		<td><?php if ($_smarty_tpl->tpl_vars['item']->value['is_banner']==1){?><span class="red">是</span><?php }else{ ?>否<?php }?></td>
		<td><?php if ($_smarty_tpl->tpl_vars['item']->value['hidden']){?><span class="red">隐藏</span><?php }else{ ?>显示<?php }?></td>
		<td><?php if ($_smarty_tpl->tpl_vars['item']->value['audit']){?><b class="blue">已发布</b><?php }else{ ?><b class="red">待审箱</b><?php }?></td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['item']->value['min_amount'];?>
</td><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
		<td>
			<?php if ($_smarty_tpl->tpl_vars['item']->value['from']=='about'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/about:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

			<?php }elseif($_smarty_tpl->tpl_vars['item']->value['from']=='help'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/help:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

			<?php }elseif($_smarty_tpl->tpl_vars['item']->value['from']=='page'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/page:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

			<?php }else{ ?>
			<!--<?php echo smarty_function_link(array('ctl'=>"block/item:push",'arg0'=>'article','arg1'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'title'=>"推送",'load'=>"mini:推送文章",'class'=>"button"),$_smarty_tpl);?>
-->
			<?php echo smarty_function_link(array('ctl'=>"article/article:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['item']->value['from']=='about'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/about:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

			<?php }elseif($_smarty_tpl->tpl_vars['item']->value['from']=='help'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/help:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

			<?php }elseif($_smarty_tpl->tpl_vars['item']->value['from']=='page'){?>
			<?php echo smarty_function_link(array('ctl'=>"article/page:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

			<?php }else{ ?>
			<?php echo smarty_function_link(array('ctl'=>"article/article:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['article_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

			<?php }?>	
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
				<?php echo smarty_function_link(array('ctl'=>"article/article:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"block/item:batch",'args'=>'article','type'=>"button",'load'=>"mini:批量推荐文章",'batch'=>"mini:PRI",'priv'=>"hide",'value'=>"批量推荐"),$_smarty_tpl);?>

				<?php echo smarty_function_link(array('ctl'=>"article/article:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>

			</td>
			<td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>