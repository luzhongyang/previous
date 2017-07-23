/*全局公用js*/

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
    if(/(ijh.waimai|com.jhcms)/.test(navigator.userAgent.toLowerCase())){
        if(navigator.userAgent.indexOf("Android") >=0){
            return 'Android';
        }else{
            return 'IOS';
        }
    }else{
        return false;
    }
}


//Gps转百度坐标
function gpsToBaidu(lng, lat) {
    var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    var x = lng;
    var y = lat;
    var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
    var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
    var bdlng = z * Math.cos(theta) + 0.0065;
    var bdlat = z * Math.sin(theta) + 0.006;
    return {"lng":bdlng.toFixed(5), "lat": bdlat.toFixed(5)};
}


//取到当前的坐标(Biadu系坐标)
function getUxLocation(callback){
    callback = callback || function(ret){};
    if(UxLocation.lat && UxLocation.lng && UxLocation.addr){
        Widget.MsgBox.hide();
        UxLocation["error"] = 0;
        callback(UxLocation);
        return true;
    }else if(localStorage["UxLocation"]){
        Widget.MsgBox.hide();
        try{
            uxl = JSON.parse(localStorage["UxLocation"]) || {};
            if(uxl.lat && uxl.lng && uxl.addr){
                UxLocation = uxl;
                UxLocation["error"] = 0;
                Cookie.set('UxLocation','{"lat":"'+UxLocation['lat']+'","lng":"'+UxLocation['lng']+'"}', 86400);
                callback(UxLocation);
                return true;
            }
        }catch(e){
            setUxLocation({"lat":0, "lng":0, "addr":""});
            //alert(e);
            //Cookie中没有保存用户位置
        }
    }
    if(checkIsWeixin()){ //微信获位置坐标
        var it_wxloction = setInterval(function () {
            wx.ready(function(){
                wx.getLocation({
                    success: function (res) {
                        clearInterval(it_wxloction);
                        Widget.MsgBox.hide();
                        var poi = GpsToBaidu(res.longitude.toFixed(6), res.latitude.toFixed(6));
                        UxLocation["lat"] = poi.lat;
                        UxLocation["lng"] = poi.lng;
                        setUxLocation(UxLocation);
                        geocoder(UxLocation.lng, UxLocation.lat, function(ret){
                            if(ret.status ==0){
                                if(ret.result.pois.length>0){
                                    UxLocation['addr'] = ret.result.pois[0]['addr'];
                                    UxLocation["error"] = 0;
                                    setUxLocation(UxLocation);
                                    callback(UxLocation);
                                }
                            }
                        });
                    },
                    fail: function (res) {
                        clearInterval(it_wxloction);
                        alert("fail:"+JSON.stringify(res));
                    },
                    cancel: function (res) {
                        clearInterval(it_wxloction);
                        alert('用户拒绝授权获取地理位置');
                    },
                    complete: function (res) {
                        clearInterval(it_wxloction);
                        Widget.MsgBox.hide();
                        var poi = GpsToBaidu(res.longitude.toFixed(6), res.latitude.toFixed(6));
                        UxLocation["lat"] = poi.lat;
                        UxLocation["lng"] = poi.lng;
                        setUxLocation(UxLocation);
                        geocoder(UxLocation.lng, UxLocation.lat, function(ret){
                            if(ret.status ==0){
                                if(ret.result.pois.length>0){
                                    UxLocation['addr'] = ret.result.pois[0]['addr'];
                                    UxLocation["error"] = 0;
                                    setUxLocation(UxLocation);
                                    callback(UxLocation);
                                }
                            }
                        });
                    }
                });
            });
            // 退出循环
            return false;
        }, 2000);
    }else if(navigator.geolocation){ //浏览器获取位置坐标
        navigator.geolocation.getCurrentPosition(function(position){
            var poi = GpsToBaidu(position.coords.longitude.toFixed(6), position.coords.latitude.toFixed(6));
            UxLocation["lat"] = poi.lat;
            UxLocation["lng"] = poi.lng;
            setUxLocation(UxLocation);
            geocoder(UxLocation.lng, UxLocation.lat, function(ret){
                if(ret.status ==0){
                    if(ret.result.pois.length>0){
                        UxLocation['addr'] = ret.result.pois[0]['addr'];
                        UxLocation["error"] = 0;
                        setUxLocation(UxLocation);
                        callback(UxLocation);
                    }
                }
            });
        },function(error){
            var error_msg = "";
            switch (error.code){
                case error.PERMISSION_DENIED:
                    error_msg = '获取位置信息失败,用户拒绝请求地理定位';
                    break;
                case error.POSITION_UNAVAILABLE:
                    error_msg = '获取位置信息失败,位置信息不可用';
                    break;
                case error.TIMEOUT:
                    error_msg = '获取位置信息失败,请求获取用户位置超时';
                    break;
                case error.UNKNOWN_ERROR:
                    error_msg = '获取位置信息失败,定位系统失效';
                    break;
            }
            callback({"error":error.code, "message":error_msg});
        },{enableHighAccuracy:true});
    }else{
        callback({"error":-1, "message":error_msg});
    }
}


//调用BaiduAPI根据坐标获取标注点
function geocoder(lng, lat, callback){
    callback = callback || function(ret){};
    var callfun = GGUID();
    window[callfun] = function(ret){callback(ret);}
    $.getScript("http://api.map.baidu.com/geocoder/v2/?ak=824a595f958e444b737a5bc6325ad44f&callback="+callfun+"&location="+lat+","+lng+"&output=json&pois=1");
}


//根据检索词发起检索,搜索范围约束在当前城市
function placeApi(key, city, callback){
    city = city || Cookie.get("CITY_NAME");
    callback = callback || function(ret){};
    var callfun = GGUID();
    window[callfun] = function(ret){callback(ret);}
    $.getScript("http://api.map.baidu.com/place/v2/search?ak=824a595f958e444b737a5bc6325ad44f&output=json&callback="+callfun+"&query="+key+"&page_size=10&page_num=0&scope=1&region="+city);
}


//将两点经纬度距离输出为公里
function getDistance(lng1,lat1,lng2,lat2){
    var radLat1 = lat1 * Math.PI / 180.0;
    var radLat2 = lat2 * Math.PI / 180.0;
    var a = radLat1 - radLat2;
    var  b = lng1 * Math.PI / 180.0 - lng2 * Math.PI / 180.0;
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) +
    Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
    s = s *6378.137 ;// EARTH_RADIUS;
    s = Math.round(s * 10000) / 10; //输出为公里
    return (s/1000);
}


// 格式化输出距离单位
function formatDistance(dist){
    dist = parseFloat(dist, 10);  //解析一个字符串，并返回一个浮点数,第二个参数表示10进制
    if(dist < 1000){
        return dist.toFixed(2) + "米";
    }else{
        return (dist/1000).toFixed(2) + "千米";
    }
}


//获取js对象长度
function getObjLen(data) {
    var index = 0;
    for(i in data){
        index+=1;
    }
    return index;
}


/*数组去重复*/
function unique(arr) {
    var result = [], hash = {};
    for (var i = 0, elem; (elem = arr[i]) != null; i++) {
        if (!hash[elem]) {
            result.push(elem);
            hash[elem] = true;
        }
    }
    return result;
}

/*检查用户登录情况*/
function check_login(){
    if(!is_login){
        document.location = '/login';
        return false;
    }
    return true;
}


//关注模块处理，关注问题，用户等
$("#follow-button,.followTopic,.followerUser").click(function(){
    if(!check_login()){
        return ;
    }
    $(this).button('loading');
    var follow_btn = $(this);
    var source_type = $(this).data('source_type');
    var source_id = $(this).data('source_id');
    var show_num = $(this).data('show_num');
    $.ajax({
        url: "/ajax/follow/",
        async: true,
        dataType: 'json',
        data: {},
        type: 'POST',
        success: function (ret) {
        	follow_btn.removeClass('disabled');
	        follow_btn.removeAttr('disabled');
            if(ret.status == 1 ) {
		        if(ret.followed == 'followed'){
		            follow_btn.html('已关注');
		            follow_btn.addClass('active');
		        }else{
		            follow_btn.html('关注');
		            follow_btn.removeClass('active');
		        }
            }
            /*是否操作关注数*/
	        if(Boolean(show_num)){
	            var follower_num = $("#follower-num").html();
	            if(ret.followed =='followed'){
	                $("#follower-num").html(parseInt(follower_num)+1);
	            }else{
	                $("#follower-num").html(parseInt(follower_num)-1);
	            }
	        }
        },
        error: function (xhr, status, err) {
            $.alert(err);
        },
    });
});


//赞同模块公共处理
$(".btn-support").hover(function(){
    var btn_support = $(this);
    var source_type = btn_support.data('source_type');
    var source_id = btn_support.data('source_id');
    $.ajax({
        url: "/ajax/supportCheck/",
        async: true,
        dataType: 'json',
        data: {},
        type: 'POST',
        success: function (ret) {
        	btn_support.removeClass('btn-default');
	        if(ret.status == 0){
	            btn_support.addClass('btn-warning');
	            btn_support.html('<i class="fa fa-thumbs-o-up"></i> 已赞');
	        }else{
	            btn_support.addClass('btn-success');
	            btn_support.html('<i class="fa fa-thumbs-o-up"></i> 赞同');
	        }
        },
        error: function (xhr, status, err) {
            $.alert(err);
        },
    });
}, function(){
    var btn_support = $(this);
    var support_num = $(this).data('support_num');
    btn_support.attr('class','btn btn-default btn-sm btn-support');
    btn_support.html('<i class="fa fa-thumbs-o-up"></i> '+support_num);
});


//赞同请求
$(document).off('click','.btn-support').on('click','.btn-support',function{
	if(!check_login()){
        return ;
    }
    var btn_support = $(this);
    var source_type = btn_support.data('source_type');
    var source_id = btn_support.data('source_id');
    var support_num = parseInt(btn_support.data('support_num'));
    $.get('/support/'+source_type+'/'+source_id,function(msg){
        if(msg =='success'){
            support_num++
            btn_support.html('<i class="fa fa-thumbs-o-up"></i> '+support_num);
            btn_support.data('support_num',support_num);
        }
    });
})

//举报请求
$(document).off('click','.btn-report').on('click','.btn-report', function(){
    if(!check_login()) {
        return ;
    }
    var btn_report = $(this);
    var source_type = btn_report.data('source_type');
    var source_id = btn_report.data('source_id');
    var support_num = parseInt(btn_report.data('support_num'));
    $.get('/report/'+source_type+'/'+source_id,function(msg){
        if(msg =='success'){
            support_num++
            btn_report.html('<i class="fa fa-thumbs-o-up"></i> '+support_num);
            btn_report.data('support_num',support_num);
        }
    });
})

/*通知异步加载*/
$("#unread_notifications").load("/ajax/unreadNotifis");

/*异步加载私信*/
$("#unread_messages").load("/ajax/unreadMsgs");


function add_comment(token,source_type,source_id,content,to_user_id){
    var postData = {_token:token,source_id:source_id,source_type:source_type,content:content};
    if(to_user_id>0){
        postData.to_user_id = to_user_id;
    }
    $.post('/comment/store',postData,function(html){
        $("#comments-"+source_type+"-"+source_id+" .widget-comment-list").append(html);
        $("#comment-"+source_type+"-content-"+source_id).val('');
    });
}


function load_comments(source_type,source_id){
    $.get('/'+source_type+'/'+source_id+'/comments',function(html){
        $("#comments-"+source_type+"-"+source_id+" .widget-comment-list").append(html);
    });
}

function clear_comments(source_type,source_id){
    $("#comments-"+source_type+"-"+source_id+" .widget-comment-list").empty();
}
