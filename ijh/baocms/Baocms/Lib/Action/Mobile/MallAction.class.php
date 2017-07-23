<?php
/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class MallAction extends CommonAction {
    
    
    public function index()
    {
        // 获取众筹
        $map = array('closed' => 0, 'audit' => 1,'type'=>'crowd', 'city_id' => $this->city_id, 'ltime' => array('GT', time()));
        $Goods = D('Goods');
        $Goodscrowd = D('Goodscrowd');
        $heat = $Goods->where($map)->order($orderby)->limit('2')->select();
        $arr = array();
        foreach($heat as $k => $v){
            $arr[] = $v['goods_id'];
        }
        $details['goods_id'] = array('IN',implode(',',$arr));
        $crowd = $Goodscrowd->where($details)->select();
        $items = $Goodscrowd->merge($heat,$crowd);
        $this->assign('itemss', $items);
        //新品上架
        $map2 = array('closed' => 0, 'audit' => 1,'type'=>'goods', 'city_id' => $this->city_id);
        $orderby = array('create_time'=>'DESC');
        $new = $Goods->where($map2)->order($orderby)->limit('4')->select();
        $this->assign('new', $new);
        //推荐
        $orderby = array('orderby'=>'ASC');
        $tuijian = $Goods->where($map2)->order($orderby)->limit('4')->select();
        $this->assign('tuijian', $tuijian);
        //限时抢购
        $map3 = array('closed' => 0, 'audit' => 1,'type'=>'goods', 'city_id' => $this->city_id, 'rush_ltime' => array('GT', time()), 'rush_kucun' => array('GT', '0'));
        $xianshi = $Goods->where($map3)->order($orderby)->limit('3')->select();
        $this->assign('xianshi', $xianshi);
        //猜你喜欢
        $orderby = array('views'=>'DESC');
        $like = $Goods->where($map2)->order($orderby)->limit('8')->select();
        $this->assign('like', $like);
        $this->display('index');
    }
    public function _initialize() {
        parent::_initialize();
        $goods = session('goods');
        $this->assign('cartnum', (int) array_sum($goods));
    }
    public function crowdList(){
        $Goods = D('Goods');
        $Goodscrowd = D('Goodscrowd');
        
        $linkArr = array();
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
            $linkArr['keywrod'] = $map['title'];
        }
        $this->assign('nextpage', LinkTo('mall/crowdloaddata', array('keyword' => $keyword, 'p' => '0000')));
        $this->mobile_title = '众筹商品';
        $this->display();
    }

     public function crowdloaddata() {
        
        $Goodscrowd = D('Goodscrowd');
        $Goods = D('Goods');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'audit' => 1,'type'=>'crowd', 'city_id' => $this->city_id, 'ltime' => array('GT', time()));
        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
        }
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }
        $list = $Goods->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();
         foreach($list as $k => $v){
            $arr[] = $v['goods_id'];
        }
        $details['goods_id'] = array('IN',implode(',',$arr));
        $crowd = $Goodscrowd->where($details)->select();
        $items = $Goodscrowd->merge($list,$crowd);
        $this->assign('itemss', $items); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }
    public function support($goods_id){
        $goods_id = (int) $goods_id;
        $Goodscrowd = D('Goodscrowd');
        $Goods = D('Goods');
        $Goodslist = D('Goodslist');
        $Goodstype = D('Goodstype');
        if (!$goods = D('Goods')->find($goods_id)) {
            $this->error('您访问的产品不存在！');
        }
        if ($goods['closed'] != 0 || $goods['audit'] != 1) {
            $this->error('您访问的产品不存在！');
        }
        if (!$crowd = $Goodscrowd->find($goods_id)) {
            $this->error('您访问的产品不存在！');
        }
        $detail = array_merge($goods,$crowd);
        $shop = D('Shop')->find($detail['shop_id']);
        $this->assign('shop', $shop);
        $goodstype = $Goodstype->where(array('goods_id' =>$goods_id))->order(array('price' => 'asc'))->select();
        $this->assign('goodstype', $goodstype);
        $this->assign('detail', $detail);
        $this->display();
    }
    
    public function crowdDetail($goods_id) {
        $goods_id = (int) $goods_id;
        $Goodscrowd = D('Goodscrowd');
        $Goods = D('Goods');
        $Goodsproject = D('Goodsproject');
        $Goodsask = D('Goodsask');
        $Goodslist = D('Goodslist');
        $Goodstype = D('Goodstype');
        if (!$goods = D('Goods')->find($goods_id)) {
            $this->error('您访问的产品不存在！');
        }
        if ($goods['closed'] != 0 || $goods['audit'] != 1) {
            $this->error('您访问的产品不存在！');
        }
        if (!$crowd = $Goodscrowd->find($goods_id)) {
            $this->error('您访问的产品不存在！');
        }
        $detail = array_merge($goods,$crowd);
        $shop = D('Shop')->find($detail['shop_id']);
        $this->assign('shop', $shop);
      
        //其他众筹
        $maps = array('closed' => 0, 'audit' => 1,'type'=>'crowd', 'city_id' => $this->city_id, 'ltime' => array('GT', time()));
        $list = $Goods->where($maps)->order(array('views'=>'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach($list as $k => $v){
            $arr[] = $v['goods_id'];
        }
        $details['goods_id'] = array('IN',implode(',',$arr));
        $crowd = $Goodscrowd->where($details)->select();
        $like = $Goodscrowd->merge($list,$crowd);
        $this->assign('like', $like);

        $goodsdianping = D('Goodsdianping');
        import('ORG.Util.Page'); // 导入分页类
        $map = array('closed' => 0, 'goods_id' => $goods_id, 'show_date' => array('ELT', TODAY));
        $count = $goodsdianping->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 5); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $list = $goodsdianping->where($map)->order(array('dianping_id' => 'desc'))->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $user_ids = $dianping_ids = array();
        foreach ($list as $k => $val) {
            $list[$k] = $val;
            $user_ids[$val['user_id']] = $val['user_id'];
            $dianping_ids[$val['dianping_id']] = $val['dianping_id'];
        }
        
        if (!empty($dianping_ids)) {
            $this->assign('pics', D('Goodsdianpingpics')->where(array('dianping_id' => array('IN', $dianping_ids)))->select());
        }
        //项目进展
        $projectcount = $Goodsproject->where(array('goods_id' =>$goods_id))->count();
        $project = $Goodsproject->where(array('goods_id' =>$goods_id))->order(array('dateline' => 'desc'))->select();
        $this->assign('projectcount', $projectcount);
        $this->assign('project', $project);
        //问题回答
        $askcount = $Goodsask->where(array('goods_id' =>$goods_id))->count();
        $ask_list = $Goodsask->where(array('goods_id' =>$goods_id))->order(array('dateline' => 'desc'))->select();
        foreach($ask_list as $k => $v){
            if($v['answer_c']){
                $ask[] = $v;
                $user_ids[$v['uid']] = $v['uid'];
            }
        }
        
        $this->assign('askcount', $askcount);
        $this->assign('ask', $ask);
        //获取购买列表
        $goodstype = $Goodstype->where(array('goods_id' =>$goods_id))->order(array('price' => 'asc'))->select();
        $this->assign('goodstype', $goodstype);
        //获取购买记录
        $listcount = $Goodslist->where(array('goods_id' =>$goods_id))->count();
        $goods_list = $Goodslist->where(array('goods_id' =>$goods_id))->order(array('dateline' => 'desc'))->select();
        foreach($goods_list as $k => $v){
            $user_ids[$v['uid']] = $v['uid'];
        }
        if (!empty($user_ids)) {
            $this->assign('users', D('Users')->itemsByIds($user_ids));
        }
        
        $this->assign('listcount', $listcount); // 赋值数据集
        $this->assign('goods_list', $goods_list); // 赋值数据集
        
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->seodatas['title'] = $detail['title'];
        D('Goods')->updateCount($goods_id, 'views');
        $this->assign('detail', $detail);
        $this->display();
    }

    public function ask($goods_id)
    {
        $Goodsask = D('Goodsask');
        if (empty($this->uid)) {
            $this->ajaxLogin(); //提示异步登录
        }
        $goods_id = (int) $goods_id;
        if (!$detail = D('Goods')->find($goods_id)) {
            $this->error('该商品不存在');
        }
        $data['uid'] = $this->uid;
        $data['goods_id'] = $goods_id;
        $data['ask_c'] = $this->_post('ask_c', 'htmlspecialchars');
        $data['dateline'] = time();
        if ($ask_id = $Goodsask->add($data)) {
            $this->baoMsg('提交成功');
        }
        
    }
    public function favorites($goods_id)
    {
        $Goodsfollow = D('Goodsfollow');
        $Goodscrowd = D('Goodscrowd');
        if (empty($this->uid)) {
             AppJump();
        }
        $goods_id = (int) $goods_id;
        if (!$detail = D('Goods')->find($goods_id)) {
            $this->error('该商品不存在');
        }
        $data['type'] = 'follow';
        $data['goods_id'] = $goods_id;
        $data['uid'] = $this->uid;
        $data['dateline'] = time();
        $map = array('type'=>'follow','uid'=>$this->uid,'goods_id'=>$goods_id);
        if($Goodsfollow->where($map)->find()){
             $this->error('您已经收藏过了！');
        }else if ($ask_id = $Goodsfollow->add($data)) {
            $Goodscrowd->updateCount($goods_id, 'follow_num');
             $this->success('恭喜您收藏成功！', U('mall/crowdDetail', array('goods_id' => $goods_id)));
        }
    }
 
    public function detail_c($goods_id)
    {
        $Goods = D('Goods');
        $Goodscrowd = D('Goodscrowd');
        $map = array('closed' => 0, 'audit' => 1,'type'=>'crowd', 'city_id' => $this->city_id,'goods_id' => array('NEQ',$goods_id), 'ltime' => array('GT', time()));
       
        $list = $Goods->where($map)->order($orderby)->limit('20')->select();
        shuffle($list);$num = 0;
        foreach($list as $k => $v){
            $num++;
            if($num<5){
                $arr[] = $v['goods_id'];
                $arrs[] = $v;
            }
        }
        
        $details['goods_id'] = array('IN',implode(',',$arr));
        $crowd = $Goodscrowd->where($details)->select();
        $items = $Goodscrowd->merge($arrs,$crowd);
        $this->assign('itemss', $items); // 赋值分页输出
        $this->display();
    }
    public function buycrowd($goods_id=0)
    {
        if (empty($this->uid)) {
            AppJump();
        }
        if (!$goods_id = (int) $goods_id) {
            $this->error('未选择要购买的众筹');
        }elseif (!$detail = D('Goods')->find($goods_id)) {
            $this->error('该商品不存在');
        }elseif (!$data = $this->check_fields($this->_post('data'), 'type_id,name,mobile,addr')) {
            $this->error('非法的参数提交');
        }elseif (!$type = D('Goodstype')->where(array('type_id'=>(int)$data['type_id'], 'goods_id'=>$goods_id))->find()) {
            $this->error('该商品不存在');
        }elseif (!empty($type['max_num']) && $type['have_num'] >= $type['max_num']) {
            $this->error('该众筹限额已满，无法购买');
        }elseif (!$data['name'] = trim(htmlspecialchars($data['name']))) {
            $this->error('姓名不能为空');
        }elseif (!$data['mobile'] = $data['mobile']) {
            $this->error('手机号码不能为空');
        }elseif (!$data['addr'] = trim(htmlspecialchars($data['addr']))) {
            $this->error('地址不能为空');
        }else{
            $data['uid'] = $this->uid;
            $data['price'] = $type['price'];
            $data['total_price'] = $type['price'];
            $data['goods_id'] = $goods_id;
            $data['dateline'] = NOW_TIME;
            if (!empty($type['yunfei'])) {
                $data['total_price'] += $type['yunfei'];
            }
            if($list_id = D('Goodslist')->add($data)){
                $this->success('众筹订单创建成功',U('mall/crowdpay', array('list_id' => $list_id)));
            }
        }
    }
  
    public function crowdpay($list_id){
        if(!$list_id = (int)$list_id){
            $this->error('众筹订单不存在');
        }elseif(!$list = D('Goodslist')->find($list_id)){
            $this->error('众筹订单不存在');
        }elseif($list['uid'] != $this->uid || $list['order_status'] != 0){
            $this->error('非法操作订单');
        }elseif ($list['pay_status'] == 1) {
            $this->error('该订单已经支付');
        }elseif (!$type = D('Goodstype')->where(array('type_id'=>$list['type_id'], 'goods_id'=>$list['goods_id']))->find()) {
            $this->error('该商品不存在');
        }elseif (!empty($type['max_num']) && $type['have_num'] >= $type['max_num']) {
            $this->error('该众筹限额已满，无法购买');
        }else{
            $goods = D('Goodscrowd')->find($list['goods_id']);
            $type = D('Goodstype')->find($list['type_id']);
            $this->assign('type',$type);
            $this->assign('goods',$goods);
            $this->assign('list',$list);
            
            $url = U('/mcenter/crowd/detail', array('goods_id' => $list['goods_id']));
            $this->assign('url',$url);
            $this->assign('payment', D('Payment')->getPayments());
            $this->display();
        }
    }
   
    public function crowdpay2($list_id){
        if (empty($this->uid)) {
            $this->ajaxLogin();
        }
        if(!$list_id = (int) $list_id){
            $this->error('该众筹订单不存在');
        }elseif(!$list = D('Goodslist')->find($list_id)){
            $this->error('该众筹订单不存在');
        }elseif($list['uid'] != $this->uid || $list['order_status'] != 0){
            $this->error('非法操作订单');
        }elseif ($list['pay_status'] == 1) {
            $this->error('该订单已经支付');
        }elseif (!$type = D('Goodstype')->where(array('type_id'=>$list['type_id'], 'goods_id'=>$list['goods_id']))->find()) {
            $this->error('该商品不存在');
        }elseif (!empty($type['max_num']) && $type['have_num'] >= $type['max_num']) {
            $this->error('该众筹限额已满，无法购买');
        }
        if (!$code = $this->_post('code')) {
            $this->error('请选择支付方式！');
        }
        $payment = D('Payment')->checkPayment($code);
        if (empty($payment)) {
            $this->error('该支付方式不存在');
        }
        $goods = D('Goodscrowd')->find($list['goods_id']);
        if (empty($goods)){
            $this->error('该众筹不存在');
        }
        $logs = D('Paymentlogs')->getLogsByOrderId('crowd', $list_id);
        if (empty($logs)) {
            $logs = array(
                'type' => 'crowd',
                'user_id' => $this->uid,
                'order_id' => $list_id,
                'code' => $code,
                'need_pay' => $list['total_price'],
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);
        } else {
            $logs['need_pay'] = $list['total_price'];
            $logs['code'] = $code;
            D('Paymentlogs')->save($logs);
        }
            
            //====================微信支付通知==抢购=========================
            include_once "Baocms/Lib/Net/Wxmesg.class.php";
            /*微信订单通知消息-开始*/
            $notice_data = array(
                'url'       =>  "http://".$_SERVER['HTTP_HOST']."/mcenter/goods/detail/order_id/".$list_id.".html",
                'first'   => '亲,您的订单创建成功!',
                'remark'  => '详情请登录-http://'.$_SERVER['HTTP_HOST'],
                'amount'  => round($list['price']/100,2).'元',
                'order'   => $list_id,
                'info'    => $goods['title']
            );
            $notice_data = Wxmesg::notice($notice_data);
            Wxmesg::net($this->uid, 'OPENTM206930158', $notice_data);
            /*微信订单通知消息-结束*/
            //====================微信支付通知==============================
            
            $this->success('选择支付方式成功！下面请进行支付！', U('payment/payment', array('log_id' => $logs['log_id'])));
    }
    
    
    public function items() {
        $keyword = $this->_param('keyword', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        $cat = (int) $this->_param('cat');
        $area = (int) $this->_param('area');
        $cate_id = (int) $this->_param('cate_id');
        $order = (int) $this->_param('order');
        $this->assign('area', $area);
        $this->assign('cate_id', $cate_id);
        $this->assign('order', $order);
        $this->assign('cat', $cat);
        $this->assign('nextpage', LinkTo('mall/loaddata', array('cat' => $cat, 'order' => $order, 'area' => $area, 'cate_id' => $cate_id, 'keyword' => $keyword, 'p' => '0000')));
        $this->mobile_title = '商城商品';
        $this->display();
    }
  
    public function loaddata() {

        $Goods = D('Goods');
        import('ORG.Util.Page'); // 导入分页类
        $area = (int) $this->_param('area');

        $order = (int) $this->_param('order');

        if ($area) {
            $map['area_id'] = $area;
        }
        $cate_id = (int) $this->_param('cate_id');

        if ($cate_id) {
            $map['cate_id'] = $cate_id;
        }
        $map['audit'] = 1;
        $map['closed'] = 0;
        $map['end_date'] = array('egt', TODAY);

        if ($keyword = $this->_param('keyword', 'htmlspecialchars')) {
            $map['title'] = array('LIKE', '%' . $keyword . '%');
        }
        $cat = (int) $this->_param('cat');
        if ($cat) {
            $catids = D('Goodscate')->getChildren($cat);
            if (!empty($catids)) {
                $map['cate_id'] = array('IN', $catids);
            } else {
                $map['cate_id'] = $cat;
            }
        }
        $map['city_id'] = $this->city_id;
        $count = $Goods->where($map)->count(); // 查询满足要求的总记录数 
        $Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出

        $var = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $p = $_GET[$var];
        if ($Page->totalPages < $p) {
            die('0');
        }

        if ($order == '1') {
            $order_arr = 'create_time desc';
        } elseif ($order == '2') {
            $order_arr = 'sold_num desc';
        } else {
            $order_arr = 'orderby desc';
        }

        $list = $Goods->where($map)->order($order_arr)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $k => $val) {
            if ($val['shop_id']) {
                $shop_ids[$val['shop_id']] = $val['shop_id'];
            }
            $val['end_time'] = strtotime($val['end_date']) - NOW_TIME + 86400;
            $list[$k] = $val;
        }
        $this->assign('list', $list); // 赋值数据集
        $this->assign('page', $show); // 赋值分页输出
        $this->display(); // 输出模板
    }
    public function buy($goods_id=0, $vid=0) {
        $goods_id = (int) $goods_id;
        $vid = (int)$vid;
        $sku_id = $goods_id.'_'.$vid;
        if (empty($goods_id)) {
            $this->error('请选择产品');
        }
        if (!$detail = D('Goods')->find($goods_id)) {
            $this->error('改商品不存在');
        }
        if ($detail['closed'] != 0 || $detail['audit'] != 1) {
            $this->error('该商品不存在');
        }
        if ($detail['end_date'] < TODAY) {
            $this->error('该商品已经过期，暂时不能购买');
        }
        $cart_goods = session('goods');
		
        $num = (int) $this->_get('num');
        if (empty($num) || $num <= 0) {
            $num = 1;
        }
		if($detail['kucun']< $num){
			$this->error('商品库存不足！');
		}
        if ($num > 99) {
            $num = 99;
        }
        if($g_value_list = D('Goodsformat')->where(array('goods_id'=>$goods_id))->select()){
            $goods_value_list = array();
            foreach($g_value_list as $v){
                $goods_value_list[$v['id']] = $v;
            }
            if(!$goods_value = $goods_value_list[$vid]){
                 $this->error('你没有选择规格');
            }else if($goods_value_list[$vid]['goods_id'] != $goods_id){
                  $this->error('该商品配置信息不正确');
            }
            $cart_goods[$sku_id] = (int)$cart_goods[$sku_id] + $num;
            if($cart_goods[$sku_id] > $goods_value['store']){
                 $this->error('商品库存不足');
            }
        }else if($cart_goods[$sku_id] > $detail['kucun']){
             $this->error('商品库存不足');
        }else{
			$cart_goods[$sku_id] = (int)$cart_goods[$sku_id] + 1;
		}
        session('goods', $cart_goods);
		
        header("Location:" . U('mall/cart'));
        die;
    }
    public function cartadd($goods_id) {
        $shop_id = (int) $this->_param('shop_id');
        $goods_id = (int) $goods_id;
        $vid = (int) $this->_param('vid');
        $sku_id = $goods_id.'_'.$vid;
        if (empty($goods_id)) {
            die('请选择产品');
        }
        if (!$detail = D('Goods')->find($goods_id)) {
            die('该商品不存在');
        }
        if ($detail['closed'] != 0 || $detail['audit'] != 1) {
            die('该商品不存在');
        }
        if ($detail['end_date'] < TODAY) {
            die('该商品已经过期，暂时不能购买');
        }
        $cart_goods = session('goods');
        $num = (int) $this->_get('num');
        if (empty($num) || $num <= 0) {
            $num = 1;
        }
        if ($num > 99) {
            $num = 99;
        }
        if($g_value_list = D('Goodsformat')->where(array('goods_id'=>$goods_id))->select()){
            $goods_value_list = array();
            foreach($g_value_list as $v){
                $goods_value_list[$v['id']] = $v;
            }
            if(!$goods_value = $goods_value_list[$vid]){
                die('你没有选择规格');
            }else if($goods_value_list[$vid]['goods_id'] != $goods_id){
                 die('该商品配置信息不正确');
            }
            $cart_goods[$sku_id] = (int)$cart_goods[$sku_id] + $num;
            if($cart_goods[$sku_id] > $goods_value['store']){
                die('商品库存不存');
            }
        }else if($cart_goods[$sku_id] > $detail['kucun']){
            die('商品库存不存');
        }
        session('goods', $cart_goods);
        die('0');  
    }
    public function cartadd2() {
        if (IS_AJAX) {
            $shop_id = (int) $_POST['shop_id'];
            $goods_id = (int) $_POST['goods_id'];
            $vid = (int)$_POST['vid'];
            $sku_id = $goods_id.'_'.$vid;
            if (empty($goods_id)) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '请选择商品'));
            }
            if (!$detail = D('Goods')->find($goods_id)) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '该商品不存在'));
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '该商品不存在'));
            }
            if ($detail['end_date'] < TODAY) {
                $this->ajaxReturn(array('status' => 'error', 'msg' => '该商品已经过期，暂时不能购买'));
            }
            $cart_goods = session('goods');
            $num = (int) $this->_get('num');
            if (empty($num) || $num <= 0) {
                $num = 1;
            }
            if ($num > 99) {
                $num = 99;
            }
            if($g_value_list = D('Goodsformat')->where(array('goods_id'=>$goods_id))->select()){
                $goods_value_list = array();
                foreach($g_value_list as $v){
                    $goods_value_list[$v['id']] = $v;
                }
                if(!$goods_value = $goods_value_list[$vid]){
                    $this->ajaxReturn(array('status' => 'error', 'msg' => '你没有选择规格'));
                }else if($goods_value_list[$vid]['goods_id'] != $goods_id){
                    $this->ajaxReturn(array('status' => 'error', 'msg' => '该商品配置信息不正确'));
                }
                $cart_goods[$sku_id] = (int)$cart_goods[$sku_id] + $num;
                if($cart_goods[$sku_id] > $goods_value['store']){
                    $this->ajaxReturn(array('status' => 'error', 'msg' => '商品库存不存'));
                }
            }else if($cart_goods[$sku_id] > $detail['kucun']){
                $this->ajaxReturn(array('status' => 'error', 'msg' => '商品库存不存'));
            }else{
                $cart_goods[$sku_id] = (int)$cart_goods[$sku_id] + $num;
            }
            session('goods', $cart_goods);
            $this->ajaxReturn(array('status' => 'success', 'msg' => '加入购物车成功'));
        }
    }
    public function cart() {
            $cart_goods = session('goods');    
            if (empty($cart_goods)) {
                $this->error("亲还没有选购产品呢!", U('mall/index'));
            }
            $good_list = array();
            $total_num = 0;
            foreach($cart_goods as $k => $v){
                list($gid, $vid) = explode('_', $k);
                $gid = (int)$gid; $vid = (int)$vid;
                $goods_ids[$gid] = $gid;
                $value_ids[$vid] = $vid;
            }
            $goods_list = $goods_value_list = array();
            if($goods_ids){
                if($value_ids){
                    $_values_list = D('Goodsformat')->where(array('id'=>array('IN', implode(',', $value_ids))))->select();
                    foreach($_values_list as $v){
                        $goods_value_list[$v['id']] = $v;
                    }
                }
                if($_goods_list = D('Goods')->where(array('goods_id'=>array('IN', implode(',', $goods_ids))))->select()){
                    foreach($_goods_list as $v){
                        if ($v['closed'] != 0 || $v['audit'] != 1 || $v['end_date'] < TODAY) {
                            continue;
                        }else if($v['rush_ltime'] > $now_time && $v['rush_kucun']>= $cart_goods[$v['goods_id'].'_0']){
                            //抢购时商品价格和库存使用抢购的
							if($v['rush_price'] && $v['rush_kucun']){
								$v['mall_price'] = $v['rush_price'];
								$v['kucun'] = $v['rush_kucun'];
							}
							
                        }                        
                        $goods_list[$v['goods_id']] = $v;
                    }
                }
                $_cart_goods = array();
                foreach($cart_goods as $k=>$v){
                    list($gid, $vid) = explode('_', $k);
                    $gid = (int)$gid; $vid = (int)$vid;
                    $row = $value = array();
                    $row = $goods_list[$gid];
                    if($vid){
                        if($goods_value_list[$vid]['goods_id'] != $gid){
                            continue;
                        }
                        $value = $goods_value_list[$vid];
                        if($value['mall_price'] > $value['price']){
                            $cc = $value['mall_price'];
                            $value['mall_price'] = $value['price'];
                            $value['price'] = $cc;
                        }
                        $total_price += $value['mall_price'] * (int)$v;
                    }else{
                        if($row['mall_price'] > $row['price']){
                            $aa = $row['mall_price'];
                            $row['mall_price'] = $row['price'];
                            $row['price'] = $aa;
                        }
                        $total_price += $row['mall_price'] * (int)$v;
                    }
                    $row['num'] = (int)$v;
                    $row['vid'] = $vid;
                    $total_num += (int)$v;
                    $row['store'] = $row['kucun'] = $value['store'];
					if($value){
						$row['mall_price'] = $value['mall_price'];
						$row['total_price'] = $row['mall_price'] * $row['num'];
					}else{
						
						$row['total_price'] = $row['mall_price'] * $row['num'];
					}
                    if($value['photo']){
                        $row['photo'] = $value['photo'];
                    }
                    $row['value'] = $value;
                    $row = array_merge($goods_list[$gid], $row);
                    $_cart_goods[$k] = $row;
                }              
                $cart_goods = $_cart_goods;
            }
           // print_r($_cart_goods);echo 'File:',__FILE__,',Line:',__LINE__;exit;
            
            $this->assign('total_num',$total_num);
            $this->assign('total_price',$total_price);
            $this->assign('cart_goods',$cart_goods);
			
            $this->display();

/*        $goods = session('goods');       
        $back = end($goods);
        $back = key($goods); //传递访问的最后一个商品的ID
        $this->assign('back', $back);
        if (empty($goods)) {
            $this->error("亲还没有选购产品呢!", U('mall/index'));
        }
        $goods_ids = array_keys($goods);
        $cart_goods = D('Goods')->itemsByIds($goods_ids);
        $shop_ids = array();
        foreach ($cart_goods as $k => $val) {
            $cart_goods[$k]['buy_num'] = $goods[$k];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $this->assign('cart_shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('cart_goods', $cart_goods);
        $this->mobile_title = '购物车';
        $this->display();*/
    }
    public function detail($goods_id=0, $vid=0) {
        $goods_id = (int) $goods_id;
        if (empty($goods_id)) {
            $this->error('商品不存在');
        }
        if (!$detail = D('Goods')->find($goods_id)) {
            $this->error('商品不存在');
        }
        if ($detail['closed'] != 0 || $detail['audit'] != 1) {
            $this->error('商品不存在');
        }
        $shop_id = $detail['shop_id'];
        $recom = D('Goods')->where(array('shop_id' => $shop_id, 'goods_id' => array('neq', $goods_id)))->select();
        $record = D('Usersgoods');
        $insert = $record->getRecord($this->uid, $goods_id);
        $this->assign('recom', $recom);
        $shop = D('Shop')->find($shop_id);
        $weidian = D('Weidiandetails')->where(array('shop_id' => $shop_id))->find();
        if ($weidian) {
            $shop['weidian_id'] = $weidian['id'];
        }
        if($detail['max_buy']<=0){
            $detail['max_buy'] = '99';
        }
        $this->assign('now_time', time());
        $this->assign('shop', $shop);
        $this->mobile_title = '商品详情';
        $goods_vid = 0;
        if($goods_value_list = D('Goodsformat')->where(array('goods_id'=>$goods_id))->select()){
            $gvid = (int)$_GET['vid'];
            $goods_value = $goods_value_list[0];
            $goods_vid = $goods_value['id'];
            $format_list = D('Format')->format_goodsid($goods_id, $detail['shopcate_id']);
            $content_format_values = array(); //以content为key的数组
            foreach($goods_value_list as $v){
                if($v['id'] == $gvid){
                    $goods_value = $v;
                    $goods_vid = $gvid;
                }
                foreach(explode('-', $v['content']) as $vid){
                    $goods_value_ids[$vid] = $vid;
                }
                $content_format_values[$v['content']] = $v;
            }
            $goods_value['values'] = explode('-', $goods_value['content']);
            $format_select_value = array();
            foreach($format_list as $v){
                foreach($v['values'] as $vv){
                    if(in_array($vv['id'], $goods_value['values'])){
                        $format_select_value[$vv['format_id']] = $vv['id'];
                    }
                }
            }
            foreach($format_list as $v){
                $_is_have = false;
                $_values = array();
                $__vids = $format_select_value;
                foreach($v['values'] as $vv){                    
                    if(in_array($vv['id'], $goods_value_ids)){
                        $__vids[$vv['format_id']] = $vv['id'];
                        asort($__vids);
                        if($_val = $content_format_values[implode('-', $__vids)]){
                            $_is_have = true;
                            $vv['vid'] = $_val['id'];
                            $_values[$vv['id']] = $vv; 
                        }
                        if(in_array($vv['id'], $format_select_value)){
                            $vv['checked'] = true;
                        }
                        $_is_have = true;
                        $_values[$vv['id']] = $vv;                        
                    }
                    $v['values'] = $_values;
                }                
                if($_is_have){
                    $_format_list[$v['id']] = $v;
                }
            }
            $format_list = $_format_list; 
            $detail['value'] = $goods_value;
            if($goods_value['photo']){
                $detail['photo'] = $goods_value['photo'];
            }
            $detail['store'] = $goods_value['store'];
            $detail['mall_price'] = $goods_value['price'];
            $detail['price'] = $goods_value['mall_price'];
            
        }
        $detail['vid'] = $goods_vid;
        $this->assign('detail', $detail);
        $this->assign('goods_vid', $goods_vid);
        $this->assign('goods_value', $goods_value);
        $this->assign('format_list',$format_list);
        $this->display();
    }
    public function cartdel() {
        $goods_id = (int) $this->_get('goods_id');
        $goods = session('goods');
        if (isset($goods[$goods_id])) {
            unset($goods[$goods_id]);
            session('goods', $goods);
        }
        die('0');
    }
    public function cartdel2() {
        $goods_id = (int) $this->_get('goods_id');
		$vid = (int) $this->_get('vid');
        $goods = session('goods');
		$goods_vid = $goods_id . "_" . $vid;
        if (isset($goods[$goods_vid])) {
            unset($goods[$goods_vid]);
            session('goods', $goods);
        }
        header("Location:" . U('mall/cart'));
        //$this->success('删除成功', U('mall/cart'));
    }
    public function neworder() {
        $goods = $this->_get('goods');
        $goods = explode(',', $goods);
        if (empty($goods)) {
            $this->error('亲购买点吧');
        }
        $datas = array();
        foreach ($goods as $val) {
            $good = explode('-', $val);
            $good[1] = (int) $good[1];
            if (empty($good[0]) || empty($good[1])) {
                $this->error('亲购买点吧');
            }
            if ($good[1] > 99 || $good[1] < 0) {
                $this->error('本店不支持批发');
            }
            $datas[$good[0]] = $good[1];
        }
        session('goods', $datas);
        header("Location:" . U('mall/cart'));
        die;
    }
    public function order() {
        if (empty($this->uid)) {
            AppJump();
        }
        $num = $this->_post('num', false);
        $vids = $goods_ids = array();
        $now_time = time();
        $cart_goods = $goods_ids = $value_ids = array();
        foreach ($num as $k => $val) {
            if(($val = (int) $val) && ($val >0) && ($val < 100)){
                $cart_goods[$k] = $val;
                list($gid, $vid) = explode('_', $k);
                $gid = (int)$gid; $vid = (int)$vid;
                $goods_ids[$gid] = $gid;
                $value_ids[$vid] = $vid;
                $cart_goods[$k] = $val;
            }
        }
        if($value_ids){
            if($items = D('Goodsformat')->where(array('id'=>array('IN', implode(',', $value_ids))))->select()){
                foreach($items as $v){
                    $value_list[$v['id']] = $v;
                }
            }
        }
        if($goods_ids){
            if($items = D('Goods')->where(array('goods_id'=>array('IN', implode(',', $goods_ids))))->select()){                
                foreach($items as $v){
                    if ($v['closed'] != 0 || $v['audit'] != 1 || $v['end_date'] < TODAY) {
                        continue;
                    }else if($v['rush_ltime'] > $now_time && $v['rush_kucun']>= $cart_goods[$v['goods_id'].'_0']){
                        //抢购时商品价格和库存使用抢购的
                        $v['mall_price'] = $v['rush_price'];
                        $v['kucun'] = $v['rush_kucun'];
                    }
                    $goods_list[$v['goods_id']] = $v;
                }
            }
        }
        $_cart_goods = $order_goods = array();
        foreach($cart_goods as $k=>$v){
            list($gid, $vid) = explode('_', $k);
            $gid = (int)$gid; $vid = (int)$vid;
            $val = $value = array();            
            if($val = $goods_list[$gid]){
                if($vid){
                    if($value_list[$vid]['goods_id'] != $gid){
                        continue;
                    }
                    $value = $value_list[$vid];
                    $val['store'] = $value['store'];
                    if($value['mall_price'] > $value['price']){
                        $a = $value['mall_price'];
                        $value['mall_price'] = $value['price'];
                        $value['price'] = $a;
                    }
                    $val['mall_price'] = $value['mall_price'];
                    $total_price += $value['mall_price'] * (int)$v;
                }else{
                    $total_price += $goods['mall_price'] * (int)$v;
                }
                if($val['kucun'] < $val['num']){
                    $this->baoError($val['title'].'的库存不足！');
                }
                $val['num'] = (int)$v;
                $val['vid'] = $vid;
                $total_num += (int)$v;
                $val['value'] = $value;
                $val = array_merge($goods_list[$gid], $val);
                $_cart_goods[$k] = $val;
                $order_goods[$val['shop_id']]['total_price'] += $val['mall_price'] * $val['num'];
                $order_goods[$val['shop_id']]['goods'][$k] = $val;
            }
        }        
        if (empty($_cart_goods)){
            $this->ajaxReturn('订单错误:没有选择要购买的商品','JSON');
        }
        $tui = cookie('tui');
        if (!empty($tui)) {//推广部分
            $tui = explode('_', $tui);
            $tuiguang = array('uid' => (int) $tui[0],'goods_id' => (int) $tui[1]);
        }     
        $order_ids = array();        
        foreach($order_goods as $sid=>$val){
            $shop = D('shop')->find($sid);
            $a = array('shop_id'=>$sid, 'user_id'=>$this->uid);
            $a['is_shop'] = (int) $shop['is_pei']; //是否由商家自己配送
            $a['create_time'] = time();
            $a['create_ip'] = get_client_ip();
            $a{'total_price'} = $val['total_price'];         
            if($order_id = D('Order')->add($a)){ //后期可以考虑加上事务回滚功能
                $order_ids[$order_id] = $order_id;
                foreach($val['goods'] as $k=>$v){
                    $b = array('order_id'=>$order_id, 'shop_id'=>$sid, 'goods_id'=>$v['goods_id'], 'vid'=>$v['vid']);
                    if($tuiguang && $tuiguang['goods_id'] == $v['goods_id']){
                        $b['tui_uid'] = $tuiguang['uid'];
                    }
                    $b['num'] = $v['num'];
                    if($v['mall_price'] > $v['price']){
                        $aa = $v['mall_price'];
                        $v['mall_price'] = $v['price'];
                        $v['price'] = $aa;
                    }
                    $b['price'] = $v['mall_price'];
                    $b['total_price'] = $v['mall_price'] * $v['num'];
                    $b['spec_name'] = $v['value']['format_title'];
                    $b['title'] = $v['title'];
                    if(!$photo = $v['value']['photo']){
                        $photo = $v['photo'];
                    }
                    $b['photo'] = $photo;
                    $b['create_time'] = time();
                    $b['create_ip'] = get_client_ip();                    
                    if(D('Ordergoods')->add($b)){ //扣除库存                        
                        if($v['vid'] && $v['rush_ltime'] > $now_time && $v['rush_kucun']>= $v['num']){ //抢购时减去抢购库存
                            D('Goods')->updateCount($v['goods_id'], 'rush_kucun', -$v['num']);
                        }
                        D('Goods')->updateCount($v['goods_id'], 'kucun', -$v['num']);
                    }
                }                
            }  
        }
        session('goods', null);
        if (count($order_ids) > 1) {//如果大于1 那么形成一个 支付记录 来合并付款！如果其他条件可以直接去付款
            //$need_pay = D('Order')->useIntegral($this->uid,$order_ids);
            //$detail1 = D('Ordergoods')->where(array('order_id'=>$order_id))->find();
            $detail1 = D('Order')->find($order_id);
            //print_r($detail1);die;
            $need_pay = $detail1['total_price'];
            $logs = array(
                'type' => 'goods',
                'user_id' => $this->uid,
                'order_id' => 0,
                'order_ids' => join(',', $order_ids),
                'code' => '',
                'need_pay' => $need_pay, //使用积分后的支付金额
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);
            $url = U('mall/paycode', array('log_id' => $logs['log_id']));
        } else {
            $url =  U('mall/pay', array('order_id' => $order_id));
        }
        die(json_encode(array('ret'=>0,'url'=>$url)));
    }
    public function paycode() {
        $log_id = (int) $this->_get('log_id');
        if (empty($log_id)) {
            $this->error('没有有效支付记录！');
        }
        if (!$detail = D('Paymentlogs')->find($log_id)) {
            $this->error('没有有效的支付记录！');
        }
        if ($detail['is_paid'] != 0 || empty($detail['order_ids']) || !empty($detail['order_id']) || empty($detail['need_pay'])) {
            $this->error('没有有效的支付记录！');
        }
        $order_ids = explode(',', $detail['order_ids']);
        $ordergood = D('Ordergoods')->where(array('order_id' => array('IN', $order_ids)))->select();

        $goods_id = $shop_ids = array();

        foreach ($ordergood as $k => $val) {
            $goods_id[$val['goods_id']] = $val['goods_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $this->assign('goods', D('Goods')->itemsByIds($goods_id));
        $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('ordergoods', $ordergood);
        $this->assign('useraddr', D('Useraddr')->where(array('user_id' => $this->uid))->limit()->select());
        $this->assign('payment', D('Payment')->getPayments());
        $this->assign('logs', $detail);
        $this->mobile_title = '订单支付';
        $this->display();
    }
    
    
    
    public function pay() {
        if (empty($this->uid)) {
            AppJump();
        }
        $this->check_mobile();
        $order_id = (int) $this->_get('order_id');
        $order = D('Order')->find($order_id);
        if (empty($order) || $order['status'] != 0 || $order['user_id'] != $this->uid) {
            $this->error('该订单不存在');
            die;
        }
        $ordergood = D('Ordergoods')->where(array('order_id' => $order_id))->select();

        $goods_id = $shop_ids = array();
        foreach ($ordergood as $k => $val) {
            $goods_id[$val['goods_id']] = $val['goods_id'];
            $shop_ids[$val['shop_id']] = $val['shop_id'];
        }
        $this->assign('goods', D('Goods')->itemsByIds($goods_id));
        $this->assign('shops', D('Shop')->itemsByIds($shop_ids));
        $this->assign('ordergoods', $ordergood);
        $this->assign('useraddr', D('Useraddr')->where(array('user_id' => $this->uid))->limit()->select());
        $this->assign('order', $order);
        $this->assign('payment', D('Payment')->getPayments(true));
        
        $url = U('mcenter/goods/detail', array('order_id' => $order_id));
        $this->assign('url',$url);
        
        $this->mobile_title = '订单支付';
        $this->display();
    }
    
    public function paycode2() { //这里是因为原来的是按订单付，这里是合并付款逻辑部分 
        $log_id = (int) $this->_get('log_id');
        if (empty($log_id)) {
            $this->error('没有有效支付记录！');
        }
        if (!$detail = D('Paymentlogs')->find($log_id)) {
            $this->error('没有有效的支付记录！');
        }
        if ($detail['is_paid'] != 0 || empty($detail['order_ids']) || !empty($detail['order_id']) || empty($detail['need_pay'])) {
            $this->error('没有有效的支付记录！');
        }
        $order_ids = explode(',', $detail['order_ids']);
        $addr_id = (int) $this->_post('addr_id');
        if (empty($addr_id)) {
            $this->error('请选择一个要配送的地址！');
        }
        D('Order')->where(array('order_id' => array('IN', $order_ids)))->save(array('addr_id' => $addr_id));
        if (!$code = $this->_post('code')) {
            $this->error('请选择支付方式！');
        }
        if ($code == 'wait') { //如果是货到付款
            D('Order')->save(array(
                'is_daofu' => 1,
                    ), array('where' => array('order_id' => array('IN', $order_ids))));
            D('Ordergoods')->save(array(
                'is_daofu' => 1,
                    ), array('where' => array(
                    'order_id' => array('IN', $order_ids)
            )));
            D('Payment')->mallSold($order_ids);
            D('Payment')->mallPeisong(array($order_ids), 1);
			foreach($order_ids as $v){
				D('Sms')->mallTZshop($v);
			}
            
            $this->success('恭喜您下单成功！', U('mcenter/goods/index'));
        } else {
            $payment = D('Payment')->checkPayment($code);
            if (empty($payment)) {
                $this->error('该支付方式不存在');
            }
            $detail['code'] = $code;
            D('Paymentlogs')->save($detail);
            header("Location:" . U('payment/payment', array('log_id' => $detail['log_id'])));
        }
    }
    public function combine() {
        if (empty($this->uid)) {
            AppJump();
        }
        $log_id = (int) $this->_get('log_id');
        header("Location:" . U('payment/payment', array('log_id' => $log_id)));
        exit;
        if (!$detail = D('Paymentlogs')->find($log_id)) {
            $this->error('没有有效的支付记录！');
        }
        if ($detail['is_paid'] != 0 || empty($detail['order_ids']) || !empty($detail['order_id']) || empty($detail['need_pay'])) {
            $this->error('没有有效的支付记录！');
        }
        $this->assign('button', D('Payment')->getCode($detail));
        $this->assign('logs', $detail);
        $this->mobile_title = '订单支付';
        $this->display();
    }
    public function pay2() {
        if (empty($this->uid)) {
            AppJump();
        }
        $order_id = (int) $this->_get('order_id');
        $order = D('Order')->find($order_id);
        if (empty($order) || $order['status'] != 0 || $order['user_id'] != $this->uid) {
            $this->error('该订单不存在');
        }

        $addr_id = (int) $this->_post('addr_id');

        if (empty($addr_id)) {
            $this->error('请选择一个要配送的地址！');
        }
        D('Order')->save(array('addr_id' => $addr_id, 'order_id' => $order_id));
        if (!$code = $this->_post('code')) {
            $this->error('请选择支付方式！');
        }

        $ua = D('UserAddr');
        $uaddr = $ua->where(array('addr_id' => $order['addr_id']))->find();

        if ($code == 'wait') { //如果是货到付款
            D('Order')->save(array(
                'order_id' => $order_id,
                'is_daofu' => 1,
            ));
            D('Ordergoods')->save(array(
                'is_daofu' => 1,
                    ), array('where' => array(
                    'order_id' => $order_id
            )));

            D('Payment')->mallSold($order_id);
            D('Payment')->mallPeisong(array($order_id), 1);
            $goods_ids = D('Ordergoods')->where("order_id={$order_id}")->getField('goods_id', true);
            $goods_ids = implode(',', $goods_ids);
            $map = array('goods_id' => array('in', $goods_ids));
            $goods_name = D('Goods')->where($map)->getField('title', true);
            $goods_name = implode(',', $goods_name);
            //====================微信支付通知===========================
            include_once "Baocms/Lib/Net/Wxmesg.class.php";
            /* 微信订单通知消息-开始 */
            $notice_data = array(
                'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/mcenter/goods/index/aready/' . $order_id . '.html',
                'first' => '亲,您的订单创建成功!',
                'remark' => '详情请登录-http://' . $_SERVER['HTTP_HOST'],
                'amount' => round($order['total_price'] / 100, 2) . '元',
                'order' => $order_id,
                'info' => $goods_name
            );
            $notice_data = Wxmesg::notice($notice_data);
            Wxmesg::net($this->uid, 'OPENTM206930158', $notice_data);
            /* 微信订单通知消息-结束 */
            //====================微信支付通知===========================
            $this->success('恭喜您下单成功！', U('mcenter/goods/index'));
        } else {
            $payment = D('Payment')->checkPayment($code);
            if (empty($payment)) {
                $this->error('该支付方式不存在');
            }
            $logs = D('Paymentlogs')->getLogsByOrderId('goods', $order_id);
           // $need_pay = D('Order')->useIntegral($this->uid, array($order_id));
            $detail1 = D('Order')->find($order_id);
            //print_r($detail1);die;
            $need_pay = $detail1['total_price'];
            if (empty($logs)) {
                $logs = array(
                    'type' => 'goods',
                    'user_id' => $this->uid,
                    'order_id' => $order_id,
                    'code' => $code,
                    'need_pay' => $need_pay,
                    'create_time' => NOW_TIME,
                    'create_ip' => get_client_ip(),
                    'is_paid' => 0
                );
                $logs['log_id'] = D('Paymentlogs')->add($logs);
            } else {
                $logs['need_pay'] = $need_pay;
                $logs['code'] = $code;
                D('Paymentlogs')->save($logs);
            }
            $goods_ids = D('Ordergoods')->where("order_id={$order_id}")->getField('goods_id', true);
            $goods_ids = implode(',', $goods_ids);
            $map = array('goods_id' => array('in', $goods_ids));
            $goods_name = D('Goods')->where($map)->getField('title', true);
            $goods_name = implode(',', $goods_name);
            //====================微信支付通知===========================
            include_once "Baocms/Lib/Net/Wxmesg.class.php";
            /* 微信订单通知消息-开始 */
            $notice_data = array(
                'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/mcenter/goods/index/aready/' . $order_id . '.html',
                'first' => '亲,您的订单创建成功!',
                'remark' => '详情请登录-http://' . $_SERVER['HTTP_HOST'],
                'amount' => round($order['total_price'] / 100, 2) . '元',
                'order' => $order_id,
                'info' => $goods_name
            );
            $notice_data = Wxmesg::notice($notice_data);
            Wxmesg::net($this->uid, 'OPENTM206930158', $notice_data);
            /* 微信订单通知消息-结束 */
            //====================微信支付通知==============================
            
                header("Location:" . U('payment/payment', array('log_id' => $logs['log_id'])));
            
        }
    }
}
