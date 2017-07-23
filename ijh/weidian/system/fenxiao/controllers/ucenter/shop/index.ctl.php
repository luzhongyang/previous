<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Shop_Index extends Ctl_Ucenter
{
   
    public function index(){
        if($this->FENXIAO['uid'] != $this->uid){
            $this->msgbox->add('非法操作分销店铺!',211)->response();
        }else if($this->FENXIAO['status'] == 0){ 
            $this->msgbox->add('该店铺正在审核中!',212);
        }else{
            $this->tmpl = 'fenxiao/ucenter/shop/index.html';
        }
    }

    

    public function tuike()
    {
        //查询关注状态
        $detail = K::M('member/member')->detail($this->uid);
        $is_guanzhu = 0;
        if($detail['wx_openid'] && $client = K::M('weixin/wechat')->admin_wechat_client()){
            $wx_info = $client->getUserInfoById($detail['wx_openid']);

            if( 1 == $wx_info['subscribe'] ){
                $is_guanzhu = 1;
            }
        }
        $config = K::M('system/config')->get('site');
        //查询是否已经加入该店推客
        $fenxiao = K::M('fenxiao/fenxiao')->find(array('shop_id'=>$this->FENXIAO['shop_id'],'uid'=>$this->uid));
        if($fenxiao){
            $this->pagedata['is_tuike'] = 1;
        }
        $this->pagedata['weixinqr'] = $config['weixinqr'];
        $this->pagedata['is_guanzhu'] = $is_guanzhu;
        $this->tmpl = 'fenxiao/ucenter/shop/tuike.html';
    }

    /**
     * 申请加入推客
     */
    public function register(){
        if(IS_AJAX){
            $fenxiao = K::M('fenxiao/fenxiao')->find(array('shop_id'=>$this->FENXIAO['shop_id'],'uid'=>$this->uid));
            if($fenxiao){
                $this->msgbox->add('您已经是该店铺的推客了！',211);
            }else{
                //分销主表数据
                $data = array(
                    'p_sid'=>$this->FENXIAO['sid'],
                    'shop_id'=>$this->FENXIAO['shop_id'],
                    'uid'=>$this->uid,
                    'shop_name'=>$this->FENXIAO['shop_name'],
                    'title'=>$this->MEMBER['nickname']."的小店",
                    'photo'=>$this->MEMBER['face']
                );

                if($fenxiao = K::M('fenxiao/fenxiao')->create($data)){
                    
                    //收集关系表数据
                    $mi_data = array(
                        'sid'=>$fenxiao, //分销店铺id
                        'invite1'=>$this->MEMBER['uid'],//当前用户id就是一级获得提成的id
                        'invite2'=>$this->FENXIAO['uid']              
                    );
                    //写入二级用户
                    
                    //根据p_sid判断是否有三级用户id
                    if($this->FENXIAO['p_sid']){
                        $fenxiao_level3 = K::M('fenxiao/fenxiao')->detail($this->FENXIAO['p_sid']);
                        $mi_data['invite3'] = $fenxiao_level3['uid'];
                    }

                    K::M('fenxiao/member')->create($mi_data);
                    $this->msgbox->add('申请推客成功！');
                    $this->msgbox->set_data("forward", $this->mklink('ucenter/shop/manage:index',null,null,'base'));
                }else{
                    $this->msgbox->add('申请失败！',212);
                }
            }
        }
    }     
}