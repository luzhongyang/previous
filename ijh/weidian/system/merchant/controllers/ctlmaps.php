<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
    array(


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        '首页|fa fa-home|merchant/index' => array(
            array('title' => '管理中心','icon' => 'fa fa-cog', 'menu' => true,
                'items' => array(
                    array('title' => '管理中心', 'ctl' => 'merchant/index:index', 'menu' => true),
                )
            ),
            array('title' => '消息管理', 'menu' => true, 'icon' => 'fa fa-comment',
                'items' => array(
                    array('title' => '消息管理', 'ctl' => 'merchant/msg:order', 'menu' => true),
                    array('title' => '评价消息', 'ctl' => 'merchant/msg:comment', 'nav' => 'merchant/msg:order'),
                    array('title' => '投诉消息', 'ctl' => 'merchant/msg:complain', 'nav' => 'merchant/msg:order'),
                    array('title' => '系统消息', 'ctl' => 'merchant/msg:system', 'nav' => 'merchant/msg:order'),
                    array('title' => '订单消息详情', 'ctl' => 'merchant/order:detailorder', 'menu' => false),
                    array('title' => '评价消息详情', 'ctl' => 'merchant/order:detailcomment', 'menu' => false),
                    array('title' => '投诉消息详情', 'ctl' => 'merchant/order:detailcomplain', 'menu' => false),
                    array('title' => '系统消息详情', 'ctl' => 'merchant/order:detailsystem', 'menu' => false),
                )
            ),
            array('title' => '数据统计', 'icon' => 'fa fa-signal','menu' => true,
                'items' => array(
                    array('title' => '收入统计', 'ctl' => 'merchant/tongji:income', 'menu' => true),
                    array('title' => '收入统计', 'ctl' => 'merchant/tongji:w_income', 'nav' => 'merchant/tongji:income'),
                    array('title' => '团购、代金券收入统计', 'ctl' => 'merchant/tongji:t_income', 'nav' => 'merchant/tongji:income'),
                    array('title' => '优惠买单收入统计', 'ctl' => 'merchant/tongji:m_income', 'nav' => 'merchant/tongji:income'),
                    array('title' => '订单统计', 'ctl' => 'merchant/tongji:order', 'menu' => true),
                    array('title' => '外卖订单统计', 'ctl' => 'merchant/tongji:w_order', 'nav' => 'merchant/tongji:order'),
                    array('title' => '团购订单统计', 'ctl' => 'merchant/tongji:t_order', 'nav' => 'merchant/tongji:order'),
                    array('title' => '买单订单统计', 'ctl' => 'merchant/tongji:m_order', 'nav' => 'merchant/tongji:order'),
                    array('title' => '订单来源', 'ctl' => 'merchant/tongji:orderfrom', 'menu' => true),
                    array('title' => '团购订单来源', 'ctl' => 'merchant/tongji:t_orderfrom', 'nav' => 'merchant/tongji:orderfrom'),
                    array('title' => '外卖订单来源', 'ctl' => 'merchant/tongji:w_orderfrom', 'nav' => 'merchant/tongji:orderfrom'),
                    array('title' => '买单订单来源', 'ctl' => 'merchant/tongji:m_orderfrom', 'nav' => 'merchant/tongji:orderfrom'),
//                    array('title' => '商品销量', 'ctl' => 'merchant/tongji:product', 'menu' => true),

                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),

//        '团购|fa fa-group|merchant/tuan/tuan/index' => array(
//
//            array('title' => '团购管理','icon' => 'fa fa-gears',  'menu' => true,
//                'items' => array(
//                    array('title' => '团购管理', 'ctl' => 'merchant/tuan/tuan:index', 'menu' => true),
//                    array('title' => '添加团购', 'ctl' => 'merchant/tuan/tuan:create', 'nav' => 'merchant/tuan/tuan:index'),
//                    array('title' => '修改团购', 'ctl' => 'merchant/tuan/tuan:edit', 'nav' => 'merchant/tuan/tuan:index'),
//                    array('title' => '删除团购', 'ctl' => 'merchant/tuan/tuan:del', 'nav' => 'merchant/tuan/tuan:index'),
//                    array('title' => '团购商品上架', 'ctl' => 'merchant/tuan/tuan:onsale', 'nav' => 'merchant/tuan/tuan:index'),
//                    array('title' => '搜索团购商品', 'ctl' => 'merchant/tuan/tuan:so', 'nav' => 'merchant/tuan/tuan:index'),
//                )
//            ),
//            array('title' => '优惠买单','icon' => 'fa fa-cny', 'menu' => true,
//                'items' => array(
//                    array('title' => '优惠买单', 'ctl' => 'merchant/tuan/maidan:index', 'menu' => true),
//                    array('title' => '买单订单', 'ctl' => 'merchant/tuan/maidan:order', 'menu' => true),
//                    array('title' => '删除优惠', 'ctl' => 'merchant/tuan/maidan:delete', 'nav' => 'merchant/tuan/maidan:index'),
//                )
//            ),
//
//            array('title' => '订单管理', 'icon' => 'fa fa-file-text-o','menu' => true,
//                'items' => array(
//                    array('title' => '订单管理', 'ctl' => 'merchant/tuan/order:index', 'menu' => true),
//                    array('title' => '待支付', 'ctl' => 'merchant/tuan/order:waitpay', 'nav' => 'merchant/tuan/order:index'),
//                    array('title' => '已取消', 'ctl' => 'merchant/tuan/order:cancellist', 'nav' => 'merchant/tuan/order:index'),
//                    array('title' => '今日完成', 'ctl' => 'merchant/tuan/order:todaycomplete', 'nav' => 'merchant/tuan/order:index'),
//                    array('title' => '总完成', 'ctl' => 'merchant/tuan/order:allcomplete', 'nav' => 'merchant/tuan/order:index'),
//                    array('title' => '团购券管理', 'ctl' => 'merchant/tuan/order:ticket', 'menu' => true),
//                    array('title' => '团购券核销', 'ctl' => 'merchant/tuan/order:used', 'nav' => 'merchant/tuan/order:ticket'),
//                    array('title' => '团购券验证', 'ctl' => 'merchant/tuan/order:dialog', 'nav' => 'merchant/tuan/order:ticket'),
//                    array('title' => '团购验证', 'ctl' => 'merchant/tuan/order:check', 'nav' => 'merchant/tuan/order:ticket'),
//                    array('title' => '订单详情', 'ctl' => 'merchant/tuan/order:detail', 'nav' => 'merchant/tuan/order:index'),
//                )
//            ),
//        ),

        ///菜品管理单
        '微店|ico ico1|merchant/weidian/index' => array(
            array('title' => L('我的店铺'),'icon' => 'fa fa-institution', 'menu' => true,
                'items' => array(
                    array('title' => L('店铺信息'), 'ctl' => 'merchant/weidian:index', 'menu' => true),
                    array('title' => L('微店设置'), 'ctl' => 'merchant/weidian:open', 'menu' => true),
                    array('title' => L('微店开通'), 'ctl' => 'merchant/weidian:open', 'nav' => 'merchant/weidian:index'),

                    array('title' => L('广告管理'), 'ctl' => 'merchant/weidian/banner:index', 'menu' => true),
                    array('title' => L('创建广告'), 'ctl' => 'merchant/weidian/banner:create', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('设置状态'), 'ctl' => 'merchant/weidian/banner:audit', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('修改广告'), 'ctl' => 'merchant/weidian/banner:edit', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('删除广告'), 'ctl' => 'merchant/weidian/banner:delete', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('批量删除广告'), 'ctl' => 'merchant/weidian/banner:dels', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('搜索广告'), 'ctl' => 'merchant/weidian/banner:so', 'nav' => 'merchant/weidian/banner:index'),
                    array('title' => L('活动列表'), 'ctl' => 'merchant/weidian/huodong:index', 'menu' => true),
                    array('title' => L('创建活动'), 'ctl' => 'merchant/weidian/huodong:create', 'nav' => 'merchant/weidian/huodong:index'),
                    array('title' => L('修改活动'), 'ctl' => 'merchant/weidian/huodong:edit', 'nav' => 'merchant/weidian/huodong:index'),
                    array('title' => L('删除活动'), 'ctl' => 'merchant/weidian/huodong:delete', 'nav' => 'merchant/weidian/huodong:index'),
                    array('title' => L('批量删除活动'), 'ctl' => 'merchant/weidian/huodong:dels', 'nav' => 'merchant/weidian/huodong:index'),
                    array('title' => L('设置活动状态'), 'ctl' => 'merchant/weidian/huodong:set_status', 'nav' => 'merchant/weidian/huodong:index'),
                    array('title' => L('搜索活动'), 'ctl' => 'merchant/weidian/huodong:so', 'nav' => 'merchant/weidian/huodong:index'),
                )
            ),
            array('title' => '优惠券管理', 'icon' => 'fa fa-money', 'menu' => true,
                'items' => array(
                    array('title' => '优惠券列表', 'ctl' => 'merchant/shop/coupon:index', 'menu' => true),
                    array('title' => '创建优惠券', 'ctl' => 'merchant/shop/coupon:create', 'nav' => 'merchant/shop/coupon:create'),
                    array('title' => '修改优惠券', 'ctl' => 'merchant/shop/coupon:edit', 'nav' => 'merchant/shop/coupon:edit'),
                    array('title' => '删除优惠券', 'ctl' => 'merchant/shop/coupon:delete', 'nav' => 'merchant/shop/coupon:delete'),
                    array('title' => '搜索优惠券', 'ctl' => 'merchant/shop/coupon:so', 'nav' => 'merchant/shop/coupon:index'),
                )
            ),
            array('title' => L('商品管理'),'icon' => 'fa fa-archive','menu' => true,
                'items' => array(

                    array('title' => L('商品分类'), 'ctl' => 'merchant/weidian/productcate:index', 'menu' => true),
                    array('title' => L('添加分类'), 'ctl' => 'merchant/weidian/productcate:create', 'nav' => 'merchant/weidian/productcate:index'),
                    array('title' => L('修改分类'), 'ctl' => 'merchant/weidian/productcate:edit', 'nav' => 'merchant/weidian/productcate:index'),
                    array('title' => L('删除分类'), 'ctl' => 'merchant/weidian/productcate:delete', 'nav' => 'merchant/weidian/productcate:index'),
                    array('title' => L('更新分类'), 'ctl' => 'merchant/weidian/productcate:update', 'nav' => 'merchant/weidian/productcate:index'),
                    array('title' => L('更新分类'), 'ctl' => 'merchant/weidian/productcate:example', 'nav' => 'merchant/weidian/productcate:index'),

                    array('title' => L('普通商品'), 'ctl' => 'merchant/weidian/product:index', 'menu' => true),
                    array('title' => L('添加商品'), 'ctl' => 'merchant/weidian/product:create', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('修改商品'), 'ctl' => 'merchant/weidian/product:edit', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('搜索商品'), 'ctl' => 'merchant/weidian/product:so', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('删除商品'), 'ctl' => 'merchant/weidian/product:delete', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('更新商品'), 'ctl' => 'merchant/weidian/product:open', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('上架商品'), 'ctl' => 'merchant/weidian/product:onsale_open', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('上架商品'), 'ctl' => 'merchant/weidian/product:onsale_openall', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('下架商品'), 'ctl' => 'merchant/weidian/product:onsale_close', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('设置规格名称'), 'ctl' => 'merchant/weidian/product:set_name', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('设置规格属性'), 'ctl' => 'merchant/weidian/product:set_value', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('设置规格属性'), 'ctl' => 'merchant/weidian/product:get_attr', 'nav' => 'merchant/weidian/product:index'),
                    array('title' => L('设置是否开放分销'), 'ctl' => 'merchant/weidian/product:set_is_fenxiao', 'nav' => 'merchant/weidian/product:index'),

                )
            ),

            array('title' => L('订单管理'), 'icon' => 'fa fa-file-text-o','menu' => true,
                'items' => array(
                    array('title' => L('商品订单'), 'ctl' => 'merchant/weidian/order:index', 'menu' => true),
                    array('title' => L('待确认'), 'ctl' => 'merchant/weidian/order:wait', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('待发货'), 'ctl' => 'merchant/weidian/order:fahuo', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('待收货'), 'ctl' => 'merchant/weidian/order:shouhuo', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('已收货'), 'ctl' => 'merchant/weidian/order:confirm', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('已完成'), 'ctl' => 'merchant/weidian/order:complete', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('已取消'), 'ctl' => 'merchant/weidian/order:cancellist', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => L('自提单'), 'ctl' => 'merchant/weidian/order:ziti', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '接单按钮', 'ctl' => 'merchant/weidian/order:accept', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '发货按钮', 'ctl' => 'merchant/weidian/order:sendgoods', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '确认收货按钮', 'ctl' => 'merchant/weidian/order:service', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '确认完成按钮', 'ctl' => 'merchant/weidian/order:finish', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '核销按钮', 'ctl' => 'merchant/weidian/order:dialog', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '核销按钮', 'ctl' => 'merchant/weidian/order:setspend', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '取消订单', 'ctl' => 'merchant/weidian/order:cancel', 'nav' => 'merchant/weidian/order:index'),
                    array('title' => '订单评价', 'ctl' => 'merchant/weidian/comment:comment', 'menu' => true),
                    array('title' => '未回复的订单评价', 'ctl' => 'merchant/weidian/comment:comment_wait', 'nav' => 'merchant/weidian/comment:comment'),
                    array('title' => '回复订单评价', 'ctl' => 'merchant/weidian/comment:reply', 'nav' => 'merchant/weidian/comment:comment'),
                    array('title' => '订单评价详情', 'ctl' => 'merchant/weidian/comment:detail', 'nav' => 'merchant/weidian/comment:comment'),
                )
            )
,
        ),



        '拼团|ico ico2|merchant/weidian/index' => array(

            array('title' => L('商品管理'),'icon' => 'fa fa-archive','menu' => true,
                'items' => array(

                    array('title' => L('拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:index', 'menu' => true),
                    array('title' => L('添加拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:create', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('修改拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:edit', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('修改拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:so', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('删除拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:delete', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('更新拼团商品'), 'ctl' => 'merchant/weidian/pintuanproduct:update', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('设置规格名称'), 'ctl' => 'merchant/weidian/pintuanproduct:set_name', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('设置规格属性'), 'ctl' => 'merchant/weidian/pintuanproduct:set_value', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                    array('title' => L('设置规格属性'), 'ctl' => 'merchant/weidian/pintuanproduct:get_attr', 'nav' => 'merchant/weidian/pintuanproduct:index'),
                )
            ),
            array('title' => L('拼团管理'), 'icon' => 'fa fa-group','menu' => true,
                'items' => array(
                    array('title' => L('拼团管理'), 'ctl' => 'merchant/weidian/pintuangroup:index', 'menu' => true),
                    array('title' => L('更新拼团'), 'ctl' => 'merchant/weidian/pintuangroup:update', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('查看拼团'), 'ctl' => 'merchant/weidian/pintuangroup:detail', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('组团中-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:start', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('组团成功-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:process', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('组团失败-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:complete', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('商家已接单-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:ok', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('商家接单-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:status_ok', 'nav' => 'merchant/weidian/pintuangroup:index'),
                    array('title' => L('商家取消组团-拼团'), 'ctl' => 'merchant/weidian/pintuangroup:status_complete', 'nav' => 'merchant/weidian/pintuangroup:index'),

                    array('title' => L('拼团订单管理'), 'ctl' => 'merchant/weidian/pintuanorder:index', 'menu' => true),
                    array('title' => L('配送订单'), 'ctl' => 'merchant/weidian/pintuanorder:pei', 'nav' => 'merchant/weidian/pintuanorder:index'),
                    array('title' => L('配送完成'), 'ctl' => 'merchant/weidian/pintuanorder:delivered', 'nav' => 'merchant/weidian/pintuanorder:index'),
                    array('title' => L('订单完成'), 'ctl' => 'merchant/weidian/pintuanorder:complete', 'nav' => 'merchant/weidian/pintuanorder:index'),
                    array('title' => L('取消订单'), 'ctl' => 'merchant/weidian/pintuanorder:cancellist', 'nav' => 'merchant/weidian/pintuanorder:index'),
                    array('title' => L('配送订单'), 'ctl' => 'merchant/weidian/pintuanorder:pei', 'nav' => 'merchant/weidian/pintuanorder:index'),

                    array('title' => L('拼团佣金记录'), 'ctl' => 'merchant/weidian/pintuanyongjin:index', 'menu' => true),
                    array('title' => L('支付佣金'), 'ctl' => 'merchant/weidian/pintuanyongjin:pay', 'nav' => 'merchant/weidian/pintuanyongjin:index'),
                    array('title' => L('查看流水'), 'ctl' => 'merchant/weidian/pintuanyongjin:log', 'nav' => 'merchant/weidian/pintuanyongjin:index'),

                )
            ),

        ),


        '分销|fa fa-sitemap|merchant/weidian/index' => array(

            array('title' => L('微分销'),'icon' => 'fa fa-sitemap', 'menu' => true,
                'items' => array(
                    array('title' => L('分销设置'), 'ctl' => 'merchant/weidian/fenxiao:index', 'menu' => true),
                    array('title' => L('店铺列表'), 'ctl' => 'merchant/weidian/fenxiao:items', 'menu' => true),
                    array('title' => L('分销商品'), 'ctl' => 'merchant/weidian/fenxiao:product', 'menu' => true),
                    array('title' => L('分销订单'), 'ctl' => 'merchant/weidian/fenxiao:orders', 'menu' => true),
                    array('title' => L('分销待发货订单'), 'ctl' => 'merchant/weidian/fenxiao:f_fahuo', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('分销待收货订单'), 'ctl' => 'merchant/weidian/fenxiao:f_shouhuo', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('分销已收货订单'), 'ctl' => 'merchant/weidian/fenxiao:f_confirm', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('分销已完成订单'), 'ctl' => 'merchant/weidian/fenxiao:f_complete', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('分销已取消订单'), 'ctl' => 'merchant/weidian/fenxiao:f_cancellist', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('分销自提订单'), 'ctl' => 'merchant/weidian/fenxiao:f_ziti', 'nav' => 'merchant/weidian/fenxiao:orders'),
                    array('title' => L('设置状态'), 'ctl' => 'merchant/weidian/fenxiao:set_status', 'nav' => 'merchant/weidian/fenxiao:orders'),
                )
            ),
        ),


//        '外送|fa fa-motorcycle|merchant/waimai/product/index' => array(
//            array('title' => '商品管理', 'icon' => 'fa fa-archive','menu' => true,
//                'items' => array(
//                    array('title' => '商品管理', 'ctl' => 'merchant/waimai/product:index', 'menu' => true),
//                    array('title' => '分类管理', 'ctl' => 'merchant/waimai/cate:index', 'menu' => true),
//                    array('title' => '商品管理', 'ctl' => 'merchant/waimai/product:skunotice', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '库存管理', 'ctl' => 'merchant/waimai/product:stock_add', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '上架产品', 'ctl' => 'merchant/waimai/product:onsale_open', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '下架产品', 'ctl' => 'merchant/waimai/product:onsale_close', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '创建分类', 'ctl' => 'merchant/waimai/cate:create', 'nav' => 'merchant/waimai/cate:index'),
//                    array('title' => '修改分类', 'ctl' => 'merchant/waimai/cate:edit', 'nav' => 'merchant/waimai/cate:index'),
//                    array('title' => '删除分类', 'ctl' => 'merchant/waimai/cate:delete', 'nav' => 'merchant/waimai/cate:index'),
//                    array('title' => '创建商品', 'ctl' => 'merchant/waimai/product:create', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '修改商品', 'ctl' => 'merchant/waimai/product:edit', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '删除商品', 'ctl' => 'merchant/waimai/product:delete', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '商品规格', 'ctl' => 'merchant/waimai/product:specs', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '删除规格', 'ctl' => 'merchant/waimai/product:specs_del', 'nav' => 'merchant/waimai/product:index'),
//                    array('title' => '上架状态设置', 'ctl' => 'merchant/waimai/product:open', 'nav' => 'merchant/waimai/product:index'),
//
//                )
//            ),
//            array('title' => '外送订单', 'menu' => false,
//                'items' => array(
//                    array('title' => '快速管理', 'ctl' => 'merchant/waimai/ordermanage:index', 'menu' => false),
//                )
//            ),
//            array('title' => '订单管理','icon' => 'fa fa-file-text-o', 'menu' => true,
//                'items' => array(
//                    array('title' => '外送订单', 'ctl' => 'merchant/waimai/order:index', 'menu' => true),
//                    array('title' => '外送订单', 'ctl' => 'merchant/waimai/order:waimai', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '修改配送方式', 'ctl' => 'merchant/waimai/order:setpei', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '配送订单', 'ctl' => 'merchant/waimai/order:pei', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '配送完成订单', 'ctl' => 'merchant/waimai/order:delivered', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '完成的订单', 'ctl' => 'merchant/waimai/order:complete', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '取消的订单', 'ctl' => 'merchant/waimai/order:cancellist', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '自提订单', 'ctl' => 'merchant/waimai/order:ziti', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '配送按钮', 'ctl' => 'merchant/waimai/order:peisong', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '取消订单按钮', 'ctl' => 'merchant/waimai/order:cancel', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '完成订单按钮', 'ctl' => 'merchant/waimai/order:finish', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '接单按钮', 'ctl' => 'merchant/waimai/order:accept', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '订单详情', 'ctl' => 'merchant/waimai/order:detail', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '自提订单核销', 'ctl' => 'merchant/waimai/order:setspend', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '订单核销弹框', 'ctl' => 'merchant/waimai/order:dialog', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '打印小票', 'ctl' => 'merchant/waimai/order:porder', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '检查打印平台', 'ctl' => 'merchant/waimai/order:check_print', 'nav' => 'merchant/waimai/order:index'),
//                    array('title' => '在线云打印', 'ctl' => 'merchant/waimai/order:yun_print', 'nav' => 'merchant/waimai/order:index'),
//                )
//            ),
//            array('title' => '店铺设置','icon' => 'fa fa-institution', 'menu' => true,
//                'items' => array(
//                    array('title' => '店铺设置', 'ctl' => 'merchant/waimai:index', 'menu' => true),
//                    array('title' => '配送设置', 'ctl' => 'merchant/waimai/shop:pei', 'menu' => true),
//                    array('title' => '店铺设置', 'ctl' => 'merchant/waimai/shop:have', 'menu' => false),
//                    array('title' => '优惠设置', 'ctl' => 'merchant/waimai/shop:youhui', 'menu' => true),
//                    array('title' => '删除优惠', 'ctl' => 'merchant/waimai/shop:yhdelete', 'nav' => 'merchant/waimai/shop:youhui'),
//                )
//            ),
//        ),
//        '预约|fa fa-phone|merchant/yuyue/zhuohao/items' => array(
//            array('title' => '桌号管理','icon' => 'fa fa-cog', 'menu' => true,
//                'items' => array(
//                    array('title' => '桌号管理', 'ctl' => 'merchant/yuyue/zhuohao:items', 'menu' => true),
//                    array('title' => '分类管理', 'ctl' => 'merchant/yuyue/zhuohao:cate', 'menu' => true),
//                    array('title' => '添加桌号分类', 'ctl' => 'merchant/yuyue/zhuohao:cate_create', 'nav' => 'merchant/yuyue/zhuohao:cate'),
//                    array('title' => '修改桌号分类', 'ctl' => 'merchant/yuyue/zhuohao:cate_edit', 'nav' => 'merchant/yuyue/zhuohao:cate'),
//                    array('title' => '删除桌号分类', 'ctl' => 'merchant/yuyue/zhuohao:cate_delete', 'nav' => 'merchant/yuyue/zhuohao:cate'),
//                    array('title' => '添加桌号', 'ctl' => 'merchant/yuyue/zhuohao:zhuohao_create', 'nav' => 'merchant/yuyue/zhuohao:items'),
//                    array('title' => '修改桌号', 'ctl' => 'merchant/yuyue/zhuohao:zhuohao_edit', 'nav' => 'merchant/yuyue/zhuohao:items'),
//                    array('title' => '删除桌号', 'ctl' => 'merchant/yuyue/zhuohao:zhuohao_delete', 'nav' => 'merchant/yuyue/zhuohao:items'),
//                    array('title' => '搜索桌号', 'ctl' => 'merchant/yuyue/zhuohao:so', 'nav' => 'merchant/yuyue/zhuohao:items'),
//                )
//            ),
//            array('title' => '订单管理','icon' => 'fa fa-file-text-o',  'menu' => true,
//                'items' => array(
//                    array('title' => '排号订单', 'ctl' => 'merchant/yuyue/order:paidui', 'menu' => true),
//                    array('title' => '订座订单', 'ctl' => 'merchant/yuyue/order:dingzuo', 'menu' => true),
//                    array('title' => '排号订单选择桌号', 'ctl' => 'merchant/yuyue/order:paidui_choose_zhuohao', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '订座订单选择桌号', 'ctl' => 'merchant/yuyue/order:dingzuo_choose_zhuohao', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '排号订单接单', 'ctl' => 'merchant/yuyue/order:paidui_jiedan', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '排号订单取消', 'ctl' => 'merchant/yuyue/order:paidui_cancel', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '排号订单完成', 'ctl' => 'merchant/yuyue/order:paidui_complete', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '排号订单删除', 'ctl' => 'merchant/yuyue/order:paidui_delete', 'nav' => 'merchant/yuyue/order:paidui'),
//
//                    array('title' => '排号订单排队中列表', 'ctl' => 'merchant/yuyue/order:paidui_wait_items', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '排号订单已完成列表', 'ctl' => 'merchant/yuyue/order:paidui_complete_items', 'nav' => 'merchant/yuyue/order:paidui'),
//                    array('title' => '排号订单已取消列表', 'ctl' => 'merchant/yuyue/order:paidui_cancel_items', 'nav' => 'merchant/yuyue/order:paidui'),
//
//                    array('title' => '订座订单接单', 'ctl' => 'merchant/yuyue/order:dingzuo_jiedan', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '订座订单取消', 'ctl' => 'merchant/yuyue/order:dingzuo_cancel', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '订座订单完成', 'ctl' => 'merchant/yuyue/order:dingzuo_complete', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '订座订单删除', 'ctl' => 'merchant/yuyue/order:dingzuo_delete', 'nav' => 'merchant/yuyue/order:dingzuo'),
//
//                    array('title' => '订座订单排队中列表', 'ctl' => 'merchant/yuyue/order:dingzuo_wait_items', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '订座订单已完成列表', 'ctl' => 'merchant/yuyue/order:dingzuo_complete_items', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                    array('title' => '订座订单已取消列表', 'ctl' => 'merchant/yuyue/order:dingzuo_cancel_items', 'nav' => 'merchant/yuyue/order:dingzuo'),
//                )
//            )
//        ),




//    '微信' => array(
//        array('title'=>'微信设置', 'menu'=>true,
//            'items'=>array(
//                array('title'=>'公众号管理', 'ctl'=>'merchant/member:index', 'menu'=>true),
//                array('title'=>'关注回复', 'ctl'=>'merchant/member:fans', 'menu'=>true),
//                array('title'=>'关键字回复', 'ctl'=>'merchant/member:detail', 'nav'=>'merchant/member:index'),
//                array('title'=>'自定义菜单', 'ctl'=>'merchant/member:detail', 'nav'=>'merchant/member:index'),
//            )
//        ),
//        array('title'=>'素材管理', 'menu'=>true,
//            'items'=>array(
//                array('title'=>'单图文', 'ctl'=>'merchant/member:index', 'menu'=>true),
//            )
//        ),
//        array('title'=>'营销营销', 'menu'=>true,
//            'items'=>array(
//                array('title'=>'优惠券', 'ctl'=>'merchant/weixin/youhui', 'menu'=>true),
//                array('title'=>'刮刮卡', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'大转盘', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'砸金蛋', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'摇一摇', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'微助力', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'微接力', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'微信红包', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//                array('title'=>'微信卡券', 'ctl'=>'merchant/weixin/index', 'menu'=>true),
//            )
//        ),
//    ),
    '微信|fa fa-weixin' => array(
    array('title' => L('微信管理'),'icon' => 'fa fa-weixin','menu' => true,
        'items' => array(
            array('title' => L('微信管理'), 'ctl' => 'merchant/weixin/index:index', 'nav' => 'merchant/weixin/index:index', 'menu' => true),
            array('title' => L('绑定'), 'ctl' => 'merchant/weixin/index:bind', 'nav' => 'merchant/weixin/index:index'),
            array('title' => L('绑定公众号'), 'ctl' => 'merchant/weixin/index:wxloginpage', 'nav' => 'merchant/weixin/index:index'),
            array('title' => L('绑定公众号'), 'ctl' => 'merchant/weixin/index:wxcallback', 'nav' => 'merchant/weixin/index:index'),
            array('title' => L('单次关注'), 'ctl' => 'merchant/weixin/index:welcome', 'nav' => 'merchant/weixin/index:welcome', 'menu' => true),
            array('title' => L('自动回复'), 'ctl' => 'merchant/weixin/index:auto', 'nav' => 'merchant/weixin:index', 'menu' => true),
            array('title' => L('关键字回复'), 'ctl' => 'merchant/weixin/keyword:index', 'nav' => 'merchant/weixin/keyword:index', 'menu' => true),
            array('title' => L('添加关键字'), 'ctl' => 'merchant/weixin/keyword:create', 'nav' => 'merchant/weixin/keyword:index'),
            array('title' => L('修改关键字'), 'ctl' => 'merchant/weixin/keyword:edit', 'nav' => 'merchant/weixin/keyword:index'),
            array('title' => L('删除关键字'), 'ctl' => 'merchant/weixin/keyword:delete', 'nav' => 'merchant/weixin/keyword:index'),
            array('title' => L('自定义菜单'), 'ctl' => 'merchant/weixin/menu:index', 'nav' => 'merchant/weixin/menu:index', 'menu' => true),
            array('title' => L('添加菜单'), 'ctl' => 'merchant/weixin/menu:create', 'nav' => 'merchant/weixin/menu:index'),
            array('title' => L('修改菜单'), 'ctl' => 'merchant/weixin/menu:edit', 'nav' => 'merchant/weixin/menu:index'),
            array('title' => L('删除菜单'), 'ctl' => 'merchant/weixin/menu:delete', 'nav' => 'merchant/weixin/menu:index'),
            array('title' => L('同步菜单'), 'ctl' => 'merchant/weixin/menu:towechat', 'nav' => 'merchant/weixin/menu:index'),
        )
    ),
    array('title' => L('素材管理'),'icon' => 'fa fa-folder-o', 'menu' => true,
        'items' => array(
            array('title' => L('微信素材'), 'ctl' => 'merchant/weixin/reply:index', 'menu' => true),
            array('title' => L('添加素材'), 'ctl' => 'merchant/weixin/reply:create', 'nav' => 'merchant/weixin/reply:index'),
            array('title' => L('修改素材'), 'ctl' => 'merchant/weixin/reply:edit', 'nav' => 'merchant/weixin/reply:index'),
            array('title' => L('删除素材'), 'ctl' => 'merchant/weixin/reply:delete', 'nav' => 'merchant/weixin/reply:index'),
            array('title' => L('选择素材'), 'ctl' => 'merchant/weixin/reply:dialog', 'nav' => 'merchant/weixin/reply:index'),
        )
    ),
    array('title' => L('营销插件'),'icon' => 'fa fa-puzzle-piece', 'menu' => true,
        'items' => array(
            //优惠券
            array('title' => L('优惠券'), 'ctl' => 'merchant/weixin/coupon:index', 'nav' => 'merchant/weixin/coupon:index', 'menu' => true),
            array('title' => L('添加优惠券'), 'ctl' => 'merchant/weixin/coupon:create', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('修改优惠券'), 'ctl' => 'merchant/weixin/coupon:edit', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('删除优惠券'), 'ctl' => 'merchant/weixin/coupon:delete', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('领取优惠券'), 'ctl' => 'merchant/weixin/coupon:sign', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('优惠码'), 'ctl' => 'merchant/weixin/coupon:sn', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/coupon:preview', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/coupon:snedit', 'nav' => 'merchant/weixin/coupon:index'),
            array('title' => L('删除成员'), 'ctl' => 'merchant/weixin/coupon:sndelete', 'nav' => 'merchant/weixin/coupon:index'),

            //刮刮卡
            array('title' => L('刮刮卡'), 'ctl' => 'merchant/weixin/scratch:index', 'nav' => 'merchant/weixin/scratch:index', ),
            array('title' => L('添加刮刮卡'), 'ctl' => 'merchant/weixin/scratch:create', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('修改刮刮卡'), 'ctl' => 'merchant/weixin/scratch:edit', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('删除刮刮卡'), 'ctl' => 'merchant/weixin/scratch:delete', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('领取优惠券'), 'ctl' => 'merchant/weixin/scratch:sign', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/scratch:sn', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/scratch:sndelete', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/scratch:snedit', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/scratch:preview', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('奖品'), 'ctl' => 'merchant/weixin/scratch:goods', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('添加奖品'), 'ctl' => 'merchant/weixin/scratch:goodscreate', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('修改奖品'), 'ctl' => 'merchant/weixin/scratch:goodsedit', 'nav' => 'merchant/weixin/scratch:index'),
            array('title' => L('删除奖品'), 'ctl' => 'merchant/weixin/scratch:goodsdelete', 'nav' => 'merchant/weixin/scratch:index'),

            //大转盘
            array('title' => L('大转盘'), 'ctl' => 'merchant/weixin/lottery:index', 'nav' => 'merchant/weixin/lottery:index', ),
            array('title' => L('添加大转盘'), 'ctl' => 'merchant/weixin/lottery:create', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('修改大转盘'), 'ctl' => 'merchant/weixin/lottery:edit', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('删除大转盘'), 'ctl' => 'merchant/weixin/lottery:delete', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/lottery:sn', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/lottery:sndelete', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/lottery:snedit', 'nav' => 'merchant/weixin/lottery:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/lottery:preview', 'nav' => 'merchant/weixin/lottery:index'),

            //砸金蛋
            array('title' => L('砸金蛋'), 'ctl' => 'merchant/weixin/goldegg:index', 'nav' => 'merchant/weixin/goldegg:index', ),
            array('title' => L('添加砸金蛋'), 'ctl' => 'merchant/weixin/goldegg:create', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('修改砸金蛋'), 'ctl' => 'merchant/weixin/goldegg:edit', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('删除砸金蛋'), 'ctl' => 'merchant/weixin/goldegg:delete', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/goldegg:sn', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/goldegg:sndelete', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/goldegg:snedit', 'nav' => 'merchant/weixin/goldegg:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/goldegg:preview', 'nav' => 'merchant/weixin/goldegg:index'),

            //红包
            array('title' => L('抢红包'), 'ctl' => 'merchant/weixin/packet:index', 'nav' => 'merchant/weixin/packet:index',),
            array('title' => L('添加红包'), 'ctl' => 'merchant/weixin/packet:create', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('修改红包'), 'ctl' => 'merchant/weixin/packet:edit', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('删除红包'), 'ctl' => 'merchant/weixin/packet:delete', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('兑换'), 'ctl' => 'merchant/weixin/packet:logs', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/packet:sn', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/packet:sndelete', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/packet:snedit', 'nav' => 'merchant/weixin/packet:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/packet:preview', 'nav' => 'merchant/weixin/packet:index'),

            //卡券
            /*
            array('title'=>L('卡券'), 'ctl'=>'merchant/weixin/card:index','nav'=>'merchant/weixin/card:index','menu'=>true),
            array('title'=>L('添加卡券'), 'ctl'=>'merchant/weixin/card:create', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('修改卡券'), 'ctl'=>'merchant/weixin/card:edit', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('删除卡券'), 'ctl'=>'merchant/weixin/card:delete', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('中奖用户'), 'ctl'=>'merchant/weixin/card:sn', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('删除用户'), 'ctl'=>'merchant/weixin/card:sndelete', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('改变状态'), 'ctl'=>'merchant/weixin/card:snedit', 'nav'=>'merchant/weixin/card:index'),
            array('title'=>L('预览'), 'ctl'=>'merchant/weixin/card:preview', 'nav'=>'merchant/weixin/card:index'),
            */
            //摇一摇
            array('title' => L('摇一摇'), 'ctl' => 'merchant/weixin/shake:index', 'nav' => 'merchant/weixin/shake:index', ),
            array('title' => L('添加摇一摇'), 'ctl' => 'merchant/weixin/shake:create', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('修改摇一摇'), 'ctl' => 'merchant/weixin/shake:edit', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('删除摇一摇'), 'ctl' => 'merchant/weixin/shake:delete', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('领取优惠券'), 'ctl' => 'merchant/weixin/shake:sign', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/shake:sn', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/shake:sndelete', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/shake:snedit', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/shake:preview', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('奖品'), 'ctl' => 'merchant/weixin/shake:goods', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('添加奖品'), 'ctl' => 'merchant/weixin/shake:goodscreate', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('修改奖品'), 'ctl' => 'merchant/weixin/shake:goodsedit', 'nav' => 'merchant/weixin/shake:index'),
            array('title' => L('删除奖品'), 'ctl' => 'merchant/weixin/shake:goodsdelete', 'nav' => 'merchant/weixin/shake:index'),

            //微助力
            array('title' => L('微助力'), 'ctl' => 'merchant/weixin/help:index', 'nav' => 'merchant/weixin/help:index', ),
            array('title' => L('添加微助力'), 'ctl' => 'merchant/weixin/help:create', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('修改微助力'), 'ctl' => 'merchant/weixin/help:edit', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('删除微助力'), 'ctl' => 'merchant/weixin/help:delete', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('领取优惠券'), 'ctl' => 'merchant/weixin/help:sign', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/help:sn', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/help:sndelete', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/help:snedit', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/help:preview', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('奖品'), 'ctl' => 'merchant/weixin/help:goods', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('添加奖品'), 'ctl' => 'merchant/weixin/help:goodscreate', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('修改奖品'), 'ctl' => 'merchant/weixin/help:goodsedit', 'nav' => 'merchant/weixin/help:index'),
            array('title' => L('删除奖品'), 'ctl' => 'merchant/weixin/help:goodsdelete', 'nav' => 'merchant/weixin/help:index'),

            //微接力
            array('title' => L('微接力'), 'ctl' => 'merchant/weixin/relay:index', 'nav' => 'merchant/weixin/relay:index', ),
            array('title' => L('添加微接力'), 'ctl' => 'merchant/weixin/relay:create', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('修改微接力'), 'ctl' => 'merchant/weixin/relay:edit', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('删除微接力'), 'ctl' => 'merchant/weixin/relay:delete', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('领取优惠券'), 'ctl' => 'merchant/weixin/relay:sign', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('中奖用户'), 'ctl' => 'merchant/weixin/relay:sn', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('删除用户'), 'ctl' => 'merchant/weixin/relay:sndelete', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('改变状态'), 'ctl' => 'merchant/weixin/relay:snedit', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('预览'), 'ctl' => 'merchant/weixin/relay:preview', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('奖品'), 'ctl' => 'merchant/weixin/relay:goods', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('添加奖品'), 'ctl' => 'merchant/weixin/relay:goodscreate', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('修改奖品'), 'ctl' => 'merchant/weixin/relay:goodsedit', 'nav' => 'merchant/weixin/relay:index'),
            array('title' => L('删除奖品'), 'ctl' => 'merchant/weixin/relay:goodsdelete', 'nav' => 'merchant/weixin/relay:index'),

        )
    )
),
        '店铺|fa fa-institution|merchant/shop/coupon' => array(
            array('title' => '基本设置','icon' => 'fa fa-gears', 'menu' => true,
                'items' => array(
//                    array('title' => '店铺首页', 'ctl' => 'merchant/shop:see', 'menu' => true),
                    array('title' => '资料设置', 'ctl' => 'merchant/shop:index', 'menu' => true),
                    array('title' => '安全设置', 'ctl' => 'merchant/shop:passwd', 'nav' => 'merchant/shop:index'),
                    array('title' => '获取商圈', 'ctl' => 'merchant/shop:get_business', 'nav' => 'merchant/shop:index'),
                    array('title' => '更换手机', 'ctl' => 'merchant/shop:mobile', 'nav' => 'merchant/shop:index'),
                    array('title' => '提现帐号', 'ctl' => 'merchant/shop:account', 'nav' => 'merchant/shop:index'),
                    array('title' => '店铺认证', 'ctl' => 'merchant/shop/verify:index', 'menu' => true),
                    array('title' => '店主认证', 'ctl' => 'merchant/shop/verify:dianzhu', 'nav' => 'merchant/shop/verify:index'),
                    array('title' => '企业认证', 'ctl' => 'merchant/shop/verify:yyzz', 'nav' => 'merchant/shop/verify:index'),
                    array('title' => '餐饮认证', 'ctl' => 'merchant/shop/verify:canyin', 'nav' => 'merchant/shop/verify:index'),
//                    array('title' => '功能开通', 'ctl' => 'merchant/shop/open:index', 'menu' => true),
//                    array('title' => '功能开通', 'ctl' => 'merchant/shop/open:save', 'nav' => 'merchant/shop/open:save'),
//                    array('title' => '打印设置', 'ctl' => 'merchant/shop/print:index', 'menu' => true),
//                    array('title' => '添加设置', 'ctl' => 'merchant/shop/print:create', 'nav' => 'merchant/shop/print:index'),
//                    array('title' => '相册设置', 'ctl' => 'merchant/shop/album:index', 'menu' => true),
//                    array('title' => '添加相册', 'ctl' => 'merchant/shop/album:create', 'nav' => 'merchant/shop/album:index'),
//                    array('title' => '修改相册', 'ctl' => 'merchant/shop/album:edit', 'nav' => 'merchant/shop/album:index'),
//                    array('title' => '删除相册', 'ctl' => 'merchant/shop/album:delete', 'nav' => 'merchant/shop/album:index'),
//                    array('title' => '管理相册', 'ctl' => 'merchant/shop/album:detail', 'nav' => 'merchant/shop/album:index'),
                    array('title' => '修改设置', 'ctl' => 'merchant/shop/print:edit', 'nav' => 'merchant/shop/print:index'),
                    array('title' => '删除设置', 'ctl' => 'merchant/shop/print:delete', 'nav' => 'merchant/shop/print:index'),
                    array('title' => '开启或静默', 'ctl' => 'merchant/shop/print:change', 'nav' => 'merchant/shop/print:index'),
                )
            ),

//            array('title' => '评价管理','icon' => 'fa fa-star-half-full', 'menu' => true,
//                'items' => array(
////                    array('title' => '店铺评价', 'ctl' => 'merchant/shop/comment:index', 'menu' => true),
////                    array('title' => '店铺评价回复', 'ctl' => 'merchant/shop/comment:reply', 'nav' => 'merchant/shop/comment:index'),
////                    array('title' => '店铺评价详情', 'ctl' => 'merchant/shop/comment:detail', 'nav' => 'merchant/shop/comment:index'),
////                    array('title' => '外卖评价', 'ctl' => 'merchant/waimai/comment:index', 'menu' => true),
////                    array('title' => '外卖评价', 'ctl' => 'merchant/waimai/comment:items', 'nav' => 'merchant/waimai/comment:index'),
////                    array('title' => '外卖评价回复', 'ctl' => 'merchant/waimai/comment:reply', 'nav' => 'merchant/waimai/comment:index'),
////                    array('title' => '外卖评价详情', 'ctl' => 'merchant/waimai/comment:detail', 'nav' => 'merchant/waimai/comment:index'),
////                    array('title' => '店铺评价回复dialog', 'ctl' => 'merchant/shop/comment:reply_dialog', 'nav' => 'merchant/shop/comment:index'),
////                    array('title' => '外卖评价回复dialog', 'ctl' => 'merchant/waimai/comment:reply_dialog', 'nav' => 'merchant/waimai/comment:index'),
//                )
//            ),
            array('title' => '客户管理', 'icon' => 'fa fa-user-plus', 'menu' => true,
                'items' => array(
                    array('title' => '我的客户', 'ctl' => 'merchant/shop/member:index', 'menu' => true),
                    array('title' => '我的粉丝', 'ctl' => 'merchant/shop/member:fans', 'menu' => true),
                    array('title' => '详情', 'ctl' => 'merchant/shop/member:detail', 'nav' => 'merchant/shop/member:index'),
                )
            ),
            array('title' => '资金管理','icon' => 'fa fa-database', 'menu' => true,
                'items' => array(
                    array('title' => '资金管理', 'ctl' => 'merchant/shop/money:index', 'menu' => true),
                    array('title' => '提现日志', 'ctl' => 'merchant/shop/money:txlog', 'menu' => true),
                    array('title' => '提现', 'ctl' => 'merchant/shop/money:tixian', 'nav' => 'merchant/shop/money:txlog'),
                )
            ),
            array('title' => '订单设置','icon' => 'fa fa-database', 'menu' => true,
                'items' => array(
                    array('title' => '订单设置', 'ctl' => 'merchant/shop/trade:selffetch', 'menu' => true),
                    array('title' => '上门自提', 'ctl' => 'merchant/shop/trade:selffetch', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '同城配送', 'ctl' => 'merchant/shop/trade:localdelivery', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '快递发货', 'ctl' => 'merchant/shop/trade:delivery', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '交易设置', 'ctl' => 'merchant/shop/trade:setting', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '添加运费模板', 'ctl' => 'merchant/shop/trade:deliveryadd', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '修改运费模板', 'ctl' => 'merchant/shop/trade:deliveryedit', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '删除运费模板', 'ctl' => 'merchant/shop/trade:deliverydel', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '删除配送区域', 'ctl' => 'merchant/shop/trade:areadel', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '添加自提点', 'ctl' => 'merchant/shop/trade:selffetchadd', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '修改自提点', 'ctl' => 'merchant/shop/trade:selffetchedit', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '删除自提点', 'ctl' => 'merchant/shop/trade:selffetchdel', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => 'ajax请求城市数据', 'ctl' => 'merchant/shop/trade:ajaxregion', 'nav' => 'merchant/shop/trade:selffetch'),
                    array('title' => '保存选中regionids', 'ctl' => 'merchant/shop/trade:saveregions', 'nav' => 'merchant/shop/trade:selffetch'),
                )
            ),
        ),
);
