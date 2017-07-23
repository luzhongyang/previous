appcan.ready(function(){
	 if(uexWidgetOne.platformName == 'IOS'){
         $("#ios-hack").show();
         var height = $('header').offset().height + 20;
         var top = parseInt($('#content').css('top')) + 20;
         $('header').children().eq(0)
         
         $('#content').css('top',top)
         $('header').css('height',height);
         $('header').offset().height = $('header').offset().height + 20;
     }else{
         var height = baoapp.helper.adapt();
     }
})
