<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:43:54
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/index.html" */ ?>
<?php /*%%SmartyHeaderCode:168011698957b2c43a29c7c7-55137788%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee00bd6348b3fb5b79863497a5a27ed68f1b155a' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/index.html',
      1 => 1471229544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168011698957b2c43a29c7c7-55137788',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MEMBER' => 0,
    'pager' => 0,
    'hb_count' => 0,
    'comments' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c43a327ef2_43427851',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c43a327ef2_43427851')) {function content_57b2c43a327ef2_43427851($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<meta http-equiv="Page-Enter" content="revealTrans(Duration=1.0,Transition=7)">
</head>

<body>
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/msg:index'),$_smarty_tpl);?>
" link-load="" class="bellIco"><span id="bellnum" class="num">0</span></a></i>
    <div class="title">
    	我的
    </div>
        <i class="right"><?php if ($_smarty_tpl->tpl_vars['MEMBER']->value['uid']){?><a class="" href="<?php echo smarty_function_link(array('ctl'=>'passport/loginout'),$_smarty_tpl);?>
">退出</a><?php }?></i>
</header>
<section class="page_center_box">
	<div class="mineHome">
    	<div class="mineHome_infor mb10">
            <div class="infor">
            	<a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/info:index'),$_smarty_tpl);?>
"  link-load=""><span class="headX"><!--<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['face'];?>
" width="100" height="100"/> --><img src="/themes/default/static/images/mine/face1.png"/ width="100" height="100"></span><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['mobile'];?>
<em></em></a>
            </div>
            <ul class="list_box">
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/money:index'),$_smarty_tpl);?>
"  link-load="">
                <li class="list"><p class="maincl"><big><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['money'];?>
</big>元</p><p>余额</p></li>
                </a>
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/hongbao'),$_smarty_tpl);?>
"  link-load="">
                <li class="list"><p class="maincl"><big><?php echo $_smarty_tpl->tpl_vars['hb_count']->value;?>
</big>个</p><p>红包</p></li>
                </a>
                <a href="javascript:integral();" link-load="">
                <li class="list"><p class="maincl"><big><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['jifen'];?>
</big>分</p><p>美币</p></li>
                </a>
            </ul>
        </div>
        <ul class="form_list_box">
            <li class="mineHome_list">
                <a href="javascript:goorderwell();" link-load="" >
            	<p class="fl"><em class="ico_1"></em>待评价订单</p>
                <div class="fr"><span class="num"><?php if ($_smarty_tpl->tpl_vars['comments']->value==0){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['comments']->value;?>
<?php }?>
                </span><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list">
            	<a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/addr:index'),$_smarty_tpl);?>
"  link-load="">
            	<p class="fl"><em class="ico_2"></em>收货地址</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list">
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/collect:index'),$_smarty_tpl);?>
"  link-load="">
            	<p class="fl"><em class="ico_3"></em>我的收藏</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list">
                <a href="javascript:mallorder();" link-load="">
            	<p class="fl"><em class="ico_4"></em>商城订单</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list">
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/share'),$_smarty_tpl);?>
" link-load="">
            	<p class="fl"><em class="ico_5"></em>分享有奖</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
           <!-- <li class="mineHome_list">
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/info/update_passwd'),$_smarty_tpl);?>
" link-load="">
            	<p class="fl"><em class="ico_6"></em>修改密码</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li> -->
            <li class="mineHome_list">
                <a href="<?php echo smarty_function_link(array('ctl'=>'about'),$_smarty_tpl);?>
" link-load="">
            	<p class="fl"><em class="ico_7"></em>关于</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list last">
                <a href="<?php echo smarty_function_link(array('ctl'=>'help/index'),$_smarty_tpl);?>
" link-load="">
            	<p class="fl"><em class="coin_s"></em>服务中心</p>
                <div class="fr"><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>  
        </ul>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['MEMBER']->value['uid']){?>
    <!--<input type="submit" value="退出登录" class="btn login_out" style="width:100%;background:#ff5757;font-size:0.16rem;color:#ffffff;border:none;border-radius:0.05rem;"> -->
    <?php }?>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script>
$(document).ready(function() {
    $('.list').removeClass('on');
    $('#l5').addClass('on');
    // 加载用户未读消息
    getmsgs();
    $('.login_out').click(function(){
        window.location.href='<?php echo smarty_function_link(array('ctl'=>"passport/loginout"),$_smarty_tpl);?>
';
    }) 
});

function getmsgs() {
    jQuery.ajax({  
        url: "<?php echo smarty_function_link(array('ctl'=>'ucenter/msg:getmsgs'),$_smarty_tpl);?>
", 
        async: true,  
        dataType: 'json',  
        type: 'POST',   
        success: function (ret) { 
            if(ret.error>0) {
            }else {
                $("#bellnum").text(ret.data.rows);
            }
        }, 
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert(errorThrown); 
        },  
    });
}

function goorderwell() {
    localStorage['waitcommment'] = 'waitcommment';
    localStorage['order_orderwell'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'order:orderwell'),$_smarty_tpl);?>
";
    //window.location.href='<?php echo smarty_function_link(array('ctl'=>"order/orderwell"),$_smarty_tpl);?>
';
}

function integral() {
    localStorage['ucenter_integral_index'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter/integral'),$_smarty_tpl);?>
"; 
}

function mallorder() {
    localStorage['ucenter_mall_orderitems'] = window.location.href;
    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:orderitems'),$_smarty_tpl);?>
"; 
}


</script>
</body>
</html><?php }} ?>