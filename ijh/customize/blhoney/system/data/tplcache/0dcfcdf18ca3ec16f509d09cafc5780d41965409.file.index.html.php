<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:47
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/money/index.html" */ ?>
<?php /*%%SmartyHeaderCode:18245494357b2af1bdadbc2-82215915%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0dcfcdf18ca3ec16f509d09cafc5780d41965409' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/money/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18245494357b2af1bdadbc2-82215915',
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
  'unifunc' => 'content_57b2af1be09c34_72539697',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af1be09c34_72539697')) {function content_57b2af1be09c34_72539697($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
	<ul>
		<li class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:index'),$_smarty_tpl);?>
">资金管理</a></li>
		<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:log'),$_smarty_tpl);?>
">资金日志</a></li>
		<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:txlog'),$_smarty_tpl);?>
">提现日志</a></li>
	</ul>
	<span class="r"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/money:tixian'),$_smarty_tpl);?>
" class="btn btn-success">申请提现</a></span>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr><th class="w-50">类型</th><th class="w-100">收支</th><th>日志</th><th class="w-150">时间</th></tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['money']<0){?>支出<?php }else{ ?>收入<?php }?></td>
        <td><b<?php if ($_smarty_tpl->tpl_vars['item']->value['money']<0){?> class="red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</b></td>        
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['intro'];?>
</td>
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