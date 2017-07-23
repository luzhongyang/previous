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
                array('title'=>'管理中心', 'ctl'=>'wuye/index:index', 'menu'=>true),
                array('title'=>'绑定小区', 'ctl'=>'wuye/index:bind', 'menu'=>false),
                array('title'=>'绑定小区确认', 'ctl'=>'wuye/index:bind_sub', 'menu'=>false),
            )
        ),
        array('title'=>'小区管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'业主列表', 'ctl'=>'wuye/yezhu/index:index', 'menu'=>true),
                array('title'=>'业主详情', 'ctl'=>'wuye/yezhu/index:detail', 'menu'=>false),
                array('title'=>'创建业主', 'ctl'=>'wuye/yezhu/index:create', 'menu'=>false),
                array('title'=>'编辑业主', 'ctl'=>'wuye/yezhu/index:edit', 'menu'=>false),
                array('title'=>'删除业主', 'ctl'=>'wuye/yezhu/index:delete', 'menu'=>false),
                array('title'=>'批量导入缴费单', 'ctl'=>'wuye/yezhu/index:bill_import', 'menu'=>false),
                array('title'=>'批量导入缴费单确认', 'ctl'=>'wuye/yezhu/index:bill_import_sub', 'menu'=>false), //支持单条和批量导入缴费单
                array('title'=>'设置状态', 'ctl'=>'wuye/yezhu/index:set_audit', 'menu'=>false),

                array('title'=>'轮播广告', 'ctl'=>'wuye/banner/index:index', 'menu'=>true),
                array('title'=>'创建轮播', 'ctl'=>'wuye/banner/index:create', 'menu'=>false),
                array('title'=>'修改轮播', 'ctl'=>'wuye/banner/index:edit', 'menu'=>false),
                array('title'=>'删除轮播', 'ctl'=>'wuye/banner/index:delete', 'menu'=>false),
                array('title'=>'审核轮播', 'ctl'=>'wuye/banner/index:audit', 'menu'=>false),
                
                array('title'=>'新闻列表', 'ctl'=>'wuye/news/index:index', 'menu'=>true),
                array('title'=>'添加新闻', 'ctl'=>'wuye/news/index:create', 'menu'=>false),  
                array('title'=>'修改新闻', 'ctl'=>'wuye/news/index:edit', 'menu'=>false), 
                array('title'=>'删除新闻', 'ctl'=>'wuye/news/index:delete', 'menu'=>false), 
                array('title'=>'新闻详情', 'ctl'=>'wuye/news/index:detail', 'menu'=>false), 
                
                array('title'=>'缴费订单列表', 'ctl'=>'wuye/bill/index:index', 'menu'=>true),
                array('title'=>'批量导入', 'ctl'=>'wuye/bill/index:import', 'menu'=>false),  
                array('title'=>'模板下载', 'ctl'=>'wuye/bill/index:download', 'menu'=>false), 
                array('title'=>'创建个人缴费单', 'ctl'=>'wuye/bill/index:create', 'menu'=>false), 
                array('title'=>'编辑缴费单', 'ctl'=>'wuye/bill/index:edit', 'menu'=>false), 
                array('title'=>'删除缴费单', 'ctl'=>'wuye/bill/index:delete', 'menu'=>false), 
                
                array('title'=>'便民服务', 'ctl'=>'wuye/bianmin/index:index', 'menu'=>true),
                array('title'=>'创建服务', 'ctl'=>'wuye/bianmin/index:create', 'menu'=>false),
                array('title'=>'编辑服务', 'ctl'=>'wuye/bianmin/index:edit', 'menu'=>false),
                array('title'=>'删除服务', 'ctl'=>'wuye/bianmin/index:delete', 'menu'=>false),
                array('title'=>'报修详情', 'ctl'=>'wuye/bianmin/index:detail', 'menu'=>false),
                
                array('title'=>'报修记录', 'ctl'=>'wuye/baoxiu/index:index', 'menu'=>true),
                array('title'=>'报修记录详情', 'ctl'=>'wuye/baoxiu/index:detail', 'menu'=>false),
                array('title'=>'设置状态', 'ctl'=>'wuye/baoxiu/index:set_status', 'menu'=>false),
                array('title'=>'删除报修', 'ctl'=>'wuye/baoxiu/index:delete', 'menu'=>false),
                array('title'=>'报修回复', 'ctl'=>'wuye/baoxiu/index:reply', 'menu'=>false),
                
                array('title'=>'投诉记录', 'ctl'=>'wuye/report/index:index', 'menu'=>true),
                array('title'=>'投诉详情', 'ctl'=>'wuye/report/index:detail', 'menu'=>false),
                array('title'=>'设置状态', 'ctl'=>'wuye/report/index:set_status', 'menu'=>false),
                array('title'=>'删除投诉', 'ctl'=>'wuye/report/index:delete', 'menu'=>false),
                array('title'=>'投诉回复', 'ctl'=>'wuye/report/index:reply', 'menu'=>false),
            )
        ),

         array('title'=>'通用控制器', 'menu'=>false,
            'items'=>array(
                array('title'=>'上传图片', 'ctl'=>'wuye/upload:photo', 'menu'=>false),
                array('title'=>'上传图片', 'ctl'=>'wuye/upload:editor', 'menu'=>false),
            )
        )       
    ),


    'tixian' => array(
        array('title'=>'物业相关', 'menu'=>true,
            'items'=>array(
                array('title'=>'小区管理', 'ctl'=>'wuye/xiaoqu/index:index', 'menu'=>true),
                array('title'=>'小区详情', 'ctl'=>'wuye/xiaoqu/index:detail', 'menu'=>false),
                array('title'=>'编辑小区', 'ctl'=>'wuye/xiaoqu/index:edit', 'menu'=>false),
                array('title'=>'账户管理', 'ctl'=>'wuye/manage/index:index', 'menu'=>true),
                array('title'=>'修改密码', 'ctl'=>'wuye/manage/index:update_passwd', 'menu'=>false),
                array('title'=>'修改手机', 'ctl'=>'wuye/manage/index:update_mobile', 'menu'=>false),
            )
        ),
        array('title'=>'提现管理', 'menu'=>true,
            'items'=>array(
                array('title'=>'提现记录', 'ctl'=>'wuye/tixian/index:index', 'menu'=>true),
                array('title'=>'绑定银行', 'ctl'=>'wuye/tixian/index:bind_bank', 'menu'=>true),
                array('title'=>'申请提现', 'ctl'=>'wuye/tixian/index:reg', 'menu'=>true),
                array('title'=>'余额日志', 'ctl'=>'wuye/tixian/index:money_log', 'menu'=>true),
                array('title'=>'修改银行', 'ctl'=>'wuye/tixian/index:edit', 'menu'=>false),
            )
        ),
    ),

    
);
