<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
array(
    'index' => array(
        array('title'=>L('管理中心'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('管理中心'), 'ctl'=>'biz/index:index', 'menu'=>true),
            )
        ),
        array('title'=>L('店铺设置'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('基本资料'), 'ctl'=>'biz/shop:index', 'menu'=>true), 
                array('title'=>L('优惠设置'), 'ctl'=>'biz/shop:youhui', 'menu'=>true),
                array('title'=>L('删除优惠'), 'ctl'=>'biz/shop:yhdelete','menu'=>false),
                array('title'=>L('配送设置'), 'ctl'=>'biz/shop:pei', 'menu'=>true),
                array('title'=>L('打印设置'), 'ctl'=>'biz/print:index', 'menu'=>true),
                array('title'=>L('添加打印平台'), 'ctl'=>'biz/print:create', 'nav'=>'biz/print:index'),
                array('title'=>L('修改打印平台'), 'ctl'=>'biz/print:edit', 'nav'=>'biz/print:index'),
                array('title'=>L('删除打印平台'), 'ctl'=>'biz/print:delete', 'nav'=>'biz/print:index'),
                array('title'=>L('设置启用或静默'), 'ctl'=>'biz/print:setstatus', 'nav'=>'biz/print:index'),
                array('title'=>L('安全设置'), 'ctl'=>'biz/shop:passwd', 'nav'=>'biz/shop:index'),
                array('title'=>L('手机设置'), 'ctl'=>'biz/shop:mobile', 'nav'=>'biz/shop:index'),
                array('title'=>L('提现帐号'), 'ctl'=>'biz/shop:account', 'nav'=>'biz/shop:index'),
                array('title'=>L('店铺认证'), 'ctl'=>'biz/verify:index', 'menu'=>true),
                array('title'=>L('店主认证'), 'ctl'=>'biz/verify:dianzhu', 'nav'=>'biz/verify:index'),
                array('title'=>L('企业认证'), 'ctl'=>'biz/verify:yyzz', 'nav'=>'biz/verify:index'),
                array('title'=>L('餐饮认证'), 'ctl'=>'biz/verify:canyin', 'nav'=>'biz/verify:index'),
            )
        ),         
        array('title'=>L('客户管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('我的客户'), 'ctl'=>'biz/member:index', 'menu'=>true),
                array('title'=>L('我的粉丝'), 'ctl'=>'biz/member:fans', 'menu'=>true),
                array('title'=>L('客户统计'), 'ctl'=>'biz/member:detail', 'nav'=>'biz/member:index'),
            )
        ),
        array('title'=>L('消息管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('订单消息'), 'ctl'=>'biz/msg:order', 'menu'=>true),
                array('title'=>L('评价消息'), 'ctl'=>'biz/msg:comment', 'menu'=>true),
                array('title'=>L('投诉消息'), 'ctl'=>'biz/msg:complain', 'menu'=>true),
                array('title'=>L('系统消息'), 'ctl'=>'biz/msg:system', 'menu'=>true),
                array('title'=>L('设置已读'), 'ctl'=>'biz/msg:setread', 'nav'=>'biz/msg:system'),
            )
        ),
        array('title'=>L('资金管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('资金管理'), 'ctl'=>'biz/money:index', 'menu'=>true),
                array('title'=>L('资金日志'), 'ctl'=>'biz/money:log', 'nav'=>'biz/money:index'),
                array('title'=>L('提现日志'), 'ctl'=>'biz/money:txlog','menu'=>true),
                array('title'=>L('申请提现'), 'ctl'=>'biz/money:tixian','nav'=>'biz/money:txlog'),
            )
        ),
        array('title'=>L('数据统计'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('收入统计'), 'ctl'=>'biz/tongji:income', 'menu'=>true),
                array('title'=>L('订单统计'), 'ctl'=>'biz/tongji:order', 'menu'=>true),
                array('title'=>L('订单来源'), 'ctl'=>'biz/tongji:orderfrom', 'menu'=>true),
                array('title'=>L('商品销量'), 'ctl'=>'biz/tongji:product', 'menu'=>true),
            )
        ), 
        array('title'=>L('通用控制器'), 'menu'=>false,
            'items'=>array(
                array('title'=>L('上传图片'), 'ctl'=>'biz/upload:photo', 'menu'=>false),
                array('title'=>L('上传图片'), 'ctl'=>'biz/upload:editor', 'menu'=>false),
            )
        )
    ),

    ///菜品管理单
    'product' => array(
        array('title'=>L('商品管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('商品分类'), 'ctl'=>'biz/cate:index', 'menu'=>true),
                array('title'=>L('添加分类'), 'ctl'=>'biz/cate:create', 'nav'=>'biz/cate:index'),
                array('title'=>L('修改分类'), 'ctl'=>'biz/cate:edit', 'nav'=>'biz/cate:index'),
                array('title'=>L('删除分类'), 'ctl'=>'biz/cate:delete', 'nav'=>'biz/cate:index'),
                array('title'=>L('更新分类'), 'ctl'=>'biz/cate:update', 'nav'=>'biz/cate:index'),

                array('title'=>L('商品管理'), 'ctl'=>'biz/product:index', 'menu'=>true),
                array('title'=>L('添加商品'), 'ctl'=>'biz/product:create', 'nav'=>'biz/product:index'),
                array('title'=>L('修改商品'), 'ctl'=>'biz/product:edit', 'nav'=>'biz/product:index'),
                array('title'=>L('删除商品'), 'ctl'=>'biz/product:delete', 'nav'=>'biz/product:index'),
                array('title'=>L('更新商品'), 'ctl'=>'biz/product:update', 'nav'=>'biz/product:index'),           
            )
        ),


        array('title'=>L('订单管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('订单管理'), 'ctl'=>'biz/order:index', 'menu'=>true),
                array('title'=>L('配送订单'), 'ctl'=>'biz/order:pei', 'nav'=>'biz/order:index'),
                array('title'=>L('配送完成'), 'ctl'=>'biz/order:delivered', 'nav'=>'biz/order:index'),
                array('title'=>L('完成订单'), 'ctl'=>'biz/order:complete','nav'=>'biz/order:index'),
                array('title'=>L('订单取消'), 'ctl'=>'biz/order:cancel', 'nav'=>'biz/order:index'),
                array('title'=>L('商户接单'), 'ctl'=>'biz/order:accept', 'nav'=>'biz/order:index'),
                array('title'=>L('订单完成'), 'ctl'=>'biz/order:finish','nav'=>'biz/order:index'),
                array('title'=>L('订单配送'), 'ctl'=>'biz/order:peisong', 'nav'=>'biz/order:index'),
                array('title'=>L('取消订单'), 'ctl'=>'biz/order:cancellist', 'nav'=>'biz/order:index'),
                array('title'=>L('回复订单'), 'ctl'=>'biz/order:reply','nav'=>'biz/order:index'),
                array('title'=>L('订单管理'), 'ctl'=>'biz/ordermanage:index'),
                array('title'=>L('订单详情'), 'ctl'=>'biz/order:detail', 'nav'=>'biz/order:index'),
                array('title'=>L('打印小票'), 'ctl'=>'biz/order:porder', 'nav'=>'biz/order:index'),
                array('title'=>L('检查打印机'), 'ctl'=>'biz/order:check_print', 'nav'=>'biz/order:index'),
                array('title'=>L('在线打印'), 'ctl'=>'biz/order:yun_print', 'nav'=>'biz/order:index'),
                array('title'=>L('订单详情'), 'ctl'=>'biz/order:getorder'),
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
                array('title'=>L('红包'), 'ctl'=>'biz/weixin/packet:index','nav'=>'biz/weixin/packet:index','menu'=>true),
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
    )
);
