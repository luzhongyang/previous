<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 17:04:41
         compiled from "admin:member/member/dialog.html" */ ?>
<?php /*%%SmartyHeaderCode:158019973557b2d729154865-08770752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '250c93d14851080d839416851957c70885cc09ac' => 
    array (
      0 => 'admin:member/member/dialog.html',
      1 => 1470380623,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '158019973557b2d729154865-08770752',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2d7291c7663_62068239',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2d7291c7663_62068239')) {function content_57b2d7291c7663_62068239($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table left">
    <tr>
        <th>会员名(UID)</th>
        <th>手机</th>
        <th>余额</th>
        <th><?php echo smarty_function_link(array('ctl'=>"member/member:so",'arg0'=>"dialog",'arg1'=>$_smarty_tpl->tpl_vars['pager']->value['multi'],'arg2'=>$_smarty_tpl->tpl_vars['pager']->value['from'],'class'=>"button",'title'=>"搜索",'load'=>"mini:搜索会员",'width'=>"mini:500"),$_smarty_tpl);?>
</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
		<td>		
		<label><input type="radio" name="itemId" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
" data="{'itemId':'<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
','title':'<?php echo $_smarty_tpl->tpl_vars['item']->value['nickname'];?>
'}" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['nickname'];?>
(UID:<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
)</label>
        </td>
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</td>
		<td><?php if ($_smarty_tpl->tpl_vars['item']->value['closed']=='1'){?>删除<?php }else{ ?>正常<?php }?></td>
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
                     <?php if ($_smarty_tpl->tpl_vars['pager']->value['pagebar']){?> 
			<tr>
                            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
                        </tr>
                    <?php }?>   
		</table>
	</div>

</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>