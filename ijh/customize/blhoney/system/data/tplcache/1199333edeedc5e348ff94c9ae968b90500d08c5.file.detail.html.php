<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 16:29:50
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/share/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:7931349657b2c43deaa036-44237310%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1199333edeedc5e348ff94c9ae968b90500d08c5' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/share/detail.html',
      1 => 1471336183,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7931349657b2c43deaa036-44237310',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c43df061e8_95916114',
  'variables' => 
  array (
    'request' => 0,
    'invite' => 0,
    'mylink' => 0,
    'CONFIG' => 0,
    'wxjs_config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c43df061e8_95916114')) {function content_57b2c43df061e8_95916114($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
    <header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/share:index'),$_smarty_tpl);?>
"  link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
    	分享活动详情
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>

<section class="page_center_box">
    <div class="sharePage_details">
        <img src="/themes/default/static/images/shareXq.png" width="100%" height=""> 
        <div class="pressCode_mask">
            <div class="cont">
                <div id="qrcodeTable" ></div>
                <p>扫一扫上面的二维码图案，分享好友</p>
                <p>或点击<span class="pointcl1">右上角</span>分享，获得红包</p>
            </div>
        </div>
        <h1><span>活动规则说明</span></h1>
        <div class="nr">
            <p class="black9"><?php echo nl2br($_smarty_tpl->tpl_vars['invite']->value['intro']);?>
</p>
        </div>
    </div>
</section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<script>
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
</html><?php }} ?>