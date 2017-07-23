<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 09:14:32
         compiled from "D:\phpStudy\WWW\shequ\themes\default\block\sheader.html" */ ?>
<?php /*%%SmartyHeaderCode:2855558339bf830ba62-68629856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f734a874a32a938c50dfd088d522fc7640ff6fdc' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\block\\sheader.html',
      1 => 1479178308,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2855558339bf830ba62-68629856',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
    'CONFIG' => 0,
    'tpl_title' => 0,
    'wxjs_config' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58339bf83b1340_86128468',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58339bf83b1340_86128468')) {function content_58339bf83b1340_86128468($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
<meta name="format-detection" content="telephone=no,email=no,adress=no" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name='apple-touch-fullscreen' content='yes'/>
<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
<title><?php if ($_smarty_tpl->tpl_vars['request']->value['IN_WEIXIN']){?><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
<?php }else{ ?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['tpl_title']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'] : $tmp);?>
<?php }?></title>
<link rel="stylesheet" type="text/css" href="/themes/default/static/css/pub_app.css"/>
<link rel="stylesheet" type="text/css" href="/themes/default/static/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/themes/default/static/css/pullToRefresh.css"/>
<link rel="stylesheet" type="text/css" href="/themes/default/static/css/append.css"/>
<link rel="stylesheet" type="text/css" href="/themes/default/static/css/mobiscroll.custom-2.6.2.min.css"/>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['request']->value['IN_WEIXIN']){?>
    window.WXJS_CFG = {
        debug: false,
        appId: '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["appId"];?>
',
        timestamp: '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["timestamp"];?>
',
        nonceStr: '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["nonceStr"];?>
',
        signature: '<?php echo $_smarty_tpl->tpl_vars['wxjs_config']->value["signature"];?>
',
        jsApiList: ['getLocation']
    };
    wx.config(WXJS_CFG);
<?php }?>
window.CFG = {"domain":"<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['domain'];?>
","url":"<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['siteurl'];?>
", "title":"<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
", "res":"<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
", "img":"<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
","C_PREFIX":"KT-"};
</script>
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/layer.m/layer.m.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/fastclick.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/jquery.flexslider-min.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/iscroll.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/common.js?20161017" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/pub.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/jscookie.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/ecart.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/mobiscroll.custom-2.6.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/jquery.qrcode.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/jquery.sglide.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/mobiscroll.custom-2.6.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/static/js/pullToRefresh.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7b92b3afff29988b6d4dbf9a00698ed8"></script>
<script src="/themes/default/static/js/loaddata.js" type="text/javascript" charset="utf-8"></script><?php }} ?>