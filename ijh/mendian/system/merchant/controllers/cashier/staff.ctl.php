<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Staff extends Ctl
{
    protected $_allow_fields = 'staff_id,shop_id,is_owner,name,mobile,day_orders,day_cash,day_money,day_alipay,day_wxpay,day_chongzhi,day_refund,day_refund_cash,day_refund_money,day_refund_wxpay,day_refund_alipay,audit,loginip,lastlogin,closed,dateline';

    public function so()
    {
        $this->tmpl = 'merchant:cashier/staff/so.html';
    }

    public function index($page=1)
    {
        $filter = $pager = $items = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
            if($SO['mobile']){$filter['mobile'] = $SO['mobile'];}
        }
        $filter['closed'] = 0;
        $filter['shop_id'] = $this->shop_id;
        if($items = K::M('cashier/staff')->items($filter, null, $page, $limit, $count)){
            foreach ($items as $k => $v) {
                $v = $this->filter_fields($this->_allow_fields, $v);
                $items[$k] = $v;
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:cashier/staff/index.html';
    }
    
    public function create()
    {
        if ($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'name,mobile,passwd,audit')){
                $this->msgbox->add('非法的参数提交', 211);
            }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add("手机号码不正确", 212);
            }else if(empty($data['passwd'])){
                $this->msgbox->add('密码不能为空', 213);
            }else{
                /*$filter['closed'] = 1;
                $filter['shop_id'] = $this->shop_id;
                if ($items = K::M('cashier/staff')->items($filter)) {
                    $ids = array();
                    foreach ($items as $k => $v) {
                        $ids[] = $v['mobile'];
                    }
                    if (!empty($ids)) {
                        if (in_array($mobile, $ids)) {
                            if ($detail = K::M('cashier/staff')->find(array('shop_id'=>$this->shop_id, 'mobile'=>$mobile)) ) {
                                if($staff_id = K::M('cashier/staff')->update($detail['staff_id'], array('closed'=>0))){
                                    $this->msgbox->add('添加内容成功');
                                    $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/staff:index'));
                                }
                            }
                        }
                    }
                }else{*/
                    $data['shop_id'] = $this->shop_id;
                    $data['dateline'] = __TIME;
                    if($staff_id = K::M('cashier/staff')->create($data)){
                        $this->msgbox->add('添加内容成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/staff:index'));
                    }
                //}
            }
        }else{
            $this->tmpl = 'merchant:cashier/staff/create.html';
        }
    }

    public function edit($staff_id=0)
    {
        if(!($staff_id = (int)$staff_id) && !($staff_id = $this->GP('staff_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/staff')->detail($staff_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'name,mobile,passwd,audit')){
                $this->msgbox->add('非法的参数提交', 214);
            }else if(!$mobile = K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add("手机号码不正确", 215);
            }else if(empty($data['passwd'])){
                $this->msgbox->add('密码不能为空', 216);
            }else{
                if(K::M('cashier/staff')->update($detail['staff_id'], $data)){
                    $this->msgbox->add('修改内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/staff:index'));
                }
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:cashier/staff/edit.html';
        }
    }

    public function delete($staff_id=0)
    {
        if (($staff_id = (int)$staff_id) || ($staff_id = $this->GP($staff_id))) {
            if(!$detail = K::M('cashier/staff')->detail($staff_id)){
                $this->msgbox->add('内容不存在',212);
            }elseif($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作',213);
            }else{
                if(K::M('cashier/staff')->delete($detail['staff_id'])){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            if (!$staff_ids = $this->GP('staff_ids')) {
                $this->msgbox->add('未指定要删除的内容ID', 211);
            }elseif (!$staff_ids = K::M('verify/check')->ids($staff_ids)) {
                $this->msgbox->add('非法的参数提交', 212);
            }else{
                if($items = K::M('cashier/staff')->items_by_ids($staff_ids)){
                    $del_ids = array();
                    foreach($items as $v){
                        if($v['shop_id'] = $this->shop_id){
                            $del_ids[$v['staff_id']] = $v['staff_id'];
                        }
                    }
                    if($del_ids){
                        K::M('cashier/staff')->delete($del_ids);
                    }
                }
                $this->msgbox->add('删除内容成功');
            }
        }
    }

}