<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class HotelAction extends CommonAction {

    public function _initialize() {
        parent::_initialize();
        $this->cates = D('Hotel')->getHotelCate();
        $this->assign('cates', $this->cates);
        $this->types = D('Hotelbrand')->fetchAll();
        $this->assign('hoteltypes',$this->types);
        $this->stars = D('Hotel')->getHotelStar();
        $this->assign('stars', $this->stars);
    }
    
    
    public function index() {
        $hotel = D('Hotel');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'audit' => 1);
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['hotel_name'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        if ($city_id = (int) $this->_param('city_id')) {
            $map['city_id'] = $city_id;
            $this->assign('city_id', $city_id);
        }
        if ($area_id = (int) $this->_param('area_id')) {
            $map['area_id'] = $area_id;
            $this->assign('area_id', $area_id);
        }
        if ($cate_id = (int) $this->_param('cate_id')) {
            $map['cate_id'] = $cate_id;
            $this->assign('cate_id', $cate_id);
        }
        $count = $hotel->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $hotel->where($map)->order(array('hotel_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }
    
    public function yuyue() {
        $hotel = D('Hotelorder');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0);
        
        $stime = I('stime','','trim,htmlspecialchars');
        if($stime){
            $stime = strtotime($stime);
            $map['stime'] = array(array('ELT', $stime+86399), array('EGT', $stime));
            $this->assign('stime',date('Y-m-d',$stime));
        }
        $order_id = I('order_id','','trim,intval');
        if($order_id){
            $map['order_id'] = $order_id;
            $this->assign('order_id',$order_id);
        }
        
        $count = $hotel->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $hotel->where($map)->order(array('order_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $hotel_ids = $room_ids =  array();
        foreach($list as $k => $v){
            $hotel_ids[$v['hotel_id']] = $v['hotel_id'];
            $room_ids[$v['room_id']] = $v['room_id'];
        }
        $hotels = D('Hotel')->itemsByIds($hotel_ids);
        $rooms = D('Hotelroom')->itemsByIds($room_ids);
        foreach($list as $k => $v){
            $list[$k]['hotel'] = $hotels[$v['hotel_id']];
            $list[$k]['room'] = $rooms[$v['room_id']];
        }
        $roomtype = D('Hotelroom')->getRoomType();

        $this->assign('roomtype', $roomtype);
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function yuyue_cancel($order_id){
        if($order_id = (int) $order_id){
            if(!$order = D('Hotelorder')->find($order_id)){
                $this->baoError('订单不存在');
            }elseif($order['order_status'] == -1){
                $this->baoError('该订单已取消');
            }else{
                if(false !== D('Hotelorder')->cancel($order_id)){
                    $this->baoSuccess('订单取消成功',U('hotel/yuyue'));
                }else{
                    $this->baoError('订单取消失败');
                }
            }
        }else{
            $this->baoError('请选择要取消的订单');
        }
    }
    
    
    public function yuyue_complete($order_id){
        if($order_id = (int) $order_id){
            if(!$order = D('Hotelorder')->find($order_id)){
                $this->baoError('订单不存在');
            }elseif(($order['online_pay'] == 1&&$order['order_status'] != 1)||($order['online_pay'] == 0&&$order['order_status'] != 0)){
                $this->baoError('该订单无法完成');
            }else{
                if(false !== D('Hotelorder')->complete($order_id)){
                    $this->baoSuccess('订单操作成功',U('hotel/yuyue'));
                }else{
                    $this->baoError('订单操作失败');
                }
            }
        }else{
            $this->baoError('请选择要完成的订单');
        }
    }
    
    
    public function yuyue_delete($order_id){
        if($order_id = (int) $order_id){
            if(!$order = D('Hotelorder')->find($order_id)){
                $this->baoError('订单不存在');
            }elseif($order['order_status'] != -1){
                $this->baoError('订单状态不正确');
            }else{
                if(false !== D('Hotelorder')->save(array('order_id'=>$order_id,'closed'=>1))){
                    $this->baoSuccess('订单删除成功',U('hotel/yuyue'));
                }else{
                    $this->baoError('订单删除失败');
                }
            }
        }else{
            $this->baoError('请选择要删除的订单');
        }
    }
    
    
    public function yuyue_detail($order_id=null){
        if(!$order_id = (int)$order_id){
            $this->error('订单不存在');
        }elseif(!$detail = D('Hotelorder')->find($order_id)){
             $this->error('订单不存在');
        }elseif($detail['closed'] == 1){
             $this->error('订单已删除');
        }else{
            $detail['night_num'] = $this->diffBetweenTwoDays($detail['stime'],$detail['ltime']); 
            $detail['room'] = D('Hotelroom')->find($detail['room_id']); 
            $detail['hotel'] = D('Hotel')->find($detail['hotel_id']);
            $this->assign('detail',$detail);
            $this->display();
        }
    }
    
    function diffBetweenTwoDays ($day1, $day2){
          $second1 = strtotime($day1);
          $second2 = strtotime($day2);

          if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
          }
          return ($second1 - $second2) / 86400;
    }


    public function noaudit(){
        $hotel = D('Hotel');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'audit' => array('IN',array(0,2)));
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['hotel_name'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        if ($city_id = (int) $this->_param('city_id')) {
            $map['city_id'] = $city_id;
            $this->assign('city_id', $city_id);
        }
        if ($area_id = (int) $this->_param('area_id')) {
            $map['area_id'] = $area_id;
            $this->assign('area_id', $area_id);
        }
        if ($cate_id = (int) $this->_param('cate_id')) {
            $map['cate_id'] = $cate_id;
            $this->assign('cate_id', $cate_id);
        }
        $count = $hotel->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 25); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $hotel->where($map)->order(array('hotel_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }

    public function create() {
        $obj = D('Hotel');
        if ($this->isPost()) {
            $data = $this->createCheck();
            $thumb = $this->_param('thumb', false);
            foreach ($thumb as $k => $val) {
                if (empty($val)) {
                    unset($thumb[$k]);
                }
                if (!isImage($val)) {
                    unset($thumb[$k]);
                }
            }
            if ($hotel_id = $obj->add($data)) {
                foreach($thumb as $k=>$val){
                    D('Hotelpics')->add(array('hotel_id'=>$hotel_id,'photo'=>$val));
                }
                $this->baoSuccess('操作成功', U('hotel/index'));
            }
            $this->baoError('操作失败');
        } else {
            $this->assign('detail', $detail);
            $this->display();
        }
       
    }
    
    private function createCheck() {
        $data = $this->checkFields($this->_post('data', false), array('hotel_name','shop_id','addr', 'city_id', 'area_id','business_id','cate_id', 'type','price','star', 'tel', 'details', 'photo', 'lng', 'lat','is_wifi','is_kt','is_nq','is_tv','is_xyj','is_ly','is_bx','is_base','is_rsh','in_time','out_time'));
        $data['hotel_name'] = htmlspecialchars($data['hotel_name']);
        if (empty($data['hotel_name'])) {
            $this->baoError('酒店名称不能为空');
        }$data['addr'] = htmlspecialchars($data['addr']);
        if (empty($data['addr'])) {
            $this->baoError('酒店地址不能为空');
        }$data['cate_id'] = (int)$data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('酒店级别没有选择');
        }$data['star'] = (int)$data['star'];
        if (empty($data['star'])) {
            $this->baoError('酒店星级不能为空');
        }$data['price'] = (int)$data['price'];
        if (empty($data['price'])) {
            $this->baoError('酒店起价不能为空');
        }$data['tel'] = htmlspecialchars($data['tel']);
        if (empty($data['tel'])) {
            $this->baoError('酒店联系电话不能为空');
        }
        $data['type'] = (int)$data['type'];
        $data['lng'] = htmlspecialchars($data['lng']);
        $data['lat'] = htmlspecialchars($data['lat']);
        if (empty($data['lng']) || empty($data['lat'])) {
                $this->baoError('酒店坐标没有选择');
            }
        $data['shop_id'] = (int)$data['shop_id'];
        if(empty($data['shop_id'])){
            $this->baoError('商家不能为空');
        }elseif(!$shop = D('Shop')->find($data['shop_id'])){
            $this->baoError('商家不存在');
        }
        $data['area_id'] = $shop['area_id'];
        $data['business_id'] = $shop['business_id'];
        $data['city_id'] = $shop['city_id'];
        $data['photo'] = htmlspecialchars($data['photo']);
        if (empty($data['photo'])) {
            $this->baoError('请上传缩略图');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('缩略图格式不正确');
        } 
        
        $data['details'] = SecurityEditorHtml($data['details']);
        if (empty($data['details'])) {
            $this->baoError('酒店详情不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['details'])) {
            $this->baoError('酒店详情含有敏感词：' . $words);
        } 
        $data['in_time'] = htmlspecialchars($data['in_time']);
        $data['out_time'] = htmlspecialchars($data['out_time']);
        $data['is_wifi'] = (int)$data['is_wifi'];
        $data['is_wifi'] = (int)$data['is_wifi'];
        $data['is_kt'] = (int)$data['is_kt'];
        $data['is_nq'] = (int)$data['is_nq'];
        $data['is_tv'] = (int)$data['is_tv'];
        $data['is_xyj'] = (int)$data['is_xyj'];
        $data['is_ly'] = (int)$data['is_ly'];
        $data['is_bx'] = (int)$data['is_bx'];
        $data['is_base'] = (int)$data['is_base'];
        $data['is_rsh'] = (int)$data['is_rsh'];
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        $data['audit'] = 1;
        return $data;
    }
    
    
    public function edit($hotel_id = 0) {

        if ($hotel_id = (int) $hotel_id) {
            $obj = D('Hotel');
            if (!$detail = $obj->find($hotel_id)) {
                $this->baoError('请选择要编辑的酒店');
            }
            if ($this->isPost()) {
                $data = $this->editCheck();
                $thumb = $this->_param('thumb', false);
                foreach ($thumb as $k => $val) {
                    if (empty($val)) {
                        unset($thumb[$k]);
                    }
                    if (!isImage($val)) {
                        unset($thumb[$k]);
                    }
                }
                $data['hotel_id'] = $hotel_id;
                if (false !== $obj->save($data)) {
                    D('Hotelpics')->where(array('hotel_id'=>$hotel_id))->delete();
                    foreach($thumb as $k=>$val){
                        D('Hotelpics')->add(array('hotel_id'=>$hotel_id,'photo'=>$val));
                    }
                    $this->baoSuccess('操作成功', U('hotel/index'));
                }
                $this->baoError('操作失败');
            } else {
                $thumb = D('Hotelpics')->where(array('hotel_id'=>$hotel_id))->select();
                $this->assign('thumb', $thumb);
                $this->assign('shop',D('Shop')->find($detail['shop_id']));
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->baoError('请选择要编辑的酒店');
        }
    }
    
    private function editCheck() {
        $data = $this->checkFields($this->_post('data', false), array('hotel_name','shop_id','addr', 'city_id', 'area_id','business_id','cate_id', 'type','price','star', 'tel', 'details', 'photo', 'lng', 'lat','is_wifi','is_kt','is_nq','is_tv','is_xyj','is_ly','is_bx','is_base','is_rsh','in_time','out_time'));
        $data['hotel_name'] = htmlspecialchars($data['hotel_name']);
        if (empty($data['hotel_name'])) {
            $this->baoError('酒店名称不能为空');
        }$data['addr'] = htmlspecialchars($data['addr']);
        if (empty($data['addr'])) {
            $this->baoError('酒店地址不能为空');
        }$data['cate_id'] = (int)$data['cate_id'];
        if (empty($data['cate_id'])) {
            $this->baoError('酒店级别没有选择');
        }$data['star'] = (int)$data['star'];
        if (empty($data['star'])) {
            $this->baoError('酒店星级不能为空');
        }$data['price'] = (int)$data['price'];
        if (empty($data['price'])) {
            $this->baoError('酒店起价不能为空');
        }$data['tel'] = htmlspecialchars($data['tel']);
        if (empty($data['tel'])) {
            $this->baoError('酒店联系电话不能为空');
        }
        $data['type'] = (int)$data['type'];
        $data['lng'] = htmlspecialchars($data['lng']);
        $data['lat'] = htmlspecialchars($data['lat']);
        if (empty($data['lng']) || empty($data['lat'])) {
                $this->baoError('酒店坐标没有选择');
            }
        $data['shop_id'] = (int)$data['shop_id'];
        if(empty($data['shop_id'])){
            $this->baoError('商家不能为空');
        }elseif(!$shop = D('Shop')->find($data['shop_id'])){
            $this->baoError('商家不存在');
        }
        $data['area_id'] = $shop['area_id'];
        $data['business_id'] = $shop['business_id'];
        $data['city_id'] = $shop['city_id'];
        $data['photo'] = htmlspecialchars($data['photo']);
        if (empty($data['photo'])) {
            $this->baoError('请上传缩略图');
        }
        if (!isImage($data['photo'])) {
            $this->baoError('缩略图格式不正确');
        } 
        
        $data['details'] = SecurityEditorHtml($data['details']);
        if (empty($data['details'])) {
            $this->baoError('酒店详情不能为空');
        }
        if ($words = D('Sensitive')->checkWords($data['details'])) {
            $this->baoError('酒店详情含有敏感词：' . $words);
        } 
        $data['in_time'] = htmlspecialchars($data['in_time']);
        $data['out_time'] = htmlspecialchars($data['out_time']);
        $data['is_wifi'] = (int)$data['is_wifi'];
        $data['is_kt'] = (int)$data['is_kt'];
        $data['is_nq'] = (int)$data['is_nq'];
        $data['is_tv'] = (int)$data['is_tv'];
        $data['is_xyj'] = (int)$data['is_xyj'];
        $data['is_ly'] = (int)$data['is_ly'];
        $data['is_bx'] = (int)$data['is_bx'];
        $data['is_base'] = (int)$data['is_base'];
        $data['is_rsh'] = (int)$data['is_rsh'];
        $data['update_time'] = NOW_TIME;
        $data['update_ip'] = get_client_ip();
        return $data;
    }
    
    
    public function delete($hotel_id = 0) {
        $obj = D('Hotel');
        if (is_numeric($hotel_id) && ($hotel_id = (int) $hotel_id)) {
            $obj->save(array('hotel_id' => $hotel_id, 'closed' => 1));
            $this->baoSuccess('删除成功！', U('hotel/index'));
        } else {
            $hotel_id = $this->_post('hotel_id', false);
            if (is_array($hotel_id)) {
                foreach ($hotel_id as $id) {
                    $obj->save(array('hotel_id' => $id, 'closed' => 1));
                }
                $this->baoSuccess('删除成功！', U('hotel/index'));
            }
            $this->baoError('请选择要删除的酒店');
        }
    }

    public function audit($hotel_id = 0) {
        $obj = D('Hotel');
        if (is_numeric($hotel_id) && ($hotel_id = (int) $hotel_id)) {
            $obj->save(array('hotel_id' => $hotel_id, 'audit' => 1));
            $this->baoSuccess('审核成功！', U('hotel/index'));
        } else {
            $hotel_id = $this->_post('hotel_id', false);
            if (is_array($hotel_id)) {
                foreach ($hotel_id as $id) {
                    $obj->save(array('hotel_id' => $id, 'audit' => 1));
                }
                $this->baoSuccess('审核成功！', U('hotel/index'));
            }
            $this->baoError('请选择要审核的酒店');
        }
    }

    public function refuse($hotel_id){
        $obj = D('Hotel');
         if (is_numeric($hotel_id) && ($hotel_id = (int) $hotel_id)) {
            if ($this->isPost()) {
                $reason = htmlspecialchars($this->_param('reason'));
                if(!$reason){
                    $this->baoError('拒绝理由不能为空');
                }
                $obj->save(array('hotel_id' => $hotel_id, 'audit' => 2,'reason'=>$reason));
                $this->baoSuccess('操作成功！', U('hotel/index'));
            }else{
                $this->assign('hotel_id',$hotel_id);
                $this->display();
            }
         }
    }
    
}
