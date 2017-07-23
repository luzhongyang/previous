<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:17:15
         compiled from "admin:shop/cate/create.html" */ ?>
<?php /*%%SmartyHeaderCode:24907154057b2afebc0c205-67744503%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6cad2fc04756a024fc7e0f08d37bb4ad64f0e39' => 
    array (
      0 => 'admin:shop/cate/create.html',
      1 => 1470380626,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '24907154057b2afebc0c205-67744503',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'cates' => 0,
    'v' => 0,
    'parent_id' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2afebc742b3_12847824',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2afebc742b3_12847824')) {function content_57b2afebc742b3_12847824($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/cate:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data"><form action="?shop/cate-create.html" mini-form="cate-form" method="post" ENCTYPE="multipart/form-data">
        <table width="100%" border="0" cellspacing="0" class="table-data form">
            <tr>
                <th width="150">上级分类:</th>
                <td>
                    <select name="data[parent_id]">
                        <option value="0">一级分类</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"<?php if ($_smarty_tpl->tpl_vars['v']->value['cate_id']==$_smarty_tpl->tpl_vars['parent_id']->value){?>selected="selected"<?php }?>>|--<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><span class="red">*</span>标题：</th>
                <td><input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td>
            </tr>
            <tr>
                <th><span class="red">*</span>图标：</th>
                <td><input type="text" name="data[icon]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['icon'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['icon']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['icon'];?>
"<?php }?> class="input w-200" />&nbsp;&nbsp;&nbsp;<input type="file" name="data[icon]" class="input w-100" /></td>
            </tr>
            <tr>
                <th><span class="red">*</span>排序：</th>
                <td><input type="text" name="data[orderby]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['orderby'])===null||$tmp==='' ? '50' : $tmp);?>
" class="input w-100"/></td>
            </tr>
            <tr>
                <th class="clear-th-bottom"></th>
                <td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td>
            </tr>
        </table>
    </form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>