<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Client_Member_Collect extends Ctl
{
    protected $_allow_shop_fields = 'shop_id,city_id,contact,cate_id,cate_title,mobile,phone,title,have_waimai,have_tuan,have_quan,have_maidan,lng,lat,banner,logo,score,business_id,area_id,addr,avg_amount,comments,max_youhui,intro,info,verify_name,tmpl_type';
    protected $allow_staff_fields = 'staff_id,city_id,city_name,from,from_title,name,mobile,face,orders,score,comments,lat,lng,verify_name,status,intro,tags,attr';
    /* 收藏列表
    * @param $type,收藏类型,1:店铺,2:人员
    */
    public function items($params)
    {
        $this->check_login();
        $filter = $items = array();
        $page = max((int)$params['page'], 1);
        $limit = 10;
        if(!$type=$params['type']){
           $this->msgbox->add('参数不正确', 200);
        }else if(!in_array($type, array(1,2,3))){
           $this->msgbox->add('参数不正确', 210);
        }else{
            if($collect_list = K::M("member/collect")->items(array('uid'=>$this->uid, 'type'=>$type), array('collect_id'=>'DESC'), $page, $limit, $count)){
                $can_ids = array();
                foreach($collect_list as $v){
                    $can_ids[$v['can_id']] = $v['can_id'];
                }
                if($type == 1){
                    if($items = $this->shop($can_ids)){
                        $_LNG = $params['lng'];
                        $_LAT = $params['lat'];
                        if($_LNG || $_LAT){
                            $_LNG = __LNG;
                            $_LAT = __LAT;
                        }
                        foreach($items as $k=>$v){
                            $v = $this->filter_fields($this->_allow_shop_fields, $v);
                            $v['juli'] = K::M('helper/round')->juli($v['lng'], $v['lat'], $_LNG, $_LAT);
                            $v['juli_label'] = K::M('helper/format')->juli($v['juli']);
                            $items[$k] = $v;
                        }
                    }
                }else if($type == 2){
                    if($items = $this->staff($can_ids)){
                        foreach($items as $k=>$v){
                            $v = $this->filter_fields($this->allow_staff_fields, $v);
                            $items[$k] = $v;
                        } 
                    }
                }
            }
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
        }
    }
   /* 添加收藏
    * @param $type int,类型
    * @param $can_id int，
    */
    public function add($params)
    {
        $this->check_login();
        if(!$type = $params['type']){
           $this->msgbox->add('参数不正确', 211);
        }else if(!$can_id = $params['can_id']){
           $this->msgbox->add('参数不正确', 212);
        }else if($collect = K::M('member/collect')->detail_by_collect($this->uid, $can_id, $params['type'])){
            $this->msgbox->add('您已经收藏过', 213);
        }else{
            $data = array(
               'uid'   => $this->uid,
               'type'  => $type,
               'can_id'=> $can_id,
               'dateline'=>__TIME,
               'status' => 1
            );
            if($collect_id = K::M('member/collect')->create($data)){
               $this->msgbox->add('收藏内容成功');
               $this->msgbox->set_data('data', array('status'=>1, 'collect_id'=>$collect_id));
            }
        }
    }
    /* 取消收藏
     * $param type
     * $param can_id
     */
    public function cancel($params)
    {
        $this->check_login();
        if(!$type = $params['type']){
           $this->msgbox->add('参数不正确', 211);
        }elseif(!$can_id = $params['can_id']){
          $this->msgbox->add('参数不正确', 212);
        }else if(K::M('member/collect')->removeRow($type, $can_id, $this->uid)){
            $this->msgbox->add('取消收藏成功');
        }else{
            $this->msgbox->add('未知错误', 213);
        }
    }
    /**
     * 收藏状态
     * @param $type,1:店铺,2:人员
     * @param $can_id
     */
    public function collect_status($params)
    {
        $this->check_login();
        if(!$type = $params['type']){
          $this->msgbox->add('参数不正确',200);
        }else if(!$can_id = $params['can_id']){
          $this->msgbox->add('参数不正确',201);
        }else{
            $return = array();
            if(K::M('member/collect')->count(array('uid'=>$this->uid, 'type'=>$type, 'can_id'=>$can_id))){
                $return['collect_status'] = 1;//已收藏
            }else{
                $return['collect_status'] = 0;//未收藏
            }
            $this->msgbox->set_data('data', $return);
        }
    }

    /* 人员被收藏
     */
    private function staff($staff_ids)
    {
        if($staff_list = K::M('staff/staff')->items_by_ids($staff_ids)){
            $house_attr_list  = K::M('house/attr')->items(array('staff_id'=>$staff_ids));
            $weixiu_attr_list  = K::M('weixiu/attr')->items(array('staff_id'=>$staff_ids));
            foreach($staff_list as $k=>$v){
                $v['tags'] = $v['attr'] = array();
                $staff_list[$k] = $v;
            }
            foreach($house_attr_list as $k=>$v){
                if($staff_list[$v['staff_id']]){
                    $staff_list[$v['staff_id']]['tags'][] = $v['cate_title'];
                }
            }
            foreach($weixiu_attr_list as $k=>$v){
                if($staff_list[$v['staff_id']]){
                    $staff_list[$v['staff_id']]['tags'][] = $v['cate_title'];
                }
            }
        }else{
            $staff_list = array();
        }
        return $staff_list;
    }
    
    /* 店铺 */
    private function shop($shop_ids)
    {
        return K::M('shop/shop')->items_by_ids($shop_ids);
    }
}
