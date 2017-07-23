<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
class Ctl_Weidian_Pintuan extends Ctl_Weidian
{

    public function index()
    {
        $cate = K::M('pintuan/productcate')->items(array('parent_id' => 0), null, 1, 7);
        $this->pagedata['cate'] = $cate;

        $filter = array();
        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;
        $filter['shop_id'] = (int)$_SESSION['WEIDIAN_SHOP_ID'];
        $arr_product = K::M('pintuan/product')->items($filter, $order_by, 1, 1, $count['count_0']);
        $this->pagedata['count'] = $count;
        $this->pagedata['shop'] = K::M('shop/shop')->detail($filter['shop_id']);
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/index.html';
    }

    /**
     * index 获取首页产品数据
     */
    public function ajax_index()
    {
        $filter = array();
        $limit = max((int) $this->GP('limit'), 10); //接收 js 传递的翻页值
        $page = max((int) $this->GP('page'), 1);

        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;


        $arr_product = K::M('pintuan/product')->items(array('closed' => 0), array('pintuan_product_id' => 'desc'), $page, $limit, $count);

        $product_ids = array();
        foreach($arr_product as $k => $val){
            $product_ids[$val['pintuan_product_id']] = $val['pintuan_product_id'];
            $arr_product[$k]['discount'] = number_format(($val['tuan_price'] / $val['price']), 1) * 10;
        }

        $filter_collect = "uid = " . $this->uid . " && pintuan_product_id in (" . implode(',', $product_ids) . ")";
        $arr_collect = K::M('pintuan/collect')->select($filter_collect);
        $arr_new_collect = array();
        foreach($arr_collect as $k => $v){
            $arr_new_collect[$v['pintuan_product_id']] = 'ok';
        }

        $return_html = null;
        if($count > 0){
            foreach($arr_product as $k => $v){
                $person_leave = $v['user_num'] - $v['order_success_count'];

                $is_collect = 'ok' == $arr_new_collect[$v['pintuan_product_id']] ? 'guanzhu scIco2' : 'guanzhu scIco1';

                $intro = K::M('pintuan/product')->intro_short($v['intro']);

                $return_html .= "
                    <div class='pintuan_list one_item'>
                        <div class='pub_img'><a href='" . $this->mklink('pintuan:product', $v['pintuan_product_id']) . "'><img
                                src='/attachs/{$v['photo']}' width='100%'><span
                                class='tag'><big>{$v['discount']}</big>折</span></a></div>
                        <div class='pub_wz'>
                            <h3 class='black'><a href='" . $this->mklink('pintuan:product', $v['pintuan_product_id']) . "'>{$v['title']}</a></h3>
                            <p class='black9'>" . $intro . "</p>
                        </div>
                        <div class='pintuan_list_state'>
                            <div class='box'><big>{$v['tuan_price']}</big>元/{$v['user_num']}人团<a href='" . $this->mklink('pintuan:product', $v['pintuan_product_id']) . "' class='btn fr'>去开团</a>
                            </div>
                            <img src='/themes/default/static/images/pintuanIco.png'>
                            <a href='javascript:;' num='{$v['pintuan_product_id']}' class='{$is_collect}'></a>
                        </div>
                    </div>
                    <a href='" . $this->mklink('pintuan:tuan_order_list') . "'><span class='xie-icon'></span></a>

                
                        ";
            }
        }
        else{
            $return_html = "<div class='content-block biaoqian-content'>
                        <div class='wushuju'>
                            <img src='/themes/default/static/images/kong.png' width='30%'>

                            <p class='mt10'>暂无数据.</p>

                        </div>
                    </div>";
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('count_num' => $count, 'html' => $return_html,));
    }

    public function shop($shop_id)
    {
        $shop_id = (int) $shop_id > 0 ? (int) $shop_id : $this->GP('shop_id');
        $filter = array();
        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;
        $filter['shop_id'] = $shop_id;
        $count = array();
        $arr_product = K::M('pintuan/product')->items($filter, $order_by, 1, 1, $count['count_0']);
        $this->pagedata['count'] = $count;


        $block = array();
        $block['shop_html'] = K::M('pintuan/collect')->shop_html($shop_id);
        $this->pagedata['block'] = $block;

        $order_by_str = "pintuan_product_id:desc";
        $this->pagedata['orderby'] = $order_by_str;
        $this->pagedata['shop_id'] = $shop_id;

        $this->tmpl = 'pintuan/search_shop.html';
    }

    //搜索
    public function search()
    {

        $hot_search = K::M('system/config')->get('pintuanhotsearch');
        $hot_search = explode(',', $hot_search['pintuanhotsearch']);

        if($cate_id = $this->GP('cate_id')){
            //分类加载
            $all_cate = K::M('pintuan/productcate')->select(array('parent_id' => 0));

            $arr_cate = K::M('pintuan/productcate')->find(array('pintuan_cate_id' => $cate_id));

            $filter = array();
            $filter['closed'] = 0;
            $filter['is_onsale'] = 1;
            $filter['cate_id'] = $cate_id;
            if(1 == $cate_id){//预留的,1默认是新品,或更多
                unset($filter['cate_id']);
                $arr_cate['title'] = "拼团产品";
            }
            $arr_product = K::M('pintuan/product')->items($filter, $order_by, 1, 1, $count['count_0']);
            $this->pagedata['count'] = $count;

            $order_by_str = $this->GP('orderby');
            switch($order_by_str){
                case 1:
                    $order_by_str = 1;
                    break;
                case 2:
                    $order_by_str = 2;
                    break;
                default:
                    $order_by_str = 0;
                    break;
            }
            $order_by = explode(":", $order_by_str);
            $order_by = array($order_by[0] => $order_by[1]);
            $this->pagedata['orderby'] = $order_by_str;

            $this->pagedata['cate'] = $arr_cate;
            $this->pagedata['all_cate'] = $all_cate;
            $this->pagedata['cate_id'] = $cate_id;
            $this->tmpl = 'pintuan/search_cate.html';
        }
        else if($title = $this->GP('title')){

            $filter = array();
            $filter['closed'] = 0;
            $filter['is_onsale'] = 1;
            $title = $this->GP('title');

            $filter['title'] = "LIKE:%" . $title . "%"; //搜索参数
            $count = array();
            $arr_product = K::M('pintuan/product')->items($filter, $order_by, 1, 1, $count['count_0']);
            $this->pagedata['count'] = $count;

            //删选参数,  category, orderby, select,  ajax 内排序.
            $order_by_str = "pintuan_product_id:desc";
            $this->pagedata['orderby'] = $order_by_str;
            $this->pagedata['title'] = $title;
            $this->tmpl = 'pintuan/search_list.html';
        }
        else{
            //删选参数,  category, orderby, select,  ajax 内排序.
            $order_by_str = "pintuan_product_id:desc";
            $this->pagedata['orderby'] = $order_by_str;
            $this->pagedata['hot_search'] = $hot_search;
            $this->tmpl = 'pintuan/search.html';
        }
    }

    public function ajax_search()
    {
        $limit = max((int) $this->GP('limit'), 10); //接收 js 传递的翻页值
        $page = max((int) $this->GP('page'), 1);

        $filter = array();
        $filter['closed'] = 0;
        $filter['is_onsale'] = 1;
        $filter['shop_id'] = $_SESSION['WEIDIAN_SHOP_ID'];

        $cate_id = $this->GP('cate_id');
        if($cate_id > 0){
            $filter['cate_id'] = $cate_id;
            if(1 == $cate_id){//预留的,1默认是新品,或更多
                unset($filter['cate_id']);
            }
        }


        $shop = (int) $this->GP('shop_id') > 0 ? $filter['shop_id'] = $this->GP('shop_id') : '';

        $title = $this->GP('title');
        if(strlen($title) > 0){
            $filter['title'] = "LIKE:%" . $title . "%"; //搜索参数
        }


        $order_by_str = strlen($this->GP('orderby')) > 3 ? $this->GP('orderby') : "pintuan_product_id:desc"; //搜索排序,翻页传递
        switch($order_by_str){
            case 1:
                $order_by_str = "sales:desc";
                break;
            case 2:
                $order_by_str = "dateline:desc";
                break;
            default:
                $order_by_str = "pintuan_product_id:desc";
                break;
        }
        $order_by = explode(":", $order_by_str);
        $order_by = array($order_by[0] => $order_by[1]);


        $arr_product = K::M('pintuan/product')->items($filter, $order_by, $page, $limit, $count);

        $product_ids = array();
        foreach($arr_product as $k => $val){
            $product_ids[$val['pintuan_product_id']] = $val['pintuan_product_id'];
            $arr_product[$k]['discount'] = number_format(($val['tuan_price'] / $val['price']), 1) * 10;
        }

        $filter_collect = "uid = " . $this->uid . " && pintuan_product_id in (" . implode(',', $product_ids) . ")";
        $arr_collect = K::M('pintuan/collect')->select($filter_collect);
        $arr_new_collect = array();
        foreach($arr_collect as $k => $v){
            $arr_new_collect[$v['pintuan_product_id']] = 'ok';
        }

        $return_html = null;
        $return_arr = array();
        $is_have = $count > 0 ? 1 : 0;
        if($count > 0){
            foreach($arr_product as $k => $v){

                $person_leave = $v['user_num'] - $v['order_success_count'];
                $v['person_leave'] = $person_leave;
                $is_collect = 'ok' == $arr_new_collect[$v['pintuan_product_id']] ? 'guanzhu scIco2' : 'guanzhu scIco1';
                $v['is_collect'] = $is_collect;
                $intro = K::M('pintuan/product')->intro_short($v['intro']);
                $v['intro'] = $intro;
                $v['link'] = $this->mklink('weidian/pintuan:product', $v['pintuan_product_id']);
                $v['link_order'] = $this->mklink('pintuan:tuan_order_list');
                $return_arr[] = $v;
            }
        }
//        echo "<Pre>---------<hr />";
//        print_r($return_arr);
//        die("</Pre>");
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('count_num' => $count, 'html' => $return_html, 'items' => $return_arr, 'is_have' => $is_have));
    }

    /**
     * 产品详情,  兼容 url 方式传参  product_id
     */
    public function product($product_id)
    {
        $product_id = (int) $product_id > 0 ? $product_id : (int) $this->GP('product_id');
        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $product_id));
        $arr_collect = K::M('pintuan/collect')->find(array('pintuan_product_id' => $product_id, 'uid' => $this->uid));
        $level_html = K::M('pintuan/productlevel')->level_html($product_id);
        $attr_html = K::M('pintuan/productattr')->attr_html($product_id);

        //返回当前产品用户的收藏状态
        if(!$this->uid){
            $is_collect = 0;
        }
        else{
            if(!$pintuan_collect = K::M('pintuan/collect')->find(array('pintuan_product_id' => $arr_product['pintuan_product_id'], 'uid' => $this->uid))){
                $is_collect = 0;
            }
            else{
                $is_collect = 1;
            }
        }
        K::M('system/logs')->log('co', $is_collect);
        $this->pagedata['is_collect'] = $is_collect;


        if(isset($_GET['detail']) && 'info' == $_GET['detail']){
            //详情页
            $this->pagedata['product'] = $arr_product;
            $this->pagedata['collect'] = $arr_collect;
            $this->tmpl = 'pintuan/product_detail.html';
        }
        else{

            $block = array();
            $block['relate_product'] = K::M('pintuan/product')->relate_pintuan_product($arr_product['pintuan_product_id'], $this->uid, 1);

//            $shop_html = K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);//清理缓存
            $block['shop_html'] = K::M('pintuan/collect')->shop_html($arr_product['shop_id']);
            $this->pagedata['block'] = $block;

            $arr_product['attr_html'] = $attr_html;
            $arr_product['level_html'] = $level_html;

            $this->pagedata['product'] = $arr_product;
            $this->pagedata['collect'] = $arr_collect;
            $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/product.html';
        }
    }

    /**
     * ajax处理收藏
     */
    public function ajax_collect()
    {
        $return = array('status' => 1, 'message' => null);
        $product_id = (int) $this->GP('product_id');
        if($this->uid < 1){
            $return['status'] = 2;
            $return['message'] = '请先登录';
        }
        else{
            $search = array(
                'pintuan_product_id' => $product_id,
                'uid'                => $this->uid
            );
            $arr_collect = K::M('pintuan/collect')->find($search);
            if(!empty($arr_collect)){
                //取消收藏
                $is_delete = K::M('pintuan/collect')->delete($arr_collect['pintuan_collect_id']);
                $return['message'] = '删除成功';
            }
            else{
                //新增收藏
                $insert = $search;
                $insert['dateline'] = time();
                $insert_id = K::M('pintuan/collect')->create($insert);
                $return['message'] = '新增成功' . $insert_id;
            }
            //清理收藏缓存
            $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $product_id));
            K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);
        }
        print_r(json_encode($return));
        exit();
    }

    /**
     * 单人购买,独立成一团,数量根据团产品最大数量,限制,价格按照原价,计算订单
     */
    public function order_single()
    {
        $this->check_login();
        //判断团购产品属性,如果属性为  无需购买开团, 则跳过设置地址,支付步骤, 直接成功,然后邀请他人参团,
        //无需购买, 生成订单金额为0, 产品数量为 0,  仅做标记读取用,  订单页面不展示数目为 0 的订单.
        //如果是 需要购买, 进入购买页面进行操作, 计算金额等
        $product_id = (int) $this->GP('product_id');
        $product_num = (int) $this->GP('num');
        $product_num = $product_num < 1 ? 1 : $product_num;
        //团购属性封装规则为   attr_name:attr_value.attr_name:attr_value
        $product_attr = "客户选择属性为: " . K::M('pintuan/productattr')->attr_get_to_string(); //加到订单备注中, 放到隐藏字段传递
        //价格选择原价,生成input表单 ,   产品id, 产品price, 产品数量, 产品属性
        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $product_id));
        $shop = K::M('shop/shop')->detail($arr_product['shop_id']);

        if(!$arr_product['pintuan_product_id']){
            $this->error(404); //产品不存在
        }
        if(0 == $arr_product['item_limit']){
            $this->error('抱歉,此产品仅限团购,不允许单独购买.'); //产品不存在
        }
        //限制最大数
        $product_num = $product_num > $arr_product['item_limit'] ? $arr_product['item_limit'] : $product_num;
        $arr_product['intro'] = K::M('pintuan/product')->intro_short($arr_product['intro']);

        $order_input = array(); //订单表单数据
        //正常付款模式,  (单人购)
        $money_pre = $arr_product['price'] * $product_num;
        $ship_fee = $arr_product['ship_fee'];

        if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
            $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
        }
        $order_input = array(
            'tuan_time'          => $arr_product['tuan_time'],
            'product_title'      => $arr_product['title'],
            'pintuan_product_id' => $arr_product['pintuan_product_id'],
            'product_price'      => $arr_product['price'],
            'product_money'      => $arr_product['price'] * $product_num,
            'product_num'        => $product_num,
            'product_attr'       => $product_attr,
            'ship_fee'           => $ship_fee,
            'money_master'       => $arr_product['money_master'],
            'money_pre'          => $money_pre,
            'money_total'        => $product_num * $arr_product['price'] + $arr_product['ship_fee'],
            'order_type'         => 'single',
            'money_type'         => '',
            'shop_id'            => $shop['shop_id'],
            'pei_type'           => $shop['pei_type'],
            'addr_id'            => $m_addr['addr_id'],
        );

        $html_hidden_input = null;
        foreach($order_input as $k => $v){
            $html_hidden_input .= "<input type='hidden' name='params[{$k}]' value='$v' />";
        }
        $this->pagedata['m_addr'] = $m_addr;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['data'] = $order_input;
        $this->pagedata['product'] = $arr_product;
        $this->pagedata['html_hidden_input'] = $html_hidden_input;
//        $this->tmpl = 'pintuan/order_single.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/order_single.html';
    }

    /**
     * 团购产品, 分团类型,  新开团操作
     */
    public function order_tuan()
    {

        $this->check_login();
        //判断团购产品属性,如果属性为  无需购买开团, 则跳过设置地址,支付步骤, 直接成功,然后邀请他人参团,
        //无需购买, 生成订单金额为0, 产品数量为 0,  仅做标记读取用,  订单页面不展示数目为 0 的订单.
        //如果是 需要购买, 进入购买页面进行操作, 计算金额等
        $product_id = (int) $this->GP('product_id');
        $product_num = (int) $this->GP('num');
        $master_need_buy = 1;
        $product_num = $product_num < 1 ? 1 : $product_num;
        //团购属性封装规则为   attr_name:attr_value.attr_name:attr_value
        $product_attr = "客户选择属性为: " . K::M('pintuan/productattr')->attr_get_to_string(); //加到订单备注中, 放到隐藏字段传递
        //价格选择原价,生成input表单 ,   产品id, 产品price, 产品数量, 产品属性
        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $product_id));
        $shop = K::M('shop/shop')->detail($arr_product['shop_id']);
        if(!$arr_product['pintuan_product_id']){
            $this->error(404); //产品不存在
        }

        $order_input = array(); //订单表单数据
        $arr_product['intro'] = K::M('pintuan/product')->intro_short($arr_product['intro']);
        if($arr_product['money_pre'] > 0){
            //预付款模式, 运费最后付 (普通团/阶梯团)
            $money_pre = $arr_product['money_pre'] * $product_num;
            $ship_fee = $arr_product['ship_fee'];
            $is_money_pre = 1;
        }
        else{
            //正常付款模式,  (普通团)
            $money_pre = $arr_product['tuan_price'] * $product_num;
            $ship_fee = $arr_product['ship_fee'];
            $is_money_pre = 0;
        }
        if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
            $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
        }
        if(2 == $shop['pei_type']){
            $shop['pei_type'] = 1;
        }
        $order_input = array(
            'tuan_time'          => $arr_product['tuan_time'],
            'product_title'      => $arr_product['title'],
            'pintuan_product_id' => $arr_product['pintuan_product_id'],
            'product_price'      => $arr_product['tuan_price'],
            'product_money'      => $arr_product['tuan_price'] * $product_num,
            'product_num'        => $product_num,
            'product_attr'       => $product_attr,
            'ship_fee'           => $ship_fee,
            'money_master'       => $arr_product['money_master'],
            'money_pre'          => $money_pre,
            'money_total'        => 0,
            'order_type'         => 'tuan',
            'from'               => 'weidian_pintuan',
            'money_type'         => '',
            'shop_id'            => $shop['shop_id'],
            'pei_type'           => $shop['pei_type'],
            'addr_id'            => $m_addr['addr_id'],
            'master_need_buy'    => $master_need_buy,
            'is_money_pre'       => $is_money_pre,
        );

        if(1 == $arr_product['tuan_type']){
            //----------------阶梯团 流程已更改,在html内判断流程,代码暂时不删,----------------
//            if(1 == $arr_product['master_need_buy']){
            //团长需要购买
            $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
            $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
//            }
//            else if(1 == $_GET['master_need_buy']){
//                //团长选择购买
//                $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
//                $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
//            }
//            else{
//                $order_input['product_num'] = 0;
//                $order_input['ship_fee'] = 0;
//                $order_input['money_pre'] = 0;
//                $order_input['money_total'] = 0;
//                $order_input['product_money'] = 0;
//            }
            //----------------阶梯团----------------
        }
        else{
            //----------------普通团 流程已更改,在html内判断流程,代码暂时不删,----------------
//            if(1 == $arr_product['master_need_buy']){
            //团长需要购买
            $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
            $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
//            }
//            elseif(1 == $_GET['master_need_buy']){
//                //团长选择购买
//                $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
//                $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
//            }
//            else{
//                $order_input['product_num'] = 0;
//                $order_input['ship_fee'] = 0;
//                $order_input['money_pre'] = 0;
//                $order_input['money_total'] = 0;
//                $order_input['product_money'] = 0;
//            }
            //----------------普通团----------------
        }
        $html_hidden_input = null;
        foreach($order_input as $k => $v){
            $html_hidden_input .= "
                <input type='hidden' name='params[{$k}]' id='{$k}' value='$v' />
                <input type='hidden' name='{$k}_old' id='{$k}_old' value='$v' />
                ";
        }
        $this->pagedata['m_addr'] = $m_addr;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['data'] = $order_input;
        $this->pagedata['product'] = $arr_product;
        $this->pagedata['html_hidden_input'] = $html_hidden_input;
//        $this->tmpl = 'pintuan/order_tuan.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/order_tuan.html';
    }

    /**
     * 生成订单
     * 说明: 拼团的产品属性, 放到留言内,  接 传递过来的 product_attr 字段
     */
    public function order_create()
    {
        $this->check_login();
        //分,单买, 和团购,二种状态,
        if(IS_AJAX){
            if($params = $this->checksubmit('params')){

                $order_count = 0 == $params['master_need_buy'] ? 0 : 1; // 是否团长必须购买
                $nums = (int) $params['product_num'];

                if(!$shop_id = (int) $params['shop_id']){
                    $this->msgbox->add('商家不存在', 210);
                }
                else if(!$shop = K::M('shop/shop')->detail($shop_id)){
                    $this->msgbox->add('商家不存在', 211);
                }
                else if(!$pid = (int) $params['pintuan_product_id']){
                    $this->msgbox->add('商品不存在', 212);
                }
                else if(!$p = K::M('pintuan/product')->find(array('pintuan_product_id' => $pid))){
                    $this->msgbox->add('商品不存在', 213);
                }
                else if($p['shop_id'] != $shop_id){
                    $this->msgbox->add('非法操作', 213);
                }
                else if($nums == 0 && $order_count > 0){  // 如果团长必须购买则判断商品数量
                    $this->msgbox->add('商品数量不存在', 214);
                }
                else if($p['stock'] < $nums && $order_count > 0){
                    $this->msgbox->add('商品库存不足', 215);
                }
                else if((int) $params['pei_type'] == 3 && $shop['is_ziti'] == 0){
                    $this->msgbox->add('商家不支持自提', 216);
                }
                else if((int) $params['pei_type'] != 3 && !$params['addr_id']){
                    $this->msgbox->add('收货地址不存在', 216);
                }
                else if((int) $params['pei_type'] != 3 && !$addr = K::M('member/addr')->detail((int) $params['addr_id'])){
                    $this->msgbox->add('收货地址不存在', 217);
                }
                else{
                    if($params['order_type'] == 'tuan'){  // 如果是多人购买
                        $group = array(
                            'city_id'             => $shop['city_id'],
                            'shop_id'             => $shop_id,
                            'group_title'         => $params['group_title'], //组团标题
                            'user_num'            => $p['user_num'], //product的成团人数 
                            'master_id'           => $this->uid,
                            'start_time'          => __TIME,
                            'end_time'            => __TIME + $p['tuan_time'] * 86400,
                            'order_count'         => $order_count, //如果不买，就是 0
                            'order_success_count' => 0, //未支付， 0 
                            'status'              => 0,
                            'pintuan_product_id'  => $p['pintuan_product_id'],
                            'money_pre'           => $p['money_pre'],
                        );
                    }
                    else{                                // 如果是单人购买
                        $group = array(
                            'city_id'             => $shop['city_id'],
                            'shop_id'             => $shop_id,
                            'user_num'            => 1,
                            'master_id'           => $this->uid,
                            'start_time'          => __TIME,
                            'end_time'            => __TIME + $p['tuan_time'] * 86400,
                            'order_count'         => 1,
                            'status'              => 0, //支付成功,更改status 为 1 
                            'pintuan_product_id'  => $p['pintuan_product_id'],
                            'order_count'         => 1, //如果不买，就是 0
                            'order_success_count' => 0, //未支付， 0 , 支付成功 1
                            'money_pre'           => $p['money_pre'],
                        );
                    }

                    $pintuan_group_id = K::M('pintuan/group')->create($group);
                    $data = array(
                        'city_id'      => $shop['city_id'],
                        'shop_id'      => $shop_id,
                        'uid'          => $this->uid,
                        'from'         => 'weidian_pintuan',
                        'order_status' => 0,
                        'online_pay'   => 1,
                        'pay_status'   => 0,
                        'intro'        => $params['product_attr'],
                        'staff_id'     => 0,
                        'order_from'   => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    );

                    $product_price = $p['tuan_price'] * $nums;

                    if(2 == $shop['pei_type']){
                        $shop['pei_type'] = 1;
                    }
                    if($order_count > 0 || 'single' == $params['order_type']){
                        //如果团长必须购买
                        //单人团必须购买
                        if((int) $params['pei_type'] == 3){  // 自提
                            $freight = 0;
                            $data['amount'] = $product_price;
                            $data['contact'] = $this->MEMBER['nickname'];
                            $data['mobile'] = $this->MEMBER['mobile'];
                            $data['pei_type'] = 3;
                            $data['pei_amount'] = 0;
                            $data['o_lat'] = $shop['lat'];
                            $data['o_lng'] = $shop['lng'];
                            $data['total_price'] = $product_price;
                        }
                        else{                              // 配送
                            $freight = $p['ship_fee'];
                            $data['amount'] = $product_price + $freight;
                            $data['contact'] = $addr['contact'];
                            $data['mobile'] = $addr['mobile'];
                            $data['addr'] = $addr['addr'];
                            $data['house'] = $addr['house'];
                            $data['lng'] = $addr['lng'];
                            $data['lat'] = $addr['lat'];
                            $data['pei_type'] = $shop['pei_type'];
                            $data['pei_amount'] = $freight;
                            $data['total_price'] = $product_price + $freight;
                        }
                    }
                    else{         // 团长无需购买直接支付订单成功
                        die;
                        $data['pay_status'] = 1;
                    }

                    // 创建订单记录
                    if($order_id = K::M('order/order')->create($data)){
                        $order = K::M('order/order')->detail($order_id);

                        // 创建子订单
                        $pdata = array(
                            'order_id'         => $order_id,
                            'product_name'     => $p['title'],
                            'product_number'   => $nums,
                            'product_price'    => $product_price,
                            'tuan_time'        => $p['tuan_time'],
                            'money_master'     => 0,
                            'freight'          => $freight,
                            'pintuan_group_id' => $pintuan_group_id,
                            'uid'              => $this->uid,
                            'is_money_pre'     => $params['is_money_pre'],
                        );
                        //组团有佣金
                        if($params['order_type'] == 'tuan'){
                            $pdata['money_master'] = $p['money_master'];
                        }

                        if(1 == $params['is_money_pre']){
                            $pdata['money_need_pay'] = $p['money_pre'];
                        }
                        K::M('pintuan/order')->create($pdata);
                        // 自提单在支付成功之后生成消费码
                        K::M('pintuan/order')->update($order_id, array('spend_number' => 0, 'spend_status' => 0));

                        // 创建订单商品记录 可用于再来一单
                        if($order_count > 0 || 'single' == $params['order_type']){
                            $opdata = array(
                                'order_id'       => $order_id,
                                'product_id'     => $p['pintuan_product_id'],
                                'product_name'   => $p['title'],
                                'product_price'  => $p['tuan_price'],
                                'package_price'  => $freight,
                                'product_number' => $nums,
                                'amount'         => $order['amount'],
                            );
                        }
                        else{
                            $opdata = array(
                                'order_id'       => $order_id,
                                'product_id'     => $p['pintuan_product_id'],
                                'product_name'   => $p['title'],
                                'product_price'  => $p['tuan_price'],
                                'package_price'  => 0,
                                'product_number' => 0,
                                'amount'         => 0,
                            );
                        }
                        K::M('pintuan/orderproduct')->create($opdata);
                        K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                        $this->msgbox->add('开团成功');
                        $arr_group = K::M('pintuan/order')->find(array('order_id' => $order_id));
                        $arr_ret = array(
                            'order_id'         => $order_id,
                            'pay_status'       => $order['pay_status'],
                            'pintuan_group_id' => $arr_group['pintuan_group_id'],
                            'total_price'      => $order['total_price'],
                            'amount'           => $order['amount'],
                            'dateline'         => $order['dateline']
                        );
                        $this->msgbox->set_data('order', $arr_ret);
                    }
                }
            }
        }
    }

    /**
     * 拼团玩法
     */
    public function tuan_intro()
    {
        $array = array(
            'from' => 'help',
            'page' => 'help_pintuan',
        );
        $register = K::M('article/article')->find($array);
        $content = K::M('article/content')->detail($register['article_id']);
        $register['content'] = $content['content'];
        $this->pagedata['register'] = $register;
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_intro.html';
    }

    /**
     * 参团,订单选择地址,页面,
     */
    public function tuan_join_order()
    {
        $this->check_login();


        //判断团购产品属性,如果属性为  无需购买开团, 则跳过设置地址,支付步骤, 直接成功,然后邀请他人参团,
        //无需购买, 生成订单金额为0, 产品数量为 0,  仅做标记读取用,  订单页面不展示数目为 0 的订单.
        //如果是 需要购买, 进入购买页面进行操作, 计算金额等
        $product_id = (int) $this->GP('product_id');
        $product_num = (int) $this->GP('num');
        $group_id = (int) $this->GP('group_id');
        $master_need_buy = empty($_GET['master_need_buy']) ? $_GET['master_need_buy'] : 1;
        $product_num = $product_num < 1 ? 1 : $product_num;

        //返回当前产品用户的收藏状态
        if(!$this->uid){
            $is_collect = 0;
        }
        else{
            if(!$pintuan_collect = K::M('pintuan/collect')->find(array('pintuan_product_id' => $arr_product['pintuan_product_id'], 'uid' => $this->uid))){
                $is_collect = 0;
            }
            else{
                $is_collect = 1;
            }
        }

        //团购属性封装规则为   attr_name:attr_value.attr_name:attr_value
        $product_attr = "客户选择属性为: " . K::M('pintuan/productattr')->attr_get_to_string(); //加到订单备注中, 放到隐藏字段传递
        //价格选择原价,生成input表单 ,   产品id, 产品price, 产品数量, 产品属性
        $arr_product = K::M('pintuan/product')->find(array('pintuan_product_id' => $product_id));
        $shop = K::M('shop/shop')->detail($arr_product['shop_id']);
        if(!$arr_product['pintuan_product_id']){
            $this->error(404); //产品不存在
        }

        $order_input = array(); //订单表单数据

        if($arr_product['money_pre'] > 0){
            //预付款模式, 运费最后付 (普通团/阶梯团)
            $money_pre = $arr_product['money_pre'] * $product_num;
            $ship_fee = $arr_product['ship_fee'];
        }
        else{
            //正常付款模式,  (普通团)
            $money_pre = $arr_product['tuan_price'] * $product_num;
            $ship_fee = $arr_product['ship_fee'];
        }
        if(!$m_addr = K::M('member/addr')->find(array('uid' => $this->uid, 'is_default' => 1))){
            $m_addr = K::M('member/addr')->find(array('uid' => $this->uid));
        }
        if(2 == $shop['pei_type']){
            $shop['pei_type'] = 1;
        }
        $order_input = array(
            'group_id'           => $group_id,
            'tuan_time'          => $arr_product['tuan_time'],
            'product_title'      => $arr_product['title'],
            'pintuan_product_id' => $arr_product['pintuan_product_id'],
            'product_price'      => $arr_product['tuan_price'],
            'product_money'      => $arr_product['tuan_price'] * $product_num,
            'product_num'        => $product_num,
            'product_attr'       => $product_attr,
            'ship_fee'           => $ship_fee,
            'money_master'       => $arr_product['money_master'],
            'money_pre'          => $money_pre,
            'money_total'        => 0,
            'order_type'         => 'tuan',
            'money_type'         => '',
            'shop_id'            => $shop['shop_id'],
            'pei_type'           => $shop['pei_type'],
            'addr_id'            => $m_addr['addr_id'],
            'master_need_buy'    => $master_need_buy,
        );

        if(1 == $arr_product['tuan_type']){
//            die('jieti');
//            
            //----------------阶梯团----------------
            //团长需要购买
            $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
            $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
            //----------------阶梯团----------------
        }
        else{
            //----------------普通团----------------
            //团长需要购买
            $order_input['money_total'] = $arr_product['money_pre'] > 0 ? $product_num * $arr_product['money_pre'] : $product_num * $arr_product['tuan_price'] + $arr_product['ship_fee'];
            $order_input['money_type'] = $arr_product['money_pre'] > 0 ? '预付款' : '';
            //----------------普通团----------------
        }
        $html_hidden_input = null;
        foreach($order_input as $k => $v){
            $html_hidden_input .= "<input type='hidden' name='params[{$k}]' value='$v' />
                ";
        }
        $this->pagedata['m_addr'] = $m_addr;
        $this->pagedata['shop'] = $shop;
        $this->pagedata['data'] = $order_input;
        $this->pagedata['product'] = $arr_product;

        $this->pagedata['html_hidden_input'] = $html_hidden_input;
        $this->tmpl = 'pintuan/tuan_join_order.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_join_order.html';
    }

    /**
     * 参团生成订单界面, 
     */
    public function tuan_join_create()
    {
        $this->check_login();
        //分,单买, 和团购,二种状态,
        if(IS_AJAX){
            if($params = $this->checksubmit('params')){

                $order_count = 1; // 是否团长必须购买
                $nums = (int) $params['product_num'];

                $group_id = (int) $params['group_id'];
                $return = K::M('pintuan/order')->check_tuan_join($group_id, $this->uid);

                if(2 == $return['status']){
                    $this->msgbox->add($return['message'], 230);
                }
                else if(!$shop_id = (int) $params['shop_id']){
                    $this->msgbox->add('商家不存在', 210);
                }
                else if(!$shop = K::M('shop/shop')->detail($shop_id)){
                    $this->msgbox->add('商家不存在', 211);
                }
                else if(!$group_id = (int) $params['group_id']){
                    $this->msgbox->add('团不存在', 218);
                }
                else if(!$group = K::M('pintuan/group')->detail($group_id)){
                    $this->msgbox->add('团不存在.', 219);
                }
                else if(!$pid = (int) $params['pintuan_product_id']){
                    $this->msgbox->add('商品不存在', 212);
                }
                else if(!$p = K::M('pintuan/product')->find(array('pintuan_product_id' => $pid))){
                    $this->msgbox->add('商品不存在', 213);
                }
                else if($p['shop_id'] != $shop_id){
                    $this->msgbox->add('非法操作', 213);
                }
                else if($nums == 0 && $order_count > 0){  // 如果团长必须购买则判断商品数量
                    $this->msgbox->add('商品数量不存在', 214);
                }
                else if($p['stock'] < $nums && $order_count > 0){
                    $this->msgbox->add('商品库存不足', 215);
                }
                else if((int) $params['pei_type'] == 3 && $shop['is_ziti'] == 0){
                    $this->msgbox->add('商家不支持自提', 216);
                }
                else if((int) $params['pei_type'] != 3 && !$params['addr_id']){
                    $this->msgbox->add('收货地址不存在', 216);
                }
                else if((int) $params['pei_type'] != 3 && !$addr = K::M('member/addr')->detail((int) $params['addr_id'])){
                    $this->msgbox->add('收货地址不存在', 217);
                }
                else{


                    $pintuan_group_id = $group_id;
                    $data = array(
                        'city_id'      => $shop['city_id'],
                        'shop_id'      => $shop_id,
                        'uid'          => $this->uid,
                        'from'         => 'weidian_pintuan',
                        'order_status' => 0,
                        'online_pay'   => 1,
                        'pay_status'   => 0,
                        'intro'        => $params['product_attr'],
                        'staff_id'     => 0,
                        'order_from'   => (defined('IN_WEIXIN') ? 'weixin' : 'wap'),
                    );

                    $product_price = $p['tuan_price'] * $nums;
                    if(2 == $shop['pei_type']){
                        $shop['pei_type'] = 1;
                    }
                    // 如果团长必须购买
                    if((int) $params['pei_type'] == 3){  // 自提
                        $freight = 0;
                        $data['amount'] = $product_price;
                        $data['contact'] = $this->MEMBER['nickname'];
                        $data['mobile'] = $this->MEMBER['mobile'];
                        $data['pei_type'] = 3;
                        $data['pei_amount'] = 0;
                        $data['o_lat'] = $shop['lat'];
                        $data['o_lng'] = $shop['lng'];
                        $data['total_price'] = $product_price;
                    }
                    else{                              // 配送
                        $freight = $p['ship_fee'];
                        $data['amount'] = $product_price + $freight;
                        $data['contact'] = $addr['contact'];
                        $data['mobile'] = $addr['mobile'];
                        $data['addr'] = $addr['addr'];
                        $data['house'] = $addr['house'];
                        $data['lng'] = $addr['lng'];
                        $data['lat'] = $addr['lat'];
                        $data['pei_type'] = $shop['pei_type'];
                        $data['pei_amount'] = $freight;
                        $data['total_price'] = $product_price + $freight;
                    }



                    // 创建订单记录
                    if($order_id = K::M('order/order')->create($data)){
                        $update_group = array(
                            'order_count' => $group['order_count'] + 1
                        );
                        K::M('pintuan/group')->update($pintuan_group_id, $update_group);

                        $order = K::M('order/order')->detail($order_id);

                        //预付款,还是全款
                        if($group['money_pre'] > 0){
                            $params['is_money_pre'] = 1;
                        }
                        else{
                            $params['is_money_pre'] = 0;
                        }
                        // 创建子订单
                        $pdata = array(
                            'order_id'         => $order_id,
                            'product_name'     => $p['title'],
                            'product_number'   => $nums,
                            'product_price'    => $product_price,
                            'tuan_time'        => $p['tuan_time'],
                            'money_master'     => 0,
                            'freight'          => $freight,
                            'pintuan_group_id' => $pintuan_group_id,
                            'uid'              => $this->uid,
                            'is_money_pre'     => $params['is_money_pre'],
                        );
                        //组团有佣金
                        $pdata['money_master'] = $p['money_master'];
                        if(1 == $params['is_money_pre']){
                            $pdata['money_need_pay'] = $p['money_pre'];
                        }

                        K::M('pintuan/order')->create($pdata);
                        // 自提单在支付成功之后生成消费码
                        K::M('pintuan/order')->update($order_id, array('spend_number' => 0, 'spend_status' => 0));

                        // 创建订单商品记录 可用于再来一单
                        $opdata = array(
                            'order_id'       => $order_id,
                            'product_id'     => $p['pintuan_product_id'],
                            'product_name'   => $p['title'],
                            'product_price'  => $p['tuan_price'],
                            'package_price'  => $freight,
                            'product_number' => $nums,
                            'amount'         => $order['amount'],
                        );

                        K::M('pintuan/orderproduct')->create($opdata);
                        K::M('order/log')->create(array('order_id' => $order_id, 'from' => 'member', 'log' => '订单已提交', 'type' => 1));
                        $this->msgbox->add('订单提交成功');
                        $this->msgbox->set_data('order', array('order_id' => $order_id, 'pay_status' => $order['pay_status']));
                    }
                }
            }
        }
    }

    /**
     * 拼团ajax判断,是否已经参团,给出警告
     * @param type $group_id
     */
    public function ajax_tuan_join($group_id)
    {
        $group_id = (int) $group_id > 0 ? $group_id : (int) $this->GP('group_id');
        $return = K::M('pintuan/order')->check_tuan_join($group_id, $this->uid);
        print_r(json_encode($return));
        exit();
    }

    /**
     * 参团详细页, group_id = xxx, 作为参团标识
     */
    public function tuan_join($group_id)
    {
        $group_id = $group_id < 1 ? (int) $this->GP('group_id') : $group_id;
        K::M('pintuan/group')->group_auto_check($group_id); //检测当前团自动过期

        //检测团长是否购买,未购买,不允许分享
        $master_is_buy = K::M('pintuan/group')->master_is_buy($group_id);

        if(0 == $master_is_buy){
            header('Location:/pintuan/index');
            exit();
        }

        if(!$arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id))){
            $this->error(404);
        }
        else if(!$arr_order = K::M('pintuan/order')->order_from_group_id($arr_group['pintuan_group_id'])){
            $this->error(404);
        }
        else if(!$arr_product = K::M('pintuan/product')->detail($arr_group['pintuan_product_id'])){
            $this->error(404);
        }

        $level_html = K::M('pintuan/productlevel')->level_html($arr_product['pintuan_product_id'], $arr_group);
        $attr_html = K::M('pintuan/productattr')->attr_html($arr_product['pintuan_product_id']);

        //关于,是否适合组团条件的判断,已经放到点击参团事件中,  
        //模板元素 状态已经在模板中展示
        $arr_group['leave_person'] = $arr_group['user_num'] - $arr_group['order_count'] > 0 ? $arr_group['user_num'] - $arr_group['order_success_count'] : 0;
        $arr_group['ymd'] = date('Y-m-d', $arr_group['dateline']);
        $arr_group['his'] = date('H:i:s', $arr_group['dateline']);
        $arr_group['nickname'] = $arr_order[0]['nickname'];
        $arr_group['face'] = $arr_order[0]['face'];


        $i = 0;
        foreach($arr_order as $k => $v){
            if($i > 10){
                break;
            }
            $tuanzhang = 0 == $i ? "<img src='/themes/default/weidian/orange/static/images/tuan-icon.png' class='img-2'>" : '';

            $tuan_person_icon .= "
                <span>
                    <img src='/attachs/{$v['face']}' class='img-1'>
                    {$tuanzhang}
                </span>
                    ";
            $i++;
        }
        $arr_group['tuan_person_icon'] = $tuan_person_icon;

      
        $block = array();
        $block['relate_product'] = K::M('pintuan/product')->relate_pintuan_product($arr_product['pintuan_product_id'], $this->uid, 0);
        $this->pagedata['block'] = $block;

        $arr_collect = K::M('pintuan/collect')->find(array('pintuan_product_id' => $arr_product['pintuan_product_id'], 'uid' => $this->uid));
        $this->pagedata['collect'] = $arr_collect;

        //拼团商家信息

        $shop_html = K::M('pintuan/collect')->shop_cache_clear($arr_product['shop_id']);
        $block['shop_html'] = K::M('pintuan/collect')->shop_html($arr_product['shop_id']);
        $this->pagedata['block'] = $block;

        $this->pagedata['page'] = $page;
        $arr_product['attr_html'] = $attr_html;
        $arr_product['level_html'] = $level_html;
        $arr_product['money_master'] = 0; //不展示 佣金团 信息
        $this->pagedata['product'] = $arr_product;
        $this->pagedata['group'] = $arr_group;

//        if(isset($_GET['detail']) && 'info' == $_GET['detail']){
//            //详情页
//            $this->tmpl = 'pintuan/tuan_join_detail.html';
//        }
//        else{
//            $this->tmpl = 'pintuan/tuan_join.html';
//        }

        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_join.html';
    }

    /**
     * 我的团列表, 有3个选项卡,
     */
    public function tuan_my()
    {
        $this->check_login();
        $overdue = K::M('pintuan/group')->group_auto_check(); //检测自动过期
        //包含三种状态, 组团中/成功/失败,
        //测试是每页2个订单,正式上线后,将 2 改为 10, 控制器和模板都需要改
        $page = max((int) $this->GP('page'), 1);
        $count = $list = array();
        $count['count_0'] = K::M('pintuan/group')->user_group_count_weidian($this->uid, 100);
        $count['count_1'] = K::M('pintuan/group')->user_group_count_weidian($this->uid, 0);
        $count['count_2'] = K::M('pintuan/group')->user_group_count_weidian($this->uid, 1);
        $count['count_3'] = K::M('pintuan/group')->user_group_count_weidian($this->uid, 2);


        $this->pagedata['page'] = $page;
        $this->pagedata['count'] = $count;
        $this->pagedata['list'] = $list;

//        $this->tmpl = 'pintuan/tuan_my.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_my.html';
    }

    public function ajax_tuan_my()
    {
        //0:全部  1loading 2succ 3failure
        $now = time();
        $filter = array();
        $limit = max((int) $this->GP('limit'), 10); //接收 js 传递的翻页值
        $page = max((int) $this->GP('page'), 1);
        $status = (int) $this->GP('status'); //3种状态
        if(!in_array($status, array(0,1,2,3))){
            $status = 100;
        }
        $list = $this->tuan_my_status($this->uid, $status, $page, $limit);
        $arr_order_id = array();
        $arr_product_id = array();
        foreach($list as $k =>$v){
            $arr_order_id[] = $v['order_id'];
            $arr_product_id[] = $v['pintuan_product_id'];
        }
        header("Content-type: text/html; charset=utf-8");

        $arr_product_list = K::M('pintuan/product')->items(array('pintuan_product_id' => $arr_product_id));
        $arr_order = K::M('order/order')->items(array('order_id'=>$arr_order_id));
        foreach($list as $k =>$v){
            $list[$k]['arr_order'] = $arr_order[$k];
        }
//header("Content-type: text/html; charset=utf-8");
//echo '<pre>------<hr />    ';
//print_r($arr_product_list);
//die('</pre>');
        $count = K::M('pintuan/group')->user_group_count_weidian($this->uid, $status);
        $return_html = null;
        $view_params = K::M('order/order')->view_params;
        foreach($list as $k => $v){
            $person_leave = $v['user_num'] - $v['order_success_count'];

            $status = $v['status'];
            $display_status = $view_params['order_status']['select'][$v['arr_order']['order_status']];
            if("未处理" == $display_status && 0 == $v['status']){
                $display_status = "组团中";//合并之后,新增状态
            }

            $is_ziti = 3 == $v['pei_type'] ? "<span class='self-tidan-tit'>自提单</span>" : '';

            $button_cancel = $button_pay = $button_see = '';


            if(0 == $v['arr_order']['order_status'] && 0 == $v['arr_order']['pay_status']){
                $button_cancel = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn' id='cancel' order_id='" . $v['order_id'] . "'>取消订单</span></a>";
                $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>去付款</span></a>";
                $display_status = '未付款';
            }

            if(0 == $v['arr_order']['order_status'] && 0 == $v['arr_order']['pay_status'] && 1 == $v['arr_order']['is_money_pre']){
                $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>预付款</span></a>";
            }

            if(in_array($v['arr_order']['order_status'], array(3, 4))){
                $button_confirm = "<a href='javascript:;' style='margin-right:0.4rem' ><span class='pub_btn active' id='arrived' order_id='" . $v['order_id'] . "'>确认送达</span></a>";
            }

//            if(1336 == $v['order_id']){
//                header("Content-type: text/html; charset=utf-8");
//                echo '<pre>------<hr />    ';
//                print_r($v);
//                die('</pre>');
//                echo 'xxx';die;
//            }
            //付尾款按钮,$pintuan_order['money_paid'] >= $order['amount']
            if(1 == $v['arr_order']['pay_status'] && 1 == $v['is_money_pre'] && $v['arr_order']['amount'] > $v['money_paid']){

                if(0 == $v['status']){
                    $display_status = '组团中(已付预付款)';
                }

                else if(1 == $v['status']){
                    //已付款,待付尾款,分阶梯团二种状态,

                    if(1 == $arr_product_list[$v['pintuan_product_id']]['tuan_type']){
                        //阶梯团                            //时间+86400,可以付款
                        if($now > $v['end_time']){
                            $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>付尾款</span></a>";
                            $display_status = '待付尾款';
                        }
                        else{
                            $display_status = '组团中(已付预付款)';
                        }
                    }
                    else{
                        $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>付尾款</span></a>";
                        $display_status = '待付尾款';
                    }
                }
            }

            switch($status){
                case 0:
                    $tuan_notice = "<span class='maincl'>团购进行中</span><br/>(还差{$person_leave}人)";
                    break;
                case 1:
                    $tuan_notice = "<span class='maincl'>组团成功</span><br/>({$v['user_num']}人团)";
                    break;
                case 2:
                    $tuan_notice = "<span class='maincl'>团购失败</span><br/>(还差{$person_leave}人)";
                    break;
            }
            $return_html .= "
                            <div class='card one_item'>
                                <div class='card-content'>
                                    <div class='list-block media-list'>
                                        <ul>
                                            <li class='item-content'>
                                                <div class='item-media'> <a href='" . $this->mklink('weidian/pintuan/tuan_order_detail', $v['order_id']) . "'><img
                                                        src='/attachs/{$v['photo']}' ></a> </div>
                                                <div class='item-inner'>
                                                    <div class='item-title'>【{$v['product_name']}】<br/> {$v['pintuan_group_id']}/{$v['order_id']}</div>
                                                    <div class='item-title-row'>
                                                        <div class='item-text'>
                                                        	<span class='color1 mr10'>{$v['user_num']}人团</span>
                                                            <span class='color2'><em class='f_size2'>￥{$v['product_price']}</em></span>
                                                        </div>
                                                        <div class='item-after'>
                                                            <p class='color2'>{$display_status}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='card-footer'>
                                <a type='button'
                                           href='" . $this->mklink('weidian/pintuan/tuan_detail', $v['pintuan_group_id']) . "'
                                           class='button button-cancel' value='查看团详情'>查看团详情</a>
                                        <a type='button'
                                           href='" . $this->mklink('weidian/pintuan/tuan_order_detail', $v['order_id']) . "'
                                           class='button button-cancel' value='查看订单'>查看订单</a>
                                </div>
                            </div>
                            
                            ";
        }

        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('count_num' => $count, 'html' => $return_html,));
    }

    public function tuan_my_status($uid, $status, $page = 1, $limit = 30)
    {
        //包含三种状态, 组团中
        $page = max((int) $this->GP('page'), 1);
//        echo $status;die;
        $list = K::M('pintuan/group')->user_group_list_weidian($this->uid, $status, $page, $limit);
        return $list;
    }

    /**
     * 我的团订单列表, 待处理/已完成
     */
    public function tuan_order_list()
    {
        $this->check_login();
        $overdue = K::M('pintuan/group')->group_auto_check(); //检测自动过期
        //包含三种状态, 组团中/成功/失败,
        //测试是每页2个订单,正式上线后,将 2 改为 10, 控制器和模板都需要改
        $page = max((int) $this->GP('page'), 1);
        $count = $list = array();
        $count['count_0'] = K::M('pintuan/group')->user_order_count($this->uid, 0);
        $count['count_1'] = K::M('pintuan/group')->user_order_count($this->uid, 1);
        //内容不在这里展示
        $reason = K::M('order/order')->get_reason();
        $this->pagedata['reason'] = $reason['pintuan'];
        $this->pagedata['view_params'] = K::M('order/order')->view_params;
        $this->pagedata['page'] = $page;
        $this->pagedata['count'] = $count;
        $this->pagedata['list'] = $list;

        $this->tmpl = 'pintuan/tuan_order_list.html';
    }

    public function tuan_order_list_status($uid, $status, $page = 1, $limit = 30)
    {
        //包含三种状态, 组团中
        $page = max((int) $this->GP('page'), 1);
//        echo $status;die;
        $list = K::M('pintuan/group')->user_order_list($this->uid, $status, $page, $limit);
        return $list;
    }

    public function ajax_tuan_order_list()
    {
        $filter = array();
        $limit = max((int) $this->GP('limit'), 10); //接收 js 传递的翻页值
        $page = max((int) $this->GP('page'), 1);
        $status = (int) $this->GP('status'); //2种状态
//        $status = 0;
        $list = $this->tuan_order_list_status($this->uid, $status, $page, $limit);
        //查找团状态
        $arr_order_id = array();
        $arr_product_id = array();
        foreach($list as $k => $v){
            $arr_order_id[] = $v['order_id'];
            $arr_product_id[] = $v['product_id'];
        }

        $arr_group_status = K::M('pintuan/order')->order_group_status_list($arr_order_id);
        $arr_product_id = array_unique($arr_product_id);
        $arr_product_list = K::M('pintuan/product')->items(array('pintuan_product_id' => $arr_product_id));
        $filter['status'] = $status;
        $count = K::M('pintuan/group')->user_order_count($this->uid, $status);

        $return_html = null;
        $view_params = K::M('order/order')->view_params;
        $now = time() - 5;
        if($count > 0){
            foreach($list as $k => $v){
                $button_pay = "";
                $person_leave = $v['user_num'] - $v['order_success_count'];
                $status = $v['status'];
                $display_status = $view_params['order_status']['select'][$v['order_status']];
                $is_ziti = 3 == $v['pei_type'] ? "<span class='self-tidan-tit'>自提单</span>" : '';

                $button_cancel = $button_pay = $button_see = '';

                if(0 == $v['order_status'] && 0 == $v['pay_status']){
                    $button_cancel = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn' id='cancel' order_id='" . $v['order_id'] . "'>取消订单</span></a>";
                    $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>去付款</span></a>";
                    $display_status = '未付款';
                }

                if(0 == $v['order_status'] && 0 == $v['pay_status'] && 1 == $v['is_money_pre']){
                    $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>预付款</span></a>";
                }

                if(in_array($v['order_status'], array(3, 4))){
                    $button_confirm = "<a href='javascript:;' style='margin-right:0.4rem' ><span class='pub_btn active' id='arrived' order_id='" . $v['order_id'] . "'>确认送达</span></a>";
                }
                //付尾款按钮,$pintuan_order['money_paid'] >= $order['amount']
                if(1 == $v['pay_status'] && 1 == $v['is_money_pre'] && $v['amount'] > $v['money_paid']){
                    if(0 == $arr_group_status[$v['order_id']]['status']){
                        $display_status = '组团中(已付预付款)';
                    }
                    else if(1 == $arr_group_status[$v['order_id']]['status']){
                        //已付款,待付尾款,分阶梯团二种状态,
                        if(1 == $arr_product_list[$v['product_id']]['tuan_type']){
                            //阶梯团                            //时间+86400,可以付款
                            if($now > $arr_group_status[$v['order_id']]['end_time']){
                                $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>付尾款</span></a>";
                                $display_status = '待付尾款';
                            }
                            else{
                                $display_status = '组团中(已付预付款)';
                            }
                        }
                        else{
                            $button_pay = "<a href='#' style='margin-right:0.4rem'><span class='pub_btn active' id='payment' order_id='" . $v['order_id'] . "'>付尾款</span></a>";
                            $display_status = '待付尾款';
                        }
                    }
                }


                $button_see = "<a style='margin-right:0.4rem' href='" . $this->mklink('pintuan/tuan_order_detail', $v['order_id']) . "'><span class='pub_btn' order_id='" . $v['order_id'] . "'>查看订单</span></a>";



                $return_html .= "
                        <div class='one_item'>
                                <div class='list-block' style='margin-top:0.5rem;'>
                                    <ul>
                                        <li class='item-content  border_t border_b tdanhao'>
                                            <div class='item-inner'>
                                                <div class='item-title'><a href='" . $this->mklink('pintuan/shop', $v['shop_id']) . "'>{$v['shop_name']}{$is_ziti}</a></div>
                                                <div class='item-after'><span class='fontcl1'>{$display_status}</span></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class='list-block media-list'>
                                    <ul>
                                        <li>
                                            <div class='item-content'>
                                                <div class='item-media'><a href='" . $this->mklink('weidian/pintuan/tuan_order_detail', $v['order_id']) . "'><img
                                                        src='/attachs/{$v['photo']}'
                                                        style='width: 4.2rem;'></a></div>
                                                <div class='item-inner'>
                                                    <div class='item-title-row'>
                                                        <div class='item-title overflow_clear'><a href='" . $this->mklink('weidian/pintuan/tuan_order_detail', $v['order_id']) . "'>{$v['product_name']}</a></div>
                                                    </div>
                                                    <div class='item-subtitle black9'><span class='shuliang'>" . date('Y-m-d H:i:s', $v['dateline']) . "</span>
                                                    </div>
                                                    <div class='item-subtitle cheng-color'>￥{$v['product_price']}/件</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class='bar-tab paying_button border_b' style='padding-top:0.5rem;text-align:right'>

                                    {$button_cancel}
                                    {$button_pay}
                                    {$button_see}
                                        {$button_confirm}
                                </div>
                        </div>";
            }
        }
        else{
            $return_html = "<div class='content-block biaoqian-content'>
                        <div class='wushuju'>
                            <img src='/themes/default/static/images/kong.png' width='30%'>

                            <p class='mt10'>暂无数据，<a href='" . $this->mklink('pintuan') . "'><span
                                    class='fontcl1'>马上去逛逛~</span></a></p>

                        </div>
                    </div>";
        }
        $this->msgbox->add('success');
        $this->msgbox->set_data('data', array('count_num' => $count, 'html' => $return_html,));
    }

    /**
     * 团订单详情
     */
    public function tuan_order_detail($order_id)
    {
        $this->check_login();
        $order_id = (int) $order_id > 0 ? $order_id : (int) $this->GP('order_id');
        $order = K::M('order/order')->detail($order_id);
        if(empty($order)){
            $this->error(404);
        }

        $order['shop'] = K::M('shop/shop')->detail($order['shop_id']);
        $order['pintuan_order'] = $porder = K::M('pintuan/order')->detail($order['order_id']);
        $pop = K::M('pintuan/orderproduct')->find(array('order_id' => $order['order_id']));
        $product = K::M('pintuan/product')->detail($pop['product_id']);
        $order['pintuan_order']['photo'] = $product['photo'];
        $reason = K::M('order/order')->get_reason();
        $order['reason'] = $reason['pintuan'];
        $pgroup = K::M('pintuan/group')->detail($porder['pintuan_group_id']);
        $order['group_status'] = $pgroup['status'];


        $orderiew_params = K::M('order/order')->view_params;
        $display_status = $orderiew_params['order_status']['select'][$order['order_status']];
        if(0 == $order['order_status'] && 0 == $order['pay_status']){
            $display_status = '未付款';
        }

        $now = time() - 5;
        $button_pay_weikuan = 0;
        if(1 == $order['pay_status'] && 1 == $order['pintuan_order']['is_money_pre'] && $order['amount'] > $order['pintuan_order']['money_paid']){
            if(0 == $order['group_status']){
                $display_status = '组团中(已付预付款)';
            }
            else if(1 == $order['group_status'] || 3 == $order['group_status']){
                //已付款,待付尾款,分阶梯团二种状态,
                if(1 == $product['tuan_type']){
                    //阶梯团                            //时间+86400,可以付款
                    if($now > $pgroup['end_time']){
                        $button_pay_weikuan = 1;
                        $display_status = '待付尾款';
                    }
                    else{
                        $display_status = '组团中(已付预付款)';
                    }
                }
                else{
                    $button_pay_weikuan = 1;
                    $display_status = '待付尾款';
                }
            }
        }

        $arr_city = K::M("data/city")->find($order['city_id']);
        header("Content-type: text/html; charset=utf-8");

        $order['city_name'] = $arr_city['city_name'];

        $this->pagedata['button_pay_weikuan'] = $button_pay_weikuan;

        $this->pagedata['display_status'] = $display_status;
        $this->pagedata['order'] = $order;
//        $this->tmpl = 'pintuan/tuan_order_detail.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_order_detail.html';
    }

    /**
     * 踢人
     */
    public function tuan_kick()
    {
        $return = array('status' => 1, 'message' => null);
        $uid = $this->uid;
        $group_id = (int) $this->GP('group_id');
        $order_id = (int) $this->GP('order_id');
        $message = K::M('pintuan/group')->group_kick($uid, $group_id, $order_id);
        $return['message'] = $message;

        print_r(json_encode($return));
        exit();
        //如果订单未支付,可以踢人,
    }

    /**
     * 团详情,  团长踢人等动作
     */
    public function tuan_detail($group_id)
    {
        $group_id = (int) $group_id > 0 ? $group_id : (int) $this->GP('group_id');
        K::M('pintuan/group')->group_auto_check($group_id); //检测当前团是否过期
        if(!$arr_group = K::M('pintuan/group')->find(array('pintuan_group_id' => $group_id))){

            $this->error(404);
        }
        else if(!$arr_order = K::M('pintuan/order')->order_from_group_id($arr_group['pintuan_group_id'])){
            $this->error(404);
        }
        else if(!$arr_product = K::M('pintuan/product')->detail($arr_group['pintuan_product_id'])){
            $this->error(404);
        }

        $arr_product['intro'] = K::M('pintuan/product')->intro_short($arr_product['intro']);

        //判断,只有团成员,才可以看团信息
        $allow_user = K::M('pintuan/order')->order_from_group_id($arr_group['pintuan_group_id'], 1);
        $arr_allow_user = array($arr_group['master_id']);
        foreach($allow_user as $v){
            $arr_allow_user[] = $v['uid'];
        }
        $arr_allow_user = array_unique($arr_allow_user);
        if(!in_array($this->uid, $arr_allow_user)){
            $link = $this->mklink('weidian/pintuan/tuan_my');
            header("location:" . $link);
            exit();
        }


        $arr_user = K::M('member/member')->select(array('uid' => $arr_allow_user));

        $now = time();
        //注意阶梯团,和普通团,的区别, 测试阶梯团,补充代码,
        //团购信息输出------------开始
        $arr_group['leave_second'] = $arr_group['end_time'] - $now > 0 ? $arr_group['end_time'] - $now : 0;
        $arr_group['leave_person'] = $arr_group['user_num'] - $arr_group['order_count'] > 0 ? $arr_group['user_num'] - $arr_group['order_success_count'] : 0;

        $i = 0;
        $tuan_person_icon = null;
        $tuan_person_html = null;
        $master_id = $arr_group['master_id']; //团长,可以踢人

        foreach($arr_order as $k => $v){
            //根据主订单表状态,判断是否允许踢人,
            $dateline_1 = date('Y-m-d', $v['dateline']);
            $dateline_2 = date('H:i', $v['dateline']);
            $tuanzhang = $shafa = $tichu = null;
            $tuanzhang = 0 == $i ? "<img src='/themes/default/weidian/orange/static/images/tuan-icon.png' class='img-2'>" : '';
            $shafa = 1 == $i ? "<img src='/themes/default/static/images/shafa.png' class='img2'>" : '';

            $tuan_person_icon .= "
                <span>
                    <img src='/attachs/{$arr_user[$v['uid']]['face']}' class='img-1'>
                    {$tuanzhang}
                </span>
                    ";

            if(0 == $i){
                $tuan_person_html .= "
                        <li class='item-content'>
                            <div class='item-media'><i><img src='/attachs/{$arr_user[$v['uid']]['face']}' class='img-tuxiang'></i></div>
                            <div class='item-inner'>
                                <div class='item-title'><span class='black3 font-size75'><span class='fontcl1'>团长</span> {$arr_user[$v['uid']]['nickname']}</span></div>
                                <div class='item-after'>{$dateline_1} {$dateline_2} 开团</div>
                            </div>
                        </li>
                        ";
            }
            else{
                $shafa_html = 1 == $i ? "<i class='shafa'></i>" : '';
                $tuan_person_html .= "
                        <li class='item-content'>
                            <div class='item-media'><i><img src='/attachs/{$arr_user[$v['uid']]['face']}' class='img-tuxiang'></i></div>
                            <div class='item-inner'>
                                <div class='item-title'><span class='black3 font-size75'>{$arr_user[$v['uid']]['nickname']}</span></div>
                                <div class='item-after'>{$dateline_1} {$dateline_2} 开团</div>
                            </div>
                        </li>

                        ";
            }
            $i++;
        }
        //团购信息输出------------结束

        $arr_group['tuan_person_icon'] = $tuan_person_icon;
        $arr_group['tuan_person_html'] = $tuan_person_html;

        //相关产品
        $block = array();
        $block['relate_product'] = K::M('pintuan/product')->relate_pintuan_product($arr_product['pintuan_product_id'], $this->uid, 0);
        $this->pagedata['block'] = $block;

        //检测团长是否购买,未购买,不允许分享
        $master_is_buy = K::M('pintuan/group')->master_is_buy($group_id);


        $this->pagedata['master_is_buy'] = $master_is_buy;
        $this->pagedata['arr_group'] = $arr_group;
        $arr_order = $arr_order[0];
        $this->pagedata['arr_order'] = $arr_order;
        $this->pagedata['arr_product'] = $arr_product;
//        $this->tmpl = 'pintuan/tuan_detail.html';
        $this->tmpl = 'weidian/' . $this->default_weidian_theme() . '/pintuan/tuan_detail.html';
    }

    /**
     * 进行中的团,更多数据
     */
    public function tuan_loading()
    {
        $this->tuan_detail();
//        $this->tmpl = 'pintuan/tuan_loading.html';
    }

    // 取消订单
    public function order_cancel()
    {
        $this->check_login();
        $reason = $this->GP('reason');
        if(!$order_id = (int) $this->GP('order_id')){
            $this->msgbox->add('订单不存在', 210);
        }
        else if(!$order = K::M('order/order')->detail($order_id)){
            $this->msgbox->add('订单不存在', 212);
        }
        else if($order['uid'] != $this->uid){
            $this->msgbox->add('非法操作', 213);
        }
        else if($order['from'] != 'weidian_pintuan'){
            $this->msgbox->add('非法操作', 214);
        }
        else if($order['order_status'] < 0){
            $this->msgbox->add('订单已经取消，无需重复取消', 214);
        }
        else if($order['order_status'] != 0){
            $this->msgbox->add('当前订单是不可取消的状态', 215);
        }
        else if(K::M('order/order')->cancel($order_id, $order, 'member', $reason)){
            $this->msgbox->add('订单取消成功');
        }
        else{
            $this->msgbox->add('订单取消失败', 216);
        }
    }

    public function locate($shop_id)
    {
        $shop_id = (int) $shop_id;
        if(!$shop = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('商家不存在', 210);
        }
        else if($shop['audit'] != 1 || $shop['closed'] != 0){
            $this->msgbox->add('商家未审核或已被删除', 211);
        }
        else if($shop['pintuan'] != 1){
            $this->msgbox->add('商家未开通拼团功能', 212);
        }
        else{
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'pintuan/locate.html';
        }
    }

    /**
     * 退回预付款,系统计划任务,这里调试用
     */
    public function return_money_pre()
    {
        if($this->GP('ijh_test')){
            $res = K::M('pintuan/group')->money_7_days();
            echo $res;
        }
        else{
            echo 'no auth';
        }

        exit();
    }

}
