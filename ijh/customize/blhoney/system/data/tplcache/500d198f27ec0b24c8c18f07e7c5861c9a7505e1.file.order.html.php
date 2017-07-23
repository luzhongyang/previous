<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 17:59:16
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/order/order.html" */ ?>
<?php /*%%SmartyHeaderCode:199820662157b2f6775baa73-99291982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '500d198f27ec0b24c8c18f07e7c5861c9a7505e1' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/order/order.html',
      1 => 1471687155,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199820662157b2f6775baa73-99291982',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b2f6776645f9_98146260',
  'variables' => 
  array (
    'detail' => 0,
    'products' => 0,
    'product_list' => 0,
    'item' => 0,
    'hongbao' => 0,
    'yh_price' => 0,
    'total_price' => 0,
    'mymoney' => 0,
    'total_youhui' => 0,
    'week' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b2f6776645f9_98146260')) {function content_57b2f6776645f9_98146260($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
    <head>
        <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

    </head>

    <body>
        <header>
            <i class="left"><a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','args'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
" class="gobackIco"></a><a href="<?php echo smarty_function_link(array('ctl'=>'shop/detail','args'=>$_smarty_tpl->tpl_vars['detail']->value['shop_id']),$_smarty_tpl);?>
" class=""></a></i>
            <div class="title">
                提交订单
            </div>
            <i class="right"><a class="" href="#"></a></i>
        </header>
        <form id="form_post" method="post">
            <input type="hidden" name="params[products]" value="<?php echo $_smarty_tpl->tpl_vars['products']->value;?>
"/>
            <input type="hidden" name="params[shop_id]" value="<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
"/>
            <input type="hidden" name="params[online_pay]" value="1"/>
            <section class="page_center_box">
                <div class="order_details_nr">
                    <ul class="form_list_box form_list_box_specil">
                        <li class="list waimaiTime set_time" style="border-bottom: 0.01rem solid #dedede; margin-bottom: 0.1rem;margin-top:0.1rem;line-height:0.5rem;">
                            <div class="fl"><p class="black6" style="color:#333;">选择预约时间</p></div>
                                <input type="hidden" name="params[ordered_time]" id="select_time" value="" />
                                <span style="margin-left:1rem;color:#901872;width:2rem;" id="service_time" week="" hour="">
                                    
                                </span>
                            
                            <div class="fr set_time">
                                <p class="black6" style="color:#333;">
                                    <span></span>
                                    <em class="linkIco"></em>
                                </p>
                            </div>
                        </li>
                        
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <li class="list" style="line-height:0.6rem;border-bottom: 0.01rem solid #dedede;">
                            <div class="fl"><p class="black6" style="color:#333;"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</p></div>
                            <div class="fr"><p class="black9" style="color:#901872;">￥<?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
&nbsp;&nbsp;<font color="#999">起</font></p></div>
                        </li>
                        <?php } ?>

                        <?php if ($_smarty_tpl->tpl_vars['hongbao']->value){?>
                        <a href="<?php echo smarty_function_link(array('ctl'=>'ucenter/hongbao/lists','money'=>$_smarty_tpl->tpl_vars['yh_price']->value),$_smarty_tpl);?>
">
                            <li class="list" id="hongbao" style="border-top: 0.01rem solid #dedede; margin-top:0.1rem;line-height: 0.5rem;">
                                <input type="hidden" name="params[hongbao_id]" id="hongbao_id" value="<?php echo $_smarty_tpl->tpl_vars['hongbao']->value['hongbao_id'];?>
"/>
                                <div class="fl"><p class="pointcl1" style="color:#333;">在线支付红包抵扣</p></div>
                                <div class="fr"><p class="pointcl1 " style="color:#333;">-￥<span class="hongbao_amount"><?php echo $_smarty_tpl->tpl_vars['hongbao']->value['amount'];?>
</span></p></div>
                            </li>
                        </a>
                        <?php }else{ ?>
                        <li class="list" id="hongbao" style="border-top: 0.01rem solid #dedede; margin-top:0.1rem;line-height: 0.5rem;">
                            <div class="fl"><p class="pointcl1" style="color:#333;">在线支付红包抵扣</p></div>
                            <div class="fr"><p class="pointcl1" style="color:#333;">暂无可用红包</p></div>
                        </li>
                        <?php }?>
                        <li class="list " style="line-height: 0.5rem;">
                            <div class="fl"></div>
                            <div class="fr"><p class="pointcl1 total" style="color:#333;">合计&nbsp;&nbsp;<span class="jq_total" style="color:#901872;"><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
元</span></p></div>
                        </li>
                        <li class="list last" id="use_money">
                            <span class="radioInt" style="float:left;margin-top:5px;"><input type="checkbox"></span>
                            <div class="wz" style="float:left;margin-top:5px;">
                                <h3>&nbsp;是否使用余额快捷支付</h3>
                            </div></br>
                             <p class="" style="line-height:0.2rem;clear:both;margin-top:10px;">余额信息&nbsp;&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['mymoney']->value>0){?><font size="2" color="#ff2121">我的余额&nbsp;<?php echo $_smarty_tpl->tpl_vars['mymoney']->value;?>
&nbsp;可抵扣&nbsp;<?php if ($_smarty_tpl->tpl_vars['mymoney']->value<=$_smarty_tpl->tpl_vars['total_price']->value){?><?php echo $_smarty_tpl->tpl_vars['mymoney']->value;?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['mymoney']->value>$_smarty_tpl->tpl_vars['total_price']->value){?><?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
.00<?php }?></font><?php }?></p>
                            <div class="figure_password">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="70">支付密码</td>
                                        <td><span><input type="password" name="params[passwd]" id="figure_password_int" class="password_int" placeholder="请输入密码" value=""></span></td>
                                        <!-- <td width="40"><label style="margin-top:0.12rem;" class="tab_int" id='tb2'></label></td> -->
                                    </tr>
                                </table>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </form>
        <footer>
            <div class="ord_tousu">
                <p class="fl" style="margin-top:0.12rem;">支付:<span class="pointcl1" style="color:#901872;"><span class="jq_total">&nbsp;&nbsp;<?php echo $_smarty_tpl->tpl_vars['total_price']->value;?>
元</span></span>&nbsp;&nbsp;<span id="is_youhui" class="black9">已优惠￥<span class="jq_youhui"></span></span></p>
                <a href="javascript:create_order();" class="fr pub_btn">提交</a></div>
        </footer>
       
        <script>
            $(document).ready(function () {
                $('.jq_youhui').text(parseFloat("<?php echo $_smarty_tpl->tpl_vars['total_youhui']->value;?>
").toFixed(2));
            });
            $('.figure_password').hide();

            $(document).off('click','.radioInt').on('click','.radioInt',function(){
                if($(this).hasClass("on")){
                    $(this).removeClass("on");
                    $('.figure_password').hide();
                } else{
                    $(this).addClass("on");
                    $('.figure_password').show();
                }
            })
            var week_array = []; 
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['week']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>week_array.push({"d":"<?php echo $_smarty_tpl->tpl_vars['v']->value['d'];?>
","w":"<?php echo $_smarty_tpl->tpl_vars['v']->value['w'];?>
"});<?php } ?>

            $('.set_time').click(function(){
                select_yuyue_time(week_array);
                //dateScroll(this);
            })

            function dateScroll(obj) {
                var date = new Date();
                var curr = new Date().getFullYear(),
                d = date.getDate(),
                m = date.getMonth();

                // datetime
                /*$(obj).mobiscroll().datetime({
                    preset: 'datetime',            //日期类型--datatime --time,
                    theme: "android-ics light",    //皮肤其他参数
                    mode: "scroller",
                    lang: 'zh',
                    display: "bottom",
                    animate: "slideup",
                    rows: 5,
                    setText: '确定',                //确认按钮名称
                    cancelText: '取消',             //取消按钮名籍我
                    stepMinute: 15,
                    dateFormat: 'yyyy年mm月dd日',  // 日期格式
                    dateOrder: 'mmddDD',             //面板中日期排列格
                    dayNames: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
                    dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    timeFormat: 'HH:ii',
                    timeWheels: 'HH-ii',
                    yearText: '年',
                    monthText: '月',
                    dayText: '日',
                    hourText: '时',
                    minuteText: '分',
                    secText: '秒',
                    startYear: (new Date()).getFullYear(), //开始年份
                    endYear: (new Date()).getFullYear() + 9, //结束年份
                });*/

                //  datehour 
                $(obj).scroller('destroy').scroller({
                    preset: 'datehour',
                    minDate: new Date(curr, m, d, 8, 00),
                    maxDate: new Date(curr, m, d + 7),
                    invalid: [{d: new Date(), start: '00:00', end: (date.getHours()) + ':' + date.getMinutes()}],
                    theme: "android-ics light",
                    mode: "scroller",
                    lang: 'zh',
                    display: "bottom",
                    animate: "slideup",
                    stepMinute: 15,
                    dateOrder: 'MMDdd',
                    timeWheels: 'HH-ii',
                    setText:'确定',
                    cancelText:'取消',
                    rows: 3
                })    
            }

            function create_order() {
                localStorage['order_pay'] = "<?php echo smarty_function_link(array('ctl'=>'ucenter/order:items'),$_smarty_tpl);?>
";
                var url = "<?php echo smarty_function_link(array('ctl'=>'order:create'),$_smarty_tpl);?>
";
                $.post(url, $("#form_post").serialize(), function (ret) {
                    if (ret.error > 0) {
                        layer.open({content: ret.message, time: 2});
                        if (ret.error >= 221 && ret.error < 224) {
                            setTimeout(function () {
                                window.location.href = "<?php echo smarty_function_link(array('ctl'=>'index/index'),$_smarty_tpl);?>
";
                            }, 1000);
                        }
                        if(ret.error == 101) {
                            setTimeout(function () {
                                window.location.href = "<?php echo smarty_function_link(array('ctl'=>'passport:login'),$_smarty_tpl);?>
";
                            }, 1000);
                        }
                    } else {
                        layer.open({content: ret.message});
                        var order_id = ret.order_id;
                        var pay_status = ret.pay_status;  
                        var link_pay = "<?php echo smarty_function_link(array('ctl'=>'order/pay','args'=>'oooo'),$_smarty_tpl);?>
";
                        var link_item = "<?php echo smarty_function_link(array('ctl'=>'ucenter/order:items','args'=>'oooo'),$_smarty_tpl);?>
";
                        window.beauty.removeby("<?php echo $_smarty_tpl->tpl_vars['detail']->value['shop_id'];?>
");
                        setTimeout(function () {
                            if(pay_status == 1){
                                window.location.href = link_item.replace('oooo', order_id);
                            }else{
                                window.location.href = link_pay.replace('oooo', order_id);
                            }
                        }, 1000);
                    }
                }, 'json');
            }

        </script>
    </body>
</html><?php }} ?>