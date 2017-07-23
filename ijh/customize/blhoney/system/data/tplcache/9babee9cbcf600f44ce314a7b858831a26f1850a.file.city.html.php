<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:14:54
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/city.html" */ ?>
<?php /*%%SmartyHeaderCode:184110193057b2852ecab926-50056213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9babee9cbcf600f44ce314a7b858831a26f1850a' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/city.html',
      1 => 1470380629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '184110193057b2852ecab926-50056213',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'city_list' => 0,
    'k' => 0,
    'v' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2852ecf9876_48018982',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2852ecf9876_48018982')) {function content_57b2852ecf9876_48018982($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>

        
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
"  link-load="" link-type="right" class="gobackIco"></a></i>
    <div class="title">
    	切换城市
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
	<ul class="form_list_box sy_search">
    	<li class="list">
            <p class="black9">定位到当前城市:  定位不准时请在列表中选择</p>
        </li>
        <li class="list last">
            <div class="fl"><h2 class="maincl"></h2></div>
            <div class="fr"><a href="#" class="sy_posit_btn"></a></div>
        </li>
    </ul>
    
    
    
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
    
    <div class="cities_wrapper">
    	<h4 class="title"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
<small class="">（按字母排序）</small></h4>
        <div class="cities">
                <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_smarty_tpl->tpl_vars['kk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['kk']->value = $_smarty_tpl->tpl_vars['vv']->key;
?>
                <a class="city" href="javascript:void(0);" val='<?php echo $_smarty_tpl->tpl_vars['vv']->value['city_name'];?>
' cityid='<?php echo $_smarty_tpl->tpl_vars['vv']->value['city_id'];?>
'><?php echo $_smarty_tpl->tpl_vars['vv']->value['city_name'];?>
</a>
                <?php } ?>
        </div>
    </div>
   
    
    <?php } ?>
    
</section>

        
        <script>
           $(document).ready(function(){
               var now_city_name = Cookie.get("UxCity");
               if(!now_city_name){
                   now_city_name = '请选择城市';
               }
               $('.maincl').text(now_city_name);
               $('.city').click(function(){
                   var cityname = $(this).attr('val');
                   var cityid = $(this).attr('cityid');
                   Cookie.set("UxCity",cityname,86400*30);
                   Cookie.set("UxCityId",cityid,86400*30);
                   location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
               })
           })
        </script>
        
    </body>
</html><?php }} ?>