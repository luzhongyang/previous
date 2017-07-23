/**
 * Created by Administrator on 2017/3/20.
 */

$(function(){
    $('.dropdown').click(function(){
        var _t = $(this),
            dc = _t.next('.dropdown-content');
        console.log(dc);
        $(dc).toggle();
    });


    $('body').append('<div class="rollbar"><div class="rollbar-item" etap="to_comments"><i class="am-icon-comments-o"></i></div><div class="rollbar-item" etap="to_top"><i class="am-icon-arrow-up"></i></div></div>')
    var scroller = $('.rollbar')
    $(window).scroll(function() {
        var h = document.documentElement.scrollTop + document.body.scrollTop
        h > 200 ? scroller.fadeIn() : scroller.fadeOut();
    })
    $('[etap="to_comments"]').on('click', function(){
        $('html,body').animate({
            scrollTop: $('#comments').offset().top + 15
        }, 300, function(){
            $('#comment').focus()
        })
    })
    $('[etap="to_top"]').on('click', function(){
        $('html,body').animate({
            scrollTop: 0
        }, 300)
    })

    var scroller = $('.rollbar')
    $(window).scroll(function() {
        var h = document.documentElement.scrollTop + document.body.scrollTop
        h > 200 ? scroller.fadeIn() : scroller.fadeOut();
    });

    $('.avator-mode').hover(function(){
        $('.update-avator').css('bottom',0);
    },function(){
        $('.update-avator').css('bottom','-30px');
    });

    $('.auth-list dd').hover(function(){
        $(this).find('.icon-tips').removeClass('hide');
    },function(){
        $(this).find('.icon-tips').addClass('hide');
    });

    $('.ask-list .am-list li').hover(function(){
        $(this).find('.del').show();
    },function(){
        $(this).find('.del').hide();
    });


    //收货地址
    $('.user-address-list .address-item').hover(function(){
        $(this).find('.actions').show();
    },function(){
        $(this).find('.actions').hide();
    });
})
