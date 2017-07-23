<?php /* Smarty version Smarty-3.1.8, created on 2016-08-16 11:09:56
         compiled from "admin:common/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:61419667657b28404654e81-57497115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d182d636c7143a23f84938a9a3e1228087494eb' => 
    array (
      0 => 'admin:common/footer.html',
      1 => 1470380607,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '61419667657b28404654e81-57497115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'request' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b28404663a57_67093376',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b28404663a57_67093376')) {function content_57b28404663a57_67093376($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['request']->value['MINI']=='load'){?>
<script type="text/javascript">(function(){
    $(".layui-layer-content .page-title").hide();
    $(".layui-layer-content .page-data").css({margin:"0px"});
})(window.KT, window.jQuery);</script>
<?php }elseif($_smarty_tpl->tpl_vars['request']->value['MINI']=='LoadIframe'){?>
<script type="text/javascript">
(function(T, $){
$(document).off("click",":checkbox[CKA]").on("click",":checkbox[CKA]",function(){
    var $cks = $(":checkbox[CK='"+$(this).attr("CKA")+"']");;
    if($(this).attr("checked")){
        $cks.each(function(){$(this).attr("checked",true);});
    }else{
        $cks.each(function(){$(this).attr("checked",false);});
    }
});
$(".page-title").hide();$(".page-data").css({margin:"0px"});
$(document).off("click", "[date],[datepicker]").on("click", "[date],[datepicker]", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$(document).off("click", "[datetime],[timepicker]").on("click", "[datetime],[timepicker]", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});
window.parent.Widget.MsgBox.hide();
if(typeof(window.parent.Dialog_Iframe) == 'object'){
    window.parent.Dialog_Iframe.dialog({height: $("body").height()+50});
}else{

}
})(window.KT, window.jQuery);
</script>
</body>
</html>
<?php }else{ ?>
<p class="s-50"></p>
<script type="text/javascript">
(function(T, $){
$(document).off("click", "[date],[datepicker]").on("click", "[date],[datepicker]", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$(document).off("click", "[datetime],[timepicker]").on("click", "[datetime],[timepicker]", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});
	$(document).off("click",":checkbox[CKA]").on("click",":checkbox[CKA]",function(){
		var $cks = $(":checkbox[CK='"+$(this).attr("CKA")+"']");;
		if($(this).prop("checked")){
			$cks.each(function(){$(this).prop("checked",true);});
		}else{
			$cks.each(function(){$(this).prop("checked",false);});
		}
	});
	if (window.parent == window){
		$(".page-data").css({margin:"45px 10px 10px 10px"});
	}
})(window.KT, window.jQuery);
</script>
</body>
</html>
<?php }?><?php }} ?>