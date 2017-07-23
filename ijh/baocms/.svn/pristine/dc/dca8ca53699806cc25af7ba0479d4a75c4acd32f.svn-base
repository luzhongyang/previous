/*+++++++++++++++++++++++++++++++++++++
  + 初始化APP访问
  +++++++++++++++++++++++++++++++++++++*/

appcan.ready(function(){  
    with(baoapp)
    {
       helper.innit();
       
       // var latlng = helper.cacheExpireRead(STORAGE.BAO_LAT_LNG);
       // if(!latlng)
        // {
            // gps();
            // latlng = helper.cacheExpireRead(STORAGE.BAO_LAT_LNG);
        // }
        // config.latlng = latlng;
    }
});

var city_id   = appcan.locStorage.getVal('CURR_CITY_ID')   || 1;
var city_name = appcan.locStorage.getVal('CURR_CITY_NAME') || '合肥';

