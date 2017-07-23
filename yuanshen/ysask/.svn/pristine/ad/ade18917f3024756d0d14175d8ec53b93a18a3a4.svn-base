<?php
namespace Common\Model;
use Think\Model;

class TagModel extends Model{

	protected $pk = 'id';
    protected $tableName = 'tag';

    protected $insertFields	= array('title','listdir','image','description','active','sort','seo_title','seo_keywords','seo_description','category_id'); // 新增数据时允许写入的字段
	protected $updateFields	= array('id','title','listdir','image','description','active','sort','seo_title','seo_keywords','seo_description','category_id','closed'); // 编辑数据时允许写入的字段

	// 自动验证设置
	protected $_validate = array(
		array('title','require','Tag标签名必填！',3),
		array('description','require','标签描述必填！',3),
		array('title','','TAG名称已存在',0,'unique',3),
	);

    //	自动填充设置
	protected $_auto = array(
		array('created_time','time',1,'function'), // 对create_time字段在更新的时候写入当前时间戳
		array('updated_time','time',2,'function'),
	);


	/*话题详情页相关标签*/
	public function relatetags()
	{
		$sql = "SELECT * FROM __TAG__ WHERE (`parent_id` = '0' AND `id` <> '1') or `parent_id` = '0' ORDER BY `watch` DESC LIMIT 25";
		return $this->query($sql);
	}

	public function getxunrow()
    {
        $sql = "SELECT __TABLE__.`id`,__TABLE__.`description`,__TABLE__.`name` AS `title`,__TABLE__.`created_time` FROM __TABLE__";
        return $this->query($sql);
    }

    /**
     * 根据tag_ids获取以id为键，title为值的数组，tag_ids为',1,2,3,'的字符串
     */
    public function getTitle($tag_ids){
    	$tag_ids=extract(',',$tag_ids);
		foreach($tag_ids as $tag_id){
			$tag_title = M('Tag')->getFieldById($tag_id,'title');
			$result[$tag_id]=$tag_title;
		}
		return $result;
    }
}