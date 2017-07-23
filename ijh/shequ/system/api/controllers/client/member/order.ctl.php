 <?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Order extends Ctl
{


    public function items_all($params)
    {
        $this->check_login();       
        $filter = $items = array();
        $orderby = array('order_id'=>'DESC');
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        //加入个人中心条件筛选
        $type = (int)$params['type'];
        if($type == 1){ //待付款
            $filter['order_status'] = '>=:0';
            $filter['pay_status'] = 0;
            $filter['online_pay'] = 1;
            $filter['from'] = "<>:'maidan'";
            //$orderby = array('lasttime'=>'DESC');
        }else if($type == 2){ //待评价
            $filter['order_status'] = 8;
            $filter['comment_status'] = 0;
            //$orderby = array('lasttime'=>'DESC');
        }else if($type == 3){ //已退款
            $filter['order_status'] = '<:0';
            //$orderby = array('lasttime'=>'DESC');
        }else{
            $filter[':SQL'] = "((`from`='maidan' AND `pay_status`=1) OR `from`<>'maidan')";            
        }
        $limit = 10;
        $page = max((int)$params['page'], 1);
        $items = $this->_order_items($filter, $orderby, $page, $limit, $count);
        $this->msgbox->set_data('data', array('orders'=>array_values($items)));
    }

    /**
     * 订单列表
     * @param page,分页参数
     * @param type,
     * @param from,类型[tuan|waimai|paotui|maidan|weixiu|house|mall|other]
     */
    public function items($params)
    {
        $this->check_login();
        if($params['from'] && !in_array($params['from'],array('tuan','waimai','paotui','maidan','weixiu','house','mall','other'))){
            $this->msgbox->add('订单类型错误',211);
        }else{
            $filter = array('uid'=>$this->uid, 'closed'=>0, 'from'=>$params['from']);
            if($params['from'] == 'maidan'){
                $filter['pay_status'] = 1;
            }
            $orderby = array('order_id'=>'DESC');
            $type = $params['type'];
            if($params['type']){
                $filter['order_status'] = array(-1, -2, 8);
            }else{
                $filter['order_status'] = array(0, 1, 2, 3, 4, 5);
            }            
            $limit = 10;
            $page = max((int)$params['page'], 1);
            $items = $this->_order_items($filter, $orderby, $page, $limit, $count);
            $this->msgbox->set_data('data', array('items'=>array_values($items)));   
        }

    }

    public function comment_info($params)
    {
        $this->check_login();
        if(!$order = K::M('order/order')->detail($params['order_id'])){
            $this->msgbox->add('错误的订单！',211);
        }else if($order['uid'] != $this->MEMBER['uid']){
            $this->msgbox->add('非法操作！',212);
        }else{
            switch ($order['from']){

              case 'tuan':
              if($comment = K::M('shop/comment')->find(array('order_id'=>$order['order_id']))){
                  if($photo = K::M('shop/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  }
                  $comment['shop'] = K::M('shop/shop')->detail($order['shop_id']);
              }
              break;

              case 'maidan':
              if($comment = K::M('shop/comment')->find(array('order_id'=>$order['order_id']))){
                 if($photo = K::M('shop/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  }
                  $comment['shop'] = K::M('shop/shop')->detail($order['shop_id']);
              }
              break;
              
              case 'waimai':
              if($comment = K::M('waimai/comment')->find(array('order_id'=>$order['order_id']))){
                  if($photo = K::M('waimai/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  }
                  $comment['shop'] = K::M('waimai/waimai')->detail($order['shop_id']);
              }
              break;

              case 'house':
              if($comment = K::M('staff/comment')->find(array('order_id'=>$order['order_id']))){
                 if($photo = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  } 
                  $comment['staff'] = K::M('staff/staff')->detail($order['staff_id']);
              }
              break;
              
              
              case 'weixiu':
              if($comment = K::M('staff/comment')->find(array('order_id'=>$order['order_id']))){
                 if($photo = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  } 
                  $comment['staff'] = K::M('staff/staff')->detail($order['staff_id']);
              }
              break;
              
              
              case 'paotui':
              if($comment = K::M('staff/comment')->find(array('order_id'=>$order['order_id']))){
                  if($photo = K::M('staff/commentphoto')->items(array('comment_id'=>$comment['comment_id']))){
                    $comment['photo'] = array_values($photo);
                  }else{
                      $comment['photo'] = array();
                  }
                  $comment['staff'] = K::M('staff/staff')->detail($order['staff_id']);
              }
              break;

            }
            
     
            if(!$comment){
                $comment = array();
            }else{
                $comment['pei_time_label'] = $comment['pei_time'].'分钟送达';
                if($order['jd_time']){
                    $comment['ok_time'] = $order['jd_time'] + ($comment['pei_time'] * 60);
                }else{
                    $comment['ok_time'] = $order['dateline'] + ($comment['pei_time'] * 60);
                }
            }
            
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('comment'=>($comment)));
        }
    }
    
    public function detail($params)
    {
        $this->check_login();
        if(!$order = K::M('order/order')->detail($params['order_id'])){
            $this->msgbox->add('错误的订单！',211);
        }else if($order['uid'] != $this->MEMBER['uid']){
            $this->msgbox->add('非法操作！',212);
        }else{
            $jifen = $this->system->config->get('jifen');
            $order['jifen'] = $jifen['jifen_ratio']*$order['amount'];
            if($photo = K::M('order/photo')->items(array('order_id'=>$order['order_id']))){
                $order['photos'] = array_values($photo);
            }
            if($voice = K::M('order/voice')->items(array('order_id'=>$order['order_id']))){
                $order['voice'] = array_values($voice);
            }
            
            if($order['staff_id']>0){
                if(!$order['staff'] = K::M('staff/staff')->detail($order['staff_id'])) {
                    $order['staff'] = array('staff'=>'');
                }
                unset($order['staff']['passwd']);
            }
 
            if(!$order['shop'] = K::M('shop/shop')->detail($order['shop_id'])) {
                $order['shop'] = array('shop_id'=>'');
            } 
            unset($order['shop']['passwd']);
            switch ($order['from']){
            case 'tuan':
              $order['detail'] = K::M('tuan/order')->detail($order['order_id']);
              if($t = K::M('tuan/tuan')->detail($order['detail']['tuan_id'])){
                  $order['photo'] = $t['photo'];
              }
              $filter_t_ticket = array();
              $filter_t_ticket['uid'] = $order['uid'];
              $filter_t_ticket['shop_id'] = $order['shop_id'];
              $filter_t_ticket['order_id'] = $order['order_id'];
              $filter_t_ticket['tuan_id'] = $t['tuan_id'];
              if($quan = K::M('tuan/ticket')->items($filter_t_ticket)){
                  foreach($quan as $qk => $qv){
                      if($qv['number']){
                          $quan[$qk]['number'] = $qv['number'];
                      }
                  }
                  $order['quan'] = array_values($quan);
              }else{
                  $order['quan'] = array();
              }

              if($lat && $lng){
                  $order['juli'] = intval(K::M('helper/round')->getdistances($order['shop']['lng'],$order['shop']['lat'], $order['lng'],$order['lat']));
              }
              break;
            }
            if($order['from'] == 'waimai'){
              $order['detail'] = K::M('waimai/order')->detail($order['order_id']);
              if($order['detail']['spend_number']){
                 $order['detail']['spend_number'] = $order['detail']['spend_number']; 
              }
              $order['waimai'] = K::M('waimai/waimai')->detail($order['shop_id']);
              $p = K::M('waimai/orderproduct')->items(array('order_id'=>$order['order_id']));
              if($p){
                  foreach($p as $pk => $pv){
                      if($pv['spec_id']){
                          $ps = K::M('waimai/productspec')->detail($pv['spec_id']);
                          $p[$pk]['spec'] = $this->filter_fields('spec_name', $ps);;
                      }else{
                          $p[$pk]['spec'] = array('spec_id'=>0);
                      }
                  }
                  $order['products'] = array_values($p);
              }
            }else if($order['from'] == 'house'){
              $order['detail'] = K::M('house/order')->detail($order['order_id']);
                if($house_cate = K::M('house/cate')->detail($order['detail']['cate_id'])) {
                    $order['detail']['icon'] = $house_cate['icon'];
                }
            }else if($order['from'] == 'weixiu'){
              $order['detail'] = K::M('weixiu/order')->detail($order['order_id']);
                if($weixiu_cate = K::M('weixiu/cate')->detail($order['detail']['cate_id'])) {
                    $order['detail']['icon'] = $weixiu_cate['icon'];
                }
            }else if($order['from'] == 'paotui'){
              $order['detail'] = K::M('paotui/order')->detail($order['order_id']);
            }
            if(!$order['detail']) {
                $order['detail'] = array('detail'=>'');
            }
        }
        if($payments = K::M('order/order')->get_payments()) {
            $order['pay_code'] = $payments[$order['pay_code']];
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('order'=>($order)));
        
    }    
    
    public function log($params)
    { 
        $this->check_login();
        if(!$order = K::M('order/order')->detail($params['order_id'])){
            $this->msgbox->add('订单错误！',211);
        }else if($order['uid'] != $this->MEMBER['uid']){
            $this->msgbox->add('非法操作！',212);
        }else{
            if($shop = K::M('shop/shop')->detail($order['shop_id'])){
                $order['shop'] = $shop;
                $order['mobile'] = $shop['mobile'];
            }else{
                $order['shop'] = array('shop_id'=>0);
            }
            if($staff = K::M('staff/staff')->detail($order['staff_id'])){
                $order['staff'] = $staff;
                $order['mobile'] = $staff['mobile'];
            }else{
                $order['staff'] = array('staff_id'=>0);
            }
            
            $jifen = $this->system->config->get('jifen');
            if($order['from'] == 'waimai') {
                if($waimai_order = K::M('waimai/order')->detail($order['order_id'])) {
                    $order['package_price'] = $waimai_order['package_price'];
                    $order['product_price'] = $waimai_order['product_price'];
                    $order['spend_number'] = $waimai_order['spend_number'];
                    $order['spend_status'] = $waimai_order['spend_status'];
                    $order['freight'] = $waimai_order['freight'];
                }
            }else if($order['from'] == 'paotui' || $order['from'] == 'weixiu' || $order['from'] == 'house'){
                if($order['from'] == 'paotui') {
                    $order_child = K::M('paotui/order')->detail($params['order_id']);
                    $order['paotui_amount'] = $order_child['paotui_amount']; 
                    $order['danbao_amount'] = $order_child['danbao_amount'];
                    $order['jiesuan_amount'] = $order_child['jiesuan_amount'];
                    $order['paotui_type'] = $order_child['type'];
                }else if($order['from'] == 'weixiu') {
                    $order_child = K::M('weixiu/order')->detail($params['order_id']);
                    $order['danbao_amount'] = $order_child['danbao_amount'];
                    $order['jiesuan_price'] = $order_child['jiesuan_price'];
                }else if($order['from'] == 'house') {
                    $order_child = K::M('house/order')->detail($params['order_id']);
                    $order['danbao_amount'] = $order_child['danbao_amount'];
                    $order['jiesuan_price'] = $order_child['jiesuan_price'];
                }
            }
            $jifen_total = (int)($order['amount']*$jifen['jifen_ratio']);
            $order['jifen_ratio'] = $jifen['jifen_ratio'];
            $order['log'] = array_values(K::M('order/log')->items(array('order_id'=>$order['order_id']), array('log_id'=>'DESC')));
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('log'=>$order, 'jifen_total'=>$jifen_total));
        }
        
    }

    //外卖商家和普通商家评论通用
    public function comment_handle($params)
    {
        $this->check_login();
        $data = array('uid'=>$this->uid);
        if(!$data['order_id'] = (int)$params['order_id']){
            $this->msgbox->add('错误的订单!',216);
        }else if(!$order = K::M('order/order')->detail($data['order_id'])){
            $this->msgbox->add('错误的订单!',216);
        }else if($order['from'] == 'waimai' && (!$data['score_fuwu'] = $params['score_fuwu']) && ($order['pei_type'] != 3)){
            $this->msgbox->add('请正确选择服务评分!'.$datas['score_fuwu'],211);
        }else if($order['from'] == 'waimai' &&(!$data['score_kouwei'] = $params['score_kouwei'])){
            $this->msgbox->add('请正确选择商品评分!',213);
        }else if(!$data['score'] = $params['score']){
            $this->msgbox->add('请正确选择总评分!',214);
        }else if($order['from'] == 'waimai' && ($order['pei_type'] != 3) && (!$data['pei_time'] = $params['pei_time'])){
            $this->msgbox->add('没有选择配送速度!',212);
        }else if(!$data['content'] = $params['content']){
            $this->msgbox->add('没有填写评价内容!',215);
        }else if($order['comment_status'] != 0 || !empty($order['comment_status'])){
            $this->msgbox->add('请勿重复评价!',216);
        }else{
            // if(!$data['pei_time'] = $params['pei_time']){
            //     $data['pei_time'] = 0;
            // }
            $data['shop_id'] = $order['shop_id'];
            if($_FILES){
                $data['have_photo'] = 1;
            }
            if($order['from'] == 'waimai'){
                $mdl_comment = K::M('waimai/comment');
                $mdl_photo = K::M('waimai/commentphoto');
            }else{
                $mdl_comment = K::M('shop/comment');
                $mdl_photo = K::M('shop/commentphoto');
            }
            //插入评价
            if($comment_id = $mdl_comment->create($data)){
                if($_FILES){
                    foreach($_FILES as $k => $v){
                        if($a = K::M('magic/upload')->upload($v,'photo')){
                            $photo_data = array(
                                'comment_id' => $comment_id,
                                'photo' => $a['photo']
                            );
                            $mdl_photo->create($photo_data);
                        }
                    }
                }                              
                if($order['from'] == 'waimai'){
                    $waimai = K::M('waimai/waimai')->detail($order['shop_id']);
                    $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$data['score'],'score_fuwu'=>'`score_fuwu`+'.$data['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$data['score_kouwei'],'pei_time'=>$pei_times);
                    if($data['score']>3){
                        $update_data['praise_num'] = '`praise_num`+1';
                    }
                    $update_data['pei_time'] = (int)(($waimai['pei_time'] * $waimai['comments'] + $data['pei_time'])/($waimai['comments'] + 1));
                    K::M('waimai/waimai')->update($order['shop_id'], $update_data, true);
                    // 只有外卖订单评价才会获得积分
                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int)($order['amount']*$jifen['jifen_ratio']);
                    K::M('member/member')->update_jifen($this->uid,$jifen_total,'订单'.$data['order_id'].'评价完成，获得积分');                    
                }else{
                    $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$data['score']);   
                    K::M('shop/shop')->update($order['shop_id'], $update_data, true);
                }                   
                K::M('order/order')->update($order['order_id'], array('comment_status'=>1));
                $title = sprintf("订单已评价");
                $content = sprintf("用户(%s)已评价了订单(ID：%s)，%s", $order['contact'], $order['order_id'], $data['content']);
                K::M('shop/shop')->send($order['shop_id'], $title, $content, 'comment', $order_id);
            } 
        }
 

    }
    
    public function staff_comment_handle($params)  //服务人员评价
    {
        $this->check_login();            
        $data = array('uid'=>$this->uid);
        if(!$this->uid){
            $this->msgbox->add('您还没有登录!',101);
        }else if(!$data['order_id'] = (int)$params['order_id']){
            $this->msgbox->add('错误的订单!',216);
        }else if(!$order = K::M('order/order')->detail($data['order_id'])){
            $this->msgbox->add('错误的订单!',216);
        }else if(empty($order['staff_id'])){
            $this->msgbox->add('错误的服务人员!',216);
        }else if(!$data['score'] = (int)$params['score']){
            $this->msgbox->add('请正确选择总评分!',214);
        }else if(!$data['content'] = $params['content']){
            $this->msgbox->add('没有填写评价内容!',215);
        }else{
            $data['staff_id'] = $order['staff_id'];
            if($_FILES){
                $data['have_photo'] = 1;
            }
            if($comment_id = K::M('staff/comment')->create($data)){
                if($_FILES){
                    //插入评价
                    foreach($_FILES as $k => $v){
                        if($a = K::M('magic/upload')->upload($v,'photo')){
                            $photo_data = array(
                                'comment_id' => $comment_id,
                                'photo' => $a['photo']
                            );
                            $create_photo = K::M('staff/commentphoto') ->create($photo_data);
                        }
                    }
                }
                //更新评分
                K::M('staff/staff')->update($order['staff_id'], array('score'=>'`score`+'.$data['score'], 'comments'=>'`comments`+1'), true);
                K::M('order/order')->update($order['order_id'], array('comment_status'=>1));
                //通知服务人员
                $title = sprintf("用户[%s]对您进行了评价(单号：%s)", $order['contact'], $order['order_id']);
                $content = sprintf("用户[%s]对您进行了评价：%s", $order['contact'], $data['content'], $order['order_id']);
                K::M('staff/staff')->send($order['staff_id'], $title, $content, 'comment', $order['order_id']);
            }
        }

    }

    //订单投诉
    public function complaint_handle($params)
    {  
        $this->check_login();
        if(!$order_id = (int)$params['order_id']){
            $this->msgbox->add('订单不能为空!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',222);
        }else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂时不可投诉!',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',213);
        }else if(!$title = $params['title']){
            $this->msgbox->add('没有选择投诉类型!',214);
        }else if(!$content = $params['content']){
            $this->msgbox->add('没有填写投诉内容!',215);
        }else if(K::M('order/complaint')->count(array('uid'=>$this->uid,'order_id'=>$order_id))){
            $this->msgbox->add('该订单已经投诉过了!',216);
        }else{
            $data = array(
                'order_id'=>$order_id,
                'uid'=>$this->uid,
                'shop_id'=>$order['shop_id'],
                'staff_id'=>$order['staff_id'],
                'title'=>$title,
                'content'=>$content
            );
            if($complaint_id = K::M('order/complaint')->create($data)){
                $title = sprintf("投诉[%s]", $title);
                $content = $title.'，'.$content;
                if($order['shop_id']){
                    K::M('shop/shop')->send($order['shop_id'], $title, $content, 'complaint', $order_id);
                }
                if($staff_id = $order['staff_id']) {
                    K::M('staff/staff')->send($order['staff_id'], $title, $content, 'complaint', $order_id);
                }                
                $this->msgbox->set_data('data', array('complaint_id'=>$complaint_id));
                $this->msgbox->add('success');
            }
        }

    }
    
    protected function _order_items($filter, $orderby, $page=1, $limit=10, &$count=0)
    {
        $items = array();
        if($order_list = K::M('order/order')->items($filter, $orderby, $page, $limit, $count)){
            $order_ids = $shop_ids = $staff_ids = $waimai_shop_ids = array();
            foreach($order_list as $k=>$v){
                if($v['shop_id']){
                    $shop_ids[$v['shop_id']] = $v['shop_id'];
                }
                $staff_ids[$v['staff_id']] = $v['staff_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
                if($v['from'] == 'tuan'){
                    $tuan_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'maidan'){
                    $maidan_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'waimai'){
                    $waimai_shop_ids[$v['shop_id']] = $v['shop_id']; 
                    $waimai_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'paotui'){
                    $paotui_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'house'){
                    $house_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'weixiu'){
                    $weixiu_order_ids[$v['order_id']] = $v['order_id'];
                }else if($v['from'] == 'mall'){
                    $mall_order_ids[$v['order_id']] = $v['order_id'];
                }
            }
            if($tuan_order_ids){
                if($tuan_order_list = K::M('tuan/order')->items_by_ids($tuan_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $tuan_order_list[$v['order_id']]){
                            $row['photo'] = $v['tuan_photo'];
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }
                }
            }
            if($maidan_order_ids){
                if($maidan_order_list = K::M('maidan/order')->items_by_ids($maidan_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $maidan_order_list[$v['order_id']]){
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }
                }
            }
            if($waimai_order_ids){
                if($waimai_order_list = K::M('waimai/order')->items_by_ids($waimai_order_ids)){
                    $waimai_list = K::M('waimai/waimai')->items_by_ids($waimai_shop_ids);
                    foreach($order_list as $k=>$v){
                        if($row = $waimai_order_list[$v['order_id']]){
                             if($a = $waimai_list[$v['shop_id']]){
                                $v['waimai_title'] = array('title'=>$a['title']);
                                $v['waimai_logo'] = array('logo'=>$a['logo']);
                            }else{
                                $v['waimai_title'] = array('title'=>'');
                                $v['waimai_logo'] = array('logo'=>'default/shop.png');
                            }
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }                   
                }
            }
            if($paotui_order_ids){
                if($paotui_order_list = K::M('paotui/order')->items_by_ids($paotui_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $paotui_order_list[$v['order_id']]){
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }
                }
            }            
            if($weixiu_order_ids){
                if($weixiu_order_list = K::M('weixiu/order')->items_by_ids($weixiu_order_ids)){
                    $weixiu_cate_list = K::M('weixiu/cate')->fetch_all();
                    foreach($order_list as $k=>$v){
                        if($row = $weixiu_order_list[$v['order_id']]){
                            $row['icon'] = $weixiu_cate_list[$row['cate_id']]['icon'];
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }
                }
            }
            if($house_order_ids){
                if($house_order_list = K::M('house/order')->items_by_ids($house_order_ids)){
                    $house_cate_list = K::M('house/cate')->fetch_all();
                    foreach($order_list as $k=>$v){
                        if($row = $house_order_list[$v['order_id']]){
                            $row['icon'] = $house_cate_list[$row['cate_id']]['icon'];
                            $v['order'] = $row;
                            $items[$k] = $v;
                        }
                        //$order_list[$k] = $v;
                    }
                }
            }
            if($mall_order_ids){
                if($house_order_list = K::M('mall/order')->items_by_ids($mall_order_ids)){
                    foreach($order_list as $k=>$v){
                        if($row = $mall_order_ids[$v['order_id']]){
                            $v['order'] = $row;
                        }
                        $order_list[$k] = $v;
                    }
                }
            }
            //积分配置
            $jifen = $this->system->config->get('jifen');
            $shop_list = K::M('shop/shop')->items_by_ids($shop_ids);
            foreach($items as $k=>$v){
                $v['jifen'] = (int)($jifen['jifen_ratio']*$v['amount']);
                if($row = $shop_list[$v['shop_id']]){
                    $v['shop'] = $this->filter_fields('shop_id,contact,cate_id,mobile,phone,thumb,logo,title', $row);
                }else{
                    $v['shop'] = array('shop_id'=>$v['shop_id'], 'title'=>'','contact'=>'', 'cate_id'=>0, 'mobile'=>'', 'phone'=>'', 'thumb'=>'','logo'=>'default/shop_logo.png');
                }
                $items[$k] = $v;
            }
        }
        return $items;
    }
        
}