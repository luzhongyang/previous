<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 19:47:20
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/order/pay.html" */ ?>
<?php /*%%SmartyHeaderCode:190533232957b2fd484c55d4-71241569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7c25a11a243dfb0fd0d55a6779255a1fbda0f54' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/order/pay.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '190533232957b2fd484c55d4-71241569',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'weixin' => 0,
    'MEMBER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2fd4850f6a9_34578671',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2fd4850f6a9_34578671')) {function content_57b2fd4850f6a9_34578671($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
        <header>
            <i class="left"><a href="" class="gobackIco"></a></i>
            <div class="title">
                在线支付
            </div>
            <i class="right"><a class="" href="#"></a></i>
        </header>
        <section class="page_center_box">
            <div class="minePay">
                <ul class="form_list_box">
                    <li class="recharge last" style="background:#fff4d5; line-height:0.3rem;">
                        <p class="fl pointcl1">订单总价</p>
                        <p class="fr pointcl1">￥<?php echo $_smarty_tpl->tpl_vars['detail']->value['amount'];?>
</p>
                    </li>
                </ul>
                <div>
                    <ul class="payWay">
                        <li><p class="bt fl">第三方支付平台应支付</p><p class="fr bt pointcl1">￥<?php echo $_smarty_tpl->tpl_vars['detail']->value['amount'];?>
</p><div class="clear"></div></li>
                        <li>
                            <label class="radioLabel">
                                <div class="fl">
                                    <em class="ico_1"></em>
                                    <p class="overflow_clear bt">支付宝</p>
                                    <p class="overflow_clear black9">推荐已安装支付宝客户端的用户使用</p>
                                </div>
                                <span class="fr radioInt on"><input name="pay_code" value="alipay" type="radio"></span>
                                <div class="clear"></div>
                            </label>
                        </li>
                        <?php if ($_smarty_tpl->tpl_vars['weixin']->value==1){?>
                        <li>
                            <label class="radioLabel">
                                <div class="fl">
                                    <em class="ico_3"></em>
                                    <p class="overflow_clear bt">微信</p>
                                    <p class="overflow_clear black9">推荐已安装微信客户端的用户使用</p>
                                </div>
                                <span class="fr radioInt"><input name="pay_code" value="wxpay" type="radio"></span>
                                <div class="clear"></div>
                            </label>
                        </li>
                        <?php }?>
                        <li>
                            <label class="radioLabel">
                                <div class="fl">
                                    <em class="ico_4"></em>
                                    <p class="overflow_clear bt">余额支付</p>
                                    <p class="overflow_clear black9">推荐余额足够的用户使用，您的余额<?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['money'];?>
</p>
                                </div>
                                <span class="fr radioInt"><input name="pay_code" value="money" type="radio"></span>
                                <div class="clear"></div>
                            </label>
                        </li>
                    </ul>
                    <div class="long_btn_box"><input type="button" onclick="orderpay();" class="long_btn minePay_show" value="确认支付" /></div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function () {
                /*单选项选择开始*/
                $('.radioLabel').click(function () {
                    $('.radioInt').removeClass('on');
                    $(this).find('.radioInt').addClass('on');
                });
                
                if(localStorage['order_pay']) {
                    $('.gobackIco').attr('href', localStorage['order_pay']);
                }
            });

            function orderpay() {
                pay_code = $('.radioInt.on').find("input[name='pay_code']").val();
                var order_id = "<?php echo $_smarty_tpl->tpl_vars['detail']->value['order_id'];?>
";
                var kind = "<?php echo $_smarty_tpl->tpl_vars['detail']->value['kind'];?>
";
                var link = "<?php echo smarty_function_link(array('ctl'=>'trade/payment/order','arg0'=>'codes','arg1'=>'orders','arg2'=>'kind'),$_smarty_tpl);?>
";
                window.location.href = link.replace('codes', pay_code).replace('orders', order_id).replace('kind', kind);
            }
        </script>
    </body>
</html>
<?php }} ?>