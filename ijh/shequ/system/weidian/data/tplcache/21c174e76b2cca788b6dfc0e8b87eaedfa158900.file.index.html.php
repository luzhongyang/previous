<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:46:18
         compiled from "D:\phpStudy\WWW\shequ\themes\default\waimai\shop\index.html" */ ?>
<?php /*%%SmartyHeaderCode:673258339bf7bd1927-25934142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21c174e76b2cca788b6dfc0e8b87eaedfa158900' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\waimai\\shop\\index.html',
      1 => 1479781884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '673258339bf7bd1927-25934142',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58339bf817c714_93700914',
  'variables' => 
  array (
    'cate_id' => 0,
    'cate_tree' => 0,
    'v' => 0,
    'pager' => 0,
    'item' => 0,
    'child' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58339bf817c714_93700914')) {function content_58339bf817c714_93700914($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("外卖店铺"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="ico headerIco headerIco_3"></a></i>
    <div class="title">
        <?php if ($_smarty_tpl->tpl_vars['cate_id']->value==5){?>
        商超
        <?php }else{ ?>
        外卖店铺
        <?php }?>
    </div>
    <i class="right"><a  href="javascript:tosearch();" link-load="" class="ico headerIco headerIco_1"></a></i>
</header>

<div class="saixuan_pull_box">
    <div class="saixuan_pull">
        <ul>
            <li class="saixuan_pull_list">
                <div class="click" filter="cate">分类<em></em></div>
                <div class="saixuan_pull_child_box saixuan_fenlei" style="display:none;">
                    <ul class="scroll_box">
                        <li class="saixuan_pull_child select_all" ><a href="javascript:;" cate_id="0" cat="0"><i class="ico ico<?php echo $_smarty_tpl->tpl_vars['v']->index+1;?>
"></i>全部商家</a></li>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['parent_id']&&$_smarty_tpl->tpl_vars['v']->value['childrens']){?>
                        <li class="saixuan_pull_child" <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']||$_smarty_tpl->tpl_vars['pager']->value['cate']['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>class="on" <?php }?> rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
" /><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a><span class="linkIco"></span></li>
                        <?php }elseif(!$_smarty_tpl->tpl_vars['v']->value['parent_id']){?>
                        <li class="saixuan_pull_child" <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']||$_smarty_tpl->tpl_vars['pager']->value['cate']['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>class="on" <?php }?> rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
" /><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a><span class="linkIco"></span></li>
                        <?php }?>
                        <?php } ?>
                    </ul>
                    <div class="saixuan_fenlei_list_box">
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['childrens']){?>
                        <ul class="saixuan_fenlei_list_nr" id="a<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
">
                            <li class="saixuan_fenlei_list"><a href="javascript:;" <?php if (!$_smarty_tpl->tpl_vars['pager']->value['cate_id']){?>class="on" <?php }?> cate_id="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
" cat_id="0" data="" >全部<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></li>
                            <?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
            </li>
            <li class="saixuan_pull_list">
                <div class="click">
                    <a href="javascript:;" filter="orderby">排序<em></em></a>
                </div>
                <div class="saixuan_pull_child_box" style="display:none;">
                    <ul id='filter_order' class="border1">
                        <li order=""><a href="javascript:;"><i class="ico ico1"></i>默认排序</a></li>
                        <li order="time"><a href="javascript:;"><i class="ico ico5"></i>速度最快</a></li>
                        <li order="juli"><a href="javascript:;"><i class="ico ico2"></i>距离最近</a></li>
                        <li order="sales"><a href="javascript:;"><i class="ico ico6"></i>销量最好</a></li>
                        <li order="price"><a href="javascript:;"><i class="ico ico4"></i>起送最低</a></li>
                        <li order="score"><a href="javascript:;"><i class="ico ico3"></i>按评价排</a></li>
                    </ul>
                </div>
            </li>
            <li class="saixuan_pull_list">
                <div class="click">
                    <a href="javascript:;" filter="sort">筛选<em></em></a>
                </div>
            	<div class="saixuan_pull_child_box" style="display:none;">
                    <ul id="filter_sort" class="border1">
                        <li sort="is_new"><a href="javascript:;"><i class="ico ico7"></i>新店开业</a></li>
                        <li sort="online_pay"><a href="javascript:;"><i class="ico ico8"></i>在线支付</a></li>
                        <li sort="first_amount"><a href="javascript:;"><i class="ico ico9"></i>首单优惠</a></li>
                        <li sort="youhui_order"><a href="javascript:;"><i class="ico ico10"></i>下单立减</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="mask_bg"></div>
</div>
<section class="page_center_box">
    <div class="recSeller_list_box border_t mt10 mb10"  id="wrapper">
        <ul>
            <!--LI节点-->
        </ul>
    </div>
</section>

<script id="item_for_waimai" type="text/x-jquery-tmpl">
<li class="recSeller_list">
    <a  class="overflow_clear"  href="${url}" onclick="clearswitch();">
        <div class="pub_img fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" />
				{{if 0==yysj_status}}
					<p class="state state3">打烊</p>
				{{/if}}
				</div>
        <div class="pub_wz">
            <p class="bt">
                <a class="overflow_clear" href="${url}" onclick="clearswitch();">${title}</a>
                {{if first_amount}}<em style="background:#F3765A;">首</em>{{/if}}
                {{if youhui}}<em style="background:#81EAE6;">减</em>{{/if}}
                {{if discount}}<em style="background:#AC8FF8;">折</em>{{/if}}
            </p>
            <a class="overflow_clear" href="${url}" onclick="clearswitch();">
            <div class="nr">

                <div class="fl">
                    <a class="overflow_clear" href="${url}" onclick="clearswitch();">
                    <div><span class="starBg" style="vertical-align:super;"><span class="star" style="width:${score*20}%;"></span></span><span class="ml10 black9">${score}分</span></div>
                    <p class="black9">¥${min_amount}&nbsp;起 | ¥${freight_price}&nbsp;配送费 | {{if pei_time}}${pei_time}{{else}}30{{/if}}&nbsp;分钟到达</p>
                    </a>
                </div>
                <div class="fr">
                    <p class="black9 price txt_right">销量${orders}</p>
                    <p class="black9 range txt_right"><em class="ico"></em>${juli_label}</p>
                </div>
            </div>
            </a>
        </div>
    </a>
</li>
</script>

<script>
$(document).ready(function () {
    var cate_id = parseInt("<?php echo $_smarty_tpl->tpl_vars['cate_id']->value;?>
");
    window.LoadData.params = {"cate_id": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['cate_id'];?>
","cat_id": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['cat_id'];?>
","title": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['title'];?>
", "orderby": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['orderby'];?>
","is_new": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['is_new'];?>
", "online_pay": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['online_pay'];?>
","first_youhui": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['first_youhui'];?>
", "youhui_order": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['youhui_order'];?>
", "pei_type": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['pei_type'];?>
", "page": 1};
    // 获取地址位置
    getUxLocation(function (ret){
        if (ret.error) {
            alert(ret.message);
            window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
        } else {
            $('#position').text(ret.addr);
            if(cate_id > 0) {
                LoadData.params['cate_id'] = cate_id;
                $(".saixuan_pull_list [filter='cate']").html('商超' + "<em></em>");
            }
            LoadData.params.page = 1;
            loadPageItems(LoadData.params);
        }
    });
});

function clearswitch() {
    localStorage.removeItem("switchTab_list");
}

/* 获取对象长度 */
function olength(data) {
    index = 0;
    for(i in data){
        index+=1;
    }
    return index;
}

// 下拉加载
function loadPageItems(params) {
    if (LoadData.LOCK) {
        return false;
    }
    LoadData.LOCK = true;
    params = params || {};
    LoadData.params = $.extend(LoadData.params, params);
    Widget.MsgBox.load("加载中...");

    $.post("<?php echo smarty_function_link(array('ctl'=>'waimai/shop:loadshopitems'),$_smarty_tpl);?>
", LoadData.params, function (ret) {
        if (ret.error) {
            Widget.MsgBox.error(ret.message);
        } else {
            var length = olength(ret.data.items);
            if ( length > 0) {
                if (parseInt(LoadData.params['page'], 9) < 2) {
                    $("#wrapper ul").html($('#item_for_waimai').tmpl(ret.data.items)); // 第一页全部显示
                } else {
                    $('#item_for_waimai').tmpl(ret.data.items).appendTo($("#wrapper ul")); // 第二页以及之后的加入wrapper
                }
            } else if (LoadData.params.page > 1) {
                if(! $(".loading_end").length) {
                    $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                }
                LoadData.LOAD_END = true;
            } else {
                //给一个没有数据的提示信息
                $("#wrapper ul").html('<div class="nonePage txt_center"><div class="nonePage_img"><img src="/themes/default/static/images/none/none2.png" width="25%"></div><h2 class="black3">该分类下暂时没有店铺</h2></div>');
                LoadData.LOAD_END = true;
            }
        }
        LoadData.params.page++;
        Widget.MsgBox.hide();
        LoadData.LOCK = false;
    }, "json");
}

// 监听滚动区域 <section></section>
$(".page_center_box").scroll(function () {
    if ($(".page_center_box").scrollTop() >= $(".recSeller_list_box").height() - $(".page_center_box").height()) {
        loadPageItems();
    }
});

$(document).ready(function() {

	/*头部下拉开始*/
    //$('.saixuan_fenlei_list_box').hide();
    /*头部下拉开始*/
    if ($('.saixuan_pull').length > 0){/*判断是否存在这个html代码*/
        $('.saixuan_pull .saixuan_pull_list').width(100 / $('.saixuan_pull .saixuan_pull_list').length + '%');
        $('.page_center_box').css('top', '0.91rem');
    }

    $(".saixuan_pull_list .click").click(function () {
        if ($(this).hasClass("on")) {
            $(".saixuan_pull_list .click").removeClass("on");
            $(".saixuan_pull_list .saixuan_pull_child_box").hide();
            $(".saixuan_pull_box .mask_bg").hide();
        }else {

            $(".saixuan_pull_list .click").removeClass("on");
            $(".saixuan_pull_list .saixuan_pull_child_box").hide();

            $(this).addClass("on");
            $(this).parent().find(".saixuan_pull_child_box").show();
            $(".saixuan_pull_box .mask_bg").show();
        }
    });

    $('.saixuan_fenlei .saixuan_pull_child').click(function () {
        $('.saixuan_fenlei_list_box').show();
        var rel = $(this).attr('rel');
        $(this).parent().find(".saixuan_pull_child").removeClass("on");
        $(this).addClass("on");
        $('.saixuan_fenlei_list_nr').hide();

        if($('#a' + rel).length == 0) {
            // 没有子分类 直接加载列表
            $('.saixuan_pull_child_box').hide();
            $('.mask_bg').hide();
            $(".saixuan_pull_list [filter='cate']").removeClass('on');
            $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
            //$(".saixuan_fenlei_list_box").hide();
            //if($(".saixuan_fenlei_list_box").css("display")=='block'){
//                $(".saixuan_pull_child .after").css("left","50%");
//            }else{
//                $(".saixuan_pull_child .after").css("left","100%")
//            }
            LoadData.params['page'] = 1;
            LoadData.params['cate_id'] = rel;
            loadPageItems();
        }else {
            // 有子分类显示子分类列表
            $('#a' + rel).show();
        }
        //if($(".saixuan_fenlei_list_box").css("display")=='block'){
//            $(".saixuan_pull_child .after").css("left","50%");
//        }else{
//            $(".saixuan_pull_child .after").css("left","100%")
//        }
    });

    $('.saixuan_fenlei .select_all').click(function(){
        //$(".saixuan_fenlei_list_box").hide();
        //if($(".saixuan_fenlei_list_box").css("display")=='block'){
//            $(".saixuan_pull_child .after").css("left","50%");
//        }else{
//            $(".saixuan_pull_child .after").css("left","100%")
//        }

    });

    $(".saixuan_pull_box .mask_bg").click(function(e){
        $(this).hide();
        $(".saixuan_pull_list .click").removeClass("on");
        $(".saixuan_pull_list .saixuan_pull_child_box").hide();
    });
	/*头部下拉结束*/


});




// 二级分类点击事件
$(".saixuan_fenlei_list a,saixuan_fenlei_list_nr a").click(function () {
    LoadData.params['page'] = 1;
    LoadData.params['cate_id'] = $(this).attr('cate_id');
    if($(this).attr('cat_id') == 0){
        $(".saixuan_pull_list [filter='cate']").html($(this).text()+"<em></em>");
        LoadData.params['title'] = $(this).attr('data');
    }else{
        $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
        LoadData.params['title'] = $(this).text();
    }
    $('.saixuan_pull_child_box').hide();
    $('.mask_bg').hide();

    $(this).parent().parent().parent().parent().parent().find(".click").removeClass("on");
    $(".saixuan_fenlei_list a").removeClass("on");
    $(this).addClass("on");
    loadPageItems();
});


// 排序条件点击事件
$("#filter_order li").click(function () {
    LoadData.params['page'] = 1;
    LoadData.params['order'] = $(this).attr('order');
    $('.saixuan_pull_child_box').hide();
    $('.mask_bg').hide();
    $(".saixuan_pull_list [filter='orderby']").html($(this).text() + "<em></em>");
    $(".saixuan_pull_list .click").removeClass("on");
    $("#filter_order li").removeClass("on");
    $(this).addClass("on");
    loadPageItems();
});

// 筛选条件点击事件
$("#filter_sort li").click(function () {
    LoadData.params['page'] = 1;
    LoadData.params['sort'] = $(this).attr('sort');
    $('.saixuan_pull_child_box').hide();
    $('.mask_bg').hide();
    $(".saixuan_pull_list [filter='sort']").html($(this).text() + "<em></em>");
    $(".saixuan_pull_list .click").removeClass("on");
    $("#filter_order li").removeClass("on");
    $(this).addClass("on");
    loadPageItems();
});

function tosearch() {
    localStorage['search_index'] = window.location.href;
    localStorage['search_from'] = 'waimai';
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
";
}
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>