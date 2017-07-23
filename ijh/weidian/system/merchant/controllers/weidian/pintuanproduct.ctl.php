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
class Ctl_Weidian_Pintuanproduct extends Ctl_Weidian
{
    public function so()
    {

        $this->check_weidian();
        $this->pagedata['cates'] = K::M('weidian/productcate')->items(array('shop_id'=>$this->shop_id));
        $this->tmpl = 'merchant:weidian/pintuanproduct/so.html';
    }

    public function index($page=1)
    {
        $this->check_weidian();
        $filter = $pager = array();
        $filter['closed'] = 0;
        $filter['shop_id'] = $this->shop_id;
        $filter['type'] = 'pintuan';
        if(isset($_GET['product_id'])){
            $filter['product_id'] = (int)$_GET['product_id'];
        }
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
        }
        if($items = K::M('weidian/product')->items($filter, array('product_id'=>'DESC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));
            $product_ids = array();
            foreach($items as $v){
                $product_ids[$v['product_id']] = $v['product_id'];
            }
            if($product_ids){
                $products = K::M('weidian/pintuan/product')->items_by_ids($product_ids);
                $find_level = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $ids),array('user_num'=>'asc'));
            }
            $cates = K::M('weidian/productcate')->options($this->shop_id);
            $view_params = K::M('weidian/pintuan/product')->view_params;
            foreach($items as $k => $v){
                foreach($products as $k1=>$v1){
                    if($v['product_id'] == $v1['product_id']){
                        $items[$k]['product'] = $v1;
                    }
                }
                foreach($find_level as $k2=>$v2){
                    if($v['product_id'] == $v2['product_id']){
                        $items[$k]['level'][] = $v2;
                    }
                }
            }
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['cates'] = $cates;
        $this->pagedata['params'] = $view_params;
        $this->tmpl = 'merchant:weidian/pintuanproduct/index.html';
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
            //进行团产品设置的一系列逻辑判断
            $error = $this->validate();
            if(!empty($error)){
                $this->msgbox->add($error, 431)->response();
            }
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pintuan')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }
            //插入数据校验
            $this->validate_insert();
            $data['shop_id'] = $this->shop_id; //添加对应商家
            $data['type'] = 'pintuan';
            if($data['delivery_type'] == 0) {
                $data['delivery_tpl_id'] = 0;
            }else if($data['delivery_type'] == 1) {
                $data['delivery_price'] = 0;
            }
            //print_r($data);die;
            if($product_id = K::M('weidian/product')->create($data)){  //先插入product表，再处理pintuanproduct表
                $_data = array(
                    'product_id' => $product_id,
                    'item_limit' => $data['item_limit'],
                    'tuan_type'  => $data['tuan_type'],
                    'tuan_time'  => $data['tuan_time'],
                    'tuan_limit'  => $data['tuan_limit'],
                    'master_need_buy'  => $data['master_need_buy'],
                    'money_master'  => $data['money_master'],
                    'money_pre'  => $data['money_pre'],
                    'address_type' => $data['address_type'],
                );
                /*
                 * 拼团价格格修改,
                 * 如果是阶梯团, 将原有拼团价格格,最低的那个,修改为拼团价格
                 * 查询每个楼层,然后存储
                 */
                if($data['tuan_type'] == 1){ //如果是阶梯团
                   foreach($data['muti_num'] as $k => $v){
                        //将第一个价格,更新到产品表
                        if($k == 1){
                            K::M('weidian/product')->update($product_id, array('wei_price' => $_POST['data']['muti_price'][$k]));
                            $_data['user_num'] = $_POST['data']['muti_num'][$k]; //更新$_data 后插入数据库
                            K::M('weidian/pintuan/product')->create($_data,true);
                        }
                        $insert_leve = array(
                            'product_id'         => $product_id,
                            'level'              => $k,
                            'user_num'           => $v,
                            'price'              => $_POST['data']['muti_price'][$k]
                        );
                        K::M('weidian/pintuan/productlevel')->create($insert_leve);
                    }
                }else{  //普通团
                    K::M('weidian/product')->update($product_id,array('wei_price'=>$data['wei_price']));
                    $_data['user_num'] = $data['user_num'];   //更新$_data 后插入数据库
                    K::M('weidian/pintuan/product')->create($_data,false);
                }
                
                //更新前台缓存  $pintuan_product_id
                //清理收藏缓存
                //$arr_product = K::M('weidian/pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
                //K::M('weidian/collect')->shop_cache_clear($arr_product['shop_id']);
                
                //存储属性数据
                //$this->attr_group($product_id);
                //$this->attr_stock($product_id);
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?weidian/pintuanproduct/index');
            }
        }
        else{
            $detail = array();
            $this->pagedata['cates'] = K::M('weidian/productcate')->options_all();
            //没有值,自己造一个二维数组循环
            $arr_level = array(
                1 => array(
                    'level'    => 1,
                    'user_num' => null,
                    'price'    => null,
                ),
                2 => array(
                    'level'    => 2,
                    'user_num' => null,
                    'price'    => null,
                ),
            );
            $detail['level_html'] = null;
            foreach($arr_level as $k => $v){
                $detail['level_html'] .= '<tr>
                            <td>' . $v['level'] . '</td>
                            <td><input type="text" class="form-control"
                                       name="data[muti_num][' . $v['level'] . ']" value="' . $v['user_num'] . '"></td>
                            <td><input type="text" class="form-control"
                                       name="data[muti_price][' . $v['level'] . ']" value="' . $v['price'] . '"></td>
                            <td>默认
                            </td>
                        </tr>';
            }
            $this->pagedata['params'] = K::M('weidian/pintuan/product')->view_params;
            $detail['attr_html'] = $this->attr_select(0);
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop_id'] = $this->shop_id;
            $this->pagedata['tpl_items'] = K::M('shop/faretpl')->select(array('shop_id'=>$this->shop_id,'closed'=>0));
            $this->tmpl = 'merchant:weidian/pintuanproduct/create.html';
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
        $attr_group = K::M('weidian/product/attrgroup')->items(array('product_id'=>$product_id),array('attr_group_id'=>'asc'));
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
            $find_attr = K::M('weidian/productattr')->items(array('product_id' => $product_id), array('attr_id'=>'asc'));
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
        //先删, 后增策略, 不做编辑处理
        $find_level = K::M('weidian/productattr')->select(array('product_id' => $product_id));
        $level_ids = array();
        foreach($find_level as $k => $v){
            $level_ids[] = $v['attr_id'];
        }
        if(count($level_ids) > 0){
            K::M('weidian/productattr')->delete($level_ids);
        }
        foreach($_POST['data']['attr_name'] as $k => $v){
            if(empty($v) || empty($_POST['data']['attr_value'][$k])){
                continue;
            }
            $now = time();
            $insert_leve = array(
                'product_id'         => $product_id,
                'attr_name'          => $v,
                'attr_value'         => $_POST['data']['attr_value'][$k],
                'dateline'           => $now
            );
            K::M('weidian/productattr')->create($insert_leve);
        }
    }

    /**
     * 过滤加入数据库的数据
     */
    public function validate_insert()
    {
        $this->check_weidian();
        if(2 == $_POST['data']['address_type']){
            $_POST['data']['ship_fee'] = 0;
        }
    }

    /**
     * 检测输入是否合法,和前段js作用一样
     * @return string
     */
    public function validate()
    {
        $this->check_weidian();
        $error = null;
        if(0 == $_POST['data']['tuan_type']){
            //普通团
            //拼团价格 不能大于 普通价
            if($_POST['data']['price'] <= $_POST['data']['wei_price']){
                $error = '普通团: 拼团价格要小于单买价<br />';
            }
            if($_POST['data']['wei_price'] <= 0){
                $error = '普通团: 拼团价格需要大于0<br />';
            }
            if($_POST['data']['user_num'] <= 1){
                $error = '普通团: 成团人数需要大于1<br />';
            }
        }
        else{
            //阶梯团
            if(is_array($_POST['data']['muti_num'])){

                foreach($_POST['data']['muti_num'] as $k => $v){
                    if($v <= 0){
                        $error .= '阶梯团: 第 1 阶梯团成团人员需要大于0<br />';
                    }
                    //拼团价格 不能大于 普通价
                    if($_POST['data']['price'] <= $_POST['data']['muti_price'][$k]){
                        $error .= '阶梯团: 拼团价格要小于单买价<br />';
                    }
                    //阶梯价格和成员数比较
                    if(isset($_POST['data']['muti_price'][$k - 1])){
                        //价格和人数合法值判断
                        if($_POST['data']['muti_price'][$k - 1] < $_POST['data']['muti_price'][$k]){
                            $error .= "阶梯团: 高楼层拼团价格需要<b>小于</b>低楼层<br />";
                        }
                        if($_POST['data']['muti_num'][$k - 1] > $_POST['data']['muti_num'][$k]){
                            $error .= "阶梯团: 高楼层拼团人数需要<b>大于</b>低楼层<br />";
                        }
//                        echo $error = 'xxx'.$_POST['data']['muti_price'][$k-1].'xxx';
                    }
                }
            }
            if($_POST['data']['money_pre']<=0)
            {
                $error .= '阶梯团: 必须设置预付款<br />';
            }
        }
        //通用判断
        if($_POST['data']['price'] <= 0){
            $error .= '单买价必须大于0<br />';
        }
        if(0 != $_POST['data']['money_master'] && 0 != $_POST['data']['money_pre'] && $_POST['data']['money_pre'] <= $_POST['data']['money_master']){
            $error .= "预付定金需要<b>大于</b>团长佣金<br />";
        }
//        $error .= 'test error';
        return $error;
    }

    public function edit($product_id = null)
    {
        $this->check_weidian();
        if(!($product_id = (int) $product_id) && !($product_id = $this->GP('product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('weidian/pintuan/product')->_detail($product_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            //进行团产品设置的一系列逻辑判断
            $error = $this->validate();
            if(!empty($error)){
                $this->msgbox->add($error, 431)->response();
            }
            if($_FILES['data']){
                foreach($_FILES['data'] as $k => $v){
                    foreach($v as $kk => $vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k => $attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'pintuan')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            //插入数据校验
            $this->validate_insert();
            if($data['delivery_type'] == 0) {
                $data['delivery_tpl_id'] = 0;
            }else if($data['delivery_type'] == 1) {
                $data['delivery_price'] = 0;
            }
            if(K::M('weidian/product')->update($product_id, $data)){ //先更新product表，再处理pintuanproduct表
                $_data = array(
                    'item_limit' => $data['item_limit'],
                    'tuan_type'  => $data['tuan_type'],
                    'tuan_time'  => $data['tuan_time'],
                    'tuan_limit'  => $data['tuan_limit'],
                    'master_need_buy'  => $data['master_need_buy'],
                    'money_master'  => $data['money_master'],
                    'money_pre'  => $data['money_pre'],
                    'address_type'  => $data['address_type'],
                );
                /*
                 * 拼团价格格修改,
                 * 如果是阶梯团, 将原有拼团价格格,最低的那个,修改为拼团价格
                 * 查询每个楼层,然后存储
                 */
                if(1 == $_POST['data']['tuan_type']){
                    //先删, 后增策略, 不做编辑处理
                    $find_level = K::M('weidian/pintuan/productlevel')->select(array('product_id' => $product_id));
                    $level_ids = array();
                    foreach($find_level as $k => $v){
                        $level_ids[] = $v['level_id'];
                    }
                    if(count($level_ids) > 0){
                        K::M('weidian/pintuan/productlevel')->delete($level_ids);
                    }
                    foreach($_POST['data']['muti_num'] as $k => $v){
                        //将第一个价格,更新到产品表
                        if(1 == $k){
                            K::M('weidian/product')->update($product_id, array('wei_price' => $_POST['data']['muti_price'][$k]));
                            $_data['user_num'] = $_POST['data']['muti_num'][$k]; //更新$_data 后插入数据库
                            K::M('weidian/pintuan/product')->update($product_id,$_data);
                            
                        }
                        $insert_leve = array(
                            'product_id'         => $product_id,
                            'level'              => $k,
                            'user_num'           => $v,
                            'price'              => $_POST['data']['muti_price'][$k]
                        );
                        K::M('weidian/pintuan/productlevel')->create($insert_leve);
                    }
                }else{
                    K::M('weidian/product')->update($product_id,array('wei_price'=>$data['wei_price']));
                    $_data['user_num'] = $data['user_num'];   //更新$_data 后插入数据库
                    K::M('weidian/pintuan/product')->update($product_id,$_data);
                }
                //更新前台缓存  $pintuan_product_id
                //清理收藏缓存
                //$arr_product = K::M('weidian/pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
                //K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);
                //存储属性数据
                $this->attr_group($product_id);
                $this->attr_stock($product_id);
                $this->msgbox->add('修改内容成功');
            }
        }
        else{
            //print_r($detail);die;
            if(1 == $detail['tuan_type']){
                $arr_level = K::M('weidian/pintuan/productlevel')->items(array('product_id' => $detail['product_id']),array('level_id'=>'asc'));
                if(count($arr_level) < 2){
                    //没有值,自己造一个二维数组循环
                    $arr_level = array(
                        1 => array(
                            'level'    => 1,
                            'user_num' => null,
                            'price'    => null,
                        ),
                        2 => array(
                            'level'    => 2,
                            'user_num' => null,
                            'price'    => null,
                        ),
                    );
                }
                $detail['level_html'] = null;

                foreach($arr_level as $k => $v){
                    $del_html = $v['level'] > 2 ? '<a href="javascript:;" class="text-danger remove-price">删除</a>' : '默认';
                    $detail['level_html'] .= '<tr>
                                    <td>' . $v['level'] . '</td>
                                    <td><input type="text" class="form-control"
                                               name="data[muti_num][' . $v['level'] . ']" value="' . $v['user_num'] . '"></td>
                                    <td><input type="text" class="form-control"
                                               name="data[muti_price][' . $v['level'] . ']" value="' . $v['price'] . '"></td>
                                    <td>' . $del_html . '
                                    </td>
                                </tr>';
                }
            }
            $detail['attr_html'] = $this->attr_select($detail['product_id']);
            //获取一级分类,select值
            $this->pagedata['params'] = K::M('weidian/pintuan/product')->view_params;
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
            $this->pagedata['tpl_items'] = K::M('shop/faretpl')->select(array('shop_id'=>$this->shop_id,'closed'=>0));
            $this->tmpl = 'merchant:weidian/pintuanproduct/edit.html';
        }
    }

    public function delete($pintuan_product_id = null)
    {
        $this->check_weidian();
        if($pintuan_product_id = (int) $pintuan_product_id){
            if(!$detail = K::M('weidian/pintuan/product')->detail($pintuan_product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }
            else{
                if(K::M('weidian/pintuan/product')->delete($pintuan_product_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }
        else if($ids = $this->GP('pintuan_product_id')){
            if(K::M('weidian/pintuan/product')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }
        else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
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

    //下架产品
    public function onsale_close()
    {
        $this->check_weidian();
        $this->onsale_open(0);
    }

}
