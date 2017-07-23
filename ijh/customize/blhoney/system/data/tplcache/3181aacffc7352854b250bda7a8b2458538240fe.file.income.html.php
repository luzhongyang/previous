<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:50
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/income.html" */ ?>
<?php /*%%SmartyHeaderCode:96484460357b2af1ef02ae7-94527676%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3181aacffc7352854b250bda7a8b2458538240fe' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/income.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96484460357b2af1ef02ae7-94527676',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'today_coins' => 0,
    'seven_coins' => 0,
    'month_coins' => 0,
    'all_coins' => 0,
    'week_data' => 0,
    'v1' => 0,
    'month_data' => 0,
    'v2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af1f030ff0_67623496',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af1f030ff0_67623496')) {function content_57b2af1f030ff0_67623496($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<style type="text/css">
    .tab_fl2{display:inline-block;width:230px;border-right:2px solid #ffffff;background:#5db42f;color:#ffffff;line-height:40px;height:40px;padding:5px 0px;float:left;text-align:center;}
</style>
<div style="margin-left:20px;margin-bottom:20px">
    <div class="tab_fl2">今日收入¥&nbsp;<?php if ($_smarty_tpl->tpl_vars['today_coins']->value){?><?php echo $_smarty_tpl->tpl_vars['today_coins']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">近一周收入¥&nbsp;<?php if ($_smarty_tpl->tpl_vars['seven_coins']->value){?><?php echo $_smarty_tpl->tpl_vars['seven_coins']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">近一月收入¥&nbsp;<?php if ($_smarty_tpl->tpl_vars['month_coins']->value){?><?php echo $_smarty_tpl->tpl_vars['month_coins']->value;?>
<?php }else{ ?>0<?php }?></div>
    <div class="tab_fl2">累计总收入¥&nbsp;<?php if ($_smarty_tpl->tpl_vars['all_coins']->value){?><?php echo $_smarty_tpl->tpl_vars['all_coins']->value;?>
<?php }else{ ?>0<?php }?></div>
</div>
<div class="ucenter_c" >
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
            text: '近一周收入量曲线',
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
                text: '收入 (元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' 元'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '收入',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v1']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v1']->value['money'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v1']->value['money'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });

    $('#month_chart').highcharts({
        title: {
            text: '近一月收入量曲线',
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
                text: '收入 (元)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' 元'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '收入',
            data: [
               <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v2']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v2']->value['money'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v2']->value['money'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });
});
</script><?php }} ?>