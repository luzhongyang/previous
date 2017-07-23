<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:19:16
         compiled from "merchant:tuan/order/index.html" */ ?>
<?php /*%%SmartyHeaderCode:240685833e3644e0c68-31310236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f43f3ae377d75bf645372c64ad06fe19b685d22' => 
    array (
      0 => 'merchant:tuan/order/index.html',
      1 => 1478919489,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '240685833e3644e0c68-31310236',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e364580b41_55111868',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e364580b41_55111868')) {function content_5833e364580b41_55111868($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_modifier_format')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="row">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a href="javascript:;">订单列表</a>
                </li>
                <li class=""><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order:ticket'),$_smarty_tpl);?>
">团购券管理</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="">
                            <table class="table table-striped  table-hover" id="myTable">
                                <thead>
                                <tr>
                                    <th>订单ID</th>
                                    <th>商品名称</th>
                                    <th>数量</th>
                                    <th>合计</th>
                                    <th>使用时间</th>
                                    <th>订单状态</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['tuan']['tuan_title'];?>
</td>
                                    <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['tuan']['tuan_price']/2;?>
 * <?php echo $_smarty_tpl->tpl_vars['item']->value['tuan']['tuan_number'];?>
</b></td>
                                    <td><b class="red">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['tuan']['tuan_price'];?>
</b></td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['tuan']['use_time']){?><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['tuan']['use_time'],'Y-m-d');?>
<?php }else{ ?>未使用<?php }?>
                                    </td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_status_label'];?>
</td>
                                    <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline'],'Y-m-d H:i:s');?>
</td>
                                    <td><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order:detail','arg0'=>$_smarty_tpl->tpl_vars['item']->value['order_id']),$_smarty_tpl);?>
"
                                           class="btn btn-primary btn-sm btn-outline" title="查看">查看</a></td>
                                </tr>
                                <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                                <tr>
                                    <td colspan="20">
                                        <div class="alert alert-info">暂无团购订单</div>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                            <div class="btn-group pull-right pagination_box">
                                <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>