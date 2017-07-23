<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 14:58:04
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/video/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:68908742757b2b606dfdea6-21480226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4e30666b5d2b683e0abb7bd8d73f87cc0582a55' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/video/detail.html',
      1 => 1471676282,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68908742757b2b606dfdea6-21480226',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b606e6b3e5_16183076',
  'variables' => 
  array (
    'request' => 0,
    'detail' => 0,
    'pager' => 0,
    'other' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b606e6b3e5_16183076')) {function content_57b2b606e6b3e5_16183076($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<header>
   <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'video:index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title"> 视频秀详情 </div>
    <i class="right"><a class=""></a> </i> 
    </header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
<section class="page_center_box">
    <!--内容-->
    <div class="shipinXQ mt10">
        <div class="xiangqing">
            <h3 class="wenzi1"><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</h3>
            <p class="black9 mb10"><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['dateline'],'Y-m-d H:i:s');?>
  爱美Home</p>
            <a href="<?php echo $_smarty_tpl->tpl_vars['detail']->value['linkurl'];?>
">
                <!-- <video src="" poster="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['thumb'];?>
"  width="100%" >您的浏览器不支持此种视频格式。</video> -->
                <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['thumb'];?>
" style="width:100%" /> 
            </a>
            <p class="wenzi2"><?php echo $_smarty_tpl->tpl_vars['detail']->value['desc'];?>
</p>
            <div class="img"> <img src="/themes/default/static/images/video/end.png"/>
                <p>【来源于网络，版权归作者所有。如有侵权请速删！】</p>
            </div>
        </div>
        <div class="tuijian">
            <div class="wenzi3">视频推荐</div>
            <div class="video_list_box">
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['other']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <li class="video_list">
                        <div class="box"> <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['thumb'];?>
"/>
                            <a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['v']->value['article_id'];?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'video:detail','args'=>$_tmp1),$_smarty_tpl);?>
">
                            <div class="nr">
                                <table width="100%" height="100%" border="0" align="center">
                                    <tr>
                                        <td valign="middle">
                                            <p><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                                            <img src="/themes/default/static/images/video/vedio_icon1.png" class="ico"/> </td>
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
        </div>
    </div>
    
    <!--内容end--> 
</section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
<style type="text/css">.page_center_box{bottom:0;}</style>
<?php }?>
</body>
</html><?php }} ?>