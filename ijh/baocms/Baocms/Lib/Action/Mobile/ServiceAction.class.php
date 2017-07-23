<?php

/*
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */

class ServiceAction extends CommonAction {

    public function index(){
		$this->display();
	}
	
    
    public function detail($service_id){
        $service_id = (int) $service_id;
        if(!$service_id){
            $this->error('数据不存在');
        }
        if(!$detail = D('Service')->find($service_id)){
            $this->error('数据不存在');
        }
        $this->assign('detail',$detail);
        $this->display();
    }
}