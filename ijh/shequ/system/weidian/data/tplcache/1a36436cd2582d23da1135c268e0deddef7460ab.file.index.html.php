<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 11:16:57
         compiled from "D:\phpStudy\WWW\shequ\themes\default\shop\index.html" */ ?>
<?php /*%%SmartyHeaderCode:47415833b8a925c894-84472793%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a36436cd2582d23da1135c268e0deddef7460ab' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\shop\\index.html',
      1 => 1479198029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '47415833b8a925c894-84472793',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'cate_tree' => 0,
    'v' => 0,
    'item' => 0,
    'child' => 0,
    'area' => 0,
    'business' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833b8a93a60b3_23713201',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833b8a93a60b3_23713201')) {function content_5833b8a93a60b3_23713201($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="ico headerIco headerIco_3"></a></i>
    <div class="title">
        <a href="<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
" link-load="" class="shangquan"><em class="addrIco"></em><span id="position">定位中...</span><em
                class="downIco"></em></a>
    </div>
    <i class="right"><a class="ico headerIco headerIco_1" href="javascript:tosearch();" link-load=""></a></i>
</header>
<div class="saixuan_pull_box" id="downOption">
    <div class="saixuan_pull">
        <ul>
            <li class="saixuan_pull_list">
                <div class="click"><a href="javascript:;"
                                      filter="cate"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['pager']->value['cate']['title'])===null||$tmp==='' ? '全部商家' : $tmp);?>
<em></em></a></div>
                <div class="saixuan_pull_child_box saixuan_fenlei" style="display:none;">

                    <ul class="scroll_box">
                        <li class="saixuan_pull_child select_all"><a href="javascript:;" cate_id="0" cat="0"><i
                                class="ico ico<?php echo $_smarty_tpl->tpl_vars['v']->index+1;?>
"></i>全部商家</a></li>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                        <?php if (!$_smarty_tpl->tpl_vars['v']->value['parent_id']&&$_smarty_tpl->tpl_vars['v']->value['childrens']){?>
                        <li class="saixuan_pull_child"
                        <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']||$_smarty_tpl->tpl_vars['pager']->value['cate']['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>class="on" <?php }?>
                        rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
"/><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a><span
                            class="linkIco"></span></li>
                        <?php }elseif(!$_smarty_tpl->tpl_vars['v']->value['parent_id']){?>
                        <li class="saixuan_pull_child"
                        <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']||$_smarty_tpl->tpl_vars['pager']->value['cate']['parent_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>class="on" <?php }?>
                        rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
"><a href="javascript:;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
"/><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</a><span
                            class="linkIco"></span></li>
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
                            <li class="saixuan_fenlei_list"><a href="javascript:;" <?php if (!$_smarty_tpl->tpl_vars['pager']->value['cate_id']){?>class="on"
                                <?php }?> cate_id="<?php echo $_smarty_tpl->tpl_vars['item']->value['cate_id'];?>
" cat_id="0" data="" >全部<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></li>
                            <?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['child']->value['parent_id']==$_smarty_tpl->tpl_vars['item']->value['cate_id']){?>
                            <li class="saixuan_fenlei_list">
                                <a href="javascript:;" <?php if ($_smarty_tpl->tpl_vars['pager']->value['cate_id']==$_smarty_tpl->tpl_vars['item']->value['cate_id']){?>class="on"
                                <?php }?>cate_id="<?php echo $_smarty_tpl->tpl_vars['child']->value['cate_id'];?>
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
                <div class="click"><a href="javascript:;" filter="area" id="near_first">附近<em></em></a></div>
                <div class="saixuan_pull_child_box saixuan_fenlei_area" style="display:none;">

                    <ul class="scroll_box">
                        <li class="saixuan_pull_child" class="on" rel="0" near="1"><a href="javascript:;">附近</a><span
                                class="linkIco"></span></li>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['area']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                        <li class="saixuan_pull_child" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" near="1"><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</a><span
                                class="linkIco"></span></li>
                        <?php } ?>
                    </ul>
                    <div class="saixuan_fenlei_list_box">
                        <ul class="saixuan_fenlei_list_nr" id="big_near">
                            <li class="saixuan_fenlei_list"><a href="javascript:;" near="1">附近</a></li>
                            <li class="saixuan_fenlei_list"><a href="javascript:;" near="1">1km</a></li>
                            <li class="saixuan_fenlei_list"><a href="javascript:;" near="3">3km</a></li>
                        </ul>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['area']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                        <ul class="saixuan_fenlei_list_nr" id="area<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" style="display:none;">
                            <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" filter="areas"><a near="9"
                                                                                                   rel="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
">全部<?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</a>
                            </li>
                            <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['business']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['area_id']==$_smarty_tpl->tpl_vars['vv']->value['area_id']){?>
                            <li class="saixuan_fenlei_list" rel="<?php echo $_smarty_tpl->tpl_vars['vv']->value['business_id'];?>
" filter="business"><a near="8"
                                                                                                           rel="<?php echo $_smarty_tpl->tpl_vars['vv']->value['business_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vv']->value['business_name'];?>
</a>
                            </li>
                            <?php }?>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </div>
            </li>

            <li class="saixuan_pull_list">
                <div class="click">
                    <a href="javascript:;" filter="orderby">智能排序<em></em></a>
                </div>
                <div class="saixuan_pull_child_box" style="display:none;">
                    <ul id='filter_order' class="border1">
                        <li
                        <?php if (!$_smarty_tpl->tpl_vars['pager']->value['order']){?>class="on" <?php }?>order=""><a href="javascript:;"><i class="ico ico1"></i>智能排序</a></li>

                        <li
                        <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='juli'){?>class="on" <?php }?>order="juli"><a href="javascript:;"><i
                            class="ico ico2"></i>离我最近</a></li>
                        <!--
                        <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='time'){?>class="on" <?php }?>order="time"><a href="javascript:;">送餐速度最快</a></li>
                        <li <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='sales'){?>class="on" <?php }?>order="sales"><a href="javascript:;">销量最好</a></li> -->
                        <li
                        <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='score'){?>class="on" <?php }?>order="score"><a href="javascript:;"><i
                            class="ico ico3"></i>好评优先</a></li>
                        <li
                        <?php if ($_smarty_tpl->tpl_vars['pager']->value['order']=='price'){?>class="on" <?php }?>order="price"><a href="javascript:;"><i
                            class="ico ico4"></i>人均最低</a></li>

                    </ul>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="mask_bg"></div>
</div>
<section class="page_center_box">
    <div class="recSeller_list_box border_t mt10 mb10" id="wrapper">
        <ul></ul>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script id="tmpl_shop_item" type="text/x-jquery-tmpl">
    <li class="recSeller_list">
        <div class="pub_img fl"><a href="${url}" link-load="" ><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${logo}" width="100" height="100" /></a></div>
        <div class="pub_wz">
            <a href="${url}" link-load="" >
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
                    <div><span class="starBg"><span class="star" title="${avg_score}" style="width:${avg_score*20}%;"></span></span><span class="ml10 black9">${avg_score}分</span></div>
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
            </a>
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
                    if (!$(".loading_end").length) {
                        $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                    }
                    LoadData.LOAD_END = true;
                } else {
                    //给一个没有数据的提示信息
                    $("#wrapper ul").html('<div class="nonePage txt_center"><div class="nonePage_img"><img src="/themes/default/static/images/none/none2.png" width="25%"></div><h2 class="black3">商户进驻中,敬请期待</h2></div>');
                    LoadData.LOAD_END = true;
                }
            }
            LoadData.params.page++;
            Widget.MsgBox.hide();
            LoadData.LOCK = false;
        }, "json");
    }
    $(document).ready(function () {
        //$('.saixuan_fenlei_list_box').hide();
        /*头部下拉开始*/
        if ($('.saixuan_pull').length > 0) {/*判断是否存在这个html代码*/
            $('.saixuan_pull .saixuan_pull_list').width(100 / $('.saixuan_pull .saixuan_pull_list').length + '%');
            $('.page_center_box').css('top', '0.91rem');
        }

        $(".saixuan_pull_list .click").click(function () {
            if ($(this).hasClass("on")) {
                $(".saixuan_pull_list .click").removeClass("on");
                $(".saixuan_pull_list .saixuan_pull_child_box").hide();
                $(".saixuan_pull_box .mask_bg").hide();
            } else {
                $(".saixuan_pull_list .click").removeClass("on");
                $(".saixuan_pull_list .saixuan_pull_child_box").hide();
                $(this).addClass("on");
                $(this).parent().find(".saixuan_pull_child_box").show();
                $(".saixuan_pull_box .mask_bg").show();
            }
        });

        //商家下拉
        $('.saixuan_fenlei .saixuan_pull_child').click(function () {
            var rel = $(this).attr('rel');
            $(this).parent().find(".saixuan_pull_child").removeClass("on");
            $(this).addClass("on");
            $('.saixuan_fenlei_list_nr').hide();
            LoadData.params['cate_id'] = rel;
            if (rel == 0) {
                $('#big_near').show();
            } else if ($('#a' + rel).length == 0) {
                $('.saixuan_pull_child_box').hide();
                $('.mask_bg').hide();
                LoadData.params['page'] = 1;
                loadPageItems();
            } else {
                $('#a' + rel).show();
            }
        });

        // 附近下拉
        $('.saixuan_fenlei_area .saixuan_pull_child').click(function () {
            var rel = $(this).attr('rel');
            $(this).parent().find(".saixuan_pull_child").removeClass("on");
            $(this).addClass("on");
            $('.saixuan_fenlei_list_nr').hide();
            LoadData.params['area_id'] = rel;
            if (rel == 0) {
                $('#big_near').show();
            } else if ($('#area' + rel).length == 0) {
                $('.saixuan_pull_child_box').hide();
                $('.mask_bg').hide();
                LoadData.params['page'] = 1;
                loadPageItems();
            } else {
                $('#area' + rel).show();
            }
        });

        /*头部下拉结束*/
    });

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
            $('.mask_bg').hide();
            $(this).parent().parent().parent().parent().parent().find(".click").removeClass("on");
        })
        /*头部下来分类开始*/

        $('#position').text() == '定位中...';
        window.LoadData.params = {
            "cate_id": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['cate_id'];?>
",
            "cat_id": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['cat_id'];?>
",
            "title": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['title'];?>
",
            "orderby": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['orderby'];?>
",
            "is_new": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['is_new'];?>
",
            "online_pay": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['online_pay'];?>
",
            "first_youhui": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['first_youhui'];?>
",
            "youhui_order": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['youhui_order'];?>
",
            "pei_type": "<?php echo $_smarty_tpl->tpl_vars['pager']->value['pei_type'];?>
",
            "page": 1
        };
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
            var near = $(this).attr('near');
            if (!near) {
                $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
            } else {
                $('#near_first').text($(this).text());
            }
            $(".saixuan_pull_child_box li").removeClass("on");
            if (!$(this).hasClass('select_all')) {
                $(this).addClass("on");
            }
            $(this).parent().parent().parent().parent().find(".click").removeClass("on");
        });


        $(".select_all a").click(function () {
            LoadData.params['page'] = 1;
            LoadData.params['cate_id'] = $(this).attr('cate_id');
            $('.saixuan_pull_child_box').hide();
            $('.mask_bg').hide();
            $(this).parent().parent().parent().parent().find(".click").removeClass("on");
            loadPageItems();
        });


        //level 2 click
        $(".saixuan_fenlei_list a,saixuan_fenlei_list_nr a").click(function () {
            LoadData.params['page'] = 1;
            LoadData.params['cate_id'] = $(this).attr('cate_id');
            var id = $(this).attr('rel');
            var near = $(this).attr('near');
            if ($(this).text() == '全部') {
                if (!near) {
                    $(".saixuan_pull_list [filter='cate']").html($(this).attr('data') + "<em></em>");
                    LoadData.params['title'] = $(this).attr('data');
                } else if (near == 9) {
                    $(".saixuan_pull_list [filter='area']").html($(this).attr('data') + "<em></em>");
                    LoadData.params['area_id'] = id;
                } else if (near == 8) {
                    $(".saixuan_pull_list [filter='area']").html($(this).attr('data') + "<em></em>");
                    LoadData.params['business_id'] = id;
                } else if (near == 1 || near == 3) {
                    $(".saixuan_pull_list [filter='area']").html($(this).attr('data') + "<em></em>");
                    LoadData.params['range'] = id;
                    LoadData.params['area_id'] = 0;
                }

            } else {
                if (!near) {
                    $(".saixuan_pull_list [filter='cate']").html($(this).text() + "<em></em>");
                    LoadData.params['title'] = $(this).text();
                } else if (near == 9) {
                    $(".saixuan_pull_list [filter='area']").html($(this).text() + "<em></em>");
                    LoadData.params['area_id'] = id;
                } else if (near == 8) {
                    $(".saixuan_pull_list [filter='area']").html($(this).text() + "<em></em>");
                    LoadData.params['business_id'] = id;
                } else if (near == 1 || near == 3) {
                    $(".saixuan_pull_list [filter='area']").html($(this).text() + "<em></em>");
                    LoadData.params['range'] = near;
                    LoadData.params['area_id'] = 0;
                }

            }

            $('.saixuan_pull_child_box').hide();
            $('.mask_bg').hide();

            $(this).parent().parent().parent().parent().parent().find(".click").removeClass("on");
            $(this).parents(".saixuan_pull_list").find(".saixuan_fenlei_list a").removeClass("on");
            $(this).addClass("on");

            loadPageItems();
        });

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

        $(".saixuan_pull_box .mask_bg").click(function (e) {
            $(this).hide();
            $(".saixuan_pull_list .click").removeClass("on");
            $(".saixuan_pull_list .saixuan_pull_child_box").hide();
        });

    });

    $(".page_center_box").scroll(function () {//监听滚动条改变
        if ($(".page_center_box").scrollTop() >= $(".recSeller_list_box").height() - $(".page_center_box").height()) {//滚动条是否滚到底部
            loadPageItems();
        }
    });
    function tosearch() {
        localStorage['search_index'] = window.location.href;
        localStorage['search_from'] = 'shop';
        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
";
    }
    $(document).ready(function () {
        $('#l2').addClass('on');
    })
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>