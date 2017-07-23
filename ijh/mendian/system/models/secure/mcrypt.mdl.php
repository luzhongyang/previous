<?php
/**
 * Copy Right Anhuike.com
 * $Id crypt.mdl.php shzhrui<anhuike@gmail.com>
 */
class Mdl_Secure_Mcrypt
{


    /**
     * 算法,另外还有192和256两种长度
     */
    const CIPHER = MCRYPT_RIJNDAEL_128;
    /**
     * 模式
     */
    const MODE = MCRYPT_MODE_ECB;

    /**
     * 加密
     * @param string $key   密钥
     * @param string $str   需加密的字符串
     * @return type
     */
    static public function encode($str, $key='', $code='base64')
    {
        $key = empty($key) ? PRI_KEY : $key;
        $str = self::_pkcs5Pad($str);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER,self::MODE),MCRYPT_RAND);
        if($endata = mcrypt_encrypt(self::CIPHER, $key, $str, self::MODE, $iv)){
            switch ($code){
                case 'base64':
                    $endata = base64_encode($endata);
                    break;
                case 'hex':
                    $endata = bin2hex($endata);
                    break;
                case 'bin':
                default:
                    $endata = $endata;
            }
        }
        return $endata;
    }

    /**
     * 解密
     * @param type $key
     * @param type $str
     * @return type
     */
    static public function decode($str, $key='', $code='base64')
    {
        $ret = false;
        switch ($code){
            case 'base64':
                $str = base64_decode($str);
                break;
            case 'hex':
                $str = self::_hex2bin($str);
                break;
            case 'bin':
            default:
        }
        if($str !== false){
            $key = empty($key) ? PRI_KEY : $key;
            $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER,self::MODE),MCRYPT_RAND);
            $ret = mcrypt_decrypt(self::CIPHER, $key, $str, self::MODE, $iv);
            $ret = self::_pkcs5Unpad($ret);
            $ret = trim($ret);
        }
        return $ret;

    }

    static private function _pkcs5Pad($text)
    {
        $blocksize = mcrypt_get_block_size(self::CIPHER,self::MODE);
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    static private function _pkcs5Unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        $ret = substr($text, 0, -1 * $pad);
        return $ret;
    }

    static private function _hex2bin($hex = false)
    {
        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
        return $ret;
    }
}