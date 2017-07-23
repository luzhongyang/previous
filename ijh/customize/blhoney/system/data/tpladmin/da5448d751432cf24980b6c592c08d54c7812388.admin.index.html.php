<?php /* Smarty version Smarty-3.1.8, created on 2016-08-19 09:39:38
         compiled from "admin:tools/database/index.html" */ ?>
<?php /*%%SmartyHeaderCode:88746393957b6635a593341-01914546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da5448d751432cf24980b6c592c08d54c7812388' => 
    array (
      0 => 'admin:tools/database/index.html',
      1 => 1470380628,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '88746393957b6635a593341-01914546',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'table_list' => 0,
    'table' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b6635a5ee7c7_66132682',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b6635a5ee7c7_66132682')) {function content_57b6635a5ee7c7_66132682($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><label class="left">数据库管理</label>
            <div class="item-menu">
                <a href="?tools/database-index.html" class="on">备份</a>
                <a href="?tools/database-backlist.html">还原</a>
                <a href="?tools/database-optimize.html">优化</a>
            </div>  
            </td>
            <td align="left"></td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">    
    <form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data form">
    <tr>
        <th colspan="10"><label class="left"><input type="checkbox" checked CKA="PRI"/>&nbsp;&nbsp;全选</label><span class="right">总大小：<?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['pager']->value['totalsize'],"size");?>
</span></th>
    </tr>
    <tr>
        <td colspan="10">
        <ul class="group-list" style="width:100%">
            <?php  $_smarty_tpl->tpl_vars['table'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['table']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['table_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['table']->key => $_smarty_tpl->tpl_vars['table']->value){
$_smarty_tpl->tpl_vars['table']->_loop = true;
?>
                <li style="width:190px;"><label><input type="checkbox" name="tables[]" value="<?php echo $_smarty_tpl->tpl_vars['table']->value['Name'];?>
" checked  CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['table']->value['Name'];?>
</label></li>
            <?php } ?>
        </ul>
        </td>
    </tr>    
    </table>
    </form>
    <div class="page-bar">
        <table>
            <tr>
            <td class="w-100"><label><input type="checkbox" checked CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
            <td colspan="10" class="left">
                <?php echo smarty_function_link(array('ctl'=>"tools/database:backup",'type'=>"button",'submit'=>"mini:#items-form",'priv'=>"hide",'value'=>"备份数据"),$_smarty_tpl);?>

                <?php echo smarty_function_link(array('ctl'=>"tools/database:optimize",'type'=>"button",'submit'=>"mini:#items-form",'priv'=>"hide",'value'=>"优化表"),$_smarty_tpl);?>

            </td>
            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
        </tr>
        </table>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>