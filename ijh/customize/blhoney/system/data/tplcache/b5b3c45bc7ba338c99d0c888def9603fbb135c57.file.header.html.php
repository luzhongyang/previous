<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:10:30
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/block/header.html" */ ?>
<?php /*%%SmartyHeaderCode:3553648357b28426d76885-90436275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5b3c45bc7ba338c99d0c888def9603fbb135c57' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/block/header.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3553648357b28426d76885-90436275',
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
    'VER' => 0,
    'ctlgroup' => 0,
    'shop' => 0,
    'menu_list' => 0,
    'menu' => 0,
    'item' => 0,
    'request' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28426e37db0_74548919',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28426e37db0_74548919')) {function content_57b28426e37db0_74548919($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($_smarty_tpl->tpl_vars['seo_sub_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_sub_title']->value;?>
_<?php }?><?php if ($_smarty_tpl->tpl_vars['seo_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_title']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?>商户管理-<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
<?php }?></title>
<link rel="stylesheet" href="http://apps.bdimg.com/libs/fontawesome/4.2.0/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/jBox/jBox.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/style/kt.widget.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/style/common.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" type="text/css" />
<link type="text/css" rel="stylesheet" href="/themes/default/biz/static/css/public.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" />
<link type="text/css" rel="stylesheet" href="/themes/default/biz/static/css/style.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" />
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/alerts.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/forms.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/tables.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/buttons.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/gicons.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/append.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"/>
<script type="text/javascript"  src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/kt.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
<script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/jBox/jBox.min.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
<script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/layer/layer.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/kt.j.js"></script>
<script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.msgbox.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/highcharts/modules/no-data-to-display.js"></script>
<script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/html2canvas.min.js"></script>
<script src="/themes/default/biz/static/script/printArea.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">
.ucenter_c table input.input,.ucenter_c table .select { height:34px; line-height:30px; }
.ucenter_c table .input, .ucenter_c table .select{height:34px; line-height:30px; }
.ucenter_c table input[type="file"] { display:inline; }
a.pbtn,
a.pbtnc { height:26px; }
.btn-xs, .btn-group-xs>.btn {
padding: 2px 8px;
font-size: 12px;
line-height: 1.5;
border-radius: 3px;
}
</style>
</head>
<body class="smallpage" style="background:#E7E8EB;">
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>
<!--头部内容开始-->
<div class="wheader">
	<div class="mainwd">
            <div class="lt"> <a href="javascript:void(0)"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['theme'];?>
/default/biz/static/images/sjlogo.png" ></a> </div>
		<div class="header_nav lt">
			<ul>
				<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/index'),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->tpl_vars['ctlgroup']->value=='index'){?> class="current"<?php }?>>首页</a></li>
				<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:index'),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->tpl_vars['ctlgroup']->value=='product'){?> class="current"<?php }?>>订单</a></li>
			</ul>
		</div>
		<div class="rt header_name"> <span class="in lt"><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
，欢迎回来</span>
			<div class="adminBox lt">
				<div class="adminBox_re"><span class="login_ico denglu_ico"></span>账户</div>
				<div class="adminBox_po">
					<ul>
						<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/index'),$_smarty_tpl);?>
">首页</a></li>
						<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
">设置</a></li>
						<li><a href="<?php echo smarty_function_link(array('ctl'=>'biz/account:loginout'),$_smarty_tpl);?>
">退出</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="cl"></div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="/themes/default/biz/static/css/ucenter.css">
<div id="wrap">
<div class="content" id="ucenter_main_lay">
<div class="cont_lt lt" id="ucenter_left_lay">
	<ul class="menu_lay">
		<?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['menu']->value['menu']){?>
		<li class="hasChild"> 
			<a href="javascript:;"><span class="icon iconOpen"></span><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</a>
			<ul class="menu_children">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['menu']){?>
				<li><a href="<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['item']->value['ctl']),$_smarty_tpl);?>
"<?php if ($_smarty_tpl->tpl_vars['request']->value['ctlmap']['ctl']==$_smarty_tpl->tpl_vars['item']->value['ctl']||$_smarty_tpl->tpl_vars['request']->value['ctlmap']['nav']==$_smarty_tpl->tpl_vars['item']->value['ctl']){?> class="on"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a></li>
				<?php }?>
				<?php } ?>
			</ul>
		</li>
        <?php }?>
		<?php } ?>
	</ul>
</div>
<script type="text/javascript">
    (function(K, $){
        $("menu_lay li.menu").click(function(){
            if($(this).hasClass("open")){
                $(this).removeClass("open").addClass("close");
                $(this).next("ul.sub_menu").slideUp("fast");
            }else{
                $(this).removeClass("close").addClass("open");
                $(this).next("ul.sub_menu").slideDown("fast");    
            }
        });		
		$(".header_name .adminBox").mouseover(function(){
                $(this).find(".adminBox_re").addClass("adminBox_on");
                $(this).find(".adminBox_po").show();
            }).mouseleave(function(){
                $(this).find(".adminBox_re").removeClass("adminBox_on");
                $(this).find(".adminBox_po").hide();
        });
    })(window.KT, window.jQuery);
    </script>
<div class="cont_rt rt" id="ucenter_right_lay">
<?php }} ?>