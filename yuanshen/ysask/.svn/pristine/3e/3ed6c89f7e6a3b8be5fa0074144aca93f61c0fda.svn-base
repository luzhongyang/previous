<?php
/**
 * 前台问答
 */
namespace Home\Controller;
use Home\Controller\EmptyController;

class QuestionController extends EmptyController{

	public function __construct()
	{
		parent::__construct();
		$this->pagesize = 10;
	}


	/*问答页面*/
	public function index()
	{
		$type = I('request.type');
		$map = array();
		if($type == 'zero') {
			// 零回答
			$map['answer'] = 0;
			$map['status'] = array('gt',0);
		}else if($type == 'reward') {
			// 高悬赏
			$map['money'] = array('gt',0);
			$map['status'] = array('gt',0);
		}else if($type == 'solve') {
			// 已解决
			$map['status'] = 2;
		}else {
			$type = 'new';
			// 默认为新问题 new
			$map['status'] = array('gt',0);
		}
		$this->assign('type', $type);
		if($cate_id = (int)I('request.cate_id')) {
			$map['category_id'] = $cate_id;
			$this->assign('cate_id', $cate_id);
		}
		$map['to_user_id'] = 0;
		$count = M('Question')->where($map)->count('id');
		$Page = new \Think\Page($count,$this->pagesize);
		$show = $Page->show();
		$question_fields = 'id,user_id,tag_ids,answer,view,money,title,created_time';
		if($question_list = M('Question')->where($map)->order(array('created_time'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->getField($question_fields)){
		 	foreach($question_list as $k=>$v) {
		 		$tag = M('Tag')->where(array('id'=>array('in',$v['tag_ids'])))->getField('id,title,sort');
		 		$user = M('User')->where(array('id'=>$v['user_id']))->getField('username,avatar');
		 		$question_list[$k]['tag_list'] = $tag;
	        	$question_list[$k]['user_name'] = $user['username'];
	        	$question_list[$k]['user_avatar'] = $user['avatar'];
	        }
		}
		$cate_list = M('Category')->where(array('type'=>'question'))->order(array('id'=>'desc'))->select();
		$hot_art_list = M('Article')->where(array('comment'=>'desc','status'=>1,'closed'=>0))->limit(10)->getField('id,title,comment');
		$hot_author = D('User')->top('article', 10);
  		$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
  		$assign = array(
  			'page'			=>	$show,
  			'nav'			=>	'xuanshang',
  			'question_list'	=>	$question_list,
  			'cate_list'		=>	$cate_list,
  			'hot_art_list'	=> 	$hot_art_list,
  			'hot_tag_list'	=>	$hot_tag_list,
  			'hot_author'	=>	$hot_author,
		);
  		$this->assign('data', $assign);
		$this->display();
	}

	/*对答*/
	public function duida()
	{
		$type = I('request.type');
		$map = array();
		if($type == 'nosolve') {
			// 未解决
			$map['status'] = 1;
		}else if($type == 'solve') {
			// 已解决
			$map['status'] = 2;
		}else {
			$type = 'new';
			// 默认为新问题 new
			$map['status'] = array('gt',0);
		}
		$this->assign('type', $type);
		if($cate_id = (int)I('request.cate_id')) {
			$map['category_id'] = $cate_id;
			$this->assign('cate_id', $cate_id);
		}
		$map = array('to_user_id'=>array('gt',0));
		$count = M('Question')->where($map)->count('id');
		$Page = new \Think\Page($count,$this->pagesize);
		$show = $Page->show();
		$question_fields = 'id,user_id,tag_ids,answer,view,money,title,created_time';
		if($question_list = M('Question')->where($map)->order(array('created_time'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->getField($question_fields)){
		 	foreach($question_list as $k=>$v) {
		 		$tag = M('Tag')->where(array('id'=>array('in',$v['tag_ids'])))->getField('id,title,sort');
		 		$user = M('User')->where(array('id'=>$v['user_id']))->getField('username,avatar');
		 		$question_list[$k]['tag_list'] = $tag;
	        	$question_list[$k]['user_name'] = $user['username'];
	        	$question_list[$k]['user_avatar'] = $user['avatar'];
	        }
		}
		$cate_list = M('Category')->where(array('type'=>'question'))->order(array('id'=>'desc'))->select();
		$hot_art_list = M('Article')->where(array('comment'=>'desc','status'=>1,'closed'=>0))->limit(10)->getField('id,title,comment');
		$hot_author = D('User')->top('article', 10);
  		$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
  		$assign = array(
  			'page'			=>	$show,
  			'nav'			=>	'duida',
  			'question_list'	=>	$question_list,
  			'cate_list'		=>	$cate_list,
  			'hot_art_list'	=> 	$hot_art_list,
  			'hot_tag_list'	=>	$hot_tag_list,
  			'hot_author'	=>	$hot_author,
		);
		$this->assign('data', $assign);
		$this->display();
	}


	/*问答详情页*/
	public function detail()
	{
		if(!$id = (int)I('get.id')) {
			$this->error('未指定要查看的内容ID');
		}else if(!$detail = M('Question')->where(array('id'=>$id,'closed'=>0))->find()) {
			$this->error('要查看的内容不存在');
		}else {
			$userinfo = session('user');
			//	更新阅读数和操作时间
			M('Question')->where(array('id'=>$id))->setInc('view', 1);
			//	问答回答记录
			$map = array('question_id'=>$detail['id']);
			$orderby = array('agree'=>'desc','created_time'=>'desc');
			$count = M('Answer')->where($map)->count('id');
			$Page = new \Think\Page($count,$this->pagesize);
			$show = $Page->show();
			$answers_fields = 'id,question_id,user_id,content,agree,disagree,comment,status,created_time';
			$answer_list = M('Answer')->where($map)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->getField($answers_fields);

			if($answer_list) {
				foreach($answer_list as $k=>$v) {
					$user = M('User')->where(array('id'=>$v['user_id']))->getField('username,avatar');
					$answer_list[$k]['user_name'] = $user['username'];
					$answer_list[$k]['user_avatar'] = $user['avatar'];
					$answer_list[$k]['peep'] = 0;
					//	如果未登录且答案的答主是指定的专家
					if(!$userinfo && $v['user_id'] == $detail['to_user_id']) {
						$answer_list[$k]['peep'] = 1;
					}
					//	如果已登录且答案的答主是指定的专家且不是自己
					if(isset($userinfo) && $v['user_id'] == $detail['to_user_id'] && $v['user_id'] != $userinfo['id']) {
						$answer_list[$k]['peep'] = 1;
					}
				}
			}
			//	值得一看
			$worth_list = M('Question')->where(array('status'=>1,'closed'=>0))->order(array('answer'=>'desc'))->limit(10)->select();
			//	推荐答主
			$db_pre = C('DB_PREFIX');
			$orderby_filter = " `{$db_pre}user`.`answer` DESC,`{$db_pre}user`.`article` DESC,`{$db_pre}user`.`updated_time` DESC ";
			$hot_pro_sql = "SELECT `{$db_pre}user`.`id`,`{$db_pre}user`.`avatar`,`{$db_pre}user`.`username`,`{$db_pre}user`.`agree` FROM `{$db_pre}professor` LEFT JOIN `{$db_pre}user` ON `{$db_pre}professor`.`user_id`=`{$db_pre}user`.`id` WHERE `{$db_pre}user`.`status`>'0' AND `{$db_pre}professor`.`status`='1' ORDER BY ".$orderby_filter." LIMIT "." 10";
			$Model = new \Think\Model();
			$hot_pro_list = $Model->query($hot_pro_sql);
			//	热门问题
			$hot_q_list = M('Question')->where(array('comment'=>'desc','status'=>1,'closed'=>0))->limit(10)->getField('id,title,answer');
			//	热议话题
			$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
			$user = M('User')->where(array('id'=>$detail['user_id']))->getField('id,username,title');
			$detail['tag_name'] = M('Tag')->where(array('tag_id'=>$detail['tag_id']))->getField('title');
			$detail['user_name'] = $user[$detail['user_id']]['username'];
			$detail['user_title'] = $user[$detail['user_id']]['title'];
			$detail['tag_list'] = M('Tag')->where(array('id'=>array('in',$detail['tag_ids'])))->getField('id,title,sort');
			$type = $detail['to_user_id'] ? $detail['to_user_id'] : 0;


			$assign = array(
				'page'					=>	$show,
				'answers_list'			=>	$answer_list,
				'worth_list'			=>	$worth_list,
				'detail'				=>	$detail,
				'type'					=>	$type,
				'hot_pro_list'			=>	$hot_pro_list,
				'hot_q_list'			=>	$hot_q_list,
				'hot_tag_list'			=>	$hot_tag_list
			);
			$this->assign('data', $assign);
			$this->display();
		}
	}

	//	详情页值得一看换一换
	public function changing()
	{
		$list = M('Question')->where(array('status'=>1,'closed'=>0))->order('rand()')->limit(10)->select();
		if(isset($list)) {
			foreach($list as $k=>$v) {
				$list[$k]['created_time'] = date('Y-m-d H:i', $v['created_time']);
			}
			$this->ajaxReturn(array('status'=>1,'data'=>$list));
		}else {
			$this->ajaxReturn(array('status'=>0,'data'=>array()));
		}
	}


	/*问答-立即提问*/
	public function ask()
	{
		$userinfo = session('user');
		if(!$userinfo) {
			$this->error('抱歉您还未登录');
		}
		$to_user_id = (int)I('get.touserid');
		if($to_user_id) {
			if($to_user_id == $userinfo['id']) {
				$this->error('您不能向自己提问');
			}else if(!$to_userinfo = D('User')->to_user_info($to_user_id)) {
				$this->error('Ta的资料信息不存在');
			}else if($to_userinfo['status'] != 1) {
				$this->error('Ta还未认证为答主');
			}
		}
		$moneypack = D('Question')->getMoneyPack();
		if(IS_POST){
			$post = I('post.');
			if($to_user_id) {
				//	对答
				$post['to_user_id'] = $to_user_id;
				$post['money'] = $to_userinfo['pay_money'];
			}else {
				//	悬赏
				$post['to_user_id'] = 0;
			}


			$post['user_id'] = $userinfo['id'] ? $userinfo['id'] : 0;
			if(!in_array((int)$post['money'],$moneypack)) {
				$this->error('悬赏金额有误');
			}

			// 判断用户金币余额是否满足
			if($userinfo['money'] < (int)$post['money'] && (int)$post['money'] > 0) {
				$this->error('您的余额不足');
			}

			if(!$data = D('Question')->create($post)) {
				$this->error(D('Question')->getError());
			}else {
				if(!$question_id = D('Question')->add($data)) {
					$this->error(D('Question')->getError());
				}else {
					//	查询最新一条记录详情
					$detail = M('Question')->find($question_id);
					//	插入经验变动记录
					$exper = (int)C('experience_ask');
					if($exper) {
						$intro_exper = '用户['.$userinfo['username'].']' . '提出问题(SOURCEID:'.$question_id.')获得[' .$exper. ']经验值';
						$exper_data = array('user_id'=>$userinfo['id'],'number'=>$exper, 'action'=>'create_question', 'source_id'=>$question_id, 'intro'=>$intro_exper);
						D('Experiencelog')->change($exper_data);
					}

					// 更新当前用户提问数
					M('User')->where(array('id'=>$userinfo['id']))->setInc('question',1);
					// 用户话题关联表-更新新增的提问数
					// if(!$user_tag = M('Usertag')->where(array('user_id'=>$userinfo['id'],'tag_id'=>$detail['tag_id']))->find()) {
					// 	$usertagid = D('Usertag')->add(array('user_id'=>$userinfo['id'],'tag_id'=>$detail['tag_id']));
					// 	$usertag = M('Usertag')->find($usertagid);
					// 	M('Usertag')->where(array('tag_id'=>$usertag['tag_id'],'user_id'=>$userinfo['id']))->setInc('question',1);
					// }else {
					// 	M('Usertag')->where(array('tag_id'=>$detail['tag_id'],'user_id'=>$userinfo['id']))->setInc('question',1);
					// }
					// 插入一条新的用户动态记录
					$doings_data = array('user_id'=>$userinfo['id'],'action'=>'create_question','source_id'=>$question_id,'source_type'=>'Question','subject'=>$detail['title'],'content'=>$detail['description']);
					if(!D('Behavior')->add($doings_data)) {
						$this->error(D('Behavior')->getError());
					}
					//	往xunsearch数据库中添加数据
					if(C('xunsearch_open') == 1) {
						$xsearch_data = array('id'=>$question_id,'title'=>$detail['title'],'description'=>$detail['description'],'created_time'=>time());
						D('search')->addIndex('question',$xsearch_data);
					}

					// 如果是非匿名方式则发送短信通知用户
					if($detail['user_hide'] != 0) {
						$code = rand(100000,999999);
						session(array('code_'.$userinfo['phone']=>$code,'code_expire'=>900));
						$Send = new \Vendor\Alidayu\Send;
						$Send->sendsms($userinfo['phone'], $code, 'sms_code');
					}

					// 悬赏和对答的问题需支付
					if($detail['money'] > 0) {
						// 调用余额支付接口
						$code = 'money';
						static $_PayApiObj = array();
				        if(!is_object($_PayApiObj)){
				            $file = SITE_PATH . 'Include/' ."ThinkPHP/Library/Vendor/Moneypay/money.php";
				            if(!file_exists($file)){
				                $this->error('您选择的支付接口不存在');
				            }else if(!$payment = D('Payment')->payment($code)){
				                $this->error('您选择的支付接口不存在');
				            }else if(empty($payment['status'])){
				                $this->error('您选择的支付接口不可用');
				            }else {
				            	$_config['return_url'] = U('Api/Payment/moneypay_return_url');
                				$_config['notify_url'] = U('Api/Payment/moneypay_notify_url');
				            	if(!$_PayApiObj = new \Vendor\Moneypay\PaymentMoney($_config)){
						            $this->error('余额支付接口不存在');
						        }else {
						        	if($detail['pay_status'] == 0) {
						        		$where = array('source_id'=>$detail['id'],'source_type'=>'Question','user_id'=>$userinfo['id'],'payment'=>$code);
						        		if(!$log = D('Paymentlog')->where($where)->find()){
						        			$data = $where;
						        			$data['amount'] = $detail['money'];
						        			$data['trade_no'] = D('Paymentlog')->create_trade_no();
						        			$data['created_time'] = time();
						        			//	插入支付日志
								            if($log_id = D('Paymentlog')->add($data)){
								                $log = D('Paymentlog')->where(array('id'=>$log_id))->find();
								                if($log['payed'] != 1) {
								                	$params = array('source_id'=>$log['source_id'],'amount'=>$log['amount'],'trade_no'=>$log['trade_no']);
								                	//	访问接口返回所需支付的金额和交易号
								                	if (!$trade = $_PayApiObj->build_url($params)) {
								                        $this->error('余额支付失败！');
								                    } else if ($userinfo['money'] < $trade['amount']) {
								                        $this->error('账户余额不足！');
								                    } else {
								                    	$mod = D('User');
												        $mod->startTrans();
												        $flag = false;
												        //	更新用户余额并新增一条余额变动日志
												        $update_money = $mod->update_money($userinfo['id'], -$trade['amount'], "发布悬赏问题(ID:[{$log['source_id']}])");
								                    	if ($update_money) {
								                    		//	更新用户冻结余额并新增一条冻结余额变动日志
								                    		$update_block_money = $mod->update_block_money($userinfo['id'], $trade['amount'], "发布悬赏问题(ID:[{$log['source_id']}])", 0);
								                    		if($update_block_money) {
										                        $log = D('Paymentlog')->log_by_no($trade['trade_no']);
										                        $userinfo['money'] = $userinfo['money'] - $trade['amount'];
										                        //	更新支付日志状态、悬赏问题状态
										                        if ($log['payed']) {
										                            $this->error('悬赏问题已经支付过了');
										                        } else if (D('Paymentlog')->set_payed($trade['trade_no'])) {
										                            if ($res = D('Payment')->payed_question($log)) {
										                            	$flag = true;
										                            }
										                        }
								                    		}
									                    }
									                    if($flag == false){
											                //回滚事务
											                $mod->rollback();
											            }else{
											                //提交事务
											                $mod->commit();
											            }
								                    }
								                }
								            }
								        }
						        	}
						        }
				            }
				        }
					}
					if($detail['to_user_id']) {
						//	对答发送通知给应答专家
					}
					$this->success('操作成功',U('question/detail',array('id'=>$question_id)));
				}
			}
        }else{
        	$cate_list = M('Category')->where(array('type'=>'question'))->order(array('id'=>'desc'))->select();
        	$tag_list = M('Tag')->where()->order(array('id'=>'desc'))->select();

        	$userinfo['phone'] = substr($userinfo['phone'], 0,3).'****'.substr($userinfo['phone'], -4);
        	$assign = array(
        		'cate_list'		=>	$cate_list,
        		'tag_list'		=>	$tag_list,
        		'to_userinfo'	=>	$to_userinfo,
        		'touserid'		=>	$to_user_id,
        		'userinfo'		=> 	$userinfo,
        		'moneypack'		=>	$moneypack
    		);
        	$this->assign('data', $assign);
            $this->display();
        }
	}

	/*查看付费答案*/
	public function paidAnswer()
	{
		$userinfo = session('user');
		$answer_id = (int)I('request.answer_id');
		if(!$detail = M('Answer')->find($answer_id)) {
			$this->error('答案不存在');
		}else if($detail['user_id'] == $userinfo['id']) {
			$this->error('非法操作');
		}else if($detail['status'] != 1) {
			$this->error('答案状态不正确');
		}else if($detail['closed'] != 0) {
			$this->error('答案已被删除');
		}else if((float)$userinfo['money'] < (float)C('peek_money')) {
			$this->error('您的余额不足，请充值');
		}else {
			$code = 'money';
			static $_PayApiObj = array();
			$peek_money = (float)C('peek_money');
			if(!is_object($_PayApiObj)) {
				$file = SITE_PATH . 'Include/' ."ThinkPHP/Library/Vendor/".ucfirst($code)."/{$code}.php";
	            if(!file_exists($file)){
	                $this->error('您选择的支付接口不存在');
	            }else if(!$payment = D('Payment')->payment($code)){
	                $this->error('您选择的支付接口不存在');
	            }else if(empty($payment['status'])){
	                $this->error('您选择的支付接口不可用');
	            }
	            $_config['return_url'] = U('Api/Payment/moneypay_return_url');
				$_config['notify_url'] = U('Api/Payment/moneypay_notify_url');
            	if(!$_PayApiObj = new \Vendor\Moneypay\PaymentMoney($_config)){
		            $this->error('余额支付接口不存在');
		        }
		        $where1 = array('user_id'=>$userinfo['id'],'from_user'=>$detail['user_id'],'answer_id'=>$answer_id,'amount'=>$peek_money);
	        	$paid = M('Seepaidans')->where($where1);
	        	if(!$paid) {
	        		$payment_log = array(
        				'source_id'		=>	$detail['id'],
        				'source_type'	=>	'Answer',
        				'user_id'		=>	$userinfo['id'],
        				'payment'		=>	$code,
        				'amount'		=>	$peek_money,
        				'trade_no'		=>	D('Paymentlog')->create_trade_no(),
    				);
    				if($log_id = D('Paymentlog')->add($payment_log)) {
    					$log = M('Paymentlog')->find($log_id);
    					if($log['payed'] != 1) {
							$params = array('source_id'=>$log['source_id'],'amount'=>$log['amount'],'trade_no'=>$log['trade_no']);
		                	//	访问接口返回所需支付的金额和交易号
		                	if (!$trade = $_PayApiObj->build_url($params)) {
		                        $this->error('余额支付失败！');
		                    }
		                    if ($userinfo['money'] < $trade['amount']) {
		                        $this->error('账户余额不足！');
		                    }
		                    $mod = D('User');
					        $mod->startTrans();
					        $flag = false;

					        //	扣除付费人余额并新增一条余额变动日志
					        $update_money = $mod->update_money($userinfo['id'], -$trade['amount'], "{$peek_money}元偷瞄答案(ID:[{$log['source_id']}])");
	                    	if ($update_money) {
	                    		//	增加付费人冻结余额并新增一条冻结余额变动日志
	                    		$update_block_money = $mod->update_block_money($userinfo['id'], $trade['amount'], "{$peek_money}元偷瞄答案(ID:[{$log['source_id']}])", 0);
	                    		if($update_block_money) {
			                        $log = D('Paymentlog')->log_by_no($trade['trade_no']);
			                        $userinfo['money'] = $userinfo['money'] - $trade['amount'];
			                        //	更新支付日志状态
			                        if ($log['payed']) {
			                            $this->error('偷瞄答案已经支付过了');
			                        } else if (D('Paymentlog')->set_payed($trade['trade_no'])) {
			                        	//  平台费率扣除处理
			                        	$rate_percent = round((int)C('rate')/100, 2);
					                    if($rate_percent < 1 && $rate_percent > 0) {
					                        $log['amount'] = $log['amount'] * (1-$rate_percent);
					                    }
					                    //	平台结算偷瞄费用给答主
					                    if($mod->update_money($detail['user_id'], $log['amount'], "用户(UID:[{$userinfo['id']}])偷瞄答案(ID:[{$log['source_id']}])您获得收入{$log['amount']}元")) {
					                    	//	结算成功，写入付费日志
					                    	$paidans_log = array('user_id'=>$userinfo['id'],'from_user'=>$detail['user_id'],'answer_id'=>$answer_id,'amount'=>$trade['amount']);
				                            if ($res = D('Seepaidans')->add($paidans_log)) {
				                            	$flag = true;
				                            }
					                    }
			                        }
	                    		}
		                    }
		                    if($flag == false){
				                //回滚事务
				                $mod->rollback();
				            }else{
				                //提交事务
				                $mod->commit();
				            }
    					}
    				}
	        	}
			}
		}
	}

}