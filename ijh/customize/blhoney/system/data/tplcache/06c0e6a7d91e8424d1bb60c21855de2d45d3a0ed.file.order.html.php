<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:52
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/order.html" */ ?>
<?php /*%%SmartyHeaderCode:134475496857b2af20063e99-72836449%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06c0e6a7d91e8424d1bb60c21855de2d45d3a0ed' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/order.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134475496857b2af20063e99-72836449',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'today_orders' => 0,
    'seven_orders' => 0,
    'month_orders' => 0,
    'all_orders' => 0,
    'pager' => 0,
    'OTOKEN' => 0,
    'week_data' => 0,
    'v1' => 0,
    'month_data' => 0,
    'v2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af200e8537_41192640',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af200e8537_41192640')) {function content_57b2af200e8537_41192640($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<style type="text/css">
    .tab_fl2{display:inline-block;width:230px;border-right:2px solid #ffffff;background:#5db42f;color:#ffffff;line-height:40px;height:40px;padding:5px 0px;float:left;text-align:center;}
</style>
<div style="margin-left:20px;margin-bottom:20px">
    <div class="tab_fl2">今日订单量&nbsp;<?php if ($_smarty_tpl->tpl_vars['today_orders']->value){?><?php echo $_smarty_tpl->tpl_vars['today_orders']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">本周订单量&nbsp;<?php if ($_smarty_tpl->tpl_vars['seven_orders']->value){?><?php echo $_smarty_tpl->tpl_vars['seven_orders']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">本月订单量&nbsp;<?php if ($_smarty_tpl->tpl_vars['month_orders']->value){?><?php echo $_smarty_tpl->tpl_vars['month_orders']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">累计总订单量&nbsp;<?php if ($_smarty_tpl->tpl_vars['all_orders']->value){?><?php echo $_smarty_tpl->tpl_vars['all_orders']->value;?>
<?php }else{ ?>0<?php }?></div>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td colspan="2">
                <div class="tableBox">
                    <div id="week_chart" style="margin-top:20px">
                    </div>
                    <div id="month_chart" style="margin-top:20px">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<script type="text/javascript">
            $("[name='data[sale_type]']").click(function () {
    if ($(this).val() == 1) {
    $("#tr_sale_sku1").show();
            $("#tr_sale_sku2").show();
    } else {
    $("#tr_sale_sku2").hide();
            $("#tr_sale_sku1").hide();
    }
    });
            $("[name='data[sale_type]']:checked").trigger("click");</script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
            (function(K, $){
            var editor = KindEditor.create('textarea[kindeditor]', {uploadJson : '<?php echo smarty_function_link(array('ctl'=>"biz/upload:editor",'http'=>"base"),$_smarty_tpl);?>
', extraFileUploadParams:{OTOKEN:"<?php echo $_smarty_tpl->tpl_vars['OTOKEN']->value;?>
"}});
                    })(window.KT, window.jQuery);
</script>  
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(function () {
    $('#week_chart').highcharts({
        chart: {
            type: 'line'
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        title: {
            text: '近一周订单量曲线',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: '订单量 (个)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '个'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '订单量',
            data: [
                 <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v1']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v1']->value['day_order'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v1']->value['day_order'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });

    $('#month_chart').highcharts({
        title: {
            text: '近一月订单量曲线',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: '订单量 (个)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '个'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '订单量',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v2']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v2']->value['day_order'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v2']->value['day_order'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });
});
</script><?php }} ?>