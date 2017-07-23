<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Waimai extends Ctl
{
    
    public function __construct($system)
    {
        parent::__construct($system);
        if(!($waimai = K::M('waimai/waimai')->detail($this->shop_id)) || empty($waimai['audit'])){
            $this->pagedata['waimai'] = $waimai;
            if($system->request['ctl'] != 'waimai' || $system->request['act'] != 'index'){
                $this->msgbox->add('您需要开通外送店铺才能使用该功能', 311);
                $this->msgbox->set_data('forward', $this->mklink('merchant/waimai:index'));
                $this->msgbox->response();
            }
        }
        $this->pagedata['waimai'] = $waimai;
        $this->waimai = $waimai;
    }
     

    public function index()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,logo,cate_id,phone,tmpl_type,yy_status,is_ziti,online_pay,is_daofu,yy_stime,yy_ltime,delcare,info')){
                $this->msgbox->add('非法的数据提交');
            }else{
                $data['lat'] = $this->shop['lat'];
                $data['lng'] = $this->shop['lng'];
                $data['addr'] = $this->shop['addr'];
                if($this->waimai['shop_id']){
                    K::M('waimai/waimai')->update($this->shop_id, $data);
                }else{
                    $detail = K::M('waimai/waimai')->find(array('shop_id'=>$this->shop_id));
                    if(1 == $detail['closed']){
                        $this->msgbox->add('店铺已被关闭,请联系管理员.');
                    }
                    else{
                        $data['shop_id'] = $this->shop_id;
                        K::M('waimai/waimai')->create($data);
                    }

                }
            }           
        }else{
            $this->pagedata['cate_tree'] = K::M('waimai/cate')->tree();            
            $this->tmpl = 'merchant:waimai/index.html';
        }
    }
}