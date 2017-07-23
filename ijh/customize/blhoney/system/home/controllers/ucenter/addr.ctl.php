<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*收货地址*/
class Ctl_Ucenter_Addr extends Ctl
{
	// 收货地址列表
    public function index($page=1) 
    {
        $check = $this->GP('check');
        if($check){
            $this->pagedata['check'] = $check;
        }
        $order = $this->GP('order');
        if($order){
            $this->pagedata['order'] = $order;
        }
        $filter = array();
        $filter['uid'] = $this->uid;
        $page= max(intval($page), 1);
        $count = 0;
        if($list = K::M('member/addr')->items($filter, array('addr_id'=>'desc'), $page, $limit, $count)){
            $addrs = array();
            foreach($list as $k=>$val){
                $addrs[$k] = $this->filter_fields('addr_id,contact,mobile,addr,is_default,house,lng,lat', $val);
            } 
        }
        $this->pagedata['addrs'] = $addrs;
    	$this->tmpl = "ucenter/addr/index.html";
    }

    public function create() 
    {
        if(!empty($_POST)){  
       
            if(!$contact = K::M('member/addr')->check_contact($this->GP('contact'))) {
                $this->msgbox->add('联系人长度为6至18位字符',210);
            }else if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add('手机号码有误',211);
            }else if(!$house = $this->GP('house')) {
                $this->msgbox->add('收货地址不能为空',212);
            }else if(!$this->GP('addr_lng') || !$this->GP('addr_lat')) {
                $this->msgbox->add('经纬度有误',213);
            }else if($addr_count = K::M('member/addr')->count(array('uid'=>$this->uid)) >= 5){
                $this->msgbox->add('抱歉，每个用户最多只能新增5个地址！',214);
            }else{

                $data = array();
                $data['uid'] = $this->uid;
                $data['contact'] = $contact;
                $data['mobile'] = $mobile;
                $data['addr'] = $this->GP('addr');
                $data['house'] = $house;
                $data['is_default'] = $this->GP('is_default') ? 1 : 0;
                $data['lng'] = $this->GP('addr_lng');
                $data['lat'] = $this->GP('addr_lat');
                if($addr_id = K::M('member/addr')->create($data)){
                    $this->msgbox->add('新增地址成功');
                }else {
                    $this->msgbox->add('新增地址失败',215);
                }
            }
        }else{
           $this->tmpl = 'ucenter/addr/create.html';         
        }
    }

    public function edit($addr_id)
    {
        if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add('你要修改的地址不存在或已经删除',210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add('非法的数据请求', 211);             
        }else{
            $this->pagedata['detail'] = $detail;   
        }
        $this->tmpl = "ucenter/addr/edit.html";
    }

    public function editsave() 
    {
        $pdata = isset($_POST) ? $_POST : false;
        if($pdata) {
            $addr_id = $this->GP('addr_id');
            $contact = $this->GP('contact');
            $mobile = $this->GP('mobile');
            $addr = $this->GP('addr');
            $house = $this->GP('house');
            $is_def = $this->GP('is_default');
            $lng = $this->GP('addr_lng');
            $lat = $this->GP('addr_lat');
            if(!K::M('verify/check')->len(strlen($this->GP('contact')),6,16)) {
                $this->msgbox->add('联系人必须是6到18位字符',210);
            }else if(!K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add('手机号码有误',211);
            }else if(!$this->GP('house')) {
                $this->msgbox->add('收货地址有误',212);
            }else if(!$this->GP('addr_lng') || !$this->GP('addr_lat')) {
                $this->msgbox->add('经纬度有误',213);
            }else if(!$detail = K::M('member/addr')->detail($this->GP('addr_id'))) {
                $this->msgbox->add("你要修改的地址不存在或已经删除",214);
            }else if($contact==$detail['contact'] && $mobile==$detail['mobile'] && $house==$detail['house'] &&  $is_def==$detail['is_default']) {
                $this->msgbox->add("您未做任何修改",215);
            }else if($detail['uid'] != $this->uid) {
                $this->msgbox->add("非法的数据请求",216);
            }else {
                $data = array();
                $data['addr_id'] = $addr_id;
                $data['contact'] = $contact;
                $data['mobile'] = $mobile;
                $data['addr'] = $addr;
                $data['house'] = $house;
                $data['is_default'] = $is_def ? 1 : 0;
                $data['lng'] =  $lng;
                $data['lat'] = $lat;

                if(K::M('member/addr')->update($data['addr_id'],$data)){
                    $this->msgbox->add('址修改成功');
                }else {
                    $this->msgbox->add('地址修改失败',209);
                }   
            }
        }
    }

    public function delete()
    {
        $addr_id = intval($this->GP('addr_id'));
        if(!$detail = K::M('member/addr')->detail($this->GP('addr_id'))) {
           $this->msgbox->add("你要修改的地址不存在或已经删除",210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add("非法的数据请求",211);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add('删除成功');
            }else {
                $this->msgbox->add('删除失败',212);
            }  
        }         
    } 

    public function add_map($addr_id)
    {
        $location = array();
        $ip_location = $this->ip_location();
        $location['addr_id'] = $addr_id;
        if($addr_id) {
            if($addr = K::M('member/addr')->detail($addr_id)) {
                $location['lng'] = $addr['lng'];
                $location['lat'] = $addr['lat'];
            }
        }
        
        $this->pagedata['location'] = $location;
    	$this->tmpl = "ucenter/addr/map.html";
    }

    public function set_default()
    {
        $addr_id = (int)$this->GP('addr_id');
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
            $this->msgbox->add('你要设置的地址不存在',210);
        }else if($detail['uid'] != $this->uid) {
            $this->msgbox->add("非法的数据请求",211);
        }else {
            if(K::M('member/addr')->set_default($this->uid,$addr_id)) {
                $this->msgbox->add('默认地址设置成功');
            }else {
                $this->msgbox->add('设置默认地址失败',212);
            }
        }
    }
    // 根据IP地址获取当前位置的经纬度
    public function ip_location() 
    {
        $locaiton = array();
        // 获得会员最近一次登录的IP
        if($loginip = K::M('member/member')->detail($this->uid)) {
            $getIp = $loginip['loginip']; 
        } 
        $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=7b92b3afff29988b6d4dbf9a00698ed8&ip={$getIp}&coor=bd09ll");
        if(empty($content)) {
            $this->msgbox->add('位置获取失败',212);
        }else {
            $json = json_decode($content);  
            $location['lng']= $json->{'content'}->{'point'}->{'x'};
            $location['lat']= $json->{'content'}->{'point'}->{'y'};
            $location['city']= $json->{'content'}->{'address_detail'}->{'city'};
            return $location;
        }
    }
}
