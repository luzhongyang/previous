<?php /* Smarty version Smarty-3.1.8, created on 2016-12-13 13:37:25
         compiled from "D:\phpStudy\WWW\shequ\themes\default\position.html" */ ?>
<?php /*%%SmartyHeaderCode:3532584f8915a9f2c6-81446762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6617e8ed72384584b8371c979d73181dae2b1ac7' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\position.html',
      1 => 1481006571,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3532584f8915a9f2c6-81446762',
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
  'unifunc' => 'content_584f8915e5f868_64233192',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584f8915e5f868_64233192')) {function content_584f8915e5f868_64233192($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("定位"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <header>
        <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" class="ico headerIco headerIco_3"></a></i>
        <div class="title">

        </div>
        <i class="right"><a href="<?php echo smarty_function_link(array('ctl'=>'city'),$_smarty_tpl);?>
" link-load="" link-type="right">切换城市</a></i>
    </header>


    <div class="lctSer">
        <div class="box">
            <form>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><input type="text" class="text" value="" placeholder="请输入小区名称或首字母搜索"  id="suggestId"></td>
                        <td width="70"><input type="button" class="pub_btn long_btn" value="搜索"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
        <section class="page_center_box" style="height:100%;">

                <ul class="form_list_box" id="search_box">
                </ul>

                <ul class="form_list_box">
                    <!--<li class="list">
                        <div class="fl"><p class="maincl">定位到当前位置</p></div>
                        <div class="fr"><a class="sy_posit_btn" href="#"></a></div>
                    </li>-->
                    <?php if ($_smarty_tpl->tpl_vars['addr_list']->value){?>
                    <li class="list bt">
                        <p class="black9" style="color:#ff0000;height:0.32rem;line-height:0.32rem;padding-left:0.2rem;font-size:0.14rem;margin-top:0.2rem;background:#eeeeee;border-top:1px solid #dddddd;border-bottom:1px solid #dddddd;">我的收货地址</p>
                    </li>
                    <?php }?>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addr_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <li class="serveAddr_cell_list pad10 border_b bgcolor_white" addr='{"lng":"<?php echo $_smarty_tpl->tpl_vars['v']->value['lng'];?>
","lat":"<?php echo $_smarty_tpl->tpl_vars['v']->value['lat'];?>
","addr":"<?php echo $_smarty_tpl->tpl_vars['v']->value['house'];?>
"}'>
                        <div class="ico fl"></div>
                        <div class="pub_wz">
                            <p class="black3"><?php echo $_smarty_tpl->tpl_vars['v']->value['contact'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['mobile'];?>
</p>
                            <p class="black9"><?php echo $_smarty_tpl->tpl_vars['v']->value['addr'];?>
,<?php echo $_smarty_tpl->tpl_vars['v']->value['house'];?>
</p>
                        </div>
                        <div class="clear"></div>
                    </li>
                    <?php } ?>
                </ul>

        </section>

        <script type="text/javascript">
        $(document).ready(function(){
            getUxLocation(function(ret){
                //在这里处理 ret{lnt, lat, addr}
            });
            var now_city_name = localStorage["UxCity"];
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
                                html += '<li class="serveAddr_cell_list pad10 border_b bgcolor_white" addr=\'{"lng":"'+value.location.lng+'","lat":"'+value.location.lat+'","addr":"'+value.name+'"}\' >';
                                html += '<div class="ico fl"></div>';
                                html += '<div class="pub_wz">';

                                if(value.address != undefined){
                                    html += '<p>'+value.address+'</p>';
                                }
                                html += '<p class="black3">'+value.name+'</p>';

                                html += '</div>';
                                html += '<div class="clear"></div>';

                                html += '</li>';
                            }
                        });
                        $('#search_box').html(html);
                    }else{
                        $('#search_box').html('<li class="list addr"><p class="addr_p" style="font-size:0.14rem;height:0.2rem;line-height:0.2rem;text-align:center;">暂时没有找到您查询的信息</p></li>');
                    }
                })
            })
            $(".form_list_box").on('click', 'li[addr]', function (){
                var addr = {};
                try{
                    addr = JSON.parse($(this).attr("addr"));
                    setUxLocation(addr);
                    location.href = "<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
";
                }catch(e){
                    alert(e);
                }
            });
        });
        </script>
<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>