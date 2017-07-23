<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:11:12
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/order/complete.html" */ ?>
<?php /*%%SmartyHeaderCode:171343365357b284501c37f0-09135475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef0af20d6fad9b3f5e954e6d0645b703beaa321d' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/order/complete.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '171343365357b284501c37f0-09135475',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'status' => 0,
    'var' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2845028fa92_39225417',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2845028fa92_39225417')) {function content_57b2845028fa92_39225417($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <ul>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:index'),$_smarty_tpl);?>
">待接订单</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:spend'),$_smarty_tpl);?>
">核销订单</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:complete'),$_smarty_tpl);?>
" class="on">完成订单</a>
    </ul>
    <!--<span class="r"><a target="_blank" href="<?php echo smarty_function_link(array('ctl'=>'biz/ordermanage:index'),$_smarty_tpl);?>
" class="btn btn-success">快速管理</a></span>-->
</div>
<div class="ucenter_c">
    <form id="items-form">
    <table cellspacing="0" cellpadding="0" class="table">
        <tr class="alt">
            <th class="w-60">订单编号</th>
            <th class="w-60">联系人</th>
            <th class="w-60">手机号</th>
            <th class="w-150">下单时间</th>
            <th class="w-100">操作</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
        <tr>
            <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
" name="order_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
<label></td>     
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>
</td>    
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>     
            <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline'],'Y-m-d H:i');?>
</td>

            <td>
                <a href="javascript:void(0);" rel="<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
"  class="btn btn-success view_btn" title="查看">查看</a>
            </td>
        </tr>
        <tr class="table_child tr_<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
">
            <td class="border_none" colspan="7">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_detail">
                <tr>
                    <th colspan="3">
                            <div>
                            <ul>
                                <li class="list">订单号：<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>

                                <li class="list">联系人：<?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>

                                <li class="list">手机号：<?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>

                                <li class="list">下单时间：<?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline'],'Y-m-d H:i');?>

                                <li class="list">状态：<?php echo $_smarty_tpl->tpl_vars['status']->value[$_smarty_tpl->tpl_vars['item']->value['order_status']];?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==8&&$_smarty_tpl->tpl_vars['item']->value['spend_status']==1){?>（已核销）<?php }?>
                                <li class="list">在线支付：<?php if ($_smarty_tpl->tpl_vars['item']->value['online_pay']==1){?>是<?php }else{ ?>否<?php }?>
                                <li class="list">支付状态：<?php if ($_smarty_tpl->tpl_vars['item']->value['pay_status']==1){?>已支付<?php }else{ ?>未支付<?php }?>
                                </ul>
                        </div>
                    </th>
                </tr>
                <?php  $_smarty_tpl->tpl_vars['var'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['var']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['var']->key => $_smarty_tpl->tpl_vars['var']->value){
$_smarty_tpl->tpl_vars['var']->_loop = true;
?>
                <tr>
                    <td width="200"><?php echo $_smarty_tpl->tpl_vars['var']->value['product_name'];?>
</td>
                    <td width="200"><span class="num">×<?php echo $_smarty_tpl->tpl_vars['var']->value['product_number'];?>
</span></td>
                    <td class="txt_r">单价：<span class="price">￥<?php echo $_smarty_tpl->tpl_vars['var']->value['product_price'];?>
</span></td>
                </tr>
                <?php } ?>
                <tr>
                    <!--<td colspan="3">打包费：￥<?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
 运费：￥<?php echo $_smarty_tpl->tpl_vars['item']->value['freight'];?>
</td>-->
                </tr>
                <tr>
                    <td colspan="3">合计：<span class="price_zong">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['product_price'];?>
</span>结算价：￥<?php echo $_smarty_tpl->tpl_vars['item']->value['js_price'];?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['first_youhui']>0){?>首单优惠：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['first_youhui'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['item']->value['order_youhui']>0){?>下单立减：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['order_youhui'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['item']->value['hongbao']>0){?>红包抵扣：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao'];?>
<?php }?></td>
                </tr>
                <tr>
                    <!--<td colspan="3">备注：<?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['note'])===null||$tmp==='' ? '无' : $tmp);?>
</td>-->
                </tr>
            </table>
        </td>
        </tr>
        <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
        <tr><td colspan="20"><div class="alert alert-info">暂无已完成订单</div></td></tr>
        <?php } ?>
        <tr>
    </table>
    </form>
   <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script>
    $(document).ready(function(){
        $(".view_btn").click(function(){
            $('.tr_'+$(this).attr('rel')).slideToggle();
        })
    })
    function finish(id) {
        var link = "<?php echo smarty_function_link(array('ctl'=>'biz/order:finish','args'=>'temp'),$_smarty_tpl);?>
";
        jQuery.ajax({
            url: link.replace('temp', id),
            async: true,
            dataType: 'json',
            type: 'POST',
            success: function (ret) {
                if (ret.error > 0) {
                    layer.msg(ret.message);
                } else {
                    layer.msg(ret.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
          },
        });
    }
</script><?php }} ?>