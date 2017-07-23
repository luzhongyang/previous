<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:21:16
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/market/invite.html" */ ?>
<?php /*%%SmartyHeaderCode:55370939957b286ac148873-53462210%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22db598c5ea97267ee61f15b9f54d4f4781a7f48' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/market/invite.html',
      1 => 1470380630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55370939957b286ac148873-53462210',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CONFIG' => 0,
    'member' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b286ac1a7352_24567128',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b286ac1a7352_24567128')) {function content_57b286ac1a7352_24567128($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php $_smarty_tpl->tpl_vars["tpl_title"] = new Smarty_variable("分享-要求好友", null, 0);?>
<!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>
<body style="background:url(/themes/default/static/images/wxShare_bg.png) no-repeat center center; background-size:cover;">
    <div class="weixin_Share">
        <div class="weixin_Share_top">
            <img src="/themes/default/static/images/wxShare1.png" width="46%" height="">
            <div><span class="wxShare_money"><span class="pointcl1"><?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['invite']['hongbao_amount'];?>
</span>元红包</span></div>
        </div>
        <div class="weixin_Share_form">
            <div class="headPort">
                <?php if ($_smarty_tpl->tpl_vars['member']->value['face']){?>
                <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['member']->value['face'];?>
" width="100" height="100" />
                <?php }else{ ?>
                <div class="fr"><div class="img"></div></div>
                <?php }?>
                
                <P class="userName"><?php echo $_smarty_tpl->tpl_vars['member']->value['nickname'];?>
</P>
                <P>正在邀请您使用<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
</P>
            </div>
            <div class="form_box" id="invite_form_box">
                <form id="invite_form">
                    <input type="hidden" name="uid"  value="<?php echo $_smarty_tpl->tpl_vars['member']->value['uid'];?>
" />
                    <input type="text" name="data[mobile]" id="invite_form_mobile"  placeholder="请输入手机号" />
                    <div class="get_yzm"  login="sendsms">获取验证码</div></br>
                    <input type="text" name="data[sms_code]"   placeholder="请输入验证码" />
                    <input type="button" value="立即领取" id="invite_btn" class="long_btn" />
                </form>
                <p class="maincl"><a href="<?php echo smarty_function_link(array('ctl'=>'help:detail','arg0'=>2),$_smarty_tpl);?>
">活动说明？</a></p>
            </div>
            <div id="invite_success" style="display:none;">
            <div class="suc_tip mt10">
                <p><em></em>成功领取好友的<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['invite']['hongbao_amount'];?>
元红包</p>
                <p>用手机号<span class="pointcl1" id="invite_success_mobile"></span>注册使用</p>
            </div>
            <div class="form_box">
                <input type="button" onclick="location.href='<?php echo smarty_function_link(array('ctl'=>"index"),$_smarty_tpl);?>
'" value="立即使用" class="long_btn" />
                <p class="maincl">活动说明？</p>
            </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
$("document").ready(function(){
    $("#invite_btn").click(function(){
        $.post("<?php echo smarty_function_link(array('ctl'=>'market:invite','arg0'=>$_smarty_tpl->tpl_vars['member']->value['uid']),$_smarty_tpl);?>
", $("#invite_form").serialize(), function(ret){
            if(ret.error){
                layer.open({content: ret.message, time: 2});
            }else{
                $("#invite_form_box").hide();
                $("#invite_success_mobile").html($("#invite_form_mobile").val());
                $("#invite_success").show();
            }
        } ,"json");
    });

    var minute = 60;
    var mobile_timeout;
    var mobile_count = minute;
    var mobile_lock = 0;

    BtnCount = function () {       
        if (mobile_count == 0) {
            $(".get_yzm").addClass("on");
            $('.get_yzm').removeAttr("disabled");
            $('.get_yzm').text("重新获取");
            mobile_lock = 0;
            clearTimeout(mobile_timeout);
            $('.get_yzm').removeClass("on");
        }else {
            mobile_count--;
            $('.get_yzm').text( + mobile_count.toString() + "秒...");
            mobile_timeout = setTimeout(BtnCount, 1000);
        }
    };
    $("[login]").click(function () {
        if (mobile_lock == 0) {
            var mobile = $('#invite_form_mobile').val(); 
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/sendsms'),$_smarty_tpl);?>
";
            $.post(link,{mobile:mobile},function(ret){  
                if(ret.error == 0){ 
                    BtnCount();
                    mobile_lock = 1;
                    $(".get_yzm").addClass("on");
                    $('.get_yzm').attr("disabled", "disabled");  
                }else{
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    mobile_lock = 0;
               }
           },'json');
            mobile_count = minute;                    
        }
    });        
});
</script>
</body>
</html>
<?php }} ?>