<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_Tieba extends Ctl
{

    public function items($params)
    {
        $filter = array('closed'=>0);
        if($xiaoqu_id = (int)$params['xiaoqu_id']){
            $filter['xiaoqu_id'] = $xiaoqu_id;
        }else if(__LNG && __LAT){
            // {{{####
            $squares = K::M('helper/round')->returnSquarePoint(__LNG, __LAT, 30); //30KM的话题
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            // ####}}}
        }
        if(in_array($params['from'], array('topic', 'trade'))){
            $filter['from'] = $params['from'];
        }
        $limit = 10;
        $page = max((int)$page, 1);
        if($items = K::M('xiaoqu/tieba')->items($filter, array('lasttime'=>'DESC', 'tieba_id'=>'DESC'), $page, $limit, $count)){
            $xiaoqu_ids = $uids = $tieba_ids = array();
            foreach($items as $k=>$v){
                $uids[$v['uid']] = $v['uid'];
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
                $tieba_ids[$v['tieba_id']] = $v['tieba_id'];
                $v = $this->filter_fields('tieba_id,uid,city_id,city_name,xiaoqu_id,from,title,content,contact,mobile,price,likes,views,replys,lng,lat,lasttime,dateline', $v);
                $v['dateline_label'] = strip_tags(K::M('helper/format')->time($v['dateline']));
                if(CLIENT_OS == 'ANDROID'){
                    $v['_photos'] = array();
                }else{
                    $v['photos'] = array();
                }
                $items[$k] = $v;
                
            }
            if($member_list = K::M('member/member')->items_by_ids($uids)){
                foreach($items as $k=>$v){
                    if($row = $member_list[$v['uid']]){
                        $v['member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                    }else{
                        $v['member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
                    }
                    $items[$k] = $v;
                }
            }
            if($xiaoqu_list = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids)){
                foreach($items as $k=>$v){
                    if($row = $xiaoqu_list[$v['xiaoqu_id']]){
                        $v['xiaoqu_title'] = $row['title'];
                    }else{
                        $v['xiaoqu_title'] = '';
                    }
                    $items[$k] = $v;
                }
            }
            if($photo_list = K::M('xiaoqu/tieba/photo')->items(array('tieba_id'=>$tieba_ids), null, 1, 100)){
                foreach($photo_list as $v){
                    if(CLIENT_OS == 'ANDROID'){
                        $items[$v['tieba_id']]['_photos'][] = $v['photo'];
                    }else{
                        $items[$v['tieba_id']]['photos'][] = $v['photo'];
                    }
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }


    public function create($params)
    {
        $this->check_login();
        if(!in_array($params['from'], array('topic', 'trade'))){
            $params['from'] = 'topic';
        }
        if(!$data = $this->check_fields($params, 'city_id,xiaoqu_id,from,title,content,contact,mobile,price,lng,lat')){
            $this->msgbox->add('参数不正确', 211);
        }else{
            if(!in_array($data['from'], array('topic', 'trade'))){
                $data['from'] = 'topic';
            }
            $data['city_id'] = CITY_ID; //默认城市ID
            if($xiaoqu_id = (int)$data['xiaoqu_id']){
                if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
                    unset($data['xiaoqu_id']);
                }else{
                    $data['city_id'] = $xiaoqu['city_id'];
                }
            }
            if(!$data['lat'] || !$data['lng']){
                if($xiaoqu){
                    $data['lng'] = $xiaoqu['lng'];
                    $data['lat'] = $xiaoqu['lat'];                    
                }else{
                    $data['lng'] = __LNG;
                    $data['lat'] = __LAT;
                }
            }
            $data['lasttime'] = __TIME;
            $data['uid'] = $this->uid;
            if(empty($data['content'])){
                $this->msgbox->add('话题内容不能为空', 211);
            }else if($data['from'] == 'trade' && empty($data['title'])){
                $this->msgbox->add('交易标题不能为空', 212);
            }else if($data['from'] == 'trade' && empty($data['contact'])){
                $this->msgbox->add('联系人不能为空', 213);
            }else if($data['from'] == 'trade' && empty($data['mobile'])){
                $this->msgbox->add('联系电话不能为空', 214);
            }else if($data['from'] == 'trade' && !K::M('verify/check')->mobile($data['mobile'])){
                $this->msgbox->add('联系电话不格式不正确', 215);
            }else if($data['from'] == 'trade' && empty($data['price'])){
                $this->msgbox->add('宝贝价格不能为空', 216);
            }else if($tieba_id = K::M('xiaoqu/tieba')->create($data)){
                if($attachs = $_FILES){
                    foreach($attachs as $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = K::M('magic/upload')->upload($attach, 'xiaoqu')){
                                K::M('xiaoqu/tieba/photo')->create(array('tieba_id'=>$tieba_id, 'photo'=>$a['photo']));
                            }
                        }
                    }
                }
                $this->msgbox->set_data('data', array('tieba_id'=>$tieba_id));              
            }
        }
    }

    public function detail($params)
    {
        if(!$tieba_id = (int)$params['tieba_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$tieba = K::M('xiaoqu/tieba')->detail($tieba_id)){
            $this->msgbox->add('话题不存在或已经删除', 212);
        }else{
			K::M('xiaoqu/tieba')->update_count($tieba_id, 'views', 1);
            $tieba = $this->filter_fields('tieba_id,uid,city_id,city_name,xiaoqu_id,from,title,content,contact,mobile,price,likes,views,replys,lng,lat,lasttime,dateline', $tieba);
            $tieba['dateline_label'] = strip_tags(K::M('helper/format')->time($tieba['dateline']));
            if(CLIENT_OS == 'ANDROID'){
                $tieba['_photos'] = array();
            }else{
                $tieba['photos'] = array();
            }
			$tieba['views'] += 1;
            $tieba['xiaoqu_title'] = $tieba['city_name'];
            if($tieba['xiaoqu_id']){
                $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($tieba['xiaoqu_id']);
                $tieba['xiaoqu_title'] = $xiaoqu['title'];
            }
            $tieba['member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
            if($photo_list = K::M('xiaoqu/tieba/photo')->items(array('tieba_id'=>$tieba_id), null, 1, 10)){
                foreach($photo_list as $v){                    
                    if(CLIENT_OS == 'ANDROID'){
                        $tieba['_photos'][] = $v['photo'];
                    }else{
                        $tieba['photos'][] = $v['photo'];
                    }
                }
            }
            $uids = array($tieba['uid']=>$tieba['uid']);
            if($items = K::M('xiaoqu/tieba/reply')->items(array('tieba_id'=>$tieba_id, 'closed'=>0), array('reply_id'=>'DESC'), 1, 10, $count)){
                foreach($items as $k=>$v){
                    $uids[$v['uid']] = $v['uid'];
                    $uids[$v['at_uid']] = $v['at_uid'];
                    $v = $this->filter_fields('reply_id,tieba_id,uid,at_uid,at_reply_id,content,dateline', $v);
                    $v['member'] = $v['at_member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
                    $items[$k] = $v;
                }
            }
            if($member_list = K::M('member/member')->items_by_ids($uids)){
                if($row = $member_list[$tieba['uid']]){
                    $tieba['member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                }
                foreach($items as $k=>$v){
                    if($row = $member_list[$v['uid']]){
                        $v['member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                    }
                    if($row = $member_list[$v['at_uid']]){
                        $v['at_member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                    }
                    $items[$k] = $v;
                }
            }
            $this->msgbox->set_data('data', array('tieba'=>$tieba, 'items'=>array_values($items), 'total_count'=>$count));
        }
    }

    public function replyItems($params)
    {
        if(!$tieba_id = (int)$params['tieba_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$tieba = K::M('xiaoqu/tieba')->detail($tieba_id)){
            $this->msgbox->add('话题不存在或已经删除', 212);
        }else{
            $limit = 10;
            $page = max((int)$params['page'], 1);
            if($items = K::M('xiaoqu/tieba/reply')->items(array('tieba_id'=>$tieba_id, 'closed'=>0), array('reply_id'=>'DESC'), $page, $limit, $count)){
				//当加载下一页有数据时同时给帖子增加一次浏览器
				K::M('xiaoqu/tieba')->update_count($tieba_id, 'views', 1);
                $uids = array();
                foreach($items as $k=>$v){
                    $uids[$v['uid']] = $v['uid'];
                    $uids[$v['at_uid']] = $v['at_uid'];
                    $v = $this->filter_fields('reply_id,tieba_id,uid,at_uid,at_reply_id,content,dateline', $v);
                    $v['member'] = $v['at_member'] = array('uid'=>0, 'nickname'=>'匿名', 'face'=>'default/face.png');
                    $items[$k] = $v;
                }
                if($member_list = K::M('member/member')->items_by_ids($uids)){
                    foreach($items as $k=>$v){
                        if($row = $member_list[$v['uid']]){
                            $v['member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                        }
                        if($row = $member_list[$v['at_uid']]){
                            $v['at_member'] = array('uid'=>$row['uid'], 'nickname'=>$row['nickname'], 'face'=>$row['face']);
                        }
                        $items[$k] = $v;
                    }
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }

    public function reply($params)
    {
        $this->check_login();
        if(!$tieba_id = (int)$params['tieba_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$tieba = K::M('xiaoqu/tieba')->detail($tieba_id)){
            $this->msgbox->add('话题不存在或已经删除', 212);
        }else if(!$data = $this->check_fields($params, 'at_reply_id,content')){
            $this->msgbox->add('参数不正确', 213);
        }else{
            if($at_reply_id = (int)$data['at_reply_id']){
                if($reply = K::M('xiaoqu/tieba/reply')->detail($at_reply_id)){
                   $data['at_uid'] = $reply['uid'];
                }else{
                    unset($data['at_reply_id']);
                }
            }
            $data['tieba_id'] = $tieba_id;
            $data['uid'] = $this->uid;
            if($reply_id = K::M('xiaoqu/tieba/reply')->create($data)){
                K::M('xiaoqu/tieba')->update($tieba_id, array('lasttime'=>__TIME, 'replys'=>'`replys`+1'), true);
                $this->msgbox->set_data('data', array('reply_id'=>$reply_id));
            }
        }
    }

    public function like($params)
    {
        $this->check_login();
        if(!$tieba_id = (int)$params['tieba_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$tieba = K::M('xiaoqu/tieba')->detail($tieba_id)){
            $this->msgbox->add('话题不存在或已经删除', 212);
        }else if(K::M('xiaoqu/tieba')->update_count($tieba_id, 'likes', 1)){
            $this->msgbox->set_data('data', array('tieba_id'=>$tieba_id, 'likes'=>$tieba['likes'] + 1));
        }      
    }
}
