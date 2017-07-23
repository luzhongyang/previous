<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 14:44:30
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/passport/login.html" */ ?>
<?php /*%%SmartyHeaderCode:96500331257b2b64e5567b2-39160496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a1db585ca79b5394885124d7666ed9372cc36e2' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/passport/login.html',
      1 => 1470380631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '96500331257b2b64e5567b2-39160496',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'reg_yzm' => 0,
    'pager' => 0,
    'backurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2b64e5ffaa6_82033652',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2b64e5ffaa6_82033652')) {function content_57b2b64e5ffaa6_82033652($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><?php $_smarty_tpl->tpl_vars['tpl_title'] = new Smarty_variable('登录', null, 0);?>
<!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
  
<header>
	<i class="left"><a id="icon_goback" href="<?php echo smarty_function_link(array('ctl'=>'mobile/index'),$_smarty_tpl);?>
"></a></i>
    <div class="title">登录</div>
    <i class="right"><a href="<?php echo smarty_function_link(array('ctl'=>'passport/register'),$_smarty_tpl);?>
">注册</a></i>
</header>
   
<section class="page_center_box">
	<div class="loginModiy mt10"  id="lg1"  style="display:none;">
    	<table width="100%">
            <tr>
                <th>手机号</th>
                <td>
                    <input type="tel" id="mobile" placeholder="请输入手机号">
                    <div class="get_yzm"  login="sendsms">获取验证码</div>
                </td>
            </tr>
            <tr>
                <th>验证码</th>
                <td>
                    <input type="number" id="yzm" maxlength="6" placeholder="请输入手机验证码">
                </td>
            </tr>

            <?php if ($_smarty_tpl->tpl_vars['reg_yzm']->value=='on'){?>
            <tr>
                <th>验证码</th>
                <td>
                    <input type="number" maxlength="6" id="verifycode" placeholder="请输入验证码"  style='width:50%'>
                    <span style='width:50%;text-align:right;'>
                        <img verify="#pass-verify" src="<?php echo smarty_function_link(array('ctl'=>'magic:verify','http'=>'ajax'),$_smarty_tpl);?>
&_=<?php echo $_smarty_tpl->tpl_vars['pager']->value['dateline'];?>
" id="pass-verify" />
                    </span>
                </td>
            </tr>
            <?php }?>

        </table>
            <div class="long_btn_box">
                <input class="long_btn" type="submit" btn="passport:handle" value="立即登录"  id="login1">
            </div>
    </div>
	<div class="loginModiy mt10" id="lg2">
    	<table width="100%">
            <tr>
                <th>手机号</th>
                <td>
                    <input type="tel" id="mobile2" placeholder="请输入手机号">
                </td>
            </tr>
            <tr>
                <th>输密码</th>
                <td>
                    <input type="password" id="password" maxlength="32" placeholder="请输入密码">
                </td>
            </tr>
        </table>
        <div class="long_btn_box">
            <input class="long_btn" type="submit" btn="passport:handle2" value="立即登录"  id="login2">
        </div>    
    </div>
    <div class="login_type" id="l2">手机短信登录</a></div>
    <div class="login_type" id="l1" style="display:none;">密码登录</a></div>
    <div class="login_bot pd10">
        <h2><span>第三方登录</span></h2>
        <div class="login_other">
            <a href="<?php echo smarty_function_link(array('ctl'=>'passport:wxlogin'),$_smarty_tpl);?>
"><i class="ico ico_1"></i><p>微信</p></a>
        </div>
    </div>

</section>

<script type="text/javascript">
 
/*判断浏览器是否支持placeholder开始*/
$(function(){
if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur();
};
})
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}
/*判断浏览器是否支持placeholder结束*/
    
$(document).ready(function(){
    $('#pass-verify').click(function(){
        var time = new Date();
        $('#pass-verify').attr('src','<?php echo smarty_function_link(array('ctl'=>"magic:verify",'http'=>"ajax"),$_smarty_tpl);?>
'+'?'+time);
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
            }else {
                mobile_count--;
                $('.get_yzm').text( + mobile_count.toString() + "秒...");
                mobile_timeout = setTimeout(BtnCount, 1000);
            }
        };


        
            $("[login]").click(function () {
                if (mobile_lock == 0) {
                    var mobile = $('#mobile').val(); 
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
        
        var right = 0;
        
        $('.login_type').click(function(){
            right = right + 1;
            if(right%2 == 0){
                $('#l1').show();$('#l2').hide();
                $('#lg1').show();$('#lg2').hide();
            }else{
                $('#l2').show();$('#l1').hide();
                $('#lg2').show();$('#lg1').hide();
            }
        })
        
        $('#login1').click(function(){
            var mobile = $('#mobile').val(); 
            var yzm = $('#yzm').val();
            var yzm_val = $('#verifycode').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/handle'),$_smarty_tpl);?>
";
            $.post(link,{mobile:mobile,yzm:yzm,yzm_val:yzm_val},function(ret){
                if(ret.error == 0){
                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    setTimeout(function(){
                       window.location.href='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                    },1000)
                    BtnCount();
                }else{
                     layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    return ;
                }
                
            },'json');
        })
        
         $('#login2').click(function(){
            var mobile = $('#mobile2').val(); 
            var password = $('#password').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/handle2'),$_smarty_tpl);?>
";
            $.post(link,{mobile:mobile,password:password},function(ret){
                if(ret.error != 0){

                    layer.open({
                        content: ret.message,
                        time: 2 //2秒后自动关闭
                    });
                    return ;
                }else{
                    layer.open({
                        content: '登录成功',
                        time: 2 //2秒后自动关闭
                    });
                    setTimeout(function(){
                       window.location.href='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                    },1000)
                    BtnCount();
                }
            },'json');
        })

        
		//注册页获取验证码部分结束
    
        
})

    
    

</script>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>
</html>
<?php }} ?>