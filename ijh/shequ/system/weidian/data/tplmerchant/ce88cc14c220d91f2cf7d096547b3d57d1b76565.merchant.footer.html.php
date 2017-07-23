<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 15:07:35
         compiled from "merchant:block/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:122405833e2b99a7d50-01703435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce88cc14c220d91f2cf7d096547b3d57d1b76565' => 
    array (
      0 => 'merchant:block/footer.html',
      1 => 1479798014,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '122405833e2b99a7d50-01703435',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e2b9a4ef87_26165355',
  'variables' => 
  array (
    'pager' => 0,
    'request' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e2b9a4ef87_26165355')) {function content_5833e2b9a4ef87_26165355($_smarty_tpl) {?></div>

<div class="footer text-center">

    <div class="pull-right">
        <!-- 10GB of <strong>250GB</strong> Free. -->
    </div>
    <div>
        <strong>Copyright</strong> © 2013-2016 江湖科技出品, All rights reserved. ICP备案：皖ICP备13010842号
    </div>
</div>

<script>
    function location_addr(address) {
        if (address) {
            window.location.href = address;
        }
    }




    (function (K, $) {
        KindEditor.ready(function (KE) {
            $("[uploadbtn]").each(function () {
                var upload_url = $(this).attr("uploadbtn");
                var uploadbutton = KE.uploadbutton({
                    button: $(this)[0],
                    fieldName: 'imgFile',
                    url: '/merchant/?upload/photo.html',
                    afterUpload: function (data) {
                        if (data.error === 0) {
                            var photo = data.photo;
                            KE(upload_url).val(photo);
                            KE(upload_url).attr("photo", "<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/" + photo);
//                            Widget.MsgBox.info('上传图片成功');
                            layer.msg('上传图片成功');
                        } else {
                            alert(data.message);
                        }
                    },
                    afterError: function (str) {
                        alert(str);
                    }
                });
                uploadbutton.fileBox.change(function (e) {
                    uploadbutton.submit();
                });
            });
            $(".ke-upload_lay .ke-button").removeClass().addClass("btn btn-success ");
            $(".ke-upload_lay .ke-button-common").removeClass("ke-button-common");
            $(document).on("click", "[preview]", function () {
                var el = $(this).attr("preview");
                if ($(el).attr('photo')) {
                    layer.open({
                        type: 1,
                        shade: false,
                        title: false,
                        area: [400, 400],
                        cancel: function (index) {
                            layer.close(index);
                        },
                        content: '<img src="' + $(el).attr('photo') + '" width="400" height="400"/>'
                    });
                } else {
                    alert("还没有添加图片");
                }
            });
        });
    })(window.KT, window.jQuery);

    (function(K, $){
        KindEditor.ready(function(KE) {
            $("[uploadbtn1]").each(function(){
                var upload_url = $(this).attr("uploadbtn1");
                var uploadbutton = KE.uploadbutton({
                    button : $(this)[0],
                    fieldName : 'imgFile',
                    url : '/merchant/index.php?upload/photo.html',
                    afterUpload : function(data) {
                        if (data.error === 0) {
                            var photo = data.photo;
                            KE(upload_url).val(photo);
                            KE(upload_url).attr("photo", "<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/" + photo);
                            layer.msg('上传图片成功');
                        } else {
                            alert(data.message);
                        }
                    },
                    afterError : function(str) {
                        alert(str);
                    }
                });
                uploadbutton.fileBox.change(function(e) {
                    uploadbutton.submit();
                });
            });
            $(".ke-upload_lay .ke-button").removeClass().addClass("btn btn-success");
            $(".ke-upload_lay .ke-button-common").removeClass("ke-button-common");
            $(document).on("click","[preview1]", function(){
                var el = $(this).attr("preview1");
                if($(el).attr('photo')){
                    layer.open({
                        type: 1,
                        shade: false,
                        title: false,
                        area: [400, 400],
                        cancel: function(index){layer.close(index);},
                        content: '<img src="'+$(el).attr('photo')+'" style="width:400px;height:400px;"/>'
                    });
                }else{
                    alert("还没有添加图片");
                }
            });
        });
    })(window.KT, window.jQuery);
</script>
<style>
    .ke-upload_lay{ position:relative;}
    .ke-upload-area .ke-upload-file {
        position: absolute;
        font-size: 20px;
        top: 0;
        right: 0;
        padding: 0;
        margin: 0;
        z-index: 811212;
        border: 0 none;
        opacity: 0;
        filter: alpha(opacity=0);
    }
   /* .layui-layer-content{}
    .layui-layer-content img{width:auto !important;}*/
</style>

<script>
    $(document).ready(function () {
        var curr_ctl = "<?php echo $_smarty_tpl->tpl_vars['request']->value['ctl'];?>
";
        var act = "<?php echo $_smarty_tpl->tpl_vars['request']->value['act'];?>
";
        $(".pull-right a").each(function(){
            if(-1 != curr_ctl.indexOf($(this).attr("hel"))){
                if(-1 != curr_ctl.indexOf("weidian")){
                    if(-1 != curr_ctl.indexOf("pintuan")){
                        $("#search_form").attr('action', $(this).attr('rel'));
                        $("#selectBoxInput").html($(this).html()); 
                    }else{
                        $("#search_form").attr('action', $(this).attr('rel'));
                        $("#selectBoxInput").html($(this).html());
                    }
                }else{
                   $("#search_form").attr('action', $(this).attr('rel'));
                    $("#selectBoxInput").html($(this).html()); 
                }
                                                
            }else if(-1 != act.indexOf($(this).attr("hel"))){
                $("#search_form").attr('action', $(this).attr('rel'));
                $("#selectBoxInput").html($(this).html());
            }
        })
        $(".pull-right li a").click(function () {
            $("#search_form").attr('action', $(this).attr('rel'));
            $("#selectBoxInput").html($(this).html());
            $('.selectList').hide();
        });
        
    });
</script>

</body>

</html>
<?php }} ?>