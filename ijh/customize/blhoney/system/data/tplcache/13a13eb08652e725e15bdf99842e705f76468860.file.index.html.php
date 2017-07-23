<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:42
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/member/index.html" */ ?>
<?php /*%%SmartyHeaderCode:61745970457b2af164e69f4-85025841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '13a13eb08652e725e15bdf99842e705f76468860' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/member/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61745970457b2af164e69f4-85025841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'members' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af16546a17_85268348',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af16546a17_85268348')) {function content_57b2af16546a17_85268348($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<ul>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/member:index'),$_smarty_tpl);?>
" class="on">我的客户</a>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/member:fans'),$_smarty_tpl);?>
">我的粉丝</a>
	</ul>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr>
        <th class="w-50">客户ID</th>
        <th class="w-150">昵称</th>
        <th class="w-300">手机号</th>
        <th class="w-100">图像</th>
        <th>最后登录时间</th>
        <th>操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['members']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
</td>       
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['nickname'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
        <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['face'];?>
" class="wh-50" /></td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['lastlogin']);?>
</td>
        <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/member:detail','arg0'=>$_smarty_tpl->tpl_vars['item']->value['uid']),$_smarty_tpl);?>
" class="btn btn-success" title="查看">查看</a></td>
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