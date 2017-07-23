<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
array(


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    'index' => array(
        array('title'=>'管理中心', 'menu'=>true,
            'items'=>array(
                array('title'=>'管理中心', 'ctl'=>'biz/index:index', 'menu'=>true),
            )
        ),
        array('title'=>'消息管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'订单消息', 'ctl'=>'biz/msg:order', 'menu'=>true),
                array('title'=>'评价消息', 'ctl'=>'biz/msg:comment', 'menu'=>true),
                array('title'=>'投诉消息', 'ctl'=>'biz/msg:complain', 'menu'=>true),
                array('title'=>'系统消息', 'ctl'=>'biz/msg:system', 'menu'=>true),
                array('title'=>'订单消息详情', 'ctl'=>'biz/order:detailorder', 'menu'=>false),
                array('title'=>'评价消息详情', 'ctl'=>'biz/order:detailcomment', 'menu'=>false),
                array('title'=>'投诉消息详情', 'ctl'=>'biz/order:detailcomplain', 'menu'=>false),
                array('title'=>'系统消息详情', 'ctl'=>'biz/order:detailsystem', 'menu'=>false),
            )
        ),
        array('title'=>'数据统计', 'menu'=>true,
            'items'=>array(
                array('title'=>'收入统计', 'ctl'=>'biz/tongji:income', 'menu'=>true),
                array('title'=>'收入统计', 'ctl'=>'biz/tongji:w_income', 'menu'=>false),  
                array('title'=>'团购、代金券收入统计', 'ctl'=>'biz/tongji:t_income', 'menu'=>false),
                array('title'=>'优惠买单收入统计', 'ctl'=>'biz/tongji:m_income', 'menu'=>false),
                array('title'=>'订单统计', 'ctl'=>'biz/tongji:order', 'menu'=>true),
                array('title'=>'外卖订单统计', 'ctl'=>'biz/tongji:w_order', 'menu'=>false),
                array('title'=>'团购订单统计', 'ctl'=>'biz/tongji:t_order', 'menu'=>false),
                array('title'=>'买单订单统计', 'ctl'=>'biz/tongji:m_order', 'menu'=>false),
                array('title'=>'订单来源', 'ctl'=>'biz/tongji:orderfrom', 'menu'=>true),
                array('title'=>'团购订单来源', 'ctl'=>'biz/tongji:t_orderfrom', 'menu'=>false),
                array('title'=>'外卖订单来源', 'ctl'=>'biz/tongji:w_orderfrom', 'menu'=>false),
                array('title'=>'买单订单来源', 'ctl'=>'biz/tongji:m_orderfrom', 'menu'=>false),
                array('title'=>'商品销量', 'ctl'=>'biz/tongji:product', 'menu'=>true),
                
            )
        ),
         array('title'=>'通用控制器', 'menu'=>false,
            'items'=>array(
                array('title'=>'上传图片', 'ctl'=>'biz/upload:photo', 'menu'=>false),
                array('title'=>'上传图片', 'ctl'=>'biz/upload:editor', 'menu'=>false),
            )
        )       
    ),
    'shop' => array(
        array('title'=>'基本设置', 'menu'=>true,
            'items'=>array(
                array('title'=>'资料设置', 'ctl'=>'biz/shop:index', 'menu'=>true),
                array('title'=>'安全设置', 'ctl'=>'biz/shop:passwd', 'nav'=>'biz/shop:index'),
                array('title'=>'获取商圈', 'ctl'=>'biz/shop:get_business', 'nav'=>'biz/shop:index'),
                array('title'=>'更换手机', 'ctl'=>'biz/shop:mobile', 'nav'=>'biz/shop:index'),
                array('title'=>'提现帐号', 'ctl'=>'biz/shop:account', 'nav'=>'biz/shop:index'),
                array('title'=>'店铺认证', 'ctl'=>'biz/shop/verify:index', 'menu'=>true),
                array('title'=>'店主认证', 'ctl'=>'biz/shop/verify:dianzhu', 'nav'=>'biz/shop/verify:index'),
                array('title'=>'企业认证', 'ctl'=>'biz/shop/verify:yyzz', 'nav'=>'biz/shop/verify:index'),
                array('title'=>'餐饮认证', 'ctl'=>'biz/shop/verify:canyin', 'nav'=>'biz/shop/verify:index'),
                array('title'=>'功能开通', 'ctl'=>'biz/shop/open:index', 'menu'=>true),
                array('title'=>'功能开通', 'ctl'=>'biz/shop/open:save',  'nav'=>'biz/shop/open:save'),
                array('title'=>'打印设置', 'ctl'=>'biz/shop/print:index', 'menu'=>true),
                array('title'=>'添加设置', 'ctl'=>'biz/shop/print:create', 'nav'=>'biz/shop/print:index'),
                array('title'=>'相册设置', 'ctl'=>'biz/shop/album:index', 'menu'=>true),
                array('title'=>'添加相册', 'ctl'=>'biz/shop/album:create', 'nav'=>'biz/shop/album:index'),
                array('title'=>'编辑相册', 'ctl'=>'biz/shop/album:edit', 'nav'=>'biz/shop/album:index'),
                array('title'=>'删除相册', 'ctl'=>'biz/shop/album:delete', 'nav'=>'biz/shop/album:index'),
                array('title'=>'管理相册', 'ctl'=>'biz/shop/album:detail', 'nav'=>'biz/shop/album:index'),
                array('title'=>'编辑设置', 'ctl'=>'biz/shop/print:edit', 'nav'=>'biz/shop/print:index'),
                array('title'=>'删除设置', 'ctl'=>'biz/shop/print:delete', 'nav'=>'biz/shop/print:index'),
                array('title'=>'开启或静默', 'ctl'=>'biz/shop/print:change', 'nav'=>'biz/shop/print:index'),
            )
        ),
        array('title'=>'优惠券管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'优惠券列表', 'ctl'=>'biz/shop/coupon:index', 'menu'=>true),
                array('title'=>'创建优惠券', 'ctl'=>'biz/shop/coupon:create', 'nav'=>'biz/shop/coupon:create'),
                array('title'=>'编辑优惠券', 'ctl'=>'biz/shop/coupon:edit', 'nav'=>'biz/shop/coupon:edit'),
                array('title'=>'删除优惠券', 'ctl'=>'biz/shop/coupon:delete', 'nav'=>'biz/shop/coupon:delete'),
            )
        ),  
        array('title'=>'评价管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'店铺评价', 'ctl'=>'biz/shop/comment:index', 'menu'=>true),
                array('title'=>'评价回复', 'ctl'=>'biz/shop/comment:reply', 'nav'=>'biz/shop/comment:index'),
                array('title'=>'评价详情', 'ctl'=>'biz/shop/comment:detail', 'nav'=>'biz/shop/comment:index'),
                array('title'=>'外卖评价', 'ctl'=>'biz/waimai/comment:index', 'menu'=>true),
                array('title'=>'外卖评价回复', 'ctl'=>'biz/waimai/comment:reply', 'nav'=>'biz/waimai/comment:index'),
                array('title'=>'外卖评价详情', 'ctl'=>'biz/waimai/comment:detail', 'nav'=>'biz/waimai/comment:index'),
            )
        ),          
        array('title'=>'客户管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'我的客户', 'ctl'=>'biz/shop/member:index', 'menu'=>true),
                array('title'=>'我的粉丝', 'ctl'=>'biz/shop/member:fans', 'menu'=>true),
                array('title'=>'详情', 'ctl'=>'biz/shop/member:detail', 'nav'=>'biz/shop/member:index'),
            )
        ),
        array('title'=>'资金管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'资金管理', 'ctl'=>'biz/shop/money:index', 'menu'=>true),
                array('title'=>'提现日志', 'ctl'=>'biz/shop/money:txlog', 'menu'=>true),
                array('title'=>'提现', 'ctl'=>'biz/shop/money:tixian', 'nav'=>'biz/shop/money:txlog'),
            )
        ),               
    ),
    'tuan' => array(
        array('title'=>'优惠买单', 'menu'=>true,
            'items'=>array(
                array('title'=>'优惠买单', 'ctl'=>'biz/tuan/maidan:index', 'menu'=>true),
                array('title'=>'买单订单', 'ctl'=>'biz/tuan/maidan:order', 'menu'=>true),
                array('title'=>'删除优惠', 'ctl'=>'biz/tuan/maidan:delete', 'nav'=>'biz/tuan/maidan:index'),
            )
        ),
        array('title'=>'团购管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'团购管理', 'ctl'=>'biz/tuan/tuan:index', 'menu'=>true),
                array('title'=>'添加团购', 'ctl'=>'biz/tuan/tuan:create', 'nav'=>'biz/tuan/tuan:index'),
                array('title'=>'编辑团购', 'ctl'=>'biz/tuan/tuan:edit', 'nav'=>'biz/tuan/tuan:index'),
                array('title'=>'删除团购', 'ctl'=>'biz/tuan/tuan:del', 'nav'=>'biz/tuan/tuan:index'),
                array('title'=>'团购商品上架', 'ctl'=>'biz/tuan/tuan:onsale', 'nav'=>'biz/tuan/tuan:index'),
            )
        ),
        array('title'=>'订单管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'订单管理', 'ctl'=>'biz/tuan/order:index', 'menu'=>true),
                array('title'=>'团购券管理', 'ctl'=>'biz/tuan/order:ticket', 'menu'=>true),
                array('title'=>'团购券核销', 'ctl'=>'biz/tuan/order:used', 'nav'=>'biz/tuan/order:ticket'),
                array('title'=>'团购券验证', 'ctl'=>'biz/tuan/order:dialog', 'nav'=>'biz/tuan/order:ticket'),
                array('title'=>'订单详情', 'ctl'=>'biz/tuan/order:detail', 'nav'=>'biz/tuan/order:index'),
            )
        ),                
    ),
    
    
    'waimai' => array(
        array('title'=>'商品管理', 'menu'=>true,
            'items'=>array(                
                array('title'=>'分类管理', 'ctl'=>'biz/waimai/cate:index', 'menu'=>true),
                array('title'=>'商品管理', 'ctl'=>'biz/waimai/product:index', 'menu'=>true),
                array('title'=>'商品管理', 'ctl'=>'biz/waimai/product:skunotice', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'库存管理', 'ctl'=>'biz/waimai/product:stock_add', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'上架产品', 'ctl'=>'biz/waimai/product:onsale_open', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'下架产品', 'ctl'=>'biz/waimai/product:onsale_close', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'创建分类', 'ctl'=>'biz/waimai/cate:create', 'nav'=>'biz/waimai/cate:index'),
                array('title'=>'编辑分类', 'ctl'=>'biz/waimai/cate:edit', 'nav'=>'biz/waimai/cate:index'),
                array('title'=>'删除分类', 'ctl'=>'biz/waimai/cate:delete', 'nav'=>'biz/waimai/cate:index'),
                array('title'=>'创建商品', 'ctl'=>'biz/waimai/product:create', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'编辑商品', 'ctl'=>'biz/waimai/product:edit', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'删除商品', 'ctl'=>'biz/waimai/product:delete', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'商品规格', 'ctl'=>'biz/waimai/product:specs', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'删除规格', 'ctl'=>'biz/waimai/product:specs_del', 'nav'=>'biz/waimai/product:index'),
                array('title'=>'上架状态设置', 'ctl'=>'biz/waimai/product:open', 'nav'=>'biz/waimai/product:index'),
                
            )
        ),
        array('title'=>'外送订单', 'menu'=>false,
            'items'=>array(
                array('title'=>'快速管理', 'ctl'=>'biz/waimai/ordermanage:index', 'menu'=>false),  
            )
        ),
        array('title'=>'订单管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'外送订单', 'ctl'=>'biz/waimai/order:index', 'menu'=>true),
                array('title'=>'外送订单', 'ctl'=>'biz/waimai/order:waimai', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'修改配送方式', 'ctl'=>'biz/waimai/order:setpei', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'配送订单', 'ctl'=>'biz/waimai/order:pei', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'配送完成订单', 'ctl'=>'biz/waimai/order:delivered', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'完成的订单', 'ctl'=>'biz/waimai/order:complete', 'nav'=>'biz/waimai/order:index'), 
                array('title'=>'取消的订单', 'ctl'=>'biz/waimai/order:cancellist', 'nav'=>'biz/waimai/order:index'), 
                array('title'=>'自提订单', 'ctl'=>'biz/waimai/order:ziti', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'配送按钮', 'ctl'=>'biz/waimai/order:peisong', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'取消订单按钮', 'ctl'=>'biz/waimai/order:cancel', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'完成订单按钮', 'ctl'=>'biz/waimai/order:finish', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'接单按钮', 'ctl'=>'biz/waimai/order:accept', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'订单详情', 'ctl'=>'biz/waimai/order:detail', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'自提订单核销', 'ctl'=>'biz/waimai/order:setspend', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'订单核销弹框', 'ctl'=>'biz/waimai/order:dialog', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'打印小票', 'ctl'=>'biz/waimai/order:porder', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'检查打印平台', 'ctl'=>'biz/waimai/order:check_print', 'nav'=>'biz/waimai/order:index'),
                array('title'=>'在线云打印', 'ctl'=>'biz/waimai/order:yun_print', 'nav'=>'biz/waimai/order:index'),
            )
        ),
        array('title'=>'店铺设置', 'menu'=>true,
            'items'=>array(               
                array('title'=>'店铺设置', 'ctl'=>'biz/waimai:index', 'menu'=>true),
                array('title'=>'配送设置', 'ctl'=>'biz/waimai/shop:pei', 'menu'=>true),
                array('title'=>'店铺设置', 'ctl'=>'biz/waimai/shop:have', 'menu'=>false),
                array('title'=>'优惠设置', 'ctl'=>'biz/waimai/shop:youhui', 'menu'=>true),
                array('title'=>'删除优惠', 'ctl'=>'biz/waimai/shop:yhdelete', 'nav'=>'biz/waimai/shop:youhui'),
            )
        ),
    ),
    ///菜品管理单
    'weidian' => array(
       array('title' => L('我的店铺'), 'menu' => true,
                    'items' => array(
                        array('title' => L('店铺信息'), 'ctl' => 'biz/weidian:index', 'menu' => true),
                        array('title' => L('微店设置'), 'ctl' => 'biz/weidian:info','menu' => true),
                        array('title' => L('微店开通'), 'ctl' => 'biz/weidian:open', 'nav' => 'biz/weidian:index'),
                        array('title' => L('支付佣金'), 'ctl' => 'biz/weidian/pintuanyongjin:pay', 'nav' => 'biz/weidian/pintuanyongjin:index'),
                        array('title' => L('查看流水'), 'ctl' => 'biz/weidian/pintuanyongjin:log', 'nav' => 'biz/weidian/pintuanyongjin:index'),
                        array('title' => L('广告管理'), 'ctl' => 'biz/weidian/banner:index', 'menu' => true),
                        array('title' => L('创建广告'), 'ctl' => 'biz/weidian/banner:create', 'nav' => 'biz/weidian/banner:create'),
                        array('title' => L('设置状态'), 'ctl' => 'biz/weidian/banner:audit', 'nav' => 'biz/weidian/banner:audit'),
                        array('title' => L('编辑广告'), 'ctl' => 'biz/weidian/banner:edit', 'nav' => 'biz/weidian/banner:edit'),
                        array('title' => L('删除广告'), 'ctl' => 'biz/weidian/banner:delete', 'nav' => 'biz/weidian/banner:delete'),
                        array('title' => L('活动列表'), 'ctl' => 'biz/weidian/huodong:index', 'menu' => true),
                        array('title' => L('创建活动'), 'ctl' => 'biz/weidian/huodong:create', 'nav' => 'biz/weidian/huodong:create'),
                        array('title' => L('编辑活动'), 'ctl' => 'biz/weidian/huodong:edit', 'nav' => 'biz/weidian/huodong:edit'),
                        array('title' => L('删除活动'), 'ctl' => 'biz/weidian/huodong:delete', 'nav' => 'biz/weidian/huodong:delete'),
                        array('title' => L('设置活动状态'), 'ctl' => 'biz/weidian/huodong:set_status', 'nav' => 'biz/weidian/huodong:set_status'),
                    )
                ),
        array('title' => L('商品管理'), 'menu' => true,
            'items' => array(

                array('title' => L('商品分类'), 'ctl' => 'biz/weidian/productcate:index', 'menu' => true),
                array('title' => L('添加分类'), 'ctl' => 'biz/weidian/productcate:create', 'nav' => 'biz/weidian/productcate:create'),
                array('title' => L('修改分类'), 'ctl' => 'biz/weidian/productcate:edit', 'nav' => 'biz/weidian/productcate:edit'),
                array('title' => L('删除分类'), 'ctl' => 'biz/weidian/productcate:delete', 'nav' => 'biz/weidian/productcate:delete'),
                array('title' => L('更新分类'), 'ctl' => 'biz/weidian/productcate:update', 'nav' => 'biz/weidian/productcate:update'),
                
                array('title' => L('普通商品'), 'ctl' => 'biz/weidian/product:index', 'menu' => true),
                array('title' => L('添加商品'), 'ctl' => 'biz/weidian/product:create', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('修改商品'), 'ctl' => 'biz/weidian/product:edit', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('删除商品'), 'ctl' => 'biz/weidian/product:delete', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('更新商品'), 'ctl' => 'biz/weidian/product:open', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('上架商品'), 'ctl' => 'biz/weidian/product:onsale_open', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('下架商品'), 'ctl' => 'biz/weidian/product:onsale_close', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('设置规格名称'), 'ctl' => 'biz/weidian/product:set_name', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('设置规格属性'), 'ctl' => 'biz/weidian/product:set_value', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('设置规格属性'), 'ctl' => 'biz/weidian/product:get_attr', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('设置是否分销'), 'ctl' => 'biz/weidian/product:set_is_fenxiao', 'nav' => 'biz/weidian/product:index'),
                array('title' => L('拼团商品'), 'ctl' => 'biz/weidian/pintuanproduct:index', 'menu' => true),
                array('title' => L('添加拼团商品'), 'ctl' => 'biz/weidian/pintuanproduct:create', 'nav' => 'biz/weidian/pintuanproduct:index'),
                array('title' => L('修改拼团商品'), 'ctl' => 'biz/weidian/pintuanproduct:edit', 'nav' => 'biz/weidian/pintuanproduct:index'),
                array('title' => L('删除拼团商品'), 'ctl' => 'biz/weidian/pintuanproduct:delete', 'nav' => 'biz/weidian/pintuanproduct:index'),
                array('title' => L('更新拼团商品'), 'ctl' => 'biz/weidian/pintuanproduct:update', 'nav' => 'biz/weidian/pintuanproduct:index'),  
                array('title' => L('设置规格名称'), 'ctl' => 'biz/weidian/pintuanproduct:set_name', 'nav' => 'biz/weidian/pintuanproduct:index'),
                array('title' => L('设置规格属性'), 'ctl' => 'biz/weidian/pintuanproduct:set_value', 'nav' => 'biz/weidian/pintuanproduct:index'),
                array('title' => L('设置规格属性'), 'ctl' => 'biz/weidian/pintuanproduct:get_attr', 'nav' => 'biz/weidian/pintuanproduct:index'),
                    )
                ),
                array('title' => L('拼团管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('拼团管理'), 'ctl' => 'biz/weidian/pintuangroup:index', 'menu' => true),
                        array('title' => L('更新拼团'), 'ctl' => 'biz/weidian/pintuangroup:update', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('查看拼团'), 'ctl' => 'biz/weidian/pintuangroup:detail', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('组团中-拼团'), 'ctl' => 'biz/weidian/pintuangroup:start', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('组团成功-拼团'), 'ctl' => 'biz/weidian/pintuangroup:process', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('组团失败-拼团'), 'ctl' => 'biz/weidian/pintuangroup:complete', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('商家已接单-拼团'), 'ctl' => 'biz/weidian/pintuangroup:ok', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('商家接单-拼团'), 'ctl' => 'biz/weidian/pintuangroup:status_ok', 'nav' => 'biz/weidian/pintuangroup:index'),
                        array('title' => L('商家取消组团-拼团'), 'ctl' => 'biz/weidian/pintuangroup:status_complete', 'nav' => 'biz/weidian/pintuangroup:index'),
                        
                        array('title' => L('拼团订单'), 'ctl' => 'biz/weidian/pintuanorder:index', 'menu' => true),
                        array('title' => L('配送订单'), 'ctl' => 'biz/weidian/pintuanorder:pei', 'nav' => 'biz/weidian/pintuanorder:index'),
                        array('title' => L('配送完成'), 'ctl' => 'biz/weidian/pintuanorder:delivered', 'nav' => 'biz/weidian/pintuanorder:index'),
                        array('title' => L('订单完成'), 'ctl' => 'biz/weidian/pintuanorder:complete', 'nav' => 'biz/weidian/pintuanorder:index'),
                        array('title' => L('取消订单'), 'ctl' => 'biz/weidian/pintuanorder:cancellist', 'nav' => 'biz/weidian/pintuanorder:index'),
                        array('title' => L('配送订单'), 'ctl' => 'biz/weidian/pintuanorder:pei', 'nav' => 'biz/weidian/pintuanorder:index'),
                        
                        array('title' => L('佣金记录'), 'ctl' => 'biz/weidian/pintuanyongjin:index', 'menu' => true),
                        
                    )
                ),
                array('title' => L('订单管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('商品订单'), 'ctl' => 'biz/weidian/order:index', 'menu' => true),
                        array('title' => L('待确认'), 'ctl' => 'biz/weidian/order:wait', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('待发货'), 'ctl' => 'biz/weidian/order:fahuo', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('待收货'), 'ctl' => 'biz/weidian/order:shouhuo', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('已收货'), 'ctl' => 'biz/weidian/order:confirm', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('已完成'), 'ctl' => 'biz/weidian/order:complete', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('已取消'), 'ctl' => 'biz/weidian/order:cancellist', 'nav' => 'biz/weidian/order:index'),
                        array('title' => L('自提单'), 'ctl' => 'biz/weidian/order:ziti', 'nav' => 'biz/weidian/order:index'),
                        array('title'=>'接单按钮', 'ctl'=>'biz/weidian/order:accept', 'nav'=>'biz/weidian/order:index'),
                        array('title'=>'发货按钮', 'ctl'=>'biz/weidian/order:sendgoods', 'nav'=>'biz/weidian/order:index'),
                        array('title'=>'确认收货按钮', 'ctl'=>'biz/weidian/order:service', 'nav'=>'biz/weidian/order:index'),
                        array('title'=>'确认完成按钮', 'ctl'=>'biz/weidian/order:finish', 'nav'=>'biz/weidian/order:index'),
                        array('title'=>'核销按钮', 'ctl'=>'biz/weidian/order:dialog', 'nav'=>'biz/weidian/order:index'),
                        array('title'=>'核销按钮', 'ctl'=>'biz/weidian/order:setspend', 'nav'=>'biz/weidian/order:index'),
			array('title'=>'取消订单', 'ctl'=>'biz/weidian/order:cancel', 'nav'=>'biz/weidian/order:index'),
                    )
                ),
                array('title' => L('微分销'), 'menu' => true,
                    'items' => array(
                        array('title' => L('分销设置'), 'ctl' => 'biz/weidian/fenxiao:index', 'menu' => true),
                        array('title' => L('店铺列表'), 'ctl' => 'biz/weidian/fenxiao:items', 'menu' => true),
                        array('title' => L('分销商品'), 'ctl' => 'biz/weidian/fenxiao:product', 'menu' => true),
                        array('title' => L('分销订单'), 'ctl' => 'biz/weidian/fenxiao:orders', 'menu' => true),
                        array('title' => L('分销待发货订单'), 'ctl' => 'biz/weidian/fenxiao:f_fahuo', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('分销待收货订单'), 'ctl' => 'biz/weidian/fenxiao:f_shouhuo', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('分销已收货订单'), 'ctl' => 'biz/weidian/fenxiao:f_confirm', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('分销已完成订单'), 'ctl' => 'biz/weidian/fenxiao:f_complete', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('分销已取消订单'), 'ctl' => 'biz/weidian/fenxiao:f_cancellist', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('分销自提订单'), 'ctl' => 'biz/weidian/fenxiao:f_ziti', 'nav' => 'biz/weidian/fenxiao:orders'),
                        array('title' => L('设置状态'), 'ctl' => 'biz/weidian/fenxiao:set_status', 'nav' => 'biz/weidian/fenxiao:set_status'),
                        array('title' => L('设置状态'), 'ctl' => 'biz/weidian/fenxiao:set_deny', 'nav' => 'biz/weidian/fenxiao:set_status'),
                    )
                ),
            ),
    
    
    'weixin' => array(
        array('title'=>'微信设置', 'menu'=>true,
            'items'=>array(
                array('title'=>'公众号管理', 'ctl'=>'biz/member:index', 'menu'=>true),
                array('title'=>'关注回复', 'ctl'=>'biz/member:fans', 'menu'=>true),
                array('title'=>'关键字回复', 'ctl'=>'biz/member:detail', 'nav'=>'biz/member:index'),
                array('title'=>'自定义菜单', 'ctl'=>'biz/member:detail', 'nav'=>'biz/member:index'),
            )
        ),
        array('title'=>'素材管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'单图文', 'ctl'=>'biz/member:index', 'menu'=>true),
            )
        ),
        array('title'=>'营销营销', 'menu'=>true,
            'items'=>array(
                array('title'=>'优惠券', 'ctl'=>'biz/weixin/youhui', 'menu'=>true),
                array('title'=>'刮刮卡', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'大转盘', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'砸金蛋', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'摇一摇', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'微助力', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'微接力', 'ctl'=>'biz/weixin/index', 'menu'=>true),                
                array('title'=>'微信红包', 'ctl'=>'biz/weixin/index', 'menu'=>true),
                array('title'=>'微信卡券', 'ctl'=>'biz/weixin/index', 'menu'=>true),
            )
        ),
    ),
    'weixin' => array(
        array('title'=>L('微信管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('微信管理'), 'ctl'=>'biz/weixin/index:index','nav'=>'biz/weixin/index:index'),
                array('title'=>L('绑定'), 'ctl'=>'biz/weixin/index:bind','nav'=>'biz/weixin/index:index'),
                array('title'=>L('绑定公众号'), 'ctl'=>'biz/weixin/index:wxloginpage', 'nav'=>'biz/weixin/index:index'),
                array('title'=>L('绑定公众号'), 'ctl'=>'biz/weixin/index:wxcallback', 'nav'=>'biz/weixin/index:index'),
                array('title'=>L('单次关注'), 'ctl'=>'biz/weixin/index:welcome', 'nav'=>'biz/weixin/index:welcome','menu'=>true),
                array('title'=>L('自动回复'), 'ctl'=>'biz/weixin/index:auto', 'nav'=>'biz/weixin:index','menu'=>true),
                array('title'=>L('关键字回复'), 'ctl'=>'biz/weixin/keyword:index', 'nav'=>'biz/weixin/keyword:index','menu'=>true),
                array('title'=>L('添加关键字'), 'ctl'=>'biz/weixin/keyword:create', 'nav'=>'biz/weixin/keyword:index'),
                array('title'=>L('编辑关键字'), 'ctl'=>'biz/weixin/keyword:edit', 'nav'=>'biz/weixin/keyword:index'),
                array('title'=>L('删除关键字'), 'ctl'=>'biz/weixin/keyword:delete', 'nav'=>'biz/weixin/keyword:index'),
                array('title'=>L('自定义菜单'), 'ctl'=>'biz/weixin/menu:index', 'nav'=>'biz/weixin/menu:index','menu'=>true),
                array('title'=>L('添加菜单'), 'ctl'=>'biz/weixin/menu:create', 'nav'=>'biz/weixin/menu:index'),
                array('title'=>L('编辑菜单'), 'ctl'=>'biz/weixin/menu:edit', 'nav'=>'biz/weixin/menu:index'),
                array('title'=>L('删除菜单'), 'ctl'=>'biz/weixin/menu:delete', 'nav'=>'biz/weixin/menu:index'),
                array('title'=>L('同步菜单'), 'ctl'=>'biz/weixin/menu:towechat', 'nav'=>'biz/weixin/menu:index'),
            )
        ),
        array('title'=>L('素材管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('微信素材'), 'ctl'=>'biz/weixin/reply:index', 'menu'=>true),
                array('title'=>L('添加素材'), 'ctl'=>'biz/weixin/reply:create','nav'=>'biz/weixin/reply:index'),
                array('title'=>L('编辑素材'), 'ctl'=>'biz/weixin/reply:edit', 'nav'=>'biz/weixin/reply:index'),
                array('title'=>L('删除素材'), 'ctl'=>'biz/weixin/reply:delete', 'nav'=>'biz/weixin/reply:index'),
                array('title'=>L('选择素材'), 'ctl'=>'biz/weixin/reply:dialog', 'nav'=>'biz/weixin/reply:index'),
            )
        ),
        array('title'=>L('营销插件'), 'menu'=>true,
            'items'=>array(
                //优惠券
                array('title'=>L('优惠券'), 'ctl'=>'biz/weixin/coupon:index', 'nav'=>'biz/weixin/coupon:index','menu'=>true),
                array('title'=>L('添加优惠券'), 'ctl'=>'biz/weixin/coupon:create', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('编辑优惠券'), 'ctl'=>'biz/weixin/coupon:edit', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('删除优惠券'), 'ctl'=>'biz/weixin/coupon:delete', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('领取优惠券'), 'ctl'=>'biz/weixin/coupon:sign', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('优惠码'), 'ctl'=>'biz/weixin/coupon:sn', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/coupon:preview', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/coupon:snedit', 'nav'=>'biz/weixin/coupon:index'),
                array('title'=>L('删除成员'), 'ctl'=>'biz/weixin/coupon:sndelete', 'nav'=>'biz/weixin/coupon:index'),
                
                //刮刮卡
                array('title'=>L('刮刮卡'), 'ctl'=>'biz/weixin/scratch:index','nav'=>'biz/weixin/scratch:index','menu'=>true),
                array('title'=>L('添加摇一摇'), 'ctl'=>'biz/weixin/scratch:create', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('编辑摇一摇'), 'ctl'=>'biz/weixin/scratch:edit', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('删除摇一摇'), 'ctl'=>'biz/weixin/scratch:delete', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('领取优惠券'), 'ctl'=>'biz/weixin/scratch:sign', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/scratch:sn', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/scratch:sndelete', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/scratch:snedit', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/scratch:preview', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('奖品'), 'ctl'=>'biz/weixin/scratch:goods', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('添加奖品'), 'ctl'=>'biz/weixin/scratch:goodscreate', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('编辑奖品'), 'ctl'=>'biz/weixin/scratch:goodsedit', 'nav'=>'biz/weixin/scratch:index'),
                array('title'=>L('删除奖品'), 'ctl'=>'biz/weixin/scratch:goodsdelete', 'nav'=>'biz/weixin/scratch:index'),
                
                //大转盘
                array('title'=>L('大转盘'), 'ctl'=>'biz/weixin/lottery:index','nav'=>'biz/weixin/lottery:index','menu'=>true),
                array('title'=>L('添加大转盘'), 'ctl'=>'biz/weixin/lottery:create', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('编辑大转盘'), 'ctl'=>'biz/weixin/lottery:edit', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('删除大转盘'), 'ctl'=>'biz/weixin/lottery:delete', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/lottery:sn', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/lottery:sndelete', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/lottery:snedit', 'nav'=>'biz/weixin/lottery:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/lottery:preview', 'nav'=>'biz/weixin/lottery:index'),
                
                //砸金蛋
                array('title'=>L('砸金蛋'), 'ctl'=>'biz/weixin/goldegg:index','nav'=>'biz/weixin/goldegg:index','menu'=>true),
                array('title'=>L('添加砸金蛋'), 'ctl'=>'biz/weixin/goldegg:create', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('编辑砸金蛋'), 'ctl'=>'biz/weixin/goldegg:edit', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('删除砸金蛋'), 'ctl'=>'biz/weixin/goldegg:delete', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/goldegg:sn', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/goldegg:sndelete', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/goldegg:snedit', 'nav'=>'biz/weixin/goldegg:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/goldegg:preview', 'nav'=>'biz/weixin/goldegg:index'),
                
                //红包
                array('title'=>L('抢红包'), 'ctl'=>'biz/weixin/packet:index','nav'=>'biz/weixin/packet:index','menu'=>true),
                array('title'=>L('添加红包'), 'ctl'=>'biz/weixin/packet:create', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('编辑红包'), 'ctl'=>'biz/weixin/packet:edit', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('删除红包'), 'ctl'=>'biz/weixin/packet:delete', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('兑换'), 'ctl'=>'biz/weixin/packet:logs', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/packet:sn', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/packet:sndelete', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/packet:snedit', 'nav'=>'biz/weixin/packet:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/packet:preview', 'nav'=>'biz/weixin/packet:index'),
                
                //卡券
                /*
                array('title'=>L('卡券'), 'ctl'=>'biz/weixin/card:index','nav'=>'biz/weixin/card:index','menu'=>true),
                array('title'=>L('添加卡券'), 'ctl'=>'biz/weixin/card:create', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('编辑卡券'), 'ctl'=>'biz/weixin/card:edit', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('删除卡券'), 'ctl'=>'biz/weixin/card:delete', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/card:sn', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/card:sndelete', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/card:snedit', 'nav'=>'biz/weixin/card:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/card:preview', 'nav'=>'biz/weixin/card:index'),
                */
                //摇一摇
                array('title'=>L('摇一摇'), 'ctl'=>'biz/weixin/shake:index', 'nav'=>'biz/weixin/shake:index','menu'=>true),
                array('title'=>L('添加摇一摇'), 'ctl'=>'biz/weixin/shake:create', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('编辑摇一摇'), 'ctl'=>'biz/weixin/shake:edit', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('删除摇一摇'), 'ctl'=>'biz/weixin/shake:delete', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('领取优惠券'), 'ctl'=>'biz/weixin/shake:sign', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/shake:sn', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/shake:sndelete', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/shake:snedit', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/shake:preview', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('奖品'), 'ctl'=>'biz/weixin/shake:goods', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('添加奖品'), 'ctl'=>'biz/weixin/shake:goodscreate', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('编辑奖品'), 'ctl'=>'biz/weixin/shake:goodsedit', 'nav'=>'biz/weixin/shake:index'),
                array('title'=>L('删除奖品'), 'ctl'=>'biz/weixin/shake:goodsdelete', 'nav'=>'biz/weixin/shake:index'),
                
                //微助力
                array('title'=>L('微助力'), 'ctl'=>'biz/weixin/help:index', 'nav'=>'biz/weixin/help:index','menu'=>true),
                array('title'=>L('添加微助力'), 'ctl'=>'biz/weixin/help:create', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('编辑微助力'), 'ctl'=>'biz/weixin/help:edit', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('删除微助力'), 'ctl'=>'biz/weixin/help:delete', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('领取优惠券'), 'ctl'=>'biz/weixin/help:sign', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/help:sn', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/help:sndelete', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/help:snedit', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/help:preview', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('奖品'), 'ctl'=>'biz/weixin/help:goods', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('添加奖品'), 'ctl'=>'biz/weixin/help:goodscreate', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('编辑奖品'), 'ctl'=>'biz/weixin/help:goodsedit', 'nav'=>'biz/weixin/help:index'),
                array('title'=>L('删除奖品'), 'ctl'=>'biz/weixin/help:goodsdelete', 'nav'=>'biz/weixin/help:index'),
                
                //微接力
                array('title'=>L('微接力'), 'ctl'=>'biz/weixin/relay:index', 'nav'=>'biz/weixin/relay:index','menu'=>true),
                array('title'=>L('添加微接力'), 'ctl'=>'biz/weixin/relay:create', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('编辑微接力'), 'ctl'=>'biz/weixin/relay:edit', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('删除微接力'), 'ctl'=>'biz/weixin/relay:delete', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('领取优惠券'), 'ctl'=>'biz/weixin/relay:sign', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('中奖用户'), 'ctl'=>'biz/weixin/relay:sn', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('删除用户'), 'ctl'=>'biz/weixin/relay:sndelete', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('改变状态'), 'ctl'=>'biz/weixin/relay:snedit', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('预览'), 'ctl'=>'biz/weixin/relay:preview', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('奖品'), 'ctl'=>'biz/weixin/relay:goods', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('添加奖品'), 'ctl'=>'biz/weixin/relay:goodscreate', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('编辑奖品'), 'ctl'=>'biz/weixin/relay:goodsedit', 'nav'=>'biz/weixin/relay:index'),
                array('title'=>L('删除奖品'), 'ctl'=>'biz/weixin/relay:goodsdelete', 'nav'=>'biz/weixin/relay:index'),
                
            )
        )
    ),

    'yuyue' => array(
        array('title'=>'桌号管理', 'menu'=>true,
            'items'=>array(                
                array('title'=>'分类管理', 'ctl'=>'biz/yuyue/zhuohao:cate', 'menu'=>true),
                array('title'=>'桌号管理', 'ctl'=>'biz/yuyue/zhuohao:items', 'menu'=>true),
                array('title'=>'添加桌号分类', 'ctl'=>'biz/yuyue/zhuohao:cate_create', 'nav'=>'biz/yuyue/zhuohao:cate'),
                array('title'=>'编辑桌号分类', 'ctl'=>'biz/yuyue/zhuohao:cate_edit', 'nav'=>'biz/yuyue/zhuohao:cate'),
                array('title'=>'删除桌号分类', 'ctl'=>'biz/yuyue/zhuohao:cate_delete', 'nav'=>'biz/yuyue/zhuohao:cate'),
                array('title'=>'添加桌号', 'ctl'=>'biz/yuyue/zhuohao:zhuohao_create', 'nav'=>'biz/yuyue/zhuohao:items'),
                array('title'=>'修改桌号', 'ctl'=>'biz/yuyue/zhuohao:zhuohao_edit', 'nav'=>'biz/yuyue/zhuohao:items'),
                array('title'=>'删除桌号', 'ctl'=>'biz/yuyue/zhuohao:zhuohao_delete', 'nav'=>'biz/yuyue/zhuohao:items'),
            )
        ),
        array('title'=>'订单管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'排号订单', 'ctl'=>'biz/yuyue/order:paidui', 'menu'=>true),
                array('title'=>'订座订单', 'ctl'=>'biz/yuyue/order:dingzuo', 'menu'=>true),
                array('title'=>'排号订单选择桌号', 'ctl'=>'biz/yuyue/order:paidui_choose_zhuohao', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'订座订单选择桌号', 'ctl'=>'biz/yuyue/order:dingzuo_choose_zhuohao', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'排号订单接单', 'ctl'=>'biz/yuyue/order:paidui_jiedan', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'排号订单取消', 'ctl'=>'biz/yuyue/order:paidui_cancel', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'排号订单完成', 'ctl'=>'biz/yuyue/order:paidui_complete', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'排号订单删除', 'ctl'=>'biz/yuyue/order:paidui_delete', 'nav'=>'biz/yuyue/order:paidui'),

                array('title'=>'排号订单排队中列表', 'ctl'=>'biz/yuyue/order:paidui_wait_items', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'排号订单已完成列表', 'ctl'=>'biz/yuyue/order:paidui_complete_items', 'nav'=>'biz/yuyue/order:paidui'),
                array('title'=>'排号订单已取消列表', 'ctl'=>'biz/yuyue/order:paidui_cancel_items', 'nav'=>'biz/yuyue/order:paidui'),

                array('title'=>'订座订单接单', 'ctl'=>'biz/yuyue/order:dingzuo_jiedan', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'订座订单取消', 'ctl'=>'biz/yuyue/order:dingzuo_cancel', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'订座订单完成', 'ctl'=>'biz/yuyue/order:dingzuo_complete', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'订座订单删除', 'ctl'=>'biz/yuyue/order:dingzuo_delete', 'nav'=>'biz/yuyue/order:dingzuo'),

                array('title'=>'订座订单排队中列表', 'ctl'=>'biz/yuyue/order:dingzuo_wait_items', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'订座订单已完成列表', 'ctl'=>'biz/yuyue/order:dingzuo_complete_items', 'nav'=>'biz/yuyue/order:dingzuo'),
                array('title'=>'订座订单已取消列表', 'ctl'=>'biz/yuyue/order:dingzuo_cancel_items', 'nav'=>'biz/yuyue/order:dingzuo'),
            )
        )
    )
);