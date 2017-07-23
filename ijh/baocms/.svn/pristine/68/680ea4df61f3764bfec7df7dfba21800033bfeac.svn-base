<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class MoreAction extends CommonAction {


    public function index() {
        $hs = D('Houseworksetting');
        $workTypes = D('Housework')->getCfg();
        $hslist = $hs->select();
        $list = array();
        foreach ($workTypes as $k => $val) {
            foreach ($hslist as $kk => $v) {
                if ($k == $v['id']) {
                    $list[$k] = $v;
                }
            }
            $list[$k]['t'] = $val;
        }
        $this->assign('list', $list);
        $this->assign('channelmeans', D('Lifecate')->getChannelMeans());
        $this->assign('elecates',D('Ele')->getEleCate());
        $this->display(); // 输出模板
    }

}
