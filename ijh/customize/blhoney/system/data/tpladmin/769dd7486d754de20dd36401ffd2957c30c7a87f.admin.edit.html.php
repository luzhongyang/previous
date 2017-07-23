<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 20:32:40
         compiled from "admin:member/member/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:123790593757b307e8561401-49747764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '769dd7486d754de20dd36401ffd2957c30c7a87f' => 
    array (
      0 => 'admin:member/member/edit.html',
      1 => 1470380623,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '123790593757b307e8561401-49747764',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b307e85bb5e7_98863293',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b307e85bb5e7_98863293')) {function content_57b307e85bb5e7_98863293($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"member/member:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data"><form action="?member/member-edit.html" mini-form="member-form" method="post" ENCTYPE="multipart/form-data">
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <input type="hidden" name="uid" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['uid'];?>
"/>
            <tr>
                <th><span class="red">*</span>手机号：</th>
                <td><input type="text" name="data[mobile]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['mobile'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td>
            </tr>
            <tr>
                <th><span class="red">*</span>密码：</th>
                <td><input type="text" name="data[passwd]" value="******" class="input w-200"/></td>
            </tr>
            <tr>
                <th>昵称：</th>
                <td><input type="text" name="data[nickname]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['nickname'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td>
            </tr>
            <tr>
                <th>头像：</th>
                <td><input type="text" name="data[face]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['face'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['face']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['face'];?>
"<?php }?> class="input w-200" />&nbsp;&nbsp;&nbsp;<input type="file" name="data[face]" class="input w-100" /></td>
            </tr>
            <tr>
                <th>微信OPENID：</th>
                <td><input type="text" name="data[wx_openid]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['wx_openid'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td>
            </tr>
            <tr>
                <th class="clear-th-bottom"></th>
                <td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td>
            </tr>
        </table>
    </form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>