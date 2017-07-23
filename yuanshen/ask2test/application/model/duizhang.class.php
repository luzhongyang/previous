<?php

!defined('IN_ASK2') && exit('Access Denied');
class duizhangmodel {

    var $db;
    var $base;


    function duizhangmodel(&$base) {
      
          $this->base = $base;
        $this->db = $base->db;
    }

   
function get_list($start = 0, $limit = 10,$begintime=0,$endtime=0){
    	$recargelist = array();
       
   $query='';
         if($begintime>0){
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."paylog`  WHERE  time>=$begintime and time <=$endtime ORDER BY `time` DESC limit $start,$limit");
         	
         }else{
         	 $query = $this->db->query("SELECT * FROM `".DB_TABLEPRE ."paylog` ORDER BY `time` DESC limit $start,$limit");
         	
         }
        
        $suffix='?';
        if( $this->base->setting['seo_on']){
        	$suffix='';
        }
        while ($money = $this->db->fetch_array($query)) {
        	//$fromuser=$this->getuser($money['touid']);
        	// $money['cash_fee'] = $money['money']/100;
        	
           // $money['fromusername'] =$fromuser['username'];
             $money['time']=tdate($money['time']);
             $money['touser']=$this->get_by_uid($money['touid']);
            
              $money['fromuser']= $money['fromuid']!=0? $this->get_by_uid($money['fromuid']):null;
             switch ($money['type']){
             	 	case 'viewaid':
             			 $money['operation']='用户付费偷看';
             		$money['money']="收入".$money['money']."元";
             		  $mod=$this->getanswer($money['typeid']);
             		 
             		  $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['qid'], 2);
             		   $money['content']="偷看回答的问题:<a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  
             		  
             		break;
             		 	case 'myviewaid':
             			 $money['operation']=$money['touser']['username'].'的偷看回答';
             		$money['money']="支出".$money['money']."元";
             		  $mod=$this->getanswer($money['typeid']);
             		 
             		  $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['qid'], 2);
             		   $money['content']="付费偷看回答的问题:<a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  
             		  
             		break;
             		case 'chongzhi':
             		 $money['operation']='用户充值';
             		
             		 $money['money']="收入".$money['money']."元";
             		  
             		   $money['content']="来自用户充值付款";
             		break;
             	case 'aid':
             		 $money['operation']='回答打赏';
             		 $mod=$this->getanswer($money['typeid']);
             		  $money['money']="收入".$money['money']."元";
             		  $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['qid'], 2);
             		   $money['content']="<a href='".$viewurl.".html'>".$mod['title']."</a>";
             		break;
             			case 'tid':
             		 $money['operation']='文章打赏';
             		  $mod=$this->gettopic($money['typeid']);
             		 $viewurl =SITE_URL.$suffix. urlmap('topic/getone/' . $mod['id'], 2);
             		   $money['content']="<a href='".$viewurl.".html'>".$mod['title']."</a>";
             		 
             		break;
             		case 'wtxuanshang':
             		 $money['operation']='提问悬赏';
             		  $mod=$this->getquestion($money['typeid']);
             $money['money']="支出".$money['money']."元";
             		  if( $mod==null){
             		  	$money['content']="此悬赏问题被删除，问题qid=".$money['typeid'];
             		  }else{
             		  	 $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['id'], 2);
             		   $money['content']="悬赏标题-><a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  }
             		break;
             			case 'fufeitiwen':
             		 $money['operation']='付费提问';
             		  $mod=$this->getquestion($money['typeid']);
             $money['money']="支出".$money['money']."元";
             		  if( $mod==null){
             		  	$money['content']="此付费问题被删除，问题qid=".$money['typeid'];
             		  }else{
             		  	 $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['id'], 2);
             		   $money['content']="付费提问标题-><a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  }
             		break;
             				case 'eqid':
             		 $money['operation']='【'.$money['fromuser']['username'].'】对专家【'.$money['touser']['username'].'】提问';
             		  $mod=$this->getquestion($money['typeid']);
             $money['money']="专家收入".$money['money']."元";
             		  if( $mod==null){
             		  	$money['content']="此付费对专家提问的问题被删除，问题qid=".$money['typeid'];
             		  }else{
             		  	 $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['id'], 2);
             		   $money['content']="对专家提问标题-><a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  }
             		break;
             			case 'adoptqid':
             		 $money['operation']='回答被采纳';
             		  $money['money']="收入".$money['money']."元";
             		  $mod=$this->getquestion($money['typeid']);
             		    $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['id'], 2);
             		   $money['content']="<a href='".$viewurl.".html'>".$mod['title']."</a>";
             		break;
             			case 'thqid':
             		 $money['operation']='问题被删除退还悬赏金额';
             		 $money['money']="收入".$money['money']."元";
             		
             		   $money['content']="此删除问题qid=".$money['typeid'];
             		break;
             			case 'theqid':
             		 $money['operation']='退还对专家付费提问金额';
             		  $money['money']="收入".$money['money']."元";
             		 $mod=$this->getquestion($money['typeid']);
             		  if( $mod==null){
             		  	$money['content']="此问题被删除，问题qid=".$money['typeid'];
             		  }else{
             		  	 $viewurl =SITE_URL. $suffix.urlmap('question/view/' . $mod['id'], 2);
             		   $money['content']="标题-><a href='".$viewurl.".html'>".$mod['title']."</a>";
             		  }
             		   
             		break;
             }
           
            $recargelist[] = $money;
        }
        return $recargelist;
    }
    function get_by_uid($uid) {
        $user = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user WHERE uid='$uid'");
        $user['avatar'] = get_avatar_dir($uid);
       
        return $user;
    }
 function getanswer($id) {
        $answer= $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "answer WHERE id='$id'");
        
         if ($answer) {
          
             $answer['title']=checkwordsglobal( $answer['title']);
              $answer['content']=checkwordsglobal( $answer['content']);
        }
        return $answer;
    }
   function getmysummoneybytouid($touid){
    	
    	$mrmb = $this->db->fetch_first("SELECT sum(cash_fee) as rmb FROM " . DB_TABLEPRE . "weixin_notify WHERE touid=$touid and haspay=0 ");
        //$mrmb=intval($mrmb)/100;
    	return $mrmb;
    	
    }
   function gethasmysummoneybytouid($touid){
    	
    	$mrmb = $this->db->fetch_first("SELECT sum(cash_fee) as rmb FROM " . DB_TABLEPRE . "weixin_notify WHERE touid=$touid and haspay=1 ");
        //$mrmb=intval($mrmb)/100;
    	return $mrmb;
    	
    }
    function getquestion($id) {
        $question = $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "question WHERE id='$id'");
        if ($question) {
          
             $question['title']=checkwordsglobal( $question['title']);
             
        }
        return $question;
    }
   function gettopic($id) {
         $topic =  $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "topic WHERE id='$id'");
        
        if ($topic) {
         
            $topic['title'] = checkwordsglobal($topic['title']);
              
        }
        return $topic;
    }


}

?>
