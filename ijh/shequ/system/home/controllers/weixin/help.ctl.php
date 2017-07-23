<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixin_Help extends Ctl_Weixin
{
	public function index()
    {
        exit();
    }
	public function preview($help_id=null)
	{
        if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
            $this->msgbox->add('该助力不存在或已经删除', 212);
        }elseif(!$weixin = K::M('weixin/weixin')->detail_by_sid($detail['shop_id'])){
			$this->msgbox->add('该商家还未绑定公众号', 216);
		}else{
			if(empty($openid)){
				$openid = $this->access_openid($detail['shop_id']);
			}
			$client = $this->wechat_client($detail['shop_id']);
			$wx_info = $client->getUserInfoById($openid);
			$list = K::M('weixin/helpsn')->items(array('help_id'=>$help_id,'openid'=>$openid));
			foreach($list as $k => $v){
				$this->pagedata['my_sn_list'] = $my_sn_list = $v;
			}
			K::M('weixin/help')->update_count($help_id, 'views', 1);

			Import::L('weixin/jssdk.php');
			$jsSdk = new WeixinJSSDK($weixin['appid'], $weixin['secret']);
			$this->pagedata['wxjscfg'] = $jsSdk->getSignPackage();

			$this->pagedata['detail'] = $detail;

			$filter['help_id'] = $help_id;

			if($prizes = K::M('weixin/helpprize')->items($filter, null, $page, $limit, $count)){
				$this->pagedata['prizes'] = $prizes;
			}

			if($sn_list = K::M('weixin/helpsn')->items($filter, array('zhuli'=>'desc'), $page, '10', $count)){
				$this->pagedata['sn_list'] = $sn_list;
			}

			$filter['openid'] = $openid;
			if($list_sn = K::M('weixin/helplist')->items($filter, null, $page, '1000', $count)){
				$this->pagedata['list_sn'] = $list_sn;
			}
			

			
			if($my_sn_list){
				$this->pagedata['url'] = $this->mklink('weixin/help/show', array($my_sn_list['sn_id']));
			}
			$member =  K::M('member/weixin')->detail_by_openid($openid);

			if (!empty ( $detail ['ltime'] ) && $detail ['ltime'] <= time ()) {
				$error = '您来晚啦';
			}else if ($detail ['follower_condtion'] == 1 && $wx_info['subscribe'] == 0) {
				switch ($detail ['follower_condtion']) {
					case 1 :
						$error = '关注后才能领取';
						break;
				}
			}else if ($detail ['member_condtion'] == 1 && !$member['uname']) {
				$error = '用户注册后才能领取';
			}
			$this->pagedata['error'] = $error;
			$this->tmpl = 'weixin/help/prev.html';
		}
	}

	public function sign($help_id=null)
	{
		if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
			$this->msgbox->add('未指定该助力ID', 217);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
			$this->msgbox->add('该助力不存在或已经删除', 216);
        }else{
			if(empty($openid)){
				$openid = $this->access_openid();
			}
			$client = $this->wechat_client();
			$wx_info = $client->getUserInfoById($openid);
			$member =  K::M('member/weixin')->detail_by_openid($openid);

			$list = K::M('weixin/helpsn')->items(array('help_id'=>$help_id,'openid'=>$openid));
			
			if (! empty ( $detail ['ltime'] ) && $detail ['ltime'] <= time ()) {
				$this->msgbox->add('您来晚啦', 215);
			}else if ($detail ['follower_condtion'] && $wx_info['subscribe'] == 0) {
				switch ($detail ['follower_condtion']) {
					case 1 :
						$this->msgbox->add('关注后才能领取', 214);
						break;
				}
			}else if ($detail ['member_condtion'] == 1 && !$member['uname']) {
				$this->msgbox->add('用户注册后才能领取', 213);
			}else{
				$data ['zhuli'] = 1;
				$data ['uid'] = $member['uid'];
				$data['wx_id'] = $detail['wx_id'];
				$data['help_id'] = $help_id;
				$data['openid'] = $openid;
				$data['nickname'] = $wx_info['nickname'];
				$data['img'] = $wx_info['headimgurl'];//修改
				if($sn = K::M('weixin/helpsn')->create($data)){
					$msg = $data['nickname'].'|'.$data['img'].'|'.$data['zhuli'];
					$this->msgbox->add($msg);
				}else {
					 $this->msgbox->add('您已经参加过了', 212);
				}
			}
			
		}
	}

	public function fenxiang($sn_id)
	{
		if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('该用户不存在', 211);
        }else if(!$detail = K::M('weixin/helpsn')->detail($sn_id)){
            $this->msgbox->add('该用户不存在', 212);
        }else{
			K::M('weixin/helpsn')->update_count($sn_id, 'zhuanfa', 1);
			$this->msgbox->add('分享成功');
		}
	}

	public function zhuli($sn_id)
	{
		if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('该用户不存在', 211);
        }else if(!$detail = K::M('weixin/helpsn')->detail($sn_id)){
            $this->msgbox->add('该用户不存在', 212);
        }else{
			if(empty($openid)){
				$openid = $this->access_openid();
			}
			$client = $this->wechat_client();
			$wx_info = $client->getUserInfoById($openid);

			
			$data['openid'] = $detail['openid'];
			$data['wx_id'] = $detail['wx_id'];
			$data['help_id'] = $detail['help_id'];

			$data['zhuliid'] = $openid;
			$data['nickname'] = $wx_info['nickname'];
			$data['img'] = $wx_info['headimgurl'];//修改

			if($list = K::M('weixin/helplist')->create($data)){
				K::M('weixin/helpsn')->update_count($sn_id, 'zhuli', 1);
				$this->msgbox->add('助力成功');
			}else {
				$this->msgbox->add('助力失败', 212);
			}
		}
	}

	public function show($sn_id)
	{
		if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('该用户不存在', 211);
        }else if(!$helpsn = K::M('weixin/helpsn')->detail($sn_id)){
            $this->msgbox->add('该用户不存在', 212);
        }else if(!$detail = K::M('weixin/help')->detail($helpsn['help_id'])){
            $this->msgbox->add('该助力不存在或已经删除', 212);
        }else{

			if(empty($openid)){
				$openid = $this->access_openid();
			}
			if($openid == $helpsn['openid']){
				 $this->msgbox->add('不能自己给自己助力', 212);
			}else{
				$client = $this->wechat_client();
				$wx_info = $client->getUserInfoById($openid);

				$list = K::M('weixin/helpsn')->items(array('help_id'=>$helpsn['help_id'],'openid'=>$helpsn['openid']));
				foreach($list as $k => $v){
					$this->pagedata['my_sn_list'] = $my_sn_list = $v;
				}

				$filter['help_id'] = $helpsn['help_id'];

				if($prizes = K::M('weixin/helpprize')->items($filter, null, $page, $limit, $count)){
					$this->pagedata['prizes'] = $prizes;
				}
				if($sn_list = K::M('weixin/helpsn')->items($filter, array('zhuli'=>'desc'), $page, '10', $count)){
					$this->pagedata['sn_list'] = $sn_list;
				}

				$filter['openid'] = $helpsn['openid'];
				if($list_sn = K::M('weixin/helplist')->items($filter, null, $page, '1000', $count)){
					$this->pagedata['list_sn'] = $list_sn;
				}

				K::M('weixin/help')->update_count($helpsn['help_id'], 'views', 1);

				Import::L('weixin/jssdk.php');
				$jsSdk = new WeixinJSSDK($weixin['appid'], $weixin['secret']);
				$this->pagedata['wxjscfg'] = $jsSdk->getSignPackage();

				$condition = array ();

				$detail ['follower_condtion'] == 1 && $condition [] = '必须微信关注后才能领取';
				$detail ['member_condtion'] == 1 && $condition [] = '必须是平台会员才能领取';

				$this->pagedata['condition'] = $condition;
				
				if($my_sn_list){
					$this->pagedata['url'] = $this->mklink('weixin/help/show', array($my_sn_list['sn_id']));
				}
				$this->pagedata['url2'] = $this->mklink('weixin/help/preview', array($helpsn['help_id']));

				$member =  K::M('member/weixin')->detail_by_openid($openid);

				if (!empty ( $detail ['ltime'] ) && $detail ['ltime'] <= time ()) {
					$error = '您来晚啦';
				}else if ($detail ['follower_condtion'] == 1 && $wx_info['subscribe'] == 0) {
					switch ($detail ['follower_condtion']) {
						case 1 :
							$error = '关注后才能领取';
							break;
					}
				}else if ($detail ['member_condtion'] == 1 && !$member['uname']) {
					$error = '用户注册后才能领取';
				}
				$this->pagedata['error'] = $error;

				$this->pagedata['helpsn'] = $helpsn;
				$this->pagedata['detail'] = $detail;
				if($list_sn = K::M('weixin/helplist')->items(array('openid'=>$helpsn['openid'],'zhuliid'=>$openid))){
					$this->pagedata['iszhuli'] = '1';
				}

				$this->tmpl = 'weixin/help/show.html';
			}
		}
	}
}