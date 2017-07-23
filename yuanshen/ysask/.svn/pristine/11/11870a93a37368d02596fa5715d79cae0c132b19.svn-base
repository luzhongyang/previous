<?php
/**
* 支付接口
*/
namespace Admin\Controller;
use Think\Controller;
class PaymentController extends CommonController{

    //  配置接口
    public function config()
    {
        if(!$payment_id = (int)I('request.payment_id')) {
            $this->error('未指定要修改的内容ID');
        }else if(!$detail = D('Payment')->where(array('id'=>$payment_id))->find()) {
            $this->error('您要修改的内容不存在或已经删除');
        }else if(IS_POST) {
            if(!$data = I('post.')) {
                $this->error('非法的数据提交');
            }else {
                // $data['config']['notify_url'] = 'http://ask.168282.com/Api/Alipay/notify_url';
                // $data['config']['return_url'] = 'http://ask.168282.com/Api/Alipay/return_url';
                $data['config']['sign_type'] =  strtoupper('MD5');
                $data['config']['input_charset'] =  strtolower('utf-8');
                $data['config']['cacert'] =  SITE_PATH . 'Include/' . 'ThinkPHP/Library/Vendor/Alipay/cacert.pem';
                $data['config']['transport' ] =  'http';
                $data['config']['payment_type'] =  "1";
                $data['config']['anti_phishing_key'] =  "";
                $data['config']['exter_invoke_ip'] =  get_client_ip();
                $data['config'] = serialize($data['config']);
                if(D('Payment')->save($data)) {
                    $this->assign('jumpUrl', \Cookie::get('_currentUrl_'));
                    $this->success('修改内容成功');
                }
            }
        }else {
            $this->assign('detail',$detail);
            if($payment_config = include(APPS_PATH.'ThinkPHP/Library/Vendor/'.ucfirst($detail['payment']).'/config.php')) {
                $this->assign('payment_config',$payment_config);
            }
            $this->assign('config',unserialize($detail['config']));
            $this->display();
        }

    }

    //  安装接口
    public function install()
    {
        if(IS_POST){
            if(!$data = I('post.')){
                $this->error('非法的数据提交');
            }else{
                if($payment_id = D('Payment')->add($data)){
                    $this->assign('jumpUrl', \Cookie::get('_currentUrl_'));
                    $this->success('添加内容成功');
                }
            }
        }else{
           $this->display('install');
        }
    }

    //  卸载接口
    public function uninstall()
    {
        if($payment_id = (int)I('request.payment_id')){
            if(D('Payment')->delete($payment_id)){
                $this->assign('jumpUrl', \Cookie::get('_currentUrl_'));
                $this->success('删除成功');
            }
        }
        // else if($ids = $this->GP('payment_id')){
        //     if(K::M('payment/payment')->delete($ids)){
        //         $this->msgbox->add('批量删除成功');
        //     }
        // }
        else{
            $this->error('未指定要删除的内容ID');
        }
    }
}