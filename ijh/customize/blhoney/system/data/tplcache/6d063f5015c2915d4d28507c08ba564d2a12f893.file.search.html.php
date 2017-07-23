<?php /* Smarty version Smarty-3.1.8, created on 2016-08-18 14:41:25
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/search.html" */ ?>
<?php /*%%SmartyHeaderCode:120257452657b55895e7fed6-93515465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d063f5015c2915d4d28507c08ba564d2a12f893' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/search.html',
      1 => 1470380629,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '120257452657b55895e7fed6-93515465',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tips' => 0,
    'shops' => 0,
    'v' => 0,
    'pager' => 0,
    'first_amount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b55895f1cc43_95006628',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b55895f1cc43_95006628')) {function content_57b55895f1cc43_95006628($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body> 
    <header>
        <form action="<?php echo smarty_function_link(array('ctl'=>'search/index'),$_smarty_tpl);?>
" method="post">
        <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'index'),$_smarty_tpl);?>
" link-load="" link-type="right" class="gobackIco"></a></i>
        <div class="title">
            <div class="searchBox">
                <input type='hidden' name='lat' id="lat">
                <input type='hidden' name='lng' id="lng">
                <input type="text" name='title' placeholder="搜索商家或地点"/>
            </div>
        </div>
        <i class="right"><input class="road_sub" type="submit" value="搜索"/></i> 
    </header>
        
        <section class="page_center_box">

                <div class="waimaiList">

                <?php if ($_smarty_tpl->tpl_vars['tips']->value){?>
                    <div class="youhui_no">
                        <div class="iconBg"><i class="ico7"></i> </div>
                        <h2><?php echo $_smarty_tpl->tpl_vars['tips']->value;?>
</h2>
                    </div>
                    
                <?php }else{ ?>    
                <ul>
                 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shops']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>  
                 <li class="list">
                     <div class="img fl"><a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['shop_id']),$_smarty_tpl);?>
" link-load=""><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['logo'];?>
" width="100" height="100" /></a></div>
                    <div class="wz">
                        <div class="nr1">
                            <div class="fl">
                                <a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','args'=>$_smarty_tpl->tpl_vars['v']->value['shop_id']),$_smarty_tpl);?>
" link-load="">
                                    <p class="bt overflow_clear"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</p>
                                    <div><span class="starBg"><span class="star" style="width:<?php echo $_smarty_tpl->tpl_vars['v']->value['score']*20;?>
%;"></span></span></div>
                                    <p class="black9">接单<?php echo $_smarty_tpl->tpl_vars['v']->value['orders'];?>
次</p>
                                </a>
                            </div>
                            <div class="fr">
                                <p class="black9"><span class="maincl">￥<b><?php echo $_smarty_tpl->tpl_vars['v']->value['min_amount'];?>
</b></span>起</p>
                                <p class="black9 mt10 juli"><?php echo $_smarty_tpl->tpl_vars['v']->value['juli'];?>
</p>
                            </div>
                        </div>
                        <div class="nr2">
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['first_amount']>0){?>
                            <p class="black9"><em style="background:#46c3ff;">首</em>新用户首次下单立减<?php echo $_smarty_tpl->tpl_vars['first_amount']->value;?>
元</p>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['youhui_title']){?>
                            <p class="black9"><em style="background:#ff6900;">减</em><?php echo $_smarty_tpl->tpl_vars['v']->value['youhui_title'];?>
</p>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['online_pay']==1){?>
                            <p class="black9"><em style="background:#f57f8c;">付</em>商家支持在线支付</p>
                            <?php }?>
                        </div>
                    </div>
                </li>
                <?php } ?>
                <?php }?>
                </ul>
                
            </div>
        </section>

        <script>
            getUxLocation(function(ret){
                if(ret.error){
                    alert(ret.message);
                    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'position'),$_smarty_tpl);?>
";
                }else{
                    var lat = ret.lat;
                    var lng = ret.lng;
                    $('#lat').val(lat);
                    $('#lng').val(lng);
                }
            });

            var juli = $('.juli').text();
            juli = formatDistance(juli);
            $('.juli').text(juli);
        </script>
    </body>
</html><?php }} ?>