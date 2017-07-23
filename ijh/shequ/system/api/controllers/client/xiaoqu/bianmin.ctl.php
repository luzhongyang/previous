<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_Bianmin extends Ctl
{


    
    public function items($params)
    {
        if(!$xiaoqu_id = (int)$params['xiaoqu_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$xiaoqu = K::M('xiaoqu/xiaoqu')->detail($xiaoqu_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else{
            $page = max((int)$params['page'], 1);
            $limit = 20;
            if($items = K::M('xiaoqu/bianmin')->items(array('xiaoqu_id'=>$xiaoqu_id), null, $page, $limit, $count)){
                foreach($items as $k=>$v){
                    $v = $this->filter_fields('bianmin_id,cate_id,cate_title,xiaoqu_id,title,intro,addr,lng,lat,phone,views,dateline', $v);
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }


    //查看便民商家，同时会更新使用次数字段
    public function detail($params)
    {
        if(!$bianmin_id = (int)$params['bianmin_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$bianmin = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else{
            K::M('xiaoqu/bianmin')->update_count($bianmin_id, 'views', 1);
            $data = $this->filter_fields('bianmin_id,cate_id,cate_title,xiaoqu_id,title,intro,addr,lng,lat,phone,views,dateline', $bianmin);
			if(CLIENT_OS == 'ANDROID'){
				$data['_addr'] = $data['addr'];
				unset($data['addr']);
			}
            $this->msgbox->set_data('data', $data);
        }
    }

    //投诉便民商家
    public function report($params)
    {
        $this->check_login();
        if(!$bianmin_id = (int)$params['bianmin_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$bianmin = K::M('xiaoqu/bianmin')->detail($bianmin_id)){
            $this->msgbox->add('数据不存在或已经删除', 212);
        }else if(!$yezhu_id = (int)$params['yezhu_id']){
            $this->msgbox->add('参数不正确', 213);
        }else if(!$yezhu = K::M('xiaoqu/yezhu')->detail($yezhu_id)){
            $this->msgbox->add('您不是该小区业主,不能投诉', 214);
        }else if($yezhu['uid'] != $this->uid){
            $this->msgbox->add('您不是该小区业主,不能投诉', 215);
        }else if(!$title = $params['title']){
            $this->msgbox->add('投诉标题不能空', 213);
        }else if(!$content = $params['content']){
            $this->msgbox->add('投诉内容不能空', 213);
        }else{
            $data = array('bianmin_id'=>$bianmin_id, 'yezhu_id'=>$yezhu_id, 'uid'=>$this->uid, 'xiaoqu_id'=>$yezhu['xiaoqu_id']);
            $data['title'] = $title;
            $data['content'] = $content;
            if($report_id = K::M('xiaoqu/bianmin/report')->create($data)){
                $this->msgbox->set_data('data', array('report_id'=>$report_id));
            }
        }        
    }

    public function reportType($params)
    {
        $items = array('资料做假', '恶意骚扰，不文明用语', '服务态度差', '漫天要价', '随便填吧');
		if(CLIENT_OS == 'ANDROID'){
			$this->msgbox->set_data('data', array('_items'=>array_values($items)));
		}else{
			$this->msgbox->set_data('data', array('items'=>array_values($items)));
		}
    }
}
