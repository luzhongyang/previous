<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:39
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/youhui.html" */ ?>
<?php /*%%SmartyHeaderCode:3591640557b2af13687107-23628807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f53dbd826bfbe96170425ace955c51b55fc6bb1d' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/youhui.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3591640557b2af13687107-23628807',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af136d60c1_65455067',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af136d60c1_65455067')) {function content_57b2af136d60c1_65455067($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="ucenter_t">
	<ul>
            <li class="on"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:youhui'),$_smarty_tpl);?>
">优惠列表</a></li>
	</ul>
	<span class="r"><a href="javascript:void(0);"  class="btn btn-success jq_add">+新增一行</a></span>
</div>

<div class="ucenter_c">
    <form id="post_form" action="<?php echo smarty_function_link(array('ctl'=>'biz/shop/youhui'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
        <table cellspacing="0" cellpadding="0" class="table">
            <tr>
                <th>满多少</th>
                <th>减多少</th>
                <th>操作</th>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <tr class="jq_tr" id="youhui_<?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_id'];?>
">
                <td><input type="text" class="input w-100" name="data[order_amount][]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['order_amount'];?>
" /></td>
                <td><input type="text" class="input w-100" name="data[youhui_amount][]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_amount'];?>
" /></td>
                <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop/yhdelete','youhui_id'=>$_smarty_tpl->tpl_vars['item']->value['youhui_id']),$_smarty_tpl);?>
" mini-act="remove:youhui_<?php echo $_smarty_tpl->tpl_vars['item']->value['youhui_id'];?>
" mini-confirm="确认要删除吗？" class="btn btn-warning">删除</a></td>
            </tr>            
            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
            <tr class="jq_tr"><td colspan="20"><div class="alert alert-info">没有数据</div></td></tr>
            <?php } ?>
        </table>
        <div><div class="jq_bottom"><input type="submit" class="btn btn-primary jq_save" value="保存数据"/></div></div>
    </form>
</div>
<script>
$(document).ready(function(){
    $(".jq_add").click(function(){
        var html = '<tr class="jq_tr">';
        html+='<td><input type="text" class="input w-100" name="data[order_amount][]" value="" /></td>';
        html+='<td><input type="text" class="input w-100" name="data[youhui_amount][]" value="" /></td>';
        html+='<td><a href="javascript:void(0);" class="btn btn-warning jq_delete">移除</a></td></tr>';
        $(".table").append(html);
    })
    $(".table").on('click','.jq_delete', function () {
        $(this).parent().parent().remove();
    })
})    
</script>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>