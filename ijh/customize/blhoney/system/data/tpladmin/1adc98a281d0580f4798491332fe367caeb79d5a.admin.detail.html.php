<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:49:59
         compiled from "admin:shop/verify/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:199246348057b28d67c562f8-47606571%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1adc98a281d0580f4798491332fe367caeb79d5a' => 
    array (
      0 => 'admin:shop/verify/detail.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '199246348057b28d67c562f8-47606571',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28d67d59b77_63058019',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28d67d59b77_63058019')) {function content_57b28d67d59b77_63058019($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/verify:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
<form action="?shop/verify-edit-<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
.html" mini-form="verify-form" method="post" ENCTYPE="multipart/form-data">
<table width="100%" border="0" cellspacing="0" class="table-data form">
<tr><th>商家：</th><td colspan="3"><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
(<?php echo $_smarty_tpl->tpl_vars['shop']->value['mobile'];?>
)</td></tr>
<tr>
    <th>店主姓名：</th><td class="w-300"><?php echo $_smarty_tpl->tpl_vars['detail']->value['id_name'];?>
</td>
    <th>店主身份证号：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['id_number'];?>
</td>
</tr>
<tr><th>店主身份证图：</th>
    <td colspan="3">
        <span style="float:left;margin-left:10px; border:1px solid #DEDEDE;text-align:center;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['id_photo'];?>
" class="wh-200" /><br /><b>店主身份证图</b>
        </span>
        <span style="float:left;margin-left:10px; border:1px solid #DEDEDE;text-align:center;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_photo'];?>
" class="wh-200" /><br /><b>商铺实景图</b>
        </span>
    </td>
</tr>
<tr><th>店主认证状态：</th>
    <td colspan="3">
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu']==1){?>
        <b class="green">已认证</b>
        <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu']==2){?>
        <b class="red">拒绝</b>
        <?php }elseif(!$_smarty_tpl->tpl_vars['detail']->value['id_number']){?>
        <b class="blue">未提交认证信息</b>
        <?php }else{ ?>
        <label><input type="radio" name="data[verify_dianzhu]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu']==1){?>checked="checked"<?php }?> value="1"/>通过</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_dianzhu]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu']==2){?>checked="checked"<?php }?> value="2"/>拒绝</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_dianzhu]" <?php if (empty($_smarty_tpl->tpl_vars['detail']->value['verify_dianzhu'])){?>checked="checked"<?php }?> value="0"/>待审</label>
        <?php }?>
    </td>
</tr>
<tr>
    <th>营业执照号：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['yz_number'];?>
</td>
    <th>营业执照图：</th><td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['yz_photo'];?>
" class="wh-200" /></td>
</tr>
<tr><th>营业执照验证状态：</th>
    <td colspan="3">
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz']==1){?>
        <b class="green">已认证</b>
        <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz']==2){?>
        <b class="red">拒绝</b>
        <?php }elseif(!$_smarty_tpl->tpl_vars['detail']->value['yz_number']){?>
        <b class="blue">未提交认证信息</b>
        <?php }else{ ?>
        <label><input type="radio" name="data[verify_yyzz]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz']==1){?>checked="checked"<?php }?> value="1"/>通过</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_yyzz]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz']==2){?>checked="checked"<?php }?> value="2"/>拒绝</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_yyzz]" <?php if (empty($_smarty_tpl->tpl_vars['detail']->value['verify_yyzz'])){?>checked="checked"<?php }?> value="0"/>待审</label>
        <?php }?>
    </td>
</tr>
<tr>
    <th>餐饮执照号：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['cy_number'];?>
</td>
    <th>餐饮执照图：</th><td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['cy_photo'];?>
" class="wh-200" /></td>
</tr>
<tr><th>餐饮验证状态：</th>
    <td colspan="3">
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_cy']==1){?>
        <b class="green">已认证</b>
        <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['verify_cy']==2){?>
        <b class="red">拒绝</b>
        <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['verify_cy']){?>
        <b class="blue">未提交认证信息</b>
        <?php }else{ ?>
        <label><input type="radio" name="data[verify_cy]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_cy']==1){?>checked="checked"<?php }?> value="1"/>通过</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_cy]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify_cy']==2){?>checked="checked"<?php }?> value="2"/>拒绝</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify_cy]" <?php if (empty($_smarty_tpl->tpl_vars['detail']->value['verify_cy'])){?>checked="checked"<?php }?> value="0"/>待审</label>
        <?php }?>
    </td>
</tr>
<!--<tr><th>提交申请时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['updatetime']);?>
</td></tr>-->
<tr><th>认证状态：</th>
    <td colspan="3">
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify']==1){?>
        <b class="green">已认证</b>
        <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['verify']==2){?>
        <b class="red">拒绝</b>
        <?php }else{ ?>
        <label><input type="radio" name="data[verify]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify']==1){?>checked="checked"<?php }?> value="1"/>通过</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify]" <?php if ($_smarty_tpl->tpl_vars['detail']->value['verify']==2){?>checked="checked"<?php }?> value="2"/>拒绝</label>&nbsp;&nbsp;
        <label><input type="radio" name="data[verify]" <?php if (empty($_smarty_tpl->tpl_vars['detail']->value['verify'])){?>checked="checked"<?php }?> value="0"/>待审</label>
        <?php }?>
    </td>
</tr>
<?php if (empty($_smarty_tpl->tpl_vars['detail']->value['verify'])){?>
<tr><th>拒绝原因：</th><td><textarea class="textarea w-500"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['refuse'])===null||$tmp==='' ? '' : $tmp);?>
</textarea></td></tr>
<?php }else{ ?>
<tr><th>审核时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['verify_time'],'Y-m-d H:i:s');?>
</td></tr>
<?php }?>
<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</div>
</form>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>