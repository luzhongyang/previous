<?php /* Smarty version Smarty-3.1.8, created on 2016-12-13 13:37:28
         compiled from "D:\phpStudy\WWW\shequ\themes\default\city.html" */ ?>
<?php /*%%SmartyHeaderCode:23675584f8918b5a6c2-43725164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66725b4d74bba476dccc1dc3ae47653594c5ae44' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\city.html',
      1 => 1477880440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23675584f8918b5a6c2-43725164',
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
  'unifunc' => 'content_584f8918bca397_30779572',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584f8918bca397_30779572')) {function content_584f8918bca397_30779572($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("切换城市"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
    <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
"  link-load="" link-type="right" class="ico headerIco headerIco_3"></a></i>
    <div class="title">
        切换城市
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">

    <div class="city_box">
        <ul>
            <li class="box_list">
                <p>当前定位城市</p>
                <ul class="city_list_inline">
                    <li><a href="#"><em class="ico lctIco"></em><span class="maincl">合肥</span></a></li>
                </ul>
            </li>
        </ul>
    </div>


    <div class="city_fixed">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <li><a href="#a<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</a></li>
            <?php } ?>
        </ul>
    </div>

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
        <div class="cities" id="a<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
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
               localStorage.setItem('UxCity', cityname);
               localStorage.setItem('UxCityId', cityid);
               Cookie.set("UxCityId",cityid, 86400*30);
               location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
           })
       })
    </script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>