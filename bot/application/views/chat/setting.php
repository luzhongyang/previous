<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  menu="menubody">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>系统设置</title>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome.css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo $this->config->item('static_chat'); ?>/style/font-awesome/css/font-awesome-ie7.css">
	<![endif]-->

		<link href="<?php echo $this->config->item('static_chat'); ?>/style/bootstrap.css?ver=3.12" rel="stylesheet"/>	  
	
	<link href="<?php echo $this->config->item('static_chat'); ?>/style/skin/metro/green_app_setting.css?ver=3.12" rel="stylesheet" id='link_css_list'/>
</head>
<body>
	<div id="body">
		<div class="menu_left">	
			<h1>系统设置</h1>
			<ul class='setting'>
				<li id="system"><i class="font-icon icon-cog"></i>系统设置</li>		
				<li id="fav"><i class="font-icon icon-star"></i>收藏夹</li>			
				<li id="help"><i class="font-icon icon-question"></i>系统帮助</li>
				<li id="about"><i class="font-icon icon-info-sign"></i>关于我们</li>
			</ul>
		</div>		
		<div class='main'></div>
	</div>
<script src="<?php echo $this->config->item('static_chat'); ?>/js/lib/seajs/sea.js?ver=3.12"></script>
<script src="/index.php/chat/user/common_js#id=<?php echo rand_string(8);?>"></script>
<script type="text/javascript">
	seajs.config({
		base:  "/static/js/",
		preload: ["lib/jquery-1.8.0.min"],
		map:[
			[ /^(.*\.(?:css|js))(.*)$/i,'$1$2?ver='+G.version]
		]
	});
	seajs.use('app/src/setting/main');
</script>
</body>
</html>