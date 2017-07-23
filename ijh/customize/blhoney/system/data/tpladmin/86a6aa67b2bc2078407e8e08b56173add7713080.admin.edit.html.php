<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 17:04:34
         compiled from "admin:hongbao/hongbao/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:173289705357b2d7227fa112-08385027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86a6aa67b2bc2078407e8e08b56173add7713080' => 
    array (
      0 => 'admin:hongbao/hongbao/edit.html',
      1 => 1470380621,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '173289705357b2d7227fa112-08385027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'user' => 0,
    'types' => 0,
    'k' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2d72287b364_03914524',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2d72287b364_03914524')) {function content_57b2d72287b364_03914524($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"hongbao/hongbao:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <form action="?hongbao/hongbao-edit.html" mini-form="hongbao-form" method="post" >
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <input type="hidden" name="hongbao_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['hongbao_id'];?>
"/>
            <tr>
                <th><span class="red">*</span>标题：</th>
                <td><input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-150"/><br /></td>
            </tr>
            <tr>
                <th>选择用户：</th>
                <td>
                    <input type="hidden" name="data[uid]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['uid'];?>
" id="hongbao_member_id" />
                    <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['nickname'];?>
" id="hongbao_member_uname" class="input w-150"/>
                    <?php echo smarty_function_link(array('ctl'=>"member/member:dialog",'title'=>"选择用户",'select'=>"mini:#hongbao_member_id,#hongbao_member_uname/N/选择用户",'class'=>"button"),$_smarty_tpl);?>

                </td>
            </tr>
            <tr>
                <th><span class="red">*</span>满多少使用：</th>
                <td><input type="text" name="data[min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['min_amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-150"/><span class="tip-comment">满足使用条件</span></td>
            </tr>
            <tr>
                <th><span class="red">*</span>红包价值：</th>
                <td><input type="text" name="data[amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-150"/><span class="tip-comment">红包价值</span></td>
            </tr>
            <tr>
                <th class="w-100"><span class="red">*</span>类型：</th>
                    <td>
                        <select name="data[type]" class="w-150">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['type']==$_smarty_tpl->tpl_vars['k']->value){?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </td>
            </tr>
            <tr><th>失效时间：</th>
                <td>
                    <input type="text" name="data[ltime]" value="<?php if ($_smarty_tpl->tpl_vars['detail']->value['ltime']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['ltime'],'Y-m-d');?>
<?php }?>" datetime="ltime" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd'});" class="input w-150"/>
                    <span class="tip-comment">红包过期时间</span>
                </td>
            </tr>
            <tr>
                <th class="clear-th-bottom"></th>
                <td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td>
            </tr>
        </table>
    </form>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>