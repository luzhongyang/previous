
    $(document).ready(function () {
        var curr_ctl = "<{$request.ctl}>";
        var act = "<{$request.act}>";
        $(".pull-right a").each(function(){
            if(-1 != curr_ctl.indexOf($(this).attr("hel"))){
                if(-1 != curr_ctl.indexOf("weidian")){
                    if(-1 != curr_ctl.indexOf("pintuan")){
                        $("#search_form").attr('action', $(this).attr('rel'));
                        $("#selectBoxInput").html($(this).html()); 
                    }else{
                        $("#search_form").attr('action', $(this).attr('rel'));
                        $("#selectBoxInput").html($(this).html());
                    }
                }else{
                   $("#search_form").attr('action', $(this).attr('rel'));
                    $("#selectBoxInput").html($(this).html()); 
                }
                                                
            }else if(-1 != act.indexOf($(this).attr("hel"))){
                $("#search_form").attr('action', $(this).attr('rel'));
                $("#selectBoxInput").html($(this).html());
            }
        })
        $(".pull-right li a").click(function () {
            $("#search_form").attr('action', $(this).attr('rel'));
            $("#selectBoxInput").html($(this).html());
            $('.selectList').hide();
        });
        
    });