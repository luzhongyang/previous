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
class Ctl_Weixin_Help extends Ctl_Weixin
{
    protected $_allow_fields = 'shop_id,keyword,title,intro,photo,stime,ltime,use_tips,end_tips,follower_condtion,member_condtion,collect_count,views,end_photo,lastupdate,clientip,dateline';

    public function index($page=1)
    {
		$pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['page'] = $limit = 30;
        $pager['page'] = $count = 0;
        if($items = K::M('weixin/help')->items(array('shop_id'=>$this->shop_id), null, $page, $limit, $count)){
            $pgaer['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $this->pagedata['items'] = $items;
        }
        $this->tmpl = 'merchant:weixin/help/index.html';
    }

	public function create()
	{
		if($data = $this->checksubmit('data')){
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
			$data['shop_id'] = $this->shop_id;
			$data['stime'] = strtotime($data['stime']);
			$data['ltime'] = strtotime($data['ltime']);
			if(!$items = K::M('weixin/keyword')->items(array('keyword'=>$data['keyword'],'shop_id'=>$this->shop_id))){
				if($help_id = K::M('weixin/help')->create($data)){
					$keyword = array();
					$keyword['shop_id'] = $this->shop_id;
					$keyword['keyword'] = $data['keyword'];
					$keyword['plugin'] = 'help:'.$help_id;
					K::M('weixin/keyword')->create($keyword);
					$this->msgbox->add('添加内容成功');
					$this->msgbox->set_data('forward',$this->mklink('merchant/weixin/help/index'));
				} 
			}else{
				$this->msgbox->add('该关键字已经被使用，请修改关键字', 212);
			}
        }else{
           $this->tmpl = 'merchant:weixin/help/create.html';
        }
	}

	public function edit($help_id=null)
    {
        if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
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
			$data['stime'] = strtotime($data['stime']);
			$data['ltime'] = strtotime($data['ltime']);
            if(K::M('weixin/help')->update($help_id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	 $this->tmpl = 'merchant:weixin/help/edit.html';
        }
	}

	public function preview($help_id=null)
	{
		$site = $this->system->config->get('site');
		$url = $site['siteurl'].'/weixin/help-preview-'.$help_id.'.html';
		echo '<img alt="模式一扫码支付" src="/qrcode?data='.urlencode($url).'&size=13"/>';
		exit;
	}
    
	 public function delete($help_id=null)
    {
        if($help_id = (int)$help_id){
            if(!$detail = K::M('weixin/help')->detail($help_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
				if($items = K::M('weixin/keyword')->items(array('keyword'=>$detail['keyword'],'shop_id'=>$this->shop_id))){
					if(K::M('weixin/help')->delete($help_id)){
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

	

	public function sn($help_id,$page=1)
	{
		if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
            $this->msgbox->add('没有指定微助力ID', 211);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
            $this->msgbox->add('该微助力不存在或已经删除', 212);
        }else{
			$filter = $pager = array();
			$pager['page'] = max(intval($page), 1);
			$pager['limit'] = $limit = 50;
			$filter['help_id'] = $help_id;
			if($items = K::M('weixin/helpsn')->items($filter, null, $page, $limit, $count)){
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
			$this->tmpl = 'merchant:weixin/help/sn.html';
		}
	} 
	

	public function sndelete($sn_id=null)
    {
        if($sn_id = (int)$sn_id){
            if(!$detail = K::M('weixin/helpsn')->detail($sn_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('weixin/helpsn')->delete($sn_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('sn_id')){
            if(K::M('weixin/helpsn')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }  

	public function snedit($sn_id=null)
    {
        if($sn_id = (int)$sn_id){
            if(!$detail = K::M('weixin/helpsn')->detail($sn_id)){
                $this->msgbox->add('你要修改的内容不存在或已经删除', 211);
            }else{
				if($detail['is_use'] == '1'){
					$data['is_use'] = 0;
					$data['use_time'] = '';
				}else{
					$data['is_use'] = 1;
					$data['use_time'] = __TIME;
				}
                if(K::M('weixin/helpsn')->update($sn_id, $data)){
                    $this->msgbox->add('改变状态成功');
                }
            }
        }
    }

	public function goods($help_id,$page_id)
	{
		if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
            $this->msgbox->add('没有指定微助力ID', 211);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
            $this->msgbox->add('该微助力不存在或已经删除', 212);
        }else{
			$filter = $pager = array();
			$pager['page'] = max(intval($page), 1);
			$pager['limit'] = $limit = 50;
			$filter['help_id'] = $help_id;
			if($items = K::M('weixin/helpprize')->items($filter, null, $page, $limit, $count)){
				$uids = array();
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
			$this->tmpl = 'merchant:weixin/help/goods.html';
		}
	}

	public function goodscreate($help_id)
    {
		if(!($help_id = (int)$help_id) && !($help_id = $this->GP('help_id'))){
            $this->msgbox->add('未指定要微助力的ID', 211);
        }else if(!$detail = K::M('weixin/help')->detail($help_id)){
            $this->msgbox->add('微助力内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
			$data['help_id'] = $help_id;
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
			$data['shop_id'] = $this->shop_id;
			$data['help_id'] = $help_id;
            if($id = K::M('weixin/helpprize')->create($data)){
                $this->msgbox->add('添加内容成功');
				$this->msgbox->set_data('forward', $this->mklink('merchant/weixin/help/goods',array($help_id)));
            } 
		}else{
		   $this->pagedata['help_id'] = $help_id;
		   $this->tmpl = 'merchant:weixin/help/goodscreate.html';
		}
    }

	public function goodsedit($id=null)
    {
        if(!($id = (int)$id) && !($id = $this->GP('id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weixin/helpprize')->detail($id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
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

            if(K::M('weixin/helpprize')->update($id, $data)){
                $this->msgbox->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
			$this->tmpl = 'merchant:weixin/help/goodsedit.html';
        }
    }

	public function goodsdelete($id=null)
    {
        if($id = (int)$id){
            if(!$detail = K::M('weixin/helpprize')->detail($id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('weixin/helpprize')->delete($id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('id')){
            if(K::M('weixin/helpprize')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
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

	public function snlist($sn_id,$page_id)
	{
		$weixin = $this->ucenter_weixin();
        if(!$sn_id){
			$this->msgbox->add('你要查看的内容不存在或已经删除', 211);
		}elseif(!$detail = K::M('weixin/helpsn')->detail($sn_id)){
			$this->msgbox->add('你要查看的内容不存在或已经删除', 212);
		}else{
			$filter = $pager = array();
			$pager['page'] = max(intval($page), 1);
			$pager['limit'] = $limit = 50;
			$filter['help_id'] = $detail['help_id'];

			$filter['openid'] = $detail['openid'];
			if($items = K::M('weixin/helplist')->items($filter, null, $page, $limit, $count)){
				$pager['count'] = $count;
				$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
			}
			$this->pagedata['items'] = $items;
			$this->pagedata['detail'] = $detail;
			$this->pagedata['pager'] = $pager;
			$this->tmpl = 'merchant:weixin/help/snlist.html';
		}
	}
}