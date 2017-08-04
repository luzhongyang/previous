<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="webpage"> 
<meta name="keywords" content="kalcaddle">
<meta name="author" content="kalcaddle.">
  <head>
  	<title>KodExplorer - Powered by KodExplorer</title>
  	<link href="<?php echo $this->config->item('static_chat'); ?>/style/bootstrap.css?ver=3.12" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome.css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome-ie7.css">
	<![endif]-->
	
	<link href="<?php echo $this->config->item('static_chat'); ?>/style/skin/metro/green_app_code_edit.css?ver=3.12" rel="stylesheet" id='link_css_list'/>
	
	<style type="text/css">
<!--/*把声明的样式包含在一个网页注释中，这样可以解决较老的浏览器不识别style的问题*/

body {
font-size: 13px;
padding: 0px;
margin: 0px;
font-family: Helvetica, arial, freesans, "Hiragino Sans GB", "Microsoft Yahei", "微软雅黑", "STXihei", "WenQuanYi Micro Hei", sans-serif;
-khtml-user-select: auto;
-webkit-user-select: auto;
-moz-user-select: auto;
-ms-user-select: auto;
-o-user-select: auto;
user-select: auto;
}



.cmd:focus {
border-color: #000;
outline: none;
box-shadow: 0 0 12px #000;
}
.cmd {
height: 30px;
width: 80%;
overflow: hidden;
border-bottom: 0px solid #ddd;background:blue;color:#ffffff;margin-left: 10px;"
}

.frame_right { font-size: 13px; width: 20%;}
.frame_right .intro_left { width: 40%; float: left;}
.frame_right .tips { padding: 5px; margin-bottom: 0; color: #888;}
.frame_right .tips p { padding-left: 2em; word-break: break-all; line-height: 1.2em;}
.frame_right .tips p:before { content: "\f006"; font-family: FontAwesome; padding-right: 8px;}
.frame_right .tips h1 { font-size: 25px; font-weight: 400; border-bottom: 1px dashed #ddd; padding: 4px 0 10px 5px; margin: 5px 0 10px 10px;}
.frame_right .tips h1 span { border-bottom: 3px solid #ddd; padding: 8px; color: #666;}
.frame_right pre { margin-left: 15px; padding: 5px; color: #56A238; line-height: 1.5em; background: #fff; border-bottom: 1px solid #eee;}
.frame_right .intro_right { width: 60%; float: left;}
.frame_right .blue { color: #8BB7D5;}
.frame_right .blue h1 span { border-color: #8BB7D5; color: #8BB7D5;}
.frame_right .orange { color: #F27642;}
.frame_right .orange h1 span { color: #F27642; border-color: #F27642;}
.frame_right .green { color: #56A238; border-left: 1px solid #ddd;}
.frame_right .green h1 span { color: #56A238; border-color: #56A238;}


	-->
</style>
	
  </head>

  <body>
	<div class="edit_main" style="height: 100%;" oncontextmenu="return core.contextmenu();">
		<div class="tools">
			<div class="left">
				<!-- <div class="disable_mask"></div> -->
				<a class="toolMenu editMenuFile" href="javascript:cmdstr('whoami');" draggable="false">查看当前用户</a>
				<a class="toolMenu editMenuEdit" href="javascript:cmdstr('cmd.exe /c dir c:\\');" draggable="false">DIR</a>
				<a class="toolMenu editMenuView" href="javascript:cmdstr('tasklist');" draggable="false">TASKLIST</a>
				<a class="toolMenu editMenuTools" href="javascript:cmdstr('ipconfig');" draggable="false">IPCONFIG</a>
				<a class="toolMenu editMenuHelp" href="javascript:rightshow();" draggable="false">帮助</a>
			</div>
			<div class="right">
				<a action="close" href="javascript:righthide();" title="关闭"><i class="font-icon icon-remove"></i></a>
				<a action="fullscreen" href="javascript:rightshow();" title="全屏/退出全屏"><i class="font-icon icon-resize-full"></i></a>
			</div>
			<div style="clear:both"></div>
		</div><!-- end tools -->

		<!-- 主体部分 -->
		<div class="frame_left">
			<div class="edit_tab">
				<div class="tabs">
					<a  href="javascript:cleardata()" class="add ">C</a>
					
					<input type="text" class="cmd" value="whoami" id="cmd" title="" data-original-title="">
					
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="edit_body">
				<textarea class="introduction" id="content" style="background:#000000;color:#ffffff"></textarea>
				<div class="tabs"></div>
			</div>			
		</div>
		<!-- 预览 -->
		<div class="frame_right" id="frame_right">
			<div class="resize"></div>
			<div class="right_main">
				<div class="function_list" style="display:block;">
					<div class="function_list_tool">
						<div class="box">
						<span> <i class="icon-code"></i> 命令帮助</span>
						<a action="close_preview" href="javascript:righthide();"><i class="font-icon icon-remove"></i></a>
					
						</div>
					</div>
					<div class="function_list_parent">
						<div class="function_list_box">
							
							
			
					
    <div class="tips blue">
        <h1> <span>丰富的功能</span> </h1>
        <p>代码自动提示</p>
        <p>多主题：选择你喜欢的编程风格</p>
        <p>自定义字体：适合种场景下使用</p>
        <p>多光标编辑,块编辑等媲美sublime的在线编程体验</p>
        <p>代码块折叠、展开；自动换行</p>
        <p>支持多标签,拖动切换顺序;</p>
        <p>维持多个文档、查找替换；历史记录；</p>
        <p>自动补全[],{},(),"",''</p>
        <p>在线实时预览,使您爱上在线编程！</p>
        <p>zendcodeing支持,写代码健步如飞</p>
        <p>更多功能,等待你的发现……</p>
    </div>
    <div class="tips orange">
        <h1> <span>多种代码高亮</span> </h1>
        <p>前端：html,JavaScript,css,less,sass,scss</p>
        <p>web开发：php,perl,python,ruby,elang,go...</p>
        <p>传统语言：java,c,c++,c#,actionScript,VBScript...</p>
        <p>其他：markdown,shell,sql,lua,xml,yaml...</p>
    </div>
    
        <div class="tips blue">
        <h1> <span>丰富的功能</span> </h1>
        <p>代码自动提示</p>
        <p>多主题：选择你喜欢的编程风格</p>
        <p>自定义字体：适合种场景下使用</p>
        <p>多光标编辑,块编辑等媲美sublime的在线编程体验</p>
        <p>代码块折叠、展开；自动换行</p>
        <p>支持多标签,拖动切换顺序;</p>
        <p>维持多个文档、查找替换；历史记录；</p>
        <p>自动补全[],{},(),"",''</p>
        <p>在线实时预览,使您爱上在线编程！</p>
        <p>zendcodeing支持,写代码健步如飞</p>
        <p>更多功能,等待你的发现……</p>
    </div>
    <div class="tips orange">
        <h1> <span>多种代码高亮</span> </h1>
        <p>前端：html,JavaScript,css,less,sass,scss</p>
        <p>web开发：php,perl,python,ruby,elang,go...</p>
        <p>传统语言：java,c,c++,c#,actionScript,VBScript...</p>
        <p>其他：markdown,shell,sql,lua,xml,yaml...</p>
    </div>
    
        <div class="tips blue">
        <h1> <span>丰富的功能</span> </h1>
        <p>代码自动提示</p>
        <p>多主题：选择你喜欢的编程风格</p>
        <p>自定义字体：适合种场景下使用</p>
        <p>多光标编辑,块编辑等媲美sublime的在线编程体验</p>
        <p>代码块折叠、展开；自动换行</p>
        <p>支持多标签,拖动切换顺序;</p>
        <p>维持多个文档、查找替换；历史记录；</p>
        <p>自动补全[],{},(),"",''</p>
        <p>在线实时预览,使您爱上在线编程！</p>
        <p>zendcodeing支持,写代码健步如飞</p>
        <p>更多功能,等待你的发现……</p>
    </div>
    <div class="tips orange">
        <h1> <span>多种代码高亮</span> </h1>
        <p>前端：html,JavaScript,css,less,sass,scss</p>
        <p>web开发：php,perl,python,ruby,elang,go...</p>
        <p>传统语言：java,c,c++,c#,actionScript,VBScript...</p>
        <p>其他：markdown,shell,sql,lua,xml,yaml...</p>
    </div>



							
							
							
							
							</div>
					</div>
				</div>
				<div class="preview" style="display:none;">
					<div class="preview_tool">
						<input type="text" value="" />
						<div class="box">
							<a action="refresh" href="javascript:preview.refresh();" title="刷新"><i class="font-icon icon-refresh"></i></a>
							<a action="open_ie" href="javascript:preview.openUrl();" target="_blank" title="浏览器打开"><i class="font-icon icon-globe"></i></a>
							<a action="close_preview" href="javascript:preview.close();" title="关闭"><i class="font-icon icon-remove"></i></a>
						</div>
					</div>
					<div class="preview_frame">
						<iframe src="" style="width:100%;height:100%;border:0;"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo $this->config->item('static_chat'); ?>/leftmenu/js/jquery.min.js" type="text/javascript"></script>
   <script> 
    	
    	 $(function(){
        $('#cmd').bind('keypress',function(event){
            if(event.keyCode == "13")    
            {
            	//alert("Alert text");
                send();
            }
        });
        $("#cmd")[0].focus(); 
    });
    	
    		 function cmdstr(str){ 
    	 jQuery("#cmd").val(str);
    	  $("#cmd")[0].focus();
    		}
    	
    	 function rightshow(){ 
    	 	 $("#frame_right").show();
    	}
    	
    	 function righthide(){ 
    	 	 $("#frame_right").hide();
    	}
     	
    	 function cleardata(){ 
    	 	 $("#content").val(''); 
    	}
    function send(){ 
    	
    
    	 var command=jQuery("#cmd").val();
    	
    	if(command=="")
    	{ 
    		alert("命令不能为空！");
    		$("#cmd")[0].focus(); 
    		return false;
    		
    	}
    	 $("#cmd").attr("disabled", true); 
    	 jQuery("#cmd").val('正在等待结果......');
    	 
    	 $("#content").val($("#content").val()+'【 命令：' + command +' 】\n\n'); 
    	
      		jQuery.ajax({  
    url: '/chat/cmd/send', 
    async: true,  
    dataType: 'json',  
     data: {"command":command}, 
    type: 'POST',    
   
   success: function (data) { 
   	
   	 if(data.code==true){
   	 	
   	 	$("#content").val($("#content").val() + data.data +'\n\n'); 
   	  //alert(data.msg);
   	 //$("#content").append('' + data.data +'\n\n'); 
   	 
   }else{
   	 $("#content").val('' + data.data +'\n\n'); 
   	}
   	   jQuery("#cmd").val('');
   $("#cmd").attr("disabled", false);
    $("#cmd")[0].focus(); 
    var scrollTop = $("#content")[0].scrollHeight;  
     $("#content").scrollTop(scrollTop);  
    
    
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	   jQuery("#cmd").val('');
   $("#cmd").attr("disabled", false); 
   $("#cmd")[0].focus();
 alert(errorThrown); 
 },  
     
  }); 
  

  
    } 
 

 
    </script> 
	



</body>
</html>