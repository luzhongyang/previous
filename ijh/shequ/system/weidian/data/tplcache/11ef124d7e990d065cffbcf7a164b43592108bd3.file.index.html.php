<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 10:31:34
         compiled from "D:\phpStudy\WWW\shequ\themes\default\tuan\index.html" */ ?>
<?php /*%%SmartyHeaderCode:297805833ad17b27ae0-52746319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11ef124d7e990d065cffbcf7a164b43592108bd3' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\tuan\\index.html',
      1 => 1479781892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '297805833ad17b27ae0-52746319',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ad17f34a18_24485491',
  'variables' => 
  array (
    'cate_tree' => 0,
    'v' => 0,
    'child' => 0,
    'areas' => 0,
    'business' => 0,
    'vv' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ad17f34a18_24485491')) {function content_5833ad17f34a18_24485491($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("团购商家"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="ico headerIco headerIco_3"></a></i>
    <div class="title">
        团购
    </div>
    <i class="right"><a href="javascript:tosearch();" link-load="" class="ico headerIco headerIco_1"></a></i>
</header>
<style type="text/css">
.tuan_no{ margin:0.3rem 0; text-align:center; line-height:0.3rem;}
.tuan_no h2{ font-weight:normal; font-size:0.18rem;}
.tuan_no .iconBg{width:0.8rem; height:0.8rem; margin:0.1rem 0; background:#F7F7F7; border:0.02rem solid #F7F7F7; display:inline-block; border-radius:0.8rem; text-align:center;}
</style>
<div class="saixuan_pull_box">
    <div class="saixuan_pull">
        <ul>
        	<li class="saixuan_pull_list"><div class="clickA"><a href="<?php echo smarty_function_link(array('ctl'=>'tuan/shop'),$_smarty_tpl);?>
">团购</a></div></li>
            <!--<li class="saixuan_pull_list">
                <div class="click" filter="cate">分类<em></em></div>
                <div class="saixuan_pull_child_box saixuan_fenlei cate" style="display:none;">
                    <ul>
                            <li class="saixuan_pull_child" rel="0">全部分类</li>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['parent_id']&&$_smarty_tpl->tpl_vars['v']->value['children']){?>
                            <li class="saixuan_pull_child" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
<span class="linkIco"></span></li>
                        <?php }elseif(!$_smarty_tpl->tpl_vars['v']->value['parent_id']){?>
                            <li class="saixuan_pull_child" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</li>
                        <?php }?>
                        <?php } ?>
                    </ul>
                    <div class="saixuan_fenlei_list_box cate2" style="display:none;">
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['v']->value['children']){?>
                        <ul class="saixuan_fenlei_list_nr" id="a<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
">
                            <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a>全部<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                            <?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
                            <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['child']->value['cate_id'];?>
"><a><?php echo $_smarty_tpl->tpl_vars['child']->value['title'];?>
</a></li>
                            <?php } ?>
                        </ul>
                        <?php }?>
                        <?php } ?>
                    </div>
                </div>
            </li>-->
            <style>
                .saixuan_fenlei_list_box_posit{ position: relative; }
            </style>
            <li class="saixuan_pull_list">
                <div class="click" filter="area">附近<em></em></div>
            	<div class="saixuan_pull_child_box saixuan_fenlei area" style="display:none;">
                    <div class="saixuan_fenlei_list_box_posit">
                        <ul class="scroll_box">
                                <li class="saixuan_pull_child" rel="0">附近<span class="linkIco"></span></li>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['areas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <li class="saixuan_pull_child" rel='<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
<span class="linkIco"></span></li>
                            <?php } ?>
                        </ul>
                        <div class="saixuan_fenlei_list_box area2">

                            <ul class="saixuan_fenlei_list_nr" id="a0">
                                <li class="saixuan_fenlei_list" rel="0.5" filter="juli"><a>附近</a></li>
                                <li class="saixuan_fenlei_list" rel="1" filter="juli"><a>1km</a></li>
                                <li class="saixuan_fenlei_list" rel="5" filter="juli"><a>5km</a></li>
                                <li class="saixuan_fenlei_list" rel="10" filter="juli"><a>10km</a></li>
                                <li class="saixuan_fenlei_list" rel="200" filter="juli"><a>全城</a></li>
                            </ul>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['areas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <ul class="saixuan_fenlei_list_nr" id="a<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" style="display:none;">
                                <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" filter="areas"><a>全部<?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</a></li>
                                <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['business']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['area_id']==$_smarty_tpl->tpl_vars['vv']->value['area_id']){?>
                                <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['vv']->value['business_id'];?>
" filter="business"><a><?php echo $_smarty_tpl->tpl_vars['vv']->value['business_name'];?>
</a></li>
                                <?php }?>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </li>
            <li class="saixuan_pull_list">
                <div class="click" filter="sort">智能排序<em></em></div>
            	<div class="saixuan_pull_child_box sort" style="display:none;">
                    <ul class="border1">
                        <li class="saixuan_pull_child" rel="default"><a><i class="ico ico1"></i>智能排序</a></li>
                        <li class="saixuan_pull_child" rel="nearly"><a><i class="ico ico2"></i>离我最近</a></li>
                        <li class="saixuan_pull_child" rel="score"><a><i class="ico ico3"></i>好评优先</a></li>
                        <li class="saixuan_pull_child" rel="avg_amount"><a><i class="ico ico4"></i>人均最低</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="mask_bg"></div>
</div>
<section class="page_center_box" style="top: 0.91rem;">
    <div class="recSeller_list_box border_t mt10 mb10" id="wrapper">
        <ul></ul>
    </div>
</section>

<script id="tmpl_tuan_items" type="text/x-jquery-tmpl">
    {{if !(have_tuan==0 && have_quan==0)}}
    <li class="recSeller_list">
        <a href="${url}">
            <div class="pub_img fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" /></div>
        </a>
        <a href="${url}">
        <div class="pub_wz">
            <p class="bt"><a href="${url}" class="overflow_clear">${title}</a><em style="background:rgb(251,98,0);">{{if have_tuan==1}}团{{/if}}</em><em style="background:rgb(251,170,30);;">{{if have_quan==1}}券
            {{/if}}
            </em></p>
            <a href="${url}">
            <div class="nr">
                <div class="fl">
                    <div><span class="starBg" style="vertical-align:super;"><span class="star" style="width:${mark*20}%;"></span></span><span class="ml10 black9">${mark}分</span></div>
                    <!--<div class="bq_box"><span class="bq" style="background:#fc7b7b;">${title}</span></div>-->
                </div>
                <div class="fr">
                    <p class="black9 price">人均：<span class="pointcl1">￥${avg_amount}</span></p>
                    <p class="black9 range"><em class="ico"></em>${juli_label}</p>
                </div>
            </div>
            </a>
        </div>
        </a>
    </li>
    {{/if}}
</script>

<script>
$(document).ready(function() {
    window.LoadData.params = {"cate_id": 0, "area_id": 0, "business_id": 0, "range": 0, "sort": "", "page": 1};
    getUxLocation(function (ret) {
        if (ret.error) {
            window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
        } else {
            $('#position').text(ret.addr);
            loadPageItems();
        }
    });
});


/*头部下拉开始*/
if ($('.saixuan_pull').length > 0)/*判断是否存在这个html代码*/
{
    $('.saixuan_pull .saixuan_pull_list').width(100 / $('.saixuan_pull .saixuan_pull_list').length + '%');
    $('.page_center_box').css('top', '0.91rem');
}

$(".saixuan_pull_list .click").click(function(){
    if($(this).hasClass("on")){
        $(".saixuan_pull_list .click").removeClass("on");
        $(".saixuan_pull_list .saixuan_pull_child_box").hide();
        $(".saixuan_pull_box .mask_bg").hide();
    }
    else{
        $(".saixuan_pull_list .click").removeClass("on");
        $(".saixuan_pull_list .saixuan_pull_child_box").hide();
        $(this).addClass("on");
        $(this).parent().find(".saixuan_pull_child_box").show();
        $(".saixuan_pull_box .mask_bg").show();
    }
});

$(".saixuan_pull_box .mask_bg").click(function(e){
    $(this).hide();
    $(".saixuan_pull_list .click").removeClass("on");
    $(".saixuan_pull_list .saixuan_pull_child_box").hide();
});
/*头部下拉结束*/

// 分类一级列表点击事件
$('.cate .saixuan_pull_child').click(function(){
    var rel = $(this).attr('rel');
    $(this).parent().find(".saixuan_pull_child").removeClass("on");
    $(this).addClass("on");
    $(this).parents(".saixuan_fenlei").find('.saixuan_fenlei_list_nr').hide();
    if($(this).parents(".saixuan_fenlei").find('#a'+rel).length>0){
        // 有子分类展开子分类
        $(this).parents(".saixuan_fenlei").find('.saixuan_fenlei_list_box').show();
        $(this).parents(".saixuan_fenlei").find('#a'+rel).show();
        //$(this).parent().find('.saixuan_pull_child .linkIco').show();
    }else{
        // 无子分类
        $('.cate').hide();
        $('.saixuan_pull_box .mask_bg').hide();
        $(".saixuan_pull_list [filter='cate']").removeClass('on');
        $(".saixuan_pull_list [filter='cate']").html($(this).text()+"<em></em>");
        LoadData.params['cate_id'] = rel;
        LoadData.params['page'] = 1;
        loadPageItems();
    }
})

// 分类二级列表点击事件
$('.cate2 .saixuan_fenlei_list_nr .saixuan_fenlei_list').click(function(){
    var cate_id = $(this).attr('rel');
    $('.cate').hide();
    $('.saixuan_pull_box .mask_bg').hide();
    $(".saixuan_pull_list [filter='cate']").removeClass('on');
    $(".saixuan_pull_list [filter='cate']").html($(this).text()+"<em></em>");
    LoadData.params['cate_id'] = cate_id;
    LoadData.params['page'] = 1;
    loadPageItems();
})

// 区域一级列表点时间
$('.area .saixuan_pull_child').click(function(){
    var rel = $(this).attr('rel');
    $(this).parent().find(".saixuan_pull_child").removeClass("on");
    $(this).addClass("on");
    $(this).parents(".saixuan_fenlei").find('.saixuan_fenlei_list_nr').hide();
    if($(this).parents(".saixuan_fenlei").find('#a'+rel).length>0){
        // 有子分类展开子分类
        $(this).parents(".saixuan_fenlei").find('.saixuan_fenlei_list_box').show();
        $(this).parents(".saixuan_fenlei").find('#a'+rel).show();
        //$(this).parent().find('.saixuan_pull_child .linkIco').show();
    }else{
        // 无子分类
        $('.area').hide();
        $('.saixuan_pull_box .mask_bg').hide();
        $(".saixuan_pull_list [filter='area']").removeClass('on');
        $(".saixuan_pull_list [filter='area']").html($(this).text()+"<em></em>");
        if(rel != 0) {LoadData.params['area_id'] = rel;}
        LoadData.params['page'] = 1;
        loadPageItems();
    }
})
// 区域二级列表点击事件
$('.area2 .saixuan_fenlei_list_nr .saixuan_fenlei_list').click(function(){
    var id = $(this).attr('rel');
    var type = $(this).attr('filter');
    $('.area').hide();
    $('.saixuan_pull_box .mask_bg').hide();
    $(".saixuan_pull_list [filter='area']").removeClass('on');
    $(".saixuan_pull_list [filter='area']").html($(this).text()+"<em></em>");
    if(type == 'areas') {
        LoadData.params['area_id'] = id;
        LoadData.params['business_id'] = 0;
        LoadData.params['range'] = 0;
    }else if(type == 'business') {
        LoadData.params['business_id'] = id;
        LoadData.params['area_id'] = 0;
        LoadData.params['range'] = 0;
    }else if(type == 'juli') {
        LoadData.params['range'] = id;
        LoadData.params['area_id'] = 0;
        LoadData.params['business_id'] = 0;
    }
    LoadData.params['page'] = 1;
    loadPageItems();
});
$('.saixuan_fenlei_list a').click(function(){
	$(this).parents(".saixuan_pull_list").find(".saixuan_fenlei_list a").removeClass("on");
	$(this).addClass("on");
})
// 排序下拉列表点击事件
$('.sort .saixuan_pull_child').click(function(){
    var sort = $(this).attr('rel');
    $('.sort').hide();
    $('.saixuan_pull_box .mask_bg').hide();
    $(".saixuan_pull_list [filter='sort']").removeClass('on');
	$(this).parent().find(".saixuan_pull_child").removeClass('on');
	$(this).addClass('on');
    $(".saixuan_pull_list [filter='sort']").html($(this).text()+"<em></em>");
    LoadData.params['sort'] = sort;
    LoadData.params['page'] = 1;
    loadPageItems();
})

   // 下拉加载
function loadPageItems(params) {
    if (LoadData.LOCK) {
        return false;
    }
    LoadData.LOCK = true;
    params = params || {};
    LoadData.params = $.extend(LoadData.params, params);
    Widget.MsgBox.load("加载中...");

    $.post("<?php echo smarty_function_link(array('ctl'=>'tuan/shop:loadtuanitems'),$_smarty_tpl);?>
", LoadData.params, function (ret) {
        if (ret.error) {
            Widget.MsgBox.error(ret.message);
        } else {
            var length = getObjLen(ret.data.items);
            if (length > 0) {
                if (parseInt(LoadData.params['page'], 10) < 2) {
                    $("#wrapper ul").html($('#tmpl_tuan_items').tmpl(ret.data.items));
                } else {
                    $('#tmpl_tuan_items').tmpl(ret.data.items).appendTo($("#wrapper ul"));
                }
            } else if (LoadData.params.page > 1 ) {
                if(! $(".loading_end").length) {
                    $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                }
                LoadData.LOAD_END = true;
            } else {
                $("#wrapper ul").html('<div class="nonePage txt_center"><div class="nonePage_img"><img src="/themes/default/static/images/none/none2.png" width="25%"></div><h2 class="black3">暂无此类团购,看看别的吧</h2></div>');
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

function tosearch() {
    localStorage['search_index'] = window.location.href;
    localStorage['search_from'] = 'tuan';
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
";
}
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>