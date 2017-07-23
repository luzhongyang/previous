<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CrowdAction extends CommonAction
{

    public function index()
    {
        $map = array('uid' => $this->uid);
        $goods_array = D('Goodscrowd') -> select();
        $gl = D('Goodslist')->where($map)->select();
        $goods_ids = array();
        $goods=array();
        foreach($goods_array as $k => $v){
            if ($v['ltime'] <= time() && $v['have_price'] < $v['all_price']) {// 失败
                $v['status'] = 2;
            }elseif($v['ltime'] > time() && $v['have_price'] < $v['all_price']){ // 众筹中
                $v['status'] = 0;
            }else{
                $v['status'] = 1;// 成功
            }
            $goods[$v['goods_id']] = $v;
        }
        foreach($gl as $k => $v){
            $goods_ids[$v['goods_id']] = $v['goods_id'];
            $list[$k]['type'] = $types[$v['type_id']];
        }
        foreach($goods as $k => $v){
            if(!in_array($v['goods_id'],$goods_ids)){
                unset($goods[$k]);
            }
        }
        foreach($gl as $k => $v){
            if($v['is_zhong'] == 1){
                $goods[$v['goods_id']]['is_zhong'] = 1;
            }
        }
        $this->assign('goods',$goods);
        $this->display();
    }
    
    public function detail(){
        $goods_id =I('goods_id','','intval,trim');
        if(!$goods_id = (int) $goods_id){
            $this->baoError('没有选择众筹项目！');
        }
        if(!$goods_crowd = D('Goodscrowd')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        if(!$goods = D('Goods')->find($goods_id)){
            $this->baoError('众筹项目不存在！');
        }
        //参与记录
        $g = D('Goodslist'); // 实例化User对象
        import('ORG.Util.Page');// 导入分页类
        $where = array(
            'goods_id'=>$goods_id,
            'uid'=>$this->uid
        );
        $count      = $g->where($where)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $g->where($where)->order('list_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $uids = $type_ids =  array();
        foreach($list as $k => $v){
            $uids[$v['uid']] = $v['uid'];
            $type_ids[$v['type_id']] = $v['type_id'];
        }
        $users = D('Users')->itemsByIds($uids);
        $types = D('Goodstype')->itemsByIds($type_ids);
        foreach($list as $k => $v){
            $list[$k]['user'] = $users[$v['uid']];
            $list[$k]['type'] = $types[$v['type_id']];
        }

        if ($goods_crowd['ltime'] <= time() && $goods_crowd['have_price'] < $goods_crowd['all_price']) {// 失败
            $goods_crowd['status'] = 2;
        }elseif($goods_crowd['ltime'] > time() && $goods_crowd['have_price'] < $goods_crowd['all_price']){ // 众筹中
            $goods_crowd['status'] = 0;
        }else{
            $goods_crowd['status'] = 1;// 成功
        }
        $typelist = D('Goodstype')->where(array('goods_id'=>$goods_id))->select();
        $this->assign('typelist',$typelist);// 赋值数据集
        $this->assign('goods_crowd',$goods_crowd);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    /**
     * 确认收货状态
     */
    public function confirm_goods($list_id=0){
        if (!$list_id = (int) $list_id) {
            $this->baoError('未选择要操作的内容ID');
        }elseif (!$detail = D('Goodslist')->find($list_id)) {
            $this->baoError('您要操作的内容不存在或已被删除');
        }elseif ($detail['uid'] != $this->uid) {
            $this->baoError('不可越权操作！');
        }elseif ($detail['order_status'] != 1 || $detail['pay_status'] != 1) {// 没有发货或者没有支付的订单
            $this->baoError('非法操作！');
        }elseif (!$goods = D('Goods')->where(array('goods_id'=>$detail['goods_id'], 'closed'=>0))->find()) {
            $this->baoError('您要操作的内容不存在或已被删除');
        }elseif (!$shop = D('Shop')->where(array('shop_id'=>$goods['shop_id'], 'closed'=>0, 'audit'=>1))->find()) {
            $this->baoError('该商家不存在');
        }elseif (!$goodscrowd = D('Goodscrowd')->find($detail['goods_id'])) {
            $this->baoError('您要操作的内容不存在或已被删除');
        }elseif ($goodscrowd['ltime'] <= time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹失败(过期，钱没达标)
            $this->baoError('非法操作！');
        }elseif ($goodscrowd['ltime'] > time() && $goodscrowd['have_price'] < $goodscrowd['all_price']) {// 众筹中，不能提前确认收货(没过期，钱没达标)
            $this->baoError('众筹中不能提前确认收货');
        }else{
            // TO DO 结算取'total_price'字段
            if (D('Users')->find($shop['user_id'])) {
                if (D('Goodslist')->save(array('list_id' => $list_id, 'order_status' => 2))) {// 先更新，后加钱。避免并发
                    if (!empty($detail['total_price'])) {
                        D('Users')->updateCount($shop['user_id'], 'money', $detail['total_price']);
                        D('Usermoneylogs')->add(array(
                            'user_id' => $shop['user_id'],
                            'money' => $detail['total_price'],
                            'create_time' => time(),
                            'create_ip' => get_client_ip(),
                            'intro' => '用户'.$this->member["nickname"].'确认众筹订单(ID:'.$list_id.')成功！',
                        ));
                    }
                }
            }
            $this->baoSuccess('确认收货成功！',U('crowd/detail', array('goods_id' => $detail['goods_id'])));
        }
    }

}
