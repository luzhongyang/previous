<?php /* Smarty version Smarty-3.1.8, created on 2016-08-17 14:39:07
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/mobile.html" */ ?>
<?php /*%%SmartyHeaderCode:25267011357b4068b7eb062-28130720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f586af0270482f6b5fd9bb2e68717e95800e129' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/biz/shop/mobile.html',
      1 => 1470380634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25267011357b4068b7eb062-28130720',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mobile' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b4068b82d4c7_34245414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b4068b82d4c7_34245414')) {function content_57b4068b82d4c7_34245414($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="zxTabs">
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:index'),$_smarty_tpl);?>
">基本资料</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:passwd'),$_smarty_tpl);?>
">安全设置</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
" class="on">更换手机</a>
    <a href="<?php echo smarty_function_link(array('ctl'=>'biz/shop:account'),$_smarty_tpl);?>
">提现帐号</a>
    <div class="tishi pointcl"></div>
</div>
<div class="ucenter_c">
    <form id="form_post"  method="post">
        <table cellspacing="0" cellpadding="0" class="form">
            <tr>
                <th>旧手机号：</th>
                <td><b><?php echo $_smarty_tpl->tpl_vars['mobile']->value;?>
</b></td>
            </tr>            
            <tr>
                <th><span class="red">*</span>登录密码：</th>
                <td><input type="password" name="data[passwd]" value="" class="input w-200"/></td>
            </tr>

            <tr>
                <th><span class="red">*</span>新手机：</th>
                <td><input type="text" name="data[mobile]" value="" id="mobile" class="input w-200"/><div class="btn btn-success get_yzm" login="sendsms">获取验证码</div></td>
            </tr>
            <tr>
                <th><span class="red">*</span>验证码：</th>
                <td><input type="text" name="data[code]" value="" class="input w-200"/></td>
            </tr>
            <tr>
                <th></th>
                <td><input type="button" value="保存数据" id="btn_mobile" class="btn btn-primary" /></td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
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
                $(".get_yzm").addClass("on");
                $('.get_yzm').removeAttr("disabled");
                $('.get_yzm').text("重新获取");
                mobile_lock = 0;
                clearTimeout(mobile_timeout);
                $('.get_yzm').removeClass("on");
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
                        $(".get_yzm").addClass("on");
                        $('.get_yzm').attr("disabled", "disabled");
                    } else {
                        layer.msg(ret.message);
                        mobile_lock = 0;
                    }
                }, 'json');
                mobile_count = minute;
            }
        });
        $('#btn_mobile').click(function () {
            var link = "<?php echo smarty_function_link(array('ctl'=>'biz/shop:mobile'),$_smarty_tpl);?>
";
            $.post(link,$("#form_post").serialize(), function (ret) {
                if (ret.error == 0) {
                    layer.msg(ret.message);
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 1000)
                    BtnCount();
                } else {
                    layer.msg(ret.message);
                }
            }, 'json');
        })
    })

</script>

<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>