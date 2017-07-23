<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 17:36:25
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/info/index.html" */ ?>
<?php /*%%SmartyHeaderCode:63218519357b2de995adf53-87226300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25d9e6cd535d9d42c73d32e22d1cd590e4d4fcde' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/info/index.html',
      1 => 1470380642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63218519357b2de995adf53-87226300',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MEMBER' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2de9960d813_82985741',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2de9960d813_82985741')) {function content_57b2de9960d813_82985741($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
<?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
    
    <script>
        
         if (!window.applicationCache) {
                  alert("不支持HTML5");
          }

        function fileSelected(obj){
                    var files = obj.files;
                    for(var i=0;i<files.length;i++){
                        var tag = '';
                        var rFilter = /^(image\/gif|image\/jpeg|image\/jpg|image\/png)$/i;
                    if (! rFilter.test(files[i].type)) {                   
                        alert("只允许上传JPG、PNG、GIF格式图片");
                        return false;
                    }
                    var reader = new FileReader();
                    reader.onloadstart = function(e){
                            $(".loading").show();
                    }
                    reader.onload = function(e){
                        $(".face_img").attr('src',e.target.result);
                    }
                    reader.readAsDataURL(files[i]);
                }
        } 
        
    </script>
    
<header>
	<i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'ucenter'),$_smarty_tpl);?>
"  link-load="" link-type="right" class="gobackIco"><span class="num">0</span></a></i>
    <div class="title">
    	账户信息
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<section class="page_center_box">
	<div class="accountInfor">
        <ul class="form_list_box">
            <li class="mineHome_list accountInfor_headX">
            	<p class="fl">头像</p>
                <div class="fr">
                    <div class="img"><?php if ($_smarty_tpl->tpl_vars['MEMBER']->value['face']){?><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['face'];?>
" class="face_img" width="100" height="100"/><?php }?></div>
                </div>
                <div class="clear"></div>
            </li>
            <li class="mineHome_list last">
                <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/info/update_nickname'),$_smarty_tpl);?>
"  link-load="">
            	<p class="fl">用户名</p>
                <div class="fr">
                    <?php if ($_smarty_tpl->tpl_vars['MEMBER']->value['nickname']){?>
                            <span class="black9"><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['nickname'];?>
</span>
                    <?php }else{ ?>
                            <span class="black9">点击设置昵称</span>
                    <?php }?>
                    <em class="linkIco"></em></div>
                <div class="clear"></div>
                <?php if (!$_smarty_tpl->tpl_vars['MEMBER']->value['nickname']){?></a><?php }?>
            </li>
            <li class="mineHome_list"><p class="black9">账户设置</p></li>
            <li class="mineHome_list">
            	<a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/info/update_mobile'),$_smarty_tpl);?>
" link-load="">
            	<p class="fl"><em class="ico_8"></em>手机</p>
                <div class="fr"><span class="black9"><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['mobile'];?>
</span><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
            <li class="mineHome_list last">
            	<a href="javascript:;">
            	<p class="fl"><em class="ico_9"></em>微信</p>
                <div class="fr"><span class="maincl" id='wxbangd'><?php if ($_smarty_tpl->tpl_vars['MEMBER']->value['wx_openid']){?>已绑定<?php }else{ ?>未绑定<?php }?></span><em class="linkIco"></em></div>
                <div class="clear"></div>
                </a>
            </li>
        </ul>
    </div>
</section>
<?php echo $_smarty_tpl->getSubTemplate ("block/sfooter.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="mask_box">
    <form action="<?php echo smarty_function_link(array('ctl'=>'ucenter/info:upload_face'),$_smarty_tpl);?>
" mini-form="car-form" id="sbtfrm" method="post" ENCTYPE="multipart/form-data">
    <div class="maskOne accountInfor_headX_mask">
        <div class="title">
            <span class="fl">上传图像</span>
            <span class="fr" style="color:#ff0000;">关闭</span>
            <div class="clear"></div>
        </div>
        <div class="cont">
            <div class="btn_box">
            	<label class="btn"><input type="file" name="avatar" onchange="fileSelected(this)" id="fileField"  /></label>
            </div>
        </div>
        <div class="yuee_btn"> <input type="submit" value="保存" class="btn" style=" color:#fff;width:95%;margin:0 auto;margin-bottom:0.1rem;background-color: #1ec0be"></div>
    </div>
        
	<div class="mask_bg"></div>
    </form>
</div>

<div class="mask_box">
    <div class="maskOne addrDel_mask" style="text-align:center;">
        <div class="title">解除绑定</div>
        <div class="cont">
            <p class="black9">确定要解除帐号与微信的关联吗？</br>解除后将无法使用微信登录此帐号</p>
            <div class="btn_box">
                <input type="button" class="pub_btn graybg cancel" value="取消" />&nbsp;
                <input type="button" id="no_bind" class="pub_btn confirm" value="解除绑定" />
            </div>
        </div>
    </div>
    <div class="mask_bg"></div>
</div>

<script>
$(document).ready(function() {
	$(".accountInfor_headX").click(function(){
		$(".accountInfor_headX_mask").show();
		$(".accountInfor_headX_mask").parent().find(".mask_bg").show();
	});

    $('.title .fr').click(function(){
        $('.accountInfor_headX_mask').hide();
        $(".accountInfor_headX_mask").parent().find(".mask_bg").hide();
    });

    $('#wxbangd').click(function(){
        var status = $('#wxbangd').text();
        if(status=='已绑定') {
            // 解除绑定弹框 
            $('.addrDel_mask').show();
            $(".addrDel_mask").parent().find(".mask_bg").show();
            $('#no_bind').click(function(){
                wx_bind();
                $('.addrDel_mask').hide();
            });
        }else {
            wx_bind();
        }
    });
    $('.addrDel_mask .cancel').click(function(){
        $('.addrDel_mask').hide();
        $(".addrDel_mask").parent().find(".mask_bg").hide();
    });
});

function wx_bind() {
    jQuery.ajax({  
        url: "<?php echo smarty_function_link(array('ctl'=>'ucenter/info:wx_bind'),$_smarty_tpl);?>
", 
        async: true,  
        dataType: 'json',  
        type: 'POST',   
        success: function (ret) { 
            if(ret.error > 0){
                layer.open({content: ret.message,time: 2});
                setTimeout(function(){window.location.reload();},2000);
            }else{
                window.location.reload();
            }
        }, 
        error: function (XMLHttpRequest, textStatus, errorThrown) { 
            alert(errorThrown); 
        },   
    });   
}

</script>


</body>
</html>
<?php }} ?>