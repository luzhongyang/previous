<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:11:15
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/order/spend.html" */ ?>
<?php /*%%SmartyHeaderCode:46095814457b28453e975f4-44928451%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ec0ad9f46d49feae8300d70d646eddf1eec7e7d' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/order/spend.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46095814457b28453e975f4-44928451',
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
  'unifunc' => 'content_57b2845402d061_82748157',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2845402d061_82748157')) {function content_57b2845402d061_82748157($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <ul>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:index'),$_smarty_tpl);?>
">待接订单</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:spend'),$_smarty_tpl);?>
" class="on">核销订单</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:complete'),$_smarty_tpl);?>
">完成订单</a>
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
            <th class="w-200">操作</th>
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
                <a title="核销" mini-width="400" mini-height="200" mini-load="核销订单" href="<?php echo smarty_function_link(array('ctl'=>'biz/order/dialog','args'=>$_smarty_tpl->tpl_vars['item']->value['order_id']),$_smarty_tpl);?>
" class="btn btn-success">核销</a>
                <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:cancel','arg0'=>$_smarty_tpl->tpl_vars['item']->value['order_id']),$_smarty_tpl);?>
" mini-act="confirm:您确定要取消订单吗" class="btn btn-success" title="取消订单">取消订单</a>
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
                <tr class="bottom">
                    <td colspan="3"><a class="print_btns" href="javascript:void(0);"  rel="<?php echo smarty_function_link(array('ctl'=>'biz/order/porder','arg0'=>$_smarty_tpl->tpl_vars['item']->value['order_id']),$_smarty_tpl);?>
" target="_self">打印小票</a></td> 
                </tr>
            </table>
        </td>
        </tr>
        <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
        <tr><td colspan="20"><div class="alert alert-info">暂无待配送订单</div></td></tr>
        <?php } ?>
        <tr>
    </table>
    </form>
    <div class="page-bar">
            <table>
                <!--<tr>
                    <td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
                    <td class="left">
                        <a action="<?php echo smarty_function_link(array('ctl'=>'biz/order:peisong'),$_smarty_tpl);?>
"  mini-submit="#items-form" class="btn btn-success" title="批量配送">批量配送</a>
                        <a action="<?php echo smarty_function_link(array('ctl'=>'biz/order:cancel'),$_smarty_tpl);?>
" mini-submit="#items-form" mini-act="confirm:您确定要批量取消订单吗" class="btn btn-success" title="批量取消订单">批量取消订单</a>
                    </td>
                    <td><div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div></td>
                </tr>-->
            </table>
        </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script>
    $(document).ready(function(){
        $(".view_btn").click(function(){
            $('.tr_'+$(this).attr('rel')).slideToggle();
        })
        
        $(".print_btns").click(function(){
            var url = $(this).attr('rel');
            layer.open({
                type: 2,
                title: '打印小票',
                shadeClose: true,
                shade: 0.8,
                area: ['350px', '60%'],
                content: url 
            }); 
        })
        
    })


    function peisong(id) {
        var link = "<?php echo smarty_function_link(array('ctl'=>'biz/order:peisong','args'=>'temp'),$_smarty_tpl);?>
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