<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 13:27:16
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/help/index.html" */ ?>
<?php /*%%SmartyHeaderCode:212230674057b2a4347c3219-72564183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed7927991b78e234f00c15a2b3234c8e5fc0c633' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/help/index.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212230674057b2a4347c3219-72564183',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
    'detail' => 0,
    'items' => 0,
    'count' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2a4348252a0_21617775',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2a4348252a0_21617775')) {function content_57b2a4348252a0_21617775($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable('服务中心', null, 0);?>
<!DOCTYPE HTML>
<html>
<head>
    <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/index'),$_smarty_tpl);?>
" class="gobackIco"></a></i>
    <div class="title">
        <?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>

    </div>
</header>
<?php }else{ ?>
<style type="text/css">.page_center_box{top:0;}</style>
<?php }?>
<section class="page_center_box">
    <div class="">
        <div class="serve_center mb10"> 
            <a href="tel:"><img src="/themes/default/static/images/kf_img.png"><p>联系客服</p></a>
        </div>
        <ul class="form_list_box">
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['item']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['item']->index++;
?>
            <li class="mineHome_list <?php if ($_smarty_tpl->tpl_vars['item']->index==($_smarty_tpl->tpl_vars['count']->value-1)){?>last<?php }?> ">
                <a href="<?php echo smarty_function_link(array('ctl'=>'help/detail','args'=>$_smarty_tpl->tpl_vars['item']->value['article_id']),$_smarty_tpl);?>
">
                    <p class="fl"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</p>
                    <div class="fr"><em class="linkIco"></em></div>
                    <div class="clear"></div>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php if (!$_smarty_tpl->tpl_vars['request']->value['IN_APP_CLIENT']){?>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?>
<script>
    $(document).ready(function(){
    
        $('#l5').addClass('on');
     
    });
</script>
</body>
</html>
<?php }} ?>