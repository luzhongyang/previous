<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 17:04:24
         compiled from "admin:hongbao/hongbao/items.html" */ ?>
<?php /*%%SmartyHeaderCode:75952676657b2d718866530-54661779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99ab315605ac9dd699a31b555717fd6e2600cd2d' => 
    array (
      0 => 'admin:hongbao/hongbao/items.html',
      1 => 1470380621,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '75952676657b2d718866530-54661779',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'types' => 0,
    'users' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2d7189429e8_91798243',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2d7189429e8_91798243')) {function content_57b2d7189429e8_91798243($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
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
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:create",'class'=>"button",'title'=>"创建"),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;<?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:add",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;<?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
<form id="items-form">
<table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr><th class="w-100">ID</th>
        <th>标题</th>
        <th class="w-100">红包类型</th>
        <th class="w-150">红包金额</th>        
        <th class="w-150">用户</th>
        <th>红包卡密</th>
        <th class="w-100">失效时间</th>
        <th>状态</th>
        <th class="w-100">创建时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao_id'];?>
" name="hongbao_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao_id'];?>
<label></td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['types']->value[$_smarty_tpl->tpl_vars['item']->value['type']])===null||$tmp==='' ? "普通红包" : $tmp);?>
</td>
        <td>订单满<b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['min_amount'];?>
</b>减<b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['amount'];?>
</b></td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['uid']){?><?php echo $_smarty_tpl->tpl_vars['users']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
(ID:<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
)<?php }else{ ?><b class="blue">未领取</b><?php }?></td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao_sn'];?>
</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['ltime'],'Y-m-d');?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['used_time']){?><b class="gray">已使用</b><?php }else{ ?><b class="green">未使用</b><?php }?></td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
        <td>
            <?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['hongbao_id'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['hongbao_id'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

            <?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['hongbao_id'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

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
                <?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>

            </td>
            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
        </tr>
    </table>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>