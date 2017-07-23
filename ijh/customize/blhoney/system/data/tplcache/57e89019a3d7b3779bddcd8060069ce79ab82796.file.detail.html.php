<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:49:35
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/shop/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:171283414757b2843a47c815-18938336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57e89019a3d7b3779bddcd8060069ce79ab82796' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/shop/detail.html',
      1 => 1471333768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '171283414757b2843a47c815-18938336',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2843a570995_48120201',
  'variables' => 
  array (
    'detail' => 0,
    'request' => 0,
    'pics' => 0,
    'pager' => 0,
    'v' => 0,
    'comments' => 0,
    'comment_items' => 0,
    'vv' => 0,
    'CONFIG' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2843a570995_48120201')) {function content_57b2843a570995_48120201($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <meta name="description" content="这家店不错哦，一起去吧！<?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
，<?php echo $_smarty_tpl->tpl_vars['detail']->value['addr'];?>
，<?php echo $_smarty_tpl->tpl_vars['detail']->value['mobile'];?>
" />
    </head>
    <body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
        <header>
            <i class="left"><a href=""  link-load="" link-type="right" class="gobackIco"></a></i>
            <div class="title">
            	商家详情
            </div>
            <i class="right"><a class="<?php if ($_smarty_tpl->tpl_vars['detail']->value['collect']==1){?>collectrue<?php }else{ ?>atentIco<?php }?>" href="javascript:collect(<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
);"></a> <a class="shareIco share_show ml10"></a></i>
        </header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
        <section class="page_center_box">
            <div class="shangjia">
                <!--详情轮播-->
                <div class="banner mb10">
                    <div class="flexslider">  
                        <ul class="slides">  
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pics']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <li><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" width="100%" /></li>
                            <?php }
if (!$_smarty_tpl->tpl_vars['v']->_loop) {
?>
                            <li><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" width="100%"/></li>
                            <?php } ?>
                        </ul>  
                    </div>
                </div>
                <script type="text/javascript">
					$(document).ready(function () {
						$('.flexslider').flexslider({
							directionNav: true,
							pauseOnAction: false,
						});//首页轮播js结束
					});
				</script>
                <!--详情轮播end-->            
                <div class="nrBox mb10">
                    <h3><span class="title">店铺公告</span></h3>
                    <div class="nr">
                        <p class="black9"><?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</p>

                    </div>
                </div>
                <div class="nrBox mb10">
                    <h3><span class="title">店铺信息</span></h3>
                    <div class="waimaiList">
                    	<style>
                        .waimaiList .list:last-child { margin-bottom: 0;}
                        </style>
                        <ul>
                            <li class="list">
                                <div class="img fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" width="100" height="100" /></div>
                                <div class="wz">
                                    <div class="nr1">
                                        <div class="fl">
                                            <p class="bt overflow_clear"><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</a></p>
                                            <div><span class="starBg" style="vertical-align:super;"><span class="star" style="width:<?php echo $_smarty_tpl->tpl_vars['detail']->value['score']*20;?>
%;"></span></div>
                                            
                                        </div>
                                        <div class="fr">
                                            <p class="black9"><span class="maincl">￥<b><?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
</b></span>起</p>
                                            <p class="black9">已售<?php echo $_smarty_tpl->tpl_vars['detail']->value['orders'];?>
份</p>
                                        </div>
                                    </div>   
                                </div>
                                <div class="clear"></div>
                            </li>
                        </ul>
                    </div>
                    <ul>
                        <li class="shangjia_hd_list"><p class="black9"><em class="ico ico_1"></em>营业时间：周一至周五  <?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_stime'];?>
-<?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_ltime'];?>
</p></li>
                        <li class="shangjia_hd_list"><p class="black9 mr10 pad_r10"><em class="ico ico_2"></em><?php echo $_smarty_tpl->tpl_vars['detail']->value['addr'];?>
</p></li>
                        <li class="shangjia_hd_list"><p class="black9 mr10 pad_r10"><a href="tel:<?php echo $_smarty_tpl->tpl_vars['detail']->value['phone'];?>
" class="ico ico_3"></a><?php echo $_smarty_tpl->tpl_vars['detail']->value['phone'];?>
</p></li>
                    </ul>
                </div>
                <!--评价-->
                <div class="nrBox mb10">
                    <h3><span class="title">评价</span><span class="black9">（全部<?php echo $_smarty_tpl->tpl_vars['comments']->value;?>
条）</span><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'shop/comment','args'=>$_tmp1),$_smarty_tpl);?>
" class="fr linkIco mt10"></a></h3>
                    <style>
                    .evaluate_list:first-child {border-top:0;}
                    </style>
                    <ul>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['comment_items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <li class="evaluate_list">
                            <div class="tx fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['face'];?>
" width="100" height="100" /></div>
                            <div class="wz">
                                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['nickname'];?>
</p>
                                <div><span class="starBg"><span class="star" style="width:<?php echo ($_smarty_tpl->tpl_vars['v']->value['score_fuwu']+$_smarty_tpl->tpl_vars['v']->value['score_price'])/2*20;?>
%;"></span></span></div>
                                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['content'];?>
</p>
                                <div class="img_list">
                                    <ul>
                                        <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_smarty_tpl->tpl_vars['kk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value['photo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['kk']->value = $_smarty_tpl->tpl_vars['vv']->key;
?>
                                        <li><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['vv']->value['photo'];?>
" width="100" height="100" /></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <p class="black9"><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['v']->value['dateline'],"Y-m-d H:i:s");?>
</p>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['reply']){?>
                                <div class="evaluate_reply">
                                    <p><?php echo $_smarty_tpl->tpl_vars['v']->value['reply'];?>
</p>
                                    <p class="time black9"><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['v']->value['reply_time'],"Y-m-d H:i:s");?>
</p>
                                </div>
                                <?php }?>
                            </div>
                            <div class="clear"></div>
                        </li>
                    <?php } ?>
                    </ul>  
                </div>
                <!--评价end-->
            </div>
        </section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
        <footer>
            <div class="ord_tousu">
                <!-- <p class="fl black9 pad_t10"><span class="maincl">￥<big><b><?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
</b></big></span>起</p> -->
                <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
<?php $_tmp2=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'shop:ordered','args'=>$_tmp2),$_smarty_tpl);?>
" class="fr pub_btn">立即预约</a></div>
        </footer>
<?php }else{ ?>
<style type="text/css">.page_center_box{bottom:0;}</style>
<?php }?>
<!--分享弹出层-->
<div>
    <div class="maskOne sharePage_mask">
        <div class="cont">
            <ul>
                <!--<li><a href="#"><em class="ico_1"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_2"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_3"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_4"></em><p>微信</p></a></li>-->
                <li><a href="javascript:shareblog();"><em class="ico_5"></em><p style="color:#901872;">新浪微博</p></a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <a href="javascript:;" class="cancel" style="color:#901872;">取消</a>
    </div>
    <div class="mask_bg"></div>
</div>
<script>
$(document).ready(function() {
    $(".share_show").click(function(){
		$(".sharePage_mask").show();
		$(".sharePage_mask").parent().find(".mask_bg").show();
	});
	$(".sharePage_mask").find(".cancel").click(function(){
		$(".sharePage_mask").hide();
		$(".sharePage_mask").parent().find(".mask_bg").hide();
	});
});
</script>
<!--分享弹出层end-->

    </body>
</html>
<script>
if(localStorage['shop_detail']) {
    $('.gobackIco').attr('href', localStorage['shop_detail']);
}

function collect(shop_id) {
    var link = "<?php echo smarty_function_link(array('ctl'=>'ucenter/collect:keepstatus','args'=>'temp'),$_smarty_tpl);?>
";
    jQuery.ajax({        
        url: link.replace("temp",shop_id), 
        async: true,  
        dataType: 'json',
        type: 'POST',   
        success: function (ret) { 
            if(ret.error > 0) {
                layer.open({content: ret.message,time: 2});
                setTimeout(function(){
                    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'passport:login'),$_smarty_tpl);?>
";
                },2000);
            }else {
                layer.open({content: ret.message,time: 2});
            }
            window.location.reload();
        }, 
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert(errorThrown); 
        },  
    });
}

function shareblog() {
    var shareUrl = window.location.href;                   
    var sharePic = "<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
";       
    var shareTitle = '在'+"<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
"+'发现一个不错的美发哦，您也来看看吧。'+"<?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
"; // 内容
    window.location.href ='http://service.weibo.com/share/share.php?appkey=1550938859'+'&url='+encodeURIComponent(shareUrl)+'&content=utf-8&sourceUrl='+encodeURIComponent(shareUrl)+'&pic='+encodeURIComponent(sharePic)+'&title='+encodeURIComponent(shareTitle);
}
</script>
<?php }} ?>