<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Xiaoqu extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu';
    protected $_pk = 'xiaoqu_id';
    protected $_cols = 'xiaoqu_id,city_id,wuye_id,area_id,title,addr,lat,lng,orderby,phone,audit,closed,dateline';
    protected $_orderby = array('xiaoqu_id'=>'DESC');
    protected function _format_row($row)
    {
        static $city_list = null;
        if($city_list === null){
            $city_list = K::M('data/city')->fetch_all();
        }
        $row['city_name'] = $city_list[$row['city_id']]['city_name'];
        $row['lat'] = bcdiv($row['lat'], 1000000,6);
        $row['lng'] = bcdiv($row['lng'], 1000000,6);
        return $row;
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
   
    protected function _check($row, $xiaoqu_id=null)
    {
        if(isset($row['lat'])){
            $row['lat'] = round(bcmul($row['lat'], 1000000));
        } 
        if(isset($row['lng'])){
            $row['lng'] = round(bcmul($row['lng'], 1000000));
        }     
        return parent::_check($row, $xiaoqu_id);
    }
    
    public function create($data, $checked=false)
    {
        $data['orderby'] = 1;
        $data['audit'] = 0;
        $data['closed'] = 0;
        $data['dateline'] = $data['dateline'] ? $data['dateline'] : __TIME;
        return $this->db->insert($this->_table, $data);
    }
}