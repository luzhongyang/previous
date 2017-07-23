<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:48:23
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/mall/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:39432778057b513e7079ea5-34965588%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0b3b04616a5fe17601b35cb001285a241fee881' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/mall/detail.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '39432778057b513e7079ea5-34965588',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b513e70d8676_38540393',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b513e70d8676_38540393')) {function content_57b513e70d8676_38540393($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
    
<header>
    <i class="left"><a href="" link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
        商品详情
    </div>
    <i class="right"></i>
</header>
<section class="page_center_box">
    <div class="mineIntegral_details">
        <div class="mineIntegral_details_infor">
            <div class="img"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['photo'];?>
" width="280" height="200" /></div>
            <div class="infor">
                <p class="bt"><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</p>
                <p class="black9 mt5"><em></em><span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['detail']->value['jifen'];?>
</span> 积分<span class="ml10">剩余数量：<?php echo $_smarty_tpl->tpl_vars['detail']->value['sku'];?>
</span></p>
            </div>
        </div>
        <div class="dianpu_list mb10">
            <div class="wz" style="margin-left:0;">
                <p class="maincl"><big><b><?php echo $_smarty_tpl->tpl_vars['detail']->value['price'];?>
</b></big>元</p>
                <div class="num_operate dianpu_num">
                    <span class="reduce" quantity="-" pid="<?php echo $_smarty_tpl->tpl_vars['detail']->value['product_id'];?>
" num="0" onClick="dec(this);">-</span>
                    <input type="text" value="0" class="text_box" id="text_box_num">
                    <span class="add" quantity="+" pid="<?php echo $_smarty_tpl->tpl_vars['detail']->value['product_id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
" price="<?php echo $_smarty_tpl->tpl_vars['detail']->value['price'];?>
" jifen="<?php echo $_smarty_tpl->tpl_vars['detail']->value['jifen'];?>
" sku="<?php echo $_smarty_tpl->tpl_vars['detail']->value['sku'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['detail']->value['photo'];?>
" onClick="addcart(this);">+</span>
                </div>
            </div>
        </div>
        <h2 class="">商品详情</h2>
        <div class="details">
            <?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>

        </div>
    </div>
</section>
<!--底部购物车-->  
<section class="dianpu_footer">
    <div class="dianpu_fot_shop">
        <div class="fl">
            <div class="fl spcart"><i id='num'></i></div>
            <div class="fl zjia" >合计：<span class="maincl big" id='total1'></span></div>
        </div>
        <div class="fr"><a href="javascript:ordersub();" class="pub_btn">立即购买</a></div>
        <div class="clear"></div>
    </div>
    <div class="dianpu_spin none">
        <h2><a href="javascript:void(0);" class="empty black9" >关闭</a></h2>
        <div></div>
    </div>
    <div class="dianpu_shop_zzc"></div>
</section>
<!--JS 购物车-->
<script type="text/javascript">
    $('.dianpu_fot_shop .spcart').click(function(){
        $('.dianpu_footer .dianpu_spin').slideToggle();
        if($('.dianpu_footer .dianpu_shop_zzc').css('display')=='none'){
            $('.dianpu_shop_zzc').show();
        }
        else{
            $('.dianpu_shop_zzc').hide();
        }
    });//底部购物车弹出窗结束
    $('.dianpu_shop_zzc').click(function(){
        $('.dianpu_footer .dianpu_spin').hide();
        $('.dianpu_shop_zzc').hide();
    });//底部购物车弹出窗结束


    if(localStorage['mall_detail']) {
        $('.gobackIco').attr('href', localStorage['mall_detail']);
    }

    function ordersub() {
        localStorage['mall_ordersub'] = window.location.href;
        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'mall:ordersub'),$_smarty_tpl);?>
";
    }
    var price = null;
    var product_id = parseInt("<?php echo $_smarty_tpl->tpl_vars['detail']->value['product_id'];?>
");

    //初始化购物车
    ~function () {
        window.mall.init();
        getlist(product_id);
    }();
    
    // 显示底部购物车列表
    function getlist(product_id) {
        var str_top = ''; var str_bottom = '';var num = null;
        var cart = window.mall.getcart();
        
        for(var pid in cart) {
            if(product_id == pid) {
                price = parseFloat(cart[pid]['price']*cart[pid]['num']).toFixed(2);
                num = parseInt(cart[pid]['num']);
                str_bottom += '<div class="dianpu_list dianpu_list_bt">';
                str_bottom += '<h3>'+decodeURIComponent(cart[pid]['title'])+'<span class="maincl">￥'+parseFloat(cart[pid]['price']*cart[pid]['num']).toFixed(2)+'</span></h3>';
                str_bottom += '<div class="num_operate dianpu_num">';
                str_bottom += '<span class="reduce" quantity="-" pid="'+cart[pid]['product_id']+'" num="'+cart[pid]['num']+'" onClick="dec(this);">-</span>';
                str_bottom += '<input type="text" value="'+cart[pid]['num']+'" class="text_box">';
                str_bottom += '<span class="add" quantity="+" pid="'+cart[pid]['product_id']+'" title="'+decodeURIComponent(cart[pid]['title'])+'" price="'+cart[pid]['price']+'" jifen="'+cart[pid]['jifen']+'"  sku="'+cart[pid]['sku']+'" photo="'+cart[pid]['photo']+'" onClick="addcart(this);">+</span>';
                str_bottom += '</div>';
            }
        }  
        

        if(num > 0) {
            $('#text_box_num').val(num);
            $('#num').text(num);
            $('.reduce').attr('num', num);
        }else {
            $('#num').text(0);
        }
        if(price > 0) {
            $('#total1').text(price+'元');
        }else {
            $('#total1').text('0.00元');
        }
        $('.dianpu_spin div').html(str_bottom);
    }

    // 加号
    function addcart(o) {
        var data = {}; 
        data['product_id'] = $(o).attr('pid');
        data['title'] = encodeURIComponent($(o).attr('title'));
        data['price'] = $(o).attr('price');
        data['jifen'] = $(o).attr('jifen');
        data['sku'] = sku = $(o).attr('sku');
        data['photo'] = $(o).attr('photo');
        window.mall.addcart(data);
        getlist(data['product_id']);
    }

    // 减号
    function dec(o) {
        if($(o).attr('num') == 1) {
            return false;
        }
        window.mall.dec($(o).attr('pid'));
        getlist($(o).attr('pid'));
    }

    $(".empty").click(function () {
        $('.dianpu_footer .dianpu_spin').slideToggle();
        $('.dianpu_shop_zzc').hide();
    })

</script>
<!--底部购物车end--> 
</body>
</html>
<?php }} ?>