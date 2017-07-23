<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:35:58
         compiled from "admin:order/order/tongji.html" */ ?>
<?php /*%%SmartyHeaderCode:124201720857b510fe3b2314-41097499%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df6247f9857e81f9c222ae5ae6731b393977e2ad' => 
    array (
      0 => 'admin:order/order/tongji.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '124201720857b510fe3b2314-41097499',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'years' => 0,
    'v' => 0,
    'dyear' => 0,
    'months' => 0,
    'dmonth' => 0,
    'month_income' => 0,
    'month_onlinepay' => 0,
    'order_checkout' => 0,
    'month_order' => 0,
    'month_cancel' => 0,
    'loglist' => 0,
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b510fe476a30_98185032',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b510fe476a30_98185032')) {function content_57b510fe476a30_98185032($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/modules/no-data-to-display.js"></script>
<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
         <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>

        </tr>
    </table>
</div>

<div class="page-data"> 
    <form action="?order/order-tongji.html" method="post" >
        <table width="100%" border="0" cellspacing="0" class="table-data table">
           <tr>
                <td>
                    <select name="data[year]" >
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
                    <select name="data[month]">
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
                    <input type="submit" class="bt-big" value="搜索">
                </td>  
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr>
                <th class="w-100">本月营业额</th>
                <th class="w-100">在线支付金额</th>
                <th class="w-100">结算</th>
                <th class="w-100">已完成订单数</th>
                <th class="w-100">已取消订单数</th>
            </tr>
            <tr>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['month_income']->value)===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['month_onlinepay']->value)===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100">&yen;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['order_checkout']->value)===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['month_order']->value)===null||$tmp==='' ? '0' : $tmp);?>
</td>
                <td class="w-100"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['month_cancel']->value)===null||$tmp==='' ? '0' : $tmp);?>
</td>
            </tr>
        </table>
        <table width="100%" border="1" cellspacing="1" class="table-data table">
        <div id="month_chart" style="margin-right:20px">
        </div>
         </table>
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr>
                <th class="w-100">编号</th>
                <th class="w-100">日志</th>
                <th class="w-100">金额</th>
                <th class="w-100">发生日期</th>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['loglist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <tr>
                    <td class="w-100"><?php echo $_smarty_tpl->tpl_vars['v']->value['log_id'];?>
</td>
                    <td class="w-100"><?php echo $_smarty_tpl->tpl_vars['v']->value['intro'];?>
</td>
                    <td class="w-100"><?php echo $_smarty_tpl->tpl_vars['v']->value['money'];?>
</td>
                    <td class="w-100"><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['v']->value['dateline'],'Y-m-d H:i:s');?>
</td>
                </tr>
            <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
                <tr><td colspan="20"><p class="text-align tip-notice">没有数据</p></td></tr>
            <?php } ?>
        </table>
    </form>
    <?php if ($_smarty_tpl->tpl_vars['loglist']->value){?>
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

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(function () {
    $('#month_chart').highcharts({
   
        title: {
            text: '<?php echo $_smarty_tpl->tpl_vars['dyear']->value;?>
年<?php echo $_smarty_tpl->tpl_vars['dmonth']->value;?>
月'+'订单报表',
            x: 5 //center
        },
        subtitle: {
            text: '',
            x: 0
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -0,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
        },
        legend: {
            align: 'center', //程度标的目标地位
        　　verticalAlign: 'top', //垂直标的目标地位
        　　x: 0, //间隔x轴的间隔
        　　y: 20 //间隔Y轴的间隔
        },
        series: [
        {
            name: '订单数(单)',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v']->value['dates'];?>
+'日',   <?php if (empty($_smarty_tpl->tpl_vars['v']->value['orders'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v']->value['orders'];?>
<?php }?>],
                <?php } ?>
            ]
        },
        {
            name: '营业额(元)',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v']->value['dates'];?>
+'日',   <?php if (empty($_smarty_tpl->tpl_vars['v']->value['moneys'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v']->value['moneys'];?>
<?php }?>],
                <?php } ?>
            ]
        }
        ]
    });
});
</script><?php }} ?>