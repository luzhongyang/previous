//
$(document).ready(function () {
	
	if ($('#downOption').length > 0)/*判断是否存在这个html代码*/
	{
		$('#downOption .list').width(100 / $('#downOption .list').length + '%');
		$('.page_center_box').css('top', '0.93rem');
	}
	if ($('.switchTab_box').length > 0)/*判断是否存在这个html代码*/
	{
		$('.page_center_box').css('top', '0.95rem');
	}
	/*单选项选择开始*/
	/*$('.radioLabel').click(function(){
		$('.radioInt').removeClass('on');
		$(this).find('.radioInt').addClass('on');
	});*/
	/*单选项选择结束*/
	/*店铺页面开始*/
	if ($('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
	{
		$('#shangjia_tab li').width(100 / $('#shangjia_tab li').length + '%');
		$('.page_center_box').css('top', '0.9rem');
	}//头部切换tab结束
	if ($('.dianpuPrompt').length > 0 && $('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
	{
		$('#shangjia_tab').css('top', '0.9rem');
		$('.page_center_box').css('top', '1.3rem');
	} else if ($('.dianpuPrompt').length > 0 || $('#shangjia_tab').length > 0) {
		$('.page_center_box').css('top', '0.9rem');
	}//头部提示结束
	/*店铺页面结束*/
	
});