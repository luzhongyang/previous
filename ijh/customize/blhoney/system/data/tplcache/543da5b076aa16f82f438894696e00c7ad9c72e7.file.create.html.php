<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:23:44
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pic/create.html" */ ?>
<?php /*%%SmartyHeaderCode:27580789057b2bf805ff116-79791212%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '543da5b076aa16f82f438894696e00c7ad9c72e7' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/pic/create.html',
      1 => 1471148794,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27580789057b2bf805ff116-79791212',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2bf8063c762_08874401',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2bf8063c762_08874401')) {function content_57b2bf8063c762_08874401($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop/pic'),$_smarty_tpl);?>
" class="on">轮播设置</a>
    <div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <form action="<?php echo smarty_function_link(array('ctl'=>'biz/shop/createpic'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <th>图片：</th>
                <td>
                    <input type="text" name="data[photo]" class="input w-300" id="file_photo" value=""/>
                    <input type="button" uploadbtn="#file_photo" class="ke-upload_lay" value=" 选择文件 " />
                    <a preview="#file_photo" class="btn btn-default" style="color:#333;"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span>预览</a>
                </td>
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