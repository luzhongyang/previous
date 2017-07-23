/**
 * Created by win10 on 2017/4/6.
 */
window.onload=function(){
    var oBox=document.getElementsByClassName('news-answer-left-bottom');
    var oDiv=document.getElementsByClassName('left-bottom-top');
    var aBtn=document.getElementsByTagName('.left-top ul li');
    var aDiv=document.getElementsByClassName('list-middle');
    for(var i=0;i<aBtn.length; i++){
        aBtn[i].index=i;
        aBtn[i].onclick=function(){
            for(var i=0;i<aBtn.length;i++){
                aBtn[i].className='';
                aDiv[i].className='left-bottom';
            }
            aBtn[i].className='show';
            aDiv[i].className='show';
        };
    }
};