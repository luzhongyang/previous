<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 16:24:14
         compiled from "admin:order/order/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:165329506157b570ae6bc150-95718863%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5626848fd62563223cdd7a8c4bf108333cfda8f0' => 
    array (
      0 => 'admin:order/order/detail.html',
      1 => 1470380625,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '165329506157b570ae6bc150-95718863',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'payments' => 0,
    'froms' => 0,
    'var' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b570ae982108_85639355',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b570ae982108_85639355')) {function content_57b570ae982108_85639355($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"order/order:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <table width="100%" border="0" cellspacing="0" class="table-data form">
        <tr>
            <th>订单ID：</th><td class="w-300"><?php echo $_smarty_tpl->tpl_vars['detail']->value['order_id'];?>
</td>
            <th>用户：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['user']['nickname'];?>
</td>
        </tr>
        <tr>
            <th>商家：</th><td><span class="red"><?php echo $_smarty_tpl->tpl_vars['detail']->value['shop']['title'];?>
</span></td>
            <th>商品总价：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['product_price'];?>
</td>
        </tr>
        <tr><th>商品数量：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['product_number'];?>
</td><th>打包费：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['package_price'];?>
</td></tr>
        <tr><th>运费：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['freight'];?>
</td><th>使用余额支付：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['money'];?>
</td></tr>
        <tr><th>第三方支付：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['amount'];?>
</td><th>订单优惠：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['order_youhui'];?>
</td></tr> 
        <tr><th>首单优惠：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['first_youhui'];?>
</td><th>使用红包：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['hongbao_id']>0){?><?php echo $_smarty_tpl->tpl_vars['detail']->value['hongbao'];?>
(ID:<?php echo $_smarty_tpl->tpl_vars['detail']->value['hongbao_id'];?>
)<?php }else{ ?>无<?php }?></td></tr>
        <tr>
            <th>经纬度：</th><td>经度：<?php echo $_smarty_tpl->tpl_vars['detail']->value['lng'];?>
纬度：<?php echo $_smarty_tpl->tpl_vars['detail']->value['lat'];?>
</td>
            <th>地址：</th><td><span class="green"><?php echo $_smarty_tpl->tpl_vars['detail']->value['addr'];?>
，<?php echo $_smarty_tpl->tpl_vars['detail']->value['house'];?>
(<?php echo $_smarty_tpl->tpl_vars['detail']->value['contact'];?>
,<?php echo $_smarty_tpl->tpl_vars['detail']->value['mobile'];?>
)</span></td>
        </tr>
        <tr><th>期望送达时间：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_time']==0){?>尽快送达<?php }else{ ?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['dateline'],'Y-m-d');?>
<?php echo $_smarty_tpl->tpl_vars['detail']->value['pei_time'];?>
<?php }?></td><th>备注：</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['note'])===null||$tmp==='' ? '无' : $tmp);?>
</td></tr>
        <tr><th>订单状态：</th><td><span class="red"><?php echo $_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']];?>
</span></td><th>支付状态：</th><td><span class="green"><?php if ($_smarty_tpl->tpl_vars['detail']->value['pay_status']==1){?>已支付<?php }else{ ?>未支付<?php }?></span></td></tr>
        <tr><th>是否在线支付：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==1){?>在线支付<?php }else{ ?>餐到付款<?php }?></td><th>支付方式：</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->tpl_vars['detail']->value['pay_type']])===null||$tmp==='' ? '无' : $tmp);?>
</td></tr>
        <tr><th>支付IP：</th><td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['pay_ip'])===null||$tmp==='' ? '无' : $tmp);?>
</td><th>支付时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['pay_time'],'Y-m-d H:i:s');?>
</td></tr>
        <tr>
            <th>配送类型：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==0){?>商家自主配送<?php }elseif($_smarty_tpl->tpl_vars['detail']->value['pei_type']==1){?>第三方配送<?php }else{ ?>代购送<?php }?></td>
            <th>配送员：</th>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==0){?>
                        商家自主配送
                    <?php }else{ ?>
                        <?php if ($_smarty_tpl->tpl_vars['detail']->value['staff_id']>0){?>
                            <?php echo $_smarty_tpl->tpl_vars['detail']->value['staff']['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['detail']->value['staff']['mobile'];?>
)
                            <?php if ($_smarty_tpl->tpl_vars['detail']->value['order_status']==4||$_smarty_tpl->tpl_vars['detail']->value['order_status']==3){?>
                            <?php echo smarty_function_link(array('ctl'=>"order/order:quxiaopei",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消配送员",'confirm'=>"mini:确定要取消配送员吗",'title'=>"取消配送员",'class'=>"button"),$_smarty_tpl);?>

                            <?php }?>
                            <?php }elseif($_smarty_tpl->tpl_vars['detail']->value['order_status']>1&&$_smarty_tpl->tpl_vars['detail']->value['order_status']<8&&$_smarty_tpl->tpl_vars['detail']->value['staff']<1){?>
                            <?php echo smarty_function_link(array('ctl'=>"order/order:dopaidan",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'load'=>"mini:派单给配送",'title'=>"派单配送",'class'=>"button"),$_smarty_tpl);?>

                            <?php }else{ ?>
                            配送员未接单
                            <?php }?>

                    <?php }?>
                </td>
            </tr>
        <tr><th>配送费用：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['pei_amount'];?>
</td><th>评论状态：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['comments_status']==1){?>已点评<?php }else{ ?>未点评<?php }?></td></tr>
        <tr>
            <th>最后催单时间：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['cui_time']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['cui_time']);?>
<?php }else{ ?>--<?php }?></td>
            <th>订单来源：</th><td><?php echo $_smarty_tpl->tpl_vars['froms']->value[$_smarty_tpl->tpl_vars['detail']->value['order_from']];?>
</td>
        </tr>
        <tr><th>客户IP：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['clientip'];?>
</td><th>下单时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['dateline'],'Y-m-d H:i:s');?>
</td></tr>
        <tr><td colspan="10" class="h-10"></td></tr>
    </table>    
    <?php if ($_smarty_tpl->tpl_vars['detail']->value['products']){?>
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-100">商品ID</th>
        <th class="w-50">商品名称</th>
        <th class="w-50">单价</th>
        <th class="w-50">打包费</th>
        <th class="w-100">数量</th>
        <th class="w-100">小计</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['var']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['detail']->value['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value){
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
    <tr>
        <td>ID:<?php echo $_smarty_tpl->tpl_vars['var']->value['product_id'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['var']->value['product_name'];?>
</td>
        <td>￥<?php echo $_smarty_tpl->tpl_vars['var']->value['product_price'];?>
</td>
        <td>￥<?php echo $_smarty_tpl->tpl_vars['var']->value['package_price'];?>
</td>
        <td>X<?php echo $_smarty_tpl->tpl_vars['var']->value['product_number'];?>
</td>
        <td>￥<?php echo $_smarty_tpl->tpl_vars['var']->value['amount'];?>
</td>
    </tr>
    <?php } ?>
    </table>                            
    <?php }?>                                                                                                                        
    <?php if ($_smarty_tpl->tpl_vars['detail']->value['logs']){?>
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-100">日志编号</th>
        <th class="w-50">操作人员</th>
        <th class="w-150">明细</th>
        <th class="w-100">时间</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['var']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['detail']->value['logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value){
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
    <tr >
        <td><?php echo $_smarty_tpl->tpl_vars['var']->value['log_id'];?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['var']->value['from']=='member'){?>用户<?php }elseif($_smarty_tpl->tpl_vars['var']->value['from']=='shop'){?>商家<?php }elseif($_smarty_tpl->tpl_vars['var']->value['from']=='staff'){?>配送员<?php }else{ ?>管理人员<?php }?>(<?php echo $_smarty_tpl->tpl_vars['detail']->value['types'][$_smarty_tpl->tpl_vars['var']->value['type']];?>
)</td>
        <td><?php echo $_smarty_tpl->tpl_vars['var']->value['log'];?>
</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['var']->value['dateline']);?>
</td>
    </tr>
    <?php } ?>
    <?php }?>
    </table> 


    <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='已取消'||$_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='订单完成'){?>
    <?php }else{ ?>
    <table width="100%" border="0" cellspacing="0" class="table-data table">
    <tr>
        <th class="w-20">管理员操作</th>
        <th class="w-200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th class="w-1400">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    </tr>
    <tr>
        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='未处理'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==1&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==0){?>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td class="w-200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='未处理'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==0&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==0){?>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:accept",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'arg1'=>1,'act'=>"mini:接单",'confirm'=>"mini:确定要接单吗",'title'=>"接单",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='未处理'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==1&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==1){?>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:accept",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'arg1'=>1,'act'=>"mini:接单",'confirm'=>"mini:确定要接单吗",'title'=>"接单",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='已接单'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==1&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==1){?> 
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:peisong",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:开始配送",'confirm'=>"mini:确定要开始配送吗",'title'=>"开始配送",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='已接单'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==0&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==0){?> 
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:peisong",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:开始配送",'confirm'=>"mini:确定要开始配送吗",'title'=>"开始配送",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='配送开始'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==1&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==1){?> 
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:finish",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:完成订单",'confirm'=>"mini:确定要完成订单吗",'title'=>"完成订单",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['detail']->value['status'][$_smarty_tpl->tpl_vars['detail']->value['order_status']]=='配送开始'&&$_smarty_tpl->tpl_vars['detail']->value['online_pay']==0&&$_smarty_tpl->tpl_vars['detail']->value['pay_status']==0){?> 
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:finish",'arg0'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:完成订单",'confirm'=>"mini:确定要完成订单吗",'title'=>"完成订单",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td><?php echo smarty_function_link(array('ctl'=>"order/order:cancel",'args'=>$_smarty_tpl->tpl_vars['detail']->value['order_id'],'act'=>"mini:取消订单",'confirm'=>"mini:确定要取消订单吗",'title'=>"取消订单",'class'=>"button"),$_smarty_tpl);?>
</td>
        <?php }?>

        <td class="w-1400">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>   
    </table>
    <?php }?>                        
    
</div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>