<?php

$key = "R52QLJRHJ43445SDF";

function addnumberforbyte($char, $increment) {
    $temp = $char + $increment + 256;
    $temp = $temp % 256;
    return $temp;
}

function encrypt_win($str1) {
    global $key;
    $base = $key;
    $str = strrev($str1);
    $length = strlen($str);
    for ($i = 1; $i <= $length; $i++) {
        $char = dechex(addnumberforbyte(ord(substr($str, $i - 1, 1)), ord(substr($base, $i - 1, 1))));
        $temp.=(strlen($char) == 1 ? "0$char" : $char);
    }
    return $temp;
}

function decode_win($str1) {
    global $key;
    $base = $key;
    $str = $str1;
    $length = strlen($str) / 2;

    for ($i = 1; $i <= $length; $i++) {
        $temp.=chr(addnumberforbyte(hexdec(substr($str, ($i - 1) * 2, 2)), -(ord(substr($base, $i - 1, 1)))));
    }
    return strrev($temp);
}

function htmlencode($str) {
    return trim(htmlspecialchars($str));
}

function processtj($str, $dw) {
    $temp = explode(";", $str);
    if ($temp[0] == "") {
        if ($temp[1] == "") {
            return "不限";
        } else {
            return $temp[1] . $dw . "以下";
        }
    } else {
        if ($temp[1] == "") {
            return $temp[0] . $dw . "以上";
        } else {
            return $temp[0] . "到" . $temp[1] . $dw . "之间";
        }
    }
}

function CutStr($str, $length) {
//剪切字符串到一定长度，长度以所占字节为准
    $len = strlen($str);
    if ($len <= $length) {
        return $str;
    } else {
        $length = $length - 3;
        $CWordIsOver = 1;
        for ($i = 0; $i <= $len - 1; $i++) {
            $temp = substr($str, $i, 1);

            if (ord($temp) > 127) {
                $CWordIsOver = -$CWordIsOver;
            }

            if ($i + 1 == $length) {
                if ($CWordIsOver == -1) {
                    $length--;
                }
                break;
            }
        }
        return substr($str, 0, $length) . "...";
    }
}

function outjsmsg($msg) {
//输出javascript提示信息并返回	
    print("<html><body><script language=javascript>\n");
    print("<!--\n");
    print("alert('$msg');\n");
    print("history.back();\n");
    print("-->\n");
    print("</script></body></html>\n");
    return true;
}

function HtmlOut($str) {
//将文字转化为它的源代码格式
    $guest = $str;

    $guest = str_replace("  ", "　", $guest);
    $guest = str_replace(" ", "`nbsp;", $guest);

    $guest = htmlspecialchars($guest);
    $guest = str_replace("`nbsp;", " ", $guest);

    $guest = str_replace("\r\n", "<BR>", $guest);

    return($guest);
}

function LastNextPage($pagecount, $page, $table_style, $font_style) {
//生成上一页下一页链接
    $temp = "";
    global $QUERY_STRING, $HTTP_HOST, $SCRIPT_NAME;
    $action = "http://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";
    if (@$_SERVER['QUERY_STRING'] != "") {
        $QUERY_STRING = $_SERVER['QUERY_STRING'];
        $query = explode("&", $QUERY_STRING);
        while (list($index, $value) = each($query)) {
            $a = explode("=", $value);
            if (strcmp(strtolower($a[0]), "page") != 0) {            
                @$temp .= $a[0] . "=" . $a[1] . "&";
            }
        }
    } else {
        $temp = "";
    }

    print("<table " . $table_style . ">\n");
    print("<form method=get onsubmit=\"document.location ='" . $action . "?" . $temp . "page='+ this.page.value;return false;\"><tr>\n");
    print("<td align=right>\n");
    print($font_style . "\n");
    if ($page <= 1) {
        print ("[第一页] \n");
        print ("[上一页] \n");
    } else {
        print("[<a href=" . $action . "?" . $temp . "page=1>第一页</a>] \n");
        print("[<a href=" . $action . "?" . $temp . "page=" . ($page - 1) . ">上一页</a>]\n");
    }

    if ($page >= $pagecount) {
        print ("[下一页] \n");
        print ("[最后一页]\n");
    } else {
        print("[<a href=" . $action . "?" . $temp . "page=" . ($page + 1) . ">下一页</a>] \n");
        print("[<a href=" . $action . "?" . $temp . "page=" . $pagecount . ">最后一页</a>]\n");
    }

    print(" 第" . "<input tyep=text name=page maxlength=5 size=2 value=" . $page . ">" . "页\n<input class=button type=submit style=\"font-size: 7pt\" value=GO>\n");
    print(" 共 " . $pagecount . " 页\n");
    print("</td>\n");
    print("</tr></form>\n");
    print("</table>\n");
}

function TurnPage($pagecount, $page, $table_style, $font_style) {
//生成上一页下一页链接


    global $QUERY_STRING, $HTTP_HOST, $SCRIPT_NAME;
    $action = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if ($_SERVER[QUERY_STRING] != "") {
        $QUERY_STRING = $_SERVER[QUERY_STRING];
        $query = explode("&", $QUERY_STRING);
        while (list($index, $value) = each($query)) {
            $a = explode("=", $value);
            if (strcmp(strtolower($a[0]), "page") != 0) {
                $temp .= $a[0] . "=" . $a[1] . "&";
            }
        }
    } else {
        $temp = "";
    }

    print("<table " . $table_style . ">\n");
    print("<form method=get onsubmit=\"document.location ='" . $action . "&" . $temp . "page='+ this.page.value;return false;\"><tr>\n");
    print("<td align=right>\n");
    print($font_style . "\n");

    if ($page <= 1) {
        print ("[第一页] \n");
        print ("[上一页] \n");
    } else {
        print("[<a href=" . $action . "&" . $temp . "page=1>第一页</a>] \n");
        print("[<a href=" . $action . "&" . $temp . "page=" . ($page - 1) . ">上一页</a>]\n");
    }

    if ($page >= $pagecount) {
        print ("[下一页] \n");
        print ("[最后一页]\n");
    } else {
        print("[<a href=" . $action . "&" . $temp . "page=" . ($page + 1) . ">下一页</a>] \n");
        print("[<a href=" . $action . "&" . $temp . "page=" . $pagecount . ">最后一页</a>]\n");
    }

    print(" 第" . "<input class=button tyep=text name=page maxlength=5 size=2 value=" . $page . ">" . "页\n<input class=button type=submit style=\"font-size: 7pt\" value=GO>\n");
    print(" 共 " . $pagecount . " 页\n");
    print("</td>\n");
    print("</tr></form>\n");
    print("</table>\n");
}

function formatDT($dt, $style) {
    /* 	
      style=0 2000-10-10 下午 12:17:45
      style=1 2000-10-10 23:17:45
      style=2 2000-10-10 23:45
      style=3 00-10-10 23:45
      style=4 10-10 23:45
      style=5 2000-10-10
      style=6 00-10-10
      style=7 10-10
     */
    $style_str = array(
        "Y-m-d A h:i:s",
        "Y-m-d H:i:s",
        "Y-m-d H:i",
        "y-m-d H:i",
        "m-d H:i",
        "Y-m-d",
        "y-m-d",
        "h:i");

    $temp = date($style_str[$style], $dt);
    $temp = ($style == 0 ? str_replace("AM", "上午", str_replace("PM", "下午", $temp)) : $temp);
    return($temp);
}

function outcheck($check_value) {
    if ($check_value != "") {
        outjsmsg(str_replace("\n", "\\n", $check_value));
        exit();
    }
}

function checkvalue($str, $low, $up, $mode, $lable) {
    /*
      Mode = 1 检测是否为空   2是否是数字  4是否整数
      8是否是为数字、字母和_.-
      16 自定义字符检测
      32 长度检测
      64 数字大小检测
     */

    if ($str == "") {
        $lenght = 0;
        $str = "";
    } else {
        $length = strlen($str);
    }
    $temp = "";
    if ($mode % 2 >= 1) {
        if ($str == "") {
            $temp = $temp . "“" . $lable . "”" . "不能为空！" . "\n";
        }
    }

    if ($mode % 4 >= 2) {
        $base = " 0123456789.";
        for ($i = 0; $i <= $length - 1; $i++)
            if (strpos($base, substr($base, i, i + 1)) == 0) {
                $temp = $temp . "“" . $lable . "”" . "必需是数字！" . "\n";
                break;
            }
    }

    if ($mode % 8 >= 4) {
        $base = " 0123456789";
        for ($i = 0; $i <= $length - 1; $i++)
            if (strpos($base, substr($base, i, i + 1)) == 0) {
                $temp = $temp . "“" . $lable . "”" . "必需是整数！" . "\n";
                break;
            }
    }

    if ($mode % 16 >= 8) {
        $base = " abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz0123456789_-.";
        for ($i = 0; $i <= $length - 1; $i++)
            if (strpos($base, substr($base, i, i + 1)) == 0) {
                $temp = $temp . "“" . $lable . "”" . "包含非法字符！它只能是字母、数字和“- _ .”。" . "\n";
                break;
            }
    }

    if ($mode % 32 >= 16) {
        $base = str_replace($up, "[a-z]", "abcdefghijklmnopqrstuvwxyz");
        $base = str_replace($base, "[a-z]", "abcdefghijklmnopqrstuvwxyz");
        $base = str_replace($base, "[0-9]", "0123456789");
        $base = " " . $base;
        for ($i = 0; $i <= $length - 1; $i++)
            if (strpos($base, substr($base, i, i + 1)) == 0) {
                $temp = $temp . "“" . $lable . "”" . "包含非法字符！它只能是" . $up . "。" . "\n";
                break;
            }
    }

    if ($mode % 64 >= 32) {
        if (!($length >= $low && $length <= $up)) {
            $temp = $temp . "“" . $lable . "”" . "的长度必需在" . $low . "到" . $up . "之间！" . "\n";
        }
    }

    if ($mode % 128 >= 64) {
        if (!((int) ($str) >= (int) ($low) && (int) ($str) <= (int) ($up))) {
            $temp = $temp . "“" . $lable . "”" . "必需在" . $low . "到" . $up . "之间！" . "\n";
        }
    }

    return($temp);
}

function user_rank($vip) {
    $vip = $vip;
    $sql = "select * from user_rank where id=" . $vip;
    $row = mysql_fetch_array(mysql_query($sql));
    print $row["name"];
}

function sms($mobile, $msg) {
    $url = "http://221.130.185.108/smsmarketing/wwwroot/api/get_send/?uid=jiuxuan&pwd=123456&mobile=" . $mobile . "&msg=" . $msg . "&dtime=";
    $str = file($url);
    $count = count($str);
    for ($i = 0; $i < $count; $i++) {
        @$file .= $str[$i];
    }

    if ($file == '0发送成功!') {
        print "短信发送成功";
    } else {
        print "短信发送失败";
    }
}

?>
