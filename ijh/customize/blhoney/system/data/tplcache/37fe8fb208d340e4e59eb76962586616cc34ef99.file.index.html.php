<?php /* Smarty version Smarty-3.1.8, created on 2016-08-19 14:03:23
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/hotstyle/index.html" */ ?>
<?php /*%%SmartyHeaderCode:37737921957b2a9df9b5cd3-65386137%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '37fe8fb208d340e4e59eb76962586616cc34ef99' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/hotstyle/index.html',
      1 => 1471586601,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '37737921957b2a9df9b5cd3-65386137',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a9dfa1dec1_68132899',
  'variables' => 
  array (
    'request' => 0,
    'banners' => 0,
    'v' => 0,
    'pager' => 0,
    'cate_tree' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a9dfa1dec1_68132899')) {function content_57b2a9dfa1dec1_68132899($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<style>
			.hotstyle .flexslider .slides .list img{
			    height: 1.67rem
			}
			.hotstyle .banner{
			    max-height: 1.7rem;
			}
		</style
    </head>
    <body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
            <div class="title">
                热门发型
            </div>
            <i class="right"><a class=""></a></i>
        </header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
        <section class="page_center_box">
        	<div class="hotstyle">
                <!--banner部分-->
                <div class="banner mb10">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <li class="list">
                                <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['article_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'hotstyle:detail','args'=>$_tmp1),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb'];?>
"></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--banner部分结束-->
                <div class="downOption" >
                    <ul>
                        <li class="list" id="cate_list" style="width:50%;">分类<em></em></li>
                        <li class="list" id="sort_list" style="width:50%;">排序<em></em></li>
                    </ul>
                    <div class="clear"></div>
                    <div class="downOption_pull" style="margin-top:0.01rem;">
                        <div class="list_box" id="cate_items">
                            <ul id='cate'>
                                <li val="0" title="全部分类"><a href="javascript:void(0);">全部分类</a></li>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                    <li val="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
"><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                <?php } ?>
                            </ul>
                            
                        </div>
                        <div class="list_box" id="sort_items">
                            <ul id='sort'>
                                <li val="article_id"><a href="javascript:void(0);" >默认排序</a></li>
                                <li val="ontime"><a href="javascript:void(0);" >发布时间</a></li>
                                <li val="views"><a href="javascript:void(0);" >浏览数</a></li>
                            </ul>
                        </div>
                        
                        <div class="mask_bg"></div>
                    </div>
                </div>
                <!--下拉菜单end-->
                <!--热门发型列表-->
                <div class="bgcolor_white mb10" >
                    <div class="hotstyle_list_box" id="wrapper">
                    	<ul></ul>
                        <div class="clear"></div>
                    </div>
                </div>
                <!--热门发型列表end-->
            </div>
        </section>
        <?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php }else{ ?>
        <style type="text/css">.page_center_box{bottom:0;}</style>
       <?php }?>
    </body>
</html>

<script id="tmpl_cate_item" type="text/x-jquery-tmpl">
<li class="hotstyle_list">
    <div class="box">
        <a href="${url}">
            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${thumb}"/>
        </a>
    </div>
    <div class="nr overflow_clear">${title}</div>
</li>
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.flexslider').flexslider({
            directionNav: true,
            pauseOnAction: false,
        });//轮播js结束

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

        LoadData.params['page'] = 1;
        loadPageItems();
    });

    $("body").click(function(e){ 
        if (!$(e.target).is('li')) {
            $('.downOption .downOption_pull').hide();   
        }else { 
            return; 
        } 
    }); 

    $('#cate li').click(function(){
        var val = $(this).attr('val');
        $(this).addClass("on");
        $('.downOption .downOption_pull #cate_items').hide();
        $(".mask_bg").hide();
        $('.downOption #cate_list').removeClass('on');
        $('.downOption #cate_list').html($(this).attr('title')+'<em></em>');
        LoadData.params['page'] = 1;
        LoadData.params['cate_id'] = val;
        loadPageItems();
    });

    $('#sort li').click(function(){
        var val = $(this).attr('val');
        $(this).addClass("on");
        $('.downOption .downOption_pull #sort_items').hide();
        $(".mask_bg").hide();
        $('.downOption #sort_list').removeClass('on');
        $('.downOption #sort_list').html($(this).text()+'<em></em>');
        LoadData.params['page'] = 1;
        LoadData.params['sort'] = val;
        loadPageItems();
    });

    function loadPageItems(params) {
        if (LoadData.LOCK) {
            return false;
        }
        LoadData.LOCK = true;
        params = params || {};
        LoadData.params = $.extend(LoadData.params, params);
        Widget.MsgBox.load("加载中...");
        $.post("<?php echo smarty_function_link(array('ctl'=>'hotstyle:loaditems'),$_smarty_tpl);?>
", LoadData.params, function (ret) {
            if (ret.error) {
                Widget.MsgBox.error(ret.message);
            } else {
                if (ret.data.items.length > 0) {
                    if (parseInt(LoadData.params['page'], 10) < 2) {
                        $("#wrapper ul").html($('#tmpl_cate_item').tmpl(ret.data.items));
                    } else {
                        $('#tmpl_cate_item').tmpl(ret.data.items).appendTo($("#wrapper ul"));
                    }
                }
            }
            LoadData.params.page++;
            Widget.MsgBox.hide();
            LoadData.LOCK = false;
        }, "json");
    }

    $(window).scroll(function () {//监听滚动条改变
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {//滚动条是否滚到底部
            loadPageItems();
        }
    });
</script><?php }} ?>