<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 16:25:46
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/passwd.html" */ ?>
<?php /*%%SmartyHeaderCode:50878361657b41f8ad0f553-09591470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d840c9dc718a7f800761157a3f561e06f3c4a99' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/passwd.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50878361657b41f8ad0f553-09591470',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b41f8ad472f2_20805433',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b41f8ad472f2_20805433')) {function content_57b41f8ad472f2_20805433($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
">基本资料</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
" class="on">安全设置</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
">更换手机</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
">提现帐号</a>
    <div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <form action="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <th><span class="red">*</span>旧密码：</th>
                <td><input type="password" name="data[passwd]" value="" class="input w-150"/></td>
            </tr>
            <tr>
                <th><span class="red">*</span>新密码：</th>
                <td><input type="password" name="data[new_passwd]" value="" class="input w-150"/></td>
            </tr>
            <tr>
                <th><span class="red">*</span>确认新密码：</th>
                <td><input type="password" name="data[new_passwd2]" value="" class="input w-150"/></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" value="保存数据" class="btn btn-primary" /></td>
            </tr>
        </table>
    </form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>