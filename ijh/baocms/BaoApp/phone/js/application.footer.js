/*+++++++++++++++++++++++++++++++++++++
  + 页面公共底部
  +++++++++++++++++++++++++++++++++++++*/
 
  appcan.ready(function(){
      
     var  tag ='<div id="f_index" onclick="daohang(\'index\');"><div class="icon i-1"></div><p>首页</p></div>';
          tag+='<div id="f_tuan" onclick="daohang(\'tuan\');"><div class="icon i-2"></div><p>抢购</p></div>';
          tag+='<div id="f_coupon" onclick="daohang(\'coupon\');"><div class="icon i-3"></div><p>优惠券</p></div>';
          tag+='<div id="f_personal" onclick="daohang(\'personal\');"><div class="icon i-4"></div><p>我的</p></div>';
          tag+='<div id="f_more" onclick="daohang(\'more\');"><div class="icon i-5"></div><p>更多</p></div>';
          document.querySelector('footer').innerHTML = tag;
     });
   
   function daohang(page)
   {
   		//var currPage = appcan.locStorage.getVal('CURR_PAGE');
   		//if(page == currPage)return false;

   		//appcan.locStorage.setVal('CURR_PAGE',page);
   		var pages = {
   			index:'wgtroot://index.html',
   			tuan:'wgtroot://tuan/index.html',
   			coupon:'wgtroot://coupon/main.html',
   			personal:'wgtroot://mcenter/personal.html',
   			more:'wgtroot://more.html'
   		};
   		if(page == 'personal'){
   			if(!baoapp.helper.islogin()){
   				appcan.window.open('login','wgtroot://login.html',11,0,0);
   				return false;
   			}
   		}
   		appcan.window.open(page,pages[page],0,0,0);
   } 
   