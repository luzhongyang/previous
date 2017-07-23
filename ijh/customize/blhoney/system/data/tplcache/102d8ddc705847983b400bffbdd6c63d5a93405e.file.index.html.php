<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 16:00:05
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/mall/index.html" */ ?>
<?php /*%%SmartyHeaderCode:101733644457b2c805ade050-02081605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '102d8ddc705847983b400bffbdd6c63d5a93405e' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/mall/index.html',
      1 => 1471229571,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101733644457b2c805ade050-02081605',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cates' => 0,
    'v' => 0,
    'pager' => 0,
    'items' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c805b926c3_56127459',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c805b926c3_56127459')) {function content_57b2c805b926c3_56127459($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_adv')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.adv.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
    	商城
    </div>
    <i class="right"></i>
</header>
<section class="page_center_box">
	<div class="banner">
        <div class="flexslider">  
            <ul class="slides">  
                <?php echo smarty_function_adv(array('id'=>"2",'name'=>"首页轮播"),$_smarty_tpl);?>

            </ul>  
        </div>
    </div>
    <div class="mineIntegral_link_box mb10">
        <ul>
            <li class="mineIntegral_link"><a href="javascript:integral();" link-load=""><em class="ico_1"></em>我的美币</a></li>
            <li class="mineIntegral_link"><a href="javascript:mallorder();"  link-load=""><em class="ico_2"></em>商城订单</a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="mineIntegral_menu mb10">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <li class="list">
            	<a href="<?php echo smarty_function_link(array('ctl'=>'mall/index','args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
"><i class="ico_2" style="background:rgba(0, 0, 0, 0) url(<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
) no-repeat scroll center top / 100% auto;"></i>
                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                </a>
            </li>
            <?php } ?>
            <li class="list">
                <a href="<?php echo smarty_function_link(array('ctl'=>'mall/items'),$_smarty_tpl);?>
" link-load="">
            	<i class="ico_8"></i>
                <p>全部</p>
                </a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="mineIntegral_list_box">
        <ul>
        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
         	<li class="mineIntegral_list">
            	<div class="nr">
                    <div class="pub_img"><a href="javascript:detail(<?php echo $_smarty_tpl->tpl_vars['v']->value['product_id'];?>
);"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" width="280" height="200" /><span class="tag"><?php echo $_smarty_tpl->tpl_vars['v']->value['jifen'];?>
美币</span></a></div>
                    <div class="pub_wz">
                    	<p class="bt"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                    	<p class="black9">支付<span class="maincl"><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
元</span><a pid="<?php echo $_smarty_tpl->tpl_vars['v']->value['product_id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
" price="<?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
" jifen="<?php echo $_smarty_tpl->tpl_vars['v']->value['jifen'];?>
"  sku="<?php echo $_smarty_tpl->tpl_vars['v']->value['sku'];?>
" cateid="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" photo="<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" href="javascript:void(0);" class="pub_btn fr" onClick="addcart(this);">+</a></p>
                    </div>
                </div>
            </li>  
	    </ul>
        <?php } ?>
        <div class="clear"></div>
    </div>
    <!--<div class="mineIntegral_list_box">
            <ul>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['product']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value['closed']==0&&$_smarty_tpl->tpl_vars['v']->value['sku']>0){?>
    	    <li class="mineIntegral_list">
            	<div class="nr">
                    <a href="<?php echo smarty_function_link(array('ctl'=>'mall/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['product_id']),$_smarty_tpl);?>
" link-load="">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" width="280" height="200" />
                    <p class="bt"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                    <p class="black9"><span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['v']->value['jifen'];?>
</span>美币<a href="<?php echo smarty_function_link(array('ctl'=>'mall/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['product_id']),$_smarty_tpl);?>
" link-load="" class="pub_btn fr">兑换</a></p>
                    </a>
                </div>
            </li>
            <?php }?>
            <?php } ?>
	    </ul>
        <div class="clear"></div>
    </div>-->
</section>
<!--浮动购物车-->
<div class="mallCart">
    <a href="javascript:ordersub();">
	<img src="/themes/default/static/images/cart.png">
    <span class="num" id="number">1</span>
    </a>
</div>
<!--浮动购物车end-->

<script type="text/javascript">
    $(document).ready(function () {
         $('#l4').addClass('on');
        $('.flexslider').flexslider({
            directionNav: true,
            pauseOnAction: false,
        });//轮播js结束

        $('.list').removeClass('on');
        $('#l4').addClass('on');
    });
</script>

<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<script>
function integral() {
    localStorage['ucenter_integral_index'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter/integral'),$_smarty_tpl);?>
"; 
}
function mallorder() {
    localStorage['ucenter_mall_orderitems'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:orderitems'),$_smarty_tpl);?>
"; 
}
function detail(order_id) {
    var link = "<?php echo smarty_function_link(array('ctl'=>'mall:detail','args'=>'temp'),$_smarty_tpl);?>
"
    localStorage['mall_detail'] = window.location.href;
    window.location.href = link.replace('temp', order_id);
}
function ordersub() {
    localStorage['mall_ordersub'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'mall:ordersub'),$_smarty_tpl);?>
";
}

// 添加商品到购物车
function addcart(o) {
    var data = {}; 
    data['product_id'] = $(o).attr('pid');
    data['title'] = encodeURIComponent($(o).attr('title'));
    data['price'] = $(o).attr('price');
    data['jifen'] = $(o).attr('jifen');
    data['sku'] = sku = $(o).attr('sku');
    data['photo'] = $(o).attr('photo');
    window.mall.addcart(data);
    $("#number").text(window.mall.count());
}

//初始化购物车
~function () {
    window.mall.init();
    var count = parseInt(window.mall.count(),10);
    $("#number").text(count);
}();
</script><?php }} ?>