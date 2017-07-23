<?php /* Smarty version Smarty-3.1.8, created on 2016-12-05 16:09:53
         compiled from "admin:shop/shop/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:24695584520d15fc721-56007662%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fa7ea8027a1908152e217b47e95a064c37746a0' => 
    array (
      0 => 'admin:shop/shop/edit.html',
      1 => 1479879851,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '24695584520d15fc721-56007662',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
    'citys' => 0,
    'v' => 0,
    'areas' => 0,
    'busis' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_584520d1a61cf1_50209172',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_584520d1a61cf1_50209172')) {function content_584520d1a61cf1_50209172($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_function_widget')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.widget.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.bmap.js"></script>
<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
            <td align="right"><?php echo smarty_function_link(array('ctl'=>"shop/shop:index",'priv'=>"hidden",'class'=>"button"),$_smarty_tpl);?>
</td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <form action="?shop/shop-edit.html" mini-form="shop-form" method="post" ENCTYPE="multipart/form-data">
    <input type="hidden" name="shop_id" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
"/>
    <table width="100%" border="0" cellspacing="0" class="table-data form">
        <tr>
            <th>商家名称：</th>
            <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
</td>
        </tr>
        <tr>
            <th>城市：</th>
            <td>
                 <select id="city" name="data[city_id]" class="w-200">
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['citys']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['city_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['city_id']==$_smarty_tpl->tpl_vars['v']->value['city_id']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['city_name'];?>
</option>
                    <?php } ?>
                </select>
            </td>
        </tr>
       <tr>
            <th>区县：</th>
            <td>
                <select name="data[area_id]" id="area" class="w-200">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['areas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['area_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['area_id']==$_smarty_tpl->tpl_vars['v']->value['area_id']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['area_name'];?>
</option>
                <?php } ?></select>
            </td>
        </tr>
        <tr>
            <th>商圈：</th>
            <td>
                <select name="data[business_id]" id="business" class="w-200">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['busis']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['business_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['business_id']==$_smarty_tpl->tpl_vars['v']->value['business_id']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['business_name'];?>
</option>
                <?php } ?></select>
            </td>
        </tr>
        <tr>
            <th>分类：</th>
            <td><select name="data[cate_id]" class="w-200"><?php echo smarty_function_widget(array('id'=>"shop/cate",'value'=>$_smarty_tpl->tpl_vars['detail']->value['cate_id'],'type'=>"option"),$_smarty_tpl);?>
</select></td>
        </tr>
        <tr><th>手机号：</th><td><input type="text" name="data[mobile]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['mobile'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/><span class="tip-comment">手机号，登录用</span></td></tr>
        <tr><th>密码：</th><td><input type="text" name="data[passwd]" value="******" class="input w-200"/></td></tr>
        <tr>
            <th>客服电话：</th>
            <td>
                <input type="text" name="data[phone]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['phone'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/>
                <span class="tip-comment">客服电话</span>
            </td>
        </tr>
        
       <tr><th>logo：</th><td><input type="text" name="data[logo]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['logo']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
"<?php }?> class="input w-300" />&nbsp;&nbsp;&nbsp;<input type="file" name="data[logo]" class="input w-100" /></td></tr>
        
        <tr><th>banner：</th><td><input type="text" name="data[banner]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['banner'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['banner']){?>photo1="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['banner'];?>
"<?php }?> class="input w-300" />&nbsp;&nbsp;&nbsp;<input type="file" name="data[banner]" class="input w-100" /></td></tr>
        <tr><th>坐标：</th>
            <td>
                <label>经度:<input type="text" name="data[lng]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['lng'];?>
" id="Bmap_marker_lng" class="input w-100"/></label>
                <label>纬度:<input type="text" name="data[lat]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['lat'];?>
" id="Bmap_marker_lat" class="input w-100"/></label>    
                <span class="tip-comment">使用百度地图经纬度<a map-marker="#Bmap_marker_lng,#Bmap_marker_lat" class="button"><b>拾取工具</b></a></span>
            </td>
        </tr>
        <tr><th>地址：</th><td><input type="text" name="data[addr]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['addr'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-500"/></td></tr>
        
        <!-- <tr><th>起送价：</th><td><input type="text" name="data[min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['min_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">起送</span></td></tr> -->
        <tr><th>提现比例：</th>
            <td>
                <input type="text" name="data[tixian_percent]" value="<?php if ($_smarty_tpl->tpl_vars['detail']->value['tixian_percent']==0){?>100<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['detail']->value['tixian_percent'];?>
<?php }?>" class="input w-50"/>%
                <span class="tip-comment">填写0~100之间的数字(例如:填写95则表示提现100元实际得到100X95%=95元)</span>
            </td>
        </tr>
        <tr><th>人均消费：</th>
            <td>
                <input type="text" name="data[avg_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['avg_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-50"/>
                <span class="tip-comment">元</span>
            </td>
        </tr>
        <!-- <tr>
            <th>在线支付：</th>
            <td>
                <label><input type="radio" name="data[online_pay]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==1){?>checked="checked"<?php }?> class="input"/>支持</label><label><input type="radio" name="data[online_pay]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==0){?>checked="checked"<?php }?> class="input"/>不支持</label>
            </td>
        </tr>   -->      
        <tr>
            <th>审核：</th>
            <td>
                <label><input type="radio" name="data[audit]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[audit]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr>
            <th>开通外卖：</th>
            <td>
                <label><input type="radio" name="data[have_waimai]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_waimai']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[have_waimai]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_waimai']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr>
            <th>开通团购：</th>
            <td>
                <label><input type="radio" name="data[have_tuan]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_tuan']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[have_tuan]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_tuan']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr>
            <th>开通代金券：</th>
            <td>
                <label><input type="radio" name="data[have_quan]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_quan']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[have_quan]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_quan']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr>
            <th>开通优惠买单：</th>
            <td>
                <label><input type="radio" name="data[have_maidan]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_maidan']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[have_maidan]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_maidan']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr>
            <th>开通微店：</th>
            <td>
                <label><input type="radio" name="data[have_weidian]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_weidian']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[have_weidian]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['have_weidian']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr><th>排序：</th><td><input type="text" name="data[orderby]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['orderby'])===null||$tmp==='' ? '50' : $tmp);?>
" class="input w-100"/></td></tr>
        <!-- <tr><th>优惠公告：</th><td><textarea name="data[info]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</textarea><br /></td></tr> -->
        <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>
<script type="text/javascript">
(function(K, $){
    $(document).on("change", "#city", function(){
        var city_id = $(this).val();
        $.getJSON("?data/area-options-"+city_id+".html", function(ret){
            if(ret.error){
                Widget.MsgBox.error(ret.message);
            }else{
                var html = '';
                for(var i in ret.options){
                    html += "<option value="+i+">"+ret.options[i]+"</option>";
                }
                $("#area").html(html);
            }
        });
    });
    $(document).on("change", "#area", function(){
        var area_id = $(this).val();
        $.getJSON("?data/business-options-"+area_id+".html", function(ret){
            if(ret.error){
                Widget.MsgBox.error(ret.message);
            }else{
                var html = '';
                for(var i in ret.options){
                    html += "<option value="+i+">"+ret.options[i]+"</option>";
                }
                $("#business").html(html);
            }
        });        
    });
       
})(window.KT, window.jQuery)
</script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>