<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class EleAction extends CommonAction {

    private $create_fields = array('shop_id', 'distribution', 'is_open', 'is_pay', 'is_fan', 'fan_money', 'is_new', 'full_money', 'new_money', 'logistics', 'since_money', 'sold_num', 'month_num', 'intro', 'orderby');
    private $create_jqprint_fields = array('apiKey', 'mKey', 'partner', 'machine_code', 'auto_print', 'num', 'type');
    private $edit_jqprint_fields = array('apiKey', 'mKey', 'partner', 'machine_code', 'auto_print', 'num', 'type');
    protected $ele;

    public function _initialize() {
        parent::_initialize();
        $getEleCate = D('Ele')->getEleCate();
        $this->assign('getEleCate', $getEleCate);
        $this->ele = D('Ele')->find($this->shop_id);
        //print_r($this->ele);die;
        if (empty($this->ele) && ACTION_NAME != 'apply') {
            $this->error('您还没有入住外卖频道', U('ele/apply'));
        }
        if (!empty($this->ele) && $this->ele['audit'] == 0) {
            $this->error("亲，您的申请正在审核中！");
        }
     
        $this->assign('ele', $this->ele);
    }

    public function index() {
        $this->display();
    }

    public function setting(){
        $shopsetting = D('Shopsetting');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('shop_id' => $this->shop_id, 'closed' => 0);
        $count = $shopsetting->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        if ($list = $shopsetting->where($map)->select()) {
            if ( ($shop = D('Shop')->find($this->shop_id)) && $shop['closed'] != 1 && $shop['audit'] != 0) {
                $this->assign('shop', $shop);
            }
            $this->assign('list', $list); // 赋值数据集
            $this->assign('page', $show); // 赋值分页输出
        }
        $this->display(); // 输出模板
    }

    public function jqprint_create(){
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Shopsetting');
            if ($obj->add($data)) {
                $this->baoSuccess('添加成功', U('ele/setting'));
            }
            $this->baoError('操作失败！');
        } else {
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_jqprint_fields);
        if (empty($data['apiKey'])) {
            $this->baoError('API 密钥不能为空');
        }elseif (empty($data['mKey'])) {
            $this->baoError('终端密钥不能为空');
        }elseif (empty($data['partner'])) {
            $this->baoError('易连云用户ID不能为空');
        }elseif (empty($data['machine_code'])) {
            $this->baoError('终端号不能为空');
        }elseif ($data['auto_print'] != 0 && $data['auto_print'] != 1) {
            $this->baoError('非法的参数提交');
        }else{
            $data['type'] = htmlspecialchars($data['type']);
            $data['shop_id'] = $this->shop_id;
            $data['closed'] = 0;
            $data['num'] = (int) $data['num'];
            return $data;
        }
    }

    public function jqprint_edit($set_id = 0){
        $obj = D('Shopsetting');
        if (!$set_id = (int) $set_id) {
            $this->baoError('未选择的打印机ID');
        }elseif ( (!$detail = $obj->find($set_id)) || $detail['closed'] == 1) {
            $this->baoError('打印机不存在或已被删除');
        }elseif ($detail['shop_id'] != $this->shop_id) {
            $this->baoError('不可操作其他人的！');
        }else{
            if ($this->isPost()) {
                $data = $this->editCheck();
                $data['set_id'] = $detail['set_id'];
                if (false !== $obj->save($data)) {
                    $this->baoSuccess('操作成功', U('ele/setting'));
                }
                $this->baoError('操作失败');
            } else {
                $this->assign('detail', $detail);
                $this->display();
            }
        }
    }

    private function editCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->edit_jqprint_fields);
        if (empty($data['apiKey'])) {
            $this->baoError('API 密钥不能为空');
        }elseif (empty($data['mKey'])) {
            $this->baoError('终端密钥不能为空');
        }elseif (empty($data['partner'])) {
            $this->baoError('易连云用户ID不能为空');
        }elseif (empty($data['machine_code'])) {
            $this->baoError('终端号不能为空');
        }elseif ($data['auto_print'] != 0 && $data['auto_print'] != 1) {
            $this->baoError('非法的参数提交');
        }else{
            $data['type'] = htmlspecialchars($data['type']);
            $data['num'] = (int) $data['num'];
            return $data;
        }
    }

    public function jqprint_set($set_id = 0){
        $obj = D('Shopsetting');
        if (!$set_id = (int) $set_id) {
            $this->baoError('未选择的打印机ID');
        }elseif ( (!$detail = $obj->find($set_id)) || $detail['closed'] == 1) {
            $this->baoError('打印机不存在或已被删除');
        }elseif ($detail['shop_id'] != $this->shop_id) {
            $this->baoError('不可操作其他人的！');
        }else{
            if (false !== D('Shop')->save(array('shop_id' => $detail['shop_id'], 'jqprint_id' => $detail['set_id']))) {
                $this->baoSuccess('操作成功', U('ele/setting'));
            }
            $this->baoError('操作失败');
        }
    }

    public function jqprint_local(){
        if (false !== D('Shop')->save(array('shop_id' => $this->shop_id, 'jqprint_id' => 0))) {
            $this->baoSuccess('操作成功', U('ele/setting'));
        }
        $this->baoError('操作失败');
    }

    public function jqprint_delete($set_id = 0){
        $obj = D('Shopsetting');
        if (!$set_id = (int) $set_id) {
            $this->baoError('未选择的打印机ID');
        }elseif ( (!$detail = $obj->find($set_id)) || $detail['closed'] == 1) {
            $this->baoError('打印机不存在或已被删除');
        }elseif ($detail['shop_id'] != $this->shop_id) {
            $this->baoError('不可操作其他人的！');
        }else{
            if (false !== $obj->save(array('set_id' => $detail['set_id'], 'closed' => 1))) {
                $this->baoSuccess('操作成功', U('ele/setting'));
            }
            $this->baoError('操作失败');
        }
    }
    
    public function open() {
        $is_open = (int) $_POST['is_open'];
        //$is_open = $is_open ? 1 : 0;
        D('Ele')->save(array(
            'shop_id' => $this->shop_id,
            'is_open' => $is_open
        ));
        //dump(D('Ele')->getLastSql());
        $this->baoSuccess('操作成功！', U('ele/index'));
    }

    public function apply() {
        $this->assign("area", D("Area")->fetchAll());
        $this->assign("city", D("City")->fetchAll());

        if ($this->isPost()) {
            $data = $this->applyCheck();
            $obj = D('Ele');
            $cate = $this->_post('cate', false);
            $cate = implode(',', $cate);
            $data['cate'] = $cate;
            if ($obj->add($data)) {
                $this->baoSuccess('添加成功', U('ele/index'));
            }
            $this->baoError('操作失败！');
        } else {
            $this->display();
        }
    }

    private function applyCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['shop_id'] = $this->shop_id;
        if (empty($data['shop_id'])) {
            $this->baoError('ID不能为空');
        }
        if (!$shop = D('Shop')->find($data['shop_id'])) {
            $this->baoError('商家不存在');
        }
        $data['shop_name'] = $shop['shop_name'];
        $data['lng'] = $shop['lng'];
        $data['lat'] = $shop['lat'];
        $data['area_id'] = $shop['area_id'];
        $data['city_id'] = $shop['city_id'];
        $data['is_open'] = (int) $data['is_open'];
        $data['is_pay'] = (int) $data['is_pay'];
        $data['is_fan'] = (int) $data['is_fan'];
        $data['fan_money'] = (int) ($data['fan_money'] * 100);
        $data['is_new'] = (int) $data['is_new'];
        $data['full_money'] = (int) ($data['full_money'] * 100);
        $data['new_money'] = (int) ($data['new_money'] * 100);
        $data['logistics'] = (int) ($data['logistics'] * 100);
        $data['since_money'] = (int) ($data['since_money'] * 100);
        $data['distribution'] = (int) $data['distribution'];
        $data['intro'] = SecurityEditorHtml($data['intro']);
        if (empty($data['intro'])) {
            $this->baoError('说明不能为空');
        }
        return $data;
    }

}
