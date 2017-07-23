<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:13:32
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/msg/index.html" */ ?>
<?php /*%%SmartyHeaderCode:157045017157b2af0c3d0ce5-71265585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a10e19ec0409efaa90072e630aaa3c49f24451aa' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/msg/index.html',
      1 => 1470380632,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157045017157b2af0c3d0ce5-71265585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'newmsg' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2af0c43ea59_47821748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2af0c43ea59_47821748')) {function content_57b2af0c43ea59_47821748($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
	<ul id='tab_1'>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/msg:order'),$_smarty_tpl);?>
" >订单消息</a>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/msg:comment'),$_smarty_tpl);?>
" >评价消息</a>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/msg:complain'),$_smarty_tpl);?>
" >投诉消息</a>
		<a href="<?php echo smarty_function_link(array('ctl'=>'biz/msg:system'),$_smarty_tpl);?>
" >系统消息</a>
	</ul>
</div>
<div class="ucenter_c">
    <table cellspacing="0" cellpadding="0" class="table">
    <tr class="alt">
        <th class="w-100">是否新消息</th>
	    <th class="w-100">标题</th>
	    <th class="w-100">内容</th>
	    <th class="w-150">时间</th>
	    <th class="w-150">操作</th>
    </tr>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <tr>
        <td><?php if ($_smarty_tpl->tpl_vars['item']->value['is_read']==0){?>新消息<?php }elseif($_smarty_tpl->tpl_vars['item']->value['is_read']==1){?>已读<?php }else{ ?><?php }?></td>   
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>         
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</td>
        <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline'],'Y-m-d H:i');?>
</td>
        <td><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:detail','args'=>$_smarty_tpl->tpl_vars['item']->value['order_id']),$_smarty_tpl);?>
" onclick="sendmsgid(<?php echo $_smarty_tpl->tpl_vars['item']->value['msg_id'];?>
);" class="btn btn-success" title="查看">查看</a></td>
    </tr>
    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
    <tr><td colspan="20"><div class="alert alert-info"><?php echo $_smarty_tpl->tpl_vars['newmsg']->value;?>
</div></td></tr>
    <?php } ?>
    <tr>
    </table>
    <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script>
 $("#tab_1 a").each(function(){  
    $this = $(this);  
    if($this[0].href==String(window.location)){  
        $this.addClass("on");  
    }  
});  

function sendmsgid(msg_id) {
    localStorage['shop_msg_id'] = msg_id;
}

</script><?php }} ?>