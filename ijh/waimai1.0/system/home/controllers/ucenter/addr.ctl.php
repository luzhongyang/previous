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
                $this->msgbox->add(L('联系人长度为6至18位字符'),210);
            }else if(!$mobile = K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add(L('手机号不正确'),211);
            }else if(!$house = $this->GP('house')) {
                $this->msgbox->add(L('收货地址不能为空'),212);
            }else if(!$this->GP('addr_lng') || !$this->GP('addr_lat')) {
                $this->msgbox->add(L('经纬度有误'),213);
            }else if($addr_count = K::M('member/addr')->count(array('uid'=>$this->uid)) >= 5){
                $this->msgbox->add(L('抱歉，每个用户最多只能新增5个地址'),214);
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
                    $this->msgbox->add(L('SUCCESS'));
                }else {
                    $this->msgbox->add(L('FAIL'),215);
                }
            }
        }else{
           $this->tmpl = 'ucenter/addr/create.html';         
        }
    }

    public function edit($addr_id)
    {
        if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 211);             
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
                $this->msgbox->add(L('联系人长度为6至18位字符'),210);
            }else if(!K::M('verify/check')->mobile($this->GP('mobile'))){
                $this->msgbox->add(L('手机号不正确'),211);
            }else if(!$this->GP('house')) {
                $this->msgbox->add(L('收货地址不能为空'),212);
            }else if(!$this->GP('addr_lng') || !$this->GP('addr_lat')) {
                $this->msgbox->add(L('经纬度有误'),213);
            }else if(!$detail = K::M('member/addr')->detail($this->GP('addr_id'))) {
                $this->msgbox->add(L('地址不存在或已被删除'),214);
            }else if($contact==$detail['contact'] && $mobile==$detail['mobile'] && $house==$detail['house'] &&  $is_def==$detail['is_default']) {
                $this->msgbox->add(L('您未做任何修改'),215);
            }else if($detail['uid'] != $this->uid) {
                $this->msgbox->add(L('非法操作'),216);
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
                    $this->msgbox->add(L('SUCCESS'));
                }else {
                    $this->msgbox->add(L('FAIL'),209);
                }   
            }
        }
    }

    public function delete()
    {
        $addr_id = intval($this->GP('addr_id'));
        if(!$detail = K::M('member/addr')->detail($this->GP('addr_id'))) {
           $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'),211);
        }else {
            if(K::M('member/addr')->delete($addr_id)){
                $this->msgbox->add(L('SUCCESS'));
            }else {
                $this->msgbox->add(L('FAIL'),212);
            }  
        }         
    } 

    public function add_map($addr_id)
    {
        $location = array();
        $location['addr_id'] = $addr_id;
        if($addr_id) {
            if($addr = K::M('member/addr')->detail($addr_id)) {
                $location['lng'] = $addr['lng'];
                $location['lat'] = $addr['lat'];
            }
        }
        $this->pagedata['location'] = $location;
        if($this->cookie->get('LANG') == 'zh_cn'){
            $this->tmpl = "ucenter/addr/map.html";
        }else if($this->cookie->get('LANG') == 'en_us'){
            $this->tmpl = "ucenter/addr/mapgoogle.html";
        }
    }

    public function set_default()
    {
        $addr_id = (int)$this->GP('addr_id');
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
            $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),211);
        }else {
            if(K::M('member/addr')->set_default($this->uid,$addr_id)) {
                $this->msgbox->add(L('SUCCESS'));
            }else {
                $this->msgbox->add(L('FAIL'),212);
            }
        }
    }
}
