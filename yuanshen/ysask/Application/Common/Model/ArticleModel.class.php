<?php
namespace Common\Model;
use Think\Model;

class ArticleModel extends CommonModel{

	protected $pk = 'id';
    protected $tableName = 'article';

    protected $insertFields = array('user_id', 'category_id','category_name','tag_id','money','title', 'content', 'summary', 'status', 'logo', 'updated_time', 'created_time');

    protected $updateFields = array('user_id', 'category_id','category_name','tag_id','title','content', 'summary', 'status', 'logo', 'updated_time');

    //  自动验证
    protected $_validate = array(
        array('title', 'require', '文章标题不能为空！', 1, 'regex', 3),
        array('summary', 'require', '文章概述不能为空！', 1, 'regex', 3),
        array('content', 'require', '文章内容不能为空！', 1, 'regex', 3),
        array('category_id', '/^[1-9]\d*$/', '请选择分类！', 1, 'regex', 3),
        // array('tag_id', '/^[1-9]\d*$/', '请选择话题！', 1, 'regex', 3),
    );

    // 	自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);

	/*推荐文章*/
    public function recommended()
    {
    	$map['status'] = array('gt',0);
    	$orderby = array('support'=>'desc','created_time'=>'desc');
    	$fields = 'id,title,support';
        $list = $this->where($map)->order($orderby)->limit(8)->getField($fields);
        return $list;
    }


    /*根据tagid获取前台话题页文章列表*/
    public function topitems($id)
    {
        //$sql = "select __ARTICLE__.*, __TAGGED__.`tag_id` as `pivot_tag_id`, __TAGGED__.`tagged_id` as `pivot_tagged_id` from __ARTICLE__ inner join __TAGGED__ on __ARTICLE__.`id` = __TAGGED__.`tagged_id` where __TAGGED__.`tag_id` = '1' and __TAGGED__.`tagged_type` = 'Article' order by `created_time` desc limit 15 offset 0";
        //return $this->query($sql);
        $where['tag_ids'] = array('like',','.$id.',');
        $article = M('Article')->where($where)->limit(15)->order('created_time desc')->select();
        return $article;
    }


    public function getxunrow()
    {
        $sql = "SELECT __TABLE__.`id`,__TABLE__.`title`,__TABLE__.`summary` AS `description`,__TABLE__.`created_time` FROM __TABLE__";
        return $this->query($sql);
    }

    public function getMoneyPack()
    {
        return array(0,10,20,50,100,200);
    }
}