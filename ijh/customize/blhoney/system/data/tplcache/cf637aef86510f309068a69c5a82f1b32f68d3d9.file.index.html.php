<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:18:54
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/video/index.html" */ ?>
<?php /*%%SmartyHeaderCode:107608253357b2861e9fd1d1-26027219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf637aef86510f309068a69c5a82f1b32f68d3d9' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/video/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107608253357b2861e9fd1d1-26027219',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
    'banners' => 0,
    'pager' => 0,
    'v' => 0,
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2861ea63960_01810645',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2861ea63960_01810645')) {function content_57b2861ea63960_01810645($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
            <div class="title">
                视频秀
            </div>
            <i class="right"><a class=""></a></i>
        </header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
        <section class="page_center_box">
        	<div class="shipin">
                <!--banner部分-->
                <div class="banner mb10">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['banners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <li class="list">
                            	<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb'];?>
">
                                <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['article_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'video:detail','args'=>$_tmp1),$_smarty_tpl);?>
">
                                <div class="video_mask">
                            	<table width="100%" height="100%" border="0" align="center">
                                	<tr>
                                    	<td valign="middle"><img src="/themes/default/static/images/video/vedio_icon1.png"/></td>
                                    </tr>
                                </table>		
                                </div>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--banner部分结束-->
                <!--视频列表-->
                <div class="video_list_box">
                	<ul>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <li class="video_list">
                            <div class="box">
                            	<img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb'];?>
"/>
                                <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['article_id'];?>
<?php $_tmp2=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'video:detail','args'=>$_tmp2),$_smarty_tpl);?>
">
                                <div class="nr">
                                	<table width="100%" height="100%" border="0" align="center">
                                        <tr>
                                            <td valign="middle">
                                            	<p><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                                            	<img src="/themes/default/static/images/video/vedio_icon1.png" class="ico"/>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                </a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <!--视频列表end-->
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