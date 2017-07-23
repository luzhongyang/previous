<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CloudAction extends CommonAction {

    protected $types = array();

    public function _initialize() {
        parent::_initialize();
        $this->types = D('Cloudgoods')->getType();
        $this->assign('types', $this->types);
    }

    public function index() {
        $goods = D('Cloudgoods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('audit' => 1, 'closed' => 0);
        $type = (int) $this->_param('type');
        if (!empty($type)) {
            $map['type'] = $type;
            $this->assign('type', $type);
        }
        if ($area_id = (int) $this->_param('area_id')) {
            $map['area_id'] = $area_id;
            $this->assign('area_id', $area_id);
        }
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title|intro'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        $count = $goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $goods->where($map)->order(array('goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function cloudbuy() {
        if (empty($this->uid)) {
            $this->ajaxReturn(array('status' => 'login'));
        }
        $goods_id = (int) $_POST['goods_id'];
        $detail = D('Cloudgoods')->find($goods_id);
        if (empty($detail)) {
            $this->ajaxReturn(array('status' => 'error', 'msg' => '该云购商品不存在'));
        }
        $obj = D('Cloudgoods');
        $logs = D('Cloudlogs');
        if (IS_AJAX) {
            $num = (int) $_POST['num'];
            if (empty($num)) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '数量不能为空'));
            }
            if ($num < $this->types[$detail['type']]['num'] || $num % $this->types[$detail['type']]['num'] != 0) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '数量不正确'));
            }
            $count = $logs->where(array('goods_id' => $goods_id, 'user_id' => $this->uid))->sum('num');
            $left = $detail['max'] - $count;
            $lefts = $detail['price'] - $detail['join'];
            ($left <= $lefts) ? $limit = $left : $limit = $lefts;
            if ($num > $limit) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '您最多能购买' . $limit . '人次'));
            }
            if ($this->member['money'] < $num * 100) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '抱歉，您的余额不足','back_url'=>U('cloud/detail',array('goods_id'=>$goods_id)), 'url' => U('member/money/money')));
            }
            if (false !== $obj->cloud($goods_id, $this->uid, $num)) {
                $details = D('Cloudgoods')->find($goods_id);
                if($details['join'] >= $details['price']){
                    $obj->lottery($goods_id);
                }
                $this->ajaxReturn(array('status' => 'success', 'msg' => '云购成功，请等待结果或者继续加注'));
            } else {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '云购失败'));
            }
        }
    }

    public function detail($goods_id = 0) {
        if ($goods_id = (int) $goods_id) {
            $obj = D('Cloudgoods');
            if (!$detail = $obj->find($goods_id)) {
                $this->error('没有该商品');
            }
            $thumb = unserialize($detail['thumb']);
            $count = D('Cloudlogs')->where(array('goods_id' => $goods_id, 'user_id' => $this->uid))->sum('num');
            $left = $detail['max'] - $count;
            $cloudlogs = D('Cloudlogs');

            $map = array('goods_id' => $goods_id);
            $list = $cloudlogs->where($map)->order(array('log_id' => 'asc'))->select();
            $lists = $obj->get_datas($list);
           
            $listss = $user_ids = array();
            foreach ($lists as $k => $val) {
                $user_ids[$val['user_id']] = $val['user_id'];
                $listss[date('Y-m-d', $val['create_time'])][date('H:i:s', $val['create_time']) . '.' .$val['microtime']][] = $val;
            }
            krsort($listss);
            foreach($listss as $k=>$val){
                krsort($listss[$k]);
            }
            $this->assign('users',D('Users')->itemsByIds($user_ids));
            $this->assign('list',$listss);
            $this->assign('left', $left);
            $this->assign('thumb', $thumb);
            $this->assign('detail', $detail);
            if($detail['status'] == 1){
                redirect(U('cloud/zhong',array('goods_id'=>$goods_id)));
            }else{
                $this->display();
            }
        } else {
            $this->error('没有该商品');
        }
    }

    public function zhong($goods_id) {
        if ($goods_id = (int) $goods_id) {
            $obj = D('Cloudgoods');
            if (!$detail = $obj->find($goods_id)) {
                $this->error('没有该商品');
            }
            if($detail['status'] !=1||empty($detail['win_number'])||empty($detail['win_user_id'])){
                $this->error('该商品还未开奖');
            }
            $cloudlogs = D('Cloudlogs');

            $map = array('goods_id' => $goods_id);
            $list = $cloudlogs->where($map)->order(array('log_id' => 'asc'))->select();
            $lists = $obj->get_datas($list);
           
            $listss = $user_ids = array();
            foreach ($lists as $k => $val) {
                $user_ids[$val['user_id']] = $val['user_id'];
                $listss[date('Y-m-d', $val['create_time'])][date('H:i:s', $val['create_time']) . '.' .$val['microtime']][] = $val;
            }
            krsort($listss);
            foreach($listss as $k=>$val){
                krsort($listss[$k]);
            }
            $this->assign('users',D('Users')->itemsByIds($user_ids));
            $this->assign('list',$listss);

            
            //中奖信息必须根据原list算法算出，不然不对
            
            $win_list = $cloudlogs->where($map)->order(array('log_id' => 'asc'))->select();
            $win_lists = $obj->get_datas($win_list);
            $win_listss = array();
            foreach ($win_lists as $k => $val) {
                if($val['user_id'] == $detail['win_user_id']){
                    $win_listss[date('Y-m-d H:i:s', $val['create_time']) . '.' .$val['microtime']][] = $val;
                }
            }
            $this->assign('lists',$win_listss);
            $total = $cloudlogs->where(array('goods_id'=>$goods_id,'user_id'=>$detail['win_user_id']))->sum('num');
            $return = $obj->get_last50_time($list);
            
            
            $this->assign('return',$return);
            $this->assign('total',$total);
            $u_list = array();
            foreach ($win_lists as $k=>$val){
                 if($val['user_id'] == $detail['win_user_id']){
                     $u_list[] = $val;
                 }
            }
            $this->assign('u_list',$u_list);
            $this->assign('detail', $detail);
            $this->display();
        } else {
            $this->error('没有该商品');
        }
    }

}
