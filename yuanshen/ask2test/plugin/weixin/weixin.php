<?php



define('IN_ASK2', TRUE);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'].'/');
require  '../../lib/db.class.php';
require   '../../lib/global.func.php';

 require '../../config.php';
$wechatObj = new wechatCallbackapiTest();

if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
	 var $db;
	  var $token;
	  function wechatCallbackapiTest() {
	  	
	  	 $this->init_db();
	  $this->token=$this->getoken();
	  }
 function init_db() {
        $this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_CHARSET, DB_CONNECT);
    }
    function getoken(){
    	 $wxtoken =   $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "setting where k='wxtoken' limit 0,1");
    	return trim($wxtoken['v']);
    }
    //验证签名
    public function valid()
    {
    	
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R \r\n".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")){
                //过滤关注和取消关注事件
            }else{
                
            }
            
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                  
                        $result = $this->receiveText($postObj);
                  
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T \r\n".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }

    //接收事件消息
    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
            	 $site =   $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "weixin_info limit 0,1");
                $content = $site['msg'];
                $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK":
               $content=$this->getcontent($object->EventKey);
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            case "LOCATION":
                $content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode"){
                    $content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
                }else if ($object->ScanCodeInfo->ScanType == "barcode"){
                    $codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：".$codeValue;
                }else{
                    $content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 ".$object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 ".$object->SendLocationInfo->Label;
                break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }
      if($content==""){
         	$content="小编不知道你在说啥";
         }
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    private function getcontent($keyword,$object=null){
      $keys = array();
       $kcontent = array();
       $content=$keyword;
        $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "weixin_keywords order by id desc LIMIT 0,1000");
          while ($key = $this->db->fetch_array($query)) {
          	//精准匹配
             if($key['showtype']==1){
             	if($keyword==$key['txtname']){
             		//系统关键词
             		if($key['txttype']==1){
             			switch (trim($key['txtcontent'])){
             				case '#最新问题#':
             			$content=$this->newquestion();
             						if(count($content)<=0){
             							$content="没有最新问题推荐哟";
             						}
             					break;
             					case '#热门问题#':
             				$content=$this->hotquestion();
             						if(count($content)<=0){
             							$content="没有最新问题推荐哟";
             						}
             					break;
             					case '#最新文章#':
             						$content=$this->newblog();
             						if(count($content)<=0){
             							$content="没有最新文章推荐哟";
             						}
             					break;
             					case '#站长推荐#':
             			$content=$this->hotblog();
             						if(count($content)<=0){
             							$content="没有站长推荐的文章哟";
             						}
             					break;
             					case '#附近的人#':
             					break;
             					case '#附近的问题#':
             					break;
             		
             			}
             		}else{
             			  if(!empty($key['title'])&&$key['title']!=''){
             			  	
             			  	$sql= $this->db->query("SELECT * FROM " . DB_TABLEPRE . "weixin_keywords where txtname='$keyword' order by id desc LIMIT 0,9");

             			  	
             			     while ($topic = $this->db->fetch_array($sql)) {
             			     	
             			     	if(strstr($topic['wburl'],'http:')){
             			     		$kcontent[] = array("Title"=> checkwordsglobal(  $topic['title']), "Description"=>checkwordsglobal( $topic['txtcontent']), "PicUrl"=>  SITE_URL.$topic['fmtu'], "Url" =>$topic['wburl']);
             			 
             			     	}else{
             			     		$kcontent[] = array("Title"=> checkwordsglobal(  $topic['title']), "Description"=>checkwordsglobal( $topic['txtcontent']), "PicUrl"=>  SITE_URL.$topic['fmtu'], "Url" =>SITE_URL.'?article-'.$topic['wzid']);
             			 
             			     	}
                         	
        }
             			  	
             			  
             			  }else{
             			  	 $content = $key['txtcontent'];
             			  }
             			 
             		}
             		if(count($kcontent)>0){
             			$content=$kcontent;
             		}
             		break;
             	}
             }else{
             	//模糊匹配
             if(strstr($keyword, $key['txtname'])){
             if($key['txttype']==1){
             			switch (trim($key['txtcontent'])){
             				case '#最新问题#':
             			$content=$this->newquestion();
             						if(count($content)<=0){
             							$content="没有最新问题推荐哟";
             						}
             					break;
             					case '#热门问题#':
             			$content=$this->hotquestion();
             						if(count($content)<=0){
             							$content="没有最新问题推荐哟";
             						}
             					break;
             					case '#最新文章#':
             				$content=$this->newblog();
             						if(count($content)<=0){
             							$content="没有最新文章推荐哟";
             						}
             					break;
             					case '#站长推荐#':
             			$content=$this->hotblog();
             						if(count($content)<=0){
             							$content="没有站长推荐的文章哟";
             						}
             					break;
             					case '#附近的人#':
             					break;
             					case '#附近的问题#':
             					break;
             			}
             		}else{
             		 if(!empty($key['title'])&&$key['title']!=''){
             			  	
             			  	$sql= $this->db->query("SELECT * FROM " . DB_TABLEPRE . "weixin_keywords where txtname='$keyword' order by id desc LIMIT 0,9");

             			  	
             			     while ($topic = $this->db->fetch_array($sql)) {
             			     if(strstr($topic['wburl'],'http:')){
             			     		$kcontent[] = array("Title"=> checkwordsglobal(  $topic['title']), "Description"=>checkwordsglobal( $topic['txtcontent']), "PicUrl"=>  SITE_URL.$topic['fmtu'], "Url" =>$topic['wburl']);
             			 
             			     	}else{
             			     		$kcontent[] = array("Title"=> checkwordsglobal(  $topic['title']), "Description"=>checkwordsglobal( $topic['txtcontent']), "PicUrl"=>  SITE_URL.$topic['fmtu'], "Url" =>SITE_URL.'?article-'.$topic['wzid']);
             			 
             			     	}			 
        }
             			  	
             			  
             			  }else{
             			  	 $content = $key['txtcontent'];
             			  }
             		}
             if(count($kcontent)>0){
             			$content=$kcontent;
             		}
             		break;
             	}
             }
          }
          return $content;
    }
    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
       
      
        $content="";
        $content=$this->getcontent($keyword,$object);
      
        
//        //自动回复模式
//     if (strstr($keyword, "最新博客")){
//       $content = array();
//        $query = $this->db->query("SELECT * FROM " . DB_TABLEPRE . "topic order by id desc LIMIT 0,4");
//        while ($topic = $this->db->fetch_array($query)) {
//           
//  //$topic['viewtime'] = tdate($topic['viewtime']);
//  $index=strpos($topic['image'],'http');
//  if($index==0){
//  	 $content[] = array("Title"=>$topic['title'], "Description"=>"", "PicUrl"=> $topic['image'], "Url" =>'http://' . $_SERVER['HTTP_HOST'].'/article-'.$topic['id']);
//  }else{
//  	 $content[] = array("Title"=>$topic['title'], "Description"=>"", "PicUrl"=> 'http://' . $_SERVER['HTTP_HOST'].$topic['image'], "Url" =>'http://' . $_SERVER['HTTP_HOST'].'/article-'.$topic['id']);
//  }
//            
//        }
//        
//          
//        }
//        else if (strstr($keyword, "文本")){
//            $content = "这是个文本消息";
//        }else if (strstr($keyword, "表情")){
//            $content = "中国：".$this->bytes_to_emoji(0x1F1E8).$this->bytes_to_emoji(0x1F1F3)."\n仙人掌：".$this->bytes_to_emoji(0x1F335);
//        }else if (strstr($keyword, "单图文")){
//            $content = array();
//            $content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
//        }else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
//            $content = array();
//            $content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
//            $content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
//            $content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
//        }else if (strstr($keyword, "音乐")){
//            $content = array();
//            $content = array("Title"=>"最炫民族风", "Description"=>"歌手：凤凰传奇", "MusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3", "HQMusicUrl"=>"http://121.199.4.61/music/zxmzf.mp3"); 
//        }else{
//            $content = date("Y-m-d H:i:s",time())."\nOpenID：".$object->FromUserName."\nask2问答系统";
//        }
         if($content==""){
         	 $unword =   $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "setting where k='unword' limit 0,1");
    	      $_content=trim($unword['v']);
    	      
         	$content=empty($_content)? "小编不知道你在说啥":$_content;
         }
             if($content=="签到"||$content=="打卡"){
               	$content="签到记录已经收到";
               }
          if($content=="账号绑定"){
          	$openid=$object->FromUserName;
          	 $getone =   $this->db->fetch_first("SELECT * FROM " . DB_TABLEPRE . "user where openid='$openid' limit 0,1");
    	      if($getone==null){
    	      	 $url="http://".$_SERVER['SERVER_NAME']."?account/bind/$openid";
               	$content="<a href='$url'>点击进入账号绑定</a>";
    	      }else{
    	      	
               	$content="您已经绑定账号了";
    	      }
    	      
          	   
               }
               if($content=='openid'){
               	$content="您的openid:".$object->FromUserName;
               }
//                  if($content=='我圣诞快乐'){
//                  	@require   '../../lib/wxpay/hongbao/pay.php';
//$packet = new Packet();
////
//////调取支付方法
//	$result=$packet->_route('wxpacket',array('openid'=>$object->FromUserName));
////	
//	switch ($result){
//		case 'SUCCESS':
//			$content="圣诞快乐，送了你一个红包，赶快领取吧！";
//			break;
//			default:
//				$content="红包领取失败，再接再励!".$result;
//				break;
//	}
////
//                  }
            
        if(is_array($content)){
            if (isset($content[0])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }

    //接收图片消息
    private function receiveImage($object)
    {
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object)
    {
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
           // $object->content=$object->Recognition;
            //$this->receiveText($object);
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }
        return $result;
    }

    //接收视频消息
    private function receiveVideo($object)
    {
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)){
            return "";
        }

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[news]]></MsgType>
    <ArticleCount>%s</ArticleCount>
    <Articles>
$item_str    </Articles>
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        if(!is_array($musicArray)){
            return "";
        }
        $itemTpl = "<Music>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <MusicUrl><![CDATA[%s]]></MusicUrl>
        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[music]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[image]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
        <MediaId><![CDATA[%s]]></MediaId>
    </Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[voice]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
        <MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[video]]></MsgType>
    $item_str
</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复第三方接口消息
    private function relayPart3($url, $rawData)
    {
        $headers = array("Content-Type: text/xml; charset=utf-8");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    //字节转Emoji表情
    function bytes_to_emoji($cp)
    {
        if ($cp > 0x10000){       # 4 bytes
            return chr(0xF0 | (($cp & 0x1C0000) >> 18)).chr(0x80 | (($cp & 0x3F000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x800){   # 3 bytes
            return chr(0xE0 | (($cp & 0xF000) >> 12)).chr(0x80 | (($cp & 0xFC0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else if ($cp > 0x80){    # 2 bytes
            return chr(0xC0 | (($cp & 0x7C0) >> 6)).chr(0x80 | ($cp & 0x3F));
        }else{                    # 1 byte
            return chr($cp);
        }
    }

    //日志记录
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 1000000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }
    //最新博客
    function newblog(){
       $content = array();
        
        $newtopic=file_get_contents('http://' . $_SERVER['HTTP_HOST'] .'/?api_article/list');
				
		   $de_json = json_decode($newtopic,TRUE);
		
      $count_json = count($de_json);
        for ($i = 0; $i < $count_json; $i++)
           {
               
 
             
            
				 $content[] = array("Title"=> $de_json[$i]['Title'], "Description"=>$de_json[$i]['Description'], "PicUrl"=> $de_json[$i]['PicUrl'], "Url" =>$de_json[$i]['Url']);

                }
				
			
				
				
        return $content;
    }
   //最热博客
    function hotblog(){
       $content = array();
        
        $newtopic=file_get_contents('http://' . $_SERVER['HTTP_HOST'] .'/?api_article/hotalist');
				
		   $de_json = json_decode($newtopic,TRUE);
		
      $count_json = count($de_json);
        for ($i = 0; $i < $count_json; $i++)
           {
               
 
             
            
				 $content[] = array("Title"=> $de_json[$i]['Title'], "Description"=>$de_json[$i]['Description'], "PicUrl"=> $de_json[$i]['PicUrl'], "Url" =>$de_json[$i]['Url']);

                }
				
			
				
				
        return $content;
    }
    //最新问题
    function newquestion(){
       $content = array();

    		$newquestion=file_get_contents('http://' . $_SERVER['HTTP_HOST'] .'/?api_article/newqlist');
				
		   $de_json = json_decode($newquestion,TRUE);
	
      $count_json = count($de_json);
        for ($i = 0; $i < $count_json; $i++)
           {
               
 
            
$content[] = array("Title"=> checkwordsglobal( $de_json[$i]['title']), "Description"=>checkwordsglobal($de_json[$i]['description']), "PicUrl"=> $de_json[$i]['avatar'], "Url" =>$de_json[$i]['url']);
                }
                
        return $content;
    }
    //最新问题
    function hotquestion(){
       $content = array();

    		$hotquestion=file_get_contents('http://' . $_SERVER['HTTP_HOST'] .'/?api_article/hotqlist');
				
		   $de_json = json_decode($hotquestion,TRUE);
	
      $count_json = count($de_json);
        for ($i = 0; $i < $count_json; $i++)
           {
               
 
            
$content[] = array("Title"=> checkwordsglobal( $de_json[$i]['title']), "Description"=>checkwordsglobal($de_json[$i]['description']), "PicUrl"=> $de_json[$i]['avatar'], "Url" =>$de_json[$i]['url']);
                }
                
        return $content;
    }
}
?>