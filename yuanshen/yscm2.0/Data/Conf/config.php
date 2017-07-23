<?php
return array(	
	'DB_CHARSET'		=> 'utf8', // 数据库编码默认采用utf8
	'URL_CASE_INSENSITIVE'	=> false, //url地址大小写不敏感设置	
	'DEFAULT_MODULE'	=> 'Home',  // 默认模块
	'DEFAULT_CONTROLLER'	=> 'Index', // 默认控制器名称
	'DEFAULT_ACTION'		=> 'index', // 默认操作名
	//'TMPL_FILE_DEPR'		=> '_', //定义模板简化的目录层次	

	//定界符
	'TMPL_L_DELIM'		=> '{',
	'TMPL_R_DELIM'		=> '}',
	'SHOW_PAGE_TRACE'	=> false, //让页面显示追踪日志信息
	
	/*需要有模板才可以开启，不然无法跳转！*/	
	'TMPL_ACTION_ERROR'	=> 'Public:error', //默认错误跳转对应的模板文件	
	'TMPL_ACTION_SUCCESS'	=> 'Public:success', //默认成功跳转对应的模板文件

	//'LOAD_EXT_CONFIG'	=> 'site',  //加载配置文件
	'LOG_RECORD'		=> true, // 开启日志记录
	'LOG_LEVEL'			=> 'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误
	'LOG_TYPE'			=> 'File', // 日志记录类型 默认为文件方式

	//令牌验证
	'TOKEN_ON'			=> false, //是否开启令牌验证
	'TOKEN_NAME'		=> '__hash__',// 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'		=> 'md5',//令牌验证哈希规则
	'TOKEN_RESET'		=> true,  //令牌验证出错后是否重置令牌 默认为true
	//'DEFAULT_FILTER'		=> 'trim,removeXSS,htmlspecialchars', // 默认参数过滤方法 用于I函数...

	//笑话归类
	'JOKE_TYPE_TEXT'		=> 1, //段子类型
	'JOKE_TYPE_PIC'		=> 2, //图片类型
	'JOKE_TYPE_GIF'		=> 3, //GIF类型
	'JOKE_TYPE_video'		=> 4, //视频类型

	//笑话状态
	'JOKE_STATUS_UNAUDIT'	=> 0, //未审核
	'JOKE_STATUS_AUDIT'	=> 1,   //通过
	'JOKE_STATUS_FAIL'	=> 2,    //未通过

	//用户身份
	'USER_DEFAULT_LEVEL'	=> 1,  //默认等级
	'USER_STATUS_DISABLE'	=> 0,    //禁用
	'USER_STATUS_UNACTIVATE' => 0, //默认状态，未激活或禁用
	'USER_STATUS_NORMAL'	=> 1,  //正常状态
	'USER_DEFAULT_MONEY' => 30,
	'SESSION_EXPIRE' => 600,
	//评论状态
	'REVIEW_STATUS_UNAUDIT' => 0, //未审核
	'REVIEW_STATUS_AUDIT'	=> 1,   //通过
	'REVIEW_STATUS_FAIL'	=> 2,    //未通过  

	//我的信息状态
	'TRACE_STATUS_INCOME'	=> 1, //收入
	'TRACE_STATUS_COST'	=> 2,  //消费
);