//***JavaScript 表单域读写函数集*******//
//*******编写：牛云飞 *****************//

function outcheck(check_value) {
    if (check_value != "") {
        alert(check_value)
        return false;
    }
    return true;
}

function checkvalue(obj, low, up, mode, lable) {
    /*
     Mode = 1 检测是否为空   2是否是数字  4是否整数
     8是否是为数字、字母和_.-
     16 自定义字符检测
     32 长度检测
     64 数字大小检测
     */
    var temp, type;
    var length, i, base, str;

    str = getformvalue(obj);
    if (str == null) {
        lenght = 0;
        str = "";
    }
    else {
        length = str.length
    }
    temp = ""
    if (mode % 2 >= 1) {
        if (str == "") {
            temp = temp + "“" + lable + "”" + "不能为空！" + "\n";
        }
    }

    if (mode % 4 >= 2) {
        base = "0123456789."
        for (i = 0; i <= length - 1; i++)
            if (base.indexOf(str.substring(i, i + 1)) == -1) {
                temp = temp + "“" + lable + "”" + "必需是数字！" + "\n";
                break;
            }
    }

    if (mode % 8 >= 4) {
        base = "0123456789"
        for (i = 0; i <= length - 1; i++)
            if (base.indexOf(str.substring(i, i + 1)) == -1) {
                temp = temp + "“" + lable + "”" + "必需是整数！" + "\n";
                break;
            }
    }

    if (mode % 16 >= 8) {
        base = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz0123456789_-."
        for (i = 0; i <= length - 1; i++)
            if (base.indexOf(str.substring(i, i + 1)) == -1) {
                temp = temp + "“" + lable + "”" + "包含非法字符！它只能是字母、数字和“- _ .”。" + "\n";
                break;
            }
    }

    if (mode % 32 >= 16) {
        base = low.replace("[a-z]", "abcdefghijklmnopqrstuvwxyz")
        base = base.replace("[a-z]", "abcdefghijklmnopqrstuvwxyz")
        base = base.replace("[0-9]", "0123456789")
        for (i = 0; i <= length - 1; i++)
            if (base.indexOf(str.substring(i, i + 1)) == -1) {
                temp = temp + "“" + lable + "”" + "包含非法字符！它只能是" + up + "。" + "\n";
                break;
            }
    }

    if (mode % 64 >= 32) {
        if (!(length >= low && length <= up)) {
            temp = temp + "“" + lable + "”" + "的长度必需在" + low + "到" + up + "之间！" + "\n";
        }
    }

    if (mode % 128 >= 64) {
        if (!(parseInt(str) >= parseInt(low) && parseInt(str) <= parseInt(up))) {
            temp = temp + "“" + lable + "”" + "必需在" + low + "到" + up + "之间！" + "\n";
        }

    }
    if (temp != "") {
        alert(temp);
        type = (getformtype(obj));
        if (type != "radio" && type != "checkbox") {
            obj.focus();
        }
        return false;
    }
    return true;

}

function getformtype(obj) {
    var type;
    type = obj.type;
    if (typeof (type) == "undefined") {

        type = obj[0].type;
    }
    return type;
}
function getformvalue(input) {
//取表单域的值
    var type, temp;
    temp = "";

    type = getformtype(input);

    switch (type) {
        case "radio":	//单选框
            n = input.length - 1;

            if (isNaN(n) == true) {
                if (input.checked == true) {
                    temp = input.value;
                } else {
                    temp = "";
                }
            } else {
                for (i = 0; i <= n; i++) {
                    if (input[i].checked == true) {
                        return(input[i].value);
                    }
                }
                break;
            }
        case "checkbox":	//复选框
            n = input.length - 1;
            if (isNaN(n) == true) {
                if (input.checked == true) {
                    temp = input.value;
                } else {
                    temp = "";
                }
            } else {
                for (i = 0; i <= n; i++) {
                    if (input[i].checked == true) {
                        if (temp != "") {
                            temp += ",";
                        }
                        temp += input[i].value;

                    }
                }
            }
            return(temp);
            break;

        case "select-one" :	//单选列表框
            n = input.length - 1;
            for (i = 0; i <= n; i++) {
                if (input.options[i].selected == true) {
                    temp = input.options[i].value;
                    break;
                }
            }
            return(temp);
            break;
        case "select-multiple":	//多选列表框
            n = input.length - 1;
            for (i = 0; i <= n; i++) {
                if (input.options[i].selected == true) {
                    if (temp != "") {
                        temp += ",";
                    }
                    temp += input.options[i].value;
                }
            }
            return(temp);
            break;
        default:				//其它
            return(input.value);
            break;

    }

    return(input.value);

}

function ischecked(group, value) {
    var i, n;
    n = group.length - 1;
    for (i = 0; i <= n; i++) {
        if (value == group[i]) {
            return true;
        }
    }
    return false;
}


function SetSelectedAndChecked(input, value) {
//设置表单域的选择
    var type, temp, i, n;
    var split_value = new Array();
    temp = "";

    type = input.type;

    if (typeof (type) == "undefined") {
        type = input[0].type;
    }


    switch (type) {
        case "radio":	//单选框
            n = input.length - 1;

            if (isNaN(n) == true) {
                if (input.value = value) {
                    input.checked = true;
                } else {
                    input.checked = false;
                }
            } else {
                for (i = 0; i <= n; i++) {
                    if (input[i].value == value) {
                        input[i].checked = true;
                    } else {
                        input[i].checked = false;
                    }
                }
            }
            break;

        case "checkbox":	//复选框
            n = input.length - 1;
            split_value = value.split(",");
            if (isNaN(n) == true) {
                if (ischecked(split_value, input.value)) {
                    input.checked = true;
                } else {
                    input.checked = false;
                }
            } else {
                for (i = 0; i <= n; i++) {
                    if (ischecked(split_value, input[i].value)) {
                        input[i].checked = true;
                    } else {
                        input[i].checked = false;
                    }
                }

            }
            break;

        case "select-one" :	//单选列表框
            n = input.options.length - 1;
            for (i = 0; i <= n; i++) {
                if (input.options[i].value == value) {
                    input.options[i].selected = true;
                } else {
                    input.options[i].selected = false;
                }

            }
            break;
        case "select-multiple":	//多选列表框
            n = input.options.length - 1;
            split_value = value.split(",");
            for (i = 0; i <= n; i++) {
                if (ischecked(split_value, input.options[i].value)) {
                    input.options[i].selected = true;
                } else {
                    input.options[i].selected = false;
                }
            }
            break;
        default:				//其它
            return false;
            break;

    }

    return true;

}
