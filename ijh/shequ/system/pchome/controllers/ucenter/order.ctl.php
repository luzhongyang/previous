<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Order extends Ctl_Ucenter
{
    public function index($st,$page=1)
    {
        $filter = $pager = $items = array();
        $pager['limit'] = $limit = 10;
        $pager['page'] = $page = max((int) $page, 1);
        $filter['uid'] = $this->uid;
        $filter['closed'] = 0;
        $filter['from'] = "tuan";
        if($st = (int)$st){
            if(in_array($st,array(0,1,2,3,4,5))){
                if($st == 1){
                   $filter['order_status'] = 0;
                    $filter['pay_status'] = 0;
                }elseif($st == 2){
                    $filter['order_status'] = 5;
                }elseif($st == 3){
                    $filter['order_status'] = 8;
                    $filter['comment_status'] = 0;
                }elseif($st == 4){
                    $filter['order_status'] = 8;
                }elseif($st == 5){
                    $filter['order_status'] = -1;
                }
            }
        }
        $this->pagedata['st'] = $st;
        $today = date('Y-m-d',__TIME);
        if($date = (int)$this->GP('date')){
            if(in_array($date,array(0,1,2,3,4))){
                if($date == 1){
                    $stime = strtotime($today) - 7*86400; 
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 2){
                    $stime = strtotime("-1 month",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 3){
                    $stime = strtotime("-3 month",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }elseif($st == 4){
                    $stime = strtotime("-1 year",strtotime($today));
                    $filter['dateline'] = $stime.'~'.__TIME;
                }
            }
        }
        $this->pagedata['date'] = $date;
        
        if (!$items = K::M('order/order')->items($filter, array('order_id'=>'desc'), $page, $limit, $count)) {
            $items= array();
        }else{
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('ucenter/tuan/index',array($st,'{page}'),array('date'=>$date),'base'));
            $shop_ids = $order_ids = array();
            foreach($items as $k=>$v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
                $order_ids[$v['order_id']] = $v['order_id'];
            }
            if($shop_ids){
                $this->pagedata['shops'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            if($order_ids){
                $this->pagedata['tuan_orders'] = K::M('tuan/order')->items_by_ids($order_ids);
            }
        }
        $this->pagedata['total_count'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'from'=>"tuan"));
        $this->pagedata['count_1'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>0,'from'=>"tuan",'pay_status'=>0));
        $this->pagedata['count_2'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>5,'from'=>"tuan"));
        $this->pagedata['count_3'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'comment_status'=>0,'from'=>"tuan"));
        $this->pagedata['count_4'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>8,'from'=>"tuan"));
        $this->pagedata['count_5'] = K::M('order/order')->count(array('uid'=>$this->uid,'closed'=>0,'order_status'=>-1,'from'=>"tuan"));
        $this->pagedata['pager'] = $pager;
        $this->pagedata['items'] = $items;
        $this->tmpl = 'pchome/ucenter/tuan/index.html';
    }
    

    public function detail($order_id)
    {
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('该订单不存在', 211);
        }else if(!$detail = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('该订单不存在或已经删除', 211);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 211);
        }else{
            $this->pagedata['tuan_order'] = K::M('tuan/order')->detail($order_id);
            $this->pagedata['quan'] = K::M('tuan/ticket')->find(array('order_id'=>$order_id));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'pchome/ucenter/tuan/detail.html';
        }
        
    }

    
    public function cancel($order_id)
    {
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add("不存在的订单",212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消',214);
        }else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态',215);
        }else{
            if(K::M('order/order')->cancel($order_id, $order, 'member')) {
                $data = array(
                    'shop_id'=>$order['shop_id'],
                    'title'=>'订单已取消',
                    'content'=>'用户('.$order['contact'].')已取消订单(ID:'.$order_id.')',
                    'is_read'=>0,
                    'type'=>1,
                    'order_id'=>$order_id
                    );
                if($order['from'] == 'tuan' || $order['from'] == 'waimai'){
                    K::M('shop/msg')->create($data);
                }
                
                //还原库存和销量
                $op = K::M('mall/order/product')->items(array('order_id'=>$order_id));
                foreach($op as $k => $v){
                    K::M('mall/product')->update_count($v['product_id'],'sku',$v['product_number']);
                    K::M('mall/product')->update_count($v['product_id'],'sales',($v['product_number']*-1));
                }
                $this->msgbox->add('退单成功');
            }else {
                $this->msgbox->add('退单失败',216);
            }
        }
        
        
    }

    public function delete()
    {
        $dingzuo_id = (int)$this->GP('dingzuo_id');
        if(!$dingzuo_id){
            $this->msgbox->add('参数错误', 211);
        }else if(!$detail = K::M('yuyue/dingzuo')->detail($dingzuo_id)){
            $this->msgbox->add('订单不存在或已经删除', 212);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作该订单', 213);
        }else if(K::M('yuyue/dingzuo')->delete($dingzuo_id)){
            K::M('yuyue/dingzuo')->update($dingzuo_id,array('lasttime'=>__TIME));
            $this->msgbox->add('删除成功');
        }
    }
    
    
    // 催单
    public function cuidan($order_id)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add("订单不存在",212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if(!$worder = K::M('waimai/order')->detail($order_id)) {
            $this->msgbox->add("订单不存在",212);
        }else if((__TIME - $order['jd_time']) < 1800){
            $this->msgbox->add('请在30分钟后催单',216);
        }else {
            if(K::M('order/order')->update($order_id, array('cui_time'=>__TIME))) {
                $data = array(
                    'shop_id'=>$order['shop_id'],
                    'title'=>'用户正在催单',
                    'content'=>'用户('.$order['contact'].')正在催促订单(ID:'.$order_id.')',
                    'is_read'=>0,
                    'type'=>1,
                    'order_id'=>$order_id
                );
                K::M('shop/msg')->create($data);
                if($staff = $order['staff_id']) {
                    $data2 = array(
                        'staff_id'  => $staff,
                        'title'    => '用户正在催单',
                        'content'  => '用户('.$order['contact'].')正在催促订单(ID:'.$order_id.')',
                        'is_read'  => 0,
                    );
                    K::M('staff/msg')->create($data2);
                }
                $this->msgbox->add('催单成功');
            }else {
                $this->msgbox->add('催单失败',214);
            }
        }
    }
    
    
    /*评价*/
    public function comment($order_id)
    {
        if(!$order_id = (int)$order_id){
            $this->msgbox->add('订单不存在!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',213);
        }else{
            $peitime = K::M('shop/comment')->peitime();
            $this->pagedata['peitime'] = $peitime;
            $jifen = K::M('system/config')->get('jifen');
            $this->pagedata['jifen'] = intval($order['amount']*$jifen['jifen_ratio']);
            $this->pagedata['order'] = $order;
            if($order['from'] == 'waimai'){
                $this->tmpl = 'pchome/ucenter/order/comment_waimai.html';
            }else if($order['from'] == 'tuan'){
                $this->tmpl = 'pchome/ucenter/order/comment_shop.html';
            }else if($order['from'] == 'maidan'){
                $this->tmpl = 'pchome/ucenter/order/comment_shop.html';
            }else{
                $this->tmpl = 'pchome/ucenter/order/comment_staff.html';
            }
        }
    }

    public function comment_handle()  //外卖商家和普通商家评论通用
    {
        if($this->checksubmit()){
            $datas = $this->GP('data');
            $file = $_FILES;
            $datas['uid'] = $this->uid;
            if(!$this->uid){
                $this->msgbox->add('您还没有登录!',101);
            }else if(!$datas['order_id']){
                $this->msgbox->add('错误的订单!',216);
            }else if(!$order = K::M('order/order')->detail($datas['order_id'])){
                $this->msgbox->add('错误的订单!',216);
            }else if($order['comment_status'] == 1){
                $this->msgbox->add('你已经评价过了!',216);
            }else if($order['from'] == 'waimai' &&(!$datas['score_fuwu'] || $datas['score_fuwu'] < 1 || $datas['score_fuwu'] > 5)){
                $this->msgbox->add('请正确选择服务评分!'.$datas['score_fuwu'],211);
            }else if($order['from'] == 'waimai' &&(!$datas['score_kouwei'] || $datas['score_kouwei'] < 1 || $datas['score_kouwei'] > 5)){
                $this->msgbox->add('请正确选择口味评分!',213);
            }else if(!$datas['score'] || $datas['score'] < 1 || $datas['score'] > 5){
                $this->msgbox->add('请正确选择总评分!',214);
            }else if($order['from'] == 'waimai' && $order['pei_type'] != 3 && empty($datas['pei_time'])){
                $this->msgbox->add('没有选择配送速度!',212);
            }else if(!$datas['content']){
                $this->msgbox->add('没有填写评价内容!',215);
            }else{
                $pei_times = 0;
                $datas['shop_id'] = $order['shop_id'];
                if($data['file']){
                    $datas['have_photo'] = 1;
                }

                if($order['from'] == 'waimai'){
                    $km = 'waimai/comment';
                    $hp = 'waimai/commentphoto';
                }else{
                    $km = 'shop/comment';
                    $hp = 'shop/commentphoto';
                }
                $datas['clientip'] = __IP;
                $datas['dateline'] = __TIME;
                if($create = K::M($km)->create($datas)){
                    if($file){
                        //插入评价
                        foreach($file as $k => $v){
                            if($a = K::M('magic/upload')->upload($v,'photo')){
                                $photo_data = array(
                                    'comment_id' => $create,
                                    'photo' => $a['photo']
                                );
                                $create_photo = K::M($hp) -> create($photo_data);
                            }
                        }
                    }
                    $shop = K::M('shop/shop') -> detail($order['shop_id']);

                    K::M('shop/shop')->update($order['shop_id'], array('comments'=>$shop['comments']+1));
                    K::M('shop/shop')->update_count($order['shop_id'], 'score', $datas['score']);
                    K::M('order/order')->update($datas['order_id'],array('comment_status'=>1));
                    $jifen = $this->system->config->get('jifen');
                    $jifen_total = (int)($order['amount']*$jifen['jifen_ratio']);
                    K::M('member/member')->update_jifen($this->uid,$jifen_total,'订单'.$data['order_id'].'评价完成，获得积分');
                    K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>'订单已评价','content'=>'用户('.$order['contact'].')已评价订单(ID:'.$order['order_id'].')','is_read'=>0,'type'=>2,'order_id'=>$order['order_id']));
                    // 计算商家平均等待时间
                    $order_items = K::M('waimai/comment')->items(array('shop_id' => $order['shop_id']), array(), 0, 9999999, $count);
                    foreach($order_items as $key => $val){
                        $pei_times += $val['pei_time'];
                    }
                    $pei_times = intval($pei_times / $count);

                    if($datas['score']>3){
                        $update_data = array('comments'=>'`comments`+1','praise_num'=>'`praise_num`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_times);
                    }else{
                       $update_data = array('comments'=>'`comments`+1','score'=>'`score`+'.$datas['score'],'score_fuwu'=>'`score_fuwu`+'.$datas['score_fuwu'],'score_kouwei'=>'`score_kouwei`+'.$datas['score_kouwei'],'pei_time'=>$pei_times);
                    }
                    if($order['from'] == 'waimai') {
                        K::M('waimai/waimai')->update($order['shop_id'],$update_data,true);
                    }

                    $this->msgbox->add('评价成功!');
                    //$this->msgbox->set_data('forward',$this->mklink('ucenter/order/detail', array('args'=>$order['order_id'])));
                }else{
                    $this->msgbox->add('评价失败!',217);
                }
            }

        }

    }



    public function staff_comment_handle()  //服务人员评价
    {
        if($this->checksubmit()){
            $datas = $this->GP('data');
            $file = $_FILES;

            $datas['uid'] = $this->uid;

            if(!$this->uid){
                $this->msgbox->add('您还没有登录!',101);
            }else if(!$datas['order_id']){
                $this->msgbox->add('错误的订单!',216);
            }else if(!$order = K::M('order/order')->detail($datas['order_id'])){
                $this->msgbox->add('错误的订单!',216);
            }else if($order['comment_status'] == 1){
                $this->msgbox->add('你已经评价过了!',216);
            }else if($order['staff_id'] == 0){
                $this->msgbox->add('错误的服务人员!',216);
            }else if(!$datas['score'] || $datas['score'] < 1 || $datas['score'] > 5){
                $this->msgbox->add('请正确选择总评分!',214);
            }else if(!$datas['content']){
                $this->msgbox->add('没有填写评价内容!',215);
            }else{

                $datas['staff_id'] = $order['staff_id'];
                if($data['file']){
                    $datas['have_photo'] = 1;
                }


                if($create = K::M('staff/comment')->create($datas)){
                    if($file){
                        //插入评价
                        foreach($file as $k => $v){
                            if($a = K::M('magic/upload')->upload($v,'photo')){
                                $photo_data = array(
                                    'comment_id' => $create,
                                    'photo' => $a['photo']
                                );
                                $create_photo = K::M('staff/commentphoto') -> create($photo_data);
                            }
                        }
                    }
                    K::M('order/order')->update($datas['order_id'],array('comment_status'=>1));

                    $this->msgbox->add('评价成功!');
                }else{
                    $this->msgbox->add('评价失败!',217);
                }
            }

        }

    }




    public function complaint($order_id) //订单投诉
    {
        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('订单不能为空!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',212);
        }else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂时不可投诉!',213);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',214);
        }else{
            $this->pagedata['order_id'] = $order_id;
            $this->tmpl = 'ucenter/order/complaint.html';
        }
    }

    public function complaint_handle($order_id){

        $this->check_login();
        $order_id = (int)$order_id;
        if(!$order_id){
            $this->msgbox->add('订单不能为空!',211);
        }else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在!',222);
        }else if($order['order_status'] < 1){
            $this->msgbox->add('该订单暂时不可投诉!',212);
        }else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作!',213);
        }else if(!$title = $this->GP('title')){
            $this->msgbox->add('没有选择投诉类型!',214);
        }else if(!$content = $this->GP('content')){
            $this->msgbox->add('没有填写投诉内容!',215);
        }else if($check = K::M('order/complaint')->find(array('uid'=>$this->uid,'order_id'=>$order_id))){
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
            if(!$add = K::M('order/complaint')->create($data)){
                $this->msgbox->add('投诉失败!',217);
            }else{
                K::M('shop/msg')->create(array('shop_id'=>$order['shop_id'],'title'=>'订单被投诉','content'=>sprintf('订单(%s)被用户投诉',$order['order_id']),'is_read'=>0,'type'=>3,'order_id'=>$order_id));
                $this->msgbox->add('投诉成功!');
            }
        }
    }

    //商城订单收货
    public function mall_ok($order_id){
        $this->check_login();
        if(!$order_id = (int)$order_id) {
            $this->msgbox->add('错误的订单ID',211);
        }else if(!$order = K::M('order/order')->detail($order_id)) {
            $this->msgbox->add("不存在的订单",212);
        }else if($order['uid'] != $this->uid) {
            $this->msgbox->add('你没有权限操作',213);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已完成过了',214);
        }else{
            $this->msgbox->add('收货成功！');
            K::M('order/order')->update($order_id,array('order_status'=>8));
            K::M('order/log')->create(array('order_id'=>$order['order_id'],'from'=>'member','log'=>'订单已收货完成','status'=>6));
        }
    }

}
