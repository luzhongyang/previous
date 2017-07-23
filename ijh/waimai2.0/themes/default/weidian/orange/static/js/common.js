window.Widget  = window.Widget || {};
var MsgBox = Widget.MsgBox = Widget.MsgBox || {};
MsgBox.success=function(msg, title, callback){
    MsgBox.alert(msg, title, callback);
};
MsgBox.error=function(msg,title,callback){
    MsgBox.alert(msg, title, callback);    
};
MsgBox.alert = function(msg,title,callback){
    MsgBox.hide();
    if(typeof(title) == 'function'){
        $.alert(msg, callback);
    }else if(typeof(title) == 'string'){
        callback = callback || function(ret){};
        $.alert(msg, title, callback);
    }else{
        $.alert(msg);
    }
}
MsgBox.confirm = function(msg, title, callback){
    MsgBox.hide();
    if(typeof(title) == 'function'){
        callback = title;
        $.confirm(msg, function(){callback(true)}, function(){callback(false);});
    }else{
        $.confirm(msg, title,  function(){callback(true)}, function(){callback(false);});
    }
}
MsgBox.notice=function(msg, title, callback){
    MsgBox.alert(msg, title, callback);
};
MsgBox.load=function(msg, time, callback){
    MsgBox.hide();
    if(typeof(time) == 'function'){
        callback = time;
        time = 2;
    }
    time = time || 2;
    callback = callback || function(){};
    $.showPreloader(msg)
    setTimeout(function () {
        $.hidePreloader();
        callback();
    }, time*1000);
};
MsgBox.show = function(msg, title, callback){
    MsgBox.alert(msg, title, callback);
};
MsgBox.hide = function(){
    $.closeModal();
};
MsgBox.prompt = function(msg, title, callback){
    MsgBox.hide();
    if(typeof(title) == 'function'){
        callback = title;
        $.prompt(msg, function(value){callback(value)});
    }else{
        $.prompt(msg, title, function(value){callback(value)});
    }    
}
//重写toFixed方法  
Number.prototype.toFixed=function(len)  
{  
	var tempNum = 0;  
	var s,temp;  
	var s1 = this + "";  
	var start = s1.indexOf(".");  
	  
	//截取小数点后,0之后的数字，判断是否大于5，如果大于5这入为1  

   if(s1.substr(start+len+1,1)>=5)  
	tempNum=1;  

	//计算10的len次方,把原数字扩大它要保留的小数位数的倍数  
  var temp = Math.pow(10,len);  
	//求最接近this * temp的最小数字  
	//floor() 方法执行的是向下取整计算，它返回的是小于或等于函数参数，并且与之最接近的整数  
	s = Math.floor(this * temp) + tempNum;  
	return s/temp;  

}
String.prototype.toFixed=function(len)  
{  
	var tempNum = 0;  
	var s,temp;  
	var s1 = this + "";  
	var start = s1.indexOf(".");  
	  
	//截取小数点后,0之后的数字，判断是否大于5，如果大于5这入为1  

   if(s1.substr(start+len+1,1)>=5)  
	tempNum=1;  

	//计算10的len次方,把原数字扩大它要保留的小数位数的倍数  
  var temp = Math.pow(10,len);  
	//求最接近this * temp的最小数字  
	//floor() 方法执行的是向下取整计算，它返回的是小于或等于函数参数，并且与之最接近的整数  
	s = Math.floor(this * temp) + tempNum;  
	return s/temp; 

}
//cookie
window.Cookie = window.Cookie || {};
window.UxLocation = window.UxLocation || {"lat":0, "lng":0, "addr":""};
window.CFG = window.CFG || {"domain":"","url":"/", "title":"外卖系统", "res":"/static", "img":"/attachs","C_PREFIX":"KT-"};
window.LoadData = window.LoadData || {"LOCK":false, "LOAD_END":false, "params":{"page":1}};
//验证字符串是否合法的cookie键名
Cookie._valid_key = function(key){
    return (new RegExp("^[^\\x00-\\x20\\x7f\\(\\)<>@,;:\\\\\\\"\\[\\]\\?=\\{\\}\\/\\u0080-\\uffff]+\x24")).test(key);
}
Cookie.set = function(key, value, expire, path){
    path = path || "/";
    key = window.CFG['C_PREFIX']+key;
    if(Cookie._valid_key(key)){
        //var a = key + "=" + escape(value);
        var a = key + "=" + (value);
        if(typeof(expire) != 'undefined'){
            var date = new Date();
            expire = parseInt(expire,10);
            date.setTime(date.getTime() + expire*1000);
            a += "; expires="+date.toGMTString();
        }
        a += ";path="+path;
        document.cookie = a;
    }
    return null;
};
Cookie.get = function(key){
    key = window.CFG['C_PREFIX']+key;
    if(Cookie._valid_key(key)){
        var reg = new RegExp("(^| )" + key + "=([^;]*)(;|\x24)"),
        result = reg.exec(document.cookie);
        if(result){
            //return unescape(result[2]) || null;
            return (result[2]) || null;
        }
    }
    return null;
};
Cookie.remove = function(key){
    key = window.CFG['C_PREFIX']+key;
    document.cookie = key+"=;expires="+(new Date(0)).toGMTString();
};
//生成全局GUID
function GGUID(){
    var guid = '';
    for (var i = 1; i <= 32; i++) {
        var n = Math.floor(Math.random() * 16.0).toString(16);
        guid += n;
    }
    return "KT"+guid.toUpperCase();
}
//判断是否为手机访问
function checkIsMobile(){
    if(/(iphone|ipad|ipod|android|windows phone)/.test(navigator.userAgent.toLowerCase())){
        return true;
    }else{
        return false;
    }
}
//判断是否为腾讯手机浏览器
function checkIsMQQBrowser(){
    if(/(mqqbrowser)/.test(navigator.userAgent.toLowerCase())){
        return true;
    }else{
        return false;
    }
}
//判断是否微信
function checkIsWeixin(){
    if(/(micromessenger)/.test(navigator.userAgent.toLowerCase())){
        return true;
    }else{
        return false;
    }
}
//判断是否为APPwebView调用
function checkIsAppClient(){
    if(/(ijh.waimai)/.test(navigator.userAgent.toLowerCase())){
        return true;
    }else{
        return false;
    }
}
//Android版本
function getAndroidVersion(){
    var index = navigator.userAgent.indexOf("Android");
    if(index >= 0){
        var androidVersion = parseFloat(navigator.userAgent.slice(index+8));
        if(androidVersion > 1){
            return androidVersion;
        }else{
            return 100;
        }
    }else{
        return 100;
    }
}
//Gps转百度坐标
function GpsToBaidu(lng, lat) {
    var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    var x = lng;
    var y = lat;
    var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
    var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
    var bdlng = z * Math.cos(theta) + 0.0065;
    var bdlat = z * Math.sin(theta) + 0.006;
    
    return {"lng":bdlng.toFixed(5), "lat": bdlat.toFixed(5)};
}

function setUxLocation(uxl){
    UxLocation = uxl || {};
//    console.log(UxLocation);
    localStorage['UxLocation'] = JSON.stringify(UxLocation);
    Cookie.set('UxLocation','{"lat":"'+UxLocation['lat']+'","lng":"'+UxLocation['lng']+'"}', 86400);
}

//取到当前的坐标(Biadu系坐标)
function getUxLocation(callback){
    callback = callback || function(ret){};
    
    uxl = {};
    if(localStorage["UxLocation"]){
        uxl = JSON.parse(localStorage["UxLocation"]) || {};
    }
    
    if(UxLocation.lat >0 && UxLocation.lng >0 && UxLocation.addr){
//        console.log(1111);
        Widget.MsgBox.hide();
        UxLocation["error"] = 0;
        callback(UxLocation);
    }else if(uxl.lat >0 && uxl.lng >0){
        Widget.MsgBox.hide();
//        alert('2222');
//        alert(localStorage["UxLocation"]);
//        console.warn('2222');
//        console.log(localStorage["UxLocation"]);
        try{
            if(uxl.lat >0 && uxl.lng >0 && uxl.addr){
                UxLocation = uxl;
                UxLocation["error"] = 0;
                
                setUxLocation(UxLocation);
                callback(UxLocation);
            }
            
        }catch(e){
//            setUxLocation({"lat":0, "lng":0, "addr":""});
            //alert(e);
            //Cookie中没有保存用户位置
        }
    }
    else
    {
//        if(checkIsWeixin()){ //微信获位置坐标
//            var it_wxloction = setInterval(function () {
//                wx.ready(function(){
//                    wx.getLocation({
//                        success: function (res) {
//                            clearInterval(it_wxloction);
//                            Widget.MsgBox.hide();
//                            var poi = GpsToBaidu(res.longitude.toFixed(6), res.latitude.toFixed(6));
//                            UxLocation["lat"] = poi.lat;
//                            UxLocation["lng"] = poi.lng;
//                            setUxLocation(UxLocation);
//                            geocoder(UxLocation.lng, UxLocation.lat, function(ret){
//                                if(ret.status ==0){
//                                    if(ret.result.pois.length>0){
//                                        UxLocation['addr'] = ret.result.pois[0]['addr'];
//                                        UxLocation["error"] = 0;
//                                        setUxLocation(UxLocation);
//                                        callback(UxLocation);                                    
//                                    }
//                                }
//                            });
//                        },
//                        fail: function (res) {
//                            clearInterval(it_wxloction);
//                            alert("fail:"+JSON.stringify(res));
//                        },
//                        cancel: function (res) { 
//                            clearInterval(it_wxloction);
//                            alert('用户拒绝授权获取地理位置');
//                        },
//                        complete: function (res) {
//                            clearInterval(it_wxloction);
//                            Widget.MsgBox.hide();
//                            var poi = GpsToBaidu(res.longitude.toFixed(6), res.latitude.toFixed(6));
//                            UxLocation["lat"] = poi.lat;
//                            UxLocation["lng"] = poi.lng;
//                            setUxLocation(UxLocation);
//                            geocoder(UxLocation.lng, UxLocation.lat, function(ret){
//                                if(ret.status ==0){
//                                    if(ret.result.pois.length>0){
//                                        UxLocation['addr'] = ret.result.pois[0]['addr'];
//                                        UxLocation["error"] = 0;
//                                        setUxLocation(UxLocation);
//                                        callback(UxLocation);                                    
//                                    }
//                                }
//                            });
//                        }
//                    });
//                });            
//                // 退出循环            
//                return false;
//            }, 2000);
//        }else
            if(navigator.geolocation){ //浏览器获取位置坐标


            var map = new BMap.Map("hide_map");
            var point = new BMap.Point();
            map.centerAndZoom(point,12);

            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r){
                    if(geolocation.getStatus() == BMAP_STATUS_SUCCESS){
                        var mk = new BMap.Marker(r.point);
                        //map.addOverlay(mk);//无需定位
                        //map.panTo(r.point);
    //			$.alert('您的位置：'+r.point.lng+','+r.point.lat);
    //                 var poi = GpsToBaidu(r.point.lng.toFixed(6), r.point.lat.toFixed(6));
                        UxLocation["lat"] = r.point.lat;
                        UxLocation["lng"] = r.point.lng;
                        setUxLocation(UxLocation);      
        //                console.log(r.point.lat+'---'+r.point.lng);
                        $.getJSON('/index.php?ctl=bmap&act=getpois&lat='+r.point.lat+"&lng="+r.point.lng, function(ret){
                            if(!ret.error){
                                $.each(ret.data, function(index,item) {
                                    if(index == 0) {
                                        UxLocation['addr'] = item.addr;
                                        UxLocation["error"] = 0;
                                        setUxLocation(UxLocation)
                                        callback(UxLocation);
                                    }
                                }); 
                            }
                        })

                    }
                    else {
//                            alert('failed'+geolocation.getStatus());
                            error_msg = geolocation.getStatus();
                    }
            },{enableHighAccuracy: true})
    //        alert('xxx');
    //        navigator.geolocation.getCurrentPosition(function(position){
    //            var poi = GpsToBaidu(position.coords.longitude.toFixed(6), position.coords.latitude.toFixed(6));
    //            UxLocation["lat"] = poi.lat;
    //            UxLocation["lng"] = poi.lng;
    //            setUxLocation(UxLocation);
    //            /*geocoder(UxLocation.lng, UxLocation.lat, function(ret){
    //                if(ret.status ==0){
    //                    if(ret.result.pois.length>0){
    //                        UxLocation['addr'] = ret.result.pois[0]['addr'];
    //                        UxLocation["error"] = 0;                      
    //                        setUxLocation(UxLocation);                
    //                        callback(UxLocation);
    //                    }
    //                }
    //            }); */
    //            $.getJSON('/index.php?ctl=bmap&act=getpois&lat='+poi.lat+"&lng="+poi.lng, function(ret){
    //                if(!ret.error){
    //                    $.each(ret.data, function(index,item) {
    //                        if(index == 0) {
    //                            UxLocation['addr'] = item.addr;
    //                            UxLocation["error"] = 0;
    //                            setUxLocation(UxLocation)
    //                            callback(UxLocation);
    //                        }
    //                    }); 
    //                }
    //            })
    //        },function(error){
    //            var error_msg = "";
    //            switch (error.code){
    //                case error.PERMISSION_DENIED:
    //                    error_msg = '获取位置信息失败,用户拒绝请求地理定位';
    //                    break; 
    //                case error.POSITION_UNAVAILABLE:
    //                    error_msg = '获取位置信息失败,位置信息不可用';
    //                    break; 
    //                case error.TIMEOUT:
    //                    error_msg = '获取位置信息失败,请求获取用户位置超时';
    //                    break; 
    //                case error.UNKNOWN_ERROR:
    //                    error_msg = '获取位置信息失败,定位系统失效';
    //                    break;
    //            }
    //            callback({"error":error.code, "message":error_msg});
    //        },{enableHighAccuracy:true});
        }else{
            callback({"error":-1, "message":error_msg});
        }
    }
}

//调用BaiduAPI根据坐标获取标注点
function geocoder(lng, lat, callback){
    callback = callback || function(ret){};
    var callfun = GGUID();
    window[callfun] = function(ret){callback(ret);}
    $.getScript("http://api.map.baidu.com/geocoder/v2/?ak=824a595f958e444b737a5bc6325ad44f&callback="+callfun+"&location="+lat+","+lng+"&output=json&pois=1");
}

function placeapi(key, city, callback){
    city = city || localStorage["UxCity"];
    callback = callback || function(ret){};
    var callfun = GGUID();
    window[callfun] = function(ret){callback(ret);} 
    $.getScript("http://api.map.baidu.com/place/v2/search?ak=824a595f958e444b737a5bc6325ad44f&output=json&callback="+callfun+"&query="+key+"&page_size=10&page_num=0&scope=1&region="+city);
}

//距离输出为公里
function GetDistance(lng1,lat1,lng2,lat2){
    var radLat1 = lat1 * Math.PI / 180.0;
    var radLat2 = lat2 * Math.PI / 180.0;
    var a = radLat1 - radLat2;
    var  b = lng1 * Math.PI / 180.0 - lng2 * Math.PI / 180.0;
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) +
    Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
    s = s *6378.137 ;// EARTH_RADIUS;
    s = Math.round(s * 10000) / 10; //输出为米
    return s;
}

// 格式化输出距离单位
function formatDistance(dist){
    dist = parseFloat(dist, 10);
    if(dist < 1000){
        return dist.toFixed(2) + "米";
    }else{
        return (dist/1000).toFixed(2) + "千米";
    }
}

/*
 * 跳转页面
 * （默认页面往左滑动，即 left）
 * （页面往右滑动，即 right
 */
/*function linkLoadPage(url, type) {
    if(checkIsMQQBrowser()){
        window.location.href = url;
        return ;
    }
    var animateCss = {}, animateAfterCss = {};
    type = type || 'left';
    switch (type) {
        case 'left':
            animateCss = {'left': '-' + $(window).width() + 'px'};
            animateAfterCss = {'left': '0px'};
            break;
        case 'right':
            animateCss = {'left': $(window).width() + 'px'};
            animateAfterCss = {'left': '0px'};
            window.location.href = url;
            return;
            break;
    }
    $('header,footer,section,#downOption,#shangjia_tab,.dianpuPrompt,.switchTab_box,.saixuan_pull').animate(animateCss, function () {
        Widget.MsgBox.load();
        window.addEventListener("pagehide", function () {
            $('header,footer,section,#downOption,#shangjia_tab,.dianpuPrompt,.switchTab_box').css(animateAfterCss);
            Widget.MsgBox.hide();
        });
        setTimeout(function () {
            window.location.href = url;
        });
    });
}*/


/*function build_refresher_items(url, json, tmpl, wapper, theme , first,type) {
    if (theme) {
        $('#wrapper ul').append('<div class="loading_ico"><img src="' + theme + '/static/images/load.gif" />正在加载中...</div>');
    }
    $.post(url, json, function (ret) {
        if (ret.error != 0) {
            layer.open({'content': ret.message});
        } else if (!ret.data.items) {                
            if(first){
                if(type == 'shop'){
                    $('.loading_ico').remove();
                    $('#wrapper ul').append('<div class="youhui_no"><div class="iconBg"><i class="ico7"></i> </div><h2>暂无商铺</h2><p class="black9">抱歉，暂时没有符合您搜索的商铺！</p></div>');
                }
            }else{
                $('.loading_ico').remove();
                $("#pullUp .pullUpLabel").html('没有更多了');
            }                
        } else if (ret.data.items.length == 0) {                
            if(first){
                if(type == 'shop'){
                    $('.loading_ico').remove();
                    $('#wrapper ul').append('<div class="youhui_no"><div class="iconBg"><i class="ico7"></i> </div><h2>暂无商铺</h2><p class="black9">抱歉，暂时没有符合您搜索的商铺！</p></div>');
                }
            }else{
                $('.loading_ico').remove();
                $("#pullUp .pullUpLabel").html('没有更多了');
            }                
        } else {
            $('.loading_ico').remove();
            $(tmpl).tmpl(ret.data.items).appendTo(wapper);
        }
    }, 'json');    
}*/


function time_select(yuji, start, start_quarter, end, end_quarter) {
    start = parseInt(start, 10);
    start_quarter = parseInt(start_quarter, 10);
    end = parseInt(end, 10);
    end_quarter = parseInt(end_quarter, 10);
    var html = '';
    if(yuji != '') {
        html += yuji + ",";
    }
    
    if (start_quarter > 0) {
        for (var q = start_quarter; q <= 3; q++) {
            if (q == 3) {
                html += start + ':' + q * 15 + '-' + (start + 1) + ':00' + ",";
            } else {
                html += start + ':' + q * 15 + '-' + start + ':' + (q + 1) * 15 + ",";
            }
        }
        if(start+1<end){
            for (var i = start + 1; i < end; i++) {
                for (var q = 0; q <= 3; q++) {
                    var end_time = i + ':' + (q + 1) * 15;
                    if (q == 3) {
                        end_time = (i + 1) + ':00';
                    }
                    var begin_time = i + ':' + q * 15;
                    if (q == 0) {
                        begin_time = i + ':00';
                    }
                    html += begin_time + '-' + end_time + ",";
                }
            }
        }
    }else if (end_quarter > 0) {
        for (var i = start; i < end; i++) {
            for (var q = 0; q <= 3; q++) {
                var end_time = i + ':' + (q + 1) * 15;
                if (q == 3) {
                    end_time = (i + 1) + ':00';
                }
                var begin_time = i + ':' + q * 15;
                if (q == 0) {
                    begin_time = i + ':00';
                }
                html += begin_time + '-' + end_time + ",";
            }
        }
        for (var q = 0; q < end_quarter; q++) {
            if (q == 0) {
                html += end + ':00-' + end + ':' + (q + 1) * 15;
            } else {
                html += end + ':' + q * 15 + '-' + end + ':' + (q + 1) * 15  + ",";
            }
        }
    }else{
        for (var i = start; i < end; i++) {
            for (var q = 0; q <= 3; q++) {
                var end_time = i + ':' + (q + 1) * 15;
                if (q == 3) {
                    end_time = (i + 1) + ':00';
                }
                var begin_time = i + ':' + q * 15;
                if (q == 0) {
                    begin_time = i + ':00';
                }
                html += begin_time + '-' + end_time + ",";
            }
        }
    }    
    return html;
}



function position() {
    if (localStorage.getItem('lat') && localStorage.getItem('lng')) {
        //如果存在wx则转化为bd，并且赋值road
        var y = localStorage.getItem('lat');
        var x = localStorage.getItem('lng');
        var ggPoint = new BMap.Point(x, y);
        //坐标转换完之后的回调函数
        translateCallback = function (data) {
            if (data.status === 0) {
                var xx = data.points[0].lat;
                var yy = data.points[0].lng;

                //var map = new BMap.Map("allmap");
                var point = new BMap.Point(yy, xx);
                //map.centerAndZoom(point,12);
                var geoc = new BMap.Geocoder();

                geoc.getLocation(point, function (rs) {
                    var addComp = rs.addressComponents;
                    if (addComp) {
                        localStorage['road'] = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
                    }
                });
            }
        }
        setTimeout(function () {
            var convertor = new BMap.Convertor();
            var pointArr = [];
            pointArr.push(ggPoint);
            convertor.translate(pointArr, 1, 5, translateCallback)
        }, 1000);
    }
}
/*页面点击事件*/
if(window.WXJS_CFG && checkIsWeixin()){
    wx.config({debug:false,appId:WXJS_CFG.appId,timestamp:WXJS_CFG.timestamp,nonceStr:WXJS_CFG.nonceStr,signature:WXJS_CFG.signature,jsApiList:["getLocation"]});
}
$(document).ready(function () {
    FastClick.attach(document.body);
    $(document).on("click", "[link-load]", function () {
        var url = $(this).attr("link-url") || $(this).attr("href");
        var type = $(this).attr('link-type') || "left";
        linkLoadPage(url, type);
        return false;
    });
});


/*获得字符串长度*/
function GetStrLen(str) {
    //获得字符串实际长度，中文2，英文1
    var realLength = 0, len = str.length, charCode = -1;
    for (var i = 0; i < len; i++) {
        charCode = str.charCodeAt(i);
        if (charCode >= 0 && charCode <= 128) realLength += 1;
        else realLength += 2;
    }
    return realLength;
};  

/*数组去重复*/
function Unique(arr) {
    var result = [], hash = {};
    for (var i = 0, elem; (elem = arr[i]) != null; i++) {
        if (!hash[elem]) {
            result.push(elem);
            hash[elem] = true;
        }
    }
    return result;
}

/*删除数组中指定元素*/
function removeByValue(arr, val) {
  for(var i=0; i<arr.length; i++) {
    if(arr[i] == val) {
      arr.splice(i, 1);
      break;
    }
  }
}

/*获取JSON对象的长度*/
function GetJsonLen(jsonData){
    var jsonLength = 0;
    for(var item in jsonData){
        jsonLength++;
    }
    return jsonLength;
}

window.__MINI_CONFIRM = window.__MINI_CONFIRM || function(elm){
    var cfm = null;
    if($(elm).attr("mini-confirm")){
        cfm = $(elm).attr("mini-confirm");
    }else if(($(elm).attr("mini-act") || "").indexOf("confirm:")>-1){
        cfm = $(elm).attr("mini-act").replace("confirm:","");
    }else if(($(elm).attr("mini-act") || "").indexOf("remove:")>-1){
        cfm = "您确定要删除这条记录吗??\n三思啊.黄金有价数据无价!!";
    }
    if(cfm && !confirm(cfm)){
        return false;
    }
    return true;
}
$(document).off("submit","form[mini-form]").on("submit","form[mini-form]",function(){
    window.__MINI_LOAD = window.__MINI_LOAD || false;
    if(window.__MINI_LOAD){ //防止重复提交
        return false;
    }
    window.__MINI_LOAD = true;
    Widget.MsgBox.success("数据处理中...");
    Widget.MsgBox.load("数据处理中...");
    if($(this).find("[name='MINI']").size()<1){
        $(this).prepend('<input type="hidden" name="MINI" value="form" />');
    }
    $(this).find("[name='MINI']").val('iframe');
    $(this).attr("target", "miniframe");
    if($(this).find("input[type='file']").size()>0){
        $(this).attr("ENCTYPE", "multipart/form-data");
    }
    return true;
});
$(document).off("click","[mini-submit],a[mini-submit]").on("click","[mini-submit],a[mini-submit]",function(e){
    e.stopPropagation();e.preventDefault();
    window.__MINI_LOAD = window.__MINI_LOAD || false;
    if(window.__MINI_LOAD){ //防止重复提交
        return false;
    }
    if($("#miniframe").size()<1){
        $("body").prepend('<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>');
    }
    var form = $(this).attr("mini-submit");
    var action = $(this).attr("action") || $(form).attr("action");
    $(form).attr("action", action).attr("target", "miniframe").attr("method", "post");
    var value = $(this).attr("mini-value") || "true";
    Widget.MsgBox.load("数据处理中...", 30);
    window.__MINI_LOAD_TIMEER = setTimeout(function(){
        Widget.MsgBox.alert("网络不给力,稍后重试");
    }, 30000);
    //clearTimeout(window.__MINI_LOAD_TIMEER);
    if($(form).find("[name='MINI']").size()<1){
        $(form).prepend('<input type="hidden" name="MINI" value="iframe" />');
    }
    $(form).find("[name='MINI']").val('iframe');
    if($(form).find("input[type='file']").size()>0){
        $(form).attr("ENCTYPE", "multipart/form-data");
    }
    $(form).submit();
    return true;    
});


// 浮点数减法函数运算
function FloatSub(arg2,arg1){
    var r1,r2,m,n;
    try{r1 = arg1.toString().split('.')[1].length}catch(e){r1 = 0}
    try{r2 = arg2.toString().split('.')[1].length}catch(e){r2 = 0}
    m = Math.pow(10,Math.max(r1,r2));
    //动态控制精度长度
    n = (r1 >= r2) ? r1 : r2;
    return ((arg2 * m - arg1 * m) / m).toFixed(n);
}

function _title(v){
    document.title=v;
}