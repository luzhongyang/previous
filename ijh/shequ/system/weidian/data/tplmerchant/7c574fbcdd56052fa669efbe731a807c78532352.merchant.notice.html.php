<?php /* Smarty version Smarty-3.1.8, created on 2016-11-23 10:58:24
         compiled from "merchant:page/notice.html" */ ?>
<?php /*%%SmartyHeaderCode:9171583505d0eb1dd8-46887728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7c574fbcdd56052fa669efbe731a807c78532352' => 
    array (
      0 => 'merchant:page/notice.html',
      1 => 1479193743,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '9171583505d0eb1dd8-46887728',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'seo_sub_title' => 0,
    'seo_title' => 0,
    'SEO' => 0,
    'CONFIG' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_583505d0f41ac8_87908448',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_583505d0f41ac8_87908448')) {function content_583505d0f41ac8_87908448($_smarty_tpl) {?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php if ($_smarty_tpl->tpl_vars['seo_sub_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_sub_title']->value;?>
_<?php }?><?php if ($_smarty_tpl->tpl_vars['seo_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_title']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?>商户管理-<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
<?php }?></title>

    <link href="/merchant/style/css/animate.css" rel="stylesheet">
    <link href="/merchant/style/css/style.css" rel="stylesheet">

    <!--个性化样式-->
    <link href="/merchant/style/css/customer.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="/merchant/script/js/jquery-2.1.1.js"></script>
    <script src="/merchant/script/js/bootstrap.min.js"></script>

    <!--老平台js-->
    <script type="text/javascript" src="/static/script/kt.js"></script>
    <script type="text/javascript" src="/static/script/jBox/jBox.min.js"></script>
    <script type="text/javascript" src="/static/script/layer/layer.js"></script>
    <!--<script type="text/javascript" src="/static/script/kt.j.js"></script>-->
    <script type="text/javascript" src="/static/script/widget.msgbox.js"></script>
    <script type="text/javascript" src="/static/script/My97DatePicker/WdatePicker.js"></script>

    <script src="/themes/default/biz/static/script/printArea.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>


    <script src="/merchant/script/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/merchant/script/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/merchant/script/js/inspinia.js"></script>
    <script src="/merchant/script/js/plugins/pace/pace.min.js"></script>
    <script src="/merchant/script/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/merchant/script/js/layer.js"></script>

<style type="text/css" media="screen">
.noticePage{ text-align:center; padding-top:80px;}
.noticePage p{ font-size:16px; line-height:24px; color:#666; margin:4px 0;}
.noticePage p.big{ font-size:20px; line-height:34px; margin:10px 0; font-weight:bold;}
.noticePage .red{ color:#ff3300;}
.noticePage .link a{ font-size:14px; line-height:24px; color:#115ec7;}
.noticePage .link a:hover{ text-decoration:underline;}
</style>
</head>
<body class="" style="background:#fff;">
<div class="noticePage animated fadeInUp">
    <div class="img">
        <?php if ($_smarty_tpl->tpl_vars['pager']->value['error']&&$_smarty_tpl->tpl_vars['pager']->value['error']!=200){?>
        <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/clew-error.gif" alt="" />
        <?php }else{ ?>
        <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/clew-success.gif" alt="" />
        <?php }?>
    </div>
    <p class="big"><?php echo $_smarty_tpl->tpl_vars['pager']->value['message'];?>
</p>
    <p><span class="red" id="timer_span"><?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
</span>秒之后页面自动跳转</p>
    <P class="link"><a href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
" class="red">如没有跳转,点击这里立即跳转</a></P>
</div>
<script type="text/javascript">

var timer = parseInt(<?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
);
window.onload = function(){
    window.setInterval(function(){
        if(timer < 1){
            window.clearInterval();
            window.location.href = "<?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
";
            return ;
        }
        timer --;
        $('#timer_span').text(timer);
    }, 1000);
}
</script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>