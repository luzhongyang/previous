<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_Baoxiu extends Ctl
{

    public function items($params)
    {
        $this->check_login();
        if(!$yezhu_id = (int)$params['yezhu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您不是该小区业主', 214);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您不是该小区业主', 215);
        }else{
            $limit = 10;
            $page = max((int)$params['page'], 1);
            if($items = K::M('xiaoqu/baoxiu')->items(array('yezhu_id'=>$yezhu_id,'closed'=>0), array('baoxiu_id'=>'DESC'), $page, $limit, $count)){
                $baoxiu_ids = array();
                foreach($items as $k=>$v){
                    $baoxiu_ids[$v['baoxiu_id']] = $v['baoxiu_id'];
                    $v = $this->filter_fields('baoxiu_id,uid,xiaoqu_id,yezhu_id,contact,mobile,yuyue_time,content,reply,reply_time,tx_time,status,dateline', $v);
                    if(CLIENT_OS == 'ANDROID'){
                        $v['_photos'] = array();
                    }else{
                        $v['photos'] = array();
                    }
                    $items[$k] = $v;
                }
                if($photo_list = K::M('xiaoqu/baoxiu/photo')->items(array('baoxiu_id'=>$baoxiu_ids), null, 1, 100)){
                    foreach($photo_list as $k=>$v){                        
                        if(CLIENT_OS == 'ANDROID'){
                            $items[$v['baoxiu_id']]['_photos'][] = $v['photo'];
                        }else{
                            $items[$v['baoxiu_id']]['photos'][] = $v['photo'];
                        }
                    }
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }


    public function create($params)
    {
        $this->check_login();
        if(!$yezhu_id = (int)$params['yezhu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您不是该小区业主', 214);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作', 215);
        }else if(!$data = $this->check_fields($params, 'yuyue_date,contact,mobile,content')){
            $this->msgbox->add('参数不正确', 216);
        }else{
            $data['yezhu_id'] = $yezhu_id;
            $data['uid'] = $this->uid;
            $data['xiaoqu_id'] = $yezhu['xiaoqu_id'];
            if($data['yuyue_date']){
                $data['yuyue_date'] = strtotime(date('Y-').$data['yuyue_date'].':00');
            }
            if($baoxiu_id = K::M('xiaoqu/baoxiu')->create($data)){
                if($attachs = $_FILES){
                    foreach($attachs as $attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = K::M('magic/upload')->upload($attach, 'xiaoqu')){
                                K::M('xiaoqu/baoxiu/photo')->create(array('baoxiu_id'=>$baoxiu_id, 'photo'=>$a['photo']));
                            }
                        }
                    }
                }
                $this->msgbox->set_data('data', array('baoxiu_id'=>$baoxiu_id));
            }
        }
    }

    public function cancel($params)
    {
        $this->check_login();
        if(!$baoxiu_id = (int)$params['baoxiu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$baoxiu = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else if($baoxiu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作', 213);
        }else if($baoxiu['status'] < 0){
            $this->msgbox->add('保修已经撤销', 214);
        }else if($baoxiu['status'] > 0){
            $this->msgbox->add('保修已经完成不可撤销', 215);
        }else if(K::M('xiaoqu/baoxiu')->update($baoxiu_id, array('status'=>'-1'))){
            $this->msgbox->set_data('data', array('baoxiu_id'=>$baoxiu_id));
        }      
    }

    public function delete($params)
    {
        $this->check_login();
        if(!$baoxiu_id = (int)$params['baoxiu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$baoxiu = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else if($baoxiu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作', 213);
        }else if(K::M('xiaoqu/baoxiu')->delete($baoxiu_id)){
            $this->msgbox->set_data('data', array('baoxiu_id'=>$baoxiu_id));
        }      
    }

    public function tixing($params)
    {
        $this->check_login();
        if(!$baoxiu_id = (int)$params['baoxiu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$baoxiu = K::M('xiaoqu/baoxiu')->detail($baoxiu_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else if($baoxiu['uid'] != $this->uid){
            $this->msgbox->add('您没有权限操作', 213);
        }else if($baoxiu['status'] < 0){
            $this->msgbox->add('保修已经撤销', 214);
        }else if($baoxiu['status'] > 0){
            $this->msgbox->add('保修已经处理', 215);
        }else if(K::M('xiaoqu/baoxiu')->update($baoxiu_id, array('tx_time'=>__TIME))){
            $this->msgbox->set_data('data', array('baoxiu_id'=>$baoxiu_id));
        }      
    }
}
