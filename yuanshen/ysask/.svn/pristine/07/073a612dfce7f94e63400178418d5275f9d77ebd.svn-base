<?php
namespace Common\Model;
use Think\Model;

class CommentModel extends CommonModel{

	protected $pk = 'id';
    protected $tableName = 'comment';

    protected $insertFields	= array('user_id','content','source_id','source_type','status','score','created_time');
	protected $updateFields	= array('id','status','agree','disagree','score','updated_time');

    protected $_validate = array(
        array('source_id', '/^[1-9]\d*$/', '要评论的内容不存在！', 1, 'regex', 3),
        array('source_type', 'require', '要评论的内容类型不正确！', 1, 'regex', 3),
        array('content', 'require', '评论内容不能为空', 1, 'regex', 3),
        array('user_id', '/^[1-9]\d*$/', '评论人不存在！', 1, 'regex', 3),
    );

	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);

}