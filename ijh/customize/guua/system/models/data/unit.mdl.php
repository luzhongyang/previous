<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Data_Unit
{   
  
    public function unit_list()
    {
         return array(
            1=>L('个'),
            2=>L('件'),
            3=>L('次'),
            4=>L('平米'),
            5=>L('小时'),
            6=>L('斤'),
            7=>L('两'),
            8=>L('公斤'),
            9=>L('台'),
            10=>L('套'),            
            11=>L('条'),            
            12=>L('双'),             
            13=>L('座'),             
            14=>L('张'),
        );
    }
}
