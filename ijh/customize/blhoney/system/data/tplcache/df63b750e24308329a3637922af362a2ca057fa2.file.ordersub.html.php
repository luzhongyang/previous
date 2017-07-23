<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 09:48:34
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/mall/ordersub.html" */ ?>
<?php /*%%SmartyHeaderCode:180358808357b513f2e86522-46128283%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df63b750e24308329a3637922af362a2ca057fa2' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/mall/ordersub.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '180358808357b513f2e86522-46128283',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'maddr' => 0,
    'total_price' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b513f2edf625_71196285',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b513f2edf625_71196285')) {function content_57b513f2edf625_71196285($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
    <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
	<i class="left"><a href="#" class="gobackIco"></a></i>
    <div class="title">
    	提交订单
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
	<div class="order_confirm_infor mb10">
    	<div class="ico fl"></div>
        <?php if (empty($_smarty_tpl->tpl_vars['maddr']->value)){?>
        <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/addr/create'),$_smarty_tpl);?>
">
            <div class="wz">
                <p class="bt">您还没有设置地址</p>
                <p>点击立即添加地址</p>
            </div>
        </a>
        <?php }else{ ?>
        <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/addr/index','order'=>2),$_smarty_tpl);?>
">
            <div class="wz" id="addr_info">
                <input type="hidden" id="addr" name="params[addr_id]" value="<?php echo $_smarty_tpl->tpl_vars['maddr']->value['addr_id'];?>
"/>
                <p class="bt"><span class="contact"><?php echo $_smarty_tpl->tpl_vars['maddr']->value['contact'];?>
</span> <span class="mobile"><?php echo $_smarty_tpl->tpl_vars['maddr']->value['mobile'];?>
</span></p>
                <p class="house"><?php echo $_smarty_tpl->tpl_vars['maddr']->value['house'];?>
</p>
            </div>
        </a>
        <?php }?>
    </div>
	<div class="mb10 mall_dianpu_list"></div>
	<div class="order_details_nr">
        <ul class="form_list_box">
            <li class="list last">
            	<div class="fl">合计</div>
                <div class="fr"><p class="maincl total" id="total1"><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
元</p></div>
            </li>
        </ul>
    </div>
</section>
<footer>
    <div class="ord_tousu">
		<p class="fl pad_t10">支付：<span class="maincl"><big id="total2"><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
</big>元</span></p>
		<a href="javascript:createorder();" class="fr pub_btn">提交</a></div>
</footer>

<script>
$(document).ready(function() {

});

if(localStorage['mall_ordersub']) {
    $('.gobackIco').attr('href', localStorage['mall_ordersub']);
}



//初始化购物车
~function () {
    window.mall.init();
    var totalprice = parseFloat(window.mall.totalprice()).toFixed(2);
    $('#total1').text(totalprice+'元');
    $('#total2').text(totalprice);
    getlist();
}();

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
    var totalprice = parseFloat(window.mall.totalprice()).toFixed(2);
    $('#total1').text(totalprice+'元');
    $('#total2').text(totalprice);
    getlist();
}

// 减号
function dec(o) {
    if($(o).attr('num') == 1) {
        return false;
    }
    var product_id = $(o).attr('pid');
    window.mall.dec($(o).attr('pid'));
    var totalprice = parseFloat(window.mall.totalprice()).toFixed(2);
    $('#total1').text(totalprice+'元');
    $('#total2').text(totalprice);
    getlist();
}

// 删除单个商品
function del(o) {
    // 当购物车长度为1时，通知用户至少选择一个商品
    var cart_len = getObjLen(window.mall.getcart());
    if(cart_len == 1) {
        layer.open({content: '请至少选择一个商品',time: 2});
        return false;
    }
    
    var product_id = $(o).attr('pid');
    window.mall.dec(product_id, 'null');
    var totalprice = parseFloat(window.mall.totalprice()).toFixed(2);
    $('#total1').text(totalprice+'元');
    $('#total2').text(totalprice);
    getlist();
}


// 展示购物车商品列表
function getlist() {
    var cart = window.mall.getcart();
    var str = '';
    for(var pid in cart) {
        str += '<div class="dianpu_list">';
        str += '<span class="close" pid="'+pid+'" onClick="del(this);">×</span>';
        str += '<div class="img fl"><a href="javascript:void(0);"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/'+cart[pid]['photo']+'" width="100" height="100" /></a></div>';
        str += '<div class="wz">';
        str += '<h3>'+decodeURIComponent(cart[pid]['title'])+'</h3>';
        str += '<p class="maincl">￥'+cart[pid]['price']+'<span class="ml10 black9">'+cart[pid]['jifen']+'积分</span></p>';
        str += '<p class="black9">剩余数量：'+cart[pid]['sku']+'</p>';
        str += '<div class="num_operate dianpu_num">';
        str += '<span class="reduce" quantity="-" pid="'+cart[pid]['product_id']+'" num="'+cart[pid]['num']+'" onClick="dec(this);">-</span>';
        str += '<input type="text" value="'+cart[pid]['num']+'" class="text_box">';
        str += '<span class="add" quantity="+" pid="'+cart[pid]['product_id']+'" title="'+decodeURIComponent(cart[pid]['title'])+'" price="'+cart[pid]['price']+'" jifen="'+cart[pid]['jifen']+'"  sku="'+cart[pid]['sku']+'"  photo="'+cart[pid]['photo']+'" onClick="addcart(this);">+</span>';
        str += '</div>';
        str += '</div>';
        str += '</div>';   
    }
    $('.mall_dianpu_list').html(str);
}

function createorder() {
    localStorage['order_pay'] = "<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:orderitems'),$_smarty_tpl);?>
";
    var addr_id = $('#addr').val();
    jQuery.ajax({  
        url: "<?php echo smarty_function_link(array('ctl'=>'mall:create'),$_smarty_tpl);?>
", 
        async: true,  
        dataType: 'json',  
        data: {"addr_id":addr_id},
        type: 'POST',   
        success: function (ret) { 
            if(ret.error > 0){
                layer.open({content: ret.message,time: 2});
                return false;
            }else{
                layer.open({content: ret.message,time: 2});
                var order_id = ret.data.order_id;
                var link_pay = "<?php echo smarty_function_link(array('ctl'=>'order/pay','arg0'=>'temp1','arg1'=>'mall'),$_smarty_tpl);?>
";
                setTimeout(function(){window.location.href = link_pay.replace('temp1', order_id);},2000); 
            }
        },error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert(errorThrown); 
        },
    });
}

</script>
</body>
</html><?php }} ?>