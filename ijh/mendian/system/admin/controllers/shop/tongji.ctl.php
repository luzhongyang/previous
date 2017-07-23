<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/14
 * Time: 15:10
 */
class Ctl_Shop_Tongji extends Ctl {
    //所有商家的统计数据
    public function index(){
        //所有的订单统计
        $cashier = K::M('cashier/cashier');
        
        //今天金额
        $filter_day = $filter_week = $filter_mouth = array();
        
        //一周的金额

        //一个月的金额



    }
}