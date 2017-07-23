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
                array('title'=>L('管理中心'), 'ctl'=>'ditui/index:index', 'menu'=>true),
            )
        ),
        array('title'=>L('基本设置'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('基本资料'), 'ctl'=>'ditui/base:index', 'menu'=>true),
                array('title'=>L('安全设置'), 'ctl'=>'ditui/base:passwd', 'nav'=>'ditui/base:index'),
                array('title'=>L('手机设置'), 'ctl'=>'ditui/base:mobile', 'nav'=>'ditui/base:index'),
                array('title'=>L('提现帐号'), 'ctl'=>'ditui/base:account', 'nav'=>'ditui/base:index'),
                array('title'=>L('身份认证'), 'ctl'=>'ditui/base:license', 'nav'=>'ditui/base:index'),
            )
        ),         
        array('title'=>L('推广管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('地推用户'), 'ctl'=>'ditui/member:index', 'menu'=>true),
                array('title'=>L('用户详情'), 'ctl'=>'ditui/member:detail', 'nav'=>'ditui/member:index'),
                array('title'=>L('地推商家'), 'ctl'=>'ditui/shop:index', 'menu'=>true),
            )
        ),
        array('title'=>L('日志管理'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('日志管理'), 'ctl'=>'ditui/log:index', 'menu'=>true),
            )
        ),
        array('title'=>L('数据统计'), 'menu'=>true,
            'items'=>array(
                array('title'=>L('收入统计'), 'ctl'=>'ditui/tongji:mincome', 'menu'=>true),
                array('title'=>L('地推用户'), 'ctl'=>'ditui/tongji:member', 'menu'=>true),
                array('title'=>L('地推商家'), 'ctl'=>'ditui/tongji:shop', 'menu'=>true),
                array('title'=>L('用户渠道'), 'ctl'=>'ditui/tongji:mincome', 'nav'=>'ditui/tongji:mincome'),
                array('title'=>L('商家渠道'), 'ctl'=>'ditui/tongji:sincome', 'nav'=>'ditui/tongji:mincome'),
            )
        ), 
        array('title'=>L('通用控制器'), 'menu'=>false,
            'items'=>array(
                array('title'=>L('上传图片'), 'ctl'=>'biz/upload:photo', 'menu'=>false),
                array('title'=>L('上传图片'), 'ctl'=>'biz/upload:editor', 'menu'=>false),
            )
        )
    )
);
