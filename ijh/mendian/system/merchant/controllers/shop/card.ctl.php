<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Card extends Ctl
{
    protected $_allow_fields = 'card_id,shop_id,staff_id,uid,grade_id,number,wx_openid,mobile,name,sex,Y,M,D,orders,total_money,money,total_jifen,jifen,dateline';

    public function so()
    {
        $this->tmpl = 'merchant:shop/card/so.html';
    }

    public function index($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['number']){$filter['number'] = "LIKE:%".$SO['number']."%";}
            if($SO['name']){$filter['name'] = "LIKE:%".$SO['name']."%";}
            if($SO['mobile']){$filter['mobile'] = "LIKE:%".$SO['mobile']."%";}
        }
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('card/card')->items($filter, array('card_id'=>'desc'), $page, $limit, $count)){
            foreach ($items as $k => $v) {
                $v = $this->filter_fields($this->_allow_fields, $v);
                $items[$k] = $v;
                if ($grade_obj = K::M('card/grade')->detail($v['grade_id'])) {
                    $items[$k]['grade_obj'] = $grade_obj;
                }else{
                    $items[$k]['grade_obj'] = array();
                }
            }
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:shop/card/index.html';
    }

    public function create()
    {
        if ($data = $this->checksubmit('data')) {
            if(!$data = $this->check_fields($data, 'grade_id,number,mobile,name,birthday')){
                $this->msgbox->add('非法的参数提交', 212);
            }else if(!$grade = K::M('card/grade')->detail($data['grade_id'])){
                $this->msgbox->add('会员等级不存在或已被删除', 213);
            }else if(empty($data['mobile']) && empty($data['name'])){
                $this->msgbox->add('会员姓名或者电话不能为空', 214);
            }else{
                $data['staff_id'] = 0;
                if ($birthday = strtotime($data['birthday'])) {
                    $data['Y'] = date('Y',$birthday);
                    $data['M'] = date('m',$birthday);
                    $data['D'] = date('d',$birthday);
                }
                unset($data['birthday']);
                $data['shop_id'] = $this->shop_id;
                if($card_id = K::M('card/card')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/card:index'));
                }
            }
        }else{
            $this->pagedata['grade_obj'] = K::M('card/grade')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'merchant:shop/card/create.html';
        }
    }

    public function edit($card_id=null)
    {
        if(!($card_id = (int)$card_id) && !($card_id = $this->GP('card_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'grade_id,number,mobile,name,birthday')){
                $this->msgbox->add('非法的参数提交', 214);
            }else if(empty($data['mobile']) && empty($data['name'])){
                $this->msgbox->add('会员姓名或者电话不能为空', 215);
            }else if(!K::M('card/grade')->detail($detail['grade_id'])){
                $this->msgbox->add('会员等级不存在或已被删除', 216);
            }else{
                if ($birthday = strtotime($data['birthday'])) {
                    $data['Y'] = date('Y',$birthday);
                    $data['M'] = date('m',$birthday);
                    $data['D'] = date('d',$birthday);
                }
                if(K::M('card/card')->update($detail['card_id'], $data)){
                    $this->msgbox->add('修改内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/card/index'));
                }
            }
        }else{
            $this->pagedata['grade_obj'] = K::M('card/grade')->items(array('shop_id'=>$detail['shop_id']));
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:shop/card/edit.html';
        }
    }

    public function delete($card_id=null)
    {
        if (!($card_id = (int)$card_id) && !($card_id = $this->GP($card_id))) {
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }elseif(!$detail = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('内容不存在',212);
        }elseif($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作',213);
        }else{
            if(K::M('card/card')->delete($detail['card_id'])){
                $this->msgbox->add('删除内容成功');
            }
        }
    }

    public function delAll()
    {
        if (!$ids = $this->GP('card_ids')) {
            $this->msgbox->add('未指定要删除的内容ID', 211);
        }elseif (!$ids = K::M('verify/check')->ids($ids)) {
            $this->msgbox->add('非法的参数提交', 212);
        }else{
            if($items = K::M('card/card')->items_by_ids($ids)){
                $del_ids = array();
                foreach($items as $v){
                    if($v['shop_id'] = $this->shop_id){
                        $del_ids[$v['card_id']] = $v['card_id'];
                    }
                }
                if($del_ids){
                    K::M('card/card')->delete($del_ids);
                }
            }
            $this->msgbox->add('删除内容成功');
        }
    }

    // 

    // 会员充值管理页面
    public function chongzhi()
    {
        $cashier = K::M('cashier/cashier')->detail($this->shop_id);
        $this->pagedata['items'] = K::M('card/card')->items(array('shop_id'=>$this->shop_id,'closed'=>0),null,1,10000,$count);
        $this->pagedata['package_data'] = $cashier['package_data'];
        $this->tmpl = 'merchant:shop/card/chongzhi.html';
    }

    // 会员充值先 生成订单
    public function chongzhi_sub()
    {
        if(($money = (float)$this->GP('money')) <= 0){
            $this->msgbox->add('充值金额不正确', 211);
        }else if(!$card_id = (int)$this->GP('card_id')){
            $this->msgbox->add('未指定要充值的会员卡', 212);
        }else if(!$card = K::M('card/card')->detail($card_id)){
            $this->msgbox->add('会员卡不存在', 212);
        }else{
            $order_data = array('shop_id'=>$this->shop_id, 'staff_id'=>$this->staff_id, 'uid'=>$card['uid'], 'from'=>'card', 'amount'=>$money, 'total_price'=>$money);
            if($order_id = K::M('order/order')->create($order_data)){
                //同一订单在card_order,cashier_order订单表中都有记录，方便业务处理
                $card_order = array('order_id'=>$order_id, 'card_id'=>$card['card_id'], 'chongzhi_money'=>$money);
                K::M('card/order')->create($card_order);
                $cashier_order = array('order_id'=>$order_id, 'card_id'=>$card['card_id'], 'type'=>'chongzhi','product_number'=>1, 'product_price'=>$money);
                K::M('cashier/order')->create($cashier_order); //向收银表插入记录
                $product_title = sprintf('会员卡(%s)充值￥%s', $card['number'], $money);
                $product = array('order_id'=>$order_id,'product_id'=>0, 'product_title'=>$product_title,'product_price'=>$money, 'product_number'=>1, 'amount'=>$money);
                K::M('cashier/order/product')->create($product);
                $this->msgbox->set_data('order', array('order_id'=>$order_id,'amount'=>$money));
            }
        }
    }

    // 生成订单之后现金入账
    public function cashpay()
    {
        if(!$order_id = (int)$this->GP('order_id')){
            $this->msgbox->add('无效的订单号', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('订单已经完成不可作废', 212);
        }else if($order['order_status'] < 0 || $order['order_status'] == 8){
            $this->msgbox->add('订单状态不可支付', 213);
        }else if($order['pay_status']){
            $this->msgbox->add('订单已经支付过了', 214);
        }else if($order['shop_id'] != $this->shop_id){
            $this->msgbox->add('您没有权限操作', 215);
        }else if(($shishou_amount = (float)$this->GP('shishou_amount') < $order['amount'])){
            $this->msgbox->add('实收金额不能小于订单金额', 215);
        }else if($trade = K::M('trade/payment')->cashpay($order)){
            $log = K::M('payment/log')->log_by_no($trade['trade_no']);
            if(K::M('cashier/order')->set_payed($log, $trade)){
                $zhaoling_amount = $shishou_amount - $order['amount'];
                if($zhaoling_amount || $shishou_amount){
                    K::M('cashier/order')->update($order_id, array('shishou_amount'=>$shishou_amount, 'zhaoling_amount'=>$zhaoling_amount));
                }
                $card = K::M('card/card')->detail($order['card_id']);
                $card_detail['mobile'] = $card['mobile'];
                $card_detail['name'] = $card['name'];
                $card_detail['money'] = $card['money'];
                $card_detail['jifen'] = $card['jifen'];
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('trade_detail'=>$trade,'card'=>$card_detail));
            }
        }
    }

    // 现金入账前取消动作 取消订单
    public function cancel_order()
    {
        if(!$order_id = (int)$this->GP('order_id')) {
            $this->msgbox->add('无效的订单号', 211);
        }else if(!$order = K::M('cashier/order')->detail($order_id)){
            $this->msgbox->add('无效的订单号', 212);
        }else if($order['order_status'] == 8){
            $this->msgbox->add('订单已经完成不可作废', 213);
        }else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经作废过了', 214);
        }else if(K::M('order/order')->cancel($order_id, $order)){
            $this->msgbox->set_data('data', array('order_id'=>$order_id));
        }
    }
}