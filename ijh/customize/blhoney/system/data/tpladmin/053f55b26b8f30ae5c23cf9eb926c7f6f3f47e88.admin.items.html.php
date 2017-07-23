<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 20:20:05
         compiled from "admin:member/log/items.html" */ ?>
<?php /*%%SmartyHeaderCode:95887428157b304f50af6e7-99833868%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '053f55b26b8f30ae5c23cf9eb926c7f6f3f47e88' => 
    array (
      0 => 'admin:member/log/items.html',
      1 => 1470380623,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '95887428157b304f50af6e7-99833868',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
    'member_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b304f5122900_91450909',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b304f5122900_91450909')) {function content_57b304f5122900_91450909($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_modifier_iplocal')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.iplocal.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"member/log:so",'class'=>"button",'load'=>"mini:搜索日志",'width'=>"mini:400",'title'=>"搜索"),$_smarty_tpl);?>
 &nbsp; &nbsp;</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr>
                <th class="w-100">ID</th>
                <th class="w-100">用户</th>
                <th class="w-100">类型</th>
                <th class="w-100">收支</th>
                <th>说明</th>
                <th class="w-150">时间</th>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <tr>
                    <td class="left"><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['log_id'];?>
" name="log_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['log_id'];?>
<label></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['member_list']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['type']=='money'){?>余额<?php }else{ ?>积分<?php }?></td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['number'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['intro'];?>
</td>
                    <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['clientip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['clientip']);?>
)</td>
                </tr>
            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                <tr><td colspan="20"><p class="text-align">没有数据</p></td></tr>
            <?php } ?>
        </table>
    </form>
    <div class="page-bar">
        <table>
            <tr>
                <td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
                <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
            </tr>
        </table>
    </div>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>