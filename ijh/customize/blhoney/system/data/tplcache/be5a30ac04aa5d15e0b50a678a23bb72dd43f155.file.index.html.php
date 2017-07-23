<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:40
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/verify/index.html" */ ?>
<?php /*%%SmartyHeaderCode:211855195157b2af14baba66-97916357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be5a30ac04aa5d15e0b50a678a23bb72dd43f155' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/verify/index.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211855195157b2af14baba66-97916357',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'pager' => 0,
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af14c0dc81_22567692',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af14c0dc81_22567692')) {function content_57b2af14c0dc81_22567692($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:index'),$_smarty_tpl);?>
" class="on">店铺认证</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:dianzhu'),$_smarty_tpl);?>
">店主认证</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:yyzz'),$_smarty_tpl);?>
">企业认证</a>
	<a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:canyin'),$_smarty_tpl);?>
">餐饮认证</a>
	<div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
        <tr><th>类别</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <tr>
            <td>店主认证</td>
            <td><?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu']==1){?><font color="#5cb85c">已认证</font><?php }else{ ?><font color="red">未认证</font><?php }?></td>
            <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:dianzhu'),$_smarty_tpl);?>
" class="btn btn-success">查看</a></td>
        </tr>
        <tr>
            <td>企业认证</td>
            <td><?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz']==1){?><font color="#5cb85c">已认证</font><?php }else{ ?><font color="red">未认证</font><?php }?></td>
            <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:yyzz'),$_smarty_tpl);?>
" class="btn btn-success">查看</a></td>
        </tr>
        <tr>
            <td>餐饮认证</td>
            <td><?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_cy']==1){?><font color="#5cb85c">已认证</font><?php }else{ ?><font color="red">未认证</font><?php }?></td>
            <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/verify:canyin'),$_smarty_tpl);?>
" class="btn btn-success">查看</a></td>
        </tr>
    </table>
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