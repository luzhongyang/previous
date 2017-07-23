<?php
/**
* 积分商城
*/
namespace Admin\Controller;
use Think\Controller;
class ShopController extends Controller{
	/**
	 * 搜索订单
	 */
	public function search_order(){
		$query=I('post.query');
		$Exchange = M('Exchange');
		$where['id'] = array('like','%'.$query.'%');
		$where['name'] = array('like','%'.$query.'%');
		$where['phone'] = array('like','%'.$query.'%');
		$where['address'] = array('like','%'.$query.'%');
		$where['_logic'] = 'OR';

		$order = $Exchange->where($where)->select();
		$this->assign('list',$order);
		$this->display('order');
	}

	/**
	 * 搜索商品
	 */
	public function search_goods(){
		$query=I('post.query');
		$result = search('goods',$query);
		$this->assign('list',$result);
		//分类
		$category = M('category')->where("type='goods'")->order('sort asc')->getField('id,title');
		$this->assign('category',$category);
		$this->display('goods');
	}

	/**
	 * 商品列表
	 */
	public function goods(){
		$category_id = 0;
		if((int)I('get.category_id') > 0) {
			$category_id = (int)I('get.category_id');
			$where = 'category_id='.$category_id;//商品类别
		}
		$Goods = M('Goods');
		$count = $Goods->count('id');
		$page = new \Think\Page($count,12);
		$list =  $Goods->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$list);

		//分类
		$category = M('category')->where("type='goods'")->order('sort asc')->getField('id,title');
		$this->assign('category',$category);
		$this->display();
	}

	/**
	 * 添加商品
	 */
	public function add(){
		//分类
		$category = M('category')->where("type='goods'")->order('sort asc')->select();
		$this->assign('category',$category);
		if(!empty($_POST)){
			//var_dump($_POST);exit;
			$Goods = D('Goods');
			$Goods->title = I('post.title');
			$Goods->category_id = (int)I('post.category');
			$Goods->image = I('post.image');
			$Goods->coin = (int)I('post.coin');
			$Goods->description = I('post.description');
			$Goods->status = (int)I('post.status');
			if (!$Goods->autoCheckToken($_POST)){
				$this->error('令牌验证错误');
 			}
			$new = $Goods->add();
			if($new){
				//添加索引
				$data = array(
					'id'=>$new,
					'title'=>I('post.title'),
					'description'=>I('post.description'),
					'created_time'=>time()
					);
				D('Search')->addIndex('goods',$data);
				$this->success('添加商品成功');
			}else{
				$this->error('添加商品失败');
			}
		}else{
			$this->display();
		}
	}

	/**
	 * 编辑商品
	 */
	public function edit(){
		//分类
		$category = M('category')->where("type='goods'")->order('sort asc')->select();
		$this->assign('category',$category);
		//判断商品是否存在
		$id = (int)I('id');
		$Goods = D('Goods');
		$old = $Goods->where('id='.$id)->find();
		if(empty($old)){
			$this->error('抱歉，未找到该商品的信息');
		}
		$this->assign('vo',$old);
		//处理表单
		if(!empty($_POST)){
			//var_dump($_POST);exit;
			$Goods->id = $id;
			$Goods->title = I('post.title');
			$Goods->category_id = (int)I('post.category');
			$Goods->image = I('post.image');
			$Goods->coin = (int)I('post.price');
			$Goods->description = I('post.description');
			$Goods->status = (int)I('post.status');
			if (!$Goods->autoCheckToken($_POST)){
				$this->error('令牌验证错误');
 			}
			$new = $Goods->save();
			if($new !== false){
				//更新索引
				$data = array(
					'id'=>$id,
					'title'=>I('post.title'),
					'description'=>I('post.description'),
				);
				$result = D('search')->updateIndex('goods',$data);
				if($result !== true){
					$this->error($result);
				}

				$this->success('编辑商品成功');
			}else{
				$this->error('编辑商品失败');
			}
		}else{
			$this->display();
		}
	}

	/**
	 * 删除商品,支持批量删除
	 */
	public function delete(){
		$ids = I('id');
		$Goods = M('Goods');
		//删除商品
		if(!$Goods->delete($ids)){
			$this->error('删除商品失败');
		}
		//删除索引
		$ids = explode(',', $ids);
		$de = D('search')->deleteIndex('goods',$ids);
		if($de !== true){
			$this->error($de);
		}
		$this->success('删除商品成功');
	}

	/**
	 * 商品类别列表
	 */
	public function category(){
		$category = M('Category')->where("type='goods'")->order('sort asc')->select();
		$this->assign('list',$category);
		$this->display();
	}

	/**
	 * 添加商品类别
	 */
	public function add_category(){
		if(!empty($_POST)){
			$Category = D('Category');
			if (!$Category->autoCheckToken($_POST)){
				$this->error('令牌验证错误');
 			}
			$Category->title = I('post.title');
			if(empty($Category->title)){
				$this->error('名称不能为空');
			}
			$Category->sort = I('post.sort',0);
			$Category->type = 'goods';
			$Category->created_time = time();

			//判断类别是否已存在
			if(!unique_category('goods',$Category->title)){
				$this->error('该类别已存在，请勿重复添加');
			}
			if($Category->add()){
				$this->success('添加成功','category');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}

	}

	/**
	 * 根据id编辑商品类别
	 */
	public function edit_category(){
 		$id = I('id');
 		if(empty($id)){
 			$this->error('类别id不能为空');
 		}
 		//判断类别是否存在
 		$old = M('Category')->where('id='.$id)->find();
 		if(empty($old)){
 			$this->error('未找到该类别','category');
 		}
		if(!empty($_POST)){
			$Category = D('Category');
			if (!$Category->autoCheckToken($_POST)){
				$this->error('令牌验证错误');
 			}
			$Category->title = I('post.title');
			if(empty($Category->title)){
				$this->error('名称不能为空');
			}
			$Category->sort = I('post.sort',0);
			$Category->type = 'goods';
			$Category->id = $id;
			$Category->updated_time = time();

			//判断修改后的类别是否已存在
			if(!unique_category('goods',$Category->title)){
				$this->error('该类别已存在，请勿重复添加');
			}
			$result = $Category->save();
			if($result !== false){
				$this->success('修改成功','category');
			}else{
				$this->error('修改失败');
			}
		}else{
			$this->assign('vo',$old);
			$this->display();
		}

	}

	/**
	 * 删除类别，递归删除类别下的所有商品
	 */
	public function delete_category(){
		$ids = I('ids');
		$Category = M('Category');
		if(!$Category->delete($ids)){
			$this->error('删除类别失败');
		}
		$ids = explode(',',$ids);
		$Goods = M('Goods');
		foreach($ids as $id){
			$goods = $Goods->where('Category_id='.$id)->delete();
			if($goods === false){
				$this->error('递归删除该类别下的商品失败');
			}
		}
		$this->success('删除类别成功');
	}

	/**
	 * 订单管理
	 */
	public function order(){
		$Exchange = M('Exchange');
		$list = $Exchange->order('id')->select();
		$this->assign('list',$list);
		$this->display();
	}

	/**
	 * 发货
	 */
	public function send_goods(){
		$id=(int)I('id');
		$Exchange = M('Exchange');
		$result = $Exchange->where('id='.$id)->setField('status',1);
		if($result !== false){
			$this->success('发货成功');
		}else{
			$this->error('发货失败');
		}
	}

	/**
	 * 删除订单
	 */
	public function delete_order(){
		$ids = I('ids');
	}

	/**
	 * 搜索
	 */
	public function search(){

	}
}