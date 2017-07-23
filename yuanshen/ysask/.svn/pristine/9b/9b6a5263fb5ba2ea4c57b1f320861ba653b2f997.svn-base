<?php
/**
 * WxapiController
 * @version: 1.1.0
 * @author: wxz.553@163.com
 * @copyright © 2016 168282.com All rights reserved.
 */
namespace Api\Controller;
use Think\Controller;

class WxapiController extends Controller {

	protected $options = array();
	protected $setting = array();

	//初始化做身份授权认证
	protected function _initialize() { 
	require "Data/Conf/config.ini.php";
	$Setting_config = $array;
	$this->options = array(
		'token' => $Setting_config['wx_token'],
		'encodingaeskey' => $Setting_config['wx_encodingaeskey'],
		'appid' => $Setting_config['wx_appid'],
		'appsecret' => $Setting_config['wx_appsecret']
	);
	$this->setting = $Setting_config;
	}

	public function index(){	
		$weObj = new \Wechat($this->options);
		$weObj->valid();
		//$weObj->sendMassMessage(array('touser' => array('open_id'), 'text' => array('content' => 'hello')));
		$type = $weObj->getRev()->getRevType();	   
		switch($type) {
				case \Wechat::MSGTYPE_TEXT:
					//关键词匹配	    		
					$content = $weObj->getRev()->getRevContent();
					$keyword = D('wx_keyword')->where('keyword="'.$content.'"')->find();
					if($keyword) {
						$this->sendMsg($keyword,$weObj);
					}else {
						$reply = D('wx_reply')->where('type="default"')->find();
						if($reply) 
							$this->sendMsg($reply,$weObj);
					}
					break;
				case \Wechat::MSGTYPE_EVENT:
					$event = $weObj->getRev()->getRevEvent();
					//菜单click事件
					if($event['event'] == \Wechat::EVENT_MENU_CLICK) { 
						$key = $event['key'];
						$keyword = D('wx_keyword')->find($key);
						if($keyword)
							$this->sendMsg($keyword,$weObj);
					}

					//关注事件
					if($event['event'] == \Wechat::EVENT_SUBSCRIBE) {
						$reply = D('wx_reply')->where('type="subscribe"')->find();
						if($reply) 
							$this->sendMsg($reply,$weObj);
					}
					break;
				case \Wechat::MSGTYPE_IMAGE:
					
					break;
				default:
					$reply = D('wx_reply')->where('type="default"')->find();
					if($reply) 
						$this->sendMsg($reply,$weObj);
					break;
		}
	}

	private function sendMsg($msg,$wc) {
		//文本回复
		if($msg['rtype'] == 1) {
			$wc->text($msg['content'])->reply();
		}
		//图文回复
		if($msg['rtype'] == 2) {
			$resource = D('wx_resource')->find($msg['rid']);

			if($resource) {
				$data = array();
				
				$articles = json_decode($resource['articles'],true);
				foreach ($articles as $key => $value) {
					$img = D('wx_img')->where('media_id="'.$value['thumb_media_id'].'"')->find();

					$data[$key]['Title'] = $value['title'];
					$data[$key]['Description'] = $value['digest'];
					$data[$key]['PicUrl'] = $this->setting['site_domain'].$img['path'];
					$data[$key]['Url'] = $value['url'];
				}

				$wc->news($data)->reply();
			}
		}
	}

}