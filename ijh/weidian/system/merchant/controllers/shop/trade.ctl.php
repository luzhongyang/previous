<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
// 商户订单设置
class Ctl_Shop_Trade extends Ctl
{
	// 上门自提
	public function selffetch($page=1)
	{
		$province = K::M('data/region')->items(array('level'=>1),null,1,34,$count);
		if($items = K::M('shop/ziti')->items(array('shop_id'=>$this->shop_id,'closed'=>0),null,1,500,$count)) {
			$this->pagedata['items'] = $items;
		}
		$this->pagedata['provinces'] = $province;
		$this->tmpl = 'merchant:shop/trade/selffetch.html';
	}

	// 添加自提点
	public function selffetchadd()
	{
  		if($data = $this->checksubmit('data')) {
  			if(!$data['title']) {
  				$this->msgbox->add('请填写自提点名称便于买家理解和管理',211);
  			}else if(!$data['province_id']) {
  				$this->msgbox->add('请选择省份',212);
  			}else if(!$data['city_id']) {
  				$this->msgbox->add('请选择城市',213);
  			}else if(!$data['area_id']) {
  				$this->msgbox->add('请选择区域',214);
  			}else if(!$data['address_detail']) {
  				$this->msgbox->add('请填写自提点的具体地址',215);
  			}else if(!$data['phone']) {
  				$this->msgbox->add('请填写联系电话',216);
  			}else if(!$data['fuwu_stime']){
  				$this->msgbox->add('请选择接待开始时间',217);
  			}else if(!$data['fuwu_ltime']) {
  				$this->msgbox->add('请选择接待结束时间',218);
  			}else {
  				$data['shop_id'] = $this->shop_id;
  				$province = K::M('data/region')->detail($data['province_id']);
  				$city = K::M('data/region')->detail($data['city_id']);
  				$area = K::M('data/region')->detail($data['area_id']);
  				$data['region'] = $province['region_name'] . ',' . $city['region_name'] . ',' .$area['region_name'];
                $data_city = K::M('data/city')->find(array('city_name'=>$city['region_name']));
                $data['data_city_id'] = $data_city['city_id'];
  				if($addr_id = K::M('shop/ziti')->create($data)) {
  					$this->msgbox->add('success');
  					$this->msgbox->set_data('data',array('addr_id'=>$addr_id));
  				}
  			}
  		}
	}

	// 修改自提点
	public function selffetchedit($addr_id)
	{
		if(!$addr_id = (int)$addr_id) {
			$this->msgbox->add('未指定要修改的内容ID', 211);
		}else if(!$detail = K::M('shop/ziti')->detail($addr_id)) {
			$this->msgbox->add('您要修改的内容不存在或已经删除', 212);
		}else if($data = $this->checksubmit('data')) {
			if(!$data['title']) {
  				$this->msgbox->add('请填写自提点名称便于买家理解和管理',211);
  			}else if(!$data['province_id']) {
  				$this->msgbox->add('请选择省份',212);
  			}else if(!$data['city_id']) {
  				$this->msgbox->add('请选择城市',213);
  			}else if(!$data['area_id']) {
  				$this->msgbox->add('请选择区域',214);
  			}else if(!$data['address_detail']) {
  				$this->msgbox->add('请填写自提点的具体地址',215);
  			}else if(!$data['phone']) {
  				$this->msgbox->add('请填写联系电话',216);
  			}else if(!$data['fuwu_stime']){
  				$this->msgbox->add('请选择接待开始时间',217);
  			}else if(!$data['fuwu_ltime']) {
  				$this->msgbox->add('请选择接待结束时间',218);
  			}else {
  				$data['shop_id'] = $this->shop_id;
  				$province = K::M('data/region')->detail($data['province_id']);
  				$city = K::M('data/region')->detail($data['city_id']);
  				$area = K::M('data/region')->detail($data['area_id']);
  				$data['region'] = $province['region_name'] . ',' . $city['region_name'] . ',' .$area['region_name'];
                $data_city = K::M('data/city')->find(array('city_name'=>$city['region_name']));
                $data['data_city_id'] = $data_city['city_id'];
  				if(K::M('shop/ziti')->update($addr_id, $data)) {
  					$this->msgbox->add('操作成功');
  					$this->msgbox->set_data('data',array('addr_id'=>$addr_id));
  				}
  			}
  		}else {
  			$this->pagedata['regions'] = K::M('data/region')->select();
  			$this->pagedata['detail'] = $detail;
  			$this->tmpl = 'merchant:shop/trade/selffetchedit.html';
  		}
	}

	// 删除自提点
	public function selffetchdel($addr_id)
	{
		if($addr_id = (int)$addr_id){
            if(!$detail = K::M('shop/ziti')->detail($addr_id, $force)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 211);
            }else if(K::M('shop/ziti')->delete($addr_id, $force)){
                $this->msgbox->add('删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
	}

	// 同城配送
	public function localdelivery()
	{
		if($data = $this->checksubmit('data')){
            if(!$data = $this->check_fields($data,'min_amount,pei_type,fkm,fm,sm,is_local')){
                $this->msgbox->add('非法的数据提交', 211);
            }else{
                if($data['fkm']){
                    $freight_stage = array();
                    foreach($data['fkm'] as $k => $v){
                        $freight_stage[$k]['fkm'] = intval($v);
                        $freight_stage[$k]['fm'] = intval($data['fm'][$k]);
                        $freight_stage[$k]['sm'] = intval($data['sm'][$k]);
                        if(!$data['fkm'][$k] || !$data['sm'][$k]){
                           unset($freight_stage[$k]['fkm']);
                           unset($freight_stage[$k]['fm']);
                           unset($freight_stage[$k]['sm']);
                        }
                    }
                }
                foreach($freight_stage as $key => $val){
                    if(!$val){
                        unset($freight_stage[$key]);
                    }
                }
                $data['freight_stage'] = serialize($freight_stage);
                K::M('weidian/weidian')->update($this->shop_id,$data);
                K::M('weidian/weidian')->update_pei_distance($this->shop_id,$data['fkm']);
                $this->msgbox->add('配送设置成功');
            }
        }else{
            $this->pagedata['detail'] = K::M('weidian/weidian')->detail($this->shop_id);
            $this->tmpl = 'merchant:shop/trade/localdelivery.html';
        }
	}

	// 快递发货(运费模板)
	public function delivery($page=1)
	{
		$filter = array();
		$filter['shop_id'] = $this->shop_id;
		$filter['closed'] = 0;
		$pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
		if($items = K::M('shop/faretpl')->items($filter, array('orderby'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('merchant/shop/trade/selffetch', array('{page}')));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
		$this->tmpl = 'merchant:shop/trade/delivery.html';
	}

	// 添加运费模板
	public function deliveryadd()
	{
		if($data = $this->checksubmit()){
            $data_tpl = $this->checksubmit('data');
            $data_tpl_items2 = $this->checksubmit('data2');
            if(count($data_tpl_items2)==0) {
                $this->msgbox->add('至少要有一个配送区域',210)->response();
            }
            if($data_tpl) {
                if($tpl_id = K::M('shop/faretpl')->create($data_tpl)) {
                    if($data_tpl_items2) {
                        foreach($data_tpl_items2 as $k2=>$v2) {
                            $v2['tpl_id'] = $tpl_id;
                            K::M('shop/faretplitem')->create($v2);
                        }
                        $this->msgbox->add('保存成功');
                        $this->msgbox->set_data('forward',  $this->mklink('merchant/shop/trade/delivery'));
                    }
                }
            }
        }else{
            $this->pagedata['shop'] = $this->shop;
            $this->tmpl = 'merchant:shop/trade/deliveryadd.html';
		}
	}

    // 修改运费模板
    public function deliveryedit($tpl_id)
    {
        if(!$tpl_id = (int)$tpl_id) {
            $this->msgbox->add('未指定要修改的内容ID',211);
        }else if(!$detail = K::M('shop/faretpl')->detail($tpl_id)) {
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($this->checksubmit()){
            if($data = $this->checksubmit('data')) {
                $data['lasttime'] = __TIME;
                K::M('shop/faretpl')->update($tpl_id, $data);
            }
            if(!is_array($this->checksubmit('data1')) && !is_array($this->checksubmit('data2'))) {
                $this->msgbox->add('至少要有一个配送区域',210)->response();
            }
            if($data_tpl_edit = $this->checksubmit('data1')) {
                if($item_list = K::M('shop/faretplitem')->items(array('tpl_id'=>$tpl_id))){
                    foreach($data_tpl_edit as $k=>$v){
                        if($sp = $item_list[$k]){
                            $a = array();
                            if($v['first']!=$sp['first']){
                                $a['first'] = $v['first'];
                            }
                            if($v['first_price']!=$sp['first_price']){
                                $a['first_price'] = $v['first_price'];
                            }
                            if($v['renew']!=$sp['renew']){
                                $a['renew'] = $v['renew'];
                            }
                            if($v['renew_price']!=$sp['renew_price']){
                                $a['renew_price'] = $v['renew_price'];
                            }
                            if($a){
                                K::M('shop/faretplitem')->update($k, $a);
                            }
                        }
                    }
                }
            }
            if($data_tpl_add = $this->checksubmit('data2')) {
                foreach($data_tpl_add as $k=>$v){
                    $v['tpl_id'] = $tpl_id;
                    K::M('shop/faretplitem')->create($v);
                }
            }
            $this->msgbox->add('保存成功');
            $this->msgbox->set_data('tpl_id', $tpl_id);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = $this->shop;
            $this->pagedata['items'] = K::M('shop/faretplitem')->select(array('tpl_id'=>$detail['tpl_id'], 'shop_id'=>$this->shop_id,'closed'=>0));
            $this->tmpl = 'merchant:shop/trade/deliveryedit.html';
        }
    }

    // 删除运费模板
    public function deliverydel($tpl_id)
    {
        if(!$tpl_id = (int)$tpl_id) {
            $this->msgbox->add('未指定要删除的内容ID',210);
        }else if(!$detail = K::M('shop/faretpl')->detail($tpl_id)) {
            $this->msgbox->add('你要删除的内容不存在或已经删除',211);
        }else if($detail['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作',212);
        }else if(K::M("shop/faretpl")->delete($tpl_id)){
            $this->msgbox->add('操作成功');
        }
    }

    // 删除配送区域
    public function areadel($item_id,$tpl_id)
    {
        if(!$item_id = (int)$item_id) {
            $this->msgbox->add('未指定要删除的内容ID',210);
        }else if(!$detail = K::M('shop/faretplitem')->detail($item_id)) {
            $this->msgbox->add('你要删除的内容不存在或已经删除',211);
        }else if($tpl_id != $detail['tpl_id']) {
            $this->msgbox->add('非法操作',212);
        }else if($detail['shop_id'] != $this->shop_id) {
            $this->msgbox->add('非法操作',213);
        }else if(K::M('shop/faretplitem')->delete($item_id)){
            $this->msgbox->add('操作成功');
        }
    }

	// ajax请求城市数据
	public function ajaxregion()
	{
		if($province_id = (int)$_POST['province_id']) {
			$items = K::M('data/region')->select(array('parent_id'=>$province_id));
			$data = $items;
			$f_city = array_shift($items);
			$f_city_id = $f_city['region_id'];
			$area_items = K::M('data/region')->select(array('parent_id'=>$f_city_id));
			foreach ($data as $key => $value) {
				$data[$f_city_id]['children'] = $area_items;
			}
			if($data) {$items = $data;}
		}else if($city_id = (int)$_POST['city_id']) {
			$items = K::M('data/region')->select(array('parent_id'=>$city_id));
		}else if($_POST['tree'] == 'tree_all'){
			$items = K::M('data/region')->items(null,array('region_id'=>'asc'),1,4000,$count);

		}else if($_POST['tree'] == 'tree_ids'){
            $only_2_level = array(3235,3239,3242);
            $treeids = explode(',', $_POST['tree_ids']);
            $tree_options = K::M('data/region')->select(array('region_id'=>$treeids));
            $options = K::M('data/region')->select();

            foreach($tree_options as $k=>$v) {
                if(in_array($v['region_id'], $only_2_level)) {
                    unset($tree_options[$k]);
                }
   
            }
 
            $items_xxx = array();
            foreach ($options as $key => $value) {
                if(!in_array($value, $tree_options)){
                    $items_xxx[] = $value;
                }
            }
            $items = $items_xxx;
          
            $items_k_v = array();
            foreach($items as $k => $v){
                $items_k_v[$v['region_id']] = $v;
            }
            $items = $items_k_v;
            $new_items = array();
            foreach( $items as $k => $v){
                if( 0 == $v['parent_id'])
                {
                    $new_items[$v['region_id']] = $v;
                }
            }
            
            foreach($new_items as $k => $v){
                $new_items[$k]['list'] = array();
                $is_have_level_1 = 0;
                $is_only_2_level = 0;
                if(in_array($k,$only_2_level))
                {
                    $is_only_2_level = 1;
                }
                foreach( $items as $kk => $vv){
                    if($vv['parent_id'] == $v['region_id'])
                    {
                        $new_items[$k]['list'][$vv['region_id']] = $vv;
                        if(1 == $is_only_2_level)
                        {
                            $is_have_level_1 = 1;
                            continue;
                        }
                        $is_have_level_2 = 0;
                        foreach($items as $kkk => $vvv){
                            if($vvv['parent_id'] == $vv['region_id'])
                            {
                                 $new_items[$k]['list'][$vv['region_id']]['list'][$vvv['region_id']] = $vvv;
                                 $is_have_level_2 = 1;
                                 $is_have_level_1 = 1;
                            }
                        }
                        if( 0 == $is_have_level_2)
                        {
                            unset($items[$vv['region_id']]);
                        }
                    }
                }
                 if( 0 == $is_have_level_1)
                {
                    unset($items[$v['region_id']]);
                }
            }
        }
		$this->msgbox->add('success');
		$this->msgbox->set_data('data', array('items'=>array_values($items)));
	}

}
