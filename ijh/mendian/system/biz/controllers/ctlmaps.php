<?php
/*
  title =>  显示标题
  ctl       =>  ctl:act
  menu  => 是否显示菜单, 只有有相应权限并且这里设置true才会显示在菜单上
 */
return
array(

    'index' => array(
        array('title'=>'管理中心', 'menu'=>false,
            'items'=>array(
                array('title'=>'管理中心', 'ctl'=>'cashier/index:index', 'menu'=>true),
            )
        ),
        array(
            'title'=>'商品管理','menu'=>true,
            'items'=>array(
                array('title'=>'商品列表', 'ctl'=>'cashier/product:index', 'menu'=>true),

            )
        ),
        array(
            'title'=>'消息中心','menu'=>true,
            'items'=>array(
                array('title'=>'系统消息','ctl'=>'Cashier/messages:message','menu'=>true),
                array('title'=>'系统消息','ctl'=>'Cashier/messages:message','menu'=>true),
                array('title'=>'系统消息','ctl'=>'Cashier/messages:message','menu'=>true)
            )
        ),
        array(
            'title'=>'统计中心','menu'=>true,
            'items'=>array(
                array('title'=>'统计')
            )
        ),
        //权限判断--商家登录
        array(
            'title'=>'商家登录','meuu'=>false,
            'items'=>array(
                array('title'=>'商家登录','ctl'=>'cashier/account:index','menu'=>false),
                array('title'=>'登录首页','ctl'=>'cashier/account:login','menu'=>false),
                array('title'=>'商家推出登录','ctl'=>'cashier/account:loginout','meuu'=>false)
            )
        ),
        //权限判断--密码修改
        array(
            'title'=>'密码相关','menu'=>false,
            'items'=>array(
                array('title'=>'忘记密码one','ctl'=>'cashier/password:step_one','menu'=>false),
                array("title"=>'发送短信验证码','ctl'=>'cashier/password:sendsms','menu'=>false),
                array('title'=>'忘记密码one','ctl'=>'cashier/password:step_two','menu'=>false),
                array('title'=>'忘记密码one','ctl'=>'cashier/password:step_three','menu'=>false)
                

)
        )


       /* array('title'=>'消息管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'订单消息', 'ctl'=>'msg:order', 'menu'=>true),
                array('title'=>'评价消息', 'ctl'=>'msg:comment', 'menu'=>true),
                array('title'=>'投诉消息', 'ctl'=>'msg:complain', 'menu'=>true),
                array('title'=>'系统消息', 'ctl'=>'msg:system', 'menu'=>true),
                array('title'=>'订单消息详情', 'ctl'=>'order:detailorder', 'menu'=>false),
                array('title'=>'评价消息详情', 'ctl'=>'order:detailcomment', 'menu'=>false),
                array('title'=>'投诉消息详情', 'ctl'=>'order:detailcomplain', 'menu'=>false),
                array('title'=>'系统消息详情', 'ctl'=>'order:detailsystem', 'menu'=>false),
            )
        ),
        array('title'=>'数据统计', 'menu'=>true,
            'items'=>array(
                array('title'=>'收入统计', 'ctl'=>'tongji:income', 'menu'=>true),
                array('title'=>'收入统计', 'ctl'=>'tongji:w_income', 'menu'=>false),
                array('title'=>'团购、代金券收入统计', 'ctl'=>'tongji:t_income', 'menu'=>false),
                array('title'=>'优惠买单收入统计', 'ctl'=>'tongji:m_income', 'menu'=>false),
                array('title'=>'订单统计', 'ctl'=>'tongji:order', 'menu'=>true),
                array('title'=>'外卖订单统计', 'ctl'=>'tongji:w_order', 'menu'=>false),
                array('title'=>'团购订单统计', 'ctl'=>'tongji:t_order', 'menu'=>false),
                array('title'=>'买单订单统计', 'ctl'=>'tongji:m_order', 'menu'=>false),
                array('title'=>'订单来源', 'ctl'=>'tongji:orderfrom', 'menu'=>true),
                array('title'=>'团购订单来源', 'ctl'=>'tongji:t_orderfrom', 'menu'=>false),
                array('title'=>'外卖订单来源', 'ctl'=>'tongji:w_orderfrom', 'menu'=>false),
                array('title'=>'买单订单来源', 'ctl'=>'tongji:m_orderfrom', 'menu'=>false),
                array('title'=>'商品销量', 'ctl'=>'tongji:product', 'menu'=>true),
                
            )
        ),
         array('title'=>'通用控制器', 'menu'=>false,
            'items'=>array(
                array('title'=>'上传图片', 'ctl'=>'upload:photo', 'menu'=>false),
                array('title'=>'上传图片', 'ctl'=>'upload:editor', 'menu'=>false),
            )
        )       */
    )
);