<?php /* Smarty version Smarty-3.1.8, created on 2016-08-20 09:41:10
         compiled from "/data/htdocs/blhoney_com/public_html/themes/default/ucenter/mall/orderitems.html" */ ?>
<?php /*%%SmartyHeaderCode:148542268157b7b5369c9c06-91321997%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec4ed0cd2c4b15bed929251bb50949410517e63b' => 
    array (
      0 => '/data/htdocs/blhoney_com/public_html/themes/default/ucenter/mall/orderitems.html',
      1 => 1470380642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148542268157b7b5369c9c06-91321997',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57b7b536a05c32_67407674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b7b536a05c32_67407674')) {function content_57b7b536a05c32_67407674($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include '/data/htdocs/blhoney_com/public_html/system/plugins/smarty/function.link.php';
?><!DOCTYPE HTML>
<html>
<head>
    <?php echo $_smarty_tpl->getSubTemplate ("block/sheader.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>

<body>
<header>
	<i class="left"><a href="" class="gobackIco"></a></i>
    <div class="title">
    	商城订单
    </div>
    <i class="right"><a class="" href="#"></a></i>
</header>
<style type="text/css">
.tuan_no{ margin:0.3rem 0; text-align:center; line-height:0.3rem;}
.tuan_no h2{ font-weight:normal; font-size:0.18rem;}
.tuan_no .iconBg{width:0.8rem; height:0.8rem; margin:0.1rem 0; background:#F7F7F7; border:0.02rem solid #F7F7F7; display:inline-block; border-radius:0.8rem; text-align:center;}
</style>
<section class="page_center_box" id="wrapper">
   <ul></ul>
</section>
</body>
</html>

<script id="tmpl_goods_item" type="text/x-jquery-tmpl">
<div class="daizhifu mt10">
    <div class="daizhifu-cont">
        <div class="daizhifu-tit pad_l10">
        {{if order_status==0 && pay_status==0}}
            订单待支付
        {{else order_status==0 && pay_status==1}}
            订单已支付
        {{else order_status==5 && pay_status==1}}
            订单已发货
        {{else order_status==-1}}
            订单已取消
        {{else order_status==8}}
            订单已完成
        {{/if}}
            <span class="black9 font_size14">-${dateline}</span></div>
        <ul>
            {{each(key,val) products}}
            <li class="daizhifu-list pad_l10 pad_r10 pad_b10">
                <div class="fl tupian" style="width:0.6rem;height:0.6rem;"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/${val.photo}"/></div>
                <div class="wenzi ">
                    <a href="javascript:void(0);" class="font_size14">${val.product_name}</a>
                    <div class="font_size14 ">
                        <div class="fl">
                            <span>${val.product_price}元</span>
                            <span class="jifen">${val.product_jifen}<span class="black9">积分</span></span>
                        </div>
                        <div class="fr">x${val.product_number}</div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </li>
           {{/each}}
        </ul>
        <div class="pad_l10 chulidingdan pad_r10">
            <div class="chuli-list ">
                {{if pay_status==0 && order_status==0}}
                <a href="javascript:set(${order_id},'chargeback');" class="btn">取消订单</a>
                {{/if}}
                <a href="javascript:set(${order_id},'detail');" class="btn">查看订单</a>
                {{if order_status==0 && pay_status==0}}
                <a href="javascript:set(${order_id},'pay');" class="btn buton">支付订单</a>
                {{/if}}
                {{if order_status==5 && pay_status==1}}
                <a href="javascript:set(${order_id},'receive');" class="btn buton">确认收货</a>
                {{/if}}
             </div>
        </div>
    
    </div>
</div>
</script>

<script>
$(document).ready(function () {
    LoadData.params['page'] = 1;
    loadPageItems();

});


if(localStorage['ucenter_mall_orderitems']) {
    $('.gobackIco').attr('href', localStorage['ucenter_mall_orderitems']);
}

function loadPageItems(params) {
    if (LoadData.LOCK) {
        return false;
    }
    LoadData.LOCK = true;
    params = params || {};
    LoadData.params = $.extend(LoadData.params, params);
    Widget.MsgBox.load("加载中...");
    var link =
    $.post("<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:loaditems'),$_smarty_tpl);?>
", LoadData.params, function (ret) {
        if (ret.error) {
            Widget.MsgBox.error(ret.message);
        } else {
            console.log(ret.data.items);
            var length = getObjLen(ret.data.items);
            if ( length > 0) {
                if (parseInt(LoadData.params['page'], 10) < 2) {
                    $("#wrapper ul").html($('#tmpl_goods_item').tmpl(ret.data.items)); // 第一页全部显示
                } else {
                    $('#tmpl_goods_item').tmpl(ret.data.items).appendTo($("#wrapper ul")); // 第二页以及之后的加入wrapper
                }
            } else if (LoadData.params.page > 1) {
                if(! $(".loading_end").length) {
                    $('#wrapper ul').append('<div class="loading_end">没有更多了...</div>');
                }
                LoadData.LOAD_END = true;
            } else {
                //给一个没有数据的提示信息
                $("#wrapper ul").html('<div class="tuan_no"><div class="iconBg"><i class="ico8"></i> </div><h2>你暂无商城订单</h2></div>');
                LoadData.LOAD_END = true;
            }
        }
        LoadData.params.page++;
        Widget.MsgBox.hide();
        LoadData.LOCK = false;
    }, "json");
}

$(window).scroll(function () {//监听滚动条改变
    if ($(window).scrollTop() == $(document).height() - $(window).height()) { //滚动条到顶部的垂直高度 = 页面高度 - 可视高度
        loadPageItems();
    }
});

function set(order_id, type) {
    var link = null;
    if(type == 'pay') {
        link = "<?php echo smarty_function_link(array('ctl'=>'order:pay','arg0'=>'temp1','arg1'=>'temp2'),$_smarty_tpl);?>
";
        window.location.href = link.replace("temp1",order_id).replace('temp2', 'mall');
    }else if(type == 'detail'){
        link = "<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:detail','args'=>'temp'),$_smarty_tpl);?>
";
        window.location.href = link.replace('temp', order_id);
    }else {
        link = "<?php echo smarty_function_link(array('ctl'=>'ucenter/mall:"+type+"','args'=>'temp'),$_smarty_tpl);?>
";
        jQuery.ajax({        
            url: link.replace("temp",order_id), 
            async: true,  
            dataType: 'json',
            type: 'POST',   
            success: function (ret) { 
                if(ret.error > 0){
                    layer.open({content: ret.message,time: 2});
                }else{
                    layer.open({content: ret.message,time: 2});
                    setTimeout(function(){window.location.reload();},1000);
                }
            }, 
        });
    }
}
</script><?php }} ?>