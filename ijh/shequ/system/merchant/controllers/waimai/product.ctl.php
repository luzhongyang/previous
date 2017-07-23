<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('waimai');

class Ctl_Waimai_Product extends Ctl_Waimai
{

    public function index($page=1)
    {
        $this->check_waimai();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        if($items = K::M('waimai/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/waimai/product/index', array('{page}')));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        //待接单   预约   完成  取消数量
        $filter1['shop_id'] = $this->shop_id;
        $filter1['order_status'] = 0;
        $filter1['pay_status'] = 1;
        $filter1['from'] = 'waimai';
        $filter1['staff_id'] = 0;
        $filter1['closed'] = 0;
        $countnum['unjie'] = K::M('order/order')->count($filter1);//待接单
        $filter2['shop_id'] = $this->shop_id;
        $filter2['order_status'] = array(1, 2);
        $filter2['from'] = 'waimai';
        $filter2['staff_id'] = 0;
        $filter2['closed'] = 0;
        $countnum['unpei'] = K::M('order/order')->count($filter2);//待配送
        $filter3['shop_id'] = $this->shop_id;
        $filter3['order_status'] = array(1,8);
        $filter3['from'] = 'waimai';
        $filter3['closed'] = 0;
        $filter3['pei_type'] = 3;
        $countnum['ziti'] = K::M('order/order')->count($filter3);//自提订单
        $filter4['shop_id'] = $this->shop_id;
        $filter4['order_status'] = -1;
        $filter4['from'] = 'waimai';
        $filter4['closed'] = 0;
        $countnum['cansle'] = K::M('order/order')->count($filter4);//已取消
        // 今日已完成订单数
        $today = date('Ymd', __TIME);
        $countnum['tover'] = K::M('order/order')->count((array('shop_id'=>$this->shop_id,'from'=>'waimai','order_status'=>8,'day'=>$today,'closed'=>0)));
        $countnum['over'] = K::M('order/order')->count((array('shop_id'=>$this->shop_id,'from'=>'waimai','order_status'=>8,'closed'=>0)));
        //待接单   预约   完成  取消数量
        $this->pagedata['countnum'] = $countnum;
        $this->pagedata['cates'] = K::M('waimai/productcate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
        $this->tmpl = 'merchant:waimai/product/index.html';
    }

    //增加库存
    public function stock_add()
    {
        $stock_add = $this->GP('stock_num');
        if ($stock_add > 0) {
            if (!$ids = $this->GP('product_id')) {
                $this->msgbox->add('请选择产品', 210);
            } else {
                $filter = array(
                    'shop_id' => $this->shop['shop_id'],
                    'product_id' => $ids,
                );
                if ($arr_product = K::M('waimai/product')->items($filter)) {
                    foreach ($arr_product as $v) {
                        $arr_product = K::M('waimai/product')->update_count($v['product_id'], 'sale_sku', $stock_add);
                    }
                }
            }

        }
    }

    //上架产品
    public function onsale_open($is_onsale = 0)
    {
        $is_onsale = $is_onsale > 0 ? 1 : 0;
        if (!$ids = $this->GP('product_id')) {
            $this->msgbox->add('请选择产品', 210);
        } else {
            $filter = array(
                'shop_id' => $this->shop['shop_id'],
                'product_id' => $ids,
            );
            if($is_onsale) {
                $is_onsale = 0;
            }else {
                $is_onsale = 1;
            }
            if ($arr_product = K::M('waimai/product')->items($filter)) {
                foreach ($arr_product as $v) {
                    $update = array('is_onsale' => $is_onsale);
                    $arr_product = K::M('waimai/product')->update($v['product_id'], $update);
                }
            }
        }
    }

    //下架产品
    public function onsale_close()
    {
        $this->onsale_open(1);
    }

    public function skunotice($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;
        $filter['sale_sku'] = '<:15';
        if($items = K::M('waimai/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
        }
        $cate_ids = array();
        foreach($items as $k=>$v){
            $cate_ids[$v['cate_id']] = $v['cate_id'];
        }
        $this->pagedata['cates'] = K::M('waimai/productcate')->items_by_ids($cate_ids);
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
        $this->tmpl = 'merchant:waimai/product/skunotice.html';
    } 
    
    public function open($product_id=null)
    {
        $this->check_waimai();
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else{
            if($detail['is_onsale'] == 0){
                $open = 1;
            }else{
                $open = 0;
            }
            $up = K::M('waimai/product')->update($product_id,array('is_onsale'=>$open));
            if($up){
                $this->msgbox->add('操作成功!');
            }else{
                $this->msgbox->add('操作失败!',300);
            }
        }
        
    }
    
    public function create()
    {
        $this->check_waimai();
        if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data,'title,photo,cate_id,price,package_price,sale_sku,is_onsale,orderby,intro')) {
                $this->msgbox->add('非法的数据提交',210);
            }else if(!$data['title']){
                $this->msgbox->add('请填写名称',211);
            }else if(!$data['photo']){
                $this->msgbox->add('请上传图片',212);
            }else if(!$data['cate_id']){
                $this->msgbox->add('请选择分类',213);
            }else if(!$data['price']){
                $this->msgbox->add('请填写价格',214);
            }else if(!$data['sale_sku']){
                $this->msgbox->add('请填写库存',216);
            }else if(!$data['orderby']){
                $this->msgbox->add('请填写排序',218);
            }else {
                $data['sale_type'] = 1;
                $data['spec'] = '0';
                $data['shop_id'] = $this->shop_id;
                if($product_id = K::M('waimai/product')->create($data)){
                    $this->msgbox->add('添加内容成功');
                    $this->msgbox->set_data('forward',  $this->mklink('merchant/waimai/product/index'));
                } 
            }
        }else{
           $this->pagedata['shop_id'] = $this->shop_id;  
           $this->pagedata['shop'] = K::M('shop/shop')->detail($this->shop_id);
           $this->pagedata['pcates'] = K::M('waimai/productcate')->tree($this->shop_id);
           $this->tmpl = 'merchant:waimai/product/create.html';
        }   
    }

    public function edit($product_id=null)
    {
        $this->check_waimai();
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('waimai/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data,'title,photo,cate_id,price,package_price,sale_sku,is_onsale,orderby,intro')) {
                $this->msgbox->add('非法的数据提交',214);
            }else if(!$data['title']){
                $this->msgbox->add('请填写名称',215);
            }else if(!$data['photo']){
                $this->msgbox->add('请上传图片',216);
            }else if(!$data['cate_id']){
                $this->msgbox->add('请选择分类',217);
            }else if(!$data['price']){
                $this->msgbox->add('请填写价格',218);
            }else if(!$data['sale_sku']){
                $this->msgbox->add('请填写库存',220);
            }else if(!$data['is_onsale']){
                $this->msgbox->add('请选择是否上架',221);
            }else if(!$data['orderby']){
                $this->msgbox->add('请填写排序',222);
            }else {
                if(K::M('waimai/product')->update($product_id, $data)){
                    $this->msgbox->add('修改内容成功');
                }  
            }
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['pcates'] = K::M('waimai/productcate')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'merchant:waimai/product/edit.html';
        }       
    }

    public function delete($product_id=null)
    {
        $this->check_waimai();
        if($product_id = (int)$product_id){
            if(!$detail = K::M('waimai/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
    public function specs($product_id=null) 
    { 
        $this->check_waimai();
        $product_id = (int)$product_id;
        if(!$pro = K::M('waimai/product')->detail($product_id)) {
            $this->msgbox->add('商品不存在',210);
        }else if($pro['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作', 213);
        }else {
            if($data = $this->checksubmit()) {
                if(!$data = $this->check_fields($data, 'spec_name,price,package_price,sale_sku,spec_photo')){
                    $this->msgbox->add('非法的数据提交', 211);
                }else{
                    // 修改规格
                    if($data1 = $this->checksubmit('data1')) {
                        if($spec_list = K::M('waimai/productspec')->items(array('product_id'=>$product_id))){
                            foreach($data1 as $k=>$v){
                                if($sp = $spec_list[$k]){
                                    $a = array();
                                    if($v['spec_name']!=$sp['spec_name']){
                                        $a['spec_name'] = $v['spec_name'];
                                    } 
                                    if($v['price']!=$sp['price']){
                                        $a['price'] = $v['price'];
                                    }
                                    if($v['package_price']!=$sp['package_price']){
                                        $a['package_price'] = $v['package_price'];
                                    }
                                    if($v['sale_sku']!=$sp['sale_sku']){
                                        $a['sale_sku'] = $v['sale_sku'];
                                    }
                                    if($v['spec_photo']!=$sp['spec_photo']){
                                        $a['spec_photo'] = $v['spec_photo'];
                                    }

                                    if($a){
                                        K::M('waimai/productspec')->update($k, $a);
                                    }   
                                }
                            }
                        }
                    }

                    // 新增规格
                    if($data2 = $this->checksubmit('data2')) {
                        foreach($data2 as $k=>$v){
                            $v['product_id'] = $product_id;
                            K::M('waimai/productspec')->create($v);
                        } 
                        K::M('waimai/product')->update_spec($product_id);
                    }
                    $this->msgbox->add('规格设置成功'); 
                }
            }else {
                $filter = array('product_id'=>$product_id);
                if($items = K::M('waimai/productspec')->items($filter, null, $page, $limit, $count)){
                    $pager['count'] = $count;
                    $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($product_id, '{page}')));
                    $this->pagedata['items'] = $items;
                    K::M('waimai/product')->update($product_id,array('is_spec'=>1));
                }else {
                    K::M('waimai/product')->update($product_id,array('is_spec'=>0));
                }
                $this->pagedata['pager'] = $pager;

                $this->pagedata['product_id'] = $product_id;
                $this->tmpl = 'merchant:waimai/product/specs.html';
            } 
        }
    }

    public function specs_del($spec_id, $product_id)
    {
        $this->check_waimai();
        if($spec_id = (int)$spec_id){
            if(!$detail = K::M('waimai/productspec')->detail($spec_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['product_id'] != $product_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('waimai/productspec')->delete($spec_id)){
                    if(!$res = K::M('waimai/productspec')->find(array('product_id'=>$product_id))){
                        K::M('waimai/product')->update($product_id, array('is_spec'=>0));
                    }
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
    
     
}