<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 15:08:43
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/shop/shop.html" */ ?>
<?php /*%%SmartyHeaderCode:45901684457b40d7bf378b1-10974876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f449ece5526ec97c73cad53887ac768f5ad901e' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/shop/shop.html',
      1 => 1470380631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45901684457b40d7bf378b1-10974876',
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
  'unifunc' => 'content_57b40d7c098551_99374307',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b40d7c098551_99374307')) {function content_57b40d7c098551_99374307($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
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
            <li><a href="<?php echo smarty_function_link(array('ctl'=>'shop/comment','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
" link-load="" link-type="right">评价</a></li>
            <li><a class="on" href="<?php echo smarty_function_link(array('ctl'=>'shop/shop','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
">商家</a></li>
        </ul>
        <!--头部切换结束-->
        <section class="page_center_box">
            <div class="shangjia mt10 ">
                <div class="shangjia_attention">
                    <div class="img fl"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" width="100" height="100" /></div>
                    <div class="wz">
                        <div class="left">
                            <P><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</P>
                            <div><span class="starBg"><span class="star" style="width:<?php echo $_smarty_tpl->tpl_vars['detail']->value['score']/$_smarty_tpl->tpl_vars['detail']->value['comments']*20;?>
%;"></span></span></div>
                        </div>
                        <a href="javascript:void(0);" rel="<?php echo $_smarty_tpl->tpl_vars['detail']->value['collect'];?>
" class="pub_btn"><?php if ($_smarty_tpl->tpl_vars['detail']->value['collect']==0){?>收藏<?php }else{ ?>取消收藏<?php }?></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="shangjia_infor_list mb10">
                    <ul>
                        <li>
                            <p class="maincl">￥<?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
</p>
                            <p>起送金额</p>
                        </li>
                        <li>
                            <p class="maincl"><?php echo $_smarty_tpl->tpl_vars['detail']->value['pei_time'];?>
分钟</p>
                            <p>平均送达时间</p>
                        </li>
                        <li>
                            <p class="maincl">￥<?php echo $_smarty_tpl->tpl_vars['detail']->value['freight'];?>
</p>
                            <p>配送费</p>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="nrBox mb10">
                    <h3 class="fontcl2">商家公告</h3>
                    <div class="nr">
                        <p class="fontcl2"><?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</p>
                    </div>
                </div>
                <div class="nrBox mb10">
                    <h3 class="black9">商家活动</h3>
                    <ul>
                        <?php if ($_smarty_tpl->tpl_vars['detail']->value['first_amount']>0){?><li class="shangjia_hd_list"><span class="bq fl" style="background:#46c3ff;">首</span><p>新用户首次下单立减<?php echo $_smarty_tpl->tpl_vars['detail']->value['first_amount'];?>
元</p></li><?php }?>
                        <?php if (!empty($_smarty_tpl->tpl_vars['detail']->value['youhui'])){?><li class="shangjia_hd_list"><span class="bq fl" style="background:#ff6900;">减</span><p><?php echo $_smarty_tpl->tpl_vars['detail']->value['youhui_title'];?>
</p></li><?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==1){?><li class="shangjia_hd_list"><span class="bq fl" style="background:#48cfcc;">付</span><p>该商家支持在线支付</p></li><?php }?>
                    </ul>
                </div>
                <!--<div class="nrBox mb10">
                    <h3 class="fontcl2">商家简介</h3>
                    <div class="nr">
                        <p class="">新店开业，优惠多多！</p>
                    </div>
                </div>-->
                <div class="nrBox mb10">
                    <h3 class="black9">商家信息</h3>
                    <ul>
                        <li class="shangjia_hd_list"><p>商家地址：<?php echo $_smarty_tpl->tpl_vars['detail']->value['addr'];?>
</p></li>
                        <li class="shangjia_hd_list"><p>营业时间：<?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_stime'];?>
-<?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_ltime'];?>
</p></li>
                    </ul>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function(){
                $(".pub_btn").click(function(){
                    if($(this).attr('rel') == 1){
                        var url = "<?php echo smarty_function_link(array('ctl'=>'shop/cancel','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
";
                    }else{
                        var url = "<?php echo smarty_function_link(array('ctl'=>'shop/collect','arg0'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
";
                    }
                    $.post(url,{},function(data){
                        if(data.error >0){
                            layer.open({content:data.message,time:2});
                        }else{
                            layer.open({content:data.message});
                            setTimeout(function(){
                                window.location.reload(true);
                            },1000)
                        }
                    },'json')
                })
            })
        </script>
    </body>
</html>
<?php }} ?>