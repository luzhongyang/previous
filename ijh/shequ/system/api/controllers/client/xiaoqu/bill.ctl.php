<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_Xiaoqu_Bill extends Ctl
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
            $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
            if($items = K::M('xiaoqu/bill')->items(array('yezhu_id'=>$yezhu_id, 'closed'=>0), array('bill_id'=>'DESC'), $page, $limit, $count)){
                $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
                $wuye = K::M('xiaoqu/xiaoqu')->detail($xiaoqu['wuye_id']);
                foreach($items as $k=>$v){
                    $v['bill_title'] = date("Y年m月账单", strtotime($v['bill_sn']));
                    $v['xiaoqu_title'] = $xiaoqu['title'];
                    $v['yezhu_name'] = $yezhu['contact'];
                    $v['yezhu_house'] = $yezhu['house'];
                    $v['wuye_name'] = $wuye['title'];
                    $items[$k] = $v;
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items), 'total_count'=>$count));
        }
    }

    public function detail($params)
    {
        $this->check_login();
        if(!$bill_id = (int)$params['bill_id']){
            $this->msgbox->add('参数不正确', 211);
        }else if(!$bill = K::M('xiaoqu/bill')->detail($bill_id)){
            $this->msgbox->add('帐单不存在或已经删除', 214);
        }else if($bill['uid'] != $this->uid){
            $this->msgbox->add('您没有权限', 215);
        }else{
            $yezhu = K::M('xiaoqu/yezhu')->detail($bill['yezhu_id']);
            $xiaoqu = K::M('xiaoqu/xiaoqu')->detail($yezhu['xiaoqu_id']);
            $wuye = K::M('xiaoqu/xiaoqu')->detail($xiaoqu['wuye_id']);
            $bill['xiaoqu_title'] = $xiaoqu['title'];
            $bill['yezhu_name'] = $yezhu['contact'];
            $bill['yezhu_house'] = $yezhu['house'];
            $bill['wuye_name'] = $wuye['title'];
            $bill['bill_title'] = date("Y年m月账单", strtotime($bill['bill_sn']));
            $this->msgbox->set_data('data', $bill);
        }
    }

}
