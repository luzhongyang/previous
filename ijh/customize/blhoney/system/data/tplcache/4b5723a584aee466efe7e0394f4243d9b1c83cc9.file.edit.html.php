<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 18:30:48
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/product/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:159309921757b2eb58296504-01926308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b5723a584aee466efe7e0394f4243d9b1c83cc9' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/product/edit.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159309921757b2eb58296504-01926308',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'tree' => 0,
    'v' => 0,
    'vv' => 0,
    'pager' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2eb58346822_88246079',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2eb58346822_88246079')) {function content_57b2eb58346822_88246079($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/cate:index'),$_smarty_tpl);?>
">商品分类</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/product:index'),$_smarty_tpl);?>
" class="on">商品管理</a>
    <div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <form action="<?php echo smarty_function_link(array('ctl'=>'biz/product:edit','args'=>$_smarty_tpl->tpl_vars['detail']->value['product_id']),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <th><span class="red">*</span>分类：</th>
                <td>
                    <select name="data[cate_id]" class="select_td select w-300">
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                        <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['cate_id']==$_smarty_tpl->tpl_vars['vv']->value['cate_id']){?>selected<?php }?>>&nbsp;|--<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><span class="red">*</span>标题：</th>
                <td>
                    <input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/><span class="tip-comment">标题</span>
                </td>
            </tr>
            <tr>
                <th>图片：</th>
                <td>
                    <input type="text" name="data[photo]" class="input w-300" id="file_photo" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['photo'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['photo']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['photo'];?>
"<?php }?> />
                    <input type="button" uploadbtn="#file_photo" class="ke-upload_lay" value=" 选择文件 " />
                    <a preview="#file_photo" class="btn btn-default" style="color:#333;"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span>预览</a>
                </td>
            </tr>
            <tr>
                <th><span class="red">*</span>价格：</th>
                <td><input type="text" name="data[price]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['price'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">价格</span></td>
            </tr>
            <tr>
                <th><span class="red">*</span>销量：</th>
                <td><input type="text" name="data[sales]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['sales'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100"/><span class="tip-comment">销量</span></td>
            </tr>
            <tr>
                <th>类型：</th>
                <td>
                    <ul class="group-list">
                        <li><label><input type="radio" name="data[sale_type]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['sale_type']==0){?>checked="checked"<?php }?>>普通</label></li>
                        <li><label><input type="radio" name="data[sale_type]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['sale_type']==1){?>checked="checked"<?php }?> >限量</label></li>
                        <div class="clear-both"></div>
                    </ul>
                </td>
            </tr>
            <tr id="tr_sale_sku1" class="hide">
                <th>限购数：</th><td><input type="text" name="data[sale_sku]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['sale_sku'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100"/></td></tr>
            <tr id="tr_sale_sku2" class="hide">
                <th>已购数：</th><td><input type="text" name="data[sale_count]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['sale_count'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100"/></td>
            </tr>
            <tr><th><span class="red">*</span>描述：</th><td><textarea name="data[intro]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['detail']->value['intro'];?>
</textarea><br /></td></tr>
<tr><th><span class="red">*</span>排序：</th><td><input type="text" name="data[orderby]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['orderby'])===null||$tmp==='' ? '50' : $tmp);?>
" class="input w-100"/><span class="tip-comment">排序</span></td></tr>
            <tr>
                <th></th>
                <td><input type="submit" value="保存数据" class="btn btn-primary" /></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
        $("[name='data[sale_type]']").click(function () {
            if ($(this).val() == 1) {
                $("#tr_sale_sku1").show();
                $("#tr_sale_sku2").show();
            } else {
                $("#tr_sale_sku2").hide();
                $("#tr_sale_sku1").hide();
            }
        });
        $("[name='data[sale_type]']:checked").trigger("click");
</script>
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