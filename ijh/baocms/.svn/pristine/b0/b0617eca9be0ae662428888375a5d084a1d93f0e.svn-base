<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CrowdAction extends CommonAction {

   public function index() {
        $Goods = D('Goods');
		$Crowd = D('Goodscrowd');
        import('ORG.Util.Page'); // 导入分页类    
        $map = array('closed' => 0,'type'=>'crowd');
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
		if ($shop_id = (int) $this->_param('shop_id')) {
            $map['shop_id'] = $shop_id;
        }
		if ($status = (int) $this->_param('status')) {
            switch ($status) {
                case '1':
                    $map['audit'] = 0;// 未开始也就是未审核的
                    break;
                case '2':
                    $crowd_status = 0;// 众筹中
                    break;
                case '3':
                    $crowd_status = 1;// 成功
                    break;
                case '4':
                    $crowd_status = 2;// 失败
                break;
            }
        }
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $lists = $Goods->where($map)->order(array('audit' => 'asc', 'goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($lists as $k => $val) {
			$goods_ids[] = $val['goods_id']; 
            $val = $Goods->_format($val);
            $list[$val['goods_id']] = $val;
        }

		if($goods_ids){
			$f['goods_id'] = array('IN',implode(',',$goods_ids));
			$Crowd_list = $Crowd->where($f)->select();
			foreach($Crowd_list as $k => $v){
                if ($v['ltime'] <= time() && $v['have_price'] < $v['all_price']) {// 失败
                    $v['status'] = 2;
                }elseif($v['ltime'] > time() && $v['have_price'] < $v['all_price']){ // 众筹中
                    $v['status'] = 0;
                }else{
                    $v['status'] = 1;// 成功
                }
                
                if (isset($crowd_status) && $list[$v['goods_id']]['audit'] == 0) {//有状态条件并且该众筹未审核
                    unset($list[$v['goods_id']]);
                }elseif (isset($crowd_status) && $crowd_status !== $v['status']) {// 有状态条件并且不匹配
                    unset($list[$v['goods_id']]);
                }else{
                    $Crowd_lists[$v['goods_id']] = $v;
                }
			}
			$this->assign('crowd', $Crowd_lists);
		}
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

	/*public function lists($goods_id)
	{
		if ($goods_id = (int) $goods_id) {
			$Goods = D('Goods');
            $Goodslist = D('Goodslist');
			$Crowd = D('Goodscrowd');
			$detail = D('Goods')->find($goods_id);
			$this->assign('detail', $detail);
			$list = $Goodslist->where(array('goods_id' => $goods_id))->select();
			$this->assign('meals', $list);
			
			foreach($list as $k => $v){
				$user_ids[$v['uid']] = $v['uid'];
				$type_ids[$v['type_id']] = $v['type_id'];
			}
			if (!empty($type_ids)) {
				$this->assign('type', D('Goodstype')->itemsByIds($type_ids));
			}
			if (!empty($user_ids)) {
				$this->assign('users', D('Users')->itemsByIds($user_ids));
			}
			$this->display();
        } else {
            $this->baoError('请选择众筹');
        }
	}*/

    public function lists($type_id=0)
    {
        if(!$type_id = (int) $type_id){
            $this->baoError('未选择要查看的内容ID');
        }elseif ((!$detail = D('Goodstype')->find($type_id)) || (!$goods = D('Goods')->where(array('closed'=>0, 'goods_id'=>$detail['goods_id']))->find())) {
            $this->baoError('您要查看的内容不存在或已被删除');
        }elseif (!$goods_crowd = D('Goodscrowd')->find($detail['goods_id'])) {
            $this->baoError('您要查看的内容不存在或已被删除');
        }else{
            import('ORG.Util.Page'); // 导入分页类
            $count = D('Goodslist')->where(array('type_id'=>$type_id))->count(); // 查询满足要求的总记录数 
            $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show(); // 分页显示输出
            if ($list = D('Goodslist')->where(array('type_id'=>$type_id))->order(array('list_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select()) {
                $user_ids = $type_ids = array();
                foreach ($list as $k => $v) {
                    $user_ids[$v['uid']] = $v['uid'];
                    $type_ids[$v['type_id']] = $v['type_id'];
                }
                if (!empty($user_ids)) {
                    $this->assign('users', D('Users')->itemsByIds($user_ids));
                }
                if (!empty($type_ids)) {
                    $types = D('Goodstype')->itemsByIds($type_ids);
                }
                foreach ($list as $k => $v) {
                    $list[$k]['type'] = $types[$v['type_id']];
                }

                if ($goods_crowd['ltime'] <= time() && $goods_crowd['have_price'] < $goods_crowd['all_price']) {// 失败
                    $goods_crowd['status'] = 2;
                }elseif($goods_crowd['ltime'] > time() && $goods_crowd['have_price'] < $goods_crowd['all_price']){ // 众筹中
                    $goods_crowd['status'] = 0;
                }else{
                    $goods_crowd['status'] = 1;// 成功
                }
                $this->assign('goods_crowd', $goods_crowd);
                $this->assign('detail', $detail);
                $this->assign('meals', $list);
                $this->assign('page', $show); // 赋值分页输出
            }
            $this->display();
        }
    }

    public function delete($goods_id = 0) {
        $obj = D('Goods');
        if (is_numeric($goods_id) && ($goods_id = (int) $goods_id)) {
            $obj->save(array('goods_id' => $goods_id, 'closed' => 1));
            $this->baoSuccess('删除成功！', U('crowd/index'));
        } else {
            $goods_id = $this->_post('goods_id', false);
            if (is_array($goods_id)) {
                foreach ($goods_id as $id) {
                    $obj->save(array('goods_id' => $id, 'closed' => 1));
                }
                $this->baoSuccess('批量删除成功！', U('crowd/index'));
            }
            $this->baoError('请选择要删除的众筹');
        }
    }

    public function audit($goods_id = 0) {
        $obj = D('Goods');
        if (is_numeric($goods_id) && ($goods_id = (int) $goods_id)) {
            $obj->save(array('goods_id' => $goods_id, 'audit' => 1));
            $this->baoSuccess('审核成功！', U('crowd/index'));
        } else {
            $goods_id = $this->_post('goods_id', false);
            if (is_array($goods_id)) {
                foreach ($goods_id as $id) {
                    $obj->save(array('goods_id' => $id, 'audit' => 1));
                }
                $this->baoSuccess('批量审核成功！', U('crowd/index'));
            }
            $this->baoError('请选择要审核的众筹');
        }
    }

    public function detail($goods_id=0)
    {
        if(!$goods_id = (int) $goods_id){
            $this->baoError('请选择要查看的众筹ID');
        }elseif (!$detail = D('Goods')->where(array('goods_id'=>$goods_id, 'closed'=>0))->find()) {
            $this->baoError('您要查看的众筹不存在或已被删除');
        }else{
            import('ORG.Util.Page'); // 导入分页类
            $map = array('goods_id' => $goods_id);
            $count = D('Goodstype')->where($map)->count(); // 查询满足要求的总记录数 
            $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show(); // 分页显示输出
            $list = D('Goodstype')->where($map)->order(array('choujiang' => 'asc', 'type_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $this->assign('detail', $detail);
            $this->assign('meals', $list);
            $this->assign('page', $show); // 赋值分页输出
            $this->display();
        }
    }
}
