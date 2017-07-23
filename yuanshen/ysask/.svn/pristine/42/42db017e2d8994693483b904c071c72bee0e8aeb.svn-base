<?php
/**
 * 前台Ajax请求
 */
namespace Home\Controller;
use Think\Controller;

class AjaxController extends Controller{

	public function __construct()
	{
		parent::__construct();
	}


	/*问答-提交答案*/
	public function askAnswer()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$post = I('post.');
			if(!$q_id = (int)$post['question_id']) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定问题ID'));
			}else if(!$question = M('Question')->where(array('id'=>$q_id,'closed'=>0,'status'=>1))->find()) {
				$this->ajaxReturn(array('status'=>0,'message'=>'要回答的问题不存在'));
			}else if($question['user_id'] == $userinfo['id']) {
				$this->ajaxReturn(array('status'=>0,'message'=>'提交回答失败，不能自问自答'));
			}else if(!$post['content']){
				$this->ajaxReturn(array('status'=>0,'message'=>'回答不能为空'));
			}else if(check_word($post['content'])){
				$this->ajaxReturn(array('status'=>0,'message'=>'回答内容包含敏感词'));
			}else if($answer = M('Answer')->where(array('question_id'=>$q_id,'user_id'=>$userinfo['id']))->find()){
				$this->ajaxReturn(array('status'=>0,'message'=>'不能重复回答同一个问题'));
			}else {
				$data = array('question_title'=>$question['title'],'user_id'=>$userinfo['id'],'content'=>$post['content'],'question_id'=>$q_id,'created_time'=>time());
				if(!$answer_id = D('Answer')->add($data)) {
					$this->ajaxReturn(array('status'=>0,'message'=>M('Answer')->getError()));
				}
				// 更新该问答的回答数
				M('Question')->where(array('id'=>$q_id))->setInc('answer',1);
				//	如果是一对一对答直接支付酬金给回答者
				if($question['to_user_id']==$userinfo['id'] && $question['pay_status']==1 && $question['money']>0)  {
					$mod = D('User');
			        $mod->startTrans();
			        $flag = false;
					//	扣除发布人的冻结金额，写冻结日志
					$intro = "应答答主(" .$userinfo['username']. "[UID:{$userinfo['id']}]" . ")回答问题[ID:{$q_id}]支付酬金{$question['money']}元";
					$blocked = $mod->update_block_money($question['user_id'], -$question['money'], $intro, 0);
					if($blocked) {
						//	增加应答答主的余额，写余额日志
						$intro = "对答方式回答问题[ID:{$q_id}]获得酬金{$question['money']}元";
						if($mod->update_money($userinfo['id'], $question['money'], $intro)) {
							//	自动采纳问题更新问题状态为已解决
							if(D('Question')->set_adopt($q_id, $answer_id)) {
								$flag = true;
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
				$this->ajaxReturn(array('status'=>1,'message'=>'回答成功'));
			}
		}
	}

	/*问答-追加编辑*/
	public function askEdit()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_POST) {
			$post = I('post.data');
			if(!$data = check_fields($post,'id,description')) {
				$this->error('非法的数据提交');
			}else {
				$detail = M('Question')->find($data['id']);
				if($detail['description'] != $data['description']) {
					M('Question')->where(array('id'=>$data['id']))->save(array('description'=>$data['description'],'updated_time'=>time()));
				}
				$this->success('操作成功',U('question/detail',array('id'=>$data['id'])));
			}
		}else {
			if(!$id = (int)I('get.id')) {
				$this->error('未指定要追加编辑的内容ID');
			}else if(!$question = M('Question')->find($id)) {
				$this->error('要追加编辑的内容不存在');
			}else if($question['user_id'] != $userinfo['id']) {
				$this->error('非法操作');
			}else if($question['status'] == 1) {
				$this->error('该内容已解决');
			}else if($question['status'] == 2) {
				$this->error('该内容已被举报');
			}else {
				$this->assign('detail',$question);
				$this->display();
			}
		}
	}


	/*问答-追加悬赏*/
	public function askAward()
	{
		check_login();
		if(IS_AJAX) {
			$q_id = (int)I('request.question_id');
			$money = (int)I('request.money');
			if(!$question = M('Question')->find($q_id)) {
				$this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
			}else if($question['user_id'] != $userinfo['id']) {
				$this->ajaxReturn(array('status'=>0,'message'=>'非法操作'));
			}else if($question['status'] != 0) {
				$this->ajaxReturn(array('status'=>0,'message'=>'内容状态不正确'));
			}else if(empty($money)) {
				$this->ajaxReturn(array('status'=>0,'message'=>'追加的悬赏金额不正确'));
			}else if($this->USER['money'] < $money){
				$this->ajaxReturn(array('status'=>0,'message'=>'您的余额不足'));
			}else{
				//	插入一条追加悬赏日志
				$award = array('user_id'=>$userinfo['id'],'award_content_id'=>$q_id,'award_content_type'=>'Question','money'=>$money,'remark'=>'问答(ID:'.$q_id.')追加悬赏');
				if(!$award_arr = D('Award')->create($award)) {
					$this->ajaxReturn(array('status'=>0,'message'=>M('Award')->getError()));
				}else if(!D('Award')->add($award_arr)) {
					$this->ajaxReturn(array('status'=>0,'message'=>M('Award')->getError()));
				}
				//	更新用户账号金币
				M('User')->where(array('id'=>$userinfo['id']))->setDec('money',$money);
				//	更新问答内容的悬赏金
				M('Question')->where(array('id'=>$q_id))->setInc('money',$money);
				//	插入一条用户动态
				$doings_data = array('user_id'=>$userinfo['id'],'action'=>'question_addaward','source_id'=>$q_id,'source_type'=>'Question','subject'=>$question['title'],'content'=>'追加了'.$money.'个金币');
				if(!$doings_arr = D('Behavior')->create($doings_data)) {
					$this->ajaxReturn(array('status'=>0,'message'=>M('Behavior')->getError()));
				}else if(!D('Behavior')->add($doings_arr)) {
					$this->ajaxReturn(array('status'=>0,'message'=>M('Behavior')->getError()));
				}
				$this->ajaxReturn(array('status'=>1,'messge'=>'操作成功'));
			}
		}
	}


	/*问答-邀请回答(被邀列表)*/
	public function askInviteUsers()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$q_id = (int)I('request.question_id');
			if(!$q_id) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定内容ID'));
			}else if(!$question = M('Question')->where(array('user_id'=>$userinfo['id'],'id'=>$q_id,'status'=>0))->find()) {
				$this->ajaxReturn(array('stauts'=>0,'message'=>'内容不存在'));
			}else {
				$invitations = M('Questioninvitation')->invitations($q_id);
				$invitedUserIds = array_pluck($invitations,'user_id');
				$userids = implode(',',$invitedUserIds);
				if($userids) {
					$map['user_id']  = array('not in',$userids);
				}
				$map['tag_id'] = array('in', $question['tag_id']);
				$order = array('answer'=>'desc','support'=>'desc');
				$group = 'user_id';
				$userTags = M('Usertag')->where($map)->order($order)->group($group)->limit(16)->getField('user_id,tag_id,answer,support');
				$users = array();
				foreach($userTags as $k=>$v){
	                $user = M('User')->find($v['user_id']);
	                $professor = M('Professor')->find($v['user_id']);
	                if(!$user){
	                    unset($userTags[$k]);
	                }
	                $user['tag_name'] = '';
	                $user['tag_answers'] = 0;
	                $tag = M('Usertag')->find($v['tag_id']);
	                if($tag){
	                    $user['tag_name'] = $tag['name'];
	                }
	                $user['tag_answers'] = $v['answer'];
	                $user['url'] = U('user/index',array('user_id'=>$v['user_id']));
	                $user['isInvited'] = 0;
	                if($professor['status'] == 1) {
	                	$users[] = $user;
	                }
	            }
	            $this->ajaxReturn(array('status'=>1,'message'=>'内容获取成功','data'=>$users));
			}
		}
	}


	/*问答-邀请回答(搜索)*/
	public function askInviteSearch()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$q_id = (int)$I('request.question_id');
			if(!$q_id) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定内容ID'));
			}else if(!$question = M('Question')->where(array('user_id'=>$userinfo['id'],'id'=>$q_id,'status'=>0))->find()) {
				$this->ajaxReturn(array('stauts'=>0,'message'=>'内容不存在'));
			}else {
				$word = I('request.word');
				$fields = 'id,username,phone,email,avatar,status,watch,fans,question,answer,invite,adopt,article';
				$users = M('User')->where(array('user_id'=>array('neq',$userinfo['id']),'username'=>array('like',"$word%")))->limit(10)->getField($fields);
				$this->ajaxReturn(array('status'=>1,'message'=>'内容获取成功','data'=>$users));
			}
		}
	}


	/*问答-邀请回答(ajax邀请确认)*/
	public function askInviteConfirm()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$type = I('request.type');
			$q_id = (int)$I('request.question_id');
			$invitee_id = (int)I('request.invitee_id'); //	被邀请答主id
			$email = I('request.email');
			if(!$type) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定邀请类型'));
			}else if(!$q_id) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定内容ID'));
			}else if(!$question = M('Question')->where(array('user_id'=>$userinfo['id'],'id'=>$q_id,'status'=>0))->find()) {
				$this->ajaxReturn(array('stauts'=>0,'message'=>'内容不存在'));
			}else{
				if($type == 'station') {
					if(!$fromuser = M('User')->find($invitee_id)) {
						$this->ajaxReturn(array('status'=>0,'message'=>'答主不存在'));
					}else if(M('Questioninvitation')->where(array('question_id'=>$q_id,'send_to'=>$fromuser['email'],'invitee_id'=>$invitee_id,'inviter_id'=>$userinfo['id']))->count('id')) {
						$this->ajaxReturn(array('status'=>0,'message'=>'该答主已经邀请过了'));
					}else {
						$data = array('inviter_id'=>$userinfo['id'],'question_id'=>$q_id,'invitee_id'=>$invitee_id,'send_to'=>$fromuser['email']);
						if(!$data_arr = D('Questioninvitation')->create($data)) {
							$this->ajaxReturn(array('status'=>0,'message'=>M('Questioninvitation')->getError()));
						}else if(!$invite_id = D('Questioninvitation')->add($data_arr)) {
							$this->ajaxReturn(array('status'=>0,'message'=>M('Questioninvitation')->getError()));
						}else {
							$map = array('question_id'=>$q_id,'invitee_id'=>array('gt',0));
							$items = M('Questioninvitation')->where($map)->order(array('created_time'=>'desc'))->group('invitee_id')->limit(3)->select();
							$this->ajaxReturn(array('status'=>1,'message'=>'操作成功','data'=>array('type'=>'station','items'=>$items)));
						}
					}
				}else if($type == 'email') {
					if(!$email){
						$this->ajaxReturn(array('status'=>0,'message'=>'未指定邮箱地址'));
					}else if(!$email_user = M('User')->where(array('email'=>$email))->find()){
						$this->ajaxReturn(array('status'=>0,'message'=>'操作出错，请稍候再试'));
					}else if(1 != M('Professor')->where(array('user_id'=>$email_user['id']))->getField('status')) {
						$this->ajaxReturn(array('status'=>0,'message'=>'该答主专业领域未认证'));
					}else if(M('Questioninvitation')->where(array('question_id'=>$q_id,'send_to'=>$email,'inviter_id'=>$userinfo['id']))){
						$this->ajaxReturn(array('stauts'=>0,'message'=>'该答主已经邀请过了'));
					}else {
						$data = array('inviter_id'=>$userinfo['id'],'question_id'=>$q_id,'invitee_id'=>$email_user['id'],'send_to'=>$email);
						if(!$data_arr = D('Questioninvitation')->create($data)) {
							$this->ajaxReturn(array('status'=>0,'message'=>M('Questioninvitation')->getError()));
						}else if(!$invite_id = D('Questioninvitation')->add($data_arr)) {
							$this->ajaxReturn(array('status'=>0,'message'=>M('Questioninvitation')->getError()));
						}else {
							$this->ajaxReturn(array('status'=>1,'message'=>'操作成功','data'=>array('type'=>'email','items'=>array())));
						}
					}
				}
			}
		}
	}

	/*采纳为最佳答案*/
	public function askAdopt()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			if(!$answer_id = (int)I('request.answer_id')) {
				$this->ajaxReturn(array('status'=>0,'message'=>'未指定内容ID'));
			}else if(!$answer = M('Answer')->where(array('closed'=>0,'status'=>1,'id'=>$answer_id))) {
				$this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
			}else if(!$question = M('Question')->where(array('closed'=>0,'status'=>1,'id'=>$answer['question_id']))) {
				$this->ajaxReturn(array('status'=>0,'message'=>'非法操作'));
			}else if($question['user_id'] != $userinfo['id']) {
				$this->ajaxReturn(array('status'=>0,'message'=>'非法操作'));
			}else if($answer['adopted_time'] != 0 && $question['status'] == 2 && $question['adopt_answer_id'] == $answer_id) {
				$this->ajaxReturn(array('status'=>0,'message'=>'该问题已经采纳过最佳答案了'));
			}else {
				if(D('Question')->set_adopt($answer['question_id'], $answer_id)) {
					$this->ajaxReturn(array('status'=>1,'message'=>'操作成功'));
				}
			}
		}
	}


	/*检查赞和踩状态*/
	public function supportCheck()
    {
    	$source_type = I('request.source_type');
    	$source_id = (int)I('request.source_id');
        if($source_type === 'answer'){
            $source  = M('Answer')->find($source_id);
        }
        if(!$source){
            $this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
        }
        $support = M('Support')->where(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'souce_type'=>$source_type))->find();
        if($support){
        	if($support['type'] == 1) {
        		$type = 'disagree';
        	}else {
        		$type = 'agree';
        	}
            $this->ajaxReturn(array('status'=>0,'message'=>'已操作','type'=>$type));
        }
        $this->ajaxReturn(array('status'=>1,'message'=>'未操作'));
    }


    /*未读通知数目*/
    public function unreadNotifis()
    {
        $total = M('Usermsg')->where(array('to_user_id'=>$userinfo['id'],'is_read'=>0))->count('id');
        $response = '<span class="fa fa-bell-o fa-lg"></span>';
        if( $total > 0 ){
            if($total > 99){
                $total = '99+' ;
            }
            $response =  '<span class="fa fa-bell-o fa-lg"></span><span class="label label-danger">'.$total.'</span>';
        }
        echo json_encode($response);die;
    }


    /*未读消息数目*/
    public function unreadMsgs()
    {
        $total = M('Usermsg')->where(array('to_uid'=>$userinfo['id'],'sender_deleted'=>0,'addressee_deleted'=>0))->count('id');
        $response = '<span class="fa fa-envelope-o fa-lg"></span>';
        if( $total > 0 ){
            if($total > 99){
                $total = '99+' ;
            }
            $response =  '<span class="fa fa-envelope-o fa-lg"></span><span class="label label-success">'.$total.'</span>';
        }
        echo json_encode($response);die;
    }


    /*通用举报*/
    public function report()
    {
    	//	类型：问题、用户、话题、回答、评论
    	$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
    	if(IS_AJAX) {
    		$post = I('post.');
    		$source_id = (int)$post['source_id'];
			$source_type = $post['source_type'];
			if(in_array($source_type, array('question','user','tag','answer','comment','article'))) {
				if($source_type === 'question'){
		            $source  = M('Question')->find($source_id);
		            $subject = $source['title'];
		        }else if($source_type === 'user'){
		            $source  = M('User')->find($source_id);
		            $subject = $source['username'];
		        }else if($source_type === 'tag'){
		            $source  = M('Tag')->find($source_id);
		            $subject = $source['name'];
		        }else if ($source_type === 'answer') {
		        	$source = M('Answer')->find($source_id);
		        	$subject = $source['question_title'];
		        }else if ($source_type === 'comment') {
		        	$source = M('Comment')->find($source_id);
		        	$subject = $source['content'];
		        }else if ($source_type === 'article') {
		        	$source = M('Article')->find($source_id);
		        	$subject = $source['content'];
		        }
		        if(!$source) {
		        	$this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
		        }
		        if($source['user_id'] == $userinfo['id']) {
		        	$this->ajaxReturn(array('status'=>0,'message'=>'该操作你不能对自己使用'));
		        }
	        	$source_type = ucfirst($source_type);
	        	$report = M('Claim')->find(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type));
	        	if($report) {
	        		$this->ajaxReturn(array('status'=>0,'message'=>'您已经举报过啦！管理员正在处理中，请耐心等待'));
	        	}else if(check_word($post['reason'])) {
        			$this->ajaxReturn(array('status'=>0,'message'=>'举报原因包含敏感词'));
        		}else if(check_word($post['intro'])) {
        			$this->ajaxReturn(array('status'=>0,'message'=>'举报说明包含敏感词'));
        		}else {
        			$data = array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type,'reason'=>$post['reason'],'intro'=>$post['intro']);
        			if($id = D('Claim')->add($data)) {
        				$this->ajaxReturn(array('status'=>1,'message'=>'操作成功','reported'=>'reported'));
        			}
        		}
			}
    	}
    }

    /*通用赞和踩*/
	public function agree()
	{
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$source_id = (int)I('post.source_id');
			$source_type = I('post.source_type');
			$type = I('post.type');
			if(!in_array($source_type, array('question','answer','comment','tag','article','discuss','user'))) {
				$this->ajaxReturn(array('status'=>0,'message'=>'非法操作'));
			}else {
				$source_type = ucfirst($source_type);
		        $source = M("{$source_type}")->find($source_id);
		        if(!$source){
		            $this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
		        }
		        if($source['user_id'] == $userinfo['id']) {
		        	$this->ajaxReturn(array('status'=>0,'message'=>'该操作你不能对自己使用'));
		        }
	        	if(in_array($type,array('agree','disagree'))) {
	        		$support = M('Support')->where(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type,'type'=>$type))->find();
			        if($support){
			        	$this->ajaxReturn(array('status'=>0,'message'=>'您已经操作过了'));
			        }
		        	$data = array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type,'type'=>$type,'created_time'=>time());
	        		if(D('Support')->add($data)) {
	        			M("{$source_type}")->where(array('id'=>$source_id))->setInc($type, 1);
	        			$count = M('Support')->where(array('type'=>$type,'source_id'=>$source_id,'source_type'=>$source_type))->count('id');
	        			$this->ajaxReturn(array('status'=>1,'message'=>'操作成功','count'=>$count));
	        		}
	        	}
			}
		}
	}

	/*通用关注和取消关注*/
	public function follow()
	{
		// 类型：问题、用户、话题
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			if(!$source_id = (int)I('request.source_id')) {
				$this->ajaxReturn(array('status'=>0,'message'=>'内容id不正确'));
			}
			if(!$source_type = I('request.source_type')) {
				$this->ajaxReturn(array('status'=>0,'message'=>'内容类型不正确'));
			}
			if(in_array($source_type, array('question','user','tag'))) {
				if($source_type === 'question'){
		            $source  = M('Question')->find($source_id);
		            $subject = $source['title'];
		        }else if($source_type === 'user'){
		            $source  = M('User')->find($source_id);
		            $subject = $source['username'];
		        }else if($source_type === 'tag'){
		            $source  = M('Tag')->find($source_id);
		            $subject = $source['name'];
		        }
		        if(!$source){
		            $this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
		        }
		        if($source['user_id'] == $userinfo['id']) {
		        	$this->ajaxReturn(array('status'=>0,'message'=>'该操作你不能对自己使用'));
		        }
	        	$type = ucfirst($source_type);
	        	/*再次关注相当于是取消关注*/
		        $watch = M('Watch')->where(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$type))->find();
		        if($watch){
		            M('Watch')->where(array('id'=>$watch['id']))->delete();
		            if($source_type === 'user'){
		                M('User')->where(array('id'=>$source['id']))->setDec('watch',1);
		            }else if($source_type === 'tag' ){
		                M('Tag')->where(array('id'=>$source['id']))->setDec('watch',1);
		            }else if($source_type === 'question') {
		            	M('Question')->where(array('id'=>$source['id']))->setDec('watch',1);
		            }
		            $this->ajaxReturn(array('status'=>1,'message'=>'取关成功','followed'=>'unfollowed'));
		        }else {
		        	$data = array('user_id'=>$userinfo['id'],'username'=>$this->USER['username'],'source_id'=>$source_id,'source_type'=>$type,'created_time'=>time());
		        	if(D('Watch')->add($data)) {
		        		if($source_type === 'user'){
			                //	发送notify  插入动态  更新关注数
			                $doing_data = array('user_id'=>$userinfo['id'],'action'=>'watch_question','source_id'=>$source_id,'source_type'=>$type,'subject'=>$subject);
			                D('Behavior')->add($doing_data);
			                M('User')->where(array('id'=>$source['id']))->setInc('watch',1);
			            }else if($source_type === 'tag' ){
			            	//	发送notify  更新关注数
			                M('Tag')->where(array('id'=>$source['id']))->setInc('watch',1);
			            }else if($source_type === 'question') {
			            	//	更新关注数
			            	M('Question')->where(array('id'=>$source['id']))->setInc('watch',1);
			            }
		        	}
		        	$this->ajaxReturn(array('status'=>1,'message'=>'关注成功','followed'=>'followed'));
		        }
			}
		}
	}

	/*通用收藏和取消收藏*/
	public function collect()
	{
		//	类型：文章、话题、讨论、问答
		$userinfo = session('user');
    	if(!$userinfo) {
    		$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
    	}
		if(IS_AJAX) {
			$source_type = I('request.source_type');
    		$source_id = (int)I('request.source_id');
    		if(in_array($source_type, array('article','tag','discuss','question'))) {
    			$source_type = ucfirst($source_type);
    			$collect = D('Collection')->where(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type))->find();
	    		if($collect) {
	    			//	取消
	    			if(D('Collection')->where(array('id'=>$collect['id']))->delete()) {
	    				D("{$source_type}")->where(array('id'=>$source_id))->setDec('collect', 1);
	    				$this->ajaxReturn(array('status'=>1,'message'=>'取消收藏成功','collected'=>'uncollected'));
	    			}
	    		}else {
    				$source = M("{$source_type}")->find($source_id);
    				if(!$source) {
    					$this->ajaxReturn(array('status'=>0,'message'=>'要操作的内容不存在'));
    				}else {
    					$intro = $source['title'];
		    			//	加入收藏
		    			$data = array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type,'intro'=>$intro);
	    				if($c_id = D('Collection')->add($data)) {
	    					M("{$source_type}")->where(array('id'=>$source_id))->setInc('collect', 1);
	    					$this->ajaxReturn(array('status'=>1,'message'=>'收藏成功','collected'=>'collected'));
	    				}
    				}
	    		}
    		}
		}
	}

	/*通用评论*/
	public function comment()
	{
		//	类型：答案、文章、讨论
		$userinfo = session('user');
		if(!$userinfo) {
			$this->ajaxReturn(array('status'=>0,'message'=>'抱歉您还未登录','error'=>101));
		}
		if(IS_AJAX) {
			$post = I('post.');
			$source_type = $post['source_type'];
			$source_id = (int)$post['source_id'];
			if(!in_array($source_type, array('comment','article','discuss'))) {
				$this->ajaxReturn(array('status'=>0,'message'=>'要评论的内容类型不正确'));
			}
			$source_type = ucfirst($source_type);
			$detail = M("{$source_type}")->find($source_id);
			if(!$detail) {
				$this->ajaxReturn(array('status'=>0,'message'=>'你要评论的内容不存在'));
			}
			if($detail['user_id'] == $userinfo['id']) {
				$this->ajaxReturn(array('status'=>0,'message'=>'你不能给自己评论'));
			}
			$comment = M('Comment')->where(array('user_id'=>$userinfo['id'],'source_id'=>$source_id,'source_type'=>$source_type))->find();
			if($comment) {
				$this->ajaxReturn(array('status'=>0,'message'=>'您已经评论过了'));
			}else if(!$post['content']){
				$this->ajaxReturn(array('status'=>0,'message'=>'请填写你的评论'));
			}else if(check_word($post['content'])){
				$this->ajaxReturn(array('status'=>0,'message'=>'评论内容包含敏感词'));
			}else {
				$score = isset($post['score']) ? $post['score'] : 0;
				$data = array(
					'user_id'		=>	$userinfo['id'],
					'source_id'		=>	$source_id,
					'source_type'	=>	$source_type,
					'content'		=>	$post['content'],
					'to_user_id'	=>  $detail['user_id'],
					'score'			=>	$score,
					'created_time'	=>time(),
				);
    			if($c_id = D('Comment')->add($data)) {
    				M("{$source_type}")->where(array('id'=>$source_id))->setInc('comment', 1);
    				$count = M('Comment')->where(array('source_id'=>$source_id,'source_type'=>$source_type))->count('id');
    				$this->ajaxReturn(array('status'=>1,'message'=>'操作成功','count'=>$count));
    			}
			}
		}
	}

	/*打赏生成支付url*/
	public function getPayUrl()
	{
		//	类型：文章、回答
		if(IS_AJAX) {
			$post = I('post.');
			$t1 = $post['source_type'];
			$t2 = (int)$post['source_id'];
			$t3 = (int)$post['touser'];
			$t4 = (float)$post['money'];
			$t5 = rand(111111111, 999999999);
			$native = new \Vendor\Wxpay\lib\NativePay();
            $url = $native->GetPrePayUrl($t1."_".$t2."_".$t3."_".$t4."_".$t5);
            $this->ajaxReturn(array('status'=>1,'message'=>'请求成功','data'=>urlencode($url)));
		}
	}

	public function getQrcode()
	{
        require_once APPS_PATH . 'ThinkPHP/Library/Vendor/Wxpay/unit/phpqrcode/phpqrcode.php';
        $url = urldecode(I('get.data'));
		\QRcode::png($url, false, "H", 5, 2);
	}

	/*打赏*/
	public function reward()
	{
	}
}