<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 09:58:57
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/shop/comment.html" */ ?>
<?php /*%%SmartyHeaderCode:89009052657b3c4e1d76142-15743802%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84ee8c556511df900ee1356603d83b3e258b76f8' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/shop/comment.html',
      1 => 1470380631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '89009052657b3c4e1d76142-15743802',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b3c4e1df6635_40910594',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b3c4e1df6635_40910594')) {function content_57b3c4e1df6635_40910594($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>

    <body>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
"  link-load="" link-type="right" class="gobackIco"></a><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</a></i>
            <div class="title">
            </div>
            <i class="right"><a class="searchIco" link-load="" href="<?php echo smarty_function_link(array('ctl'=>'search'),$_smarty_tpl);?>
"></a></i>
        </header>
        <!--提示内容开始-->
        <div class="dianpuPrompt"><p>商家温馨提示:<?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</p></div>
        <!--提示内容结束-->
        <!--头部切换开始-->
        <ul id="shangjia_tab">
            <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
" link-load="" link-type="right">菜单</a></li>
            <li><a class="on" href="<?php echo smarty_function_link(array('ctl'=>'shop/comment','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
">评价</a></li>
            <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/shop','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
" link-load="">商家</a></li>
        </ul>
        <!--头部切换结束-->
        <section class="page_center_box">
            <div class="evaluate mt10 mb10">
                <div class="fl">
                    <p class="fen pointcl1"><?php echo $_smarty_tpl->tpl_vars['detail']->value['agv'];?>
%</p>
                    <p class="black9">好评率</p> 
                </div>
                <div class="fr">
                    <p>综合得分&nbsp;&nbsp;<span class="starBg"><span class="star" style=" width:<?php echo $_smarty_tpl->tpl_vars['detail']->value['score']/$_smarty_tpl->tpl_vars['detail']->value['comments']*20;?>
%;"></span></span></p>
                    <p>服务态度&nbsp;&nbsp;<span class="starBg"><span class="star" style=" width:<?php echo $_smarty_tpl->tpl_vars['detail']->value['score_fuwu']/$_smarty_tpl->tpl_vars['detail']->value['comments']*20;?>
%;"></span></span></p>
                    <p>菜品口味&nbsp;&nbsp;<span class="starBg"><span class="star" style=" width:<?php echo $_smarty_tpl->tpl_vars['detail']->value['score_kouwei']/$_smarty_tpl->tpl_vars['detail']->value['comments']*20;?>
%;"></span></span></p>
                </div>
                <div class="clear"></div>
            </div>
            <div class="evaluate_list_box">
                <h3 class="black9">共有<?php echo $_smarty_tpl->tpl_vars['detail']->value['comments'];?>
人评价</h3>
            </div>
            <div class="evaluate_list_box">
                <div id="wrapper" style="position: absolute;">
                    <ul>

                    </ul>
                </div>
            </div>
        </section>
        <script id="data_list" type="text/x-jquery-tmpl">
            <li class="evaluate_list">
            	<div class="tx fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${face}" width="100" height="100" /></div>
                <div class="wz">
                	<p>${mobile}</p>
                    <div>
                    	<span class="star_evaluate"><span class="bq" style="background:#ff6aad;">服</span><span class="starBg"><span class="star" style=" width:${score_fuwu*20}%;"></span></span></span>
                        <span class="star_evaluate"><span class="bq" style="background:#7ecef4;">味</span><span class="starBg"><span class="star" style=" width:${score_kouwei*20}%;"></span></span></span>
                    </div>
                    <div>
                    	<span class="star_evaluate black9"><span class="bq" style="background:#466fae;">配</span>${pei_time}</span>
                    </div>
                    <p>${content}</p>
                    <div class="img_list">
                    	<ul>
                        {{each(i,pic) photo}}
                            <li><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${pic.photo}" width="100" height="100" /></li>     
                        {{/each}}
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <p class="black9">${dateline}</p>
                {{if reply != ""}}
                    <div class="evaluate_reply">
                    	<p>${reply}</p>
                        <p class="time black9">${reply_time}</p>
                    </div>
                {{/if}}
                </div>
                <div class="clear"></div>
            </li>    
    
    
        </script>
        <script>
            var page = 1;
            var wapper = document.querySelector("#wrapper ul");
            $("#pullUp").hide();
            build_refresher_items("<?php echo smarty_function_link(array('ctl'=>'shop/items'),$_smarty_tpl);?>
", {page: 1, shop_id: "<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
"}, "#data_list", wapper);
            refresher.init({
                id: "wrapper",
                pullDownAction: function () {
                    var url = "<?php echo smarty_function_link(array('ctl'=>'shop/items'),$_smarty_tpl);?>
";
                    post_json = {page: 1, shop_id: "<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
"};
                    $("#wrapper ul").html("");
                    build_refresher_items(url, post_json, '#data_list', wapper);
                    page = 1;
                    myScroll.refresh();
                },
                pullUpAction: function () {
                    page++;
                    var url = "<?php echo smarty_function_link(array('ctl'=>'shop/items'),$_smarty_tpl);?>
";
                    post_json = {page: page, shop_id: "<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
"};
                    build_refresher_items(url, post_json, '#data_list', wapper);
                    myScroll.refresh();
                },
            });
        </script>
    </body>
</html>
<?php }} ?>