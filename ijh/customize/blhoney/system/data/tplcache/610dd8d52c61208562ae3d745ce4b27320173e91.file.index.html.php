<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:20:39
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/welcome/index.html" */ ?>
<?php /*%%SmartyHeaderCode:173554775657b286875c8135-13378252%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '610dd8d52c61208562ae3d745ce4b27320173e91' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/welcome/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173554775657b286875c8135-13378252',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CONFIG' => 0,
    'pager' => 0,
    'site' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28687617d31_43618784',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28687617d31_43618784')) {function content_57b28687617d31_43618784($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE html>
<html>
<head>
<meta name="Generator" content="ECJIA 1.5" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<title>外送APP下载-<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
</title>
<link type="text/css" rel="stylesheet" href="/themes/default/welcome/css/style.css" />
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="/themes/default/welcome/js/scrollReveal.min.js"></script>
<script type="text/javascript" src="/themes/default/welcome/js/swiper.min.js"></script>
<style>
html { overflow-y: auto; }
body { background-color: #fff; }
.header { width: 100%; }
.offerPos { position: relative; height: 60px; }
.header_extend { position: absolute; left: 0; top: 0; }
</style>
</head>
<body>
<div class="index b2b2c">
<script>
$(document).ready(function() {
    //快捷导航
	$(".fast-nav li").click(function(){
		var index 	= $(this).index(),
			_this 	= $(".action").eq(index),
			sc_top	= _this.offset().top-80,
			t   	= 300;
		if( index == 2){
			sc_top = sc_top+20;
		}else if(index == 3){
			sc_top = sc_top+20;
		}else if(index == 9){
			sc_top = sc_top+40;
		}
		$("html,body").animate({
			scrollTop:sc_top
		},t);
	});
	var arr	= [];
	$(".action").each(function(i){
		arr[i] = $(".action").eq(i).offset().top;
	});
	$(window).resize(function(){
		$(".action").each(function(i){
			arr[i] = $(".action").eq(i).offset().top;
		});
	})
	$(window).scroll(function(){
		var top = $(document).scrollTop(),
			t   = 100;
		for (var i = 0 ; i < arr.length; i++) {
			if(top >= arr[i]-300 && top < arr[i] + 150){
				$(".fast-nav li").removeClass("active");
				$(".fast-nav li").eq(i).addClass("active");
			}
		};
	});

	var fast_nav_height = $(".fast-nav").height();
	var window_height	= $(window).height();
	$(".fast-nav").css({
		top:(window_height-fast_nav_height)/2
	})
	$(window).resize(function(){
		fast_nav_height = $(".fast-nav").height();
		window_height   = $(window).height();
		$(".fast-nav").stop(true,false).animate({
			top:(window_height-fast_nav_height)/2
		},300);
	});

	$(window).scroll(function(){
		if($(window).scrollTop() > $(".section-7 .title").offset().top){
			$(".section-7 ul li .wrap").removeClass("xuanzhuan180").addClass("xuanzhuan0");
		};
	});

	$(".section-11 ul li").hover(function(){
		$(this).addClass("active");
		$(this).find("p").hide();
		$(this).find(".img").show();
	},function(){
		$(this).removeClass("active");
		$(this).find("p").show();
		$(this).find(".img").hide();
	});

});
</script>
	<!--fix-nav定位头部导航开始-->
    <div class="fix-nav">
        <div class="fix-nav-wrapper">
            <div class="l"><a href="<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['siteurl'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['logo'];?>
"></a></div>
            <div class="r">
                <ul class="fa fast-nav">
                    <li  class="active"><a href="javascript:void(0);">APP简介</a></li>
                    <li ><a href="javascript:void(0);">客户端</a></li>
                    <li ><a href="javascript:void(0);">商户端</a></li>
                    <li ><a href="javascript:void(0);">配送端</a></li>
                </ul>
                <div class="linkA"><a target="_blank" href="<?php echo smarty_function_link(array('ctl'=>'biz/account/signup'),$_smarty_tpl);?>
">商家入驻</a></div>
                <div class="topWechat">
                	<div class="downceng2"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['site']->value['weixinqr'];?>
" width="100" height="100"><p>关注<?php echo $_smarty_tpl->tpl_vars['site']->value['title'];?>
公众号</p></div>
                </div>
                <div class="topTel"><em></em><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['phone'];?>
</div>
            </div>
        </div>
    </div>
    <!--fix-nav定位头部导航结束-->
    <div class="content">
        <div class="section section-1 action">
        	<div class="section-wrapper">
                <div class="box">
                	<div class="pingOne">
                        <div class="pingOne_nr1">
                            <div class="f_l" data-sr="wait .4s enter left"><img src="/themes/default/welcome/images/ping1_img1.png"></div>
                            <div class="f_r" data-sr="wait .9s enter right"><img src="/themes/default/welcome/images/ping1_img2.png"></div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="pingOne_nr2">
                        	<img src="/themes/default/welcome/images/ping1_img4.png">
                            <div class="animt_build movebuildone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-2 action">
            <div class="section-wrapper">
                <div class="title"><img src="/themes/default/welcome/images/ping2_img1.png"></div>
                <div class="box">
                	<img src="/themes/default/welcome/images/ping2_img2.png" class="img1"  data-sr="over 1s,enter left"> 
                    <img src="/themes/default/welcome/images/ping2_img3.png" class="img2"  data-sr="over 1s, enter bottom">
                    <div class="ico ico1"  data-sr="over 1s,wait .3s, enter bottom"><img src="/themes/default/welcome/images/ping2_ico1.png"><p>一键下单</p><p>方便快捷</p></div>
                    <div class="ico ico2"  data-sr="over 1s,wait .5s, enter bottom"><img src="/themes/default/welcome/images/ping2_ico2.png"><p>多种支付</p><p>任你选择</p></div>
                    <div class="ico ico3"  data-sr="over 1s,wait .7s, enter bottom"><p>火速配送</p><p>坐等外卖</p><img src="/themes/default/welcome/images/ping2_ico3.png"></div>
                    <div class="ico ico4"  data-sr="over 1s,wait .9s, enter bottom"><p>外卖状态</p><p>时刻跟踪</p><img src="/themes/default/welcome/images/ping2_ico4.png"></div>
                    <img src="/themes/default/welcome/images/ping2_x.png" class="x"  data-sr="over 1s,wait 1.6s, enter center">
                    <div class="weixinCode">
                    	<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['weixinqr'];?>
" class="f_l" width="139" height="139">
                        <div class="wz">
                        	<a href="javascript:void(0);" class="btn btn1"><em></em>Android下载</a>
                    		<a href="javascript:void(0);" class="btn btn2"><em></em>IOS下载</a>
                            <p>客户端下载！</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-3 action">
            <div class="section-wrapper">
                <div class="title"><img src="/themes/default/welcome/images/ping3_img1.png"></div>
                <div class="box">
                    <div class="pingThree">
                    	<div class="weixinCode f_l">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['weixinqr'];?>
" class="f_l" width="139" height="139">
                            <div class="wz">
                                <a href="javascript:void(0);" class="btn btn1"><em></em>Android下载</a>
                                <a href="javascript:void(0);" class="btn btn2"><em></em>IOS下载</a>
                                <p>商户端下载！</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="img_lunbo f_l">
                        	<div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"><img src="/themes/default/welcome/images/sySan_img1.png" width="257" height="456" ></div>
                                    <div class="swiper-slide"><img src="/themes/default/welcome/images/sySan_img2.png" width="257" height="456" ></div>
                                    <div class="swiper-slide"><img src="/themes/default/welcome/images/sySan_img3.png" width="257" height="456" ></div>
                                    <div class="swiper-slide"><img src="/themes/default/welcome/images/sySan_img4.png" width="257" height="456" ></div>
                                </div>
                                <div class="clear"></div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                            <script src="js/swiper.min.js"></script>
                            <script>
							var swiper = new Swiper('.swiper-container', {
								pagination: '.swiper-pagination',
								paginationClickable: true,
								centeredSlides: true,
								autoplay: 2500,
								autoplayDisableOnInteraction: false,
							});
							</script>
                        </div>
                        <ul class="wz_list f_l">
                            <li><p>便捷的操作，详细的数据统计</p></li>
                            <li><p>资金管理安全高效操作方便</p></li>
                            <li><p>用户信息全掌握时刻了解最新动态</p></li>
                            <li><p>有效及时与用户互动评价交流提高粘度</p></li>
                            <li><p>商家和平台用户三位一体的结合高效便捷</p></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-4 action">
            <div class="section-wrapper">
                <div class="title"><img src="/themes/default/welcome/images/ping4_t.png"></div>
                <div class="box">
                	<img src="/themes/default/welcome/images/ping4_img1.png" class="img1"  data-sr="over 1s,wait .3s, enter bottom">
                    <img src="/themes/default/welcome/images/ping4_img2.png" class="img2"  data-sr="over 1s,wait .5s, enter bottom">
                    <img src="/themes/default/welcome/images/ping4_img3.png" class="img3"  data-sr="over 1s,wait .7s, enter bottom">
                    <img src="/themes/default/welcome/images/ping4_img4.png" class="img4"  data-sr="over 1s,wait .9s, enter bottom">
                    <img src="/themes/default/welcome/images/ping4_img5.png" class="img5"  data-sr="over 1s,wait 1.1s, enter bottom">
                    <img src="/themes/default/welcome/images/ping4_x.png" class="x"  data-sr="over 1s,wait 1.6s, enter center">
                    <div class="weixinCode">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['weixinqr'];?>
" class="f_l" width="139" height="139">
                        <div class="wz">
                            <a href="javascript:void(0);" class="btn btn1"><em></em>Android下载</a>
                            <a href="javascript:void(0);" class="btn btn2"><em></em>IOS下载</a>
                            <p>配送端下载！</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <img src="/themes/default/welcome/images/ping4_bg.png" class="bg"  data-sr="over 1s,enter bottom">
                </div>
            </div>
            
        </div>
        <!--右侧悬浮弹窗开始-->
<script>
$(document).ready(function() {
    $(".float_window>img").click(function(){
		$(".float_window_nr").show();
	});
	$(".float_window_nr .closs_btn").click(function(){
		$(".float_window_nr").hide();
	});
    $(".float_window_nr").show();
});
</script>
<div class="float_window">
	<img src="/themes/default/welcome/images/float_float_window1.png">
    <div class="float_window_nr">
    	<img src="/themes/default/welcome/images/float_float_window2.png">
        <a href="javascript:void(0);" class="closs_btn"></a>
        <a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" target="_blank" class="btn"></a>
    </div>
</div>
<!--右侧悬浮弹窗结束-->

    </div>
</div>
</body>
<script>
window.sr = new scrollReveal({
	// reset: true,
	move: '200px',
	mobile: true
});
$(function(){
	$(".ul-tab li").click(function(){
		var index = $(this).index();
		if(!$(this).hasClass("active")){
			$(".ul-tab li").removeClass("active");
			$(this).addClass("active");
		}
		$(".tab-con .box-wrap").removeClass("show");
		$(".tab-con .box-wrap").eq(index).addClass("show");
	});

	var index = 0;
    var autoChange = setInterval(function(){
	    if(index < $(".banner-wrapper .btns li").length-1){
	        index++;
	    }else{
	        index=0;
	    }
	    showPics(index);
	},5000);
	$(".banner-wrapper .btns li").hover(function(){
		var _index = $(this).index();
		clearInterval(autoChange);
		showPics(_index);
		index = _index;
    },function(){
		autoChange = setInterval(function(){
			if(index < $(".banner-wrapper .btns li").length-1){
		        index++;
		    }else{
		        index=0;
		    }
		    showPics(index);
		},5000);
    });
	function showPics(index){
		var _this = $(".banner-wrapper .pics li").eq(index);
		$(".banner-wrapper .btns li").removeClass("active");
		$(".banner-wrapper .btns li").eq(index).addClass("active");
		_this.stop(true,false).animate({
			opacity: 1
		},1000);
		_this.siblings("li").stop(true,false).animate({
			opacity: 0
		},1000);
	}//切换效果结束

});
</script>
</html><?php }} ?>