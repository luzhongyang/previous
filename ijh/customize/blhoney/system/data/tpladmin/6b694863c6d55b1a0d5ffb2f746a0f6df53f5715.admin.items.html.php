<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 20:19:56
         compiled from "admin:member/member/items.html" */ ?>
<?php /*%%SmartyHeaderCode:43783212557b304ec842fa1-78489604%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b694863c6d55b1a0d5ffb2f746a0f6df53f5715' => 
    array (
      0 => 'admin:member/member/items.html',
      1 => 1470380623,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '43783212557b304ec842fa1-78489604',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b304ec92f6c1_47069205',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b304ec92f6c1_47069205')) {function content_57b304ec92f6c1_47069205($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
if (!is_callable('smarty_modifier_iplocal')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.iplocal.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"member/member:create",'class'=>"button",'title'=>"添加"),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;<?php echo smarty_function_link(array('ctl'=>"member/member:so",'load'=>"mini:搜索内容",'width'=>"mini:500",'class'=>"button",'title'=>"搜索"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">	
    <form id="items-form">
        <table width="100%" border="0" cellspacing="0" class="table-data table">
            <tr>
                <th class="w-100">UID</th>
                <th class="w-50">头像</th>
                <th class="w-100">昵称</th>
                <th>手机号</th>
                <th class="w-100">余额</th>
                <th class="w-100">积分</th>
                <th class="w-100">订单数</th>                
                <th>微信</th>
                <th class="w-100">登录时间</th>
                <th class="w-100">注册时间</th>
                <th class="w-150">操作</th>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <tr class="<?php if ($_smarty_tpl->tpl_vars['item']->value['closed']==1){?>del<?php }?>">
                <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
" name="uid[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
<label></td>
                <td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['face'];?>
" onerror="javascript:this.src='<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/default/face.png';" class="wh-50" /></td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['nickname'])===null||$tmp==='' ? '--' : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mobile'];?>
</td>
                <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</b></td>
                <td><b class="blue"><?php echo $_smarty_tpl->tpl_vars['item']->value['jifen'];?>
</b></td>
                <td><b class="green"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['item']->value['orders'])===null||$tmp==='' ? '--' : $tmp);?>
</b></td>                                
                <td><?php if ($_smarty_tpl->tpl_vars['item']->value['wx_openid']){?><b class="green">已绑定</b><?php }else{ ?><b>未绑定</b><?php }?></td>
                <td><?php if ($_smarty_tpl->tpl_vars['item']->value['lastlogin']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['lastlogin']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['loginip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['loginip']);?>
)<?php }else{ ?>未登录<?php }?></td>
                <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
<br /><?php echo $_smarty_tpl->tpl_vars['item']->value['regip'];?>
(<?php echo smarty_modifier_iplocal($_smarty_tpl->tpl_vars['item']->value['regip']);?>
)</td>
                <td>
                    <?php echo smarty_function_link(array('ctl'=>"member/member:money",'args'=>$_smarty_tpl->tpl_vars['item']->value['uid'],'class'=>"button",'title'=>"余额"),$_smarty_tpl);?>

                    <?php echo smarty_function_link(array('ctl'=>"member/member:detail",'args'=>$_smarty_tpl->tpl_vars['item']->value['uid'],'class'=>"button",'title'=>"查看"),$_smarty_tpl);?>

                    <?php echo smarty_function_link(array('ctl'=>"member/member:edit",'args'=>$_smarty_tpl->tpl_vars['item']->value['uid'],'title'=>"修改",'class'=>"button"),$_smarty_tpl);?>

                    <?php echo smarty_function_link(array('ctl'=>"member/member:delete",'args'=>$_smarty_tpl->tpl_vars['item']->value['uid'],'act'=>"mini:删除",'confirm'=>"mini:确定要删除吗？",'title'=>"删除",'class'=>"button"),$_smarty_tpl);?>

                </td>
            </tr>
            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
            <tr><td colspan="20"><p class="text-align tip-notice">没有数据</p></td></tr>
            <?php } ?>
        </table>
    </form>
    <style type="text/css">
        tr.del td{text-decoration:line-through;}
    </style>
    <div class="page-bar">
        <table>
            <tr>
                <td class="w-100"><label><input type="checkbox" CKA="PRI"/>&nbsp;&nbsp;全选</label></td>
                <td colspan="10" class="left"><?php echo smarty_function_link(array('ctl'=>"member/member:delete",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量删除选中的内容吗?",'priv'=>"hide",'value'=>"批量删除"),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;<?php echo smarty_function_link(array('ctl'=>"member/member:doaudit",'type'=>"button",'submit'=>"mini:#items-form",'confirm'=>"mini:确定要批量审核选中的内容吗?",'priv'=>"hide",'value'=>"批量审核"),$_smarty_tpl);?>
</td>
                <td class="page-list"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</td>
            </tr>
        </table>
    </div>
    </div>
    <?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>