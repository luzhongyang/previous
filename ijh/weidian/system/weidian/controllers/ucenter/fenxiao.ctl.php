<?php

/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Fenxiao extends Ctl_Ucenter
{
   
    public function index(){
        if($fenxiao = K::M('fenxiao/fenxiao')->find(array('uid'=>$this->uid,'shop_id'=>WEIDIAN_SHOP_ID))){
            //$url = K::M('fenxiao/fenxiao')->get_url($fenxiao['sid']).'/ucenter/shop/index';
            $url = K::M('fenxiao/fenxiao')->get_url($fenxiao['sid']).'/ucenter/shop/manage/index';
            $url = str_replace(__CFG::C_DOMAIN, '.weidian'.__CFG::C_DOMAIN, $url);
//            print_r($url);die;
            header("Location:".$url);
        }else{
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

            $this->pagedata['weixinqr'] = $config['weixinqr'];
            $this->pagedata['is_guanzhu'] = $is_guanzhu;
            $this->tmpl = 'weidian/ucenter/fenxiao/index.html';
        }

    }

    

    public function tuike()
    {
        $this->tmpl = 'fenxiao/ucenter/shop/tuike.html';
    }

    /**
     * 申请加入推客
     */
    public function register(){
        if(IS_AJAX){
            $fenxiao = K::M('fenxiao/fenxiao')->find(array('shop_id'=>WEIDIAN_SHOP_ID,'uid'=>$this->uid));
            if($fenxiao){
                $this->msgbox->add('您已经是该店铺的推客了！',211);
            }else{
                //分销主表数据
                $data = array(
                    'p_sid'=>0,
                    'shop_id'=>WEIDIAN_SHOP_ID,
                    'uid'=>$this->uid,
                    'shop_name'=>$this->weidian['title'],
                    'title'=>$this->MEMBER['nickname']."的小店",
                    'photo'=>$this->MEMBER['face']
                );

                if($fenxiao = K::M('fenxiao/fenxiao')->create($data)){
                    $data2 = array(
                        'sid'  => $fenxiao,
                        'invite1' => $this->uid,
                        'invite2' => 0,
                        'invite3' => 0,
                    );
                    K::M('fenxiao/member')->create($data2);
                    $this->msgbox->add('申请推客成功！');
                    $url = K::M('fenxiao/fenxiao')->get_url($fenxiao).'/ucenter/shop/manage/index';
                    $this->msgbox->set_data("forward",$url);
                }else{
                    $this->msgbox->add('申请失败！',212);
                }
            }
        }
    }     
}