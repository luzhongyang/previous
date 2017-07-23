/**
 * Created by Administrator on 2017/4/5 0005.
 */
window.onload=function(){
    var aDiv=document.getElementsByClassName('read-item');
    var oLeft=document.getElementById('btn-re_prev');
    var oRight=document.getElementById('btn-re-next');
    var now=0;
    function tab(){
        for(var i=0;i<aDiv.length;i++){
            /*aDiv[i].className='';*/
            aDiv[i].style.display='none';
        }
        /*aDiv[now].className='active';*/
        aDiv[now].style.display='block';
    }
    for(var i=0;i<aDiv.length;i++){
        aDiv[i].index=i;
        aDiv[i].onclick=function(){
            now=this.index;
            tab();
        };
    }
    oRight.onclick=function(){
        now++;
        //alert(now);
        if(now==aDiv.length)now=0;
        tab();
    };
    oLeft.onclick=function(){
        now--;
        if(now<0)now=aDiv.length-1;
        tab();
    };
};


