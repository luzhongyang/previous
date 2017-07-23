<?php /* Smarty version Smarty-3.1.8, created on 2016-11-22 14:16:25
         compiled from "merchant:index.html" */ ?>
<?php /*%%SmartyHeaderCode:36415833e2b959cc12-92102316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f35a9078cddec7eebcf746fa892dee74190f5eec' => 
    array (
      0 => 'merchant:index.html',
      1 => 1478943458,
      2 => 'merchant',
    ),
  ),
  'nocache_hash' => '36415833e2b959cc12-92102316',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'todaymoney' => 0,
    'today_order' => 0,
    'shopcomtnum' => 0,
    'fans' => 0,
    'wait_accept' => 0,
    'wait_peisong' => 0,
    'is_peiing' => 0,
    'orderall' => 0,
    'cansle' => 0,
    'ziti' => 0,
    'unshopcom' => 0,
    'item' => 0,
    'dianusers' => 0,
    'unwaicom' => 0,
    'waiusers' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5833e2b968c076_29854129',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5833e2b968c076_29854129')) {function content_5833e2b968c076_29854129($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_modifier_format')) include 'D:\\phpStudy\\WWW\\shequ\\system\\plugins/smarty\\modifier.format.php';
?><?php echo $_smarty_tpl->getSubTemplate ("merchant:block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<!--内容开始-->
<div class="row">
    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">订单</span>
                <h5>今日总收入</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['todaymoney']->value;?>
</h1>
                <div class="stat-percent font-bold text-success">元</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">订单</span>
                <h5>今日总销量</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['today_order']->value;?>
</h1>
                <div class="stat-percent font-bold text-success">个</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">总数</span>
                <h5>收到点评</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['shopcomtnum']->value;?>
</h1>
                <div class="stat-percent font-bold text-success">条</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="label label-success pull-right">总数</span>
                <h5>我的粉丝</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins"><?php echo $_smarty_tpl->tpl_vars['fans']->value;?>
</h1>
                <div class="stat-percent font-bold text-success">个</div>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-bell fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 待接单数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['wait_accept']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-send-o fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 待配送数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['wait_peisong']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-space-shuttle fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 配送中数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['is_peiing']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-rmb fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 已完成数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['orderall']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-reply fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 已取消数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['cansle']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="widget style1 lazur-bg">
            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-user fa-3x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> 自提单数 </span>
                    <h2 class="font-bold"><?php echo $_smarty_tpl->tpl_vars['ziti']->value;?>
</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-3 m-b-md">
        <div class="idx_enter">
            <div class="ibox-title">
                <h5>快捷入口</h5>
            </div>
            <div class="ibox-content">
                <a class="btn btn-block btn-outline btn-primary" href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/money'),$_smarty_tpl);?>
">
                    资金管理
                </a>
                <a class="btn btn-block btn-outline btn-primary"  href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/coupon'),$_smarty_tpl);?>
">
                    优惠券管理
                </a>
                <a class="btn btn-block btn-outline btn-primary" href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/order'),$_smarty_tpl);?>
">
                    订单管理
                </a>
                <a class="btn btn-block btn-outline btn-primary" href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/comment'),$_smarty_tpl);?>
">
                    评价管理
                </a>
                <a class="btn btn-block btn-outline btn-primary" href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/member'),$_smarty_tpl);?>
">
                    客户管理
                </a>
                <a class="btn btn-block btn-outline btn-primary" href="<?php echo smarty_function_link(array('ctl'=>'merchant/weidian/info'),$_smarty_tpl);?>
">
                    微店设置
                </a>

            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 店铺未回复的评论</a>
                </li>
                <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">外送未回复的评论</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th>评价ID</th>
                                <th>客户</th>
                                <th>订单号</th>
                                <th >综合评分</th>
                                <th>状态</th>
                                <th>评价时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['unshopcom']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <tr>
                                <td><!-- <input type="checkbox"  checked class="i-checks" name="input[]"><span class="m-l"> --><?php echo $_smarty_tpl->tpl_vars['item']->value['comment_id'];?>
</span></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['dianusers']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</td>
                                 <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score'];?>
</td>
                                <td>未回复</td>
                                <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
                                <td>
                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/comment/reply_dialog','args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id']),$_smarty_tpl);?>
" mini-load="店铺评论回复" mini-width="500" mini-height="300"><button type="button" class="btn btn-outline btn-primary btn-sm">回复评论</button>
                                    </a>
                                    <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/shop/comment/detail','args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id']),$_smarty_tpl);?>
">
                                        <button type="button" class="btn btn-outline btn-info btn-sm">详情</button>
                                    </a>
                                </td>
                            </tr>
                            <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                                <tr><td colspan="20"><div class="alert alert-info">暂无数据</div></td></tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <table class="table table-striped">
                        <thead>
                        <tr>

                            <th>评价ID</th>
                            <th>客户</th>
                            <th>订单号</th>
                            <th >综合评分</th>
                            <th >服务评分</th>
                            <th >口味评分</th>
                            <th>状态</th>
                            <th>评价时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['unwaicom']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <tr>
                            <td><!-- <input type="checkbox"  checked class="i-checks" name="input[]"><span class="m-l"> --><?php echo $_smarty_tpl->tpl_vars['item']->value['comment_id'];?>
</span></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['waiusers']->value[$_smarty_tpl->tpl_vars['item']->value['uid']]['nickname'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_id'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score_fuwu'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['score_kouwei'];?>
</td>
                            <td>未回复</td>
                            <td><?php echo smarty_modifier_format($_smarty_tpl->tpl_vars['item']->value['dateline']);?>
</td>
                            <td>
                                <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/comment/reply_dialog','args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id']),$_smarty_tpl);?>
" mini-load="外卖评论回复" mini-width="500" mini-height="300"><button type="button" class="btn btn-outline btn-primary btn-sm">回复评论</button>
                                </a>
                                <a href="<?php echo smarty_function_link(array('ctl'=>'merchant/waimai/comment/detail','args'=>$_smarty_tpl->tpl_vars['item']->value['comment_id']),$_smarty_tpl);?>
">
                                    <button type="button" class="btn btn-outline btn-info btn-sm">详情</button>
                                </a>
                            </td>
                        </tr>
                        <?php }
if (!$_smarty_tpl->tpl_vars['item']->_loop) {
?>
                            <tr><td colspan="20"><div class="alert alert-info">暂无数据</div></td></tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>

            </div>


        </div>

    </div>
</div>
<!--内容结束-->
<?php echo $_smarty_tpl->getSubTemplate ("merchant:block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<script>
function location_addr(address) {
    if(address) {
        window.location.href = address;
    }
}
</script>

<?php }} ?>