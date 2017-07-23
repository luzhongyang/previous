<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 15:29:02
         compiled from "view:page/notice.html" */ ?>
<?php /*%%SmartyHeaderCode:97097613757b2c0be183611-22271280%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4726972748e23f1b8d6d136249b447af2846f4a9' => 
    array (
      0 => 'view:page/notice.html',
      1 => 1470380612,
      2 => 'view',
    ),
  ),
  'nocache_hash' => '97097613757b2c0be183611-22271280',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CONFIG' => 0,
    'msgnum' => 0,
    'pager' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2c0be216997_95527648',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2c0be216997_95527648')) {function content_57b2c0be216997_95527648($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>

    <body>
        <header>
            <i class="left"></i>
            <div class="title"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
 - 系统提示！</div>
            <i class="right"></i>
        </header>
        
        <header>
        <i class="left"><a class="bell_prompt" href="<?php echo smarty_function_link(array('ctl'=>'mobile/member/message:index','arg'=>1),$_smarty_tpl);?>
"><?php if ($_smarty_tpl->tpl_vars['msgnum']->value>0){?><span class="num"><?php echo $_smarty_tpl->tpl_vars['msgnum']->value;?>
</span><?php }?></a></i>
        <div class="title">我的</div>
        <i class="right"></i>
    </header>
    
    
    <div class="error_box">
            <div style="text-align:center;"><img src="/themes/default/xiche/static/images/<?php if ($_smarty_tpl->tpl_vars['pager']->value['error']){?>404error.png<?php }else{ ?>404success.png<?php }?>" class="error_img" style="margin:0px auto;" /></div>
            <p class="error_p">
                
                <?php if ($_smarty_tpl->tpl_vars['pager']->value['error']){?><span style="color:red;"><?php }else{ ?><span><?php }?><?php echo $_smarty_tpl->tpl_vars['pager']->value['message'];?>
</span>
                
                <br>
                <?php if ($_smarty_tpl->tpl_vars['pager']->value['timer']>0){?>如果您不做出选择，<br>将在 <strong id="notice-timer" style="color:red;"><?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
</strong> 秒后跳转到第一个链接地址。<?php }else{ ?>请选择以下操作。<?php }?><br>
                <?php  $_smarty_tpl->tpl_vars['link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['link']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pager']->value['url_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['link']->key => $_smarty_tpl->tpl_vars['link']->value){
$_smarty_tpl->tpl_vars['link']->_loop = true;
?>
            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/images/icon/link.gif" align="absmiddle" style="margin-right:5px;"/><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value['url'];?>
" style="color: #006699"><?php echo $_smarty_tpl->tpl_vars['link']->value['title'];?>
</a>
            <?php }
if (!$_smarty_tpl->tpl_vars['link']->_loop) {
?>
            <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/images/icon/link.gif" align="absmiddle" style="margin-right:5px;"/><a href="<?php if ($_smarty_tpl->tpl_vars['pager']->value['link']){?><?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
<?php }else{ ?><?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
<?php }?>" style="color: #006699">点击立即跳转</a>
			<?php } ?>
            </p>
            
            
            
    </div>
        
        
        
<?php if (((int)$_smarty_tpl->tpl_vars['pager']->value['timer']>0)){?>
<script type="text/javascript">
var timer = <?php echo $_smarty_tpl->tpl_vars['pager']->value['timer'];?>
;
//var timer = 6000000;
var link = "<?php if ($_smarty_tpl->tpl_vars['pager']->value['link']){?><?php echo $_smarty_tpl->tpl_vars['pager']->value['link'];?>
<?php }else{ ?><?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
<?php }?>";
window.onload = function(){
	if (link == 'javascript:history.go(-1)' && window.history.length == 0){
		document.getElementById('notice-msg').innerHTML = '';
		return;
	}
	window.setInterval(function(){
		if(timer<1){window.clearInterval();
			window.location.href = link;
			return ;
		}
		timer --;
		document.getElementById("notice-timer").inserHTML = timer;
	}, 1000);
}
</script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['pager']->value['appendjs']){?><?php echo $_smarty_tpl->tpl_vars['pager']->value['appendjs'];?>
<?php }?>

        
    </body>
</html>






<?php }} ?>