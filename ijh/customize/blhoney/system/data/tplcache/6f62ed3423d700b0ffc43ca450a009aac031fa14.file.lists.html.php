<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 10:36:12
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/hongbao/lists.html" */ ?>
<?php /*%%SmartyHeaderCode:67967595757b3cd9c108d98-30524552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f62ed3423d700b0ffc43ca450a009aac031fa14' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/hongbao/lists.html',
      1 => 1470380642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67967595757b3cd9c108d98-30524552',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'MEMBER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b3cd9c1597c3_44996433',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b3cd9c1597c3_44996433')) {function content_57b3cd9c1597c3_44996433($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
    <body>
        <header>
            <i class="left"><a href="javascript:history.go(-1);" class="gobackIco"></a></i>
            <div class="title">
                我的红包
            </div>
        </header>
        <section class="page_center_box">
            <div>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <div class="redBag_list" rel="<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao_id'];?>
">
                    <div class="redBag_top" style="background:#1ec0be;">
                        <div class="fl"><small>￥</small><big class="amount_<?php echo $_smarty_tpl->tpl_vars['item']->value['hongbao_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['amount'];?>
</big></div>
                        <div class="fl">
                            <h4><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</h4>
                            <p>满<?php echo $_smarty_tpl->tpl_vars['item']->value['min_amount'];?>
元可用</p>
                        </div>
                        <div class="clear"></div>
                        <div class="redBag_bg"></div>
                    </div>
                    <div class="redBag_bottom">
                        <p>此红包限手机尾号<?php echo substr($_smarty_tpl->tpl_vars['MEMBER']->value['mobile'],-4);?>
的用户使用</p>
                        <p>有效期至：<?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['ltime'],'Y.m.d');?>
</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
        <script>
            var shop_id = localStorage.getItem('shop_id');
            $('.redBag_list').click(function () {
                var hongbao_id = $(this).attr('rel');
                var amount = $(".amount_" + $(this).attr('rel')).html();
                localStorage.setItem('hongbao_id', hongbao_id);
                localStorage.setItem('amount', amount);
                var link = "<?php echo smarty_function_link(array('ctl'=>'order/order','args'=>'oooo'),$_smarty_tpl);?>
";
                var url = link.replace('oooo', shop_id);
                setTimeout(function () {
                    window.location.href = url;
                }, 500);
            })
        </script>
    </body>
</html>
<?php }} ?>