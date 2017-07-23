<?php
/* * 
 * 系统权限配置，角色管理
 */
namespace Admin\Controller;
use Think\Controller;
class AuthGroupController extends CommonController{
	//搜索
	public function _filter(&$map){
		$map['title'] = array('like',"%".$_REQUEST['name']."%");
	}
	public function _before_add() {
		$list['orders'] = D('AuthGroup')->max('orders')+1; //自动填充排序
		$this->assign($list);
	}
	//分配权限
	public function access(){
		$id=I('get.id');
		// 获取用户组数据
		$group_data = M('AuthGroup')->where(array('id'=>$id))->find();
		$group_data['rules'] = explode(',', $group_data['rules']);
		// 获取规则数据
		$rule_data = D('AuthRule')->getTreeData('level','sort','title');
		$assign = array(
			'group_data'=>$group_data,
			'rule_data'=>$rule_data
		);
		$this->assign($assign);
		$this->display();
	}
	public function access_insert(){
		if(IS_POST){
			$data = I('post.');
			$map = array(
				'id'=>$data['id']
			);
			$data['rules'] = implode(',', $data['rule_ids']);
			D('AuthGroup')->editData($map,$data);
			$this->success('操作成功',U('AuthGroup/index'));
		}else{
			$this->success('错误操作!');
		}
	}

	//权限组用户列表
	public function user(){
		$group_id =  isset($_GET['id'])?$_GET['id']:'';
		$access = D('AuthGroupAccess');
		$list = $access->where('group_id='.$group_id)->select();		
		$ids = array(); 
		$ids = array_column($list,'uid'); 
		$ids = implode(",",$ids);
		if($ids){
			$admin = D('admin');
			$userlist = $admin->where('id in ('.$ids.')')->select();
			$this->assign('list',$userlist);
		}				
		$this->display();
	}
}
