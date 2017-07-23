<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:35
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/product.html" */ ?>
<?php /*%%SmartyHeaderCode:101189371457b2af0f8d17b9-48155046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3da2382ba85414df18b0545e0752e36597aacf24' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/tongji/product.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101189371457b2af0f8d17b9-48155046',
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
  'unifunc' => 'content_57b2af0f9244c8_41691993',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af0f9244c8_41691993')) {function content_57b2af0f9244c8_41691993($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="form">
        <tr>
            <td colspan="2">
                <div class="tableBox">
                    <div id="week_cicle">
                    </div>
                    <div id="month_cicle" style="margin-top:20px">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(function () {
    $('#week_cicle').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '近一周商品销量饼状图'
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
            name: '商品销量',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                ['<?php echo $_smarty_tpl->tpl_vars['v1']->value['title'];?>
',   <?php if (empty($_smarty_tpl->tpl_vars['v1']->value['sale_cnt'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v1']->value['sale_cnt'];?>
<?php }?>],
                <?php } ?>
            ]
        }],
    });

    $('#month_cicle').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '近一月商品销量饼状图'
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
            name: '商品销量',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                ['<?php echo $_smarty_tpl->tpl_vars['v2']->value['title'];?>
',   <?php if (empty($_smarty_tpl->tpl_vars['v2']->value['sale_cnt'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v2']->value['sale_cnt'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });
});
</script><?php }} ?>