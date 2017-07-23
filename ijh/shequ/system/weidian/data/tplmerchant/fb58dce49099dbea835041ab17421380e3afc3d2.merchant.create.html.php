<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:10:22
         compiled from "merchant:waimai/product/create.html" */ ?>
<?php /*%%SmartyHeaderCode:15041584520ee9e1212-43511520%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb58dce49099dbea835041ab17421380e3afc3d2' => 
    array (
      0 => 'merchant:waimai/product/create.html',
      1 => 1479089779,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '15041584520ee9e1212-43511520',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'pcates' => 0,
    'v' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520eea2b056_24470499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520eea2b056_24470499')) {function content_584520eea2b056_24470499($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="row">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class=""><a  href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:index'),$_smarty_tpl);?>
" >商品管理</a></li>
                <li class=""><a  href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:skunotice'),$_smarty_tpl);?>
">库存报警</a></li>
                <li class="active"><a  href="javascript:;" >添加商品</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <form action="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:create'),$_smarty_tpl);?>
" mini-form="waimai_product_create" method="post" class="form-horizontal" ENCTYPE="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">名称：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="form-control">
                                    </div>
                                </div>   
                            </div>
                            
                            <div class="form-group draggable">
                                <label class="col-sm-2 control-label">图片：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4"><input type="text" name="data[photo]" class="form-control" id="file_photo" value=""/></div>
                                    <div class="col-sm-8"><input type="button" uploadbtn="#file_photo" class="ke-upload_lay pull-left" value=" 选择文件 " /><a preview="#file_photo" class="btn btn-success btn-outline"><span class="bs-glyphicons glyphicon glyphicon-th" aria-hidden="true"></span>预览</a></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">上级分类：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <select class="form-control " name="data[cate_id]">
                                            <!-- <option value="0">一级分类</option> -->
                                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pcates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['cate_id'];?>
">|--<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
                                                <?php if ($_smarty_tpl->tpl_vars['v']->value['childrens']){?>
                                                    <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value){
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['vv']->value['cate_id'];?>
">&nbsp;&nbsp;&nbsp;&nbsp;|--<?php echo $_smarty_tpl->tpl_vars['vv']->value['title'];?>
</option>
                                                    <?php } ?>
                                                <?php }?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">价格：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <div class="input-group "><span class="input-group-addon">¥</span>
                                            <input type="text" name="data[price]" value="" class="form-control">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">打包费：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <div class="input-group "><span class="input-group-addon">¥</span>
                                            <input type="text" name="data[package_price]" value="" class="form-control">
                                        </div>
                                    </div><span class="help-block -none">打包费,0:免打包费</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">库存：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <input type="text" name="data[sale_sku]" value="999" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否上架：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <div class="radio radio-success radio-inline">
                                            <input type="radio" id="is_onsale_1" name="data[is_onsale]" value="1" checked="checked">
                                            <label for="is_onsale_1">上架</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_onsale_0" name="data[is_onsale]" value="0" >
                                            <label for="is_onsale_0">下架</label>
                                        </div>
                                    </div>
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
                                <label class="col-sm-2 control-label">描述：</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <textarea name="data[intro]"  class="form-control" style="height: 150px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary" type="submit">保存数据</button>
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
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php }} ?>