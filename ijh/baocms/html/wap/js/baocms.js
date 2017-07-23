/* 公用 */
var scroll;
$(function(){
	scroll = new IScroll('.page-center-box', {
		scrollbars: true,
		mouseWheel: true,
		interactiveScrollbars: true,
		shrinkScrollbars: 'scale',
		fadeScrollbars: true
	});
	$('.page-center-box').on('touchmove', function(e){
		e.preventDefault();
	});
	
	if ($('#search-bar').length > 0)
	{
		$('#search-bar li').width(100 / $('#search-bar li').length + '%');
		$('.page-center-box').css('top', '0.9rem');
	}
	if ($('#tab-bar').length > 0)
	{
		$('.page-center-box').css('top', '1rem');
	}
	if ($('footer').length == 0)
	{
		$('.page-center-box').css('bottom', 0);
	}
	scroll.refresh();
});



function set_bar(line_num,num){ //line,每行个数   num,总个数   多行也可以自伸展。
		var line = 0;//行数，也是百分比个数
		var mo = num%line_num; //求出余数
		if(mo == 0){
			line = parseInt(num/line_num);	
		}else{
			line = parseInt(num/line_num) +1;	
		}
		
		var arr = new Array();
		if(mo == 0){
			for(var i = 0;i<(line)*line_num;i++){
				arr[i] = (100/line_num)+'%';
			}
		}else{
			for(var i = 0;i<(line-1)*line_num;i++){
				arr[i] = (100/line_num)+'%';
			}
			for(var ii = i;ii<mo+i;ii++){
				arr[ii] = (100/mo)+'%';
			}
		}

		var p = 0;
		 $.each(arr,function(i,val){
			p = p + 1;
			$('#all-bar').find('#l'+p).width(val);
		 });
		 
		var top_num = 0;
		if(line == 1){
			top_num = 0.9;	
		}else{
		    top_num = 0.9+0.4*(line-1);
		}

		$('.page-center-box').css('top', top_num+'rem');	 
}
	