# <?exit();?>
# Tipask Multi-Volume Data Dump Vol.1
# Version: ask2 3.1.1
# Time: 2016-09-21
# Type: 
# Table Prefix: ask_
# Tipask Home: http://www.ask2.cn
DROP TABLE IF EXISTS ask_usergroup;
CREATE TABLE `ask_usergroup` (
  `groupid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(4) NOT NULL DEFAULT '1' COMMENT '用户级别',
  `grouptitle` char(30) NOT NULL DEFAULT '',
  `grouptype` tinyint(1) NOT NULL DEFAULT '2',
  `creditslower` int(10) NOT NULL,
  `creditshigher` int(10) NOT NULL DEFAULT '0',
  `questionlimits` int(10) NOT NULL DEFAULT '0',
  `answerlimits` int(10) NOT NULL DEFAULT '0',
  `credit3limits` int(10) NOT NULL DEFAULT '0',
  `regulars` text NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 AUTO_INCREMENT=27;

INSERT INTO ask_usergroup VALUES ('1','0','超级管理员','1','0','1','0','0','0','user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n');
INSERT INTO ask_usergroup VALUES ('2','0','管理员','1','0','1','0','0','0','user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('3','0','分类员','1','0','1','0','0','0','user/qqlogin,user/register,index/default,category/view,category/list,question/view,category/recommend,note/list,note/view,rss/category,rss/list,rss/question,user/space,user/scorelist,question/search,question/add,gift/default,gift/search,gift/add\r\n,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('6','0','游客','3','0','1','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,user/space_ask,user/space_answer,user/space');
INSERT INTO ask_usergroup VALUES ('7','1','书童','2','0','80','3','3','5','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('8','2','书生','2','80','400','5','5','8','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('9','3','秀才','2','400','800','10','10','10','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('10','4','举人','2','800','2000','15','15','12','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('11','5','解元','2','2000','4000','10','10','10','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('12','6','贡士','2','4000','7000','15','15','20','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('13','7','会元','2','7000','10000','15','15','20','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('14','8','同进士出身','2','10000','14000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('15','9','大学士','2','14000','18000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('16','10','探花','2','18000','22000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('17','11','榜眼','2','22000','32000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('18','12','状元','2','32000','45000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('19','13','编修','2','45000','60000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('20','14','府丞','2','60000','100000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('21','15','翰林学士','2','100000','150000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('22','16','御史中丞','2','150000','250000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('23','17','詹士','2','250000','400000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('24','18','侍郎','2','400000','700000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('25','19','大学士','2','700000','1000000','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');
INSERT INTO ask_usergroup VALUES ('26','20','文曲星','2','1000000','999999999','0','0','0','user/register,user/editimg,index/default,category/view,category/list,question/view,question/follow,topic/default,note/list,note/view,rss/category,rss/list,rss/question,user/scorelist,user/activelist,expert/default,user/qqlogin,gift/default,gift/search,gift/add,question/search,question/add,question/answer,doing/default,user/space_ask,user/space_answer,user/space,answer/append,answer/addcomment,question/edittag,favorite/add,inform/add,question/answercomment,note/addcomment,question/attentto,user/attentto,user/register,user/recommend,user/default,user/score,user/recharge,ebank/aliapyback,ebank/aliapytransfer,user/ask,user/answer,user/follower,user/attention,favorite/default,favorite/delete,question/addfavorite,user/profile,user/uppass,user/editimg,user/saveimg,user/mycategory,user/unchainauth,user/level,attach/uploadimage,question/adopt,question/close,question/supply,question/addscore,question/editanswer,question/search,message/send,message/new,message/personal,message/system,message/outbox,message/view,message/remove,message/removedialog,user/sendcheckmail,user/editemail,user/sendcheckmail,user/editemail');

DROP TABLE IF EXISTS ask_user;
CREATE TABLE `ask_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(18) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '7',
  `credits` int(10) NOT NULL DEFAULT '0',
  `credit1` int(10) NOT NULL DEFAULT '0',
  `credit2` int(10) NOT NULL DEFAULT '0',
  `credit3` int(10) NOT NULL DEFAULT '0',
  `regip` char(15) DEFAULT NULL,
  `regtime` int(10) NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `bday` date DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `qq` varchar(15) DEFAULT NULL,
  `msn` varchar(40) DEFAULT NULL,
  `authstr` varchar(25) DEFAULT NULL,
  `signature` mediumtext,
  `introduction` varchar(200) DEFAULT NULL,
  `questions` int(10) unsigned NOT NULL DEFAULT '0',
  `answers` int(10) unsigned NOT NULL DEFAULT '0',
  `adopts` int(10) unsigned NOT NULL DEFAULT '0',
  `supports` int(10) NOT NULL DEFAULT '0',
  `followers` int(10) NOT NULL DEFAULT '0',
  `attentions` int(10) NOT NULL DEFAULT '0',
  `isnotify` tinyint(1) unsigned NOT NULL DEFAULT '7',
  `elect` int(10) NOT NULL DEFAULT '0',
  `expert` tinyint(2) NOT NULL DEFAULT '0',
  `chuli` int(10) NOT NULL,
  `bankcard` varchar(200) DEFAULT NULL,
  `activecode` varchar(200) DEFAULT NULL,
  `active` int(10) DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=753 DEFAULT CHARSET=utf8 AUTO_INCREMENT=753;

INSERT INTO ask_user VALUES ('1','admin','e10adc3949ba59abbe56e057f20f883e','vip_ask2@163.com','1','200','279','104','0','127.0.0.1','0','1474424045','0','0000-00-00','','','','','若长相守不过你拈花我把酒，酒醒后能否赏我个好梦如旧。\r\n','','47','25','11','20','0','16','1','0','1','1','','','0');
INSERT INTO ask_user VALUES ('742','懒惰赖床的小兵','e10adc3949ba59abbe56e057f20f883e','641282822@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','更喜欢的一方肯定会是弱者，先说对不起，会等待，更会忍耐。\r\n','','1','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('741','猫三七','e10adc3949ba59abbe56e057f20f883e','628656834@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','我想要的不多，一个你一个家一个未出世的ta。\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('740','我是樊磊','e10adc3949ba59abbe56e057f20f883e','454969240@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','比起委屈和失去你 我宁愿一直装傻假装什么都不知道\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('739','该用户已诈尸矣','e10adc3949ba59abbe56e057f20f883e','238802685@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','你的过去我没能参与，你的未来我奉陪到底。\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('738','惜若水三千','e10adc3949ba59abbe56e057f20f883e','714042757@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','太爱所以不分手，太恨所以不快乐。\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('737','cyx168','e10adc3949ba59abbe56e057f20f883e','345321089@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','爱情一旦输给眼泪，一句谎言也算安慰\r\n','','1','2','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('736','唯我.杜康','e10adc3949ba59abbe56e057f20f883e','138115775@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','我一直在寻找一句能够打动你的话\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('735','zhouchangyi','e10adc3949ba59abbe56e057f20f883e','934730058@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','原来我发现我有多爱你\r\n','','1','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('734','360U2699109498','e10adc3949ba59abbe56e057f20f883e','238963185@qq.com','7','0','0','0','0','127.0.0.1','1467783055','1467783055','0','0000-00-00','','','','','我一旦喜欢上你，就对其他人失去兴趣。\r\n','','0','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('733','放手备战','e10adc3949ba59abbe56e057f20f883e','785946692@qq.com','7','0','0','0','0','127.0.0.1','1467783051','1467783051','0','0000-00-00','','','','','静静的牵着手，是最简单的梦。\r\n','','0','2','1','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('732','YY2016小柒','e10adc3949ba59abbe56e057f20f883e','818260663@qq.com','7','0','0','0','0','127.0.0.1','1467783047','1467783047','0','0000-00-00','','','','','被人惦念的滋味是如此让人受宠若惊。\r\n','','0','2','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('731','cjbzd','e10adc3949ba59abbe56e057f20f883e','997137752@qq.com','7','0','0','0','0','127.0.0.1','1467783047','1467783047','0','0000-00-00','','','','','原来我一直为你停留/甚至到忘记了时间。\r\n','','1','2','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('730','f01205','e10adc3949ba59abbe56e057f20f883e','132498280@qq.com','7','0','0','0','0','127.0.0.1','1467783047','1467783047','0','0000-00-00','','','','','在遥远的天边，你是否听见我的呼喊，你是否还记得有个痴痴爱你的傻瓜。\r\n','','2','1','0','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('729','glw205','e10adc3949ba59abbe56e057f20f883e','929754563@qq.com','7','0','0','0','0','127.0.0.1','1467783040','1467783040','0','0000-00-00','','','','','唯求与他共搭未来的列车.抵达幸福的彼岸。\r\n','','1','3','1','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('728','艮本停不下来','e10adc3949ba59abbe56e057f20f883e','294308885@qq.com','7','0','0','0','0','127.0.0.1','1467783007','1467783007','0','0000-00-00','','','','','时光与爱永不老去.Time and love never grows old\r\n','','0','3','1','0','0','0','1','0','0','0','','','0');
INSERT INTO ask_user VALUES ('727','匿名网友','e10adc3949ba59abbe56e057f20f883e','139239274@qq.com','7','0','0','0','0','127.0.0.1','1467783005','1467783005','0','','','','','','','','4','5','3','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('726','','e10adc3949ba59abbe56e057f20f883e','478000969@qq.com','7','0','0','0','0','127.0.0.1','1467783003','1467783003','0','','','','','','','','3','3','1','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('743','ffffff','eed8cdc400dfd4ec85dff70a170066b7','342343@qq.com','7','0','0','0','0','127.0.0.1','1469087335','1469087335','0','','','','','','','','0','0','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('744','jjjjjj','3abf00fa61bfae2fff9133375e142416','343243@qq.com','7','0','0','0','0','127.0.0.1','1469087428','1469087428','0','','','','','','','','2','0','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('745','林大头的娘','e10adc3949ba59abbe56e057f20f883e','570823386@qq.com','7','0','0','0','0','127.0.0.1','1470289599','1470289599','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('746','宝妹儿妈z','e10adc3949ba59abbe56e057f20f883e','334032599@qq.com','7','0','0','0','0','127.0.0.1','1470289599','1470289599','0','','','','','','','','1','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('747','毛毛的丹妮','e10adc3949ba59abbe56e057f20f883e','980766767@qq.com','7','0','0','0','0','127.0.0.1','1470289599','1470289599','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('748','你深知我心','e10adc3949ba59abbe56e057f20f883e','506516444@qq.com','7','0','0','0','0','127.0.0.1','1470289599','1470289599','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('749','树友i7a0ih','e10adc3949ba59abbe56e057f20f883e','310599620@qq.com','7','0','0','0','0','127.0.0.1','1470290439','1470290439','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('750','2胖巫婆','e10adc3949ba59abbe56e057f20f883e','685072533@qq.com','7','0','0','0','0','127.0.0.1','1470290441','1470290441','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('751','欧小二他老','e10adc3949ba59abbe56e057f20f883e','924270818@qq.com','7','0','0','0','0','127.0.0.1','1470290441','1470290441','0','','','','','','','','0','1','1','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('752','咖啡有点儿','e10adc3949ba59abbe56e057f20f883e','382717555@qq.com','7','0','0','0','0','127.0.0.1','1470290441','1470290441','0','','','','','','','','0','1','0','0','0','0','7','0','0','0','','','0');
INSERT INTO ask_user VALUES ('2','xingfu','111111','980306726@qq.com','7','0','0','0','0','127.0.0.1','1471342263','1471342439','0','','','','','','','','0','0','0','0','0','0','7','0','0','0','','','0');

DROP TABLE IF EXISTS ask_answer_append;
CREATE TABLE `ask_answer_append` (
  `appendanswerid` int(10) NOT NULL AUTO_INCREMENT,
  `answerid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `authorid` int(10) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`appendanswerid`),
  KEY `answerid` (`answerid`),
  KEY `authorid` (`authorid`),
  KEY `time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;


DROP TABLE IF EXISTS ask_answer_comment;
CREATE TABLE `ask_answer_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(10) NOT NULL,
  `authorid` int(10) NOT NULL,
  `author` char(18) NOT NULL,
  `content` varchar(100) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=384 DEFAULT CHARSET=utf8 AUTO_INCREMENT=384;

INSERT INTO ask_answer_comment VALUES ('374','1173','1','admin','你真的帮了我大忙','1467783003');
INSERT INTO ask_answer_comment VALUES ('375','1175','1','admin','你真的帮了我大忙','1467783005');
INSERT INTO ask_answer_comment VALUES ('376','1177','727','匿名网友','谢谢你','1467783007');
INSERT INTO ask_answer_comment VALUES ('377','1180','1','admin','高手留个联系方式吧','1467783042');
INSERT INTO ask_answer_comment VALUES ('378','1181','729','glw205','非常感谢你','1467783044');
INSERT INTO ask_answer_comment VALUES ('379','1182','726','','大神......','1467783045');
INSERT INTO ask_answer_comment VALUES ('380','1202','731','cjbzd','真给力','1467783058');
INSERT INTO ask_answer_comment VALUES ('381','1203','742','懒惰赖床的小兵','谢谢你','1467783060');
INSERT INTO ask_answer_comment VALUES ('382','1204','730','f01205','你真的帮了我大忙','1467783062');
INSERT INTO ask_answer_comment VALUES ('383','1212','744','jjjjjj','真给力','1470290441');

DROP TABLE IF EXISTS ask_answer_support;
CREATE TABLE `ask_answer_support` (
  `sid` char(16) NOT NULL,
  `aid` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`sid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_attach;
CREATE TABLE `ask_attach` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `filename` char(100) NOT NULL DEFAULT '',
  `filetype` char(50) NOT NULL DEFAULT '',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0',
  `location` char(100) NOT NULL DEFAULT '',
  `downloads` mediumint(8) NOT NULL DEFAULT '0',
  `isimage` tinyint(1) NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `time` (`time`,`isimage`,`downloads`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


DROP TABLE IF EXISTS ask_badword;
CREATE TABLE `ask_badword` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(15) NOT NULL DEFAULT '',
  `find` varchar(255) NOT NULL DEFAULT '',
  `replacement` varchar(255) NOT NULL DEFAULT '',
  `findpattern` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `find` (`find`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;

INSERT INTO ask_badword VALUES ('4','admin','习近平','小习','');
INSERT INTO ask_badword VALUES ('3','admin','汉语','中国话','');

DROP TABLE IF EXISTS ask_banned;
CREATE TABLE `ask_banned` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `ip1` char(3) NOT NULL,
  `ip2` char(3) NOT NULL,
  `ip3` char(3) NOT NULL,
  `ip4` char(3) NOT NULL,
  `admin` varchar(15) NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `expiration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_category;
CREATE TABLE `ask_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `dir` char(30) NOT NULL,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `grade` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `questions` int(10) unsigned NOT NULL DEFAULT '0',
  `alias` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 AUTO_INCREMENT=27;

INSERT INTO ask_category VALUES ('25','电脑网络','','23','2','0','0','');
INSERT INTO ask_category VALUES ('26','编程','','23','2','1','0','');
INSERT INTO ask_category VALUES ('22','默认','','0','1','0','19','');
INSERT INTO ask_category VALUES ('23','电脑','','0','1','0','2','');
INSERT INTO ask_category VALUES ('24','生活','','0','1','1','5','');

DROP TABLE IF EXISTS ask_category_admin;
CREATE TABLE `ask_category_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_chexingku;
CREATE TABLE `ask_chexingku` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shouzimu` varchar(200) NOT NULL,
  `pinpai` varchar(200) NOT NULL,
  `chexing` varchar(200) NOT NULL,
  `jiaqian` varchar(200) NOT NULL,
  `jiebie` varchar(200) NOT NULL,
  `chexingjiegou` varchar(200) NOT NULL,
  `fadongji` varchar(200) NOT NULL,
  `biansuxiang` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4358 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4358;

INSERT INTO ask_chexingku VALUES ('2909','A','AC Schnitzer','AC Schnitzer M3','109.00万','','三厢','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2910','A','AC Schnitzer','AC Schnitzer X5','110.00万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2911','A','阿尔法罗密欧','ALFA 156','35.00万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2912','A','阿尔法罗密欧','ALFA GT','40.00万','','硬顶跑车','3.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('2913','A','阿斯顿·马丁','Rapide','298.80-364.50万','','掀背','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2914','A','阿斯顿·马丁','拉共达Taraf','810.00万','','三厢','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2915','A','阿斯顿·马丁','V8 Vantage','198.80-218.80万','','软顶敞篷车','4.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('2916','A','阿斯顿·马丁','V12 Vantage','289.80-309.80万','','软顶敞篷车','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2917','A','阿斯顿·马丁','阿斯顿·马丁DB9','341.80-388.80万','','软顶敞篷车','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2918','A','阿斯顿·马丁','Vanquish','498.80-537.20万','','软顶敞篷车','6.0L','自动');
INSERT INTO ask_chexingku VALUES ('2919','A','阿斯顿·马丁','阿斯顿·马丁DB11','325.90万','','硬顶跑车','5.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('2920','A','阿斯顿·马丁','Virage','430.00-456.00万','','软顶敞篷车','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2921','A','阿斯顿·马丁','V12 Zagato','1200.00万','','硬顶跑车','6.0L','手动');
INSERT INTO ask_chexingku VALUES ('2922','A','阿斯顿·马丁','阿斯顿·马丁DBS','449.90-489.90万','','软顶敞篷车','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2923','A','安凯客车','宝斯通','28.80-35.00万','','客车','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('2924','A','奥迪','奥迪A3','18.49-28.10万','','两厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2925','A','奥迪','奥迪A4L','28.99-39.39万','','三厢','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('2926','A','奥迪','奥迪A6L','41.53-75.76万','','三厢','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('2927','A','奥迪','奥迪Q3','23.42-34.49万','','SUV','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2928','A','奥迪','奥迪Q5','38.34-53.40万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2929','A','奥迪','奥迪A4','27.49-56.65万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('2930','A','奥迪','奥迪A6','30.80-54.17万','','三厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('2931','A','奥迪','奥迪A1','19.98-28.98万','','两厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2932','A','奥迪','奥迪A3(进口)','29.98-40.78万','','两厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2933','A','奥迪','奥迪S3','39.98万','','三厢','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2934','A','奥迪','奥迪A4(进口)','41.80万','','旅行版','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2935','A','奥迪','奥迪A5','39.80-62.80万','','掀背','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('2936','A','奥迪','奥迪S5','67.90-85.80万','','掀背','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2937','A','奥迪','奥迪A6(进口)','59.98-63.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2938','A','奥迪','奥迪S6','99.98万','','三厢','4.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2939','A','奥迪','奥迪A7','59.80-93.80万','','掀背','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('2940','A','奥迪','奥迪S7','135.80万','','掀背','4.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2941','A','奥迪','奥迪A8','87.98-271.50万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2942','A','奥迪','奥迪S8','198.80万','','三厢','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2943','A','奥迪','奥迪Q3(进口)','37.70-42.88万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2944','A','奥迪','奥迪Q5(进口)','58.80-61.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2945','A','奥迪','奥迪SQ5','66.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2946','A','奥迪','奥迪Q7','75.38-109.88万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2947','A','奥迪','奥迪TT','54.28-61.78万','','软顶敞篷车','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2948','A','奥迪','奥迪TTS','68.18-72.98万','','软顶敞篷车','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2949','A','奥迪','奥迪R8','182.30-253.80万','','软顶敞篷车','4.2L','双离合');
INSERT INTO ask_chexingku VALUES ('2950','A','奥迪','奥迪RS 5','109.80-128.80万','','软顶敞篷车','4.2L','双离合');
INSERT INTO ask_chexingku VALUES ('2951','A','奥迪','奥迪RS 6','159.80万','','旅行版','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2952','A','奥迪','奥迪RS 7','169.88-189.80万','','掀背','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2953','B','巴博斯','巴博斯 CLS级','87.00万','','三厢','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('2954','B','巴博斯','巴博斯 SLK级','62.00万','','硬顶敞篷车','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('2955','B','巴博斯','巴博斯 S级','156.80万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2956','B','巴博斯','巴博斯 M级','125.80万','','SUV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('2957','B','宝骏','乐驰','3.98-4.98万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('2958','B','宝骏','宝骏330','5.58-5.98万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('2959','B','宝骏','宝骏610','5.98-8.58万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('2960','B','宝骏','宝骏630','5.98-7.48万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('2961','B','宝骏','宝骏560','7.38-9.48万','','SUV','1.5T','AMT');
INSERT INTO ask_chexingku VALUES ('2962','B','宝骏','宝骏730','6.08-8.98万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('2963','B','宝马','宝马2系旅行车','23.69-33.19万','','两厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2964','B','宝马','宝马3系','28.30-59.88万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('2965','B','宝马','宝马5系','43.56-77.86万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2966','B','宝马','宝马X1','28.60-43.90万','','SUV','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2967','B','宝马','宝马i3','41.68-51.68万','','两厢','0.7L','固定齿比');
INSERT INTO ask_chexingku VALUES ('2968','B','宝马','宝马1系(进口)','25.60-49.60万','','两厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2969','B','宝马','宝马3系(进口)','39.96-67.00万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2970','B','宝马','宝马3系GT','39.80-66.70万','','掀背','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2971','B','宝马','宝马4系','42.00-83.00万','','掀背','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2972','B','宝马','宝马5系(进口)','45.70-87.90万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2973','B','宝马','宝马5系GT','68.80-168.80万','','掀背','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2974','B','宝马','宝马6系','95.20-188.20万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2975','B','宝马','宝马7系','89.80-198.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2976','B','宝马','宝马X3','42.10-75.00万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2977','B','宝马','宝马X4','53.00-77.40万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2978','B','宝马','宝马X5','75.80-172.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2979','B','宝马','宝马X6','83.80-216.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2980','B','宝马','宝马2系多功能旅行车','28.99-32.99万','','MPV','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2981','B','宝马','宝马2系','27.60-51.70万','','软顶敞篷车','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2982','B','宝马','宝马i8','198.80万','','硬顶跑车','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2983','B','宝马','宝马Z4','58.30-90.90万','','硬顶敞篷车','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2984','B','宝马','宝马2系旅行车(进口)','27.99-34.99万','','两厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('2985','B','宝马','宝马X1(进口)','36.70-56.50万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('2986','B','宝马','宝马M3','99.80-111.08万','','三厢','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2987','B','宝马','宝马M4','92.70-120.68万','','硬顶敞篷车','3.0T','手动');
INSERT INTO ask_chexingku VALUES ('2988','B','宝马','宝马M5','178.80-197.80万','','三厢','4.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2989','B','宝马','宝马M6','220.60-229.60万','','三厢','4.4T','双离合');
INSERT INTO ask_chexingku VALUES ('2990','B','宝马','宝马X5 M','198.80万','','SUV','4.4T','手自一体');
INSERT INTO ask_chexingku VALUES ('2991','B','宝马','宝马X6 M','215.80万','','SUV','4.4T','手自一体');
INSERT INTO ask_chexingku VALUES ('2992','B','宝马','宝马M2','64.05万','','硬顶跑车','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2993','B','宝马','宝马1系M','59.80万','','硬顶跑车','3.0T','手动');
INSERT INTO ask_chexingku VALUES ('2994','B','宝沃','宝沃BX7','16.98-30.28万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2995','B','保时捷','Panamera','114.50-407.20万','','掀背','2.9T','手自一体');
INSERT INTO ask_chexingku VALUES ('2996','B','保时捷','Macan','58.80-99.80万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2997','B','保时捷','Cayenne','97.20-283.90万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('2998','B','保时捷','保时捷718','58.80-85.80万','','软顶敞篷车','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('2999','B','保时捷','保时捷911','131.80-276.10万','','软顶敞篷车','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3000','B','保时捷','918 Spyder','1338.8-1463.5万','','硬顶敞篷车','4.6L','双离合');
INSERT INTO ask_chexingku VALUES ('3001','B','保时捷','Boxster','74.70-106.50万','','软顶敞篷车','2.7L','双离合');
INSERT INTO ask_chexingku VALUES ('3002','B','保时捷','Cayman','72.70-111.80万','','硬顶跑车','2.7L','双离合');
INSERT INTO ask_chexingku VALUES ('3003','B','北京','北京40','12.98-16.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3004','B','北京','北京80','28.80-29.80万','','SUV','2.3T','手动');
INSERT INTO ask_chexingku VALUES ('3005','B','北京','北京汽车E系列','4.58-8.78万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3006','B','北汽幻速','北汽幻速H6','暂无报价','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3007','B','北汽幻速','北汽幻速S2','5.18-6.08万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3008','B','北汽幻速','北汽幻速S3','5.48-6.68万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3009','B','北汽幻速','北汽幻速S6','7.98-11.68万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3010','B','北汽幻速','北汽幻速H3','5.58-6.28万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3011','B','北汽幻速','北汽幻速H3F','5.88-6.78万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3012','B','北汽幻速','北汽幻速H2','3.98-6.68万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3013','B','北汽幻速','北汽幻速H2V','3.58-3.98万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3014','B','北汽绅宝','绅宝D20','4.88-8.28万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3015','B','北汽绅宝','绅宝CC','9.98-14.98万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3016','B','北汽绅宝','绅宝D50','7.48-11.38万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3017','B','北汽绅宝','绅宝D60','11.98-16.88万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3018','B','北汽绅宝','绅宝D70','13.98-21.58万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3019','B','北汽绅宝','绅宝D80','20.48-26.88万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3020','B','北汽绅宝','绅宝X25','5.58-7.58万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3021','B','北汽绅宝','绅宝X35','6.58-8.88万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3022','B','北汽绅宝','绅宝X55','7.68-11.98万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3023','B','北汽绅宝','绅宝X65','9.88-14.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3024','B','北汽威旺','北汽威旺S50','7.98-10.88万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3025','B','北汽威旺','北汽威旺306','3.18-4.68万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3026','B','北汽威旺','北汽威旺307','4.38-5.18万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3027','B','北汽威旺','北汽威旺M20','4.03-5.68万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3028','B','北汽威旺','北汽威旺M30','4.43-5.43万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3029','B','北汽威旺','北汽威旺M35','5.58-6.13万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3030','B','北汽威旺','北汽威旺T205-D','2.98-3.40万','','皮卡','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3031','B','北汽威旺','北汽威旺205','2.98-4.08万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3032','B','北汽威旺','北汽007','8.28-10.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3033','B','北汽新能源','EV系列','17.78-24.69万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3034','B','北汽新能源','EU系列','25.69万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3035','B','北汽新能源','北汽新能源ES210','34.69万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3036','B','北汽新能源','EX系列','20.69-21.69万','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3037','B','北汽制造','战旗','7.04-8.08万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3038','B','北汽制造','BJ 212','6.57-7.03万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3039','B','北汽制造','北京BW007','8.28-10.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3040','B','北汽制造','勇士','19.70-20.90万','','SUV','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('3041','B','北汽制造','陆霸','15.28-17.28万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3042','B','北汽制造','越铃','5.17-7.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3043','B','北汽制造','锐铃','7.16-11.67万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3044','B','北汽制造','战旗皮卡','6.29-7.74万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3045','B','北汽制造','骑士S12','7.88-10.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3046','B','北汽制造','陆铃','6.48万','','皮卡','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3047','B','奔驰','奔驰C级','31.48-59.90万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3048','B','奔驰','奔驰E级','39.80-79.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3049','B','奔驰','奔驰GLA','26.98-39.80万','','SUV','1.6T','双离合');
INSERT INTO ask_chexingku VALUES ('3050','B','奔驰','奔驰GLC','39.60-57.90万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3051','B','奔驰','奔驰GLK级','37.80-55.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3052','B','奔驰','奔驰V级','48.90-61.80万','','MPV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3053','B','奔驰','威霆','33.90-38.90万','','MPV','2.1T','手动');
INSERT INTO ask_chexingku VALUES ('3054','B','奔驰','唯雅诺','44.90-68.90万','','MPV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3055','B','奔驰','凌特','37.60-49.90万','','客车','2.1T','手动');
INSERT INTO ask_chexingku VALUES ('3056','B','奔驰','奔驰A级','23.40-36.00万','','两厢','1.6T','双离合');
INSERT INTO ask_chexingku VALUES ('3057','B','奔驰','奔驰B级','24.20-36.80万','','两厢','1.6T','双离合');
INSERT INTO ask_chexingku VALUES ('3058','B','奔驰','奔驰CLA级','26.60-37.80万','','三厢','1.6T','双离合');
INSERT INTO ask_chexingku VALUES ('3059','B','奔驰','奔驰C级(进口)','38.28-57.00万','','旅行版','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3060','B','奔驰','奔驰E级(进口)','53.00-85.30万','','软顶敞篷车','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3061','B','奔驰','奔驰CLS级','69.80-98.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3062','B','奔驰','奔驰S级','93.80-199.80万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3063','B','奔驰','奔驰GLE','76.80-119.80万','','SUV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('3064','B','奔驰','奔驰G级','169.80万','','SUV','4.0T','自动');
INSERT INTO ask_chexingku VALUES ('3065','B','奔驰','奔驰GLS','107.60-159.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3066','B','奔驰','奔驰R级','59.80-80.60万','','MPV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3067','B','奔驰','奔驰SLK级','58.80-89.80万','','硬顶敞篷车','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3068','B','奔驰','奔驰SL级','106.80-130.80万','','硬顶敞篷车','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3069','B','奔驰','奔驰GLA(进口)','28.98-39.80万','','SUV','1.6T','双离合');
INSERT INTO ask_chexingku VALUES ('3070','B','奔驰','Sprinter','125.00万','','MPV','3.5L','自动');
INSERT INTO ask_chexingku VALUES ('3071','B','奔驰','威霆(进口)','33.00-38.00万','','MPV','2.3L','自动');
INSERT INTO ask_chexingku VALUES ('3072','B','奔驰','奔驰GLK级(进口)','44.80-72.80万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3073','B','奔驰','奔驰M级','77.80-195.80万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3074','B','奔驰','奔驰GL级','103.80-159.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3075','B','奔驰','唯雅诺(进口)','57.00-86.80万','','MPV','3.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3076','B','奔驰','奔驰CLK级','64.00-91.80万','','软顶敞篷车','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3077','B','奔驰','奔驰CL级','249.80万','','硬顶跑车','5.5T','自动');
INSERT INTO ask_chexingku VALUES ('3078','B','奔驰','奔驰A级AMG','49.80-59.20万','','两厢','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3079','B','奔驰','奔驰CLA级AMG','59.80万','','三厢','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3080','B','奔驰','奔驰C级AMG','99.80-127.80万','','三厢','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3081','B','奔驰','奔驰CLS级AMG','177.80-186.80万','','三厢','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3082','B','奔驰','奔驰S级AMG','247.80-299.80万','','三厢','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3083','B','奔驰','奔驰GLA AMG','57.80万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3084','B','奔驰','奔驰GLE AMG','185.80-198.80万','','SUV','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3085','B','奔驰','奔驰G级AMG','231.80-381.80万','','SUV','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3086','B','奔驰','奔驰GLS AMG','199.80万','','SUV','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3087','B','奔驰','奔驰SL级AMG','239.80万','','硬顶敞篷车','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3088','B','奔驰','AMG GT','141.80-168.80万','','硬顶跑车','4.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3089','B','奔驰','奔驰E级AMG','148.80万','','三厢','6.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3090','B','奔驰','奔驰SLK级AMG','129.90万','','硬顶敞篷车','5.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3091','B','奔驰','奔驰M级AMG','189.80-199.80万','','SUV','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3092','B','奔驰','奔驰GL级AMG','198.00-214.80万','','SUV','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3093','B','奔驰','奔驰SLS级AMG','308.00-380.00万','','硬顶跑车','6.2L','双离合');
INSERT INTO ask_chexingku VALUES ('3094','B','奔驰','迈巴赫S级','146.80-288.80万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3095','B','奔腾','奔腾B30','6.98-9.28万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3096','B','奔腾','全新奔腾B50','8.18-12.28万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3097','B','奔腾','奔腾B70','9.98-14.98万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3098','B','奔腾','奔腾B90','14.58-20.18万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3099','B','奔腾','奔腾X80','11.98-18.18万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3100','B','本田','杰德','14.98-18.38万','','两厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3101','B','本田','思域','12.99-16.99万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3102','B','本田','哥瑞','7.98-11.98万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3103','B','本田','思铂睿','17.98-26.78万','','三厢','2.0L','双离合');
INSERT INTO ask_chexingku VALUES ('3104','B','本田','本田XR-V','12.78-16.28万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3105','B','本田','本田CR-V','17.98-24.98万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3106','B','本田','艾力绅','24.98-30.98万','','MPV','2.4L','无级');
INSERT INTO ask_chexingku VALUES ('3107','B','本田','飞度','7.38-11.28万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3108','B','本田','锋范','7.98-11.98万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3109','B','本田','凌派','10.98-14.98万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3110','B','本田','歌诗图','25.98-33.58万','','掀背','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3111','B','本田','雅阁','16.98-23.78万','','三厢','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3112','B','本田','缤智','12.88-18.98万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3113','B','本田','奥德赛','22.98-29.98万','','MPV','2.4L','无级');
INSERT INTO ask_chexingku VALUES ('3114','B','本田','锋范经典','8.98-15.98万','','三厢','1.5L','自动');
INSERT INTO ask_chexingku VALUES ('3115','B','本田','思迪','9.38-12.48万','','三厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3116','B','本田','INSIGHT','20.98万','','掀背','1.3L','无级');
INSERT INTO ask_chexingku VALUES ('3117','B','本田','本田CR-Z','28.88万','','硬顶跑车','1.5L','无级');
INSERT INTO ask_chexingku VALUES ('3118','B','本田','飞度(进口)','17.98万','','两厢','1.3L','无级');
INSERT INTO ask_chexingku VALUES ('3119','B','本田','里程','40.00万','','三厢','3.5L','自动');
INSERT INTO ask_chexingku VALUES ('3120','B','本田','时韵','28.00万','','MPV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('3121','B','比亚迪','比亚迪F0','3.79-4.79万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3122','B','比亚迪','比亚迪e5','22.98-24.98万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3123','B','比亚迪','比亚迪F3','4.39-7.29万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3124','B','比亚迪','比亚迪G3','6.29-7.89万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3125','B','比亚迪','比亚迪G5','7.59-10.29万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3126','B','比亚迪','比亚迪L3','5.49-7.19万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3127','B','比亚迪','秦','20.98-30.98万','','三厢','1.5T','固定齿比');
INSERT INTO ask_chexingku VALUES ('3128','B','比亚迪','速锐','6.99-9.59万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3129','B','比亚迪','比亚迪G6','7.98-11.58万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3130','B','比亚迪','思锐','10.39-15.09万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3131','B','比亚迪','元','5.99-24.98万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3132','B','比亚迪','宋','9.69-14.69万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3133','B','比亚迪','比亚迪S6','7.99-12.39万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3134','B','比亚迪','比亚迪S7','10.69-14.69万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3135','B','比亚迪','唐','25.13-51.88万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3136','B','比亚迪','比亚迪e6','30.98-36.98万','','MPV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3137','B','比亚迪','比亚迪M6','10.39-15.39万','','MPV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3138','B','比亚迪','福莱尔','2.98-5.58万','','两厢','0.8L','自动');
INSERT INTO ask_chexingku VALUES ('3139','B','比亚迪','比亚迪F3R','5.39-7.38万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3140','B','比亚迪','比亚迪G3R','5.99-7.39万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3141','B','比亚迪','比亚迪F6','7.98-15.98万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3142','B','比亚迪','比亚迪S8','16.58-20.68万','','硬顶敞篷车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3143','B','标致','标致301','8.57-11.97万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3144','B','标致','标致308','10.59-13.49万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3145','B','标致','标致308S','11.27-17.97万','','两厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3146','B','标致','标致408','12.97-18.97万','','三厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3147','B','标致','标致508','17.37-26.97万','','三厢','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('3148','B','标致','标致2008','9.97-16.37万','','SUV','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3149','B','标致','标致3008','15.27-22.32万','','SUV','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('3150','B','标致','标致206','7.78-33.00万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3151','B','标致','标致207','7.18-10.78万','','两厢','1.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3152','B','标致','标致307','9.28-19.18万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3153','B','标致','标致4008(进口)','19.98-27.98万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3154','B','标致','标致RCZ','32.88-35.68万','','硬顶跑车','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3155','B','标致','标致308(进口)','22.38-34.84万','','旅行版','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3156','B','标致','标致3008(进口)','24.68-26.68万','','SUV','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3157','B','标致','标致206(进口)','25.50万','','硬顶敞篷车','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3158','B','标致','标致207(进口)','21.68-26.58万','','硬顶敞篷车','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3159','B','标致','标致307(进口)','23.98-36.00万','','旅行版','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3160','B','标致','标致407','28.00-49.00万','','三厢','1.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3161','B','标致','标致607','43.00-47.00万','','三厢','2.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3162','B','别克','凯越','8.69-10.59万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3163','B','别克','威朗','13.59-20.59万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3164','B','别克','英朗','10.99-15.99万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3165','B','别克','君威','17.89-27.99万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3166','B','别克','君越','22.58-33.98万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3167','B','别克','昂科拉','13.99-18.99万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3168','B','别克','昂科威','21.99-34.99万','','SUV','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3169','B','别克','别克GL8','20.90-39.99万','','MPV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3170','B','别克','林荫大道','30.89-49.88万','','三厢','2.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3171','B','别克','荣御','36.80-49.80万','','三厢','2.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3172','B','别克','昂科雷','50.90-64.90万','','SUV','3.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3173','B','宾利','慕尚','498.00-555.80万','','三厢','6.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3174','B','宾利','飞驰','319.80-435.80万','','三厢','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3175','B','宾利','添越','398.00-480.00万','','SUV','6.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3176','B','宾利','欧陆','304.80-526.80万','','软顶敞篷车','4.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3177','B','宾利','雅致','498.00-1288万','','三厢','6.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3178','B','布加迪','威航','2500.00万','','硬顶跑车','8.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3179','C','昌河','昌河Q25','5.59-7.59万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3180','C','昌河','福瑞达','2.88-4.78万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3181','C','昌河','福瑞达M50','4.68-5.78万','','客车','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3182','C','昌河','福运','3.98-4.18万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3183','C','昌河','福瑞达K21','3.69-3.79万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3184','C','昌河','福瑞达K22','3.99-4.09万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3185','C','昌河','爱迪尔','3.49-4.88万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3186','C','长安','奔奔','4.49-6.09万','','两厢','1.4L','AMT');
INSERT INTO ask_chexingku VALUES ('3187','C','长安','奔奔MINI','3.69-4.99万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3188','C','长安','长安CX20','5.59-6.59万','','两厢','1.4L','AMT');
INSERT INTO ask_chexingku VALUES ('3189','C','长安','悦翔V5','6.19-7.59万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3190','C','长安','悦翔V3','4.69-5.39万','','三厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3191','C','长安','逸动','7.49-24.99万','','两厢','1.5T','固定齿比');
INSERT INTO ask_chexingku VALUES ('3192','C','长安','悦翔V7','5.99-8.79万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3193','C','长安','睿骋','10.88-20.18万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3194','C','长安','长安CS15','5.79-7.39万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3195','C','长安','长安CS35','7.89-9.89万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3196','C','长安','长安CS75','9.28-15.88万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3197','C','长安','奔奔i','3.69-5.88万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3198','C','长安','奔奔LOVE','3.89-5.89万','','两厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3199','C','长安','悦翔','5.39-7.29万','','两厢','1.5L','自动');
INSERT INTO ask_chexingku VALUES ('3200','C','长安','长安CX30','6.38-10.68万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3201','C','长安','志翔','7.98-11.58万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3202','C','长安','杰勋','10.48-14.98万','','MPV','1.5L','自动');
INSERT INTO ask_chexingku VALUES ('3203','C','长安商用','长安V5','4.28-4.66万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3204','C','长安商用','欧力威','3.98-6.59万','','两厢','1.2L','AMT');
INSERT INTO ask_chexingku VALUES ('3205','C','长安商用','长安CX70','6.89-8.49万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3206','C','长安商用','欧尚','5.19-6.49万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3207','C','长安商用','长安之星','2.50-5.09万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3208','C','长安商用','长安之星2','3.19-4.68万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3209','C','长安商用','长安之星3','2.99-3.99万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3210','C','长安商用','长安之星7','3.69-4.09万','','客车','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3211','C','长安商用','长安之星9','4.78-5.28万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3212','C','长安商用','欧诺','3.59-5.39万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3213','C','长安商用','长安星卡','3.59-4.48万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3214','C','长安商用','金牛星','4.59-5.89万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3215','C','长安商用','长安星光','2.89-3.68万','','客车','0.8L','手动');
INSERT INTO ask_chexingku VALUES ('3216','C','长安商用','长安之星S460','3.55-4.79万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3217','C','长安商用','神骐T20','4.08-5.55万','','货车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3218','C','长安商用','睿行','5.89-7.19万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3219','C','长安商用','睿行M90','6.99-8.99万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3220','C','长安商用','尊行','15.58-21.98万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3221','C','长安商用','神骐F30','4.99-5.80万','','皮卡','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3222','C','长安商用','神骐F50','6.29-7.09万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3223','C','长安商用','长安星光4500','5.09-5.88万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3224','C','长城','长城C30','5.49-7.19万','','三厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3225','C','长城','长城C50','7.39-9.28万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3226','C','长城','风骏5','6.88-12.08万','','皮卡','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3227','C','长城','风骏6','8.68-12.48万','','皮卡','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3228','C','长城','风骏3','7.08-12.08万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3229','C','长城','长城精灵','3.69-4.99万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3230','C','长城','长城C20R','6.29-7.29万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3231','C','长城','长城M2','6.59-8.99万','','两厢','1.5L','无级');
INSERT INTO ask_chexingku VALUES ('3232','C','长城','酷熊','6.39-8.79万','','两厢','1.5L','无级');
INSERT INTO ask_chexingku VALUES ('3233','C','长城','凌傲','5.49-8.09万','','两厢','1.3L','无级');
INSERT INTO ask_chexingku VALUES ('3234','C','长城','炫丽','5.39-7.89万','','两厢','1.3L','无级');
INSERT INTO ask_chexingku VALUES ('3235','C','长城','长城M1','4.39-5.99万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3236','C','长城','长城M4','6.39-7.79万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3237','C','长城','赛弗','7.48-9.96万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3238','C','长城','赛影','6.48-10.98万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3239','C','长城','长城V80','6.98-11.48万','','MPV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3240','C','长城','嘉誉','7.98-14.18万','','MPV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('3241','C','长城','金迪尔','6.18-7.48万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3242','C','成功汽车','成功V1','3.68-4.00万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3243','C','成功汽车','成功V2','3.88-4.18万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3244','C','成功汽车','成功K1','3.67-4.38万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3245','C','成功汽车','成功K2','3.83-4.58万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3246','C','成功汽车','成功X1','6.80万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3247','D','DS','DS 4S','14.99-22.99万','','两厢','1.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('3248','D','DS','DS 5LS','14.98-24.68万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3249','D','DS','DS 5','21.99-34.59万','','两厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3250','D','DS','DS 6','19.39-30.19万','','SUV','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3251','D','DS','DS 3','19.98-27.98万','','两厢','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3252','D','DS','DS 4','24.28-27.28万','','两厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3253','D','DS','DS 5(进口)','29.88-34.88万','','两厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3254','D','大发','森雅','6.98-9.88万','','MPV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3255','D','大众','辉昂','35.90-67.00万','','三厢','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3256','D','大众','POLO','7.59-14.69万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3257','D','大众','桑塔纳','8.49-13.89万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3258','D','大众','朗行','11.29-16.29万','','两厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3259','D','大众','朗逸','10.99-15.99万','','三厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3260','D','大众','朗境','14.89-17.19万','','两厢','1.4T','手自一体');
INSERT INTO ask_chexingku VALUES ('3261','D','大众','凌渡','14.59-21.39万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3262','D','大众','帕萨特','18.39-33.29万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3263','D','大众','途观','19.98-31.58万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3264','D','大众','途安','15.58-23.08万','','MPV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3265','D','大众','高尔','6.88-7.99万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3266','D','大众','Passat领驭','16.43-30.38万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3267','D','大众','桑塔纳经典','6.70-10.25万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3268','D','大众','桑塔纳志俊','9.08-14.90万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3269','D','大众','捷达','7.99-12.08万','','三厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3270','D','大众','宝来','10.78-15.38万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3271','D','大众','高尔夫','12.19-23.99万','','两厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3272','D','大众','速腾','13.18-21.88万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3273','D','大众','高尔夫·嘉旅','13.19-19.79万','','两厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3274','D','大众','迈腾','18.99-31.69万','','三厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('3275','D','大众','一汽-大众CC','25.28-34.28万','','三厢','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3276','D','大众','宝来/宝来经典','11.25-22.19万','','两厢','1.6L','自动');
INSERT INTO ask_chexingku VALUES ('3277','D','大众','开迪','12.58-14.76万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3278','D','大众','大众up!','11.69-26.88万','','两厢','1.0L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3279','D','大众','甲壳虫','19.18-33.00万','','掀背','1.2T','双离合');
INSERT INTO ask_chexingku VALUES ('3280','D','大众','高尔夫(进口)','23.08-41.38万','','两厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('3281','D','大众','蔚揽','29.98-43.58万','','旅行版','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('3282','D','大众','辉腾','79.58-149.98万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3283','D','大众','Tiguan','32.88-39.98万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3284','D','大众','途锐','65.88-94.60万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3285','D','大众','夏朗','26.98-39.96万','','MPV','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('3286','D','大众','迈特威','41.88-81.80万','','MPV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3287','D','大众','凯路威','35.18-39.80万','','MPV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3288','D','大众','尚酷','22.28-39.08万','','硬顶跑车','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('3289','D','大众','Passat','34.00-53.00万','','三厢','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3290','D','大众','大众CC','39.39-53.68万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3291','D','大众','大众Eos','41.31-46.85万','','硬顶敞篷车','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3292','D','大众','迈腾(进口)','36.06-43.98万','','三厢','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3293','D','道奇','凯领','23.90-33.90万','','MPV','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('3294','D','道奇','酷威','27.49-37.29万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3295','D','道奇','道奇Ram','65.00-72.00万','','皮卡','5.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3296','D','道奇','锋哲','22.80-24.80万','','三厢','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3297','D','道奇','酷搏','19.99-21.99万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3298','D','东风','御风','12.38-22.27万','','客车','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('3299','D','东风','东风皮卡','6.65-10.48万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3300','D','东风','虎视','7.58-10.28万','','皮卡','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3301','D','东风','俊风CV03','4.28-5.33万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3302','D','东风','猛士','88.00万','','SUV','6.5T','自动');
INSERT INTO ask_chexingku VALUES ('3303','D','东风','帅客','6.88-9.18万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3304','D','东风','俊风','3.98-4.55万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3305','D','东风','锐骐多功能车','10.18-14.28万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3306','D','东风','锐骐皮卡','7.98-14.48万','','皮卡','2.2T','手动');
INSERT INTO ask_chexingku VALUES ('3307','D','东风','奥丁','12.18-15.98万','','SUV','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('3308','D','东风','御轩','12.98-19.98万','','MPV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('3309','D','东风风度','东风风度MX6','12.28-16.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3310','D','东风风光','东风风光580','7.29-10.00万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3311','D','东风风光','东风风光360','5.79-7.49万','','MPV','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3312','D','东风风光','东风风光370','5.59-6.99万','','MPV','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3313','D','东风风光','东风风光330','3.68-5.39万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3314','D','东风风光','东风风光','5.18-5.99万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3315','D','东风风光','东风风光350','6.29万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3316','D','东风风神','东风风神E30','15.98-19.98万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3317','D','东风风神','东风风神H30','6.88-9.18万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3318','D','东风风神','东风风神S30','5.98-8.18万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3319','D','东风风神','东风风神A60','6.97-8.37万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3320','D','东风风神','东风风神A30','5.97-8.57万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3321','D','东风风神','东风风神L60','8.97-12.97万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3322','D','东风风神','东风A9','17.97-21.97万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3323','D','东风风神','东风风神AX3','6.97-8.77万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3324','D','东风风神','东风风神AX7','9.97-14.17万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3325','D','东风风行','景逸','5.69-7.39万','','两厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3326','D','东风风行','景逸S50','6.99-10.29万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3327','D','东风风行','景逸X3','6.69-7.39万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3328','D','东风风行','景逸X5','7.99-9.99万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3329','D','东风风行','景逸XV','7.99-8.69万','','SUV','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3330','D','东风风行','风行SX6','6.99-10.29万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3331','D','东风风行','风行CM7','14.99-21.99万','','MPV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3332','D','东风风行','风行F600','9.99-12.29万','','MPV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3333','D','东风风行','风行S500','6.09-9.99万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3334','D','东风风行','菱智','4.99-9.99万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3335','D','东风风行','景逸SUV','8.09-9.89万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3336','D','东风小康','东风小康C35','4.98万','','客车','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3337','D','东风小康','东风小康C36','4.78万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3338','D','东风小康','东风小康C37','5.18-5.49万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3339','D','东风小康','东风小康K07','2.79-3.69万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3340','D','东风小康','东风小康K07II','2.79-4.28万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3341','D','东风小康','东风小康K07S','2.79-3.09万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3342','D','东风小康','东风小康K17','2.79-3.09万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3343','D','东风小康','东风小康V07S','2.88-3.18万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3344','D','东风小康','东风小康V29','4.59-5.48万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3345','D','东风小康','东风小康C31','3.49-3.89万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3346','D','东风小康','东风小康C32','3.79-4.19万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3347','D','东风小康','东风小康K01','2.59-3.09万','','货车','0.9L','手动');
INSERT INTO ask_chexingku VALUES ('3348','D','东风小康','东风小康K02','3.29-3.39万','','货车','1.1L','手动');
INSERT INTO ask_chexingku VALUES ('3349','D','东风小康','东风小康V21','3.38-4.08万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3350','D','东风小康','东风小康V22','3.78-4.48万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3351','D','东风小康','东风小康V27','3.78-5.88万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3352','D','东风小康','东风小康K06','3.75-4.35万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3353','D','东南','V3菱悦','5.69-6.79万','','三厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3354','D','东南','V5菱致','7.09-10.59万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3355','D','东南','V6菱仕','7.99-9.79万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3356','D','东南','东南DX7','9.69-13.99万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3357','D','东南','希旺','3.68-4.98万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3358','D','东南','得利卡','6.78-10.98万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3359','D','东南','菱帅','7.89-15.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3360','F','法拉利','California T','308.80万','','硬顶敞篷车','3.9T','双离合');
INSERT INTO ask_chexingku VALUES ('3361','F','法拉利','F12berlinetta','530.80万','','硬顶跑车','6.3L','双离合');
INSERT INTO ask_chexingku VALUES ('3362','F','法拉利','GTC4Lusso','538.80万','','硬顶跑车','6.3L','双离合');
INSERT INTO ask_chexingku VALUES ('3363','F','法拉利','LaFerrari','2250.00万','','硬顶跑车','6.3L','双离合');
INSERT INTO ask_chexingku VALUES ('3364','F','法拉利','法拉利488','338.80-388.80万','','硬顶敞篷车','3.9T','双离合');
INSERT INTO ask_chexingku VALUES ('3365','F','法拉利','法拉利458','388.00-558.80万','','硬顶敞篷车','4.5L','双离合');
INSERT INTO ask_chexingku VALUES ('3366','F','法拉利','法拉利599','492.80万','','硬顶跑车','6.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3367','F','法拉利','法拉利FF','530.80万','','硬顶跑车','6.3L','双离合');
INSERT INTO ask_chexingku VALUES ('3368','F','法拉利','法拉利360','280.00-300.00万','','软顶敞篷车','3.6L','AMT');
INSERT INTO ask_chexingku VALUES ('3369','F','法拉利','法拉利575M','320.00万','','硬顶跑车','5.7L','AMT');
INSERT INTO ask_chexingku VALUES ('3370','F','法拉利','法拉利612','569.80万','','硬顶跑车','5.7L','AMT');
INSERT INTO ask_chexingku VALUES ('3371','F','法拉利','法拉利F430','360.80-445.80万','','软顶敞篷车','4.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3372','F','菲亚特','菲翔','10.08-14.88万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3373','F','菲亚特','致悦','10.08-14.88万','','两厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3374','F','菲亚特','派朗','7.48-8.38万','','三厢','1.7L','手动');
INSERT INTO ask_chexingku VALUES ('3375','F','菲亚特','派力奥','5.58-9.58万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3376','F','菲亚特','西耶那','6.48-9.98万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3377','F','菲亚特','周末风','7.21-11.68万','','旅行版','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3378','F','菲亚特','菲亚特500','16.98-26.18万','','两厢','1.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3379','F','菲亚特','菲跃','24.98-37.58万','','SUV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3380','F','菲亚特','朋多','14.88-16.66万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3381','F','菲亚特','博悦','16.39-23.90万','','两厢','1.4T','AMT');
INSERT INTO ask_chexingku VALUES ('3382','F','菲亚特','领雅','17.10-18.60万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3383','F','丰田','YARiS L 致炫','6.98-10.88万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3384','F','丰田','雷凌','10.78-15.98万','','三厢','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3385','F','丰田','凯美瑞','18.48-32.98万','','三厢','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3386','F','丰田','汉兰达','23.98-42.28万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3387','F','丰田','逸致','14.98-18.98万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3388','F','丰田','雅力士','8.70-12.56万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3389','F','丰田','威驰','6.98-11.28万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3390','F','丰田','花冠','9.08-11.38万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3391','F','丰田','卡罗拉','10.78-17.58万','','三厢','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3392','F','丰田','普锐斯','22.98-26.98万','','两厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3393','F','丰田','锐志','20.98-31.48万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3394','F','丰田','皇冠','25.48-38.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3395','F','丰田','一汽丰田RAV4','17.98-27.28万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3396','F','丰田','兰德酷路泽','77.10-119.40万','','SUV','4.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3397','F','丰田','普拉多','36.98-62.53万','','SUV','2.7L','手动');
INSERT INTO ask_chexingku VALUES ('3398','F','丰田','柯斯达','37.25-55.68万','','客车','2.7L','手动');
INSERT INTO ask_chexingku VALUES ('3399','F','丰田','特锐','9.88-13.48万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3400','F','丰田','FJ 酷路泽','54.68万','','SUV','4.0L','自动');
INSERT INTO ask_chexingku VALUES ('3401','F','丰田','Fortuner','34.00万','','SUV','2.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3402','F','丰田','威飒','32.66-40.88万','','SUV','2.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3403','F','丰田','红杉','110.00万','','SUV','5.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3404','F','丰田','埃尔法','61.78-81.40万','','MPV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3405','F','丰田','普瑞维亚','46.98-61.00万','','MPV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3406','F','丰田','Sienna','45.00-52.00万','','MPV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3407','F','丰田','丰田86','26.96-27.96万','','硬顶跑车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3408','F','丰田','杰路驰','24.56万','','硬顶跑车','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3409','F','丰田','HIACE','39.40-53.70万','','客车','2.7L','手动');
INSERT INTO ask_chexingku VALUES ('3410','F','丰田','坦途','49.00-51.80万','','皮卡','5.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3411','F','丰田','凯美瑞(海外)','33.80-38.50万','','三厢','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('3412','F','丰田','丰田RAV4(进口)','31.88-38.00万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3413','F','丰田','汉兰达(进口)','40.00-53.10万','','SUV','3.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3414','F','丰田','兰德酷路泽(进口)','49.00-101.90万','','SUV','4.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3415','F','丰田','普拉多(进口)','40.00-54.00万','','SUV','2.7L','自动');
INSERT INTO ask_chexingku VALUES ('3416','F','福迪','揽福','8.98-14.88万','','SUV','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3417','F','福迪','探索者Ⅲ','8.18-8.48万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3418','F','福迪','探索者6','8.98-10.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3419','F','福迪','小超人','4.98-6.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3420','F','福迪','雄师F16','7.88-9.68万','','皮卡','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3421','F','福迪','雄师F22','8.98-13.38万','','皮卡','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3422','F','福迪','雄狮','7.38-9.38万','','皮卡','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3423','F','福迪','探索者Ⅱ','6.98万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3424','F','福汽启腾','启腾EX80','4.29-6.08万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3425','F','福汽启腾','启腾M70','3.59-4.59万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3426','F','福特','嘉年华','7.99-12.29万','','两厢','1.0T','手动');
INSERT INTO ask_chexingku VALUES ('3427','F','福特','福克斯','9.98-16.58万','','两厢','1.0T','手动');
INSERT INTO ask_chexingku VALUES ('3428','F','福特','福睿斯','9.68-11.98万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3429','F','福特','蒙迪欧','17.98-26.58万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3430','F','福特','致胜','17.98-19.48万','','三厢','2.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3431','F','福特','金牛座','23.38-34.88万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3432','F','福特','翼搏','9.48-12.78万','','SUV','1.0T','手动');
INSERT INTO ask_chexingku VALUES ('3433','F','福特','翼虎','19.38-27.58万','','SUV','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3434','F','福特','锐界','24.98-44.98万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3435','F','福特','麦柯斯','19.48-24.58万','','MPV','2.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3436','F','福特','蒙迪欧-致胜','16.98-25.68万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3437','F','福特','撼路者','26.58-36.08万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3438','F','福特','途睿欧','17.69-20.39万','','MPV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3439','F','福特','经典全顺','9.28-17.93万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3440','F','福特','新世代全顺','14.56-24.10万','','客车','2.2T','手动');
INSERT INTO ask_chexingku VALUES ('3441','F','福特','福特GT','550.00万','','','','');
INSERT INTO ask_chexingku VALUES ('3442','F','福特','嘉年华(进口)','18.59万','','两厢','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('3443','F','福特','福克斯(进口)','25.98-39.90万','','两厢','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3444','F','福特','探险者','44.98-63.98万','','SUV','2.3T','手自一体');
INSERT INTO ask_chexingku VALUES ('3445','F','福特','福特E350','141.00-218.00万','','MPV','5.4L','自动');
INSERT INTO ask_chexingku VALUES ('3446','F','福特','Mustang','39.98-76.40万','','硬顶跑车','2.3T','手自一体');
INSERT INTO ask_chexingku VALUES ('3447','F','福特','福特F-150','50.00-57.00万','','皮卡','6.2L','自动');
INSERT INTO ask_chexingku VALUES ('3448','F','福特','Kuga','27.80-39.50万','','SUV','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('3449','F','福特','锐界(进口)','29.28-53.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3450','F','福特','征服者','82.00万','','SUV','5.4L','自动');
INSERT INTO ask_chexingku VALUES ('3451','F','福田','萨瓦纳','12.78-16.78万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3452','F','福田','伽途ix5','4.89-5.89万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3453','F','福田','伽途ix7','5.99-6.79万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3454','F','福田','伽途V3','3.29-3.79万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3455','F','福田','伽途V5','3.69-4.29万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3456','F','福田','风景G7','6.78-11.28万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3457','F','福田','风景G9','9.26-16.85万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3458','F','福田','福田风景','5.63-9.93万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3459','F','福田','蒙派克E','7.80-18.80万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3460','F','福田','蒙派克S','13.90-17.25万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3461','F','福田','图雅诺','10.98-18.98万','','客车','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3462','F','福田','萨普','5.88-9.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3463','F','福田','拓陆者','8.18-20.31万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3464','F','福田','迷迪','5.93-8.68万','','MPV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3465','G','GMC','YUKON','118.80-168.00万','','SUV','5.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3466','G','GMC','SAVANA','88.00-168.00万','','MPV','5.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3467','G','GMC','SIERRA','59.80-72.80万','','皮卡','5.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('3468','G','GMC','TERRAIN','59.00万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3469','G','观致','观致3','10.09-16.99万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3470','G','观致','观致5','13.99-19.49万','','SUV','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('3471','G','光冈','大蛇','218.00万','','硬顶跑车','3.3L','自动');
INSERT INTO ask_chexingku VALUES ('3472','G','光冈','嘉路','115.00万','','软顶敞篷车','3.6L','自动');
INSERT INTO ask_chexingku VALUES ('3473','G','光冈','女王','85.00万','','硬顶敞篷车','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3474','G','广汽传祺','传祺GA3','7.58-11.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3475','G','广汽传祺','传祺GA3S视界','6.98-11.98万','','三厢','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3476','G','广汽传祺','传祺GA5','10.58-21.93万','','三厢','1.0L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3477','G','广汽传祺','传祺GA6','10.28-19.68万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3478','G','广汽传祺','传祺GA8','16.98-29.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3479','G','广汽传祺','传祺GS4','9.98-15.38万','','SUV','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3480','G','广汽传祺','传祺GS5','12.38-22.98万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3481','G','广汽传祺','传祺GS5 Super','11.68-21.88万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3482','G','广汽吉奥','E美','6.98-9.68万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3483','G','广汽吉奥','奥轩GX5','10.98-15.18万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3484','G','广汽吉奥','广汽吉奥GX6','10.98-14.68万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3485','G','广汽吉奥','星朗','4.58-7.43万','','MPV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3486','G','广汽吉奥','星旺','2.59-2.98万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3487','G','广汽吉奥','星旺CL','3.68-4.58万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3488','G','广汽吉奥','星旺L','3.29-3.48万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3489','G','广汽吉奥','星旺M1','2.99-3.18万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3490','G','广汽吉奥','星旺M2','3.09-3.28万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3491','G','广汽吉奥','财运100','5.29-5.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3492','G','广汽吉奥','财运300','5.79-6.18万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3493','G','广汽吉奥','财运500','6.29-8.88万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3494','G','广汽吉奥','广汽吉奥GP150','8.88-11.28万','','皮卡','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('3495','G','广汽吉奥','奥轩G3','8.98-9.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3496','G','广汽吉奥','吉奥凯旋','7.80万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3497','G','广汽吉奥','凯睿','8.58-10.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3498','G','广汽吉奥','帅豹','11.98-14.38万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3499','G','广汽吉奥','帅威','6.98-7.68万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3500','G','广汽吉奥','奥轩G5','8.68-14.88万','','SUV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('3501','G','广汽吉奥','帅驰','5.93-6.28万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3502','G','广汽吉奥','帅舰','7.08-8.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3503','H','哈飞','哈飞小霸王','3.28-3.78万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3504','H','哈飞','骏意','4.14-4.44万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3505','H','哈飞','民意','2.89万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3506','H','哈飞','中意V5','3.87-4.37万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3507','H','哈飞','民意微卡','3.19-3.59万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3508','H','哈飞','赛豹III','6.38-10.48万','','三厢','1.6L','自动');
INSERT INTO ask_chexingku VALUES ('3509','H','哈飞','路宝','3.34-5.28万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3510','H','哈飞','赛马','5.48-8.47万','','两厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3511','H','哈飞','赛豹V','8.38-9.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3512','H','哈飞','路尊大霸王','5.09-6.08万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3513','H','哈弗','哈弗H1','5.49-8.29万','','SUV','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3514','H','哈弗','哈弗H2','8.88-12.88万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3515','H','哈弗','哈弗H5','9.48-16.38万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3516','H','哈弗','哈弗H6','8.88-16.28万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3517','H','哈弗','哈弗H6 Coupe','12.28-17.18万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3518','H','哈弗','哈弗H7','14.98-16.98万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3519','H','哈弗','哈弗H8','18.88-25.68万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3520','H','哈弗','哈弗H9','20.98-27.28万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3521','H','哈弗','哈弗H3','8.98-15.88万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3522','H','海格','海格H4E','22.30-25.80万','','客车','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3523','H','海格','海格H5C','16.53-24.68万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3524','H','海格','海格H5V','21.08-29.28万','','客车','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3525','H','海格','海格H6C','18.98-25.08万','','客车','2.7L','手动');
INSERT INTO ask_chexingku VALUES ('3526','H','海格','海格H6V','70.80-80.80万','','客车','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3527','H','海格','海格H7V','20.88万','','客车','3.0T','手动');
INSERT INTO ask_chexingku VALUES ('3528','H','海格','龙威','7.28-16.58万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3529','H','海格','御骏','7.18-9.28万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3530','H','海马','丘比特','4.99-6.39万','','两厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3531','H','海马','福美来','6.18-11.89万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3532','H','海马','海马M8','10.68-16.68万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3533','H','海马','海马S7','8.98-14.48万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3534','H','海马','海马骑士','10.58-15.28万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3535','H','海马','海马V70','7.89-12.89万','','MPV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3536','H','海马','普力马','8.38-21.68万','','MPV','1.6L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3537','H','海马','海福星','5.98-17.36万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3538','H','海马','海马3','10.38-11.68万','','三厢','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3539','H','海马','欢动','7.96-10.66万','','两厢','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3540','H','海马','海马M3','5.58-8.18万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3541','H','海马','海马M6','6.98-10.28万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3542','H','海马','海马S5','7.98-11.68万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3543','H','海马','福仕达腾达','3.88万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3544','H','海马','福仕达福卡','3.48-4.08万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3545','H','海马','海马王子','2.98-4.38万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3546','H','海马','海马爱尚','3.58-4.58万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3547','H','海马','福仕达鸿达','2.98-4.38万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3548','H','海马','福仕达荣达','3.28-5.08万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3549','H','汉腾汽车','汉腾X7','7.98-14.98万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3550','H','悍马','悍马H3','75.80-85.00万','','SUV','3.5L','自动');
INSERT INTO ask_chexingku VALUES ('3551','H','悍马','悍马H2','118.00-128.00万','','SUV','6.0L','自动');
INSERT INTO ask_chexingku VALUES ('3552','H','恒天','途腾T1','5.98-6.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3553','H','恒天','途腾T2','6.38-8.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3554','H','恒天','途腾T3','6.98-8.38万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3555','H','红旗','红旗H7','24.98-47.98万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3556','H','红旗','红旗L5','500.00万','','三厢','6.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3557','H','红旗','新明仕','11.88万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3558','H','红旗','红旗盛世','34.98-68.88万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3559','H','华凯','华凯皮卡','6.54-7.78万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3560','H','华利','天津大发TJ110','暂无报价','','','','');
INSERT INTO ask_chexingku VALUES ('3561','H','华普','海锋','5.89-6.19万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3562','H','华普','海尚','5.29-7.19万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3563','H','华普','海炫','6.39万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3564','H','华普','海迅','5.00-6.99万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3565','H','华普','海域','3.99-7.68万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3566','H','华普','海悦','5.39万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3567','H','华普','华普海景','6.39-10.19万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3568','H','华颂','华颂7','23.77-28.77万','','MPV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3569','H','华泰','路盛E70','6.97-8.97万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3570','H','华泰','路盛E80','6.18-7.18万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3571','H','华泰','宝利格','7.37-9.37万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3572','H','华泰','圣达菲','7.75-9.05万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3573','H','华泰','圣达菲经典','6.08-6.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3574','H','华泰','特拉卡','10.57-26.98万','','SUV','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('3575','H','华泰','华泰B11','11.97-17.67万','','三厢','1.8T','自动');
INSERT INTO ask_chexingku VALUES ('3576','H','华泰新能源','华泰iEV230','21.35-22.55万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3577','H','华泰新能源','华泰XEV260','24.98-27.28万','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3578','H','黄海','旗胜V3','10.18-11.38万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3579','H','黄海','挑战者SUV','6.98-8.18万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3580','H','黄海','瑞途','16.88-29.88万','','客车','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3581','H','黄海','傲骏','5.48-6.28万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3582','H','黄海','大柴神','6.28-12.98万','','皮卡','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3583','H','黄海','黄海N1','6.78-11.88万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3584','H','黄海','黄海N2','9.28-17.58万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3585','H','黄海','小柴神','5.48-6.28万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3586','H','黄海','翱龙CUV','7.98-10.68万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3587','H','黄海','旗胜F1','8.28-12.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3588','J','Jeep','北京JEEP','11.50-13.86万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3589','J','Jeep','大切诺基','35.80-49.60万','','SUV','4.0L','自动');
INSERT INTO ask_chexingku VALUES ('3590','J','Jeep','自由侠','14.18-20.28万','','SUV','1.4T','手自一体');
INSERT INTO ask_chexingku VALUES ('3591','J','Jeep','自由光','20.98-31.58万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3592','J','Jeep','指南者','22.19-28.09万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3593','J','Jeep','牧马人','42.95-53.95万','','SUV','2.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3594','J','Jeep','自由光(进口)','52.99万','','SUV','3.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3595','J','Jeep','大切诺基(进口)','55.99-85.49万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3596','J','Jeep','自由客','22.19-27.69万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3597','J','Jeep','自由人','49.80万','','SUV','3.7L','自动');
INSERT INTO ask_chexingku VALUES ('3598','J','Jeep','指挥官','54.00-64.99万','','SUV','4.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3599','J','Jeep','大切诺基 SRT','120.49万','','SUV','6.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3600','J','吉利汽车','远景SUV','8.09-10.39万','','SUV','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3601','J','吉利汽车','熊猫','3.69-4.99万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3602','J','吉利汽车','金刚','4.59-6.59万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3603','J','吉利汽车','英伦C5','4.99-6.39万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3604','J','吉利汽车','自由舰','3.89-4.19万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3605','J','吉利汽车','帝豪','6.98-24.98万','','两厢','1.3T','固定齿比');
INSERT INTO ask_chexingku VALUES ('3606','J','吉利汽车','海景','5.19-5.69万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3607','J','吉利汽车','英伦TX4','22.80万','','两厢','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('3608','J','吉利汽车','远景','5.39-6.79万','','三厢','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3609','J','吉利汽车','博瑞','11.98-22.98万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3610','J','吉利汽车','吉利EC8','8.89-11.89万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3611','J','吉利汽车','博越','9.88-15.78万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3612','J','吉利汽车','帝豪GS','7.78-10.88万','','SUV','1.3T','手动');
INSERT INTO ask_chexingku VALUES ('3613','J','吉利汽车','吉利GX7','6.99-11.99万','','SUV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3614','J','吉利汽车','豪情SUV','12.99-15.29万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3615','J','吉利汽车','吉利GC7','6.29-7.99万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3616','J','吉利汽车','吉利GX2','5.09-6.58万','','两厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3617','J','吉利汽车','豪情','2.99-4.80万','','两厢','1.0L','自动');
INSERT INTO ask_chexingku VALUES ('3618','J','吉利汽车','吉利SC3','4.08-4.78万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3619','J','吉利汽车','吉利SC5-RV','5.23-5.63万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3620','J','吉利汽车','金刚财富','4.19-6.08万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3621','J','吉利汽车','金鹰','4.58-6.58万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3622','J','吉利汽车','优利欧','3.53-5.50万','','三厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3623','J','吉利汽车','经典帝豪','6.68-11.38万','','两厢','1.5L','无级');
INSERT INTO ask_chexingku VALUES ('3624','J','吉利汽车','吉利SX7','9.28-12.99万','','SUV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3625','J','吉利汽车','美人豹','6.98-12.99万','','硬顶跑车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3626','J','吉利汽车','中国龙','8.68-8.88万','','硬顶跑车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3627','J','江淮','悦悦','3.88-4.18万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3628','J','江淮','和悦A30','4.99-7.69万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3629','J','江淮','江淮iEV','15.28-17.98万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3630','J','江淮','和悦','5.98-8.58万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3631','J','江淮','江淮iEV6S','21.98万','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3632','J','江淮','瑞风S2','5.88-7.68万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3633','J','江淮','瑞风S3','6.58-8.88万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3634','J','江淮','瑞风S5','8.95-13.95万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3635','J','江淮','瑞风M2','5.98-8.78万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3636','J','江淮','瑞风M3','6.98-8.88万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3637','J','江淮','瑞风M5','13.95-16.25万','','MPV','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3638','J','江淮','凌铃','3.24-3.65万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3639','J','江淮','瑞风','8.50-16.38万','','客车','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3640','J','江淮','星锐','13.78-19.80万','','客车','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3641','J','江淮','江淮K3','5.52-7.43万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3642','J','江淮','江淮K5','5.30-7.45万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3643','J','江淮','瑞铃','5.78-9.38万','','皮卡','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3644','J','江淮','帅铃T6','8.58-10.38万','','皮卡','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3645','J','江淮','征途','8.40-11.28万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3646','J','江淮','和悦A13','5.28-5.88万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3647','J','江淮','和悦A13RS','5.28-6.08万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3648','J','江淮','同悦','4.88-6.38万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3649','J','江淮','同悦RS','4.88-6.38万','','两厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3650','J','江淮','宾悦','8.88-14.98万','','三厢','1.8L','自动');
INSERT INTO ask_chexingku VALUES ('3651','J','江淮','瑞鹰','7.98-15.18万','','SUV','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('3652','J','江铃','宝典','6.98-10.86万','','皮卡','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3653','J','江铃','域虎','9.68-13.68万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3654','J','江铃','宝威','9.48-10.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3655','J','江铃集团轻汽','骐铃T3','6.28-6.68万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3656','J','江铃集团轻汽','骐铃T5','6.38-9.88万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3657','J','江铃集团轻汽','骐铃T7','7.18-10.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3658','J','江铃集团新能源','江铃E200','10.58-10.88万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3659','J','捷豹','捷豹XFL','暂无报价','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3660','J','捷豹','捷豹XE','39.80-57.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3661','J','捷豹','捷豹XF','51.80-80.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3662','J','捷豹','捷豹XJ','79.80-127.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3663','J','捷豹','捷豹F-PACE','54.80-89.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3664','J','捷豹','捷豹F-TYPE','79.80-198.80万','','软顶敞篷车','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3665','J','捷豹','捷豹XK','142.00-261.80万','','软顶敞篷车','4.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3666','J','捷豹','捷豹X-Type','53.00万','','三厢','2.5L','自动');
INSERT INTO ask_chexingku VALUES ('3667','J','捷豹','捷豹S-Type','63.30-103.00万','','三厢','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('3668','J','金杯','阁瑞斯','7.98-27.18万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3669','J','金杯','金杯大海狮','10.58-24.98万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3670','J','金杯','金杯海狮','5.68-12.48万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3671','J','金杯','金杯S50','8.83-13.28万','','SUV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('3672','J','金杯','华晨金杯750','5.38-7.33万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3673','J','金杯','海狮X30L','4.68-5.18万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3674','J','金杯','海星A7','2.59万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3675','J','金杯','海星A9','2.89-3.69万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3676','J','金杯','小海狮X30','3.50-4.68万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3677','J','金杯','海星T20','2.79-3.19万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3678','J','金杯','海星T22','3.39-3.69万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3679','J','金杯','金杯T30','3.59-4.39万','','货车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3680','J','金杯','金杯T32','3.89-4.09万','','货车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3681','J','金杯','智尚S30','4.98-7.28万','','SUV','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3682','J','金杯','智尚S35','5.98-7.38万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3683','J','金杯','西部牛仔','3.73-5.11万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3684','J','金杯','小金牛','3.28-3.58万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3685','J','金杯','大力神','6.68-9.48万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3686','J','金杯','大力神K5','6.78-10.48万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3687','J','金杯','金典','5.38-7.08万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3688','J','金杯','雷龙','5.28-8.08万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3689','J','金龙','金威','6.35-9.18万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3690','J','金龙','凯歌','15.98-75.00万','','客车','2.4L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3691','J','金龙','凯特','22.60-23.60万','','客车','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('3692','J','金旅','大海师G6','75.00万','','客车','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3693','J','金旅','大海师X5','16.80-18.80万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3694','J','金旅','金旅海狮','5.98-8.98万','','客车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3695','J','九龙','艾菲','22.98万','','MPV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3696','J','九龙','九龙A4','9.98-14.98万','','客车','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3697','J','九龙','九龙A5','16.88-25.88万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3698','J','九龙','九龙A6','9.98-25.98万','','客车','2.7L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3699','J','九龙','考斯特','23.98-32.98万','','客车','2.7L','手动');
INSERT INTO ask_chexingku VALUES ('3700','J','九龙','大MPV','12.98-16.88万','','客车','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3701','K','KTM','X-BOW','139.00万','','软顶敞篷车','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3702','K','卡尔森','卡尔森 S级','288.00-358.80万','','三厢','5.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3703','K','卡尔森','卡尔森 GL级','188.00-248.80万','','SUV','4.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3704','K','卡升','卡升C10','128.00-148.00万','','MPV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3705','K','卡升','卡升C7','80.80-97.80万','','MPV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3706','K','卡威','卡威W1','9.48-10.33万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3707','K','卡威','卡威K1','9.98-12.78万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3708','K','卡威','卡威K150','10.08-13.48万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3709','K','开瑞','开瑞K50','4.68-7.38万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3710','K','开瑞','优胜2代','3.09-4.43万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3711','K','开瑞','优雅2代','4.29-5.99万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3712','K','开瑞','优优','4.45-5.59万','','客车','1.0T','手动');
INSERT INTO ask_chexingku VALUES ('3713','K','开瑞','优优2代','3.40-4.40万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3714','K','开瑞','优劲','3.20-4.35万','','货车','1.1L','手动');
INSERT INTO ask_chexingku VALUES ('3715','K','开瑞','杰虎','6.48-8.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3716','K','开瑞','优雅','4.18-5.78万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3717','K','开瑞','优翼','5.78-6.28万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3718','K','开瑞','优派','3.48-4.28万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3719','K','开瑞','优胜','3.28万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3720','K','凯迪拉克','凯迪拉克ATS-L','29.88-42.88万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3721','K','凯迪拉克','凯迪拉克CT6','43.99-81.88万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3722','K','凯迪拉克','凯迪拉克XTS','34.99-47.99万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3723','K','凯迪拉克','凯迪拉克XT5','35.99-53.99万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3724','K','凯迪拉克','SLS赛威','38.88-82.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3725','K','凯迪拉克','凯迪拉克CTS','35.80-51.80万','','三厢','2.8L','自动');
INSERT INTO ask_chexingku VALUES ('3726','K','凯迪拉克','凯迪拉克CTS(进口)','42.80-51.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3727','K','凯迪拉克','凯雷德ESCALADE','158.80万','','SUV','6.0L','无级');
INSERT INTO ask_chexingku VALUES ('3728','K','凯迪拉克','凯迪拉克SRX','39.98-59.80万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3729','K','凯迪拉克','凯迪拉克ATS(进口)','30.80-43.80万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3730','K','凯迪拉克','帝威','84.00万','','三厢','4.6L','自动');
INSERT INTO ask_chexingku VALUES ('3731','K','凯迪拉克','凯迪拉克XLR','152.00万','','硬顶敞篷车','4.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3732','K','凯翼','凯翼V3','6.78-7.88万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3733','K','凯翼','凯翼C3','4.58-6.08万','','三厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3734','K','凯翼','凯翼C3R','4.58-6.08万','','两厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3735','K','凯翼','凯翼X3','6.66-9.69万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3736','K','康迪','全球鹰K10','15.08万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3737','K','康迪','全球鹰K11','18.18万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3738','K','康迪','全球鹰K12','15.88万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3739','K','康迪','全球鹰K17','16.48万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3740','K','科尼赛克','Agera','2650.00万','','硬顶敞篷车','5.0T','双离合');
INSERT INTO ask_chexingku VALUES ('3741','K','科尼赛克','科尼赛克CCX','2300.00万','','硬顶跑车','4.7L','手动');
INSERT INTO ask_chexingku VALUES ('3742','K','科尼赛克','科尼赛克CCXR','2600-4700万','','硬顶跑车','4.7T','手动');
INSERT INTO ask_chexingku VALUES ('3743','K','克莱斯勒','铂锐','18.20-22.70万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3744','K','克莱斯勒','克莱斯勒300C','30.00-50.90万','','三厢','2.7L','自动');
INSERT INTO ask_chexingku VALUES ('3745','K','克莱斯勒','大捷龙','24.90-35.90万','','MPV','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('3746','K','克莱斯勒','克莱斯勒300C(进口)','39.99-49.19万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3747','K','克莱斯勒','大捷龙(进口)','44.68-49.68万','','MPV','3.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3748','K','克莱斯勒','PT 漫步者','23.99-39.50万','','两厢','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3749','K','克莱斯勒','交叉火力','61.00万','','硬顶跑车','3.2L','自动');
INSERT INTO ask_chexingku VALUES ('3750','K','LOCAL MOTORS','RALLY FIGHTER','158.00万','','SUV','6.2L','自动');
INSERT INTO ask_chexingku VALUES ('3751','K','兰博基尼','Huracan','299.00-429.09万','','硬顶跑车','5.2L','双离合');
INSERT INTO ask_chexingku VALUES ('3752','K','兰博基尼','Aventador','648.80-801.15万','','硬顶敞篷车','6.5L','ISR');
INSERT INTO ask_chexingku VALUES ('3753','K','兰博基尼','Gallardo','298.00-490.00万','','软顶敞篷车','5.0L','手动');
INSERT INTO ask_chexingku VALUES ('3754','K','兰博基尼','Murcielago','428.00-438.00万','','硬顶跑车','6.2L','AMT');
INSERT INTO ask_chexingku VALUES ('3755','K','兰博基尼','Reventon','1500.00万','','硬顶跑车','6.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3756','K','劳伦士','劳伦士S级','130.80-295.00万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3757','K','劳伦士','劳伦士M级','122.80-174.80万','','SUV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3758','K','劳斯莱斯','幻影','688.00-1488万','','三厢','6.7L','自动');
INSERT INTO ask_chexingku VALUES ('3759','K','劳斯莱斯','古思特','419.00-666.00万','','三厢','6.6T','自动');
INSERT INTO ask_chexingku VALUES ('3760','K','劳斯莱斯','魅影','473.00万','','硬顶跑车','6.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3761','K','劳斯莱斯','曜影','477.80万','','','6.6T','');
INSERT INTO ask_chexingku VALUES ('3762','K','雷丁','雷丁D50','3.38-5.19万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3763','K','雷克萨斯','雷克萨斯CT','26.90-34.80万','','两厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3764','K','雷克萨斯','雷克萨斯IS','36.90-48.00万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3765','K','雷克萨斯','雷克萨斯ES','29.80-49.80万','','三厢','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3766','K','雷克萨斯','雷克萨斯GS','45.90-79.90万','','三厢','2.0T','无级');
INSERT INTO ask_chexingku VALUES ('3767','K','雷克萨斯','雷克萨斯LS','149.00-238.80万','','三厢','4.6L','无级');
INSERT INTO ask_chexingku VALUES ('3768','K','雷克萨斯','雷克萨斯NX','31.80-59.90万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3769','K','雷克萨斯','雷克萨斯GX','84.80-94.68万','','SUV','4.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3770','K','雷克萨斯','雷克萨斯RX','41.80-86.90万','','SUV','2.0T','无级');
INSERT INTO ask_chexingku VALUES ('3771','K','雷克萨斯','雷克萨斯LX','138.60-143.80万','','SUV','5.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3772','K','雷克萨斯','雷克萨斯RC','48.80-58.60万','','硬顶跑车','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3773','K','雷克萨斯','雷克萨斯RX经典','46.90-96.88万','','SUV','2.7L','无级');
INSERT INTO ask_chexingku VALUES ('3774','K','雷克萨斯','雷克萨斯SC','92.00-132.10万','','硬顶敞篷车','4.3L','自动');
INSERT INTO ask_chexingku VALUES ('3775','K','雷克萨斯','雷克萨斯RC F','109.80-126.80万','','硬顶跑车','5.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3776','K','雷克萨斯','雷克萨斯LFA','598.80万','','硬顶跑车','4.8L','序列');
INSERT INTO ask_chexingku VALUES ('3777','L','雷诺','科雷嘉','16.38-21.98万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3778','L','雷诺','风朗','16.58-18.98万','','三厢','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3779','L','雷诺','梅甘娜','33.99-35.99万','','硬顶跑车','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3780','L','雷诺','纬度','17.68-28.48万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3781','L','雷诺','塔利斯曼','32.28-48.88万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3782','L','雷诺','卡缤','13.98-18.88万','','SUV','1.2T','双离合');
INSERT INTO ask_chexingku VALUES ('3783','L','雷诺','科雷傲(进口)','20.48-27.88万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('3784','L','雷诺','风景','18.50-26.50万','','MPV','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('3785','L','雷诺','拉古那','25.18-37.18万','','掀背','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3786','L','雷诺','威赛帝','53.80万','','两厢','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3787','L','理念','理念S1','6.78-9.98万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3788','L','力帆汽车','力帆330','14.38-14.68万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3789','L','力帆汽车','力帆620','4.59-21.98万','','三厢','1.5L','固定齿比');
INSERT INTO ask_chexingku VALUES ('3790','L','力帆汽车','力帆820','7.68-11.98万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3791','L','力帆汽车','力帆X50','5.98-8.28万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3792','L','力帆汽车','力帆X60','7.45-9.09万','','SUV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3793','L','力帆汽车','迈威','5.78-7.68万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3794','L','力帆汽车','丰顺','3.28-4.94万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3795','L','力帆汽车','福顺','2.78-3.18万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3796','L','力帆汽车','乐途','3.58-5.98万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3797','L','力帆汽车','兴顺','3.78-4.58万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3798','L','力帆汽车','力帆T11','2.78-3.18万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3799','L','力帆汽车','力帆T21','3.48-3.63万','','货车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3800','L','力帆汽车','力帆320','3.48-5.49万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3801','L','力帆汽车','力帆530','5.18-6.98万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3802','L','力帆汽车','力帆520','3.99-7.88万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3803','L','力帆汽车','力帆630','5.49-7.29万','','三厢','1.5L','无级');
INSERT INTO ask_chexingku VALUES ('3804','L','力帆汽车','力帆720','5.98-8.04万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3805','L','莲花汽车','莲花L3','6.38-8.68万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3806','L','莲花汽车','莲花L5','8.58-11.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3807','L','莲花汽车','竞速','11.98-13.98万','','掀背','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3808','L','莲花汽车','竞悦','11.98-12.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3809','L','猎豹汽车','飞腾','8.98-10.68万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3810','L','猎豹汽车','飞腾C5','7.98-8.89万','','SUV','1.5T','AMT');
INSERT INTO ask_chexingku VALUES ('3811','L','猎豹汽车','猎豹CS10','9.68-14.68万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3812','L','猎豹汽车','黑金刚','10.98-17.98万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3813','L','猎豹汽车','猎豹CS6','14.68-19.78万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3814','L','猎豹汽车','猎豹Q6','11.99-17.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3815','L','猎豹汽车','飞扬','6.33-9.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3816','L','猎豹汽车','猎豹CT5','11.98-16.48万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3817','L','猎豹汽车','猎豹CS7','9.98-12.38万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3818','L','猎豹汽车','猎豹6481','9.98-12.48万','','SUV','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3819','L','猎豹汽车','骐菱','6.98-8.68万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3820','L','猎豹汽车','飞铃','5.98-6.90万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3821','L','林肯','林肯MKZ','28.48-44.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3822','L','林肯','林肯MKC','33.98-48.58万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3823','L','林肯','林肯MKX','44.98-65.98万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3824','L','林肯','领航员','98.88万','','SUV','3.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3825','L','林肯','林肯MKS','109.80万','','三厢','3.5T','自动');
INSERT INTO ask_chexingku VALUES ('3826','L','林肯','林肯MKT','119.80万','','SUV','3.5T','自动');
INSERT INTO ask_chexingku VALUES ('3827','L','林肯','城市','75.00-138.00万','','三厢','4.1L','自动');
INSERT INTO ask_chexingku VALUES ('3828','L','铃木','北斗星','3.29-4.69万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3829','L','铃木','北斗星X5','4.19-5.19万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3830','L','铃木','派喜','5.00万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3831','L','铃木','利亚纳A6','5.29-8.29万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3832','L','铃木','浪迪','4.98-5.35万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3833','L','铃木','利亚纳','5.68-10.66万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3834','L','铃木','奥拓','4.18-6.19万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('3835','L','铃木','雨燕','5.98-8.28万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3836','L','铃木','启悦','8.79-12.19万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3837','L','铃木','天语 SX4','7.98-9.98万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3838','L','铃木','天语 尚悦','7.58-8.58万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3839','L','铃木','锋驭','10.98-16.48万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3840','L','铃木','维特拉','9.98-15.98万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3841','L','铃木','羚羊','4.18-7.78万','','三厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3842','L','铃木','速翼特','17.88-18.88万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3843','L','铃木','凯泽西','18.88-27.48万','','三厢','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3844','L','铃木','吉姆尼(进口)','14.18-16.08万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3845','L','铃木','超级维特拉','26.48-27.48万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('3846','L','陆地方舟','艾威','5.38-5.68万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3847','L','陆地方舟','陆地方舟风尚','29.80万','','MPV','','手动');
INSERT INTO ask_chexingku VALUES ('3848','L','陆地方舟','陆地方舟V5','6.98-7.28万','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3849','L','陆风','陆风X5','8.98-12.68万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3850','L','陆风','陆风X7','12.98-14.78万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3851','L','陆风','陆风X8','11.38-15.19万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3852','L','陆风','风华','5.58-6.23万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3853','L','陆风','陆风X6','7.98-15.16万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3854','L','陆风','陆风X9','10.85-16.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3855','L','陆风','风尚','6.98-10.93万','','MPV','1.5L','自动');
INSERT INTO ask_chexingku VALUES ('3856','L','路虎','发现神行','36.80-51.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3857','L','路虎','揽胜极光','39.80-57.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3858','L','路虎','揽胜极光(进口)','69.80万','','','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3859','L','路虎','第四代发现','82.80-104.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3860','L','路虎','揽胜运动版','92.80-229.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3861','L','路虎','揽胜','149.80-329.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3862','L','路虎','发现神行(进口)','55.80-61.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3863','L','路虎','卫士','74.80万','','SUV','2.4T','手动');
INSERT INTO ask_chexingku VALUES ('3864','L','路虎','神行者2','39.80-68.80万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('3865','L','路虎','神行者','45.80-48.80万','','SUV','2.5L','自动');
INSERT INTO ask_chexingku VALUES ('3866','L','路虎','第三代发现','69.00-109.80万','','SUV','2.7T','手自一体');
INSERT INTO ask_chexingku VALUES ('3867','L','路特斯','Elise','59.80万','','硬顶敞篷车','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3868','L','路特斯','Evora','128.00万','','硬顶跑车','3.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3869','L','路特斯','Exige','108.00万','','硬顶跑车','3.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3870','M','MG','MG 3SW','8.77万','','两厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('3871','M','MG','MG3','6.37-8.37万','','两厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3872','M','MG','MG5','8.97-14.07万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3873','M','MG','MG6','11.68-18.28万','','掀背','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3874','M','MG','锐行','7.79-14.99万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3875','M','MG','锐腾','10.97-17.97万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3876','M','MG','MG7','15.68-30.28万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3877','M','MG','MGTF','24.96-26.58万','','软顶敞篷车','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3878','M','MINI','MINI','18.50-38.50万','','两厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('3879','M','MINI','MINI CLUBMAN','24.90-38.10万','','两厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('3880','M','MINI','MINI COUNTRYMAN','25.90-37.90万','','SUV','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3881','M','MINI','MINI ROADSTER','37.60-43.30万','','软顶敞篷车','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3882','M','MINI','MINI PACEMAN','33.10-38.90万','','SUV','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3883','M','MINI','MINI COUPE','31.80-38.50万','','硬顶跑车','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3884','M','MINI','MINI JCW','35.50-39.10万','','两厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3885','M','MINI','MINI JCW CLUBMAN','41.90万','','两厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3886','M','MINI','MINI JCW COUNTRYMAN','42.90万','','SUV','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3887','M','MINI','MINI JCW PACEMAN','43.90万','','SUV','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3888','M','MINI','MINI JCW COUPE','42.50万','','硬顶跑车','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('3889','M','马自达','马自达3 Axela昂克赛拉','11.49-15.99万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3890','M','马自达','马自达3星骋','9.48-12.58万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3891','M','马自达','马自达CX-5','16.98-24.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3892','M','马自达','马自达2','7.58-11.08万','','两厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('3893','M','马自达','马自达2劲翔','8.18-11.58万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3894','M','马自达','马自达3','9.68-16.48万','','三厢','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3895','M','马自达','阿特兹','17.98-23.98万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3896','M','马自达','马自达6','12.98-15.98万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3897','M','马自达','睿翼','16.48-18.48万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3898','M','马自达','马自达CX-4','14.08-21.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3899','M','马自达','马自达CX-7','19.98-27.38万','','SUV','2.3T','手自一体');
INSERT INTO ask_chexingku VALUES ('3900','M','马自达','马自达8','21.98-25.98万','','MPV','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3901','M','马自达','马自达5','16.58-19.38万','','MPV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3902','M','马自达','马自达MX-5','29.98万','','硬顶敞篷车','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3903','M','马自达','马自达CX-9','43.90万','','SUV','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3904','M','马自达','马自达3(进口)','13.98-18.88万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3905','M','马自达','ATENZA','23.88万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3906','M','马自达','马自达CX-5(进口)','23.38-28.18万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3907','M','马自达','马自达CX-7(进口)','28.80-29.08万','','SUV','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3908','M','马自达','马自达8(进口)','33.90万','','MPV','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('3909','M','马自达','马自达RX-8','38.00-39.00万','','硬顶跑车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('3910','M','玛莎拉蒂','Ghibli','89.80-139.80万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3911','M','玛莎拉蒂','总裁','142.15-298.80万','','三厢','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3912','M','玛莎拉蒂','Levante','99.98-147.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3913','M','玛莎拉蒂','GranTurismo','219.80-288.80万','','硬顶跑车','4.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3914','M','玛莎拉蒂','GranCabrio','268.80-302.80万','','软顶敞篷车','4.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3915','M','玛莎拉蒂','Coupe','130.00-186.00万','','硬顶跑车','3.2L','手动');
INSERT INTO ask_chexingku VALUES ('3916','M','玛莎拉蒂','玛莎拉蒂Spyder','138.00万','','软顶敞篷车','4.2L','自动');
INSERT INTO ask_chexingku VALUES ('3917','M','迈巴赫','迈巴赫','538.00-1298万','','三厢','5.5T','自动');
INSERT INTO ask_chexingku VALUES ('3918','M','迈凯伦','迈凯伦P1','1260.00万','','硬顶跑车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3919','M','迈凯伦','迈凯伦540C','225.00万','','硬顶跑车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3920','M','迈凯伦','迈凯伦570GT','273.10万','','硬顶敞篷车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3921','M','迈凯伦','迈凯伦570S','255.60万','','硬顶跑车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3922','M','迈凯伦','迈凯伦625C','349.80-381.80万','','硬顶敞篷车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3923','M','迈凯伦','迈凯伦650S','375.80-406.80万','','硬顶敞篷车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3924','M','迈凯伦','迈凯伦675LT','493.30万','','','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3925','M','迈凯伦','迈凯伦12C','338.00-403.80万','','硬顶敞篷车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('3926','M','摩根','摩根EV3','85.00万','','','','');
INSERT INTO ask_chexingku VALUES ('3927','M','摩根','3 Wheeler','88.00-89.36万','','软顶敞篷车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3928','M','摩根','摩根4-4','95.00万','','软顶敞篷车','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3929','M','摩根','摩根Aero','323.75-417.19万','','硬顶敞篷车','4.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3930','M','摩根','摩根Aero 8','268.00万','','硬顶敞篷车','4.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3931','M','摩根','摩根Plus 4','120.00-130.00万','','软顶敞篷车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3932','M','摩根','摩根Plus 8','248.00万','','软顶敞篷车','4.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('3933','M','摩根','摩根Roadster','150.00-160.00万','','软顶敞篷车','3.7L','手动');
INSERT INTO ask_chexingku VALUES ('3934','N','纳智捷','锐3','5.98-9.68万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3935','N','纳智捷','纳5','8.58-11.98万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('3936','N','纳智捷','优6 SUV','10.98-20.08万','','SUV','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('3937','N','纳智捷','大7 SUV','17.98-24.98万','','SUV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('3938','N','纳智捷','大7 MPV','16.98-24.98万','','MPV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3939','N','纳智捷','MASTER CEO','39.80-41.80万','','MPV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('3940','N','南京金龙','开沃D11','13.60-75.80万','','客车','2.8T','固定齿比');
INSERT INTO ask_chexingku VALUES ('3941','O','讴歌','讴歌CDX','22.98-30.98万','','SUV','1.5T','双离合');
INSERT INTO ask_chexingku VALUES ('3942','O','讴歌','讴歌NSX','300.00万','','','','');
INSERT INTO ask_chexingku VALUES ('3943','O','讴歌','讴歌ILX','29.80-32.80万','','三厢','1.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3944','O','讴歌','讴歌TLX','38.98-43.90万','','三厢','2.4L','双离合');
INSERT INTO ask_chexingku VALUES ('3945','O','讴歌','讴歌RLX','85.80-109.80万','','三厢','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3946','O','讴歌','讴歌RDX','39.98-45.98万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('3947','O','讴歌','讴歌MDX','73.90-79.50万','','SUV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3948','O','讴歌','讴歌ZDX','88.80万','','SUV','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('3949','O','讴歌','讴歌TL','39.00-64.50万','','三厢','3.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3950','O','讴歌','讴歌RL','68.00-86.00万','','三厢','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3951','O','欧宝','雅特','18.00-36.98万','','两厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3952','O','欧宝','英速亚','32.50-37.50万','','旅行版','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('3953','O','欧宝','麦瑞纳','19.50-21.50万','','MPV','1.4T','手自一体');
INSERT INTO ask_chexingku VALUES ('3954','O','欧宝','赛飞利','19.98-30.99万','','MPV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('3955','O','欧宝','威达','30.80-39.80万','','三厢','2.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('3956','O','欧宝','安德拉','26.60-32.49万','','SUV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('3957','O','欧朗','欧朗','6.28-8.98万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3958','P','帕加尼','Huayra','2900.00万','','硬顶跑车','6.0T','序列');
INSERT INTO ask_chexingku VALUES ('3959','Q','奇瑞','瑞虎7','10.99-16.39万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3960','Q','奇瑞','奇瑞QQ','3.79-5.09万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3961','Q','奇瑞','风云2','4.29-4.69万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3962','Q','奇瑞','奇瑞E3','5.29-6.49万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3963','Q','奇瑞','艾瑞泽3','5.79-7.49万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3964','Q','奇瑞','艾瑞泽5','5.89-9.79万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3965','Q','奇瑞','艾瑞泽7','7.29-21.29万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3966','Q','奇瑞','奇瑞E5','6.58-8.48万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3967','Q','奇瑞','瑞虎3','6.89-9.29万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3968','Q','奇瑞','瑞虎5','8.99-15.19万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('3969','Q','奇瑞','艾瑞泽M7','7.99-10.79万','','MPV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3970','Q','奇瑞','爱卡','6.28-6.68万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('3971','Q','奇瑞','奇瑞QQ3','2.68-5.94万','','两厢','0.8L','手动');
INSERT INTO ask_chexingku VALUES ('3972','Q','奇瑞','奇瑞QQ6','3.98-5.48万','','掀背','1.1L','AMT');
INSERT INTO ask_chexingku VALUES ('3973','Q','奇瑞','奇瑞QQme','5.50-6.90万','','两厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3974','Q','奇瑞','旗云1','3.88-5.49万','','掀背','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3975','Q','奇瑞','奇瑞A1','3.68-5.98万','','两厢','1.0L','AMT');
INSERT INTO ask_chexingku VALUES ('3976','Q','奇瑞','旗云','4.98-9.58万','','掀背','1.3L','无级');
INSERT INTO ask_chexingku VALUES ('3977','Q','奇瑞','旗云2','4.78-5.98万','','掀背','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3978','Q','奇瑞','风云','5.56-6.98万','','掀背','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3979','Q','奇瑞','奇瑞A3','7.48-10.28万','','两厢','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3980','Q','奇瑞','奇瑞A5','5.58-10.58万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('3981','Q','奇瑞','旗云3','5.78-9.38万','','三厢','1.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('3982','Q','奇瑞','东方之子','8.18-20.18万','','三厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3983','Q','奇瑞','旗云5','7.58-10.18万','','三厢','1.8L','无级');
INSERT INTO ask_chexingku VALUES ('3984','Q','奇瑞','奇瑞X1','5.28-6.78万','','SUV','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('3985','Q','奇瑞','瑞虎','8.48-13.98万','','SUV','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('3986','Q','奇瑞','东方之子Cross','10.48-15.98万','','MPV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('3987','Q','奇瑞','奇瑞eQ','15.99-16.49万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3988','Q','奇瑞','奇瑞QQ3EV','4.58-4.68万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3989','Q','启辰','启辰R30','3.99-5.19万','','两厢','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('3990','Q','启辰','晨风','24.28-25.68万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('3991','Q','启辰','启辰D50','6.98-8.58万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3992','Q','启辰','启辰R50','6.98-8.58万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3993','Q','启辰','启辰R50X','7.45-8.98万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3994','Q','启辰','启辰T70','8.98-12.78万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3995','Q','启辰','启辰T70X','11.68-13.38万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('3996','Q','起亚','起亚K2','7.29-10.19万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('3997','Q','起亚','秀尔','10.38-12.78万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3998','Q','起亚','赛拉图','8.98-11.48万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('3999','Q','起亚','福瑞迪','9.88-11.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4000','Q','起亚','起亚K3S','10.18-14.38万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4001','Q','起亚','起亚K3','9.68-15.08万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4002','Q','起亚','起亚K4','12.88-18.88万','','三厢','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('4003','Q','起亚','起亚K5','15.98-24.88万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('4004','Q','起亚','起亚KX3','11.28-17.78万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4005','Q','起亚','起亚KX5','15.68-23.18万','','SUV','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('4006','Q','起亚','狮跑','10.98-14.68万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4007','Q','起亚','智跑','14.48-18.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4008','Q','起亚','千里马','6.28-10.48万','','三厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('4009','Q','起亚','锐欧','6.98-10.48万','','三厢','1.4L','自动');
INSERT INTO ask_chexingku VALUES ('4010','Q','起亚','远舰','12.28-19.98万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4011','Q','起亚','嘉华','19.58-28.80万','','MPV','2.7L','自动');
INSERT INTO ask_chexingku VALUES ('4012','Q','起亚','凯尊','24.30-32.46万','','三厢','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4013','Q','起亚','起亚K9','55.80-75.88万','','三厢','3.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4014','Q','起亚','索兰托','23.78-37.06万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4015','Q','起亚','霸锐','39.80-41.68万','','SUV','3.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4016','Q','起亚','佳乐','15.98-20.68万','','MPV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4017','Q','起亚','嘉华(进口)','26.98-39.24万','','MPV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('4018','Q','起亚','起亚VQ','29.70-32.50万','','MPV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('4019','Q','起亚','速迈','17.98-22.78万','','硬顶跑车','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('4020','Q','起亚','起亚K5(进口)','25.98-28.98万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4021','Q','起亚','SPORTAGE','21.60-26.50万','','SUV','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4022','Q','起亚','欧菲莱斯','23.90-32.80万','','三厢','2.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('4023','Q','前途','前途K50','暂无报价','','硬顶跑车','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4024','R','日产','玛驰','5.98-8.75万','','两厢','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4025','R','日产','骊威','8.58-11.72万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4026','R','日产','骐达','9.99-13.49万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4027','R','日产','轩逸','9.98-15.90万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4028','R','日产','阳光','7.98-11.28万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4029','R','日产','LANNIA 蓝鸟','10.59-14.39万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4030','R','日产','天籁','17.58-29.98万','','三厢','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4031','R','日产','西玛','23.48-26.78万','','三厢','2.5L','无级');
INSERT INTO ask_chexingku VALUES ('4032','R','日产','逍客','13.98-18.98万','','SUV','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('4033','R','日产','奇骏','18.18-26.78万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4034','R','日产','楼兰','23.88-37.98万','','SUV','2.5L','无级');
INSERT INTO ask_chexingku VALUES ('4035','R','日产','颐达','10.68-17.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4036','R','日产','蓝鸟','15.88-21.98万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4037','R','日产','骏逸','13.88-16.23万','','MPV','1.8L','自动');
INSERT INTO ask_chexingku VALUES ('4038','R','日产','帕拉丁','16.48-24.78万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4039','R','日产','日产NV200','10.78-12.38万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4040','R','日产','日产D22','13.88-18.88万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4041','R','日产','日产ZN厢式车','15.18-19.68万','','皮卡','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4042','R','日产','途乐','79.80万','','SUV','5.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4043','R','日产','贵士','46.80万','','MPV','3.5L','无级');
INSERT INTO ask_chexingku VALUES ('4044','R','日产','日产370Z','52.50-64.50万','','硬顶跑车','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('4045','R','日产','日产GT-R','158.00-235.00万','','硬顶跑车','3.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4046','R','日产','碧莲','79.80-126.80万','','客车','4.5L','手动');
INSERT INTO ask_chexingku VALUES ('4047','R','日产','奇骏(进口)','29.10-33.30万','','SUV','2.5L','自动');
INSERT INTO ask_chexingku VALUES ('4048','R','日产','楼兰(海外)','55.80万','','SUV','3.5L','无级');
INSERT INTO ask_chexingku VALUES ('4049','R','日产','风度','28.80-32.80万','','三厢','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('4050','R','日产','风雅','50.00-58.50万','','三厢','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4051','R','日产','CIMA','66.00万','','三厢','4.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4052','R','日产','日产350Z','58.00-58.20万','','硬顶跑车','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4053','R','荣威','荣威e50','18.89万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4054','R','荣威','荣威350','7.87-14.07万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4055','R','荣威','荣威360','7.59-12.99万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4056','R','荣威','荣威550','9.98-18.28万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('4057','R','荣威','荣威e550','23.98万','','三厢','1.5L','自动');
INSERT INTO ask_chexingku VALUES ('4058','R','荣威','荣威950','17.98-28.98万','','三厢','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4059','R','荣威','荣威e950','28.88-30.88万','','三厢','1.4T','自动');
INSERT INTO ask_chexingku VALUES ('4060','R','荣威','荣威RX5','9.98-18.68万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4061','R','荣威','荣威W5','14.28-22.18万','','SUV','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('4062','R','荣威','荣威750','16.28-27.68万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('4063','R','如虎','如虎 XL','350.00万','','硬顶跑车','4.8L','双离合');
INSERT INTO ask_chexingku VALUES ('4064','R','如虎','如虎 CTR 3','550.00万','','硬顶跑车','3.8T','序列');
INSERT INTO ask_chexingku VALUES ('4065','R','瑞麒','瑞麒M1','3.88-16.98万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4066','R','瑞麒','瑞麒M5','4.88-6.28万','','掀背','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('4067','R','瑞麒','瑞麒G3','6.98-9.68万','','三厢','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('4068','R','瑞麒','瑞麒G5','9.98-17.98万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4069','R','瑞麒','瑞麒G6','18.98-25.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4070','S','smart','smart fortwo','12.50-23.50万','','两厢','0.9T','固定齿比');
INSERT INTO ask_chexingku VALUES ('4071','S','smart','smart forfour','13.50-18.60万','','两厢','0.9T','双离合');
INSERT INTO ask_chexingku VALUES ('4072','S','smart','smart forjeremy','38.80万','','两厢','1.0T','AMT');
INSERT INTO ask_chexingku VALUES ('4073','S','萨博','Saab 9-3','32.50-66.80万','','三厢','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4074','S','萨博','Saab 9-5','45.90-54.90万','','三厢','2.3T','手自一体');
INSERT INTO ask_chexingku VALUES ('4075','S','赛麟','赛麟科迈罗','53.00-127.20万','','软顶敞篷车','3.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4076','S','赛麟','赛麟野马','57.80-165.60万','','软顶敞篷车','2.3T','手自一体');
INSERT INTO ask_chexingku VALUES ('4077','S','三菱','欧蓝德经典','15.48-21.98万','','SUV','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('4078','S','三菱','帕杰罗速跑','18.20-38.60万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4079','S','三菱','风迪思','9.88-14.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4080','S','三菱','蓝瑟','6.98-7.68万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4081','S','三菱','翼神','9.58-16.98万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4082','S','三菱','三菱戈蓝','14.98-19.98万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4083','S','三菱','君阁','12.98-17.48万','','MPV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4084','S','三菱','菱绅','15.98-22.78万','','MPV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4085','S','三菱','欧蓝德','暂无报价','','','','');
INSERT INTO ask_chexingku VALUES ('4086','S','三菱','劲炫ASX','10.98-17.98万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4087','S','三菱','帕杰罗·劲畅','20.88-30.88万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4088','S','三菱','帕杰罗','29.80-48.60万','','SUV','3.0L','自动');
INSERT INTO ask_chexingku VALUES ('4089','S','三菱','欧蓝德(进口)','19.98-28.48万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4090','S','三菱','帕杰罗·劲畅(进口)','36.80-39.80万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4091','S','三菱','帕杰罗(进口)','36.98-42.98万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4092','S','三菱','LANCER','21.80-50.80万','','三厢','2.0L','双离合');
INSERT INTO ask_chexingku VALUES ('4093','S','三菱','ASX劲炫(进口)','18.38-25.50万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4094','S','三菱','格蓝迪','25.25-31.80万','','MPV','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('4095','S','三菱','伊柯丽斯','29.80-33.80万','','硬顶跑车','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4096','S','陕汽通家','福家','3.58-17.80万','','客车','1.0L','固定齿比');
INSERT INTO ask_chexingku VALUES ('4097','S','陕汽通家','龙锐','6.08-6.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('4098','S','上汽大通','上汽大通G10','13.38-26.98万','','MPV','1.9T','手动');
INSERT INTO ask_chexingku VALUES ('4099','S','上汽大通','上汽大通V80','12.98-49.90万','','客车','2.5T','固定齿比');
INSERT INTO ask_chexingku VALUES ('4100','S','上汽大通','伊思坦纳','16.38-22.68万','','客车','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('4101','S','世爵','世爵C8','508.00万','','硬顶跑车','4.2L','手自一体');
INSERT INTO ask_chexingku VALUES ('4102','S','双环','小贵族','3.69-5.28万','','两厢','0.8L','序列');
INSERT INTO ask_chexingku VALUES ('4103','S','双环','来宝SRV','9.68-11.58万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4104','S','双环','双环SCEO','9.98-16.88万','','SUV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('4105','S','双龙','主席','41.80-69.80万','','三厢','2.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4106','S','双龙','蒂维拉','12.98-18.98万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4107','S','双龙','柯兰多','13.98-24.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4108','S','双龙','爱腾','15.48-21.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4109','S','双龙','途凌','13.98-20.98万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4110','S','双龙','雷斯特W','24.98-32.98万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4111','S','双龙','享御','21.98-25.98万','','SUV','2.0T','自动');
INSERT INTO ask_chexingku VALUES ('4112','S','双龙','路帝','21.98-26.98万','','MPV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4113','S','双龙','雷斯特','24.98-47.80万','','SUV','2.0T','自动');
INSERT INTO ask_chexingku VALUES ('4114','S','思铭','思铭','9.99-11.69万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('4115','S','斯巴鲁','翼豹','49.80万','','三厢','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4116','S','斯巴鲁','力狮','21.98-29.28万','','三厢','2.0T','无级');
INSERT INTO ask_chexingku VALUES ('4117','S','斯巴鲁','斯巴鲁XV','18.98-22.98万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4118','S','斯巴鲁','森林人','23.98-33.48万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4119','S','斯巴鲁','傲虎','28.98-35.98万','','SUV','2.0T','无级');
INSERT INTO ask_chexingku VALUES ('4120','S','斯巴鲁','斯巴鲁BRZ','26.90-27.90万','','硬顶跑车','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4121','S','斯巴鲁','驰鹏','54.98-58.78万','','SUV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4122','S','斯达泰克','斯达泰克-卫士','112.80-132.80万','','SUV','2.2T','手动');
INSERT INTO ask_chexingku VALUES ('4123','S','斯达泰克','斯达泰克-揽胜','185.80-388.80万','','皮卡','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4124','S','斯达泰克','斯达泰克-揽胜运动版','148.80-175.80万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4125','S','斯柯达','晶锐','6.99-10.99万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4126','S','斯柯达','明锐','9.98-17.99万','','掀背','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4127','S','斯柯达','昕动','6.99-11.99万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4128','S','斯柯达','昕锐','7.99-11.69万','','三厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4129','S','斯柯达','速派','16.98-27.68万','','掀背','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4130','S','斯柯达','Yeti','12.98-20.98万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4131','S','斯柯达','昊锐','17.19-27.13万','','三厢','1.4T','双离合');
INSERT INTO ask_chexingku VALUES ('4132','S','斯柯达','明锐(进口)','19.92-23.78万','','旅行版','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4133','S','斯柯达','速尊','29.98-33.48万','','旅行版','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('4134','S','斯柯达','Superb','29.50-33.78万','','三厢','1.8T','手自一体');
INSERT INTO ask_chexingku VALUES ('4135','S','斯柯达','Yeti(进口)','29.30-33.28万','','SUV','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4136','T','泰卡特','泰卡特 T9','183.90万','','掀背','3.0T','双离合');
INSERT INTO ask_chexingku VALUES ('4137','T','泰卡特','泰卡特 T7','127.70-152.70万','','SUV','3.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4138','T','泰卡特','泰卡特 T1','110.10万','','软顶敞篷车','2.7L','双离合');
INSERT INTO ask_chexingku VALUES ('4139','T','泰卡特','泰卡特 T2','112.20万','','硬顶跑车','2.7L','双离合');
INSERT INTO ask_chexingku VALUES ('4140','T','泰卡特','泰卡特 T3','192.30万','','硬顶跑车','3.4L','双离合');
INSERT INTO ask_chexingku VALUES ('4141','T','特斯拉','MODEL 3','暂无报价','','','','');
INSERT INTO ask_chexingku VALUES ('4142','T','特斯拉','MODEL S','65.76-104.85万','','掀背','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4143','T','特斯拉','MODEL X','75.44-115.34万','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4144','T','腾势','腾势','36.90-39.90万','','三厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4145','W','威麟','威麟H3','15.98万','','客车','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4146','W','威麟','威麟H5','17.98-21.38万','','客车','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4147','W','威麟','威麟X5','10.98-14.38万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4148','W','威麟','威麟V5','8.58-13.78万','','MPV','1.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4149','W','威兹曼','威兹曼GT','295.00-385.00万','','硬顶跑车','4.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4150','W','威兹曼','威兹曼Roadster','310.00-410.00万','','软顶敞篷车','4.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4151','W','潍柴英致','英致G5','暂无报价','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4152','W','潍柴英致','英致G3','5.69-7.99万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4153','W','潍柴英致','英致727','4.68-4.98万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4154','W','潍柴英致','英致737','5.68-9.98万','','MPV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4155','W','沃尔沃','沃尔沃S80L','39.99-49.99万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4156','W','沃尔沃','沃尔沃S40','20.90-37.80万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4157','W','沃尔沃','沃尔沃S60L','26.69-55.99万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('4158','W','沃尔沃','沃尔沃XC60','35.89-53.99万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4159','W','沃尔沃','XC Classic','54.89-63.89万','','SUV','2.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('4160','W','沃尔沃','沃尔沃S90','57.00-72.00万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4161','W','沃尔沃','沃尔沃V40','22.39-30.99万','','两厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('4162','W','沃尔沃','沃尔沃S60','40.29-50.69万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4163','W','沃尔沃','沃尔沃V60','30.99-41.69万','','旅行版','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4164','W','沃尔沃','沃尔沃XC90','68.80-135.80万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4165','W','沃尔沃','沃尔沃S80','45.80-123.98万','','三厢','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('4166','W','沃尔沃','沃尔沃XC60(进口)','38.99-67.80万','','SUV','2.0T','双离合');
INSERT INTO ask_chexingku VALUES ('4167','W','沃尔沃','沃尔沃C30','22.50-40.00万','','两厢','2.0L','双离合');
INSERT INTO ask_chexingku VALUES ('4168','W','沃尔沃','沃尔沃S40(进口)','32.50-46.80万','','三厢','1.9L','自动');
INSERT INTO ask_chexingku VALUES ('4169','W','沃尔沃','沃尔沃C70','59.80-80.00万','','硬顶敞篷车','2.3T','手动');
INSERT INTO ask_chexingku VALUES ('4170','W','五菱汽车','五菱宏光','4.18-7.93万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4171','W','五菱汽车','五菱荣光','4.03-5.78万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4172','W','五菱汽车','五菱荣光V','3.78-4.58万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4173','W','五菱汽车','五菱之光','3.08-3.49万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4174','W','五菱汽车','PN货车','3.66-3.99万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4175','W','五菱汽车','五菱荣光小卡','3.71-4.26万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4176','W','五菱汽车','五菱之光小卡','2.99-3.29万','','货车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4177','W','五菱汽车','五菱征程','6.60-7.72万','','客车','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4178','W','五十铃','五十铃mu-X','17.88-25.38万','','SUV','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4179','W','五十铃','D-MAX','13.40-18.28万','','皮卡','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4180','W','五十铃','瑞迈','8.48-11.68万','','皮卡','2.8T','手动');
INSERT INTO ask_chexingku VALUES ('4181','W','五十铃','五十铃皮卡','9.28-14.08万','','皮卡','2.5L','手动');
INSERT INTO ask_chexingku VALUES ('4182','X','西雅特','伊比飒','14.98-18.88万','','两厢','1.2T','双离合');
INSERT INTO ask_chexingku VALUES ('4183','X','西雅特','LEON','24.39-29.46万','','两厢','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4184','X','西雅特','欧悦搏','29.92-36.57万','','MPV','1.8T','双离合');
INSERT INTO ask_chexingku VALUES ('4185','X','现代','瑞纳','7.39-10.69万','','三厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4186','X','现代','瑞奕','7.29-9.99万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4187','X','现代','悦动','7.88-12.08万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4188','X','现代','朗动','10.58-12.78万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4189','X','现代','领动','9.98-15.18万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4190','X','现代','伊兰特','8.98-9.88万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4191','X','现代','名图','12.98-17.68万','','三厢','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('4192','X','现代','索纳塔九','17.48-24.98万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('4193','X','现代','北京现代ix25','11.98-18.68万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4194','X','现代','途胜','15.99-23.99万','','SUV','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('4195','X','现代','北京现代ix35','14.98-22.28万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4196','X','现代','全新胜达','20.98-28.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4197','X','现代','索纳塔八','18.39-21.39万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4198','X','现代','雅绅特','7.18-10.58万','','三厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4199','X','现代','北京现代i30','9.98-14.18万','','两厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4200','X','现代','领翔','15.58-22.88万','','三厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4201','X','现代','名驭','11.48-13.98万','','三厢','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('4202','X','现代','索纳塔','12.38-22.80万','','三厢','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('4203','X','现代','御翔','16.58-22.38万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4204','X','现代','康恩迪','39.60-49.80万','','客车','4.0T','手动');
INSERT INTO ask_chexingku VALUES ('4205','X','现代','Veloster飞思','17.28-21.98万','','两厢','1.6T','手动');
INSERT INTO ask_chexingku VALUES ('4206','X','现代','雅尊','24.08-33.28万','','三厢','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4207','X','现代','捷恩斯','37.80-64.88万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4208','X','现代','雅科仕','73.80-132.00万','','三厢','3.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4209','X','现代','全新胜达(进口)','30.06-36.18万','','SUV','2.2T','手自一体');
INSERT INTO ask_chexingku VALUES ('4210','X','现代','格锐','25.60-37.98万','','SUV','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4211','X','现代','H-1辉翼','21.18-24.98万','','MPV','2.4L','自动');
INSERT INTO ask_chexingku VALUES ('4212','X','现代','劳恩斯-酷派','23.36-36.96万','','硬顶跑车','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4213','X','现代','索纳塔(进口)','29.38万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4214','X','现代','途胜(进口)','24.58-27.50万','','SUV','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('4215','X','现代','新胜达(进口)','21.00-29.46万','','SUV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4216','X','现代','君爵','24.50-25.50万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4217','X','现代','劳恩斯','39.80-58.80万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4218','X','现代','维拉克斯','39.80-43.98万','','SUV','3.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4219','X','现代','美佳','11.62-13.97万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4220','X','现代','酷派','17.80-20.73万','','硬顶跑车','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4221','X','新凯','凯胜','10.80-12.98万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4222','X','新凯','新凯凌特','158.00万','','MPV','3.5L','自动');
INSERT INTO ask_chexingku VALUES ('4223','X','新凯','新凯威霆','90.80万','','MPV','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4224','X','雪佛兰','赛欧','6.29-7.99万','','三厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('4225','X','雪佛兰','爱唯欧','7.39-10.99万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4226','X','雪佛兰','乐风RV','7.49-9.99万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4227','X','雪佛兰','科鲁兹','8.99-16.99万','','三厢','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4228','X','雪佛兰','迈锐宝','16.49-19.99万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('4229','X','雪佛兰','迈锐宝XL','17.99-24.99万','','三厢','1.5T','手自一体');
INSERT INTO ask_chexingku VALUES ('4230','X','雪佛兰','创酷','10.99-14.99万','','SUV','1.4T','手动');
INSERT INTO ask_chexingku VALUES ('4231','X','雪佛兰','科帕奇','17.99-20.99万','','SUV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4232','X','雪佛兰','乐骋','7.19-10.39万','','两厢','1.2L','自动');
INSERT INTO ask_chexingku VALUES ('4233','X','雪佛兰','乐风','7.39-10.79万','','三厢','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4234','X','雪佛兰','景程','10.88-19.69万','','三厢','1.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4235','X','雪佛兰','科迈罗','45.58-49.98万','','硬顶跑车','3.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4236','X','雪佛兰','斯帕可','7.78-8.88万','','两厢','1.0L','自动');
INSERT INTO ask_chexingku VALUES ('4237','X','雪佛兰','沃蓝达','49.80万','','掀背','1.4L','固定齿比');
INSERT INTO ask_chexingku VALUES ('4238','X','雪佛兰','科帕奇(进口)','22.48-37.28万','','SUV','2.4L','手自一体');
INSERT INTO ask_chexingku VALUES ('4239','X','雪铁龙','雪铁龙C4L','13.19-18.99万','','三厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('4240','X','雪铁龙','世嘉','9.58-11.18万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4241','X','雪铁龙','爱丽舍','8.38-12.08万','','三厢','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4242','X','雪铁龙','C4世嘉','10.78-16.48万','','三厢','1.2T','手动');
INSERT INTO ask_chexingku VALUES ('4243','X','雪铁龙','雪铁龙C5','18.19-24.99万','','三厢','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('4244','X','雪铁龙','雪铁龙C3-XR','10.88-17.18万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4245','X','雪铁龙','雪铁龙C2','7.18-10.68万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4246','X','雪铁龙','富康','6.28-10.08万','','两厢','1.4L','手动');
INSERT INTO ask_chexingku VALUES ('4247','X','雪铁龙','凯旋','14.98-20.48万','','三厢','2.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4248','X','雪铁龙','赛纳','12.98-18.38万','','两厢','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4249','X','雪铁龙','毕加索','12.58-20.98万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4250','X','雪铁龙','雪铁龙C4 Aircross','19.98-27.98万','','SUV','2.0L','无级');
INSERT INTO ask_chexingku VALUES ('4251','X','雪铁龙','C4 PICASSO','21.68-25.38万','','MPV','1.6T','手自一体');
INSERT INTO ask_chexingku VALUES ('4252','X','雪铁龙','雪铁龙C3','29.50万','','两厢','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4253','X','雪铁龙','雪铁龙C4','19.98-24.98万','','两厢','1.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4254','X','雪铁龙','雪铁龙C5(进口)','29.88-52.00万','','三厢','2.0L','自动');
INSERT INTO ask_chexingku VALUES ('4255','X','雪铁龙','雪铁龙C6(进口)','63.98-64.88万','','三厢','3.0L','手自一体');
INSERT INTO ask_chexingku VALUES ('4256','Y','野马汽车','野马E70','暂无报价','','SUV','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4257','Y','野马汽车','野马F10','4.58-5.88万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4258','Y','野马汽车','野马F12','4.98-6.28万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4259','Y','野马汽车','野马F16','5.58-6.98万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4260','Y','野马汽车','野马T70','7.30-12.18万','','SUV','1.8L','手动');
INSERT INTO ask_chexingku VALUES ('4261','Y','野马汽车','野马F99','4.78-7.08万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4262','Y','一汽','威志V2','4.69-5.59万','','两厢','1.3L','AMT');
INSERT INTO ask_chexingku VALUES ('4263','Y','一汽','威志V5','5.29-6.59万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4264','Y','一汽','夏利N5','3.69-4.89万','','三厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4265','Y','一汽','夏利N7','4.89-5.29万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4266','Y','一汽','骏派D60','6.49-9.99万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4267','Y','一汽','夏利','3.10-3.50万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4268','Y','一汽','威乐','6.48-9.48万','','三厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4269','Y','一汽','威志','5.00-6.88万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4270','Y','一汽','威姿','6.38-8.98万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4271','Y','一汽','森雅R7','6.89-8.69万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4272','Y','一汽','森雅S80','4.99-6.59万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4273','Y','一汽','佳宝V52','2.72-2.92万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4274','Y','一汽','佳宝V55','3.29万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4275','Y','一汽','佳宝V75','2.89-3.09万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4276','Y','一汽','佳宝V77','3.09-3.59万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4277','Y','一汽','佳宝V80','4.09-5.39万','','客车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4278','Y','一汽','佳宝T50','3.29-3.45万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4279','Y','一汽','佳宝T51','2.55万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4280','Y','一汽','佳宝T57','2.99-3.09万','','货车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4281','Y','一汽','解放T80','3.49-3.79万','','货车','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4282','Y','一汽','森雅M80','5.19-8.15万','','MPV','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('4283','Y','一汽','佳宝V70','3.62-4.88万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4284','Y','一汽','佳宝V70 II代','3.49-5.09万','','客车','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4285','Y','一汽','坤程','6.38-6.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('4286','Y','依维柯','宝迪','13.09-31.59万','','客车','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4287','Y','依维柯','得意','10.79-17.79万','','客车','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4288','Y','依维柯','都灵','12.49-22.20万','','客车','2.5T','手动');
INSERT INTO ask_chexingku VALUES ('4289','Y','英菲尼迪','英菲尼迪Q50L','27.98-40.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4290','Y','英菲尼迪','英菲尼迪QX50','34.98-44.98万','','SUV','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4291','Y','英菲尼迪','英菲尼迪Q50','32.58-54.98万','','三厢','2.0T','手自一体');
INSERT INTO ask_chexingku VALUES ('4292','Y','英菲尼迪','英菲尼迪Q70','39.98-64.98万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4293','Y','英菲尼迪','英菲尼迪ESQ','18.98-24.98万','','SUV','1.6L','无级');
INSERT INTO ask_chexingku VALUES ('4294','Y','英菲尼迪','英菲尼迪QX60','61.80-73.80万','','SUV','2.5T','无级');
INSERT INTO ask_chexingku VALUES ('4295','Y','英菲尼迪','英菲尼迪QX70','77.80-116.80万','','SUV','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('4296','Y','英菲尼迪','英菲尼迪QX80','119.80万','','SUV','5.6L','手自一体');
INSERT INTO ask_chexingku VALUES ('4297','Y','英菲尼迪','英菲尼迪Q60','69.90万','','硬顶敞篷车','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('4298','Y','英菲尼迪','英菲尼迪QX50(进口)','41.88-60.48万','','SUV','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4299','Y','英菲尼迪','英菲尼迪G系','25.80-75.41万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4300','Y','英菲尼迪','英菲尼迪M系','43.88-74.58万','','三厢','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4301','Y','英菲尼迪','英菲尼迪EX','46.38-65.50万','','SUV','2.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4302','Y','英菲尼迪','英菲尼迪FX','66.30-121.80万','','SUV','3.5L','手自一体');
INSERT INTO ask_chexingku VALUES ('4303','Y','英菲尼迪','英菲尼迪JX','61.80-71.80万','','SUV','3.5L','无级');
INSERT INTO ask_chexingku VALUES ('4304','Y','英菲尼迪','英菲尼迪QX','92.00-152.80万','','SUV','5.6L','自动');
INSERT INTO ask_chexingku VALUES ('4305','Y','英菲尼迪','英菲尼迪Q60S','66.21万','','硬顶跑车','3.7L','手自一体');
INSERT INTO ask_chexingku VALUES ('4306','Y','永源','猎鹰','8.08-10.38万','','SUV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4307','Y','永源','永源A380','5.99-9.88万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4308','Y','永源','永源五星','3.78-4.28万','','客车','1.1L','手动');
INSERT INTO ask_chexingku VALUES ('4309','Y','驭胜','驭胜S330','8.88-14.28万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4310','Y','驭胜','驭胜S350','12.28-15.98万','','SUV','2.0T','手动');
INSERT INTO ask_chexingku VALUES ('4311','Z','知豆','知豆D1','15.88万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4312','Z','知豆','知豆D2','15.88万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4313','Z','知豆','知豆','10.88万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4314','Z','中华','中华豚','3.98-4.58万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4315','Z','中华','中华H220','5.48-6.78万','','两厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('4316','Z','中华','中华H230','5.58-6.88万','','三厢','1.5L','AMT');
INSERT INTO ask_chexingku VALUES ('4317','Z','中华','中华H330','6.58-7.58万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4318','Z','中华','中华H530','8.58-12.58万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4319','Z','中华','中华V3','6.57-10.27万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4320','Z','中华','中华V5','8.98-14.58万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4321','Z','中华','中华H320','6.38-7.88万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4322','Z','中华','中华骏捷Cross','7.68-10.98万','','两厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4323','Z','中华','中华骏捷FRV','5.58-8.53万','','两厢','1.3L','手自一体');
INSERT INTO ask_chexingku VALUES ('4324','Z','中华','中华骏捷FSV','6.58-9.78万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4325','Z','中华','中华骏捷','7.58-16.58万','','三厢','1.6L','自动');
INSERT INTO ask_chexingku VALUES ('4326','Z','中华','中华尊驰','10.58-25.28万','','三厢','1.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4327','Z','中华','中华酷宝','12.89-16.95万','','硬顶跑车','1.8L','手自一体');
INSERT INTO ask_chexingku VALUES ('4328','Z','中兴','中兴C3','5.88-6.38万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4329','Z','中兴','中兴GX3','6.38-6.98万','','SUV','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4330','Z','中兴','威虎G3','6.18-7.58万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('4331','Z','中兴','威虎TUV','7.08-10.98万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('4332','Z','中兴','小老虎','6.38-7.58万','','皮卡','2.4T','手动');
INSERT INTO ask_chexingku VALUES ('4333','Z','中兴','无限','8.98-9.38万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4334','Z','中兴','无限V3','9.98-13.78万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4335','Z','中兴','无限V5','9.98-14.83万','','SUV','2.4L','手动');
INSERT INTO ask_chexingku VALUES ('4336','Z','中兴','无限V7','7.98-8.38万','','SUV','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4337','Z','中兴','昌铃','5.99-6.59万','','皮卡','2.2L','手动');
INSERT INTO ask_chexingku VALUES ('4338','Z','中兴','旗舰A9','5.39-5.99万','','皮卡','2.0L','手动');
INSERT INTO ask_chexingku VALUES ('4339','Z','众泰','江南T11','10.50万','','两厢','','自动');
INSERT INTO ask_chexingku VALUES ('4340','Z','众泰','江南TT','2.08-2.58万','','两厢','0.8L','手动');
INSERT INTO ask_chexingku VALUES ('4341','Z','众泰','云100','15.89-16.99万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4342','Z','众泰','芝麻E30','17.98万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4343','Z','众泰','众泰E200','18.18万','','两厢','','固定齿比');
INSERT INTO ask_chexingku VALUES ('4344','Z','众泰','众泰Z100','3.00-3.50万','','两厢','1.0L','手动');
INSERT INTO ask_chexingku VALUES ('4345','Z','众泰','众泰Z300','5.49-8.85万','','三厢','1.5L','手动');
INSERT INTO ask_chexingku VALUES ('4346','Z','众泰','众泰Z500','7.68-10.98万','','三厢','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4347','Z','众泰','众泰Z700','9.98-15.88万','','三厢','1.8T','手动');
INSERT INTO ask_chexingku VALUES ('4348','Z','众泰','众泰T200','4.60-6.30万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4349','Z','众泰','大迈X5','7.39-12.39万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4350','Z','众泰','众泰SR7','7.38-15.98万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4351','Z','众泰','众泰T600','7.98-14.98万','','SUV','1.5T','手动');
INSERT INTO ask_chexingku VALUES ('4352','Z','众泰','众泰V10','3.78-5.08万','','客车','1.2L','手动');
INSERT INTO ask_chexingku VALUES ('4353','Z','众泰','众泰M300','6.98-14.98万','','MPV','1.6L','手动');
INSERT INTO ask_chexingku VALUES ('4354','Z','众泰','众泰Z200','4.36-6.86万','','三厢','1.3L','自动');
INSERT INTO ask_chexingku VALUES ('4355','Z','众泰','众泰Z200HB','4.96-7.66万','','两厢','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4356','Z','众泰','众泰2008','4.38-6.38万','','SUV','1.3L','手动');
INSERT INTO ask_chexingku VALUES ('4357','Z','众泰','众泰5008','5.38-7.48万','','SUV','1.3L','无级');

DROP TABLE IF EXISTS ask_credit;
CREATE TABLE `ask_credit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `operation` varchar(100) NOT NULL DEFAULT '',
  `credit1` smallint(6) NOT NULL DEFAULT '0',
  `credit2` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=utf8 AUTO_INCREMENT=231;

INSERT INTO ask_credit VALUES ('218','1','1467876119','offer','0','0');
INSERT INTO ask_credit VALUES ('219','1','1467876119','question/add','5','0');
INSERT INTO ask_credit VALUES ('220','1','1467878024','offer','0','0');
INSERT INTO ask_credit VALUES ('221','1','1467878024','question/add','5','0');
INSERT INTO ask_credit VALUES ('222','1','1468283283','user/login','2','0');
INSERT INTO ask_credit VALUES ('223','1','1472540673','offer','0','0');
INSERT INTO ask_credit VALUES ('224','1','1472540673','question/add','5','0');
INSERT INTO ask_credit VALUES ('225','1','1472541423','offer','0','0');
INSERT INTO ask_credit VALUES ('226','1','1472541423','question/add','5','0');
INSERT INTO ask_credit VALUES ('227','1','1472541763','offer','0','0');
INSERT INTO ask_credit VALUES ('228','1','1472541763','question/add','5','0');
INSERT INTO ask_credit VALUES ('229','1','1472546460','offer','0','0');
INSERT INTO ask_credit VALUES ('230','1','1472546460','question/add','5','0');

DROP TABLE IF EXISTS ask_crontab;
CREATE TABLE `ask_crontab` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `name` char(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `lastrun` int(10) unsigned NOT NULL DEFAULT '0',
  `nextrun` int(10) unsigned NOT NULL DEFAULT '0',
  `weekday` tinyint(1) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `hour` tinyint(2) NOT NULL DEFAULT '0',
  `minute` char(36) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_datacall;
CREATE TABLE `ask_datacall` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `expression` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_doing;
CREATE TABLE `ask_doing` (
  `doingid` bigint(20) NOT NULL AUTO_INCREMENT,
  `authorid` int(10) NOT NULL,
  `author` varchar(20) NOT NULL,
  `action` tinyint(1) NOT NULL,
  `questionid` int(10) NOT NULL,
  `content` text,
  `referid` int(10) NOT NULL DEFAULT '0',
  `refer_authorid` int(10) NOT NULL DEFAULT '0',
  `refer_content` tinytext,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`doingid`),
  KEY `authorid` (`authorid`,`author`),
  KEY `sourceid` (`questionid`),
  KEY `createtime` (`createtime`),
  KEY `referid` (`referid`)
) ENGINE=MyISAM AUTO_INCREMENT=1245 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1245;

INSERT INTO ask_doing VALUES ('1126','1','admin','4','575','','0','0','','1467783003');
INSERT INTO ask_doing VALUES ('1127','1','admin','4','575','','0','0','','1467783003');
INSERT INTO ask_doing VALUES ('1128','1','admin','4','575','','0','0','','1467783003');
INSERT INTO ask_doing VALUES ('1129','1','admin','1','575','','0','0','','1467783003');
INSERT INTO ask_doing VALUES ('1130','1','admin','8','575','你真的帮了我大忙','1173','1','是的，网上的为准','1467783003');
INSERT INTO ask_doing VALUES ('1131','1','admin','4','576','','0','0','','1467783005');
INSERT INTO ask_doing VALUES ('1132','1','admin','4','576','','0','0','','1467783005');
INSERT INTO ask_doing VALUES ('1133','726','','4','576','','0','0','','1467783005');
INSERT INTO ask_doing VALUES ('1134','1','admin','1','576','','0','0','','1467783005');
INSERT INTO ask_doing VALUES ('1135','1','admin','8','576','你真的帮了我大忙','1175','1','应该会涨，因为大家普遍反映考试题简单，可能分数线高了','1467783005');
INSERT INTO ask_doing VALUES ('1136','1','admin','4','577','','0','0','','1467783007');
INSERT INTO ask_doing VALUES ('1137','727','匿名网友','4','577','','0','0','','1467783007');
INSERT INTO ask_doing VALUES ('1138','1','admin','4','577','','0','0','','1467783007');
INSERT INTO ask_doing VALUES ('1139','726','','4','577','','0','0','','1467783007');
INSERT INTO ask_doing VALUES ('1140','727','匿名网友','1','577','','0','0','','1467783007');
INSERT INTO ask_doing VALUES ('1141','727','匿名网友','8','577','谢谢你','1177','726','复习一年把','1467783007');
INSERT INTO ask_doing VALUES ('1142','726','','4','578','','0','0','','1467783040');
INSERT INTO ask_doing VALUES ('1143','1','admin','4','578','','0','0','','1467783040');
INSERT INTO ask_doing VALUES ('1144','726','','4','578','','0','0','','1467783040');
INSERT INTO ask_doing VALUES ('1145','727','匿名网友','1','578','','0','0','','1467783040');
INSERT INTO ask_doing VALUES ('1146','1','admin','4','579','','0','0','','1467783042');
INSERT INTO ask_doing VALUES ('1147','726','','4','579','','0','0','','1467783042');
INSERT INTO ask_doing VALUES ('1148','727','匿名网友','4','579','','0','0','','1467783042');
INSERT INTO ask_doing VALUES ('1149','1','admin','1','579','','0','0','','1467783042');
INSERT INTO ask_doing VALUES ('1150','1','admin','8','579','高手留个联系方式吧','1180','727','不会吧，问问馆里。','1467783042');
INSERT INTO ask_doing VALUES ('1151','1','admin','4','580','','0','0','','1467783044');
INSERT INTO ask_doing VALUES ('1152','729','glw205','4','580','','0','0','','1467783044');
INSERT INTO ask_doing VALUES ('1153','726','','4','580','','0','0','','1467783044');
INSERT INTO ask_doing VALUES ('1154','727','匿名网友','4','580','','0','0','','1467783044');
INSERT INTO ask_doing VALUES ('1155','729','glw205','1','580','','0','0','','1467783044');
INSERT INTO ask_doing VALUES ('1156','729','glw205','8','580','非常感谢你','1181','727','最低限就可以','1467783044');
INSERT INTO ask_doing VALUES ('1157','1','admin','4','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1158','726','','4','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1159','727','匿名网友','4','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1160','728','艮本停不下来','4','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1161','729','glw205','4','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1162','726','','1','581','','0','0','','1467783045');
INSERT INTO ask_doing VALUES ('1163','726','','8','581','大神......','1182','727','这不一定，要根据当年整体成绩加权后确定','1467783045');
INSERT INTO ask_doing VALUES ('1164','727','匿名网友','4','582','','0','0','','1467783047');
INSERT INTO ask_doing VALUES ('1165','728','艮本停不下来','4','582','','0','0','','1467783047');
INSERT INTO ask_doing VALUES ('1166','726','','4','582','','0','0','','1467783047');
INSERT INTO ask_doing VALUES ('1167','728','艮本停不下来','4','582','','0','0','','1467783047');
INSERT INTO ask_doing VALUES ('1168','727','匿名网友','1','582','','0','0','','1467783047');
INSERT INTO ask_doing VALUES ('1169','732','YY2016小柒','4','583','','0','0','','1467783049');
INSERT INTO ask_doing VALUES ('1170','731','cjbzd','4','583','','0','0','','1467783049');
INSERT INTO ask_doing VALUES ('1171','730','f01205','4','583','','0','0','','1467783049');
INSERT INTO ask_doing VALUES ('1172','732','YY2016小柒','4','583','','0','0','','1467783049');
INSERT INTO ask_doing VALUES ('1173','727','匿名网友','1','583','','0','0','','1467783049');
INSERT INTO ask_doing VALUES ('1174','731','cjbzd','4','584','','0','0','','1467783051');
INSERT INTO ask_doing VALUES ('1175','731','cjbzd','4','584','','0','0','','1467783051');
INSERT INTO ask_doing VALUES ('1176','1','admin','4','584','','0','0','','1467783051');
INSERT INTO ask_doing VALUES ('1177','1','admin','4','584','','0','0','','1467783051');
INSERT INTO ask_doing VALUES ('1178','726','','1','584','','0','0','','1467783051');
INSERT INTO ask_doing VALUES ('1179','727','匿名网友','4','585','','0','0','','1467783053');
INSERT INTO ask_doing VALUES ('1180','726','','4','585','','0','0','','1467783053');
INSERT INTO ask_doing VALUES ('1181','1','admin','4','585','','0','0','','1467783053');
INSERT INTO ask_doing VALUES ('1182','733','放手备战','4','585','','0','0','','1467783053');
INSERT INTO ask_doing VALUES ('1183','730','f01205','1','585','','0','0','','1467783053');
INSERT INTO ask_doing VALUES ('1184','733','放手备战','4','586','','0','0','','1467783055');
INSERT INTO ask_doing VALUES ('1185','730','f01205','4','586','','0','0','','1467783055');
INSERT INTO ask_doing VALUES ('1186','728','艮本停不下来','4','586','','0','0','','1467783055');
INSERT INTO ask_doing VALUES ('1187','729','glw205','4','586','','0','0','','1467783055');
INSERT INTO ask_doing VALUES ('1188','726','','1','586','','0','0','','1467783055');
INSERT INTO ask_doing VALUES ('1189','742','懒惰赖床的小兵','4','587','','0','0','','1467783058');
INSERT INTO ask_doing VALUES ('1190','730','f01205','4','587','','0','0','','1467783058');
INSERT INTO ask_doing VALUES ('1191','734','360U2699109498','4','587','','0','0','','1467783058');
INSERT INTO ask_doing VALUES ('1192','728','艮本停不下来','4','587','','0','0','','1467783058');
INSERT INTO ask_doing VALUES ('1193','731','cjbzd','1','587','','0','0','','1467783058');
INSERT INTO ask_doing VALUES ('1194','731','cjbzd','8','587','真给力','1202','728','当然可以去读了，只要是正规的学校都可以','1467783058');
INSERT INTO ask_doing VALUES ('1195','734','360U2699109498','4','588','','0','0','','1467783060');
INSERT INTO ask_doing VALUES ('1196','732','YY2016小柒','4','588','','0','0','','1467783060');
INSERT INTO ask_doing VALUES ('1197','738','惜若水三千','4','588','','0','0','','1467783060');
INSERT INTO ask_doing VALUES ('1198','735','zhouchangyi','4','588','','0','0','','1467783060');
INSERT INTO ask_doing VALUES ('1199','742','懒惰赖床的小兵','1','588','','0','0','','1467783060');
INSERT INTO ask_doing VALUES ('1200','742','懒惰赖床的小兵','8','588','谢谢你','1203','733','六安市梅山路','1467783060');
INSERT INTO ask_doing VALUES ('1201','732','YY2016小柒','4','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1202','741','猫三七','4','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1203','735','zhouchangyi','4','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1204','730','f01205','4','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1205','738','惜若水三千','4','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1206','730','f01205','1','589','','0','0','','1467783062');
INSERT INTO ask_doing VALUES ('1207','730','f01205','8','589','你真的帮了我大忙','1204','729','智汇推是腾讯旗下的产品。智汇推整合腾讯资讯、娱乐等网络媒体的PC和移动端资源面向区域企业提供的“品效合一”的营销推广服务.效果自然出众，目前安徽区尚未有总代理出现，但是我们目','1467783062');
INSERT INTO ask_doing VALUES ('1208','1','admin','1','590','小习长得帅','0','0','','1467876119');
INSERT INTO ask_doing VALUES ('1209','1','admin','1','591','狗日的中国话','0','0','','1467878024');
INSERT INTO ask_doing VALUES ('1229','1','admin','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1228','746','宝妹儿妈z','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1227','735','zhouchangyi','1','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1226','740','我是樊磊','4','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1225','733','放手备战','4','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1224','732','YY2016小柒','4','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1223','742','懒惰赖床的小兵','4','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1222','731','cjbzd','4','602','','0','0','','1470289599');
INSERT INTO ask_doing VALUES ('1230','739','该用户已诈尸矣','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1231','742','懒惰赖床的小兵','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1232','738','惜若水三千','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1233','735','zhouchangyi','4','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1234','746','宝妹儿妈z','1','603','','0','0','','1470290439');
INSERT INTO ask_doing VALUES ('1235','747','毛毛的丹妮','4','604','','0','0','','1470290441');
INSERT INTO ask_doing VALUES ('1236','736','唯我.杜康','4','604','','0','0','','1470290441');
INSERT INTO ask_doing VALUES ('1237','742','懒惰赖床的小兵','4','604','','0','0','','1470290441');
INSERT INTO ask_doing VALUES ('1238','746','宝妹儿妈z','4','604','','0','0','','1470290441');
INSERT INTO ask_doing VALUES ('1239','744','jjjjjj','1','604','','0','0','','1470290441');
INSERT INTO ask_doing VALUES ('1240','744','jjjjjj','8','604','真给力','1212','751','                         ','1470290441');
INSERT INTO ask_doing VALUES ('1241','1','admin','1','605','[键入文档标题][键入文档副标题][标题 1]对于“插入”选项卡上的库，在设计时都充分考虑了其中的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。[标题 2]在“开始”选项卡上，通过从快速样式库1472540522112037.docx中为所选文本选择一种外观，您可以方便地更改文档中所选文本的格式。 您还可以使用“开始”选项卡上的其他控件来直接设置文本格式。大多数控件都允许您选择是使用当前主题外观，还是使用某种直接指定的格式。[标题 3]var&nbsp;a=3;\r\nconsole.log(a);\r\nalert(&quot;fffff&quot;);对于“插入”选项卡上的库，在设计时都充分考虑了其中的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。','0','0','','1472540673');
INSERT INTO ask_doing VALUES ('1242','1','admin','1','606','咨询描述:[键入文档标题][键入文档副标题][标题 1]对于“插入”选项卡上的库，在设计时都充分考虑了其中1472540522112037.docxvar&nbsp;a=4;\r\nalert(a);的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。[标题 2]在“开始”选项卡上，通过从快速样式库1472540522112037.docx中为所选文本选择一种外观，您可以方便地更改文档中所选文本的格式。 您还可以使用“开始”选项卡上的其他控件来直接设置文本格式。大多数控件都允许您选择是使用当前主题外观，还是使用某种直接指定的格式。[标题 3]var&nbsp;a=3; console.log(a); alert(&quot;fffff&quot;);对于“插入”选项卡上的库，在设计时都充分考虑了其中的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。','0','0','','1472541423');
INSERT INTO ask_doing VALUES ('1243','1','admin','1','607','dddddddddddddddddddd$a=9;\r\n$b=10;\r\n$c=$a+$b;\r\necho&nbsp;$c;ggggggggggggggggggggg','0','0','','1472541763');
INSERT INTO ask_doing VALUES ('1244','1','admin','1','608','\r\n &nbsp;alert(&quot;ffffff&quot;);','0','0','','1472546460');

DROP TABLE IF EXISTS ask_editor;
CREATE TABLE `ask_editor` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `tag` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(255) NOT NULL DEFAULT '',
  `code` text NOT NULL,
  `displayorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_expert;
CREATE TABLE `ask_expert` (
  `uid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_famous;
CREATE TABLE `ask_famous` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reason` char(50) DEFAULT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_favorite;
CREATE TABLE `ask_favorite` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `qid` mediumint(10) unsigned NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `qid` (`qid`),
  KEY `time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;


DROP TABLE IF EXISTS ask_gift;
CREATE TABLE `ask_gift` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `credit` int(10) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;


DROP TABLE IF EXISTS ask_giftlog;
CREATE TABLE `ask_giftlog` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `username` char(20) NOT NULL,
  `realname` char(20) NOT NULL,
  `gid` int(10) NOT NULL,
  `giftname` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postcode` char(10) NOT NULL,
  `phone` char(15) NOT NULL,
  `qq` char(15) NOT NULL,
  `email` varchar(30) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `credit` int(10) NOT NULL,
  `time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_inform;
CREATE TABLE `ask_inform` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `uid` int(10) NOT NULL,
  `qtitle` varchar(200) NOT NULL,
  `qid` int(100) NOT NULL,
  `aid` int(11) NOT NULL,
  `content` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `keywords` varchar(100) NOT NULL,
  `counts` int(11) NOT NULL DEFAULT '1',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9;


DROP TABLE IF EXISTS ask_keywords;
CREATE TABLE `ask_keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `find` varchar(200) NOT NULL,
  `replacement` varchar(200) NOT NULL,
  `admin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 AUTO_INCREMENT=7;

INSERT INTO ask_keywords VALUES ('1','百度','http://www.baidu.com','admin');
INSERT INTO ask_keywords VALUES ('2','腾讯','http://www.qq.com','admin');
INSERT INTO ask_keywords VALUES ('3','无人机','http://www.wurenji.com','admin');
INSERT INTO ask_keywords VALUES ('4','问答系统','http://www.ask2.cn','admin');
INSERT INTO ask_keywords VALUES ('6','银泰中心','http://www.wenda.com/q-285.html','admin');

DROP TABLE IF EXISTS ask_link;
CREATE TABLE `ask_link` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO ask_link VALUES ('1','0','ask2问答系统','http://www.ask2.cn','ask2问答系统_高仿360问答系统','');

DROP TABLE IF EXISTS ask_login_auth;
CREATE TABLE `ask_login_auth` (
  `uid` int(10) NOT NULL,
  `type` enum('qq','sina') NOT NULL,
  `token` varchar(50) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_message;
CREATE TABLE `ask_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(15) NOT NULL DEFAULT '',
  `fromuid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `touid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '1',
  `subject` varchar(75) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `touid` (`touid`,`time`),
  KEY `fromuid` (`fromuid`,`time`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 AUTO_INCREMENT=133;

INSERT INTO ask_message VALUES ('132','ask2问答系统管理员','0','1','1','抱歉，您的问题帅哥问答的题标题标题由于长时间没有处理，现已过期关闭！','1467888493','您的问题帅哥问答的题标题标题由于长时间没有处理，现已过期关闭！<br /> <a href=\"http://www.myrole.com/?q-599.html\">点击查看问题</a>','0');

DROP TABLE IF EXISTS ask_nav;
CREATE TABLE `ask_nav` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `title` char(255) NOT NULL,
  `url` char(255) NOT NULL,
  `target` tinyint(1) NOT NULL DEFAULT '0',
  `available` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `displayorder` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 AUTO_INCREMENT=15;

INSERT INTO ask_nav VALUES ('1','问答首页','问答首页','index/default','0','1','1','0');
INSERT INTO ask_nav VALUES ('2','问答动态','问答动态','doing/default','0','1','1','1');
INSERT INTO ask_nav VALUES ('3','问题库','分类大全','category/view/all','0','1','1','2');
INSERT INTO ask_nav VALUES ('4','问答专家','问答专家','expert/default','0','1','1','3');
INSERT INTO ask_nav VALUES ('5','知识专题','知识专题','topic/default','0','1','1','4');
INSERT INTO ask_nav VALUES ('6','活跃用户','活跃用户','user/activelist','0','1','1','5');
INSERT INTO ask_nav VALUES ('7','财富商城','财富商城','gift/default','0','1','1','6');
INSERT INTO ask_nav VALUES ('8','站内公告','站内公告','note/list','0','1','1','7');
INSERT INTO ask_nav VALUES ('11','源码下载','','http://www.ask2.cn/download/default.html','0','1','2','0');
INSERT INTO ask_nav VALUES ('10','问答咨询','','c-17','0','1','1','9');
INSERT INTO ask_nav VALUES ('12','百度知道','','http://zhidao.baidu.com','0','1','2','0');
INSERT INTO ask_nav VALUES ('13','五笔吧','','http://www.wubiba.com','0','1','2','0');
INSERT INTO ask_nav VALUES ('14','情感问答网','','http://zixun.ask2.cn','0','1','2','0');

DROP TABLE IF EXISTS ask_note;
CREATE TABLE `ask_note` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `authorid` int(10) NOT NULL DEFAULT '0',
  `author` char(18) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` int(10) NOT NULL DEFAULT '0',
  `views` int(10) NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;

INSERT INTO ask_note VALUES ('1','1','admin','ask2问答平台开发公告（重要)','<p>目前整套系统高仿360问答，系统自带360问答采集，能快速采集目标网站用户信息还有回答，目前处于研发阶段，预计3月底出一版。</p>','1452144046','0','20','');
INSERT INTO ask_note VALUES ('2','1','admin','ask2问答系统2016年1月19日升级','<p><img src=\"http://www.ask2.cn/data/attach/1601/L5ou07vJ.png\" title=\"首页.png\"/></p><p>首页没有登录将展示热点问题，登录了就展示用户个人信息</p>','1453170334','0','47','');

DROP TABLE IF EXISTS ask_note_comment;
CREATE TABLE `ask_note_comment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `noteid` int(10) NOT NULL,
  `authorid` int(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_question;
CREATE TABLE `ask_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid1` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid2` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cid3` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` smallint(6) unsigned NOT NULL DEFAULT '0',
  `author` char(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `description` text NOT NULL,
  `supply` text NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `answers` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attentions` int(10) NOT NULL DEFAULT '0',
  `goods` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ipåœ°å€',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cid1` (`cid1`),
  KEY `cid2` (`cid2`),
  KEY `cid3` (`cid3`),
  KEY `time` (`time`),
  KEY `price` (`price`),
  KEY `answers` (`answers`),
  KEY `authorid` (`authorid`)
) ENGINE=MyISAM AUTO_INCREMENT=609 DEFAULT CHARSET=utf8 AUTO_INCREMENT=609;

INSERT INTO ask_question VALUES ('575','22','22','0','0','84','admin','1','我已经被安徽建工技师学院录取了，还可以在网上填报志愿吗','<div class=\"q-cnt\">如果在网上填报志愿被别的学校录取了，那是不是不用管安徽建工技师学院的录取通知书了</div>','','1467782344','1467783003','0','1','0','0','2','127.0.0.1','198');
INSERT INTO ask_question VALUES ('576','22','22','0','0','22','admin','1','今年芜湖七中分数线','<div class=\"q-cnt\">芜湖七中分数线会涨么 普通班</div>','','1467781026','1467783005','0','2','2','0','2','127.0.0.1','108');
INSERT INTO ask_question VALUES ('577','22','22','0','0','44','匿名网友','727','安徽今年理科326分可以上安徽那里学校','','','1467780368','1467783007','0','2','2','0','2','127.0.0.1','29');
INSERT INTO ask_question VALUES ('578','22','22','0','0','11','匿名网友','727','汉语言文学专业晓庄学院和安徽师范学院哪个好啊?','<div class=\"q-cnt\">江苏考生，一本差6分，将来或者当小学老师或者从事文字工作，在纠结报哪所学校好</div>','','1467781961','1472965961','0','2','0','0','1','127.0.0.1','118');
INSERT INTO ask_question VALUES ('579','22','22','0','0','86','admin','1','金寨县文化馆图书室要搬哪里去？','','','1467780763','1467783042','0','1','1','0','2','127.0.0.1','178');
INSERT INTO ask_question VALUES ('580','22','22','0','0','54','glw205','729','2016年合肥高职需多少分','<div class=\"q-cnt\">2016年合肥高职需多少分</div>','','1467781065','1467783044','0','1','3','0','2','127.0.0.1','157');
INSERT INTO ask_question VALUES ('581','22','22','0','0','43','','726','马鞍山现在的中考录取分数线是不是在逐年增高啊','','','1467780527','1467783045','0','1','4','0','2','127.0.0.1','51');
INSERT INTO ask_question VALUES ('582','22','22','0','0','17','匿名网友','727','安徽的一个女的通过微信破坏了一个幸福的家庭 我作为一个儿子该怎不办？？我不想我爸妈离婚','','','1467780288','1472964288','0','4','2','0','1','127.0.0.1','153');
INSERT INTO ask_question VALUES ('583','22','22','0','0','63','匿名网友','727','今年安徽高中分数线','<div class=\"q-cnt\">分数线会提高么</div>','','1467779630','1472963630','0','1','3','0','1','127.0.0.1','133');
INSERT INTO ask_question VALUES ('584','22','22','0','0','60','','726','合肥学院国际汉语教育专业学生就业如何？大部分都能去韩国吗？','<div class=\"q-cnt\">合肥学院国际汉语教育专业学生就业如何？大部分都能去韩国吗？</div>','','1467779632','1472963632','0','2','2','0','1','127.0.0.1','207');
INSERT INTO ask_question VALUES ('585','22','22','0','0','82','f01205','730','芜湖七中普通班分数线会上涨么','<div class=\"q-cnt\">芜湖七中普通班分数线会上涨么</div>','','1467780594','1472964594','0','1','4','0','1','127.0.0.1','128');
INSERT INTO ask_question VALUES ('586','22','22','0','0','7','','726','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','','','1467782216','1472966216','0','11','4','0','1','127.0.0.1','217');
INSERT INTO ask_question VALUES ('587','22','22','0','0','74','cjbzd','731','请问一下，安徽合肥医学高等专科学院有中专证书可以去读吗','<div class=\"q-cnt\">安徽合肥医科高等专科学院有中专证书可以去读吗</div>','','1467781380','1467783058','0','1','4','0','2','127.0.0.1','74');
INSERT INTO ask_question VALUES ('588','22','22','0','0','53','懒惰赖床的小兵','742','六安裕安区交通大夏在哪？','','','1467781201','1467783060','0','1','3','0','2','127.0.0.1','46');
INSERT INTO ask_question VALUES ('589','22','22','0','0','43','f01205','730','腾讯智汇推在合肥的哪家代理公司做的比较好','<div class=\"q-cnt\"><p>听说智汇推的效果不错，合肥这边哪家代理公司做的比较好，求推荐！</p></div>','','1467780063','1467783062','0','1','5','0','2','127.0.0.1','129');
INSERT INTO ask_question VALUES ('590','22','22','0','0','0','admin','1','小习出席人大代表，真事，吗？','<p>小习长得帅<br/></p>','','1467876119','1473060119','0','0','0','0','1','127.0.0.1','1');
INSERT INTO ask_question VALUES ('591','22','22','0','0','0','admin','1','中国话好学吗','<p>狗日的中国话</p>','','1467878024','1473062024','0','0','0','0','1','127.0.0.1','1');
INSERT INTO ask_question VALUES ('592','1','0','0','0','10','admin','1','标题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('593','1','0','0','0','10','admin','1','不隆胸，我能得到幸福吗?','题主本科在读，21岁，胸部一直未发育（真的是非常平的那种）。表面上与其他女生没什么不同（穿了胸罩撑A cup ，里面其实是空的）但心里面还是很自卑的。有过两任男友，都是关系亲密到一定程度的时候我就提出分手，因为害怕被发现。。。随着年纪增长自卑感越来越强，现在的状况可以用痛苦来形容……<br><br>虽然如此，但还是不愿意隆胸，一方面担心隆胸有可能带来的风险，另一方面认为这样的自己也可以有幸福，是不是太天真了？','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('594','1','0','0','0','10','admin','1','麦格、娜绮丽、曼托、妙桃、娜高、ES，哪种假体隆胸最好？','手感最好的是哪个？他们分别有什么优缺点呢？','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('595','23','0','0','0','10','admin','1','标题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('596','22','0','0','0','10','admin','1','标题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('597','22','0','0','0','10','admin','1','标66题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','10');
INSERT INTO ask_question VALUES ('598','22','0','0','0','10','admin','1','问答的题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','1','192.168.1.1','11');
INSERT INTO ask_question VALUES ('599','22','0','0','0','10','admin','1','帅哥问答的题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','','1409637582','1414821582','1','0','0','0','9','192.168.1.1','11');
INSERT INTO ask_question VALUES ('604','22','22','0','0','87','jjjjjj','744','月子里还差两天，可以洗头发洗澡吗？求解','','','1470286902','1470290441','0','3','3','0','2','127.0.0.1','55');
INSERT INTO ask_question VALUES ('603','22','22','0','0','11','宝妹儿妈z','746','怎样给新生儿洗头发，求高招','','','1470287920','1475471920','0','1','6','0','1','127.0.0.1','84');
INSERT INTO ask_question VALUES ('602','24','24','0','0','49','zhouchangyi','735','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','','','1470286900','1475470900','0','5','5','0','1','127.0.0.1','127');
INSERT INTO ask_question VALUES ('605','23','23','0','0','0','admin','1','fffffffddddddddddddd','<h1><span style=\"font-size: 12px;\">[键入文档标题][键入文档副标题][标题 1]对于“插入”选项卡上的库，在设计时都充分考虑了其中</span></h1><p style=\"line-height: 16px;\"><img src=\"http://www.myrole.com/js/neweditor/dialogs/attachment/fileTypeImages/icon_doc.gif\"/><span style=\"color: rgb(0, 102, 204); font-size: 12px; text-decoration: underline;\"><a style=\"color: rgb(0, 102, 204); font-size: 12px; text-decoration: underline;\" href=\"/ueditor/php/upload/file/20160830/1472540522112037.docx\" title=\"1472540522112037.docx\">1472540522112037.docx</a></span></p><pre class=\"brush:js;toolbar:false\">var&nbsp;a=4;\r\nalert(a);</pre><h1><span style=\"font-size: 12px;\">的项与文档整体外观的协调性。 您可</span></h1><h1><span style=\"font-size: 12px;\"><img width=\"530\" height=\"340\" src=\"http://api.map.baidu.com/staticimage?center=116.424512,39.928416&zoom=13&width=530&height=340&markers=116.424512,39.928416\"/></span></h1><h1><span style=\"font-size: 12px;\">以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。[标题 2]在“开始”选项卡上，通过从快速样式库1472540522112037.docx中为所选文本选择一种外观，您可以方便地更改文档中所选文本的格式。 您还可以使用“开始”选项卡上的其他控件来直接设置文本格式。大多数控件都允许您选择是使用当前主题外观，还是使用某种直接指定的格式。[标题 3]var&nbsp;a=3;\r\nconsole.log(a);\r\nalert(&quot;fffff&quot;);对于“插入”选项卡上的库，在设计时都充分考虑了其中的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。<br/></span></h1><p><img src=\"http://img.baidu.com/hi/jx2/j_0024.gif\"/></p><p><br/></p><p><br/></p>','','1472540673','1477724673','0','0','1','0','1','127.0.0.1','9');
INSERT INTO ask_question VALUES ('606','24','24','0','0','0','admin','1','dedddddddddddddddddddd','咨询描述:[键入文档标题][键入文档副标题][标题 1]对于“插入”选项卡上的库，在设计时都充分考虑了其中1472540522112037.docxvar&nbsp;a=4;\r\nalert(a);的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。[标题 2]在“开始”选项卡上，通过从快速样式库1472540522112037.docx中为所选文本选择一种外观，您可以方便地更改文档中所选文本的格式。 您还可以使用“开始”选项卡上的其他控件来直接设置文本格式。大多数控件都允许您选择是使用当前主题外观，还是使用某种直接指定的格式。[标题 3]var&nbsp;a=3; console.log(a); alert(&quot;fffff&quot;);对于“插入”选项卡上的库，在设计时都充分考虑了其中的项与文档整体外观的协调性。 您可以使用这些库来插入表格、页眉、页脚、列表、封面以及其他文档构建基块。 您创建的图片、图表或关系图也将与当前的文档外观协调一致。','','1472541423','1477725423','0','0','1','0','1','127.0.0.1','1');
INSERT INTO ask_question VALUES ('607','23','23','0','0','0','admin','1','dddddddddddddddddddddd','<p>dddddddddddddddddddd<img width=\"530\" height=\"340\" src=\"http://api.map.baidu.com/staticimage?center=116.404,39.915&zoom=10&width=530&height=340&markers=116.404,39.915\"/></p><pre class=\"brush:php;toolbar:false\">$a=9;\r\n$b=10;\r\n$c=$a+$b;\r\necho&nbsp;$c;</pre><p><br/></p><p><img src=\"/ueditor/php/upload/image/20160830/1472540480432813.png\"/></p><p><img src=\"/ueditor/php/upload/image/20160830/1472540426115622.jpg\"/></p><p><br/></p><p><img src=\"http://img.baidu.com/hi/jx2/j_0060.gif\"/></p><p>ggggggggggggggggggggg</p><p><br/></p>','','1472541763','1477725763','0','0','1','0','1','127.0.0.1','1');
INSERT INTO ask_question VALUES ('608','24','24','0','0','0','admin','1','ffffddddddddddddddddddddd','<p><br/>\r\n &nbsp;alert(&quot;ffffff&quot;);</p>','','1472546460','1477730460','0','0','1','0','1','127.0.0.1','1');

DROP TABLE IF EXISTS ask_question_attention;
CREATE TABLE `ask_question_attention` (
  `qid` int(10) NOT NULL,
  `followerid` int(10) NOT NULL,
  `follower` char(18) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`qid`,`followerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ask_question_attention VALUES ('576','1','admin','1467783005');
INSERT INTO ask_question_attention VALUES ('576','726','','1467783005');
INSERT INTO ask_question_attention VALUES ('577','1','admin','1467783007');
INSERT INTO ask_question_attention VALUES ('577','726','','1467783007');
INSERT INTO ask_question_attention VALUES ('579','727','匿名网友','1467783042');
INSERT INTO ask_question_attention VALUES ('580','729','glw205','1467783044');
INSERT INTO ask_question_attention VALUES ('580','726','','1467783044');
INSERT INTO ask_question_attention VALUES ('580','727','匿名网友','1467783044');
INSERT INTO ask_question_attention VALUES ('581','1','admin','1467783045');
INSERT INTO ask_question_attention VALUES ('581','726','','1467783045');
INSERT INTO ask_question_attention VALUES ('582','726','','1467783047');
INSERT INTO ask_question_attention VALUES ('581','728','艮本停不下来','1467783045');
INSERT INTO ask_question_attention VALUES ('581','729','glw205','1467783045');
INSERT INTO ask_question_attention VALUES ('582','728','艮本停不下来','1467783047');
INSERT INTO ask_question_attention VALUES ('583','732','YY2016小柒','1467783049');
INSERT INTO ask_question_attention VALUES ('583','731','cjbzd','1467783049');
INSERT INTO ask_question_attention VALUES ('583','730','f01205','1467783049');
INSERT INTO ask_question_attention VALUES ('584','731','cjbzd','1467783051');
INSERT INTO ask_question_attention VALUES ('584','1','admin','1467783051');
INSERT INTO ask_question_attention VALUES ('585','727','匿名网友','1467783053');
INSERT INTO ask_question_attention VALUES ('585','726','','1467783053');
INSERT INTO ask_question_attention VALUES ('585','1','admin','1467783053');
INSERT INTO ask_question_attention VALUES ('585','733','放手备战','1467783053');
INSERT INTO ask_question_attention VALUES ('586','733','放手备战','1467783055');
INSERT INTO ask_question_attention VALUES ('586','730','f01205','1467783055');
INSERT INTO ask_question_attention VALUES ('586','728','艮本停不下来','1467783055');
INSERT INTO ask_question_attention VALUES ('586','729','glw205','1467783055');
INSERT INTO ask_question_attention VALUES ('587','742','懒惰赖床的小兵','1467783058');
INSERT INTO ask_question_attention VALUES ('587','730','f01205','1467783058');
INSERT INTO ask_question_attention VALUES ('587','734','360U2699109498','1467783058');
INSERT INTO ask_question_attention VALUES ('587','728','艮本停不下来','1467783058');
INSERT INTO ask_question_attention VALUES ('588','738','惜若水三千','1467783060');
INSERT INTO ask_question_attention VALUES ('588','732','YY2016小柒','1467783060');
INSERT INTO ask_question_attention VALUES ('588','735','zhouchangyi','1467783060');
INSERT INTO ask_question_attention VALUES ('589','732','YY2016小柒','1467783062');
INSERT INTO ask_question_attention VALUES ('589','741','猫三七','1467783062');
INSERT INTO ask_question_attention VALUES ('589','735','zhouchangyi','1467783062');
INSERT INTO ask_question_attention VALUES ('589','730','f01205','1467783062');
INSERT INTO ask_question_attention VALUES ('589','738','惜若水三千','1467783062');
INSERT INTO ask_question_attention VALUES ('601','735','zhouchangyi','1470288982');
INSERT INTO ask_question_attention VALUES ('600','732','YY2016小柒','1470288981');
INSERT INTO ask_question_attention VALUES ('600','741','猫三七','1470288981');
INSERT INTO ask_question_attention VALUES ('600','731','cjbzd','1470288981');
INSERT INTO ask_question_attention VALUES ('600','738','惜若水三千','1470288981');
INSERT INTO ask_question_attention VALUES ('601','1','admin','1470288982');
INSERT INTO ask_question_attention VALUES ('601','743','ffffff','1470288982');
INSERT INTO ask_question_attention VALUES ('601','733','放手备战','1470288982');
INSERT INTO ask_question_attention VALUES ('601','738','惜若水三千','1470288982');
INSERT INTO ask_question_attention VALUES ('602','731','cjbzd','1470289599');
INSERT INTO ask_question_attention VALUES ('602','742','懒惰赖床的小兵','1470289599');
INSERT INTO ask_question_attention VALUES ('602','732','YY2016小柒','1470289599');
INSERT INTO ask_question_attention VALUES ('602','733','放手备战','1470289599');
INSERT INTO ask_question_attention VALUES ('602','740','我是樊磊','1470289599');
INSERT INTO ask_question_attention VALUES ('603','746','宝妹儿妈z','1470290439');
INSERT INTO ask_question_attention VALUES ('603','1','admin','1470290439');
INSERT INTO ask_question_attention VALUES ('603','739','该用户已诈尸矣','1470290439');
INSERT INTO ask_question_attention VALUES ('603','742','懒惰赖床的小兵','1470290439');
INSERT INTO ask_question_attention VALUES ('603','738','惜若水三千','1470290439');
INSERT INTO ask_question_attention VALUES ('603','735','zhouchangyi','1470290439');
INSERT INTO ask_question_attention VALUES ('604','742','懒惰赖床的小兵','1470290441');
INSERT INTO ask_question_attention VALUES ('604','736','唯我.杜康','1470290441');
INSERT INTO ask_question_attention VALUES ('604','746','宝妹儿妈z','1470290441');
INSERT INTO ask_question_attention VALUES ('605','1','admin','1472540673');
INSERT INTO ask_question_attention VALUES ('606','1','admin','1472541423');
INSERT INTO ask_question_attention VALUES ('607','1','admin','1472541763');
INSERT INTO ask_question_attention VALUES ('608','1','admin','1472546460');

DROP TABLE IF EXISTS ask_question_supply;
CREATE TABLE `ask_question_supply` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `qid` int(10) NOT NULL,
  `content` text NOT NULL,
  `time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `qid` (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


DROP TABLE IF EXISTS ask_question_tag;
CREATE TABLE `ask_question_tag` (
  `qid` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`,`name`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ask_question_tag VALUES ('575','填报志愿','1467783003');
INSERT INTO ask_question_tag VALUES ('575','安徽建工','1467783003');
INSERT INTO ask_question_tag VALUES ('575','技师','1467783003');
INSERT INTO ask_question_tag VALUES ('575','录取','1467783003');
INSERT INTO ask_question_tag VALUES ('575','网上','1467783003');
INSERT INTO ask_question_tag VALUES ('576','分数线','1467783005');
INSERT INTO ask_question_tag VALUES ('577','安徽','1467783007');
INSERT INTO ask_question_tag VALUES ('577','学校','1467783007');
INSERT INTO ask_question_tag VALUES ('578','汉语言文学','1467783040');
INSERT INTO ask_question_tag VALUES ('578','师范学院','1467783040');
INSERT INTO ask_question_tag VALUES ('578','晓庄学院','1467783040');
INSERT INTO ask_question_tag VALUES ('578','安徽','1467783040');
INSERT INTO ask_question_tag VALUES ('578','专业','1467783040');
INSERT INTO ask_question_tag VALUES ('579','金寨县','1467783042');
INSERT INTO ask_question_tag VALUES ('579','图书室','1467783042');
INSERT INTO ask_question_tag VALUES ('579','文化馆','1467783042');
INSERT INTO ask_question_tag VALUES ('580','高职','1467783044');
INSERT INTO ask_question_tag VALUES ('580','合肥','1467783044');
INSERT INTO ask_question_tag VALUES ('581','分数线','1467783045');
INSERT INTO ask_question_tag VALUES ('581','中考录取','1467783045');
INSERT INTO ask_question_tag VALUES ('581','马鞍山','1467783045');
INSERT INTO ask_question_tag VALUES ('582','安徽','1467783047');
INSERT INTO ask_question_tag VALUES ('583','分数线','1467783049');
INSERT INTO ask_question_tag VALUES ('583','安徽','1467783049');
INSERT INTO ask_question_tag VALUES ('583','高中','1467783049');
INSERT INTO ask_question_tag VALUES ('584','合肥学院','1467783051');
INSERT INTO ask_question_tag VALUES ('584','学生就业','1467783051');
INSERT INTO ask_question_tag VALUES ('584','韩国','1467783051');
INSERT INTO ask_question_tag VALUES ('584','汉语','1467783051');
INSERT INTO ask_question_tag VALUES ('584','国际','1467783051');
INSERT INTO ask_question_tag VALUES ('585','分数线','1467783053');
INSERT INTO ask_question_tag VALUES ('586','安徽高考','1467783055');
INSERT INTO ask_question_tag VALUES ('586','毕业生','1467783055');
INSERT INTO ask_question_tag VALUES ('586','微电子','1467783055');
INSERT INTO ask_question_tag VALUES ('586','想学','1467783055');
INSERT INTO ask_question_tag VALUES ('586','学校','1467783055');
INSERT INTO ask_question_tag VALUES ('587','专科学院','1467783058');
INSERT INTO ask_question_tag VALUES ('587','安徽','1467783058');
INSERT INTO ask_question_tag VALUES ('587','合肥','1467783058');
INSERT INTO ask_question_tag VALUES ('587','医学','1467783058');
INSERT INTO ask_question_tag VALUES ('587','证书','1467783058');
INSERT INTO ask_question_tag VALUES ('588','六安','1467783060');
INSERT INTO ask_question_tag VALUES ('589','腾讯','1467783062');
INSERT INTO ask_question_tag VALUES ('589','合肥','1467783062');
INSERT INTO ask_question_tag VALUES ('590','人大代表','1467876119');
INSERT INTO ask_question_tag VALUES ('591','中国话','1467878024');
INSERT INTO ask_question_tag VALUES ('603','新生儿','1470290439');
INSERT INTO ask_question_tag VALUES ('603','高招','1470290439');
INSERT INTO ask_question_tag VALUES ('604','头发','1470290441');

DROP TABLE IF EXISTS ask_recommend;
CREATE TABLE `ask_recommend` (
  `qid` int(10) unsigned NOT NULL DEFAULT '0',
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS ask_setting;
CREATE TABLE `ask_setting` (
  `k` varchar(32) NOT NULL DEFAULT '',
  `v` text NOT NULL,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ask_setting VALUES ('site_name','ask2问答系统');
INSERT INTO ask_setting VALUES ('meta_description','ask2问答系统');
INSERT INTO ask_setting VALUES ('meta_keywords','php问答系统,百度知道程序');
INSERT INTO ask_setting VALUES ('cookie_domain','');
INSERT INTO ask_setting VALUES ('cookie_pre','tp_');
INSERT INTO ask_setting VALUES ('seo_prefix','?');
INSERT INTO ask_setting VALUES ('seo_suffix','.html');
INSERT INTO ask_setting VALUES ('date_format','Y/m/d');
INSERT INTO ask_setting VALUES ('time_format','H:i');
INSERT INTO ask_setting VALUES ('time_offset','8');
INSERT INTO ask_setting VALUES ('time_diff','0');
INSERT INTO ask_setting VALUES ('site_icp','京ICP备15032243号-1');
INSERT INTO ask_setting VALUES ('site_statcode','');
INSERT INTO ask_setting VALUES ('xunsearch_open','0');
INSERT INTO ask_setting VALUES ('xunsearch_sdk_file','');
INSERT INTO ask_setting VALUES ('banner_color','#858c96');
INSERT INTO ask_setting VALUES ('banner_img','https://gss0.bdstatic.com/7051cy89RcgCncy6lo7D0j9wexYrbOWh7c50/zhidaoribao/2016/0710/top.jpg');
INSERT INTO ask_setting VALUES ('allow_register','1');
INSERT INTO ask_setting VALUES ('access_email','');
INSERT INTO ask_setting VALUES ('censor_email','');
INSERT INTO ask_setting VALUES ('censor_username','');
INSERT INTO ask_setting VALUES ('maildefault','vip@domain.com');
INSERT INTO ask_setting VALUES ('mailsend','1');
INSERT INTO ask_setting VALUES ('mailserver','smtp.domain.com');
INSERT INTO ask_setting VALUES ('mailport','25');
INSERT INTO ask_setting VALUES ('mailauth','0');
INSERT INTO ask_setting VALUES ('mailfrom','vip <vip@domain.com>');
INSERT INTO ask_setting VALUES ('mailauth_username','vip@domain.com');
INSERT INTO ask_setting VALUES ('mailauth_password','123456');
INSERT INTO ask_setting VALUES ('maildelimiter','0');
INSERT INTO ask_setting VALUES ('mailusername','1');
INSERT INTO ask_setting VALUES ('mailsilent','0');
INSERT INTO ask_setting VALUES ('credit1_register','20');
INSERT INTO ask_setting VALUES ('credit2_register','20');
INSERT INTO ask_setting VALUES ('credit1_login','2');
INSERT INTO ask_setting VALUES ('credit2_login','0');
INSERT INTO ask_setting VALUES ('credit1_ask','5');
INSERT INTO ask_setting VALUES ('credit2_ask','0');
INSERT INTO ask_setting VALUES ('credit1_answer','2');
INSERT INTO ask_setting VALUES ('credit2_answer','1');
INSERT INTO ask_setting VALUES ('credit1_message','-1');
INSERT INTO ask_setting VALUES ('credit2_message','0');
INSERT INTO ask_setting VALUES ('credit1_adopt','5');
INSERT INTO ask_setting VALUES ('credit2_adopt','2');
INSERT INTO ask_setting VALUES ('list_indexnosolve','10');
INSERT INTO ask_setting VALUES ('list_indexcommend','10');
INSERT INTO ask_setting VALUES ('list_indexreward','8');
INSERT INTO ask_setting VALUES ('list_indexnote','10');
INSERT INTO ask_setting VALUES ('list_indexhottag','20');
INSERT INTO ask_setting VALUES ('list_indexexpert','4');
INSERT INTO ask_setting VALUES ('list_indexallscore','8');
INSERT INTO ask_setting VALUES ('list_indexweekscore','8');
INSERT INTO ask_setting VALUES ('list_default','15');
INSERT INTO ask_setting VALUES ('rss_ttl','60');
INSERT INTO ask_setting VALUES ('code_register','0');
INSERT INTO ask_setting VALUES ('code_login','0');
INSERT INTO ask_setting VALUES ('code_ask','1');
INSERT INTO ask_setting VALUES ('code_message','1');
INSERT INTO ask_setting VALUES ('passport_type','0');
INSERT INTO ask_setting VALUES ('passport_open','0');
INSERT INTO ask_setting VALUES ('passport_key','');
INSERT INTO ask_setting VALUES ('passport_client','');
INSERT INTO ask_setting VALUES ('passport_server','');
INSERT INTO ask_setting VALUES ('passport_login','login.php');
INSERT INTO ask_setting VALUES ('passport_logout','login.php?action=quit');
INSERT INTO ask_setting VALUES ('passport_register','register.php');
INSERT INTO ask_setting VALUES ('passport_expire','3600');
INSERT INTO ask_setting VALUES ('passport_credit1','0');
INSERT INTO ask_setting VALUES ('passport_credit2','0');
INSERT INTO ask_setting VALUES ('overdue_days','60');
INSERT INTO ask_setting VALUES ('ucenter_open','0');
INSERT INTO ask_setting VALUES ('seo_on','0');
INSERT INTO ask_setting VALUES ('seo_title','');
INSERT INTO ask_setting VALUES ('seo_keywords','');
INSERT INTO ask_setting VALUES ('seo_description','');
INSERT INTO ask_setting VALUES ('seo_headers','');
INSERT INTO ask_setting VALUES ('notify_mail','0');
INSERT INTO ask_setting VALUES ('notify_message','1');
INSERT INTO ask_setting VALUES ('tpl_dir','zui');
INSERT INTO ask_setting VALUES ('verify_question','0');
INSERT INTO ask_setting VALUES ('index_life','0');
INSERT INTO ask_setting VALUES ('msgtpl','a:4:{i:0;a:2:{s:5:\"title\";s:36:\"您的问题{wtbt}有了新回答！\";s:7:\"content\";s:51:\"你在{wzmc}上的提出的问题有了新回答！\";}i:1;a:2:{s:5:\"title\";s:54:\"恭喜，您对问题{wtbt}的回答已经被采纳！\";s:7:\"content\";s:42:\"你在{wzmc}上的回答内容被采纳！\";}i:2;a:2:{s:5:\"title\";s:78:\"抱歉，您的问题{wtbt}由于长时间没有处理，现已过期关闭！\";s:7:\"content\";s:69:\"您的问题{wtbt}由于长时间没有处理，现已过期关闭！\";}i:3;a:2:{s:5:\"title\";s:42:\"您对{wtbt}的回答有了新的评分！\";s:7:\"content\";s:36:\"您的回答{hdnr}有了新评分！\";}}');
INSERT INTO ask_setting VALUES ('allow_outer','3');
INSERT INTO ask_setting VALUES ('stopcopy_on','0');
INSERT INTO ask_setting VALUES ('stopcopy_allowagent','webkit\r\nopera\r\nmsie\r\ncompatible\r\nbaiduspider\r\ngoogle\r\nsoso\r\nsogou\r\ngecko\r\nmozilla');
INSERT INTO ask_setting VALUES ('stopcopy_stopagent','');
INSERT INTO ask_setting VALUES ('stopcopy_maxnum','60');
INSERT INTO ask_setting VALUES ('editor_wordcount','false');
INSERT INTO ask_setting VALUES ('editor_elementpath','false');
INSERT INTO ask_setting VALUES ('editor_toolbars','bold,forecolor,insertimage,autotypeset,attachment,link,unlink,fontfamily,fontsize,insertvideo,kityformula,map,fullscreen');
INSERT INTO ask_setting VALUES ('gift_range','a:3:{i:0;s:2:\"50\";i:50;s:3:\"100\";i:100;s:3:\"300\";}');
INSERT INTO ask_setting VALUES ('usernamepre','ask_');
INSERT INTO ask_setting VALUES ('usercount','0');
INSERT INTO ask_setting VALUES ('sum_onlineuser_time','30');
INSERT INTO ask_setting VALUES ('sum_category_time','60');
INSERT INTO ask_setting VALUES ('del_tmp_crontab','1440');
INSERT INTO ask_setting VALUES ('allow_credit3','0');
INSERT INTO ask_setting VALUES ('apend_question_num','5');
INSERT INTO ask_setting VALUES ('time_friendly','1');
INSERT INTO ask_setting VALUES ('register_clause','');
INSERT INTO ask_setting VALUES ('tpl_wapdir','amazeuiwap');
INSERT INTO ask_setting VALUES ('wap_domain','');
INSERT INTO ask_setting VALUES ('auth_key','8BdS0M5Y5M1L6p8LdleedOcF0rb97Y6NfH9RatcOeV7Dd306c9e71Maq184j2Tew');
INSERT INTO ask_setting VALUES ('admin_email','webmaster@domain.com');
INSERT INTO ask_setting VALUES ('seo_index_title','php问答系统-ask2问答官网');
INSERT INTO ask_setting VALUES ('seo_index_keywords','php问答系统');
INSERT INTO ask_setting VALUES ('seo_index_description','php问答系统');
INSERT INTO ask_setting VALUES ('seo_question_title','');
INSERT INTO ask_setting VALUES ('seo_question_keywords','');
INSERT INTO ask_setting VALUES ('seo_question_description','');
INSERT INTO ask_setting VALUES ('seo_category_title','');
INSERT INTO ask_setting VALUES ('seo_category_keywords','');
INSERT INTO ask_setting VALUES ('seo_category_description','');
INSERT INTO ask_setting VALUES ('question_share','');
INSERT INTO ask_setting VALUES ('qqlogin_avatar','0');
INSERT INTO ask_setting VALUES ('site_alias','站点别名');
INSERT INTO ask_setting VALUES ('maxindex_keywords','4');
INSERT INTO ask_setting VALUES ('pagemaxindex_keywords','4');
INSERT INTO ask_setting VALUES ('openweixin','');
INSERT INTO ask_setting VALUES ('baidu_api',' http://data.zz.baidu.com/urls?site=www.ask2.cn&token=YuHZrBhWBcGeXkIL');
INSERT INTO ask_setting VALUES ('wxtoken','3546060ff4d14gab024g4200');
INSERT INTO ask_setting VALUES ('unword','主人，我不知道你要说什么。');
INSERT INTO ask_setting VALUES ('duoshuoname','');
INSERT INTO ask_setting VALUES ('zl_domain','zl.myrole.com');
INSERT INTO ask_setting VALUES ('allow_expert','0');
INSERT INTO ask_setting VALUES ('qqlogin_open','0');
INSERT INTO ask_setting VALUES ('qqlogin_appid','43243244');
INSERT INTO ask_setting VALUES ('qqlogin_key','fdsf');
INSERT INTO ask_setting VALUES ('site_logo','http://www.myrole.com/data/attach/logo/logo.png');
INSERT INTO ask_setting VALUES ('site_qrcode','');
INSERT INTO ask_setting VALUES ('register_on','0');
INSERT INTO ask_setting VALUES ('hot_on','0');
INSERT INTO ask_setting VALUES ('title_description','知名专家为您解答');
INSERT INTO ask_setting VALUES ('search_shownum','5');
INSERT INTO ask_setting VALUES ('search_placeholder','请输入关键词检索');
INSERT INTO ask_setting VALUES ('ucenter_url','');

DROP TABLE IF EXISTS ask_tid_qid;
CREATE TABLE `ask_tid_qid` (
  `tid` int(10) NOT NULL DEFAULT '0',
  `qid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`,`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_topic;
CREATE TABLE `ask_topic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `describtion` text,
  `image` varchar(100) DEFAULT NULL,
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `author` varchar(200) NOT NULL,
  `authorid` int(10) NOT NULL,
  `views` int(10) NOT NULL,
  `articleclassid` int(10) NOT NULL,
  `isphone` int(10) NOT NULL,
  `viewtime` int(10) unsigned NOT NULL,
  `ispc` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 AUTO_INCREMENT=56;

INSERT INTO ask_topic VALUES ('38','帅哥问答的题标题标题','内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容内容','http://www.myrole.com//caijiimage/get.jpg','0','cyx168','737','21','24','0','1468299519','0');
INSERT INTO ask_topic VALUES ('39','北京涉赌电玩城:庄家发钱请大户 有人输千万',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：回龙观暗藏赌博电玩城：发中华烟引诱赌客，高利贷现场放贷，有赌客输掉一千多万）\n                </p>\n                                <p class=\"f_center\"><img alt=\"回龙观暗藏赌博电玩城：发中华烟引诱赌客，高利贷现场放贷，有赌客输掉一千多万\" src=\"http://cms-bucket.nosdn.127.net/catchpic/2/26/26D1045EFBD06BFF5C7AE13536259910.jpg\" border=\"0\" /><br  />北京西五环园博园附近某个生产赌博机的厂家</p><p class=\"f_center\"><img alt=\"北京涉赌电玩城:庄家发钱请大户 有人输千万\" src=\"http://cms-bucket.nosdn.127.net/catchpic/5/50/509511C73A2B9A8B0A1B092FD0DBFD5B.jpg\" /><br  />几名男子坐在捕鱼机前，每把输赢至少数千元</p><p>“你看这层老茧。”陶礼伸出右手小拇指，关节处老茧有一角硬币大小</p><p>这是小拇指长时间点击“发射炮”所致，“几乎每一个打鱼的人都有”。</p><p>陶礼所说的“打鱼”是电玩城的捕鱼游戏，买币上分、退分，进行赌博。除了捕鱼机，这里还充斥着各种类型的押分机，同样是赌。</p><p>“一天输个十万八万是常事，人怎么能玩得过机器。”6年间，陶礼输了五六百万元，依然深陷其中。</p><p>在这个坐落于回龙观社区的电玩城内，每个玩家都能讲出几个某某输了几百上千万元的案例。</p><p>这是一个“畸形”的圈子，赌客、电玩城、赌博机生产厂商交织在一起。陶礼和其他赌客们明知有“套”，却不能自拔;电玩城为了赚钱，铤而走险，涉嫌违法;生产厂家为了销路，为买家提供稳赚不赔的赌博机器。</p><p>针对回龙观电玩城设置赌博游戏机并退币的情形，北京康达律师事务所律师韩骁表示，此电玩城已涉嫌赌博。</p><p>经营者为玩家提供场地、设备，并通过赌博机从中抽成，玩家输赢过万，属于涉案金额较大的违法犯罪行为，组织经营人员已涉嫌开设赌场罪。</p><p><strong>吃钱的“捕鱼机”</strong></p><p>6月27日晚10点，回龙观西大街北店时代广场大多数商家已关门打烊，D座四楼的永旺达电玩城依然人声嘈杂，随处都是低头“打鱼”的赌客。</p><p>100多平方米的游戏大厅，分布着8台捕鱼游戏机，如同磁铁一般吸引着玩家和看客。</p><p>一台捕鱼机前，坐满8位玩家，屏幕画面里充斥着各种鱼类，一会有一条“金龙”游过，玩家激动起来，握紧拳头狂砸发射键，不断爆粗口“还打不死”。也有玩家表情紧张，按住发射键不动。</p><p>只见满屏幕“子弹”乱飞，“金龙”依然不紧不慢地从头游到尾，彷佛“铁打的一样”。</p><p>没有打到一条龙，玩家们分数则瞬间由数十万分变成了几千分。</p><p>“你想啊，这个东西多块，按住不放，一分钟得发射多少炮，打出去的都是钱啊。”</p><p>为何打不到鱼，玩家依然疯狂“发炮”?</p><p>一名资深玩家解释，那可都是钱啊，不同的鱼倍数不一样，像龙、金龟、鳄鱼、“日本鬼子”都是大倍数分值，从一百多倍到五百多倍不等，打下一条就等于3000元到一万多元。</p><p>老赌客陶礼在这里输了上百万元，他每天泡在游戏大厅的时间多过于工作、睡觉。</p><p>“今天怎么样?”陶礼挤到一桌坐满玩家的捕鱼机前，打探输赢。</p><p>“输了两万三四了。”</p><p>“才过来不到一小时，输了一万多了。”</p><p>“我昨晚输了74000(元)，就打下来一条鳄鱼。”陶礼愤愤地说，在“四楼”，他一周输了18万。</p><p>陶礼介绍，电玩城的电子币分为200元和500元的两种，兑换成分之后分别为20000分和50000分。一般打鱼为1000分一炮，也就意味着玩家点一下10块钱没了。</p><p>除了大厅内的捕鱼机“吃钱”，隐藏在暗室的三台押分机更是无底洞。在这间约30平米的小房间内，三台押分机依次排开，有黑红梅方、奔驰宝马、猴子熊猫等。</p><p>一名玩家解释说，游戏机里的1分是1元钱，这台机器每次的最低下注额为10分，一个人最高可达5000分，最多10人同时在玩，下注额多达5万元。</p><p>距离永旺达电玩城50米的大厦二楼同样有一个电玩城。陶礼说，这里玩得更大。</p><p>一个月前，陶礼在二楼电玩城押分时，曾见过黑红梅方的押分机，一小时“杀”了赌客172万。“所有人都输，10个口坐满人，平均每个赌客一小时输17万。”</p><p><strong>设置暗室专供熟客赌博</strong></p><p>根据文化部、公安部等部门联合下发的《加强游艺娱乐场所管理的相关通知》规定，禁止设立任何形式的退分、退币等赌博功能的游戏设备，同时电子游戏机单次消费也不能超过4元，玩家每天总金额也不得超过200元。</p><p>据经营一家电玩城的老板介绍，算不算赌博，就看电玩城是否将玩家赢得的游戏币或者电子分退换成钱，如果警方没有证据证明游戏币(包括电子分)能退钱，那警方就拿电玩城一点办法都没有。所以很多涉赌的电玩城把消息封得很严，退钱也是在隐蔽处由专人进行。</p><p>6月28日，回龙观西大街某游戏机厅，游戏机厅的工作人员拿着pos机为一男子刷卡，男子充了数千元之后开始游戏。</p><p>回龙观西大街“四楼”和“二楼”的电玩城均设有暗室。如果没有熟人带路，均无法进入。</p><p>通往暗室的路上密布摄像头。“二楼”电玩城的暗室的门口，甚至有专人拿着对讲机看守。</p><p>游戏大厅内，每个陌生人的进入，都会引起工作人员警惕。因记者是生面孔，服务员紧盯不放，全程贴身跟随。有陌生玩家打开背包掏钱，服务员也会凑过来查看包内物品。</p><p>6月27日晚11点多，四楼大厅拐角处的打鱼机前，“黑红梅方”押分正进行得火热，一名20出头的玩家，连续压中两三把，机器的分数迅速升至5000多元。他当即表示要退分。</p><p>陶礼称，服务员随时可以通过遥控器将这台押分机切换到打鱼机，以防止有人来查。</p><p>当晚，多名玩家退分，一名服务员说，“大家等等，已经让人去‘二楼’拿钱了。”另一名服务员说，“两个电玩城是一个老板，四楼的先开业，已有多年。”</p><p>15分钟后，一名服务员挎着一个黑色电脑包回来，另一名服务员拿着一叠人民币将需要退分的人员喊到游戏厅外的过道，一分钟后，一名玩家面带喜色地从外面回来，手里攥着近万元人民币。</p><p>连续多日，每当有玩家退分，最后都被服务员叫到游戏厅外的过道，随后手里拿着钱回来。</p><p>“二楼”的大厅，服务员退分则更为大胆。当有玩家要求退分时，服务员直接将钱从吧台拿钱交易。</p><p>在押分的暗室里，一切都公开化，玩家上分、庄家退分都会直接给钱或存币卡。</p><p>7月5日晚10时30分许，四楼游戏厅暗室，一名三十多岁的玩家直接从包里掏出一千元给服务员上分，服务员拿着钥匙拧了一下，机器上出现了1000分，几分钟疯狂下注后，屏幕上仅剩200多分。</p><p><strong>庄家发钱请赌客入局</strong></p><p>陶礼心里明白，赌博游戏就是个深渊，最后只有庄家能赢。</p><p>陶礼2010年左右接触到“捕鱼机”，刚开始只是小打小闹，输赢几百块。之后，越玩越大，“控制不住了。”前两年为了还账，陶礼将北京的房子也卖了。</p><p>“打鱼”成了陶礼的生活。</p><p>他介绍，很多电玩城为了吸引赌客，会进行各种活动，并对重要客户进行重点“照顾”。</p><p>回龙观西大街某电玩城，一男子赌赢之后，工作人员将赌金交与该男子，男子称今天已经输了3万多。</p><p>“老板说给我办张会员卡，只要来，一天给200块钱，给包中华烟。”陶礼也明白，老板给钱就为增加人气，最后都会输回去。</p><p>陶礼见过一个一年输了4000万的玩家，是电玩城的VIP，吃喝拉撒全免费，累了免费去隔壁宾馆睡觉，电玩城一天免费给他500块钱和一包中华烟。</p><p>“你想啊，每天有人发钱，赌客想不来都难，但是攒了一个月，可能半小时就输了。”他说。</p><p>“在回龙观‘四楼’饮料免费喝，水果免费吃。”多名玩家说。每天晚上11点左右，服务员会拿着玉溪香烟按人头发，每人一包。</p><p>一名玩家边抽着烟边问服务员，“还是开这个挣钱啊。”服务员笑称，“这也不是谁都能开的，还得要关系硬。”</p><p>多名玩家称，“二楼”与“四楼”的老板是江西人，在北京拥有多家电玩城。连续多日，玩家在这里输的钱就有数十万。资深玩家称，“四楼”每天的流水多时可达百万元。</p><p>多名资深玩家透露，除了上述服务，很多电玩城，还会有返成，一是玩家输了钱，会按不同比例返还，比如说，有玩家输了4万，按20%的点返还，他就可以找老板要回8000元。还有就是玩家带“大户”过来玩，大户的输了钱，电玩城都按点返给带大户过来的人。</p><p>玩家们心里清楚，这些都是为了要吸引他们继续赌，不管返多少，最终还是会回到电玩城。</p><p>针对回龙观两处电玩城设置赌博游戏机并退币的情形，北京康达律师事务所律师韩骁表示，此电玩城已涉嫌赌博。</p><p>韩骁称，经营者为玩家提供场地、设备，并通过赌博机从中抽成，玩家输赢过万，属于涉案金额较大的违法犯罪行为，组织经营人员涉嫌开设赌场罪。</p><p>6月28日，回龙观西大街某电玩城，游戏机厅有内室，内室里外都有监控。</p><p>对于相关玩家，韩骁认为，玩家同样违法，根据《治安管理处罚条例》，警方可对参赌人员进行行政拘留，并处相应罚金。</p><p><strong>高利贷活跃的“赌博圈”</strong></p><p>与机器拼，最后都会血本无归。</p><p>6月28日，回龙观西大街某电玩城，几名男子正坐在赌博机前。</p><p>疯狂的时候，连续一周，陶礼吃住在电玩城。“就一直打鱼，饿了有吃的，困了就到边上的沙发眯一会儿。”</p><p>此前陶礼有一份正经的工作，平时做点淘宝小生意，“现在都没了”。在“四楼”电玩城，他将车抵押出去，借了两万元的高利贷，每天600元利息。</p><p>多名玩家都借过高利贷，他们称，在电玩城内可轻易找到放高利贷者，平时都在“二楼”待着，如果“四楼”有人想借钱，通过吧台联系，他们会直接过来。</p><p>四楼一名玩家说，最近半年时间内，自己已输了三四百万元。7月5日一天，他输了三万多元。坐在捕鱼机旁，他感慨，“我这一小时输的，就是工地上工人一年的血汗钱。”</p><p>凡有玩家在其身边押分，他都劝解大家千万别沾赌博机，“有钱的输掉生活，换做工薪阶层就是倾家荡产”。</p><p>陶礼也曾后悔赌博。这些年，回龙观的电玩城只是他玩过众多游戏厅中的一处，也见惯了男女赌客们，输钱了砸机器的、跳楼的都有。</p><p>一个月之前，陶礼在回龙观“二楼”打鱼，一名赌客的妻子找到游戏厅闹着要跳楼。“男的因为打鱼输钱，将车抵押给了高利贷，直到还不起。后来，经过协调，电玩城老板帮赌客还了利息。“他也不想出事，谁让钱都输给了电玩城。”</p><p>还有一次在“四楼”，一位女赌客半小时输了两三万，直接把打鱼的机器砸了。隔天，又像平常一样过来打鱼。</p><p>30多岁的李飞(化名)也因“打鱼”赔上了全部身家。</p><p>2012年，李飞被朋友带过来打鱼，第一次赢了一万块。之后的四年多，他不再有第一次的好运气，连续输钱。</p><p>当时带他“下海”的哥们，已经输得不见踪影。“他有一千多万，两套房子，赌博后都输光了。”李飞说。</p><p>李飞回忆，“最后他在电玩城，都是蹭到别人边上，笑脸说‘兄弟，借个币玩玩呗’，谁能想到这曾经是千万资产的人?”</p><p><strong>机器控输赢，玩家必输</strong></p><p>“庄家的稳赚不赔，输赢可事先预设。”多名游戏机厂家老板明确表示他们可以调控捕鱼机的难度及输赢，能保证庄家每次抽成比例，剩下的则由玩家“自相残杀”。</p><p>在北京西五环园博园附近就隐蔽着这样一家赌博机生产厂家。</p><p>该厂为一处民宅，工作人员打开大门后，院子内堆放有五六台捕鱼机和押分机，还有两台正在安装的捕鱼机外壳。</p><p>老板介绍，一台捕鱼机价格1.1万元左右，扑克牌游戏机2.4万左右，“保证你赚钱，不赚钱，我们的机器谁来买。”</p><p>据老板透露，2006年开始，这家不挂牌的小厂就开始生产这种带有赌博性质的游戏机，市场面向全北京。10年间，捕鱼机卖出去了有4000多台，押分机有1000多台。</p><p>“这种机器一般买回去都是用于赌博，一次拿两三台的比较多。”老板称，因涉嫌赌博，大多数买家都是买回去赚到钱就跑路。</p><p>一般捕鱼机的盈利点都设置在20%-40%左右。老板表示，盈利点再高就没有人玩了，低了也没什么赚头。“我们只为买家考虑，至于玩家谁赢谁输，跟我们没有关系。”</p><p>广州一赌博机生产厂家老板称，目前市面上出现的打鱼机，以及押梅花红方押分机、百家乐等机器公司都有。可以作弊的机器销售火爆，电玩城可以随意调控输赢。</p><p><!-- AD200x300_2 -->\n\n <p>赌博机厂家程序员介绍，调控主要是针对游戏机的打码器，比如捕鱼机，可以为最容易、容易、困难、死难。机器调控为死难后，玩家很难赢，庄家从玩家押注金额中抽成25%，“玩家押注5万元，庄家就能抽一万多。”</p><p>同样，“死难”之上，通过打码器依然可以再升高抽水率，“只要将你想一天抽多少钱，用打码器输进去，机器就会自动抽水。”</p><p>甚至庄家想控制谁输谁赢，机器也能做到。程序员透露，每一台作弊机都装有电话口跟手机绑定，通常业内叫“短信猫”。如同信号接收器一样，庄家只需通过手机发短信发给赌博机的电话口，想让谁输谁就输。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/2/26/26D1045EFBD06BFF5C7AE13536259910.jpg','0','YY2016小柒','732','7','24','0','1468299583','0');
INSERT INTO ask_topic VALUES ('40','莆田被淹网友称报应 媒体:暴戾思维猛于暴雨洪水',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：莆田被淹有网友称是报应，中青报刊文：暴戾思维猛于暴雨洪水）\n                </p>\n                                <p class=\"f_center\"><img alt=\"莆田被淹网友称报应 媒体:暴戾思维猛于暴雨洪水\" src=\"http://cms-bucket.nosdn.127.net/catchpic/B/B5/B54BD4CEA41459FC12099C15F8140B29.jpg\" height=\"379\" width=\"600\" /><br  />2016年7月9日，福建莆田，新度镇凌厝村，一个村民在积水的街道上艰难骑行</p><p class=\"f_center\"><img alt=\"莆田被淹网友称报应 媒体:暴戾思维猛于暴雨洪水\" src=\"http://cms-bucket.nosdn.127.net/catchpic/4/47/47691A064F1C3488ED7044B5E3A33589.jpg\" height=\"380\" width=\"600\" /><br  />2016年7月9日，福建莆田，新度镇凌厝村，多处房屋因暴雨冲刷而倒塌。</p><p>中国青年报7月12日消息，福建莆田遭遇了特大暴雨袭击，车辆被淹、住宅倒塌。与以往任何一则灾难新闻不同的是，网络评论不只是忧虑与牵挂，还夹杂着十分刺耳的声音——“这就是报应”“把莆田全淹了吧”。读到这些诅咒，让人感觉一阵寒意。</p><p>饱受洪水侵袭的无辜百姓，和那些民营医疗“莆田系”利益集团完全是两回事。莆田的暴雨，只是一场因台风而起的自然灾害，这些不必费力解释的道理，具备起码智识的人都不难判断。自认为义愤，动辄放言杀光、死光，不是正义，是典型的暴戾思维。</p><p>暴戾思维时常伴随着对正义的幻觉。是的，那些事故频发、资质不全的医疗机构很可恨，打着消除病痛的幌子骗人钱财，我们难免对身陷其中的患者心生同情。但是，那些被洪水冲垮的房屋，不是莆田系的作恶场，而是老实巴交农民的家；那些被雨水泡烂的店铺，不是莆田系的摇钱树，而是普通人赖以糊口的饭碗。</p><p>灾祸考验一个地方的应急能力，对灾祸的反应，考验的却是社会的善意与良知。暴雨洪水虽冲垮了房屋与良田，终有退去之日，但暴戾思维所注入的恶意，很难随灾祸的远去而稀释。</p><p><!-- AD200x300_2 -->\n\n <p>晚上再打开微博，那些面露兴奋的诅咒之词，已经淹没在网友的训斥中，很多人灰溜溜地改了昵称、删了评论。但是不久之后，他们很可能改头换面，又要杀死这个、灭绝那个。偌大的网络空间，总有一个阴暗潮湿的角落，可以安放幽暗的人性和暴戾的思维。</p><p>由此想起一则故事：有位先生给学生出了一道题：谁能用不多的钱买一件东西，把房子装满？有的买了稻草，有的买了树苗，都没成功。唯有一个学生，买了支蜡烛，点燃后，烛光填满了整个屋子。</p><p>我们很难用有限的言辞和精力，来驱逐每一分暴戾。这个故事告诉我，与其絮絮叨叨地说理、怒气冲天地回骂，不如让理性的火焰攒聚起来，照亮每一个潮湿幽暗的角落，让刻薄、冷血的言辞无法寄生、无从滋长、无处遁形。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/B/B5/B54BD4CEA41459FC12099C15F8140B29.jpg','0','惜若水三千','738','4','24','0','1468299584','0');
INSERT INTO ask_topic VALUES ('41','女学生手机落快车上 司机交还要走200元:劳动所得',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：女学生手机落快车上 司机交还要走200元:劳动所得）\n                </p>\n                                <div class=\"original-tit\" style=\"border: 0px; margin: 0px; padding: 0px 0px 0px 28px; line-height: 24px; color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; text-align: start;\"><br  /></div><sohuadcode style=\"color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; font-size: 12px; line-height: 14px; text-align: start;\"></sohuadcode><span style=\"color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; font-size: 12px; line-height: 14px; text-align: start;\"></span><span style=\"color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; font-size: 12px; line-height: 14px; text-align: start;\"></span><div class=\"text clear\" id=\"contentText\" style=\"border: 0px; margin: 0px auto 24px; padding: 0px; zoom: 1; line-height: 26px; color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; text-align: start;\"><div itemprop=\"articleBody\" style=\"border: 0px; margin: 0px; padding: 0px;\"><div align=\"center\" style=\"border: 0px; margin: 0px; padding: 0px;\"><img src=\"http://cms-bucket.nosdn.127.net/catchpic/C/CE/CE84957F5D234661997376BDA72A6893.jpeg\" alt=\"楚天都市报7月11日讯（记者刘孝斌 王永胜 实习生肖慧婷）今日，女大学生小陶乘坐快车，将一部苹果手机忘在车上。她去拿回手机时，却被司机索要200元费用。小陶对此不认同，而司机称自己付出了成本，应该收钱。\" align=\"middle\" border=\"1\" class=\"flag_bigP\" style=\"border: 0px; margin: 0px; padding: 0px; font-size: 0px; color: transparent;\" /><br  />快车使用截图<div class=\"conserve-photo\" picurl=\"http://cms-bucket.nosdn.127.net/catchpic/C/CE/CE84957F5D234661997376BDA72A6893.jpeg\" style=\"border: 0px; margin: 0px; padding: 0px; width: 105px; height: 29px; cursor: pointer; position: absolute; right: 20px; border-radius: 3px; top: 1088px; left: 871.5px; background: url(&quot;images/saveBtn.png&quot;) no-repeat;\"><div class=\"comCount\" style=\"border: 0px; margin: 0px; padding: 0px; font-size: 11px; width: 76px; height: 12px; position: absolute; top: 18px; right: 0px; font-stretch: normal; line-height: 12px; font-family: 宋体; color: white;\">1</div></div></div><p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">7月11日，女大学生小陶乘坐快车，将一部苹果手机忘在车上。她去拿回手机时，却被司机索要200元费用。小陶对此不认同，而司机称自己付出了成本，应该收钱。</p><p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">小陶介绍，今日上午9时50分许，她和朋友叫了一辆快车，从东西湖区园艺小区到中心广场小区附近。下车时，她本人的一部苹果5S手机落在车上。发现后，她给司机杨师傅打了几个电话，要求归还手机，但是对方暗示要给报酬。</p><p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">小陶称，后来双方见面后，她说可否买点烟或者给点其它东西，杨师傅没同意，最后她给了200元钱才将手机拿回。</p><p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">司机杨师傅称，小陶两人上车后均坐在后排。两人下车后，他马上又带上一个乘客。接到小陶电话时，他已经带上乘客发车，不好下车去找，路上也没有听到后排有手机响，就说将乘客送到后再找。但是，小陶给他打了几个电话，带着质疑和责怪的语气，并称要报警。“我感觉对自己是一种污辱，感觉是我要吞掉她的手机。”杨师傅称，他将乘客送到后，在后排座位下找到了手机。</p><p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">杨师傅说，他是靠跑车获得运营收入，来回跑有成本，收费200元并不过分。他还介绍，事后他还收到几条带有辱骂性质的短信。</p><p><!-- AD200x300_2 -->\n\n <p style=\"border: 0px; margin: 0px; padding: 26px 0px 0px; color: rgb(0, 0, 0);\">湖北省社科院社会研究所所长冯桂林教授表示，不管是乘客还是司机都要讲文明，说话、做事要互相体谅对方，不要使用不文明或者情绪化的语言。司机靠开车谋生，司机并未将手机私藏不还，可收取适当成本费用，具体给多少双方可以协商。</p></div></div><div class=\"original-title\" style=\"border: 0px; margin: 0px auto 13px; padding: 0px; line-height: 20px; height: 37px; overflow: hidden; color: rgb(51, 51, 51); font-family: 宋体, simsun, sans-serif, Arial; text-align: start; background-image: url(&quot;images/bg_line.gif&quot;); background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: 0px 36px; background-repeat: repeat-x;\"></div>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/C/CE/CE84957F5D234661997376BDA72A6893.jpeg','0','猫三七','741','12','24','0','1468299585','0');
INSERT INTO ask_topic VALUES ('42','15岁\"司机\"在沪驾车撞伤行人 且涉嫌酒驾',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：15岁“司机”在沪驾车撞伤行人，还涉嫌酒驾）\n                </p>\n                                <p>我国法律明确规定，年满18周岁才能取得机动车驾驶资格证。7月10日下午，在上海闵行华漕地区发生一起交通事故，撞伤人的“司机”不但醉酒驾驶，而且今年才刚满15岁。</p><p class=\"f_center\"><img alt=\"15岁“司机”在沪驾车撞伤行人 且涉嫌酒驾\" src=\"http://cms-bucket.nosdn.127.net/catchpic/2/27/27FE31D627F4ABF2DFAE8AA6B4E3B854.jpg\" width=\"592\" height=\"396\" /><br  />肇事车</p><p class=\"f_center\"><img alt=\"15岁“司机”在沪驾车撞伤行人 且涉嫌酒驾\" src=\"http://cms-bucket.nosdn.127.net/catchpic/4/42/420E8B28913F06796A8B315B72C11A57.jpg\" width=\"592\" height=\"451\" /><br  />肇事者</p><p class=\"f_center\"><img alt=\"15岁“司机”在沪驾车撞伤行人 且涉嫌酒驾\" src=\"http://cms-bucket.nosdn.127.net/catchpic/5/5D/5DC16392C0AC354C733840888D529619.jpg\" width=\"544\" height=\"337\" /><br  />视频截图</p><p><!-- AD200x300_2 -->\n\n <p>监控画面显示，当日13点43分，在闵行区纪翟路纪川路口，一辆外牌白色起亚小轿车由北向南直行的时候，突然内道超车撞倒正在路口由西向东通行的行人韩某，致使韩某头部受伤倒地。民警到达事故现场调查时，肇事司机却拿不出驾驶证。</p><p>经过调查，民警发现司机小吴不仅未满16周岁，事发时还涉嫌酒驾。闵行交警一中队民警李强表示，小吴的酒精检测含量达到0.82（毫克），是醉酒驾车。</p><p>警方表示，由于小吴未满16周岁不能追究其刑事责任，将责令他的家长或者监护人加以管教，并进行事故赔偿。</p><p><br  /></p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/2/27/27FE31D627F4ABF2DFAE8AA6B4E3B854.jpg','0','admin','1','7','24','0','1468299585','0');
INSERT INTO ask_topic VALUES ('43','六旬老夫妻想孙子 连续3年通过报纸送生日祝福',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：六旬老夫妻想孙子 连续3年通过报纸送生日祝福）\n                </p>\n                                <p>昨天，一对年过六旬的老夫妻致电本报市民热线，想通过晚报《我要说》送给三周岁的孙子一份特殊的生日礼物。</p><p>从2014年开始，每年的7月10日，这对老夫妻都会如期来电，以这种特殊的方式给“见不到”的孙子送上祝福。</p><p><strong>珍藏当天的《厦门晚报》</strong></p><p><strong>等孩子长大后给他看</strong></p><p>这对老夫妻说，虽然孙子生活在厦门，儿子和儿媳妇把孙子照顾得很好。但是，出于一些原因，他们暂时见不到孙子，因此特别想念。每年的7月11日，如果能如愿在晚报《我要说》上发出爷爷奶奶对孙子的祝福，他们就很知足了。</p><p>老夫妻说，过去两年的7月11日，他们都会将《厦门晚报》收藏起来，因为上面有他们对孙子的祝福，他们的亲朋好友也会特别关注这一天的《厦门晚报》，帮忙收集报纸，或将祝福转达。今天，他们将继续这一做法。</p><p>“我们会把报纸珍藏，等孩子长大后，识字了，我们会拿给他看，让他知道，在他生日的时候，爷爷奶奶是以这样的方式为他过生日的。”</p><p><strong>“这会触到我们心里的痛</strong></p><p><strong>请不要为难我们”</strong></p><p>“等孙子长大了，希望他能理解爷爷奶奶，明白爷爷奶奶的心里惦记着他，多么多么爱他。”电话里，老人有点哽咽，他们说，今年孙子三周岁了，就快要上幼儿园了，所以今年的生日也很特别。</p><p>是什么样的原因，使得爷爷奶奶无法见到孙子？当记者提出这个问题时，老人在电话里的声音有些颤抖：“有些事不好说，没办法说，也说不出来，甚至无法调解。因为这会触到我们心里的痛，请不要为难我们。”</p><p>“说出来了，事情就闹大了，这样对孙子的生活会有影响，我们不想影响孙子，不想让孙子在成长过程中有不愉快，不想从小就给他留下阴影。”</p><p>“请让我们用最平和、最温馨的方式来祝福我们的孙子，这样就好。”老人最后再次对晚报表达了感谢。</p><p><strong>【2016年】3周岁生日</strong></p><p><strong>今年要上幼儿园了，祝他快乐</strong></p><p><!-- AD200x300_2 -->\n\n <p>老夫妻：明天7月11日是我孙子三周岁的生日，我们希望在晚报上送给他一份特殊的生日礼物，可以吗？孙子叫×××，小名土豆，今年要上幼儿园了，祝他在幼儿园生活得快乐。爷爷奶奶会很爱他的，祝他生日快乐，健康成长。我们从孙子周岁开始，在他每年生日期间都在晚报上送他一份特殊的生日礼物，也谢谢你们。</p><p><strong>【2015年】2周岁生日</strong></p><p>健健康康成长，长大了明事理</p><p><strong>【2014年】1周岁生日</strong></p><p>等孩子长大，会拿报纸给他看</p>\n                \n                                                ','http://www.myrole.com//caijiimage/130.jpg','0','艮本停不下来','728','11','24','0','1468299587','0');
INSERT INTO ask_topic VALUES ('44','男子不听劝下河捕鱼被困河心 警民消防联手相救',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：男子不听劝下河捕鱼被困河心 警民消防联手相救）\n                </p>\n                                <p>7月10日，广汉一男子不听劝告下河捕鱼，被上涨的河水困在了河中心，河水持续上涨一直淹没到了男子脖子。广汉市公安局新平派出所与公安消防官兵及时赶到，使用冲锋舟将男子营救出了险境。</p><p>当日中午1点过，广汉市公安局新平派出所接群众报警称：三星堆对面鸭子河内有一男子落水，情况危急，请救助。接警后，新平派出所立即派出警力赶往事发地点，同时通知公安消防携带救援器械前往协助。</p><p>民警到达现场时，发现河水大幅上涨，一名男子身处河道中心，被突然上涨的河水淹没大半，仅剩头部露在水面。由于水流非常湍急，且男子被困于一处落差水位处，无法通过游泳靠近解救，现场情况十分危急。新平派出所民警在与赶来增援的西外派出所民警一面通过喊话器稳定落水群众情绪，让其不要随便移动、稳住重心、保持体力。同时从附近的村民家中找来绳索等物品，做好先期营救的准备。</p><p>几分钟之后，消防官兵携带冲锋舟赶到救援现场，民警与消防官兵立即开展救援。可是当冲锋舟靠近男子的时候，由于男子身处一处落差水位，周边水流湍急，还存在几个回水漩涡，冲锋舟不但无法靠近男子，逆流行驶时产生的水浪还把男子冲得摇摇晃晃，高速转动的螺旋桨对于男子来说也是潜在的危险。</p><p><!-- AD200x300_2 -->\n\n <p>救援人员几次靠近失败之后，及时调整救援策略。冲锋舟在男子一米外游曳，由岸边的民警通过绑在船上的绳索，牵引稳定着冲锋舟，再由冲锋舟上的消防队员抛投救生绳进行营救。可是河水巨大的冲击力让岸上牵引着冲锋舟的民警被摇晃的船体带动着左右摇摆，民警的体力急剧消耗。危急时刻，岸边围观的群众也自发加入稳定冲锋舟的队伍。最终通过消防官兵、派出所民警和过往群众的共同努力，经过一个多小时的奋力营救，落水群众被成功安全救起。</p><p>经了解，今年41岁的落水男子荣某，当日下午不顾汛期禁令，私自下河撒网捕鱼，不料河水突然暴涨，原本立足的河滩被瞬间淹没，水性不怎么好的他只能站在河中最高的一块滩地上等待救援。被救后，荣某对现场的救援人员再三致谢，并表示以后再也不随便下水了。</p>\n                \n                                                ','http://www.myrole.com//caijiimage/bba1cd11728b4710f9d84cbcc0cec3fdfd0323ce.jpg','0','懒惰赖床的小兵','742','8','24','0','1468299587','0');
INSERT INTO ask_topic VALUES ('45','妻子怀疑丈夫有外遇 放火自焚殃及两家邻居',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：妻子怀疑丈夫有外遇放火自焚殃及两家邻居）\n                </p>\n                                <p>近日，齐齐哈尔富裕县友谊乡农民侯某因为怀疑丈夫有外遇，竟然放火自焚，不仅烧毁了自家的房屋，大火还殃及了两个邻居的房屋。7月8日，侯某因涉嫌放火罪被检察机关批准逮捕。</p><p><!-- AD200x300_2 -->\n\n <p>6月29日晚，富裕县公安局友谊派出所接到报警，教育农场居民侯某家的房子着火了。当民警赶到现场时，发现侯某家的房屋已被烧塌架，与侯某家房子连脊的两个邻居的住房受损严重，侯某已经被送往医院抢救。</p><p>派出所民警通过调查得知，侯某的丈夫王某在外打工期间，结识了一个刘姓女子，二人关系很暧昧，王某总不回家。侯某得知情况后，想让丈夫辞职不干，可是王某不同意，二人为此事总是吵架。6月29日，侯某和丈夫吵架后，觉得生活无望，产生了自杀的念头。当日夜晚，侯某将自家存放的柴油泼撒到柴火上点燃后，吞服了半袋老鼠药倒在屋里，幸好火情被邻居发现得早，侯某被抢救及时保住了一条命。</p>\n                \n                                                ','http://www.myrole.com//caijiimage/cdbf6c81800a19d814dcb35431fa828ba71e4687.jpg','0','放手备战','733','20','24','0','1468299588','1');
INSERT INTO ask_topic VALUES ('46','美\"路怒症\"女子剐蹭他车后 边骂脏话边撩衣露胸',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：“路怒症”女子剐蹭他车后边骂脏话边撩衣露胸）\n                </p>\n                                <p class=\"f_center\"><img alt=\"美\"路怒症\"女子剐蹭他车后 边骂脏话边撩衣露胸\" src=\"http://img4.cache.netease.com/cnews/2016/7/12/2016071212010575b74.jpg\" /><br  /></p><p><br  /></p><p>中新网7月12日电 据美媒报道，近日，美国内华达州一名女子在一次交通意外事故中突然发飙，不仅又吼又叫，还脱去上衣。整个过程被另一名司机录下来后上传到网上，立刻引发网友们的关注。事件曝光后不久，这名“怒路症”女子也被警方逮捕。</p><p>涉事女司机为34岁的迪马克(Gina DeMarco)。 数天前，迪马克驾驶汽车在U.S.95号公路上突然变道，之后与一辆卡车擦撞。没想到迪马克从车里出来后，开始对卡车司机罗德里格斯(Adrian Rodriguez)发难。</p><p><!-- AD200x300_2 -->\n\n <p>迪马克对罗德里格斯大叫称：“你撞到我的车了，我全新的车，白痴。” 迪马克一边骂一边还撩起衣服露出乳房，之后还用自己的臀部对着罗德里格斯一家。</p><p>还没等罗德里格斯回过神来，迪马克又跳进车里，扬长而去了。</p><p>迪马克发难的全过程被罗德里格斯用手机拍摄下来传到网上，短短时间内已经有超过30万人观看。在接受采访时罗德里格斯说：“我不知道她当时在想什么，她为什么要这么做？”</p><p>在事发后，迪马克主动向警方自首，目前已经被捕，并被控肇事逃逸等五项罪名。不过当局怀疑，迪马克可能还涉及欺诈或者身份盗窃等罪行，目前警方正在就此进行调查。</p><p><br  /></p>\n                \n                                                ','http://img4.cache.netease.com/cnews/2016/7/12/2016071212010575b74.jpg','0','cjbzd','731','27','24','0','1468299589','0');
INSERT INTO ask_topic VALUES ('47','七旬老人酒后下水游泳 失踪两天尸体在江面发现',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：七旬老人酒后下水游泳失踪两天后尸体在江面被发现(图)）\n                </p>\n                                <p class=\"f_center\"><img src=\"http://cms-bucket.nosdn.127.net/catchpic/1/1D/1D40561856EE39C52D92B77084009145.jpg\" alt=\"事发现场\" /><br  />事发现场</p><p>今天12时20分左右，哈市公安局水上分局的民警发现九站公园附近江面上漂着一具男子尸体。经过调查得知，这名男子正是9日下午在江内游泳后失踪的男子。经确认，男子已经死亡，随后民警通知其亲属赶往现场。</p><p><!-- AD200x300_2 -->\n\n <p>13时30分左右，记者赶到现场看到，在哈工会码头附近，一名老人身上只穿着一条短裤躺在岸边，头被泡在水里，手脚已经发白。记者从哈市公安局水上分局工作人员处了解到，9日14时10分，他们接到报警称一位老人在江内游泳时失踪，他们一直在寻找。今天中午12时20分，工作人员在江面发现一名男子的尸体，于是赶紧将尸体打捞上岸。经核实，该男子正是在9日失踪的老人。</p><p>据老人的牌友陈先生介绍，老人今年77岁，经常和他在九站公园内打麻将。老人平时特别喜欢锻炼身体，身体一直都很好，游泳二十多年，还喜欢打太极拳。老人9日中午喝了点酒，和他们打了一会麻将后，就去游泳了。13时30分左右，他们发现老人一直没有上岸，找了很久也没有找到，直到今天中午才发现老人。</p><p>目前，事故具体原因正在调查。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/1/1D/1D40561856EE39C52D92B77084009145.jpg','0','glw205','729','11','24','0','1468299590','0');
INSERT INTO ask_topic VALUES ('48','老人丧事现场跳脱衣舞淫秽表演影响恶劣 4人被抓',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：老人丧事现场跳脱衣舞影响恶劣 民警出击4人被拘）\n                </p>\n                                <p>中新网安阳7月12日电 老人病故，脱衣女郎却现丧事现场进行淫秽表演，并引发台下观众阵阵喝彩，引发恶劣影响。当地警方接警后快速出击，当场抓获涉案人员4人，其中2名组织者被刑事拘留，其他2人被治安拘留。</p><p><!-- AD200x300_2 -->\n\n <p>河南省内黄县公安局12日通报，7月8日晚，该县亳城派出所接群众举报，亳城乡河村一家老人病故现场正在进行淫秽表演，动作不堪入目，语言低级下流。接到举报后，派出所民警前往演出地点进行秘密拍照录像取证后，立即将涉嫌组织淫秽表演的耿某、李某等5人传唤到亳城派出所。</p><p>经调查，7月5日，内黄县亳城乡李七级村的李某电话联系让滑县的耿某组织人员到亳城乡河村进行表演脱衣舞。7月8日，耿某带领表演人员于某等3人到河村进行演出。在当夜11时许，于某开始在舞台上跳脱衣舞，行为低俗，不堪入目，影响极其恶劣。</p><p>派出所民警将参与人员传唤到公安机关后，所有人员对参与、组织淫秽表演的事实供认不讳。目前，涉嫌组织淫秽表演的耿某、李某已被刑事拘留，参与淫秽表演的于某和涉嫌作伪证的芦某被治安拘留。</p>\n                \n                                                ','http://www.myrole.com//caijiimage/024f78f0f736afc33532a065b119ebc4b74512f7.jpg','0','唯我.杜康','736','14','24','0','1468299590','0');
INSERT INTO ask_topic VALUES ('49','台湾ATM遭盗领7000万 两名俄罗斯嫌犯出境逃香港',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：台湾第一银行ATM遭盗领7000万 两名俄罗斯嫌犯已出境逃往香港）\n                </p>\n                                <p class=\"f_center\"><img alt=\"台湾第一银行ATM遭盗领7000万 两名俄罗斯嫌犯已出境逃往香港\" src=\"http://cms-bucket.nosdn.127.net/catchpic/E/E2/E225DA992C14379F1B6A92A9EFAFEF89.jpg\" style=\"width: 550px; height: 428px\" /><br  />歹徒被监视录影画面。</p><p>【环球网综合报道 实习记者 伶伶】据中时电子报7月12日报道，台湾第一银行部分分行ATM提款机在周休连假遭人异常盗领，台北市警方、刑事局及调查局获知后，已展开清查，警方初步认为，此案歹徒并未以外力破坏提款机，而是利用系统漏洞让机器吐钞。警方扩大调阅监视器过滤交通工具发现有3人涉嫌作案。其中2人为俄罗斯人、2人提款、1人车手，进一步比对出境资料，查出嫌犯7月11日已出境逃往香港。</p><p>刑事局昨晚获知第一银行ATM提款机遭人盗领后，即通报台北市及台中市警方清查管辖区域内有无类似状况及报案记录，台北市警方回报，前晚接获民众报案，有男子在提款机前举止异常，警方获报前往，该男子已离去，现场仍有不少现钞掉落，警方觉得怪异，于是联系第一银行了解。</p><p>台北市警方昨天进而与第一银行再联系，第一银行似乎有所保留，并未透露太多讯息，也未报案，让警方以为是单一个案，没想到，12日凌晨，第一银行即主动发布新闻稿，表示目前本案共计遭盗领金额约7000余万元，20家分行共34台ATM发生异常，已请警方积极侦办中，并向调查局备案。</p><p>第一银行指出，经全面清查银行ATM，初步了解可能遭植入恶意软件驱动吐钞模块执行吐钞，因皆属德利多富(Wincor)公司的同一款机型，目前该款机型已全面暂停服务。</p><p><!-- AD200x300_2 -->\n\n <p>第一银行强调，由于遭盗领的ATM皆非透过本行帐务系统取款，因此并不影响任何客户存款，客户权益完全受到保障，且本案因与帐务及账户无关，所以与“无卡提款”完全无关。</p><p>第一银行表示，本案因其中一家分行在连假上班后，发现ATM钞箱异常，经调阅ATM监视影像，发现疑似2名不明人士带帽子和口罩，在完全无操作ATM的情形下，直接让ATM吐钞后大量提领，并立即将现金装入背包离开，作案过程约5~10分钟，交易皆集中在7月9日和7月10日，所以展开全面清查。</p><p>警方指出，由于第一银行未正式报案，提供详细信息，加上歹徒犯案地点在北部及中部，12日会进一步与第一银行联系，就所提供数据全力侦办，不排除内神通外鬼的可能，另据传涉案人已出境，警方也将一并了解。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/E/E2/E225DA992C14379F1B6A92A9EFAFEF89.jpg','0','zhouchangyi','735','26','24','0','1468299591','0');
INSERT INTO ask_topic VALUES ('50','男子多次医院偷病人救命钱 崔永元帮抓贼',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：邓州一男子多次医院偷病人救命钱 崔永元帮抓贼）\n                </p>\n                                <p class=\"f_center\"><img alt=\"男子多次医院偷病人救命钱 崔永元帮抓贼\" src=\"http://cms-bucket.nosdn.127.net/catchpic/9/9E/9E9643D9641D4AA22B2E1EBF0E50EB25.jpg\" height=\"544\" width=\"400\" /><br  />崔永元微博截图</p><p class=\"f_center\"><img alt=\"男子多次医院偷病人救命钱 崔永元帮抓贼\" src=\"http://cms-bucket.nosdn.127.net/catchpic/9/96/96C94A51808EF601803B1126CDA69BD0.jpg\" /><br  />嫌疑人</p><p>近日，邓州一男子多次到医院盗窃病人治病保命的血汗钱，邓州警方通过网络发布协查令，崔永元等名人也转发消息，最终蟊贼在广东落网。昨日邓州市公安官方微信“@平安邓州”发布了该消息。</p><p>今年5月份以来，邓州市几家医院接连发生多起盗窃病人财物的案件，社会影响极其恶劣。为尽快破案，邓州警方成立专案组开展侦破。为将其早日捉拿归案，邓州警方通过“平安邓州”今日头条、官方微博和微信平台发布协查令，向社会公开征集破案线索。</p><p><!-- AD200x300_2 -->\n\n <p>协查令一经发出，立即引起了社会各界和广大网友的高度关注。中国新闻网、京华时报、@新浪河南、@平安中原等主流媒体、官方“双微”平台先后进行了转载报道，@崔永元、@王于京、@交警陈清洲等社会名人、网络大V以及广大网友纷纷予以转发，迅速在全国范围内对盗贼形成围堵之势。</p><p>邓州警方经过缜密侦查，最终确定此蟊贼是邓州市董某(41岁)，但此时董某已在邓州销声匿迹，不知去向。专案组民警冒着酷暑，先后转展海南、湖南、广东三省八市顺线追踪，历时十二天，行程8000多公里，于7月4日，在广东省惠州市惠阳区成功将其抓获。犯罪嫌疑人董某对自己多次盗窃医院病人钱物的犯罪事实供认不讳。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/9/9E/9E9643D9641D4AA22B2E1EBF0E50EB25.jpg','0','懒惰赖床的小兵','742','29','24','0','1468299592','0');
INSERT INTO ask_topic VALUES ('51','网曝杭州女子路边抽烟 让孙子学狗爬用嘴叼玩具蛇',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：杭州一大妈坐马路边 边抽烟边让孙子学狗爬用嘴叼蛇）\n                </p>\n                                <p class=\"f_center\"><img alt=\"杭州一大妈坐马路边 边抽烟边让孙子学狗爬用嘴叼蛇\" src=\"http://cms-bucket.nosdn.127.net/catchpic/C/C6/C6CDDF622AB545F8145AB7AA62E0F429.jpg\" oldsrc=\"W020160712317670336156.jpg\" style=\"border: 0px; margin: 0px; padding: 0px; vertical-align: bottom;\" /><br  />19楼网友爆料</p><p class=\"f_center\"><img alt=\"杭州一大妈坐马路边 边抽烟边让孙子学狗爬用嘴叼蛇\" src=\"http://cms-bucket.nosdn.127.net/catchpic/A/AC/AC65C44107289EBD8B250546A91B2CD6.jpg\" oldsrc=\"W020160712317670806644.jpg\" style=\"border: 0px; margin: 0px; padding: 0px; vertical-align: bottom;\" /><br  />大妈边抽烟边让孙子用嘴叼“蛇”</p><p class=\"f_center\"><img alt=\"杭州一大妈坐马路边 边抽烟边让孙子学狗爬用嘴叼蛇\" src=\"http://cms-bucket.nosdn.127.net/catchpic/1/16/167116470F7820CDF2913490C34DB6BB.jpg\" oldsrc=\"W020160712317670926674.jpg\" style=\"border: 0px; text-align: center; margin: 0px; padding: 0px; vertical-align: bottom;\" /><br  /><span style=\"text-indent: 28px;\">小男孩学着小狗的样子，爬过去用嘴叼起</span></p><p><!-- AD200x300_2 -->\n\n <p>昨天，19楼网友“牛奶喝不厌”爆料称：她看到她一个朋友的朋友圈，简直震惊了！有个大妈在杭州的马路上把自己的孙子当狗溜...　朋友说他今天下午在环城西路凤起路口看到了一个大妈，坐在马路牙子上，嘴里叼着烟，手上玩着蛇。是玩具蛇。旁边还坐着个小男孩。朋友热爱摄影，看到眼前这一幕便掏出相机拍了一会儿。</p><p>接下来的一幕让他震惊了！</p><p>大妈居然笑着把蛇甩了出去，让小男孩学着小狗的样子，爬过去用嘴叼起，再爬回来交给她！男孩还吐舌头汪汪叫。。。</p><p>朋友忍不住上前劝止，一问才知他们是祖孙，从安徽来杭州玩。</p><p>孙子三岁半。平时就喜欢学狗狗。。。通过交谈，朋友发现两人智力和精神还算正常，看他拿着相机，小男孩还对着镜头做鬼脸。后来朋友还是对他们进行了卫生和安全教育后才离开现场。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/C/C6/C6CDDF622AB545F8145AB7AA62E0F429.jpg','0','放手备战','733','9','24','0','1468299593','0');
INSERT INTO ask_topic VALUES ('52','男子偷独木舟放头顶骑车 警察见\"奇景\"轻松逮人',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：男子偷独木舟用头顶着骑车 警察见“奇景”轻松逮人）\n                </p>\n                                <p class=\"f_center\"><img src=\"http://cms-bucket.nosdn.127.net/catchpic/A/AF/AFCE041C8C0098A7B2D062BC293BADCA.jpg\" alt=\"男子偷独木舟用头顶着骑车警察见“奇景”轻松逮人\" /><br  />李姓男子行窃独木舟后，用头顶着骑车，留下高难度画面，警方依监视器逮人</p><p>中新网7月12日电 据台湾《联合报》报道，新北市李姓男子今年4月间，潜入万里海边一处货柜屋，偷走独木舟、钓鱼竿等，为了搬运3公尺长的独木舟，李姓男子竟突发奇想，把20公斤重的独木舟，当安全帽顶在头上，骑着摩托车扬长而去，警方调阅监视器发现这个“奇景”，轻松逮人，检方日前依窃盗罪嫌将他起诉。</p><p><!-- AD200x300_2 -->\n\n <p>检警调查，李姓男子(50岁)当天凌晨4时许，骑着朋友的摩托车前往万里海边，发现简姓男子所有的货柜屋气密窗未上锁，遂爬入行窃，偷走沈姓男子寄放的一艘蓝色塑料独木舟及4支钓鱼竿后骑车逃逸。</p><p>简姓男子发现货柜屋遭窃向警方报案，警方沿线调阅监视器画面，发现当晚有一名男子骑乘摩托车往金山方向行驶，头上顶着的正是沈姓男子失窃的蓝色独木舟，由于体积庞大加上颜色鲜艳，非常好辨认，即刻将他逮捕。</p><p>李姓男子落网后向警方供称，因为自己喜欢钓鱼，搭船到海上一般能钓得到，但苦无船只，才心生歹念行窃，他坦承取走独木舟、钓鱼竿，但辩称是向简姓男子借来的，否认行窃，基隆地检署日前侦查终结，依窃盗罪嫌将李姓男子起诉。</p>\n                \n                                                ','http://cms-bucket.nosdn.127.net/catchpic/A/AF/AFCE041C8C0098A7B2D062BC293BADCA.jpg','0','艮本停不下来','728','16','24','0','1468299595','1');
INSERT INTO ask_topic VALUES ('53','22岁台湾女孩要穿婚纱从西班牙走回台湾',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：史上最强新娘 台女孩要穿婚纱从西班牙走回台湾）\n                </p>\n                                <p>中新网7月12日电 据台湾联合新闻网报道，“我们想用这个经历告诉大家，如果你有任何想达成的梦想，只要开始执行，就会有成功的一天，”目前还在旅途中的解博茹说。</p><p>22岁的台湾女孩解博茹打算和西班牙男友马林(Alfonso Marin)以最省钱的方式，从西班牙一路旅行回台湾，途中不搭飞机、不花钱住旅馆，只用步行、搭便车、搭帐篷等方式旅游，而且最特别的是，解博茹一路上都穿着自制的新娘白纱、马林也穿着全套西装，成为所到城市中最引人注目的焦点。</p><p><!-- AD200x300_2 -->\n\n <p>这对情侣在马德里的一间酒吧相识，解博茹当时是从台湾政大前往西班牙的交换生，而马林则在当地修习艺术相关课程，热爱旅行的两人决定花八个月的时间，一起完成这个看似疯狂的点子，他们也成立了WeddingDiary粉丝专页，与所有人分享旅途中的酸甜苦辣。</p><p>解博茹表示，他们仅有很少的旅费，但这一路上却因此得到更多，“自从西班牙的电视台Andalucia Directo采访后，只要我们穿着婚纱走在路上，就会被许多人认出来，很多人来为我们打气、找我们拍照、或请我们一起喝茶，我们也因此认识了很多新朋友。”</p><p>解博茹也指出，旅途中难免会有低潮，但只要一穿上新郎、新娘服，就好像将众人的期望穿上身，立刻获得许多能量，让他们能继续完成这个梦想。</p><p><br  /></p><p><br  /></p>\n                \n                                                ','http://www.myrole.com//caijiimage/u=294118498,2397545403&fm=21&gp=0.jpg','0','猫三七','741','17','24','0','1468299596','0');
INSERT INTO ask_topic VALUES ('54','拼车回家遭遇车祸致5死1伤 福建两个家庭破碎',' style=\"border-top:1px solid #ddd;\">\n                                <p class=\"otitle\">\n                    （原标题：拼车回家遭遇车祸致5死1伤 两个家庭破碎）\n                </p>\n                                <p>过完这个暑假，7岁女孩小琪(化名)就要上一年级了。然而，连同小琪在内，还有她9岁的哥哥和10岁的同村男孩小志(化名)，都被前天的一场车祸夺走了生命。</p><p>前天下午5点30分许，在324国道云霄县火田镇后埔村路段，一辆从漳州往云霄方向行驶的小车，与一辆相向而行的大挂车发生碰撞。小车上，除了三个孩子，小琪的母亲和小志的奶奶也当场遇难，而小车司机目前仍未脱离生命危险。</p><p><strong>小车严重变形，4人当场不幸身亡</strong></p><p>海都记者了解到，5名死者均为云霄莆美镇益宝山村人。事发前，他们分别到漳州市区游玩，前天傍晚一起拼车回家，未料遭遇车祸，两个家庭瞬间破碎。</p><p>事发当晚，漳州市委书记陈家东、市长檀云坤作出批示，要求漳州市、云霄县做好善后工作，尽快调查事故原因，采取有效措施确保安全。副市长黄华安带领市安监局局长林立辉、市交警支队支队长李仲坚等赶赴现场开展善后处置。</p><p>目前，事故发生的具体原因仍在进一步调查中。</p><p>【惨祸】</p><p><strong>4人当场遇难 1人抢救无效身亡</strong></p><p>昨日上午10时许，海都记者来到事发现场，此时现场已经没有留下任何与车祸有关的痕迹。</p><p>海都记者看到，该路段是一处近70°的急转弯，路边防护水泥柱上标有急转弯路段标示，而路中央黄线处，安置了近20个塑料反光棒，但现场并没有设置监控。</p><p>事发点路旁边，仅有两间给车辆加水的商铺。昨日上午，海都记者找到了该商铺的老板，他称，店铺用于夜间加水，白天并没有开张，事发当晚8时许，他来开店时，现场已经围满了前来处理事故的工作人员。</p><p><strong>事故地点位于一个转弯路段</strong></p><p>“‘砰’的一声，非常响！”后埔村村民吴先生的店铺，距离事发现场约50米。事发时，他听到声音后便跑出来一探究竟。他说，发生碰撞后，小车尾部往前甩了近180°，车头和车身都变形了，而小车里还有乘员被甩了出来。后来，附近的许多村民都围了过去。这一说法，得到现场其他几位村民的证实。</p><p>一位附近的村民介绍，当时小车车速较快，在转弯处来不及转弯，遂驶入逆向车道，与相向而行、在快车道的大挂车发生碰撞。不过，这一说法并没有得到交警部门的证实。</p><p>昨日，据云霄县交警大队提供的通报称，事发当时，许某兵驾驶一辆重型半挂牵引车，与柳某汉驾驶的起亚小型轿车发生碰撞，造成两车局部损坏。事发时，小车上共有6名乘员。其中，龚某娟、罗某阳、龚某琪、吴某华4人当场死亡，驾驶员柳某汉及乘员龚某志受伤。另外，大挂车司机——湖南耒阳籍34岁的许某兵，没有在事故中受伤。</p><p>昨日上午，海都记者来到云霄县中医院，医生介绍，当晚6时许，确实从324国道火田镇段的车祸中送来了两名伤者。但小孩龚某志因抢救无效死亡，而柳某汉则转至漳州市医院。昨日下午，漳州市医院相关负责人介绍，柳某汉身体多处骨折，脾脏、肝脏破裂，目前正在ICU接受治疗，还未脱离生命危险。</p><p><b>□伤亡名单</b></p><p>1.龚某娟，女，31岁，云霄莆美镇益宝山村人，小车乘员(当场死亡)</p><p>3.龚某琪，女，7岁，云霄莆美镇益宝山村人，小车乘员(当场死亡)</p><p>4.吴某华，女，54岁，云霄莆美镇益宝山村人，小车乘员(当场死亡)</p><p>5.龚某志，男，10岁，云霄莆美镇益宝山村人，小车乘员(抢救无效死亡)</p><p>6.柳某汉，男，25岁，云霄县陈岱镇人，小车司机(仍未脱离生命危险)</p><p>【心碎】</p><p><strong>两个家庭破碎 他一天痛失三个亲人</strong></p><p>据知情人士介绍，在车祸中死亡的5人，均为云霄县莆美镇益宝山村人。昨日下午，海都记者来到莆美镇益宝山村。据多位当地村民证实，这5名死者确为该村村民，来自两个家庭。其中，龚某娟为罗某阳和龚某琪的母亲，吴某华则为龚某志的奶奶。</p><p>随后，海都记者来到龚某娟的家中。此时，亲戚们围聚在屋里屋外，陷入一阵悲伤。面对女儿、外孙和外孙女的离去，龚某娟的父亲龚某乙几度哽咽。他说，他和老伴在解放军第175医院打工，孙子今年上二年级，孙女则刚要上一年级。两周前，因孩子正在放暑假，女儿便带着两个孩子到漳州市区来找外公外婆。前天，他们3人准备回家，龚某娟便约了同村的吴某华和龚某志，5人一起拼车。</p><p><!-- AD200x300_2 -->\n\n <p>而龚某娟当时联系的是吴某华的女儿龚明女。龚明女介绍，7月3日，母亲吴某华带着侄儿龚某志来漳州市区玩，前天正好要回去，她与龚某娟是好友，所以她便让母亲和侄儿与龚某娟拼车。</p><p>“车子是龚某娟叫的。”龚明女说，她并不知道叫了哪家的车。龚明女提供了她手机上的通话记录，上面显示，在7月10日15点34分和16点整，龚某娟共呼入两次电话，通话时间均为11秒。龚明女说，第一次是龚某娟称车子已经联系好了，第二次是龚某娟坐车到了她的住所楼下，让她母亲和侄儿下楼。此后的通话记录显示，龚明女在当晚7点后多次向龚某娟拨打电话，均没有接通。</p><p>目前，除了事故的具体原因外，调度小车等相关问题，有关部门正在进一步调查。</p>\n                \n                                                ','http://www.myrole.com//caijiimage/65.jpg','0','该用户已诈尸矣','739','20','24','0','1468299598','0');

DROP TABLE IF EXISTS ask_topic_tag;
CREATE TABLE `ask_topic_tag` (
  `aid` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`aid`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ask_topic_tag VALUES ('38','帅哥','1468299519');
INSERT INTO ask_topic_tag VALUES ('39','捕鱼游戏机','1468299583');
INSERT INTO ask_topic_tag VALUES ('39','律师事务所','1468299583');
INSERT INTO ask_topic_tag VALUES ('39','开设赌场','1468299583');
INSERT INTO ask_topic_tag VALUES ('39','游戏大厅','1468299583');
INSERT INTO ask_topic_tag VALUES ('39','回龙观','1468299583');
INSERT INTO ask_topic_tag VALUES ('40','中国青年报','1468299584');
INSERT INTO ask_topic_tag VALUES ('40','应急能力','1468299584');
INSERT INTO ask_topic_tag VALUES ('40','暴雨袭击','1468299584');
INSERT INTO ask_topic_tag VALUES ('40','普通人','1468299584');
INSERT INTO ask_topic_tag VALUES ('40','摇钱树','1468299584');
INSERT INTO ask_topic_tag VALUES ('41','湖北省','1468299585');
INSERT INTO ask_topic_tag VALUES ('41','苹果手机','1468299585');
INSERT INTO ask_topic_tag VALUES ('41','东西湖区','1468299585');
INSERT INTO ask_topic_tag VALUES ('41','女大学生','1468299585');
INSERT INTO ask_topic_tag VALUES ('41','研究所','1468299585');
INSERT INTO ask_topic_tag VALUES ('42','事故赔偿','1468299585');
INSERT INTO ask_topic_tag VALUES ('42','头部受伤','1468299585');
INSERT INTO ask_topic_tag VALUES ('42','肇事司机','1468299585');
INSERT INTO ask_topic_tag VALUES ('42','交通事故','1468299585');
INSERT INTO ask_topic_tag VALUES ('42','闵行区','1468299585');
INSERT INTO ask_topic_tag VALUES ('43','厦门晚报','1468299587');
INSERT INTO ask_topic_tag VALUES ('43','生日礼物','1468299587');
INSERT INTO ask_topic_tag VALUES ('43','生日祝福','1468299587');
INSERT INTO ask_topic_tag VALUES ('43','幼儿园','1468299587');
INSERT INTO ask_topic_tag VALUES ('43','儿媳妇','1468299587');
INSERT INTO ask_topic_tag VALUES ('44','消防队员','1468299587');
INSERT INTO ask_topic_tag VALUES ('44','派出所','1468299587');
INSERT INTO ask_topic_tag VALUES ('44','公安局','1468299587');
INSERT INTO ask_topic_tag VALUES ('44','三星堆','1468299587');
INSERT INTO ask_topic_tag VALUES ('44','冲锋舟','1468299587');
INSERT INTO ask_topic_tag VALUES ('45','齐齐哈尔','1468299588');
INSERT INTO ask_topic_tag VALUES ('45','邻居发现','1468299588');
INSERT INTO ask_topic_tag VALUES ('45','派出所','1468299588');
INSERT INTO ask_topic_tag VALUES ('45','公安局','1468299588');
INSERT INTO ask_topic_tag VALUES ('45','检察机关','1468299588');
INSERT INTO ask_topic_tag VALUES ('46','罗德里格斯','1468299589');
INSERT INTO ask_topic_tag VALUES ('46','中新网','1468299589');
INSERT INTO ask_topic_tag VALUES ('46','卡车司机','1468299589');
INSERT INTO ask_topic_tag VALUES ('46','内华达','1468299589');
INSERT INTO ask_topic_tag VALUES ('46','style','1468299589');
INSERT INTO ask_topic_tag VALUES ('47','工作人员','1468299590');
INSERT INTO ask_topic_tag VALUES ('47','太极拳','1468299590');
INSERT INTO ask_topic_tag VALUES ('47','公安局','1468299590');
INSERT INTO ask_topic_tag VALUES ('47','style','1468299590');
INSERT INTO ask_topic_tag VALUES ('47','游泳','1468299590');
INSERT INTO ask_topic_tag VALUES ('48','河南省','1468299590');
INSERT INTO ask_topic_tag VALUES ('48','中新网','1468299590');
INSERT INTO ask_topic_tag VALUES ('48','淫秽表演','1468299590');
INSERT INTO ask_topic_tag VALUES ('48','派出所','1468299590');
INSERT INTO ask_topic_tag VALUES ('48','刑事拘留','1468299590');
INSERT INTO ask_topic_tag VALUES ('49','台北市警方','1468299591');
INSERT INTO ask_topic_tag VALUES ('49','俄罗斯','1468299591');
INSERT INTO ask_topic_tag VALUES ('49','提款机','1468299591');
INSERT INTO ask_topic_tag VALUES ('49','新闻稿','1468299591');
INSERT INTO ask_topic_tag VALUES ('49','监视器','1468299591');
INSERT INTO ask_topic_tag VALUES ('50','中国新闻网','1468299592');
INSERT INTO ask_topic_tag VALUES ('50','犯罪嫌疑人','1468299592');
INSERT INTO ask_topic_tag VALUES ('50','京华时报','1468299592');
INSERT INTO ask_topic_tag VALUES ('50','犯罪事实','1468299592');
INSERT INTO ask_topic_tag VALUES ('50','广东省','1468299592');
INSERT INTO ask_topic_tag VALUES ('51','style','1468299593');
INSERT INTO ask_topic_tag VALUES ('51','杭州','1468299593');
INSERT INTO ask_topic_tag VALUES ('51','安徽','1468299593');
INSERT INTO ask_topic_tag VALUES ('51','朋友','1468299593');
INSERT INTO ask_topic_tag VALUES ('51','玩具','1468299593');
INSERT INTO ask_topic_tag VALUES ('52','中新网','1468299595');
INSERT INTO ask_topic_tag VALUES ('52','摩托车','1468299595');
INSERT INTO ask_topic_tag VALUES ('52','突发奇想','1468299595');
INSERT INTO ask_topic_tag VALUES ('52','独木舟','1468299595');
INSERT INTO ask_topic_tag VALUES ('52','钓鱼竿','1468299595');
INSERT INTO ask_topic_tag VALUES ('53','西班牙','1468299596');
INSERT INTO ask_topic_tag VALUES ('53','中新网','1468299596');
INSERT INTO ask_topic_tag VALUES ('53','马德里','1468299596');
INSERT INTO ask_topic_tag VALUES ('53','新闻网','1468299596');
INSERT INTO ask_topic_tag VALUES ('53','电视台','1468299596');
INSERT INTO ask_topic_tag VALUES ('54','工作人员','1468299598');
INSERT INTO ask_topic_tag VALUES ('54','交警支队','1468299598');
INSERT INTO ask_topic_tag VALUES ('54','事故原因','1468299598');
INSERT INTO ask_topic_tag VALUES ('54','事故发生','1468299598');
INSERT INTO ask_topic_tag VALUES ('54','云霄县','1468299598');
INSERT INTO ask_topic_tag VALUES ('55','','1469149888');

DROP TABLE IF EXISTS ask_topicclass;
CREATE TABLE `ask_topicclass` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `dir` varchar(200) NOT NULL,
  `pid` int(10) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `articles` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;


DROP TABLE IF EXISTS ask_answer;
CREATE TABLE `ask_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(50) NOT NULL,
  `author` varchar(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `adopttime` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `comments` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ip` varchar(20) DEFAULT NULL,
  `supports` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `qid` (`qid`),
  KEY `authorid` (`authorid`),
  KEY `adopttime` (`adopttime`),
  KEY `time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=1214 DEFAULT CHARSET=utf8 AUTO_INCREMENT=1214;

INSERT INTO ask_answer VALUES ('1173','575','我已经被安徽建工技师学院录取了，还可以在网上填报志愿吗','admin','1','1467782404','1467783003','<div class=\"resolved-cnt\"><p>是的，网上的为准</p></div>','1','1','127.0.0.1','27');
INSERT INTO ask_answer VALUES ('1174','576','今年芜湖七中分数线','匿名网友 ','727','1467781866','0','<div class=\"resolved-cnt\"><p>据了解是560分。</p></div>','0','1','127.0.0.1','73');
INSERT INTO ask_answer VALUES ('1175','576','今年芜湖七中分数线','admin','1','1467781866','1467783005','<div class=\"other-ans-cnt\"><p>应该会涨，因为大家普遍反映考试题简单，可能分数线高了</p></div>','1','1','127.0.0.1','75');
INSERT INTO ask_answer VALUES ('1176','577','安徽今年理科326分可以上安徽那里学校','艮本停不下来','728','1467782528','0','<div class=\"resolved-cnt\"><p>今年安徽三本446，高职专科290，你的326，只能读专科了，而且如果是公办专科好的专业分数肯定不低，估计是上不了，只能选择普通一点的专业了！</p></div>','0','1','127.0.0.1','62');
INSERT INTO ask_answer VALUES ('1177','577','安徽今年理科326分可以上安徽那里学校','','726','1467782948','1467783007','<div class=\"other-ans-cnt\"><p>复习一年把</p></div>','1','1','127.0.0.1','58');
INSERT INTO ask_answer VALUES ('1178','578','汉语言文学专业晓庄学院和安徽师范学院哪个好啊?','glw205','729','1467782262','0','<div class=\"resolved-cnt\"><p>安徽师范学院比较好。</p></div>','0','1','127.0.0.1','45');
INSERT INTO ask_answer VALUES ('1179','578','汉语言文学专业晓庄学院和安徽师范学院哪个好啊?','','726','1467782562','0','<div class=\"other-ans-cnt\"><p>现在没有安徽师范学院。只有安徽师范大学<br></p></div>','0','1','127.0.0.1','30');
INSERT INTO ask_answer VALUES ('1180','579','金寨县文化馆图书室要搬哪里去？','匿名网友','727','1467782684','1467783042','<div class=\"resolved-cnt\"><p>不会吧，问问馆里。</p></div>','1','1','127.0.0.1','31');
INSERT INTO ask_answer VALUES ('1181','580','2016年合肥高职需多少分','匿名网友','727','1467782925','1467783044','<div class=\"resolved-cnt\"><p>最低限就可以</p></div>','1','1','127.0.0.1','47');
INSERT INTO ask_answer VALUES ('1182','581','马鞍山现在的中考录取分数线是不是在逐年增高啊','匿名网友','727','1467782087','1467783045','<div class=\"resolved-cnt\"><p>这不一定，要根据当年整体成绩加权后确定</p></div>','1','1','127.0.0.1','66');
INSERT INTO ask_answer VALUES ('1183','582','安徽的一个女的通过微信破坏了一个幸福的家庭 我作为一个儿子该怎不办？？我不想我爸妈离婚','f01205','730','1467782869','0','<div class=\"resolved-cnt\"><p>红杏出墙说的就是你父亲，虽说那个女的动机不良，勾引了你父亲，如果你父亲有那么一点珍惜婚姻，爱家庭、爱妻子、爱子女，也不会抛弃你们与那个女的勾搭成奸，与你妈离婚。现在出现这种事只有你、你爷爷、奶奶、外公、外婆、叔叔、大伯、姑姑们共同做你父亲工作，必要时可找你父亲单位领导，…，挽救你父亲回头。</p></div>','0','1','127.0.0.1','48');
INSERT INTO ask_answer VALUES ('1184','582','安徽的一个女的通过微信破坏了一个幸福的家庭 我作为一个儿子该怎不办？？我不想我爸妈离婚','cjbzd','731','1467781909','0','<div class=\"other-ans-cnt\"><p>带上你的父亲出去转转吧，真好放暑假了。在旅行当中说说你们之前的幸福。</p></div>','0','1','127.0.0.1','69');
INSERT INTO ask_answer VALUES ('1185','582','安徽的一个女的通过微信破坏了一个幸福的家庭 我作为一个儿子该怎不办？？我不想我爸妈离婚','YY2016小柒','732','1467782929','0','<div class=\"other-ans-cnt\"><p>多沟通、多讲道理，争取回心转意。</p></div>','0','1','127.0.0.1','61');
INSERT INTO ask_answer VALUES ('1186','582','安徽的一个女的通过微信破坏了一个幸福的家庭 我作为一个儿子该怎不办？？我不想我爸妈离婚','艮本停不下来','728','1467782569','0','<div class=\"other-ans-cnt\"><p>这个就看你爸爸了 &nbsp;如果他执意的要跟那个狐狸精在一起 &nbsp;你还是接受吧 要不受伤的就是你妈妈 &nbsp; 如果你爸爸只是一时鬼迷心窍还是可以原谅的 &nbsp;建议你可以跟你的父亲好好地沟通一下 </p></div>','0','1','127.0.0.1','67');
INSERT INTO ask_answer VALUES ('1187','583','今年安徽高中分数线','YY2016小柒','732','1467782031','0','<div class=\"resolved-cnt\"><p>1、合肥市2016年中考还没有进行，现在无法知晓中考分数线。 2、中考考生可以参考一下2015年分数线，2015年合肥市区普通高中最低录取分数线为596分。合肥一、六、八中三校联招线为752。<br></p></div>','0','1','127.0.0.1','75');
INSERT INTO ask_answer VALUES ('1188','584','合肥学院国际汉语教育专业学生就业如何？大部分都能去韩国吗？','放手备战','733','1467782153','0','<div class=\"resolved-cnt\"><p>该专业还是不错的，但还得靠个人努力才行</p></div>','0','1','127.0.0.1','52');
INSERT INTO ask_answer VALUES ('1189','584','合肥学院国际汉语教育专业学生就业如何？大部分都能去韩国吗？','glw205','729','1467782873','0','<div class=\"other-ans-cnt\"><p>去哪里看你自己，没有学校包你去哪里</p></div>','0','1','127.0.0.1','53');
INSERT INTO ask_answer VALUES ('1190','585','芜湖七中普通班分数线会上涨么','','726','1467782695','0','<div class=\"resolved-cnt\"><p>不会的哦哦哦</p></div>','0','1','127.0.0.1','74');
INSERT INTO ask_answer VALUES ('1191','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','360U2699109498','734','1467782517','0','<div class=\"resolved-cnt\"><p>浙大、交通是可以的</p></div>','0','1','127.0.0.1','21');
INSERT INTO ask_answer VALUES ('1192','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','zhouchangyi','735','1467782877','0','<div class=\"other-ans-cnt\"><p>我以为好的专业比好的学校更重要。</p></div>','0','1','127.0.0.1','43');
INSERT INTO ask_answer VALUES ('1193','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','唯我.杜康','736','1467782157','0','<div class=\"other-ans-cnt\"><p>两电一邮看看；就是西安电子科技大学，电子科技大学；北京邮电大学，参照自己排名及15年排名综合考虑，祝好运<br></p></div>','0','1','127.0.0.1','28');
INSERT INTO ask_answer VALUES ('1194','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','匿名网友 ','727','1467782757','0','<div class=\"other-ans-cnt\"><p>北京邮电，华北电力，华中科技，应该都可以实现吧</p></div>','0','1','127.0.0.1','74');
INSERT INTO ask_answer VALUES ('1195','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','cyx168','737','1467782097','0','<div class=\"other-ans-cnt\"><p>要看你的兴趣<br></p></div>','0','1','127.0.0.1','27');
INSERT INTO ask_answer VALUES ('1196','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','惜若水三千','738','1467782458','0','<div class=\"other-ans-cnt\"><p>可以考个很好的学校了<br></p></div>','0','1','127.0.0.1','56');
INSERT INTO ask_answer VALUES ('1197','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','该用户已诈尸矣','739','1467782398','0','<div class=\"other-ans-cnt\"><p>北京上海之类的学校吧</p><p>&nbsp;</p></div>','0','1','127.0.0.1','41');
INSERT INTO ask_answer VALUES ('1198','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','我是樊磊','740','1467781978','0','<div class=\"other-ans-cnt\"><p>这个分数很多选择</p></div>','0','1','127.0.0.1','55');
INSERT INTO ask_answer VALUES ('1199','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','猫三七','741','1467782758','0','<div class=\"other-ans-cnt\"><p>考的还可以</p></div>','0','1','127.0.0.1','72');
INSERT INTO ask_answer VALUES ('1200','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','懒惰赖床的小兵','742','1467781918','0','<div class=\"other-ans-cnt\"><p>北京交通大学<br></p></div>','0','1','127.0.0.1','23');
INSERT INTO ask_answer VALUES ('1201','586','我是安徽高考毕业生，考了637分，全省2360名次想学微电子科学，想问一下那所学校最理想？急','cjbzd','731','1467782698','0','<div class=\"other-ans-cnt\"><p>选一所自己喜欢的大学，最好是一线城市的，经济发展比较好的城市。另外要选自己喜欢的专业，对未来人生的质量很重要。<br></p></div>','0','1','127.0.0.1','25');
INSERT INTO ask_answer VALUES ('1202','587','请问一下，安徽合肥医学高等专科学院有中专证书可以去读吗','艮本停不下来','728','1467782520','1467783058','<div class=\"resolved-cnt\"><p>当然可以去读了，只要是正规的学校都可以<br></p></div>','1','1','127.0.0.1','45');
INSERT INTO ask_answer VALUES ('1203','588','六安裕安区交通大夏在哪？','放手备战','733','1467781862','1467783060','<div class=\"resolved-cnt\"><p>六安市梅山路<br></p></div>','1','1','127.0.0.1','28');
INSERT INTO ask_answer VALUES ('1204','589','腾讯智汇推在合肥的哪家代理公司做的比较好','glw205','729','1467782884','1467783062','<div class=\"resolved-cnt\"><p>智汇推是腾讯旗下的产品。智汇推整合腾讯资讯、娱乐等网络媒体的PC和移动端资源面向区域企业提供的“品效合一”的营销推广服务.效果自然出众，目前安徽区尚未有总代理出现，但是我们目前已经跟一家点动传媒合作，效果很不错。经理比较负责，从前端显示到后端着陆页的优化都提供了专业化的建议，强烈推荐去咨询，联系人是张总，号码是15555112073，你会得到你想要的</p><p><br></p></div>','1','1','127.0.0.1','34');
INSERT INTO ask_answer VALUES ('1205','602','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','林大头的娘 ','745','1470288520','0','<div class=\"answer-text\" itemprop=\"content\" id=\"best_answer_content\">                 是体虚的表现。月子过后，慢慢慢慢就会好，你现在。不用担心。吃一些补血补气。            </div>','0','1','127.0.0.1','31');
INSERT INTO ask_answer VALUES ('1206','602','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','宝妹儿妈z ','746','1470288581','0','<div class=\"answer-text\" itemprop=\"content\">                         月子里是会酱紫的，不是病，月子里比较虚，会出虚汗的。                    </div>','0','1','127.0.0.1','54');
INSERT INTO ask_answer VALUES ('1207','602','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','毛毛的丹妮 ','747','1470289065','0','<div class=\"answer-text\" itemprop=\"content\">                         月子里身体虚流汗多是正常的，不是因为热而流汗                    </div>','0','1','127.0.0.1','71');
INSERT INTO ask_answer VALUES ('1208','602','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','你深知我心 ','748','1470288585','0','<div class=\"answer-text\" itemprop=\"content\">                         正常的，你出汗，一蒸发自然会冷，都是正常，注意保暖就行了                    </div>','0','1','127.0.0.1','35');
INSERT INTO ask_answer VALUES ('1209','602','月子里，经常出汗，摸后背一直是冷的，这是为什么？这会是月子病么？有办法对付么','cyx168','737','1470288585','0','<div class=\"answer-text\" itemprop=\"content\">                         我大宝的时候和你一样，很多都不懂，这里大多数宝妈都是提问的，之后我们很多宝妈都是在裙学习讨论，里面还有好几个是妇产科儿科的，关于宝宝还 有我们女人孕期产后的护理都可以交流经验，希望能帮到你 裙号1393o94                    </div>','0','1','127.0.0.1','68');
INSERT INTO ask_answer VALUES ('1210','603','怎样给新生儿洗头发，求高招','树友i7a0ih ','749','1470290381','0','<div class=\"answer-text\" itemprop=\"content\">                         准备好温水和婴儿洗发沐浴露二合一的，抱着宝宝的身体，轻轻地拿洗发水按摩宝宝的头部，洗净就好了                    </div>','0','1','127.0.0.1','70');
INSERT INTO ask_answer VALUES ('1211','604','月子里还差两天，可以洗头发洗澡吗？求解','2胖巫婆 ','750','1470289843','0','<div class=\"answer-text\" itemprop=\"content\">                         可以，我是产后第七天洗澡洗头的，总共用了5分钟搞定                    </div>','0','1','127.0.0.1','22');
INSERT INTO ask_answer VALUES ('1212','604','月子里还差两天，可以洗头发洗澡吗？求解','欧小二他老 ','751','1470290323','1470290441','<div class=\"answer-text\" itemprop=\"content\">                         ','1','1','127.0.0.1','69');
INSERT INTO ask_answer VALUES ('1213','604','月子里还差两天，可以洗头发洗澡吗？求解','咖啡有点儿 ','752','1470290323','0','<div class=\"answer-text\" itemprop=\"content\">                         我月子里都洗了，时间不早太长，不要着凉，没事儿的                    </div>','0','1','127.0.0.1','61');

DROP TABLE IF EXISTS ask_user_attention;
CREATE TABLE `ask_user_attention` (
  `uid` int(10) NOT NULL,
  `followerid` int(10) NOT NULL,
  `follower` char(18) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`followerid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_user_category;
CREATE TABLE `ask_user_category` (
  `uid` int(10) NOT NULL,
  `cid` int(4) NOT NULL,
  PRIMARY KEY (`uid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ask_user_category VALUES ('1','24');
INSERT INTO ask_user_category VALUES ('1','26');

DROP TABLE IF EXISTS ask_user_readlog;
CREATE TABLE `ask_user_readlog` (
  `uid` int(10) NOT NULL,
  `qid` int(10) NOT NULL,
  PRIMARY KEY (`uid`,`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_userbank;
CREATE TABLE `ask_userbank` (
  `id` int(10) NOT NULL,
  `fromuid` int(10) NOT NULL,
  `touid` int(10) NOT NULL,
  `operation` varchar(200) NOT NULL,
  `money` int(10) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_ad;
CREATE TABLE `ask_ad` (
  `html` text,
  `page` varchar(50) NOT NULL DEFAULT '',
  `position` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`page`,`position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_userlog;
CREATE TABLE `ask_userlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sid` varchar(10) NOT NULL DEFAULT '',
  `type` enum('login','ask','answer') NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`sid`),
  KEY `time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 AUTO_INCREMENT=66;

INSERT INTO ask_userlog VALUES ('1','0216638862','answer','1448271533');
INSERT INTO ask_userlog VALUES ('2','0216638862','answer','1448273491');
INSERT INTO ask_userlog VALUES ('3','0216638862','answer','1448273665');
INSERT INTO ask_userlog VALUES ('4','0216638862','answer','1448274027');
INSERT INTO ask_userlog VALUES ('5','0216638862','answer','1448274558');
INSERT INTO ask_userlog VALUES ('6','0216638862','answer','1448274775');
INSERT INTO ask_userlog VALUES ('7','0216638862','answer','1448274834');
INSERT INTO ask_userlog VALUES ('8','330d0c20aa','answer','1452144388');
INSERT INTO ask_userlog VALUES ('9','2ec99efec7','answer','1454222222');
INSERT INTO ask_userlog VALUES ('10','2ec99efec7','answer','1454222242');
INSERT INTO ask_userlog VALUES ('11','2ec99efec7','answer','1454222330');
INSERT INTO ask_userlog VALUES ('12','ca64c96b1b','answer','1454224695');
INSERT INTO ask_userlog VALUES ('13','7f0331e00c','ask','1456896166');
INSERT INTO ask_userlog VALUES ('14','aa85bb0b72','answer','1456896323');
INSERT INTO ask_userlog VALUES ('15','aa85bb0b72','answer','1456897013');
INSERT INTO ask_userlog VALUES ('16','13844574d5','answer','1456921046');
INSERT INTO ask_userlog VALUES ('17','e19064e30d','answer','1457182725');
INSERT INTO ask_userlog VALUES ('18','e19064e30d','answer','1457183007');
INSERT INTO ask_userlog VALUES ('19','e19064e30d','answer','1457183097');
INSERT INTO ask_userlog VALUES ('20','e19064e30d','answer','1457183139');
INSERT INTO ask_userlog VALUES ('21','e19064e30d','answer','1457184804');
INSERT INTO ask_userlog VALUES ('22','34d13ba84b','answer','1457233300');
INSERT INTO ask_userlog VALUES ('23','11aa1e2d23','answer','1458447078');
INSERT INTO ask_userlog VALUES ('24','1a8f288ad9','answer','1460514897');
INSERT INTO ask_userlog VALUES ('25','d8fe5df82d','answer','1460514918');
INSERT INTO ask_userlog VALUES ('26','08364501f1','answer','1460530521');
INSERT INTO ask_userlog VALUES ('27','445f745e4a','answer','1460530635');
INSERT INTO ask_userlog VALUES ('28','08364501f1','answer','1460537233');
INSERT INTO ask_userlog VALUES ('29','2a042e99e7','ask','1461119141');
INSERT INTO ask_userlog VALUES ('30','4fdea322a2','answer','1462863433');
INSERT INTO ask_userlog VALUES ('31','4fdea322a2','answer','1462864373');
INSERT INTO ask_userlog VALUES ('32','4fdea322a2','answer','1462864406');
INSERT INTO ask_userlog VALUES ('33','4afea7c0d1','ask','1463474495');
INSERT INTO ask_userlog VALUES ('34','907b78e0d5','ask','1464239829');
INSERT INTO ask_userlog VALUES ('35','a504b20bde','ask','1464240692');
INSERT INTO ask_userlog VALUES ('36','a504b20bde','ask','1464240737');
INSERT INTO ask_userlog VALUES ('37','a504b20bde','ask','1464241111');
INSERT INTO ask_userlog VALUES ('38','a504b20bde','ask','1464241611');
INSERT INTO ask_userlog VALUES ('39','a504b20bde','ask','1464241681');
INSERT INTO ask_userlog VALUES ('40','a504b20bde','ask','1464241769');
INSERT INTO ask_userlog VALUES ('41','a504b20bde','ask','1464241810');
INSERT INTO ask_userlog VALUES ('42','a504b20bde','ask','1464241874');
INSERT INTO ask_userlog VALUES ('43','a504b20bde','ask','1464241935');
INSERT INTO ask_userlog VALUES ('44','a504b20bde','ask','1464241952');
INSERT INTO ask_userlog VALUES ('45','a504b20bde','ask','1464241964');
INSERT INTO ask_userlog VALUES ('46','a504b20bde','ask','1464242027');
INSERT INTO ask_userlog VALUES ('47','a504b20bde','ask','1464242043');
INSERT INTO ask_userlog VALUES ('48','a504b20bde','ask','1464242203');
INSERT INTO ask_userlog VALUES ('49','a504b20bde','ask','1464242214');
INSERT INTO ask_userlog VALUES ('50','a504b20bde','ask','1464242325');
INSERT INTO ask_userlog VALUES ('51','a504b20bde','ask','1464242342');
INSERT INTO ask_userlog VALUES ('52','a504b20bde','ask','1464242379');
INSERT INTO ask_userlog VALUES ('53','a504b20bde','ask','1464242413');
INSERT INTO ask_userlog VALUES ('54','a504b20bde','ask','1464242435');
INSERT INTO ask_userlog VALUES ('55','5752473257','answer','1464677783');
INSERT INTO ask_userlog VALUES ('56','d0f892a17d','answer','1465711163');
INSERT INTO ask_userlog VALUES ('57','d0f892a17d','ask','1466660823');
INSERT INTO ask_userlog VALUES ('58','475072eec8','ask','1466660983');
INSERT INTO ask_userlog VALUES ('59','475072eec8','ask','1466664256');
INSERT INTO ask_userlog VALUES ('60','a85f1a8343','ask','1467876119');
INSERT INTO ask_userlog VALUES ('61','a85f1a8343','ask','1467878024');
INSERT INTO ask_userlog VALUES ('62','5972d741af','ask','1472540673');
INSERT INTO ask_userlog VALUES ('63','5972d741af','ask','1472541423');
INSERT INTO ask_userlog VALUES ('64','5972d741af','ask','1472541763');
INSERT INTO ask_userlog VALUES ('65','5972d741af','ask','1472546460');

DROP TABLE IF EXISTS ask_visit;
CREATE TABLE `ask_visit` (
  `ip` varchar(15) NOT NULL,
  `time` int(10) NOT NULL DEFAULT '0',
  KEY `ip` (`ip`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ask_weixin_follower;
CREATE TABLE `ask_weixin_follower` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `openid` varchar(200) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `language` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `headimgurl` varchar(200) NOT NULL,
  `privilege` varchar(200) NOT NULL,
  `unionid` varchar(200) NOT NULL,
  `sex` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_weixin_info;
CREATE TABLE `ask_weixin_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `msg` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO ask_weixin_info VALUES ('1','很高兴认识你');

DROP TABLE IF EXISTS ask_weixin_keywords;
CREATE TABLE `ask_weixin_keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `txtname` varchar(200) NOT NULL,
  `txtcontent` varchar(200) NOT NULL,
  `txttype` varchar(200) NOT NULL,
  `showtype` int(10) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `fmtu` varchar(200) NOT NULL,
  `wzid` int(10) NOT NULL,
  `wburl` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_weixin_menu;
CREATE TABLE `ask_weixin_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(200) NOT NULL,
  `menu_type` varchar(200) NOT NULL,
  `menu_keyword` varchar(200) NOT NULL,
  `menu_link` varchar(200) NOT NULL,
  `menu_pid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS ask_weixin_setting;
CREATE TABLE `ask_weixin_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `wxname` varchar(200) NOT NULL,
  `wxid` varchar(200) NOT NULL,
  `weixin` varchar(200) NOT NULL,
  `appid` varchar(200) NOT NULL,
  `appsecret` varchar(200) NOT NULL,
  `winxintype` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


