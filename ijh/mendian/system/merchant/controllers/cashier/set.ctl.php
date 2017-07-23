<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('cashier');
class Ctl_Cashier_Set extends Ctl_Cashier
{
    public function index()
    {
        $shop_id = $this->shop_id;
        if(!$detail = K::M('cashier/cashier')->detail($shop_id)){
            $this->msgbox->add('数据异常！', 212);
        }else if($data = $this->checksubmit('data')){
            $data['dateline'] =time();  
            if(K::M('cashier/cashier')->update($shop_id, $data)){
                $this->msgbox->add('操作成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/set/index'));
            }  
        }else{
            $this->pagedata['moling'] = K::M('cashier/cashier')->moling();
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:cashier/set/index.html';
        }       
    }
    public function printer()
    {
        $shop_id = $this->shop_id;
        $detail = K::M('shop/printer')->detail(array('shop_id'=>$shop_id));
        if($data = $this->checksubmit('data')){
            $data['dateline'] =time();
            $data['shop_id'] =$shop_id;
            if($detail){       
                if(K::M('shop/printer')->update($detail.printer_id, $data)){
                    $this->msgbox->add('操作成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/set/printer'));
                } 
            }else{
                if($printer_id = K::M('shop/printer')->create($data)){
                    $this->msgbox->add('操作成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/cashier/set/printer'));
                } 
            }
             
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'merchant:cashier/set/printer.html';
        }       
    }

}