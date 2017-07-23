<?php /* Smarty version Smarty-3.1.8, created on 2016-08-19 09:37:51
         compiled from "admin:module/ctl/index.html" */ ?>
<?php /*%%SmartyHeaderCode:82930032357b662ef387494-20605870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d4c3e8c79d58670d3c096f8c561cafe1584ae52' => 
    array (
      0 => 'admin:module/ctl/index.html',
      1 => 1470380624,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '82930032357b662ef387494-20605870',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'menu_tree' => 0,
    'v' => 0,
    'vv' => 0,
    'vvv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b662ef4066a4_92662210',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b662ef4066a4_92662210')) {function content_57b662ef4066a4_92662210($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right">&nbsp; <?php echo smarty_function_link(array('ctl'=>"module/ctl:batch",'class'=>"button",'width'=>"mini:700",'load'=>"mini:添加导航菜单",'title'=>"添加控制模块"),$_smarty_tpl);?>
</td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<table align="center" width="100%" cellpadding="0" cellspacing="0" class="table-data list">
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
		<?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_smarty_tpl->tpl_vars['kk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['kk']->value = $_smarty_tpl->tpl_vars['vv']->key;
?>
		<tr>
			<td class="title left" style="padding-right:50px;">
				<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
 &gt; <?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>

				<span class="right">
					<?php echo smarty_function_link(array('ctl'=>"module/ctl:detail",'args'=>($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'class'=>"button",'width'=>"mini:700",'load'=>"mini:管理控制模型",'title'=>"管理模型"),$_smarty_tpl);?>

					<?php echo smarty_function_link(array('ctl'=>"module/menu:edit",'args'=>($_smarty_tpl->tpl_vars['vv']->value['mod_id']),'class'=>"button",'width'=>"mini:400",'load'=>"mini:编辑导航菜单",'title'=>"编辑导航"),$_smarty_tpl);?>

				</span>
			</td>
		</tr>
		<tr><td>
		<ul class="group-list">
		<?php  $_smarty_tpl->tpl_vars['vvv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vvv']->_loop = false;
 $_smarty_tpl->tpl_vars['kkk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['vv']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vvv']->key => $_smarty_tpl->tpl_vars['vvv']->value){
$_smarty_tpl->tpl_vars['vvv']->_loop = true;
 $_smarty_tpl->tpl_vars['kkk']->value = $_smarty_tpl->tpl_vars['vvv']->key;
?><li><?php echo $_smarty_tpl->tpl_vars['vvv']->value['title'];?>
[<?php if ($_smarty_tpl->tpl_vars['vvv']->value['visible']){?><b class="red">显示</b><?php }else{ ?>隐藏<?php }?>]</li><?php }
if (!$_smarty_tpl->tpl_vars['vvv']->_loop) {
?><li style="color:#FF3300;">未添加模型<li><?php } ?>
		<div class="clear-both"></div>
		</ul>
		</td></tr>
		<?php } ?>
		<?php } ?>
	</table>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>