// JavaScript Document
$(document).ready(function () {

    $(window).scroll(function () {

        if ($(window).scrollTop() > 40) {

            $(".shy-idx_top_fixed").show();

            $(".shy-idx_top").hide();
        } else {

            $(".shy-idx_top_fixed").hide();

            $(".shy-idx_top").show();
        }

    });

});


$(document).ready(function () {


    $(".fast-nav li").click(function () {

        var index = $(this).index(),

            _this = $(".action").eq(index),

            sc_top = _this.offset().top - 100,

            t = 300;

        if (index == 2) {

            sc_top = sc_top + 0;

        } else if (index == 3) {

            sc_top = sc_top + 0;

        } else if (index == 9) {

            sc_top = sc_top + 0;

        }
        if (3 != index) {
            $("html,body").animate({

                scrollTop: sc_top

            }, t);
        }


    });

    var arr = [];

    $(".action").each(function (i) {

        arr[i] = $(".action").eq(i).offset().top;

    });

    $(window).resize(function () {

        $(".action").each(function (i) {

            arr[i] = $(".action").eq(i).offset().top;

        });

    })

    $(window).scroll(function () {

        var top = $(document).scrollTop(),

            t = 100;

        for (var i = 0; i < arr.length; i++) {

            if (top >= arr[i] - 300 && top < arr[i] + 150) {

                $(".fast-nav li").removeClass("active");

                $(".fast-nav li").eq(i).addClass("active");

            }

        }
        ;

    });


    var fast_nav_height = $(".fast-nav").height();

    var window_height = $(window).height();

    $(".fast-nav").css({

        top: (window_height - fast_nav_height) / 2

    })

    $(window).resize(function () {

        fast_nav_height = $(".fast-nav").height();

        window_height = $(window).height();

        $(".fast-nav").stop(true, false).animate({

            top: (window_height - fast_nav_height) / 2

        }, 300);

    });


});

