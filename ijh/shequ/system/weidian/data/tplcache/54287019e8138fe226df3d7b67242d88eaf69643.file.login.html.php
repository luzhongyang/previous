<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 15:07:00
         compiled from "D:\phpStudy\WWW\shequ\themes\default\passport\login.html" */ ?>
<?php /*%%SmartyHeaderCode:60555833ee945b3ce7-76164330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54287019e8138fe226df3d7b67242d88eaf69643' => 
    array (
      0 => 'D:\\phpStudy\\WWW\\shequ\\themes\\default\\passport\\login.html',
      1 => 1479432120,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60555833ee945b3ce7-76164330',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'backurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833ee94639be2_20633447',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833ee94639be2_20633447')) {function content_5833ee94639be2_20633447($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable(L("登陆"), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ("block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<header>
    <i class="left"><a id="icon_goback" href="<?php echo smarty_function_link(array('ctl'=>'ucenter/index'),$_smarty_tpl);?>
" class="ico headerIco headerIco_3"></a></i>
    <div class="title">登录</div>
    <i class="right"><a href="<?php echo smarty_function_link(array('ctl'=>'passport/register'),$_smarty_tpl);?>
">注册</a></i>
</header>
<section class="page_center_box">
    <div class="loginPage">
        <div class="txt_center pad_b10 img"><img src="/themes/default/static/images/loginTop.png" width="100"></div>

        <div class="mt10" id="lg1">

            <div class="loginPage_int_box border_b border_t">
                <div class="pub_ico fl"><em class="ico ico_1"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="tel" id="mobile2" placeholder="请输入手机号">
                </div>
            </div>
            <div class="loginPage_int_box border_b mb10">
                <div class="pub_ico fl"><em class="ico ico_3"></em></div>
                <div class="pub_box"><input class="long_int" type="password" id="password" placeholder="请输入密码" value="">
                </div>
            </div>

            <div class="btn_box">
                <input class="long_btn" type="button" btn="passport:handle2" value="立即登录" id="login2">
            </div>

        </div>

        <!--手机短信登录-->
        <div class="mt10" id="lg2" style="display:none;">

            <div class="loginPage_int_box border_b border_t">
                <div class="pub_ico fl"><em class="ico ico_1"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="tel" id="mobile" placeholder="请输入手机号">
                    <a href="javascript:;" class="pub_btn get_yzm" login="sendsms">获取验证码</a>
                </div>
            </div>
            <div class="loginPage_int_box border_b mb10">
                <div class="pub_ico fl"><em class="ico ico_2"></em></div>
                <div class="pub_box">
                    <input class="long_int" type="number" id="yzm" maxlength="6" placeholder="请输入手机验证码">
                </div>
            </div>
            <div class="btn_box">
                <input class="long_btn" type="submit" btn="passport:handle" value="立即登录" id="login1">
            </div>

        </div>

        <div class="pad_l10 pad_r10">
            <div class="fl">
                <span class="maincl login_type" id="l1">手机短信登录</span>
                <span class="maincl login_type" id="l2" style="display:none;">密码登录</span>
            </div>
            <div class="fr">
                <a href="<?php echo smarty_function_link(array('ctl'=>'passport/forget'),$_smarty_tpl);?>
" class="black9">忘记密码?</a>
            </div>
            <div class="cl"></div>
        </div>


        <style>
            .login_bot {
                margin: 0.3rem 0;
            }

            .login_bot h2 {
                text-align: center;
                border-bottom: 0.01rem solid #ddd;
                height: 0.2rem;
                margin: 0 auto 0.2rem;
            }

            .login_bot span {
                font-size: 0.14rem;
                display: inline-block;
                background: #f7f7f7;
                padding: 0 0.2rem;
                line-height: 0.4rem;
            }

            .login_other {
                margin: 0 0.15rem;
                text-align: center;
            }

            .login_other a {
                display: inline-block;
                margin: 0 0.1rem;
            }

            .login_other a p {
                font-size: 0.14rem;
                line-height: 0.24rem;
                color: #999999;
            }

            .login_other a .ico {
                display: inline-block;
                width: 0.4rem;
                height: 0.4rem;
                background: url(/themes/default/static/images/pay_ico.png) no-repeat;
                vertical-align: middle;
                background-size: 100% auto;
            }

            .login_other a .ico_1 {
                background-position: center -0.8rem;
            }
        </style>
        <div class="login_bot pd10">
            <h2><span class="black6">第三帐号方登录</span></h2>
            <div class="login_other">
                <a href="<?php echo smarty_function_link(array('ctl'=>'passport:wxlogin'),$_smarty_tpl);?>
"><i class="ico ico_1"></i>
                    <p>微信</p></a>
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
        $('#pass-verify').click(function () {
            var time = new Date();
            $('#pass-verify').attr('src', '<?php echo smarty_function_link(array('ctl'=>"magic:verify",'http'=>"ajax"),$_smarty_tpl);?>
' + '?' + time);
        })

        var minute = 60;
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
                $.post(link, {mobile: mobile}, function (ret) {
                    if (ret.error == 0) {
                        BtnCount();
                        mobile_lock = 1;
                        $(".get_yzm").addClass("graybg");
                        $('.get_yzm').attr("disabled", "disabled");
                        layer.open({content: ret.message, time: 2});
                        console.log(ret.message);
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

        $('.login_type').click(function () {
            right = right + 1;
            if (right % 2 == 0) {
                $('#l1').show();
                $('#l2').hide();
                $('#lg1').show();
                $('#lg2').hide();
            } else {
                $('#l2').show();
                $('#l1').hide();
                $('#lg2').show();
                $('#lg1').hide();
            }
        })

        $('#login1').click(function () {
            var mobile = $('#mobile').val();
            var yzm = $('#yzm').val();
            var yzm_val = $('#verifycode').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/handle'),$_smarty_tpl);?>
";
            $.post(link, {mobile: mobile, yzm: yzm, yzm_val: yzm_val}, function (ret) {
                if (ret.error == 0) {
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                    }, 1000)
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

        $('#login2').click(function () {
            var mobile = $('#mobile2').val();
            var password = $('#password').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/handle2'),$_smarty_tpl);?>
";

            $.post(link, {mobile: mobile, password: password}, function (ret) {
                if (ret.error != 0) {

                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    return;
                } else {
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    setTimeout(function () {
                        window.location.href = '<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                    }, 1000)
                    BtnCount();
                }
            }, 'json');
        })
        //注册页获取验证码部分结束
    })

</script>
<script>
$(document).ready(function () {
	var img_h = $(".loginPage .img").height();
	localStorage.setItem('def_height',$(window).height());
	$(window).resize(function(){
		
		var width = $(window).width();
		var height = $(window).height();
		
		if(height != localStorage.getItem('def_height')){
			
			$('.page_center_box').animate({'scrollTop':img_h + 10},600);
			$("footer").hide();
			var height  =$(window).height();
			var width = $(window).width();
			
		}
		else
		{

			$('.page_center_box').animate({'scrollTop':0},0);
			$("footer").show();
			var height  =$(window).height();
			var width = $(window).width();

		}
	});

});
</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>