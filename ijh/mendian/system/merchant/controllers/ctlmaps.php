<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
    array(
        '首页|fa fa-home|merchant/index' => array(
            array('title' => '管理中心','icon' => 'fa fa-cog', 'menu' => true,
                'items' => array(
                    array('title' => '管理中心', 'ctl' => 'merchant/index:index', 'menu' => true),
                )
            ),
            array('title' => '消息管理', 'menu' => true, 'icon' => 'fa fa-comment',
                'items' => array(
                    array('title' => '订单消息', 'ctl' => 'merchant/msg:order', 'menu' => true),
                    array('title' => '评价消息', 'ctl' => 'merchant/msg:comment', 'menu' => true),
                    array('title' => '投诉消息', 'ctl' => 'merchant/msg:complain', 'menu' => true),
                    array('title' => '系统消息', 'ctl' => 'merchant/msg:system', 'menu' => true),
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
                    array('title' => '商品销量', 'ctl' => 'merchant/tongji:product', 'menu' => true),

                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
		
		'商品管理|fa fa-cashier|merchant/cashier/index' => array(
			array('title' => '商品分类', 'menu' => true, 'icon' => 'fa fa-product',
                'items' => array(
                    array('title' => '分类列表', 'ctl' => 'merchant/cashier/productcate:index', 'menu' => true),
                    array('title' => '分类创建', 'ctl' => 'merchant/cashier/productcate:create', 'menu' => false),
					array('title' => '分类编辑', 'ctl' => 'merchant/cashier/productcate:edit', 'menu' => false),
					array('title' => '分类删除', 'ctl' => 'merchant/cashier/productcate:delete', 'menu' => false),
					array('title' => '分类搜索', 'ctl' => 'merchant/cashier/productcate:so', 'menu' => false),
                )
            ),
            array('title' => '商品管理', 'menu' => true, 'icon' => 'fa fa-product',
                'items' => array(
                    array('title' => '商品列表', 'ctl' => 'merchant/cashier/product:index', 'menu' => true),
                    array('title' => '商品创建', 'ctl' => 'merchant/cashier/product:create', 'menu' => false),
					array('title' => '商品编辑', 'ctl' => 'merchant/cashier/product:edit', 'menu' => false),
					array('title' => '商品删除', 'ctl' => 'merchant/cashier/product:delete', 'menu' => false),
					array('title' => '商品搜索', 'ctl' => 'merchant/cashier/product:so', 'menu' => false),
                )
            ),
			
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
		'收银管理|fa fa-cashier|merchant/cashier/index' => array(
			array('title' => '收银设置', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '收银设置', 'ctl' => 'merchant/cashier/set:index', 'menu' => true),
					array('title' => '打印设置', 'ctl' => 'merchant/cashier/set:printer', 'menu' => true),
                )
            ),
            array('title' => '收银员管理', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '收银员列表', 'ctl' => 'merchant/cashier/staff:index', 'menu' => true),
                    array('title' => '添加收银员', 'ctl' => 'merchant/cashier/staff:create', 'nav' => 'merchant/cashier/staff:index'),
                    array('title' => '编辑收银员', 'ctl' => 'merchant/cashier/staff:edit', 'nav' => 'merchant/cashier/staff:index'),
                    array('title' => '删除收银员', 'ctl' => 'merchant/cashier/staff:delete', 'nav' => 'merchant/cashier/staff:index'),
                    array('title' => '批量删除', 'ctl' => 'merchant/cashier/staff:delAll', 'nav' => 'merchant/cashier/staff:index'),
                    array('title' => '搜索', 'ctl' => 'merchant/cashier/staff:so', 'nav' => 'merchant/cashier/staff:index')
                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),

        '会员管理|fa fa-cashier|merchant/shop/card/index' => array(
            array('title' => '会员管理', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '会员列表', 'ctl' => 'merchant/shop/card:index', 'menu' => true),
                    array('title' => '会员创建', 'ctl' => 'merchant/shop/card:create', 'nav' => 'merchant/shop/card:index'),
                    array('title' => '会员编辑', 'ctl' => 'merchant/shop/card:edit', 'nav' => 'merchant/shop/card:index'),
                    array('title' => '会员删除', 'ctl' => 'merchant/shop/card:delete', 'nav' => 'merchant/shop/card:index'),
                    array('title' => '批量删除', 'ctl' => 'merchant/shop/card:delAll', 'nav' => 'merchant/shop/card:index'),
                    array('title' => '会员搜索', 'ctl' => 'merchant/shop/card:so', 'nav' => 'merchant/shop/card:index'),
                    array('title' => '消费记录', 'ctl' => 'merchant/shop/expense:index', 'menu' => false),
                    array('title' => '积分记录', 'ctl' => 'merchant/shop/jifen:index', 'menu' => false)
                )
            ),
            array('title' => '会员等级管理', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '会员等级列表', 'ctl' => 'merchant/shop/grade:index', 'menu' => true),
                    array('title' => '会员等级创建', 'ctl' => 'merchant/shop/grade:create', 'nav' => 'merchant/shop/grade:index'),
                    array('title' => '会员等级编辑', 'ctl' => 'merchant/shop/grade:edit', 'nav' => 'merchant/shop/grade:index'),
                    array('title' => '会员等级删除', 'ctl' => 'merchant/shop/grade:delete', 'nav' => 'merchant/shop/grade:index')
                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
        '会员充值|fa fa-cashier|merchant/shop/card/chongzhi' => array(
            array('title' => '会员充值', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '会员充值', 'ctl' => 'merchant/shop/card:chongzhi', 'menu' => true),
                    array('title' => '生成订单', 'ctl' => 'merchant/shop/card:chongzhi_sub', 'menu' => false),
                    array('title' => '提交充值', 'ctl' => 'merchant/shop/card:cashpay', 'menu' => false),
                    array('title' => '实收dialog', 'ctl' => 'merchant/shop/card:cancel_order', 'menu' => false),
                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
        '收款|fa fa-cashier|merchant/cashier/order/payee' => array(
            array('title' => '收款', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '收款', 'ctl' => 'merchant/cashier/order:payee', 'menu' => true),
                    array('title' => '收款', 'ctl' => 'merchant/cashier/order:create', 'menu' => false),
                    array('title' => '收款', 'ctl' => 'merchant/cashier/order:cancel', 'menu' => false),
                    array('title' => '收款', 'ctl' => 'merchant/cashier/order:cashpay', 'menu' => false),
                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
        '我的收入|fa fa-cashier|merchant/shop/expense/index' => array(
            array('title' => '消费记录', 'menu' => true, 'icon' => 'fa fa-cashier',
                'items' => array(
                    array('title' => '消费列表', 'ctl' => 'merchant/shop/expense:index', 'menu' => true),
                    array('title' => '搜索', 'ctl' => 'merchant/shop/expense:so', 'nav' => 'merchant/shop/expense:index')
                )
            ),
            array('title' => '通用控制器', 'menu' => false,
                'items' => array(
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:photo', 'menu' => false),
                    array('title' => '上传图片', 'ctl' => 'merchant/upload:editor', 'menu' => false),
                )
            )
        ),
        '店铺|fa fa-institution|merchant/shop/coupon' => array(
            array('title' => '基本设置','icon' => 'fa fa-gears', 'menu' => true,
                'items' => array(
                    array('title' => '资料设置', 'ctl' => 'merchant/shop:index', 'menu' => true),
                    array('title' => '安全设置', 'ctl' => 'merchant/shop:passwd', 'nav' => 'merchant/shop:index'),
                    array('title' => '获取商圈', 'ctl' => 'merchant/shop:get_business', 'nav' => 'merchant/shop:index'),
                    array('title' => '更换手机', 'ctl' => 'merchant/shop:mobile', 'nav' => 'merchant/shop:index'),
                    array('title' => '提现帐号', 'ctl' => 'merchant/shop:account', 'nav' => 'merchant/shop:index'),
                    array('title' => '店铺认证', 'ctl' => 'merchant/shop/verify:index', 'menu' => true),
                    array('title' => '店主认证', 'ctl' => 'merchant/shop/verify:dianzhu', 'nav' => 'merchant/shop/verify:index'),
                    array('title' => '企业认证', 'ctl' => 'merchant/shop/verify:yyzz', 'nav' => 'merchant/shop/verify:index'),
                    array('title' => '餐饮认证', 'ctl' => 'merchant/shop/verify:canyin', 'nav' => 'merchant/shop/verify:index'),
                    array('title' => '功能开通', 'ctl' => 'merchant/shop/open:index', 'menu' => true),
                    array('title' => '功能开通', 'ctl' => 'merchant/shop/open:save', 'nav' => 'merchant/shop/open:save'),
                    array('title' => '打印设置', 'ctl' => 'merchant/shop/print:index', 'menu' => true),
                    array('title' => '添加设置', 'ctl' => 'merchant/shop/print:create', 'nav' => 'merchant/shop/print:index'),
                    array('title' => '相册设置', 'ctl' => 'merchant/shop/album:index', 'menu' => true),
                    array('title' => '添加相册', 'ctl' => 'merchant/shop/album:create', 'nav' => 'merchant/shop/album:index'),
                    array('title' => '修改相册', 'ctl' => 'merchant/shop/album:edit', 'nav' => 'merchant/shop/album:index'),
                    array('title' => '删除相册', 'ctl' => 'merchant/shop/album:delete', 'nav' => 'merchant/shop/album:index'),
                    array('title' => '管理相册', 'ctl' => 'merchant/shop/album:detail', 'nav' => 'merchant/shop/album:index'),
                    array('title' => '修改设置', 'ctl' => 'merchant/shop/print:edit', 'nav' => 'merchant/shop/print:index'),
                    array('title' => '删除设置', 'ctl' => 'merchant/shop/print:delete', 'nav' => 'merchant/shop/print:index'),
                    array('title' => '开启或静默', 'ctl' => 'merchant/shop/print:change', 'nav' => 'merchant/shop/print:index'),
                )
            )
        ),

);
