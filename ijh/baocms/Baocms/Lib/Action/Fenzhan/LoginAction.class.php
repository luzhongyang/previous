<?php

/* 
 * 软件为合肥生活宝网络公司出品，未经授权许可不得使用！
 * 作者：baocms团队
 * 官网：www.baocms.com
 * 邮件: youge@baocms.com  QQ 800026911
 */
class LoginAction extends CommonAction{
    
    public function index(){
        $this->display();
    }
    
    public function loging(){
        $yzm = $this->_post('yzm');
        if(strtolower($yzm) != strtolower(session('verify'))){
            session('verify',null);
            $this->baoError('验证码不正确!',2000,true);
        }
        $username = $this->_post('username','trim');
        $password = $this->_post('password','trim,md5');
        $adminObj = D('Admin');
        $fenzhan = $adminObj->getAdminByUsername($username);
        if(empty($fenzhan) || $fenzhan['password'] != $password){
            session('verify',null);
            $this->baoError('用户名或密码不正确!',2000,true);
        }
        if($admin['closed'] == 1){
           session('verify',null);
           $this->baoError('该账户已经被禁用!',2000,true); 
        }
        $fenzhan['last_time'] = NOW_TIME;
        $fenzhan['last_ip']  = get_client_ip();
        $adminObj->where("admin_id=%d",$fenzhan['admin_id'])->save(array('last_time'=>$fenzhan['last_time'],'last_ip'=>$fenzhan['last_ip']));
		
		$citys = D('City')->fetchAll();
		foreach($citys as $k=>$v){
			if($v['city_id'] == $fenzhan['city_id']){
				$fenzhan['city_name'] = $v['name'];
				break;
			}
		}
		
        session('fenzhan',$fenzhan);
        $this->baoSuccess('登录成功！',U('index/index'));
    }
    
    public function logout(){
        session('fenzhan',null);
        $this->success('退出成功',U('login/index'));
    }
    
    public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify(5,2,'png',60,30);
    }
    
}
