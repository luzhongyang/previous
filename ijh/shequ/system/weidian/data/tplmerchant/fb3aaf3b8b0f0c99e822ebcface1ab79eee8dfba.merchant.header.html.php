<?php /* Smarty version Smarty-3.1.8, created on 2016-12-21 16:39:19
         compiled from "merchant:block/header.html" */ ?>
<?php /*%%SmartyHeaderCode:289195833e2b97a67f7-52574087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb3aaf3b8b0f0c99e822ebcface1ab79eee8dfba' => 
    array (
      0 => 'merchant:block/header.html',
      1 => 1481695164,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '289195833e2b97a67f7-52574087',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e2b982aec1_16617430',
  'variables' => 
  array (
    'seo_sub_title' => 0,
    'seo_title' => 0,
    'SEO' => 0,
    'CONFIG' => 0,
    'pager' => 0,
    'menu_list' => 0,
    'v' => 0,
    'vv' => 0,
    'request' => 0,
    'shop' => 0,
    'ctlmenu' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e2b982aec1_16617430')) {function content_5833e2b982aec1_16617430($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($_smarty_tpl->tpl_vars['seo_sub_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_sub_title']->value;?>
_<?php }?><?php if ($_smarty_tpl->tpl_vars['seo_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_title']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?>商户管理-<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
<?php }?></title>
    <link href="/merchant/style/css/bootstrap.min.css" rel="stylesheet">
    <link href="/merchant/style/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/merchant/style/css/animate.css" rel="stylesheet">
    <link href="/merchant/style/css/style.css" rel="stylesheet">
    <link href="/merchant/style/css/layer.css" rel="stylesheet">
    <link href="/merchant/style/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/merchant/style/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

    <!--部分页面引入样式-->
    <link href="/merchant/style/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="/merchant/style/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/merchant/style/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!--switchery开关-->
    <link href="/merchant/style/css/plugins/switchery/switchery.css" rel="stylesheet">

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


    <!--部分页面引入js-->
    <script src="/merchant/script/js/plugins/dataTables/datatables.min.js"></script>
    <script src="/merchant/script/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="/merchant/script/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!--switchery开关-->
    <script src="/merchant/script/js/plugins/switchery/switchery.js"></script>

    <script src="/merchant/script/js/plugins/chartJs/Chart.min.js"></script>
   <!--  搜索js -->
    <script src="/merchant/script/js/search.js"></script>

    <script src="/merchant/script/js/jquery.qrcode.min.js" type="text/javascript" charset="utf-8"></script>

    <style type="text/css" media="screen">
    .navbar-form-custom .form-control{ width:285px; border:1px solid #e7eaec; border-right:0 none;}
    .input-group-btn{ width:auto;}
    .navbar-form-custom{ margin-top:13px;}
    .navbar-form-custom{ width:auto; height:auto;}
    .navbar-form-custom .form-control{ height:auto;}
    .minimalize-styl-2{ margin:14px 15px 5px 20px;}
    </style>
</head>

<body class="">
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <a href="javascript:;" data-index="0" class="">商户中心</a>
                    <span class="img"></span>
                </li>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['v']->value['menu']){?>
                <li<?php if ($_smarty_tpl->tpl_vars['v']->value['active']){?> class="active"<?php }?>> <a href='javascript:;'><i class='<?php echo $_smarty_tpl->tpl_vars['v']->value['icon'];?>
'></i> <span class='nav-label'><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</span> <span class='fa arrow'></span></a>
                    <ul class='nav nav-second-level collapse<?php if ($_smarty_tpl->tpl_vars['v']->value['active']){?> collapse in<?php }?>'>
                        <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['vv']->value['menu']){?>
                        <li<?php if ($_smarty_tpl->tpl_vars['vv']->value['active']||$_smarty_tpl->tpl_vars['request']->value['ctlmap']['nav']==$_smarty_tpl->tpl_vars['vv']->value['ctl']){?> class="active"<?php }?>> <a href="<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['vv']->value['ctl']),$_smarty_tpl);?>
"><i class=''></i><?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</a> </li>
                        <?php }?>
                        <?php } ?>
                    </ul>
                </li>
                <?php }?>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom navbar-static-top_box ">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header col-sm-8">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                    <form role="search" class="navbar-form-custom" id="search_form" action="<?php echo smarty_function_link(array('ctl'=>'merchant/weidian/order:index'),$_smarty_tpl);?>
" method="post">                
                        <div class="form-group">
                            <!-- <input type="text" placeholder="搜索" class="form-control" name="top-search" id="top-search"> -->
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button tabindex="-1" class="btn btn-white" id="selectBoxInput" type="button">外卖订单</button>
                                    <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"><span class="caret"></span></button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a  hel="waimai" rel="<?php echo smarty_function_link(array('ctl'=>'waimai/order:so'),$_smarty_tpl);?>
">外卖订单</a>
                                        </li>
                                        <li><a  hel="tuan" rel="<?php echo smarty_function_link(array('ctl'=>'tuan/order:index'),$_smarty_tpl);?>
">团购订单</a>
                                        </li>
                                        <li><a  hel="weidian" rel="<?php echo smarty_function_link(array('ctl'=>'weidian/order:index'),$_smarty_tpl);?>
">微店订单</a>
                                        </li>
                                        <li><a  hel="pintuan" rel="<?php echo smarty_function_link(array('ctl'=>'weidian/pintuanorder:index'),$_smarty_tpl);?>
">拼团订单</a>
                                        </li>
                                        <li><a  hel="yuyue" rel="<?php echo smarty_function_link(array('ctl'=>'yuyue/order:paidui'),$_smarty_tpl);?>
">排号订单</a>
                                        </li>
                                        <li><a  hel="dingzuo" rel="<?php echo smarty_function_link(array('ctl'=>'yuyue/order:dingzuo'),$_smarty_tpl);?>
">订座订单</a>
                                        </li>
                                        <li><a  hel="fenxiao" rel="<?php echo smarty_function_link(array('ctl'=>'weidian/fenxiao:orders'),$_smarty_tpl);?>
">分销订单</a>
                                        </li>
                                    </ul>
                                </div>
								<input type="text" placeholder="订单编号/手机号/地址" class="form-control" name="keyword" value="<?php echo $_smarty_tpl->tpl_vars['pager']->value['keyword'];?>
" id="top-search">
								<button type="submit" class="btn btn-primary">搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"><?php echo $_smarty_tpl->tpl_vars['shop']->value['title'];?>
，欢迎回来！</span>
                    </li>
                    <li><a href="<?php echo smarty_function_link(array('ctl'=>'account:loginout'),$_smarty_tpl);?>
"> <i class="fa fa-sign-out"></i> 退出 </a></li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper border-bottom  white-bg navbar-static-top_box"
             style="padding: 10px; margin: 10px 0 0px 0; border-radius: 3px;">
            <div class="col-lg-10">
                <ol class="breadcrumb">
                    <li><a href='#'><?php echo $_smarty_tpl->tpl_vars['ctlmenu']->value['title'];?>
</a></li>
                    <li  class='active'><a href='<?php echo smarty_function_link(array('ctl'=>$_smarty_tpl->tpl_vars['request']->value['tlmap']['ctl']),$_smarty_tpl);?>
'><strong><?php echo $_smarty_tpl->tpl_vars['request']->value['ctlmap']['title'];?>
</strong></a></li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
<?php }} ?>