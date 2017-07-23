<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:32:17
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pic/index.html" */ ?>
<?php /*%%SmartyHeaderCode:107136540757b2894139ba18-58246449%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'afeb55023f9d844e47f5419f0db9ec82a843e601' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pic/index.html',
      1 => 1471148807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107136540757b2894139ba18-58246449',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pics' => 0,
    'v' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b289413f3b71_25056793',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b289413f3b71_25056793')) {function content_57b289413f3b71_25056793($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
    <ul>
        <li class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop/pic'),$_smarty_tpl);?>
">轮播设置</a></li>
    </ul>
    <span class="r"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:createpic'),$_smarty_tpl);?>
" class="btn btn-success">添加轮播</a></span>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr>  
        <th class="w-30">图片ID</th>
        <th class="w-80">图片</th>
        <th class="w-50">创建时间</th>
        <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pics']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['pic_id'];?>
</td>
        <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" class="wh-50" /></td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['v']->value['dateline'],'Y-m-d H:i:s');?>
</td>   
        <td>
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop/editpic','args'=>$_smarty_tpl->tpl_vars['v']->value['pic_id']),$_smarty_tpl);?>
" class="btn btn-success">修改</a>&nbsp;&nbsp;
            <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop/delpic','args'=>$_smarty_tpl->tpl_vars['v']->value['pic_id']),$_smarty_tpl);?>
" mini-act="confirm:确认要删除该轮播吗?" class="btn btn-success">删除</a>
        </td>
    </tr>     
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