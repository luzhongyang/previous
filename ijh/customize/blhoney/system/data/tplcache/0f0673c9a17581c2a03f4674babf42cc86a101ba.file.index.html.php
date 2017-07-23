<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:11:19
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/cate/index.html" */ ?>
<?php /*%%SmartyHeaderCode:59155943957b28457e36a33-16595763%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f0673c9a17581c2a03f4674babf42cc86a101ba' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/cate/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59155943957b28457e36a33-16595763',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tree' => 0,
    'v' => 0,
    'vv' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28457ea50a1_72160805',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28457ea50a1_72160805')) {function content_57b28457ea50a1_72160805($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
    <ul>
            <li class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate:index'),$_smarty_tpl);?>
">商品分类</a></li>
            <li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/product:index'),$_smarty_tpl);?>
">商品管理</a></li>
    </ul>
    <span class="r"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate:create'),$_smarty_tpl);?>
" class="btn btn-success">添加分类</a></span>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr>
        <th class="w-150">分类ID</th>
        <th>标题</th>
        <th class="w-100">排序</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>        
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['orderby'];?>
</td>
        <td>
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate/edit','args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
" class="btn btn-success">修改</a>&nbsp;&nbsp;
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate/delete','args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
" mini-act="confirm:确认要删除该分类吗?" class="btn btn-success">删除</a>
        </td>
    </tr>    
    <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
</td>
        <td>&nbsp;├──<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</td>      
        <td><?php echo $_smarty_tpl->tpl_vars['vv']->value['orderby'];?>
</td>
        <td>
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate/edit','args'=>$_smarty_tpl->tpl_vars['vv']->value['cate_id']),$_smarty_tpl);?>
" class="btn btn-success">修改</a>&nbsp;&nbsp;
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate/delete','args'=>$_smarty_tpl->tpl_vars['vv']->value['cate_id']),$_smarty_tpl);?>
" mini-act="confirm:确认要删除该分类吗?" class="btn btn-success">删除</a>
        </td>
    </tr>
    <?php } ?>    
    <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
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