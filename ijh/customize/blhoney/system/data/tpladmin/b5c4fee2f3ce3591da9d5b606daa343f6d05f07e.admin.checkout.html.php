<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:36:00
         compiled from "admin:order/order/checkout.html" */ ?>
<?php /*%%SmartyHeaderCode:79948837057b511007735b8-50728902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5c4fee2f3ce3591da9d5b606daa343f6d05f07e' => 
    array (
      0 => 'admin:order/order/checkout.html',
      1 => 1470380624,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '79948837057b511007735b8-50728902',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'shop_id' => 0,
    'dyear' => 0,
    'dmonth' => 0,
    'years' => 0,
    'v' => 0,
    'months' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b51100810456_46296156',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b51100810456_46296156')) {function content_57b51100810456_46296156($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
         <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right">
                <?php echo smarty_function_link(array('ctl'=>"order/order:exportform",'arg0'=>$_smarty_tpl->tpl_vars['shop_id']->value,'arg1'=>$_smarty_tpl->tpl_vars['dyear']->value,'arg2'=>$_smarty_tpl->tpl_vars['dmonth']->value,'class'=>"button",'title'=>"导出"),$_smarty_tpl);?>

            </td>
            <td width="15"></td>
        </tr>
    </table>
</div>

<div class="page-data"> 
        <table width="100%" border="0" cellspacing="0" class="table-data table">
           <tr>
                <td>
                    <select id="j_year">
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['years']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['dyear']->value==$_smarty_tpl->tpl_vars['v']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
年</option>
                        <?php } ?>
                    </select>
                    <select id="j_month">
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['months']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['dmonth']->value==$_smarty_tpl->tpl_vars['v']->value){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
月</option>  
                        <?php } ?>   
                    </select>
                    <input type="button" id="btn_checkout" class="bt-big" value="搜索">
                    
                </td>  
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr>
                <th class="w-100">编号</th>
                <th class="w-100">商户名称</th>
                <th class="w-100">本月营业额</th>
                <th class="w-100">本月订单结算</th>
                <th class="w-100">在线支付</th>
                <th class="w-100">查看</th>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <tr>  
                <td class="w-100"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['shop_id'])===null||$tmp==='' ? '' : $tmp);?>
</td>
                <td class="w-100"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['shopname'])===null||$tmp==='' ? '' : $tmp);?>
</td>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['income'])===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['checkout'])===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['v']->value['onlinepay'])===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100"><?php echo smarty_function_link(array('ctl'=>"order/order:checkbill",'arg0'=>$_smarty_tpl->tpl_vars['v']->value['shop_id'],'arg1'=>$_smarty_tpl->tpl_vars['dyear']->value,'arg2'=>$_smarty_tpl->tpl_vars['dmonth']->value,'class'=>"button"),$_smarty_tpl);?>
</td>
            </tr>
            <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
            <tr><td colspan="20"><p class="text-align tip-notice">没有数据</p></td></tr>
            <?php } ?>
        </table>    
    <?php if ($_smarty_tpl->tpl_vars['list']->value){?>
    <div class="page-bar">
        <table>
            <tr>
            <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
        </tr>
        </table>
    </div>
    <?php }else{ ?>
    <?php }?>
</div>
<script type="text/javascript">
(function($, K){
var link = "?order/order-checkout-#year#-#month#-2.html"
$("#btn_checkout").on("click", function(){
    location.href = link.replace("#year#", $("#j_year").val()).replace("#month#", $("#j_month").val());
})
})(window.jQuery, window.KT)
</script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>