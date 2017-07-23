<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Cashier_Order extends Ctl
{
    public function index($page = 1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['shop_id']){
                $filter['shop_id'] = $SO['shop_id'];
            }
            if($SO['pay_status']){
                $filter['pay_status'] = $SO['pay_status'];
            }
            if($SO['pay_desc']){
                $filter['pay_desc'] = $SO['pay_desc'];
            }
        }
        if($items = K::M('cashier/order')->items($filter, array('po_id' => 'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:cashier/order/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:cashier/order/so.html';
    }
    public function detail($po_id = null)
    {
        if(!$po_id = (int) $po_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('cashier/order')->detail($po_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cashier/order/detail.html';
        }
    }
    public function create()
    {
         $update = $data;
                $update['po_id'] = $po_id;
                $update['trade_no'] = '1111' . date("YmdHis") . rand(1000, 9999);
                $update['title'] = 'APP收银';
                $update['body'] = 'APP收银';
                $update['shop_id'] = '0';
        
        $ali_returh = K::M('trade/payment')->cashier_alipay($update);
        die;
        $code = 'alipay';
//        $oPayApi = K::M('trade/payment')->loadPayment($code);
        $payment = K::M('payment/payment')->payment($code);
        $config = $payment['config'];
        $site = K::$system->config->get('site');
            if(/*$code == 'wxpay' && */defined('IN_APP')){
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code, 'app'), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code, 'app'), null, 'www');
            }else{
                $config['return_url'] = K::M('helper/link')->mklink('trade/payment:return', array($code), null, 'www');
                $config['notify_url'] = K::M('helper/link')->mklink('trade/payment:notify', array($code), null, 'www');
            }
            $config['show_url'] = $site['siteurl'];
        echo "<Pre>-----sss----<hr />";
        print_r($config);
        die("</Pre>");
        die;
        //test mocro wx pay ok
//        $data = array(
//            'pay_desc' => '测试网页支付007',
//            'amount' => '0.01',
//            'auth_code' => '289037345332903733',
//        );
//
//        $data['wx_url'] = K::M('cashier/order')->wx_micro_pay($data);
//        $data = array(
//            'pay_desc'=>'测试网页支付007',
//            'amount' => '5.5',
//            'auth_code' => '289037345332903733',
//        );
//        $data['wx_url'] = K::M('cashier/order')->ali_micro_pay($data);
//        var_dump(defined('IN_APP'));die;
//       $data['wx_url'] = K::M('cashier/order')->wx_pay($data);
//        die;
        if($data = $this->checksubmit('data')){
            if($po_id = K::M('cashier/order')->create($data)){
                $update = $data;
                $update['po_id'] = $po_id;
                $update['trade_no'] = '1111' . date("YmdHis") . rand(1000, 9999);
                $update['title'] = 'APP收银';
                $update['body'] = 'APP收银';
                $update['shop_id'] = '0';
                if(1 == $data['order_type']){
                    //wxpay
                    $wx_returh = K::M('trade/payment')->cashier_wxpay($update);
                    $update['wx_url'] = $wx_returh['url'];
                }else if(2 == $data['order_type']){
                    //alipay
//                    $update['ali_url'] = K::M('trade/payment')->cashier_alipay($update);
                    $ali_returh = K::M('trade/payment')->cashier_alipay($update);
                    $update['ali_url'] = $ali_returh['url'];
            
                }else{
                    $ali_returh = K::M('trade/payment')->cashier_alipay($update);
                    $update['ali_url'] = $ali_returh['url'];
                    $wx_returh = K::M('trade/payment')->cashier_wxpay($update);
                    $update['wx_url'] = $wx_returh['url'];
                }
                K::M('cashier/order')->update($po_id, $update);
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?cashier/order-index.html');
            }
        }else{
            $this->tmpl = 'admin:cashier/order/create.html';
        }
    }
    public function edit($po_id = null)
    {
        if(!($po_id = (int) $po_id) && !($po_id = $this->GP('po_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('cashier/order')->detail($po_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){

            if(K::M('cashier/order')->update($po_id, $data)){
                echo "<Pre>---------<hr />";
                echo $po_id;
                print_r($data);
                die("</Pre>");
                $this->msgbox->add('修改内容成功');
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:cashier/order/edit.html';
        }
    }
    public function doaudit($po_id = null)
    {
        if($po_id = (int) $po_id){
            if(K::M('cashier/order')->batch($po_id, array('audit' => 1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('po_id')){
            if(K::M('cashier/order')->batch($ids, array('audit' => 1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($po_id = null)
    {
        if($po_id = (int) $po_id){
            if(!$detail = K::M('cashier/order')->detail($po_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('cashier/order')->delete($po_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('po_id')){
            if(K::M('cashier/order')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}
