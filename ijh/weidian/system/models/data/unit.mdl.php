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
            1=>'个',
            2=>'件',
            3=>'次',
            4=>'平米',
            5=>'小时',
            6=>'斤',
            7=>'两',
            8=>'公斤',
            9=>'台',
            10=>'套',            
            11=>'条',            
            12=>'双',             
            13=>'座',             
            14=>'张',
        );
    }
}
