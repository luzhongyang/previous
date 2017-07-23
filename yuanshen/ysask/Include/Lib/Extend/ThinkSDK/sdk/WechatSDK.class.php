<?php
class WechatSDK extends ThinkOauth{
	/**
	 * 获取requestCode的api接口
	 * @var string
	 */
	protected $GetRequestCodeURL = 'https://open.weixin.qq.com/connect/qrconnect';
	
	/**
	 * 获取access_token的api接口
	 * @var string
	 */
	protected $GetAccessTokenURL = 'https://api.weixin.qq.com/sns/oauth2/access_token';
	
	/**
	 * 获取request_code的额外参数,可在配置中修改 URL查询字符串格式
	 * @var srting
	 */
	protected $Authorize = 'snsapi_login';

	/**
	 * API根路径
	 * @var string
	 */
	protected $ApiBase = 'https://api.weixin.qq.com/sns';

	/**
	 * 获取access_token
	 * @param string $code 上一步请求到的code
	 */
	public function getAccessToken($code, $extend = null){
		$this->config();
		$params = array(
				'appid'      => $this->AppKey,
				'secret'	 => $this->AppSecret,
				'grant_type' => $this->GrantType,
				'code'       => $code,
		);

		$data = $this->http($this->GetAccessTokenURL, $params, 'GET');
		$this->Token = $this->parseToken($data, $extend);
		return $this->Token;
	}

	/**
	 * 组装接口调用参数 并调用接口
	 * @param  string $api    微博API
	 * @param  string $param  调用API的额外参数
	 * @param  string $method HTTP请求方法 默认为GET
	 * @return json
	 */

	public function call($api, $param = '', $method = 'GET', $multi = false){
		/* 腾讯QQ调用公共参数 */
		$params = array(
			'access_token'       => $this->Token['access_token'],
			'openid'             => $this->openid(),
		);
		
		$data = $this->http($this->url($api), $this->param($params, $param), $method);
		return json_decode($data, true);
	}
	
	/**
	 * 解析access_token方法请求后的返回值 
	 * @param string $result 获取access_token的方法的返回值
	 */
	protected function parseToken($result, $extend){
		parse_str($result, $data);
		if($data['access_token'] && $data['expires_in'] && $data['openid']){
			$this->Token = $data;
			return $data;
		} else
			throw new Exception("获取微信 ACCESS_TOKEN 出错：{$result}");
	}

	/**
	 * 获取当前授权应用的openid
	 * @return string
	 */
	public function openid(){
		$data = $this->Token;
		if(isset($data['openid']))
			return $data['openid'];
		else
			throw new Exception('没有获取到openid！');
		}
	}
}