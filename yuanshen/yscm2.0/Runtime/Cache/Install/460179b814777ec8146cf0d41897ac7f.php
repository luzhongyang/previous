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

                        
    <form class="form-horizontal" id="default" action="/index.php?m=install&c=index&a=index&step=2" method="post">
        <fieldset class="step" id="default-step-1" >
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">系统部署检测</header>
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>目录名</th>
                                <th class="hidden-phone">要求</th>
                                <th>是否可写</th>
                                <th>环境状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($dirCheck)): $i = 0; $__LIST__ = $dirCheck;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dir): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($dir); ?></td>
                                <td class="hidden-phone">必须可写</td>
                                <td><?php echo is_writable($dir) ? '可写' : '不可写' ?></td>
                                <td>
                                    <?php echo is_writable($dir) ? '<div class="right"></div>' : '<div class="error"></div>' ?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">环境检测</header>
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th>检测项目</th>
                                <th class="hidden-phone">所需配置</th>
                                <th>最佳环境</th>
                                <th>当前环境</th>
                                <th>环境状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>操作系统</td>
                                <td class="hidden-phone">不限制</td>
                                <td>Linux</td>
                                <td><?php echo get_run_os();?></td>
                                <td><div class="right"></div></td>
                            </tr>
                            <tr>
                                <td>WEB 服务器</td>
                                <td class="hidden-phone">Apache/Nginx/IIS</td>
                                <td>apache2.4 / Nginx1.7 / IIS8.0</td>
                                <td><?php echo get_run_server();?></td>
                                <td><div class="right"></div></td>
                            </tr>
                            <tr>
                                <td>PHP 版本</td>
                                <td class="hidden-phone">>=5.4</td>
                                <td>5.6</td>
                                <td><?php echo PHP_VERSION; ?></td>
                                <td><div class="right"></div></td>
                            </tr>
                            <tr>
                                <td>GD库</td>
                                <td class="hidden-phone">支持</td>
                                <td>支持</td>
                                <td><?php echo function_exists('imagecreatetruecolor') ? '支持' : '不支持' ?></td>
                                <td>
                                    <?php echo function_exists('imagecreatetruecolor') ? '<div class="right"></div>' : '<div class="error"></div>' ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="stepbtn">
                <input type="submit" value="继续安装" class="btn btn-info btn-shadow btn-step pull-right">
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


</body>
</html>