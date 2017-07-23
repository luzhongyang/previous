<?php
/**
 * 前台文章
 */
namespace Home\Controller;
use Home\Controller\EmptyController;

class ArticleController extends EmptyController{

	public function __construct()
	{
		parent::__construct();
		$this->pagesize = 10;
	}


	/*文章页面*/
	public function index()
	{
		$map = array();
		$type = I('request.type');
		if($type == 'hot') {
			$orderby = array('comment'=>'desc');
		}else {
			$type = 'new';
			$orderby = array('created_time'=>'desc');
		}
		$this->assign('type', $type);
		if($cate_id = (int)I('get.cate_id')) {
			$map['category_id'] = $cate_id;
			$this->assign('cate_id',$cate_id);
		}
		$map['status'] = array('gt',0);
		$count = M('Article')->where($map)->count('id');
		$Page = new \Think\Page($count,$this->pagesize);
		$show = $Page->show();
		$article_fields = 'id,user_id,logo,title,summary,content,view,agree,collect,comment,created_time';
		$article_list = M('Article')->where($map)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->getField($article_fields);
		if($article_list) {
			foreach($article_list as $k=>$v) {
				$user = M('User')->where(array('id'=>$v['user_id']))->getField('username','avatar');
				$article_list[$k]['user_name'] = $user['username'];
				$article_list[$k]['user_avatar'] = $user['avatar'];
			}
		}
		$cate_list = M('Category')->where(array('type'=>'article','status'=>1,'closed'=>0))->getField('id,title,created_time');
  		$hot_art_list = M('Article')->where(array('comment'=>'desc','status'=>1,'closed'=>0))->limit(10)->getField('id,title,comment');
  		$hot_author = D('User')->top('article', 10);
  		$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
  		$assign = array(
  			'cate_list'		=>	$cate_list,
  			'page'			=>	$show,
  			'list'	=>	$article_list,
  			'hot_art_list'=>	$hot_art_list,
  			'hot_author'		=>	$hot_author,
  			'hot_tag_list'		=>	$hot_tag_list,
  			'nav'			=>	'article',
		);
  		$this->assign('data', $assign);
		$this->display();
	}


	/*文章详情页*/
	public function detail()
	{
		if(!$id = (int)I('get.id')) {
			$this->error('未指定要查看的内容ID');
		}else if(!$detail = M('Article')->find($id)) {
			$this->error('要查看的内容不存在');
		}else {
			//	更新文章阅读数
			M('Article')->where(array('id'=>$id))->setInc('view', 1);
			$detail['tag_name'] = M('Tag')->where(array('tag_id'=>$detail['tag_id']))->getField('title');
			$detail['cate_name'] = M('Category')->where(array('id'=>$detail['category_id'],'status'=>1,'closed'=>0))->getField('title');
			$user = M('User')->find($detail['user_id']);
			$detail['user_name'] = $user['username'];
			$detail['user_avatar'] = $user['avatar'];
			$detail['user_articles'] = $user['article'];
			$detail['pre_art_id'] = M('Article')->where(array('id'=>array('lt',$detail['id'])))->max('id');
			$detail['next_art_id'] = M('Article')->where(array('id'=>array('gt',$detail['id'])))->min('id');
			if(isset($detail['pre_art_id'])) {
				$detail['pre_art'] = M('Article')->find($detail['pre_art_id']);
			}
			if(isset($detail['next_art_id'])) {
				$detail['next_art'] = M('Article')->find($detail['next_art_id']);
			}
			//	收藏
			$collection = M('Collection')->where(array('user_id'=>$this->uid,'source_type'=>'Article','source_id'=>$id))->find();
			if($collection) {
				$detail['is_collect'] = 1;
				$detail['collect_id'] = $collection['id'];
			}else {
				$detail['is_collect'] = 0;
				$detail['collect_id'] = 0;
			}
			//	支持
			$support = M('Support')->where(array('supportable_id'=>$id,'user_id'=>$this->uid))->find();
			if($support) {
				$detail['is_support'] = 1;
				$deatil['support_id'] = $support['id'];
			}else {
				$detail['is_support'] = 0;
				$detail['support_id'] = 0;
			}
			//	相关阅读
			$relate_list = M('Article')->where(array('status'=>1,'closed'=>0))->order('rand()')->limit(10)->select();

			//	评论列表
			$map = array('source_id'=>$detail['id'],'source_type'=>'Article');
			$orderby = array('agree'=>'desc','created_time'=>'desc');
			$count = M('Comment')->where($map)->count('id');
			$Page = new \Think\Page($count,$this->pagesize);
			$show = $Page->show();
			$comment_fields = 'id,user_id,source_id,content,agree,disagree,status,created_time';
			$comment_list = M('Comment')->where($map)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->getField($comment_fields);
			if($comment_list) {
				foreach($comment_list as $k=>$v) {
					$user = M('User')->where(array('id'=>$v['user_id']))->getField('id,username,avatar');
					$comment_list[$k]['user_name'] = $user[$v['user_id']]['username'];
					$comment_list[$k]['user_avatar'] = $user[$v['user_id']]['avatar'];
					$comment_ids[] = $v['id'];
				}
			}
			$comment_ids = implode(',',$comment_ids);
			$where2['source_id']  = array('in', $comment_ids);
			$comment_list2 = M('Comment')->where($where2)->getField($comment_fields);
			if($comment_list2) {
				foreach($comment_list2 as $k=>$v) {
					$user = M('User')->where(array('id'=>$v['user_id']))->getField('id,username,avatar');
					$comment_list2[$k]['user_name'] = $user[$v['user_id']]['username'];
					$comment_list2[$k]['user_avatar'] = $user[$v['user_id']]['avatar'];
				}
			}
			foreach($comment_list as $k1=>$v1) {
				foreach($comment_list2 as $k2=>$v2) {
					if($v1['id'] == $v2['source_id']) {
						$comment_list[$v1['id']]['comments'][] = $v2;
					}
				}
			}
			$hot_art_list = M('Article')->where(array('comment'=>'desc','status'=>1,'closed'=>0))->limit(10)->getField('id,title,comment');
	  		$hot_author = D('User')->top('article', 10);
	  		$hot_tag_list = M('Tag')->order(array('watch'=>'desc'))->limit(25)->getField('id,title,watch');
			$assign = array(
				'page'			=>	$show,
				'comment_list'	=>	$comment_list,
				'hot_art_list'	=>	$hot_art_list,
				'hot_author'	=>	$hot_author,
				'hot_tag_list'	=>	$hot_tag_list,
				'detail'		=>	$detail,
				'relate_list'	=> 	$relate_list,
				'userinfo'		=> 	check_login()
			);
			$this->assign('data', $assign);
			$this->display();
		}
	}


	/*新增文章*/
	public function publish()
	{
		$userinfo = session('user');
		$money_pack = D('Article')->getMoneyPack();
		if(IS_POST) {
			$post = I('post.');
			if($art_data = D('Article')->create($post,1)) {
				if(!in_array((int)$art_data['money'],$money_pack)) {
					$this->error('付费金额有误');
				}
				$art_data['user_id'] = $this->uid;
				if($art_id = D('Article')->add($art_data)) {
					$detail = D('Article')->find($art_id);
					$exper = (int)C('experience_article');
					$experience = array('action'=>'create_article','source_id'=>$art_id,'intro'=>$detail['title'],'number'=>$exper);
					D('Experiencelog')->change($this->uid, $experience);
					M('User')->where(array('user_id'=>$this->uid))->setInc('article',1);
					$doings_data = array('user_id'=>$this->uid,'action'=>'create_article','source_id'=>$art_id,'source_type'=>'Article','subject'=>$detail['title'],'content'=>$detail['content']);
					if($doings_arr = D('Behavior')->create($doings_data)) {
						D('Behavior')->add($doings_arr);
					}
					//	往xunsearch数据库中添加数据
					if(C('xunsearch_open') == 1) {
						$xsearch_data = array('id'=>$art_id,'title'=>$detail['title'],'description'=>$detail['summary'],'created_time'=>time());
						D('search')->addIndex('article',$xsearch_data);
					}
					$this->success('操作成功',U('article/detail',array('id'=>$art_id)));
				}
			}else {
				$this->error(D('Article')->getError());
			}
		}else {
			$cate_list = M('Category')->where(array('type'=>'article','status'=>1,'closed'=>0))->order(array('id'=>'desc'))->select();
        	$tag_list = M('Tag')->where()->order(array('id'=>'desc'))->select();
        	$userinfo['phone'] = substr($userinfo['phone'], 0,3).'****'.substr($userinfo['phone'], -4);
        	$assign = array(
        		'cate_list'		=>	$cate_list,
        		'tag_list'		=>	$tag_list,
        		'money_pack'	=>	$money_pack,
        		'userinfo'		=>	$userinfo,
    		);
        	$this->assign('data', $assign);
			$this->display();
		}
	}

	/*查看付费文章*/
	public function paidArticle()
	{
		$userinfo = session('user');
		$article_id = (int)I('request.article_id');
		if(!$detail = M('Article')->find($article_id)) {
			$this->error('文章不存在');
		}else if($detail['user_id'] == $userinfo['id']) {
			$this->error('非法操作');
		}else if($detail['status'] != 1) {
			$this->error('文章状态不正确');
		}else if($detail['closed'] != 0) {
			$this->error('文章已被删除');
		}else if($detail['money'] == 0) {
			$this->error('该文章不需要付费');
		}else if((float)$userinfo['money'] < (float)$detail['money']) {
			$this->error('您的余额不足，请充值');
		}else {
			$code = 'money';
			static $_PayApiObj = array();
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
		        }else {
		        	$where1 = array('user_id'=>$userinfo['id'],'from_user'=>$detail['user_id'],'article_id'=>$article_id,'amount'=>$detail['money']);
		        	$paid = M('Seepaidart')->where($where1);
		        	if(!$paid) {
	        			$payment_log = array(
	        				'source_id'		=>	$detail['id'],
	        				'source_type'	=>	'Article',
	        				'user_id'		=>	$userinfo['id'],
	        				'payment'		=>	$code,
	        				'amount'		=>	$detail['money'],
	        				'trade_no'		=>	D('Paymentlog')->create_trade_no(),
        				);
		        		if($log_id = D('Paymentlog')->add($payment_log)) {
		        			$log = M('Paymentlog')->find($log_id);
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

							        //	扣除付费人余额并新增一条余额变动日志
							        $update_money = $mod->update_money($userinfo['id'], -$trade['amount'], "查看付费文章(ID:[{$log['source_id']}])");
			                    	if ($update_money) {
			                    		//	增加付费人冻结余额并新增一条冻结余额变动日志
			                    		$update_block_money = $mod->update_block_money($userinfo['id'], $trade['amount'], "查看付费文章(ID:[{$log['source_id']}])", 0);
			                    		if($update_block_money) {
					                        $log = D('Paymentlog')->log_by_no($trade['trade_no']);
					                        $userinfo['money'] = $userinfo['money'] - $trade['amount'];
					                        //	更新支付日志状态
					                        if ($log['payed']) {
					                            $this->error('付费文章已经支付过了');
					                        } else if (D('Paymentlog')->set_payed($trade['trade_no'])) {
					                        	//  平台费率扣除处理
					                        	$rate_percent = round((int)C('rate')/100, 2);
							                    if($rate_percent < 1 && $rate_percent > 0) {
							                        $log['amount'] = $log['amount'] * (1-$rate_percent);
							                    }
							                    //	平台结算文章查看费用给文章发布人
							                    if($mod->update_money($detail['user_id'], $log['amount'], "用户(UID:[{$userinfo['id']}])查看付费文章(ID:[{$log['source_id']}])您获得收入{$log['amount']}元")) {
							                    	//	结算成功，写入付费日志
							                    	$paidart_log = array('user_id'=>$userinfo['id'],'from_user'=>$detail['user_id'],'article_id'=>$artilce_id,'amount'=>$trade['amount']);
						                            if ($res = D('Seepaidart')->add($paidart_log)) {
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
	}
}