<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class TiebaAction extends CommonAction{
 
    public  function index($city_id = null){
		$Post = D('Post');
		if(!$city_id = (int)$city_id){
			$city_id = $CONFIG['site']['city_id'];
		}
		import('ORG.Util.Page');// 导入分页类
		$User = D('users');
		$map = array();
		$map['city__id'] = $city_id;
		$count = $Post->where($map)->count();// 查询满足要求的总记录数 
		$Page = new Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$list=$Post->where($map)->order('create_time desc')->select();
		if($list) {
			foreach ($list as $k => $val) {
				if(!$val['user_id']){
					$this->baoError('贴吧发布者ID错误');
				}
				$nickname = $User->where(array('user_id'=>$val['user_id']))->getField('nickname');
				$list[$k]['nickname'] = $nickname;
			}
		}
		$this->assign('cates', D('City')->fetchAll());
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);
		$this->display();
	}
	public  function delete($city_id = null, $post_id = null){
		if(!$city_id = (int)$city_id){
			$city_id = $CONFIG['site']['city_id'];
		}
		$Post = D('Post');
		$post_id = (int)$post_id;
		if(!$post_id){
			$this->baoError('贴吧ID错误');
		}else if($id =$Post->delete($post_id)){
			$this->baoSuccess('删除成功！',U('tieba/index'));
		}else{
			$this->baoError('删除失败！');
		}
	}
	public function audit($post_id) {
        $jifen = $this->CONFIG['integral']['tiezi'];
        if($post_id = (int) $post_id) {
            $obj = D('post');
            $tiezi = $obj -> find($post_id);
            $obj->save(array('post_id' => $post_id, 'audit' => 1));
            //给用户增加积分
            if($jifen){
                D('Users')->where(array('user_id'=>$tiezi['user_id']))->setInc('integral',$jifen);
                D('Userintegrallogs')->add(array(
                    'user_id'   => $tiezi['user_id'],
                    'integral'  => $jifen,
                    'intro'     => '发表帖子获得积分',
                    'create_time' => NOW_TIME,
                    'create_ip' => get_client_ip()
                ));
            }
            $this->baoSuccess('审核成功！', U('tieba/index'));
        } else {
            $tuan_id = $this->_post('post_id', false);
            if (is_array($post_id)) {
                $obj = D('post');
                foreach ($post_id as $id) {
                    $obj->save(array('post_id' => $id, 'audit' => 1));
                }
                $this->baoSuccess('审核成功！', U('tieba/index'));
            }
            $this->baoError('请选择要审核的抢购');
        }
    }
}
?>
