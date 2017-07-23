<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_Yezhu extends Ctl
{

    public function items($params)
    {
        $this->check_login();
        $filter = array('uid'=>$this->uid, 'closed'=>0);
        $filter['closed'] = 0;
        if($items = K::M('xiaoqu/yezhu')->items($filter, null, $page, $limit, $count)){
            $xiaoqu_ids = array();
            foreach($items as $k=>$v){
                $xiaoqu_ids[$v['xiaoqu_id']] = $v['xiaoqu_id'];
            }
            if($xiaoqu_list = K::M('xiaoqu/xiaoqu')->items_by_ids($xiaoqu_ids)){
                foreach($items as $k=>$v){
                    $v = $this->filter_fields('yezhu_id,xiaoqu_id,xiaoqu_title,uid,contact,mobile,house_louhao,house_danyuan,house_huhao,house_mianji,lng,lat,audit,dateline', $v);
                    if($row = $xiaoqu_list[$v['xiaoqu_id']]){
                        $v['xiaoqu_title'] = $row['title'];
                        $v['lng'] = $row['lng']; 
                        $v['lat'] = $row['lat']; 
                        $v['city_id'] = $row['city_id'];
                        $v['city_name'] = $row['city_name'];
                    }else{
                        $v['xiaoqu_title'] = '';
                        $v['lng'] = $v['lat'] ='';
                        $v['city_id'] = '0';
                        $v['city_name'] = '';
                    }
                    $items[$k] = $v;
                }
            }
        }
        $this->msgbox->set_data('data', array('items'=>array_values($items)));
    }

    public function create($params)
    {
        $this->check_login();
        $data = array();
        if(!$xiaoqu_id = (int)$params['xiaoqu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('小区不存在或已经删除', 212);
        }else if(!$data['house_louhao'] = $params['house_louhao']){
            $this->msgbox->add('楼号不能为空', 213);
        }else if(!$data['house_danyuan'] = $params['house_danyuan']){
            $this->msgbox->add('单元不能为空', 214);
        }else if(!$data['house_huhao'] = $params['house_huhao']){
            $this->msgbox->add('户号不能为空', 215);
        }else{
            if(isset($params['contact'])){
                $data['contact'] = $params['contact'];
            }
            if(isset($params['mobile'])){
                if(!$mobile = K::M('verify/check')->mobile($params['mobile'])){
                    $this->msgbox->add('联系电话必须为手机号码', 216)->response();
                }
                $data['mobile'] = $mobile;
            }
            $data['xiaoqu_id'] = $xiaoqu_id;
            $data['uid'] = $this->uid;
            if($yezhu_id = K::M('xiaoqu/yezhu')->create($data)){
                $this->msgbox->set_data('data', array('yezhu_id'=>$yezhu_id));
            }
        }
    }

    public function edit($params)
    {
        $this->check_login();
        $data = array();
        if(!$yezhu_id = (int)$params['yezhu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add($yezhu_id.'---数据不存在或已经删除', 212);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限修改入住信息', 213);
        }else if(!$data = $this->check_fields($params, 'xiaoqu_id,house_louhao,house_danyuan,house_huhao,contact,mobile')){
            $this->msgbox->add('非法的数据提交', 214);
        }else if(K::M('xiaoqu/yezhu')->update($yezhu_id, $data)){
            $this->msgbox->set_data('data', array('yezhu_id'=>$yezhu_id));
        }
    }

    public function delete($params)
    {
        $this->check_login();
        $data = array();
        if(!$yezhu_id = (int)$params['yezhu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限修改入住信息', 213);
        }else if(K::M('xiaoqu/yezhu')->delete($yezhu_id)){
            $this->msgbox->set_data('data', array('yezhu_id'=>$yezhu_id));
        }
    } 
}
