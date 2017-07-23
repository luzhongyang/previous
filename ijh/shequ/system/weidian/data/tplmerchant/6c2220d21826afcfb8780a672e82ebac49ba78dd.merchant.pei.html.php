<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:10:34
         compiled from "merchant:waimai/shop/pei.html" */ ?>
<?php /*%%SmartyHeaderCode:28954584520fa7b18e0-20024496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c2220d21826afcfb8780a672e82ebac49ba78dd' => 
    array (
      0 => 'merchant:waimai/shop/pei.html',
      1 => 1479522170,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '28954584520fa7b18e0-20024496',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'detail' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520fa817b34_70967342',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520fa817b34_70967342')) {function content_584520fa817b34_70967342($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a  href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/shop:pei'),$_smarty_tpl);?>
" >配送设置</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox float-e-margins">
                                        <!-- <div class="ibox-title">
                                            <div class="ibox-tools">
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div> -->
                                        <div class="">
                                        <form action="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/shop:pei'),$_smarty_tpl);?>
" mini-form="ucenter" method="post" ENCTYPE="multipart/form-data">
                                            <table class="table table-striped table-bordered table-hover" id="myTable">
                                                <tr>
                                                    <th>起送金额：</th>
                                                    <td><input type="text" name="data[min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['min_amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-100" style="width:100px;"/>&nbsp;元</td>
                                                </tr>
                                                <tr>
                                                    <th>配送费：</th>
                                                    <?php if (count($_smarty_tpl->tpl_vars['detail']->value['freight_stage'])==0){?>
                                                            <td id="freight_td">公里数：<input type="text" name="data[fkm][]" value="" class="input w-50"/>&nbsp;km&nbsp;&nbsp;&nbsp;用户支付：<input type="text" name="data[fm][]" value="" class="input w-50"/>&nbsp;元&nbsp;&nbsp;&nbsp;第三方配送：<input type="text" name="data[sm][]" value="" class="input w-50"/>&nbsp;元&nbsp;<a href="javascript:void(0);" class="btn btn-warning jq_delete">移除</a>
                                                                <a href="javascript:void(0);"  class="btn btn-success jq_add" style="float:right;">+新增一行</a>
                                                            </td>
                                                        <?php }else{ ?>
                                                            <td id="freight_td">
                                                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['detail']->value['freight_stage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['v']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
 $_smarty_tpl->tpl_vars['v']->index++;
?>
                                                                <div style="margin-top:10px;">公里数：<input type="text" name="data[fkm][]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['fkm'];?>
" class="input w-50"/>&nbsp;km&nbsp;&nbsp;&nbsp;用户支付：<input type="text" name="data[fm][]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['fm'];?>
" class="input w-50"/>&nbsp;元&nbsp;&nbsp;&nbsp;第三方配送：<input type="text" name="data[sm][]" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['sm'];?>
" class="input w-50"/>&nbsp;元&nbsp;<a href="javascript:void(0);" class="btn btn-warning jq_delete">移除</a>
                                                                <?php if ($_smarty_tpl->tpl_vars['v']->index==0){?><a href="javascript:void(0);"  class="btn btn-success jq_add" style="float:right;">+新增一行</a><?php }?></div>
                                                                <?php } ?>
                                                                
                                                            </td>
                                                    <?php }?>
                                                </tr>
                                                <!--<tr>-->
                                                    <!--<th>配送距离：</th>-->
                                                    <!--<td>-->
                                                        <!---->
                                                        <!--<input type="text" name="data[pei_distance]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['pei_distance'])===null||$tmp==='' ? '3' : $tmp);?>
" class="input w-200"/>-->
                                                        <!--<span class="comment-tip">单位: 千米, 小数会四舍五入, 默认3千米.</span>-->
                                                        <!---->
                                                    <!--</td>-->
                                                <!--</tr>-->
                                                <tr>
                                                    <th>配送方式：</th>
                                                    <td >
                                                    <select name="data[pei_type]" id="pei_type_select" class="select select_td input w-100" style="height:34px;">
                                                        <option value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==0){?>selected<?php }?> >自己送</option>
                                                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==1){?>selected<?php }?> >第三方配送</option>
                                                        <option value="2" <?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==2){?>selected<?php }?> >第三方代购及配送</option>
                                                    </select>
                                                    </td>
                                                </tr>
                                            <!--    <tr>
                                                    <th>配送结算价：</th>
                                                    <td>
                                                        <input type="text" name="data[pei_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['pei_amount'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/>
                                                        <span class="comment-tip">由第三方配送时支付给配送员的费用</span>
                                                    </td>
                                                </tr>-->
                                                <tr><th></th><td><input type="submit" value="保存数据" class="btn btn-primary" /></td></tr>
                                            </table>
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
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript">
$(document).ready(function(){
    var tr = '<div style="margin-top:10px;">公里数：<input type="text" name="data[fkm][]" value="" class="input w-50"/>&nbsp;km&nbsp;&nbsp;&nbsp;用户支付：<input type="text" name="data[fm][]" value="" class="input w-50"/>&nbsp;元&nbsp;&nbsp;&nbsp;第三方配送：<input type="text" name="data[sm][]" value="" class="input w-50"/>&nbsp;元&nbsp;<a href="javascript:void(0);" class="btn btn-warning jq_delete">移除</a><div>';
    $('.jq_add').click(function(){
        $('#freight_td').append(tr);
    })
     $(document).on('click','.jq_delete', function () {
        $(this).parent().remove();
    })
})
</script>  
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>