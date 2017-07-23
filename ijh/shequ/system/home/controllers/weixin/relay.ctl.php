<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixin_Relay extends Ctl_Weixin
{
	public function index()
    {
        exit();
    }
	
	public function preview($relay_id=null)
	{
        if(!($relay_id = (int)$relay_id) && !($relay_id = $this->GP('relay_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/relay')->detail($relay_id)){
            $this->msgbox->add('该接力不存在或已经删除', 212);
        }elseif(!$weixin = K::M('weixin/weixin')->detail_by_sid($detail['shop_id'])){
			$this->msgbox->add('该商家还未绑定公众号', 216);
		}else{
			if(empty($openid)){
				$openid = $this->access_openid($detail['shop_id']);
			}
			$client = $this->wechat_client($detail['shop_id']);
			$wx_info = $client->getUserInfoById($openid);
			$openid = 'oNk4bt2iSuRpxQNAejGPIFKriYmc';
			$list = K::M('weixin/relaysn')->items(array('relay_id'=>$relay_id,'openid'=>$openid));
			foreach($list as $k => $v){
				$this->pagedata['my_sn_list'] = $my_sn_list = $v;
			}
			K::M('weixin/relay')->update_count($relay_id, 'views', 1);

			Import::L('weixin/jssdk.php');
			$jsSdk = new WeixinJSSDK($weixin['appid'], $weixin['secret']);
			$this->pagedata['wxjscfg'] = $jsSdk->getSignPackage();

			$this->pagedata['detail'] = $detail;
			$condition = array ();

			$filter['relay_id'] = $relay_id;

			if($prizes = K::M('weixin/relayprize')->items($filter, null, $page, $limit, $count)){
				$this->pagedata['prizes'] = $prizes;
			}

			if($sn_list = K::M('weixin/relaysn')->items($filter, array('gold'=>'desc'), $page, '10', $count)){
				$this->pagedata['sn_list'] = $sn_list;
			}

			$filter['openid'] = $openid;
			$filter['type'] = 1;
			if($list_sn = K::M('weixin/relaylist')->items($filter, null, $page, '100', $count)){
				$this->pagedata['list_sn'] = $list_sn;
			}

			$filter['openid'] = $openid;
			$filter['type'] = 2;
			if($list_sn2 = K::M('weixin/relaylist')->items($filter, null, $page, '1000', $count)){
				$list_sn3 = $arr3 = array();
				foreach($list_sn2 as $k => $v){
					
					if(in_array($v['jieliid'],$arr3)){
						$list_sn3[$v['jieliid']]['gold'] += $v['gold'];
						$list_sn3[$v['jieliid']]['cishu'] += 1;
					}else{
						$arr3[] = $v['jieliid'];
						$list_sn3[$v['jieliid']] = $v;
						$list_sn3[$v['jieliid']]['cishu'] = 1;
					}
				}
				$this->pagedata['list_sn3'] = $list_sn3;
			}

			$detail ['follower_condtion'] == 1 && $condition [] = '必须微信关注后才能领取';
			$detail ['member_condtion'] == 1 && $condition [] = '必须是平台会员才能领取';

			$this->pagedata['condition'] = $condition;
			
			if($my_sn_list){
				$this->pagedata['url'] = $this->mklink('weixin/relay/show', array($my_sn_list['sn_id']));
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

			$this->pagedata['time'] = time();
			$this->pagedata['error'] = $error;
			$this->tmpl = 'weixin/relay/prev.html';
		}
	}

	public function sign($relay_id,$qian,$sn_id=null)
	{
		if(!($relay_id = (int)$relay_id) && !($relay_id = $this->GP('relay_id'))){
			$this->msgbox->add('未指定该接力ID', 217);
        }else if(!$detail = K::M('weixin/relay')->detail($relay_id)){
			$this->msgbox->add('该接力不存在或已经删除', 216);
        }else{
			if($sn_id<=0){
				/*if(empty($openid)){
					$openid = $this->access_openid();
				}
				$client = $this->wechat_client();
				$wx_info = $client->getUserInfoById($openid);*/
				$openid = 'oNk4bt2iSuRpxQNAejGPIFKriYmc';
				$member =  K::M('member/weixin')->detail_by_openid($openid);

				
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
					$data ['cishu'] = 1;
					$data ['uid'] = $member['uid'];
					$data['wx_id'] = $detail['wx_id'];
					$data['relay_id'] = $relay_id;
					$data['openid'] = $openid;
					$data['nickname'] = $wx_info['nickname'];
					$data['gold'] = $qian;
					$data['img'] = $wx_info['headimgurl'];//修改
					if($sn = K::M('weixin/relaysn')->create($data)){
						$datas['openid'] = $openid;
						$datas['wx_id'] = $detail['wx_id'];
						$datas['relay_id'] = $detail['relay_id'];
						$datas['nickname'] = $wx_info['nickname'];
						$datas['img'] = $wx_info['headimgurl'];//修改
						$datas['type'] = 1;
						$datas['gold'] = $qian;
						if($list = K::M('weixin/relaylist')->create($datas)){
							$this->msgbox->add($qian);
						}
					}
				}
			}else{
				/*if(empty($openid)){
					$openid = $this->access_openid();
				}
				$client = $this->wechat_client();
				$wx_info = $client->getUserInfoById($openid);*/
				$openid = 'oNk4bt2iSuRpxQNAejGPIFKriYmc';
				$list = K::M('weixin/relaysn')->items(array('relay_id'=>$relay_id,'openid'=>$openid));
				foreach($list as $k => $v){
					if($v['cishu']>= $detail['max_num']){
						$this->msgbox->add('您已经没有接力次数了', 213);
					}else if($v['openid'] != $openid){
						$this->msgbox->add('用户错误', 214);
					}else{
						K::M('weixin/relaysn')->update_count($sn_id, 'cishu', 1);
						K::M('weixin/relaysn')->update_count($sn_id, 'gold', $qian);
						$datas['openid'] = $openid;
						$datas['wx_id'] = $detail['wx_id'];
						$datas['relay_id'] = $detail['relay_id'];
						$datas['nickname'] = $wx_info['nickname'];
						$datas['img'] = $wx_info['headimgurl'];//修改
						$datas['type'] = 1;
						$datas['gold'] = $qian;
						if($list = K::M('weixin/relaylist')->create($datas)){
							$this->msgbox->add($qian);
						}
					}
				}
			}
		}
	}

	public function fenxiang($sn_id)
	{
		if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('该用户不存在', 211);
        }else if(!$detail = K::M('weixin/relaysn')->detail($sn_id)){
            $this->msgbox->add('该用户不存在', 212);
        }else{
			$this->msgbox->add('分享成功');
		}
	}

	public function show($sn_id=null)
	{
        if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('该用户不存在', 211);
        }else if(!$relaysn = K::M('weixin/relaysn')->detail($sn_id)){
            $this->msgbox->add('该用户不存在', 212);
        }else if(!$detail = K::M('weixin/relay')->detail($relaysn['relay_id'])){
            $this->msgbox->add('该接力不存在或已经删除', 212);
        }else{
			/*if(empty($openid)){
				$openid = $this->access_openid();
			}
			$client = $this->wechat_client();
			$wx_info = $client->getUserInfoById($openid);*/
			$openid = '99999999999999';
			if($openid == $relaysn['openid']){
				 $this->msgbox->add('不能自己给自己接力', 212);
			}else{
				$relay_id = $relaysn['relay_id'];
				$list = K::M('weixin/relaysn')->items(array('relay_id'=>$relay_id,'openid'=>$relaysn['openid']));
				foreach($list as $k => $v){
					$this->pagedata['my_sn_list'] = $my_sn_list = $v;
				}
				K::M('weixin/relay')->update_count($relay_id, 'views', 1);

				Import::L('weixin/jssdk.php');
				$jsSdk = new WeixinJSSDK($weixin['appid'], $weixin['secret']);
				$this->pagedata['wxjscfg'] = $jsSdk->getSignPackage();

				//mine
				$my_list = K::M('weixin/relaylist')->items(array('relay_id'=>$relay_id,'openid'=>$relaysn['openid'],'jieliid'=>$openid),null,1,100,$my_count);
				
				foreach($my_list as $k => $v){
					$gold_all += $v['gold'];
				}
				$this->pagedata['my_count'] = $my_count;
				$this->pagedata['gold_all'] = $gold_all;
				$this->pagedata['detail'] = $detail;



				$filter['relay_id'] = $relay_id;

				if($prizes = K::M('weixin/relayprize')->items($filter, null, $page, $limit, $count)){
					$this->pagedata['prizes'] = $prizes;
				}

				if($sn_list = K::M('weixin/relaysn')->items($filter, array('gold'=>'desc'), $page, '10', $count)){
					$this->pagedata['sn_list'] = $sn_list;
				}

				$filter['openid'] = $relaysn['openid'];
				$filter['type'] = 1;
				if($list_sn = K::M('weixin/relaylist')->items($filter, null, $page, '100', $count)){
					$this->pagedata['list_sn'] = $list_sn;
				}

				$filter['openid'] = $relaysn['openid'];
				$filter['type'] = 2;
				if($list_sn2 = K::M('weixin/relaylist')->items($filter, null, $page, '1000', $count)){
					$list_sn3 = $arr3 = array();
					foreach($list_sn2 as $k => $v){
						
						if(in_array($v['jieliid'],$arr3)){
							$list_sn3[$v['jieliid']]['gold'] += $v['gold'];
							$list_sn3[$v['jieliid']]['cishu'] += 1;
						}else{
							$arr3[] = $v['jieliid'];
							$list_sn3[$v['jieliid']] = $v;
							$list_sn3[$v['jieliid']]['cishu'] = 1;
						}
					}
					$this->pagedata['list_sn3'] = $list_sn3;
				}

				$detail ['follower_condtion'] == 1 && $condition [] = '必须微信关注后才能领取';
				$detail ['member_condtion'] == 1 && $condition [] = '必须是平台会员才能领取';

				$this->pagedata['condition'] = $condition;
				
				if($my_sn_list){
					$this->pagedata['url'] = $this->mklink('weixin/relay/show', array($my_sn_list['sn_id']));
				}
				$this->pagedata['url2'] = $this->mklink('weixin/relay/preview', array($detail['relay_id']));
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

				$this->pagedata['time'] = time();
				$this->pagedata['error'] = $error;
				$this->tmpl = 'weixin/relay/show.html';
			}
		}
	}

	public function sign2($relay_id,$qian,$sn_id)
	{
		if(!($relay_id = (int)$relay_id) && !($relay_id = $this->GP('relay_id'))){
			$this->msgbox->add('未指定该接力ID', 217);
        }else if(!$detail = K::M('weixin/relay')->detail($relay_id)){
			$this->msgbox->add('该接力不存在或已经删除', 216);
        }else if(!$relaysn = K::M('weixin/relaysn')->detail($sn_id)){
			$this->msgbox->add('该接力玩家不存在', 217);
		}else{
			
			/*if(empty($openid)){
				$openid = $this->access_openid();
			}
			$client = $this->wechat_client();
			$wx_info = $client->getUserInfoById($openid);*/
			$openid = '99999999999999';
			$my_list = K::M('weixin/relaylist')->items(array('relay_id'=>$relay_id,'openid'=>$relaysn['openid'],'jieliid'=>$openid),null,1,100,$my_count);

			if($my_count>= $detail['relay_num']){
				$this->msgbox->add('您已经没有接力次数了', 213);
			}else{
				K::M('weixin/relaysn')->update_count($sn_id, 'gold', $qian);
				$datas['openid'] = $relaysn['openid'];
				$datas['jieliid'] = $openid;
				$datas['wx_id'] = $detail['wx_id'];
				$datas['relay_id'] = $detail['relay_id'];
				$datas['nickname'] = $wx_info['nickname'];
				$datas['img'] = $wx_info['headimgurl'];//修改
				$datas['type'] = 2;
				$datas['gold'] = $qian;
				if($list = K::M('weixin/relaylist')->create($datas)){
					$this->msgbox->add($qian);
				}
			}
		}
	}
}