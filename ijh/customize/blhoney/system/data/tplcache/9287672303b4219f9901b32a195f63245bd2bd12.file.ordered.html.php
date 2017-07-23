<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:41:41
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/shop/ordered.html" */ ?>
<?php /*%%SmartyHeaderCode:34374969457b2b5a55e6bb3-26551589%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9287672303b4219f9901b32a195f63245bd2bd12' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/shop/ordered.html',
      1 => 1470380631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34374969457b2b5a55e6bb3-26551589',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'v' => 0,
    'vv' => 0,
    'product_list' => 0,
    'vvv' => 0,
    'pager' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b5a568da16_01016305',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b5a568da16_01016305')) {function content_57b2b5a568da16_01016305($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <script src="/themes/default/static/js/jquery.fly.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/themes/default/static/js/requestAnimationFrame.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
            <div class="title">
                选择预约服务
            </div>
            <i class="right"><a class=""></a></i>
        </header>
        <section class="page_center_box" style="bottom:0.50rem; padding-bottom:0;">
            <div class="dianpu_cont">
          
                <div class="dianpu_left fl">
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                    <div class="box"><h3><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</h3>
                        <ul>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['childrens']){?>
                            <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['vv']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['vv']->index++;
?>
                            <li class="bt <?php if ($_smarty_tpl->tpl_vars['v']->index==0&&$_smarty_tpl->tpl_vars['vv']->index==0){?>on<?php }?>" cateid="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
"> <a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</a></li>
                            <?php } ?>
                            <?php }?>
                        </ul>
                    </div>
                   <?php } ?>
                </div>
        
                <div id="product_items" class="dianpu_right fr">
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                    <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['vv']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['vv']->index++;
?>
                    <div class="dianpu_list_box" >
                        <h2 class="dianpu_list_bt" id="list_title"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
-<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</h2>
                        <?php  $_smarty_tpl->tpl_vars['vvv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vvv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vvv']->key => $_smarty_tpl->tpl_vars['vvv']->value){
$_smarty_tpl->tpl_vars['vvv']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['vvv']->value['cate_id']==$_smarty_tpl->tpl_vars['vv']->value['cate_id']){?>
                        <div class="dianpu_list">
                            <div class="img fl"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['vvv']->value['photo'];?>
" width="100" height="100" /></a></div>
                            <div class="wz">
                                <h3><?php echo $_smarty_tpl->tpl_vars['vvv']->value['title'];?>
</h3>
                                <p class="black9"><span class="maincl">￥<big><?php echo $_smarty_tpl->tpl_vars['vvv']->value['price'];?>
</big></span>起</p>
                                <span class="radioInt"  pid="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['product_id'];?>
" cateid="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['cate_id'];?>
" price="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['price'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['vvv']->value['title'];?>
" ><input type="checkbox"></span>
                            </div>
                        </div>
                        <?php }?>
                        <?php } ?>
                    </div>
                    <?php } ?>                        
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </div>
        </section>
        <section class="dianpu_footer">
            <div class="dianpu_fot_shop">
                <div class="fl">
                    <div class="fl spcart"><i id="num">0</i></div>
                    <div class="fl zjia" >
                        合计：<span class="maincl big"><sbeauty>￥</sbeauty><span id="total_price">0</span></span>
                    </div>
                </div>
                <div class="fr jiesuan"><a id="cart" href="javascript:void(0);" class="pub_btn">立即预约</a></div>
                <div class="clear"></div>
            </div>
            <div class="dianpu_spin none">
                <h2><a href="#" class="empty black9"><em></em>清空所有</a></h2>
                <div>
                    
                </div>
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
    
</script>
<script>
    $(document).ready(function(e) {
        var  public_top = $('.dianpu_left').offset().top; //这个滚动一个条件
        var  list = Array();
        
        $(".dianpu_list_bt").each(function(a){
            list[a] = $(this).offset().top;
        });
        
        var num =  $(".dianpu_left .bt").length;
        
        function gundong(){
            for(i=0;i<num;i++){
                if($(".dianpu_list_bt").eq(i).offset().top <=public_top ){
                    $(".dianpu_left .bt").removeClass('on');
                    $(".dianpu_left .bt").eq(i).addClass('on');
                }
            }       
        }           
        $('.dianpu_right').scroll(function () {  
            gundong();
        });
        
        $('.dianpu_left li').click(function(){
            $(".dianpu_left li").removeClass("on");
            $(this).addClass("on");
        });
        

        
        $(".dianpu_left li").click(function(){              
            var index = $(this).index(".bt");
            $(".dianpu_right").animate({scrollTop: list[index]-public_top+'px'}, 200);
			$(".dianpu_left li").removeClass("on");
			$(this).addClass("on");
        });
        
        $('.dianpu_left .box h3').click(function(){
            var $li = $(this).parent().find('ul li:first');
            var index = $li.index(".bt");
            $(".dianpu_right").animate({scrollTop: list[index]-public_top+'px'}, 200);                        
        });
    });

    var shop_id = "<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
";

    // 选择服务事件
    $(".dianpu_list_box .radioInt").click(function(){
        if($(this).hasClass("on")){
            $(this).parents(".dianpu_list_box").find(".radioInt").removeClass("on");
            $(this).removeClass("on");
        }
        else{
            $(this).parents(".dianpu_list_box").find(".radioInt").removeClass("on");
            $(this).addClass("on");
        }
        addcart(this);
    });
    
    // 设置底部购物车价格、数量值
    function set_status() {
        var min_amount = "<?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
";
        var total = window.beauty.totalprice(shop_id);
        if (total == 0) {
            $('#cart').removeClass("pub_btn");
            $('#cart').attr('href', "javascript:void(0);");
            $('#cart').html("￥" + min_amount + "起");
        } else if (total < min_amount) {
            $('#cart').removeClass("pub_btn");
            $('#cart').attr('href', "javascript:void(0);");
            $('#cart').html("还差￥" + parseFloat(min_amount - total).toFixed(2) + "起");
        } else {
            $('#cart').attr('href', "<?php echo smarty_function_link(array('ctl'=>'order/order','args'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
");
            $('#cart').addClass('pub_btn');
            $('#cart').html("立即预约");
        }
        var count = parseInt(window.beauty.count(shop_id),10);
        var totalprice = parseFloat(total).toFixed(2);
        $("#num").text(count);
        $("#total_price").html(totalprice);
    }
    
    // 添加物品到购物车
    function addcart(o) {
        var data = {};
        var count = 0;
        $("#product_items").find(".radioInt.on").each(function(name, value){
            var index = $(value).attr('pid');
            data[index] = {};
            data[index]['product_id'] =  index;
            data[index]['cate_id']    =  $(value).attr('cateid');
            data[index]['price']      =  $(value).attr('price');
            data[index]['title']      =  encodeURIComponent($(value).attr('title'));
            count += 1;
        }); 
        window.beauty.addcart(shop_id, data, count);
        //alert(window.beauty.count(shop_id));
        $("#num").text(count);
        $("#total_price").html(parseFloat(window.beauty.totalprice(shop_id)).toFixed(2));
        set_status();
        get_list();
        cate_list();
    }
   
    // 清空购物车
    $(".empty").click(function () {
        layer.open({
            title: '温馨提示',
            content: '确定要清空购物车吗？',
            btn: ['确认', '取消'],
            shadeClose: false,
            yes: function () {
                window.beauty.removeby(shop_id);
                $("#num").text(0);
                $("#total_price").html(parseFloat(window.beauty.totalprice(shop_id)).toFixed(2));
                $(".ordernum").val(0);
                set_status();
                get_list();
                cate_list();
                layer.closeAll();
                $('.dianpu_footer .dianpu_spin').slideToggle();
                $('.dianpu_shop_zzc').hide();
                $("#product_items").find(".radioInt.on").removeClass('on');
            }, no: function () {

            }
        });
    })

    function cate_list() {
        var cates = window.beauty.catecount("<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
");
        var str = "";
        $("[id^='cate_num']").find("em").hide();
        for (var cate_id in cates) {
            if (cates[cate_id] > 0) {
                $("#cate_num_" + cate_id + " em").html(cates[cate_id]).show();
            }
        }
    }

    // 获取cookie购物车列表
    function get_list() {
        var goods = window.beauty.getcart();
        var str = "";
        $(".dianpu_spin div").html("");
        goods[shop_id] = goods[shop_id] || {};
        if (typeof (goods[shop_id]['undefined']) == 'undefined') {
            goods[shop_id]['undefined'] = [];
        }else {
            for(var sid in goods) {
                if(sid == shop_id) {
                    for(var index in goods[sid]['undefined']) {
                        if (goods[sid]['undefined']['num'] > 0) {
                            if(goods[sid]['undefined'] != 'num') {
                                if(goods[sid]['undefined'][index]["spec_name"] != undefined) {
                                     str += '<div class="dianpu_list dianpu_list_bt">';
                                    str += '<h3>'+goods[sid]['undefined'][index]["spec_name"]+'<span class="maincl">￥'+goods[sid]['undefined'][index]["price"]+'</span></h3></div>';
                                    //str += '<span class="radioInt"><input type="checkbox"></span></div>';
                                    // 设置已选中的服务高亮
                                    $("#product_items").find(".radioInt").each(function(name, value){
                                        if($(value).attr('spec_id') == goods[sid]['undefined'][index]["spec_id"]) {
                                           $(value).context.className = "radioInt on";
                                        }
                                    });
                                }
                            }
                        } 
                    }
                }
            }
            $(".dianpu_spin div").html(str); 
        }
    }

    //初始化购物车数据
    ~function () {
        window.beauty.init();
        var count = window.beauty.count(shop_id);
        set_status();
        get_list();
        cate_list();
    }();
    </script>
    </body>
</html>
<?php }} ?>