<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:10:41
         compiled from "merchant:waimai/product/specs.html" */ ?>
<?php /*%%SmartyHeaderCode:750558452101911157-45530397%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36e68d08c59c26af11019c069f380abf268fa7d2' => 
    array (
      0 => 'merchant:waimai/product/specs.html',
      1 => 1479522424,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '750558452101911157-45530397',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product_id' => 0,
    'items' => 0,
    'item' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584521019721d7_48275617',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584521019721d7_48275617')) {function content_584521019721d7_48275617($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="row">
    <div class="col-sm-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a  href="javascript:;" >外卖商品规格</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="ibox-content">
                            <a href="javascript:;"><button class="btn btn-primary jq_add" type="button"><i class="fa fa-plus"></i>&nbsp;新增一行</button></a><br/><br/>
                            <form action="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['product_id']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:specs','args'=>$_tmp1),$_smarty_tpl);?>
" mini-form="specs" method="post" class="form-horizontal" ENCTYPE="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>编号</th>
                                        <th>名称</th>
                                        <th>价格</th>
                                        <th>打包费</th>
                                        <th>库存</th>
                                        <th>图片</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                    <tr class="jq_tr">
                                        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
</td>
                                        <td><input type="text" class="input w-100 self" name="data1[<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
][spec_name]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_name'];?>
"/></td>
                                        <td><input type="text" class="input w-60 self" name="data1[<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
][price]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
" /></td>
                                        <td><input type="text" class="input w-60 self" name="data1[<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
][package_price]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['package_price'];?>
" /></td>
                                        <td><input type="text" class="input w-60 self" name="data1[<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
][sale_sku]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['sale_sku'];?>
" /></td>
                                        <td>
                                            <div class="col-sm-5">
                                                <input type="text" name="data[<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
][spec_photo]" id="file_photo_<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
" value="" />
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="button" uploadbtn="#file_photo_<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
" rel="<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
" class="ke-upload_lay pull-left" value=" 选择文件 "/>
                                                <a preview="#file_photo_<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
" class="btn btn-success btn-outline"><i class="fa fa-th"></i> 预览</a>
                                            </div>
                                        </td>
                                        <td><a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['product_id']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo smarty_function_link(array('ctl'=>'merchant/waimai/product:specs_del','arg0'=>$_smarty_tpl->tpl_vars['item']->value['spec_id'],'arg1'=>$_tmp2),$_smarty_tpl);?>
" mini-act="remove:spec_<?php echo $_smarty_tpl->tpl_vars['item']->value['spec_id'];?>
" mini-confirm="确认要删除吗？" class="btn btn-warning">删除</a></td>
                                    </tr>  
                                    
                                    <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                                    <tr class="nodata"><td colspan="20"><div class="alert alert-info">没有数据</div></td></tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>   
                                </tfoot>
                            </table>
                            <a href="javascript:;"><button class="btn btn-primary jq_bottom" type="submit"><i class="fa fa-check-square-o"></i>&nbsp;保存数据</button></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" charset="utf-8" async defer>
function GGUID() {
    var guid = 'KT';
    for (var i = 1; i <= 32; i++) {
        var n = Math.floor(Math.random() * 16.0).toString(16);
        guid += n;
    }
    return guid.toUpperCase();
}


</script>
<style>
    .self{
         padding: 0px 12px;
    }    
</style>

<script type="text/javascript">
function init_uploadbtn(KE){
    $("[uploadbtn]:visible").each(function(){
         var upload_url = $(this).attr("uploadbtn");
         var uploadbutton = KE.uploadbutton({
            button : $(this)[0],
            fieldName : 'imgFile',
            url : '/merchant/?upload/photo.html',
            afterUpload : function(data) {
                if (data.error === 0) {
                    var photo = data.photo;
                    KE(upload_url).val(photo);
                    KE(upload_url).attr("photo", "<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/"+photo);
                    layer.msg('上传图片成功');
                } else {
                    alert(data.message);
                }
            },
            afterError : function(str) {
                alert(str);
            }
        });
        uploadbutton.fileBox.change(function(e) {
            uploadbutton.submit();
        });           
    });
    $(".ke-upload_lay .ke-button").removeClass().addClass("btn btn-success ");
    $(".ke-upload_lay .ke-button-common").removeClass("ke-button-common");
}
(function(K, $){
    $(document).ready(function(){
        $(".jq_add").click(function(){
            var guid = GGUID();
            var html = '<tr class="jq_tr tr222">';
            html+='<td>New</td>';
            html+='<td><input type="text" class="input w-100 self" name="data2['+guid+'][spec_name]" value="" /></td>';
            html+='<td><input type="text" class="input w-60 self" name="data2['+guid+'][price]" value="" /></td>';
            html+='<td><input type="text" class="input w-60 self" name="data2['+guid+'][package_price]" value="" /></td>';
            html+='<td><input type="text" class="input w-60 self" name="data2['+guid+'][sale_sku]" value="" /></td>';
            html+='<td><div class="col-sm-5"><input type="text" name="data2['+guid+'][spec_photo]" id="file_photo_'+guid+'" value=""/></div><div class="col-sm-5"><input type="button" uploadbtn="#file_photo_'+guid+'" class="ke-upload_lay pull-left" value="选择文件" />&nbsp;&nbsp;<a preview="#file_photo_'+guid+'" class="btn btn-success btn-outline"><i class="fa fa-th"></i> 预览</a></div></td>';
            html+='<td><a href="javascript:void(0);" class="btn btn-warning jq_delete">移除</a></td></tr>';
            $(".table").append(html);
            $(".nodata").html("");
            $('.jq_bottom').show();
            init_uploadbtn(KindEditor);
            $('.ke-upload-file').css('width','170px');
        })
        $(".table").on('click','.jq_delete', function () {
            $(this).parent().parent().remove();
            if($('.tr222').html() == undefined) {
                $('.jq_bottom').hide();
            }
        })
        <?php if ($_smarty_tpl->tpl_vars['items']->value){?>
        $('.jq_bottom').show();
        <?php }else{ ?>
        $('.jq_bottom').hide();
        <?php }?>
    })
})(window.KT, window.jQuery);
</script>
<?php }} ?>