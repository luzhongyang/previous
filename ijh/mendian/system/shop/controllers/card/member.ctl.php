<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2016-01-14 01:25:14Z youyi $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Card_Member extends Ctl_Card
{

    public function index()
    {
        $level = K::M('card/grade')->items_by_shop_id(SHOP_ID);
        $guid=$this->card['grade_id'];
        $user_level = 0;
        foreach ($level as $v){
            if($v['grade_id'] == $guid){
                $user_level=$v['level'];
            }
        }
        $this->pagedata['level'] = $user_level;
        $filter = array(
            'card_id'=>$this->card['card_id'],
            'dateline'=> '>:'.$this->system->sdaytime
        );
        $this->pagedata['today_is_sign'] = K::M('card/sign')->count($filter);
        $this->tmpl = 'shop/card/member/index.html';
    }

    
    public function tq()
    {
        $this->pagedata['detail'] = $this->shop;
        $this->tmpl = 'shop/card/member/tq.html';
    }

    
    public function explain()
    {
        $this->pagedata['detail'] = $this->shop;
        $this->tmpl = 'shop/card/member/explain.html';
    }


    
}
