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

                        
    <fieldset class="step" id="default-step-3" >
        <div class="steping">
            <div class="stepprocess" id="stepprocess" style="height:280px; overflow:auto;">
                <ul id="installmsg">
                    <li>初始化中...</li>
                </ul>
            </div>
        </div>
    </fieldset>


                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>


    <script src="http://cdn.bootcss.com/jquery/1.12.4/jquery.js"></script>
    <script>
        var start = 1;
        var url = '<?php echo U('index/index', array('step' => 4));?>';
        $(function() {
            setTimeout(function () {
                /** 步骤一 */
                $.post(url, {start: 1}, function (data) {
                    append(data.info);
                    if (data.status == 1) {
                        /** 步骤二 */
                        $.post(url, {start: 2}, function (data) {
                            append(data.info);
                            if (data.status == 1) {
                                /** 步骤三 */
                                $.post(url, {start: 3}, function (data) {
                                    append(data.info);
                                    if (data.status == 1) {
                                        /** 步骤四 */
                                        $.post(url, {start: 4}, function (data) {
                                            append('安装完成,正在跳转...');
                                            setTimeout(function () {
                                                location.href = data.info;
                                            }, 1500);
                                        }, 'json');
                                    }
                                }, 'json');
                            }
                        }, 'json');
                    }
                }, 'json');
            }, 2000);
        });
        /** append */
        function append(text)
        {
            document.getElementById('stepprocess').scrollTop = document.getElementById('stepprocess').scrollHeight;
            $('#installmsg').append("<li>"+ text +"</li>");
        }
    </script>

</body>
</html>