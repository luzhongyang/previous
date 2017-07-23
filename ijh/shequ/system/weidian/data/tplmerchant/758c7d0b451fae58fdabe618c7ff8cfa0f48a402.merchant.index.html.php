<?php /* Smarty version Smarty-3.1.8, created on 2016-11-25 10:55:09
         compiled from "merchant:tuan/tuan/index.html" */ ?>
<?php /*%%SmartyHeaderCode:92595837a80d3c3834-78690573%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '758c7d0b451fae58fdabe618c7ff8cfa0f48a402' => 
    array (
      0 => 'merchant:tuan/tuan/index.html',
      1 => 1478771097,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '92595837a80d3c3834-78690573',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'countnum' => 0,
    'items' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5837a80dab0421_70939973',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5837a80dab0421_70939973')) {function content_5837a80dab0421_70939973($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_modifier_format')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<!--<link href="/merchant/style/css/mine.css" rel="stylesheet">-->

<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">订单</span>
                <h5>待支付</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['unpay'];?>
</h1>
                <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order/waitpay'),$_smarty_tpl);?>
"
                                                                 class="btn btn-primary">立即查看</a></div>
                <small> &nbsp;</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">订单</span>
                <h5>已取消</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['cansle'];?>
</h1>
                <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order/cancellist'),$_smarty_tpl);?>
"
                                                                 class="btn btn-primary">立即查看</a></div>
                <small> &nbsp;</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">订单</span>
                <h5>今日完成</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['tover'];?>
</h1>
                <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order/todaycomplete'),$_smarty_tpl);?>
"
                                                                 class="btn btn-primary">立即查看</a></div>
                <small> &nbsp;</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-info pull-right">订单</span>
                <h5>总完成</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['over'];?>
</h1>
                <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/order/allcomplete'),$_smarty_tpl);?>
"
                                                                 class="btn btn-primary">立即查看</a></div>
                <small> &nbsp;</small>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 商品列表</a></li>
                <li class="list_btn_right">
                    <button onclick="location_addr('<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan:create'),$_smarty_tpl);?>
')"
                            class="btn btn-primary ">添加商品
                    </button>
                </li>
                <li class="list_btn_right">
                    <button class="btn btn-danger " href="<?php echo smarty_function_link(array('ctl'=>"merchant/tuan/tuan/so"),$_smarty_tpl);?>
" mini-load="搜索内容" mini-width="500" class="btn btn-danger " title="搜索">搜索
                    </button>
                </li>

            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <table class="table table-striped table-hover" id="myTable">
                            <thead>
                            <tr>
                                <th>商品ID</th>
                                <th>标题</th>
                                <th>类型</th>
                                <th>市场价</th>
                                <th>团购价</th>
                                <th>已购数</th>
                                <th>库存</th>
                                <th>最小起购</th>
                                <th>最大限购</th>
                                <th>有效期</th>
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
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['tuan_id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['item']->value['type']=='tuan'){?>团购券<?php }else{ ?>代金券<?php }?></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['market_price'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sale_count'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['stock_num'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['min_buy'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['max_buy'];?>
</td>
                                <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['stime'],'Y-m-d');?>
 ~ <?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['ltime'],'Y-m-d');?>
</td>
                                <td>
                                    <a href="javascript:onsale(<?php echo $_smarty_tpl->tpl_vars['item']->value['tuan_id'];?>
);"
                                       class="btn btn-<?php if ($_smarty_tpl->tpl_vars['item']->value['is_onsale']==0){?>warning<?php }else{ ?>success<?php }?> btn-sm btn-outline"
                                       style="margin-right:2px;"><?php if ($_smarty_tpl->tpl_vars['item']->value['is_onsale']==0){?>上架<?php }else{ ?>下架<?php }?></a>
                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan:edit','args'=>$_smarty_tpl->tpl_vars['item']->value['tuan_id']),$_smarty_tpl);?>
"
                                       class="btn btn-primary btn-sm btn-outline" style="margin-right:2px;">修改</a>
                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan:del','args'=>$_smarty_tpl->tpl_vars['item']->value['tuan_id']),$_smarty_tpl);?>
"
                                       class="btn btn-danger btn-sm btn-outline" mini-act="del" mini-confirm="确定要删除吗？" title="删除">删除</a>
                                </td>

                            </tr>
                            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                            <tr>
                                <td colspan="20">
                                    <div class="alert alert-info">没有数据</div>
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
<!--搜索弹出窗-->
<!-- <div class="modal inmodal fade" id="sechScree" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">窗口标题</h4>
                <small class="font-bold">这里可以显示副标题。</small>
            </div>
            <form class="form-horizontal m-t" id="signupForm">
                <div class="modal-body">
                    <div class="formStyle">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关键字：</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="商品ID/货号/名称" class="form-control">
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 这里写点提示的内容</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">分类：</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="account">
                                    <option></option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">商品状态：</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="account">
                                    <option></option>
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </div>
            </form>
        </div>
    </div>
</div> -->


<!--搜索弹出窗结束-->
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>




<script type="text/javascript" charset="utf-8" async defer>

    $(document).ready(function () {

    });

    // 上架、下架
    function onsale(id) {
        var link = "<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan:onsale','args'=>'temp'),$_smarty_tpl);?>
";
        jQuery.ajax({
            url: link.replace('temp', id),
            async: true,
            dataType: 'json',
            type: 'POST',
            success: function (ret) {
                if (ret.error > 0) {
                    parent.layer.msg(ret.message);
                } else {
                    parent.layer.msg(ret.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
        });
    }

</script>

<?php }} ?>