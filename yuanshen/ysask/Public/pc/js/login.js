/*$(function(){
    $('#form_login').validator({
        rules: {
            username: function(element,params) {
                return /^[a-zA-Z]\w{3,}/.test(element.value) ||
                this.test(element, "mobile")===true ||
                this.test(element, "email")===true ||
                '请填写用户名、手机号或者邮箱';
            }
        },
        fields: {
            "username": "required; username;length[6~16]",
            "password": "required; password;length[6~16]"
        },
        display: function(element){
            return $(element).attr('placeholder');
        },
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
        valid:function(form)
        {
            $.ajax({
                type:'post',
                cache:false,
                dataType:'json',
                url:'/login.html',
                data:$(form).serialize(),
                error:function(e){alert('服务器错误');},
                success:function(d)
                {
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='/admin.html';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
                }
            })
        }
    });
})*/