<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}

class Ctl_Weidian extends Ctl
{

    public function __construct($system)
    {
        parent::__construct($system);
    }

    protected function check_weidian()
    {
        //判断是否开通微店
        $weidian = K::M('weidian/weidian')->detail($this->shop_id);
        if (!$weidian || $weidian['audit']!=1) {
            $ctl = $this->request['ctl'] . ':' . $this->request['act'];
            if ($ctl != 'weidian:info') {
                $this->msgbox->add('您还没有开通微店功能', 211);
                $this->msgbox->set_data('forward', $this->mklink('merchant/weidian/open', null, null, 'base'));
                $this->msgbox->response();
            }
        }
        $this->weidian = $weidian;
        $this->pagedata['weidian'] = $weidian;
    }

    public function index()
    {
        $this->check_weidian();
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
        if ($items = K::M('order/order')->items($filter, array('order_id' => 'desc'), 1, 99999, $count)) {
            foreach ($items as $k => $v) {
                $weidian['order_money'] += $v['amount'];
            }
        }
        $weidian['order_count'] = $count;
        $weidian['ymd'] = date('Y年m月1日') . ' - ' . date('d日');
        $this->pagedata['weidian'] = $weidian;
        $this->tmpl = 'merchant:weidian/weidian/index.html';
    }

    // 提交或修改申请资料
    public function open()
    {
        $weidian = K::M('weidian/weidian')->detail($this->shop_id);
        if ($data = $this->checksubmit('data')) {
            if (!$data = $this->check_fields($data, 'title,info,logo,phone,is_daofu,is_ziti,online_pay')) {
                $this->msgbox->add('非法的数据提交', 211);
            } else {
                $data['shop_id'] = $this->shop_id;
                if(empty($data['title'])) {
                    $this->msgbox->add('微店名称不能为空', 212)->response();
                }else if(empty($data['phone'])) {
                    $this->msgbox->add('客服电话不能为空', 213)->response();
                }
                if ($weidian) {
                    if(K::M('weidian/weidian')->update($this->shop_id, $data)) {
                        $this->msgbox->add('修改微店信息成功');
                    }else {
                        $this->msgbox->add('修改微店信息失败',214)->response();
                    }
                }else {
                    if(K::M('weidian/weidian')->create($data)) {
                        $this->msgbox->add('微店申请资料提交成功');
                    }
                }

                $this->msgbox->set_data('forward', $this->mklink('merchant/weidian:open'));
            }
        } else {
            if( 0 == $weidian['online_pay'] &&  0 == $weidian['is_daofu'] ){
                $weidian['online_pay']  = $weidian['is_daofu'] = 1;
            }
            $this->pagedata['weidian'] = $weidian;
            $this->tmpl = 'merchant:weidian/weidian/info.html';
        }
    }
}