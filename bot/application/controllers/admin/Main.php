<?php
if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}
class Main extends Admin_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_nam
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $page = array();
        $page['menu1'] = 'main';
        $page['menu2'] = 'main';
        $page['title'] = '我的首页';
        $page['nav1'] = '控制中心';
        $page['nav2'] = '我的首页';
        $view_data = array();
        $view_data['page'] = $page;
        $this->load->view('admin/main', $view_data);
    }
    public function chat()
    {
        $netbotguid = $this->input->get('netbotguid');
        $this->load->model('chatlist_mdl');
        if ($this->chatlist_mdl->check3($this->user, $netbotguid)) {
            $_SESSION['netbotguid'] = $netbotguid;
            $_SESSION['netbottype'] = 'online';
            unset($_SESSION['history']);
            unset($_SESSION['path_copy']);
            unset($_SESSION['path_copy_type']);
            redirect('/chat/explorer/main/?netbotguid=' . $netbotguid);
        } else {
            redirect('/500.htm');
        }
    }
    public function offline()
    {
        $netbotguid = $this->input->get('netbotguid');
        $file_path = $this->config->item('pathlist_path') . '/' . $netbotguid . '/treelist.txt';
        if (file_exists($file_path)) {
            $_SESSION['netbotguid'] = $netbotguid;
            $_SESSION['netbottype'] = 'offline';
            unset($_SESSION['history']);
            unset($_SESSION['path_copy']);
            unset($_SESSION['path_copy_type']);
            redirect('/chat/explorer/main/?netbotguid=' . $netbotguid);
        } else {
            redirect('/501.htm');
        }
    }
    public function mpassword()
    {
        $page = array();
        $page['menu1'] = 'index';
        $page['menu2'] = '';
        $page['title'] = '用户中心';
        $page['nav1'] = '用户中心';
        $page['nav2'] = '修改密码';
        $this->load->model('member_mdl');
        $info = $this->member_mdl->info_view($this->user);
        $view_data = array('page' => $page, 'status' => '0', 'info' => $info);
        $this->load->view('admin/mpassword', $view_data);
    }
    public function mpasswordsave()
    {
        header('Content-Type:text/html; charset=utf-8');
        $opassword = $this->input->post('opassword');
        $opassword = md5($opassword);
        $password = $this->input->post('password');
        $password = md5($password);
        $this->load->model('member_mdl');
        $info = $this->member_mdl->info_view($this->user);
        if ($opassword != $info['password']) {
            echo '<script language=JavaScript>{window.alert(\'您输入的原密码不正确！\');history.go(-1);}</script>';
            die;
        }
        $data = array();
        $data['password'] = $password;
        $this->member_mdl->member_user_update($this->user, $data);
        echo '<script language=JavaScript>{window.alert(\'密码修改成功，请牢记您的新密码！\');window.location.href=\'/admin/main\';}</script>';
        die;
    }
}