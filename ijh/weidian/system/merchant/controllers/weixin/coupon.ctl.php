<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weixin/weixin');
class Ctl_Weixin_Coupon extends Ctl_Weixin
{
    protected $_allow_fields = 'coupon_id,shop_id,type,keyword,title,intro,photo,stime,ltime,use_tips,end_tips,end_photo,num,max_count,down_count,use_count,views,follower_condtion,clientip,dateline';

    public function index($page=1)
    {
		$pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['page'] = $limit = 30;
        $pager['page'] = $count = 0;
        if($items = K::M('weixin/coupon')->items(array('shop_id'=>$this->shop_id), null, $page, $limit, $count)){
            $pgaer['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = 'merchant:weixin/coupon/index.html';
    }

	public function create()
	{
		if($data = $this->checksubmit('data')){
            if(!$data['keyword']) {
                $this->msgbox->add('请填写关键词',210)->response();
            }else if(!$data['title']){
                $this->msgbox->add('请填写标题',211)->response();
            }else if(!$data['stime']) {
                $this->msgbox->add('请填写发布时间',212)->response();
            }else if(!$data['ltime']) {
                $this->msgbox->add('请填写结束时间',212)->response();
            }else if(!$data['end_tips']) {
                $this->msgbox->add('请填写优惠金额',212)->response();
            }else if(!$data['num']) {
                $this->msgbox->add('请填写优惠券数量',212)->response();
            }else if(!$data['max_count']) {
                $this->msgbox->add('请填写每人最多允许数',212)->response();
            }
            if($_FILES['data']){
				foreach($_FILES['data'] as $k=>$v){
					foreach($v as $kk=>$vv){
						$attachs[$kk][$k] = $vv;
					}
				}
				$upload = K::M('magic/upload');
				foreach($attachs as $k=>$attach){
					if($attach['error'] == UPLOAD_ERR_OK){
						if($a = $upload->upload($attach, 'weixin')){
							$data[$k] = $a['photo'];
						}
					}
				}
			}
			if($data['stime']){
					$data['stime'] = strtotime($data['stime']);
				}
			if($data['ltime']){
				$data['ltime'] = strtotime($data['ltime']);
			}
			$data['shop_id'] = $this->shop_id;
			if(!$items = K::M('weixin/keyword')->items(array('keyword'=>$data['keyword'],'shop_id'=>$this->shop_id))){
				if($coupon_id = K::M('weixin/coupon')->create($data)){
					$keyword = array();
					$keyword['shop_id'] = $this->shop_id;
					$keyword['keyword'] = $data['keyword'];
					$keyword['plugin'] = 'coupon:'.$coupon_id;
					K::M('weixin/keyword')->create($keyword);
					$this->msgbox->add('添加内容成功');
					$this->msgbox->set_data('forward', $this->mklink('merchant/weixin/coupon/index'));
				} 
			}else{
				$this->msgbox->add('该关键字已经被使用，请修改关键字', 212);
			}
            
        }else{
           $this->tmpl = 'merchant:weixin/coupon/create.html';
        }
	}

	public function edit($coupon_id=null)
    {
        if(!($coupon_id = (int)$coupon_id) && !($coupon_id = $this->GP('coupon_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/coupon')->detail($coupon_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作别人的优惠券', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data['keyword']) {
                $this->msgbox->add('请填写关键词',210)->response();
            }else if(!$data['title']){
                $this->msgbox->add('请填写标题',211)->response();
            }else if(!$data['stime']) {
                $this->msgbox->add('请填写发布时间',212)->response();
            }else if(!$data['ltime']) {
                $this->msgbox->add('请填写结束时间',212)->response();
            }else if(!$data['end_tips']) {
                $this->msgbox->add('请填写优惠金额',212)->response();
            }else if(!$data['num']) {
                $this->msgbox->add('请填写优惠券数量',212)->response();
            }else if(!$data['max_count']) {
                $this->msgbox->add('请填写每人最多允许数',212)->response();
            }
			if($_FILES['data']){
				foreach($_FILES['data'] as $k=>$v){
					foreach($v as $kk=>$vv){
						$attachs[$kk][$k] = $vv;
					}
				}
				$upload = K::M('magic/upload');
				foreach($attachs as $k=>$attach){
					if($attach['error'] == UPLOAD_ERR_OK){
						if($a = $upload->upload($attach, 'weixin')){
							$data[$k] = $a['photo'];
						}
					}
				}
			}
			if($data['stime']){
					$data['stime'] = strtotime($data['stime']);
				}
			if($data['ltime']){
				$data['ltime'] = strtotime($data['ltime']);
			}
            if(K::M('weixin/coupon')->update($coupon_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'merchant:weixin/coupon/edit.html';
        }
	}

	 public function delete($coupon_id=null)
    {
        if($coupon_id = (int)$coupon_id){
            if(!$detail = K::M('weixin/coupon')->detail($coupon_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作别人的优惠券', 212);
            }else{
				if($items = K::M('weixin/keyword')->items(array('keyword'=>$detail['keyword'],'shop_id'=>$this->shop_id))){
					if(K::M('weixin/coupon')->delete($coupon_id)){
						foreach($items as $k => $v){
							K::M('weixin/keyword')->delete($v['kw_id']);
						}
						$this->msgbox->add('删除内容成功');
					}
				}else{
					$this->msgbox->add('非法操作');
				}	
            }
        }
    }  

	public function preview($coupon_id=null)
	{
        $site = $this->system->config->get('site');
        //print_r($site);die;
		$url = $site['siteurl'].'/weixin/coupon-preview-'.$coupon_id.'.html';
		echo '<img alt="模式一扫码支付" src="/qrcode?data='.urlencode($url).'&size=13"/>';
		exit;
	}

	public function sign($coupon_id=null)
	{
		if(!($coupon_id = (int)$coupon_id) && !($coupon_id = $this->GP('coupon_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/coupon')->detail($coupon_id)){
            $this->msgbox->add('该优惠券不存在或已经删除', 212);
        }else{
			if(empty($openid)){
				$openid = $this->access_openid();
			}
			$client = $this->wechat_client();
			$wx_info = $client->getUserInfoById($openid);

			$member =  K::M('member/weixin')->detail_by_openid($openid);

			$list = K::M('weixin/couponsn')->items(array('coupon_id'=>$coupon_id,'openid'=>$openid));
			
			if (! empty ( $detail ['ltime'] ) && $detail ['ltime'] <= time ()) {
				$error = '您来晚啦';
			} else if ($detail ['max_count'] > 0 && $detail ['max_count'] <= count($list)) {
				$error = '您的领取名额已用完啦';
			} else if ($detail ['num']<=$detail['down_count']) {
				$error = '优惠券已经领取光啦';
			}else if ($detail ['follower_condtion'] && $wx_info['subscribe'] == 0) {
				switch ($detail ['follower_condtion']) {
					case 1 :
						$error = '关注后才能领取';
						break;
				}
			}else if ($detail ['member_condtion'] == 1 && !$member['uname']) {
				$error = '用户注册后才能领取';
			}else{
				$data ['sn'] = uniqid ();
				$data ['uid'] = $this->uid;
				$data['shop_id'] = $this->shop_id;
				$data['coupon'] = $coupon_id;
				$data['openid'] = $openid;
				$data['nickname'] = $wx_info['nickname'];
				if($sn = K::M('weixin/couponsn')->create($data)){
					K::M('weixin/coupon')->update_count($coupon_id, 'down_count', 1);
					header('Location: coupon-show-'.$sn);
				}else {
					$error = '领取会员卡后才能领取';
				}
			}
			if($error){
				$this->tmpl = 'merchant:weixin/coupon/over.html';
			}
		}
	}

	public function sn($coupon_id,$page_id)
	{
		if(!($coupon_id = (int)$coupon_id) && !($coupon_id = $this->GP('coupon_id'))){
            $this->msgbox->add('没有指定优惠券ID', 211);
        }else if(!$detail = K::M('weixin/coupon')->detail($coupon_id)){
            $this->msgbox->add('该优惠券不存在或已经删除', 212);
        }else{
			$filter = $pager = array();
			$pager['page'] = max(intval($page), 1);
			$pager['limit'] = $limit = 50;
			$filter['coupon'] = $coupon_id;
			if($items = K::M('weixin/couponsn')->items($filter, null, $page, $limit, $count)){
				$uids = '';
				foreach($items as $k => $v){
					$uids[$v['uid']] = $v['uid'];
				}
				$this->pagedata['member_list'] = K::M('member/member')->items_by_ids($uids);
				$pager['count'] = $count;
				$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
			}
			$this->pagedata['items'] = $items;
			$this->pagedata['detail'] = $detail;
			$this->pagedata['pager'] = $pager;
			$this->tmpl = 'merchant:weixin/coupon/sn.html';
		}
	} 

	public function show($sn)
	{
		if(!($sn = (int)$sn) && !($sn = $this->GP('sn'))){
            $this->msgbox->add('非法访问', 211);
        }else if(!$detail = K::M('weixin/couponsn')->detail($sn)){
            $this->msgbox->add('非法访问', 212);
        }else if(!$coupon = K::M('weixin/coupon')->detail($detail['coupon'])){
            $this->msgbox->add('非法访问', 213);
        }else{
			$this->pagedata['detail'] = $detail;
			$condition = array ();
			$coupon ['max_count'] > 0 && $condition [] = '每人最多可领取' . $coupon ['max_count'] . '张';
			$coupon ['follower_condtion'] == 1 && $condition [] = '必须微信关注后才能领取';
			$coupon ['member_condtion'] == 1 && $condition [] = '必须是平台会员才能领取';
			$this->pagedata['coupon'] = $coupon;
			$this->pagedata['condition'] = $condition;
			$this->pagedata['detail'] = $detail;
			$this->tmpl = 'merchant:weixin/coupon/show.html';
		}
	}

	public function sndelete($sn_id=null)
    {
        if($sn_id = (int)$sn_id){
            if(!$detail = K::M('weixin/couponsn')->detail($sn_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('weixin/couponsn')->delete($sn_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('sn_id')){
            if(K::M('weixin/couponsn')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

	public function snedit($sn_id=null)
    {
        if($sn_id = (int)$sn_id){
            if(!$detail = K::M('weixin/couponsn')->detail($sn_id)){
                $this->msgbox->add('你要修改的内容不存在或已经删除', 211);
            }else{
				if($detail['is_use'] == '1'){
					$data['is_use'] = 0;
					$data['use_time'] = '';
				}else{
					$data['is_use'] = 1;
					$data['use_time'] = __TIME;
				}
                if(K::M('weixin/couponsn')->update($sn_id, $data)){
                    $this->msgbox->add('改变状态成功');
                }
            }
        }
    }  

	protected function wechat_client()
    {
        static $client = null;
        if($client === null){
            if(!$client = K::M('weixin/weixin')->admin_wechat_client()){
                exit('网站公众号设置错误');
            }
        }
        return $client;
    }

    protected function access_openid($force = false)
    {
        static $openid = null;
        if($force || $openid === null){
            if($code = $this->GP('code')){
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                $openid = $ret['openid'];
            }else{
                if(!$openid = $this->cookie->get('wx_openid')){
                    $client = $this->wechat_client();
                    $url = $this->request['url'].'/'.$this->request['uri'];
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:'.$authurl);
                    exit();
                }
            }
            $this->cookie->set('wx_openid', $openid);
        }
        if(empty($openid)){
            exit('获取授权失败');
        }
        return $openid;
    }
}