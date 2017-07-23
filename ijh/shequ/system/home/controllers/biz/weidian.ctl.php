<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('biz/biz');
class Ctl_Biz_Weidian extends Ctl_Biz
{

    public function __construct($system)
    {
        parent::__construct($system);
        $this->check_weidian();
    }

    public function check_weidian()
    {
    	//判断是否开通微店
    	if(!$weidian = K::M('weidian/weidian')->detail($this->shop_id)){
    		$ctl = $this->request['ctl'].':'.$this->request['act'];
    		if($ctl != 'biz/weidian:open'){
    			$this->msgbox->add('您还没有开通微店功能', 211);
    			$forward = $this->mklink('biz/weidian/open', null, null, 'base');
    			$this->msgbox->set_data('forward', $forward);
    			$this->msgbox->response();
    		}
    	}
    	$this->weidian = $weidian;
    	$this->pagedata['weidian'] = $weidian;
    }

    public function index()
    {
        $shop_id = $this->shop_id;
        $weidian = K::M('weidian/weidian')->detail($shop_id);

        $filter = array();
        $start_date = date('Y-m-01 00:00:00');
        $start_date = strtotime($start_date);
        $filter['dateline'] = '>:' . $start_date;
        $filter['order_status'] = '>:0';
        $filter['shop_id'] = $this->shop_id;
        //统计订单数目
        $weidian['order_count'] = 0;
        $weidian['order_money'] = 0;
        if($items = K::M('order/order')->items($filter, array('order_id'=>'desc'), 1, 99999, $count)){
            foreach ($items as $k=>$v){
                $weidian['order_money'] += $v['amount'];
            }
        }
        $weidian['order_count'] = $count;
        $weidian['ymd'] = date('Y年m月1日').' - '.date('d日');
        $this->pagedata['weidian'] = $weidian;
        $this->tmpl = 'biz/weidian/weidian/index.html';
    }

    public function info()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,logo,phone,is_daofu,is_ziti,online_pay')){
                $this->msgbox->add('非法的数据提交', 211);
            }else if(K::M('weidian/weidian')->update($this->shop_id, $data)){
                $this->msgbox->add('修改微店信息成功');
            }
        }else{
            $this->tmpl = 'biz/weidian/weidian/info.html';
        }
    }

    //开通微店铺
    public function open()
    {
        //仍然可以编辑资料
//        if($this->weidian){
//            $this->msgbox->add('您已经开通店铺了', 211);
//            $this->msgbox->set_data('forward', $this->mklink('biz/weidian:info'));
//        }else
        if ($data = $this->checksubmit('data')) {

            if (!$data = $this->check_fields($data, 'title,info,logo,phone,is_daofu,is_ziti,online_pay')) {
                $this->msgbox->add('非法的数据提交', 211);
            } else {
                $data['shop_id'] = $this->shop_id;

                if ($this->weidian) {
                    K::M('weidian/weidian')->update($this->shop_id, $data);
                } else {
                    K::M('weidian/weidian')->create($data);
                }

                $this->msgbox->set_data('forward', $this->mklink('biz/weidian:info'));
            }
        } else {
            $this->tmpl = 'biz/weidian/weidian/open.html';
        }
    }
}