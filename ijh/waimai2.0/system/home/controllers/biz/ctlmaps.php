<?php

/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
        array(
            'index' => array(
                array('title' => L('管理中心'), 'menu' => true,
                    'items' => array(
                        array('title' => L('管理中心'), 'ctl' => 'biz/index:index', 'menu' => true),
                    )
                ),
                array('title' => L('店铺设置'), 'menu' => true,
                    'items' => array(
                        array('title' => L('基本资料'), 'ctl' => 'biz/shop:index', 'menu' => true),
                        array('title' => L('优惠设置'), 'ctl' => 'biz/shop:youhui', 'menu' => true),
                        array('title' => L('满减优惠'), 'ctl' => 'biz/shop:youhui', 'nav' => 'biz/shop:youhui'),
                        array('title' => L('店铺优惠券'), 'ctl' => 'biz/shop:coupon', 'nav' => 'biz/shop:youhui'),
                        array('title' => L('删除满减优惠'), 'ctl' => 'biz/shop:youhuidel', 'menu' => false),
                        array('title' => L('删除店铺优惠券'), 'ctl' => 'biz/shop:coupondel', 'menu' => false),
                        array('title' => L('配送设置'), 'ctl' => 'biz/shop:pei', 'menu' => true),
                        array('title' => L('打印设置'), 'ctl' => 'biz/print:index', 'menu' => true),
                        array('title' => L('添加打印平台'), 'ctl' => 'biz/print:create', 'nav' => 'biz/print:index'),
                        array('title' => L('修改打印平台'), 'ctl' => 'biz/print:edit', 'nav' => 'biz/print:index'),
                        array('title' => L('删除打印平台'), 'ctl' => 'biz/print:delete', 'nav' => 'biz/print:index'),
                        array('title' => L('设置启用或静默'), 'ctl' => 'biz/print:setstatus', 'nav' => 'biz/print:index'),
                        array('title' => L('安全设置'), 'ctl' => 'biz/shop:passwd', 'nav' => 'biz/shop:index'),
                        array('title' => L('手机设置'), 'ctl' => 'biz/shop:mobile', 'nav' => 'biz/shop:index'),
                        array('title' => L('提现帐号'), 'ctl' => 'biz/shop:account', 'nav' => 'biz/shop:index'),
                        array('title' => L('店铺认证'), 'ctl' => 'biz/verify:index', 'menu' => true),
                        array('title' => L('内景设置'), 'ctl' => 'biz/shop:pic', 'menu' => true),
                        array('title' => L('添加内景'), 'ctl' => 'biz/shop:createpic', 'nav' => 'biz/shop:pic'),
                        array('title' => L('修改内景'), 'ctl' => 'biz/shop:editpic', 'nav' => 'biz/shop:pic'),
                        array('title' => L('删除内景'), 'ctl' => 'biz/shop:delpic', 'nav' => 'biz/shop:pic'),
                        array('title' => L('微店轮播'), 'ctl' => 'biz/shop:banner', 'menu' => true),
                        array('title' => L('添加微店轮播图'), 'ctl' => 'biz/shop:createbanner', 'nav' => 'biz/shop:banner'),
                        array('title' => L('修改微店轮播图'), 'ctl' => 'biz/shop:editbanner', 'nav' => 'biz/shop:banner'),
                        array('title' => L('删除微店轮播图'), 'ctl' => 'biz/shop:delbanner', 'nav' => 'biz/shop:banner'),
                        array('title' => L('功能开启'), 'ctl' => 'biz/shop:opened', 'menu' => true),
                        array('title' => L('功能开启提交'), 'ctl' => 'biz/shop:setopened', 'menu' => false),
                        array('title' => L('店主认证'), 'ctl' => 'biz/verify:dianzhu', 'nav' => 'biz/verify:index'),
                        array('title' => L('企业认证'), 'ctl' => 'biz/verify:yyzz', 'nav' => 'biz/verify:index'),
                        array('title' => L('餐饮认证'), 'ctl' => 'biz/verify:canyin', 'nav' => 'biz/verify:index'),
                    )
                ),
                array('title' => L('客户管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('我的客户'), 'ctl' => 'biz/member:index', 'menu' => true),
                        array('title' => L('我的粉丝'), 'ctl' => 'biz/member:fans', 'menu' => true),
                        array('title' => L('客户统计'), 'ctl' => 'biz/member:detail', 'nav' => 'biz/member:index'),
                    )
                ),
                array('title' => L('消息管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('订单消息'), 'ctl' => 'biz/msg:order', 'menu' => true),
                        array('title' => L('评价消息'), 'ctl' => 'biz/msg:comment', 'menu' => true),
                        array('title' => L('投诉消息'), 'ctl' => 'biz/msg:complain', 'menu' => true),
                        array('title' => L('系统消息'), 'ctl' => 'biz/msg:system', 'menu' => true),
                        array('title' => L('设置已读'), 'ctl' => 'biz/msg:setread', 'nav' => 'biz/msg:system'),
                    )
                ),
                array('title' => L('资金管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('资金管理'), 'ctl' => 'biz/money:index', 'menu' => true),
                        array('title' => L('资金日志'), 'ctl' => 'biz/money:log', 'nav' => 'biz/money:index'),
                        array('title' => L('提现日志'), 'ctl' => 'biz/money:txlog', 'menu' => true),
                        array('title' => L('申请提现'), 'ctl' => 'biz/money:tixian', 'nav' => 'biz/money:txlog'),
                    )
                ),
                array('title' => L('数据统计'), 'menu' => true,
                    'items' => array(
                        array('title' => L('收入统计'), 'ctl' => 'biz/tongji:income', 'menu' => true),
                        array('title' => L('订单统计'), 'ctl' => 'biz/tongji:order', 'menu' => true),
                        array('title' => L('订单来源'), 'ctl' => 'biz/tongji:orderfrom', 'menu' => true),
                        array('title' => L('商品销量'), 'ctl' => 'biz/tongji:product', 'menu' => true),
                    )
                ),
                array('title' => L('通用控制器'), 'menu' => false,
                    'items' => array(
                        array('title' => L('上传图片'), 'ctl' => 'biz/upload:photo', 'menu' => false),
                        array('title' => L('上传图片'), 'ctl' => 'biz/upload:editor', 'menu' => false),
                    )
                )
            ),
            ///菜品管理单
            'product' => array(
                array('title' => L('商品管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('商品分类'), 'ctl' => 'biz/cate:index', 'menu' => true),
                        array('title' => L('添加分类'), 'ctl' => 'biz/cate:create', 'nav' => 'biz/cate:index'),
                        array('title' => L('修改分类'), 'ctl' => 'biz/cate:edit', 'nav' => 'biz/cate:index'),
                        array('title' => L('删除分类'), 'ctl' => 'biz/cate:delete', 'nav' => 'biz/cate:index'),
                        array('title' => L('更新分类'), 'ctl' => 'biz/cate:update', 'nav' => 'biz/cate:index'),
                        array('title' => L('商品管理'), 'ctl' => 'biz/product:index', 'menu' => true),
                        array('title' => L('添加商品'), 'ctl' => 'biz/product:create', 'nav' => 'biz/product:index'),
                        array('title' => L('修改商品'), 'ctl' => 'biz/product:edit', 'nav' => 'biz/product:index'),
                        array('title' => L('删除商品'), 'ctl' => 'biz/product:delete', 'nav' => 'biz/product:index'),
                        array('title' => L('更新商品'), 'ctl' => 'biz/product:update', 'nav' => 'biz/product:index'),
                        array('title' => L('规格设置'), 'ctl' => 'biz/product:setspec', 'nav' => 'biz/product:index'),
                        array('title' => L('删除规格'), 'ctl' => 'biz/product:spec_del', 'nav' => 'biz/product:index'),
                    )
                ),
                array('title' => L('订单管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('订单管理'), 'ctl' => 'biz/order:index', 'menu' => true),
                        array('title' => L('配送订单'), 'ctl' => 'biz/order:pei', 'nav' => 'biz/order:index'),
                        array('title' => L('配送完成'), 'ctl' => 'biz/order:delivered', 'nav' => 'biz/order:index'),
                        array('title' => L('完成订单'), 'ctl' => 'biz/order:complete', 'nav' => 'biz/order:index'),
                        array('title' => L('订单取消'), 'ctl' => 'biz/order:cancel', 'nav' => 'biz/order:index'),
                        array('title' => L('自提订单'), 'ctl' => 'biz/order:ziti', 'nav' => 'biz/order:index'),
                        array('title' => L('商户接单'), 'ctl' => 'biz/order:accept', 'nav' => 'biz/order:index'),
                        array('title' => L('设为骑手配送'), 'ctl' => 'biz/order:setpei', 'nav' => 'biz/order:index'),
                        array('title' => L('自提单核销对话框'), 'ctl' => 'biz/order:dialog', 'nav' => 'biz/order:index'),
                        array('title' => L('自提订单核销'), 'ctl' => 'biz/order:setspend', 'nav' => 'biz/order:index'),
                        array('title' => L('订单完成'), 'ctl' => 'biz/order:finish', 'nav' => 'biz/order:index'),
                        array('title' => L('订单配送'), 'ctl' => 'biz/order:peisong', 'nav' => 'biz/order:index'),
                        array('title' => L('取消订单'), 'ctl' => 'biz/order:cancellist', 'nav' => 'biz/order:index'),
                        array('title' => L('回复订单'), 'ctl' => 'biz/order:reply', 'nav' => 'biz/order:index'),
                        array('title' => L('订单管理'), 'ctl' => 'biz/ordermanage:index'),
                        array('title' => L('订单详情'), 'ctl' => 'biz/order:detail', 'nav' => 'biz/order:index'),
                        array('title' => L('打印小票'), 'ctl' => 'biz/order:porder', 'nav' => 'biz/order:index'),
                        array('title' => L('检查打印机'), 'ctl' => 'biz/order:check_print', 'nav' => 'biz/order:index'),
                        array('title' => L('在线打印'), 'ctl' => 'biz/order:yun_print', 'nav' => 'biz/order:index'),
                        array('title' => L('订单详情'), 'ctl' => 'biz/order:getorder'),
                    )
                ),
            ),
            ///菜品管理单
            'pintuangroup' => array(
                array('title' => L('拼团商品管理'), 'menu' => true,
                    'items' => array(
                        //分类由系统统一设置,暂时不提供操作
//                        array('title' => L('拼团系统分类'), 'ctl' => 'biz/pintuancate:index', 'menu' => true),
//                        array('title' => L('添加拼团分类'), 'ctl' => 'biz/pintuancate:create', 'nav' => 'biz/pintuancate:index'),
//                        array('title' => L('修改拼团分类'), 'ctl' => 'biz/pintuancate:edit', 'nav' => 'biz/pintuancate:index'),
//                        array('title' => L('删除拼团分类'), 'ctl' => 'biz/pintuancate:delete', 'nav' => 'biz/pintuancate:index'),
//                        array('title' => L('更新拼团分类'), 'ctl' => 'biz/pintuancate:update', 'nav' => 'biz/pintuancate:index'),
                        array('title' => L('拼团商品'), 'ctl' => 'biz/pintuanproduct:index', 'menu' => true),
                        array('title' => L('添加拼团商品'), 'ctl' => 'biz/pintuanproduct:create', 'nav' => 'biz/pintuanproduct:index'),
                        array('title' => L('修改拼团商品'), 'ctl' => 'biz/pintuanproduct:edit', 'nav' => 'biz/pintuanproduct:index'),
                        array('title' => L('删除拼团商品'), 'ctl' => 'biz/pintuanproduct:delete', 'nav' => 'biz/pintuanproduct:index'),
                        array('title' => L('更新拼团商品'), 'ctl' => 'biz/pintuanproduct:update', 'nav' => 'biz/pintuanproduct:index'),
                    )
                ),
                array('title' => L('拼团管理'), 'menu' => true,
                    'items' => array(
                        array('title' => L('拼团管理'), 'ctl' => 'biz/pintuangroup:index', 'menu' => true),
                        array('title' => L('更新拼团'), 'ctl' => 'biz/pintuangroup:update', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('查看拼团'), 'ctl' => 'biz/pintuangroup:detail', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('组团中-拼团'), 'ctl' => 'biz/pintuangroup:start', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('组团成功-拼团'), 'ctl' => 'biz/pintuangroup:process', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('组团失败-拼团'), 'ctl' => 'biz/pintuangroup:complete', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('商家已接单-拼团'), 'ctl' => 'biz/pintuangroup:ok', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('商家接单-拼团'), 'ctl' => 'biz/pintuangroup:status_ok', 'nav' => 'biz/pintuangroup:index'),
                        array('title' => L('商家取消组团-拼团'), 'ctl' => 'biz/pintuangroup:status_complete', 'nav' => 'biz/pintuangroup:index'),
                        
                        array('title' => L('拼团订单'), 'ctl' => 'biz/pintuanorder:index', 'menu' => true),
                        array('title' => L('配送订单'), 'ctl' => 'biz/pintuanorder:pei', 'nav' => 'biz/pintuanorder:index'),
                        array('title' => L('配送完成'), 'ctl' => 'biz/pintuanorder:delivered', 'nav' => 'biz/pintuanorder:index'),
                        array('title' => L('订单完成'), 'ctl' => 'biz/pintuanorder:complete', 'nav' => 'biz/pintuanorder:index'),
                        array('title' => L('取消订单'), 'ctl' => 'biz/pintuanorder:cancellist', 'nav' => 'biz/pintuanorder:index'),
                        array('title' => L('配送订单'), 'ctl' => 'biz/pintuanorder:pei', 'nav' => 'biz/pintuanorder:index'),
                        
                    )
                ),
                array('title' => L('佣金记录'), 'menu' => true,
                    'items' => array(
                        
                        array('title' => L('佣金记录'), 'ctl' => 'biz/pintuanyongjin:index', 'menu' => true),
                        array('title' => L('支付佣金'), 'ctl' => 'biz/pintuanyongjin:pay', 'nav' => 'biz/pintuanyongjin:index'),
                        array('title' => L('查看流水'), 'ctl' => 'biz/pintuanyongjin:log', 'nav' => 'biz/pintuanyongjin:index'),
                        
                        
                    )
                ),
            )
);
