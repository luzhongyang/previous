<?php
namespace Wap\Model;
use Think\Model;
class JokeModel extends Model{
	protected $insertFields	= array('cid','title','image','content','is_package','package_fee','package_user_id','type','status','user_id','audit_num','good_num','bad_num','review_num','share_num','award_num','tags_id','god_reply','reason','commend','related_content'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','cid','title','image','content','is_package','package_fee','package_user_id','type','status','user_id','audit_num','good_num','bad_num','review_num','share_num','award_num','tags_id','god_reply','reason','commend','related_content'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('title','require','标题必填！',1),
		array('content','require','内容必填',1),
		array('content','check_word','内容不能有非法关键词',1,'function'), // 自定义函数验证敏感词
		array('title','check_word','标题不能有非法关键词',1,'function'), // 自定义函数验证敏感词
	);

	// 自动填充设置
	protected $_auto = array(
		array('create_time','time',1,'function'),
		array('audit_time','time',1,'function'),
	);
}
