/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id kK.js by @shzhrui<anhuike@gmail.com>
 */
window.KT = window.KT || {version: "1.0a"};
window.Widget = window.Widget || {};
(function(K, $){
K.$GUID = "KT";
//Global 容器
window.$_G = K._G = {};
$_G.get = function(key){
    return K._G[key];
};
$_G.set = function(key, value, protected_) {
    var b = !protected_ || (protected_ && typeof K.G[key] == "undefined");
    b && (K._G[key] = value);
    return K._G[key];
};

//生成全局GUID
K.GGUID = function(){
    var guid = K.$GUID;
    for (var i = 1; i <= 32; i++) {
        var n = Math.floor(Math.random() * 16.0).toString(16);
        guid += n;
    }
    return guid.toUpperCase();
};
K.Guid = function(){
    return K.$GUID + $_G._counter++;
};
$_G._counter = $_G._counter || 1;

//cookie
var Cookie = window.Cookie = window.Cookie || {};
//验证字符串是否合法的cookie键名
Cookie._valid_key = function(key){
    return (new RegExp("^[^\\x00-\\x20\\x7f\\(\\)<>@,;:\\\\\\\"\\[\\]\\?=\\{\\}\\/\\u0080-\\uffff]+\x24")).test(key);
}
Cookie.set = function(key, value, expire){
    if(Cookie._valid_key(key)){
        var a = key + "=" + escape(value);
        if(typeof(expire) != 'undefined'){
            var date = new Date();
            expire = parseInt(expire,10);
            data.setTime(date.getTime + expire*1000);
            a += "; expires="+data.toGMTString();
        }
        document.cookie = a;
    }
    return null;
};
Cookie.get = function(key){
    if(Cookie._valid_key(key)){
        var reg = new RegExp("(^| )" + key + "=([^;]*)(;|\x24)"),
            result = reg.exec(document.cookie);            
        if(result){
            return result[2] || null;
        }
    }
    return null;
};
Cookie.remove = function(key){
    document.cookie = key+"=;expires="+(new Date(0)).toGMTString();
};

Widget.Dialog = Widget.Dialog || {};

Widget.Dialog.Load = function(link,title,width,handler){
    var option = {width:500,autoOpen:false,modal:true};
    var opt = $.extend({},option);
    handler = handler || function(){};
    title = title || "";
    opt.width = width || opt.width; 
    Widget.MsgBox.load("数据努力加载中。。。", 5000); 
    if(link.indexOf("?")<0){
        link += "?MINI=load";
    }else{
        link += "&MINI=load";
    }
    $.get(link, function(content){
        layer.open({
            type: 1,
            title:title,
            area: opt.width+'px',
            skin: 'layui-layer-rim', //加上边框
            content: content,
            success : function(){
                Widget.MsgBox.hide();handler();
            }
        });
    });
};
window.Dialog_callback = [];
Widget.Dialog.iframe = function(link, title, width, handler){
    var option = {width:700,modal:true};
    var opt = $.extend({},option);
    opt.title = title || "";
    opt.width = width || 700;
    Widget.MsgBox.success("数据处理中...");
    Widget.MsgBox.load("数据努力加载中...");
    var callback = K.GGUID();
    if(link.indexOf("?")<0){
        link += "?MINI=LoadIframe&callback="+callback;
    }else{
        link += "&MINI=LoadIframe&callback="+callback;
    }

    layer.open({
        type: 2,
        title:title,
        area: opt.width+'px',
        skin: 'layui-layer-rim', //加上边框
        content: link,
        success : function(){
            Widget.MsgBox.hide();handler();
        }
    });
    return ;
}
Widget.Dialog.Select = function(link, multi, handler, opt){
    multi = multi || 'N';
    handler = handler || function(ret){return ret;};
    if(link.indexOf("?")<0){
        link += "?MINI=LoadIframe&multi="+multi;
    }else{
        link += "&MINI=LoadIframe&multi="+multi;
    }
    layer.open({
        type: 2,
        area: ['700px', '530px'],
        skin: 'layui-layer-rim',
        content: link,
        success: function(layero, index){

        },
        btn: ['确认选择','取消选择'],
        yes: function(index,layero){
            var body = $(window.frames["layui-layer-iframe"+index].document).find("body");
            var items = [];
            body.find('input[CK="PRI"]:checked').each(function(){
                var data = $(this).attr("data") || '{}';
                data = eval('(' + data + ')');
                if(multi == 'Y'){
                    items.push([$(this).val(), data]);
                }else{
                    items = [$(this).val(), data];
                }
            });
            setTimeout(function(){handler(items);}, 500);
            layer.close(index);         
        }
    });
};

var MsgBox = Widget.MsgBox = Widget.MsgBox || {};
MsgBox.success=function(msg, options, callback){
    MsgBox.hide();
    if(typeof(options) == 'function'){
        callback = options;
        options = {};
    }
    callback = callback || function(ret){};
    options = $.extend({/*style:"background-color: #000;filter: alpha(opacity=60);background-color: rgba(0,0,0,0.6);color: #fff;border: none;",*/"time":2},options||{});
    options["end"] = callback;
    options["content"] = msg;
    layer.open(options);
};
MsgBox.error=function(msg,options,callback){
    MsgBox.hide();
    if(typeof(options) == 'function'){
        callback = options;
        options = {};
    }
    callback = callback || function(ret){}
    options = $.extend({/*style:"border:none; background-color:#78BA32; color:#fff;",*/"time":3},options||{});
    options["end"] = callback;
    options["content"] = msg;
    layer.open(options);
};
MsgBox.alert = function(msg, callback){
    MsgBox.hide();
    callback = callback || function(ret){};
    options["end"] = callback;
    options["content"] = msg;
    layer.open({content: msg, btn: ['确认'], end: callback});
}
MsgBox.confirm = function(msg, options, callback){
    MsgBox.hide();
    if(typeof(options) == 'function'){
        callback = options;
        options = {shadeClose: false, btn: ['确认', '取消']};
    }
    callback = callback || function(ret){};
    options["content"] = msg;
    options["btn"]  =options["btn"] || ['确认', '取消'];
    options["yes"] = function(index){callback(true);layer.close(index);}
    options["no"] = function(index){callback(false);layer.close(index);}
    layer.open(options);
}
MsgBox.notice=function(options){
    MsgBox.hide();
    layer.open(options);
};
MsgBox.load=function(msg,options){
    MsgBox.hide();
    options = $.extend({time:120,type:2,shade:false,shadeClose:false},options||{});
    layer.open(options);
    //layer.open({shade:false,shadeClose:false,time:10000,type:2,content:'<div class="loading"><div class="dot white"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>'});
};
MsgBox.show=function(options,callback){
    options = options||{};
    options['end'] = callback || function(){};
    layer.open(options);
};
MsgBox.hide=function(){
    layer.closeAll();
};
//重写toFixed方法  
Number.prototype.toFixed2=function(len) {  
    var tempNum = 0;  
    var s,temp;  
    var s1 = this + "";  
    var start = s1.indexOf(".");  
    if(s1.substr(start+len+1,1)>=5) {
        tempNum=1; 
    } 
    var temp = Math.pow(10,len);  
    s = Math.floor(this * temp) + tempNum;  
    return s/temp;  
}
String.prototype.toFixed=function(len)  {  
    var tempNum = 0;  
    var s,temp;  
    var s1 = this + "";  
    var start = s1.indexOf(".");  
    if(s1.substr(start+len+1,1)>=5) {
        tempNum=1;
    }
    var temp = Math.pow(10,len);  
    s = Math.floor(this * temp) + tempNum;  
    return s/temp; 
}
})(window.KT, window.jQuery)