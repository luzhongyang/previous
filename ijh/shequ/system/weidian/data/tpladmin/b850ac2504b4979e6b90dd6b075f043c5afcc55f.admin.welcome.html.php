<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:15:55
         compiled from "admin:page/welcome.html" */ ?>
<?php /*%%SmartyHeaderCode:273945833e29bf05ec7-59826941%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b850ac2504b4979e6b90dd6b075f043c5afcc55f' => 
    array (
      0 => 'admin:page/welcome.html',
      1 => 1475911366,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '273945833e29bf05ec7-59826941',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'ADMIN' => 0,
    'sysinfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e29c07a807_64335237',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e29c07a807_64335237')) {function content_5833e29c07a807_64335237($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_qq')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\modifier.qq.php';
?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
            <th>系统管理平台首页</th>
            <td class="right"></td>
            <td width="15"></td>
        </tr>
    </table>
</div>
<div class="page-data">
    <?php if ($_smarty_tpl->tpl_vars['ADMIN']->value['admin_name']=='ijianghu'&&$_smarty_tpl->tpl_vars['ADMIN']->value['passwd']==md5('ijianghu')){?>
    <h4 class="tip-error">老兄！据我所知你使用的还是默认帐号密码，请尽快修改以免发生安全问题</h4>
    <?php }?>
    <div id="ijh-news" class="none"></div>
    <div class="space15"></div>
    <table width="100%" border="0" cellspacing="0" class="table-data table">
        <tr><th colspan="15" class="left">系统信息</th></tr>
        <tr>
            <td class="w-150 left">系统版本：</td>
            <td class="left" colspan="10"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['version'];?>
</td>
        </tr>
        <tr>
            <td class="w-150 left">服务器操作系统：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['server_os'];?>
</td>
            <td class="w-150 left">服务器域名/IP：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['server_domain'];?>
</td>
            <td class="w-150 left">服务器环境：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['web_server'];?>
</td>
        </tr>
        <tr>
            <td class="w-150 left">PHP 版本：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['php_version'];?>
</td>
            <td class="w-150 left">Mysql 版本：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['mysql_version'];?>
</td>
            <td class="w-150 left">GD 版本：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['gd_version'];?>
</td>
        </tr>
        <tr>
            <td class="w-150 left">文件上传限制：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['upload_max_filesize'];?>
</td>
            <td class="w-150 left">最大占用内存：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['memory_limit'];?>
</td>
            <td class="w-150 left">最大执行时间：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['max_execution_time'];?>
</td>
        </tr>
        <tr>
            <td class="w-150 left">安全模式：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['safe_mode'];?>
</td>
            <td class="w-150 left">Zlib支持：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['zlib'];?>
</td>
            <td class="w-150 left">Curl支持：</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['sysinfo']->value['curl'];?>
</td>
        </tr>
    </table>
    <div class="space15"></div>
    <table width="100%" border="0" cellspacing="0" class="table-data table">
        <tr><th colspan="15" class="left">开发团队</th></tr>
        <tr><td class="w-150 left">版权所有：</td><td class="left"><a href="http://www.ijh.cc" target="_blank">合肥江湖信息科技有限公司</a></td></tr>
        <tr><td class="w-150 left">开发团队：</td><td class="left">江湖技术团队</td></tr>
        <tr><td class="w-150 left">联系电话：</td><td class="left">0551-64278115</td></tr>
        <tr><td class="w-150 left">授权咨询：</td><td class="left"><?php echo smarty_modifier_qq("800070067");?>
</td>
        </tr>
    </table> 
</div>
<!--有最新安全漏洞补丁的时候后台提醒请不要删除该JS-->
<script type="text/javascript" src="http://www.ijh.cc/index.php?ctl=listen&act=news&cat=waimai&version=<?php echo @JH_VERSION;?>
.<?php echo @JH_RELEASE;?>
"></script>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>