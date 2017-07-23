<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Weixiu extends Ctl
{

    public function index($cate_id,$new)
    {
        $cate = $this->get_cate();
        $this->tmpl = 'weixiu/index.html';
    }
    
    public function map($cate_id){
        $this->pagedata['cate_id']= $cate_id;
        $this->tmpl = 'weixiu/map.html';
    }
    
    private function get_cate(){
        $cate = K::M('weixiu/cate')->select(array('parent_id'=>0));
        foreach($cate as $k => $v){
            $cate[$k]['products'] = K::M('weixiu_cate')->select(array('parent_id'=>$v['cate_id']));
        }
        $this->pagedata['cates']= $cate;
    }

    public function items($cate_id){

        $cate_list = K::M('weixiu/cate')->select();
        $this->pagedata['cate_list']= $cate_list;
        $orderby = array();
        $lng = $this->GP('lng');
        $lat = $this->GP('lat');
        if(!$lng || !$lat){
            $lng = $this->request['UxLocation']['lng'];
            $lat = $this->request['UxLocation']['lat'];
        }

        if($lng && $lat){
            $page = max((int)$this->GP('page'), 1);
            $filter = array('audit'=>1,'closed'=>0,'status'=>0);
            $filter['weixiu']['cate_id'] = $cate_id;
            $filter['from'] = "weixiu";
            //$limit = 500;
            $squares = K::M('helper/round')->returnSquarePoint($lng, $lat);//使用此函数计算得到结果
            $filter['lat'] = $squares['left-bottom']['lat'].'~'.$squares['right-top']['lat'];
            $filter['lng'] = $squares['left-bottom']['lng'].'~'.$squares['right-top']['lng'];
            
            if($staff = K::M('staff/staff')->staff_items($filter,null,$page,500,$count)){
                foreach($staff as $ks => $vs){  //从ID列表得出的结果中筛选出身边的配送员
                    $staff[$ks]['juli'] = K::M('helper/round')->juli($vs['lng'], $vs['lat'], $lng, $lat);  //距离
                    $staff[$ks]['juli_label'] = K::M('helper/format')->juli($staff[$ks]['juli']);
                    $staff[$ks]['avg_score'] = ($vs['score']/$vs['comments']) ? round($vs['score']/$vs['comments'],2) : 0 ;
                }
                if($this->GP('order') == 'juli'){
                    uasort($staff, array($this, 'juli_order'));
                }else if($this->GP('order') == 'score'){
                    uasort($staff, array($this, 'score_order'));
                }                
                $items = array_slice($staff, ($page-1)*10, 10, true);
            }else{
                 $items = array();
            }
            $staff_ids = array(); 
            foreach($items as $k=>$v){
                $staff_ids[$v['staff_id']] = $v['staff_id'];
            }
            $attrs = K::M('weixiu/attr')->items(array('staff_id'=>$staff_ids));
            foreach($items as $k=>$v){
                foreach($attrs as $k1=>$v1){
                    if($v1['staff_id'] == $v['staff_id']){
                        $items[$k]['attr'][] = $v1;
                    }
                }
            }
        }
        $cate = K::M('weixiu/cate')->detail($cate_id);
        $this->pagedata['cate']= $cate;

        $this->pagedata['staff']= $items;
        
        $this->tmpl = 'weixiu/items.html';
    }

    protected function score_order($a, $b)
    {
         if ($a['avg_score'] == $b['avg_score']) {
            return 0;
        }
        return ($a['avg_score'] < $b['avg_score']) ? 1 : -1;       
    }
    
    protected function juli_order($a, $b)
    {
        if ($a['juli'] == $b['juli']) {
            return 0;
        }
        return ($a['juli'] < $b['juli']) ? -1 : 1;
    }
    
    public function search(){
        $this->tmpl = 'weixiu/search.html';
    }

    
    public function staff_detail($staff_id){  //服务人员详情
        
        $detail = K::M('staff/staff')->detail($staff_id);

        $attr = K::M('weixiu/attr')->items(array('staff_id'=>$detail['staff_id'],null,500));
        foreach($attr as $k => $v){
            $attr[$k]['cate'] = K::M('weixiu/cate')->detail($v['cate_id']);
        }
        $unit = K::M('data/unit')->unit_list();
        $this->pagedata['unit'] = $unit;
        
        
        //评价
        $comments = K::M('staff/comment')->select(array('staff_id'=>$detail['staff_id']));
        $commentsa = $commentsb = $commentsc = array();

        
        $i = $a = $b = $c = 0;
         foreach($comments as $kk => $vv){
            $u = K::M('member/member')->detail($vv['uid']);
            echo $u['nickname'];
            $comments[$kk]['staff_name'] = $u['nickname'];
         }

        foreach($comments as $kk => $vv){
            if($vv['score'] > 3){
                $commentsa[] = $vv;
                $a = $a + 1;
            }else if($vv['score'] == 3){
                $commentsb[] = $vv;
                $b = $b + 1;
            }else if($vv['score'] < 3){
                $commentsc[] = $vv;
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
        
        $detail['collect'] = 0;
        if($this->uid) {
            if(K::M('member/collect')->count(array('uid'=>$this->uid,'type'=>2,'can_id'=>$staff_id,'status'=>1))){
                $detail['collect'] = 1;
            }
        }
        
        $this->pagedata['comments'] = $comments;
        $this->pagedata['commentsa'] = $commentsa;
        $this->pagedata['commentsb'] = $commentsb;
        $this->pagedata['commentsc'] = $commentsc;
        $this->pagedata['count'] = $count;

        $this->pagedata['attr']= $attr;
        $this->pagedata['detail']= $detail;
        $this->tmpl = 'weixiu/staff_detail.html';
        
    }


    
    public function detail($cate_id){  //服务详情
        
        $cate = K::M('weixiu/cate')->detail($cate_id);
        $this->pagedata['cate'] = $cate;
        $unit = K::M('data/unit')->unit_list();
        $this->pagedata['unit'] = $unit;
        $this->tmpl = 'weixiu/detail.html';
        
    }
    

    
    public function getstaffpoi(){
        $items = $filter = array();
        $SouthWlng = $this->GP('SouthWlng');
        $SouthWlat = $this->GP('SouthWlat');
        $NorthElng = $this->GP('NorthElng');
        $NorthElat = $this->GP('NorthElat');
        if(!$SouthWlng || !$SouthWlat || !$NorthElng || !$NorthElat){
            $this->msgbox->add('经度纬度不完整',211);
        }else{
            $filter['lat'] = $SouthWlat.'~'.$NorthElat;   //左下纬度和右上纬度
            $filter['lng'] = $SouthWlng.'~'.$NorthElng;   //左下经度和右上经度
            $filter['from'] = 'weixiu';
            $filter['closed'] = 0;
            $filter['status'] = 1;
            $items = K::M('staff/staff')->items($filter,null,1,500);
            foreach ($items as $k=>$val){
                $items[$k] = $this->filter_fields('staff_id,lat,lng', $val);
            }
            $count = count($items);
            if(empty($items)){
                $items = array();
            }
            $this->msgbox->add('success');
            $this->msgbox->set_data('data', array('items' => $items,'count'=>$count));
            $this->msgbox->response();
            
            
        }
    }
    
  

}