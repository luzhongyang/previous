/**
 * Created by win10 on 2017/4/21.
 */

/*运动*/
function getStyle(obj,name){
    return obj.currentStyle?obj.currentStyle[name]:getComputedStyle(obj,false)[name];
}
function move(obj,json,opitions){
    //opitions={ duration,easing,complete}
    opitions = opitions || {};
    opitions.duration = opitions.duration || '800';
    opitions.easing = opitions.easing || 'ease-in';
    clearInterval(obj.timer);
    //json={width:0,height:0};
    var start = {};
    //json={width:200,height:200};
    var dis= {};
    for(var name in json){
        start[name] = parseFloat(getStyle(obj,name));
        dis[name] = json[name]-start[name];
    }
    var count = Math.floor(opitions.duration/30);
    var n = 0;
    obj.timer = setInterval(function(){
        n++
        for(var name in json){
            switch(opitions.easing){
                case 'linear':
                    var a = n/count;
                    var cur = dis[name]*a;
                    break;
                case 'ease-in':
                    var a = n/count;
                    var cur = dis[name]*a*a*a;
                    break;
                case 'ease-out':
                    var a = 1-n/count;
                    var cur = dis[name]*(1-a*a*a);
                    break;
            }
            /*var a = n/count;
             var cur = dis[name]*a;*/
            if(name=='opacity'){
                obj.style[name]=start[name]+cur;
                obj.style.filter='alpha(opacity:'+(start[name]+cur)*100+')';
            }else{
                obj.style[name]=start[name]+cur+'px';
            }
        }
        if(n==count){
            clearInterval(obj.timer);
            opitions.complete && opitions.complete();
        }
    },30);
}
