<?php

!defined('IN_ASK2') && exit('Access Denied');
class tixianmodel {

    var $db;
    var $base;


    function tixianmodel(&$base) {
      
          $this->base = $base;
        $this->db = $base->db;
    }

    function get_list($start = 0, $limit = 10) {
        $mdlist = array();

         $query='';
        
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."user_tixian`  WHERE state=0 ORDER BY `time` DESC limit $start,$limit");
         	
        
       
     
             while($md=$this->db->fetch_array($query)) {
           
             	$user=$this->get_by_uid($md['uid']);
            $md['time'] = tdate($md['time']);
           $md['uid']=$user['uid'];
             $md['username']=$user['username'];
          
             $mdlist[] = $md;
        }
    
     
        return $mdlist;
    }
    function get_by_uid($uid, $loginstatus = 1) {
        $user = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user WHERE uid='$uid'");
        $user['avatar'] = get_avatar_dir($uid);
        $user['register_time'] = tdate($user['regtime']);
        $user['lastlogin'] = tdate($user['lastlogin']);
        $user['grouptitle'] = $this->base->usergroup[$user['groupid']]['grouptitle'];
       
        return $user;
    }
    function get_viewlist($uid,$start = 0, $limit = 10,$begintime=0,$endtime=0) {
    	$total=0;
        $mdlist = array();

         $query='';
       
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."weixin_notify` where touid=$uid and haspay=0 ORDER BY `time_end` DESC limit $start,$limit");
         	
         
       
     
             while($md=$this->db->fetch_array($query)) {
      
            $md['format_time'] = tdate($md['time_end']);
            $md['cash_fee']=$md['cash_fee']/100;
            $total=$total+$md['cash_fee'];
            $arr=split('_',  $md['attach']);
            
         
            $type=$arr[0];
             $md['type']=$type;
             $dashangren=$this->f_get($md['openid']);
             $md['nickname']=$dashangren['nickname'];
              $md['headimgurl']=$dashangren['headimgurl'];
            switch ($type){
            	case 'aid':
            		 $md['type']="打赏回答";
            		$md['model']=$this->getanswer($arr[1]);
            		break;
            			case 'qid':
            					 $md['type']="打赏提问";
            		break;
            			case 'tid':
            					 $md['type']="打赏文章";
            				$md['model']=$this->gettopic($arr[1]);
            		break;
            		
            }
            
            switch (    $md['trade_trye']){
            	case "NATIVE":
            		$md['laiyuan']="扫码支付";
            		break;
            		case "JSAPI":
            			$md['laiyuan']="微信浏览器请求";
            		break;
            }
           
             $mdlist[] = $md;
        }
    
        $list=array($mdlist,$total);
        return $list;
    }
   /* 根据aid获取一个答案的内容，暂时无用 */

    function getanswer($id) {
        $answer= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "answer WHERE id='$id'");
        
         if ($answer) {
          
             $answer['title']=checkwordsglobal( $answer['title']);
              $answer['content']=checkwordsglobal( $answer['content']);
        }
        return $answer;
    }
function f_get($openid) {
         $model =  $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "weixin_follower where openid='$openid' limit 0,1");
        
       
        return $model;
    }

    function gettopic($id) {
         $topic =  $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "topic WHERE id='$id'");
        
        if ($topic) {
            $topic['viewtime'] = tdate($topic['viewtime']);
            $topic['title'] = checkwordsglobal($topic['title']);
             
        }
        return $topic;
    }
    

}

?>
