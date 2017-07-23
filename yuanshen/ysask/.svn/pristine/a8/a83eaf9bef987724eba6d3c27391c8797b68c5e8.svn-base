<?php
namespace Common\Model;
use Think\Model;
class UserModel extends CommonModel{

    protected $pk = 'id';
    protected $tableName = 'user';

	protected $insertFields	= array('username','password','sex','birthday','city','title','introduction','email','status','avatar','phone','level','money','experience','fans','question','answer','invite','adopt','article','created_time','updated_time','register_ip','last_login_ip','last_login_time'); //

	protected $updateFields	= array('username','password','sex','birthday','city','title','introduction','email','status','avatar','phone','level','money','experience','fans','question','answer','invite','adopt','article','updated_time','last_login_ip','last_login_time','agree','disagree'); // 编辑数据时允许写入的字段


	protected $_validate = array(
		array('username','require','用户名不能为空'),
		array('username',"/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]{1,20}$/u",'用户名格式错误'),
		array('username','','抱歉，该用户名已被注册',0,'unique'),
		array('phone','require','请填写手机号'),
		array('phone',"/^1([3-5]|7|8])\\d{9}$/",'号码格式错误'),
		array('phone','','抱歉，该号码已被注册',0,'unique'),
        array('password',"/^[\w-\.]{8,20}$/",'密码格式错误'),
		array('repassword','password','确认密码和密码输入不一致',0,'confirm'),
		//array('sex','0,1','不敢相信你的性别',0,'notin'),
		//array('birthday',"1489129506,1489129569",'不敢相信你的年龄',0,'expire'),
		);
	protected $_auto = array(
		array('password','substr_pwd',3,'function'),//密码加密处理
		array('created_time','time',1,'function'),
		array('updated_time','time',3,'function'),
		array('register_ip','get_client_ip',1,'function'),
		array('last_login_ip','get_client_ip',1,'function'),
		array('last_login_time','time',1,'function'),
		);

	//根据用户id获取用户信息
    public function get_user_info($id){
    	//获取用户信息
		$array['user'] = M('User')->where('id='.$id)->find();
		//获取专业认证信息
		$where['user_id'] = $id;
		$where['status'] = 1;
		$array['professor'] = M('Professor')->where($where)->find();
		return $array;
    }

	/*活跃用户*/
    public function activities($limit=8)
    {
        $sql = "SELECT `id`,`username`,`avatar`,`experience`,`money` FROM __TABLE__ WHERE `status`>'0' ORDER BY `answer` DESC,`article` DESC,`updated_time` DESC LIMIT ".$limit;
        return $this->query($sql);
    }


    /**
     * 排行榜-热门作者
     * @param  [int] $limit [查询条数]
     * @return [bool]        [返回值]
     */
    public function top($type,$limit)
    {
        $sql = "SELECT __USER__.`id`,__USER__.`username`,__USER__.`avatar`,__USER__.`title`,__USER__.`money`,__USER__.`experience`,__USER__.`fans`,__USER__.`answer`,__USER__.`article`,__USER__.`question`,__USER__.`agree`,__USER_DATA__.`email_status`,__USER_DATA__.`mobile_status` FROM __USER__ LEFT JOIN __USER_DATA__ ON __USER__.`id` = __USER_DATA__.`user_id` WHERE __USER__.`status` > '0' ORDER BY __USER__.`".$type."` DESC LIMIT " . $limit;
        return $this->query($sql);
    }



     /*话题详情页推荐用户*/
    public function recommendusers()
    {
        $sql = "select __USER__.*, __WATCH__.`source_id` as `pivot_source_id`, __WATCH__.`id` as `pivot_user_id` from __USER__ inner join __WATCH__ on __USER__.`id` = __WATCH__.`user_id` where __WATCH__.`source_id` = '1' and __WATCH__.`source_type` = 'Tag' order by __USER__.`money` desc, __USER__.`support` desc limit 10";
        return $this->query($sql);
    }

    /*活跃用户关联话题*/
    public function hotTags($uid)
    {
        if($uid = (int)$uid) {
            $sql = " SELECT DISTINCT `tag_id` FROM __USER_TAG__ where __USER_TAG__.`user_id`='$uid' AND __USER_TAG__.`user_id` IS NOT NULL ORDER BY `support` DESC,`answer` DESC,`created_time` DESC LIMIT 5";
            $hotTagIds = $this->query($sql);
            $tags = array();
            foreach($hotTagIds as $hotTagId){
                $tag = D('Tag')->find($hotTagId['tag_id']);
                if($tag){
                    $tags[] = $tag;
                }

            }
            return $tags;
        }
    }


    /*推荐专家*/
    public function tjUsers()
    {
        $sql = "select `__USER__`.`id`,`__USER__`.`avatar`, `__USER__`.`username`, `__USER__`.`description`, `__USER__`.`title`, `__USER__`.`money`, `__USER__`.`experience`, `__USER__`.`fans`,`__USER__`.`answer`, `__USER__`.`article`, `__PROFESSOR__`.`status`, `__PROFESSOR__`.`skill` from `__USER__` left join `__PROFESSOR__` on `__USER__`.`id` = `__PROFESSOR__`.`user_id` where `__USER__`.`status` > '0' and `__PROFESSOR__`.`status` = '1' order by `__USER__`.`answer` desc, `__USER__`.`article` desc, `__USER__`.`updated_time` desc limit 16";
        return $this->query($sql);
    }


    public function getxunrow()
    {
        $sql = "SELECT __TABLE__.`id`,__TABLE__.`description`,__TABLE__.`username` AS `title`,__TABLE__.`created_time` FROM __TABLE__";
        return $this->query($sql);
    }

    //  更新用户账户余额
    public function update_money($uids, $money, $intro='')
    {
        if(!$money = (float)$money){
            return false;
        }else if(empty($intro)){
            return false;
        }else{
            if($uids = check_ids($uids)){
                foreach(explode(',', $uids) as $uid){
                    $user = $this->find($uid);
                    $before_val = $user['money']; // 变动前的余额
                    if($money > 0){
                        //  充值
                        $sql = "UPDATE __USER__ SET `money`=`money`+{$money},`total_money`=`total_money`+{$money} WHERE id='$uid'";
                    }else{
                        //  提现或其他业务
                        $sql = "UPDATE __USER__ SET `money`=`money`+{$money} WHERE id='$uid'";
                    }
                    if($this->execute($sql)){
                        // 写入余额变动日志
                        $log = array('before_val'=>$before_val,'change_val'=>$money,'after_val'=>$before_val+$money,'intro'=>$intro);
                        D('Usermoneylog')->log($uid, $log);
                    }
                }
                return true;
            }
        }
        return false;
    }

    //  更新用户冻结余额
    public function update_block_money($uids, $money, $intro='', $type)
    {
        if(!$money = (float)$money){
            return false;
        }else if(empty($intro)){
            return false;
        }else{
            if($uids = check_ids($uids)){
                foreach(explode(',', $uids) as $uid){
                    $user = $this->find($uid);
                    $before_val = $user['pay_block_money']; // 变动前的冻结金
                    $sql = "UPDATE __USER__ SET `pay_block_money`=`pay_block_money`+{$money} WHERE id='$uid'";
                    if($this->execute($sql)){
                        // 写入冻结余额变动日志
                        $log = array('type'=>$type,'before_val'=>$before_val,'change_val'=>$money,'after_val'=>$before_val+$money,'intro'=>$intro);
                        D('Userblocklog')->log($uid, $log);
                    }
                }
                return true;
            }
        }
        return false;
    }


    //  更新用户账户总入账金币  充值、赚取
    public function update_total_money($uid, $money)
    {
        if($uid = (int)$uid){
            $sql = "UPDATE __TABLE__ SET `total_money`=`total_money`+{$money} WHERE id='$uid'";
            return $this->execute($sql);
        }
        return false;
    }

    //  向Ta提问时查询Ta的信息
    public function to_user_info($uid)
    {
        if($uid = (int)$uid) {
            $sql_user_professor = "SELECT  a.`username`,a.`level`,a.`avatar`,a.`sex`,a.`adopt`,a.`answer`,a.`fans`,b.`pay_money`,b.`status` FROM __USER__ a,__PROFESSOR__ b WHERE a.`id`=b.`user_id` AND a.`id`='{$uid}'";
            $user_professor = $this->query($sql_user_professor);
            $sql_usertag = "SELECT `tag_id` FROM __USER_TAG__ WHERE `user_id`='{$uid}'";
            $usertag = $this->query($sql_usertag);
            foreach($usertag as $k=>$v) {
                $tagids[] = $v['tag_id'];
            }
            $tag_ids = implode(',', $tagids);
            if($tag_ids) {
                $sql_tag = "SELECT `id`,`title` FROM __TAG__ WHERE `id` IN ({$tag_ids})";
                $tag = $this->query($sql_tag);
                foreach($tag as $k=>$v) {
                    $tag_title[] = $v['title'];
                }
                $tagtitle = implode(' ', $tag_title);
                $user_professor[0]['tag'] = $tagtitle;
            }
            return $user_professor[0];
        }
        return false;
    }
}