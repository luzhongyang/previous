<?php /* Smarty version Smarty-3.1.8, created on 2016-11-25 10:55:12
         compiled from "merchant:tuan/tuan/create.html" */ ?>
<?php /*%%SmartyHeaderCode:264995837a810093da6-01355336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb026b4c9a00bef242ab46ea8b028b8329616586' => 
    array (
      0 => 'merchant:tuan/tuan/create.html',
      1 => 1478942678,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '264995837a810093da6-01355336',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'OTOKEN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5837a8100dd122_39552818',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5837a8100dd122_39552818')) {function content_5837a8100dd122_39552818($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>添加团购</h5>
            </div>
            <div class="ibox-content">
                <form action="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan:create'),$_smarty_tpl);?>
" method="post" mini-form="merchant"
                      class="form-horizontal" ENCTYPE="multipart/form-data">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标题：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[title]" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="radio radio-success radio-inline">
                                    <input type="radio" id="type_tuan" name="data[type]" value="tuan" checked="checked" />
                                    <label for="type_tuan">团购券</label>
                                </div>
                                <div class="radio radio-inline">
                                    <input type="radio" id="type_quan" name="data[type]" value="quan" />
                                    <label for="type_quan">代金券</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">描述：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[desc]" value="" class="form-control">
                            </div>
                            <span class="help-block -none">副标题用</span>
                        </div>
                    </div>
                    <div class="form-group draggable">
                        <label class="col-sm-2 control-label">图标：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4"><input type="text" name="data[photo]" class="form-control" id="file_photo" value="" readonly="readonly" /></div>
                            <div class="col-sm-8"><input type="button" uploadbtn="#file_photo" class="ke-upload_lay pull-left" value=" 选择文件 " /><a preview="#file_photo" class="btn btn-success btn-outline"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span> 预览</a></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">门店价：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="input-group ">
                                    <span class="input-group-addon">¥</span>
                                    <input type="text" name="data[market_price]" value="" class="form-control">
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">优惠价：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="input-group ">
                                    <span class="input-group-addon">¥</span>
                                    <input type="text" name="data[price]" value="" class="form-control">
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group draggable">
                        <label class="col-sm-2 control-label">开始时间：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <span  class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="data[stime]" id="d4311"   value=""  class="form-control"  onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="readonly" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group draggable">
                        <label class="col-sm-2 control-label">结束时间：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <span  class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="data[ltime]" id="d4312"  value="" class="form-control"  onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly="readonly" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">最小购买数：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[min_buy]" value="1" class="form-control">
                            </div>
                            <span class="help-block -none">每单最少购买数量</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">最大购买数：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[max_buy]" value="99" class="form-control">
                            </div>
                            <span class="help-block -none">每单最多购买数量</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">排序：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[orderby]" value="50" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">库存数量：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <input type="text" name="data[stock_num]" value="999" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">使用规则：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-6">
                                <textarea name="data[notice]" class="form-control border-left m-t" style="height: 150px"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图文详情：</label>
                        <div class="col-sm-10">
                            <div class="col-sm-12">
                                <textarea name="data[detail]" class="form-control border-left m-t" kindeditor="full" style="width:500px;height:350px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                            <div class="col-sm-4">
                                <button class="btn btn-primary" type="submit">保存数据</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/tuan/tuan'),$_smarty_tpl);?>
" class="btn btn-default" type="submit">返回</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
    (function (K, $) {
        var editor = KindEditor.create('textarea[kindeditor]', {
            uploadJson: '<?php echo smarty_function_link(array('ctl'=>"merchant/upload:editor",'http'=>"base"),$_smarty_tpl);?>
',
            extraFileUploadParams: {OTOKEN: "<?php echo $_smarty_tpl->tpl_vars['OTOKEN']->value;?>
"}
        });
    })(window.KT, window.jQuery);
</script>
<?php }} ?>