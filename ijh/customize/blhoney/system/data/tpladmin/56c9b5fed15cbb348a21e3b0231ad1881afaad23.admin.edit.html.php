<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:49:03
         compiled from "admin:article/article/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:52279308657b2b75fe49670-11927078%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56c9b5fed15cbb348a21e3b0231ad1881afaad23' => 
    array (
      0 => 'admin:article/article/edit.html',
      1 => 1470380619,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '52279308657b2b75fe49670-11927078',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'OATOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b75ff35a30_23126322',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b75ff35a30_23126322')) {function content_57b2b75ff35a30_23126322($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_widget')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.widget.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right">
		<?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='about'){?>
		<?php echo smarty_function_link(array('ctl'=>"article/about:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
		<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='help'){?>
		<?php echo smarty_function_link(array('ctl'=>"article/help:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
		<?php }elseif($_smarty_tpl->tpl_vars['pager']->value['from']=='page'){?>
		<?php echo smarty_function_link(array('ctl'=>"article/page:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
		<?php }else{ ?>
		<?php echo smarty_function_link(array('ctl'=>"article/article:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
		<?php }?>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data" id="page-data">
<form action="?article/<?php echo $_smarty_tpl->tpl_vars['pager']->value['from'];?>
-edit.html" mini-form="article-form" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="article_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['article_id'];?>
" />
<table width="100%" border="0" cellspacing="0" class="table-data form" id="table-info">
<tr><th>标题：</th><td><input type="text" name="data[title]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
" class="input title w-500"/></td></tr>
<tr><th class="w-100">分类：</th><td><select name="data[cat_id]"><?php echo smarty_function_widget(array('id'=>"article/cate",'from'=>$_smarty_tpl->tpl_vars['pager']->value['from'],'value'=>$_smarty_tpl->tpl_vars['detail']->value['cat_id']),$_smarty_tpl);?>
</select></td></tr>
<?php if ($_smarty_tpl->tpl_vars['pager']->value['from']=='article'){?>
<tr><th>缩略图：</th><td><input type="file" name="data[thumb]" class="input w-300" /><?php if ($_smarty_tpl->tpl_vars['detail']->value['thumb']){?><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['thumb'];?>
" class="wh-100"/><?php }?></td></tr>
<?php }else{ ?>
<tr><th>页面名：</th><td><input type="text" name="data[page]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['page'];?>
" class="input w-200"/></td></tr>
<?php }?>
<tr><th>描述：</th><td><textarea name="data[desc]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['detail']->value['desc'];?>
</textarea></td></tr>
<tr><th>跳转：</th>
    <td>
        <input type="text" name="data[linkurl]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['linkurl'];?>
" class="input w-500"/>
        <span class="tip-comment">填写后访问该文章后将直接跳转到该地址，以http:// 开头</span>
    </td>
</tr>
<tr><th>内容：</th><td><textarea name="data[content]" kindeditor="full" style="width:800px;height:350px;"><?php echo $_smarty_tpl->tpl_vars['detail']->value['content'];?>
</textarea></td></tr>
<tr><th class="w-100">SEO标题：</th><td><input type="text" name="data[seo_title]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['seo_title'];?>
" class="input w-500"/></td></tr>
<tr><th class="w-100">SEO关键词：</th><td><input type="text" name="data[seo_keywords]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['seo_keywords'];?>
" class="input w-500"/></td></tr>
<tr><th>SEO描述：</th><td><textarea name="data[seo_description]" class="textarea h-60"><?php echo $_smarty_tpl->tpl_vars['detail']->value['seo_description'];?>
</textarea><br /></td></tr>
<tr>
	<th>统计：</th>
	<td>
		<label>浏览数:<input type="text" name="data[views]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['views'];?>
" class="input w-50"/></label>
		<label>收藏数:<input type="text" name="data[favorites]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['favorites'];?>
" class="input w-50"/></label>
		<label>图片数:<input type="text" name="data[photos]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['photos'];?>
" class="input w-50"/></label>
		<label>留言数:<input type="text" name="data[comments]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['comments'];?>
" class="input w-50"/></label>
	</td>
</tr>
<tr><th>发布时间：</th>
    <td>
        <input type="text" name="data[ontime]" value="<?php if ($_smarty_tpl->tpl_vars['detail']->value['ontime']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['ontime'],"Y-m-d H:i:s");?>
<?php }?>" datetime="ontime" class="input w-150"/>
        <span class="tip-comment">为空文章即时发布，设置后时间到自动发布</span>
    </td>
</tr>
<tr><th>排序：</th><td><input type="text" name="data[orderby]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['orderby'];?>
" class="input w-100"/></td></tr>
<tr><th>起步价：</th><td><input type="text" name="data[min_amount]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
" class="input w-100"/></td></tr>
<tr><th>评论：</th>
    <td>
        <label><input type="radio" name="data[allow_comment]" value="1"  <?php if ($_smarty_tpl->tpl_vars['detail']->value['allow_comment']){?>checked="checked"<?php }?>/>开启</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <label><input type="radio" name="data[allow_comment]" value="0"  <?php if (!$_smarty_tpl->tpl_vars['detail']->value['allow_comment']){?>checked="checked"<?php }?>/>关闭</label>
        <span class="tip-comment">是否开启该文间的评论功能</span>
    </td>
</tr>
<tr>
	<th>隐藏：</th>
	<td>
		<label><input type="radio" name="data[hidden]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['hidden']){?>checked="checked"<?php }?> value="1"/>是</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="data[hidden]" <?php if (!$_smarty_tpl->tpl_vars['detail']->value['hidden']){?>checked="checked"<?php }?> value="0"/>否</label>
        <span class="tip-comment">设置隐藏后，在列表中将不显示该文件，但输入文章地址仍然可以打开</span>
	</td>
</tr>
<tr>
	<th>是否为轮播：</th>
	<td>
		<label><input type="radio" name="data[is_banner]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['is_banner']){?>checked="checked"<?php }?> value="1"/>是</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="data[is_banner]" <?php if (!$_smarty_tpl->tpl_vars['detail']->value['is_banner']){?>checked="checked"<?php }?> value="0"/>否</label>
        <span class="tip-comment">设置轮播后，在列表中将在顶部轮播图中显示</span>
	</td>
</tr>
<tr>
	<th>状态：</th>
	<td>
		<label><input type="radio" name="data[audit]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']){?>checked="checked"<?php }?> value="1"/>发布</label>&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="data[audit]" <?php if (!$_smarty_tpl->tpl_vars['detail']->value['audit']){?>checked="checked"<?php }?> value="0"/>待审箱</label>
	</td>
</tr>
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
(function(K, $){
$("#page-data").tabs();
var editor = KindEditor.create('textarea[kindeditor]', {uploadJson : '?article/article-upload-<?php echo $_smarty_tpl->tpl_vars['detail']->value['article_id'];?>
.html', extraFileUploadParams:{OATOKEN:"<?php echo $_smarty_tpl->tpl_vars['OATOKEN']->value;?>
"}});
})(window.KT, window.jQuery);
</script> 
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>