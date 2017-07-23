<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 15:16:38
         compiled from "admin:shop/shop/dialog.html" */ ?>
<?php /*%%SmartyHeaderCode:77297719857b803d6b81983-14286727%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9ca8f3387c9afe248240738072d44ddb921640c' => 
    array (
      0 => 'admin:shop/shop/dialog.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '77297719857b803d6b81983-14286727',
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
  'unifunc' => 'content_57b803d6bec029_69455032',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b803d6bec029_69455032')) {function content_57b803d6bec029_69455032($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-data">	
	<form id="items-form">
    <table width="100%" border="0" cellspacing="0" class="table-data table left">
    <tr>
        <th>商户(ID)</th>
        <th>城市</th>
        <th>手机</th>
        <th>审核</th>
        <th><?php echo smarty_function_link(array('ctl'=>"shop/shop:so",'arg0'=>"dialog",'arg1'=>$_smarty_tpl->tpl_vars['pager']->value['multi'],'arg2'=>$_smarty_tpl->tpl_vars['pager']->value['from'],'class'=>"button",'title'=>"搜索",'load'=>"mini:搜索商家",'width'=>"mini:400"),$_smarty_tpl);?>
</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
		<td>		
		<label><input type="radio" name="itemId" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
" data="{'itemId':'<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
','title':'<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
'}" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
(UID:<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
)</label>
        </td>		
		<td><?php echo $_smarty_tpl->tpl_vars['item']->value['city_name'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['audit']){?><b class="blue">通过</b><?php }else{ ?><b class="red">待审</b><?php }?></td>
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