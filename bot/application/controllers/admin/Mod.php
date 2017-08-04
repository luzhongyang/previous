<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod extends Admin_Controller {

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
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		


        $page = array();
        $page['menu1'] = "main";
        $page['menu2'] = "mod";
        $page['title'] = "模块设置";
        $page['nav1'] = "控制中心";
        $page['nav2'] = "模块设置";	
	

    $view_data= array();
    $view_data['page']=$page;
		$this->load->view('admin/mod', $view_data);
 

	}

	
	
	
	
}

