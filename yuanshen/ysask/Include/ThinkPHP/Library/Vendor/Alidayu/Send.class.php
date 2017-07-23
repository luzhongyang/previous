<?php

namespace Vendor\Alidayu;
include('TopSdk.php');
use TopClient;
use AlibabaAliqinFcSmsNumSendRequest;

class Send {

	/**
	 * [发送短信验证码]
	 * @param  [type] $mobile [手机号码]
	 * @param  [type] $code   [验证码]
	 * @param  [type] $key    [模板标识]
	 * @return [type]         [description]
	 */
	public function sendsms($mobile,$code,$key)
	{
		if(!$this->check_sms(get_client_ip(), $title)){
            $result = $title;
        }

        require "Data/Conf/config.ini.php";
		$Setting_config = $array;
		$sms_tpl = $Setting_config['sms_tpl'];
		foreach($sms_tpl as $k=>$v) {
			$tmpl[$v['key']] = $v;
		}

		$site_name = '';
		$client = new TopClient;
		$client->appkey = (string)C('sms_appkey');
		$client->secretKey = (string)C('sms_appsecret');
		$client->format = 'json';
		$request = new AlibabaAliqinFcSmsNumSendRequest;
		$request->setExtend('123456');
		$request->setSmsType('normal');
		$request->setSmsFreeSignName((string)C('sms_signname'));
		$request->setsmsParam('{"number":"'.$code.'","sitename":"'.$site_name.'"}');
		$request->setRecNum($mobile);
		$request->setSmsTemplateCode($tmpl[$key]['smsid']);
		$rlt = $client->execute($request);
		if($rlt->code == 29) {
			$result = 'appkey不正确';
		}else if($rlt->code == 25) {
			$result = 'appsecret不正确';
		}else if($rlt->code == 15) {
			$result = $rlt->sub_msg;
		}
		$content = $tmpl[$key]['content'];
		$content = str_replace('${sitename}', '【'.(string)C('sms_signname').'】', $content);
		$content = str_replace('${number}', $code, $content);
		if($rlt->result->success == 1) {
			$result = $rlt->result->success;
			$data = array(
				'mobile'=>$mobile,
				'content'=>$content,
				'status'=>1,
				'created_ip'=>get_client_ip(),
				'created_time'=>time()
			);
			D('Smslog')->add($data);
		}else {
			$data = array(
				'mobile'=>$mobile,
				'content'=>$content,
				'status'=>0,
				'created_ip'=>get_client_ip(),
				'created_time'=>time()
			);
			D('Smslog')->add($data);
		}
		return $result;
	}

	/*检验短信发送间隔规则*/
	public function check_sms($clientip=null, &$title=''){
        $clientip = $clientip ? $clientip : get_client_ip();
        if($mobile_time = (int)C('mobile_time')){// 同一IP接收短信的时间隔(分钟)
            if((time() - $mobile_time*60) < D('Smslog')->lasttime_by_ip($clientip)){
                $title = sprintf('两次短信间隔不能少于%s分钟', $mobile_time);
                return false;
            }
        }
        if($mobile_count = (int)C('mobile_count')){// 同一IP24小时可以接收短信数
            $time = time() - 86400;
            $map = array();
            $map['created_ip'] = $clientip;
            $map['created_time'] = array('gt',$time);
            if($mobile_count <= D('Smslog')->where($map)->count('id')){
                $title = sprintf('同一IP24小时只能发送%s条短信', $mobile_count);
                return false;
            }
        }
        return true;
    }
}