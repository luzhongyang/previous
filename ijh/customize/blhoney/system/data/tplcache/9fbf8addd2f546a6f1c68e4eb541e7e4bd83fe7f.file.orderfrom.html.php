<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:53
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/orderfrom.html" */ ?>
<?php /*%%SmartyHeaderCode:34792079557b2af21a2bcc8-23701082%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fbf8addd2f546a6f1c68e4eb541e7e4bd83fe7f' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/orderfrom.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34792079557b2af21a2bcc8-23701082',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'week_data' => 0,
    'v1' => 0,
    'month_data' => 0,
    'v2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af21aa4991_77189336',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af21aa4991_77189336')) {function content_57b2af21aa4991_77189336($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td colspan="2">
                <div class="tableBox">
                    <div id="week_orderfrom" >
                    </div>
                    <div id="month_orderfrom" style="margin-top:20px">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(function () {
    $('#week_orderfrom').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '近一周订单来源饼状图'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '订单来源',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                ['<?php if ($_smarty_tpl->tpl_vars['v1']->value['order_from']=='www'){?>PC网页<?php }?><?php if ($_smarty_tpl->tpl_vars['v1']->value['order_from']=='wap'){?>手机网页<?php }?><?php if ($_smarty_tpl->tpl_vars['v1']->value['order_from']=='android'){?>安卓APP<?php }?><?php if ($_smarty_tpl->tpl_vars['v1']->value['order_from']=='ios'){?>苹果APP<?php }?><?php if ($_smarty_tpl->tpl_vars['v1']->value['order_from']=='weixin'){?>微信<?php }?>',   <?php echo $_smarty_tpl->tpl_vars['v1']->value['nums'];?>
],
                <?php }
if (!$_smarty_tpl->tpl_vars['v1']->_loop) {
?>
                <?php } ?>
            ]
        }]
    });

    $('#month_orderfrom').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '近一月订单来源饼状图'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '订单来源',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                ['<?php if ($_smarty_tpl->tpl_vars['v2']->value['order_from']=='www'){?>PC网页<?php }?><?php if ($_smarty_tpl->tpl_vars['v2']->value['order_from']=='wap'){?>手机网页<?php }?><?php if ($_smarty_tpl->tpl_vars['v2']->value['order_from']=='android'){?>安卓APP<?php }?><?php if ($_smarty_tpl->tpl_vars['v2']->value['order_from']=='ios'){?>苹果APP<?php }?><?php if ($_smarty_tpl->tpl_vars['v2']->value['order_from']=='weixin'){?>微信<?php }?>',   <?php echo $_smarty_tpl->tpl_vars['v2']->value['nums'];?>
],
                <?php }
if (!$_smarty_tpl->tpl_vars['v2']->_loop) {
?>
                <?php } ?>     
            ]
        }]
    });
});
</script>
<?php }} ?>