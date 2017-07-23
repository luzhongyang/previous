<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:11:18
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/order/index.html" */ ?>
<?php /*%%SmartyHeaderCode:94985145557b2845619a297-00868772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1efb3751467bed6d03488ac4091d9f87a1be33fe' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/order/index.html',
      1 => 1470380633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '94985145557b2845619a297-00868772',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'status' => 0,
    'var' => 0,
    'shop' => 0,
    'payments' => 0,
    'val' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b284562f7c54_36471339',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b284562f7c54_36471339')) {function content_57b284562f7c54_36471339($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<div class="zxTabs">
    <ul>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:index'),$_smarty_tpl);?>
" class="on">待接订单</a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:spend'),$_smarty_tpl);?>
">核销订单</a>
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
            <th class="w-300">操作</th>
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
                <a href="javascript:accept(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
,0);" class="btn btn-success" title="接单">接单</a>
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
                <!--<tr class="bottom">
                    <td colspan="3"><a href="javascript:printorder(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
);" target="_self">打印小票</a></td> 
                </tr>-->
            </table>
        </td>
        </tr>
        <div class="stamp stamp_list_<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
" id="stamp_list_<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
">
            <div class="stamp_list_box">
                <div class="stamp_list">
                    <div class="print_btn"><a href="javascript:void(0);" class="print_<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
">立即打印</a></div>
                    <div class="stamp_list_cont">
                         <ul>
                            <li class="list_cont">
                                <p>店铺：<?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
</p>
                            </li>
                            <li class="list_cont">
                                <p>订单时间：<?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline'],'m-d H:i');?>
</p>
                                <p>支付方式：<?php if ($_smarty_tpl->tpl_vars['item']->value['online_pay']==1){?><?php echo $_smarty_tpl->tpl_vars['payments']->value[$_smarty_tpl->tpl_vars['item']->value['pay_code']];?>
<?php }else{ ?>餐到付款<?php }?>（<?php if ($_smarty_tpl->tpl_vars['item']->value['pay_status']==1){?>已付<?php }else{ ?>未付<?php }?>）</p>
                            </li>
                            <li class="list_cont">
                                <p>顾客留言：<?php echo $_smarty_tpl->tpl_vars['item']->value['note'];?>
</p>
                            </li>
                            <li class="list_cont">
                                <p>商品详情：</p>
                                <ul class="list_cd">
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                        <li><span class="bt"><?php echo $_smarty_tpl->tpl_vars['val']->value['product_name'];?>
</span><span class="num">×<?php echo $_smarty_tpl->tpl_vars['val']->value['product_number'];?>
</span><span class="price">￥<?php echo $_smarty_tpl->tpl_vars['val']->value['product_price'];?>
</span></li>
                                    <?php } ?>
                                    <li><span class="bt">打包费</span><span class="num"></span><span class="price"><?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
</span></li>
                                    <li><span class="bt">运费</span><span class="num"></span><span class="price"><?php echo $_smarty_tpl->tpl_vars['item']->value['freight'];?>
</span></li>
                                </ul>
                            </li>
                            <li class="list_cont">
                                <p>商品合计：￥<?php echo $_smarty_tpl->tpl_vars['item']->value['product_price'];?>
</p>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['first_youhui']>0){?><p>首单立减：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['first_youhui'];?>
</p><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['order_youhui']>0){?><p>下单立减：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['order_youhui'];?>
</p><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['hongbao']>0){?><p>红包抵扣：-￥<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao'];?>
</p><?php }?>
                                <p>结算价：<big>￥<?php echo $_smarty_tpl->tpl_vars['item']->value['js_price'];?>
</big></p>
                            </li>
                        </ul>
                        <div class="stamp_list_infor">
                            <p>顾客信息：</p>
                            <P class="big_font"><?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>
</P>
                            <P class="big_font"><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</P>
                            <P class="big_font"><?php echo $_smarty_tpl->tpl_vars['item']->value['house'];?>
</P>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mask_bg"></div>
        </div>
        <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
        <tr><td colspan="20"><div class="alert alert-info">暂无客户订单</div></td></tr>
        <?php } ?>
        <tr>
            </table>
        </form>
        <div class="page-bar">
            <table>
                <tr>
                    <td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
                    <td class="left">
                        <a action="<?php echo smarty_function_link(array('ctl'=>'biz/order:accept','pei_type'=>0),$_smarty_tpl);?>
"  mini-submit="#items-form" class="btn btn-success" title="批量接单">批量接单</a>
                        <a action="<?php echo smarty_function_link(array('ctl'=>'biz/order:cancel'),$_smarty_tpl);?>
" mini-submit="#items-form" mini-act="confirm:您确定要批量取消订单吗" class="btn btn-success" title="批量取消订单">批量取消订单</a>
                    </td>
                    <td><div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div></td>
                </tr>
            </table>
        </div>
        </div>
        <?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <script>
            $(document).ready(function () {
                $(".view_btn").click(function () {
                    $('.tr_' + $(this).attr('rel')).slideToggle();
                })
                
                $(".stamp .mask_bg").click(function(){
                    $(".stamp").hide();
                })
            })

            function cancel(id) {
                var link = "<?php echo smarty_function_link(array('ctl'=>'biz/order:cancel','arg0'=>'temp'),$_smarty_tpl);?>
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


            function accept(id,type) {
                var link = "<?php echo smarty_function_link(array('ctl'=>'biz/order:accept','arg0'=>'temp','arg1'=>'oooo'),$_smarty_tpl);?>
";
                jQuery.ajax({
                    url: link.replace('temp', id).replace('oooo',type),
                    async: true,
                    dataType: 'json',
                    type: 'POST',
                    success: function (ret) {
                        if (ret.error > 0) {
                            layer.msg(ret.message);
                        } else {
                            layer.msg(ret.message);
                            if(ret.is_one == 1){
                                setTimeout(function () {
                                    window.location.href="<?php echo smarty_function_link(array('ctl'=>'biz/order:spend'),$_smarty_tpl);?>
";
                                }, 1000);
                            }else{
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                });
            }
            
            function printorder(order_id){
                
                $(".stamp_list_"+order_id).show();
                $(".print_"+order_id).click(function(){
                    var link = "<?php echo smarty_function_link(array('ctl'=>'biz/order:porder','args'=>'__order_id'),$_smarty_tpl);?>
";
                     $.get(link.replace('__order_id',order_id),function (ret) {
                       $('#abc').html(ret);
                       $('#abc').printArea();
                    },'html')
                })

            }
            
            
            
            
            
        </script>
        
        
        <span  id='abc'></span><?php }} ?>