//本地存储数据所用常量
var STORAGE = {
    //用户ID
    BAO_USER_ID       : 'uid',
    //用户令牌
    BAO_USER_TOKEN    : 'user_token',
    //用户基本信息
    BAO_USER_INFO     : 'user_info',
    //最后访问日期
    BAO_LAST_MODIFY   : 'lastModify',
    //经纬度
    BAO_LAT_LNG       : 'latlng',

    //当前城市ID
    BAO_CITY_ID       : 'city_id',
    //city_name
    BAO_CITY_NAME     : 'city_name',
    //幕布加载方法
    //产生的数据，由各窗口公用，每次调用同步方法会被清空
    BAO_LOADED_DATA   : 'loadedData',
    //加载后当前窗口完成时返回的窗口
    BAO_BACK_WINDOW   : 'backwindow',
    //参数
    BAO_REQEUST_URL   : 'requrl',
    
    BAO_REQEUST_DATA  : 'reqdata',

    //缓存
    
    //城市列表
    BAO_CACHE_CITYS : 'citys',
    //地区列表
    BAO_CACHE_AREAS : 'areas',
    //店铺类型
    BAO_CACHE_SHOP_CATE : 'shopcates',
    //商品类型
    BAO_CACHE_GOOD_CATE : 'goodcates',
    //团购类型
    BAO_CACHE_TUAN_CATE : 'tuancates',
    //注册验证码
    BAO_REGIST_IDENTIFY: 'scode',
    //信鸽注册标识,表示已经与uid绑定
    BAO_XINGGE_UID :'xingge_uid',
    //信鸽注册标识,表示已安装APP
    BAO_XINGGE_INSTALL: 'xingge_install',
    
    BAO_ACCESS_ID:'access_id',
    
    BAO_ACCESS_KEY:'access_key',
    
}
//根据Key缓存和读取当前页面数据
var KEY={
    //首页tab热门关注
    INDEX_TUAN: 'index_tuan',
    //团购详情页
    TUAN_DETAIL: 'tuan_detail',
    //团购首页热门关注
    TUAN_INDEX_HOT: 'tuan_index_hot',
    //团购首页今日新单
    TUAN_INDEX_NEW: 'tuan_index_new',
    //团购首页最热抢购
    TUAN_INDEX_TUAN: 'tuan_index_tuan',
    //团购购买
    TUAN_BUY: 'tuan_buy',
    //团购支付
    TUAN_PAY: 'tuan_pay',
    //团购分类首页
    TUAN_CAT: 'tuan_cat',
    //地图页面
    COMMON_GPS: 'common_gps',
    //个人中心优惠卷
    MCENTER_COUPON:'mcenter_coupon',
    //优惠卷列表页
    COUPON_INDEX:'coupon_index',
    //优惠卷主页
    COUPON_MAIN:'coupon_main',
    //优惠卷详情页
    COUPON_DETAIL:'coupon_detail',
    //个人中心页面
    PERSONAL_INDEX: 'personal_index',
    //个人中心注册
    REGIST: 'regist',
    //地址
    GET_CITY:'get_city',
    
    MEMBER_ADDR:'member_addr',
    
    MEMBER_ADDR_ID:'member_addr_id',
    //个人中心我的抢购
    MEMBER_TUAN_INDEX:'member_tuan_index',
    //个人中心抢购详情
    MEMBER_TUAN_DETAIL:'member_tuan_detail',
    //我的信息
    MEMBER_MSG:'member_msg',
    MEMBER_MSG_ID:'member_msg_id',
    
    SHOP_DETAIL:'shop_detail',
}

var CONST=
{
    //请求成功，并返回数据
    BAO_REQUEST_SUCCESS: 200,
    
    //已经登录成功,不要重复登录
    BAO_LOGIN_ALREADY: 201,
    
    //登录成功
    BAO_LOGIN_SUCCESS: 202,
    
    //登录信息错误
    BAO_LOGIN_ERROR: 203 ,
    
    //登录账号不能为空
    BAO_LOGIN_ACCOUNT_ERROR: 204,
    
    //登录密码不能为空
    BAO_LOGIN_PSWD_ERROR:  205,
    
    //验证码错误
    BAO_SCODE_ERROR: 304,
    
    //手机号已存在
    BAO_PHONE_EXIST_ERROR: 306,
     
     //错误的手机号
    BAO_PHONE_ERROR: 307,
     
     //该优惠券不存在！
    BAO_COUPON_ERROR: 308,
     
     //该优惠券已经过期
    BAO_COUPON_EXPIRES: 309,
     
     //该优惠券已经下载完了
    BAO_COUPON_NONUM: 310,
     
     //超过下载该优惠券的限制了！
    BAO_COUPON_LIMITED: 311,
    
    //未登录或登录状态不正确！
    BAO_LOGIN_NO_REG: 314,
    
}

var baoapp = (function(appcan){
   var h,c;
   h = {};
   c = 
   {
       //APP路径
       app_path :'',
       //服务器地址
       server_url:'http://www.baocms.cn/index.php?g=app',
       //图片附件根地址
       attachs:'http://www.baocms.cn/attachs/',
       //手机抢购详情
       tuan_url:'http://www.baocms.cn/mobile/tuan/detail/tuan_id/',
       shop_url:'http://www.baocms.cn/mobile/shop/detail/shop_id/',
       coupon_url:'http://www.baocms.cn/mobile/coupon/detail/coupon_id/',
       //alipay回调地址
       alipay_callback:'http://www.baocms.cn/',
       //数据缓存目录
       cache_path:'wgt://',
       //窗口关闭动画持续时间
       close_duration: 200,
       //打开窗口动画持续时间
       open_duration:220,
       //Toast持续时间
       toast: 2000,
       //城市ID
       city_id:'1',
       //城市名
       city_name:'',
       //经度纬度,用-分割
       latlng:'',
       //用户登录id
       user_id:'',
       //用户访问Token
       user_token:'',
       //用户登录状态,默认6个小时
       user_expire:21600,
       //缓存时间，默认10个小时
       cache_expire:36000,
       //经纬度缓存时长,1个小时
       latlng_expire:3600,
       //离线加密密码
       crypto_pswd: 'baocms20150907',
       //城市列表
       citys:{},
       //地区列表
       areas:{},
       //店铺类型
       shopcates:{},
       //商品类型
       goodscates:{},
       //团购类型
       tuancates:{},
       //信鸽access_id
       access_id:'',
       //信鸽access_key
       access_key:'',
       //QQ分享AppID
       qq_appid: '1104804293',
       //微信AppID
       wx_appid: 'wxc1de3416538695cc',
       //微信Secret
       wx_secret: '7a91bff0ea3d6508b85404d99d5d990a',
      
   }
   //是否登录
   h.islogin=function(){
       var user_token = appcan.locStorage.getVal(STORAGE.BAO_USER_TOKEN);
       if(user_token){
          return true; 
       }
       return false;
   }
   /*
    *退出登录
    */
   h.clearlogin=function(){
       appcan.locStorage.setVal(STORAGE.BAO_USER_TOKEN,'');
       appcan.locStorage.setVal(STORAGE.BAO_USER_INFO,'');
       appcan.locStorage.setVal(STORAGE.BAO_USER_ID,'');
   }
   
  /**
    * 初始化
    * 1.确认登录状态 本地缓存user_token
    * 2.提取本地缓存
    * 最新更新时间lastModify
    */
   h.innit=function(){
       var curDate = Date.parse(new Date());
       curDate /= 1000;
       if(true == h.LoginExpireOrExists(curDate)){
           appcan.locStorage.setVal(STORAGE.BAO_USER_TOKEN,'');
       }else{
           c.user_token = appcan.locStorage.getVal(STORAGE.BAO_USER_TOKEN) || '';
       }
       
       if(true == h.cacheExpireOrExists(curDate)){
           h.syncData();
       }else{
           h.readCache();
       }
       c.city_id = appcan.locStorage.getVal(STORAGE.BAO_CITY_ID)||'';
       c.city_name = appcan.locStorage.getVal(STORAGE.BAO_CITY_NAME)||'';
       c.user_id = appcan.locStorage.getVal(STORAGE.BAO_USER_ID)||'';
       appcan.locStorage.setVal(STORAGE.BAO_LAST_MODIFY,curDate);
   }
   
   h.getAccessId = function(callback){
       //获取信鸽ID以及密钥
       var access_id = appcan.locStorage.getVal(STORAGE.BAO_ACCESS_ID)||0;
       var access_key = appcan.locStorage.getVal(STORAGE.BAO_ACCESS_KEY)||0;
       if(access_id!=0&&access_key!=0){
           c.access_id = access_id;
           c.access_key = access_key;
           callback(c.access_id,c.access_key);
           return;
       }
       var url = h.createUrl('datas','xinge');
       //IOS平台
       if(uexWidgetOne.getPlatform()=='0'){
           data = {plat:'ios'};
       }else{
           data = {plat:'android'};
       }
        
       h.ayscLoad(url,data,'GET','json',function(data){
           if(data.status===CONST.BAO_REQUEST_SUCCESS){
               c.accesskey = data.accesskey;
               c.accessid = data.accessid;
               appcan.locStorage.setVal(STORAGE.BAO_ACCESS_ID,data.accessid);
               appcan.locStorage.setVal(STORAGE.BAO_ACCESS_KEY,data.accesskey);
               callback(c.access_id,c.access_key)
          }else{
               callback(0,0);
          }
       });
   }
   
   //写入登录数据
   h.loginlog=function(user_token,user_id,user_info){
       appcan.locStorage.setVal(STORAGE.BAO_USER_TOKEN,user_token);
       appcan.locStorage.setVal(STORAGE.BAO_USER_ID,user_id);
       appcan.locStorage.setVal(STORAGE.BAO_USER_INFO,user_info);
       var curDate = Date.parse(new Date());
           curDate /=1000;
       appcan.locStorage.setVal(STORAGE.BAO_LAST_MODIFY,curDate);
   }
   //登录状态过期或者不存在
   h.LoginExpireOrExists = function(date){
       var lastModify = appcan.locStorage.getVal(STORAGE.BAO_LAST_MODIFY);
       if(!lastModify){
           return true;
       }
       if((date - lastModify) > c.user_expire){
          return true;
       }
        return false;
   }
   
   //缓存状态过期或者不存在
   h.cacheExpireOrExists = function(date){
       var lastModify = appcan.locStorage.getVal(STORAGE.BAO_LAST_MODIFY);
       if(!lastModify){
           return true;
       }
       if(lastModify && (date - lastModify) > c.cache_expire){
          return true;
       }
        return false;
   }
   
   
   
      /**
    * 批量缓存图片到手机SD卡
    * @param {id} id 指定img的id
    * @param {data} 对象类型 {id:id,photo:photo}数组 其中id为唯一标识,photo为URL路径
    * @param callback 完成后回调
    * @single 单个图片加载
    */
   h.getImgCache = function(id,data,callback,single){
       var debug = true;
       if(debug){
           for(var i in data){
               var path = c.attachs + data[i].photo;
               if(single){
                   $('#'+id).attr('src',path);
                   return;
               }
               $('#'+id+data[i].id).attr('src',path);
           }
           return;
       }
        single = single || false;
        var option = new Array();      //将option定义为数组,方便下面对存储的中间值进行赋值
        var ids = new Array();
        for (var i in data) {        
            var downloadpath = c.attachs + data[i].photo;            //从页面获取下载的URL地址 
            appcan.locStorage.setVal("dln_", downloadpath); 
            if (downloadpath != null) {
                ids[i] = data[i].id;
                option[i] = {              //设置下载值,作为对数组的赋值,也是后面进行缓存的设置
                    maxtask : 6,
                    url : downloadpath,
                    progress : null,
                    success : function(path, session) {         //缓存完成返回
                        var n = appcan.locStorage.getVal("dln_" + id);          //获取中间值
                        var ids = appcan.locStorage.getVal("dln_id");   
                        var count = 0;
                        if(ids === '1'){
                            $('#' + id).attr('src',path);
                            enddownload(id);
                            return;
                        }else{
                           ids = ids.split(',');
                           count = ids.length - 1;
                           $('#' + id + ids[n]).attr('src', path);           //将缓存完成的地址显示到页面上  
                        }
                        var i = ++n;                //生成一个新的中间值
                        appcan.locStorage.setVal("dln_" + id, i);       //将新的中间值重新存储
                        if (i <= count) {
                            godownload(i);          //循环执行缓存动作
                        } else {
                            enddownload(id);   
                            callback();
                        }
                    },
                    fail : function(session) {//出错返回
                        var n = appcan.locStorage.getVal("dln_" + id);          //获取中间值
                        var ids = appcan.locStorage.getVal("dln_id");   
                        var count = 0;
                        if(ids==='1'){
                            return;
                        }else{
                            ids = ids.split(',');
                            count = ids.length - 1;
                        }
                        var i = ++n;                //生成一个新的中间值
                        appcan.locStorage.setVal("dln_" + id, i);       //将新的中间值重新存储
                        if (i <= count) {
                            godownload(i);          //循环执行缓存动作
                        } else {
                            enddownload(id);  
                            callback();
                        }
                    }
                };
            };
        };
        var a = 0;          //通过数组的长度,获取中间值,减1得到值是方便作为数组下标进行取值
        if(single){   
            appcan.locStorage.setVal("dln_id", '1');  
        }    //存储下载数据的中间值
        else{
            appcan.locStorage.setVal("dln_id", ids.join(','));
        }
        appcan.locStorage.setVal("dln_" + id, a);             //存储下载数据的中间值
        godownload(a);           //执行第一次缓存动作
        /**
         * 执行缓存动作
         * @param {int} i 对应的下载数据下标
         */
        function godownload(i) {
            var cache = appcan.icache(option[i]);
            cache.run(option[i]);          //运行上面对option的赋值并进行相应的循环
        };
        
        
        function enddownload(id){
            appcan.locStorage.remove("dln_id"); 
            appcan.locStorage.remove("dln_" + id);
        }
    
    };
    
    
   /*
    * 清除缓存数据
    */
    h.clearcache = function(callback){
       uexWidgetOne.cleanCache();
       var keys = appcan.locStorage.keys();//返回值是数组，包含所有的key
       var length = keys.length;
       with(STORAGE){
       var no_clean = Array(BAO_USER_TOKEN,BAO_USER_ID,BAO_USER_INFO,BAO_USER_INFO,BAO_ACCESS_ID,BAO_XINGGE_UID,BAO_XINGGE_INSTALL)
       
       for(var i= 0; i<length;i++){
           if(!in_array(keys[i],no_clean)){
               appcan.locStorage.remove(keys[i]);
           }
       }
       callback(true);
       /*
       uexFileMgr.deleteFileByPath(appcan.file.wgtPath+'/icache/');
       uexFileMgr.cbDeleteFileByPath = function(opId,dataType,data){
             if (data == 0) {
                callback(true);
            } else {
                callback(false);
            }
           }*/
        }
        
        
        function in_array(search,array){
            for(var i in array){
                if(array[i]==search){
                    return true;
                }
            }
            return false;
        }
   }
   
   
   //抓取数据缓存
   h.syncData=function(){
        var url = h.createUrl('Datas','cates');
        var data = {};
        
        h.ayscLoad(url,data,'GET','json',function(data){
            try{
                if(data.status===CONST.BAO_REQUEST_SUCCESS){
                    appcan.locStorage.setVal(STORAGE.BAO_CACHE_SHOP_CATE,data.shopcates);
                    appcan.locStorage.setVal(STORAGE.BAO_CACHE_GOOD_CATE,data.goodcates);
                    appcan.locStorage.setVal(STORAGE.BAO_CACHE_TUAN_CATE,data.tuancates);
                    c.tuancates = data.tuancates;
                    c.goodcates = data.goodcates;
                    c.shopcates = data.shopcates;
                }else{
                    h.resourceError();
                }
            }catch(e){
                    h.resourceError();
            }
        });
        
        var url = h.createUrl('Datas','cityareas');
        var data = {};
        
        h.ayscLoad(url,data,'GET','json',function(data){
            try{
               if(data.status==CONST.BAO_REQUEST_SUCCESS){
                    appcan.locStorage.setVal(STORAGE.BAO_CACHE_CITYS,data.city);
                    appcan.locStorage.setVal(STORAGE.BAO_CACHE_AREAS,data.area);
                    c.citys = data.city;
                    c.areas = data.area;
                 }else{
                    h.resourceError();
                 }
               }catch(e){  
                    h.resourceError();
            }
        });
        
   }
   
   
   h.readCache = function(){
       try{
            c.citys = eval("("+appcan.locStorage.getVal(STORAGE.BAO_CACHE_CITYS)+")");
            c.areas = eval("("+appcan.locStorage.getVal(STORAGE.BAO_CACHE_AREAS)+")");
            c.shopcates = eval("("+appcan.locStorage.getVal(STORAGE.BAO_CACHE_SHOP_CATE)+")");
            c.goodcates = eval("("+appcan.locStorage.getVal(STORAGE.BAO_CACHE_GOOD_CATE)+")");
            c.tuancates = eval("("+appcan.locStorage.getVal(STORAGE.BAO_CACHE_TUAN_CATE)+")");
        }catch(e){
            h.resourceError();
        }
   }
      
   
   /**
    * 创建Url
    * @param obj,对象[a:'',b:'']
    * @return string
    */
   h.createUrl=function(m,a,obj)
   {
       var url = c.server_url+'&m='+m+'&a='+a;
       if(obj){
           for(var k in obj){
               url+='&'+k+'='+obj[k];
           }
       }
       c.city_id = c.city_id || appcan.locStorage.getVal(STORAGE.BAO_CITY_ID);
       if(c.city_id){
           url+='&city_id='+c.city_id;
       }
       c.latlng = c.latlng || appcan.locStorage.getVal(STORAGE.BAO_LAT_LNG);
       if(c.latlng){
           var latlng = c.latlng.split('-');
           url+='&lat='+latlng[0]+'&lng='+latlng[1];
       }
       c.user_token = c.user_token || appcan.locStorage.getVal(STORAGE.BAO_USER_TOKEN);
       if(c.user_token){
           url+='&user_token='+c.user_token;
       }
       c.user_id = c.user_id || appcan.locStorage.getVal(STORAGE.BAO_USER_ID);
       if(c.user_id){
           url+='&uid='+c.user_id;
       }
       return url;
   }
   /**
    *同步刷新方式 
    * @param backwindow,*.html格式,调用完毕后返回的窗口
    * @param requrl, url格式,调用所需的URL路径
    * @param reqdata,url格式,调用所需的数据路径
    */
   h.syncLoad = function(backwindow,requrl,reqdata)
   {
       appcan.locStorage.setVal(STORAGE.BAO_LOADED_DATA,'');
       backwindow = backwindow || '';
       requrl = requrl || '';
       reqdata = reqdata || '';
       appcan.locStorage.setVal(STORAGE.BAO_BACK_WINDOW,backwindow);
       appcan.locStorage.setVal(STORAGE.BAO_REQEUST_URL,requrl);
       appcan.locStorage.setVal(STORAGE.BAO_REQEUST_DATA,reqdata);
       h.linkTo('loading','../loading.html','',5);
   }
   
   
   
   /**
    * 异步刷新
    * @param o,html中标签 
    * @param data,对象格式,发起请求所需数据
    * @param callback1,滑到底部回调的方法
    * @param callback2,滑到顶部回调的方法
    **/
   h.ayscRefresh=function(o,callback1,callback2)
   {
        o = o || 'body';
        o = document.querySelector(o);
        o.onscroll = function(event){
            var stop=this.scrollTop,sheight=this.scrollHeight,cheight=this.clientHeight;
            if(stop+cheight>=sheight){
                //滑到到底部
                !callback1 || callback1(event.target);
            }
            if(!stop){
                //滑到到顶部
                !callback2 || callback2(event.target);
            }
        }
   },
   //Ajax加载
   h.ayscLoad=function(url,data,requestType,dataType,callback,status,offline,crypto)
   {
       if(!url)  throw new Error('异步请求网络地址不能为空！');
       data = data || {};
       requestType = requestType || 'GET';
       dataType = dataType || 'json';
       offline  = offline  || false;
       crypto   = crypto   || true;
       
       appcan.ajax({
           url: url,
           type: requestType,
           data: data,
           dataType: dataType,
           timeout: 30000,//请求过时30秒
           appVerify: true,
           offline: offline,
           offlineDataPath: c.cache_path,
           expires: c.cache_expire,
           crypto : crypto,
           password : c.crypto_pswd,
           beforeSend:function(xhr,settings){
               console.log('开始请求数据');
           },
           complete:function(xhr,status){
               console.log('请求数据完成！');
           },
           success:function(data,status,requestCode,response,xhr){
               if(requestCode==CONST.BAO_REQUEST_SUCCESS){
                 !callback || callback(data); 
               }else if(requestCode == CONST.BAO_LOGIN_ERROR){
                    c.user_token = '';
                    c.user_id = 0;
                    appcan.locStorage.remove(STORAGE.BAO_USER_TOKEN);
                    appcan.locStorage.remove(STORAGE.BAO_USER_ID);
               }else{
                 h.resourceError();
            }
           },
           error:function(xhr,errorType,error,msg){
               console.log('请求错误::'+msg);
           }
       });
   }

   /*
    * 网络错误
    */
   h.resourceError = function(){
      // h.linkTo('loadingfail','../loading_fail.html','',5);
   }

   /*
    * 层窗口
    * id:父窗口
    * url:子窗口
    * top:距顶部距离
    * callback:回调函数
    * **/
   h.frameOpen=function(id,url,top,callback,name,left,index)
   {
       if(!id || !url)throw new Error('参数不正确！');
       top  = top || 0;
       name = (name || (url.split('.'))[0]);
       appcan.frame.open({
            id: id,
            url: url,
            left: 0,
            top: top,
            name: name,
            index: (index || 0),
            change:function(err, res){
                alert('Hello,Frame!');
            }
       });
       callback = callback || function(){};
       return callback();
        // window.onorientationchange = window.onresize = function() {
            // appcan.frame.resize(id, 0, top);
        // }
   }
   /*关闭浮动窗口*/
  h.frameClose=function(name)
  {
      if(!name) throw new Error('请指定要关闭的窗口！');
      appcan.frame.close(name);
  }
 //高德地图API
  h.mapopen=function(lon,lat,x,y,width,height,addr){
      x = x || 0;
      y = y || 0;
      width = width || 300;
      height = height || 500;
      lon = lon || 0 ;
      lat = lat || 0;
      addr = addr || '';
      if(!lon||!lat){
          return false;
      }
     // json:(String类型) 必选添加到地图的标注信息的集合。该字符串为JSON格式。如下:
  
      
     // var json = {left:x,top:y,width:width,height:height,isScrollWithWeb:false,longitude:lon,latitude:lat};
      //var data = JSON.stringify(json);
      uexBaiduMap.open(x, y, width, height,lon,lat);
      
      uexBaiduMap.cbOpen = function(){
            var json=[
                {
                id:'1',//(必选)唯一标识符 
                longitude:lon,//(必选)经度 
                latitude:lat,//(必选)纬度 
                bubble:{//(可选)自定义弹出气泡 
                     title:'谈了个气泡',//(必选)自定义弹出气泡标题
                    } 
                }
            ];
           json = JSON.stringify(json);
           uexBaiduMap.setZoomLevel(15);
           uexBaiduMap.addMarkersOverlay(json);
      }
      return true;
  }
  
  //高德地图关闭
  h.mapclose=function(){
      uexBaiduMap.close();
  }
  
  
   /*
    * 获取请求参数?a=1&b=2
    * @return 对象,{a: "12333", b: "87867866"}
    */
   h.getRequest=function(search)
   {
       var  params = {};
       if(search.indexOf('?')!=-1){
           search = search.replace('?','');
           search = search.split('&');
           for(var k in search){
               var kv= search[k].split('=');
               params[kv[0]] = unescape(kv[1]);
           }
           return params;
       }
       return false;
   }
   /*
    * 页面跳转
    * @param name, 创建
    * @param data,格式为字符串 key-name
    * 
    * @param backwindow, 返回窗口路径
    */
   h.linkTo=function(name,url,data,anid,backwindow,type)
   {
       //关闭当前窗口
       anid = anid || 2;
       backwindow = backwindow || '';    
       if(backwindow.length > 0){
           appcan.locStorage.setVal('backwindow',backwindow);
       }
       if(data&&data.length > 0){
           data = data.split('-');
           appcan.locStorage.setVal(data[0],data[1]);
       }
       if(!name||!url){
           throw new Error('跳转网址不能为空！');
       }
        //强制刷新
        type = type || 4;
        appcan.window.open({
            name:name,
            data:url,
            dataType:0,
            aniId:anid,
            type:type,
            animDuration: c.open_duration,
            extraInfo:{
                opaque:true,
                bgColor:'#2FBDAA'
            }
        });
        
   }

   //窗口提示
   h.notice=function(msg){
       appcan.window.alert({
              title : "提示",
              content : msg,
              buttons : ['确定'],
              callback : function(err, data, dataType, optId) {
                  console.log(err, data, dataType, optId);
              }
        });
   }
   h.confirm=function(obj)
   {
       obj.buttons = obj.buttons || ['确定','取消'];
       appcan.window.confirm({
           title: obj.title,
           content: obj.content,
           buttons: obj.buttons,
           callback:obj.callback
       });
   }
   /* Toast提示
    * time:0或为空不执行计时器
    * string:0或空移除提示
    */
   h.toast=function(string,time,callback,type)
   {
        if(!string){
            if(document.getElementById('popLoading')){
               document.querySelector('body').removeChild(document.getElementById('popLoading'));
            }
            return false;
        }
        type = type || 0;//1文字提示,0图片显示
        if(document.getElementById('popLoading'))return false;
        loading = document.createElement('div');
        loading.id = "popLoading";
        if(type){
        	loading.innerHTML = "<div class='text' unselectable='on' onselectstart='return false;'>"+string+"</div>"
        }else{
        	loading.innerHTML = "<div class='img' unselectable='on' onselectstart='return false;'></div>"
        }
        document.querySelector('body').appendChild(loading);
            
        if(time){
            s = setInterval(function(){
                if(document.getElementById('popLoading'))
                document.querySelector('body').removeChild(document.getElementById('popLoading'));
                !callback || callback();
                clearInterval(s);
            },time);
       }     
   }
   
   h.goback=function(anid)
   {
       //
       anid = anid || 1;
       var backwindow = appcan.locStorage.getVal('backwindow');
      // appcan.window.close(anid,c.close_duration);
      backwindow = backwindow || '';
      if(backwindow.length > 0 ){
          h.linkTo('name',backwindow);
      }else{
          appcan.window.close(anid,c.close_duration);
      }
      
   }
   /*
    * 事件触发器
    * o:CSS选择器
    * type:['click','touchstart','touchmove','touchend']
    * callback:回调
    */
   h.trigger=function(o,callback,type)
   {
         var eventType = ['click','touchstart','touchmove','touchend'];
         callback  =  callback || function(){};
         type      =  type || 'touchend';
         for(i in eventType){
             if(type==eventType[i]){
                 document.querySelector(o).addEventListener(type,callback,false);
                 return true;
             }
         }         
         throw new Error('事件类型不存在或错误！');
   }
   
   /*
             适配苹果设备    
    */
   h.adapt = function(){
      if(uexWidgetOne.platformName == 'iOS'){
         var height = $('header').offset().height + 20;
         var top = parseInt($('#content').css('top')) + 20;
         $('header').css('border-top','20px solid #2FBDAA');
         $('#content').css('top',top);
     }else{
         var height = $('header').offset().height;
     }
        return height;
   }
   
   
   /*
    * 将数据带时间轴缓存
    */
   h.cacheExpireWrite=function(key,data)
   {
       if(!key || !data)throw new Error('键名或数据不能为空！');
       
        var curDate  = Date.parse(new Date());
            curDate /= 1000;
            data    += '@:'+ curDate; 
            appcan.locStorage.setVal(key,data);
   }
   /*
    * 读取时间轴数据
    * 过期返回false,否则返回true
    */
   h.cacheExpireRead=function(key,expire)
   {
       var cache    = appcan.locStorage.getVal(key);
           if(!cache) return false;
           cache    = cache.split('@:');
           deadline = parseInt(cache[1]);
       var curDate  = Date.parse(new Date());
           curDate /= 1000;    
           expire   = expire || c.latlng_expire;
           if( (curDate-deadline)< expire){
               return cache[0];
           }
       return false;    
   }
    /*
     * 调用系统浏览器打开URL
     */
     h.openUrl = function(url){
          if(uexWidgetOne.getPlatform()=='0'){
          //IOS设备
          uexWidget.loadApp(url,'','');
          }else{
              //android设备
              uexWidget.loadApp('android.intent.action.VIEW','text/html',url);
          } 
     }
   return {helper:h,config:c};
})(appcan);

//定位功能
(function(baoapp){
    var addr;
    function _open(opCode, dataType, data){
       //alert('Open::'+opCode + "," + dataType + "," + data);
    }
    function _change(lat,log){
       uexLocation.getAddress(lat,log,1);
    }
    function _address(opCode, dataType, data, callback){
        data = JSON.parse(data);
        //定位，将经纬度以“-”链接写入缓存
        baoapp.helper.cacheExpireWrite(STORAGE.BAO_LAT_LNG ,data.location.lat+'-'+data.location.lng);
        //定位,将当前城市写入缓存
        baoapp.helper.cacheExpireWrite(STORAGE.BAO_CITY_NAME ,data.addressComponent.city);
        
         //alert(data.formatted_address);
       // alert('经度：'+data.location.lat+'纬度：'+data.location.lng);
      //  alert('省份：'+data.addressComponent.province+'街号：'+data.addressComponent.street_number+'区域：'+data.addressComponent.district+'城市：'+data.addressComponent.city+'街道：'+data.addressComponent.street);
    }
    baoapp.gps = function(close){
        close = close || 0;
        var loclevel = [0,1,2,3], distanceFilter = 100, addr = {};
            uexLocation.openLocation(loclevel[0], distanceFilter);
            uexLocation.cbOpenLocation = _open;
            uexLocation.onChange       = _change;
            uexLocation.cbGetAddress   = _address;
            if(!close)
            uexLocation.closeLocation();
            return addr;
    }
})(baoapp);

//QQ分享
(function(baoapp){
 
   function _isInstalled(opId,dataType,data){
       if(data){baoapp.helper.toast('没有安装QQ,请先安装QQ吧',2000,null,1);return false;}
       uexQQ.login(baoapp.config.qq_appid);
   }
   baoapp.qq = function(_data){
       uexQQ.isQQInstalled();
       
       uexQQ.cbIsQQInstalled = function (opId,dataType,data){
             if(data)
             {
                baoapp.helper.toast('没有安装QQ,请先安装QQ吧',2000,null,1);
                 return false;
             }
             uexQQ.cbShareQQ = function(opId,dataType,data){
                 data = JSON.parse(data);
                 if(!data.ret){
                     baoapp.helper.toast("分享失败",2000,null,1);
                     return;
                 }
                 baoapp.helper.toast("分享成功",2000,null,1);
             }
            uexQQ.shareImgTextToQZone(baoapp.config.qq_appid,_data);
        };
   }
   baoapp.qqlogin = function(callback){
       uexQQ.isQQInstalled();
       
       uexQQ.cbIsQQInstalled = function (opId,dataType,data){
             var login = false;
             if(data)
             {
                 baoapp.helper.toast('没有安装QQ,请先安装QQ吧',2000,null,1);
                 callback(login);
                 return;
             }
             uexQQ.cbLogin = function(opId,dataType,data){
                 data = JSON.parse(data);
                 if(data.ret=='0'){
                     var openid = data.data.openid;
                     var access_token = data.data.access_token;
                     appcan.locStorage.setVal('qq_openid',openid);
                     appcan.locStorage.setVal('qq_access_token',access_token);
                     login = true;
                 }
                 callback(login);
             }
             uexQQ.login(baoapp.config.qq_appid);
        };
   }
   
})(baoapp);
//微信分享
(function(baoapp){
    //授权登录
    baoapp.wxLogin = function(callback){
        uexWeiXin.cbWeiXinLogin = function(opid,dataType,data){
            var login = false;
            if(!data){
                var state = appcan.locStorage.getVal('qqstate');
                uexWeiXin.cbGetWeiXinLoginAccessToken = function(opid,dataType,data){
                    data = JSON.parse(data);
                    appcan.locStorage.setVal('wx_access_token',data.access_token);
                    appcan.locStorage.setVal('wx_refresh_token',data.refresh_token);
                    appcan.locStorage.setVal('wx_openid',data.openid);
                    login = true;
                }
                uexWeiXin.getWeiXinLoginAccessToken(baoapp.config.wx_appid,'authorization_code');
            }
            callback(login);
        }
        uexWeiXin.weiXinLogin('snsapi_userinfo');
       // uexWeiXin.weiXinLogin('snsapi_userinfo,snsapi_base',state.toString());
    }
    /*
     * 获取微信登录accessToken
     * secret 应用密钥AppSecret
     */
    function getAccessToken(secret){
        uexWeiXin.cbGetWeiXinLoginAccessToken = function(opid,dataType,data){
            //access_token,expires_in,refresh_token,openid,scope   
            data = JSON.parse(data);         
            appcan.locStorage.setVal('access_token_openid', data['access_token']+'-'+data['openid']);
        };
        uexWeiXin.getWeiXinLoginAccessToken(secret,'authorization_code');
    }
    //AccessToken超时刷新
    function refreshAccessToken(refresh_token){
        uexWeiXin.cbGetWeiXinLoginRefreshAccessToken = function(opid,dataType,data){
            //access_token,expires_in,refresh_token,openid,scope
            data = JSON.parse(data);
            appcan.locStorage.setVal('access_token_openid', data['access_token']+'-'+data['openid']);
        };
        uexWeiXin.getWeiXinLoginRefreshAccessToken('refresh_token',refresh_token);
    }
    //检验accessToken是否有效
    function checkAccessToken(access_token,openid){
        uexWeiXin.cbGetWeiXinLoginCheckAccessToken = function(opid,dataType,data){
            if(!data){
               
            }else if(data == 1){
                baoapp.helper.toast('AccessToken无效',2000,null,1);
                refreshAccessToken(access_token);
            }else{
                baoapp.helper.toast('未知错误',2000,null,1);
            }
        };
        uexWeiXin.getWeiXinLoginCheckAccessToken(access_token,openid);
    }
    
    baoapp.shareLink = function(jsonData){
      //thumbImg,wedpageUrl,scene 1,title,description
        uexWeixin.cbShareLinkContent =function(data){
            if(!data){
              baoapp.helper.toast('分享成功！',2000,null,1);
            }else{
              baoapp.helper.toast('分享失败！',2000,null,1);
            }
        };
        
        uexWeiXin.shareLinkContent(jsonData);
       // uexWeiXin.shareLinkContent(jsonData);
    }
    //注册App
    baoapp.registerApp = function (){
      //注册AppId
      uexWeiXin.cbRegisterApp = function(opId,dataTpye,data){
        if(!data){
          //打开微信
          // uexWeiXin.openWXApp() ; 
          //判断a_t_o是否存在
          var a_t_o = appcan.locStorage.getVal('access_token_openid');
          if(a_t_o){
            a_t_o =  a_t_o.split('-');
            checkAccessToken(a_t_o[0], a_t_o[1]);
          }else{
            getAccessToken(baoapp.config.wx_secret);
          }
        }else{
          baoapp.helper.toast('注册失败',2000,null,1);
        }
      }   
      uexWeiXin.registerApp(baoapp.config.wx_appid);
    }
    baoapp.weixin = function(jsonData){
      
      uexWeixin.cbIsWXAppInstalled = function(opId,dataTpye,data){                              
        if(!data){
           shareLink(jsonData);
        }else{
          baoapp.helper.toast('您没有安装微信',2000,null,1);
        }
      }
      uexWeiXin.isWXAppInstalled();
    }
    
    
    
})(baoapp);
var tool=
{
    //格式化本地时间
    getLocal:function()
    {
        return new Date().toLocaleString().replace(/:\d{1,2}$/,' '); 
    }
}



