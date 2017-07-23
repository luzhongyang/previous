<?php
namespace Home\Controller;
use Home\Controller\EmptyController;

class ShopController extends EmptyController{
	//初始化
	protected function _initialize(){
		$this->goods_mod = D('goods');
		$this->category_mod = D('Category');
		$this->user_mod = D('User');
		$this->exchange_mod = D('Exchange');
		//最新用户兑换
		$new_exchange = $this->get_new_exchange();
		$this->assign('new_exchange',$new_exchange);
	}

	//商品列表
	public function index() {
		$where = 'status=1';
		$category_id = 0;
		if((int)I('get.category_id') > 0) {
			$category_id = (int)I('get.category_id');
			$where = 'category_id='.$category_id;//商品类别
		}
		$count = $this->goods_mod->where($where)->count('id');
		$page = new \Think\Page($count,12);
		$goods = $this->goods_mod->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('goods',$goods);
		$page_str = str_replace('/home/shop/index/', '/shop/', strtolower($page->show()));
		$this->assign('page',$page_str);

		//分类
		$category = $this->category_mod->where("type='goods'")->order('sort asc')->select();
		$this->assign('title','商城');
		$this->assign('category',$category);
		//$this->getseo('shop');
		$this->display();
	}

	//商品详情页
	public function detail() {
		if((int)I('get.id') > 0) {
			$id = (int)I('get.id');
			$goods = $this->goods_mod->where('id='.$id)->find();
			$this->assign('goods',$goods);
			$this->assign('title',$goods['title']);
			$this->display();
		}else {
			$this->msg('错误提示','非法访问！');
		}
	}

/*
	//商品兑换页
	public function exchange() {
		if((int)I('get.id') > 0) {
			$id = (int)I('get.id');
			$goods = $this->goods_mod->where('id='.$id)->find();
			$this->assign('goods',$goods);
			$this->assign('title','兑换商品');
			$this->display();
		}else {
			$this->msg('错误提示','非法访问！');
		}
	}
*/
	//商品下单,只限一样商品
	public function order() {
		//判断用户是否登录
		if(!session('user.id')){
			$this->error('请先登录','/login');
		}

		$goods_id = (int)I('goods_id');
		$goods = $this->goods_mod->where('id='.$goods_id)->find();

		if(!empty($_POST)){
			if (!$this->exchange_mod->autoCheckToken($_POST)){
				$this->error('令牌验证错误');
 			}
			$num = (int)I('post.num');
			$user = $this->user_mod->where('id='.session('user.id'))->find();
			if($user['coin'] >= $amount) {
				$exchange = $this->exchange_mod;
				$exchange['id'] = time().rand_six_num();
				$exchange['user_id'] = $this->user['id'];
				$exchange['goods_id'] =$goods_id;
				$exchange['num'] = $num;
				$exchange['coin'] = $amount;
				$exchange['name'] = I('post.name');
				$exchange['phone'] = I('post.phone');
				$exchange['address'] = I('post.address');
				$exchange['status'] = 0;
				$exchange['created_time'] = time();

				//插入新纪录
				$exchange->add();
				//扣除金币
				$this->user_mod->where('id='+$user['id'])->setDec('coin',$amount);
				//更新商品库存
				$this->goods_mod->where('id='+$goods['id'])->setDec('stock',$num);
				$this->success('商品兑换成功~');
			}
			$this->ajaxReturn(array('err' => 0,'msg' => '当前'.C('site_jifen').'不够!'));
		}else{
			$array['goods'] = $goods;
			$array['address'] = M('Address')->where('user_id='.session('user.id'))->select();
			$this->assign($array);
			$this->display();
		}
	}

	//获取新兑换记录
	private function get_new_exchange() {
		$exchange = $this->exchange_mod->order('id desc')->limit('0,6')->select();
		foreach ($exchange as $key => $value) {
			$user = M('user')->where('id='.$value['user_id'])->find();
			$exchange[$key]['user_info'] = $user;
		}
		return $exchange;
	}

	//取消订单
	public function cancel_order(){
		//判断用户是否登录
		if(!session('user.id')){
			$this->error('请先登录','/login');
		}

		$order_id = (int)I('order_id');
		//退回金币
		$order = $this->exchange_mod->where('order_id='.$order_id)->find();
		$user_id = $order['user_id'];
		$goods_id = $order['goods_id'];
		$this->user_mod->where('id='+$user['id'])->setInc('coin',$order['coin']);
		//恢复库存
		$this->goods_mod->where('id='.$goods_id)->setInc('stock',$order['num']);
		//删除兑换记录
		$this->exchange_mod->where('order_id='.$order_id)->delete();
		$this->success('取消订单成功');
	}

	//评价商品
}