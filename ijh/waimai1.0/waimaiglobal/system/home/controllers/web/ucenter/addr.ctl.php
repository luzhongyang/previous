<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Web_Ucenter_Addr extends Ctl_Web_Ucenter {


    public function index($page=1)
    {
        $page = max((int)$page, 1);
        $filter = array();
        $limit = 10;
        $filter['uid'] = $this->uid;
        if($items = K::M('member/addr')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'web/ucenter/addr/items.html';
    }
    
    public function create() {
        if (empty($this->uid)) {
            $this->msgbox->add(L('请先登陆后操作'), 101);
        } else {
            if (IS_AJAX) {
                if ($params = $this->checksubmit('params')) {
                    if (empty($params['contact'])) {
                        $this->msgbox->add(L('联系人不能为空'), 221);
                    } elseif (!$params['mobile'] = K::M('verify/check')->mobile($params['mobile'])) {
                        $this->msgbox->add(L('手机号码不正确'), 222);
                    } elseif (empty($params['addr'])) {
                        $this->msgbox->add(L('位置不能为空'), 223);
                    } elseif (empty($params['house'])) {
                        $this->msgbox->add(L('详细地址不能为空'), 224);
                    } elseif (!$params['lng'] || !$params['lat']) {
                        $this->msgbox->add(L('地址坐标不正确'), 224);
                    } else {
                        $params['uid'] = $this->uid;
                        if ($addr_id = K::M('member/addr')->create($params)) {
                            $this->msgbox->add(L('添加地址成功'));
                            $addrs = K::M('member/addr')->items(array('uid' => $this->uid), array('addr_id' => 'desc'));
                            $this->msgbox->set_data('addrs', array_values($addrs));
                            $this->msgbox->set_data('addr_id', $addr_id);
                        } else {
                            $this->msgbox->add(L('添加失败'), 250);
                        }
                    }
                }
            }
        }
    }
    
   public function edit() 
    {
        if ($params = $this->checksubmit('params')) {
            if(!K::M('verify/check')->len(strlen($params['contact']),6,16)) {
                $this->msgbox->add(L('联系人长度为6至18位字符'),210);
            }else if(!K::M('verify/check')->mobile($params['mobile'])){
                $this->msgbox->add(L('手机号不正确'),211);
            }else if(!$params['addr']||!$params['house']) {
                $this->msgbox->add(L('收货地址不能为空'),212);
            }else if(!$params['lng'] || !$params['lat']) {
                $this->msgbox->add(L('经纬度不正确'),213);
            }else if(!$detail = K::M('member/addr')->detail($params['addr_id'])) {
                $this->msgbox->add(L('地址不存在或已被删除'),214);
            }else if($detail['uid'] != $this->uid) {
                $this->msgbox->add(L('非法操作'),216);
            }else if($params['contact']==$detail['contact'] && $params['mobile']==$detail['mobile'] && $params['house']==$detail['house']) {
                $this->msgbox->add(L('您未做任何修改'),215);
            }else {
                if(K::M('member/addr')->update($params['addr_id'],$params)){
                    $this->msgbox->add(L('修改地址成功'));
                }else {
                    $this->msgbox->add(L('修改地址失败'),209);
                }   
            }
        }
    }
    
    public function delete($addr_id)
    {
        $addr_id = (int)$addr_id;
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
           $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),211);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add(L('地址删除成功'));
            }else {
                $this->msgbox->add(L('删除失败'),212);
            }  
        }         
    } 
    
    public function set_default($addr_id)
    {
        $addr_id = (int)$addr_id;
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
            $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),211);
        }else {
            if(K::M('member/addr')->set_default($this->uid,$addr_id)) {
                $this->msgbox->add(L('设置默认地址成功'));
            }else {
                $this->msgbox->add(L('设置默认地址失败'),212);
            }
        }
    }

}
