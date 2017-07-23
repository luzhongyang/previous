<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:35:46
         compiled from "admin:config/attach.html" */ ?>
<?php /*%%SmartyHeaderCode:64970241857b2a632ec6fa6-76756365%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '550f89eefab758a3e30754fbad628e7eb5b210fe' => 
    array (
      0 => 'admin:config/attach.html',
      1 => 1470380607,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '64970241857b2a632ec6fa6-76756365',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a63308cea9_46988647',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a63308cea9_46988647')) {function content_57b2a63308cea9_46988647($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"></td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
<h4 class="tip-notice">图片大小设置 800X1000 表示生成图片有宽高双重限制，设置为800 表示只有宽限制，高度等比例</h4>
<form action="?system/config-attach.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="attach" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
<tr>
	<th>附件保存位置：</th>
	<td>
		<input type="text" name="config[dir]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['dir'])===null||$tmp==='' ? './attachs' : $tmp);?>
" class="input w-300"/>
		<span class="tip-comment">"./" 表示站点根目录，除填写服务器绝对地址外请用"./"开头</span>
	</td>
</tr>
<tr>
	<th>附件URL地址：</th>
	<td>
		<input type="text" name="config[url]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['url'])===null||$tmp==='' ? './attachs' : $tmp);?>
" class="input w-300"/>
		<span class="tip-comment">"./" 表示站点根目录,也可填写"http://"开头的绝对地址</span>
	</td>
</tr>
<tr><th>附件类型限制：</th>
	<td>
		<input type="text" name="config[allow_exts]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['allow_exts'])===null||$tmp==='' ? 'jpg,gif,png,jpeg' : $tmp);?>
" class="input w-300"/>
		<span class="tip-comment">通常只为图片扩展名,为了安全程序限制了只能上传图片</span>
	</td>
</tr>
<tr><th>附件大小限制：</th>
    <td>
        <input type="text" name="config[allow_size]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['allow_size'])===null||$tmp==='' ? '2048' : $tmp);?>
" class="input w-200"/>
        <span class="tip-comment">单位KB, 1M = 1024KB</span>
    </td>
</tr>
<tr>
	<th>水印类型：</th>
	<td>
		<label><input type="radio" name="config[watermarktype]" value="" <?php if (!$_smarty_tpl->tpl_vars['config']->value['watermarktype']){?>checked<?php }?>/>关闭水印</label><span></span><br/>
		<label><input type="radio" name="config[watermarktype]" value="png" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']=='png'){?>checked<?php }?>/>图片水印</label>
		<span class="tip-comment">水印文件：system/data/watermark/watermark.png</span><br/>
		<label><input type="radio" name="config[watermarktype]" value="text" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']=='text'){?>checked<?php }?>/>文字水印</label>
		<span class="tip-comment">文字水印</span>
	</td>
</tr>
<tr watermarktext="font" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']!='text'){?> style="display:none;"<?php }?>><th>文字水印字体：</th>
	<td>
		<input type="text" name="config[watermarktext][font]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['watermarktext']['font'])===null||$tmp==='' ? 'msyh.ttf' : $tmp);?>
" class="input w-100"/>
		<span class="tip-comment">字体文件目录:system/data/watermark/*.ttf</span>
	</td>
</tr>
<tr watermarktext="size" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']!='text'){?> style="display:none;"<?php }?>><th>文字水印大小：</th>
	<td>
		<input type="text" name="config[watermarktext][size]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['watermarktext']['size'])===null||$tmp==='' ? '14' : $tmp);?>
" class="input w-100"/>
	</td>
</tr>
<tr watermarktext="color" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']!='text'){?> style="display:none;"<?php }?>><th>文字水印颜色：</th>
	<td>
		<input type="text" name="config[watermarktext][color]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['watermarktext']['color'])===null||$tmp==='' ? '#FFFFFF' : $tmp);?>
" class="input w-100"/>
		<span class="tip-comment">16进制RGB颜色 如:#FF3300</span>
	</td>
</tr>
<tr watermarktext="text" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarktype']!='text'){?> style="display:none;"<?php }?>><th>文字水印内容：</th>
	<td>
		<input type="text" name="config[watermarktext][text]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['watermarktext']['text'])===null||$tmp==='' ? '@{name}' : $tmp);?>
" class="input w-300"/>
		<span class="tip-comment">支持变量{name}上传者(用户/公司)</span>
	</td>
</tr>
<tr>
	<th>水印位置：</th>
	<td>
		<label><input type="radio" name="config[watermarkstatus]" value="1" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='1'){?>checked<?php }?>/>1#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="2" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='2'){?>checked<?php }?>/>2#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="3" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='3'){?>checked<?php }?>/>3#</label><br/>
		<label><input type="radio" name="config[watermarkstatus]" value="4" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='4'){?>checked<?php }?>/>4#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="5" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='5'){?>checked<?php }?>/>5#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="6" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='6'){?>checked<?php }?>/>6#</label><br />
		<label><input type="radio" name="config[watermarkstatus]" value="7" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='7'){?>checked<?php }?>/>7#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="8" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='8'){?>checked<?php }?>/>8#</label>
		<label><input type="radio" name="config[watermarkstatus]" value="9" <?php if ($_smarty_tpl->tpl_vars['config']->value['watermarkstatus']=='9'){?>checked<?php }?>/>9#</label>
	</td>
</tr>
<tr><th>水印质量：</th>
    <td>
        <input type="text" name="config[watermarkquality]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['watermarkquality'])===null||$tmp==='' ? '90' : $tmp);?>
" class="input w-100"/>
        <span class="tip-comment">设置 JPEG 类型的图片附件添加水印后的质量参数，范围为 0～100 的整数，数值越大结果图片效果越好，但尺寸也越大。</span>
    </td>
</tr>
<tr><th>图片质量：</th>
    <td>
        <input type="text" name="config[thumbquality]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['thumbquality'])===null||$tmp==='' ? '90' : $tmp);?>
" class="input w-100"/>
        <span class="tip-comment">设置 JPEG 类型的图片修改尺寸后的质量参数，范围为 0～100 的整数，数值越大结果图片效果越好，但尺寸也越大。</span>
    </td>
</tr>
<tr><th>全局缩略图：</th>
	<td>
		<input type="text" name="config[thumb]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['thumb'])===null||$tmp==='' ? '200' : $tmp);?>
" class="input w-100"/>
	</td>
</tr>
<!--
<tr><th>在建工地缩略图：</th>
	<td>
		<input type="text" name="config[site][photo]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['site']['photo'])===null||$tmp==='' ? '200' : $tmp);?>
" class="input w-100"/>
	
	</td>
</tr>
<tr><th>装修公司优惠信息图片：</th>
	<td>
		<input type="text" name="config[youhui][photo]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['youhui']['photo'])===null||$tmp==='' ? '200' : $tmp);?>
" class="input w-100"/>
	
	</td>
</tr>

<tr><th>装修公司：</th>
    <td>
    <ul class="group-list">
        <li style="width:200px;">长方形:
            <input type="text" name="config[company][logo]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['company']['logo'])===null||$tmp==='' ? '200X100' : $tmp);?>
" class="input w-100"/>
        </li>
        <li>正方形：<input type="text" name="config[company][thumb]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['company']['thumb'])===null||$tmp==='' ? '200X200' : $tmp);?>
" class="input w-100"/></li>
        <div class="clear-both"></div>
    </ul>
    </td>
</tr>
<tr><th>案例图片：</th>
	<td>
		<ul class="group-list">
            <li style="width:320px;">大:
                <input type="text" name="config[casephoto][photo]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['casephoto']['photo'])===null||$tmp==='' ? '720' : $tmp);?>
" class="input w-100"/>
                <label><input type="checkbox" name="config[casephoto][watermark]" value="1" <?php if ($_smarty_tpl->tpl_vars['config']->value['casephoto']['watermark']){?>checked="checked"<?php }?>/>水印</label>
                <span class="tip-comment">全局水印开启才生效</span>
            </li>
            <li>中：<input type="text" name="config[casephoto][thumb]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['casephoto']['thumb'])===null||$tmp==='' ? '200' : $tmp);?>
" class="input w-100"/></li>
            <li>小：<input type="text" name="config[casephoto][small]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['casephoto']['small'])===null||$tmp==='' ? '60X60' : $tmp);?>
" class="input w-100"/></li>
            <div class="clear-both"></div>
        </ul>
	</td>
</tr>

<tr><th>编辑器图片：</th>
	<td>
		<ul class="group-list">
            <li style="width:320px;">大:
                <input type="text" name="config[editor][photo]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['editor']['photo'])===null||$tmp==='' ? '600' : $tmp);?>
" class="input w-100"/>
                <label><input type="checkbox" name="config[editor][watermark]" value="1" <?php if ($_smarty_tpl->tpl_vars['config']->value['editor']['watermark']){?>checked="checked"<?php }?>/>水印</label>
                <span class="tip-comment">全局水印开启才生效</span>
            </li>
            <li>小：<input type="text" name="config[editor][thumb]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['editor']['thumb'])===null||$tmp==='' ? '200' : $tmp);?>
" class="input w-100"/></li>
            <div class="clear-both"></div>
        </ul>
	</td>
</tr>
-->
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form>
</div>
<script type="text/javascript">
(function(K, $){
	$("input[name='config[watermarktype]']").on('click', function(){
		if($(this).val() == 'text'){
			$("tr[watermarktext]").show();
		}else{
			$("tr[watermarktext]").hide();
		}
	});
})(window.KT, window.jQuery);
</script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>