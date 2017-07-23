<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
array(
    'index' => array(
        array('title'=>'管理中心', 'menu'=>true,
            'items'=>array(
                array('title'=>'管理中心', 'ctl'=>'biz/index:index', 'menu'=>true),
            )
        ),
        array('title'=>'店铺设置', 'menu'=>true,
            'items'=>array(
                array('title'=>'基本资料', 'ctl'=>'biz/shop:index', 'menu'=>true),
                array('title'=>'优惠设置', 'ctl'=>'biz/shop:youhui', 'menu'=>true),
                array('title'=>'设置优惠', 'ctl'=>'biz/shop:yhcreate','menu'=>false),
                array('title'=>'编辑优惠', 'ctl'=>'biz/shop:yhedit','menu'=>false),
                array('title'=>'删除优惠', 'ctl'=>'biz/shop:yhdelete','menu'=>false),
                array('title'=>'配送设置', 'ctl'=>'biz/shop:pei', 'menu'=>true),
                array('title'=>'安全设置', 'ctl'=>'biz/shop:passwd', 'nav'=>'biz/shop:index'),
                array('title'=>'手机设置', 'ctl'=>'biz/shop:mobile', 'nav'=>'biz/shop:index'),
                array('title'=>'提现帐号', 'ctl'=>'biz/shop:account', 'nav'=>'biz/shop:index'),
                array('title'=>'店铺认证', 'ctl'=>'biz/verify:index', 'menu'=>true),
                array('title'=>'轮播设置', 'ctl' => 'biz/shop:pic', 'menu' => true),
                array('title'=>'添加轮播', 'ctl' => 'biz/shop:createpic', 'nav' => 'biz/shop:pic'),
                array('title'=>'修改轮播', 'ctl' => 'biz/shop:editpic', 'nav' => 'biz/shop:pic'),
                array('title'=>'删除轮播', 'ctl' => 'biz/shop:delpic', 'nav' => 'biz/shop:pic'),
                array('title'=>'店主认证', 'ctl'=>'biz/verify:dianzhu', 'nav'=>'biz/verify:index'),
                array('title'=>'企业认证', 'ctl'=>'biz/verify:yyzz', 'nav'=>'biz/verify:index'),
                array('title'=>'餐饮认证', 'ctl'=>'biz/verify:canyin', 'nav'=>'biz/verify:index'),
            )
        ),         
        array('title'=>'客户管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'我的客户', 'ctl'=>'biz/member:index', 'menu'=>true),
                array('title'=>'我的粉丝', 'ctl'=>'biz/member:fans', 'menu'=>true),
                array('title'=>'客户统计', 'ctl'=>'biz/member:detail', 'nav'=>'biz/member:index'),
            )
        ),
        array('title'=>'消息管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'订单消息', 'ctl'=>'biz/msg:order', 'menu'=>true),
                array('title'=>'评价消息', 'ctl'=>'biz/msg:comment', 'menu'=>true),
                array('title'=>'投诉消息', 'ctl'=>'biz/msg:complain', 'menu'=>true),
                array('title'=>'系统消息', 'ctl'=>'biz/msg:system', 'menu'=>true),
                array('title'=>'设置已读', 'ctl'=>'biz/msg:setread', 'nav'=>'biz/msg:system'),
            )
        ),
        array('title'=>'资金管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'资金管理', 'ctl'=>'biz/money:index', 'menu'=>true),
                array('title'=>'资金日志', 'ctl'=>'biz/money:log', 'nav'=>'biz/money:index'),
                array('title'=>'提现日志', 'ctl'=>'biz/money:txlog','menu'=>true),
                array('title'=>'申请提现', 'ctl'=>'biz/money:tixian','nav'=>'biz/money:txlog'),
            )
        ),
        array('title'=>'数据统计', 'menu'=>true,
            'items'=>array(
                array('title'=>'收入统计', 'ctl'=>'biz/tongji:income', 'menu'=>true),
                array('title'=>'订单统计', 'ctl'=>'biz/tongji:order', 'menu'=>true),
                array('title'=>'订单来源', 'ctl'=>'biz/tongji:orderfrom', 'menu'=>true),
                array('title'=>'商品销量', 'ctl'=>'biz/tongji:product', 'menu'=>true),
                //array('title'=>'客户统计', 'ctl'=>'biz/tongji:member', 'menu'=>true),
            )
        ), 
        array('title'=>'通用控制器', 'menu'=>false,
            'items'=>array(
                array('title'=>'上传图片', 'ctl'=>'biz/upload:photo', 'menu'=>false),
                array('title'=>'上传图片', 'ctl'=>'biz/upload:editor', 'menu'=>false),
            )
        )
    ),

    ///菜品管理单
    'product' => array(
        array('title'=>'商品管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'商品分类', 'ctl'=>'biz/cate:index', 'menu'=>true),
                array('title'=>'添加分类', 'ctl'=>'biz/cate:create', 'nav'=>'biz/cate:index'),
                array('title'=>'修改分类', 'ctl'=>'biz/cate:edit', 'nav'=>'biz/cate:index'),
                array('title'=>'删除分类', 'ctl'=>'biz/cate:delete', 'nav'=>'biz/cate:index'),
                array('title'=>'更新分类', 'ctl'=>'biz/cate:update', 'nav'=>'biz/cate:index'),

                array('title'=>'商品管理', 'ctl'=>'biz/product:index', 'menu'=>true),
                array('title'=>'添加商品', 'ctl'=>'biz/product:create', 'nav'=>'biz/product:index'),
                array('title'=>'修改商品', 'ctl'=>'biz/product:edit', 'nav'=>'biz/product:index'),
                array('title'=>'删除商品', 'ctl'=>'biz/product:delete', 'nav'=>'biz/product:index'),
                array('title'=>'更新商品', 'ctl'=>'biz/product:update', 'nav'=>'biz/product:index'),    
                array('title'=>'设置规格', 'ctl'=>'biz/product:spec', 'nav'=>'biz/product:index'),   
                array('title'=>'删除规格', 'ctl'=>'biz/product:spec_del', 'nav'=>'biz/product:index'),    
            )
        ),


        array('title'=>'订单管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'订单管理', 'ctl'=>'biz/order:index', 'menu'=>true),
                array('title'=>'核销订单', 'ctl'=>'biz/order:spend', 'nav'=>'biz/order:index'),
                array('title'=>'核销弹框', 'ctl'=>'biz/order:dialog', 'nav'=>'biz/order:index'),
                array('title'=>'确认消费', 'ctl'=>'biz/order:setspend', 'nav'=>'biz/order:index'),
                array('title'=>'配送完成', 'ctl'=>'biz/order:delivered', 'nav'=>'biz/order:index'),
                array('title'=>'完成订单', 'ctl'=>'biz/order:complete','nav'=>'biz/order:index'),
                array('title'=>'订单取消', 'ctl'=>'biz/order:cancel', 'nav'=>'biz/order:index'),
                array('title'=>'商户接单', 'ctl'=>'biz/order:accept', 'nav'=>'biz/order:index'),
                array('title'=>'订单完成', 'ctl'=>'biz/order:finish','nav'=>'biz/order:index'),
                array('title'=>'订单配送', 'ctl'=>'biz/order:peisong', 'nav'=>'biz/order:index'),
                array('title'=>'取消订单', 'ctl'=>'biz/order:cancellist', 'nav'=>'biz/order:index'),
                array('title'=>'回复订单', 'ctl'=>'biz/order:reply','nav'=>'biz/order:index'),
                array('title'=>'订单管理', 'ctl'=>'biz/ordermanage:index'),
                array('title'=>'订单详情', 'ctl'=>'biz/order:detail', 'nav'=>'biz/order:index'),
                array('title'=>'打印小票', 'ctl'=>'biz/order:porder', 'nav'=>'biz/order:index'),
                array('title'=>'订单详情', 'ctl'=>'biz/order:getorder'),
            )
        ), 
        
    )
);
