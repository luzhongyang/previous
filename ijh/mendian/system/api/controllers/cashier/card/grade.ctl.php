<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Cashier_Card_Grade extends Ctl_Cashier
{
    
    public function items($params)
    {
        if(!$items = K::M('card/grade')->items_by_shop_id($this->shop_id)){
            $items = array();
        }
        $this->msgbox->set_data(array('items'=>array_values($items)));
    }

    public function create($params)
    {
        $this->check_owner();
        if(!$data = $this->check_fields($params, 'title,need_money,orderby,discount')){
            $this->msgbox->add('非法的数据提交', 211);
        }else{
            $data['shop_id'] = $this->shop_id;
            if($grade_id = K::M('card/grade')->create($data)){
                $this->msgbox->set_data(array('grade_id'=>$grade_id));
            }
        } 
    }

    public function edit($params)
    {
        $this->check_owner();
        if(!$grade_id = (int)$params['grade_id']){
            $this->msgbox->add('参数错误', 211);
        }else if(!$data = $this->check_fields($params, 'title,need_money,orderby,discount')){
            $this->msgbox->add('非法的数据提交', 212);
        }else if(K::M('card/grade')->update($grade_id, $data)){
            $this->msgbox->set_data(array('grade_id'=>$grade_id));
        }
    }

    public function delete($params)
    {
        $this->check_owner();
        if(!$ids = K::M('verify/check')->ids(trim($params['grade_id'],','))){
            $this->msgbox->add(L('请求参数错误'), 211);
        }else if(!$items = K::M('card/grade')->items_by_ids($ids)){
            $this->msgbox->add(L('未指删除的会员卡类型'), 212);
        }else{
            $del_ids = array();
            foreach($items as $k=>$v){
                if($v['shop_id'] == $this->shop_id){
                    $del_ids[$v['grade_id']] = $v['grade_id'];
                } 
            }
            if($del_ids){
                if(K::M('card/card')->count(array('grade_id'=>$del_ids,'closed'=>0))){
                    $this->msgbox->add('删除会员卡需要先删除该卡下面的会员', 213);
                }else{
                    K::M('card/grade')->delete($del_ids);
                    $this->msgbox->add('success');
                }
            }else{
                $this->msgbox->add('没有要删除的会员卡类型', 214);
            }
        }
    }
}