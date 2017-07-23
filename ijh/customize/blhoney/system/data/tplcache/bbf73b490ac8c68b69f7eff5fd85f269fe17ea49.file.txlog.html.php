<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:49
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/money/txlog.html" */ ?>
<?php /*%%SmartyHeaderCode:41136597357b2af1d37d1e0-48553076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bbf73b490ac8c68b69f7eff5fd85f269fe17ea49' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/money/txlog.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41136597357b2af1d37d1e0-48553076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af1d3f4088_49094184',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af1d3f4088_49094184')) {function content_57b2af1d3f4088_49094184($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
	<ul>
		<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:index'),$_smarty_tpl);?>
">资金管理</a></li>
		<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:log'),$_smarty_tpl);?>
">资金日志</a></li>
		<li  class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:txlog'),$_smarty_tpl);?>
">提现日志</a></li>
	</ul>
	<span class="r"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:tixian'),$_smarty_tpl);?>
" class="btn btn-success">申请提现</a></span>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr>
        <th class="w-50">提现金额</th>
        <th class="w-150">提现描述</th>
        <th class="w-300">账户信息</th>
        <th class="w-100">状态</th>
        <th class="w-100">理由</th>
        <th>处理时间</th>
        <th>提交时间</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</td>       
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['intro'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['account_info'];?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?><font style="color: green;">通过</font><?php }elseif($_smarty_tpl->tpl_vars['item']->value['status']==2){?><font style="color: red;">拒绝</font><?php }else{ ?>未处理<?php }?></td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['reason']){?><?php echo $_smarty_tpl->tpl_vars['item']->value['reason'];?>
<?php }else{ ?>无<?php }?></td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['updatetime']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['updatetime']);?>
<?php }?></td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
    </tr>
    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
    <tr><td colspan="20"><div class="alert alert-info">没有数据</div></td></tr>
    <?php } ?>
    <tr>
    </table>
    <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>