<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:29:17
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/cate/create.html" */ ?>
<?php /*%%SmartyHeaderCode:111669625357b2b2bd7d15b8-09605436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '969df82dfbee61f6e46af75c5f853e2e5150bcf2' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/cate/create.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '111669625357b2b2bd7d15b8-09605436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cate_tree' => 0,
    'v' => 0,
    'k' => 0,
    'pager' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b2bd8261a6_45431476',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b2bd8261a6_45431476')) {function content_57b2b2bd8261a6_45431476($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate:index'),$_smarty_tpl);?>
" class="on">商品分类</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/product:index'),$_smarty_tpl);?>
">商品管理</a>
    <div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <form action="<?php echo smarty_function_link(array('ctl'=>'biz/cate:create'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <th><span class="red">*</span>父级分类：</th>
                <td>
                    <select name="data[parent_id]" class="input w-200">
                        <option value="0">顶级分类</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['parent_id']){?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                        <?php }?>
                        <?php } ?>
                    </select>
                </td>
            </tr>     
            <tr>
                <th>标题：</th>
                <td>
                    <input type="text" name="data[title]" value="" class="input w-150">
                </td>
            </tr>
            <tr>
                <th><span class="red"></span>排序：</th>
                <td><input type="text" name="data[orderby]" value="" class="input w-150"/></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" value="保存数据" class="btn btn-success" /></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
(function(K, $){
var editor = KindEditor.create('textarea[kindeditor]',{uploadJson : '<?php echo smarty_function_link(array('ctl'=>"biz/upload:editor",'http'=>"base"),$_smarty_tpl);?>
', extraFileUploadParams:{OTOKEN:"<?php echo $_smarty_tpl->tpl_vars['OTOKEN']->value;?>
"}});
})(window.KT, window.jQuery);
</script>  
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>