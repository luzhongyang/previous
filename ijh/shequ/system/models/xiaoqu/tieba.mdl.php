<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Xiaoqu_Tieba extends Mdl_Table
{   
  
    protected $_table = 'xiaoqu_tieba';
    protected $_pk = 'tieba_id';
    protected $_cols = 'tieba_id,city_id,xiaoqu_id,uid,from,title,content,contact,mobile,price,likes,views,replys,lng,lat,lasttime,closed,clientip,dateline';
    protected $_orderby = array('lasttime'=>'DESC');
    
    protected function _format_row($row)
    {
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
   
    protected function _check($row, $tieba_id=null)
    {
        if(isset($row['lat'])){
            $row['lat'] = round(bcmul($row['lat'], 1000000));
        } 
        if(isset($row['lng'])){
            $row['lng'] = round(bcmul($row['lng'], 1000000));
        }     
        return parent::_check($row, $tieba_id);
    }
}