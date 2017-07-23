<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 11:05:19
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/mall/items.html" */ ?>
<?php /*%%SmartyHeaderCode:113335395957b525ef7668b0-69825010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2579e20253d6ea88f13815f9ca5cd4c6d03411fe' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/mall/items.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113335395957b525ef7668b0-69825010',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cate_id' => 0,
    'cates' => 0,
    'val' => 0,
    'items' => 0,
    'pager' => 0,
    'v' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b525ef7f24c1_88144912',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b525ef7f24c1_88144912')) {function content_57b525ef7f24c1_88144912($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'mall/index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
    	积分商城列表
    </div>
    <i class="right"><a class="menuIco" href="javascript:;" id="header_menu"></a></i>
</header>
<div class="mineIntegral_pull">
    <div class="list_box">
        <ul>
            <li <?php if (empty($_smarty_tpl->tpl_vars['cate_id']->value)){?>class="on"<?php }?> ><a href="<?php echo smarty_function_link(array('ctl'=>'mall/items'),$_smarty_tpl);?>
">全部</a></li>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
            <li <?php if ($_smarty_tpl->tpl_vars['val']->value['cate_id']==$_smarty_tpl->tpl_vars['cate_id']->value){?>class="on"<?php }?> ><a href="<?php echo smarty_function_link(array('ctl'=>'mall/items','cate_id'=>$_smarty_tpl->tpl_vars['val']->value['cate_id']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
            <?php } ?>
        </ul>
    </div>
    <div class="mask_bg"></div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('#l4').addClass('on');
		/*头部下来分类开始*/
		$("#header_menu").click(function(){
			$(".mineIntegral_pull").find(".list_box").toggle();
			$(".mineIntegral_pull").find(".mask_bg").toggle();
		});
		$(".mineIntegral_pull .list_box li").click(function(){
			$(this).parent().find("li").removeClass("on");
			$(this).addClass("on");
			$(".mineIntegral_pull").find(".list_box").hide();
			$(".mineIntegral_pull").find(".mask_bg").hide();
		});
		/*头部下来分类开始*/
	});
</script>
<section class="page_center_box">

	<div class="mineIntegral_list_box mt10">
        <ul>
         	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
            <li class="mineIntegral_list">
                <div class="nr">
                    <div class="pub_img"><a href="#"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" width="280" height="200" /><span class="tag"><?php echo $_smarty_tpl->tpl_vars['v']->value['jifen'];?>
积分</span></a></div>
                    <div class="pub_wz">
                        <p class="bt"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                        <p class="black9">支付<span class="maincl"><?php echo $_smarty_tpl->tpl_vars['v']->value['price'];?>
元</span><a href="#" class="pub_btn fr">+</a></p>
                    </div>
                </div>
            </li>  
        </ul>
        <?php } ?>
	    </ul>
        <div class="clear"></div>
    </div>

    <!--<div class="mineIntegral_list_box">
            <ul>
            
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['product']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value['closed']==0&&$_smarty_tpl->tpl_vars['v']->value['sku']>0){?>
    	    <li class="mineIntegral_list">
            	<div class="nr">
                    <a href="<?php echo smarty_function_link(array('ctl'=>'mall/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['product_id']),$_smarty_tpl);?>
">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['photo'];?>
" width="280" height="200" />
                    <p class="bt"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                    </a>
                    <p class="black9"><span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['v']->value['jifen'];?>
</span>积分<a href="<?php echo smarty_function_link(array('ctl'=>'mall/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['product_id']),$_smarty_tpl);?>
" class="pub_btn fr">兑换</a></p>
                </div>
            </li>
            <?php }?>
            <?php } ?>

	    </ul>
        <div class="clear"></div>
    </div>-->
</section>
<section class="dianpu_footer">
    <div class="dianpu_fot_shop">
        <div class="fl">
            <div class="fl spcart"><i>1</i></div>
            <div class="fl zjia" >合计：<span class="maincl big"><small>￥</small>28</span></div>
        </div>
        <div class="fr"><a href="#" class="pub_btn">立即购买</a></div>
        <div class="clear"></div>
    </div>
    <div class="dianpu_spin none">
        <h2><a href="#" class="empty black9"><em></em>清空所有</a></h2>
        <div class="dianpu_list dianpu_list_bt">
            <h3>短发<span class="maincl">￥28</span></h3>
            <span class="radioInt"><input type="checkbox"></span>
        </div>
        <div class="dianpu_list dianpu_list_bt">
            <h3>短发<span class="maincl">￥28</span></h3>
            <span class="radioInt"><input type="checkbox"></span>
        </div>
    </div>
    <div class="dianpu_shop_zzc"></div>
    
</section>
<!--JS 购物车-->
<script type="text/javascript">
	$(".radioInt").click(function(){
		if($(this).hasClass("on")){
			$(this).removeClass("on");
		}
		else{
			$(this).addClass("on");
		}
	});//复选js

    $('.dianpu_fot_shop .spcart').click(function(){
        $('.dianpu_footer .dianpu_spin').slideToggle();
        if($('.dianpu_footer .dianpu_shop_zzc').css('display')=='none'){
            $('.dianpu_shop_zzc').show();
        }
        else{
            $('.dianpu_shop_zzc').hide();
        }
    });//底部购物车弹出窗结束
    $('.dianpu_shop_zzc').click(function(){
        $('.dianpu_footer .dianpu_spin').hide();
        $('.dianpu_shop_zzc').hide();
    });//底部购物车弹出窗结束
    
    //商量数量加减
    $(function(){
        
        $(".add").click(function(){ 
            var t=$(this).parent().find('input[class*=text_box]');
            t.val(parseInt(t.val())+1);
            $(this).parent().find(".reduce").show();
            $(this).parent().find('input[class*=text_box]').css("color","#1ec0be");
            //setTotal(); 
        }) 
        $(".reduce").click(function(){ 
            var t=$(this).parent().find('input[class*=text_box]'); 
            t.val(parseInt(t.val())-1) 
            if(parseInt(t.val())<=0){
                $(this).parent().find('input[class*=text_box]').val(0);
                $(this).parent().find('input[class*=text_box]').css("color","#fff");
                $(this).parent().find(".reduce").hide();
            }
            //setTotal(); 
        }) 
    
        //setTotal(); 
    }) 
</script>    
</body>
</html>
<?php }} ?>