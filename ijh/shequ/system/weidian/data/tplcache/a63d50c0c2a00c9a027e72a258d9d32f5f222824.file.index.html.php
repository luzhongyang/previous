<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:15:46
         compiled from "D:\phpStudy\WWW\shequ\themes\default\index.html" */ ?>
<?php /*%%SmartyHeaderCode:92175833ae4cde65c7-66905155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a63d50c0c2a00c9a027e72a258d9d32f5f222824' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\index.html',
      1 => 1479784465,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92175833ae4cde65c7-66905155',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ae4ce9c4c7_35586318',
  'variables' => 
  array (
    'city_id' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ae4ce9c4c7_35586318')) {function content_5833ae4ce9c4c7_35586318($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_function_adv')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.adv.php';
?><?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'city'),$_smarty_tpl);?>
"  link-load="" class="this_city"></a></i>
            <div class="title">
                <a  href="<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
"  link-load="" class="shangquan shangquan_add"><em class="addrIco"></em><span id="position">定位中...</span><em class="downIco"></em></a>
            </div>
            <i class="right"><a  href="javascript:tosearch();"  link-load="" class="ico headerIco headerIco_1"></a></i>
        </header>

<section class="page_center_box">
	<div class="banner">
        <div class="flexslider">
            <ul class="slides"><?php echo smarty_function_adv(array('id'=>"1",'name'=>"首页轮播",'city_id'=>$_smarty_tpl->tpl_vars['city_id']->value),$_smarty_tpl);?>
</ul>
        </div>
    </div>
    <div class="sy_menuCate mb10">
    	<ul>
            <?php echo smarty_function_adv(array('id'=>"4",'name'=>"首页分类",'city_id'=>$_smarty_tpl->tpl_vars['city_id']->value),$_smarty_tpl);?>

        </ul>
    </div>
    <div class="sy_extend mb10">
        <ul>
            <?php echo smarty_function_adv(array('id'=>"2",'name'=>"App广告位",'city_id'=>$_smarty_tpl->tpl_vars['city_id']->value),$_smarty_tpl);?>

        </ul>
    </div>
    <h3 class="bgcolor_white border_b pad10 clear_both font_size14">推荐商家<a href="<?php echo smarty_function_link(array('ctl'=>'shop/index'),$_smarty_tpl);?>
" class="fr black9">更多&gt;</a></h3>
    <div class="recSeller_list_box border_t mt10 mb10"  id="wrapper"  style="min-height:300px;position:relative;">
        <ul></ul>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script id="tmpl_shop_item" type="text/x-jquery-tmpl">
    <li class="recSeller_list">
    <a href="${url}" link-load="">
        <div class="pub_img fl"><a href="${url}" link-load="" ><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" /></a></div>
        <div class="pub_wz">

            <p class="bt">
                <a href="${url}" class="overflow_clear">${title}</a>
                {{if have_paidui == 1}}<em style="background:#00cdda;">排</em>{{/if}}
                {{if have_dingzuo == 1}}<em style="background:#7ed321;">订</em>{{/if}}
                {{if have_waimai==1}}<em style="background:#f5a623;">外</em>{{/if}}
                {{if have_weidian==1}}<em style="background:#ff6600;">店</em>{{/if}}
            </p>
            <div class="nr">
                <div class="fl">
                    <a href="${url}" link-load="">
                    <div><span class="starBg"><span class="star" style="width:${score*20}%;"></span></span><span class="ml10 black9">${score}分</span></div>
                    <p class="black9">${cate_title}</p>
                    </a>
                </div>
                <div class="fr">
                    <a href="${url}" link-load="">
                    <p class="black9 price">人均：<span class="pointcl1">￥${avg_amount}</span></p>
                    <p class="black9 range"><em class="ico"></em>${juli_label}</p>
                    </a>
                </div>
            </div>
            <div class="tag_box">
                {{if have_tuan==1}}
                    {{if tuan_title}}
                    <p class="overflow_clear black6"><em class="tag" style="background:#f46007;">团</em>${tuan_title}</p>
                    {{/if}}
                {{/if}}
                {{if have_maidan==1}}
                    {{if coupon_title}}
                    <p class="overflow_clear black6"><em class="tag" style="background:#ff2b79;">惠</em>${coupon_title}</p>
                    {{/if}}
                {{/if}}
                {{if have_quan==1}}
                    {{if quan_title}}
                    <p class="overflow_clear black6"><em class="tag" style="background:#0598ec;">券</em>${quan_title}</p>
                    {{/if}}
                {{/if}}
            </div>
        </div>
        </a>
    </li>
</script>

<script type="text/javascript">
window.LoadData.params = {"page": 1};
function ask_demo_uxlocation(){
    layer.open({
        //title : "切换地址",
        content: '为了更好的体验程序功能，建议您切换地址为【合肥.华润五彩国际】？',
        btn: ['立即切换', '任性继续'],
        shadeClose: false,
        yes: function(){
            var demo_uxlocation = {"lng":"117.257186","lat":"31.835828","addr":"华润五彩国际"};
            setUxLocation(demo_uxlocation);
            Cookie.set("UxCityId", 1);
            Cookie.set("UxCity", '合肥');
            localStorage.setItem('UxCity', '合肥');
            localStorage.setItem('UxCityId', '1');
            Cookie.set("ask_deme_uxlocation", 1);
            window.location = 'index.html';
            //layer.open({content: '你点了确认', time: 1});
        }, no: function(){
            Cookie.set("ask_deme_uxlocation", 1);
            window.location = 'index.html';
            //layer.open({content: '你选择了取消', time: 1});
        }
    });
}
$(document).ready(function () {
    $('#l1').addClass('on');
    var now_city_name = localStorage.getItem("UxCity");
    if(!now_city_name){
        now_city_name = '选择城市';
    }
    $('.this_city').text(now_city_name);
    $('#position').text()=='定位中...'
    if(Cookie.get("ask_deme_uxlocation")!=1){
        ask_demo_uxlocation();
    }else{
        var LocTimer = setTimeout(function(){
            alert("获取不到你的地址");
            window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
        }, 10000);
        getUxLocation(function(ret){
            clearTimeout(LocTimer);
            if(ret.error){
                alert(ret.message);
                window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
            }else{
                $('#position').text(ret.addr);
                //地址处理
                var link = "<?php echo smarty_function_link(array('ctl'=>'index/get_addr'),$_smarty_tpl);?>
";
                $.post(link, {lat:ret.lat,lng:ret.lng}, function (r) {
                    if (r.error == 0) {
                        $('.this_city').text(r.addr);
                    }
                }, 'json');
                loadPageItem(LoadData.params);
            }
        });
    }

});
function loadPageItem(params){
    if(LoadData.LOCK || LoadData.LOAD_END){
        return false;
    }
    LoadData.LOCK = true;
    params = params || {};
    LoadData.params = $.extend(LoadData.params, params);
    Widget.MsgBox.load("加载中...");
    $.post("<?php echo smarty_function_link(array('ctl'=>'index:index'),$_smarty_tpl);?>
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

// 监听滚动区域 <section></section>
$(".page_center_box").scroll(function () {
    if ($(".page_center_box").scrollTop() >= $(".recSeller_list_box").height() - $(".page_center_box").height()) {
        loadPageItem();
    }
});

function tosearch() {
    localStorage['search_index'] = window.location.href;
    localStorage['search_from'] = 'shop';
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
";
}
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.flexslider').flexslider({
            directionNav: true,
            pauseOnAction: false,
        });//首页轮播js结束
    });
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>