<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:45:48
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/order/items.html" */ ?>
<?php /*%%SmartyHeaderCode:160192928357b2c4acba0e29-94728872%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da9feb040da6e2acc5757202a3c8784b54d53da1' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/order/items.html',
      1 => 1470380643,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160192928357b2c4acba0e29-94728872',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'v' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c4acc5bda2_75865213',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c4acc5bda2_75865213')) {function content_57b2c4acc5bda2_75865213($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
    <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title">
    	我的订单
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<style type="text/css">
.tuan_no{ margin:0.3rem 0; text-align:center; line-height:0.3rem;}
.tuan_no h2{ font-weight:normal; font-size:0.18rem;}
.tuan_no .iconBg{width:0.8rem; height:0.8rem; margin:0.1rem 0; background:#F7F7F7; border:0.02rem solid #F7F7F7; display:inline-block; border-radius:0.8rem; text-align:center;}
</style>
<section class="page_center_box">
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
    <div class="daizhifu mineOrd_state_box mt10">
        <div class="daizhifu-cont">
            <div class="daizhifu-tit pad_l10">
            <?php if ($_smarty_tpl->tpl_vars['v']->value['order_status']==0&&$_smarty_tpl->tpl_vars['v']->value['pay_status']==0){?>
            订单待支付
            <?php }elseif($_smarty_tpl->tpl_vars['v']->value['order_status']==0&&$_smarty_tpl->tpl_vars['v']->value['pay_status']==1){?>
            订单已支付
            <?php }elseif($_smarty_tpl->tpl_vars['v']->value['order_status']==1&&$_smarty_tpl->tpl_vars['v']->value['pay_status']==1){?>
            商家已接单
            <?php }elseif($_smarty_tpl->tpl_vars['v']->value['order_status']==8&&$_smarty_tpl->tpl_vars['v']->value['comment_status']==0){?>
            订单待评价
            <?php }elseif($_smarty_tpl->tpl_vars['v']->value['order_status']==8&&$_smarty_tpl->tpl_vars['v']->value['comment_status']==1){?>
            订单已评价
            <?php }elseif($_smarty_tpl->tpl_vars['v']->value['order_status']==-1){?>
            订单已取消
            <?php }?>
            <span class="black9 font_size14">-<?php echo $_smarty_tpl->tpl_vars['v']->value['ordered_time'];?>
</span>
            <?php if ($_smarty_tpl->tpl_vars['v']->value['comment_status']==1){?><a href="javascript:delorder(<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
);" class="tong fr"></a><?php }?>
            </div>
            <ul>
                <li class="daizhifu-list pad_l10 pad_r10 pad_b10">
                    <div class="fl tupian"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['shop']['logo'];?>
"/></div>
                    <div class="wenzi ">
                        <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['shop']['shop_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'shop:detail','args'=>$_tmp1),$_smarty_tpl);?>
" class="font_size14"><?php echo $_smarty_tpl->tpl_vars['v']->value['shop']['title'];?>
</a>
                        <div class="font_size14 mt10">
                            <div class="fl black9"><?php echo $_smarty_tpl->tpl_vars['v']->value['product_number'];?>
项服务</div>
                            <div class="fr black9"><span class="maincl">￥<big><?php echo $_smarty_tpl->tpl_vars['v']->value['amount'];?>
</big></span>起</div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </li>
            </ul>
            <div class="pad_l10 chulidingdan pad_r10">
                <div class="chuli-list ">
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['pay_status']==0&&$_smarty_tpl->tpl_vars['v']->value['order_status']==0){?>
                    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
,'chargeback');" class="btn">取消订单</a>
                    <?php }?>
                    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
,'detail');" class="btn">查看订单</a>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['order_status']==0&&$_smarty_tpl->tpl_vars['v']->value['pay_status']==0){?>
                    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
,'pay');" class="btn buton">支付订单</a>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['order_status']==8&&$_smarty_tpl->tpl_vars['v']->value['comment_status']==0){?>
                    <a href="javascript:set(<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
,'comment');" class="btn buton">评价订单</a>
                    <?php }?>
                 </div>
            </div>
        </div>
    </div>
    <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
        <div class="tuan_no"><div class="iconBg"><i class="ico2"></i> </div><h2>你暂无预约订单</h2></div>
    <?php } ?>

</section>

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
                    setTimeout(function(){window.location.reload();},1000);
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
                        setTimeout(function(){window.location.reload();},1000);
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

</script><?php }} ?>