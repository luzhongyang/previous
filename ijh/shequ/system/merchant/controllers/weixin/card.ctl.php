<?php

/**

 * Copy Right IJH.CC

 * Each engineer has a duty to keep the code elegant

 * $Id$

 */
if (!defined('__CORE_DIR')) {
    exit("Access Denied");
}
Import::C('weixin/weixin');
class Ctl_Weixin_Card extends Ctl_Weixin {
    
    public function index($page = 1) {
        $client =K::M('weixin/wechat')->wechat_client();
        $cardlist = $client->getcardlist($weixin);
        //print_r($cardlist);die;
        $res = json_decode($cardlist, true);
        $arr1 = $card = array();
        if ($res['errcode'] == 0 && $res['total_num'] > 0) {
            foreach ($res['card_id_list'] as $k => $v) {
                $arr = array();
                $arr = json_decode($client->getcarddetail($weixin, $v), true);
                $arr1[] = $arr['card'];
            }
            foreach ($arr1 as $k => $v) {
                $card[$k] = $v[strtolower($v['card_type'])]['base_info'];
                $card[$k]['card_type'] = $v['card_type'];
                $card[$k]['iid'] = base64_encode($v[strtolower($v['card_type'])]['base_info']['id']);
            }
            $this->pagedata['card'] = $card;
            $this->pagedata['weixin'] = $weixin;
            $this->tmpl = 'merchant:weixin/card/index.html';
        } else {
            $this->msgbox->add('您没有卡劵,请先在微信中添加', 213);
        }
    }

    public function get_card($id) {
        $weixin = $this->ucenter_weixin();
        $client = $this->wechat_client();
        $id = base64_decode($id);
        $res = $client->get_card($weixin, $id);
        $cart = json_decode($res, true);
        $url = $client->getQrcodeImgUrlByTicket($cart['ticket']);
        $qrurl = $this->mklink('merchant/weixin/card:wxqrcode', array(), array('id' => $id));
        header("Location:{$qrurl}");
    }

    public function show() {
        $weixin = $this->ucenter_weixin();
        $site = K::M('system/config')->get('site');
        $url = $site['siteurl'] . '/' . K::M('helper/link')->mklink('weixin/voucher:index', array($weixin['wx_id']));
        $qrurl = $this->mklink('merchant/weixin/card:wxqrcode2', array(), array('codeurl' => $url));
        header("Location:{$qrurl}");
    }

    public function consume($id) {
        $weixin = $this->ucenter_weixin();
        if ($code = $this->GP('code')) {
            $client = $this->wechat_client();
            $id = base64_decode($id);
            $res = $client->get_code($weixin, $id, $code);
            $cart = json_decode($res, true);
            if ($cart['errcode'] == 0) {
                if ($cart['card']['begin_time'] < time() && $cart['card']['end_time'] > time() && $cart['can_consume'] === true) {
                    $res2 = $client->consume($weixin, $id, $code);
                    $res3 = json_decode($res2, true);
                    if ($res3['errcode'] == 0 || $res3['errmsg'] == 'ok') {
                        $this->msgbox->add('核销成功');
                    } else {
                        $this->msgbox->add('核销失败', 214);
                    }
                } else {
                    $this->msgbox->add('该卡劵已过期 或已被核销', 213);
                }
            } else {
                $this->msgbox->add('该卡劵不存在 请查证卡劵ID', 211);
            }
        } else {
            $this->pagedata['id'] = $id;
            $this->tmpl = 'merchant:weixin/card/form.html';
        }
    }

    public function delete_card($id) {

        $weixin = $this->ucenter_weixin();
        $client = $this->wechat_client();
        $id = base64_decode($id);
        $res = $client->delete_card($weixin, $id);
        $cart = json_decode($res, true);
        if ($cart['errcode'] == 0 || $cart['errmsg'] == 'ok') {
            $this->msgbox->add('删除成功');
        } else {
            $this->msgbox->add('删除失败', 214);
        }
    }

    public function wxqrcode2() {
        if (!$codeurl = $this->GP('codeurl')) {
            exit('params error');
        }
        $this->pagedata['codeurl'] = $codeurl;
        $this->tmpl = 'merchant:weixin/card/wxqrcode2.html';
    }

    public function wxqrcode() {
        if (!$id = $this->GP('id')) {
            exit('params error');
        }
        $weixin = $this->ucenter_weixin();
        $client = $this->wechat_client();
        $cardlist = $client->getcardlist($weixin);
        $detail = json_decode($client->getcarddetail($weixin, $id), true);
        $card = $detail['card'][strtolower($detail['card']['card_type'])]['base_info'];
        $card['card_type'] = $detail['card']['card_type'];
        $card['iid'] = base64_encode($detail['card'][strtolower($detail['card']['card_type'])]['base_info']['id']);
        $res = $client->get_card($weixin, $id);
        $cart = json_decode($res, true);
        $url = $client->getQrcodeImgUrlByTicket($cart['ticket']);
        $this->pagedata['id'] = $id;
        $this->pagedata['detail'] = $card;
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger') === true) {
            $this->pagedata['isling'] = 1;
        }
        $this->pagedata['codeurl'] = $url;
        $this->tmpl = 'merchant:weixin/card/wxqrcode.html';
    }

    protected function wechat_client() {

        static $client = null;
        if ($client === null) {
            if (!$client = K::M('weixin/weixin')->admin_wechat_client()) {
                exit('网站公众号设置错误');
            }
        }
        return $client;
    }

    protected function access_openid($force = false) {
        static $openid = null;
        if ($force || $openid === null) {
            if ($code = $this->GP('code')) {
                $client = $this->wechat_client();
                $ret = $client->getAccessTokenByCode($code);
                $openid = $ret['openid'];
            } else {
                if (!$openid = $this->cookie->get('wx_openid')) {
                    $client = $this->wechat_client();
                    $url = $this->request['url'] . '/' . $this->request['uri'];
                    $authurl = $client->getOAuthConnectUri($url, $state, 'snsapi_userinfo');
                    header('Location:' . $authurl);
                    exit();
                }
            }
            $this->cookie->set('wx_openid', $openid);
        }
        if (empty($openid)) {
            exit('获取授权失败');
        }
        return $openid;
    }

}
