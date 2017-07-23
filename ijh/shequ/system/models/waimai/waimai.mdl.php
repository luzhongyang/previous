<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Waimai_Waimai extends Mdl_Table
{
    protected $_table = 'waimai';
    protected $_pk = 'shop_id';
    protected $_cols = 'shop_id,city_id,cate_id,title,banner,logo,declare,addr,views,orders,comments,praise_num,score,score_fuwu,score_kouwei,first_amount,min_amount,freight,pei_amount,pei_time,pei_distance,pei_type,yy_status,yy_stime,yy_ltime,yy_xiuxi,is_new,online_pay,youhui,info,delcare,pmid,verify_name,audit,closed,clientip,tmpl_type,dateline,phone,freight_stage,is_daofu,is_ziti,lat,lng,orderby';
    protected $_orderby = array('orderby'=>'ASC', 'praise_num'=>'DESC', 'orders'=>'DESC');
    protected function _format_row($row)
    {
        static $cate_list = null;
        if($cate_list === null){
            $cate_list = K::M('waimai/cate')->fetch_all();
        }
        if($city = K::M('data/city')->city($row['city_id'])){
            $row['city_name'] = $city['city_name'];
        }
        if($cate = $cate_list[$row['cate_id']]){
            $row['cate_title'] = $row['cate_name'] = $cate['title'];
        }
        if(!$row['logo']){
            $row['logo'] = 'default/shop_logo.png';
        }
        $youhui = $order_youhui = $youhui_title =  array();
        if($row['youhui']){
            foreach(explode(',', $row['youhui']) as $v){
                if($a = explode(':', $v)){
                    if($a[0] && $a[1]){
                        $order_youhui[$a[0]] = (int)$a[1];
                        $youhui_title[] = "满{$a[0]}减{$a[1]}";
                    }
                }
            }
            if($order_youhui){
                ksort($order_youhui);
                foreach($order_youhui as $k=>$v){
                    $youhui[] = array('order_amount'=>$k, 'youhui_amount'=>$v);
                }
            }
            
        }
        //处理freight_stage取最小值
        if($row['freight_stage'] = unserialize($row['freight_stage'])){
            foreach($row['freight_stage'] as $fk => $fv){
                $new_arr[$fv['fm']] = $fv['fm'];
            }
            ksort($new_arr);
            $row['freight_price'] = array_shift($new_arr);
            if(!$row['freight_price']){
                $row['freight_price'] = 0;
            }
            //处理freight_stage取最小值结束            
        }else{
            $row['freight_stage'] = array();
            $row['freight_price'] = 0;
        }
        if(!in_array($row['tmpl_type'], array('waimai', 'market'))){
            $row['tmpl_type'] = 'waimai';
        }
        $row['youhui_title'] = implode(',', $youhui_title);
        $row['order_youhui'] = $youhui;
        $row['lat'] = bcdiv($row['lat'], 1000000,6);
        $row['lng'] = bcdiv($row['lng'], 1000000,6);

        //增加营业时间状态
        if(1 == $row['yy_status']){
            $row['yysj_status'] = 1;
            $start_time = strtotime(date('Y-m-d ').$row['yy_stime']);
            $end_time = strtotime(date('Y-m-d ').$row['yy_ltime']);
            $now = time();

            if($now >= $start_time && $start_time && $now <= $end_time){
                //营业中
                $row['yysj_status'] = 1;
            }else{
                $row['yysj_status'] = 0;
            }
        }
        else{
            $row['yysj_status'] = 0;
        }



        return $row;
    }
    
    
    public function create($data)
	{
		if(!$data = $this->_check($data)){
			return false;
		}
		$data['dateline'] = __CFG::TIME;
        if($this->db->insert($this->_table, $data)){
            return true;
        }else{
            return false;
        }
	}
    
    public function where($filter=null, $pre='', $ANDOR='AND')
    {
        if(is_array($filter)){
            if(isset($filter['lat'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['lat'], $m)){
                    $filter['lat'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['lat'] = bcmul($filter['lat'], 1000000);
                }
            }
            if(isset($filter['lng'])){
                if(preg_match('/^([\-\d\.]+)~([\-\d\.]+)$/', $filter['lng'], $m)){
                    $filter['lng'] = bcmul($m[1], 1000000).'~' . bcmul($m[2], 1000000);
                }else{
                    $filter['lng'] = bcmul($filter['lng'], 1000000);
                }
            }                     
        }
        return parent::where($filter, $pre, $ANDOR);
    }
   
    protected function _check($row, $shop_id=null)
    {
        if(isset($row['passwd']) && !preg_match('/^[0-9a-f]{32}$/i', $row['passwd'])){
            if($shop_id && $row['passwd'] == '******'){
                unset($row['passwd']);
            }else{
                $row['passwd'] = md5($row['passwd']);
            }
        } 
        if(isset($row['mobile'])){
            $mobile = $row['mobile'];
            if($a = $this->shop($mobile, 'mobile')){
                if(empty($shop_id) || ($a['shop_id'] != $shop_id)){
                    $this->msgbox->add(L('手机号码已经存在'), 511);
                }
            }
        }
        if(isset($row['lat'])){
            $row['lat'] = round(bcmul($row['lat'], 1000000));
        } 
        if(isset($row['lng'])){
            $row['lng'] = round(bcmul($row['lng'], 1000000));
        }     
        return parent::_check($row, $shop_id);
    }
    public function update_pei_distance($shop_id,$arr_fkm)
    {
        $arr_fkm =(int) max($arr_fkm);
        $pei_distance = round($arr_fkm)>0?round($arr_fkm):10;
        $update = array(
            'pei_distance' => $pei_distance
        );
        $is_update = K::M('waimai/waimai')->update($shop_id,$update);
    }
}
