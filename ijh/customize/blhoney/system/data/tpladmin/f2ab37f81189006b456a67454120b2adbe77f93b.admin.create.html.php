<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:31:56
         compiled from "admin:shop/shop/create.html" */ ?>
<?php /*%%SmartyHeaderCode:207208684157b2892ce34112-67039012%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2ab37f81189006b456a67454120b2adbe77f93b' => 
    array (
      0 => 'admin:shop/shop/create.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '207208684157b2892ce34112-67039012',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2892cee8310_55646096',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2892cee8310_55646096')) {function content_57b2892cee8310_55646096($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_function_widget')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.widget.php';
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
<div class="page-data"><form action="?shop/shop-create.html" mini-form="shop-form" method="post" ENCTYPE="multipart/form-data">
    <table width="100%" border="0" cellspacing="0" class="table-data form">
        <tr>
            <th><span class="red">*</span>商家名称：</th>
            <td><input type="text" name="data[title]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-300"/></td>
        </tr>
        <tr>
            <th><span class="red">*</span>城市：</th>
            <td>
                <select name="data[city_id]" class="w-200"><?php echo smarty_function_widget(array('id'=>"data/city",'value'=>$_smarty_tpl->tpl_vars['detail']->value['city_id']),$_smarty_tpl);?>
</select>
            </td>
        </tr>
        <tr>
            <th><span class="red">*</span>分类：</th>
            <td>
                <select name="data[cate_id]" class="w-200">
                    <?php echo smarty_function_widget(array('id'=>"shop/cate",'value'=>$_smarty_tpl->tpl_vars['detail']->value['cate_id'],'type'=>"option"),$_smarty_tpl);?>

                </select>
            </td>
        </tr>
        <tr><th><span class="red">*</span>手机号：</th><td><input type="text" name="data[mobile]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['mobile'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/><span class="tip-comment">手机号，登录用</span></td></tr>
        <tr><th><span class="red">*</span>密码：</th><td><input type="password" name="data[passwd]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['passwd'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/></td></tr>
        <tr><th><span class="red">*</span>客服电话：</th><td><input type="text" name="data[phone]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['phone'])===null||$tmp==='' ? '' : $tmp);?>
" class="input w-200"/><span class="tip-comment">客服电话</span></td></tr>
        <tr><th><span class="red">*</span>logo：</th><td><input type="text" name="data[logo]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" <?php if ($_smarty_tpl->tpl_vars['detail']->value['logo']){?>photo="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
"<?php }?> class="input w-300" />&nbsp;&nbsp;&nbsp;<input type="file" name="data[logo]" class="input w-100" /></td></tr>
        <tr><th><span class="red">*</span>坐标：</th>
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
        <tr><th>首单优惠：</th><td><input type="text" name="data[first_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['first_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">首单优惠</span></td></tr>
        <tr><th>起送价：</th><td><input type="text" name="data[min_amount]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['min_amount'])===null||$tmp==='' ? '0.00' : $tmp);?>
" class="input w-100"/><span class="tip-comment">起送</span></td></tr>
        <tr><th>开始营业时间：</th><td><input type="text" name="data[yy_stime]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['yy_stime'])===null||$tmp==='' ? '00:00:00' : $tmp);?>
" class="input w-200"/><span class="tip-comment">开始营业时间</span></td></tr>
        <tr><th>打烊时间：</th><td><input type="text" name="data[yy_ltime]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['detail']->value['yy_ltime'])===null||$tmp==='' ? '00:00:00' : $tmp);?>
" class="input w-200"/><span class="tip-comment">打烊时间</span></td></tr>
        <tr><th><span class="red">*</span>提现比例：</th>
            <td>
                <input type="text" name="data[tixian_percent]" value="<?php if ($_smarty_tpl->tpl_vars['detail']->value['tixian_percent']==0){?>100<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['detail']->value['tixian_percent'];?>
<?php }?>" class="input w-50"/>%
                <span class="tip-comment">填写0~100之间的数字(例如:填写95则表示提现100元实际得到100X95%=95元)</span>
            </td>
        </tr>
        <tr>
            <th><span class="red">*</span>在线支付：</th>
            <td>
                <label><input type="radio" name="data[online_pay]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==1){?>checked="checked"<?php }?> class="input"/>支持</label><label><input type="radio" name="data[online_pay]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==0){?>checked="checked"<?php }?> class="input"/>不支持</label>
            </td>
        </tr>        
        <tr>
            <th>审核：</th>
            <td>
                <label><input type="radio" name="data[audit]" value="1" <?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']==1){?>checked="checked"<?php }?> class="input"/>通过</label><label><input type="radio" name="data[audit]" value="0" <?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']==0){?>checked="checked"<?php }?> class="input"/>待审</label>
            </td>
        </tr>
        <tr><th>优惠公告：</th><td><textarea name="data[info]" class="textarea"><?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</textarea><br /></td></tr>
        <tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
    </table>
</form>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>