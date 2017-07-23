<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 16:19:18
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/share/index.html" */ ?>
<?php /*%%SmartyHeaderCode:69701344457b2c43c2a4882-23577695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3fceb04aa17c64e3a351270f27e06034ea509ef' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/share/index.html',
      1 => 1471335509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69701344457b2c43c2a4882-23577695',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c43c30dca2_16563064',
  'variables' => 
  array (
    'incnt' => 0,
    'invite' => 0,
    'MEMBER' => 0,
    'mylink' => 0,
    'CONFIG' => 0,
    'wxjs_config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c43c30dca2_16563064')) {function content_57b2c43c30dca2_16563064($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable('我的分享', null, 0);?>
<!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title">
        分享
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
    <div class="sharePage">
        <!--<p class="black9">累计邀请赚取</p>
        <p class="black9">￥<big class="pointcl1"><?php if ($_smarty_tpl->tpl_vars['incnt']->value>0){?><?php echo $_smarty_tpl->tpl_vars['incnt']->value;?>
<?php }else{ ?>0<?php }?></big></p>-->

        <div class="share_bag">
            <div class="fl maincl">邀请<br>红包</div>
            <p class="maincl fr">￥<big class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['invite']->value['hongbao_amount'];?>
</big></p>
        </div>
        <p class="black3">点击邀请好友，免费送他<span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['invite']->value['hongbao_amount'];?>
</span>元红包，</p>
        <p class="black3">当好友下单成功，你也将获得<span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['invite']->value['invite_order_money'];?>
</span>元红包！</p>
        <div><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/share:detail','args'=>$_smarty_tpl->tpl_vars['MEMBER']->value['uid']),$_smarty_tpl);?>
" link-load="" class="see_details maincl">查看详情&gt;&gt;</a></div>
    </div>
</section>
<footer>
    <div class="long_btn_box" style="padding:0.1rem;"><input type="button" class="long_btn sharePage_btn" value="邀请好友" /></div>
</footer>
<div class="mask_box">
    <div class="maskOne pressCode_mask">
        <div class="cont">
            <div id="qrcodeTable" ></div>
            <p>扫一扫上面的二维码图案，分享好友</p>
            <p>或点击<span class="pointcl1">右上角</span>分享，获得红包</p>
        </div>
        <a href="javascript:;" class="cancel">知道了</a>
    </div>
    <!--<div class="maskOne sharePage_mask">
        <div class="cont">
            <ul>
                <li><a href="#"><em class="ico_1"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_2"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_3"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_4"></em><p>微信</p></a></li>
                <li><a href="#"><em class="ico_5"></em><p>微信</p></a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <a href="javascript:;" class="cancel">取消</a>
    </div>-->
    <div class="mask_bg"></div>
</div>
<script>
$(document).ready(function() {
    $(".sharePage_btn").click(function(){
        $(".pressCode_mask").show();
        $(".pressCode_mask").parent().find(".mask_bg").show();
    });
    $(".pressCode_mask").find(".cancel").click(function(){
        $(".pressCode_mask").hide();
        $(".pressCode_mask").parent().find(".mask_bg").hide();
    });
});
// 生成二维码
$('#qrcodeTable').qrcode({
    render: "canvas",            //渲染方式 table 和 canvas两种
    width: 128,                  //设置宽度  
    height: 128,                 //设置高度  
    typeNumber: -1,              //计算模式 
    correctLevel: 2,             //纠错等级  0,1,2,3 默认为2
    background: "#ffffff",       //背景颜色  
    foreground: "#000000",       //前景颜色 
    text    : '<?php echo $_smarty_tpl->tpl_vars['mylink']->value;?>
'
}); 
</script>

<!--微信JS SDK开始-->
<script>

var link = "<?php echo $_smarty_tpl->tpl_vars['mylink']->value;?>
";
var title = "<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
";
var imgUrl = "<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['siteurl'];?>
/attachs/<?php echo $_smarty_tpl->tpl_vars['invite']->value['share_photo'];?>
";
wx.config({
    debug: false,
    appId: '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["appId"];?>
',
    timestamp:'<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["timestamp"];?>
',
    nonceStr:  '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["nonceStr"];?>
',
    signature:  '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["signature"];?>
',
    jsApiList: [
        'checkJsApi',
        'onMenuShareAppMessage',
        'onMenuShareTimeline',
        'onMenuShareQQ',
    ]
});

wx.ready(function(){
    // 发送给朋友
    wx.onMenuShareAppMessage({
        title: title, 
        desc: '叫外卖,就找我', 
        link: link, 
        imgUrl: imgUrl, 
        type: '', 
        dataUrl: '', 
        success: function () { 
            layer.open({content: '分享成功！', time: 1});
        },
        cancel: function () { 
        }
    });
    // 分享到朋友圈
    wx.onMenuShareTimeline({
        title: title, 
        link: link, 
        imgUrl: imgUrl, 
        success: function () { 
            layer.open({content: '分享成功！', time: 1});
        },
        cancel: function () { 
        }
    });
    // 分享到手机QQ
    wx.onMenuShareQQ({
        title: title, 
        desc: '叫外卖,就找我', 
        link: link, 
        imgUrl: imgUrl, 
        success: function () { 
            layer.open({content: '分享成功！', time: 1});
        },
        cancel: function () { 
        }
    });
});
</script>
<!--微信JS SDK结束-->

</body>
</html>
<?php }} ?>