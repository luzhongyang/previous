<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:11:20
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/product/index.html" */ ?>
<?php /*%%SmartyHeaderCode:167280439857b284589fdef3-64870902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c024ecc47c9f978be2839dda19d372bb39e52cc2' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/product/index.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167280439857b284589fdef3-64870902',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'cates' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28458a810e1_45347665',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28458a810e1_45347665')) {function content_57b28458a810e1_45347665($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
    <ul>
        <li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate:index'),$_smarty_tpl);?>
">商品分类</a></li>
        <li class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/product:index'),$_smarty_tpl);?>
">商品管理</a></li>
    </ul>
    <span class="r"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/product:create'),$_smarty_tpl);?>
" class="btn btn-success">添加商品</a></span>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
        <tr><th class="w-50">商品ID</th>
            <th class="w-80">分类</th>
            <th class="w-100">标题</th>
            <th class="w-80">图片</th>
            <th class="w-50">价格</th>
            <th class="w-80">打包费</th>
            <th class="w-50">销量</th>
            <th class="w-80">类型</th>
            <th class="w-50">限购数</th>
            <th class="w-50">已购数</th>
            <th class="w-50">排序</th>
            <th class="w-200">操作</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['cates']->value[$_smarty_tpl->tpl_vars['item']->value['cate_id']]['title'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
            <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['photo'];?>
" class="wh-50" /></td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sales'];?>
</td>
            <td><?php if ($_smarty_tpl->tpl_vars['item']->value['sale_type']==1){?>限量<?php }else{ ?>普通<?php }?></td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sale_sku'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sale_count'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
            <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/product/edit','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" class="btn btn-success">修改</a>&nbsp;<a href="<?php echo smarty_function_link(array('ctl'=>'biz/product/delete','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" class="btn btn-success">删除</a></td>
        </tr>
        <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
        <tr><td colspan="20"><div class="alert alert-info">没有数据</div></td></tr>
        <?php } ?>
     
    </table>
    <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>