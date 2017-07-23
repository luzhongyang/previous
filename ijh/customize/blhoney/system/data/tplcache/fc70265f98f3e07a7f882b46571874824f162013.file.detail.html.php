<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:28:51
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/hotstyle/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:210406306257b2b2a37826e4-58457764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc70265f98f3e07a7f882b46571874824f162013' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/hotstyle/detail.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '210406306257b2b2a37826e4-58457764',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
    'pager' => 0,
    'detail' => 0,
    'other' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b2a38198f0_66443792',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b2a38198f0_66443792')) {function content_57b2b2a38198f0_66443792($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<header> <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'hotstyle:index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title"> 发型详情 </div>
    <i class="right"><a class=""></a></i> 
</header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
<section class="page_center_box">
    <div class="hotstyleXq"> 
        <!--banner部分 -->
        <div class="">
            <div class="flexslider">
                <ul class="slides">
                    <li class="list"> 
                    <a href="javascript:void(0);"> <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['thumb'];?>
"></a> 
                    </li>
                </ul>
            </div>
        </div>
        <!--banner部分结束--> 
        <!--内容-->
        <div class="xiangqing bgcolor_white mb10">
            <h3><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</h3>
            <div class="miaoshu">发型详情描述：<br/><span class="black6"><?php echo nl2br($_smarty_tpl->tpl_vars['detail']->value['desc']);?>
</span></div>
        </div>
        <div class="more bgcolor_white">
            <h3><span></span>更多发型</h3>
            <div class="hotstyle_list_box">
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <li class="hotstyle_list">
                        <div class="box"> 
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['article_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'hotstyle:detail','args'=>$_tmp1),$_smarty_tpl);?>
"> 
                                <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb'];?>
"/>
                            </a>
                       </div>
                        <div class="nr overflow_clear">时尚斜刘海长直发梨花头</div>
                    </li>
                    <?php } ?>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
        <!--内容end--> 
    </div>
</section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<style type="text/css">.page_center_box{bottom:0;}</style>
<?php }?>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $('.flexslider').flexslider({
            directionNav: true,
            pauseOnAction: false,
        });//轮播js结束
    });
</script><?php }} ?>