<?php
$ini = require('./Data/Conf/config.ini.php');
$rewrite = require('./Data/Conf/rewrite.php');
$tpl = require('./Data/Conf/webtpl.php');
$config = array(
	'VIEW_PATH'		=> './Theme/Pc/', //定义模板目录
	//经验值奖励
	'experience_login'=>10, //登录经验奖励
	//url重写
	'URL_MODEL' => 2,
	'rewrite_type'=>1,
	'index/index'=>'index',//首页
	'index/search'=>'search',//首页
	'login/login'=>'login',//登录
	'login/register'=>'register',//注册
	'question/index'=>'question',//问题首页
	'article/index'=>'article',//文章首页
	'tag/index'=>'tag',//话题首页
	'shop/index'=>'shop',//商城首页
	'professor/index'=>'professor',//找答主首页
	'discussion/index'=>'discussion',//讨论首页
	'guestbook/index'=>'guestbook',//留言板
	//路由
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_ROUTE_RULES' => array(//定义路由
		'login' =>'Login/login',//登录
		'logout' =>'Login/logout',//登出
		'register' => 'Login/register',//注册
		'search'=>'index/search',//搜索
/*
		'article'=>'Article/index',//文章
		'article/:id'=>'Article/detail',//文章详情
		'article/publish'=>'Article/publish',//文章发布

		'question'=>'Question/index',//问答
		'question/:id'=>'Question/detail',//问答详情
		'ask'=>'Question/ask',//提问

		'tag'=>'Tag/index',//话题
		'tag/:id'=>'Tag/detail',//话题详情

		'professor'=>'Professor/index',//答主
		'professor/:id'=>'Professor/detail',//答主详情
		'professor/identify'=>'Professor/identify',//答主详情
*/

		'shop'=>'shop/index',//商城
		'goods/:id'=>'shop/goods_detail',//商品详情
		'cart'=>'shop/cart',//购物车
		'settlement'=>'shop/settlement',//结算

		'homepage'=>'User/homepage',//个人主页
		'homepage/:id'=>'User/homepage',//ta的主页
		'personal_data'=>'User/personal_data',//个人资料
		'user/question'=>'User/question',//我的提问
		'my_answer'=>'User/answer',//我的回答
		'my_article'=>'User/article',//我的文章

		'my_message'=>'User/my_message',//我的消息
		'message_setting'=>'User/message_setting',//消息设置

		'collected_answer'=>array('User/collection',"type=answer"),//收藏的回答
		'collected_article'=>array('User/collection',"type=article"),//收藏的文章
		'collected_goods'=>array('User/collection',"type=goods"),//收藏的商品

		'watch_user'=>array('User/watchlist','type=user'),//关注的用户
		'watch_question'=>array('User/watchlist','type=question'),//关注的问题
		'watch_tag'=>array('User/watchlist','type=tag'),//关注的话题
		'fans'=>'User/fans',//我的粉丝

		'award_record'=>'User/award_record',//打赏记录
		),
);

return array_merge($ini,$rewrite,$config,$tpl);