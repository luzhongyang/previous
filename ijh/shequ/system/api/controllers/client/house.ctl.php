<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Client_House extends Ctl
{
    protected $_allow_fields = 'staff_id,city_id,city_name,from,from_title,name,mobile,face,orders,score,avg_score,comments,lat,lng,verify_name,status,intro,juli,juli_label';
    //家政分类
    public function cate()
    {
        $cate = K::M('house/cate')->select(array('parent_id'=>0));
        $unit = K::M('data/unit')->unit_list();
        foreach($cate as $k => $v){
            $cate[$k]['unit'] = $unit[$cate[$k]['unit']];
            $cate[$k]['products'] = K::M('house_cate')->select(array('parent_id'=>$v['cate_id']));
            $cate[$k]['products'] = array_values($cate[$k]['products']);
            foreach($cate[$k]['products'] as $kk => $vv){
                $cate[$k]['products'][$kk]['unit'] = $unit[$cate[$k]['products'][$kk]['unit']];
            }
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('items'=>array_values($cate)));
    }


    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }

    // 家政-附近服务人员（地图模式）
    public function map($params)
    {
        $items = $filter = array();
        if(!$params['leftbottomlng'] || !$params['righttoplat'] || !$params['leftbottomlat'] || !$params['righttoplng']){
            $this->msgbox->add('经度纬度不完整',211);
        }else{
            $filter['lat'] = $params['leftbottomlat'].'~'.$params['righttoplat'];
            $filter['lng'] = $params['leftbottomlng'].'~'.$params['righttoplng'];
            $filter['from'] = 'house';
            $filter['status'] = 1;
            if($items = K::M('staff/staff')->items($filter,null,1,500,$count)){
                $ii = 0;
                foreach($items as $k=>$v){
                    $items[$k] = $this->filter_fields($this->_allow_fields, $v);
                    $ii++;
                }
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items' => array_values($items),'count'=>$ii));
            }else{
                $this->msgbox->add('success');
                $this->msgbox->set_data('data', array('items' => array()));
            }
       
        }
    }

    //家政阿姨列表，重构 by shzhrui 2016-08-06 14:40
    public function items($params)
    {
        $_LNG = $params['lng'];
        $_LAT = $params['lat'];
        if(!$_LNG || !$_LAT){
            $_LNG = __LNG;
            $_LAT = __LAT;
        }
        if(!$_LNG || !$_LAT){
            $this->msgbox->add('经度纬度不完整',211);
        }else{
            $filter = $orderby = $items = array();
            //$filter = array('from'=>'house', 'closed'=>0, 'audit'=>1, 'verify_name'=>1);
            $filter = array('from'=>'house', 'closed'=>0, 'audit'=>1);
            // {{{####
            $squares = K::M('helper/round')->returnSquarePoint($_LNG, $_LAT);//使用此函数计算得到结果
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            // ####}}}
            if($cate_id = $params['cate_id']){
                if($cate_ids = K::M('house/cate')->children_ids($cate_id)){
                    $filter['house']['cate_id'] = $cate_ids;
                }
            }
            $limit = $_limit = 10;
            $page = $_page = max((int)$params['page'], 1);
            if($params['orderby'] == 's' || $params['orderby'] == 'score'){
                $orderby['score'] = 'DESC';
            }else if($params['orderby'] == 'o' || $params['orderby'] == 'order'){
                $orderby['orders'] = 'DESC';
            }else if($params['orderby'] == 'd' || $params['orderby'] == 'juli'){
                $_page = 1;
                $_limit = 100;
            }
            
            if(($page < 10) && ($staff_list = K::M('staff/staff')->staff_items($filter, $orderby, $_page, $_limit, $count))){
                foreach($staff_list as $k=>$v){
                    $v['juli'] = K::M('helper/round')->juli($v['lng'], $v['lat'], $_LNG, $_LAT);  // 用户与商户的距离米
                    $v['multi_score']  = $v['avg_score'];
                    $staff_list[$k] = $v;
                }
                if($params['orderby'] == 'd' || $params['orderby'] == 'juli'){
                    uasort($staff_list, array($this, 'juli_order'));
                    $items = array_slice($staff_list, ($page-1)*10, 10, true);
                }else{
                    $items = $staff_list;
                }
                $staff_ids = array();
                foreach($items as $k=>$v){
                    $v = $this->filter_fields($this->_allow_fields, $v);
                    $staff_ids[$v['staff_id']] = $v['staff_id'];
                    $v['attr'] = array();
                    $v['juli_label'] = K::M('helper/format')->juli($v['juli']);
                    $v['juli'] = $v['juli_label']; //兼容APP 重新赋值 juli字段                    
                    $items[$k] = $v;
                }                
                if($attr_list = K::M('house/attr')->items(array('staff_id'=>$staff_ids), null, 1, 100)){
                    foreach($attr_list as $k=>$v){
                        if($items[$v['staff_id']]){
                            $items[$v['staff_id']]['attr'][] = $v;
                        }
                    }
                }
            }
            $this->msgbox->set_data('data', array('items' => array_values($items)));
        }
    }

    //服务人员详情
    public function staffdetail($params)
    {
        if(!$params['lat'] || !$params['lng']){
            $this->msgbox->add('经纬度不完整',210);
        }else if(!$staff_id = $params['staff_id']){
            $this->msgbox->add('错误的服务人员',211);
        }else if(!$detail = K::M('staff/staff')->detail($staff_id)){
            $this->msgbox->add('错误的服务人员',212);
        }else{
            $detail = $this->filter_fields($this->_allow_fields, $detail);
            $unit = K::M('data/unit')->unit_list();
            $attr = K::M('house/attr')->items(array('staff_id'=>$detail['staff_id']));
            foreach($attr as $k => $v){
                $attr[$k] = K::M('house/cate')->detail($v['cate_id']);
                $attr[$k]['unit'] = $unit[$attr[$k]['unit']];
            }
            $attr = array_values($attr);

            //评价
            $comments = K::M('staff/comment')->select(array('staff_id'=>$detail['staff_id']));

            $i = $a = $b = $c = 0;
             foreach($comments as $kk => $vv){
                $u = K::M('member/member')->detail($vv['uid']);
                $comments[$kk]['staff_name'] = $u['nickname'];
             }

            foreach($comments as $kk => $vv){
                if($vv['score'] > 3){
                    $a = $a + 1;
                }else if($vv['score'] == 3){
                    $b = $b + 1;
                }else if($vv['score'] < 3){
                    $c = $c + 1;
                }
                $i=$i+1;
            }

            $count = array(
                'i'=>$i,
                'a'=>$a,
                'b'=>$b,
                'c'=>$c
            );

            if($params['uid']){
               if($collect = K::M('member/collect')->find(array('uid'=>$params['uid'],'type'=>2,'can_id'=>$params['staff_id']))){
                   if($collect['status'] == 1){
                      $detail['collect'] = 0;
                   }elseif($collect['status'] == 0){
                      $detail['collect'] = 1;
                   }
               }else{
                   $detail['collect'] = 0;
               }
            }else{
                $detail['collect'] = 0;
            }

            $detail['juli'] = K::M('helper/round')->getdistance(__LNG, __LAT, $detail['lng'], $detail['lat']);  //距离
            $detail['juli_label'] = K::M('helper/format')->juli($detail['juli']);
            //分享数组
            $cfg = $this->system->config->get('attach');
            $share = array(
                'share_url'=>$this->mklink('house/staffdetail', array($staff_id), null, 'www'),
                'share_title'=> $detail['name'],
                'share_photo'=>$cfg['attachurl'].'/'. $detail['face'],
                'share_content'=>$detail['name']
            );
            
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('count'=>$count,'attr'=>$attr,'detail'=>$detail,'share'=>$share));

        }


    }


    public function staffcomment($params)
    {

        $filter = array();
        if(!$staff_id = $params['staff_id']){
            $this->msgbox->add('错误的服务人员',211);
        }else if(!$detail = K::M('staff/staff')->detail($staff_id)){
            $this->msgbox->add('错误的服务人员',212);
        }else{
            $filter['staff_id'] = $detail['staff_id'];
            if($params['type'] == 1){
                $filter['score'] = '>:3';
            }else if($params['type'] == 2){
                $filter['score'] = 3;
            }else if($params['type'] == 3){
                $filter['score'] = '<:3';
            }
            $page = max((int)$params['page'], 1);
            $items = K::M('staff/comment')->items($filter, array('comment_id'=>'desc'), $page, 20,$count);
            foreach($items as $k => $v){
                $m = K::M('member/member')->detail($v['uid']);
                $items[$k]['nickname'] = $m['nickname'];
            }
            if(!$items){
                $items = array();
            }

            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items'=>array_values($items)));
        }

    }



    public function detail($params)
    {
        if(!$cate_id = $params['cate_id']){
            $this->msgbox->add('没有分类!',211);
        }
        $cate = K::M('house/cate')->detail($cate_id);
        $unit = K::M('data/unit')->unit_list();
        $this->msgbox->add('success');
        $this->msgbox->set_data('data',$cate);
    }

}
