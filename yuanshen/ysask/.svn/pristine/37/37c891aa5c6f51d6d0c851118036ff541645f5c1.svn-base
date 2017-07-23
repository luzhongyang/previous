<?php
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller {
	// 空控制器提示
	public function _empty(){
		header("HTTP/1.0  404  Not Found");
		$this->display('Public:404');	//加载Public下的404.html 模板
	}

	// 404提示
	public function index(){
		header( "HTTP/1.0  404  Not Found" );
		$this->display('Public:404');	//加载Public下的404.html 模板
	}
}