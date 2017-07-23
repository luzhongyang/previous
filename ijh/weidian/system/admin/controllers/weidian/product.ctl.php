<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}
class Ctl_Weidian_Product extends Ctl
{
    public function index($page = 1)
    {
        $filter = $pager = array();
        $filter['closed'] = 0;
        $filter['type'] = 'default';
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['product_id']){
                $filter['product_id'] = $SO['product_id'];
            }
            if($SO['shop_id']){
                $filter['shop_id'] = $SO['shop_id'];
            }
            if($SO['cate_id']){
                $filter['cate_id'] = $SO['cate_id'];
            }
            if($SO['title']){
                $filter['title'] = "LIKE:%" . $SO['title'] . "%";
            }
        }
        if($items = K::M('weidian/product')->items($filter, array('product_id'=>'DESC'), $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO' => $SO));
            $shop_ids = array();
            foreach($items as $v){
                $shop_ids[$v['shop_id']] = $v['shop_id'];
            }
            if($shop_ids){
                $this->pagedata['shop_list'] = K::M('shop/shop')->items_by_ids($shop_ids);
            }
            $tuan_product_cate = K::M('weidian/productcate')->options();
            $view_params = K::M('weidian/product')->view_params;
            foreach($items as $k => $v){
                $items[$k]['cate_id'] = $tuan_product_cate[$v['cate_id']];
            }
        }

        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:weidian/product/items.html';
    }
    public function so()
    {
        $this->tmpl = 'admin:weidian/product/so.html';
    }
    public function detail($product_id = null)
    {
        if(!$product_id = (int) $product_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('weidian/product')->detail($product_id, true)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $detail['closed'] = $view_params['closed']['select'][$detail['closed']];
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:weidian/product/detail.html';
        }
    }
    public function create()
    {
        if($data = $this->checksubmit('data')){
            //进行团产品设置的一系列逻辑判断
            $error = $this->validate();
            if(!empty($error)){
                $this->msgbox->add($error, 431);
                return false;
                die;
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
            if($pintuan_product_id = K::M('pintuan/product')->create($data)){
                /*
                 * 拼团价格格修改,
                 * 如果是阶梯团, 将原有拼团价格格,最低的那个,修改为拼团价格
                 * 查询每个楼层,然后存储
                 */
                if(1 == $_POST['data']['tuan_type']){
                    foreach($_POST['data']['muti_num'] as $k => $v){
                        //将第一个价格,更新到产品表
                        if(1 == $k){
                            K::M('pintuan/product')->update($pintuan_product_id, array('tuan_price' => $_POST['data']['muti_price'][$k], 'user_num' => $_POST['data']['muti_num'][$k]));
                        }
                        $insert_leve = array(
                            'pintuan_product_id' => $pintuan_product_id,
                            'level' => $k,
                            'user_num' => $v,
                            'price' => $_POST['data']['muti_price'][$k]
                        );
                        K::M('pintuan/productlevel')->create($insert_leve);
                    }
                }
                //更新前台缓存  $pintuan_product_id
                //清理收藏缓存
                $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
                K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);
                //存储属性数据
                $this->attr_insert($pintuan_product_id);
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?pintuan/product-index.html');
            }
        }else{
            $detail = array();
            $all_cate = K::M('pintuan/productcate')->options_all();
            $this->pagedata['cates'] = $all_cate;
            //没有值,自己造一个二维数组循环
            $arr_level = array(
                1 => array(
                    'level' => 1,
                    'user_num' => null,
                    'price' => null,
                ),
                2 => array(
                    'level' => 2,
                    'user_num' => null,
                    'price' => null,
                ),
            );
            $detail['level_html'] = null;
            foreach($arr_level as $k => $v){
                $detail['level_html'] .= '<tr>
                                    <td>' . $v['level'] . '</td>
                                    <td><input type="text" class="input w-100 M_num"
                                               name="data[muti_num][' . $v['level'] . ']" value="' . $v['user_num'] . '"></td>
                                    <td><input type="text" class="input w-100 M_price"
                                               name="data[muti_price][' . $v['level'] . ']" value="' . $v['price'] . '"></td>
                                    <td>
                                    </td>
                                </tr>';
            }
            $view_params                   = K::M('pintuan/product')->view_params;
            $detail['attr_html']           = $this->attr_select(0);
            $this->pagedata['view_params'] = $view_params;
            $this->pagedata['detail']      = $detail;
            $this->tmpl = 'admin:pintuan/product/create.html';
        }
    }
    public function attr_select($pintuan_product_id = 0)
    {
//        $html = '<tr>
//                            <td>
//                                <input type="text" name="data[attr_name][1]" value="" class="input w-100"/>
//                            </td>
//                            <td width="200">
//                                <input id="tags_1" name="data[attr_value][1]" type="text" class="tags" value="" />
//                            </td>
//                            <td class="center"><a href="javascript:;" class="text-danger remove-price">删除</a></td>
//                        </tr>
//                        ';
        $html = ''; //默认属性为空
        if($pintuan_product_id > 0){
            //查询表数据,组合属性
            $find_attr = K::M('pintuan/productattr')->select(array('pintuan_product_id' => $pintuan_product_id), 'pintuan_attr_id');
            $count     = count($find_attr);
            if($count > 0){
                $new_attr = array();
                $i        = 1;
                $html     = '';
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
    public function attr_insert($pintuan_product_id)
    {
        //先删, 后增策略, 不做编辑处理
        $find_level = K::M('pintuan/productattr')->select(array('pintuan_product_id' => $pintuan_product_id));
        $level_ids  = array();
        foreach($find_level as $k => $v){
            $level_ids[] = $v['pintuan_attr_id'];
        }
        if(count($level_ids) > 0){
            K::M('pintuan/productattr')->delete($level_ids);
        }
        foreach($_POST['data']['attr_name'] as $k => $v){
            if(empty($v) || empty($_POST['data']['attr_value'][$k])){
                continue;
            }
            $now         = time();
            $insert_leve = array(
                'pintuan_product_id' => $pintuan_product_id,
                'attr_name'          => $v,
                'attr_value'         => $_POST['data']['attr_value'][$k],
                'dateline'           => $now
            );
            K::M('pintuan/productattr')->create($insert_leve);
        }
    }
    /**
     * 过滤加入数据库的数据
     */
    public function validate_insert()
    {
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
        $error = null;
        if(0 == $_POST['data']['tuan_type']){
            //普通团
            //拼团价格 不能大于 普通价
            if($_POST['data']['price'] <= $_POST['data']['tuan_price']){
                $error = '普通团: 拼团价格要小于单买价<br />';
            }
            if($_POST['data']['tuan_price'] <= 0){
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
    public function edit($pintuan_product_id = null)
    {
        if(!($pintuan_product_id = (int) $pintuan_product_id) && !($pintuan_product_id = $this->GP('pintuan_product_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('pintuan/product')->detail($pintuan_product_id, true)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            //进行团产品设置的一系列逻辑判断
            $error = $this->validate();
            if(!empty($error)){
                $this->msgbox->add($error, 431);
                return false;
                die;
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
            if(K::M('pintuan/product')->update($pintuan_product_id, $data)){
                /*
                 * 拼团价格格修改,
                 * 如果是阶梯团, 将原有拼团价格格,最低的那个,修改为拼团价格
                 * 查询每个楼层,然后存储
                 */
                if(1 == $_POST['data']['tuan_type']){
                    //先删, 后增策略, 不做编辑处理
                    $find_level = K::M('pintuan/productlevel')->select(array('pintuan_product_id' => $pintuan_product_id));
                    $level_ids = array();
                    foreach($find_level as $k => $v){
                        $level_ids[] = $v['pintuan_level_id'];
                    }
                    if(count($level_ids) > 0){
                        K::M('pintuan/productlevel')->delete($level_ids);
                    }
                    foreach($_POST['data']['muti_num'] as $k => $v){
                        //将第一个价格,更新到产品表
                        if(1 == $k){
                            K::M('pintuan/product')->update($pintuan_product_id, array('tuan_price' => $_POST['data']['muti_price'][$k], 'user_num' => $_POST['data']['muti_num'][$k]));
                        }
                        $insert_leve = array(
                            'pintuan_product_id' => $pintuan_product_id,
                            'level' => $k,
                            'user_num' => $v,
                            'price' => $_POST['data']['muti_price'][$k]
                        );
                        K::M('pintuan/productlevel')->create($insert_leve);
                    }
                }
                //更新前台缓存  $pintuan_product_id
                //清理收藏缓存
                $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $pintuan_product_id));
                K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);
                
                //存储属性数据
                $this->attr_insert($pintuan_product_id);
                $this->msgbox->add('修改内容成功');
            }
        }else{
            if(1 == $detail['tuan_type']){
                $arr_level = K::M('pintuan/productlevel')->select(array('pintuan_product_id' => $detail['pintuan_product_id']), 'level');
                if(count($arr_level) < 2){
                    //没有值,自己造一个二维数组循环
                    $arr_level = array(
                        1 => array(
                            'level' => 1,
                            'user_num' => null,
                            'price' => null,
                        ),
                        2 => array(
                            'level' => 2,
                            'user_num' => null,
                            'price' => null,
                        ),
                    );
                }
                $detail['level_html'] = null;
                foreach($arr_level as $k => $v){
                    $del_html = $v['level'] > 2 ? '<a href="javascript:;" class="text-danger remove-price">删除</a>' : '';
                    $detail['level_html'] .= '<tr>
                                    <td>' . $v['level'] . '</td>
                                    <td><input type="text" class="input w-100 M_num"
                                               name="data[muti_num][' . $v['level'] . ']" value="' . $v['user_num'] . '"></td>
                                    <td><input type="text" class="input w-100 M_price"
                                               name="data[muti_price][' . $v['level'] . ']" value="' . $v['price'] . '"></td>
                                    <td>' . $del_html . '
                                    </td>
                                </tr>';
                }
            }
            $detail['attr_html']           = $this->attr_select($detail['pintuan_product_id']);
            //获取一级分类,select值
            $all_cate = K::M('pintuan/productcate')->options_all();
            $view_params = K::M('pintuan/product')->view_params;
            $this->pagedata['view_params'] = $view_params;
            $this->pagedata['cates'] = $all_cate;
            $this->pagedata['detail'] = $detail;
            $this->pagedata['shop'] = K::M('shop/shop')->detail($detail['shop_id']);
            $this->tmpl = 'admin:pintuan/product/edit.html';
        }
    }
    public function doaudit($pintuan_product_id = null)
    {
        if($pintuan_product_id = (int) $pintuan_product_id){
            if(K::M('pintuan/product')->batch($pintuan_product_id, array('audit' => 1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('pintuan_product_id')){
            if(K::M('pintuan/product')->batch($ids, array('audit' => 1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
    public function delete($pintuan_product_id = null)
    {
        if($pintuan_product_id = (int) $pintuan_product_id){
            if(!$detail = K::M('pintuan/product')->detail($pintuan_product_id)){
                $this->msgbox->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('pintuan/product')->delete($pintuan_product_id)){
                    $this->msgbox->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('pintuan_product_id')){
            if(K::M('pintuan/product')->delete($ids)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    }
}
