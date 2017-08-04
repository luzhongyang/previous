<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Verify extends CI_Controller {
    public $_referrer;
    private $_data;
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->_check_referrer();
        $this->load->model('member_mdl');
        $this->load->library('form_validation');
    }
    /**
     * 检查referrer
     *
     * @access private
     * @return void
     */
    private function _check_referrer() {
        $ref = $this->input->get('ref', TRUE);
        $this->_referrer = (!empty($ref)) ? $ref : '/admin/main';
    }
    /**
     * 默认执行函数
     *
     * @access public
     * @return void
     */
    public function index() {
        /*
        if($this->member_mdl->hasLogin())
        {
        
        redirect('back_msg?code=loginok&msg=已登录&ref=');
        }
        */
        $vcode = random_string('alnum', 6);
        $this->session->set_userdata('vcode', $vcode);
        $data = array(
            "vcode" => $vcode
        );
        $this->load->view('login', $data);
    }
    public function admin() {
        $msg = $this->input->get('msg', TRUE);
        $reg = $this->input->get('reg', TRUE);
        $data = array(
            "msg" => $msg,
            "reg" => $reg
        );
        $this->load->view('admin/login', $data);
    }
    
 
    
    public function adminlogin() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        $login = $this->member_mdl->login($username, $password);
        $lg=array();
        $lg['ll_username']=$username;
        $lg['ll_ip']=$this->input->ip_address();
        $lg['ll_addtime']=date('Y-m-d H:i:s');       
        $this->member_mdl->finger_add($lg);
        if ($login) {
            $array_items = array(
                'admin_session' => $username,
                'admin_role_session' => $login['role']
            );
            $this->session->set_userdata($array_items);
            redirect('admin/main');
        } else {
            redirect('verify/admin?msg=用户名或密码错误&ref=' . urlencode($this->_referrer));
        }
    }
    public function adminlogout() {
        $array_items = array(
            'admin_session' => '',
            'admin_role_session' => ''
        );
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        redirect('admin/main');
    }

 
    
    public function keepalive() {
        echo "ok";
    }
 

}

