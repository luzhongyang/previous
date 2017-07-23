<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:10:33
         compiled from "merchant:waimai/index.html" */ ?>
<?php /*%%SmartyHeaderCode:11925584520f959b1b8-19705782%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f8df62a5b22d62f85a605b46de8bd29a58f0407' => 
    array (
      0 => 'merchant:waimai/index.html',
      1 => 1478933366,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '11925584520f959b1b8-19705782',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'waimai' => 0,
    'pager' => 0,
    'cate_tree' => 0,
    'v' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520f965c5f6_92111763',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520f965c5f6_92111763')) {function content_584520f965c5f6_92111763($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<link href="/merchant/style/css/plugins/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">

<div class="row">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a  href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai:index'),$_smarty_tpl);?>
" >外卖店铺资料</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                    <?php if (!$_smarty_tpl->tpl_vars['waimai']->value['shop_id']){?>
                    <div class="alert alert-danger"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;小提示：您需要提交资料申请开通外送店铺功能，才可以继续操作</div>
                    <?php }elseif(!$_smarty_tpl->tpl_vars['waimai']->value['audit']){?>
                    <div class="alert alert-danger"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;小提示：您的外卖店铺正在审核中，请耐心等待</div>
                    <?php }?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <form action="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai:index'),$_smarty_tpl);?>
" method="post" mini-form="waimai_index" class="form-horizontal"  ENCTYPE="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">店铺名称：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['waimai']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group draggable">
                                            <label class="col-sm-2 control-label">店铺LOGO：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4"><input type="text" name="data[logo]" class="form-control" id="file_photo" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['waimai']->value['logo'])===null||$tmp==='' ? '' : $tmp);?>
" photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['waimai']->value['logo'];?>
" readonly="readonly"/></div>
                                                <div class="col-sm-8"><input type="button" uploadbtn="#file_photo" class="ke-upload_lay pull-left" value=" 选择文件 " /><a preview="#file_photo" class="btn btn-success btn-outline"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span> 预览</a></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">外卖分类：<br/></label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <select name="data[cate_id]" class="form-control ">
                                                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cate_tree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['cate_id']==$_smarty_tpl->tpl_vars['v']->value['cate_id']){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                                                        <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_smarty_tpl->tpl_vars['kk'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
 $_smarty_tpl->tpl_vars['kk']->value = $_smarty_tpl->tpl_vars['vv']->key;
?>
                                                            <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['cate_id']==$_smarty_tpl->tpl_vars['vv']->value['cate_id']){?>selected<?php }?> >&nbsp;┗━<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">客服电话：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <input type="text" name="data[phone]"  value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['waimai']->value['phone'])===null||$tmp==='' ? '' : $tmp);?>
" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">选择显示模板：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-2">
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" id="tmpl_type_waimai" name="data[tmpl_type]" value="waimai" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['tmpl_type']=='waimai'){?>checked="checked"<?php }?> >
                                                        <label for="tmpl_type_waimai">外卖模板</label>
                                                    </div>
                                                    <div class="radio radio-inline">
                                                        <input type="radio" id="tmpl_type_market" name="data[tmpl_type]" value="market" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['tmpl_type']=='market'){?>checked="checked"<?php }?> >
                                                        <label for="tmpl_type_market">商超模板</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="help-block -none">小提示：当店铺商品较多时选择商超模板更合适</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">到店自提：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" id="is_ziti_1" name="data[is_ziti]" value="1" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['is_ziti']==1){?>checked="checked"<?php }?>/> 
                                                        <label for="is_ziti_1">支持</label>
                                                    </div>
                                                    <div class="radio radio-inline">
                                                        <input type="radio" id="is_ziti_0" name="data[is_ziti]" value="0" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['is_ziti']==0){?>checked="checked"<?php }?>/>
                                                        <label for="is_ziti_0">不支持</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">付款方式：<br/></label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <select id="pay_type_select" class="form-control ">
                                                            <option value="all" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['is_daofu']==1&&$_smarty_tpl->tpl_vars['waimai']->value['online_pay']==1){?>selected="selected"<?php }?> >全部支持</option> 
                                                            <option value="is_daofu" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['is_daofu']==1&&$_smarty_tpl->tpl_vars['waimai']->value['online_pay']==0){?>selected="selected"<?php }?>>仅支持货到付款</option> 
                                                            <option value="online_pay" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['is_daofu']==0&&$_smarty_tpl->tpl_vars['waimai']->value['online_pay']==1){?>selected="selected"<?php }?>>仅支持在线支付</option> 
                                                    </select>
                                                    <input type="hidden" name="data[online_pay]" value="1">
                                                    <input type="hidden" name="data[is_daofu]" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">营业状态：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <div class="radio radio-success radio-inline">
                                                        <input type="radio" id="yy_status_1" name="data[yy_status]" value="1" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['yy_status']==1){?>checked="checked"<?php }?>/>
                                                        <label for="yy_status_1">营业</label>
                                                    </div>
                                                    <div class="radio radio-inline">
                                                        <input type="radio" id="yy_status_0" name="data[yy_status]" value="0" <?php if ($_smarty_tpl->tpl_vars['waimai']->value['yy_status']==0){?>checked="checked"<?php }?>/>
                                                        <label for="yy_status_0">打烊</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">营业开始时间：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" name="data[yy_stime]" id="yy_stime" value="<?php echo $_smarty_tpl->tpl_vars['waimai']->value['yy_stime'];?>
" class="form-control" onFocus="WdatePicker({dateFmt:'HH:mm'})" readonly="readonly" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">营业结束时间：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" name="data[yy_ltime]" id="yy_ltime" value="<?php echo $_smarty_tpl->tpl_vars['waimai']->value['yy_ltime'];?>
" class="form-control" onFocus="WdatePicker({dateFmt:'HH:mm'})" readonly="readonly" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">店铺简介：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <textarea name="data[info]"  class="form-control border-left m-t" style="height: 150px"><?php echo $_smarty_tpl->tpl_vars['waimai']->value['info'];?>
</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">店铺公告：</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <textarea name="data[delcare]" class="form-control border-left m-t" style="height:150px;"><?php echo $_smarty_tpl->tpl_vars['waimai']->value['delcare'];?>
</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">&nbsp;</label>
                                            <div class="col-sm-10">
                                                <div class="col-sm-4">
                                                    <button class="btn btn-primary" type="submit"><?php if ($_smarty_tpl->tpl_vars['waimai']->value){?>保存修改<?php }else{ ?>提交申请<?php }?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

<script src="/merchant/script/js/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="/merchant/script/js/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<script  type="text/javascript" charset="utf-8" async defer>
$("#pay_type_select").change(function(){
    if($(this).val() == 'is_daofu') {
        $("input[name='data[is_daofu]']").val(1);
        $("input[name='data[online_pay]']").val(0);
    }else if($(this).val() == 'online_pay') {
        $("input[name='data[is_daofu]']").val(0);
        $("input[name='data[online_pay]']").val(1);
    }else {
        $("input[name='data[is_daofu]']").val(1);
        $("input[name='data[online_pay]']").val(1);
    }
});

$('.start_time').datetimepicker({
    format:'hh:ii',
    language:  'zh-CN',
    //weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0,
    showMeridian:false,
});

$('.end_time').datetimepicker({
    format:'hh:ii',
    language:  'zh-CN',
    //weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0,
    showMeridian:false,
});
</script><?php }} ?>