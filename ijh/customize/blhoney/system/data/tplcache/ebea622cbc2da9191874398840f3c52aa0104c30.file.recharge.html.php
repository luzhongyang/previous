<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 11:52:03
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/money/recharge.html" */ ?>
<?php /*%%SmartyHeaderCode:83020943657b3df636aa6e8-73214711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebea622cbc2da9191874398840f3c52aa0104c30' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/money/recharge.html',
      1 => 1470380643,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '83020943657b3df636aa6e8-73214711',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'money_pack' => 0,
    'k' => 0,
    'money' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b3df636f80e6_46944948',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b3df636f80e6_46944948')) {function content_57b3df636f80e6_46944948($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable('我的充值', null, 0);?>
<!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/money:index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title">
    	在线充值
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
	<div class="minePay">
        <ul class="form_list_box mt10">
           <?php  $_smarty_tpl->tpl_vars['money'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['money']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['money_pack']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['money']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['money']->key => $_smarty_tpl->tpl_vars['money']->value){
$_smarty_tpl->tpl_vars['money']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['money']->key;
 $_smarty_tpl->tpl_vars['money']->index++;
?>
            <li class="recharge">
                <label class="radioLabel radioLabel1">
                    <p class="fl">充值<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
元送<span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['money']->value;?>
元</span></p>
                    <span class="fr radioInt radioInt1 <?php if ($_smarty_tpl->tpl_vars['money']->index==0){?>on<?php }?>" amount="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" ><input name="recharge" type="radio"></span>
                </label> 
            </li>
            <?php } ?>
        </ul>
        <div>
        	<ul class="payWay">
            	<li><p class="bt">支付方式</p></li>
                <li>
                    <label class="radioLabel radioLabel2">
                        <div class="fl">
                            <em class="ico_1"></em>
                            <p class="overflow_clear bt" >支付宝</p>
                            <p class="overflow_clear black9">推荐已安装支付宝客户端的用户使用</p>
                        </div>
                        <span class="fr radioInt radioInt2 on" paycode="alipay"><input name="recharge" type="radio"></span>
                        <div class="clear"></div>
                    </label>
                </li>
                <li>
                    <label class="radioLabel radioLabel2">
                        <div class="fl">
                            <em class="ico_3"></em>
                            <p class="overflow_clear bt" >微信</p>
                            <p class="overflow_clear black9">推荐已安装微信客户端的用户使用</p>
                        </div>
                        <span class="fr radioInt radioInt2" paycode="wxpay"><input name="recharge" type="radio"></span>
                        <div class="clear"></div>
                    </label>
                </li>
            </ul>
            <div class="long_btn_box"><a href="javascript:paymoney();" class="long_btn" >确认充值</a></div>
        </div>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
$(document).ready(function() {
    /*单选项选择开始*/
    $('.radioLabel1').click(function(){
        $('.radioInt1').removeClass('on');
        $(this).find('.radioInt1').addClass('on');
    });
    $('.radioLabel2').click(function(){
        $('.radioInt2').removeClass('on');
        $(this).find('.radioInt2').addClass('on');
    });
    /*单选项选择结束*/
   
});

function paymoney () {
    var code = $(".radioInt2.on").attr("paycode");
    var amount = $(".radioInt1.on").attr("amount");
    var link = "<?php echo smarty_function_link(array('ctl'=>'trade/payment:money','code'=>'codes','amount'=>'amounts'),$_smarty_tpl);?>
";
    window.location.href = link.replace('codes',code).replace('amounts',amount);
}
    
    

</script>

</body>
</html>
<?php }} ?>