alert(1);
$('.his-top ul li a').click(function(){
    var _t = $(this)
        url = _t.data('url');
    _t.addClass('current').siblings('li').removeClass('current');
    $('#main-content').html('').load(url);
});
