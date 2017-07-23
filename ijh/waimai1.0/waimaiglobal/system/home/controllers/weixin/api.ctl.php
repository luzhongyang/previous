<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

Import::C('weixin');
class Ctl_Weixin_Api extends Ctl_Weixin
{

    public function index()
    {
        
    }

    public function openapi()
    {
        $xmldata = file_get_contents('php://input');
        Import::L('weixin/crypt/wxBizMsgCrypt.php');
        // 第三方收到公众号平台发送的消息
        $msg = '';
        $AppId = 'wx88f6a87f61061596';
        $AppSecret = '0c79e1fa963cd80cc0be99b20a18faeb';
        $token = '9e5f1aa830ad215eff11eafd1015438b0f91a6f4';
        $key = '9e5f1aa8Ine4GoNe30ein5K0M82eff1aH6f4sDFe5L2';
        $pc = new wxBizMsgCrypt($token, $key, $AppId);
/*
    'signature' => '4dc32593e74eb3151a569807fe31823e303b2a52',
    'timestamp' => '1461660635',
    'nonce' => '1248046339',
    'encrypt_type' => 'aes',
    'msg_signature' => '423e16e46f8dd91d5a4feff21599d0b95b01c668',
    */
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $msg_sign = $_GET['msg_signature'];
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $xmldata, $msg);
        if ($errCode == 0) {
            print("解密后: " . $msg . "\n");
        } else {
            print($errCode . "\n");
        }
        K::M('system/logs')->log('wxopen.api.ticket', array($xmldata, $_POST, $_REQUEST, $msg));
        exit('SUCCESS');
    }

}