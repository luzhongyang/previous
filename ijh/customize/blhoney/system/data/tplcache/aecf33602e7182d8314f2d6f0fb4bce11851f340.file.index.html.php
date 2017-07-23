<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:36:52
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/index.html" */ ?>
<?php /*%%SmartyHeaderCode:163857030357b28a54299115-70685235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aecf33602e7182d8314f2d6f0fb4bce11851f340' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/index.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '163857030357b28a54299115-70685235',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop' => 0,
    'pager' => 0,
    'times' => 0,
    'v1' => 0,
    'v2' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28a5433d4c4_99359810',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28a5433d4c4_99359810')) {function content_57b28a5433d4c4_99359810($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
" class="on">基本资料</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
">安全设置</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
">更换手机</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
">提现帐号</a>
	<div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
<form action="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
<table cellspacing="0" cellpadding="0" class="form">
    <tr><th><span class="red">*</span>店铺名称：</th><td><input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['shop']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
    <tr><th>店铺LOGO：</th>
        <td>
        <input type="text" name="data[logo]" class="input w-300" id="file_photo" value="<?php echo $_smarty_tpl->tpl_vars['shop']->value['logo'];?>
" <?php if ($_smarty_tpl->tpl_vars['shop']->value['logo']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['shop']->value['logo'];?>
"<?php }?> />
        <input type="button" uploadbtn="#file_photo" class="ke-upload_lay" value=" 选择文件 " />
        <a preview="#file_photo" class="btn btn-default" style="color:#333;"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span>预览</a>
        </td>
    </tr>
    <tr><th><span class="red">*</span>联系电话：</th><td><input type="text" name="data[phone]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['shop']->value['phone'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td></tr>
<tr><th><span class="red">*</span>营业状态：</th>
    <td>
        <label><input type="radio" name="data[yy_status]" value="0" <?php if ($_smarty_tpl->tpl_vars['shop']->value['yy_status']==0){?>checked="checked"<?php }?>/>打烊</label><label><input type="radio" name="data[yy_status]" value="1" <?php if ($_smarty_tpl->tpl_vars['shop']->value['yy_status']==1){?>checked="checked"<?php }?>/>营业</label>
    </td>
</tr>
    <tr><th><span class="red">*</span>开始营业时间：</th><td>
        <select name="data[yy_stime]" class="select select_td input w-200">
            <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['times']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
               <option value="<?php echo $_smarty_tpl->tpl_vars['v1']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['shop']->value['yy_stime']==$_smarty_tpl->tpl_vars['v1']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v1']->value;?>
</option>
            <?php } ?>
        </select>
    </td></tr>

    <tr><th><span class="red">*</span>打烊时间：</th><td>
        <select name="data[yy_ltime]" class="select select_td input w-200">
            <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['times']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
               <option value="<?php echo $_smarty_tpl->tpl_vars['v2']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['shop']->value['yy_ltime']==$_smarty_tpl->tpl_vars['v2']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v2']->value;?>
</option>
            <?php } ?>
        </select>
    </td></tr>
    <tr><th>地图坐标：</th>
        <td>
            <label>经度:<input type="text" name="data[lng]" value="<?php echo $_smarty_tpl->tpl_vars['shop']->value['lng'];?>
" id="Bmap_marker_lng" class="input w-100"/></label>
            <label>纬度:<input type="text" name="data[lat]" value="<?php echo $_smarty_tpl->tpl_vars['shop']->value['lat'];?>
" id="Bmap_marker_lat" class="input w-100"/></label>   
            <span class="tip-comment"><a map-marker="#Bmap_marker_lng,#Bmap_marker_lat" class="btn btn-success"><b>拾取工具</b></a></span>
        </td>
    </tr>

    <tr><th>店铺简介：</th><td><textarea name="data[info]" class="textarea w-500"><?php echo $_smarty_tpl->tpl_vars['shop']->value['info'];?>
</textarea></td></tr>
    <tr><th></th><td><input type="submit" value="保存数据" class="btn btn-primary" /></td></tr>
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