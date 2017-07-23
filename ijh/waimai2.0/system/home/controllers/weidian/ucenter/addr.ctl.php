<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

/*收货地址*/
class Ctl_Weidian_Ucenter_Addr extends Ctl_Weidian
{
	// 收货地址列表
    public function items($page=1) 
    {
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/addr/items.html';  
    }

    public function create() 
    {
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/addr/create.html';       
    }

    // 添加地址保存设置
    public function create_save()
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
                $data['tag'] = $this->GP('tag') ? $this->GP('tag') : 0;
                if($addr_id = K::M('member/addr')->create($data)){
                    $this->msgbox->add('添加成功');
                }else {
                    $this->msgbox->add('添加失败',215);
                }
            }
        }else {
            $this->msgbox->add('联系人长度为6至18位字符',210);
        }
    }

    public function edit($addr_id)
    {
        if(!$detail = K::M('member/addr')->detail($addr_id)){
            $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid){
            $this->msgbox->add(L('非法操作'), 211);             
        }else {
            $this->pagedata['detail'] = $detail; 
            $this->pagedata['theme_style'] = $this->default_weidian_theme();
            $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/addr/edit.html';     
        }
    }

    // 修改收货地址保存设置
    public function edit_save() 
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
            $tag = $this->GP('tag');
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
                $data['tag'] = $tag;

                if(K::M('member/addr')->update($data['addr_id'],$data)){
                    $this->msgbox->add('修改成功');
                }else {
                    $this->msgbox->add('修改失败',209);
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
                $this->msgbox->add(L('操作成功'));
            }else {
                $this->msgbox->add(L('操作失败'),212);
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
                $backurl = $this->mklink('ucenter/addr/edit',array($addr_id));
            }
        }else{
            $backurl = $this->mklink('ucenter/addr/create');
        }
        $this->pagedata['backurl'] = $backurl;
        $this->pagedata['location'] = $location;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/addr/map.html';       
    }

    // 地图
    public function map()
    {
        $location['lng'] = $this->request['UxLocation']['lng'];
        $location['lat'] = $this->request['UxLocation']['lat'];
        $this->pagedata['location'] = $location;
        $this->pagedata['theme_style'] = $this->default_weidian_theme();
        $this->tmpl = 'weidian/'.$this->default_weidian_theme().'/ucenter/addr/map.html';   
    }

    public function set_default()
    {
        $addr_id = (int)$this->GP('addr_id');
        if(!$detail = K::M('member/addr')->detail($addr_id)) {
            $this->msgbox->add(L('地址不存在或已被删除'),210);
        }else if($detail['uid'] != $this->uid) {
            $this->msgbox->add(L('非法操作'),211);
        }else {
            K::M('member/addr')->set_default($this->uid,$addr_id);
            if(K::M('member/addr')->set_default($this->uid,$addr_id)) {
                $this->msgbox->add(L('操作成功'));
            }else {
                $this->msgbox->add(L('操作失败'),212);
            }
        }
    }
    
    public function ajax_addr_items()
    {
        $tags = K::M('member/addr')->get_tags(); 
        if($list = K::M('member/addr')->items(array('uid'=>$this->uid), array('addr_id'=>'desc'), 1, 5, $count)){
            foreach($list as $k=>$val){
                //1:公司,2:家,3:学校,4:其他
                if($val['tag'] == 1) {
                    $val['tag_class'] = 'tag_1';
                }else if($val['tag'] == 2) {
                    $val['tag_class'] = 'tag_2';
                }else if($val['tag'] == 3) {
                    $val['tag_class'] = 'tag_3';
                }else {
                    $val['tag_class'] = '';
                }
                $val['edit_url'] = $this->mklink('weidian/ucenter/addr/edit',array('args'=>$val['addr_id']));
                $val['tag_name'] = $tags[$val['tag']];
                $list[$k] = $val;
            } 
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',array('items'=>array_values($list)));  
    }
}
