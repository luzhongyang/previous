<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 14:05:54
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/shop/index.html" */ ?>
<?php /*%%SmartyHeaderCode:11321159857b2eb50045008-53473089%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6076d8cc3de0008dbbf5771217f3068ea7093a51' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/shop/index.html',
      1 => 1471673153,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11321159857b2eb50045008-53473089',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2eb5012cdc1_33363638',
  'variables' => 
  array (
    'pager' => 0,
    'cate_tree' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2eb5012cdc1_33363638')) {function content_57b2eb5012cdc1_33363638($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script>
    $(document).ready(function () {
        $('#l1').addClass('on');
        $('.saixuan_fenlei_list_box').hide();        
        /*头部下拉开始*/
        if ($('.saixuan_pull').length > 0){/*判断是否存在这个html代码*/
            $('.saixuan_pull .saixuan_pull_list').width(100 / $('.saixuan_pull .saixuan_pull_list').length + '%');
            $('.page_center_box').css('top', '0.91rem');
        }

        $(".saixuan_pull_list .click").click(function () {         
            if ($(this).hasClass("on")) {
                $(".saixuan_pull_list .click").removeClass("on");
                $(".saixuan_pull_list .saixuan_pull_child_box").hide();
                $(".saixuan_pull_box .mask").hide();
            }else {

                $(".saixuan_pull_list .click").removeClass("on");
                $(".saixuan_pull_list .saixuan_pull_child_box").hide();

                $(this).addClass("on");
                $(this).parent().find(".saixuan_pull_child_box").show();
                $(".saixuan_pull_box .mask").show();
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
                $('.mask').hide();
                LoadData.params['page'] = 1;
                LoadData.params['cate_id'] = rel;
                loadPageItems();
            }else {
                // 有子分类显示子分类列表
                $('#a' + rel).show();
            }
            if($(".saixuan_fenlei_list_box").css("display")=='block'){
                $(".saixuan_pull_child .after").css("left","50%");
            }else{
                $(".saixuan_pull_child .after").css("left","100%")
            }
        });

        $('.saixuan_fenlei .select_all').click(function(){
            $(".saixuan_fenlei_list_box").hide();
            if($(".saixuan_fenlei_list_box").css("display")=='block'){
                $(".saixuan_pull_child .after").css("left","50%");
            }else{
                $(".saixuan_pull_child .after").css("left","100%")
            }
        });

        

        /*头部下拉结束*/
    });
</script>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
        商家列表
    </div>
    <i class="right"><a class="searchIco" href="<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
" link-load="" ></a></i>
</header>
<section class="page_center_box">
    <div class="saixuan_pull_box" id="downOption">
        <div class="saixuan_pull">
            <ul>
                <li class="saixuan_pull_list"><div class="click"><a href="javascript:;" filter="cate"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['pager']->value['title'])===null||$tmp==='' ? '分类' : $tmp);?>
<em></em></a></div>
                    <div class="saixuan_pull_child_box saixuan_fenlei" style="display:none;">

                        <ul>
                            <li class="saixuan_pull_child select_all" ><a href="javascript:;" cate_id="0" cat="0">全部分类</a></li>
      
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['title']=='视频秀'){?>
                                <li class="saixuan_pull_child"  ><a href="<?php echo smarty_function_link(array('ctl'=>'video:index','cate_id'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                <?php }elseif($_smarty_tpl->tpl_vars['v']->value['title']=='热门发型'){?>
                                <li class="saixuan_pull_child" ><a href="<?php echo smarty_function_link(array('ctl'=>'hotstyle:index','cate_id'=>$_smarty_tpl->tpl_vars['v']->value['cate_id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                <?php }else{ ?>
                                <li class="saixuan_pull_child" <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']||$_smarty_tpl->tpl_vars['pager']->value['cate']['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>class="on" <?php }?> rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a></li>
                                <?php }?>    
                            <?php } ?>
                        </ul>
                        
                    </div>
                </li>
                <li class="saixuan_pull_list">
                <div class="click">
                    <a href="javascript:;" filter="orderby">排序<em></em></a>
                </div>
                    <div class="saixuan_pull_child_box" style="display:none;">
                        <ul id='filter_order'>
                            <li <?php if (!$_smarty_tpl->tpl_vars['pager']->value['order']){?>class="on" <?php }?>order=""><a href="javascript:;">默认排序</a></li>
                            <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='juli'){?>class="on" <?php }?>order="juli"><a href="javascript:;">距离最近</a></li>
                            <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='sales'){?>class="on" <?php }?>order="sales"><a href="javascript:;">销量最好</a></li>
                            <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='price'){?>class="on" <?php }?>order="price"><a href="javascript:;">价格最低</a></li>
                            <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='score'){?>class="on" <?php }?>order="score"><a href="javascript:;">按评价排</a></li>
                        </ul>
                    </div>
                </li>
                <li class="saixuan_pull_list"><div class="click"><a href="javascript:;" filter="filter">筛选<em></em></a></div>
                    <div class="saixuan_pull_child_box" style="display:none;">
                        <form action="<?php echo smarty_function_link(array('ctl'=>'shop/index'),$_smarty_tpl);?>
" method="get">
                            <ul class="shaixuan_pull">
                                <li>新店开业<div class="fr"><label class="tab_int <?php if ($_smarty_tpl->tpl_vars['pager']->value['is_new']==1){?>on<?php }?>" id='tb2'><input type="button" name='is_new' id='is_new' ></label></div></li>
                                <li>首单优惠<div class="fr"><label class="tab_int <?php if ($_smarty_tpl->tpl_vars['pager']->value['youhui_first']==1){?>on<?php }?>" id='tb3'><input type="button" name='youhui_first' id='youhui_first' ></label></div></li>
                                <li>下单立减<div class="fr"><label class="tab_int <?php if ($_smarty_tpl->tpl_vars['pager']->value['youhui_order']==1){?>on<?php }?>" id='tb4'><input type="button" name='youhui_order' id='youhui_order' ></label></div></li>
                                <input type='hidden' name='pei_type' id='pei_type'>
                                <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']){?><input type='hidden' name='cate_id' id='cate_id' value='<?php echo $_smarty_tpl->tpl_vars['pager']->value['cate_id'];?>
'><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']){?><input type='button' name='order' id='order' value='<?php echo $_smarty_tpl->tpl_vars['pager']->value['order'];?>
'><?php }?>
                                <li class="btn_box"><input type="button" class="btn cancel" value="取消"><input type="submit" class="btn confirm" value="确定"></li>
                            </ul>
                        </form>
                    </div>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="mask" style="z-index:98; display:none;"></div>
    </div>
    <div class="waimaiList"  id="wrapper">
        <ul> </ul>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script id="tmpl_shop_item" type="text/x-jquery-tmpl">
    <li class="list">
    <div class="img fl"><a href="${url}" link-load=""><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" /></a></div>
    <div class="wz">
    <div class="nr1">
    <div class="fl">
    <a href="${url}" link-load="">
    <p class="bt overflow_clear">${title}</p>
    <div><span class="starBg"><span class="star" style="width:${score*20}%;"></span></span></div>
    <p class="black9">接单202次</p>
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
    {{if youhui_str}}
    <p class="black9"><em style="background:#ff6900;">减</em>${youhui_str}</p>
    {{/if}}
    {{if online_pay == 1}}
    <p class="black9"><em style="background:#ff453c;">付</em>商家支持在线支付</p>
    {{/if}}
    </div>
    </div>
    </li>
</script>
<script type="text/javascript">
    var arr = "<?php echo $_smarty_tpl->tpl_vars['pager']->value['cate_id'];?>
";
    function loadPageItems(params) {
        if (LoadData.LOCK) {
            return false;
        }
        LoadData.LOCK = true;
        params = params || {};
        LoadData.params = $.extend(LoadData.params, params);
        Widget.MsgBox.load("加载中...");
        $.post("<?php echo smarty_function_link(array('ctl'=>'shop:loaditems'),$_smarty_tpl);?>
", LoadData.params, function (ret) {
            if (ret.error) {
                Widget.MsgBox.error(ret.message);
            } else {
                if (ret.data.items.length > 0) {
                    if (parseInt(LoadData.params['page'], 10) < 2) {
                        $("#wrapper ul").html($('#tmpl_shop_item').tmpl(ret.data.items));
                    } else {
                        $('#tmpl_shop_item').tmpl(ret.data.items).appendTo($("#wrapper ul"));
                    }
                } else if (LoadData.params.page > 1) {
                    if(! $(".loading_end").length) {
                        $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                    }
                    LoadData.LOAD_END = true;
                } else {
                    //给一个没有数据的提示信息
                    $("#wrapper ul").html('<div class="youhui_no"><div class="iconBg"><i class="ico8"></i> </div><h2>商户进驻中,敬请期待</h2></div>');
                    LoadData.LOAD_END = true;  
                }
            }
            LoadData.params.page++;
            Widget.MsgBox.hide();
            LoadData.LOCK = false;
        }, "json");
    }
    $(document).ready(function () {
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
        /*头部下来分类开始*/
        $('.cancel').click(function () {
            $('.saixuan_pull_child_box').hide();
            $('.mask').hide();
            $(this).parent().parent().parent().parent().parent().find(".click").removeClass("on");
        })
        /*头部下来分类开始*/

        $('#position').text() == '定位中...';
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
        getUxLocation(function (ret) {
            if (ret.error) {
                alert(ret.message);
                window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
            } else {
                $('#position').text(ret.addr);
                loadPageItems();
            }
        });
        
        $(".saixuan_pull_child").click(function () {
            $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
            $(".saixuan_pull_child_box li").removeClass("on");
            if(!$(this).hasClass('select_all')) {
                $(this).addClass("on");
            }   
            $(this).parent().parent().parent().parent().find(".click").removeClass("on");
        });
        
        
        $(".select_all a").click(function () {
            LoadData.params['page'] = 1;
            LoadData.params['cate_id'] = $(this).attr('cate_id');
            $('.saixuan_pull_child_box').hide();
            $('.mask').hide();
            $(this).parent().parent().parent().parent().find(".click").removeClass("on");
            loadPageItems();
        });
        
        
        $(".saixuan_fenlei_list a,saixuan_fenlei_list_nr a").click(function () {
            LoadData.params['page'] = 1;
            LoadData.params['cate_id'] = $(this).attr('cate_id');
            if($(this).text() == '全部'){
                $(".saixuan_pull_list [filter='cate']").html($(this).attr('data') + "<em></em>");
                LoadData.params['title'] = $(this).attr('data');
            }else{
                $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
                LoadData.params['title'] = $(this).text();
            }
            $('.saixuan_pull_child_box').hide();
            $('.mask').hide();
            
            $(this).parent().parent().parent().parent().parent().find(".click").removeClass("on");
            $(".saixuan_fenlei_list").removeClass("on");
            $(this).addClass("on");
            loadPageItems();
        });
        
        $("#filter_order li").click(function () {
            LoadData.params['page'] = 1;
            LoadData.params['order'] = $(this).attr('order');
            $('.saixuan_pull_child_box').hide();
            $('.mask').hide();
            $(".saixuan_pull_list [filter='orderby']").html($(this).text() + "<em></em>");
            $(".saixuan_pull_list .click").removeClass("on");
            $("#filter_order li").removeClass("on");
            $(this).addClass("on");
            loadPageItems();
        });
        
    });
    
    $(window).scroll(function () {//监听滚动条改变
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {//滚动条是否滚到底部
            loadPageItems();
        }
    });
    
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>