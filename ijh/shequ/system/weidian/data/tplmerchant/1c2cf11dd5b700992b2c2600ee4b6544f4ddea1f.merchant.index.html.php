<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:10:19
         compiled from "merchant:waimai/product/index.html" */ ?>
<?php /*%%SmartyHeaderCode:29501584520ebe3cf44-94259812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c2cf11dd5b700992b2c2600ee4b6544f4ddea1f' => 
    array (
      0 => 'merchant:waimai/product/index.html',
      1 => 1478662688,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '29501584520ebe3cf44-94259812',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'countnum' => 0,
    'items' => 0,
    'item' => 0,
    'cates' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520ebf03873_78617903',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520ebf03873_78617903')) {function content_584520ebf03873_78617903($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>待接单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['unjie'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:index'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>待配送</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['unpei'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:pei'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>自提单</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['ziti'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:ziti'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>已取消</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['cansle'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:cancellist'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>今日完成</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['tover'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:complete'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">订单</span>
                    <h5>总完成</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['countnum']->value['over'];?>
</h1>
                    <div class="stat-percent font-bold text-info"><a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order:complete'),$_smarty_tpl);?>
"class="btn btn-primary">立即查看</a>
                    </div>
                    <small> &nbsp;</small>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-success"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;小提示：列表中黄色背景色表示库存量小于15件</div>
    <div class="row">
        <div class="col-sm-12">    
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a  href="javascript:;" >商品管理</a>
                    </li>
                    <li class=""><a  href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:skunotice'),$_smarty_tpl);?>
" >库存报警</a>
                    </li>
                    <li class="list_btn_right">
                    <button onclick="location_addr('<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:create'),$_smarty_tpl);?>
')" class="btn btn-primary ">添加商品</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form id="item-form">

                                <table class="table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>商品ID</th>
                                            <th>分类</th>
                                            <th>名称</th>
                                            <th>价格</th>
                                            <th>打包费</th>
                                            <th>库存</th>
                                            <th>销量</th>
                                            <th>排序</th>
                                            <th width="20%">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                            <tr<?php if ($_smarty_tpl->tpl_vars['item']->value['sale_sku']<15&&$_smarty_tpl->tpl_vars['item']->value['is_onsale']){?> style="background:#fffcce"<?php }?>>
                                            <td><label><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
" id="product_id" class="i-checks" name="product_id[]" CK="PRI"/><?php echo $_smarty_tpl->tpl_vars['item']->value['product_id'];?>
</label></td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['cates']->value[$_smarty_tpl->tpl_vars['item']->value['cate_id']]['title'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sale_sku'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['sales'];?>
</td>
                                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['orderby'];?>
</td>
                                                <td>
                                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:open','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" class="btn btn-<?php if ($_smarty_tpl->tpl_vars['item']->value['is_onsale']==0){?>warning<?php }else{ ?>success<?php }?> btn-sm btn-outline" mini-act="open">
                                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['is_onsale']==1){?>下架<?php }else{ ?>上架<?php }?>
                                                    </a>&nbsp;
                                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:specs','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" class="btn btn-success btn-sm btn-outline">规格</a>&nbsp;
                                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:edit','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" class="btn btn-primary btn-sm btn-outline">修改</a>
                                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:delete','args'=>$_smarty_tpl->tpl_vars['item']->value['product_id']),$_smarty_tpl);?>
" mini-act="del" mini-confirm="确定要删除吗？" title="删除" class="btn btn-danger btn-sm btn-outline">删除</a>
                                                </td>
                                            </tr>
                                            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                                            <tr><td colspan="20"><div class="alert alert-info">没有数据</div></td></tr>
                                            <?php } ?>
                                    </tbody>
                                    <tfoot>   
                                    </tfoot>
                                </table>
                            <div class="clearfix p-xs">
                                <div class="pull-left">
                                    <label><input type="checkbox" cka="PRI" id="allChk">&nbsp;&nbsp;全选</label>
                                    <button type="button" class="btn btn-primary" id="add_stock">增加选中项库存</button>
                                    <button action="/merchant/waimai/product/onsale_open" type="button" class="btn btn-primary" id="all_onsale_yes">批量上架</button>
                                    <button action="/merchant/waimai/product/onsale_close"  type="button" class="btn btn-primary" id="all_onsale_no">批量下架</button>
                                </div>
                                <div class="btn-group pull-right pagination_box">
                                    <div class="page"><?php echo $_smarty_tpl->tpl_vars['pager']->value['pagebar'];?>
</div>
                                </div>
                            </div>
                            <input  id="stock_num" type="hidden" name="stock_num" value="0" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script  type="text/javascript" charset="utf-8" async defer>





// 全选
$("#allChk").click(function() {
    $("input[name='product_id[]']").prop("checked",this.checked);
});

// 单选
var subChk = $("input[name='product_id[]']")
subChk.click(function() {
    $("#allChk").prop("checked", subChk.length == subChk.filter(":checked").length ? true:false);
});

/* 批量上架 */
$(document).on('click','#all_onsale_yes', function() {
    var checkedNum = $("input[name='product_id[]']:checked").length;
    if(checkedNum == 0) {
        layer.msg("请选择至少一项！"); return;
    }

    // 批量选择
    if(true) {
        var checkedList = new Array();
        $("input[name='product_id[]']:checked").each(function() {
            checkedList.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: "?waimai/product/onsale_open",
            data: {'product_id':checkedList},
            success: function(ret) {
              var ret = jQuery.parseJSON(ret);
              if(ret.error ==0){
                layer.msg('操作成功');
                setTimeout(function() {window.location.reload();},1500);
              }else{
                layer.msg(ret.message);
              }

            }
        });
    }
})

//批量下架
$(document).on('click','#all_onsale_no', function() {
    // 判断是否至少选择一项
  var checkedNum = $("input[name='product_id[]']:checked").length;
  if(checkedNum == 0) {
    layer.msg("请选择至少一项！"); return;
  }

  // 批量选择
  if(true) {
      var checkedList = new Array();
      $("input[name='product_id[]']:checked").each(function() {
          checkedList.push($(this).val());
      });
      $.ajax({
          type: "POST",
          url: "?waimai/product/onsale_close",
          data: {'product_id':checkedList},
          success: function(ret) {
            var ret = jQuery.parseJSON(ret);
            if(ret.error ==0){
              layer.msg('操作成功');
              setTimeout(function(){window.location.reload();},1500);
            }else{
              layer.msg(ret.message);
            }
          }
      });
  }
})

// ajax批量增加库存
function stock_submit() {
    $("#stock_num").val($("#stock").val());
    var checkedList = new Array();
    $("input[name='product_id[]']:checked").each(function() {
        checkedList.push($(this).val());
    });
    $.ajax({
        url: "<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product/stock_add'),$_smarty_tpl);?>
",
        async: false,
        dataType: 'json',
        data: {"stock_num":$("#stock_num").val(),"product_id":checkedList},
        type: 'POST',
        success: function (ret) {
            if(ret.error == 0 ) {
                layer.msg('操作成功');
                setTimeout(function(){window.location.reload();},1500);
            }else {
                layer.msg(ret.message);
            }
        },
        error: function (xhr, status, err) {
            alert(err);
        },
    });
    $("#submit_stock").trigger("click");
}

// 批量增加库存layer弹层
$(document).on('click','#add_stock', function() {
    var checkedNum = $("input[name='product_id[]']:checked").length;
    if(checkedNum == 0) {
        layer.msg("请选择至少一项！"); return;
    }
    layer.open({
        type: 1,
        skin: 'layui-layer-rim', //加上边框
        area: ['400px', '200px'], //宽高
        title: '批量增加库存',
        content:
        '<div class="wrapper wrapper-content animated fadeInLeft">'+
            '<div class="col-md-12">'+
                '<div class="ibox float-e-margins">'+
                    '<form id="SO-form" action="" method="post" role="form" class="form-horizontal m-t">'+
                        '<div class="form-group draggable">'+
                            '<label class="col-sm-3 control-label">数目：</label>'+
                            '<div class="col-sm-4">'+
                                '<input type="text" name="stock" id="stock" value="0" class="form-control">'+
                            '</div>'+
                        '</div>'+
                        '<div class="form-group draggable">'+
                            '<label class="col-sm-3 control-label">&nbsp;</label>'+
                            '<div class="col-sm-4">'+
                                '<button class="btn btn-primary btn-w-m" type="button" id="click_stock" onclick="stock_submit();">增加库存</button>'+
                            '</div>'+
                        '</div>'+
                    '</form>'+
                '</div>'+
            '</div>'+
        '</div>'
    });
});

</script><?php }} ?>