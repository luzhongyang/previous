<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Jpush_Device extends Mdl_Table
{   
  
    protected $_table = 'jpush_device';
    protected $_pk = 'device_id';
    protected $_cols = 'device_id,uid,staff_id,shop_id,from,register_id,platform,tag_ids';

    public function init_device($id, $register_id, $from='member', $tags = array())
    {
        $tags = (array)$tags;
        if(!$info = $this->detail_by_register_id($register_id)){
            $a = array('register_id'=>$register_id, 'from'=>$from);
            if(defined('CLIENT_OS')){
                $a['platform'] = strtolower(CLIENT_OS);
            }
            switch ($from) {
                case 'staff':
                    $a['staff_id'] = $id; break;
                case 'cashier':
                    $a['staff_id'] = $id;
                    if($staff = K::M('cashier/staff')->detail($id)){
                        $a['shop_id'] = $staff['shop_id'];
                        $tags[] = 'cashier_'.$staff['shop_id'];
                    }
                    break; 
                case 'shop' :
                    $a['shop_id'] = $id; break; 
                default:
                    $a['uid'] = $id; break; 
            }
            if($device_id = $this->create($a)){
                try{
                    if(!$client = $this->client($from)){
                        return false;
                    }
                    $tags[] = 'default'; 
                    $client->device()->updateDevice($register_id, $id, null, $tags);
                    return $this->detail($device_id);
                }catch(Exception $e){
                    K::M('system/logs')->log('jpush.Exception', array('init_device_create'=>$a, 'exception'=>$e->getMessage()));
                    return false;
                }
            }
        }else if($register_id){
            $a = array();
            if($from == 'member' && $info['uid'] != $id){
                $a['uid'] = $info['uid'] = $id;
            }else if($from == 'staff' && $info['staff_id'] != $id){
                $a['staff_id'] = $info['staff_id'] = $id;
            }else if($from == 'cashier' && $info['staff_id'] != $id){
                $a['staff_id'] = $info['staff_id'] = $id;
				$a['shop_id'] = $info['shop_id'];
            }else if($from == 'shop' && $info['shop_id'] != $id){
                $a['shop_id'] = $info['shop_id'] = $id;
            }
            try{
                if(!$client = $this->client($from)){
                    return false;
                }
                $tags = array_merge($info['tags'], $tags);
                $tags = array_unique($tags);
                $client->device()->updateDevice($register_id, $id, null, $info['tags']);
                if($a){
                    $this->update($info['device_id'], $a);
                }
            }catch(Exception $e){
                K::M('system/logs')->log('jpush.Exception', array('init_device_info'=>$info, 'exception'=>$e->getMessage()));
                return false;
            }
        }
        return $info;
    }

    public function detail_by_register_id($register_id)
    {
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE ".self::field('register_id', $register_id);
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;        
    }

    public function detail_by_id($id, $from='member')
    {
        if(!$id = (int)$id){
            return false;
        }
        switch($from){
            case 'staff' : 
                $where = "staff_id='{$id}'"; break;
            case 'shop' : 
                $where = "shop_id='{$id}'"; break;
			case 'cashier' : 
                $where = "staff_id='{$id}'"; break;
            case 'shop' :
            default : 
                $where = "uid='{$id}'"; break;
        }
         if(!in_array($from, array('member', 'shop', 'staff'))){
            return false;
        }
        $sql = "SELECT * FROM ".$this->table($this->_table)." WHERE $where";
        if($row = $this->db->GetRow($sql)){
            $row = $this->_format_row($row);
        }
        return $row;
    }

    protected function _format_row($row)
    {
        static $_tag_list = null;
        if($_tag_list === null){
            $_tag_list = K::M('jpush/tag')->fetch_all();
        }
        static $_from_list = array('member'=>'用户端', 'staff'=>'服务端', 'shop'=>'商户端','cashier'=>'收银员');
        $row['from_title'] = $_from_list[$row['from']];
        $tags = array();
        foreach(explode(',', $row['tag_ids']) as $id){
            if($tag = $_tag_list[$id]){
                $tags[$id] = $tag['tag'];
            }
        }
        switch($row['from']){
            case 'staff' : 
                $row['alias'] = $row['staff_id']; break;
            case 'shop' : 
                $row['alias'] = $row['shop_id']; break;
            default : 
                $row['alias'] = $row['uid']; break;
        }
        $row['tags'] = !empty($tags) ? $tags : array('default');
        return $row;
    }

    public function client($from='member')
    {
        Import::L('JPush/JPush.php');
        $cfg = K::$system->config->get('apppush');
        try{
            $client = new JPush($cfg[$from]['appkey'], $cfg[$from]['secret']);
            return $client;
        }catch(Exception $e){
            K::M('system/logs')->log('jpush.Exception', array('init_device_info'=>$info, 'exception'=>$e->getMessage()));
            return false;
        }
    }
    
    public function jpush($title, $content, $params, $extras=null)
    {
        $tag_id = intval($params['tag_id']);
        $platform = strtolower($params['platform']);
        $device_id = (int)$params['device_id'];
        $from = strtolower($params['from']);
        if(!in_array($from, array('member', 'staff', 'shop','cashier'))){
            $from = 'member';
        }
        if(!in_array($platform, array('all', 'android', 'ios'))){
            $platform = 'all';
        }
        $log = array('title'=>$title, 'content'=>$content, 'from'=>$from, 'platform'=>$platform, 'device_id'=>$device_id);
        try{
            if(!$client = $this->client($from)){
                return false;
            }
            $sound = $extras['sound'] ? $extras['sound'] : 'default';
            $pushLoad = $client->push();
            $tag_list = K::M('jpush/tag')->fetch_all();
            if($device_id && ($device = K::M('jpush/device')->detail($device_id))){
                $pushLoad->addRegistrationId($device['register_id']);
                $log['register_id'] = $device['register_id'];
            }else if($register_id = $params['register_id']){
                $pushLoad->addRegistrationId($register_id);
                $log['register_id'] = $register_id;
            }else if($alias = $params['alias']){
                $pushLoad->addAlias((string)$alias);
                $log['alias'] = $params['alias'];
            }else if($tag_id && ($tag = $tag_list[$tag_id])){
                $pushLoad->addTag($tag['tag']);
                $log['tag'] = $tag['tag'];  
            }else if($tag = $params['tag']){
                $pushLoad->addTag($tag);   
            }else{
                $pushLoad->addAllAudience();
            }
            if($platform == 'ios'){
                $pushLoad->setPlatform('ios');
                //$pushLoad->addIosNotification($content, 'default', '+1', true, 'iOS category', $extras);
                $pushLoad->addIosNotification($content, $sound, '+1', true, null, $extras);
                //$pushLoad->setOptions(null, null, null, false, null); //开发证书
                $pushLoad->setOptions(null, null, null, true, null); //生产证书
            }else if($platform == 'android'){
                $pushLoad->setPlatform('android');
                $pushLoad->addAndroidNotification($content, $title, 1, $extras);
            }else{
                $pushLoad->setPlatform('all');
                $pushLoad->addAndroidNotification($content, $title, 1, $extras);
                //$pushLoad->addIosNotification($content, 'default', '+1', true, 'iOS category', $extras);
                $pushLoad->addIosNotification($content, $sound, '+1', true, null, $extras);
                //$pushLoad->setOptions(null, null, null, false, null); //开发证书
                $pushLoad->setOptions(null, null, null, true, null); //生产证书
            }
            $respone = $pushLoad->send();
            $respone = (array)$respone;
            if(isset($respone['data'])){
                $log['status'] = 1;
                $res = true;
            }else{
                $log['status'] = 0;
                $res = false;
            }
            K::M('jpush/log')->create($log);
            return $res;
        }catch(Exception $e) {
            //echo $e->getMessage();
            K::M('system/logs')->log('jpush.Exception', array('respone'=>$respone, 'exception'=>$e->getMessage()));
            return false;
        }  
    }
    
    public function send_member($uid, $title, $content, $extras=null)
    {
        // if(!$row = $this->detail_by_id($uid, 'member')){
        //     return false;
        // }
        return $this->jpush($title, $content, array('alias'=>$uid, 'from'=>'member'), $extras);
    }
    public function send_staff($staff_id, $title, $content, $extras=null)
    {
        // if(!$row = $this->detail_by_id($staff_id, 'staff')){
        //     return false;
        // }
        return $this->jpush($title, $content, array('alias'=>$staff_id, 'from'=>'staff'), $extras);
    }
    public function send_shop($shop_id, $title, $content, $extras=null)
    {
        // if(!$row = $this->detail_by_id($shop_id, 'shop')){
        //     return false;
        // }
        return $this->jpush($title, $content, array('alias'=>$shop_id, 'from'=>'shop'), $extras);
    }

    public function send_cashier($staff_id, $title, $content, $extras=null)
    {
        K::M('system/logs')->log('mdl.jpush.device.send_cashier', array($staff_id, $title, $content, $extras));
        return $this->jpush($title, $content, array('alias'=>$staff_id, 'from'=>'cashier'), $extras);
    }
}