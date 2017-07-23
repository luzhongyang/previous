<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 13:58:17
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/index.html" */ ?>
<?php /*%%SmartyHeaderCode:202596866657b286935270e4-99748649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b89f43932c2c2676c0a889d1cc793354bbacbad4' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/index.html',
      1 => 1471672666,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '202596866657b286935270e4-99748649',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28693655a21_36043603',
  'variables' => 
  array (
    'cate_tree' => 0,
    'v' => 0,
    'pager' => 0,
    'item' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28693655a21_36043603')) {function content_57b28693655a21_36043603($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_adv')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.adv.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'city'),$_smarty_tpl);?>
"  link-load="" class="this_city"></a></i>
            <div class="title">
                <a href="<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
"  link-load="" class="shangquan shangquan_add"><em class="addrIco"></em><span id="position">定位中...</span><em class="downIco"></em></a>
            </div>
            <i class="right"><a class="searchIco" href="<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
"  link-load="" ></a></i>
        </header>
        <section class="page_center_box">
        	<!--banner-->
            <div class="banner">
                <div class="flexslider">
                    <ul class="slides"><?php echo smarty_function_adv(array('id'=>"1",'name'=>"首页轮播"),$_smarty_tpl);?>
</ul>
                </div>
            </div>
            <!--banner结束-->
           	<!--功能-->
            <div class="menuCate_box mb10">
                <div class="flexslider">
                    <ul class="slides">
                        <li>
                            <div class="menuCate">
                                <ul>
                                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['v']->index<4){?>
                                        <li>
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['link']){?>
                                            <a href="<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['v']->value['link'],'args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
">
                                            <?php }else{ ?>
                                            <a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','cate_id'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
">
                                            <?php }?>
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
">
                                                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                                            </a>
                                        </li>
                                        <?php }?>
                                    <?php } ?>
                                    
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="menuCate">
                                <ul>
                                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['v']->index>=4){?>
                                        <li>
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['link']){?>
                                            <a href="<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['v']->value['link'],'args'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
">
                                            <?php }else{ ?>
                                            <a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','cate_id'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
">
                                            <?php }?>
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
">
                                                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                                            </a>
                                        </li>
                                        <?php }?>
                                    <?php } ?>
                                    <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','page'=>1),$_smarty_tpl);?>
"><img src="/themes/default/static/images/fuctIco/fuctIco7.png"><p>更多</p></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="downOption">
                    <ul>
                        <li class="list">分类<em></em></li>
                        <li class="list">排序<em></em></li>
                        <li class="list">筛选<em></em></li>
                    </ul>
                    <div class="clear"></div>
                    <div class="downOption_pull" style="margin-top:0.05rem;">
                        <div class="list_box">
                            <ul id='cate'>
                                <li val="0" class="on"><a href="javascript:allcate();" >全部分类</a></li>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['link']){?>
                                    <li val="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" ><a href="<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['v']->value['link'],'cate_id'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                    <?php }else{ ?>
                                    <li val="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" ><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                    <?php }?>    
                                <?php } ?>
                            </ul>
                            <div class="saixuan_fenlei_list_box" style="display:none;">    
                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['item']->value['children']){?>         
                                <ul class="saixuan_fenlei_list_nr" id="a<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
">
                                    <li class="saixuan_fenlei_list"><a href="javascript:;" <?php if (!$_smarty_tpl->tpl_vars['pager']->value['cate_id']){?>class="on" <?php }?>cate_id="0" cat_id="0" data="" >全部</a></li>  
                                    <?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['child']->value['parent_id']==$_smarty_tpl->tpl_vars['item']->value['cate_id']){?>
                                        <li class="saixuan_fenlei_list">
                                            <a href="javascript:;" <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['item']->value['cate_id']){?>class="on" <?php }?>cate_id="<?php echo $_smarty_tpl->tpl_vars['child']->value['cate_id'];?>
" cat_id="<?php echo $_smarty_tpl->tpl_vars['child']->value['parent_id'];?>
" >
                                                <?php echo $_smarty_tpl->tpl_vars['child']->value['title'];?>

                                            </a>
                                        </li>
                                        <?php }?>
                                    <?php } ?>
                                </ul>
                                <?php }?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="list_box">
                            <ul id='sort'>
                                <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index'),$_smarty_tpl);?>
" link-load="">默认排序</a></li>
                                <!--<li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','order'=>'time'),$_smarty_tpl);?>
" link-load="">送餐速度最快</a></li>-->
                                <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','order'=>'juli'),$_smarty_tpl);?>
" link-load="">距离最近</a></li>
                                <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','order'=>'sales'),$_smarty_tpl);?>
" link-load="">销量最好</a></li>
                                <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','order'=>'price'),$_smarty_tpl);?>
" link-load="">价格最低</a></li>
                                <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/index','order'=>'score'),$_smarty_tpl);?>
" link-load="">按评价排</a></li>
                            </ul>
                        </div>
                        <div class="list_box">
                            <form action="<?php echo smarty_function_link(array('ctl'=>'shop/index'),$_smarty_tpl);?>
" method="get">
                                <ul class="shaixuan_pull">
                                    <li>新店开业<div class="fr"><label class="tab_int" id='tb2'><input type="button" name='is_new' id='is_new' ></label></div></li>
                                    <li>首单优惠<div class="fr"><label class="tab_int" id='tb3'><input type="button" name='youhui_first' id='youhui_first' ></label></div></li>
                                    <li>下单立减<div class="fr"><label class="tab_int" id='tb4'><input type="button" name='youhui_order' id='youhui_order' ></label></div></li>
                                    <input type='hidden' name='pei_type' id='pei_type'>
                                    <li class="btn_box"><input type="button" class="btn cancel" value="取消"><input type="submit" class="btn confirm" value="确定"></li>
                                </ul>
                            </form>
                        </div>
                        <div class="mask_bg"></div>
                    </div>
                </div>
                <div class="waimaiList" id="wrapper" style="position:relative;">
                    <ul></ul>
                </div>
            </div>
        </section>
        <span style="display:none;" id="allmap"></span>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script id="tmpl_shop_item" type="text/x-jquery-tmpl">
<li class="list">
    <div class="img fl"><a href="javascript:shopdetail(${shop_id});" link-load="" ><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" /></a></div>
    <div class="wz">
        <div class="nr1">
            <div class="fl">
                <a href="javascript:shopdetail(${shop_id});" link-load="">
                    <p class="bt overflow_clear">${title}</p>
                    <div><span class="starBg"><span class="star" style="width:${score*20}%;"></span></span></div>
                    <p class="black9">接单${orders}次</p>
                </a>
            </div>
            <div class="fr">
                <p class="black9"><span class="maincl">￥<b>${min_amount}</b></span>起</p>
                <p class="black9 mt10">${formatDistance(juli)}</p>
            </div>
        </div>
        <div class="nr2">
            {{if first_amount>0}}
            <p class="black9"><em style="background:#46c3ff;">首</em>新用户首次下单立减${first_amount}元</p>
            {{/if}}
            {{if youhui_title}}
            <p class="black9"><em style="background:#ff6900;">减</em>${youhui_title}</p>
            {{/if}}
            {{if online_pay == 1}}
            <p class="black9"><em style="background:#ff453c;">付</em>商家支持在线支付</p>
            {{/if}}
        </div>
    </div>
</li>
</script>
<script>
$(document).ready(function () {
    var now_city_name = Cookie.get("UxCity");
    if(!now_city_name){
        now_city_name = '请选择城市';
    }
    $('.this_city').text(now_city_name);
    $('#position').text()=='定位中...'
	
    var LocTimer = setTimeout(function(){
        alert("获取不到你的地址");
        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
    }, 8000);
	getUxLocation(function(ret){
        clearTimeout(LocTimer);
        if(ret.error){
            alert(ret.message);
            window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
        }else{
            $('#position').text(ret.addr);
            loadPageItem();
        }
    });
    $('#cate li').click(function(){
        var val = $(this).attr('val');
        $('.saixuan_fenlei_list_box').show();
        $(this).parent().find(".saixuan_pull_child").removeClass("on");
        $(this).addClass("on");
        $('.saixuan_fenlei_list_nr').hide();
        if($('#a' + val).length == 0) {
            // 没有子分类 直接加载列表
            var ce = val;
            var c = 0;
            var link = '<?php echo smarty_function_link(array('ctl'=>"shop/index",'cate_id'=>"__cate_id",'cat_id'=>"__cat_id"),$_smarty_tpl);?>
';
            window.location.href=link.replace('__cate_id',ce).replace('__cat_id',c);
        }else {
            // 有子分类显示子分类列表
            $('#a' + val).show();
        }
        
    })

    if($('#cate li').hasClass('on')) {
        var vcate = $('#cate li.on').attr('val');
        $('.saixuan_fenlei_list_box').show();
        $(this).parent().find(".saixuan_pull_child").removeClass("on");
        $(this).addClass("on");
        $('.saixuan_fenlei_list_nr').hide();
        $('#a' + vcate).show();
    }


    $('.saixuan_fenlei_list_nr li a').click(function(){
        var ce = $(this).attr('cate_id');
        var c = $(this).attr('cat_id');
        var link = '<?php echo smarty_function_link(array('ctl'=>"shop/index",'cate_id'=>"__cate_id",'cat_id'=>"__cat_id"),$_smarty_tpl);?>
';
        window.location.href=link.replace('__cate_id',ce).replace('__cat_id',c);
    })
    $('.flexslider').flexslider({
        directionNav: true,
        pauseOnAction: false,
    });//首页轮播js结束
    /*头部下来分类开始*/
    $(".downOption ul .list").each(function (e) {
        $(this).click(function () {
            if ($(this).hasClass("on")) {
                $(this).parent().find(".list").removeClass("on");
                $(this).removeClass("on");
                $(".mask_bg").hide();
                $(".downOption .downOption_pull").hide();
            }
            else {
                $(this).parent().find(".list").removeClass("on");
                $(this).addClass("on");
                $(".mask_bg").show();
                $(".downOption .downOption_pull").show();
            }
            $(".downOption .downOption_pull .list_box").each(function (i) {
                if (e == i) {
                    $(this).parent().find(".list_box").hide();
                    $(this).show();
                }
                else {
                    $(this).hide();
                }
                $(this).find("li").click(function () {
                    $(this).parent().find("li").removeClass("on");
                    $(this).addClass("on");
                });
            });
        });
    });
    $('.cancel').click(function(){
        $('.list_box').hide();
        $('.mask_bg').hide();
    })
    /*头部下来分类结束*/
    $(".peisong_way label").click(function () {
        $(this).parent().find("label").removeClass("on");
        $(this).addClass("on");
        var rel = $(this).attr('rel');
        $('#pei_type').val(rel);
    });
    $("#tb1").click(function () {
        if ($(this).hasClass("on")) {
            $('#online_pay').val(0);
            $(this).removeClass("on");
        }
        else {
            $('#online_pay').val(1);
            $(this).addClass("on");
        }
    });
    $("#tb2").click(function () {
        if ($(this).hasClass("on")) {
            $('#is_new').val(0);
            $(this).removeClass("on");
        }
        else {
            $('#is_new').val(1);
            $(this).addClass("on");
        }
    });
    $("#tb3").click(function () {
        if ($(this).hasClass("on")) {
            $('#youhui_first').val(0);
            $(this).removeClass("on");
        }
        else {
            $('#youhui_first').val(1);
            $(this).addClass("on");
        }
    });
    $("#tb4").click(function () {
        if ($(this).hasClass("on")) {
            $('#youhui_order').val(0);
            $(this).removeClass("on");
        }
        else {
            $('#youhui_order').val(1);
            $(this).addClass("on");
        }
    });
});

function shopdetail(shop_id) {
    var link = "<?php echo smarty_function_link(array('ctl'=>'shop:detail','args'=>'temp'),$_smarty_tpl);?>
";
    localStorage['shop_detail'] = window.location.href;
    window.location.href = link.replace('temp', shop_id);
}

function loadPageItem(params){
    if(LoadData.LOCK || LoadData.LOAD_END){
        return false;
    }
    LoadData.LOCK = true;
    params = params || {};
    LoadData.params = $.extend(LoadData.params, params);
    Widget.MsgBox.load("加载中...");
    $.post("<?php echo smarty_function_link(array('ctl'=>'shop:loaditems'),$_smarty_tpl);?>
", LoadData.params, function(ret){
        if(ret.error){
            Widget.MsgBox.error(ret.message);
        }else{
            if(ret.data.items.length > 0){
                $('#tmpl_shop_item').tmpl(ret.data.items).appendTo($("#wrapper ul"));
            }else if(LoadData.params.page > 1){
                if(! $(".loading_end").length) {
                    $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                }
                LoadData.LOAD_END = true;
            }else{
                //给一个没有数据的提示信息
                LoadData.LOAD_END = true;
            }
        }
        LoadData.params.page ++;
        Widget.MsgBox.hide();
        LoadData.LOCK = false;
    },"json");
}

function allcate() {
    var ce = 0;
    var c = 0;
    var link = '<?php echo smarty_function_link(array('ctl'=>"shop/index",'cate_id'=>"__cate_id",'cat_id'=>"__cat_id"),$_smarty_tpl);?>
';
    window.location.href=link.replace('__cate_id',ce).replace('__cat_id',c);
}
$(window).scroll(function () {//监听滚动条改变
if ($(window).scrollTop() == $(document).height() - $(window).height()) {//滚动条是否滚到底部
        loadPageItem();
    }
});
</script>
    </body>
</html><?php }} ?>