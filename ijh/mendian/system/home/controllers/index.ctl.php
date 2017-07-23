<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Index extends Ctl
{
    public function __construct(&$system)
	{
        parent::__construct($system);
    }

    public function index()
    {   

        $this->tmpl = 'home/www/index/index.html';
        
    }

    public function productcenter()
    {
        $this->tmpl = 'home/www/index/productcenter.html';
    }

    public function customercase()
    {
        $this->tmpl = 'home/www/index/customercase.html';
    }

    public function helpcenter()
    {
        $this->tmpl = 'home/www/index/helpcenter.html';
    }

    public function cooperation()
    {
    	if($this->checksubmit()){
            if(!$data = $this->GP('data')){
                $this->msgbox->add('非法的数据提交', 201);
            }elseif(!$data = $this->check_fields($data, 'name,city_name,mobile,qq')){
				 $this->msgbox->add('非法的数据提交', 201);
			}elseif (!K::M('cooperation/cooperation')->check_mobile($data['mobile'])) {
            	$this->msgbox->add('手机号码不正确', 201);
            }else{
                if($cooperation_id = K::M('cooperation/cooperation')->create($data)){
                    $this->msgbox->add('申请成功！');
                    $this->msgbox->set_data('forward', $this->mklink('index:cooperation'));
                } else{
                    $this->msgbox->add('申请失败',202);
                }
            } 
        }else{
            $this->tmpl = 'home/www/index/cooperation.html';
        }
    }

}