<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class GoodsAction extends CommonAction {

    private $create_fields = array('title', 'photo', 'cate_id', 'price', 'shopcate_id','settlement_price', 'mall_price','use_integral','commission', 'instructions', 'details', 'end_date','ltme','rush_ltime','rush_kucun','rush_price','max_buy','kucun');
    private $edit_fields = array('title', 'photo', 'cate_id', 'price', 'shopcate_id','settlement_price', 'mall_price','use_integral','commission', 'instructions', 'details', 'end_date','ltme','rush_ltime','rush_kucun','rush_price','max_buy','kucun');

    public function _initialize() {
        parent::_initialize();
        $this->autocates = D('Goodsshopcate')->where(array('shop_id' => $this->shop_id))->select();
        $this->assign('autocates', $this->autocates);
    }
  
    private function check_weidian() {

        $wd = D('WeidianDetails');
        $wd_res = $wd->where('shop_id =' . ($this->shop_id))->find();
        if (!$wd_res) {
            $this->error('请先完善微店资料！', U('goods/weidian'));
        } elseif ($wd_res['audit'] == 0) {
            $this->error('您的微店正在审核中，请耐心等待！', U('index/index'));
        } elseif ($wd_res['audit'] == 2) {
            $this->error('您的微店未通过审核！', U('index/index'));
        }
    }
    
    private function check_format(){
        $f = D('Format');
        $res = $f -> where('shop_id ='.($this->shop_id)) -> find();
        if(!$res){
            $this->error('您必须得先建立商品规格！',U('goodsshopformat/create'));
        }
    }

    public function index() {


        $this->check_weidian();

        $Goods = D('Goods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'shop_id' => $this->shop_id, 'is_mall' => 1);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        if ($cate_id = (int) $this->_param('cate_id')) {
            $map['cate_id'] = array('IN', D('Goodscate')->getChildren($cate_id));
            $this->assign('cate_id', $cate_id);
        }

        if ($audit = (int) $this->_param('audit')) {
            $map['audit'] = ($audit === 1 ? 1 : 0);
            $this->assign('audit', $audit);
        }
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $Goods->where($map)->order(array('goods_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();

        foreach ($list as $k => $val) {
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $val = $Goods->_format($val);
            $list[$k] = $val;
        }
        if ($shop_ids) {
            $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        }
        $this->assign('cates', D('Goodscate')->fetchAll());

        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function get_select() {

        if (IS_AJAX) {

            $pid = I('pid', 0, 'intval,trim');
            $gc = D('GoodsCate');
            $list = $gc->where('parent_id =' . $pid)->select();

            if ($pid == 0) {
                $this->ajaxReturn(array('status' => 'success', 'list' => ''));
            }

            if ($list) {
                $l = '';
                foreach ($list as $k => $v) {
                    $l = $l . '<option value=' . $v['cate_id'] . ' style="color:#333333;">' . $v['cate_name'] . '</option>';
                }

                $this->ajaxReturn(array('status' => 'success', 'list' => $l));
            }
        }
    }

    public function weidian() {
        $mcates = $this->_CONFIG['mall'];
        $cates = array();
        $cates = D('weidian_cate')->select();
        $gc = D('GoodsCate');
        $select = $gc->where('parent_id =0')->select();
        $this->assign('select', $select);

        $wd = D('WeidianDetails');
        $weidian = $wd->where('shop_id =' . ($this->shop_id))->find();
        if ($this->isPost()) {
            $data = $this->checkFields($this->_post('data', false), array('weidian_name', 'addr', 'city_id', 'area_id', 'cate_id', 'business_time', 'details', 'pic', 'logo', 'lng', 'lat', 'reg_time'));
            if (empty($weidian)) {
                $data['weidian_name'] = htmlspecialchars($data['weidian_name']);
                if (empty($data['weidian_name'])) {
                    $this->baoError('店铺名称不能为空');
                }
                $data['addr'] = htmlspecialchars($data['addr']);
                if (empty($data['addr'])) {
                    $this->baoError('店铺地址不能为空');
                }
                $data['cate_id'] = (int)$data['cate_id'];
                if (empty($data['cate_id'])) {
                    $this->baoError('店铺分类没有选择');
                }
                $data['city_id'] = intval($data['city_id']);
                $data['area_id'] = intval($data['area_id']);
                if (empty($data['city_id']) || empty($data['area_id'])) {
                    $this->baoError('城市或地区没有选择');
                }
                $data['reg_time'] = NOW_TIME;
            }else{
                $data['update_time'] = NOW_TIME;
            }
            $data['business_time'] = htmlspecialchars($data['business_time']);

            $data['shop_id'] = $this->shop_id;

            if (empty($data['pic'])) {
                $this->baoError('店铺图标没有上传');
            }
            if (empty($data['logo'])) {
                $this->baoError('店铺logo没有上传');
            }
            if (empty($data['lng']) || empty($data['lat'])) {
                $this->baoError('店铺坐标没有选择');
            }
            $data['details'] = $this->_post('details', 'SecurityEditorHtml');
            if (empty($data['details']) || $data['details'] == null) {
                $this->baoError('详情没有填写');
            }
            if ($words = D('Sensitive')->checkWords($details)) {
                $this->baoError('商家介绍含有敏感词：' . $words);
            }
            if (!$weidian) { //如果没有结果则添加
                $add = $wd->add($data);
                if (!$add) {
                    $this->baoError('设置失败');
                } else {
                    $this->baoSuccess('设置成功', U('goods/weidian'));
                }
            } else {   //否则修改
                $up = $wd->where('shop_id =' . ($this->shop_id))->save($data);
                if (!$up) {
                    $this->baoError('修改失败');
                } else {
                    $this->baoSuccess('修改成功', U('goods/weidian'));
                }
            }
        } else {
            //冗余信息
			$cates = D("WeidianCate") ->select();
            $this->assign('the_shop', D('Shop')->where('shop_id =' . ($this->shop_id))->find());
            $this->assign('cates', $cates);
            $this->assign('weidian', $weidian);

            $this->display();
        }
    }

    public function create() {
        $this->check_weidian();
        if ($this->isPost()) {
            $data = $this->createCheck();
            $obj = D('Goods');
            $thumb = $this->_param('thumb', false);
            foreach ($thumb as $k => $val) {
                if (empty($val)) {
                    unset($thumb[$k]);
                }
                if (!isImage($val)) {
                    unset($thumb[$k]);
                }
            }
            $data['thumb'] = serialize($thumb);
            if ($goods_id = $obj->add($data)) {
                $wei_pic = D('Weixin')->getCode($goods_id, 3); //购物类型是3
                $obj->save(array('goods_id' => $goods_id, 'wei_pic' => $wei_pic));
                $this->baoSuccess('添加成功', U('goods/index'));
            }
            $this->baoError('操作失败！');
        } else {
            $this->assign('cates', D('Goodscate')->fetchAll());
            $this->display();
        }
    }

    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->create_fields);
        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->baoError('产品名称不能为空');
        }
        $data['shop_id'] = $this->shop_id;
        $shopdetail = D('Shop')->find($this->shop_id);

        $data['cate_id'] = (int) $data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('请选择分类');
        }
        $data['shopcate_id'] = (int) $data['shopcate_id'];
        $data['area_id'] = $this->shop['area_id'];
        $data['business_id'] = $this->shop['business_id'];
        $data['city_id'] = $this->shop['city_id'];
        $data['photo'] = htmlspecialchars($data['photo']);
		$data['rush_ltime'] = strtotime($data['rush_ltime']);
        if (empty($data['photo'])) {
            $this->baoError('请上传缩略图');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('缩略图格式不正确');
        } $data['price'] = (int) ($data['price'] * 100);
        if (empty($data['price'])) {
            $this->baoError('市场价格不能为空');
        } $data['mall_price'] = (int) ($data['mall_price'] * 100);
        if (empty($data['mall_price'])) {
            $this->baoError('商城价格不能为空');
        }
		$data['rush_price'] = (int) ($data['rush_price'] * 100);
        $cates = D('Goodscate')->fetchAll();
        $data['settlement_price'] = (int)( $data['mall_price'] - ($data['mall_price'] * $cates[$data['cate_id']]['rate'] /1000) );

        $data['commission'] = (int) ($data['commission'] * 100);
        if ($data['commission'] < 0 || $data['commission']>=$data['settlement_price']) {
            $this->baoError('佣金不能为负数，并且不能大于结算价格');
        } 
        
        $data['instructions'] = SecurityEditorHtml($data['instructions']);
        if (empty($data['instructions'])) {
            $this->baoError('购买须知不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['instructions'])) {
            $this->baoError('购买须知含有敏感词：' . $words);
        } $data['details'] = SecurityEditorHtml($data['details']);
        if (empty($data['details'])) {
            $this->baoError('商品详情不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['details'])) {
            $this->baoError('商品详情含有敏感词：' . $words);
        } $data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $this->baoError('过期时间不能为空');
        }
        if (!isDate($data['end_date'])) {
            $this->baoError('过期时间格式不正确');
        }
        //$data['use_integral'] = (int) $data['use_integral'];
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        $data['sold_num'] = 0;
        $data['view'] = 0;
        $data['is_mall'] = 1;
        return $data;
    }

    public function edit($goods_id = 0) {
        $this->check_weidian();
        if ($goods_id = (int) $goods_id) {
            $obj = D('Goods');
            if (!$detail = $obj->find($goods_id)) {
                $this->error('请选择要编辑的商品');
            }
            if ($detail['shop_id'] != $this->shop_id) {
                $this->error('请不要试图越权操作其他人的内容');
            }
            if ($this->isPost()) {
                $data = $this->editCheck();
                $data['goods_id'] = $goods_id;
                $data['audit'] = 0;
                if (!empty($detail['wei_pic'])) {
                    if (true !== strpos($detail['wei_pic'], "https://mp.weixin.qq.com/")) {
                        $wei_pic = D('Weixin')->getCode($goods_id, 3);
                        $data['wei_pic'] = $wei_pic;
                    }
                } else {
                    $wei_pic = D('Weixin')->getCode($goods_id, 3);
                    $data['wei_pic'] = $wei_pic;
                }
                $thumb = $this->_param('thumb', false);
                foreach ($thumb as $k => $val) {
                    if (empty($val)) {
                        unset($thumb[$k]);
                    }
                    if (!isImage($val)) {
                        unset($thumb[$k]);
                    }
                }
                $data['thumb'] = serialize($thumb);
                if (false !== $obj->save($data)) {
                    $this->baoSuccess('操作成功', U('goods/index'));
                }
                $this->baoError('操作失败');
            } else {
                $thumb = unserialize($detail['thumb']);
                $this->assign('thumb', $thumb);
                $this->assign('detail', $obj->_format($detail));
                $this->assign('cates', D('Goodscate')->fetchAll());
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的商品');
        }
    }

    private function editCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        $data['title'] = htmlspecialchars($data['title']);
        if (empty($data['title'])) {
            $this->baoError('产品名称不能为空');
        } $data['shop_id'] = (int) $this->shop_id;
        if (empty($data['shop_id'])) {
            $this->baoError('商家不能为空');
        }
        $shopdetail = D('Shop')->find($this->shop_id);
        $data['cate_id'] = (int) $data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('请选择分类');
        }
        $data['shopcate_id'] = (int) $data['shopcate_id'];
        $data['area_id'] = $this->shop['area_id'];
        $data['business_id'] = $this->shop['business_id'];
        $data['city_id'] = $this->shop['city_id'];
        $data['photo'] = htmlspecialchars($data['photo']);
		$data['rush_ltime'] = strtotime($data['rush_ltime']);
        if (empty($data['photo'])) {
            $this->baoError('请上传缩略图');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('缩略图格式不正确');
        } $data['price'] = (int) ($data['price'] * 100);
        if (empty($data['price'])) {
            $this->baoError('市场价格不能为空');
        } 
        $data['mall_price'] = (int) ($data['mall_price'] * 100);
        if (empty($data['mall_price'])) {
            $this->baoError('商城价格不能为空');
        }
		$data['rush_price'] = (int) ($data['rush_price'] * 100);
        $cates = D('Goodscate')->fetchAll();
        $data['settlement_price'] = (int)( $data['mall_price'] - ($data['mall_price'] * $cates[$data['cate_id']]['rate'] /1000) );
        
        $data['commission'] = (int) ($data['commission'] * 100);
        if ($data['commission'] < 0 || $data['commission']>=$data['settlement_price']) {
            $this->baoError('佣金不能为负数，并且不能大于结算价格');
        } 
        $data['instructions'] = SecurityEditorHtml($data['instructions']);
        if (empty($data['instructions'])) {
            $this->baoError('购买须知不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['instructions'])) {
            $this->baoError('购买须知含有敏感词：' . $words);
        } $data['details'] = SecurityEditorHtml($data['details']);
        if (empty($data['details'])) {
            $this->baoError('商品详情不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['details'])) {
            $this->baoError('商品详情含有敏感词：' . $words);
        } $data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $this->baoError('过期时间不能为空');
        }
        if (!isDate($data['end_date'])) {
            $this->baoError('过期时间格式不正确');
        }
        //$data['use_integral'] = (int) $data['use_integral'];
        $data['orderby'] = (int) $data['orderby'];
        return $data;
    }
    
    
    
    
     public function format($goods_id = 0) {
        $this->check_weidian();
        $this->check_format();
        if ($goods_id = (int) $goods_id) {
            $obj = D('Goodsformat');
            if (!$goods = D('Goods')->find($goods_id)) {
                $this->error('该商品不存在');
            }
            if ($goods['shop_id'] != $this->shop_id) {
                $this->error('请不要试图越权操作其他人的内容');
            }
            $formats = $obj->where(array('goods_id'=>$goods_id))->select();
            foreach($formats as $k=>$v){
                $formats[$k]['detail'] = D('Format')->format_content($v['id']);
            }
            //print_r($formats);exit;
            $this->assign('goods',$goods);
            $this->assign('formats',$formats);
            $this->display();
        } else {
            $this->baoError('请选择商品');
        }
    }
    
    public function format_create($goods_id = 0) {
        $this->check_weidian();
        $obj = D('Goodsformat');
        if(!$goods = D('Goods')->find($goods_id)){
             $this->error('商品信息不存在');
        }
        if ($this->isPost()) {
                $data = $_POST['data'];                
                 //遍历选中的项目把标题整合好写入套餐表
                $format_ids = $value_ids = array();
                foreach($data['value'] as $k => $v){
                    if(($k = (int)$k) && ($v = (int)$v)){
                        $format_ids[$k] = $k;
                        $value_ids[$v] = $v;
                    }
                }
                if($format_list = D('Format')->format_goodsid($goods_id)){
                    $fids = $vids = $vnames = array();
                    foreach($format_list as $v){
                        if(in_array($v['id'], $format_ids)){
                            $fids[$v['id']] = $v['id'];
                            foreach($v['values'] as $vv){
                                if(in_array($vv['id'], $value_ids)){
                                    $vids[$vv['id']] = $vv['id'];
                                    $vnames[$vv['id']] = $vv['name'];
                                }
                            }
                        }
                    }
                    $format_ids = $fids;
                    $value_ids = $vids;
                }else{
                   $this->error('规格不存在或已经删除'); 
                }
                $data['format_title'] = implode(',', $vnames);
                asort($value_ids);
                $data['content'] = implode('-', $value_ids);
                $data['goods_id'] = $goods_id;

                
                if($data['price'] <= $data['mall_price']){
                    $this->baoError('售价不能大于或者等于市场价格');
                }
                
                $cates = D('Goodscate')->fetchAll();
                $data['settlement_price'] = (int)( $data['mall_price'] - ($data['mall_price'] * $cates[$goods['cate_id']]['rate'] /1000) );
               // print_r($data['settlement_price']);exit;
                if($data['settlement_price'] >= $data['mall_price']){
                    $this->baoError('结算价格不能大于或者等于售价');
                }
                $data['mall_price'] = $data['mall_price'] *100;
                $data['settlement_price'] = $data['settlement_price'] *100;
                $data['price'] = $data['price'] * 100;
                if(isset($data['photo'])){
                    $data['photo'] = htmlspecialchars($data['photo']);
                }
               // print_r($data);exit;
                if ($obj->add($data)) {
                    $this->baoSuccess('操作成功', U('goods/format',array('goods_id'=>$goods_id)));
                }               
                $this->baoError('操作失败');
        } else {
            $format = D('Format')->format_goodsid($goods_id);
            $this->assign('goods', $goods);
            $this->assign('detail', $detail);
            $this->assign('formats',$format);
            $this->display();
        }
    }
    
    public function format_detail($id = 0) {
        $this->check_weidian();
        if ($id = (int) $id) {
            $obj = D('Goodsformat');
            if (!$detail = $obj->find($id)) {
                $this->error('该条信息不存在');
            }
            if ($this->isPost()) {
                $data = $_POST['data'];                
                 //遍历选中的项目把标题整合好写入套餐表
                $format_ids = $value_ids = array();
                foreach($data['value'] as $k => $v){
                    if(($k = (int)$k) && ($v = (int)$v)){
                        $format_ids[$k] = $k;
                        $value_ids[$v] = $v;
                    }
                }
                if($format_list = D('Format')->format_goodsid($detail['goods_id'])){
                    $fids = $vids = $vnames = array();
                    foreach($format_list as $v){
                        if(in_array($v['id'], $format_ids)){
                            $fids[$v['id']] = $v['id'];
                            foreach($v['values'] as $vv){
                                if(in_array($vv['id'], $value_ids)){
                                    $vids[$vv['id']] = $vv['id'];
                                    $vnames[$vv['id']] = $vv['name'];
                                }
                            }
                        }
                    }
                    $format_ids = $fids;
                    $value_ids = $vids;
                }else{
                   $this->error('规格不存在或已经删除'); 
                }
                $data['format_title'] = implode(',', $vnames);
                asort($value_ids);
                $data['content'] = implode('-', $value_ids);
                $data['id'] = $id;
                if($data['price'] <= $data['mall_price']){
                    $this->baoError('售价不能大于或者等于市场价格');
                }
                $data['mall_price'] = $data['mall_price'] *100;
                $data['price'] = $data['price'] * 100;
                if(isset($data['photo'])){
                    $data['photo'] = htmlspecialchars($data['photo']);
                }
                if (false !== $obj->save($data)) {
                    $this->baoSuccess('操作成功', U('goods/format',array('goods_id'=>$detail['goods_id'])));
                }                
                $this->baoError('操作失败');
            } else {
                $goods = D('Goods')->find($detail['goods_id']);
                $format = D('Format')->format_goodsid($detail['goods_id']);
                $detail['title'] = $goods['title'];
                $detail['format'] = explode('-',$detail['content']);
                $detail['values'] = explode('-', $detail['content']);
                $this->assign('detail', $detail);
                $this->assign('formats',$format);                
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的配置');
        }
    }
    
    public function format_delete($id = 0){
        if ($id = (int) $id) {
            $obj = D('Goodsformat');
            if (!$detail = $obj->find($id)) {
                $this->error('该条信息不存在');
            }
            if($obj->delete($id)){
                $this->baoSuccess('删除成功', U('goods/format',array('goods_id'=>$detail['goods_id'])));
            }
        } else {
            $this->baoError('请选择要删除的配置');
        }
    }

}
