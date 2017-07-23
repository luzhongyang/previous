<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixin_Packet extends Ctl_Weixin
{
	public $packet_info;

	
	public function index($id,$wx_id,$page=0)
    {
        if(!($id = (int)$id) && !($id = $this->GP('id'))){
            $this->msgbox->add('没有指定红包ID', 211);
        }else if(!$detail = K::M('weixin/packet')->detail($id)){
            $this->msgbox->add('该红包不存在或已经删除', 212);
        }else if($detail['is_open'] == 0){
			$this->msgbox->add('活动还没有开启', 213);
		}else if($detail['wx_id'] != $wx_id){
			$this->msgbox->add('您没有获取到抽奖认可', 214);
		}else{
			$this->pagedata['page'] = $page;
			$this->pagedata['detail'] = $detail;
			$this->pagedata['is_start'] = $detail['id'];
			$this->tmpl = 'weixin/packet/index.html';
		}
    }
	
	function show($id,$wx_id) {
		if(empty($openid)){
			$openid = $this->access_openid($detail['shop_id']);
		}
		$openid = '999999';
		if(!($id = (int)$id) && !($id = $this->GP('id'))){
			$result['err'] 	= -1;
			$result['msg'] 	= '没有指定红包ID';
			echo json_encode($result);
			exit;
        }else if(!$detail = K::M('weixin/packet')->detail($id)){
			$result['err'] 	= -2;
			$result['msg'] 	= '该红包不存在或已经删除';
			echo json_encode($result);
			exit;
        }else if($detail['is_open'] == 0){
			$result['err'] 	= -3;
			$result['msg'] 	= '活动还没有开启';
			echo json_encode($result);
			exit;
		}else if($detail['wx_id'] != $wx_id){
			$result['err'] 	= -4;
			$result['msg'] 	= '您没有获取到抽奖认可';
			echo json_encode($result);
			exit;
		}else{
			//$client = $this->wechat_client();
			//$wx_info = $client->getUserInfoById($openid);
			$openid = '999999';
			$wx_id	=	$detail['wx_id'];
			if($this->is_start($id) == 1){
				$result['err'] 	= 1;
				$result['msg'] 	= '活动还没有开始，请耐心等待！';
				echo json_encode($result);
				exit;
			}else if($this->is_start($id) == 2){
				$result['err'] 	= 2;
				$result['msg'] 	= '活动已经结束，敬请关注下一轮活动开始！';
				echo json_encode($result);
				exit;
			}else{

				$items = K::M('weixin/packetsn')->items(array('packet_id'=>$id,'open_id'=>$openid));
				$p_count		= count($items);
				
				/*奖品数量消耗完提示红包被领光*/
				if($p_count >= $detail['get_number']){
					$result['err'] 	= 3;
					$result['msg'] 	= '领取次数已经用光了！';
					echo json_encode($result);
					exit;
				}


				if(!$this->check_packet_type($id)){
						$result['err'] 	= 4;
						$result['msg'] 	= '红包已经领光啦，敬请关注下一轮活动开始！';
						echo json_encode($result);
						exit;
				}
				
				

				if($detail['packet_type'] == '1'){	
					$max 	= $detail['item_max'];//单个上限	
					if($this->packet_info['deci'] == 0){
						$prize 		= mt_rand(1,$max);
					}else if($detail['deci'] == 1){
						$prize 		= mt_rand(1,$max*10)/10;
					}else if($detail['deci'] == 2){
						$prize 		= sprintf("%.2f", mt_rand(1,$max*100)/100);
					}
							
					$prize_name = $prize.'元';
				
				}else{

					$unit 	= $detail['item_unit'];//面额
					$prize 		= $detail['item_unit'];
					$prize_name = $prize.'元';
				}

				$result['err'] 	= 0;
				$result['msg'] 	= '恭喜您抽中了<b class="pointcl">'.$prize_name.'</b>';
				$sn = array();
				$sn['wx_id'] 		= $wx_id;
				$sn['open_id'] 	    = $openid;
				$sn['packet_id'] 	= $id;
				$sn['prize_name'] 	= $prize_name;
				$sn['worth'] 		= $prize;
				$sn['add_time'] 	= time();
				$sn['type'] 		= $detail['packet_type'];
				$md5 				= $openid . $id . $prize . time();
				$sn['code'] 		= substr(md5($md5),0,12); 

				$sn_id 			= K::M('weixin/packetsn')->create($sn);
				if($sn_id){
					echo json_encode($result);
					exit;	
				}else{
					$result['err'] 	= 5;
					$result['msg'] 	= '未知错误，请稍后再试';
					$result['type'] = $detail['packet_type'];
					$result['prize']= $prize;
					echo json_encode($result);
					exit;	
				}
			}
		}
	}

	

	public function is_start($id){
		$now		= time();
		$is_start 	= 0;
		$detail = K::M('weixin/packet')->detail($id);

		if($detail['start_time']>$now){
			$is_start 	= 1;
		}else if($detail['end_time']<$now){
			$is_start	= 2;
		}else if(!$this->check_packet_type($id)){
			$is_start	= 3;
		}
		return $is_start;
	}

	public function check_packet_type($id){
		$flag 		= true;
		$detail = K::M('weixin/packet')->detail($id);
		$items = K::M('weixin/packetsn')->items(array('packet_id'=>$id));
		$pcount		= count($items);

		if($detail['people'] == 0 || $detail['people'] > $pcount){  //领取人数
			if($detail['packet_type'] == '1'){	
				$sum 	= $detail['item_sum'];//总额
				$lsum = 0;
				foreach($items as $k => $v){
					$lsum += $v['worth'];
				}
				
				if($sum <=$lsum){
					$flag 		= false;
				}
	
			}else if($detail['packet_type'] == '2'){
				$num 	= $detail['item_num'];//领取数量
				if($num <=$pcount){
					$flag 		= false;
				}
			}
		}else{
			$flag 		= false;
		}
		

		return $flag;
	}

	public function my_packet($id,$wx_id,$page = 1){
		
		$filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;

		//if(empty($openid)){
			//$openid = $this->access_openid();
		//}
		$openid ='999999';
		$filter	 	= array('open_id'=>$openid,'packet_id'=>$id);

		if ($items = K::M('weixin/packetsn')->items($filter, null, $page, $limit, $count)) {
            $this->pagedata['items'] = $items;
        }
		$this->pagedata['pager'] = $pager;
		$this->tmpl = 'weixin/packet/my_packet.html';
	}

	public function all_packet($id,$wx_id,$page = 1){
		
		$filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;
		
		//if(empty($openid)){
			//$openid = $this->access_openid();
		//}
		$openid ='999999';
		$filter	 	= array('open_id'=>$openid,'packet_id'=>$id);
		$opens = array();
		if ($items = K::M('weixin/packetsn')->items($filter, null, $page, $limit, $count)) {
            $pager['count'] = $count;
			foreach($items as $k => $v){
				if($opens[$v['open_id']]){
					continue;
				}else{
					$opens[$v['open_id']] = K::M('member/weixin')->detail_by_openid($v['open_id']);
				}
			}
			$this->pagedata['weixin'] = $opens;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('weixin/packet:index', array($id,$wx_id,'{page}')));
            $this->pagedata['items'] = $items;
        }
		$this->pagedata['pager'] = $pager;
		$this->tmpl = 'weixin/packet/all_packet.html';
	}

	public function is_packet($id,$wx_id,$page = 1){
		
		$filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;

		//if(empty($openid)){
			//$openid = $this->access_openid();
		//}
		$openid ='999999';
		$filter	 	= array('open_id'=>$openid,'packet_id'=>$id,'is_reward'=>'1');

		if ($items = K::M('weixin/packetsn')->items($filter, null, $page, $limit, $count)) {
            $this->pagedata['items'] = $items;
        }
		$this->pagedata['pager'] = $pager;
		$this->tmpl = 'weixin/packet/my_packet.html';
	}


	public function reward_forms($sn_id){
		//if(empty($openid)){
			//$openid = $this->access_openid();
		//}
		$openid ='999999';
		if(!($sn_id = (int)$sn_id) && !($sn_id = $this->GP('sn_id'))){
            $this->msgbox->add('没有指定获奖用户ID', 211);
        }else if(!$detail = K::M('weixin/packetsn')->detail($sn_id)){
            $this->msgbox->add('该获奖用户不存在或已经删除', 212);
        }else{
			$this->pagedata['detail'] = $detail;
			$this->tmpl = 'weixin/packet/reward_forms.html';
		}
	}
	
	public function reward_sub($sn_id,$packet_id,$pwd,$mobile){
		$data 		= array();
		$result 	= array();
		$ptype		= 1;
		$detail = K::M('weixin/packet')->detail($packet_id);
		//if(empty($openid)){
			//$openid = $this->access_openid();
		//}
		$openid ='999999';
		$filter 	= array('wx_id'=>$detail['wx_id'],'open_id'=>$openid,'packet_id'=>$packet_id);	
		
		$filter['id']	= $sn_id;
		$d= K::M('weixin/packetsn')->items($filter);
		foreach($d as $k => $v){
			$packetsn = $v;
			$price = $v['worth'];
		}

		
		
		if($packetsn['is_reward'] == 1){
			$result['err']	= 1;
			$result['info']	= '请不要重复兑换';
			echo json_encode($result);
			exit;
		}
	
		if($ptype == 1){
			if($detail['password'] != $pwd){
				$result['err']	= 2;
				$result['info']	= '兑换密码错误';
				echo json_encode($result);
				exit;
			}
		}

		$data['wx_id'] 		= $detail['wx_id'];
		$data['open_id'] 	= $openid;
		$data['price'] 		= $price;
		$data['packet_id']  = $packet_id;
		$data['status']  	= 1;
		$data['type']  		= $ptype;
		$data['time'] 		= time();
		$data['sn_id']		= $sn_id;
		$data['mobile']		= $mobile;
		if($ptype == 1){
			$data['type_name'] 		= '线下兑换';
		}else if($ptype == 2){
			$data['type_name'] 		= '转入会员卡';
		}else if($ptype == 3){
			$data['type_name'] 		= '手机充值';
			$data['mobile']  		= $this->GP['mobile'];
			$data['status']  		= 0;
		}
		if(K::M('weixin/packetling')->create($data)){
			K::M('weixin/packetsn')->update($sn_id,array('is_reward'=>2));
			$result['err']	= 0;
			$result['info']	= '兑奖成功！请等待';
			echo json_encode($result);
			exit;
		}else{
			$result['err'] 	= 5;
			$result['info'] = '未知错误，请稍后再试';
			echo json_encode($result);
			exit;	
		}
		
		

	}

	public function rule($id)
	{
		if(!($id = (int)$id) && !($id = $this->GP('id'))){
            $this->msgbox->add('没有指定红包ID', 211);
        }else if(!$detail = K::M('weixin/packet')->detail($id)){
            $this->msgbox->add('该红包不存在或已经删除', 212);
        }else{
			$this->pagedata['detail'] = $detail;
			$this->tmpl = 'weixin/packet/rule.html';
		}	
	}
}