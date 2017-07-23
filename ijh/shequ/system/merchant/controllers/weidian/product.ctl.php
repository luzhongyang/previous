<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
Import::C('weidian');
class Ctl_Weidian_Product extends Ctl_Weidian
{

    public function so()
    {

        $this->check_weidian();
        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
        $this->tmpl = 'merchant:weidian/product/so.html';
    }

    public function index($page=1)
    {
        $this->check_weidian();
        $filter = $pager = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['is_onsale'] == 1){
                $filter['is_onsale'] = 1;
            }else if($SO['is_onsale'] == 2) {
                $filter['is_onsale'] = array(0,1);
            }else {
                $filter['is_onsale'] = 0;
            }
            if($SO['stock']){$filter['stock'] = $SO['stock'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        //echo '<pre>';print_r($filter);die;
        $filter['shop_id'] = $this->shop_id;
        $filter['closed'] = 0;
        $filter['type'] = 'default';
        if($items = K::M('weidian/product')->items($filter, array('product_id'=>'desc'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
        //print_r(K::M('weidian/productcate')->fetch_all());die;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'merchant:weidian/product/index.html';
    }


    //上架产品
    public function onsale_open($is_onsale = 1)
    {
        $this->check_weidian();
        $is_onsale = $is_onsale > 0 ? 1 : 0;
        if (!$ids = $this->GP('product_id')) {
            $this->msgbox->add('请选择产品', 210);
        } else {
            $filter = array(
                'shop_id' => $this->shop['shop_id'],
                'product_id' => $ids,
            );
            if ($arr_product = K::M('weidian/product')->items($filter)) {
                foreach ($arr_product as $v) {
                    $update = array('is_onsale' => $is_onsale);
                    $arr_product = K::M('weidian/product')->update($v['product_id'], $update);
                }
            }
        }
    }
    public function onsale_openall($is_onsale = 1)
    {
        $this->check_weidian();
        $is_onsale = $is_onsale > 0 ? 1 : 0;
        if (!$ids = $this->GP('product_id')) {
            $this->msgbox->add('请选择产品', 210);
        } else {
            $filter = array(
                'shop_id' => $this->shop['shop_id'],
                'product_id' => $ids,
            );
            if ($arr_product = K::M('weidian/product')->items($filter)) {
                foreach ($arr_product as $v) {
                    $update = array('is_onsale' => $is_onsale);
                    $arr_product = K::M('weidian/product')->update($v['product_id'], $update);
                }
            }
            $this->msgbox->add('操作成功!');

        }
    }

    //下架产品
    public function onsale_close()
    {
        $this->check_weidian();
        $this->onsale_open(0);
    }

    
    
    public function open($product_id=null)
    {
        $this->check_weidian();
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else{
            if($detail['is_onsale'] == 0){
                $open = 1;
            }else{
                $open = 0;
            }
            $up = K::M('weidian/product')->update($product_id,array('is_onsale'=>$open));
            if($up){
                $this->msgbox->add('操作成功!');
            }else{
                $this->msgbox->add('操作失败!',300);
            }
        }
        
    }
    
    public function set_name()
    {
        $this->check_weidian();
        $title = $this->GP('title');
        if(!$name = K::M('weidian/name')->find(array('title'=>$title,'shop_id'=>$this->shop_id))){
            if($key = K::M('weidian/name')->create(array('title'=>$title,'shop_id'=>$this->shop_id))){
                $name = K::M('weidian/name')->detail($key);
            }
        }
        //print_r($name);die;
        $this->msgbox->add('success');
        $this->msgbox->set_data('name',$name);
    }
    
    
     public function set_value()
    {
        $this->check_weidian();
        $not_in = $this->GP('not_in');
        $title = $this->GP('title');
        if(!$value = K::M('weidian/value')->find(array('title'=>$title,'shop_id'=>$this->shop_id))){
            if($key = K::M('weidian/value')->create(array('title'=>$title,'shop_id'=>$this->shop_id))){
                $value = K::M('weidian/value')->detail($key);
            }
        }else{
            $not_in = explode("_",$not_in);
            if(in_array($value['key'], $not_in)){
                $this->msgbox->add('该属性值已存在!',211)->response();
            }
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('value',$value);
    }

    
    public function get_attr(){

        $this->check_weidian();
        $params = $_POST['params'];
        $params = json_decode($params,true);
        //print_r($params);
        $ids = $props = array();
        foreach($params as $k=>$v){
            $ids[$v['id']] = $v['id'];
            $key = explode(",", $v['props']);
            $props = array_merge($props,$key);
        }
        $props = array_unique($props);
        //print_r($props);
        $props_values = K::M('weidian/value')->items(array('key'=>$props));
        //print_r($props_values);die;
        //$attr_names = K::M('weidian/name')->items_by_ids($ids);
        $items = array();
        foreach($params as $k=>$v){
            $key = explode(",", $v['props']);
            $items[$k] = array('key'=>$v['id'],'title'=>$v['name'],'attr_value'=>array());
            foreach($key as $v1){
                if($row = $props_values[$v1]){
                    $items[$k]['attr_value'][] = $row;
                }
            }
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('items',$items);
    }
 
    public function create()
    {
        $this->check_weidian();
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            $data['shop_id'] = $this->shop_id;
            $data['type'] = 'default';
            if($product_id = K::M('weidian/product')->create($data)){
                $this->attr_group($product_id);
                $this->attr_stock($product_id);
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian:product'));
            }
        }else{
            $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
            $this->pagedata['shop_id'] = $this->shop_id;
           $this->tmpl = 'merchant:weidian/product/create.html';
        }   
    }

    public function edit($product_id=null)
    {
        $this->check_weidian();
        if(!($product_id = (int)$product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($detail['shop_id'] != $this->shop_id){
            $this->msgbox->add('非法操作', 213);
        }else if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'product')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            if(K::M('weidian/product')->update($product_id, $data)){
                $this->attr_group($product_id);
                $this->attr_stock($product_id);
                $this->msgbox->add('修改内容成功');
                $this->msgbox->set_data('forward',  $this->mklink('merchant/weidian/product/edit',array('args'=>$product_id)));
            }  
        }else{
            $stock_items = K::M('weidian/product/attrstock')->items(array('product_id'=>$product_id),array('attr_stock_id'=>'asc'));
            $attr_group = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id),array('attr_group_id'=>'asc'));
            $attr_group_ids = $titles = $title2s = array();
            foreach($attr_group as $k=>$v){
                $attr_group_ids[$v['attr_group_id']] = $v['attr_group_id'];
                $titles[] = $v['title'];
            }
            $jq_names = K::M('weidian/name')->items(array('title'=>$titles));
            foreach($attr_group as $k=>$v){
                foreach($jq_names as $k1=>$v1){
                    if($v['title'] == $v1['title']){
                        $attr_group[$k]['key'] = $v1['key'];
                    }
                }
            }
            $attr_value = K::M('weidian/product/attrvalue')->items(array('attr_group_id'=>$attr_group_ids),array('attr_value_id'=>'asc'));
            foreach($attr_value as $k=>$v){
                $title2s[] = $v['title'];
            }
            $jq_values = K::M('weidian/value')->items(array('title'=>$title2s));
            foreach($attr_value as $k=>$v){
                foreach($jq_values as $k1=>$v1){
                    if($v['title'] == $v1['title']){
                        $attr_value[$k]['key'] = $v1['key'];
                    }
                }
            }
            foreach($stock_items as $k=>$v){
                $stock_real_names = array_filter(explode("/", $v['stock_real_name']));
                $stock_reals = array();
                foreach($stock_real_names as $k1=>$v1){
                    foreach($attr_value as $k2=>$v2){
                        if($v1 == $v2['title']){
                            $stock_reals[] = $v2;
                        }
                    }
                }
                
                $stock_items[$k]['stock_reals'] =  $stock_reals;
            }
            //print_r($stock_items);die;
            $this->pagedata['attr_group'] = $attr_group;
            $this->pagedata['attr_value'] = $attr_value;
            $this->pagedata['stock_items'] = $stock_items;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
            $this->tmpl = 'merchant:weidian/product/edit.html';
        }       
    }

    public function attr_group($product_id){

        $this->check_weidian();
        if($detail = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id))){
            $attr_group_ids = array();
            foreach($detail as $kk=>$val){
                $attr_group_ids[$val['attr_group_id']] = $val['attr_group_id'];
            }
            $attr_values = K::M('weidian/product/attrvalue')->items(array('attr_group_id'=>$attr_group_ids));
            foreach($attr_values as $k=>$v){
                K::M('weidian/product/attrvalue')->delete($v['attr_value_id']);
            }
            foreach($detail as $k=>$v){
                K::M('weidian/product/attrgroup')->delete($v['attr_group_id']);
            }
        }
        $attr_value = (array) json_decode(str_replace('\\\"', '\"', $_POST['attr_value']), true);
        foreach ($attr_value as $k => $v) {
            $attr_group = array(
                'product_id'=>$product_id,
                'title' => $v['name'],
                'orderby' =>50,
            );
            $attr_v = explode(",", $v['props']);
            if($attr_group_id = K::M('weidian/product/attrgroup')->create($attr_group)){
                foreach($attr_v as $k1=>$v1){
                    $w_value = K::M('weidian/value')->detail($v1);
                    $attr_va = array(
                        'attr_group_id' => $attr_group_id,
                        'title' => $w_value['title'],
                        'orderby' => 50,
                    );
                    K::M('weidian/product/attrvalue')->create($attr_va);
                }
            }  
        }
    }

    public function attr_stock($product_id = 0){

        $this->check_weidian();
        if($attr_stock_items = K::M('weidian/product/attrstock')->items(array('product_id'=>$product_id))){
            foreach($attr_stock_items as $k=>$v){
                K::M('weidian/product/attrstock')->delete($v['attr_stock_id']);
            }
        }
        $attr_stock = (array) json_decode(str_replace('\\\"', '\"', $_POST['attr_stock']), true);
        //echo "-------------++++++++++++------------------";
        //print_r($attr_stock);
        $attr_group = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id),array('attr_group_id'=>'asc'));
        //echo "-------------++++++++++++------------------";
        //print_r($attr_group);
        //echo "-------------++++++++++++------------------";
        //print_r($this->system->db->SQLLOG());die;
        $attr_group_ids = array();
        foreach($attr_group as $k=>$v){
            $attr_group_ids[$v['attr_group_id']] = $v['attr_group_id'];
        }
        $attr_value = K::M('weidian/product/attrvalue')->items(array('attr_group_id'=>$attr_group_ids),array('attr_value_id'=>'asc'));
        $items = array();
        $j = 0;
        foreach($attr_group as $k=>$v){
            foreach($attr_value as $k1=>$v1){
                if($v['attr_group_id'] == $v1['attr_group_id']){
                    $items[$j][] = $v1;
                }
            }
            $j++;
        }
        $_count = count($items);
        $_arr_first = array();
        $_arr_first_title = array();
        for($i = 0; $i < $_count; $i++){
            if(0 == $i){
                foreach($items[$i] as $xxk => $xxv){
                    $_arr_first[] = $xxv['attr_value_id'];
                    $_arr_first_title[] = $xxv['title']. '/';
                }
            }else{
                //追加数组的方式
                $_new_arr = array();
                $_new_arr_title = array();
                foreach($_arr_first as $k => $v){
                    foreach($items[$i] as $xxk => $xxv){
                        $_new_arr[] = $v . '_' . $xxv['attr_value_id'];
                        $_new_arr_title[] = $_arr_first_title[$k]  . $xxv['title']. '/';
                    }
                }
                $_arr_first = $_new_arr;
                $_arr_first_title = $_new_arr_title;
            }
        }
        $insert_data = array();
        foreach($_arr_first as $k => $v)
        {
            $insert_data = array(
                'product_id' => $product_id,
                'stock_name' => $v,
                'price'      => $attr_stock[$k]['price'],
                'wei_price'  => $attr_stock[$k]['wei_price'],
                'stock'      => $attr_stock[$k]['stock'],
                'stock_sku'  => $attr_stock[$k]['sku'],
                'sales'      => $attr_stock[$k]['sales'],
                'stock_real_name'   => $_arr_first_title[$k],
            );
            K::M('weidian/product/attrstock')->create($insert_data);
        }
    }

    
    public function attr_select($product_id = 0)
    {
        $this->check_weidian();
        $html = ''; //默认属性为空
        if($product_id > 0){
            //查询表数据,组合属性
            $find_attr = K::M('weidian/productattr')->select(array('product_id' => $product_id), 'attr_id');
            $count = count($find_attr);
            if($count > 0){
                $new_attr = array();
                $i = 1;
                $html = '';
                foreach($find_attr as $k => $v){
                    $html .= '<tr>
                            <td>
                                <input type="text" name="data[attr_name][' . $i . ']" value="' . $v['attr_name'] . '" class="input w-100"/>
                            </td>
                            <td width="200">
                                <input id="tags_' . $i . '" name="data[attr_value][' . $i . ']" type="text" class="tags" value="' . $v['attr_value'] . '" />
                            </td>
                           <td class="center"><a href="javascript:;" class="text-danger remove-price">删除</a></td>
                        </tr>';
                    $i++;
                }
            }
        }
        return $html;
    }

    public function attr_insert($product_id)
    {
        $this->check_weidian();
        $groups = K::M('weidian/product/attrgroup')->select(array('product_id' => $product_id)); //查询数据是否已有数据，如果有，既做编辑，也做添加，没有直接做添加操作
        //编辑group
        $old_groups = $data['old']['group'];
        $old_values = $data['old']['values'];
        //新增的group
        $new_groups = $data['new']['group'];
        $new_values = $data['new']['values'];
        if($groups){  //编辑
            foreach($new_groups as $k=>$v){
                if(empty($v) || empty($new_values[$k])){
                    continue;
                }
                $insert_group = array(
                    'product_id'   => $product_id,
                    'title'        =>  $v,
                );
                if($attr_group_id = K::M('weidian/product/attrgroup')->create($insert_group)){
                    $values = explode(",", $new_values[$k]);
                    foreach($values as $v1){
                        $insert_value = array(
                            'product_id'    => $product_id,
                            'attr_group_di' => $attr_group_id,
                            'title'         => $v1,   
                        );
                        K::M('weidian/product/attrvalue')->create($insert_value);
                    }
                }   
            }
        }
        foreach($new_groups as $k=>$v){
            if(empty($v) || empty($new_values[$k])){
                continue;
            }
            $insert_group = array(
                'product_id'   => $product_id,
                'title'        =>  $v,
            );
            if($attr_group_id = K::M('weidian/product/attrgroup')->create($insert_group)){
                $values = explode(",", $new_values[$k]);
                foreach($values as $v1){
                    $insert_value = array(
                        'product_id'    => $product_id,
                        'attr_group_di' => $attr_group_id,
                        'title'         => $v1,   
                    );
                    K::M('weidian/product/attrvalue')->create($insert_value);
                }
            }   
        }
        
    }
    
    
    public function delete($product_id=null)
    {
        $this->check_weidian();
        if($product_id = (int)$product_id){
            if(!$detail = K::M('weidian/product')->detail($product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else if($detail['shop_id'] != $this->shop_id){
                $this->msgbox->add('非法操作', 213);
            }else{
                if(K::M('weidian/product')->batch($product_id,array('closed'=>1))){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
 
    
    public function set_price($product_id){
        
        $this->check_weidian();
        $this->tmpl = 'merchant:weidian/product/set_price.html';
    }
    public function set_is_fenxiao($product_id){
        
        $this->check_weidian();
        if(!$product_id){
            $this->msgbox->add('错误', 211);
        }elseif(!$product = K::M('weidian/product')->detail($product_id)){
            $this->msgbox->add('错误', 212);
        }else{
            if($product['is_fenxiao'] == 0){
                $status = 1;
            }else{
                $status = 0;
            }
            if(K::M('weidian/product')->update($product_id, array('is_fenxiao'=>$status))){
                $this->msgbox->add('操作成功');
            }else{

                $this->msgbox->add('操作失败');
            }
        }
    }

    
}