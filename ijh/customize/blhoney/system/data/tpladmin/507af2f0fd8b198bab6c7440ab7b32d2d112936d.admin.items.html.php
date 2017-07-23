<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:34:13
         compiled from "admin:shop/cate/items.html" */ ?>
<?php /*%%SmartyHeaderCode:111005024857b289b5e067d4-69284001%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '507af2f0fd8b198bab6c7440ab7b32d2d112936d' => 
    array (
      0 => 'admin:shop/cate/items.html',
      1 => 1470380626,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '111005024857b289b5e067d4-69284001',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'v' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b289b5f38dd0_13389754',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b289b5f38dd0_13389754')) {function content_57b289b5f38dd0_13389754($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
	<table width="100%" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
			<th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
			<td align="right">
				<?php echo smarty_function_link(array('ctl'=>"shop/cate:create",'class'=>"button",'load'=>"mini:添加分类",'width'=>"mini:520",'title'=>"添加分类"),$_smarty_tpl);?>
</td>
			<td width="15"></td>
		</tr>
	</table>
</div>
<div class="page-data">	
	<form id="items-form">
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data table">
		<tr>
			<th class="w-100">ID</th>
                        <th class="w-50">图标</th>
			<th>分类名称</th>
			<th class="w-100">排序</th>
			<th class="w-200">操作</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value['parent_id']==0){?>
        <tr id="cat-<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
">
            <td class="left"><label><input type="checkbox" value="cate_id[]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" CK="PRI"><?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
</label></td>
            <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
" class="wh-50" /></td>
            <td class="left"><strong><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</strong></td>
            <td class="left"><input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['orderby'];?>
" class="input w-50" /></td>
            <td>
                <?php echo smarty_function_link(array('ctl'=>"shop/cate:create",'args'=>($_smarty_tpl->tpl_vars['v']->value['cate_id']),'load'=>"mini:添加子分类",'width'=>"mini:520",'title'=>"添加子分类",'class'=>"button"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"shop/cate:edit",'args'=>($_smarty_tpl->tpl_vars['v']->value['cate_id']),'load'=>"mini:编辑分类",'width'=>"mini:520",'title'=>"编辑分类",'class'=>"button"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"shop/cate:delete",'args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

            </td>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['item']->value['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>
        <tr id="cat-<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
">
            <td class="left"><label><input type="checkbox" value="cate_id[]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
" CK="PRI"><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
</label></td>
            <td  colspan="2" style="text-align:left;padding-left:30px;">&nbsp;&nbsp;|---<strong><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</strong></td>
            <td class="left">&nbsp;&nbsp;|---<input type="text" name="orderby[<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
" class="input w-50" /></td>
            <td>
                <?php echo smarty_function_link(array('ctl'=>"shop/cate:edit",'args'=>($_smarty_tpl->tpl_vars['item']->value['cate_id']),'load'=>"mini:编辑分类",'width'=>"mini:520",'title'=>"编辑分类",'class'=>"button"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"shop/cate:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['cate_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

            </td>
        </tr>
        <?php }?>
        <?php } ?>
        <?php }?>
        <?php } ?>
	</table>
    </table>
	</form>
	<div class="page-bar">
		<table>
			<tr>
			<td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
			<td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"shop/cate:delete",'type'=>"button",'submit'=>"mini:#items-form",'title'=>"删除分类"),$_smarty_tpl);?>
</td>
			<td class="w-200"><?php echo smarty_function_link(array('ctl'=>"shop/cate:update",'type'=>"button",'submit'=>"mini:#items-form",'title'=>"更新数据"),$_smarty_tpl);?>
</td>
		</tr>
		</table>
	</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>




<!--<?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/cate:create",'class'=>"button",'title'=>"添加",'load'=>"mini:添加分类",'width'=>"mini:550"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-100">分类ID</th>
        <th class="w-50">图标</th>
        <th>标题</th>
        <th class="w-50">排序</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
    <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
" name="cate_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
<label></td>
    <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['icon'];?>
" class="wh-50" /></td>
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>    
    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
    <td>
        <?php echo smarty_function_link(array('ctl'=>"shop/cate:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['cate_id'],'title'=>"修改",'class'=>"button",'load'=>"mini:修改分类",'width'=>"mini:500"),$_smarty_tpl);?>

        <?php echo smarty_function_link(array('ctl'=>"shop/cate:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['cate_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
                <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"shop/cate:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>
</td>
                <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
            </tr>
        </table>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 --><?php }} ?>