window.KT = window.KT || {version: "1.0a"};
(function(K, $){
window.Weixin = window.Weixin || {};
//微信支付JsApi 
Weixin.wxpay = function(params, callback){
    callback = callback || function(ret){};
    function onBridgeReady(){
        WeixinJSBridge.invoke('getBrandWCPayRequest', params,callback);
    }
    if (typeof WeixinJSBridge == "undefined"){
       if( document.addEventListener ){
           document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
       }else if (document.attachEvent){
           document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
           document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
       }
    }else{
       onBridgeReady();
    }
}
})(window.KT, window.jQuery);
