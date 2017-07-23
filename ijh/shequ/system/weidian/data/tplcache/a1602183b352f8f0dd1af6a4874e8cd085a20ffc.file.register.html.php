<?php /* Smarty version Smarty-3.1.8, created on 2016-11-24 09:43:06
         compiled from "D:\phpStudy\WWW\shequ\themes\default\passport\register.html" */ ?>
<?php /*%%SmartyHeaderCode:11922583645aa0e5e35-02295302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1602183b352f8f0dd1af6a4874e8cd085a20ffc' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\passport\\register.html',
      1 => 1479951039,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11922583645aa0e5e35-02295302',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_583645aa44f195_29921956',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_583645aa44f195_29921956')) {function content_583645aa44f195_29921956($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("注册"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
    <i class="left"><a id="icon_goback" href="<?php echo smarty_function_link(array('ctl'=>'passport/login'),$_smarty_tpl);?>
" class="ico headerIco headerIco_3"></a></i>
    <div class="title">注册</div>
    <i class="right"><a href="<?php echo smarty_function_link(array('ctl'=>'passport/login'),$_smarty_tpl);?>
">登录</a></i>
</header>
<section class="page_center_box">
    <div class="loginPage" style="padding:0;">
        <div class="mt10">
            <div class="loginPage_int_box border_b border_t">
                <div class="pub_ico fl"><em class="ico ico_1"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="tel" id="mobile" placeholder="请输入手机号">
                    <a href="javascript:;" class="pub_btn get_yzm" login="sendsms">获取验证码</a>
                </div>
            </div>

            <div class="loginPage_int_box border_b">
                <div class="pub_ico fl"><em class="ico ico_2"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="number" id="yzm" maxlength="6" placeholder="请输入手机验证码">
                </div>
            </div>
            <div class="loginPage_int_box border_b">
                <div class="pub_ico fl"><em class="ico ico_3"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="password" name="passwd" id="passwd" maxlength="32"
                           placeholder="请输入密码（不少于六位）">
                </div>
            </div>
            <div class="loginPage_int_box border_b mb10">
                <div class="pub_ico fl"><em class="ico ico_3"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="password" name="repasswd" id="repasswd" maxlength="32"
                           placeholder="请再次输入密码">
                </div>
            </div>
            <div class="btn_box">
                <p class="maincl mb10">
                    <label>
                        <input type="checkbox" name="check_ok" id="check_ok"
                               style="vertical-align:text-bottom; height:auto; font-size:0; margin:0 0.05rem 0 0; padding:0;">同意《<a
                            href="javascript:protocol();">江湖外卖用户协议</a>》
                    </label>
                </p>
                <input class="long_btn" type="submit" btn="passport:register" value="立即注册" id="reg">
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    /*判断浏览器是否支持placeholder开始*/
    $(function () {
        if (!placeholderSupport()) {   // 判断浏览器是否支持 placeholder
            $('[placeholder]').focus(function () {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function () {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur();
        }
        ;
    })
    function placeholderSupport() {
        return 'placeholder' in document.createElement('input');
    }
    /*判断浏览器是否支持placeholder结束*/

    $(document).ready(function () {

        var minute = 60;

        if (localStorage['Register_info']) {
            var reg_info = JSON.parse(localStorage['Register_info']);
            $('#mobile').val(reg_info['mobile']);
            $('#yzm').val(reg_info['yzm']);
            $('#passwd').val(reg_info['passwd']);
            $('#repasswd').val(reg_info['repasswd']);
            localStorage.removeItem('Register_info');
        }

        var mobile_timeout;
        var mobile_count = minute;
        var mobile_lock = 0;

        BtnCount = function () {
            if (mobile_count == 0) {
                $(".get_yzm").addClass("graybg");
                $('.get_yzm').removeAttr("disabled");
                $('.get_yzm').text("重新获取");
                mobile_lock = 0;
                clearTimeout(mobile_timeout);
                $('.get_yzm').removeClass("graybg");
            } else {
                mobile_count--;
                $('.get_yzm').text(+mobile_count.toString() + "秒...");
                mobile_timeout = setTimeout(BtnCount, 1000);
            }
        };
        $("[login]").click(function () {
            if (mobile_lock == 0) {
                var mobile = $('#mobile').val();
                var link = "<?php echo smarty_function_link(array('ctl'=>'passport/sendsms'),$_smarty_tpl);?>
";
                $.post(link, {mobile: mobile,is_register:1}, function (ret) {
                    if (ret.error == 0) {
                        BtnCount();
                        mobile_lock = 1;
                        $(".get_yzm").addClass("graybg");
                        $('.get_yzm').attr("disabled", "disabled");
                        layer.open({content: ret.message, time: 2});
                        console.log(ret);
                    } else {
                        layer.open({
                            content: ret.message,
                            time: 2 //2秒后自动关闭
                        });
                        mobile_lock = 0;
                    }
                }, 'json');
                mobile_count = minute;
            }
        });

        var right = 0;

        $('#reg').click(function () {

            var mobile = $('#mobile').val();
            var yzm = $('#yzm').val();
            var yzm_val = $('#verifycode').val();
            var passwd = $('#passwd').val();
            var repasswd = $('#repasswd').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/register'),$_smarty_tpl);?>
";

            if (!$("input[type='checkbox']").is(':checked')) {
                layer.open({
                    content: '请先同意协议再注册',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }

            $.post(link, {
                mobile: mobile,
                yzm: yzm,
                yzm_val: yzm_val,
                passwd: passwd,
                repasswd: repasswd
            }, function (ret) {
                if (ret.error == 0) {
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'ucenter'),$_smarty_tpl);?>
";
                    }, 2000)
                    localStorage.removeItem('Register_info');
                    BtnCount();
                } else {
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    return;
                }

            }, 'json');
        })
        //注册页获取验证码部分结束
    })

    function protocol() {
        var mobile = $('#mobile').val();
        var yzm = $('#yzm').val();
        var passwd = $('#passwd').val();
        var repasswd = $('#repasswd').val();
        localStorage["Register_info"] = JSON.stringify({
            "mobile": mobile,
            "yzm": yzm,
            "passwd": passwd,
            "repasswd": repasswd
        });
        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'about/protocol'),$_smarty_tpl);?>
";
    }

</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>