<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:35:25
         compiled from "admin:product/product/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:91299679357b289fd1e73a9-31467295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa84186d14cfa80995fc46c9943c46d0810107f4' => 
    array (
      0 => 'admin:product/product/detail.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '91299679357b289fd1e73a9-31467295',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'shop' => 0,
    'cates' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b289fd26e528_73872572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b289fd26e528_73872572')) {function content_57b289fd26e528_73872572($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"product/product:shop",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id'],'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data"><table width="100%" border="0" cellspacing="0" class="table-data form">
        <tr><th>商品ID：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['product_id'];?>
</td></tr>
        <tr><th>商家：</th><td><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
</td></tr>
        <tr><th>分类：</th><td><?php echo $_smarty_tpl->tpl_vars['cates']->value[$_smarty_tpl->tpl_vars['detail']->value['cate_id']]['title'];?>
</td></tr>
        <tr><th>标题：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</td></tr>
        <tr><th>图片：</th><td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['photo'];?>
" class="w-100" /></td></tr>
        <tr><th>价格：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['price'];?>
</td></tr>
        <tr><th>打包价：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['package_price'];?>
</td></tr>
        <tr><th>销量：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['sales'];?>
</td></tr>
        <tr><th>类型：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['sale_type']==1){?>限量<?php }else{ ?>普通<?php }?></td></tr>
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['sale_type']==1){?>
        <tr><th>限购数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['sale_sku'];?>
</td></tr>
        <tr><th>已购数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['sale_count'];?>
</td></tr>
        <?php }?>
        <tr><th>简介：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['intro'];?>
</td></tr>
        <tr><th>排序：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['orderby'];?>
</td></tr>
        <tr><th>是否删除：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['closed']==0){?>正常<?php }else{ ?>已删除<?php }?></td></tr>
        <tr><th>创建时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['dateline']);?>
</td></tr>
        <tr><th>创建IP：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['clientip'];?>
</td></tr>
        
    </table></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>