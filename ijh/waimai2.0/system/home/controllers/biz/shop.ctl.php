
<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Biz_Shop extends Ctl_Biz
{

    public function index()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'title,info,addr,lat,lng,logo,phone,yy_status,yy_stime,yy_ltime,is_daofu,is_ziti,online_pay,cate_id')){
                //定制, 收单优惠改为平台设置, first_amount
                $this->msgbox->add(L('非法的数据提交'), 211);
            }
            else{
                if($attach = $_FILES['shop_logo']){
                    if(UPLOAD_ERR_OK == $attach['error']){
                        if($a = K::M('magic/upload')->upload($attach, 'shop', $this->shop['logo'])){
                            $data['logo'] = K::M('content/html')->encode($a['photo']);
                        }
                    }
                }

                //货到付款改为1个按钮,判断
                if(0 == $data['online_pay']){
                    $data['is_daofu'] = 1;
                }
                else if(1 == $data['online_pay']){
                    $data['is_daofu'] = 0;
                }else{
                    $data['is_daofu'] = 1;
                }

                if($data['lat'] == '' || $data['lng'] == ''){
                    $this->msgbox->add(L('经纬度必须设置'), 212);
                }
                else if(K::M('shop/shop')->update($this->shop_id, $data)){
                    $this->msgbox->add(L('操作成功'));
                }
            }
        }
        else{
            $stime = mktime(0, 0, 0, date("m", time()), date("d", time()), date("Y", time()));
            $etime = mktime(23, 59, 59, date("m", time()), date("d", time()), date("Y", time()));
            $list = array();
            for($start = $stime; $start <= $etime; $start+=1800){
                $times[] = date('H:i', $start);
            }
            $this->pagedata['times'] = $times;
            $this->pagedata['cate_list'] = K::M('shop/cate')->tree();
            $this->pagedata['shop'] = $this->shop;
            //echo '<pre>';print_R($this->pagedata['cate_list']);die;
            $this->tmpl = 'biz/shop/index.html';
        }
    }

    public function passwd()
    {
        if($data = $this->checksubmit('data')){
            $session = K::M('system/session')->start();
            if(!$data['passwd']){
                $this->msgbox->add(L('请填写旧密码'), 211);
            }
            else if(!$data['new_passwd']){
                $this->msgbox->add(L('请填写新密码'), 212);
            }
            else if(!$data['new_passwd2']){
                $this->msgbox->add(L('请填写确认新密码'), 213);
            }
            else if($data['new_passwd'] != $data['new_passwd2']){
                $this->msgbox->add(L('新密码两次输入不一致'), 214);
            }
            else if(md5($data['passwd']) != $this->shop['passwd']){
                $this->msgbox->add(L('旧密码不正确'), 215);
            }
            else if($data['passwd'] == $data['new_passwd']){
                $this->msgbox->add(L('新密码不能和旧密码相同'), 216);
            }
            else{
                $new_passwd = md5($data['new_passwd']);
                if(K::M('shop/shop')->update($this->shop_id, array('passwd' => $new_passwd))){
                    $this->msgbox->add(L('操作成功'));
                }
            }
        }
        else{
            $this->tmpl = 'biz/shop/passwd.html';
        }
    }

    public function mobile()
    {
        $session = K::M('system/session')->start();
        if($data = $this->checksubmit('data')){
            if(!$passwd = $data['passwd']){
                $this->msgbox->add(L('密码不能为空'), 211);
            }
            else if(md5($passwd) != $this->shop['passwd']){
                $this->msgbox->add(L('登录密码不正确'), 212);
            }
            else if(!$mobile = $data['mobile']){
                $this->msgbox->add(L('手机号不能为空'), 213);
            }
            else if(!$mobile = K::M('verify/check')->mobile($mobile)){
                $this->msgbox->add(L('手机号不正确'), 214);
            }
            else if($mobile == $this->shop['mobile']){
                $this->msgbox->add(L('新手机号与当前手机号相同'), 215);
            }
            else if(!$sms_code = $data['code']){
                $this->msgbox->add(L('验证码不能为空'), 216);
            }
            else if($sms_code != $session->get('code_' . $mobile)){
                $this->msgbox->add(L('验证码不正确'), 217);
            }
            else if(K::M('shop/shop')->update_mobile($this->shop_id, $mobile)){
                $session->delete('code_' . $mobile);
                $this->msgbox->add(L('操作成功'));
            }
        }
        else{
            $this->pagedata['mobile'] = $this->shop['mobile'];
            $this->tmpl = 'biz/shop/mobile.html';
        }
    }

    public function account()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'account_type,account_name,account_number')){
                $this->msgbox->add(L('非法的数据提交'), 211);
            }
            else if($account_info = K::M('shop/account')->detail($this->shop_id)){
                K::M('shop/account')->update($this->shop_id, $data);
                $this->msgbox->add(L('修改提现帐号成功'));
            }
            else{
                $data['shop_id'] = $this->shop_id;
                K::M('shop/account')->create($data);
                $this->msgbox->add(L('添加提现帐号成功'));
            }
        }
        else{
            $this->pagedata['account_info'] = K::M('shop/account')->detail($this->shop_id);
            $this->pagedata['bank_list'] = K::M('data/data')->bank_list();
            $this->tmpl = 'biz/shop/account.html';
        }
    }

    /* public function pei(){
      if($data = $this->checksubmit('data')){
      if(!$data = $this->check_fields($data, 'min_amount,freight,pei_distance,pei_type,pei_amount')){
      $this->msgbox->add(L('非法的数据提交'), 211);
      }else{
      K::M('shop/shop')->update($this->shop_id,$data);
      $this->msgbox->add(L('操作成功'));
      }
      }else{
      $this->pagedata['detail'] = $this->shop;
      $this->tmpl = 'biz/shop/pei.html';
      }
      } */

    public function pei()
    {
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data, 'min_amount,freight,pei_distance,pei_type,pei_amount,fkm,fm,sm')){
                $this->msgbox->add('非法的数据提交', 211);
            }
            else{
                if($data['fkm']){
                    $freight_stage = array();
                    foreach($data['fkm'] as $k => $v){
                        $freight_stage[$k]['fkm'] = intval($v);
                        $freight_stage[$k]['fm'] = intval($data['fm'][$k]);
                        $freight_stage[$k]['sm'] = intval($data['sm'][$k]);
                        //允许设置0,免配送费
                        if(!$data['fm'][$k]){
                            $data['fm'][$k] = 0;
                        }
                        if(!$data['sm'][$k]){
                            $data['sm'][$k] = 0;
                        }
                        if($v<=0){
                            unset($freight_stage[$k]['fkm']);
                            unset($freight_stage[$k]['fm']);
                            unset($freight_stage[$k]['sm']);
                        }
//                        if(!$data['fm'][$k] || !$data['sm'][$k]){
//                            unset($freight_stage[$k]['fkm']);
//                            unset($freight_stage[$k]['fm']);
//                            unset($freight_stage[$k]['sm']);
//                        }
                    }
                }
                foreach($freight_stage as $key => $val){
                    if(!$val){
                        unset($freight_stage[$key]);
                    }
                }
                $shop_data['pei_type'] = $data['pei_type'];
                $shop_data['min_amount'] = $data['min_amount'];
                $shop_data['pei_amount'] = $data['pei_amount'];
//                $shop_data['pei_distance'] = $data['pei_distance'];
                $shop_data['pei_distance'] = round($shop_data['pei_distance'])>0?round($shop_data['pei_distance']):3;
                $shop_data['freight_stage'] = serialize($freight_stage);
                K::M('shop/shop')->update($this->shop_id, $shop_data);
                K::M('shop/shop')->update_pei_distance($this->shop_id,$data['fkm']);
                $this->msgbox->add('配送设置成功');
            }
        }
        else{
            $this->pagedata['detail'] = $this->shop;
            $this->tmpl = 'biz/shop/pei.html';
        }
    }

    public function youhui()
    {
        if($data = $this->checksubmit('data')){
            $datas = array();
            foreach($data['order_amount'] as $k => $val){
                if(($a = (float) $val) && ($b = (float) $data['youhui_amount'][$k])){
                    $datas[$a] = $b;
                }
            }
            if(K::M('shop/youhui')->update_youhui($this->shop_id, $datas)){
                $this->msgbox->add(L('操作成功'));
            }
        }
        else{
            $filter = array('shop_id' => $this->shop_id);
            if($items = K::M('shop/youhui')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['items'] = $items;
            $this->pagedata['pager'] = $pager;
            $this->tmpl = 'biz/shop/youhui.html';
        }
    }

    public function youhuidel()
    {
        if($youhui_id = (int) $this->GP('youhui_id')){
            if(!$detail = K::M('shop/youhui')->detail($youhui_id)){
                $this->msgbox->add(L('你要删除的优惠不存在或已经删除'), 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add(L('非法操作'), 213);
            }
            else{
                if(K::M('shop/youhui')->delete($youhui_id)){
                    K::M('shop/shop')->change_youhui($detail['shop_id']);
                    $this->msgbox->add(L('操作成功'));
                }
            }
        }
        else{
            $this->msgbox->add(L('未指定要删除的优惠ID'), 401);
        }
    }

    public function coupon()
    {
        if($data = $this->checksubmit()){
            if(!$data = $this->check_fields($data, 'coupon_id,order_amount,coupon_amount,sku,stime,ltime')){
                $this->msgbox->add('非法的数据提交', 211);
            }
            else{
                if($update_data = $this->checksubmit('data1')){
                    foreach($update_data as $k => $v){
                        if($v){
                            $v['ltime'] = strtotime($v['ltime']);
                            K::M('shop/coupon')->update($k, $v);
                        }
                    }
                }
                if($create_data = $this->checksubmit('data2')){
                    foreach($create_data as $v){
                        if($v['coupon_amount']<0.01){
                            continue;
                        }
                        $v['shop_id'] = $this->shop_id;
                        $v['stime'] = time(); //默认当前时间开始
                        $v['ltime'] = strtotime($v['ltime']);
                        K::M('shop/coupon')->create($v);
                    }
                }

                if($coupon_items = K::M('shop/coupon')->items(array('shop_id'=>$this->shop_id,'ltime'=>'>:'.__TIME,'closed'=>0,'sku'=>'>:0'),null,1,$limit,$count)) {
                    foreach($coupon_items as $k=>$v) {
                        $coupon_str[] = $v['order_amount'] . ":" . $v['coupon_amount'];
                    }
                    K::M('shop/shop')->update($this->shop_id, array('coupon'=>implode(',', $coupon_str)));
                }
                
                $this->msgbox->add('操作成功');
            }
        }
        else{
            $filter['shop_id'] = $this->shop_id;
            $filter['closed'] = 0;
            $filter['ltime'] = '>:' . __TIME;
            $filter['sku'] = '>:0';
            if($items = K::M('shop/coupon')->items($filter, array('coupon_id'=>'desc'), 1, $limit, $count)){
                foreach($items as $k => $v){
                    $cids[] = $v['coupon_id'];
                }
                $m_cooupon_items = K::M('member/coupon')->items(array('coupon_id' => $cids));
                $this->pagedata['items'] = $items;
            }

            //统计使用情况
            $filter = array();
            $filter['shop_id'] = $this->shop_id;
            $filter['status'] = 0;
            $count = array();
            $count['no_use'] = K::M('member/coupon')->count($filter);
            $filter['status'] = 1;
            $count['used'] = K::M('member/coupon')->count($filter);
            $count['total'] = $count['no_use'] + $count['used'];
            header("Content-type: text/html; charset=utf-8");
            $this->pagedata['count'] = $count;
            $this->tmpl = 'biz/shop/coupon.html';
        }
    }

    public function coupondel()
    {
        if($coupon_id = (int) $this->GP('coupon_id')){
            $m_coupon = K::M('member/coupon')->find(array('coupon_id' => $coupon_id));
            if(!$detail = K::M('shop/coupon')->detail($coupon_id)){
                $this->msgbox->add('你要删除的优惠券不存在或已经删除', 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }
            else if($m_coupon && $detail['ltime'] > __TIME){  // 当券未过期且用户领取过了不能删除
                $this->msgbox->add('未过期不能删除', 214);
            }
            else{
                if(K::M('shop/coupon')->delete($coupon_id)){
                    //K::M('shop/shop')->change_coupon($detail['shop_id']);
                    $this->msgbox->add('操作成功');
                }
            }
        }
        else{
            $this->msgbox->add('未指定要删除的优惠ID', 401);
        }
    }

    // 内景设置
    public function pic()
    {
        $this->pagedata['pics'] = K::M('shop/pic')->items(array('shop_id' => $this->shop_id), array('pic_id' => 'desc'), 1, 100, $count);
        $this->tmpl = 'biz/shop/pic/index.html';
    }

    // 添加内景
    public function createpic()
    {
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pic')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            if($pic_id = K::M('shop/pic')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', $this->mklink('biz/shop:pic'));
            }
        }
        else{
            $this->tmpl = 'biz/shop/pic/create.html';
        }
    }

    // 编辑内景
    public function editpic($photo_id)
    {
        if(!$photo_id = (int) $photo_id){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('shop/pic')->detail($photo_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }
        else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'shop')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(K::M('shop/pic')->update($photo_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/shop/pic/edit.html';
        }
    }

    // 删除内景
    public function delpic($photo_id)
    {
        if($photo_id = (int) $photo_id){
            if(!$detail = K::M('shop/pic')->detail($photo_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }
            else{
                if(K::M('shop/pic')->delete($photo_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

    // 微店轮播图设置
    public function banner()
    {
        
        $this->pagedata['items'] = K::M('shop/weidianbanner')->items(array('shop_id'=>$this->shop_id,'closed'=>0));
        $this->tmpl = 'biz/shop/banner/items.html';
    }

    // 微店轮播图添加
    public function createbanner()
    {
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pic')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            $data['dateline'] = __TIME;
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if($pic_id = K::M('shop/weidianbanner')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', $this->mklink('biz/shop:banner'));
            }
        }
        else{
            $this->tmpl = 'biz/shop/banner/create.html';
        }
    }

    // 微店轮播图修改
    public function editbanner($banner_id)
    {
        if(!$banner_id = (int) $banner_id){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }
        else if(!$detail = K::M('shop/weidianbanner')->detail($banner_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }
        else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }
        else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'shop')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['stime'] = strtotime($data['stime']);
            $data['ltime'] = strtotime($data['ltime']);
            if(K::M('shop/weidianbanner')->update($banner_id, $data)){
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'biz/shop/banner/edit.html';
        }
    }

    // 微店轮播图删除
    public function delbanner($banner_id)
    {
        if($banner_id = (int) $banner_id){
            if(!$detail = K::M('shop/weidianbanner')->detail($banner_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }
            else{
                if(K::M('shop/weidianbanner')->delete($banner_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }

    // 功能开启
    public function opened()
    {
        $this->pagedata['shop'] = $this->shop;
        $this->tmpl = 'biz/shop/opened.html';
    }

    public function setopened()
    {
        $data['pintuan'] = isset($_POST['pintuan']) ? $_POST['pintuan'] : 0;
        $data['weidian'] = isset($_POST['weidian']) ? $_POST['weidian'] : 0;
        if($data) {
            if(K::M('shop/shop')->update($this->shop_id, $data)) {

                if( 0 == $data['pintuan'] ){
                    $arr_product = K::M('pintuan/product')->items(array('shop_id'=>$this->shop_id));
                    $ids = array();
                    foreach ($arr_product as $k=>$v){
                        $ids[] = $k;
                    }
                    K::M('pintuan/product')->update($ids, array('is_onsale'=>0));
                }
                $this->msgbox->add('操作成功');
            }else {
                $this->msgbox->add('操作失败',210);
            }
        }
    }

}
