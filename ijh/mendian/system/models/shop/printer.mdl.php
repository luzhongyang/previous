<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Mdl_Shop_Printer extends Mdl_Table
{   
  
    protected $_table = 'shop_printer';
    protected $_pk = 'printer_id';
    protected $_cols = 'printer_id,shop_id,title,type,config,status,dateline';

    protected function _format_row($row)
    {
        $row['config'] = unserialize($row['config']);
        return $row;
    }

    protected function _check($data, $printer_id=null)
    {
        if(isset($data['type']) || empty($printer_id)){
            if(empty($data['type'])){
                $this->msgbox->add('打印机类型不能为空', 211);
                return false;
            }
        }
        if(isset($data['config']) && is_array($data['config'])){
            $data['config'] = serialize($data['config']);
        }
        return parent::_check($data);
    }

}