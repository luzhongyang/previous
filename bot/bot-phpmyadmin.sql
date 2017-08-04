-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-07-14 11:34:24
-- 服务器版本： 5.6.23-log
-- PHP Version: 5.4.41

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bot`
--

-- --------------------------------------------------------

--
-- 表的结构 `app`
--

CREATE TABLE IF NOT EXISTS `app` (
  `app_id` int(11) NOT NULL,
  `app_type` varchar(20) DEFAULT NULL COMMENT '指令类型',
  `app_help` varchar(255) DEFAULT NULL COMMENT '指令说明',
  `app_vars` text COMMENT '指令表单参数',
  `app_fun` varchar(50) DEFAULT NULL COMMENT '指令英文主标识',
  `app_name` varchar(50) DEFAULT NULL COMMENT '指令名称',
  `app_isback` int(2) DEFAULT '1' COMMENT '默认是否返回',
  `app_backfun` varchar(50) DEFAULT NULL COMMENT '默认回调函数',
  `app_stauts` int(2) DEFAULT '0' COMMENT '启用状态',
  `app_plugurl` varchar(100) DEFAULT NULL COMMENT '插件下载地址',
  `app_plugmd5` varchar(40) DEFAULT NULL COMMENT '插件MD5值'
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='插件指令表';

--
-- 转存表中的数据 `app`
--

INSERT INTO `app` (`app_id`, `app_type`, `app_help`, `app_vars`, `app_fun`, `app_name`, `app_isback`, `app_backfun`, `app_stauts`, `app_plugurl`, `app_plugmd5`) VALUES
(1, 'netbot', '获取包含盘符及其根目录的文件列表，以及包含桌面，我的文档等常用路径根目录列表。参数无需填写。', '', 'treeList', '获取整机目录树', NULL, 'Treelist', 1, '', ''),
(2, 'netbot', '路径参数必填！路径中使用“/”!例子：c:/aaa', '{"data":[{"formtype":"text","formname":"path","formtitle":"路径","formdata":null}]}', 'pathList', '指定路径的文件列表', NULL, 'Pathlist', 1, '', ''),
(3, 'netbot', '【路径】【关键词】为必填项！限制后缀名为选填项。', '{"data":[{"formtype":"text","formname":"path","formtitle":"路径","formdata":"c:/"},{"formtype":"text","formname":"search","formtitle":"关键字","formdata":null},{"formtype":"select","formname":"is_content","formtitle":"搜索内容","formdata":{"0":"否","1":"是"}},{"formtype":"select","formname":"is_case","formtitle":"大小写区分","formdata":{"0":"否","1":"是"}},{"formtype":"text","formname":"ext","formtitle":"限制后缀名","formdata":"txt"}]}', 'search', '从指定路径搜索', NULL, 'Wait', 1, '', ''),
(4, 'netbot', '路径参数必填！路径中使用“/”!例子：c:/aaa/1.zip', '{"data":[{"formtype":"text","formname":"path","formtitle":"文件路径","formdata":null}]}', 'fileUpload', '上传文件', NULL, '', 1, '', ''),
(5, 'netbot', '【公网路径】为必填项！例子：http://www.xxx.com/xxx.zip<br>【下载到路径】为必填项！例子：c:/xxx/xxx2.zip', '{"data":[{"formtype":"text","formname":"path","formtitle":"公网路径","formdata":null},{"formtype":"text","formname":"download_to","formtitle":"下载到路径","formdata":null}]}', 'fileDownload', '下载文件', NULL, '', 1, '', ''),
(6, 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa', '{"data":[{"formtype":"text","formname":"path","formtitle":"路径","formdata":null}]}', 'mkdir', '新建文件夹', NULL, '', 1, '', ''),
(7, 'exe', '【留空备用暂不删】', '{"data":[{"formtype":"text","formname":"path","formtitle":"路径","formdata":null},{"formtype":"textarea","formname":"filestr","formtitle":"内容","formdata":null}]}', 'mkfile', '【留空备用暂不删】', NULL, '', 0, '', ''),
(8, 'netbot', '【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{"data":[{"formtype":"pathlist","formname":"list","formtitle":"路径列表","formdata":null}]}', 'pathDelete', '删除文件', NULL, '', 1, '', ''),
(9, 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa/1.txt', '{"data":[{"formtype":"text","formname":"path","formtitle":"路径","formdata":null}]}', 'fileRead', '读取文件', NULL, 'Wait', 1, '', ''),
(10, 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa<br />【内容】选填，为空是建立空内容文件。', '{"data":[{"formtype":"text","formname":"path","formtitle":"保存路径","formdata":null},{"formtype":"text","formname":"charset","formtitle":"保存编码","formdata":"utf-8"},{"formtype":"textarea","formname":"filestr","formtitle":"内容","formdata":null}]}', 'fileSave', '保存文件', NULL, 'Wait', 1, '', ''),
(11, 'netbot', '【压缩到的路径】为选填项，留空为压缩到第一个路径目录。<br />【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{"data":[{"formtype":"text","formname":"path","formtitle":"压缩到的路径","formdata":null},{"formtype":"pathlist","formname":"list","formtitle":"路径列表","formdata":null}]}', 'zip', '压缩文件', NULL, '', 1, 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467'),
(12, 'netbot', '【源路径】【新路径】都为必填项！', '{"data":[{"formtype":"text","formname":"path","formtitle":"源路径","formdata":null},{"formtype":"text","formname":"rname_to","formtitle":"新路径","formdata":null}]}', 'pathRname', '重命名', NULL, '', 1, '', ''),
(13, 'netbot', '【源文件】为必填项！如：c:/1.zip<br />【解压到路径】选填，留空为解压缩到当前路径', '{"data":[{"formtype":"text","formname":"path","formtitle":"源文件","formdata":null},{"formtype":"text","formname":"unzip_to","formtitle":"解压到路径","formdata":null}]}', 'unzip', '解压缩文件到路径', NULL, '', 1, 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467'),
(14, 'netbot', '【粘贴到的路径】为必填项！如：c:/aaa<br />【路径列表】中至少填写一条数据！注意属性和文件路径保持一致！', '{"data":[{"formtype":"select","formname":"copy_type","formtitle":"剪切还是拷贝","formdata":{"cut":"剪切","copy":"拷贝"}},{"formtype":"text","formname":"path_past","formtitle":"粘贴到的路径","formdata":null},{"formtype":"pathlist","formname":"list","formtitle":"路径列表","formdata":null}]}', 'pathPast', '剪切和粘贴', NULL, '', 1, '', ''),
(15, 'netbot', '【压缩到的路径】为选填项，留空为压缩到第一个路径目录。<br />【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{"data":[{"formtype":"text","formname":"path","formtitle":"压缩到的路径","formdata":null},{"formtype":"pathlist","formname":"list","formtitle":"路径列表","formdata":null}]}', 'zipUpload', '先压缩再上传', NULL, '', 1, 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467'),
(16, 'netbot', '【等待结果】控制是否等待命令执行完并返回结果。<br />【超时时间】必填项！最长等待结果时间，单位：秒。<br />【CMD命令】必填项！', '{"data":[{"formtype":"select","formname":"iswait","formtitle":"等待结果","formdata":{"1":"是","0":"否"}},{"formtype":"text","formname":"timeout","formtitle":"超时时间","formdata":60},{"formtype":"textarea","formname":"command","formtitle":"CMD命令","formdata":null}]}', 'cmd', 'CMD命令执行', NULL, 'Wait', 1, '', ''),
(17, 'netbot', '【文件路径】必填项！<br />【参数】选填！', '{"data":[{"formtype":"text","formname":"path","formtitle":"文件路径","formdata":null},{"formtype":"text","formname":"command","formtitle":"附加参数","formdata":null},{"formtype":"select","formname":"mode","formtitle":"窗口模式","formdata":{"0":"隐藏","1":"正常","2":"最大化","3":"最小化"}}]}', 'open', '远程打开文件', NULL, '', 1, '', ''),
(18, 'netbot', '三项中本次不改变的请留空！<br />【心跳间隔】10秒<填写值<10万秒', '{"data":[{"formtype":"selectdb","formname":"nb_url","formtitle":"主节点","formdata":"node"},{"formtype":"selectdb","formname":"nb_url_bak","formtitle":"备用节点","formdata":"node"},{"formtype":"text","formname":"nb_interval","formtitle":"心跳间隔[秒]","formdata":null}]}', 'setconfig', '设置上线地址和心跳时间', NULL, 'Setconfig', 1, '', ''),
(19, 'netbot', '500毫秒<间隔时间<10万毫秒', '{"data":[{"formtype":"text","formname":"interval","formtitle":"间隔时间","formdata":"500"}]}', 'startchat', '进入激活状态', NULL, 'Startchat', 1, '', ''),
(20, 'netbot', '', '', 'endchat', '停止激活状态', NULL, 'Endchat', 1, '', ''),
(21, 'netbot', '', '{"data":[{"formtype":"text","formname":"interval","formtitle":"间隔小时","formdata":"100"}]}', 'sleep', '进入静默状态', NULL, 'Sleep', 1, '', ''),
(24, 'netbot', '', '{"data":[{"formtype":"select","formname":"digit","formtitle":"图像质量","formdata":{"8":"8位","1":"1位","4":"4位","24":"24位"}}]}', 'screen', '抓屏', 1, 'Screen', 1, '', ''),
(25, 'netbot', '', '', 'addmouse', 'addmouse', 1, 'Screen', 0, '', ''),
(26, 'netbot', '', '', 'addkeyboard', 'addkeyboard', 1, 'Screen', 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `chatlist`
--

CREATE TABLE IF NOT EXISTS `chatlist` (
  `id` int(11) NOT NULL,
  `guid` varchar(50) DEFAULT NULL COMMENT '机器GUID',
  `name` varchar(50) DEFAULT NULL COMMENT '机器自定义名称',
  `cname` varchar(100) DEFAULT NULL COMMENT '机器计算机名',
  `username` varchar(50) DEFAULT NULL COMMENT '激活用户',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '数据更新时间',
  `stauts` int(2) DEFAULT '0' COMMENT '状态[0:创建,1:已激活]'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='激活主机列表';

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `ng_id` int(11) NOT NULL,
  `ng_name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `ng_type` varchar(50) DEFAULT NULL COMMENT '分组类型  主分组  扩展分组'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分组列表';

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`ng_id`, `ng_name`, `ng_type`) VALUES
(1, '默认分组', 'main');

-- --------------------------------------------------------

--
-- 表的结构 `login_log`
--

CREATE TABLE IF NOT EXISTS `login_log` (
  `ll_id` int(11) NOT NULL,
  `ll_username` varchar(50) NOT NULL COMMENT '登录名',
  `ll_addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  `ll_ip` varchar(50) NOT NULL COMMENT '登录IP'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员登录日志';

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '登录密码',
  `role` varchar(100) NOT NULL COMMENT '权限[超级管理员|操作员]',
  `lasttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登陆时间',
  `lastip` varchar(100) DEFAULT NULL COMMENT '最后登录IP',
  `grouplist` varchar(255) DEFAULT NULL COMMENT '权限组',
  `grouplist_name` varchar(255) DEFAULT NULL COMMENT '权限组可视数据，方便列表查看时理解',
  `email` varchar(100) DEFAULT NULL COMMENT '用户EMAIL'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户列表';

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `role`, `lasttime`, `lastip`, `grouplist`, `grouplist_name`, `email`) VALUES
(1, 'botadmin', '7fef6171469e80d32c0559f88b377245', 'administrator', '2015-07-14 03:32:34', '127.0.0.1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `netbot`
--

CREATE TABLE IF NOT EXISTS `netbot` (
  `nb_id` int(11) NOT NULL,
  `nb_vid` varchar(20) DEFAULT NULL COMMENT '终端版本号',
  `nb_cname` varchar(50) DEFAULT NULL COMMENT '机器计算机名',
  `nb_name` varchar(50) DEFAULT NULL COMMENT '自定义标识名',
  `nb_inf` varchar(50) DEFAULT NULL COMMENT '备注',
  `nb_guid` varchar(40) NOT NULL COMMENT '机器GUID',
  `nb_addtime` timestamp NULL DEFAULT NULL COMMENT '机器注册时间',
  `nb_lasttime` timestamp NULL DEFAULT NULL COMMENT '机器最后通讯时间',
  `nb_lasturl` varchar(100) DEFAULT NULL COMMENT '机器最后通讯节点',
  `nb_lastip` varchar(20) DEFAULT NULL COMMENT '机器最后通讯IP',
  `nb_lasttype` varchar(10) DEFAULT NULL COMMENT '机器最后通讯类型',
  `nb_group` int(7) DEFAULT NULL COMMENT '机器主分组',
  `nb_task_new` int(2) DEFAULT NULL COMMENT '是否有任务数据',
  `nb_vm` int(2) DEFAULT NULL COMMENT '是否虚拟机',
  `nb_area` varchar(50) DEFAULT NULL COMMENT '机器所在地区',
  `nb_os` varchar(50) DEFAULT NULL COMMENT '机器操作系统',
  `nb_cpu` varchar(100) DEFAULT NULL COMMENT '机器CPU',
  `nb_amd64` int(2) DEFAULT NULL COMMENT '是否64位',
  `nb_mem` int(7) DEFAULT NULL COMMENT '机器内存大小',
  `nb_mac` varchar(50) DEFAULT NULL COMMENT '机器MAC',
  `nb_internet` varchar(10) DEFAULT NULL COMMENT '机器网络类型',
  `nb_stauts_val` varchar(10) DEFAULT NULL COMMENT '最后状态变更值',
  `nb_interval` int(7) DEFAULT '300' COMMENT '心跳包间隔',
  `nb_stauts` int(2) NOT NULL DEFAULT '1' COMMENT '机器状态【0:断开1正常2激活3静默】',
  `nb_url` varchar(100) DEFAULT NULL COMMENT '主节点',
  `nb_url_bak` varchar(100) DEFAULT NULL COMMENT '备用节点',
  `nb_reg` int(2) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='机器列表';

-- --------------------------------------------------------

--
-- 表的结构 `netbot_group_expand`
--

CREATE TABLE IF NOT EXISTS `netbot_group_expand` (
  `nge_id` int(11) NOT NULL,
  `nge_netbot_id` varchar(50) NOT NULL COMMENT '机器GUID',
  `nge_group_id` int(11) NOT NULL COMMENT '机器扩展分组ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='机器扩展组记录';

-- --------------------------------------------------------

--
-- 表的结构 `netbot_robot`
--

CREATE TABLE IF NOT EXISTS `netbot_robot` (
  `id` int(7) NOT NULL,
  `guid` varchar(40) NOT NULL COMMENT '机器GUID',
  `robot` varchar(50) NOT NULL COMMENT '扩展机器人名',
  `addtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '安装时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='扩展机器人安装记录';

-- --------------------------------------------------------

--
-- 表的结构 `netbot_task`
--

CREATE TABLE IF NOT EXISTS `netbot_task` (
  `id` int(11) NOT NULL,
  `taskid` int(7) NOT NULL COMMENT '任务ID',
  `guid` varchar(40) NOT NULL COMMENT '机器GUID',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '最后执行时间',
  `hash` varchar(40) DEFAULT NULL COMMENT '最后执行版本HASH'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='机器计划任务记录';

-- --------------------------------------------------------

--
-- 表的结构 `node`
--

CREATE TABLE IF NOT EXISTS `node` (
  `id` int(7) NOT NULL,
  `url` varchar(100) NOT NULL COMMENT '地址',
  `status` int(2) DEFAULT '1' COMMENT '启用状态',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `inf` varchar(255) DEFAULT NULL COMMENT '备注',
  `addtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网络节点列表';

-- --------------------------------------------------------

--
-- 表的结构 `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `t_id` int(11) NOT NULL,
  `t_name` varchar(100) DEFAULT NULL COMMENT '任务名称',
  `t_inf` varchar(200) DEFAULT NULL COMMENT '任务说明',
  `t_stauts` int(2) DEFAULT '0' COMMENT '任务启用状态',
  `t_starttime` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `t_endtime` timestamp NULL DEFAULT NULL COMMENT '结束时间',
  `t_addtime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `t_group` varchar(200) DEFAULT NULL COMMENT '影响域【组列表或单机GUID】',
  `t_group_name` varchar(200) DEFAULT NULL COMMENT '影响域标识名【便于查看时理解】',
  `t_interval` int(7) DEFAULT '0' COMMENT '任务重复执行时间隔值【小时】',
  `t_hour` int(7) DEFAULT '0',
  `t_os_type` int(2) DEFAULT '0' COMMENT '过滤操作系统【0不过滤1包含2排除】',
  `t_os` varchar(100) DEFAULT NULL COMMENT '操作系统列表',
  `t_url_type` int(2) DEFAULT '0' COMMENT '过滤节点【0不过滤1包含2排除】',
  `t_url` varchar(200) DEFAULT NULL COMMENT '节点列表',
  `t_cpu` varchar(100) DEFAULT NULL,
  `t_mem` int(7) DEFAULT NULL,
  `t_area_type` int(2) DEFAULT '0' COMMENT '过滤地区【0不过滤1包含2排除】',
  `t_area` text COMMENT '地区列表',
  `t_hash` varchar(50) DEFAULT NULL COMMENT '任务版本HASH',
  `t_finish_num` int(7) DEFAULT '0' COMMENT '任务累计触发数',
  `t_netbot` int(2) DEFAULT '0' COMMENT '任务类型【0全局1组2单机】',
  `t_repeat` int(2) DEFAULT '0' COMMENT '是否重复执行',
  `t_isback` int(2) DEFAULT '1' COMMENT '是否返回结果',
  `t_backfun` varchar(50) DEFAULT NULL COMMENT '回调函数',
  `t_app` varchar(50) DEFAULT NULL COMMENT '调用插件类型',
  `t_function` varchar(50) DEFAULT NULL COMMENT '指令名',
  `t_vars` text COMMENT '指令参数',
  `t_plug_url` varchar(100) DEFAULT NULL COMMENT '插件下载地址',
  `t_plug_md5` varchar(50) DEFAULT NULL COMMENT '插件MD5',
  `username` varchar(50) DEFAULT NULL COMMENT '创建人'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='智能计划任务列表';

-- --------------------------------------------------------

--
-- 表的结构 `taskdata_chat`
--

CREATE TABLE IF NOT EXISTS `taskdata_chat` (
  `id` int(11) NOT NULL COMMENT '队列ID',
  `tl_data` mediumtext COMMENT '队列结果'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时队列结果';

-- --------------------------------------------------------

--
-- 表的结构 `taskdata_cron`
--

CREATE TABLE IF NOT EXISTS `taskdata_cron` (
  `id` int(11) NOT NULL COMMENT '队列ID',
  `tl_data` longtext COMMENT '队列结果'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='计划队列结果';

-- --------------------------------------------------------

--
-- 表的结构 `tasklist_chat`
--

CREATE TABLE IF NOT EXISTS `tasklist_chat` (
  `tl_id` int(11) NOT NULL,
  `tl_netbot` varchar(50) DEFAULT NULL COMMENT '机器GUID',
  `tl_taskid` int(11) DEFAULT NULL COMMENT '任务ID',
  `tl_addtime` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `tl_sendtime` timestamp NULL DEFAULT NULL COMMENT '发送时间',
  `tl_finishtime` timestamp NULL DEFAULT NULL COMMENT '完成时间',
  `tl_stauts` int(2) DEFAULT NULL COMMENT '0创建 1 推送 2 完成',
  `tl_isback` int(2) DEFAULT NULL COMMENT '是否返回',
  `tl_backfun` varchar(50) DEFAULT NULL COMMENT '回调函数',
  `tl_app` varchar(50) DEFAULT NULL COMMENT '指令类型',
  `tl_function` varchar(50) DEFAULT NULL COMMENT '指令名',
  `tl_plug_md5` varchar(50) DEFAULT NULL COMMENT '插件MD5',
  `tl_plug_url` varchar(100) DEFAULT NULL COMMENT '插件下载地址',
  `tl_vars` mediumtext COMMENT '指令参数',
  `tl_hash` varchar(50) DEFAULT NULL COMMENT '任务HASH',
  `tl_type` varchar(50) DEFAULT NULL COMMENT '请求类型',
  `tl_oldpath` varchar(255) DEFAULT NULL COMMENT '文件原路径',
  `tl_filename` varchar(255) DEFAULT NULL COMMENT '文件中转站路径',
  `tl_code` int(2) DEFAULT '0' COMMENT '执行结果状态',
  `tl_info` varchar(50) DEFAULT NULL COMMENT '执行结果信息',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时队列';

-- --------------------------------------------------------

--
-- 表的结构 `tasklist_cron`
--

CREATE TABLE IF NOT EXISTS `tasklist_cron` (
  `tl_id` int(11) NOT NULL,
  `tl_netbot` varchar(50) DEFAULT NULL,
  `tl_taskid` int(11) DEFAULT NULL,
  `tl_addtime` timestamp NULL DEFAULT NULL,
  `tl_sendtime` timestamp NULL DEFAULT NULL,
  `tl_finishtime` timestamp NULL DEFAULT NULL,
  `tl_stauts` int(2) DEFAULT NULL COMMENT '0创建 1 推送 2 完成',
  `tl_isback` int(2) DEFAULT NULL,
  `tl_backfun` varchar(50) DEFAULT NULL,
  `tl_app` varchar(50) DEFAULT NULL,
  `tl_function` varchar(50) DEFAULT NULL,
  `tl_plug_md5` varchar(50) DEFAULT NULL,
  `tl_plug_url` varchar(100) DEFAULT NULL,
  `tl_vars` mediumtext,
  `tl_hash` varchar(50) DEFAULT NULL,
  `tl_type` varchar(50) DEFAULT NULL,
  `tl_oldpath` varchar(255) DEFAULT NULL,
  `tl_filename` varchar(255) DEFAULT NULL,
  `tl_code` int(2) DEFAULT '0',
  `tl_info` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='计划队列【字段详情同tasklist_chat】';

-- --------------------------------------------------------

--
-- 表的结构 `task_files`
--

CREATE TABLE IF NOT EXISTS `task_files` (
  `tf_id` int(11) NOT NULL,
  `tf_name` varchar(255) DEFAULT NULL COMMENT '文件名',
  `tf_addtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '上传时间',
  `tf_size` int(11) DEFAULT NULL COMMENT '文件尺寸',
  `tf_oldpath` varchar(255) DEFAULT NULL COMMENT '原路径',
  `tf_filetype` varchar(50) DEFAULT NULL COMMENT '文件类型',
  `tl_id` int(11) DEFAULT NULL COMMENT '队列ID',
  `tl_type` varchar(50) DEFAULT NULL COMMENT '队列类型',
  `tl_taskid` int(11) DEFAULT NULL COMMENT '任务ID',
  `tl_netbot` varchar(50) DEFAULT NULL COMMENT '机器GUID',
  `tf_stauts` int(2) DEFAULT '0' COMMENT '通知状态',
  `tl_backfun` varchar(50) DEFAULT NULL COMMENT '回调函数',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件队列';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app`
--
ALTER TABLE `app`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `chatlist`
--
ALTER TABLE `chatlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ng_id`);

--
-- Indexes for table `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`ll_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `netbot`
--
ALTER TABLE `netbot`
  ADD PRIMARY KEY (`nb_id`),
  ADD UNIQUE KEY `nb_guid` (`nb_guid`);

--
-- Indexes for table `netbot_group_expand`
--
ALTER TABLE `netbot_group_expand`
  ADD PRIMARY KEY (`nge_id`);

--
-- Indexes for table `netbot_robot`
--
ALTER TABLE `netbot_robot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `netbot_task`
--
ALTER TABLE `netbot_task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `node`
--
ALTER TABLE `node`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `taskdata_chat`
--
ALTER TABLE `taskdata_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taskdata_cron`
--
ALTER TABLE `taskdata_cron`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasklist_chat`
--
ALTER TABLE `tasklist_chat`
  ADD PRIMARY KEY (`tl_id`),
  ADD KEY `tl_netbot` (`tl_netbot`);

--
-- Indexes for table `tasklist_cron`
--
ALTER TABLE `tasklist_cron`
  ADD PRIMARY KEY (`tl_id`),
  ADD KEY `tl_netbot` (`tl_netbot`);

--
-- Indexes for table `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`tf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app`
--
ALTER TABLE `app`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `chatlist`
--
ALTER TABLE `chatlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `ng_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login_log`
--
ALTER TABLE `login_log`
  MODIFY `ll_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `netbot`
--
ALTER TABLE `netbot`
  MODIFY `nb_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `netbot_group_expand`
--
ALTER TABLE `netbot_group_expand`
  MODIFY `nge_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `netbot_robot`
--
ALTER TABLE `netbot_robot`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `netbot_task`
--
ALTER TABLE `netbot_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `node`
--
ALTER TABLE `node`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasklist_chat`
--
ALTER TABLE `tasklist_chat`
  MODIFY `tl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasklist_cron`
--
ALTER TABLE `tasklist_cron`
  MODIFY `tl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `task_files`
--
ALTER TABLE `task_files`
  MODIFY `tf_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
