<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CloudAction extends CommonAction {

    public function _initialize() {
        parent::_initialize();
        $this->types = D('Cloudgoods')->getType();
        $this->assign('types', $this->types);
    }

    public function index() {
        $linkArr = array();
        $type = (int) $this->_param('type');
        if (!empty($type)) {
            $this->assign('type', $type);
            $linkArr['type'] = $type;
        }
        $this->assign('nextpage', LinkTo('cloud/loaddata',$linkArr,array('t' => NOW_TIME, 'p' => '0000')));
        $this->assign('linkArr',$linkArr);
        $this->mobile_title = '云购首页';
        $this->display(); // 输出模板
    }

    public function loaddata(){
        $goods = D('Cloudgoods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('audit' => 1, 'closed' => 0,'city_id'=>$this->city_id);
        $type = (int) $this->_param('type');
        if (!empty($type)) {
            $map['type'] = $type;
            $this->assign('type', $type);
            $linkArr['type'] = $type;
        }
        $count = $goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $goods->where($map)->order(array('status' => 'asc', 'goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
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
                $this->ajaxReturn(array('status' => 'error', 'msg' => '抱歉，您的余额不足','back_url'=>U('mobile/cloud/detail',array('goods_id'=>$goods_id)), 'url' => U('mcenter/money/index')));
            }
            if (false !== $obj->cloud($goods_id, $this->uid, $num)) {
                $details = D('Cloudgoods')->find($goods_id);
                if($details['join'] >= $details['price']){
                    $obj->lottery($goods_id);
                }
                $this->ajaxReturn(array('status' => 'success', 'msg' => '云购成功'));
            } else {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '云购失败'));
            }
        }
    }
	
	public function cloudbuy1() {
        if (empty($this->uid)) {
            $this->ajaxReturn(array('status' => 'login', 'url' => U('mcenter/money/index')));
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
                $this->ajaxReturn(array('status' => 'error', 'msg' => '抱歉，您的余额不足','back_url'=>U('mobile/cloud/detail',array('goods_id'=>$goods_id)), 'url' => U('mcenter/money/index')));
            }
            if (false !== $obj->cloud($goods_id, $this->uid, $num)) {
                $details = D('Cloudgoods')->find($goods_id);
                if($details['join'] >= $details['price']){
                    $obj->lottery($goods_id);
                }
                $this->ajaxReturn(array('status' => 'success', 'msg' => '云购成功'));
            } else {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '云购失败'));
            }
        }
    }

    public function detail($goods_id) {
        if ($goods_id = (int) $goods_id) {
            $obj = D('Cloudgoods');
            if (!$detail = $obj->find($goods_id)) {
                $this->error('没有该商品');
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $this->error('没有该商品');
            }
            $thumb = unserialize($detail['thumb']);
            $this->assign('thumb', $thumb);
             $count = D('Cloudlogs')->where(array('goods_id' => $goods_id, 'user_id' => $this->uid))->sum('num');
            $left = $detail['max'] - $count;
            
            $cloudlogs = D('Cloudlogs');
            $map = array('goods_id' => $goods_id);
            $list = $cloudlogs->where($map)->order(array('log_id' => 'desc'))->select();
            $user_ids = array();
            foreach ($list as $k => $val) {
                $user_ids[$val['user_id']] = $val['user_id'];
            }
            $this->assign('users', D('Users')->itemsByIds($user_ids));
            $this->assign('list',$list);
            $total = $cloudlogs->where(array('goods_id' => $goods_id, 'user_id' => $detail['win_user_id']))->sum('num');
            
            $data_all = $obj->get_datas($list);
            $return = $obj->get_last50_time($list);
            $zhongjiang = fmod($return['total'],$detail['price'])  + 10000001;
            
            $zhong = $data_all[$zhongjiang];
            $this->assign('zhong',$zhong);
            $this->assign('total', $total);
            $this->assign('left',$left);
            $this->assign('detail', $detail);
            $this->mobile_title = '云购详情';
            $this->display();
        } else {
            $this->error('没有该商品');
        }
    }

}
