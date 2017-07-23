<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="源神CMS程序安装">
    <meta name="author" content="YSCMS.cn,Pixel grid studio">
    <title>源神CMS程序安装</title>
    <link href="/Public/install/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/install/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/Public/install/js/html5shiv.js"></script>
    <script src="/Public/install/js/respond.min.js"></script>
    <![endif]-->

    <!--[if IE]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>源神CMS在谷歌浏览器下体验更好！速度更快！</strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
    </div>
    <![endif]-->

    <!--[if lte IE 8]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>您正在使用低版本浏览器，</strong> 在本页面的显示效果可能有差异。建议您升级到<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">Chrome</a>
        或以下浏览器：<a href="https://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> /<a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> /<a href="http://www.opera.com/" target="_blank">Opera</a> /<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">Internet Explorer 11</a>
    </div>
    <![endif]-->
    
</head>
<body>
<section class="container">
    <!--main content start-->
    <section class="wrapper">
        <!-- page start-->
        <div class="YSCMSstep" id="bounceInLeft">
            <div class="col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="logo text-center">
                            <a href="http://www.168282.com/" target="_blank"><span>源神CMS安装五步曲</span></a>
                        </div>
                        <div class="stepy-tab text-center">
                            <ul id="default-titles" class="stepy-titles clearfix">
                                <li id="default-title-0" <?php echo ($step == 1 ? 'class="current-step"' : ''); ?>>
                                    <div>安装须知</div>
                                </li>
                                <li id="default-title-1" <?php echo ($step == 2 ? 'class="current-step"' : ''); ?>>
                                    <div>环境检测</div>
                                </li>
                                <li id="default-title-2" <?php echo ($step == 3 ? 'class="current-step"' : ''); ?>>
                                    <div>账号配置</div>
                                </li>
                                <li id="default-title-3" <?php echo ($step == 4 ? 'class="current-step"' : ''); ?>>
                                    <div>正在安装</div>
                                </li>
                                <li id="default-title-4" <?php echo ($step == 5 ? 'class="current-step"' : ''); ?>>
                                    <div>安装完成</div>
                                </li>
                            </ul>
                        </div>

                        
    <form name="myform" action="/index.php?m=install&c=index&a=index&step=3" method="post" id="myform" onsubmit="return check();" class="form-horizontal" >
        <fieldset class="step" id="default-step-2" >
            <div class="row">
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading">填写数据库信息</header>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库主机：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="db_host" id="db_host" class="form-control" value="localhost">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库帐号：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="db_user" id="db_user" value="root" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="db_pass" id="db_pass" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库名称：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="db_name" id="db_name" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库前缀：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="db_prefix" id="db_prefix" class="form-control" value="ys_">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-lg-6">
                    <section class="panel admin">
                        <header class="panel-heading">填写管理员信息</header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">管理员帐号：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="admin_username" id="admin_username" class="form-control" value="admin" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">管理员密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="admin_password" id="admin_password" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">重复密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="repassword" id="repassword" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="text-center stepbtn">
                <input type="submit" name="submit" class="btn btn-info btn-shadow btn-step" value="开始安装" >
            </div>
        </fieldset>
    </form>


                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>


    <script src="http://cdn.bootcss.com/jquery/1.12.4/jquery.js"></script>
    <script>
        function check() {
            if (
                    $('#db_host').val() == '' ||
                    $('#db_user').val() == '' ||
                    //$('#db_pass').val() == '' ||
                    $('#db_name') == ''
            ) {
                alert('请填写完整数据库信息');
                return false;
            }

            if ($('#admin_username').val() == '') {
                alert('请输入管理员账号');
                return false;
            }

            if ($('#admin_password').val() == '') {
                alert('请输入管理员密码');
                return false;
            }

            if ($('#admin_password').val() != $('#repassword').val()) {
                alert('两次输入密码不一致');
                return false;
            }
            return true;
        }
    </script>

</body>
</html>