<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:36:09
         compiled from "admin:shop/shop/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:52652675757b28a296a6a44-25524558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a48cfd447a800570b32d7196e4a7acace62ec7b3' => 
    array (
      0 => 'admin:shop/shop/detail.html',
      1 => 1470380627,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '52652675757b28a296a6a44-25524558',
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
  'unifunc' => 'content_57b28a297749c0_92844414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28a297749c0_92844414')) {function content_57b28a297749c0_92844414($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
if (!is_callable('smarty_modifier_format')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
<div class="page-data"><table width="100%" border="0" cellspacing="0" class="table-data form">
        <tr><th>商家ID：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
</td><th>城市：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['city_name'];?>
</td></tr>
        <tr><th>分类：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['cate_title'];?>
</td><th>手机号：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['mobile'];?>
</td></tr>
        <tr><th>密码：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['passwd'];?>
</td><th>电话：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['phone'];?>
</td></tr>
        <tr><th>商家名称：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['title'];?>
</td><th>余额：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['money'];?>
</td></tr>
        <tr><th>banner：</th><td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['banner'];?>
" class="w-300" /></td><th>logo：</th><td><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['detail']->value['logo'];?>
" class="wh-100" /></td></tr>
         <tr><th>百度地图：</th><td><label>经度:<?php echo $_smarty_tpl->tpl_vars['detail']->value['lng'];?>
，纬度:<?php echo $_smarty_tpl->tpl_vars['detail']->value['lat'];?>
</td><th>地址：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['addr'];?>
</td></tr>
        <tr><th>浏览数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['views'];?>
</td><th>订单数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['orders'];?>
</td></tr>
        <tr><th>评论数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['comments'];?>
</td><th>得分：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['score'];?>
</td></tr>
        <tr><th>服务得分：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['score_fuwu'];?>
</td><th>口味得分：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['score_kouwei'];?>
</td></tr>
        <tr><th>好评数：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['praise_num'];?>
</td><th>首单优惠：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['first_amount'];?>
</td></tr>
        <tr><th>起送价：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['min_amount'];?>
</td><th>运费：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['pei_amount'];?>
</td></tr>
        <tr><th>配送距离：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['pei_distance'];?>
km</td><th>配送类型：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['pei_type']==0){?>商家自主配送<?php }elseif($_smarty_tpl->tpl_vars['detail']->value['pei_type']==1){?>第三方配送<?php }else{ ?>第三方代购<?php }?></td></tr>
        <tr><th>营业状态：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_status'];?>
</td><th>营业开始时间：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_stime'];?>
</td></tr>
        <tr><th>打烊时间：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_ltime'];?>
</td><th>中间休息时间：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['yy_xiuxi'];?>
</td></tr>
        <tr><th>是否支持在线支付：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['online_pay']==1){?><span class="green">支持</span><?php }else{ ?><span class="red">不支持</span><?php }?></td><th>简介：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['info'];?>
</td></tr>
        <tr><th>是否审核：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['audit']==1){?><span class="green">正常</span><?php }else{ ?><span class="red">待审核</span><?php }?></td><th>是否删除：</th><td><?php if ($_smarty_tpl->tpl_vars['detail']->value['closed']==0){?><span class="green">正常</span><?php }else{ ?><span class="red">已删除</span><?php }?></td></tr>
        <tr><th>创建时间：</th><td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['detail']->value['dateline']);?>
</td><th>创建IP：</th><td><?php echo $_smarty_tpl->tpl_vars['detail']->value['clientip'];?>
</td></tr>
    </table></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>