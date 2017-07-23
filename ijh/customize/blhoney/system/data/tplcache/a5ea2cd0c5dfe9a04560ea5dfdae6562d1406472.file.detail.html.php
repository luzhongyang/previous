<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:45:51
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/order/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:159735315457b2c4afb4cd08-02385206%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5ea2cd0c5dfe9a04560ea5dfdae6562d1406472' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/order/detail.html',
      1 => 1471142916,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159735315457b2c4afb4cd08-02385206',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
    'pager' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c4afc54005_09534025',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c4afc54005_09534025')) {function content_57b2c4afc54005_09534025($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
    <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/order:items'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title">
    	订单详情
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
    <div class="ty-daizhifu-tit pad_l10 bder_b">
    <?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==0&&$_smarty_tpl->tpl_vars['item']->value['pay_status']==0){?>
    订单待支付
    <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==0&&$_smarty_tpl->tpl_vars['item']->value['pay_status']==1){?>
    订单已支付
    <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==1&&$_smarty_tpl->tpl_vars['item']->value['pay_status']==1){?>
    商家已接单
    <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==8&&$_smarty_tpl->tpl_vars['item']->value['comment_status']==0){?>
    订单待评价
    <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==8&&$_smarty_tpl->tpl_vars['item']->value['comment_status']==1){?>
    订单已评价
    <?php }elseif($_smarty_tpl->tpl_vars['item']->value['order_status']==-1){?>
    订单已取消
    <?php }?>
    <span class="black9 font_size14">-<?php echo $_smarty_tpl->tpl_vars['item']->value['ordered_time'];?>
</span></div>
    <div class="meiye-dan mt10 ">
        <div class="pad_l10 pad_r10 meiye-tit">
            <div class="tu-logo fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['shop']['logo'];?>
" width="45" height="45"></div>
            <div class="mingzi"><?php echo $_smarty_tpl->tpl_vars['item']->value['shop']['title'];?>
</div>
            <div class="clear"></div>
            <a href="javascript:shopdetail(<?php echo $_smarty_tpl->tpl_vars['item']->value['shop_id'];?>
);" class="linkIco youxiang"></a>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['item']->value['spend_status']==0){?>
        <div class="yanzheng pad_l10 pad_r10 bder_b mb10">
            <p class="weihe">验证码：<span class="chengse"><?php echo $_smarty_tpl->tpl_vars['item']->value['spend_number'];?>
</span></p>
            <div class="erweima "><div id="qrcodeTable" ></div></div>
            <a href="#" class="dan-daihexiao"></a>
        </div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['item']->value['spend_status']==1){?>
        <div class="yanzheng pad_l10 pad_r10 bder_b mb10">
            <p class="yihe black9">验证码：<?php echo $_smarty_tpl->tpl_vars['item']->value['spend_number'];?>
</p>
            <div class="erweima "><div id="qrcodeTable" ></div></div>
            <a href="#" class="dan-yihexiao"></a>
        </div>
        <?php }?>
        <div class="ding-danjia">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <div class="meifa-cont pad_l10 pad_r10 "> 
                   <div class="fl"><?php echo $_smarty_tpl->tpl_vars['v']->value['product_name'];?>
</div>
                   <div class="fr">￥<?php echo $_smarty_tpl->tpl_vars['v']->value['product_price'];?>
</div>
                   <div class="clear"></div>
            </div>
            <?php } ?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['hongbao']>0){?>
            <div class="meifa-cont pad_l10 pad_r10"> 
               <div class="fl">红包抵扣</div>
               <div class="fr hongse">-<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao'];?>
元</div>
               <div class="clear"></div>
            </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['first_youhui']>0){?>
            <div class="meifa-cont pad_l10 pad_r10"> 
                   <div class="fl">首单优惠</div>
                   <div class="fr hongse">-<?php echo $_smarty_tpl->tpl_vars['item']->value['first_amount'];?>
元</div>
                   <div class="clear"></div>
            </div>
            <?php }?>
            <div class="meifa-cont pad_l10 pad_r10"> 
                   <div class="fl">合计</div>
                   <div class="fr zise"><?php echo $_smarty_tpl->tpl_vars['item']->value['amount'];?>
元</div>
                   <div class="clear"></div>
            </div>
        </div>
    </div>
    <!--订单详情-->
    <div class="dan-xiangqing mt10 pad_l10 pad_r10 bder_b">
        <div class="thetit ">订单详情</div>
        <div class="danhao ">订单号：<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</div>
        <div class="danhao ">联系人：<?php echo $_smarty_tpl->tpl_vars['item']->value['contact'];?>
&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</div>
        <!--<div class="danhao ">联系地址：合肥蜀山区往前路交口222号</div>-->
        <div class="danhao bb-non">支付方式：<?php echo $_smarty_tpl->tpl_vars['item']->value['pay_method'];?>
</div>
    </div>
</section>
<?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==(-1)||($_smarty_tpl->tpl_vars['item']->value['order_status']==8&&$_smarty_tpl->tpl_vars['item']->value['comment_status']==1)){?>
<div class="shanchu_foot">
	<a href="javascript:delorder(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
)" class="shanchucont"><em class="throw"></em><span class="black9 shandiao">删除订单</span></a>
</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==8&&$_smarty_tpl->tpl_vars['item']->value['comment_status']==0){?>
<div class="queren_foot">
    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
,'comment');" class="queren_huo">评价订单</a>
</div>
<?php }?>
<?php if (($_smarty_tpl->tpl_vars['item']->value['order_status']==0&&$_smarty_tpl->tpl_vars['item']->value['pay_status']==0)||($_smarty_tpl->tpl_vars['item']->value['order_status']==0&&$_smarty_tpl->tpl_vars['item']->value['pay_status']==1)){?>
<div class="daizhifu_foot ">
    <div class="pad_l10 pad_r10">
        <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
,'chargeback');" class="daizhifu_xiao fl">取消订单</a>
        <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
,'pay');" class="daizhifu_fu fr">支付订单</a>
        <div class="clear"></div>
    </div>
</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['order_status']==0||$_smarty_tpl->tpl_vars['item']->value['order_status']==5){?>
<div class="quxiao_foot">
    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
,'chargeback');" class="dan-cancel">取消订单</a>
</div>
<?php }?>
</body>
</html>
<script>

function set(order_id, type) {
    var link = "<?php echo smarty_function_link(array('ctl'=>'order:"+type+"','args'=>'temp'),$_smarty_tpl);?>
";
    if(type == 'chargeback') {
        jQuery.ajax({        
            url: link.replace("temp",order_id), 
            async: true,  
            dataType: 'json',
            type: 'POST',   
            success: function (ret) { 
                if(ret.error > 0){
                    layer.open({content: ret.message,time: 2});
                }else{
                    layer.open({content: ret.message,time: 2});
                    setTimeout(function(){window.location.reload();},1500);
                }
            }, 
        });
    }else {
        if(type == 'comment') {
            localStorage['order_comment'] = window.location.href;
        }
        window.location.href = link.replace("temp",order_id);
    }
    
}

function delorder(order_id) {
    layer.open({
        title: '提示',
        content: '您确定要删除订单吗？',
        btn: ['确定', '不了'],
        yes: function(index){
            var link = "<?php echo smarty_function_link(array('ctl'=>'order:delorder','args'=>'temp'),$_smarty_tpl);?>
";
            jQuery.ajax({        
                url: link.replace("temp",order_id), 
                async: true,  
                dataType: 'json',
                type: 'POST',   
                success: function (ret) { 
                    if(ret.error > 0){
                        layer.open({content: ret.message,time: 2});
                    }else{
                        layer.open({content: ret.message,time: 2});
                        setTimeout(function(){window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter/order:items'),$_smarty_tpl);?>
";},1000);
                    }
                    layer.close(index);
                }, 
                error: function (XMLHttpRequest, textStatus, errorThrown) { 
                    alert(errorThrown); 
                },  
            });
        }
    });
}

function shopdetail(shop_id) {
    var link = "<?php echo smarty_function_link(array('ctl'=>'shop:detail','args'=>'temp'),$_smarty_tpl);?>
";
    localStorage['shop_detail'] = window.location.href;
    window.location.href = link.replace('temp', shop_id);
}


$('#qrcodeTable').qrcode({
    render: "canvas",            //渲染方式 table 和 canvas两种
    width: 160,                  //设置宽度  
    height: 160,                 //设置高度  
    typeNumber: -1,              //计算模式 
    correctLevel: 0,             //纠错等级  0,1,2,3 默认为2
    background: "#ffffff",       //背景颜色  
    foreground: "#000000",       //前景颜色 
    text    : '<?php echo $_smarty_tpl->tpl_vars['item']->value['spend_number'];?>
'
}); 

</script><?php }} ?>