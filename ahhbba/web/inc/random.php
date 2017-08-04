<?php

class activeCodeObj {

    function getCode($length = 32, $mode = 0) {
        switch ($mode) {
            case '1':
                $str = '1234567890';
                break;
            case '2':
                $str = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case '3':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case '4':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case '5':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                break;
            case '6':
                $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
                break;
            default:
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
                break;
        }

        $result = '';
        $l = strlen($str);

        for ($i = 0; $i < $length; $i ++) {
            $num = rand(0, $l);
            $result .= $str[$num];
        }
        return $result;
    }

}
?>
<!--
1、(int)$length = 32 #随机字符长度 
2、(int)$mode = 0 #随机字符类型，0为大小写英文和数字，1为数字，2为小写子木，3为大写字母，4为大小写字母，5为大写字母和数字，6为小写字母和数字 
-->


