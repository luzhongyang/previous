<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class CloudAction extends CommonAction {

  
public function index() {
        $cloudlogs = D('Cloudlogs');
        $cloudgoods = D('Cloudgoods');
        import('ORG.Util.Page'); // 导入分页类
        $goods_ids = $cloudlogs->where(array('user_id' => $this->uid))->getField('goods_id', true);
        array_unique($goods_ids);
        $map = array('closed' => 0, 'audit' => 1); //这里只显示 实物
        $map['goods_id'] = array('IN', $goods_ids);
        if (isset($_GET['st']) || isset($_POST['st'])) {
            $st = (int) $this->_param('st');
            if ($st != 999) {
                $map['status'] = $st;
            }
            $this->assign('st', $st);
        } else {
            $this->assign('st', 0);
        }

        $count = $cloudgoods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $cloudgoods->where($map)->order(array('goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();


        $user_ids = array();
        foreach ($list as $k => $val) {
            $user_ids[$val['win_user_id']] = $val['win_user_id'];
            $sum = $cloudlogs->where(array('goods_id' => $val['goods_id'], 'user_id' => $this->uid))->sum('num');
            $list[$k]['sum'] = $sum;
            if (!empty($val['win_user_id'])) {
                $sum2 = $cloudlogs->where(array('goods_id' => $val['goods_id'], 'user_id' => $val['win_user_id']))->sum('num');
            }
            $list[$k]['sum2'] = $sum2;
            $res = $cloudlogs->where(array('goods_id' => $val['goods_id']))->order(array('log_id' => 'asc'))->select();
            $rlist = $cloudgoods->get_datas($res);
            foreach($rlist as $kk=>$v){
                if($v['user_id'] == $this->uid){
                    $list[$k]['mlist'][] = $rlist[$kk];
                }
            }
        }
        //dump($list);
        $this->assign('users', D('Users')->itemsByIds($user_ids));
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出    
        $this->mobile_title = '我的云购';
        $this->display();
    }

    
}
