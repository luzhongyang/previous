<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:20:54
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/position.html" */ ?>
<?php /*%%SmartyHeaderCode:1223876557b28696919ad6-85092585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9d54f9839d17aa88ad48f1f77824a57388e5bef' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/position.html',
      1 => 1470380629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1223876557b28696919ad6-85092585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'addr_list' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b286969728d3_61428025',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b286969728d3_61428025')) {function content_57b286969728d3_61428025($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
    <header>
        <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
        <div class="title">
            
        </div>
        <i class="right"><a href="<?php echo smarty_function_link(array('ctl'=>'city'),$_smarty_tpl);?>
" link-load="" link-type="right">切换城市</a></i> 
    </header>
    <section class="page_center_box" style="height:100%">
        <div class="sy_search">
            

    <div class="orderAddr">
        <div class="orderAddr_list">
            <div class="fl"><i class="ico_3"></i></div>
            <div class="orderAddr_int">
                <input type="text" value="" placeholder="请输入您所在的位置" id="suggestId">
            </div>
            <div class="clear"></div>
        </div>
        <div class="long_btn_box">
            <input type="button"  value="确定" class="long_btn">
        </div>
     </div>
            <div class="order_details_nr">                
                <ul class="form_list_box" id="search_box">
                </ul>                
                <ul class="form_list_box">
                    <!--<li class="list">
                        <div class="fl"><p class="maincl">定位到当前位置</p></div>
                        <div class="fr"><a class="sy_posit_btn" href="#"></a></div>
                    </li>-->                    
                    <?php if ($_smarty_tpl->tpl_vars['addr_list']->value){?>
                    <li class="list bt">
                        <p class="black9" style="color:#ff0000;">我的收货地址</p>
                    </li>
                    <?php }?>                
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addr_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <li class="list addr" addr='{"lng":"<?php echo $_smarty_tpl->tpl_vars['v']->value['lng'];?>
","lat":"<?php echo $_smarty_tpl->tpl_vars['v']->value['lat'];?>
","addr":"<?php echo $_smarty_tpl->tpl_vars['v']->value['house'];?>
"}'>
                        <p class="addr_p" ><?php echo $_smarty_tpl->tpl_vars['v']->value['contact'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['mobile'];?>
</p>
                        <p><?php echo $_smarty_tpl->tpl_vars['v']->value['addr'];?>
,<?php echo $_smarty_tpl->tpl_vars['v']->value['house'];?>
</p>
                    </li>
                    <?php } ?> 
                </ul>
            </div>
        </div>
        </section>        

        <script type="text/javascript">
        $(document).ready(function(){
            getUxLocation(function(ret){
                //在这里处理 ret{lnt, lat, addr}
            });           
            var now_city_name = Cookie.get("UxCity");
            if(!now_city_name){
                $('.title').text('还未选择城市');
                window.location.href='<?php echo smarty_function_link(array('ctl'=>"city"),$_smarty_tpl);?>
';
            }else{
                $('.title').text(now_city_name);
            }
            
            $('.long_btn').click(function(){                
                var addr_name = $('#suggestId').val();
                placeapi(addr_name, now_city_name, function(ret){
                    if(ret.results.length>0){
                        var html = '';
                        $.each(ret.results,function(n,value){
                            if(typeof(value.location) == 'object'){
                                html += '<li class="list addr" addr=\'{"lng":"'+value.location.lng+'","lat":"'+value.location.lat+'","addr":"'+value.name+'"}\' >';
                                if(value.address != undefined){
                                    html += '<p class="addr_p" >'+value.address+'</p>';
                                }
                                html += '<p>'+value.name+'</p></li>';
                            }
                        });
                        $('#search_box').html(html);                        
                    }else{
                        $('#search_box').html('<li class="list addr"><p class="addr_p">暂时没有找到您查询的信息</p></li>');
                    }
                })                
            })
            $(".form_list_box").on('click', 'li[addr]', function (){
                var addr = {};
                try{
                    addr = JSON.parse($(this).attr("addr"));
                    Cookie.set("UxLocation", JSON.stringify(addr), 86400);
                    location.href = "<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
";
                }catch(e){
                    alert(e);
                }
            });
        });
        </script>
    </body>
</html><?php }} ?>